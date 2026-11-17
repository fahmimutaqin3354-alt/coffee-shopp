const express = require('express');
const cors = require('cors');
const fs = require('fs');
const path = require('path');

const app = express();
const PORT = process.env.PORT || 5000;

// Middleware
app.use(cors());
app.use(express.json());
app.use(express.static(path.join(__dirname, 'public')));

// Paths
const rulesPath = path.join(__dirname, 'data', 'rules.json');
const historyPath = path.join(__dirname, 'data', 'history.json');

// Helper to read JSON
function readJson(filePath, defaultVal = {}) {
  try {
    if (!fs.existsSync(filePath)) {
      fs.writeFileSync(filePath, JSON.stringify(defaultVal, null, 2), 'utf-8');
      return defaultVal;
    }
    const data = fs.readFileSync(filePath, 'utf-8');
    return JSON.parse(data);
  } catch (err) {
    console.error(`Error reading ${filePath}:`, err);
    return defaultVal;
  }
}

// Helper to write JSON
function writeJson(filePath, data) {
  try {
    fs.writeFileSync(filePath, JSON.stringify(data, null, 2), 'utf-8');
    return true;
  } catch (err) {
    console.error(`Error writing ${filePath}:`, err);
    return false;
  }
}

/**
 * Certainty Factor Calculation Engine
 * 
 * Formula:
 * CF(H, E) = CF_pakar * CF_user
 * CF_combine = CF_old + CF_new * (1 - CF_old)
 */
function calculateCertaintyFactor(selectedSymptoms = []) {
  const rulesData = readJson(rulesPath, { moods: {}, symptoms: [] });
  const { moods, symptoms } = rulesData;

  const symptomMap = new Map();
  symptoms.forEach(s => symptomMap.set(s.code, s));

  // Initialize scores per mood
  const moodScores = {};
  Object.keys(moods).forEach(code => {
    moodScores[code] = {
      ...moods[code],
      cf: 0,
      percentage: 0,
      matchedEvidence: []
    };
  });

  // Calculate CF per evidence for each mood
  selectedSymptoms.forEach(item => {
    const symptomCode = item.code;
    const cfUser = parseFloat(item.cf_user || 0.7);
    const symptomDef = symptomMap.get(symptomCode);

    if (!symptomDef) return;

    (symptomDef.rules || []).forEach(rule => {
      const moodCode = rule.mood;
      if (!moodScores[moodCode]) return;

      const cfPakar = parseFloat(rule.cf || 0);
      const cfHE = parseFloat((cfPakar * cfUser).toFixed(4));

      moodScores[moodCode].matchedEvidence.push({
        symptomCode,
        symptomName: symptomDef.name,
        category: symptomDef.category,
        cfPakar,
        cfUser,
        cfHE
      });
    });
  });

  // Combine CF for each mood
  Object.keys(moodScores).forEach(code => {
    const evidences = moodScores[code].matchedEvidence;
    if (evidences.length === 0) {
      moodScores[code].cf = 0;
      moodScores[code].percentage = 0;
      return;
    }

    let cfCombine = evidences[0].cfHE;
    for (let i = 1; i < evidences.length; i++) {
      const cfNew = evidences[i].cfHE;
      cfCombine = cfCombine + cfNew * (1 - cfCombine);
    }

    cfCombine = Math.min(1.0, Math.max(0, cfCombine));
    moodScores[code].cf = parseFloat(cfCombine.toFixed(4));
    moodScores[code].percentage = parseFloat((cfCombine * 100).toFixed(1));
  });

  // Sort moods by CF descending
  const sortedMoods = Object.values(moodScores).sort((a, b) => b.cf - a.cf);
  const dominantMood = sortedMoods.length > 0 && sortedMoods[0].cf > 0 ? sortedMoods[0] : null;

  return {
    dominantMood,
    allMoods: sortedMoods,
    selectedCount: selectedSymptoms.length
  };
}

// ----------------- API ENDPOINTS ----------------- //

// GET /api/gejala - Mengambil master gejala, kategori, opsi tingkat keyakinan, dan master mood
app.get('/api/gejala', (req, res) => {
  const rulesData = readJson(rulesPath, { categories: [], confidenceLevels: [], moods: {}, symptoms: [] });
  res.json({
    success: true,
    data: rulesData
  });
});

// POST /api/diagnosa - Menghitung Certainty Factor dari gejala yang dipilih
app.post('/api/diagnosa', (req, res) => {
  const { symptoms } = req.body;

  if (!Array.isArray(symptoms)) {
    return res.status(400).json({
      success: false,
      message: 'Body `symptoms` harus berupa array [{ code: "G01", cf_user: 0.7 }]'
    });
  }

  const result = calculateCertaintyFactor(symptoms);
  res.json({
    success: true,
    data: result
  });
});

// GET /api/riwayat - Mengambil histori diagnosa penanganan mood
app.get('/api/riwayat', (req, res) => {
  const history = readJson(historyPath, []);
  res.json({
    success: true,
    data: history
  });
});

// POST /api/riwayat - Menyimpan catatan interaksi baru
app.post('/api/riwayat', (req, res) => {
  const { customerIdentifier, notes, symptoms, dominantMood } = req.body;

  if (!dominantMood) {
    return res.status(400).json({
      success: false,
      message: 'dominantMood wajib ada untuk menyimpan riwayat'
    });
  }

  const history = readJson(historyPath, []);
  const newEntry = {
    id: `HIST-${Date.now()}`,
    timestamp: new Date().toISOString(),
    customerIdentifier: customerIdentifier || 'Pelanggan Walk-In',
    notes: notes || '-',
    symptoms: symptoms || [],
    dominantMood: {
      code: dominantMood.code,
      name: dominantMood.name,
      cf: dominantMood.cf,
      percentage: dominantMood.percentage,
      color: dominantMood.color
    }
  };

  history.unshift(newEntry); // Add to beginning
  writeJson(historyPath, history);

  res.status(201).json({
    success: true,
    message: 'Riwayat interaksi berhasil disimpan',
    data: newEntry
  });
});

// DELETE /api/riwayat/:id - Menghapus log riwayat
app.delete('/api/riwayat/:id', (req, res) => {
  const { id } = req.params;
  let history = readJson(historyPath, []);
  const initialLength = history.length;
  history = history.filter(item => item.id !== id);

  if (history.length === initialLength) {
    return res.status(404).json({
      success: false,
      message: 'Riwayat tidak ditemukan'
    });
  }

  writeJson(historyPath, history);
  res.json({
    success: true,
    message: 'Riwayat berhasil dihapus'
  });
});

// Start Express server
app.listen(PORT, () => {
  console.log(`=======================================================`);
  console.log(`  NOIR COFFEE - SISTEM PAKAR MOOD PELANGGAN (CF)       `);
  console.log(`  Server aktif di: http://127.0.0.1:${PORT}             `);
  console.log(`  Frontend:        http://127.0.0.1:${PORT}/            `);
  console.log(`=======================================================`);
});
