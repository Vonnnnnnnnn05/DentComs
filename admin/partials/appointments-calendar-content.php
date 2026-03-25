<?php
$statusClasses = [
    'Pending' => 'bg-amber-50 text-amber-700 ring-amber-200',
    'Confirmed' => 'bg-blue-50 text-blue-700 ring-blue-200',
    'Complete' => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
    'Cancelled' => 'bg-red-50 text-red-700 ring-red-200',
    'No Show' => 'bg-slate-100 text-slate-700 ring-slate-200',
    'Rescheduled' => 'bg-violet-50 text-violet-700 ring-violet-200',
];
?>
<section class="px-4 pb-10 pt-4 sm:px-6 md:px-8">
  <div class="mx-auto w-full max-w-[1400px]">
    <div class="rounded-[24px] border border-white/70 bg-white/90 p-5 shadow-[0_22px_50px_-34px_rgba(15,23,42,0.35)] sm:p-6">
      <div class="mb-5 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
          <h1 class="text-2xl font-semibold tracking-tight text-slate-900">Appointment Calendar</h1>
          <p class="mt-1 text-sm text-slate-500">Monthly calendar view with row and column layout for all appointments.</p>
        </div>
        <div class="flex items-center gap-2">
          <a href="appointments.php?month=<?= urlencode($prevMonth) ?>" class="inline-flex items-center rounded-xl border border-slate-200 px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">Prev</a>
          <span class="rounded-xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700"><?= htmlspecialchars($calendarMonthLabel, ENT_QUOTES, 'UTF-8') ?></span>
          <a href="appointments.php?month=<?= urlencode($nextMonth) ?>" class="inline-flex items-center rounded-xl border border-slate-200 px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">Next</a>
        </div>
      </div>

      <?php if ($calendarError !== ''): ?>
        <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700">
          <?= htmlspecialchars($calendarError, ENT_QUOTES, 'UTF-8') ?>
        </div>
      <?php endif; ?>

      <div class="overflow-x-auto">
        <table class="min-w-full table-fixed border-separate border-spacing-0 overflow-hidden rounded-2xl border border-slate-200">
          <thead>
            <tr class="bg-slate-50 text-left text-sm font-semibold text-slate-600">
              <?php foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $dayName): ?>
                <th class="border-b border-slate-200 px-3 py-3"><?= htmlspecialchars($dayName, ENT_QUOTES, 'UTF-8') ?></th>
              <?php endforeach; ?>
            </tr>
          </thead>
          <tbody>
            <?php
            $dayCounter = 1;
            for ($week = 0; $week < 6; $week++):
                $rowHasVisibleDay = false;
                ob_start();
                ?>
                <tr>
                  <?php for ($weekday = 0; $weekday < 7; $weekday++): ?>
                    <?php
                    $cellIndex = ($week * 7) + $weekday;
                    $isBeforeMonth = $cellIndex < $firstWeekday;
                    $isAfterMonth = $dayCounter > $totalDays;
                    ?>
                    <?php if ($isBeforeMonth || $isAfterMonth): ?>
                      <td class="h-40 align-top border-r border-b border-slate-100 bg-slate-50/70 px-2 py-2 last:border-r-0"></td>
                    <?php else: ?>
                      <?php $rowHasVisibleDay = true; ?>
                      <td class="h-40 align-top border-r border-b border-slate-100 bg-white px-2 py-2 last:border-r-0">
                        <div class="mb-2 flex items-center justify-between">
                          <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-slate-100 text-xs font-semibold text-slate-700"><?= $dayCounter ?></span>
                          <?php $count = count($appointmentsByDay[$dayCounter] ?? []); ?>
                          <?php if ($count > 0): ?>
                            <span class="text-[11px] font-medium text-slate-500"><?= $count ?> appt<?= $count > 1 ? 's' : '' ?></span>
                          <?php endif; ?>
                        </div>

                        <div class="space-y-1.5 overflow-y-auto pr-0.5" style="max-height:110px;">
                          <?php foreach (($appointmentsByDay[$dayCounter] ?? []) as $appointment): ?>
                            <?php
                              $status = (string) ($appointment['status'] ?? 'Pending');
                              $statusClass = $statusClasses[$status] ?? 'bg-slate-100 text-slate-700 ring-slate-200';
                              $appointmentPayload = htmlspecialchars(json_encode($appointment, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT), ENT_QUOTES, 'UTF-8');
                            ?>
                            <div class="rounded-lg px-2 py-1 ring-1 <?= htmlspecialchars($statusClass, ENT_QUOTES, 'UTF-8') ?>">
                              <p class="truncate text-[11px] font-semibold"><?= htmlspecialchars((string) ($appointment['purpose_of_visit'] ?: 'Appointment'), ENT_QUOTES, 'UTF-8') ?></p>
                              <p class="truncate text-[10px] opacity-80"><?= htmlspecialchars(date('h:i a', strtotime((string) $appointment['appointment_datetime'])), ENT_QUOTES, 'UTF-8') ?> • <?= htmlspecialchars((string) ($appointment['dentist'] ?: 'N/A'), ENT_QUOTES, 'UTF-8') ?></p>
                              <button type="button" class="open-appointment-view mt-1 inline-flex rounded-md bg-white/80 px-2 py-0.5 text-[10px] font-semibold text-slate-700 ring-1 ring-slate-300 hover:bg-white" data-appointment="<?= $appointmentPayload ?>">View</button>
                            </div>
                          <?php endforeach; ?>
                        </div>
                      </td>
                      <?php $dayCounter++; ?>
                    <?php endif; ?>
                  <?php endfor; ?>
                </tr>
                <?php
                $rowHtml = ob_get_clean();
                if ($rowHasVisibleDay) {
                    echo $rowHtml;
                }
                if ($dayCounter > $totalDays) {
                    break;
                }
            endfor;
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>

