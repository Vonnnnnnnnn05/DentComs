<?php
$patientCount = count($patients);
$encodedFormValues = htmlspecialchars(json_encode($formValues, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT), ENT_QUOTES, 'UTF-8');
?>
<style>
  .patient-modal {
    transition: opacity 220ms ease, visibility 220ms ease;
  }

  .patient-modal .patient-modal-panel {
    transition: opacity 240ms ease, transform 240ms cubic-bezier(0.22, 1, 0.36, 1);
  }
</style>

<section class="px-4 pb-8 pt-4 sm:px-6 lg:px-8 lg:pt-8">
  <div class="mx-auto max-w-7xl">
    <div class="mb-6 flex flex-col gap-4 rounded-[28px] bg-gradient-to-r from-[#0f172a] via-[#1d4ed8] to-[#38bdf8] px-5 py-6 text-white shadow-[0_24px_60px_-36px_rgba(15,23,42,0.75)] sm:px-7">
      <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
          <p class="text-sm font-medium text-white/75">Patient Registry</p>
          <h1 class="mt-2 text-2xl font-semibold tracking-tight sm:text-3xl">Patients directory</h1>
          <p class="mt-2 max-w-2xl text-sm text-white/80 sm:text-base">Responsive patient table with direct profile view, edit, delete, and map actions.</p>
        </div>
        <div class="flex flex-wrap gap-3">
          <div class="rounded-2xl bg-white/12 px-4 py-3 backdrop-blur">
            <p class="text-xs uppercase tracking-[0.18em] text-white/65">Records</p>
            <p class="mt-1 text-2xl font-semibold"><?= (int) $patientCount ?></p>
          </div>
          <button
            type="button"
            id="openPatientModal"
            class="inline-flex items-center justify-center rounded-2xl bg-white px-5 py-3 text-sm font-semibold text-slate-900 transition hover:bg-slate-100"
          >
            Add Patient
          </button>
        </div>
      </div>
    </div>

    <?php if ($successMessage !== ''): ?>
      <div class="mb-4 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
        <?= htmlspecialchars($successMessage, ENT_QUOTES, 'UTF-8') ?>
      </div>
    <?php endif; ?>

    <?php if ($errorMessage !== ''): ?>
      <div class="mb-4 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700">
        <?= htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8') ?>
      </div>
    <?php endif; ?>

    <div class="overflow-hidden rounded-[28px] bg-white shadow-[0_18px_40px_-32px_rgba(15,23,42,0.6)] ring-1 ring-slate-100">
      <div class="flex flex-col gap-3 border-b border-slate-100 px-5 py-5 sm:flex-row sm:items-center sm:justify-between">
        <div>
          <p class="text-sm font-semibold text-slate-900">Patients Table</p>
          <p class="mt-1 text-sm text-slate-500">Each record supports direct profile view, edit, delete, and map lookup from the stored home address.</p>
        </div>
      </div>

      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-100 text-left">
          <thead class="bg-slate-50">
            <tr class="text-xs uppercase tracking-[0.18em] text-slate-500">
              <th class="px-5 py-4 font-semibold">Patient</th>
              <th class="px-5 py-4 font-semibold">Registered</th>
              <th class="px-5 py-4 font-semibold">Birthday</th>
              <th class="px-5 py-4 font-semibold">Age</th>
              <th class="px-5 py-4 font-semibold">Sex</th>
              <th class="px-5 py-4 font-semibold">Mobile</th>
              <th class="px-5 py-4 font-semibold">Email</th>
              <th class="px-5 py-4 font-semibold">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100 bg-white text-sm text-slate-600">
            <?php if ($patientCount === 0): ?>
              <tr>
                <td colspan="8" class="px-5 py-10 text-center text-sm text-slate-400">No patient records yet. Use the Add Patient button to create one.</td>
              </tr>
            <?php else: ?>
              <?php foreach ($patients as $patient): ?>
                <?php
                $fullName = trim(($patient['first_name'] ?? '') . ' ' . ($patient['middle_name'] ?? '') . ' ' . ($patient['last_name'] ?? ''));
                $mapUrl = !empty($patient['home_address'])
                    ? 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode($patient['home_address'])
                    : '';
                $patientPayload = htmlspecialchars(json_encode($patient, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT), ENT_QUOTES, 'UTF-8');
                ?>
                <tr class="transition hover:bg-slate-50/80">
                  <td class="px-5 py-4">
                    <div class="min-w-[220px]">
                      <p class="font-semibold text-slate-900"><?= htmlspecialchars($fullName, ENT_QUOTES, 'UTF-8') ?></p>
                      <p class="mt-1 text-xs text-slate-400"><?= htmlspecialchars($patient['occupation'] ?: 'No occupation set', ENT_QUOTES, 'UTF-8') ?></p>
                    </div>
                  </td>
                  <td class="px-5 py-4"><?= htmlspecialchars($patient['date_registered'] ?: '-', ENT_QUOTES, 'UTF-8') ?></td>
                  <td class="px-5 py-4"><?= htmlspecialchars($patient['birthday'] ?: '-', ENT_QUOTES, 'UTF-8') ?></td>
                  <td class="px-5 py-4"><?= htmlspecialchars((string) ($patient['age'] ?? '-'), ENT_QUOTES, 'UTF-8') ?></td>
                  <td class="px-5 py-4"><?= htmlspecialchars($patient['sex'] ?: '-', ENT_QUOTES, 'UTF-8') ?></td>
                  <td class="px-5 py-4"><?= htmlspecialchars($patient['mobile_no'] ?: '-', ENT_QUOTES, 'UTF-8') ?></td>
                  <td class="px-5 py-4"><?= htmlspecialchars($patient['email'] ?: '-', ENT_QUOTES, 'UTF-8') ?></td>
                  <td class="px-5 py-4">
                    <div class="flex min-w-[210px] items-center gap-2">
                      <a
                        href="view_profile.php?id=<?= urlencode($patient['id']) ?>"
                        class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700"
                        title="View patient"
                      >
                        <i data-feather="eye" class="h-4 w-4"></i>
                      </a>
                      <button
                        type="button"
                        class="edit-patient-btn inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 text-slate-600 transition hover:border-amber-200 hover:bg-amber-50 hover:text-amber-700"
                        data-patient="<?= $patientPayload ?>"
                        title="Edit patient"
                      >
                        <i data-feather="edit-3" class="h-4 w-4"></i>
                      </button>
                      <?php if ($mapUrl !== ''): ?>
                        <a
                          href="<?= htmlspecialchars($mapUrl, ENT_QUOTES, 'UTF-8') ?>"
                          target="_blank"
                          rel="noopener noreferrer"
                          class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 text-slate-600 transition hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-700"
                          title="Open home address in map"
                        >
                          <i data-feather="map-pin" class="h-4 w-4"></i>
                        </a>
                      <?php else: ?>
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-100 bg-slate-50 text-slate-300" title="No home address">
                          <i data-feather="map-pin" class="h-4 w-4"></i>
                        </span>
                      <?php endif; ?>
                      <form method="POST" action="patients.php" onsubmit="return confirm('Delete this patient record?');">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="patient_id" value="<?= htmlspecialchars($patient['id'], ENT_QUOTES, 'UTF-8') ?>">
                        <button
                          type="submit"
                          class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 text-slate-600 transition hover:border-red-200 hover:bg-red-50 hover:text-red-700"
                          title="Delete patient"
                        >
                          <i data-feather="trash-2" class="h-4 w-4"></i>
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>

