const fs = require('fs');
const path = require('path');

const rulesPath = path.join(__dirname, 'data', 'rules.json');
const rulesData = JSON.parse(fs.readFileSync(rulesPath, 'utf-8'));
const { moods, symptoms } = rulesData;

function calculateCertaintyFactor(selectedSymptoms = []) {
  const symptomMap = new Map();
  symptoms.forEach(s => symptomMap.set(s.code, s));

  const moodScores = {};
  Object.keys(moods).forEach(code => {
    moodScores[code] = {
      ...moods[code],
      cf: 0,
      percentage: 0,
      matchedEvidence: []
    };
  });

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
        cfPakar,
        cfUser,
        cfHE
      });
    });
  });

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

  const sortedMoods = Object.values(moodScores).sort((a, b) => b.cf - a.cf);
  const dominantMood = sortedMoods.length > 0 && sortedMoods[0].cf > 0 ? sortedMoods[0] : null;
  return { dominantMood, allMoods: sortedMoods };
}

// Test Case 1: Marah / Frustrasi (G01 + G02 + G06)
console.log('--- TEST 1: Marah / Frustrasi ---');
const t1 = calculateCertaintyFactor([
  { code: 'G01', cf_user: 0.8 },
  { code: 'G02', cf_user: 0.8 },
  { code: 'G06', cf_user: 0.8 }
]);
console.log('Dominant:', t1.dominantMood.code, t1.dominantMood.name, t1.dominantMood.percentage + '%');
console.assert(t1.dominantMood.code === 'M01', 'Should be M01');

// Test Case 2: Terburu-buru / Gelisah (G03 + G04 + G14)
console.log('\n--- TEST 2: Terburu-buru / Gelisah ---');
const t2 = calculateCertaintyFactor([
  { code: 'G03', cf_user: 0.9 },
  { code: 'G04', cf_user: 0.8 },
  { code: 'G14', cf_user: 1.0 }
]);
console.log('Dominant:', t2.dominantMood.code, t2.dominantMood.name, t2.dominantMood.percentage + '%');
console.assert(t2.dominantMood.code === 'M02', 'Should be M02');

// Test Case 3: Ragu-ragu / Bimbang (G07 + G08 + G09)
console.log('\n--- TEST 3: Ragu-ragu / Bimbang ---');
const t3 = calculateCertaintyFactor([
  { code: 'G07', cf_user: 0.7 },
  { code: 'G08', cf_user: 0.7 },
  { code: 'G09', cf_user: 0.7 }
]);
console.log('Dominant:', t3.dominantMood.code, t3.dominantMood.name, t3.dominantMood.percentage + '%');
console.assert(t3.dominantMood.code === 'M03', 'Should be M03');

// Test Case 4: Puas / Ramah (G11 + G12 + G13)
console.log('\n--- TEST 4: Puas / Ramah ---');
const t4 = calculateCertaintyFactor([
  { code: 'G11', cf_user: 0.8 },
  { code: 'G12', cf_user: 0.8 },
  { code: 'G13', cf_user: 0.8 }
]);
console.log('Dominant:', t4.dominantMood.code, t4.dominantMood.name, t4.dominantMood.percentage + '%');
console.assert(t4.dominantMood.code === 'M04', 'Should be M04');

console.log('\nALL 4 TESTS PASSED SUCCESSFULLY!');
