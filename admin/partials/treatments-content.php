<?php
$selectedPatientName = $selectedPatient
    ? trim(($selectedPatient['first_name'] ?? '') . ' ' . ($selectedPatient['middle_name'] ?? '') . ' ' . ($selectedPatient['last_name'] ?? ''))
    : '';

if ($selectedPatientName === '' && $selectedPatient) {
  $selectedPatientName = (string) ($selectedPatient['display_name'] ?? $selectedPatient['id'] ?? 'Unknown Patient');
}

$queryBase = [
    'patient_id' => (string) $selectedPatientId,
    'patient_name' => (string) $selectedPatientName,
    'filtered' => isset($_GET['filtered']) ? (string) $_GET['filtered'] : '0',
    'per_page' => (string) $treatmentPerPage,
];

if ($isViewTreatmentsPage) {
    $queryBase['view'] = 'treatments';
}

function treatmentStatusClass(string $status): string
{
    $normalized = strtolower(trim($status));

    if ($normalized === 'complete') {
        return 'bg-emerald-50 text-emerald-700 border-emerald-200';
    }

    if ($normalized === 'in progress') {
        return 'bg-amber-50 text-amber-700 border-amber-200';
    }

    if ($normalized === 'cancelled') {
        return 'bg-rose-50 text-rose-700 border-rose-200';
    }

    return 'bg-slate-100 text-slate-700 border-slate-200';
}
?>

<style>
  .treatment-list-card .treatment-table-scroll {
    max-height: 68vh;
    transition: max-height 300ms ease;
  }

  .treatment-list-card.is-view-page .treatment-table-scroll {
    max-height: calc(100vh - 140px);
  }
</style>

