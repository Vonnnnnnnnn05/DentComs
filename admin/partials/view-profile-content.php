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
    'Images' => ['label' => 'Images', 'href' => 'photos.php'],
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
        'title' => 'Images',
        'subtitle' => 'Patient Image references and image history can be managed here.',
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
$formTemplates = [
    'Informed Consent' => "<div style='max-width:820px; margin:0 auto; color:#111827;'><h2 style='text-align:center; font-weight:700; letter-spacing:0.08em; margin-bottom:28px;'>INFORMED CONSENT</h2><p style='text-align:justify; margin-bottom:18px;'><strong>TREATMENT TO BE DONE.</strong> I understand and consent to have any treatment done by the dentist after the procedure, the risks &amp; benefits &amp; cost have been fully explained. These treatments include, but are not limited to, x-rays, cleanings, periodontal treatments, fillings, crowns, bridges, all types of extraction, root canals, &amp;/or dentures, local anesthetics &amp; surgical cases.</p><p style='text-align:justify; margin-bottom:18px;'><strong>DRUGS &amp; MEDICATIONS.</strong> I understand that antibiotics, analgesics &amp; other medications can cause allergic reactions like redness &amp; swelling of tissues, pain, itching, vomiting, &amp;/or anaphylactic shock.</p><p style='text-align:justify; margin-bottom:18px;'><strong>CHANGES IN TREATMENT PLAN.</strong> I understand that during treatment it may be necessary to change/add procedures because of conditions found while working on the teeth that was not discovered during examination. For example, root canal therapy may be needed following routine restorative procedures. I give my permission to the dentist to make any/all changes and additions as necessary with my responsibility to pay all the costs agreed.</p><p style='text-align:justify; margin-bottom:18px;'><strong>RADIOGRAPH.</strong> I understand that an x-ray shot or a radiograph maybe necessary as part of diagnostic aid to come up with tentative diagnosis of my dental problem and to make a good treatment plan, but, this will not give me a 100% assurance for the accuracy of the treatment since all dental treatments are subject to unpredictable complications that later on may lead to sudden change of treatment plan and subject to new charges.</p><p style='text-align:justify; margin-bottom:18px;'><strong>REMOVAL OF TEETH.</strong> I understand that alternatives to tooth removal (root canal therapy, crowns &amp; periodontal surgery, etc.) &amp; I completely understand these alternatives, including their risk &amp; benefits prior to authorizing the dentist to remove teeth &amp; any other structures necessary for reasons above. I understand that removing teeth does not always remove all the infections, if present, &amp; it may be necessary to have further treatment. I understand the risk involved in having teeth removed, such as pain, swelling, spread of infection, dry socket, fractured jaw, loss of feeling on the teeth, lips, tongue &amp; surrounding tissue that can last for an indefinite period of time. I understand that I may need further treatment under a specialist if complications arise during or following treatment.</p><p style='text-align:justify; margin-bottom:18px;'><strong>VENEERS, CROWNS &amp; BRIDGES.</strong> Preparing a tooth may irritate the nerve tissue in the center of the tooth, leaving the tooth extra sensitive to heat, cold &amp; pressure. Treating such irritation may involve using special toothpastes, mouth rinses or root canal therapy. I understand that sometimes it is not possible to match the color of natural teeth exactly with artificial teeth. I further understand that I may be wearing temporary crowns, which may come off easily &amp; that I must be careful to ensure that they are kept on until the permanent crowns are delivered. It is my responsibility to return for permanent cementation within 20 days from tooth preparation, as excessive delay may allow for tooth movement, which may necessitate a remake of the crown, bridge/cap. I understand there will be additional charges for remakes due to my delaying of permanent cementation, &amp; I realize that final opportunity to make changes in my new crown, bridges or cap (including shape, fit, size, &amp; color) will be before permanent cementation.</p><p style='text-align:justify; margin-bottom:18px;'><strong>ENDODONTICS (ROOT CANAL).</strong> I understand there is no guarantee that a root canal treatment will save a tooth &amp; that complication can occur from the treatment &amp; that occasionally root canal filling materials may extend through the tooth which does not necessarily effect the success of the treatment. I understand that endodontic files &amp; drills are very fine instruments &amp; stresses vented in their manufacture &amp; calcifications present in teeth can cause them to break during use. I understand that referral to the endodontist for additional treatments may be necessary following any root canal treatment &amp; I agree that I am responsible for any additional cost for treatment performed by the endodontist. I understand that a tooth may require removal in spite of all efforts to save it.</p><p style='text-align:justify; margin-bottom:18px;'><strong>PERIODONTAL DISEASE.</strong> I understand that periodontal disease is a serious condition causing gum &amp; bone inflammation &amp;/or loss &amp; that can lead eventually to the loss of my teeth. I understand the alternative treatment plans to correct periodontal disease, including gum surgery tooth extractions with or without replacement. I understand that undertaking any dental procedures may have future adverse effect on my periodontal conditions.</p><p style='text-align:justify; margin-bottom:18px;'><strong>FILLINGS.</strong> I understand that care must be exercised in chewing on fillings, especially during the first 24 hours to avoid breakage. I understand that a more extensive filling or a crown may be required as additional decay or fracture may become evident after initial excavation. I understand that significant sensitivity is common, but usually temporary, after-effect of a newly placed filling. I further understand that filling a tooth may irritate the nerve tissue creating sensitivity &amp; treating such sensitivity could require root canal therapy or extractions.</p><p style='text-align:justify; margin-bottom:18px;'><strong>DENTURES.</strong> I understand that wearing of dentures can be difficult. Sore spots, altered speech &amp; difficulty in eating are common problems. Immediate dentures (placement of denture immediately after extractions) may be painful. Immediate dentures may require considerable adjusting &amp; several relines. I understand that it is my responsibility to return for delivery of dentures. I understand that failure to keep my delivery appointment may result in poorly fitted dentures. If a remake is required due to my delays of more than 30 days, there will be additional charges. A permanent reline will be needed later, which is not included in the initial fee. I understand that all adjustment or alterations of any kind after this initial period is subject to charges.</p><p style='text-align:justify; margin-bottom:18px;'>I understand that dentistry is not an exact science and that no dentist can properly guarantee accurate results all the time.</p><p style='text-align:justify; margin-bottom:28px;'>I hereby authorize any of the doctors/dental auxiliaries to proceed with &amp; perform the dental restorations &amp; treatments as explained to me. I understand that these are subject to modification depending on un-diagnosable circumstances that may arise during the course of treatment. I understand that regardless of any dental insurance coverage I may have, I am responsible for payment of dental fees, I agree to pay attorney’s fees, collection fee, or court costs that may be incurred to satisfy any obligation to this office. All treatment was properly explained to me &amp; any untoward circumstances that may arise during the procedure, the attending dentist will not be held liable since it is my free will, with full trust &amp; confidence in him/her, to undergo dental treatment under his/her care.</p><div style='display:flex; justify-content:space-between; gap:32px; margin-top:48px;'><div style='flex:1; border-top:1px solid #111827; padding-top:8px; text-align:center;'>Patient Signature</div><div style='flex:1; border-top:1px solid #111827; padding-top:8px; text-align:center;'>Date</div></div></div>",
    'Dental Certificate' => "<h2 style='text-align:center; font-weight:700;'>DENTAL CERTIFICATE</h2><p>To whom it may concern:</p><p>This is to certify that <strong>" . htmlspecialchars($fullName !== '' ? $fullName : 'Patient Name', ENT_QUOTES, 'UTF-8') . "</strong> was examined and treated on <strong>" . htmlspecialchars(date('F j, Y'), ENT_QUOTES, 'UTF-8') . "</strong>.</p><p><strong>Procedure:</strong></p><p><br></p><p><strong>Remarks:</strong></p><p><br></p>",
    'Medical Certificate' => "<h2 style='text-align:center; font-weight:700;'>MEDICAL CERTIFICATE</h2><p>This certifies that <strong>" . htmlspecialchars($fullName !== '' ? $fullName : 'Patient Name', ENT_QUOTES, 'UTF-8') . "</strong> visited the clinic on <strong>" . htmlspecialchars(date('F j, Y'), ENT_QUOTES, 'UTF-8') . "</strong>.</p><p><strong>Assessment:</strong></p><p><br></p><p><strong>Recommendation:</strong></p><p><br></p>",
    'PDA Dental Chart' => "<h2 style='text-align:center; font-weight:700;'>PDA DENTAL CHART</h2><p><strong>Patient:</strong> ____________________</p><p><strong>Date:</strong> ____________________</p><p><strong>Chief Complaint:</strong></p><p><br></p><p><strong>Clinical Findings:</strong></p><p><br></p><p><strong>Treatment Plan:</strong></p><p><br></p>",
    'Consent Form' => "<h2 style='text-align:center; font-weight:700;'>CONSENT FORM</h2><p>I, <strong>" . htmlspecialchars($fullName !== '' ? $fullName : 'Patient Name', ENT_QUOTES, 'UTF-8') . "</strong>, confirm that the procedure, risks, benefits, and alternatives were explained to me.</p><p><strong>Procedure Details:</strong></p><p><br></p><p><strong>Consent Notes:</strong></p><p><br></p>",
];

  // Keep Consent Form default aligned with the full consent questionnaire format.
  if (isset($formTemplates['Informed Consent'])) {
    $formTemplates['Consent Form'] = str_replace('INFORMED CONSENT', 'CONSENT FORM', $formTemplates['Informed Consent']);
  }
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

  .no-scrollbar::-webkit-scrollbar {
    display: none;
  }
  .no-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
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

  .form-editor-content {
    min-height: 300px;
    outline: none;
  }

  .editor-tool {
    transition: background-color 180ms ease, color 180ms ease, border-color 180ms ease;
  }

  .editor-tool:hover {
    background: #eff6ff;
    border-color: #bfdbfe;
    color: #0b77ff;
  }

  .form-action-icon {
    transition: background-color 180ms ease, color 180ms ease, border-color 180ms ease, transform 180ms ease;
  }

  .form-action-icon:hover {
    transform: translateY(-1px);
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
          <div class="flex overflow-x-auto border-b border-slate-200/80 bg-white no-scrollbar scroll-smooth">
            <?php foreach ($tabs as $tabKey => $tab): ?>
              <a
                href="<?= htmlspecialchars($tab['href'], ENT_QUOTES, 'UTF-8') ?>?id=<?= urlencode($patient['id']) ?>"
                class="profile-tab shrink-0 <?= $profileTab === $tabKey ? 'is-active' : '' ?> border-r border-slate-200/80 px-4 py-3.5 sm:px-6 sm:py-5 text-sm sm:text-[16px] font-medium whitespace-nowrap"
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

            <div class="mb-6 sm:mb-8 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
              <div>
                <p class="text-base sm:text-lg font-semibold text-[#0c2340]"><?= htmlspecialchars($currentTabContent['title'], ENT_QUOTES, 'UTF-8') ?></p>
                <p class="mt-1 text-xs sm:text-sm text-slate-400"><?= htmlspecialchars($currentTabContent['subtitle'], ENT_QUOTES, 'UTF-8') ?></p>
              </div>
              <div class="flex flex-col sm:items-end gap-2 w-full sm:w-auto">
                <button
                  type="button"
                  id="medicalHistorySaveBtn"
                  class="<?= $profileTab === 'medical_history' ? 'inline-flex' : 'hidden' ?> items-center justify-center rounded-xl bg-[#cfe5fb] px-6 sm:px-10 py-2.5 sm:py-3 text-sm font-medium text-[#0b77ff] transition duration-200 hover:bg-[#bddbfb] w-full sm:w-auto"
                >
                  Update
                </button>
                <?php if ($profileTab === 'photos'): ?>
                  <button
                    type="button"
                    id="photoAddTrigger"
                    class="inline-flex items-center justify-center rounded-xl bg-[#cfe5fb] px-6 sm:px-10 py-2.5 sm:py-3 text-sm font-medium text-[#0b77ff] transition duration-200 hover:bg-[#bddbfb] w-full sm:w-auto"
                  >
                    Add
                  </button>
                <?php elseif ($profileTab === 'forms'): ?>
                  <button
                    type="button"
                    id="formAddTrigger"
                    class="inline-flex items-center justify-center rounded-xl bg-[#cfe5fb] px-6 sm:px-10 py-2.5 sm:py-3 text-sm font-medium text-[#0b77ff] transition duration-200 hover:bg-[#bddbfb] w-full sm:w-auto"
                  >
                    Add
                  </button>
                <?php elseif ($profileTab === 'appointments'): ?>
                  <button
                    type="button"
                    id="appointmentAddTrigger"
                    class="inline-flex items-center justify-center rounded-xl bg-[#cfe5fb] px-6 sm:px-10 py-2.5 sm:py-3 text-sm font-medium text-[#0b77ff] transition duration-200 hover:bg-[#bddbfb] w-full sm:w-auto"
                  >
                    Add
                  </button>
                <?php elseif ($profileTab !== 'medical_history'): ?>
                  <?php if ($mapUrl !== ''): ?>
                    <a href="<?= htmlspecialchars($mapUrl, ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center rounded-xl bg-[#cfe5fb] px-6 sm:px-10 py-2.5 sm:py-3 text-sm font-medium text-[#0b77ff] transition duration-200 hover:bg-[#bddbfb] w-full sm:w-auto">
                      Update
                    </a>
                  <?php else: ?>
                    <span class="inline-flex items-center justify-center rounded-xl bg-[#e8f2fd] px-6 sm:px-10 py-2.5 sm:py-3 text-sm font-medium text-[#7ca8d8] w-full sm:w-auto">
                      Update
                    </span>
                  <?php endif; ?>
                <?php endif; ?>
                <p class="text-xs sm:text-sm text-slate-400">Last Update: <?= htmlspecialchars($createdAt, ENT_QUOTES, 'UTF-8') ?></p>
              </div>
            </div>

            <?php if ($profileTab === 'medical_history'): ?>
              <div id="medicalHistorySummary" class="space-y-5 rounded-[22px] border border-slate-200 bg-slate-50/80 px-5 py-5">
                <div class="grid gap-4 md:grid-cols-2">
                  <div class="rounded-2xl border border-slate-200 bg-white px-4 py-3">
                    <p class="text-xs font-semibold uppercase tracking-[0.14em] text-slate-400">Good health</p>
                    <p class="mt-2 text-sm font-semibold text-slate-700" data-detail-field="good_health">Not set</p>
                  </div>
                  <div class="rounded-2xl border border-slate-200 bg-white px-4 py-3">
                    <p class="text-xs font-semibold uppercase tracking-[0.14em] text-slate-400">Under treatment</p>
                    <p class="mt-2 text-sm font-semibold text-slate-700" data-detail-field="under_treatment">Not set</p>
                  </div>
                  <div class="rounded-2xl border border-slate-200 bg-white px-4 py-3">
                    <p class="text-xs font-semibold uppercase tracking-[0.14em] text-slate-400">Treatment condition</p>
                    <p class="mt-2 text-sm text-slate-700" data-detail-field="treatment_condition">Not set</p>
                  </div>
                  <div class="rounded-2xl border border-slate-200 bg-white px-4 py-3">
                    <p class="text-xs font-semibold uppercase tracking-[0.14em] text-slate-400">Serious illness or surgery</p>
                    <p class="mt-2 text-sm font-semibold text-slate-700" data-detail-field="serious_illness">Not set</p>
                  </div>
                  <div class="rounded-2xl border border-slate-200 bg-white px-4 py-3">
                    <p class="text-xs font-semibold uppercase tracking-[0.14em] text-slate-400">Illness / operation details</p>
                    <p class="mt-2 text-sm text-slate-700" data-detail-field="serious_illness_details">Not set</p>
                  </div>
                  <div class="rounded-2xl border border-slate-200 bg-white px-4 py-3">
                    <p class="text-xs font-semibold uppercase tracking-[0.14em] text-slate-400">Hospitalized</p>
                    <p class="mt-2 text-sm font-semibold text-slate-700" data-detail-field="hospitalized">Not set</p>
                  </div>
                  <div class="rounded-2xl border border-slate-200 bg-white px-4 py-3">
                    <p class="text-xs font-semibold uppercase tracking-[0.14em] text-slate-400">Hospitalized reason</p>
                    <p class="mt-2 text-sm text-slate-700" data-detail-field="hospitalized_reason">Not set</p>
                  </div>
                  <div class="rounded-2xl border border-slate-200 bg-white px-4 py-3">
                    <p class="text-xs font-semibold uppercase tracking-[0.14em] text-slate-400">Medication</p>
                    <p class="mt-2 text-sm font-semibold text-slate-700" data-detail-field="medication">Not set</p>
                  </div>
                  <div class="rounded-2xl border border-slate-200 bg-white px-4 py-3">
                    <p class="text-xs font-semibold uppercase tracking-[0.14em] text-slate-400">Medication details</p>
                    <p class="mt-2 text-sm text-slate-700" data-detail-field="medication_details">Not set</p>
                  </div>
                  <div class="rounded-2xl border border-slate-200 bg-white px-4 py-3">
                    <p class="text-xs font-semibold uppercase tracking-[0.14em] text-slate-400">Tobacco use</p>
                    <p class="mt-2 text-sm font-semibold text-slate-700" data-detail-field="tobacco">Not set</p>
                  </div>
                  <div class="rounded-2xl border border-slate-200 bg-white px-4 py-3">
                    <p class="text-xs font-semibold uppercase tracking-[0.14em] text-slate-400">Alcohol or dangerous drugs</p>
                    <p class="mt-2 text-sm font-semibold text-slate-700" data-detail-field="alcohol_drugs">Not set</p>
                  </div>
                  <div class="rounded-2xl border border-slate-200 bg-white px-4 py-3">
                    <p class="text-xs font-semibold uppercase tracking-[0.14em] text-slate-400">Allergic</p>
                    <p class="mt-2 text-sm font-semibold text-slate-700" data-detail-field="allergic">Not set</p>
                  </div>
                  <div class="rounded-2xl border border-slate-200 bg-white px-4 py-3">
                    <p class="text-xs font-semibold uppercase tracking-[0.14em] text-slate-400">Pregnant</p>
                    <p class="mt-2 text-sm font-semibold text-slate-700" data-detail-field="pregnant">Not set</p>
                  </div>
                  <div class="rounded-2xl border border-slate-200 bg-white px-4 py-3">
                    <p class="text-xs font-semibold uppercase tracking-[0.14em] text-slate-400">Nursing</p>
                    <p class="mt-2 text-sm font-semibold text-slate-700" data-detail-field="nursing">Not set</p>
                  </div>
                  <div class="rounded-2xl border border-slate-200 bg-white px-4 py-3">
                    <p class="text-xs font-semibold uppercase tracking-[0.14em] text-slate-400">Birth control pills</p>
                    <p class="mt-2 text-sm font-semibold text-slate-700" data-detail-field="birth_control">Not set</p>
                  </div>
                  <div class="rounded-2xl border border-slate-200 bg-white px-4 py-3">
                    <p class="text-xs font-semibold uppercase tracking-[0.14em] text-slate-400">Bleeding time</p>
                    <p class="mt-2 text-sm text-slate-700" data-detail-field="bleeding_time">Not set</p>
                  </div>
                  <div class="rounded-2xl border border-slate-200 bg-white px-4 py-3">
                    <p class="text-xs font-semibold uppercase tracking-[0.14em] text-slate-400">Blood type</p>
                    <p class="mt-2 text-sm text-slate-700" data-detail-field="blood_type">Not set</p>
                  </div>
                  <div class="rounded-2xl border border-slate-200 bg-white px-4 py-3">
                    <p class="text-xs font-semibold uppercase tracking-[0.14em] text-slate-400">Blood pressure</p>
                    <p class="mt-2 text-sm text-slate-700" data-detail-field="blood_pressure">Not set</p>
                  </div>
                </div>

                <div class="space-y-3 rounded-2xl border border-slate-200 bg-white px-4 py-4">
                  <p class="text-xs font-semibold uppercase tracking-[0.14em] text-slate-400">Selected allergies</p>
                  <div id="medicalHistoryAllergiesSummary" class="flex flex-wrap gap-2">
                    <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-500">None selected</span>
                  </div>
                </div>

                <div class="space-y-3 rounded-2xl border border-slate-200 bg-white px-4 py-4">
                  <p class="text-xs font-semibold uppercase tracking-[0.14em] text-slate-400">Selected conditions</p>
                  <div id="medicalHistoryConditionsSummary" class="flex flex-wrap gap-2">
                    <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-500">None selected</span>
                  </div>
                </div>
              </div>

              <div id="medicalHistoryEditorModal" class="fixed inset-0 z-[90] hidden items-end justify-center bg-slate-950/55 px-4 pb-4 pt-10">
                <div class="absolute inset-0" data-close-medical-history-modal></div>
                <div class="relative z-10 max-h-[88vh] w-full max-w-5xl overflow-hidden rounded-[26px] bg-white shadow-2xl">
                  <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
                    <div>
                      <p class="text-sm font-semibold uppercase tracking-[0.18em] text-blue-600">Medical History</p>
                      <h3 class="mt-2 text-2xl font-semibold tracking-tight text-slate-900">Update Questionnaire</h3>
                    </div>
                    <button type="button" class="inline-flex h-11 w-11 items-center justify-center rounded-full text-slate-500 transition hover:bg-slate-100 hover:text-slate-700" data-close-medical-history-modal>
                      <i data-feather="x" class="h-5 w-5"></i>
                    </button>
                  </div>

                  <div class="max-h-[calc(88vh-88px)] overflow-y-auto px-5 py-5">
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

                    <div class="mt-6 flex justify-end gap-3 border-t border-slate-100 pt-5">
                      <button type="button" class="rounded-2xl border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50" data-close-medical-history-modal>
                        Cancel
                      </button>
                      <button type="button" id="medicalHistoryModalSaveBtn" class="rounded-2xl bg-blue-700 px-6 py-3 text-sm font-semibold text-white transition hover:bg-blue-800">
                        Save Changes
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            <?php elseif ($profileTab === 'photos'): ?>
              <form id="photoUploadForm" method="POST" action="photos.php?id=<?= urlencode($patient['id']) ?>" enctype="multipart/form-data" class="mb-6 rounded-[22px] border border-dashed border-slate-200 bg-slate-50/80 p-5">
                <input type="hidden" name="action" value="upload_gallery_files">
                <input id="galleryFilesInput" type="file" name="gallery_files[]" multiple accept=".jpg,.jpeg,.png,.gif,.webp,.pdf,image/*,application/pdf" class="hidden">
                <div class="mb-4">
                  <label for="photoLabelInput" class="mb-2 block text-sm font-semibold text-slate-700">File label <span class="text-red-500">*</span></label>
                  <input id="photoLabelInput" type="text" name="file_label" required maxlength="255" placeholder="Example: Initial Consultation" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 outline-none ring-0 transition focus:border-blue-300 focus:shadow-[0_0_0_3px_rgba(59,130,246,0.15)]">
                  <p class="mt-1 text-xs text-slate-500">Add a label before selecting files. The label is saved with this upload.</p>
                </div>
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
                        <?php if (!empty($file['label'])): ?>
                          <p class="text-sm font-medium text-blue-700">Label: <?= htmlspecialchars($file['label'], ENT_QUOTES, 'UTF-8') ?></p>
                        <?php endif; ?>
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
            <?php elseif ($profileTab === 'forms'): ?>
              <div class="space-y-4">
                <?php if (empty($patientForms)): ?>
                  <div class="flex min-h-[260px] items-center justify-center rounded-[20px] border border-dashed border-slate-200 bg-slate-50/80 px-6 text-center">
                    <p class="max-w-md text-[15px] leading-7 text-slate-500">No forms saved yet. Use the Add button to create a patient-specific form.</p>
                  </div>
                <?php else: ?>
                  <?php foreach ($patientForms as $form): ?>
                    <?php
                    $formPayload = htmlspecialchars(json_encode($form, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT), ENT_QUOTES, 'UTF-8');
                    ?>
                    <div class="rounded-[22px] border border-slate-200 bg-white px-5 py-5 shadow-sm">
                      <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                        <div class="min-w-0">
                          <p class="text-lg font-semibold text-slate-900"><?= htmlspecialchars($form['title'] ?: $form['form_type'], ENT_QUOTES, 'UTF-8') ?></p>
                          <div class="mt-2 flex flex-wrap gap-x-5 gap-y-2 text-sm text-slate-500">
                            <span>Type: <?= htmlspecialchars($form['form_type'], ENT_QUOTES, 'UTF-8') ?></span>
                            <span>Date: <?= htmlspecialchars($form['form_date'], ENT_QUOTES, 'UTF-8') ?></span>
                            <span>Updated: <?= htmlspecialchars(date('M d, Y h:i a', strtotime((string) $form['updated_at'])), ENT_QUOTES, 'UTF-8') ?></span>
                          </div>
                        </div>
                        <div class="flex items-center gap-1.5 shrink-0 md:ml-4">
                          <button type="button" class="open-form-view form-action-icon inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-600 hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700" data-form="<?= $formPayload ?>" title="View form" aria-label="View form">
                            <i data-feather="eye" class="h-4 w-4"></i>
                          </button>
                          <button type="button" class="open-form-editor form-action-icon inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-600 hover:border-amber-200 hover:bg-amber-50 hover:text-amber-700" data-form="<?= $formPayload ?>" title="Edit form" aria-label="Edit form">
                            <i data-feather="edit-3" class="h-4 w-4"></i>
                          </button>
                          <button type="button" class="print-form-btn form-action-icon inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-600 hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-700" data-content="<?= htmlspecialchars($form['content'], ENT_QUOTES, 'UTF-8') ?>" data-title="<?= htmlspecialchars($form['title'] ?: $form['form_type'], ENT_QUOTES, 'UTF-8') ?>" title="Print form" aria-label="Print form">
                            <i data-feather="printer" class="h-4 w-4"></i>
                          </button>
                          <form method="POST" action="forms_profile.php?id=<?= urlencode($patient['id']) ?>" onsubmit="return confirm('Delete this form?');">
                            <input type="hidden" name="action" value="delete_patient_form">
                            <input type="hidden" name="form_id" value="<?= (int) $form['id'] ?>">
                            <button type="submit" class="form-action-icon inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-600 hover:border-red-200 hover:bg-red-50 hover:text-red-700" title="Delete form" aria-label="Delete form">
                              <i data-feather="trash-2" class="h-4 w-4"></i>
                            </button>
                          </form>
                        </div>
                      </div>
                      <div class="mt-4 rounded-2xl bg-slate-50 px-4 py-4 text-sm leading-7 text-slate-600">
                        <?= $form['content'] ?>
                      </div>
                    </div>
                  <?php endforeach; ?>
                <?php endif; ?>
              </div>

              <div id="formEditorModal" class="fixed inset-0 z-[90] hidden items-center justify-center bg-slate-950/55 px-4">
                <div class="absolute inset-0" data-close-form-editor></div>
                <div class="relative z-10 max-h-[88vh] w-full max-w-4xl overflow-hidden rounded-[26px] bg-white shadow-2xl">
                  <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
                    <div>
                      <p id="formEditorEyebrow" class="text-sm font-semibold uppercase tracking-[0.18em] text-blue-600">Add Form</p>
                      <h3 class="mt-2 text-2xl font-semibold tracking-tight text-slate-900">Patient Form Editor</h3>
                    </div>
                    <button type="button" class="inline-flex h-11 w-11 items-center justify-center rounded-full text-slate-500 transition hover:bg-slate-100 hover:text-slate-700" data-close-form-editor>
                      <i data-feather="x" class="h-5 w-5"></i>
                    </button>
                  </div>

                  <form id="patientFormEditorForm" method="POST" action="forms_profile.php?id=<?= urlencode($patient['id']) ?>" class="max-h-[calc(88vh-88px)] overflow-y-auto px-5 py-5">
                    <input type="hidden" name="action" value="save_patient_form">
                    <input type="hidden" name="form_id" id="patientFormId" value="">
                    <input type="hidden" name="title" id="patientFormTitleInput" value="">
                    <input type="hidden" name="content" id="patientFormContentInput" value="">

                    <div class="space-y-5">
                      <div>
                        <label class="mb-2 block text-sm font-medium text-slate-500">Patient</label>
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-4 text-lg font-semibold text-[#355c8a]">(ID:<?= htmlspecialchars($patient['id'], ENT_QUOTES, 'UTF-8') ?>) <?= htmlspecialchars($fullName, ENT_QUOTES, 'UTF-8') ?></div>
                      </div>

                      <div class="grid gap-4 md:grid-cols-3">
                        <div>
                          <label for="patientFormDate" class="mb-2 block text-sm font-medium text-slate-500">Date</label>
                          <input id="patientFormDate" name="form_date" type="date" value="<?= htmlspecialchars(date('Y-m-d'), ENT_QUOTES, 'UTF-8') ?>" class="w-full rounded-2xl border border-slate-200 px-4 py-4 text-lg font-semibold text-slate-700">
                        </div>
                        <div>
                          <label for="patientFormType" class="mb-2 block text-sm font-medium text-slate-500">Form Type</label>
                          <select id="patientFormType" name="form_type" class="w-full rounded-2xl border border-slate-200 px-4 py-4 text-lg text-slate-700">
                            <?php foreach (array_keys($formTemplates) as $templateType): ?>
                              <option value="<?= htmlspecialchars($templateType, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($templateType, ENT_QUOTES, 'UTF-8') ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                        <div>
                          <label for="patientFormTitleField" class="mb-2 block text-sm font-medium text-slate-500">Title</label>
                          <input id="patientFormTitleField" type="text" value="Consent Form" class="w-full rounded-2xl border border-slate-200 px-4 py-4 text-lg text-slate-700">
                        </div>
                      </div>

                      <div class="rounded-[22px] border border-slate-200 overflow-hidden">
                        <div class="flex flex-wrap items-center gap-2 border-b border-slate-200 bg-slate-50 px-4 py-3">
                          <select id="editorFontSize" class="editor-tool rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700">
                            <option value="3">Normal</option>
                            <option value="1">Small</option>
                            <option value="5">Large</option>
                            <option value="7">Huge</option>
                          </select>
                          <button type="button" class="editor-tool rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-bold" data-command="bold">B</button>
                          <button type="button" class="editor-tool rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm italic" data-command="italic">I</button>
                          <button type="button" class="editor-tool rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm underline" data-command="underline">U</button>
                          <button type="button" class="editor-tool rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm" data-command="insertUnorderedList">List</button>
                          <button type="button" class="editor-tool rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm" data-command="justifyLeft">Left</button>
                          <button type="button" class="editor-tool rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm" data-command="justifyCenter">Center</button>
                          <button type="button" class="editor-tool rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm" data-command="justifyRight">Right</button>
                        </div>
                        <div id="patientFormEditor" class="form-editor-content bg-white px-5 py-5 text-[17px] leading-8 text-slate-800" contenteditable="true"></div>
                      </div>

                      <div class="flex justify-end gap-3 border-t border-slate-100 pt-5">
                        <button type="button" class="rounded-2xl border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50" data-close-form-editor>
                          Cancel
                        </button>
                        <button type="submit" class="rounded-2xl bg-blue-700 px-6 py-3 text-sm font-semibold text-white transition hover:bg-blue-800">
                          Save Form
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>

              <div id="formViewModal" class="fixed inset-0 z-[90] hidden items-center justify-center bg-slate-950/55 px-4">
                <div class="absolute inset-0" data-close-form-view></div>
                <div class="relative z-10 max-h-[88vh] w-full max-w-4xl overflow-hidden rounded-[26px] bg-white shadow-2xl">
                  <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
                    <div>
                      <p id="formViewType" class="text-sm font-semibold uppercase tracking-[0.18em] text-blue-600">Form</p>
                      <h3 id="formViewTitle" class="mt-2 text-2xl font-semibold tracking-tight text-slate-900">Form Details</h3>
                    </div>
                    <button type="button" class="inline-flex h-11 w-11 items-center justify-center rounded-full text-slate-500 transition hover:bg-slate-100 hover:text-slate-700" data-close-form-view>
                      <i data-feather="x" class="h-5 w-5"></i>
                    </button>
                  </div>
                  <div class="max-h-[calc(88vh-88px)] overflow-y-auto px-5 py-5">
                    <div class="mb-4 flex flex-wrap gap-x-5 gap-y-2 text-sm text-slate-500">
                      <span id="formViewDate">Date: -</span>
                      <span id="formViewUpdated">Updated: -</span>
                    </div>
                    <div id="formViewContent" class="rounded-[22px] border border-slate-200 bg-slate-50 px-5 py-5 text-[16px] leading-8 text-slate-800"></div>
                  </div>
                </div>
              </div>
            <?php elseif ($profileTab === 'appointments'): ?>
              <div class="mb-6 rounded-[22px] border border-slate-200 bg-white p-4 shadow-sm">
                <div id="appointmentsCalendar" data-patient-id="<?= htmlspecialchars($patient['id'], ENT_QUOTES, 'UTF-8') ?>"></div>
              </div>

              <div class="space-y-4">
                <?php if (empty($patientAppointments)): ?>
                  <div class="flex min-h-[260px] items-center justify-center rounded-[20px] border border-dashed border-slate-200 bg-slate-50/80 px-6 text-center">
                    <p class="max-w-md text-[15px] leading-7 text-slate-500">No appointments yet. Use the Add button to create an appointment for this patient.</p>
                  </div>
                <?php else: ?>
                  <?php foreach ($patientAppointments as $appointment): ?>
                    <div class="rounded-[22px] border border-slate-200 bg-white px-5 py-5 shadow-sm">
                      <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                        <div class="min-w-0">
                          <p class="text-lg font-semibold text-slate-900"><?= htmlspecialchars($appointment['purpose_of_visit'] ?: 'Appointment', ENT_QUOTES, 'UTF-8') ?></p>
                          <div class="mt-2 flex flex-wrap gap-x-5 gap-y-2 text-sm text-slate-500">
                            <span>ID: <?= htmlspecialchars($appointment['appointment_id'], ENT_QUOTES, 'UTF-8') ?></span>
                            <span>Dentist: <?= htmlspecialchars($appointment['dentist'] ?: '-', ENT_QUOTES, 'UTF-8') ?></span>
                            <span>Date/Time: <?= htmlspecialchars(date('M d, Y h:i a', strtotime((string) $appointment['appointment_datetime'])), ENT_QUOTES, 'UTF-8') ?></span>
                            <span>Status: <?= htmlspecialchars($appointment['status'] ?: '-', ENT_QUOTES, 'UTF-8') ?></span>
                            <span>Priority: <?= htmlspecialchars($appointment['priority'] ?: 'Normal', ENT_QUOTES, 'UTF-8') ?></span>
                            <span>VIP: <?= ((int) ($appointment['is_vip'] ?? 0)) === 1 ? 'Yes' : 'No' ?></span>
                          </div>
                          <?php if (!empty($appointment['appointment_notes'])): ?>
                            <p class="mt-3 text-sm leading-6 text-slate-600"><?= nl2br(htmlspecialchars($appointment['appointment_notes'], ENT_QUOTES, 'UTF-8')) ?></p>
                          <?php endif; ?>
                          <?php if (!empty($appointment['cancel_reason'])): ?>
                            <p class="mt-2 text-sm leading-6 text-red-600">Cancel reason: <?= htmlspecialchars($appointment['cancel_reason'], ENT_QUOTES, 'UTF-8') ?></p>
                          <?php endif; ?>
                        </div>
                        <form method="POST" action="appointments_profile.php?id=<?= urlencode($patient['id']) ?>" onsubmit="return confirm('Delete this appointment?');" class="shrink-0">
                          <input type="hidden" name="action" value="delete_patient_appointment">
                          <input type="hidden" name="appointment_pk" value="<?= (int) $appointment['id'] ?>">
                          <button type="submit" class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-600 hover:border-red-200 hover:bg-red-50 hover:text-red-700" title="Delete appointment" aria-label="Delete appointment">
                            <i data-feather="trash-2" class="h-4 w-4"></i>
                          </button>
                        </form>
                      </div>
                    </div>
                  <?php endforeach; ?>
                <?php endif; ?>
              </div>

              <div id="appointmentEditorModal" class="fixed inset-0 z-[90] hidden items-center justify-center bg-slate-950/55 px-4">
                <div class="absolute inset-0" data-close-appointment-editor></div>
                <div class="relative z-10 max-h-[88vh] w-full max-w-4xl overflow-hidden rounded-[26px] bg-white shadow-2xl">
                  <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
                    <div>
                      <p class="text-sm font-semibold uppercase tracking-[0.18em] text-blue-600">Appointments</p>
                      <h3 class="mt-2 text-2xl font-semibold tracking-tight text-slate-900">Add Appointment</h3>
                    </div>
                    <button type="button" class="inline-flex h-11 w-11 items-center justify-center rounded-full text-slate-500 transition hover:bg-slate-100 hover:text-slate-700" data-close-appointment-editor>
                      <i data-feather="x" class="h-5 w-5"></i>
                    </button>
                  </div>

                  <form id="appointmentEditorForm" method="POST" action="appointments_profile.php?id=<?= urlencode($patient['id']) ?>" class="max-h-[calc(88vh-88px)] overflow-y-auto px-5 py-5">
                    <input type="hidden" name="action" value="save_patient_appointment">
                    <input type="hidden" name="patient_name" value="<?= htmlspecialchars($fullName, ENT_QUOTES, 'UTF-8') ?>">
                    <div class="space-y-5">
                      <div class="grid gap-4 md:grid-cols-2">
                        <div>
                          <label for="appointmentDateOfEntry" class="mb-2 block text-sm font-medium text-slate-500">Date of Entry</label>
                          <input id="appointmentDateOfEntry" name="date_of_entry" type="date" value="<?= htmlspecialchars(date('Y-m-d'), ENT_QUOTES, 'UTF-8') ?>" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm text-slate-700">
                        </div>
                        <div>
                          <label for="appointmentPhone" class="mb-2 block text-sm font-medium text-slate-500">Phone</label>
                          <input id="appointmentPhone" name="phone" type="text" value="<?= htmlspecialchars($patient['mobile_no'] ?? '', ENT_QUOTES, 'UTF-8') ?>" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm text-slate-700">
                        </div>
                      </div>

                      <div class="grid gap-4 md:grid-cols-3">
                        <div>
                          <label for="appointmentPriority" class="mb-2 block text-sm font-medium text-slate-500">Priority</label>
                          <select id="appointmentPriority" name="priority" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm text-slate-700">
                            <option value="Low">Low</option>
                            <option value="Normal" selected>Normal</option>
                            <option value="High">High</option>
                            <option value="Urgent">Urgent</option>
                          </select>
                        </div>
                        <div>
                          <label for="appointmentStatus" class="mb-2 block text-sm font-medium text-slate-500">Status</label>
                          <select id="appointmentStatus" name="status" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm text-slate-700">
                            <option value="Pending" selected>Pending</option>
                            <option value="Confirmed">Confirmed</option>
                            <option value="Complete">Complete</option>
                            <option value="Cancelled">Cancelled</option>
                            <option value="No Show">No Show</option>
                            <option value="Rescheduled">Rescheduled</option>
                          </select>
                        </div>
                        <label class="mt-7 inline-flex items-center gap-2 text-sm font-medium text-slate-700">
                          <input type="checkbox" name="is_vip" value="1" class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                          VIP Patient
                        </label>
                      </div>

                      <div class="grid gap-4 md:grid-cols-2">
                        <div>
                          <label for="appointmentPurpose" class="mb-2 block text-sm font-medium text-slate-500">Purpose of Visit</label>
                          <input id="appointmentPurpose" name="purpose_of_visit" type="text" required class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm text-slate-700">
                        </div>
                        <div>
                          <label for="appointmentDentist" class="mb-2 block text-sm font-medium text-slate-500">Dentist</label>
                          <input id="appointmentDentist" name="dentist" type="text" required class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm text-slate-700">
                        </div>
                      </div>

                      <div>
                        <label for="appointmentDateTime" class="mb-2 block text-sm font-medium text-slate-500">Date and Time</label>
                        <input id="appointmentDateTime" name="appointment_datetime" type="datetime-local" required class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm text-slate-700">
                      </div>

                      <div>
                        <label for="appointmentNotes" class="mb-2 block text-sm font-medium text-slate-500">Appointment Notes</label>
                        <textarea id="appointmentNotes" name="appointment_notes" rows="3" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm text-slate-700"></textarea>
                      </div>

                      <div>
                        <label for="appointmentCancelReason" class="mb-2 block text-sm font-medium text-slate-500">Reason for Cancel</label>
                        <textarea id="appointmentCancelReason" name="cancel_reason" rows="2" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm text-slate-700"></textarea>
                      </div>

                      <div class="flex justify-end gap-3 border-t border-slate-100 pt-5">
                        <button type="button" class="rounded-2xl border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50" data-close-appointment-editor>
                          Cancel
                        </button>
                        <button type="submit" class="rounded-2xl bg-blue-700 px-6 py-3 text-sm font-semibold text-white transition hover:bg-blue-800">
                          Save Appointment
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
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
      const detailsSummary = document.getElementById('medicalHistorySummary');
      const allergiesSummary = document.getElementById('medicalHistoryAllergiesSummary');
      const conditionsSummary = document.getElementById('medicalHistoryConditionsSummary');
      const openModalBtn = document.getElementById('medicalHistorySaveBtn');
      const modal = document.getElementById('medicalHistoryEditorModal');
      const modalSaveBtn = document.getElementById('medicalHistoryModalSaveBtn');
      const closeModalButtons = document.querySelectorAll('[data-close-medical-history-modal]');
      if (!form || !openModalBtn || !modal || !modalSaveBtn) return;

      const patientId = form.dataset.patientId || 'default';
      const initialState = <?= json_encode($patientMedicalHistory, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>;
      const state = {
        answers: {},
        checks: {
          allergies: [],
          conditions: []
        }
      };

      function hydrateState() {
        if (!initialState || typeof initialState !== 'object') return;
        state.answers = initialState.answers && typeof initialState.answers === 'object' ? initialState.answers : {};
        state.checks = initialState.checks && typeof initialState.checks === 'object'
          ? {
              allergies: Array.isArray(initialState.checks.allergies) ? initialState.checks.allergies : [],
              conditions: Array.isArray(initialState.checks.conditions) ? initialState.checks.conditions : []
            }
          : { allergies: [], conditions: [] };
      }

      function openModal() {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
      }

      function closeModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
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

      function formatDetailValue(value) {
        if (value === 'yes') return 'Yes';
        if (value === 'no') return 'No';
        if (value === null || value === undefined || value === '') return 'Not set';
        return value;
      }

      function renderSelectionSummary(target, values) {
        if (!target) return;

        if (!Array.isArray(values) || values.length === 0) {
          target.innerHTML = '<span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-500">None selected</span>';
          return;
        }

        target.innerHTML = values
          .map(value => `<span class="inline-flex items-center rounded-full bg-blue-50 px-3 py-1 text-xs font-medium text-blue-700">${value}</span>`)
          .join('');
      }

      function syncDetailsSummary() {
        if (!detailsSummary) return;

        detailsSummary.querySelectorAll('[data-detail-field]').forEach(element => {
          const field = element.dataset.detailField;
          element.textContent = formatDetailValue(state.answers[field]);
        });

        renderSelectionSummary(allergiesSummary, state.checks.allergies || []);
        renderSelectionSummary(conditionsSummary, state.checks.conditions || []);
      }

      function render() {
        syncAnswerButtons();
        syncTextInputs();
        syncChecks();
        syncDetailsSummary();
      }

      form.querySelectorAll('[data-field][data-value]').forEach(button => {
        button.addEventListener('click', () => {
          const field = button.dataset.field;
          const value = button.dataset.value;
          state.answers[field] = value;
          render();
        });
      });

      form.querySelectorAll('input[data-field]').forEach(input => {
        input.addEventListener('input', () => {
          state.answers[input.dataset.field] = input.value;
          render();
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
          render();
        });
      });

      openModalBtn.addEventListener('click', () => {
        render();
        openModal();
      });

      closeModalButtons.forEach(button => {
        button.addEventListener('click', closeModal);
      });

      async function saveToDatabase() {
        const payload = JSON.stringify(state);
        const response = await fetch(window.location.href, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
            'X-Requested-With': 'XMLHttpRequest'
          },
          body: new URLSearchParams({
            action: 'save_patient_medical_history',
            medical_history_payload: payload,
            patient_id: patientId
          }).toString()
        });

        let result = null;
        try {
          result = await response.json();
        } catch (error) {
          throw new Error('Unable to parse save response.');
        }

        if (!response.ok || !result || result.ok !== true) {
          throw new Error((result && result.message) ? result.message : 'Unable to save medical history.');
        }
      }

      modalSaveBtn.addEventListener('click', async () => {
        const originalText = modalSaveBtn.textContent;
        modalSaveBtn.textContent = 'Saving...';
        modalSaveBtn.disabled = true;

        try {
          await saveToDatabase();
          closeModal();
          openModalBtn.textContent = 'Saved';
          window.setTimeout(() => {
            openModalBtn.textContent = 'Update';
          }, 1200);
        } catch (error) {
          window.alert(error.message || 'Unable to save medical history.');
        } finally {
          modalSaveBtn.textContent = originalText;
          modalSaveBtn.disabled = false;
        }
      });

      document.addEventListener('keydown', event => {
        if (event.key === 'Escape' && modal.classList.contains('flex')) {
          closeModal();
        }
      });

      hydrateState();
      render();
    })();
  </script>