<div id="patientFormModal" class="patient-modal fixed inset-0 z-[70] hidden items-center justify-center bg-slate-950/55 px-4 opacity-0 invisible">
  <div class="absolute inset-0" data-close-patient-form-modal></div>
  <div class="patient-modal-panel relative max-h-[90vh] w-full max-w-5xl translate-y-4 scale-[0.98] overflow-y-auto rounded-[28px] bg-white p-5 opacity-0 shadow-2xl ring-1 ring-slate-200 sm:p-6">
    <button
      type="button"
      id="closePatientFormModal"
      class="absolute right-4 top-4 inline-flex h-10 w-10 items-center justify-center rounded-full text-slate-500 transition hover:bg-slate-100 hover:text-slate-700"
      aria-label="Close patient form modal"
    >
      <i data-feather="x" class="h-5 w-5"></i>
    </button>

    <div class="mb-6 pr-10">
      <p id="patientFormEyebrow" class="text-sm font-semibold uppercase tracking-[0.18em] text-blue-600">Add Patient</p>
      <h2 id="patientFormTitle" class="mt-2 text-2xl font-semibold tracking-tight text-slate-900">Create patient record</h2>
      <p class="mt-2 text-sm text-slate-500">Patient ID is generated automatically. Uploading a new photo on edit will replace the old one.</p>
    </div>

    <form id="patientForm" method="POST" action="patients.php" enctype="multipart/form-data" class="space-y-6">
      <input type="hidden" name="action" id="patientFormAction" value="create">
      <input type="hidden" name="patient_id" id="patient_id">

      <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
        <div>
          <label for="date_registered" class="mb-2 block text-sm font-semibold text-slate-700">Date Registered</label>
          <input id="date_registered" name="date_registered" type="date" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm text-slate-800 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
        </div>
        <div>
          <label for="title" class="mb-2 block text-sm font-semibold text-slate-700">Title</label>
          <input id="title" name="title" type="text" placeholder="Mr / Ms / Dr" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm text-slate-800 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
        </div>
        <div>
          <label for="first_name" class="mb-2 block text-sm font-semibold text-slate-700">First Name</label>
          <input id="first_name" name="first_name" type="text" required class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm text-slate-800 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
        </div>
        <div>
          <label for="middle_name" class="mb-2 block text-sm font-semibold text-slate-700">Middle Name</label>
          <input id="middle_name" name="middle_name" type="text" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm text-slate-800 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
        </div>
        <div>
          <label for="last_name" class="mb-2 block text-sm font-semibold text-slate-700">Last Name</label>
          <input id="last_name" name="last_name" type="text" required class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm text-slate-800 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
        </div>
        <div>
          <label for="nickname" class="mb-2 block text-sm font-semibold text-slate-700">Nickname</label>
          <input id="nickname" name="nickname" type="text" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm text-slate-800 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
        </div>
        <div>
          <label for="birthday" class="mb-2 block text-sm font-semibold text-slate-700">Birthday</label>
          <input id="birthday" name="birthday" type="date" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm text-slate-800 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
        </div>
        <div>
          <label for="sex" class="mb-2 block text-sm font-semibold text-slate-700">Sex</label>
          <select id="sex" name="sex" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm text-slate-800 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
            <option value="">Select</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
        </div>
        <div>
          <label for="nationality" class="mb-2 block text-sm font-semibold text-slate-700">Nationality</label>
          <input id="nationality" name="nationality" type="text" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm text-slate-800 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
        </div>
        <div>
          <label for="occupation" class="mb-2 block text-sm font-semibold text-slate-700">Occupation</label>
          <input id="occupation" name="occupation" type="text" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm text-slate-800 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
        </div>
        <div>
          <label for="mobile_no" class="mb-2 block text-sm font-semibold text-slate-700">Mobile No</label>
          <input id="mobile_no" name="mobile_no" type="text" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm text-slate-800 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
        </div>
        <div>
          <label for="home_phone" class="mb-2 block text-sm font-semibold text-slate-700">Home Phone</label>
          <input id="home_phone" name="home_phone" type="text" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm text-slate-800 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
        </div>
        <div class="sm:col-span-2 xl:col-span-2">
          <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Email</label>
          <input id="email" name="email" type="email" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm text-slate-800 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
        </div>
        <div class="sm:col-span-2 xl:col-span-3">
          <label for="home_address" class="mb-2 block text-sm font-semibold text-slate-700">Home Address</label>
          <textarea id="home_address" name="home_address" rows="3" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm text-slate-800 focus:border-blue-500 focus:ring-2 focus:ring-blue-100"></textarea>
        </div>
        <div class="sm:col-span-2 xl:col-span-3">
          <label for="office_address" class="mb-2 block text-sm font-semibold text-slate-700">Office Address</label>
          <textarea id="office_address" name="office_address" rows="3" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm text-slate-800 focus:border-blue-500 focus:ring-2 focus:ring-blue-100"></textarea>
        </div>
        <div class="sm:col-span-2 xl:col-span-3">
          <label for="photo" class="mb-2 block text-sm font-semibold text-slate-700">Patient Photo</label>
          <input id="photo" name="photo" type="file" accept=".jpg,.jpeg,.png,.gif,.webp,image/*" class="block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 file:mr-4 file:rounded-xl file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:font-semibold file:text-blue-700 hover:file:bg-blue-100 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
          <p id="patientPhotoHelper" class="mt-2 text-xs text-slate-400">Accepted files: JPG, PNG, GIF, WEBP.</p>
        </div>
      </div>

      <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">
        <button type="button" id="cancelPatientFormModal" class="rounded-2xl border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
          Cancel
        </button>
        <button type="submit" id="patientFormSubmit" class="rounded-2xl bg-blue-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-800">
          Save Patient
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  (function() {
    const formModal = document.getElementById('patientFormModal');
    const formModalPanel = formModal?.querySelector('.patient-modal-panel');
    const openPatientModalBtn = document.getElementById('openPatientModal');
    const closePatientFormModalBtn = document.getElementById('closePatientFormModal');
    const cancelPatientFormModalBtn = document.getElementById('cancelPatientFormModal');
    const patientForm = document.getElementById('patientForm');
    const patientFormAction = document.getElementById('patientFormAction');
    const patientIdField = document.getElementById('patient_id');
    const patientFormEyebrow = document.getElementById('patientFormEyebrow');
    const patientFormTitle = document.getElementById('patientFormTitle');
    const patientFormSubmit = document.getElementById('patientFormSubmit');
    const patientPhotoHelper = document.getElementById('patientPhotoHelper');
    const editButtons = document.querySelectorAll('.edit-patient-btn');
    let isFormModalClosing = false;

    function openModal(modal, panel) {
      if (!modal) return;
      modal.classList.remove('hidden');
      modal.classList.add('flex');
      document.body.classList.add('overflow-hidden');
      requestAnimationFrame(() => {
        modal.classList.remove('opacity-0', 'invisible');
        panel?.classList.remove('translate-y-4', 'scale-[0.98]', 'opacity-0');
      });
    }

    function closeModal(modal, panel, setFlag) {
      if (!modal || modal.classList.contains('hidden')) return;
      setFlag(true);
      modal.classList.add('opacity-0', 'invisible');
      panel?.classList.add('translate-y-4', 'scale-[0.98]', 'opacity-0');
      setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.classList.remove('overflow-hidden');
        setFlag(false);
      }, 240);
    }

    function setFieldValue(id, value) {
      const field = document.getElementById(id);
      if (field) {
        field.value = value || '';
      }
    }

    function resetPatientForm() {
      patientForm.reset();
      patientFormAction.value = 'create';
      patientIdField.value = '';
      patientFormEyebrow.textContent = 'Add Patient';
      patientFormTitle.textContent = 'Create patient record';
      patientFormSubmit.textContent = 'Save Patient';
      patientPhotoHelper.textContent = 'Accepted files: JPG, PNG, GIF, WEBP.';
    }

    function openCreatePatientForm() {
      resetPatientForm();
      openModal(formModal, formModalPanel);
    }

    function openEditPatientForm(patient) {
      resetPatientForm();
      patientFormAction.value = 'update';
      patientIdField.value = patient.id || '';
      patientFormEyebrow.textContent = 'Edit Patient';
      patientFormTitle.textContent = 'Update patient record';
      patientFormSubmit.textContent = 'Save Changes';
      patientPhotoHelper.textContent = patient.photo ? 'Upload a new photo only if you want to replace the current one.' : 'Accepted files: JPG, PNG, GIF, WEBP.';

      setFieldValue('date_registered', patient.date_registered);
      setFieldValue('title', patient.title);
      setFieldValue('first_name', patient.first_name);
      setFieldValue('middle_name', patient.middle_name);
      setFieldValue('last_name', patient.last_name);
      setFieldValue('nickname', patient.nickname);
      setFieldValue('birthday', patient.birthday);
      setFieldValue('sex', patient.sex);
      setFieldValue('nationality', patient.nationality);
      setFieldValue('occupation', patient.occupation);
      setFieldValue('home_address', patient.home_address);
      setFieldValue('office_address', patient.office_address);
      setFieldValue('home_phone', patient.home_phone);
      setFieldValue('mobile_no', patient.mobile_no);
      setFieldValue('email', patient.email);

      openModal(formModal, formModalPanel);
    }

    openPatientModalBtn?.addEventListener('click', openCreatePatientForm);
    closePatientFormModalBtn?.addEventListener('click', () => closeModal(formModal, formModalPanel, value => { isFormModalClosing = value; }));
    cancelPatientFormModalBtn?.addEventListener('click', () => closeModal(formModal, formModalPanel, value => { isFormModalClosing = value; }));

    formModal?.querySelectorAll('[data-close-patient-form-modal]').forEach(element => {
      element.addEventListener('click', () => closeModal(formModal, formModalPanel, value => { isFormModalClosing = value; }));
    });

    editButtons.forEach(button => {
      button.addEventListener('click', () => {
        const patient = JSON.parse(button.dataset.patient || '{}');
        openEditPatientForm(patient);
      });
    });

    document.addEventListener('keydown', (event) => {
      if (event.key === 'Escape' && formModal && !formModal.classList.contains('hidden') && !isFormModalClosing) {
        closeModal(formModal, formModalPanel, value => { isFormModalClosing = value; });
      }
    });

    const activeModal = <?= json_encode($activeModal) ?>;
    const formMode = <?= json_encode($formMode) ?>;
    const formValues = JSON.parse('<?= $encodedFormValues ?>');

    if (activeModal === 'form') {
      if (formMode === 'edit') {
        openEditPatientForm(formValues);
      } else {
        openCreatePatientForm();
        Object.entries(formValues).forEach(([key, value]) => {
          setFieldValue(key, value);
        });
      }
    }
  })();
</script>
