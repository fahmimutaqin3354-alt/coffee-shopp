/**
 * NOIR COFFEE — Client-Side Application for Mood Expert System (Certainty Factor)
 * Designed for Frontline Karyawan & Kasir (< 10 seconds execution)
 */

document.addEventListener('DOMContentLoaded', () => {
  // Application State
  const state = {
    categories: [],
    confidenceLevels: [],
    moods: {},
    symptoms: [],
    selectedSymptoms: new Map(), // code -> { code, name, category, cf_user }
    activeCategory: 'Semua',
    defaultConfidence: 0.7,
    currentDiagnosis: null,
    history: []
  };

  // DOM Elements
  const el = {
    liveClock: document.getElementById('liveClock'),
    selectedCountBadge: document.getElementById('selectedCountBadge'),
    categoryPills: document.getElementById('categoryPills'),
    confidenceRadioGroup: document.getElementById('confidenceRadioGroup'),
    symptomsContainer: document.getElementById('symptomsContainer'),
    btnUncheckAll: document.getElementById('btnUncheckAll'),
    btnResetQuick: document.getElementById('btnResetQuick'),

    // Diagnosis Output
    dominantMoodCard: document.getElementById('dominantMoodCard'),
    moodGlowBg: document.getElementById('moodGlowBg'),
    dominantMoodStatusBadge: document.getElementById('dominantMoodStatusBadge'),
    emptyMoodState: document.getElementById('emptyMoodState'),
    resultMoodState: document.getElementById('resultMoodState'),
    dominantMoodIconWrapper: document.getElementById('dominantMoodIconWrapper'),
    dominantMoodIcon: document.getElementById('dominantMoodIcon'),
    dominantMoodTitle: document.getElementById('dominantMoodTitle'),
    dominantMoodSubtitle: document.getElementById('dominantMoodSubtitle'),
    dominantMoodPercentage: document.getElementById('dominantMoodPercentage'),
    allMoodsBars: document.getElementById('allMoodsBars'),
    dominantDosList: document.getElementById('dominantDosList'),
    dominantDontsList: document.getElementById('dominantDontsList'),
    dominantScriptBox: document.getElementById('dominantScriptBox'),
    btnCopyScript: document.getElementById('btnCopyScript'),
    dominantMenuName: document.getElementById('dominantMenuName'),
    dominantMenuReason: document.getElementById('dominantMenuReason'),

    // Save Modal
    btnOpenSaveModal: document.getElementById('btnOpenSaveModal'),
    saveModal: document.getElementById('saveModal'),
    btnCloseSaveModal: document.getElementById('btnCloseSaveModal'),
    btnCancelSave: document.getElementById('btnCancelSave'),
    saveLogForm: document.getElementById('saveLogForm'),
    logCustomerIdentifier: document.getElementById('logCustomerIdentifier'),
    logNotes: document.getElementById('logNotes'),
    saveModalMoodName: document.getElementById('saveModalMoodName'),
    saveModalMoodCf: document.getElementById('saveModalMoodCf'),

    // History Modal
    btnOpenHistory: document.getElementById('btnOpenHistory'),
    historyBadgeCount: document.getElementById('historyBadgeCount'),
    historyModal: document.getElementById('historyModal'),
    btnCloseHistoryModal: document.getElementById('btnCloseHistoryModal'),
    btnCloseHistoryModalBtn: document.getElementById('btnCloseHistoryModalBtn'),
    historyListContainer: document.getElementById('historyListContainer'),
    historyTotalCount: document.getElementById('historyTotalCount'),

    // Toast
    toast: document.getElementById('toastNotification'),
    toastMessage: document.getElementById('toastMessage'),
    toastIcon: document.getElementById('toastIcon')
  };

  // 1. Initial Clock setup
  function updateLiveClock() {
    const now = new Date();
    const timeStr = now.toLocaleTimeString('id-ID', { hour12: false }) + ' WIB';
    if (el.liveClock) el.liveClock.textContent = timeStr;
  }
  setInterval(updateLiveClock, 1000);
  updateLiveClock();

  // 2. Toast Utility
  function showToast(message, type = 'success') {
    if (!el.toast) return;
    el.toastMessage.textContent = message;

    if (type === 'success') {
      el.toastIcon.className = 'bi bi-check-circle-fill text-emerald-400 text-sm';
      el.toast.style.borderColor = '#10b981';
    } else if (type === 'error') {
      el.toastIcon.className = 'bi bi-exclamation-octagon-fill text-red-400 text-sm';
      el.toast.style.borderColor = '#ef4444';
    } else {
      el.toastIcon.className = 'bi bi-info-circle-fill text-noir-gold text-sm';
      el.toast.style.borderColor = '#c89b3c';
    }

    el.toast.classList.remove('translate-y-20', 'opacity-0', 'pointer-events-none');
    setTimeout(() => {
      el.toast.classList.add('translate-y-20', 'opacity-0', 'pointer-events-none');
    }, 2800);
  }

  // 3. Load Master Data from /api/gejala
  async function loadKnowledgeBase() {
    try {
      const res = await fetch('/api/gejala');
      const json = await res.json();

      if (json.success && json.data) {
        state.categories = json.data.categories || [];
        state.confidenceLevels = json.data.confidenceLevels || [];
        state.moods = json.data.moods || {};
        state.symptoms = json.data.symptoms || [];

        renderCategoryPills();
        renderConfidenceSelector();
        renderSymptomsList();
        loadHistoryCount();
      } else {
        showToast('Gagal memuat aturan sistem pakar', 'error');
      }
    } catch (err) {
      console.error('Fetch error:', err);
      showToast('Koneksi ke backend terputus', 'error');
    }
  }

  // 4. Render Category Filter Pills
  function renderCategoryPills() {
    el.categoryPills.innerHTML = '';
    state.categories.forEach(cat => {
      const btn = document.createElement('button');
      const isActive = state.activeCategory === cat;
      btn.className = `px-3 py-1 rounded-full text-xs font-semibold transition ${
        isActive 
          ? 'bg-noir-gold text-black shadow-md shadow-noir-gold/20' 
          : 'bg-noir-850 hover:bg-noir-800 text-gray-300 border border-noir-gold/20'
      }`;
      btn.textContent = cat;
      btn.addEventListener('click', () => {
        state.activeCategory = cat;
        renderCategoryPills();
        renderSymptomsList();
      });
      el.categoryPills.appendChild(btn);
    });
  }

  // 5. Render Global Default Confidence Selector
  function renderConfidenceSelector() {
    el.confidenceRadioGroup.innerHTML = '';
    state.confidenceLevels.forEach(conf => {
      const isSelected = state.defaultConfidence === conf.value;
      const btn = document.createElement('button');
      btn.type = 'button';
      btn.className = `px-2 py-0.5 rounded text-[11px] font-bold transition border ${
        isSelected
          ? 'bg-noir-gold/25 text-noir-gold-light border-noir-gold'
          : 'bg-noir-900 text-gray-400 border-noir-gold/15 hover:text-gray-200'
      }`;
      btn.textContent = conf.label;
      btn.title = `Bobot user CF: ${conf.value}`;
      btn.addEventListener('click', () => {
        state.defaultConfidence = conf.value;
        renderConfidenceSelector();
        // Update all currently selected symptoms that have not customized confidence
        state.selectedSymptoms.forEach((item, key) => {
          item.cf_user = conf.value;
        });
        runDiagnosis();
      });
      el.confidenceRadioGroup.appendChild(btn);
    });
  }

  // 6. Render Symptoms Cards
  function renderSymptomsList() {
    el.symptomsContainer.innerHTML = '';

    const filtered = state.symptoms.filter(s => {
      if (state.activeCategory === 'Semua') return true;
      return s.category === state.activeCategory;
    });

    if (filtered.length === 0) {
      el.symptomsContainer.innerHTML = `
        <div class="col-span-2 py-8 text-center text-gray-500 text-xs">
          Tidak ada gejala pada kategori ini.
        </div>
      `;
      return;
    }

    filtered.forEach(symptom => {
      const isSelected = state.selectedSymptoms.has(symptom.code);
      const selectedItem = state.selectedSymptoms.get(symptom.code);

      const card = document.createElement('div');
      card.className = `p-3 rounded-xl border transition-all cursor-pointer select-none relative flex flex-col justify-between ${
        isSelected
          ? 'active-tag bg-noir-850'
          : 'bg-noir-850/60 hover:bg-noir-800/80 border-noir-gold/15 text-gray-300'
      }`;

      // Card Header
      const headerDiv = document.createElement('div');
      headerDiv.className = 'flex items-start justify-between gap-2 mb-1.5';

      const codeBadge = document.createElement('span');
      codeBadge.className = `text-[10px] font-mono font-bold px-1.5 py-0.5 rounded ${
        isSelected
          ? 'bg-noir-gold text-black'
          : 'bg-noir-950 text-noir-gold-light border border-noir-gold/20'
      }`;
      codeBadge.textContent = symptom.code;

      const catBadge = document.createElement('span');
      catBadge.className = 'text-[10px] text-gray-400 truncate max-w-[140px]';
      catBadge.textContent = symptom.category;

      headerDiv.appendChild(codeBadge);
      headerDiv.appendChild(catBadge);

      // Card Body: Symptom Name
      const nameP = document.createElement('p');
      nameP.className = `text-xs leading-snug font-medium mb-2 ${isSelected ? 'text-white font-semibold' : 'text-gray-300'}`;
      nameP.textContent = symptom.name;

      // Card Footer: Checkbox indicator + Individual Confidence Toggle
      const footerDiv = document.createElement('div');
      footerDiv.className = 'flex items-center justify-between pt-1 border-t border-noir-gold/10 text-[11px]';

      const checkWrapper = document.createElement('div');
      checkWrapper.className = 'flex items-center space-x-1.5';
      const checkIcon = document.createElement('i');
      checkIcon.className = isSelected 
        ? 'bi bi-check-square-fill text-noir-gold text-sm' 
        : 'bi bi-square text-gray-500 text-sm';
      const checkText = document.createElement('span');
      checkText.className = isSelected ? 'text-noir-gold-light font-bold' : 'text-gray-400';
      checkText.textContent = isSelected ? 'Terdeteksi' : 'Pilih';
      checkWrapper.appendChild(checkIcon);
      checkWrapper.appendChild(checkText);

      footerDiv.appendChild(checkWrapper);

      // If selected, allow tuning specific CF weight
      if (isSelected) {
        const cfBadge = document.createElement('span');
        cfBadge.className = 'text-[10px] font-mono px-1.5 py-0.5 rounded bg-noir-950 text-emerald-400 border border-emerald-500/30';
        cfBadge.textContent = `CF: ${selectedItem.cf_user}`;
        footerDiv.appendChild(cfBadge);
      }

      card.appendChild(headerDiv);
      card.appendChild(nameP);
      card.appendChild(footerDiv);

      // Card click event
      card.addEventListener('click', (e) => {
        toggleSymptom(symptom);
      });

      el.symptomsContainer.appendChild(card);
    });

    updateSelectedBadge();
  }

  // 7. Toggle Symptom selection
  function toggleSymptom(symptom) {
    if (state.selectedSymptoms.has(symptom.code)) {
      state.selectedSymptoms.delete(symptom.code);
    } else {
      state.selectedSymptoms.set(symptom.code, {
        code: symptom.code,
        name: symptom.name,
        category: symptom.category,
        cf_user: state.defaultConfidence
      });
    }

    renderSymptomsList();
    runDiagnosis();
  }

  // 8. Update Badge Count
  function updateSelectedBadge() {
    const count = state.selectedSymptoms.size;
    if (el.selectedCountBadge) el.selectedCountBadge.textContent = count;
  }

  // 9. Run Real-time Diagnosis (POST /api/diagnosa)
  let debounceTimeout = null;
  function runDiagnosis() {
    clearTimeout(debounceTimeout);
    debounceTimeout = setTimeout(async () => {
      const selectedArray = Array.from(state.selectedSymptoms.values()).map(s => ({
        code: s.code,
        cf_user: s.cf_user
      }));

      if (selectedArray.length === 0) {
        state.currentDiagnosis = null;
        renderEmptyState();
        return;
      }

      try {
        const res = await fetch('/api/diagnosa', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ symptoms: selectedArray })
        });
        const json = await res.json();

        if (json.success && json.data) {
          state.currentDiagnosis = json.data;
          renderDiagnosisResult(json.data);
        }
      } catch (err) {
        console.error('Diagnosis error:', err);
      }
    }, 60);
  }

  // 10. Render Empty State
  function renderEmptyState() {
    el.emptyMoodState.classList.remove('hidden');
    el.resultMoodState.classList.add('hidden');
    el.dominantMoodStatusBadge.textContent = 'Menunggu Input';
    el.dominantMoodStatusBadge.className = 'text-[10px] uppercase font-bold tracking-wider px-2 py-0.5 rounded-full bg-gray-800 text-gray-400 border border-gray-700';
    el.dominantMoodCard.style.borderColor = 'rgba(200, 155, 60, 0.25)';
    el.moodGlowBg.style.backgroundColor = 'rgba(200, 155, 60, 0.1)';
  }

  // 11. Render Diagnosis Result
  function renderDiagnosisResult(data) {
    const dominant = data.dominantMood;
    if (!dominant) {
      renderEmptyState();
      return;
    }

    el.emptyMoodState.classList.add('hidden');
    el.resultMoodState.classList.remove('hidden');

    // Status Badge
    el.dominantMoodStatusBadge.textContent = `CF Terkonfirmasi (${dominant.code})`;
    el.dominantMoodStatusBadge.className = 'text-[10px] uppercase font-bold tracking-wider px-2.5 py-0.5 rounded-full text-black font-mono shadow';
    el.dominantMoodStatusBadge.style.backgroundColor = dominant.color;

    // Mood Colors & Borders
    el.dominantMoodCard.style.borderColor = dominant.border || dominant.color;
    el.moodGlowBg.style.backgroundColor = dominant.bgSoft || 'rgba(200, 155, 60, 0.2)';

    // Icon & Header
    el.dominantMoodIconWrapper.style.backgroundColor = dominant.bgSoft || 'rgba(200, 155, 60, 0.2)';
    el.dominantMoodIconWrapper.style.borderColor = dominant.border || dominant.color;
    el.dominantMoodIconWrapper.style.borderWidth = '1px';
    el.dominantMoodIcon.className = `bi ${dominant.icon} text-3xl`;
    el.dominantMoodIcon.style.color = dominant.color;

    el.dominantMoodTitle.textContent = dominant.name;
    el.dominantMoodSubtitle.textContent = dominant.subtitle || '';
    
    // Confidence Percentage
    el.dominantMoodPercentage.textContent = `${dominant.percentage.toFixed(1)}%`;
    el.dominantMoodPercentage.style.color = dominant.color;

    // Breakdown Bars for all 4 moods
    el.allMoodsBars.innerHTML = '';
    (data.allMoods || []).forEach(m => {
      const row = document.createElement('div');
      row.className = 'space-y-1';

      const labelDiv = document.createElement('div');
      labelDiv.className = 'flex justify-between text-[11px]';
      labelDiv.innerHTML = `
        <span class="text-gray-300 font-medium ${m.code === dominant.code ? 'text-white font-bold' : ''}">${m.name}</span>
        <span class="font-mono ${m.code === dominant.code ? 'font-bold' : 'text-gray-400'}" style="color: ${m.code === dominant.code ? m.color : '#9ca3af'}">${m.percentage.toFixed(1)}%</span>
      `;

      const barBg = document.createElement('div');
      barBg.className = 'w-full h-1.5 bg-noir-850 rounded-full overflow-hidden border border-noir-gold/10';

      const barFill = document.createElement('div');
      barFill.className = 'h-full rounded-full transition-all duration-500';
      barFill.style.width = `${Math.max(2, m.percentage)}%`;
      barFill.style.backgroundColor = m.color;

      barBg.appendChild(barFill);
      row.appendChild(labelDiv);
      row.appendChild(barBg);
      el.allMoodsBars.appendChild(row);
    });

    // DO's List
    el.dominantDosList.innerHTML = '';
    (dominant.dos || []).forEach(d => {
      const li = document.createElement('li');
      li.className = 'leading-relaxed';
      li.textContent = d;
      el.dominantDosList.appendChild(li);
    });

    // DON'TS List
    el.dominantDontsList.innerHTML = '';
    (dominant.donts || []).forEach(d => {
      const li = document.createElement('li');
      li.className = 'leading-relaxed';
      li.textContent = d;
      el.dominantDontsList.appendChild(li);
    });

    // Scripts
    const firstScript = (dominant.scripts && dominant.scripts.length > 0) 
      ? dominant.scripts[0] 
      : '"Terima kasih telah berkunjung ke NOIR COFFEE. Ada yang bisa kami bantu kembali Kak?"';
    el.dominantScriptBox.textContent = firstScript;

    // Recommended Menu Pairing
    if (dominant.recommendedMenu) {
      el.dominantMenuName.textContent = dominant.recommendedMenu.nama;
      el.dominantMenuReason.textContent = dominant.recommendedMenu.alasan;
    }
  }

  // 12. Copy Script Button
  el.btnCopyScript.addEventListener('click', () => {
    const text = el.dominantScriptBox.textContent;
    if (!text) return;

    // Clean quotes for clipboard
    const cleanText = text.replace(/^"|"$/g, '').trim();
    navigator.clipboard.writeText(cleanText).then(() => {
      showToast('Skrip berhasil disalin ke clipboard!', 'success');
      el.btnCopyScript.innerHTML = '<i class="bi bi-check-lg text-emerald-400"></i><span>Tersalin!</span>';
      setTimeout(() => {
        el.btnCopyScript.innerHTML = '<i class="bi bi-clipboard"></i><span>Salin Skrip</span>';
      }, 2000);
    }).catch(err => {
      console.error(err);
      showToast('Gagal menyalin teks', 'error');
    });
  });

  // 13. Reset Buttons
  function resetAll() {
    state.selectedSymptoms.clear();
    state.currentDiagnosis = null;
    renderSymptomsList();
    renderEmptyState();
    showToast('Input checklist berhasil di-reset', 'info');
  }

  el.btnUncheckAll.addEventListener('click', resetAll);
  el.btnResetQuick.addEventListener('click', resetAll);

  // 14. Save Log Interaction Modal
  el.btnOpenSaveModal.addEventListener('click', () => {
    if (!state.currentDiagnosis || !state.currentDiagnosis.dominantMood) {
      showToast('Belum ada diagnosa aktif untuk disimpan', 'error');
      return;
    }
    const dom = state.currentDiagnosis.dominantMood;
    el.saveModalMoodName.textContent = dom.name;
    el.saveModalMoodCf.textContent = `${dom.percentage.toFixed(1)}% (CF: ${dom.cf})`;
    el.logCustomerIdentifier.value = '';
    el.logNotes.value = '';
    el.saveModal.classList.remove('hidden');
    el.logCustomerIdentifier.focus();
  });

  function closeSaveModal() {
    el.saveModal.classList.add('hidden');
  }

  el.btnCloseSaveModal.addEventListener('click', closeSaveModal);
  el.btnCancelSave.addEventListener('click', closeSaveModal);

  // Submit Save Log
  el.saveLogForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    if (!state.currentDiagnosis || !state.currentDiagnosis.dominantMood) return;

    const dom = state.currentDiagnosis.dominantMood;
    const payload = {
      customerIdentifier: el.logCustomerIdentifier.value.trim(),
      notes: el.logNotes.value.trim(),
      symptoms: Array.from(state.selectedSymptoms.values()),
      dominantMood: {
        code: dom.code,
        name: dom.name,
        cf: dom.cf,
        percentage: dom.percentage,
        color: dom.color
      }
    };

    try {
      const res = await fetch('/api/riwayat', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
      });
      const json = await res.json();

      if (json.success) {
        showToast('Catatan interaksi tersimpan!', 'success');
        closeSaveModal();
        loadHistoryCount();
      } else {
        showToast(json.message || 'Gagal menyimpan riwayat', 'error');
      }
    } catch (err) {
      console.error('Save log error:', err);
      showToast('Gagal menghubungi server', 'error');
    }
  });

  // 15. History Modal & Management
  async function loadHistoryCount() {
    try {
      const res = await fetch('/api/riwayat');
      const json = await res.json();
      if (json.success && Array.isArray(json.data)) {
        state.history = json.data;
        if (el.historyBadgeCount) el.historyBadgeCount.textContent = json.data.length;
        if (el.historyTotalCount) el.historyTotalCount.textContent = json.data.length;
      }
    } catch (err) {
      console.error(err);
    }
  }

  async function openHistoryModal() {
    await loadHistoryCount();
    renderHistoryList();
    el.historyModal.classList.remove('hidden');
  }

  function closeHistoryModal() {
    el.historyModal.classList.add('hidden');
  }

  el.btnOpenHistory.addEventListener('click', openHistoryModal);
  el.btnCloseHistoryModal.addEventListener('click', closeHistoryModal);
  el.btnCloseHistoryModalBtn.addEventListener('click', closeHistoryModal);

  function renderHistoryList() {
    el.historyListContainer.innerHTML = '';
    if (state.history.length === 0) {
      el.historyListContainer.innerHTML = `
        <div class="py-12 text-center text-gray-500 text-xs">
          <i class="bi bi-clock-history text-3xl mb-2 inline-block text-gray-600"></i>
          <p>Belum ada log interaksi yang tersimpan shift ini.</p>
        </div>
      `;
      return;
    }

    state.history.forEach(item => {
      const row = document.createElement('div');
      row.className = 'p-3.5 rounded-xl bg-noir-850 border border-noir-gold/20 flex flex-col space-y-2';

      const timeStr = new Date(item.timestamp).toLocaleString('id-ID', {
        dateStyle: 'medium',
        timeStyle: 'short'
      });

      const mood = item.dominantMood || {};
      const symptomsListStr = (item.symptoms || []).map(s => s.code || s).join(', ');

      row.innerHTML = `
        <div class="flex items-center justify-between">
          <div class="flex items-center space-x-2">
            <span class="text-xs font-bold text-white">${item.customerIdentifier || 'Pelanggan'}</span>
            <span class="text-[10px] px-2 py-0.5 rounded-full font-bold text-black" style="background-color: ${mood.color || '#c89b3c'}">
              ${mood.name || 'Mood'} &bull; ${mood.percentage ? mood.percentage.toFixed(1) + '%' : ''}
            </span>
          </div>
          <div class="flex items-center space-x-2">
            <span class="text-[11px] text-gray-400 font-mono">${timeStr}</span>
            <button class="btn-delete-history text-gray-500 hover:text-red-400 transition text-xs p-1" data-id="${item.id}" title="Hapus catatan">
              <i class="bi bi-trash"></i>
            </button>
          </div>
        </div>
        <div class="text-[11px] text-gray-300">
          <span class="text-gray-400">Tanda teramati:</span> <span class="font-mono text-noir-gold-light">${symptomsListStr || '-'}</span>
        </div>
        ${item.notes && item.notes !== '-' ? `
          <div class="text-[11px] text-gray-400 italic bg-noir-900/60 p-2 rounded border border-noir-gold/10">
            "${item.notes}"
          </div>
        ` : ''}
      `;

      // Delete listener
      const deleteBtn = row.querySelector('.btn-delete-history');
      deleteBtn.addEventListener('click', async () => {
        if (!confirm('Hapus log riwayat ini?')) return;
        try {
          const res = await fetch(`/api/riwayat/${item.id}`, { method: 'DELETE' });
          const resJson = await res.json();
          if (resJson.success) {
            showToast('Riwayat berhasil dihapus', 'info');
            loadHistoryCount();
            row.remove();
          }
        } catch (err) {
          console.error(err);
          showToast('Gagal menghapus riwayat', 'error');
        }
      });

      el.historyListContainer.appendChild(row);
    });
  }

  // Boot
  loadKnowledgeBase();
});