<?php endif; ?>
<?php if ($profileTab === 'photos' && $patient): ?>
  <script>
    (function () {
      const fileInput = document.getElementById('galleryFilesInput');
      const form = document.getElementById('photoUploadForm');
      const labelInput = document.getElementById('photoLabelInput');
      const primaryTrigger = document.getElementById('photoAddTrigger');
      const secondaryTrigger = document.getElementById('photoSecondaryAddTrigger');

      if (!fileInput || !form) return;

      function hasLabel() {
        return !!(labelInput && labelInput.value.trim() !== '');
      }

      function openPicker() {
        if (!hasLabel()) {
          window.alert('Please enter a file label before uploading.');
          labelInput?.focus();
          return;
        }
        fileInput.click();
      }

      primaryTrigger?.addEventListener('click', openPicker);
      secondaryTrigger?.addEventListener('click', openPicker);

      fileInput.addEventListener('change', () => {
        if (fileInput.files && fileInput.files.length > 0 && hasLabel()) {
          form.submit();
        }
      });

      form.addEventListener('submit', event => {
        if (!hasLabel()) {
          event.preventDefault();
          window.alert('Please enter a file label before uploading.');
          labelInput?.focus();
        }
      });
    })();
  </script>
<?php endif; ?>
<?php if ($profileTab === 'forms' && $patient): ?>
  <script>
    (function () {
      const modal = document.getElementById('formEditorModal');
      const viewModal = document.getElementById('formViewModal');
      const addTrigger = document.getElementById('formAddTrigger');
      const closeButtons = document.querySelectorAll('[data-close-form-editor]');
      const closeViewButtons = document.querySelectorAll('[data-close-form-view]');
      const form = document.getElementById('patientFormEditorForm');
      const editor = document.getElementById('patientFormEditor');
      const titleField = document.getElementById('patientFormTitleField');
      const titleInput = document.getElementById('patientFormTitleInput');
      const contentInput = document.getElementById('patientFormContentInput');
      const formIdInput = document.getElementById('patientFormId');
      const formTypeSelect = document.getElementById('patientFormType');
      const formDateInput = document.getElementById('patientFormDate');
      const eyebrow = document.getElementById('formEditorEyebrow');
      const templates = <?= json_encode($formTemplates) ?>;
      const viewType = document.getElementById('formViewType');
      const viewTitle = document.getElementById('formViewTitle');
      const viewDate = document.getElementById('formViewDate');
      const viewUpdated = document.getElementById('formViewUpdated');
      const viewContent = document.getElementById('formViewContent');

      if (!modal || !form || !editor) return;

      function openModal() {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
      }

      function closeModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
      }

      function openViewModal(payload) {
        if (!viewModal) return;
        viewType.textContent = payload.form_type || 'Form';
        viewTitle.textContent = payload.title || payload.form_type || 'Form Details';
        viewDate.textContent = `Date: ${payload.form_date || '-'}`;
        viewUpdated.textContent = `Updated: ${payload.updated_at || '-'}`;
        viewContent.innerHTML = payload.content || '';
        viewModal.classList.remove('hidden');
        viewModal.classList.add('flex');
      }

      function closeViewModal() {
        if (!viewModal) return;
        viewModal.classList.add('hidden');
        viewModal.classList.remove('flex');
      }

      function applyTemplate(forceReplace) {
        const selectedType = formTypeSelect.value;
        if (!forceReplace && editor.innerHTML.trim() !== '') return;
        editor.innerHTML = templates[selectedType] || '';
        if (!titleField.value.trim()) {
          titleField.value = selectedType;
        }
      }

      function openForCreate() {
        form.reset();
        formIdInput.value = '';
        eyebrow.textContent = 'Add Form';
        if (templates['Consent Form']) {
          formTypeSelect.value = 'Consent Form';
        }
        titleField.value = formTypeSelect.value;
        formDateInput.value = new Date().toISOString().slice(0, 10);
        editor.innerHTML = '';
        applyTemplate(true);
        openModal();
      }

      function openForEdit(payload) {
        formIdInput.value = payload.id || '';
        formTypeSelect.value = payload.form_type || 'Consent Form';
        formDateInput.value = payload.form_date || new Date().toISOString().slice(0, 10);
        titleField.value = payload.title || payload.form_type || '';
        editor.innerHTML = payload.content || '';
        eyebrow.textContent = 'Edit Form';
        openModal();
      }

      addTrigger?.addEventListener('click', openForCreate);
      closeButtons.forEach(button => button.addEventListener('click', closeModal));
      modal.querySelector('.absolute.inset-0')?.addEventListener('click', closeModal);
      closeViewButtons.forEach(button => button.addEventListener('click', closeViewModal));
      viewModal?.querySelector('.absolute.inset-0')?.addEventListener('click', closeViewModal);

      document.querySelectorAll('[data-command]').forEach(button => {
        button.addEventListener('click', () => {
          document.execCommand(button.dataset.command, false);
          editor.focus();
        });
      });

      document.getElementById('editorFontSize')?.addEventListener('change', (event) => {
        document.execCommand('fontSize', false, event.target.value);
        editor.focus();
      });

      formTypeSelect?.addEventListener('change', () => {
        if (!formIdInput.value || window.confirm('Replace the current editor content with the selected template?')) {
          titleField.value = formTypeSelect.value;
          applyTemplate(true);
        }
      });

      document.querySelectorAll('.open-form-editor').forEach(button => {
        button.addEventListener('click', () => {
          const payload = JSON.parse(button.dataset.form || '{}');
          openForEdit(payload);
        });
      });

      document.querySelectorAll('.open-form-view').forEach(button => {
        button.addEventListener('click', () => {
          const payload = JSON.parse(button.dataset.form || '{}');
          openViewModal(payload);
        });
      });

      document.querySelectorAll('.print-form-btn').forEach(button => {
        button.addEventListener('click', () => {
          const printWindow = window.open('', '_blank', 'width=900,height=700');
          if (!printWindow) return;
          printWindow.document.write(`
            <html>
              <head>
                <title>${button.dataset.title || 'Form'}</title>
                <style>
                  body { font-family: Arial, sans-serif; padding: 32px; color: #111827; }
                </style>
              </head>
              <body>${button.dataset.content || ''}</body>
            </html>
          `);
          printWindow.document.close();
          printWindow.focus();
          printWindow.print();
        });
      });

      form.addEventListener('submit', () => {
        titleInput.value = titleField.value.trim() || formTypeSelect.value;
        contentInput.value = editor.innerHTML.trim();
      });

      document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
          closeModal();
          closeViewModal();
        }
      });
    })();
  </script>
