<?php
$maxillaryPrimary = ['55', '54', '53', '52', '51', '61', '62', '63', '64', '65'];
$maxillaryPermanent = ['18', '17', '16', '15', '14', '13', '12', '11', '21', '22', '23', '24', '25', '26', '27', '28'];
$mandibularPermanent = ['48', '47', '46', '45', '44', '43', '42', '41', '31', '32', '33', '34', '35', '36', '37', '38'];
$mandibularPrimary = ['85', '84', '83', '82', '81', '71', '72', '73', '74', '75'];

$chartStatuses = [
  'decayed' => ['label' => 'Decayed', 'color' => '#ff2d2d'],
  'missing' => ['label' => 'Missing', 'color' => '#ffffff'],
  'bridge_pontic' => ['label' => 'Bridge Pontic', 'color' => '#a8e79a'],
  'reset' => ['label' => 'Reset', 'color' => '#d0d0d0'],
  'attrition' => ['label' => 'Attrition', 'color' => '#c450d7'],
  'mobile' => ['label' => 'Mobile', 'color' => '#cf6b38'],
  'partially_impacted' => ['label' => 'Partially Impacted', 'color' => '#cab56f'],
  'for_extraction' => ['label' => 'For Extraction', 'color' => '#ff5757'],
  'recurrent_caries' => ['label' => 'Recurrent Caries', 'color' => '#b23558'],
  'filled' => ['label' => 'Filled', 'color' => '#111ee6'],
  'implant' => ['label' => 'Implant', 'color' => '#c6c21f'],
  'crown_bridge_abutment' => ['label' => 'Crown/Bridge Abutment', 'color' => '#30cf25'],
  'abrasion' => ['label' => 'Abrasion', 'color' => '#ef7f7f'],
  'abfraction' => ['label' => 'Abfraction', 'color' => '#ca385e'],
  'impacted' => ['label' => 'Impacted', 'color' => '#8f7c3b'],
  'unerupted' => ['label' => 'Unerupted', 'color' => '#efd9b5'],
  'root_canal_treated' => ['label' => 'Root Canal Treated', 'color' => '#2ea8a1'],
  'healthy' => ['label' => 'Healthy', 'color' => '#a4a4a4'],
];

$patientFullName = 'No Patient Selected';
$patientPhoto = '';
if (!empty($selectedPatient)) {
    $patientFullName = trim((string) (($selectedPatient['first_name'] ?? '') . ' ' . ($selectedPatient['middle_name'] ?? '') . ' ' . ($selectedPatient['last_name'] ?? '')));
    if ($patientFullName === '') {
        $patientFullName = (string) ($selectedPatient['id'] ?? 'Patient');
    }
    $patientPhoto = !empty($selectedPatient['photo']) ? '../' . ltrim((string) $selectedPatient['photo'], '/') : '';
}

if (!function_exists('renderDentalChartRow')) {
    function renderDentalChartRow(array $teeth, int $leftCount): void
    {
    $surfaceLabels = [
      't' => 'Top Surface',
      'l' => 'Left Surface',
      'c' => 'Center Surface',
      'r' => 'Right Surface',
      'b' => 'Bottom Surface',
    ];

        echo '<div class="dc-row">';

        foreach ($teeth as $index => $tooth) {
            if ($index === $leftCount) {
                echo '<div class="dc-mid-gap" aria-hidden="true"></div>';
            }

            echo '<div class="dc-tooth" data-tooth="' . htmlspecialchars($tooth, ENT_QUOTES, 'UTF-8') . '">';
            echo '<span class="dc-tooth-number">' . htmlspecialchars($tooth, ENT_QUOTES, 'UTF-8') . '</span>';
            echo '<div class="dc-tooth-icon">';

            foreach ($surfaceLabels as $surfaceCode => $surfaceLabel) {
              echo '<button type="button" class="dc-surface dc-surface-' . htmlspecialchars($surfaceCode, ENT_QUOTES, 'UTF-8') . '" data-tooth="' . htmlspecialchars($tooth, ENT_QUOTES, 'UTF-8') . '" data-surface="' . htmlspecialchars($surfaceCode, ENT_QUOTES, 'UTF-8') . '" data-status="healthy" aria-label="Tooth ' . htmlspecialchars($tooth, ENT_QUOTES, 'UTF-8') . ' ' . htmlspecialchars($surfaceLabel, ENT_QUOTES, 'UTF-8') . '"></button>';
            }

            echo '</div>';
            echo '</div>';
        }

        echo '</div>';
    }
}