<section class="px-3 pb-6 pt-3 sm:px-4 lg:px-5 lg:pt-5">
  <div class="mx-auto max-w-[1700px]">
    <div class="mb-3 rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-sm">
      <h1 class="text-[18px] font-semibold tracking-tight text-slate-800 sm:text-[22px]">Treatments Plans</h1>
      <p class="mt-1 text-sm text-slate-500">Left panel shows patients. Right panel shows treatment details for the selected patient.</p>
    </div>

    <?php if ($schemaWarning !== ''): ?>
      <div class="mb-3 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-700">
        <?= htmlspecialchars($schemaWarning, ENT_QUOTES, 'UTF-8') ?>
      </div>
    <?php endif; ?>

    <?php if ($successMessage !== ''): ?>
      <div class="mb-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
        <?= htmlspecialchars($successMessage, ENT_QUOTES, 'UTF-8') ?>
      </div>
    <?php endif; ?>

    <?php if ($errorMessage !== ''): ?>
      <div class="mb-3 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
        <?= htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8') ?>
      </div>
    <?php endif; ?>

    <div id="treatmentsLayoutGrid" class="treatments-layout-grid grid grid-cols-1 gap-3 <?= $isViewTreatmentsPage ? '' : 'xl:grid-cols-[330px_minmax(0,1fr)]' ?>">
      <?php if (!$isViewTreatmentsPage): ?>
      <div id="treatmentsLeftPane" class="treatments-left-pane">
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
          <div class="flex items-center justify-between border-b border-slate-200 px-4 py-3">
            <h2 class="text-[16px] font-medium text-slate-800">Patient Name</h2>
            <div class="flex items-center gap-2">
              <a
                href="patients.php"
                class="inline-flex items-center gap-1.5 rounded-lg bg-[#2f89dc] px-3 py-1.5 text-base font-semibold text-white transition hover:bg-[#2478c4]"
                title="Add patient"
              >
                <i data-feather="plus" class="h-4 w-7"></i>
                Add
              </a>
              
            </div>
          </div>

          <div class="border-b border-slate-200 px-3 py-3">
            <form id="patientLoadForm" method="GET" action="treatments.php" class="flex items-center gap-2">
              <input type="hidden" name="patient_id" id="patientLoadId" value="">
              <input type="hidden" name="patient_name" id="patientLoadName" value="">
              <input type="hidden" name="filtered" value="1">
              <div class="relative w-full">
                <input
                  id="patientSearchInput"
                  list="patientSearchList"
                  type="text"
                  autocomplete="off"
                  placeholder="Search patient name"
                  value="<?= htmlspecialchars($selectedPatientName, ENT_QUOTES, 'UTF-8') ?>"
                  class="h-9 w-full rounded-md border border-slate-300 px-3 text-sm text-slate-800 focus:border-[#2f89dc] focus:outline-none focus:ring-2 focus:ring-blue-100"
                >
                <div id="patientSearchSuggestions" class="absolute left-0 right-0 top-[42px] z-20 hidden max-h-56 overflow-y-auto rounded-md border border-slate-200 bg-white shadow-lg"></div>
              </div>
              <datalist id="patientSearchList">
                <?php
                $searchListKeys = [];
                foreach ($patientDirectory as $searchPatient):
                  $searchId = trim((string) ($searchPatient['id'] ?? ''));
                  $searchName = trim((string) ($searchPatient['display_name'] ?? ''));
                    if ($searchName === '') {
                        continue;
                    }
                    $key = strtolower($searchName . '|' . $searchId);
                    if (isset($searchListKeys[$key])) {
                        continue;
                    }
                    $searchListKeys[$key] = true;
                ?>
                  <option
                    value="<?= htmlspecialchars($searchName, ENT_QUOTES, 'UTF-8') ?>"
                    data-patient-id="<?= htmlspecialchars($searchId, ENT_QUOTES, 'UTF-8') ?>"
                    data-patient-name="<?= htmlspecialchars($searchName, ENT_QUOTES, 'UTF-8') ?>"
                  ></option>
                <?php endforeach; ?>
              </datalist>
              <button type="submit" class="h-9 shrink-0 rounded-md bg-[#2f89dc] px-3 text-sm font-semibold text-white hover:bg-[#2478c4]">
                Load
              </button>
            </form>
          </div>

          <div class="max-h-[68vh] overflow-y-auto">
            <?php if (empty($patients)): ?>
              <div class="px-4 py-8 text-center text-sm text-slate-400">No patients found.</div>
            <?php else: ?>
              <?php foreach ($patients as $patient): ?>
                <?php
                $cardPatientId = (string) ($patient['patient_id'] ?? '');
                $cardPatientName = trim((string) ($patient['patient_name'] ?? ''));
                $isActive = false;
                if ($selectedPatientId !== '') {
                  $isActive = $cardPatientId !== '' && $cardPatientId === (string) $selectedPatientId;
                } elseif ($selectedPatientName !== '') {
                  $isActive = $cardPatientId === '' && $cardPatientName !== '' && $cardPatientName === (string) $selectedPatientName;
                }
                $displayDate = $patient['latest_treatment_date'] ?: ($patient['date_registered'] ?: '');
                $patientPhoto = !empty($patient['photo']) ? '../' . ltrim((string) $patient['photo'], '/') : '';
                $mapUrl = !empty($patient['home_address'])
                    ? 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode((string) $patient['home_address'])
                    : '';
                $mailUrl = !empty($patient['email'])
                    ? 'mailto:' . rawurlencode((string) $patient['email'])
                    : '';
                $phone = trim((string) ($patient['mobile_no'] ?? ''));
                $phoneUrl = $phone !== '' ? 'tel:' . preg_replace('/\s+/', '', $phone) : '';
                ?>
                <a
                  href="treatments.php?patient_id=<?= urlencode($cardPatientId) ?>&patient_name=<?= urlencode($cardPatientName) ?>&filtered=<?= isset($_GET['filtered']) ? urlencode((string) $_GET['filtered']) : '0' ?>"
                  class="block border-b border-slate-100 px-3 py-2.5 transition hover:bg-slate-50 <?= $isActive ? 'bg-[#eaf4ff]' : '' ?>"
                >
                  <div class="flex items-start gap-2.5">
                    <div class="h-14 w-14 overflow-hidden rounded-lg bg-slate-200">
                      <?php if ($patientPhoto !== ''): ?>
                        <img src="<?= htmlspecialchars($patientPhoto, ENT_QUOTES, 'UTF-8') ?>" alt="Patient photo" class="h-full w-full object-cover">
                      <?php else: ?>
                        <div class="flex h-full w-full items-center justify-center text-slate-400">
                          <i data-feather="user" class="h-5 w-5"></i>
                        </div>
                      <?php endif; ?>
                    </div>
                    <div class="min-w-0 flex-1">
                      <p class="truncate text-[16px] font-semibold leading-tight text-slate-800">
                        <?= htmlspecialchars((string) ($patient['display_name'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                      </p>
                      <p class="mt-0.5 text-sm text-slate-600">
                        <?= htmlspecialchars($displayDate !== '' ? date('n/j/Y', strtotime($displayDate)) : '-', ENT_QUOTES, 'UTF-8') ?>
                      </p>
                      <div class="mt-2 flex items-center gap-2 text-slate-500">
                        <?php if ($cardPatientId !== ''): ?>
                          <a
                            href="view_profile.php?id=<?= urlencode($cardPatientId) ?>"
                            class="inline-flex h-7 w-7 items-center justify-center rounded-md border border-slate-200 bg-white hover:text-[#2f89dc]"
                            title="View profile"
                          >
                            <i data-feather="edit-3" class="h-3.5 w-3.5"></i>
                          </a>
                        <?php else: ?>
                          <span class="inline-flex h-7 w-7 items-center justify-center rounded-md border border-slate-100 bg-slate-50 text-slate-300" title="No patient profile link">
                            <i data-feather="edit-3" class="h-3.5 w-3.5"></i>
                          </span>
                        <?php endif; ?>
                        <a
                          href="<?= htmlspecialchars($mapUrl !== '' ? $mapUrl : '#', ENT_QUOTES, 'UTF-8') ?>"
                          target="_blank"
                          rel="noopener noreferrer"
                          class="inline-flex h-7 w-7 items-center justify-center rounded-md border border-slate-200 bg-white <?= $mapUrl !== '' ? 'hover:text-[#2f89dc]' : 'pointer-events-none text-slate-300' ?>"
                          title="Location"
                        >
                          <i data-feather="map-pin" class="h-3.5 w-3.5"></i>
                        </a>
                        <a
                          href="<?= htmlspecialchars($mailUrl !== '' ? $mailUrl : '#', ENT_QUOTES, 'UTF-8') ?>"
                          class="inline-flex h-7 w-7 items-center justify-center rounded-md border border-slate-200 bg-white <?= $mailUrl !== '' ? 'hover:text-[#2f89dc]' : 'pointer-events-none text-slate-300' ?>"
                          title="Email"
                        >
                          <i data-feather="mail" class="h-3.5 w-3.5"></i>
                        </a>
                        <a
                          href="<?= htmlspecialchars($phoneUrl !== '' ? $phoneUrl : '#', ENT_QUOTES, 'UTF-8') ?>"
                          class="inline-flex h-7 w-7 items-center justify-center rounded-md border border-slate-200 bg-white <?= $phoneUrl !== '' ? 'hover:text-[#2f89dc]' : 'pointer-events-none text-slate-300' ?>"
                          title="Call"
                        >
                          <i data-feather="phone" class="h-3.5 w-3.5"></i>
                        </a>
                        <a
                          href="<?= htmlspecialchars($phoneUrl !== '' ? $phoneUrl : '#', ENT_QUOTES, 'UTF-8') ?>"
                          class="inline-flex h-7 w-7 items-center justify-center rounded-md border border-slate-200 bg-white <?= $phoneUrl !== '' ? 'hover:text-[#2f89dc]' : 'pointer-events-none text-slate-300' ?>"
                          title="Message"
                        >
                          <i data-feather="message-circle" class="h-3.5 w-3.5"></i>
                        </a>
                      </div>
                    </div>
                  </div>
                </a>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <?php endif; ?>

      <div>
        <div id="treatmentListCard" class="treatment-list-card <?= $isViewTreatmentsPage ? 'is-view-page' : '' ?> overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
          <div class="flex items-center justify-between border-b border-slate-200 px-4 py-3">
            <div>
              <h2 class="text-[20px] font-medium text-slate-800"><?= $isViewTreatmentsPage ? 'View Treatments' : 'Treatment List' ?></h2>
              <?php if ($selectedPatientName !== ''): ?>
                <p class="text-sm text-slate-500">Showing records for <?= htmlspecialchars($selectedPatientName, ENT_QUOTES, 'UTF-8') ?></p>
              <?php endif; ?>
            </div>
            <div class="flex items-center gap-2">
              <?php if ($isViewTreatmentsPage): ?>
                <a
                  href="treatments.php?<?= htmlspecialchars(http_build_query(['patient_id' => (string) $selectedPatientId, 'patient_name' => (string) $selectedPatientName, 'filtered' => isset($_GET['filtered']) ? (string) $_GET['filtered'] : '0', 'per_page' => (string) $treatmentPerPage]), ENT_QUOTES, 'UTF-8') ?>"
                  class="inline-flex items-center gap-2 rounded-lg border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                  title="Back to treatments"
                >
                  <i data-feather="arrow-left" class="h-4 w-4"></i>
                  Back
                </a>
              <?php endif; ?>
              <button id="openTreatmentModalBtn" type="button" class="inline-flex items-center gap-2 rounded-lg bg-[#2f89dc] px-4 py-2 text-lg font-semibold text-white transition hover:bg-[#2478c4]" title="Add treatment">
                <i data-feather="plus" class="h-4 w-4"></i>
                Add
              </button>
              <button type="button" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-500" title="Filter">
                <i data-feather="filter" class="h-4 w-4"></i>
              </button>
              <?php if (!$isViewTreatmentsPage): ?>
                <a
                  href="treatments.php?<?= htmlspecialchars(http_build_query(array_merge($queryBase, ['view' => 'treatments', 'page' => 1])), ENT_QUOTES, 'UTF-8') ?>"
                  class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-500 hover:bg-slate-50"
                  title="View treatments"
                >
                  <i data-feather="maximize-2" class="h-4 w-4"></i>
                </a>
              <?php endif; ?>
            </div>
          </div>

          <div class="treatment-table-scroll overflow-auto">
            <table class="min-w-full text-left">
              <thead class="sticky top-0 z-10 border-b border-slate-200 bg-slate-50 text-sm font-semibold text-slate-700">
                <tr>
                  <th class="px-4 py-3">Category</th>
                  <th class="px-4 py-3">Treatment Name</th>
                  <th class="px-4 py-3">Treatment Date</th>
                  <th class="px-4 py-3">Tooth Number</th>
                  <th class="px-4 py-3">Description</th>
                  <th class="px-4 py-3">Patient Name</th>
                  <th class="px-4 py-3">Dentist</th>
                  <th class="px-4 py-3">Amount Charged</th>
                  <th class="px-4 py-3">Status</th>
                  <th class="px-4 py-3">Treatment Notes</th>
                  <th class="px-4 py-3">Payment Status</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100 text-[15px] text-slate-700">
                <?php if (!$selectedPatient): ?>
                  <tr>
                    <td colspan="11" class="px-4 py-10 text-center text-sm text-slate-400">Select a patient to see treatments.</td>
                  </tr>
                <?php elseif (empty($patientTreatments)): ?>
                  <tr>
                    <td colspan="11" class="px-4 py-10 text-center text-sm text-slate-400">No treatments found for this patient.</td>
                  </tr>
                <?php else: ?>
                  <?php foreach ($patientTreatments as $row): ?>
                    <?php
                    $category = trim((string) ($row['category'] ?? ''));
                    $serviceName = trim((string) ($row['service_name'] ?? ''));
                    $status = (string) ($row['status'] ?? 'Scheduled');
                    $statusClass = treatmentStatusClass($status);
                    $dateValue = trim((string) ($row['treatment_date'] ?? ''));
                    $toothNumber = trim((string) ($row['tooth_number'] ?? ''));
                    $description = trim((string) ($row['description'] ?? ''));
                    $patientName = trim((string) ($row['patient_name'] ?? ''));
                    if ($patientName === '' && $selectedPatientName !== '') {
                        $patientName = $selectedPatientName;
                    }
                    $dentist = trim((string) ($row['dentist'] ?? ''));
                    $amountCharged = (float) ($row['amount_charge'] ?? 0);
                    $treatmentNotes = trim((string) ($row['treatment_note'] ?? ''));
                    $paymentStatusRaw = trim((string) ($row['payment_status'] ?? 'Unpaid'));
                    $paymentStatus = strcasecmp($paymentStatusRaw, 'Partial') === 0 ? 'Partially Paid' : $paymentStatusRaw;
                    ?>
                    <tr class="transition hover:bg-slate-50">
                      <td class="max-w-[210px] truncate px-4 py-3" title="<?= htmlspecialchars($category, ENT_QUOTES, 'UTF-8') ?>">
                        <?= htmlspecialchars($category !== '' ? $category : '-', ENT_QUOTES, 'UTF-8') ?>
                      </td>
                      <td class="max-w-[340px] truncate px-4 py-3 font-medium text-slate-800" title="<?= htmlspecialchars($serviceName, ENT_QUOTES, 'UTF-8') ?>">
                        <?= htmlspecialchars($serviceName !== '' ? $serviceName : '-', ENT_QUOTES, 'UTF-8') ?>
                      </td>
                      <td class="px-4 py-3"><?= htmlspecialchars($dateValue !== '' ? date('n/j/Y', strtotime($dateValue)) : '-', ENT_QUOTES, 'UTF-8') ?></td>
                      <td class="px-4 py-3"><?= htmlspecialchars($toothNumber !== '' ? $toothNumber : '-', ENT_QUOTES, 'UTF-8') ?></td>
                      <td class="max-w-[260px] truncate px-4 py-3" title="<?= htmlspecialchars($description, ENT_QUOTES, 'UTF-8') ?>">
                        <?= htmlspecialchars($description !== '' ? $description : '-', ENT_QUOTES, 'UTF-8') ?>
                      </td>
                      <td class="max-w-[220px] truncate px-4 py-3" title="<?= htmlspecialchars($patientName, ENT_QUOTES, 'UTF-8') ?>">
                        <?= htmlspecialchars($patientName !== '' ? $patientName : '-', ENT_QUOTES, 'UTF-8') ?>
                      </td>
                      <td class="max-w-[190px] truncate px-4 py-3" title="<?= htmlspecialchars($dentist, ENT_QUOTES, 'UTF-8') ?>">
                        <?= htmlspecialchars($dentist !== '' ? $dentist : '-', ENT_QUOTES, 'UTF-8') ?>
                      </td>
                      <td class="whitespace-nowrap px-4 py-3 font-medium text-slate-800">&#8369;<?= number_format($amountCharged, 2) ?></td>
                      <td class="px-4 py-3">
                        <span class="inline-flex rounded-full border px-2.5 py-1 text-xs font-semibold <?= $statusClass ?>">
                          <?= htmlspecialchars($status, ENT_QUOTES, 'UTF-8') ?>
                        </span>
                      </td>
                      <td class="max-w-[300px] truncate px-4 py-3" title="<?= htmlspecialchars($treatmentNotes, ENT_QUOTES, 'UTF-8') ?>">
                        <?= htmlspecialchars($treatmentNotes !== '' ? $treatmentNotes : '-', ENT_QUOTES, 'UTF-8') ?>
                      </td>
                      <td class="whitespace-nowrap px-4 py-3"><?= htmlspecialchars($paymentStatus !== '' ? $paymentStatus : '-', ENT_QUOTES, 'UTF-8') ?></td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
          </div>

          <?php if (($selectedPatientId !== '' || $selectedPatientName !== '') && $totalPatientTreatments > 0): ?>
            <?php
            $prevPage = max(1, $treatmentCurrentPage - 1);
            $nextPage = min($totalTreatmentPages, $treatmentCurrentPage + 1);
            $showingStart = (($treatmentCurrentPage - 1) * $treatmentPerPage) + 1;
            $showingEnd = min($totalPatientTreatments, $treatmentCurrentPage * $treatmentPerPage);
            ?>
            <div class="flex flex-col gap-3 border-t border-slate-200 px-4 py-3 text-sm text-slate-600 md:flex-row md:items-center md:justify-between">
              <div class="flex items-center gap-2">
                <span>Rows per page</span>
                <form method="GET" action="treatments.php" class="inline-flex items-center gap-2">
                  <input type="hidden" name="patient_id" value="<?= htmlspecialchars((string) $selectedPatientId, ENT_QUOTES, 'UTF-8') ?>">
                  <input type="hidden" name="patient_name" value="<?= htmlspecialchars((string) $selectedPatientName, ENT_QUOTES, 'UTF-8') ?>">
                  <input type="hidden" name="filtered" value="<?= htmlspecialchars(isset($_GET['filtered']) ? (string) $_GET['filtered'] : '0', ENT_QUOTES, 'UTF-8') ?>">
                  <?php if ($isViewTreatmentsPage): ?>
                    <input type="hidden" name="view" value="treatments">
                  <?php endif; ?>
                  <input type="hidden" name="page" value="1">
                  <select name="per_page" class="h-8 rounded-md border border-slate-300 px-2 text-sm text-slate-800" onchange="this.form.submit()">
                    <option value="10" <?= $treatmentPerPage === 10 ? 'selected' : '' ?>>10</option>
                    <option value="20" <?= $treatmentPerPage === 20 ? 'selected' : '' ?>>20</option>
                  </select>
                </form>
                <span>Showing <?= $showingStart ?>-<?= $showingEnd ?> of <?= (int) $totalPatientTreatments ?></span>
              </div>

              <div class="flex items-center gap-2">
                <a
                  href="treatments.php?<?= htmlspecialchars(http_build_query(array_merge($queryBase, ['page' => $prevPage])), ENT_QUOTES, 'UTF-8') ?>"
                  class="inline-flex items-center rounded-md border border-slate-300 px-3 py-1.5 text-sm font-medium <?= $treatmentCurrentPage <= 1 ? 'pointer-events-none opacity-50' : 'hover:bg-slate-50' ?>"
                >
                  Previous
                </a>
                <span>Page <?= (int) $treatmentCurrentPage ?> of <?= (int) $totalTreatmentPages ?></span>
                <a
                  href="treatments.php?<?= htmlspecialchars(http_build_query(array_merge($queryBase, ['page' => $nextPage])), ENT_QUOTES, 'UTF-8') ?>"
                  class="inline-flex items-center rounded-md border border-slate-300 px-3 py-1.5 text-sm font-medium <?= $treatmentCurrentPage >= $totalTreatmentPages ? 'pointer-events-none opacity-50' : 'hover:bg-slate-50' ?>"
                >
                  Next
                </a>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<div id="treatmentModal" class="fixed inset-0 z-[90] hidden items-center justify-center bg-slate-950/55 px-4 py-4">
  <div class="absolute inset-0" data-close-treatment-modal></div>
  <div class="relative z-10 max-h-[94vh] w-full max-w-2xl overflow-y-auto rounded-2xl border border-slate-200 bg-white shadow-2xl">
    <div class="sticky top-0 z-10 flex items-center justify-between border-b border-slate-200 bg-white px-5 py-4">
      <h3 class="text-xl font-semibold text-slate-800">Add Treatment</h3>
      <button id="closeTreatmentModalBtn" type="button" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-500 hover:bg-slate-50" aria-label="Close treatment modal">
        <i data-feather="x" class="h-4 w-4"></i>
      </button>
    </div>

    <form method="POST" action="treatments.php" class="space-y-4 px-5 py-5" id="treatmentCreateForm">
      <input type="hidden" name="action" value="create_treatment">

      <div class="grid grid-cols-1 gap-4 md:grid-cols-[120px_minmax(0,1fr)] md:items-center">
        <label for="treatment_date" class="text-sm font-medium text-slate-700">Treatment Date <span class="text-rose-500">*</span></label>
        <input
          id="treatment_date"
          name="treatment_date"
          type="date"
          required
          value="<?= htmlspecialchars($treatmentFormValues['treatment_date'] !== '' ? $treatmentFormValues['treatment_date'] : date('Y-m-d'), ENT_QUOTES, 'UTF-8') ?>"
          class="h-11 w-full rounded-md border border-slate-300 px-3 text-sm text-slate-800 focus:border-[#2f89dc] focus:outline-none focus:ring-2 focus:ring-blue-100"
        >
      </div>

      <div class="grid grid-cols-1 gap-4 md:grid-cols-[120px_minmax(0,1fr)] md:items-center">
        <label for="patient_id" class="text-sm font-medium text-slate-700">Patient Name</label>
        <select id="patient_id" name="patient_id" required class="h-11 w-full rounded-md border border-slate-300 px-3 text-sm text-slate-800 focus:border-[#2f89dc] focus:outline-none focus:ring-2 focus:ring-blue-100">
          <option value="">Select patient</option>
          <?php foreach ($patientDirectory as $patientOption): ?>
            <?php
            $optionId = trim((string) ($patientOption['id'] ?? ''));
            $optionName = trim((string) ($patientOption['display_name'] ?? ''));
            if ($optionId === '') {
                continue;
            }
            $isSelectedOption = $treatmentFormValues['patient_id'] !== ''
                ? $treatmentFormValues['patient_id'] === $optionId
                : ($selectedPatientId !== '' && $selectedPatientId === $optionId);
            ?>
            <option value="<?= htmlspecialchars($optionId, ENT_QUOTES, 'UTF-8') ?>" <?= $isSelectedOption ? 'selected' : '' ?>>
              <?= htmlspecialchars($optionName !== '' ? $optionName : $optionId, ENT_QUOTES, 'UTF-8') ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="grid grid-cols-1 gap-4 md:grid-cols-[120px_minmax(0,1fr)] md:items-center">
        <label for="tooth_number" class="text-sm font-medium text-slate-700">Tooth Number</label>
        <select id="tooth_number" name="tooth_number" class="h-11 w-full rounded-md border border-slate-300 px-3 text-sm text-slate-800 focus:border-[#2f89dc] focus:outline-none focus:ring-2 focus:ring-blue-100">
          <option value="">Select tooth</option>
          <?php for ($tooth = 1; $tooth <= 32; $tooth++): ?>
            <option value="<?= $tooth ?>" <?= $treatmentFormValues['tooth_number'] === (string) $tooth ? 'selected' : '' ?>><?= $tooth ?></option>
          <?php endfor; ?>
        </select>
      </div>

      <div class="grid grid-cols-1 gap-4 md:grid-cols-[120px_minmax(0,1fr)] md:items-center">
        <label for="category" class="text-sm font-medium text-slate-700">Category</label>
        <select id="category" name="category" class="h-11 w-full rounded-md border border-slate-300 px-3 text-sm text-slate-800 focus:border-[#2f89dc] focus:outline-none focus:ring-2 focus:ring-blue-100">
          <option value="">Select category</option>
          <?php foreach (array_keys($categoryOptions) as $categoryOption): ?>
            <?php if (trim($categoryOption) === '') { continue; } ?>
            <option value="<?= htmlspecialchars($categoryOption, ENT_QUOTES, 'UTF-8') ?>" <?= $treatmentFormValues['category'] === $categoryOption ? 'selected' : '' ?>>
              <?= htmlspecialchars($categoryOption, ENT_QUOTES, 'UTF-8') ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="grid grid-cols-1 gap-4 md:grid-cols-[120px_minmax(0,1fr)] md:items-center">
        <label for="service_id" class="text-sm font-medium text-slate-700">Treatment Name</label>
        <select id="service_id" name="service_id" required class="h-11 w-full rounded-md border border-slate-300 px-3 text-sm text-slate-800 focus:border-[#2f89dc] focus:outline-none focus:ring-2 focus:ring-blue-100">
          <option value="">Select treatment</option>
          <?php foreach ($serviceCatalog as $service): ?>
            <?php
            $serviceId = (string) ($service['service_id'] ?? '');
            $serviceName = (string) ($service['service_name'] ?? '');
            $serviceCategory = (string) ($service['category'] ?? '');
            $requiresTooth = (int) ($service['requires_tooth'] ?? 0);
            ?>
            <option
              value="<?= htmlspecialchars($serviceId, ENT_QUOTES, 'UTF-8') ?>"
              data-category="<?= htmlspecialchars($serviceCategory, ENT_QUOTES, 'UTF-8') ?>"
              data-requires-tooth="<?= $requiresTooth ?>"
              <?= $treatmentFormValues['service_id'] === $serviceId ? 'selected' : '' ?>
            >
              <?= htmlspecialchars($serviceName, ENT_QUOTES, 'UTF-8') ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="grid grid-cols-1 gap-4 md:grid-cols-[120px_minmax(0,1fr)] md:items-center">
        <label for="description" class="text-sm font-medium text-slate-700">Description</label>
        <input
          id="description"
          name="description"
          type="text"
          value="<?= htmlspecialchars($treatmentFormValues['description'], ENT_QUOTES, 'UTF-8') ?>"
          class="h-11 w-full rounded-md border border-slate-300 px-3 text-sm text-slate-800 focus:border-[#2f89dc] focus:outline-none focus:ring-2 focus:ring-blue-100"
        >
      </div>

      <div class="grid grid-cols-1 gap-4 md:grid-cols-[120px_minmax(0,1fr)] md:items-center">
        <label for="amount_charge" class="text-sm font-medium text-slate-700">Amount Charged <span class="text-rose-500">*</span></label>
        <div class="flex items-center overflow-hidden rounded-md border border-slate-300 focus-within:border-[#2f89dc] focus-within:ring-2 focus-within:ring-blue-100">
          <span class="px-3 text-sm text-slate-700">&#8369;</span>
          <input
            id="amount_charge"
            name="amount_charge"
            type="number"
            step="0.01"
            min="0"
            required
            value="<?= htmlspecialchars($treatmentFormValues['amount_charge'] !== '' ? $treatmentFormValues['amount_charge'] : '0.00', ENT_QUOTES, 'UTF-8') ?>"
            class="h-11 w-full border-0 px-1 text-sm text-slate-800 focus:outline-none"
          >
          <button type="button" id="minusAmountBtn" class="h-11 w-10 border-l border-slate-200 text-lg font-semibold text-slate-500 hover:bg-slate-50">-</button>
          <button type="button" id="plusAmountBtn" class="h-11 w-10 border-l border-slate-200 text-lg font-semibold text-slate-500 hover:bg-slate-50">+</button>
        </div>
      </div>

      <div class="grid grid-cols-1 gap-4 md:grid-cols-[120px_minmax(0,1fr)] md:items-center">
        <label for="payment_status" class="text-sm font-medium text-slate-700">Payment Status</label>
        <select id="payment_status" name="payment_status" class="h-11 w-full rounded-md border border-slate-300 px-3 text-sm text-slate-800 focus:border-[#2f89dc] focus:outline-none focus:ring-2 focus:ring-blue-100">
          <option value="Unpaid" <?= $treatmentFormValues['payment_status'] === 'Unpaid' ? 'selected' : '' ?>>Unpaid</option>
          <option value="Partial" <?= $treatmentFormValues['payment_status'] === 'Partial' ? 'selected' : '' ?>>Partially Paid</option>
          <option value="Paid" <?= $treatmentFormValues['payment_status'] === 'Paid' ? 'selected' : '' ?>>Paid</option>
        </select>
      </div>

      <div class="grid grid-cols-1 gap-4 md:grid-cols-[120px_minmax(0,1fr)] md:items-center">
        <label for="dentist" class="text-sm font-medium text-slate-700">Dentist</label>
        <select id="dentist" name="dentist" class="h-11 w-full rounded-md border border-slate-300 px-3 text-sm text-slate-800 focus:border-[#2f89dc] focus:outline-none focus:ring-2 focus:ring-blue-100">
          <option value="">Select dentist</option>
          <?php foreach (array_keys($dentistOptions) as $dentistOption): ?>
            <option value="<?= htmlspecialchars($dentistOption, ENT_QUOTES, 'UTF-8') ?>" <?= $treatmentFormValues['dentist'] === $dentistOption ? 'selected' : '' ?>>
              <?= htmlspecialchars($dentistOption, ENT_QUOTES, 'UTF-8') ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="grid grid-cols-1 gap-4 md:grid-cols-[120px_minmax(0,1fr)] md:items-center">
        <label for="status" class="text-sm font-medium text-slate-700">Status</label>
        <select id="status" name="status" class="h-11 w-full rounded-md border border-slate-300 px-3 text-sm text-slate-800 focus:border-[#2f89dc] focus:outline-none focus:ring-2 focus:ring-blue-100">
          <option value="Scheduled" <?= $treatmentFormValues['status'] === 'Scheduled' ? 'selected' : '' ?>>Scheduled</option>
          <option value="In Progress" <?= $treatmentFormValues['status'] === 'In Progress' ? 'selected' : '' ?>>In Progress</option>
          <option value="Complete" <?= $treatmentFormValues['status'] === 'Complete' ? 'selected' : '' ?>>Complete</option>
          <option value="Cancelled" <?= $treatmentFormValues['status'] === 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
        </select>
      </div>

      <div class="grid grid-cols-1 gap-4 md:grid-cols-[120px_minmax(0,1fr)] md:items-start">
        <label for="treatment_note" class="pt-2 text-sm font-medium text-slate-700">Treatment Notes</label>
        <textarea
          id="treatment_note"
          name="treatment_note"
          rows="3"
          class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm text-slate-800 focus:border-[#2f89dc] focus:outline-none focus:ring-2 focus:ring-blue-100"
        ><?= htmlspecialchars($treatmentFormValues['treatment_note'], ENT_QUOTES, 'UTF-8') ?></textarea>
      </div>

      <div class="flex items-center justify-end gap-3 border-t border-slate-200 pt-4">
        <button type="button" id="cancelTreatmentModalBtn" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Cancel</button>
        <button type="submit" class="rounded-lg bg-[#2f89dc] px-4 py-2 text-sm font-semibold text-white hover:bg-[#2478c4]">Save Treatment</button>
      </div>
    </form>
  </div>
</div>

<script>
  (function () {
    const modal = document.getElementById('treatmentModal');
    const openBtn = document.getElementById('openTreatmentModalBtn');
    const closeBtn = document.getElementById('closeTreatmentModalBtn');
    const cancelBtn = document.getElementById('cancelTreatmentModalBtn');
    const closeLayer = modal ? modal.querySelector('[data-close-treatment-modal]') : null;
    const categorySelect = document.getElementById('category');
    const serviceSelect = document.getElementById('service_id');
    const toothSelect = document.getElementById('tooth_number');
    const plusAmountBtn = document.getElementById('plusAmountBtn');
    const minusAmountBtn = document.getElementById('minusAmountBtn');
    const amountInput = document.getElementById('amount_charge');
    const patientLoadForm = document.getElementById('patientLoadForm');
    const patientSearchInput = document.getElementById('patientSearchInput');
    const patientLoadId = document.getElementById('patientLoadId');
    const patientLoadName = document.getElementById('patientLoadName');
    const patientSearchList = document.getElementById('patientSearchList');
    const patientSearchSuggestions = document.getElementById('patientSearchSuggestions');
    let activeSuggestionIndex = -1;

    function getPatientOptions() {
      if (!patientSearchList) return [];
      return Array.from(patientSearchList.options).map((option) => ({
        value: (option.value || '').trim(),
        patientId: option.getAttribute('data-patient-id') || '',
        patientName: option.getAttribute('data-patient-name') || option.value || ''
      })).filter((entry) => entry.value !== '');
    }

    function hideSuggestions() {
      if (!patientSearchSuggestions) return;
      patientSearchSuggestions.classList.add('hidden');
      patientSearchSuggestions.innerHTML = '';
      activeSuggestionIndex = -1;
    }

    function applySuggestion(entry) {
      if (!patientSearchInput || !patientLoadId || !patientLoadName) return;
      patientSearchInput.value = entry.value;
      patientLoadId.value = entry.patientId;
      patientLoadName.value = entry.patientName;
      hideSuggestions();
    }

    function renderSuggestions() {
      if (!patientSearchInput || !patientSearchSuggestions) return;

      const keyword = (patientSearchInput.value || '').trim().toLowerCase();
      if (keyword === '') {
        hideSuggestions();
        return;
      }

      const matches = getPatientOptions()
        .filter((entry) => entry.value.toLowerCase().includes(keyword))
        .slice(0, 8);

      if (matches.length === 0) {
        hideSuggestions();
        return;
      }

      patientSearchSuggestions.innerHTML = matches.map((entry, index) => {
        const escapedValue = entry.value
          .replace(/&/g, '&amp;')
          .replace(/</g, '&lt;')
          .replace(/>/g, '&gt;')
          .replace(/"/g, '&quot;')
          .replace(/'/g, '&#039;');

        return `<button type="button" data-index="${index}" class="patient-suggestion-item block w-full px-3 py-2 text-left text-sm text-slate-700 hover:bg-slate-100">${escapedValue}</button>`;
      }).join('');

      patientSearchSuggestions.classList.remove('hidden');
      activeSuggestionIndex = -1;

      const buttons = patientSearchSuggestions.querySelectorAll('.patient-suggestion-item');
      buttons.forEach((button, index) => {
        button.addEventListener('click', () => {
          applySuggestion(matches[index]);
        });
      });
    }

    function highlightSuggestion(index) {
      if (!patientSearchSuggestions) return;
      const buttons = Array.from(patientSearchSuggestions.querySelectorAll('.patient-suggestion-item'));
      buttons.forEach((btn, i) => {
        btn.classList.toggle('bg-slate-100', i === index);
      });
    }

    function openModal() {
      if (!modal) return;
      modal.classList.remove('hidden');
      modal.classList.add('flex');
      document.body.classList.add('overflow-hidden');
    }

    function closeModal() {
      if (!modal) return;
      modal.classList.add('hidden');
      modal.classList.remove('flex');
      document.body.classList.remove('overflow-hidden');
    }

    function updateServiceOptions() {
      if (!serviceSelect) return;

      const selectedCategory = categorySelect ? categorySelect.value : '';
      Array.from(serviceSelect.options).forEach((option, index) => {
        if (index === 0) {
          option.hidden = false;
          option.disabled = false;
          return;
        }

        const optionCategory = option.getAttribute('data-category') || '';
        const shouldShow = selectedCategory === '' || selectedCategory === optionCategory;
        option.hidden = !shouldShow;
        option.disabled = !shouldShow;

        if (!shouldShow && option.selected) {
          serviceSelect.value = '';
        }
      });
    }

    function syncCategoryAndToothRule() {
      if (!serviceSelect) return;
      const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
      if (!selectedOption) return;

      const selectedCategory = selectedOption.getAttribute('data-category') || '';
      const requiresTooth = selectedOption.getAttribute('data-requires-tooth') === '1';

      if (categorySelect && selectedCategory !== '') {
        categorySelect.value = selectedCategory;
      }

      if (toothSelect) {
        toothSelect.required = requiresTooth;
        toothSelect.classList.toggle('border-amber-400', requiresTooth && toothSelect.value === '');
      }
    }

    function adjustAmount(delta) {
      if (!amountInput) return;
      const current = parseFloat(amountInput.value || '0');
      const next = Math.max(0, current + delta);
      amountInput.value = next.toFixed(2);
    }

    if (openBtn) openBtn.addEventListener('click', openModal);
    if (closeBtn) closeBtn.addEventListener('click', closeModal);
    if (cancelBtn) cancelBtn.addEventListener('click', closeModal);
    if (closeLayer) closeLayer.addEventListener('click', closeModal);

    if (categorySelect) {
      categorySelect.addEventListener('change', () => {
        updateServiceOptions();
      });
    }

    if (serviceSelect) {
      serviceSelect.addEventListener('change', syncCategoryAndToothRule);
    }

    if (plusAmountBtn) plusAmountBtn.addEventListener('click', () => adjustAmount(100));
    if (minusAmountBtn) minusAmountBtn.addEventListener('click', () => adjustAmount(-100));

    if (patientLoadForm && patientSearchInput && patientLoadId && patientLoadName && patientSearchList) {
      patientSearchInput.addEventListener('input', () => {
        patientLoadId.value = '';
        patientLoadName.value = '';
        renderSuggestions();
      });

      patientSearchInput.addEventListener('keydown', (event) => {
        if (!patientSearchSuggestions || patientSearchSuggestions.classList.contains('hidden')) return;
        const buttons = Array.from(patientSearchSuggestions.querySelectorAll('.patient-suggestion-item'));
        if (buttons.length === 0) return;

        if (event.key === 'ArrowDown') {
          event.preventDefault();
          activeSuggestionIndex = (activeSuggestionIndex + 1) % buttons.length;
          highlightSuggestion(activeSuggestionIndex);
        } else if (event.key === 'ArrowUp') {
          event.preventDefault();
          activeSuggestionIndex = (activeSuggestionIndex - 1 + buttons.length) % buttons.length;
          highlightSuggestion(activeSuggestionIndex);
        } else if (event.key === 'Enter' && activeSuggestionIndex >= 0) {
          event.preventDefault();
          buttons[activeSuggestionIndex].click();
        } else if (event.key === 'Escape') {
          hideSuggestions();
        }
      });

      patientLoadForm.addEventListener('submit', (event) => {
        const typedName = (patientSearchInput.value || '').trim();
        let matchedOption = null;

        Array.from(patientSearchList.options).some((option) => {
          const optionValue = (option.value || '').trim().toLowerCase();
          if (optionValue === typedName.toLowerCase()) {
            matchedOption = option;
            return true;
          }
          return false;
        });

        if (!matchedOption) {
          matchedOption = Array.from(patientSearchList.options).find((option) => {
            const optionValue = (option.value || '').trim().toLowerCase();
            return typedName !== '' && optionValue.includes(typedName.toLowerCase());
          }) || null;

          if (!matchedOption) {
            event.preventDefault();
            patientSearchInput.focus();
            return;
          }
        }

        patientLoadId.value = matchedOption.getAttribute('data-patient-id') || '';
        patientLoadName.value = matchedOption.getAttribute('data-patient-name') || matchedOption.value || '';
        hideSuggestions();
      });

      document.addEventListener('click', (event) => {
        if (!patientSearchSuggestions || !patientSearchInput) return;
        if (event.target === patientSearchInput || patientSearchSuggestions.contains(event.target)) return;
        hideSuggestions();
      });
    }

    updateServiceOptions();
    syncCategoryAndToothRule();

    const shouldAutoOpen = <?= $openTreatmentModal ? 'true' : 'false' ?>;
    if (shouldAutoOpen) {
      openModal();
    }
  })();
</script>