<?php endif; ?>
<?php if ($profileTab === 'appointments' && $patient): ?>
  <script>
    (function () {
      const calendarEl = document.getElementById('appointmentsCalendar');
      const modal = document.getElementById('appointmentEditorModal');
      const addTrigger = document.getElementById('appointmentAddTrigger');
      const closeButtons = document.querySelectorAll('[data-close-appointment-editor]');
      const statusSelect = document.getElementById('appointmentStatus');
      const cancelReason = document.getElementById('appointmentCancelReason');

      if (!modal || !addTrigger) return;

      function openModal() {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
      }

      function closeModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
      }

      function syncCancelReasonField() {
        if (!statusSelect || !cancelReason) return;
        const isCancelled = statusSelect.value === 'Cancelled';
        cancelReason.required = isCancelled;
      }

      function loadCss(url) {
        return new Promise((resolve, reject) => {
          const existing = document.querySelector(`link[href="${url}"]`);
          if (existing) {
            resolve();
            return;
          }

          const link = document.createElement('link');
          link.rel = 'stylesheet';
          link.href = url;
          link.onload = () => resolve();
          link.onerror = () => reject(new Error('Unable to load calendar CSS.'));
          document.head.appendChild(link);
        });
      }

      function loadScript(url) {
        return new Promise((resolve, reject) => {
          const existing = document.querySelector(`script[src="${url}"]`);
          if (existing) {
            if (window.FullCalendar) {
              resolve();
            } else {
              existing.addEventListener('load', () => resolve(), { once: true });
              existing.addEventListener('error', () => reject(new Error('Unable to load calendar script.')), { once: true });
            }
            return;
          }

          const script = document.createElement('script');
          script.src = url;
          script.defer = true;
          script.onload = () => resolve();
          script.onerror = () => reject(new Error('Unable to load calendar script.'));
          document.body.appendChild(script);
        });
      }

      async function initCalendar() {
        if (!calendarEl) return;

        await loadCss('https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css');
        await loadScript('https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js');

        const patientId = calendarEl.dataset.patientId || '';
        const calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth',
          height: 560,
          headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listWeek'
          },
          events: async (fetchInfo, successCallback, failureCallback) => {
            try {
              const response = await fetch(`appointments_profile.php?id=${encodeURIComponent(patientId)}&action=appointments_calendar_json`);
              const payload = await response.json();
              if (!response.ok || !payload.ok) {
                throw new Error(payload.message || 'Unable to fetch appointments.');
              }
              successCallback(payload.events || []);
            } catch (error) {
              failureCallback(error);
            }
          },
          eventDidMount: info => {
            const dentist = info.event.extendedProps.dentist || 'N/A';
            const status = info.event.extendedProps.status || 'Pending';
            info.el.title = `${info.event.title}\nDentist: ${dentist}\nStatus: ${status}`;
          }
        });

        calendar.render();
      }

      addTrigger.addEventListener('click', openModal);
      closeButtons.forEach(button => button.addEventListener('click', closeModal));
      modal.querySelector('.absolute.inset-0')?.addEventListener('click', closeModal);
      statusSelect?.addEventListener('change', syncCancelReasonField);
      syncCancelReasonField();

      document.addEventListener('keydown', event => {
        if (event.key === 'Escape') {
          closeModal();
        }
      });

      initCalendar().catch(error => {
        console.error(error);
      });
    })();
  </script>
<?php endif; ?>