$patientSearchItems = [];
foreach ($patientList as $item) {
    $itemName = trim((string) (($item['first_name'] ?? '') . ' ' . ($item['middle_name'] ?? '') . ' ' . ($item['last_name'] ?? '')));
    $patientSearchItems[] = [
      'id' => (string) ($item['id'] ?? ''),
      'name' => $itemName !== '' ? $itemName : (string) ($item['id'] ?? 'Patient'),
    ];
}
?>

<section class="px-4 pb-8 pt-4 sm:px-6 md:px-8">
  <div class="mx-auto max-w-[1500px]">
    <div class="grid gap-4 xl:grid-cols-[410px_minmax(0,1fr)]">
      <aside class="space-y-4">
        <div class="rounded-[22px] border border-white/70 bg-white p-4 shadow-[0_18px_42px_-30px_rgba(15,23,42,0.45)]">
          <div class="rounded-[16px] bg-slate-300 h-24"></div>
          <div class="-mt-9 flex justify-center">
            <div class="h-[96px] w-[96px] overflow-hidden rounded-full border-[5px] border-white bg-slate-200 shadow-md">
              <?php if ($patientPhoto !== ''): ?>
                <img src="<?= htmlspecialchars($patientPhoto, ENT_QUOTES, 'UTF-8') ?>" alt="Patient photo" class="h-full w-full object-cover">
              <?php else: ?>
                <div class="flex h-full w-full items-center justify-center text-slate-400">
                  <i data-feather="user" class="h-8 w-8"></i>
                </div>
              <?php endif; ?>
            </div>
          </div>

          <div class="mt-3 text-center">
            <h2 class="text-3xl font-semibold tracking-tight text-slate-900"><?= htmlspecialchars($patientFullName, ENT_QUOTES, 'UTF-8') ?></h2>
            <p class="mt-1 text-sm font-semibold text-slate-700">ID: <?= htmlspecialchars((string) ($selectedPatient['id'] ?? '-'), ENT_QUOTES, 'UTF-8') ?></p>
            <p class="mt-2 text-sm text-slate-500"><?= htmlspecialchars((string) ($selectedPatient['occupation'] ?? 'No occupation'), ENT_QUOTES, 'UTF-8') ?></p>
          </div>

          <form method="GET" action="dental-chart.php" class="mt-4">
            <label for="dcPatientSearch" class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Select Patient</label>
            <div class="relative flex gap-2">
              <input id="dcPatientSearch" type="text" value="<?= htmlspecialchars($patientFullName, ENT_QUOTES, 'UTF-8') ?>" placeholder="Search patient name..." class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700" autocomplete="off">
              <input id="dcPatientIdInput" type="hidden" name="id" value="<?= htmlspecialchars((string) ($selectedPatient['id'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
              <button type="submit" class="rounded-xl bg-blue-700 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-800">Load</button>
            </div>
            <div id="dcPatientResults" class="dc-patient-results hidden"></div>
            <script id="dcPatientData" type="application/json"><?= json_encode($patientSearchItems, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?></script>
          </form>

          <div class="mt-4 grid grid-cols-2 gap-x-5 gap-y-3 text-sm">
            <div>
              <p class="text-xs uppercase text-slate-400">Age</p>
              <p class="font-semibold text-slate-700"><?= htmlspecialchars((string) ($selectedPatient['age'] ?? '-'), ENT_QUOTES, 'UTF-8') ?></p>
            </div>
            <div>
              <p class="text-xs uppercase text-slate-400">Gender</p>
              <p class="font-semibold text-slate-700"><?= htmlspecialchars((string) ($selectedPatient['sex'] ?? '-'), ENT_QUOTES, 'UTF-8') ?></p>
            </div>
            <div>
              <p class="text-xs uppercase text-slate-400">Mobile</p>
              <p class="font-semibold text-slate-700"><?= htmlspecialchars((string) ($selectedPatient['mobile_no'] ?? '-'), ENT_QUOTES, 'UTF-8') ?></p>
            </div>
            <div>
              <p class="text-xs uppercase text-slate-400">Birthday</p>
              <p class="font-semibold text-slate-700"><?= htmlspecialchars((string) ($selectedPatient['birthday'] ?? '-'), ENT_QUOTES, 'UTF-8') ?></p>
            </div>
            <div class="col-span-2">
              <p class="text-xs uppercase text-slate-400">Address</p>
              <p class="font-semibold text-slate-700"><?= htmlspecialchars((string) ($selectedPatient['home_address'] ?? '-'), ENT_QUOTES, 'UTF-8') ?></p>
            </div>
          </div>
        </div>
      </aside>

      <div class="rounded-[26px] border border-white/70 bg-white/95 p-4 shadow-[0_22px_54px_-36px_rgba(15,23,42,0.42)] sm:p-6">
        <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
          <div>
            <h1 class="text-2xl font-semibold tracking-tight text-slate-900">PDA Dental Chart</h1>
            <p class="mt-1 text-sm text-slate-500">Clickable odontogram with color variations for charting.</p>
          </div>
          <button id="dcResetAll" type="button" class="inline-flex items-center gap-2 rounded-full bg-red-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-red-700">
            <i data-feather="rotate-ccw" class="h-4 w-4"></i>
            Reset All
          </button>
        </div>

        <div class="dc-chart-shell" data-chart-key="dentcoms_dental_chart_state_<?= htmlspecialchars((string) ($selectedPatient['id'] ?? 'default'), ENT_QUOTES, 'UTF-8') ?>">
          <div class="dc-arch-label">Labial</div>
          <?php renderDentalChartRow($maxillaryPrimary, 5); ?>
          <?php renderDentalChartRow($maxillaryPermanent, 8); ?>

          <div class="dc-arch-label">Lingual</div>
          <?php renderDentalChartRow($mandibularPermanent, 8); ?>
          <?php renderDentalChartRow($mandibularPrimary, 5); ?>
          <div class="dc-arch-label">Labial</div>
        </div>

        <div id="dcStatusPicker" class="dc-status-picker hidden" role="dialog" aria-modal="false" aria-label="Select chart condition">
          <p class="dc-status-picker-title">Select Condition</p>
          <div class="dc-status-picker-list">
            <?php foreach ($chartStatuses as $statusKey => $statusMeta): ?>
              <button type="button" class="dc-status-option" data-status-option="<?= htmlspecialchars($statusKey, ENT_QUOTES, 'UTF-8') ?>">
                <span class="dc-status-option-dot" style="--dc-dot-color: <?= htmlspecialchars($statusMeta['color'], ENT_QUOTES, 'UTF-8') ?>;"></span>
                <?= htmlspecialchars((string) $statusMeta['label'], ENT_QUOTES, 'UTF-8') ?>
              </button>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="mt-6 rounded-2xl border border-slate-200 bg-white p-4">
          <p class="text-[22px] font-semibold text-slate-800">Dental Chart Legend</p>
          <div class="mt-4 grid gap-x-6 gap-y-3 sm:grid-cols-2">
            <?php foreach ($chartStatuses as $statusMeta): ?>
              <div class="dc-legend-item">
                <span class="dc-dot" style="--dc-dot-color: <?= htmlspecialchars($statusMeta['color'], ENT_QUOTES, 'UTF-8') ?>;"></span>
                <?= htmlspecialchars((string) $statusMeta['label'], ENT_QUOTES, 'UTF-8') ?>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<style>
  .dc-chart-shell {
    overflow-x: auto;
    border-radius: 20px;
    border: 1px solid #e2e8f0;
    background: linear-gradient(180deg, #f8fbff 0%, #ffffff 100%);
    padding: 12px;
  }

  .dc-arch-label {
    margin: 8px auto 10px;
    width: fit-content;
    border-radius: 999px;
    background: #eef2f7;
    padding: 3px 12px;
    font-size: 18px;
    font-weight: 600;
    color: #64748b;
  }

  .dc-row {
    display: grid;
    grid-auto-flow: column;
    grid-auto-columns: minmax(34px, 1fr);
    gap: 5px;
    align-items: end;
    margin-bottom: 10px;
    min-width: 760px;
  }

  .dc-mid-gap {
    width: 14px;
  }

  .dc-tooth {
    display: grid;
    gap: 4px;
    justify-items: center;
    border-radius: 10px;
    border: 1px solid transparent;
    background: transparent;
    padding: 3px 1px 4px;
    transition: transform 150ms ease, border-color 150ms ease, background-color 150ms ease;
  }

  .dc-tooth:hover {
    transform: translateY(-1px);
    border-color: #cbd5e1;
    background: #f8fafc;
  }

  .dc-tooth-number {
    font-size: 16px;
    line-height: 1;
    color: #334155;
  }

  .dc-tooth-icon {
    position: relative;
    display: grid;
    grid-template-columns: 8px 12px 8px;
    grid-template-rows: 6px 12px 6px;
    gap: 1px;
    width: 30px;
    height: 24px;
  }

  .dc-surface {
    border-radius: 999px;
    border: 1px solid #d5d9e1;
    background: #a4a4a4;
    cursor: pointer;
    transition: transform 120ms ease, box-shadow 120ms ease, background-color 150ms ease;
  }

  .dc-surface:hover {
    transform: scale(1.06);
    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
  }

  .dc-surface-t { grid-column: 2; grid-row: 1; }
  .dc-surface-l { grid-column: 1; grid-row: 2; }
  .dc-surface-c { grid-column: 2; grid-row: 2; border-radius: 4px; }
  .dc-surface-r { grid-column: 3; grid-row: 2; }
  .dc-surface-b { grid-column: 2; grid-row: 3; }

  .dc-surface-l,
  .dc-surface-r {
    height: 12px;
    align-self: center;
  }

  .dc-surface-t,
  .dc-surface-b {
    width: 12px;
    justify-self: center;
  }

  .dc-surface[data-status='decayed'] { background: #ff2d2d; }
  .dc-surface[data-status='missing'] { background: #ffffff; }
  .dc-surface[data-status='bridge_pontic'] { background: #a8e79a; }
  .dc-surface[data-status='attrition'] { background: #c450d7; }
  .dc-surface[data-status='mobile'] { background: #cf6b38; }
  .dc-surface[data-status='partially_impacted'] { background: #cab56f; }
  .dc-surface[data-status='for_extraction'] { background: #ff5757; }
  .dc-surface[data-status='recurrent_caries'] { background: #b23558; }
  .dc-surface[data-status='filled'] { background: #111ee6; }
  .dc-surface[data-status='implant'] { background: #c6c21f; }
  .dc-surface[data-status='crown_bridge_abutment'] { background: #30cf25; }
  .dc-surface[data-status='abrasion'] { background: #ef7f7f; }
  .dc-surface[data-status='abfraction'] { background: #ca385e; }
  .dc-surface[data-status='impacted'] { background: #8f7c3b; }
  .dc-surface[data-status='unerupted'] { background: #efd9b5; }
  .dc-surface[data-status='root_canal_treated'] { background: #2ea8a1; }
  .dc-surface[data-status='healthy'] { background: #a4a4a4; }

  .dc-status-picker {
    position: fixed;
    z-index: 120;
    width: min(240px, calc(100vw - 20px));
    max-height: min(62vh, 420px);
    overflow: hidden;
    border-radius: 12px;
    border: 1px solid #d7dee8;
    background: #f8fafc;
    box-shadow: 0 24px 48px -28px rgba(15, 23, 42, 0.55);
  }

  .dc-patient-results {
    margin-top: 8px;
    max-height: 210px;
    overflow: auto;
    border-radius: 14px;
    border: 1px solid #d7dee8;
    background: #ffffff;
    box-shadow: 0 14px 28px -20px rgba(15, 23, 42, 0.45);
  }

  .dc-patient-results.hidden {
    display: none;
  }

  .dc-patient-option {
    width: 100%;
    border: 0;
    border-bottom: 1px solid #e2e8f0;
    background: #ffffff;
    padding: 10px 12px;
    text-align: left;
    font-size: 14px;
    font-weight: 600;
    color: #334155;
    cursor: pointer;
  }

  .dc-patient-option:last-child {
    border-bottom: 0;
  }

  .dc-patient-option:hover {
    background: #eff6ff;
  }

  .dc-status-picker.hidden {
    display: none;
  }

  .dc-status-picker-title {
    margin: 0;
    border-bottom: 1px solid #e2e8f0;
    padding: 8px 10px;
    font-size: 13px;
    font-weight: 700;
    color: #24496f;
  }

  .dc-status-picker-list {
    max-height: min(56vh, 360px);
    overflow: auto;
    background: #f8fafc;
  }

  .dc-status-option {
    display: flex;
    width: 100%;
    align-items: center;
    gap: 8px;
    border: 0;
    border-bottom: 1px solid #e2e8f0;
    background: transparent;
    padding: 7px 10px;
    text-align: left;
    font-size: 13px;
    font-weight: 600;
    color: #24496f;
    cursor: pointer;
  }

  .dc-status-option:hover {
    background: #edf2f7;
  }

  .dc-status-option-dot {
    width: 10px;
    height: 10px;
    border-radius: 999px;
    border: 1px solid #cbd5e1;
    background: var(--dc-dot-color, #a4a4a4);
    flex: 0 0 auto;
  }

  .dc-legend-item {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-size: 16px;
    color: #334155;
  }

  .dc-dot {
    width: 14px;
    height: 14px;
    border-radius: 999px;
    border: 1px solid #d1d5db;
    background: var(--dc-dot-color, #a4a4a4);
  }

  @media (max-width: 768px) {
    .dc-arch-label {
      font-size: 14px;
    }

    .dc-tooth-number {
      font-size: 14px;
    }

    .dc-chart-shell {
      padding: 10px;
    }

    .dc-row {
      min-width: 660px;
    }
  }
</style>

<script>
  (function () {
    const patientSearchInput = document.getElementById('dcPatientSearch');
    const patientIdInput = document.getElementById('dcPatientIdInput');
    const patientResults = document.getElementById('dcPatientResults');
    const patientDataNode = document.getElementById('dcPatientData');
    const patientForm = patientSearchInput ? patientSearchInput.closest('form') : null;

    let patientItems = [];
    if (patientDataNode) {
      try {
        const parsed = JSON.parse(patientDataNode.textContent || '[]');
        patientItems = Array.isArray(parsed) ? parsed : [];
      } catch (error) {
        patientItems = [];
      }
    }

    function renderPatientResults(query) {
      if (!patientResults) {
        return;
      }

      const term = (query || '').trim().toLowerCase();
      if (term === '') {
        patientResults.innerHTML = '';
        patientResults.classList.add('hidden');
        return;
      }

      const matched = patientItems
        .filter(item => String(item.name || '').toLowerCase().includes(term) || String(item.id || '').toLowerCase().includes(term))
        .slice(0, 8);

      if (matched.length === 0) {
        patientResults.innerHTML = '';
        patientResults.classList.add('hidden');
        return;
      }

      patientResults.innerHTML = matched.map(item => {
        const safeName = String(item.name || '').replace(/"/g, '&quot;');
        const safeId = String(item.id || '').replace(/"/g, '&quot;');
        return `<button type="button" class="dc-patient-option" data-patient-id="${safeId}" data-patient-name="${safeName}">${safeName} <span style="color:#64748b;font-weight:500;">(${safeId})</span></button>`;
      }).join('');

      patientResults.classList.remove('hidden');
    }

    function selectPatient(id, name) {
      if (patientIdInput) {
        patientIdInput.value = id;
      }
      if (patientSearchInput) {
        patientSearchInput.value = name;
      }
      if (patientResults) {
        patientResults.classList.add('hidden');
      }
    }

    patientSearchInput?.addEventListener('input', () => {
      if (patientIdInput) {
        patientIdInput.value = '';
      }
      renderPatientResults(patientSearchInput.value || '');
    });

    patientSearchInput?.addEventListener('focus', () => {
      renderPatientResults(patientSearchInput.value || '');
    });

    patientResults?.addEventListener('click', event => {
      const target = event.target;
      if (!(target instanceof Element)) {
        return;
      }

      const button = target.closest('.dc-patient-option');
      if (!(button instanceof HTMLButtonElement)) {
        return;
      }

      const id = button.dataset.patientId || '';
      const name = button.dataset.patientName || '';
      selectPatient(id, name);
    });

    patientForm?.addEventListener('submit', event => {
      if (!patientIdInput || !patientSearchInput) {
        return;
      }

      if (patientIdInput.value.trim() !== '') {
        return;
      }

      const term = (patientSearchInput.value || '').trim().toLowerCase();
      const exact = patientItems.find(item => String(item.name || '').toLowerCase() === term || String(item.id || '').toLowerCase() === term);
      if (exact) {
        patientIdInput.value = String(exact.id || '');
        patientSearchInput.value = String(exact.name || '');
        return;
      }

      event.preventDefault();
      window.alert('Please select a patient from the search list.');
    });

    document.addEventListener('click', event => {
      const target = event.target;
      if (!(target instanceof Element)) {
        return;
      }

      if (target.closest('#dcPatientSearch') || target.closest('#dcPatientResults')) {
        return;
      }

      patientResults?.classList.add('hidden');
    });

    const chartShell = document.querySelector('.dc-chart-shell');
    const chartKey = chartShell ? (chartShell.dataset.chartKey || 'dentcoms_dental_chart_state_default') : 'dentcoms_dental_chart_state_default';
    const statusPicker = document.getElementById('dcStatusPicker');
    const statusOptions = Array.from(document.querySelectorAll('[data-status-option]'));
    const surfaceButtons = Array.from(document.querySelectorAll('.dc-surface[data-tooth][data-surface]'));
    const resetButton = document.getElementById('dcResetAll');

    if (!statusPicker || statusOptions.length === 0 || surfaceButtons.length === 0) {
      return;
    }

    let activeSurface = null;
    const validStatuses = new Set(statusOptions.map(button => button.dataset.statusOption || ''));
    const surfaces = ['t', 'l', 'c', 'r', 'b'];

    function loadState() {
      try {
        const raw = localStorage.getItem(chartKey);
        if (!raw) return {};
        const parsed = JSON.parse(raw);
        return parsed && typeof parsed === 'object' ? parsed : {};
      } catch (error) {
        return {};
      }
    }

    function saveState(state) {
      try {
        localStorage.setItem(chartKey, JSON.stringify(state));
      } catch (error) {
        console.error('Unable to save dental chart state.', error);
      }
    }

    function createDefaultToothState() {
      return { t: 'healthy', l: 'healthy', c: 'healthy', r: 'healthy', b: 'healthy' };
    }

    function normalizeToothState(toothState) {
      const normalized = createDefaultToothState();
      if (!toothState || typeof toothState !== 'object') {
        return normalized;
      }

      surfaces.forEach(surface => {
        const raw = toothState[surface];
        normalized[surface] = validStatuses.has(raw) && raw !== 'reset' ? raw : 'healthy';
      });

      return normalized;
    }

    function applyStateToView(state) {
      surfaceButtons.forEach(button => {
        const toothNo = button.dataset.tooth || '';
        const surface = button.dataset.surface || '';
        const toothState = normalizeToothState(state[toothNo]);
        button.dataset.status = toothState[surface] || 'healthy';
      });
    }

    function closePicker() {
      statusPicker.classList.add('hidden');
      activeSurface = null;
    }

    function openPicker(targetButton) {
      activeSurface = targetButton;
      statusPicker.classList.remove('hidden');

      const rect = targetButton.getBoundingClientRect();
      const pickerRect = statusPicker.getBoundingClientRect();
      const gap = 10;
      let top = rect.bottom + gap;
      let left = rect.left - (pickerRect.width / 2) + (rect.width / 2);

      const maxLeft = window.innerWidth - pickerRect.width - 8;
      const maxTop = window.innerHeight - pickerRect.height - 8;
      left = Math.max(8, Math.min(left, maxLeft));

      if (top > maxTop) {
        top = rect.top - pickerRect.height - gap;
      }

      top = Math.max(8, Math.min(top, maxTop));

      statusPicker.style.top = `${top}px`;
      statusPicker.style.left = `${left}px`;
    }

    function applyStatusToSurface(targetButton, selectedStatus) {
      const toothNo = targetButton.dataset.tooth || '';
      const surface = targetButton.dataset.surface || '';
      if (toothNo === '' || !surfaces.includes(surface)) {
        return;
      }

      const resolvedStatus = selectedStatus === 'reset' ? 'healthy' : selectedStatus;
      const toothState = normalizeToothState(state[toothNo]);
      toothState[surface] = resolvedStatus;
      state[toothNo] = toothState;
      targetButton.dataset.status = resolvedStatus;
      saveState(state);
    }

    const state = loadState();
    applyStateToView(state);

    statusOptions.forEach(button => {
      button.addEventListener('click', () => {
        const status = button.dataset.statusOption;
        if (!validStatuses.has(status)) return;
        if (activeSurface) {
          applyStatusToSurface(activeSurface, status);
        }
        closePicker();
      });
    });

    surfaceButtons.forEach(button => {
      button.addEventListener('click', () => {
        openPicker(button);
      });
    });

    document.addEventListener('click', event => {
      const target = event.target;
      if (!(target instanceof Element)) {
        return;
      }

      if (statusPicker.classList.contains('hidden')) {
        return;
      }

      const clickedSurface = target.closest('.dc-surface');
      const clickedPicker = target.closest('#dcStatusPicker');
      if (!clickedSurface && !clickedPicker) {
        closePicker();
      }
    });

    window.addEventListener('resize', () => {
      if (activeSurface && !statusPicker.classList.contains('hidden')) {
        openPicker(activeSurface);
      }
    });

    resetButton?.addEventListener('click', () => {
      if (!window.confirm('Reset the full dental chart?')) {
        return;
      }

      surfaceButtons.forEach(button => {
        button.dataset.status = 'healthy';
      });

      Object.keys(state).forEach(key => {
        delete state[key];
      });

      saveState(state);
      closePicker();
    });
  })();
</script>
