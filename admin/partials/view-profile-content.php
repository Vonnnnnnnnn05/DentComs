<?php
$fullName = $patient
    ? trim(($patient['first_name'] ?? '') . ' ' . ($patient['middle_name'] ?? '') . ' ' . ($patient['last_name'] ?? ''))
    : '';
$mapUrl = ($patient && !empty($patient['home_address']))
    ? 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode($patient['home_address'])
    : '';
$coverPhoto = (!empty($patient['photo'])) ? '../' . ltrim($patient['photo'], '/') : '';
$createdAt = !empty($patient['created_at']) ? date('M d, Y h:i a', strtotime($patient['created_at'])) : 'Not available';
$tabs = [
    'medical_history' => ['label' => 'Medical History', 'href' => 'medical_history.php'],
    'progress_notes' => ['label' => 'Progress Notes', 'href' => 'progress_notes.php'],
    'photos' => ['label' => 'Photos', 'href' => 'photos.php'],
    'dental_chart' => ['label' => 'Dental Chart', 'href' => 'dental_chart_profile.php'],
    'forms' => ['label' => 'Forms', 'href' => 'forms_profile.php'],
    'lab_cases' => ['label' => 'Lab Cases', 'href' => 'lab_cases.php'],
    'appointments' => ['label' => 'Appointments', 'href' => 'appointments_profile.php'],
];
$tabContent = [
    'medical_history' => [
        'title' => 'Medical History',
        'subtitle' => 'Interactive medical history checklist for this patient.',
    ],
    'progress_notes' => [
        'title' => 'Progress Notes',
        'subtitle' => 'Timeline-style patient notes can be placed in this section.',
    ],
    'photos' => [
        'title' => 'Photos',
        'subtitle' => 'Patient photo references and image history can be managed here.',
    ],
    'dental_chart' => [
        'title' => 'Dental Chart',
        'subtitle' => 'Dental chart summary and related patient data can appear here.',
    ],
    'forms' => [
        'title' => 'Forms',
        'subtitle' => 'Patient forms and signed records can be organized in this section.',
    ],
    'lab_cases' => [
        'title' => 'Lab Cases',
        'subtitle' => 'Lab case details and statuses can be tracked here.',
    ],
    'appointments' => [
        'title' => 'Appointments',
        'subtitle' => 'Upcoming and previous appointments can be displayed here.',
    ],
];
$currentTabContent = $tabContent[$profileTab] ?? $tabContent['medical_history'];
$placeholderContent = [
    'progress_notes' => 'Progress notes content will appear here.',
    'photos' => 'Patient photos and image records will appear here.',
    'dental_chart' => 'Dental chart details will appear here.',
    'forms' => 'Patient forms and submitted documents will appear here.',
    'lab_cases' => 'Lab cases and case tracking will appear here.',
    'appointments' => 'Appointment history and schedules will appear here.',
];
$medicalConditions = [
    'High Blood Pressure',
    'Low Blood Pressure',
    'Epilepsy / Convulsions',
    'AIDS or HIV Infection',
    'Sexually Transmitted Disease',
    'Stomach Troubles / Ulcers',
    'Fainting Seizure',
    'Rapid Weight Loss',
    'Radiation Therapy',
    'Joint Replacement / Implant',
    'Heart Surgery',
    'Heart Attack',
    'Thyroid Problem',
    'Heart Disease',
    'Heart Murmur',
    'Hepatitis / Liver Disease',
    'Rheumatic Fever',
    'Hay Fever / Allergies',
    'Respiratory Problems',
    'Hepatitis / Jaundice',
    'Tuberculosis',
    'Swollen ankles',
    'Kidney disease',
    'Diabetes',
    'Chest pain',
    'Stroke',
    'Cancer / Tumors',
    'Anemia',
    'Angina',
    'Asthma',
    'Emphysema',
    'Bleeding Problems',
    'Blood Diseases',
    'Head Injuries',
    'Arthritis / Rheumatism',
    'Other',
];
$medicalHistoryConfig = [
    ['number' => 1, 'key' => 'good_health', 'label' => 'Are you in good health?', 'type' => 'yes_no'],
    ['number' => 2, 'key' => 'under_treatment', 'label' => 'Are you under medical treatment now?', 'type' => 'yes_no'],
    ['number' => '2a', 'key' => 'treatment_condition', 'label' => 'If so, what is the condition being treated?', 'type' => 'text', 'indent' => true],
    ['number' => 3, 'key' => 'serious_illness', 'label' => 'Have you ever had serious illness or surgical operation?', 'type' => 'yes_no'],
    ['number' => '3a', 'key' => 'serious_illness_details', 'label' => 'If so, what illness or operation?', 'type' => 'text', 'indent' => true],
    ['number' => 4, 'key' => 'hospitalized', 'label' => 'Have you ever been hospitalized?', 'type' => 'yes_no'],
    ['number' => '4a', 'key' => 'hospitalized_reason', 'label' => 'If so, when and why?', 'type' => 'text', 'indent' => true],
    ['number' => 5, 'key' => 'medication', 'label' => 'Are you taking any prescription/non-prescription medication?', 'type' => 'yes_no'],
    ['number' => '5a', 'key' => 'medication_details', 'label' => 'If so, please specify', 'type' => 'text', 'indent' => true],
    ['number' => 6, 'key' => 'tobacco', 'label' => 'Do you use tobacco products?', 'type' => 'yes_no'],
    ['number' => 7, 'key' => 'alcohol_drugs', 'label' => 'Do you use alcohol, cocaine or other dangerous drugs?', 'type' => 'yes_no'],
    ['number' => 8, 'key' => 'allergic', 'label' => 'Are you allergic to any of the following:', 'type' => 'allergies'],
    ['number' => 9, 'key' => 'bleeding_time', 'label' => 'Bleeding Time', 'type' => 'text'],
    ['number' => 10, 'key' => 'women_only', 'label' => 'For women only:', 'type' => 'women_only'],
    ['number' => 11, 'key' => 'blood_type', 'label' => 'Blood Type', 'type' => 'text'],
    ['number' => 12, 'key' => 'blood_pressure', 'label' => 'Blood Pressure', 'type' => 'text'],
    ['number' => 13, 'key' => 'conditions', 'label' => 'Do you have or have you had any of the following? Check which apply', 'type' => 'conditions'],
];
?>
<style>
  .profile-shell {
    background: linear-gradient(180deg, #eef5fc 0%, #f7fbff 100%);
  }

  .profile-card {
    background: rgba(255, 255, 255, 0.94);
    box-shadow: 0 22px 60px -34px rgba(55, 95, 146, 0.35);
  }

  .profile-tab {
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #475569;
    text-decoration: none;
    transition: color 220ms ease, background-color 220ms ease, transform 220ms ease, box-shadow 220ms ease;
  }

  .profile-tab:hover {
    color: #0b77ff;
    background: linear-gradient(180deg, rgba(241, 248, 255, 0.96), rgba(255, 255, 255, 0.98));
    transform: translateY(-1px);
    box-shadow: inset 0 0 0 1px rgba(11, 119, 255, 0.08);
  }

  .profile-tab.is-active {
    color: #0b77ff;
    background: linear-gradient(180deg, rgba(230, 242, 255, 0.9), rgba(255, 255, 255, 0.95));
    box-shadow: inset 0 -2px 0 #0b77ff;
  }

  .mh-answer-btn {
    min-width: 64px;
    border: 1px solid #d7e7fb;
    background: #fff;
    color: #5b6b82;
    transition: all 180ms ease;
  }

  .mh-answer-btn:hover {
    border-color: #93c5fd;
    background: #eff6ff;
    color: #0b77ff;
  }

  .mh-answer-btn.is-selected {
    border-color: #0b77ff;
    background: #0b77ff;
    color: #fff;
    box-shadow: 0 10px 20px -14px rgba(11, 119, 255, 0.8);
  }

  .mh-check {
    transition: all 180ms ease;
    min-height: 96px;
  }

  .mh-check:hover {
    border-color: #93c5fd;
    background: #eff6ff;
  }

  .mh-check.is-selected {
    border-color: #0b77ff;
    background: #e7f1ff;
    color: #0b77ff;
  }

  .mh-input {
    transition: border-color 180ms ease, box-shadow 180ms ease, background-color 180ms ease;
  }

  .mh-input:focus {
    border-color: #60a5fa;
    box-shadow: 0 0 0 4px rgba(147, 197, 253, 0.28);
    outline: none;
  }

  .photo-card {
    transition: transform 180ms ease, box-shadow 180ms ease, border-color 180ms ease;
  }

  .photo-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 18px 40px -28px rgba(15, 23, 42, 0.35);
    border-color: #bfdbfe;
  }