<div id="appointmentViewModal" class="fixed inset-0 z-[95] hidden items-center justify-center bg-slate-950/55 px-4">
  <div class="absolute inset-0" data-close-appointment-view></div>
  <div class="relative z-10 w-full max-w-2xl overflow-hidden rounded-[24px] bg-white shadow-2xl">
    <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
      <div>
        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-blue-600">Appointment</p>
        <h3 id="appointmentViewTitle" class="mt-1 text-xl font-semibold text-slate-900">Appointment Details</h3>
      </div>
      <button type="button" class="inline-flex h-10 w-10 items-center justify-center rounded-full text-slate-500 hover:bg-slate-100 hover:text-slate-700" data-close-appointment-view>
        <i data-feather="x" class="h-5 w-5"></i>
      </button>
    </div>
    <div class="space-y-4 px-5 py-5 text-sm text-slate-700">
      <div class="grid gap-3 sm:grid-cols-2">
        <p><span class="font-semibold text-slate-500">Appointment ID:</span> <span id="appointmentViewId">-</span></p>
        <p><span class="font-semibold text-slate-500">Patient:</span> <span id="appointmentViewPatient">-</span></p>
        <p><span class="font-semibold text-slate-500">Phone:</span> <span id="appointmentViewPhone">-</span></p>
        <p><span class="font-semibold text-slate-500">Date of Entry:</span> <span id="appointmentViewDateEntry">-</span></p>
        <p><span class="font-semibold text-slate-500">Date & Time:</span> <span id="appointmentViewDateTime">-</span></p>
        <p><span class="font-semibold text-slate-500">Dentist:</span> <span id="appointmentViewDentist">-</span></p>
        <p><span class="font-semibold text-slate-500">Status:</span> <span id="appointmentViewStatus">-</span></p>
        <p><span class="font-semibold text-slate-500">Priority:</span> <span id="appointmentViewPriority">-</span></p>
      </div>
      <div>
        <p class="font-semibold text-slate-500">Purpose of Visit</p>
        <p id="appointmentViewPurpose" class="mt-1 rounded-xl bg-slate-50 px-3 py-2">-</p>
      </div>
      <div>
        <p class="font-semibold text-slate-500">Appointment Notes</p>
        <p id="appointmentViewNotes" class="mt-1 rounded-xl bg-slate-50 px-3 py-2">-</p>
      </div>
      <div>
        <p class="font-semibold text-slate-500">Reason for Cancel</p>
        <p id="appointmentViewCancelReason" class="mt-1 rounded-xl bg-slate-50 px-3 py-2">-</p>
      </div>
    </div>
  </div>
</div>

<script>
  (function () {
    const viewModal = document.getElementById('appointmentViewModal');
    if (!viewModal) return;

    const fields = {
      title: document.getElementById('appointmentViewTitle'),
      id: document.getElementById('appointmentViewId'),
      patient: document.getElementById('appointmentViewPatient'),
      phone: document.getElementById('appointmentViewPhone'),
      dateEntry: document.getElementById('appointmentViewDateEntry'),
      dateTime: document.getElementById('appointmentViewDateTime'),
      dentist: document.getElementById('appointmentViewDentist'),
      status: document.getElementById('appointmentViewStatus'),
      priority: document.getElementById('appointmentViewPriority'),
      purpose: document.getElementById('appointmentViewPurpose'),
      notes: document.getElementById('appointmentViewNotes'),
      cancelReason: document.getElementById('appointmentViewCancelReason')
    };

    function fallback(value) {
      return value && String(value).trim() !== '' ? String(value) : '-';
    }

    function openViewModal(payload) {
      fields.title.textContent = fallback(payload.purpose_of_visit);
      fields.id.textContent = fallback(payload.appointment_id);
      fields.patient.textContent = fallback(payload.patient_name);
      fields.phone.textContent = fallback(payload.phone);
      fields.dateEntry.textContent = fallback(payload.date_of_entry);
      fields.dateTime.textContent = fallback(payload.appointment_datetime);
      fields.dentist.textContent = fallback(payload.dentist);
      fields.status.textContent = fallback(payload.status);
      fields.priority.textContent = fallback(payload.priority);
      fields.purpose.textContent = fallback(payload.purpose_of_visit);
      fields.notes.textContent = fallback(payload.appointment_notes);
      fields.cancelReason.textContent = fallback(payload.cancel_reason);

      viewModal.classList.remove('hidden');
      viewModal.classList.add('flex');
    }

    function closeViewModal() {
      viewModal.classList.add('hidden');
      viewModal.classList.remove('flex');
    }

    document.querySelectorAll('.open-appointment-view').forEach(button => {
      button.addEventListener('click', () => {
        const payload = JSON.parse(button.dataset.appointment || '{}');
        openViewModal(payload);
      });
    });

    viewModal.querySelectorAll('[data-close-appointment-view]').forEach(el => {
      el.addEventListener('click', closeViewModal);
    });

    document.addEventListener('keydown', event => {
      if (event.key === 'Escape') {
        closeViewModal();
      }
    });
  })();
</script>