</style>

<section class="profile-shell min-h-screen px-4 pb-8 pt-4 sm:px-6 lg:px-8">
  <div class="mx-auto max-w-[1500px]">
    <div class="mb-5">
      <a href="patients.php" class="inline-flex items-center gap-2 rounded-2xl bg-[#cfe5fb] px-6 py-3 text-sm font-semibold text-[#0b77ff] transition duration-200 hover:bg-[#bfdcf9]">
        <i data-feather="chevron-left" class="h-4 w-4"></i>
        Back
      </a>
    </div>

    <?php if (!$patient): ?>
      <div class="profile-card rounded-[28px] border border-red-200 px-6 py-10 text-center">
        <p class="text-lg font-semibold text-slate-900">Patient record not found.</p>
        <p class="mt-2 text-sm text-slate-500">Check the patient list and try opening the profile again.</p>
      </div>
    <?php else: ?>
      <div class="grid gap-4 xl:grid-cols-[480px_minmax(0,1fr)]">
        <div class="space-y-4">
          <div class="profile-card overflow-hidden rounded-[24px] border border-white/60">
            <div class="h-[116px] bg-[#d2d6db]"></div>
            <div class="relative px-4 pb-4">
              <div class="-mt-12 flex justify-center">
                <div class="flex h-[118px] w-[118px] items-center justify-center overflow-hidden rounded-full border-[8px] border-white bg-[#eef2f7] shadow-md">
                  <?php if ($coverPhoto !== ''): ?>
                    <img src="<?= htmlspecialchars($coverPhoto, ENT_QUOTES, 'UTF-8') ?>" alt="Patient photo" class="h-full w-full object-cover">
                  <?php else: ?>
                    <i data-feather="user" class="h-12 w-12 text-slate-300"></i>
                  <?php endif; ?>
                </div>
              </div>

              <div class="mt-5 text-center">
                <h1 class="text-[22px] font-semibold uppercase tracking-tight text-[#0c2340]"><?= htmlspecialchars($fullName, ENT_QUOTES, 'UTF-8') ?></h1>
                <p class="mt-2 text-[13px] font-semibold text-[#0c2340]">ID: <?= htmlspecialchars($patient['id'] ?? '-', ENT_QUOTES, 'UTF-8') ?></p>
                <p class="mt-5 text-[13px] text-slate-400">Date Registered: <?= htmlspecialchars($patient['date_registered'] ?: '-', ENT_QUOTES, 'UTF-8') ?></p>
                <p class="mt-2 text-[13px] text-slate-400"><?= htmlspecialchars($patient['occupation'] ?: 'No occupation', ENT_QUOTES, 'UTF-8') ?></p>
              </div>

              <div class="mt-6 flex flex-wrap justify-center gap-3">
                
               
                <button type="button" onclick="window.print()" class="inline-flex items-center gap-2 rounded-xl bg-[#e8f2fd] px-5 py-3 text-sm font-medium text-[#0b77ff] transition duration-200 hover:bg-[#dcecff]">
                  <i data-feather="printer" class="h-4 w-4"></i>
                  Print
                </button>
              </div>
            </div>
          </div>

          <div class="profile-card rounded-[24px] border border-white/60 px-5 py-6">
            <div class="grid gap-x-8 gap-y-5 sm:grid-cols-2">
              <div>
                <p class="text-xs uppercase text-slate-400">Age</p>
                <p class="mt-1 text-[15px] font-semibold text-[#0c2340]"><?= htmlspecialchars(isset($patient['age']) && $patient['age'] !== '' ? $patient['age'] . ' yrs. old' : '-', ENT_QUOTES, 'UTF-8') ?></p>
              </div>
              <div>
                <p class="text-xs uppercase text-slate-400">Birthday</p>
                <p class="mt-1 text-[15px] font-semibold text-[#0c2340]"><?= htmlspecialchars($patient['birthday'] ?: '-', ENT_QUOTES, 'UTF-8') ?></p>
              </div>
              <div>
                <p class="text-xs uppercase text-slate-400">Gender</p>
                <p class="mt-1 text-[15px] font-semibold text-[#0c2340]"><?= htmlspecialchars($patient['sex'] ?: '-', ENT_QUOTES, 'UTF-8') ?></p>
              </div>
              <div>
                <p class="text-xs uppercase text-slate-400">Mobile Number</p>
                <p class="mt-1 text-[15px] font-semibold text-[#0c2340]"><?= htmlspecialchars($patient['mobile_no'] ?: '-', ENT_QUOTES, 'UTF-8') ?></p>
              </div>
              <div>
                <p class="text-xs uppercase text-slate-400">Email Address</p>
                <p class="mt-1 break-words text-[15px] font-semibold leading-6 text-[#0c2340]"><?= htmlspecialchars($patient['email'] ?: '-', ENT_QUOTES, 'UTF-8') ?></p>
              </div>
              <div>
                <p class="text-xs uppercase text-slate-400">Nationality</p>
                <p class="mt-1 text-[15px] font-semibold text-[#0c2340]"><?= htmlspecialchars($patient['nationality'] ?: '-', ENT_QUOTES, 'UTF-8') ?></p>
              </div>
              <div>
                <p class="text-xs uppercase text-slate-400">Address</p>
                <p class="mt-1 text-[15px] font-semibold leading-6 text-[#0c2340]"><?= htmlspecialchars($patient['home_address'] ?: '-', ENT_QUOTES, 'UTF-8') ?></p>
              </div>
              <div>
                <p class="text-xs uppercase text-slate-400">Occupation</p>
                <p class="mt-1 text-[15px] font-semibold text-[#0c2340]"><?= htmlspecialchars($patient['occupation'] ?: '-', ENT_QUOTES, 'UTF-8') ?></p>
              </div>
              <div>
                <p class="text-xs uppercase text-slate-400">Home Phone</p>
                <p class="mt-1 text-[15px] font-semibold text-[#0c2340]"><?= htmlspecialchars($patient['home_phone'] ?: '-', ENT_QUOTES, 'UTF-8') ?></p>
              </div>
              <div>
                <p class="text-xs uppercase text-slate-400">Nickname</p>
                <p class="mt-1 text-[15px] font-semibold text-[#0c2340]"><?= htmlspecialchars($patient['nickname'] ?: '-', ENT_QUOTES, 'UTF-8') ?></p>
              </div>
            </div>
          </div>
        </div>

        <div class="profile-card overflow-hidden rounded-[24px] border border-white/60">
          <div class="flex flex-wrap border-b border-slate-200/80 bg-white">
            <?php foreach ($tabs as $tabKey => $tab): ?>
              <a
                href="<?= htmlspecialchars($tab['href'], ENT_QUOTES, 'UTF-8') ?>?id=<?= urlencode($patient['id']) ?>"
                class="profile-tab <?= $profileTab === $tabKey ? 'is-active' : '' ?> border-r border-slate-200/80 px-6 py-6 text-[17px] font-medium"
              >
                <?= htmlspecialchars($tab['label'], ENT_QUOTES, 'UTF-8') ?>
              </a>
            <?php endforeach; ?>
          </div>

          <div class="px-4 py-5 sm:px-6 md:px-8">
            <?php if ($profileSuccessMessage !== ''): ?>
              <div class="mb-4 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                <?= htmlspecialchars($profileSuccessMessage, ENT_QUOTES, 'UTF-8') ?>
              </div>
            <?php endif; ?>

            <?php if ($profileErrorMessage !== ''): ?>
              <div class="mb-4 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700">
                <?= htmlspecialchars($profileErrorMessage, ENT_QUOTES, 'UTF-8') ?>
              </div>
            <?php endif; ?>

            <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
              <div>
                <p class="text-lg font-semibold text-[#0c2340]"><?= htmlspecialchars($currentTabContent['title'], ENT_QUOTES, 'UTF-8') ?></p>
                <p class="mt-1 text-sm text-slate-400"><?= htmlspecialchars($currentTabContent['subtitle'], ENT_QUOTES, 'UTF-8') ?></p>
              </div>
              <div class="flex flex-col items-end gap-2">
                <button
                  type="button"
                  id="medicalHistorySaveBtn"
                  class="<?= $profileTab === 'medical_history' ? 'inline-flex' : 'hidden' ?> items-center rounded-xl bg-[#cfe5fb] px-10 py-3 text-sm font-medium text-[#0b77ff] transition duration-200 hover:bg-[#bddbfb]"
                >
                  Update
                </button>
                <?php if ($profileTab === 'photos'): ?>
                  <button
                    type="button"
                    id="photoAddTrigger"
                    class="inline-flex items-center rounded-xl bg-[#cfe5fb] px-10 py-3 text-sm font-medium text-[#0b77ff] transition duration-200 hover:bg-[#bddbfb]"
                  >
                    Add
                  </button>
                <?php elseif ($profileTab !== 'medical_history'): ?>
                  <?php if ($mapUrl !== ''): ?>
                    <a href="<?= htmlspecialchars($mapUrl, ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center rounded-xl bg-[#cfe5fb] px-10 py-3 text-sm font-medium text-[#0b77ff] transition duration-200 hover:bg-[#bddbfb]">
                      Update
                    </a>
                  <?php else: ?>
                    <span class="inline-flex items-center rounded-xl bg-[#e8f2fd] px-10 py-3 text-sm font-medium text-[#7ca8d8]">
                      Update
                    </span>
                  <?php endif; ?>
                <?php endif; ?>
                <p class="text-sm text-slate-400">Last Update: <?= htmlspecialchars($createdAt, ENT_QUOTES, 'UTF-8') ?></p>
              </div>
            </div>

            <?php if ($profileTab === 'medical_history'): ?>
              <div id="medicalHistoryForm" data-patient-id="<?= htmlspecialchars($patient['id'], ENT_QUOTES, 'UTF-8') ?>" class="space-y-5">
                <?php foreach ($medicalHistoryConfig as $item): ?>
                  <?php if ($item['type'] === 'yes_no'): ?>
                    <div class="grid grid-cols-[40px_minmax(0,1fr)_150px] items-center gap-4 max-md:grid-cols-[40px_minmax(0,1fr)]">
                      <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#d7ebff] text-[15px] font-semibold text-[#0c2340]"><?= htmlspecialchars((string) $item['number'], ENT_QUOTES, 'UTF-8') ?></div>
                      <div class="text-[15px] leading-7 text-[#324a68]"><?= htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8') ?></div>
                      <div class="flex justify-end gap-2 max-md:col-start-2 max-md:justify-start">
                        <button type="button" class="mh-answer-btn rounded-xl px-4 py-2 text-sm font-medium" data-field="<?= htmlspecialchars($item['key'], ENT_QUOTES, 'UTF-8') ?>" data-value="yes">Yes</button>
                        <button type="button" class="mh-answer-btn rounded-xl px-4 py-2 text-sm font-medium" data-field="<?= htmlspecialchars($item['key'], ENT_QUOTES, 'UTF-8') ?>" data-value="no">No</button>
                      </div>
                    </div>
                  <?php elseif ($item['type'] === 'text'): ?>
                    <div class="grid grid-cols-[40px_minmax(0,1fr)] items-center gap-4 <?= !empty($item['indent']) ? 'pl-9' : '' ?>">
                      <div class="text-center text-[13px] font-semibold text-slate-300"><?= htmlspecialchars((string) $item['number'], ENT_QUOTES, 'UTF-8') ?></div>
                      <div class="grid gap-2">
                        <label class="text-[15px] leading-7 text-[#324a68]"><?= htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8') ?></label>
                        <input type="text" class="mh-input rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700" data-field="<?= htmlspecialchars($item['key'], ENT_QUOTES, 'UTF-8') ?>">
                      </div>
                    </div>
                  <?php elseif ($item['type'] === 'allergies'): ?>
                    <div class="grid grid-cols-[40px_minmax(0,1fr)] gap-4">
                      <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#d7ebff] text-[15px] font-semibold text-[#0c2340]"><?= htmlspecialchars((string) $item['number'], ENT_QUOTES, 'UTF-8') ?></div>
                      <div class="space-y-4">
                        <div class="grid gap-3 md:grid-cols-[minmax(0,1fr)_150px] md:items-center">
                          <div class="text-[15px] leading-7 text-[#324a68]"><?= htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8') ?></div>
                          <div class="flex justify-start gap-2 md:justify-end">
                            <button type="button" class="mh-answer-btn rounded-xl px-4 py-2 text-sm font-medium" data-field="allergic" data-value="yes">Yes</button>
                            <button type="button" class="mh-answer-btn rounded-xl px-4 py-2 text-sm font-medium" data-field="allergic" data-value="no">No</button>
                          </div>
                        </div>
                        <div class="grid gap-3 lg:grid-cols-2 2xl:grid-cols-3">
                          <?php foreach (['Local Anesthetic (ex. Lidocaine)', 'Penicillin, Antibiotics', 'Sulfa drugs', 'Aspirin', 'Latex', 'Others'] as $allergy): ?>
                            <button type="button" class="mh-check grid grid-cols-[18px_minmax(0,1fr)] items-center gap-3 rounded-xl border border-slate-200 px-4 py-3 text-left text-sm leading-6 text-slate-600" data-check-group="allergies" data-check-value="<?= htmlspecialchars($allergy, ENT_QUOTES, 'UTF-8') ?>">
                              <span class="inline-flex h-5 w-5 items-center justify-center rounded-full border border-current text-[11px]">+</span>
                              <span><?= htmlspecialchars($allergy, ENT_QUOTES, 'UTF-8') ?></span>
                            </button>
                          <?php endforeach; ?>
                        </div>
                      </div>
                    </div>
                  <?php elseif ($item['type'] === 'women_only'): ?>
                    <div class="grid grid-cols-[40px_minmax(0,1fr)] gap-4">
                      <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#d7ebff] text-[15px] font-semibold text-[#0c2340]"><?= htmlspecialchars((string) $item['number'], ENT_QUOTES, 'UTF-8') ?></div>
                      <div class="space-y-4">
                        <div class="text-[15px] leading-7 text-[#324a68]"><?= htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8') ?></div>
                        <?php foreach ([
                            'pregnant' => 'Are you pregnant?',
                            'nursing' => 'Are you nursing?',
                            'birth_control' => 'Are you taking birth control pills?',
                        ] as $key => $label): ?>
                          <div class="grid gap-3 md:grid-cols-[minmax(0,1fr)_150px] md:items-center">
                            <div class="pl-4 text-[15px] leading-7 text-[#324a68]"><?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?></div>
                            <div class="flex justify-start gap-2 md:justify-end">
                              <button type="button" class="mh-answer-btn rounded-xl px-4 py-2 text-sm font-medium" data-field="<?= htmlspecialchars($key, ENT_QUOTES, 'UTF-8') ?>" data-value="yes">Yes</button>
                              <button type="button" class="mh-answer-btn rounded-xl px-4 py-2 text-sm font-medium" data-field="<?= htmlspecialchars($key, ENT_QUOTES, 'UTF-8') ?>" data-value="no">No</button>
                            </div>
                          </div>
                        <?php endforeach; ?>
                      </div>
                    </div>
                  <?php elseif ($item['type'] === 'conditions'): ?>
                    <div class="grid grid-cols-[40px_minmax(0,1fr)] gap-4">
                      <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#d7ebff] text-[15px] font-semibold text-[#0c2340]"><?= htmlspecialchars((string) $item['number'], ENT_QUOTES, 'UTF-8') ?></div>
                      <div class="space-y-4">
                        <div class="text-[15px] leading-7 text-[#324a68]"><?= htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8') ?></div>
                        <div class="grid gap-3 lg:grid-cols-2 2xl:grid-cols-3">
                          <?php foreach ($medicalConditions as $condition): ?>
                            <button type="button" class="mh-check grid grid-cols-[18px_minmax(0,1fr)] items-center gap-3 rounded-xl border border-slate-200 px-4 py-3 text-left text-sm leading-6 text-slate-600" data-check-group="conditions" data-check-value="<?= htmlspecialchars($condition, ENT_QUOTES, 'UTF-8') ?>">
                              <span class="inline-flex h-5 w-5 items-center justify-center rounded-full border border-current text-[11px]">+</span>
                              <span><?= htmlspecialchars($condition, ENT_QUOTES, 'UTF-8') ?></span>
                            </button>
                          <?php endforeach; ?>
                        </div>
                      </div>
                    </div>
                  <?php endif; ?>
                <?php endforeach; ?>
              </div>
            <?php elseif ($profileTab === 'photos'): ?>
              <form id="photoUploadForm" method="POST" action="photos.php?id=<?= urlencode($patient['id']) ?>" enctype="multipart/form-data" class="mb-6 rounded-[22px] border border-dashed border-slate-200 bg-slate-50/80 p-5">
                <input type="hidden" name="action" value="upload_gallery_files">
                <input id="galleryFilesInput" type="file" name="gallery_files[]" multiple accept=".jpg,.jpeg,.png,.gif,.webp,.pdf,image/*,application/pdf" class="hidden">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                  <div>
                    <p class="text-sm font-semibold text-slate-800">Upload patient files</p>
                    <p class="mt-1 text-sm text-slate-500">Add photos or PDF files for this patient. Selected files will upload when you click the add button or choose files.</p>
                  </div>
                  <button type="button" id="photoSecondaryAddTrigger" class="inline-flex items-center justify-center rounded-xl bg-white px-5 py-3 text-sm font-medium text-[#0b77ff] ring-1 ring-slate-200 transition duration-200 hover:bg-slate-50">
                    Choose Files
                  </button>
                </div>
              </form>

              <?php if (empty($uploadedFiles)): ?>
                <div class="flex min-h-[260px] items-center justify-center rounded-[20px] border border-dashed border-slate-200 bg-slate-50/80 px-6 text-center">
                  <p class="max-w-md text-[15px] leading-7 text-slate-500">No files uploaded yet. Use the Add button to upload files for this patient.</p>
                </div>
              <?php else: ?>
                <div class="space-y-4">
                  <?php foreach ($uploadedFiles as $file): ?>
                    <a
                      href="../<?= htmlspecialchars(ltrim($file['path'], '/'), ENT_QUOTES, 'UTF-8') ?>"
                      target="_blank"
                      rel="noopener noreferrer"
                      class="photo-card grid overflow-hidden rounded-[22px] border border-slate-200 bg-white md:grid-cols-[220px_minmax(0,1fr)]"
                    >
                      <div class="flex h-48 items-center justify-center bg-slate-50 md:h-full">
                        <?php if ($file['is_image']): ?>
                          <img src="../<?= htmlspecialchars(ltrim($file['path'], '/'), ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($file['name'], ENT_QUOTES, 'UTF-8') ?>" class="h-full w-full object-cover">
                        <?php else: ?>
                          <div class="text-center">
                            <i data-feather="file-text" class="mx-auto h-10 w-10 text-slate-400"></i>
                            <p class="mt-3 text-sm font-medium text-slate-500">PDF File</p>
                          </div>
                        <?php endif; ?>
                      </div>
                      <div class="flex min-w-0 flex-col justify-center space-y-3 px-5 py-5">
                        <p class="break-words text-base font-semibold text-slate-900"><?= htmlspecialchars($file['name'], ENT_QUOTES, 'UTF-8') ?></p>
                        <div class="flex flex-wrap items-center gap-x-5 gap-y-2 text-sm text-slate-500">
                          <span>Type: <?= htmlspecialchars(strtoupper($file['extension']), ENT_QUOTES, 'UTF-8') ?></span>
                          <span>Size: <?= htmlspecialchars((string) $file['size_kb'], ENT_QUOTES, 'UTF-8') ?> KB</span>
                          <span>Uploaded: <?= htmlspecialchars($file['uploaded_at'], ENT_QUOTES, 'UTF-8') ?></span>
                        </div>
                        <span class="inline-flex w-fit items-center rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                          Open file
                        </span>
                      </div>
                    </a>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
            <?php else: ?>
              <div class="flex min-h-[420px] items-center justify-center rounded-[20px] border border-dashed border-slate-200 bg-slate-50/80 px-6 text-center">
                <p class="max-w-md text-[15px] leading-7 text-slate-500">
                  <?= htmlspecialchars($placeholderContent[$profileTab] ?? 'Content will appear here.', ENT_QUOTES, 'UTF-8') ?>
                </p>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>

<?php if ($profileTab === 'medical_history' && $patient): ?>
  <script>
    (function () {
      const form = document.getElementById('medicalHistoryForm');
      const saveBtn = document.getElementById('medicalHistorySaveBtn');
      if (!form || !saveBtn) return;

      const patientId = form.dataset.patientId || 'default';
      const storageKey = `dentcoms-medical-history-${patientId}`;
      const state = {
        answers: {},
        checks: {
          allergies: [],
          conditions: []
        }
      };

      function readState() {
        try {
          const raw = window.localStorage.getItem(storageKey);
          if (!raw) return;
          const parsed = JSON.parse(raw);
          if (parsed && typeof parsed === 'object') {
            state.answers = parsed.answers || {};
            state.checks = parsed.checks || { allergies: [], conditions: [] };
          }
        } catch (error) {
          console.error('Unable to read medical history state.', error);
        }
      }

      function writeState() {
        window.localStorage.setItem(storageKey, JSON.stringify(state));
      }

      function syncAnswerButtons() {
        form.querySelectorAll('[data-field][data-value]').forEach(button => {
          const field = button.dataset.field;
          const value = button.dataset.value;
          button.classList.toggle('is-selected', state.answers[field] === value);
        });
      }

      function syncTextInputs() {
        form.querySelectorAll('input[data-field]').forEach(input => {
          const field = input.dataset.field;
          input.value = state.answers[field] || '';
        });
      }

      function syncChecks() {
        form.querySelectorAll('[data-check-group]').forEach(button => {
          const group = button.dataset.checkGroup;
          const value = button.dataset.checkValue;
          const values = state.checks[group] || [];
          button.classList.toggle('is-selected', values.includes(value));
        });
      }

      function render() {
        syncAnswerButtons();
        syncTextInputs();
        syncChecks();
      }

      form.querySelectorAll('[data-field][data-value]').forEach(button => {
        button.addEventListener('click', () => {
          const field = button.dataset.field;
          const value = button.dataset.value;
          state.answers[field] = value;
          writeState();
          render();
        });
      });

      form.querySelectorAll('input[data-field]').forEach(input => {
        input.addEventListener('input', () => {
          state.answers[input.dataset.field] = input.value;
          writeState();
        });
      });

      form.querySelectorAll('[data-check-group]').forEach(button => {
        button.addEventListener('click', () => {
          const group = button.dataset.checkGroup;
          const value = button.dataset.checkValue;
          const values = new Set(state.checks[group] || []);
          if (values.has(value)) {
            values.delete(value);
          } else {
            values.add(value);
          }
          state.checks[group] = Array.from(values);
          writeState();
          render();
        });
      });

      saveBtn.addEventListener('click', () => {
        writeState();
        saveBtn.textContent = 'Saved';
        window.setTimeout(() => {
          saveBtn.textContent = 'Update';
        }, 1200);
      });

      readState();
      render();
    })();
  </script>
<?php endif; ?>
<?php if ($profileTab === 'photos' && $patient): ?>
  <script>
    (function () {
      const fileInput = document.getElementById('galleryFilesInput');
      const form = document.getElementById('photoUploadForm');
      const primaryTrigger = document.getElementById('photoAddTrigger');
      const secondaryTrigger = document.getElementById('photoSecondaryAddTrigger');

      if (!fileInput || !form) return;

      function openPicker() {
        fileInput.click();
      }

      primaryTrigger?.addEventListener('click', openPicker);
      secondaryTrigger?.addEventListener('click', openPicker);

      fileInput.addEventListener('change', () => {
        if (fileInput.files && fileInput.files.length > 0) {
          form.submit();
        }
      });
    })();
  </script>
<?php endif; ?>
