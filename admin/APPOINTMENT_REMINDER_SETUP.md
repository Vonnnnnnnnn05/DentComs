# Appointment Email Reminder Setup

This project now supports day-before appointment reminders using:
- `patients.email`
- `appointments.appointment_datetime`

## 1. Apply reminder log table

Run this SQL once:

```sql
SOURCE admin/sql/appointment_reminders.sql;
```

If your SQL client does not support `SOURCE`, copy and execute the SQL in:
- `admin/sql/appointment_reminders.sql`

## 2. Configure SMTP credentials

Update environment variables (recommended) used by `config/mail.php`:

- `APP_TIMEZONE` (example: `Asia/Manila`)
- `MAIL_FROM_ADDRESS`
- `MAIL_FROM_NAME`
- `MAIL_HOST`
- `MAIL_PORT`
- `MAIL_USERNAME`
- `MAIL_PASSWORD`
- `MAIL_ENCRYPTION` (`tls` or `ssl`)
- `MAIL_SMTP_AUTH` (`true` or `false`)

## 3. Test without sending

```bash
php admin/scripts/send_appointment_reminders.php --dry-run
```

## 4. Run for a specific date (optional)

```bash
php admin/scripts/send_appointment_reminders.php --target-date=2026-03-29 --dry-run
```

## 5. Send for both today and tomorrow

Dry-run:

```bash
php admin/scripts/send_appointment_reminders.php --include-today --dry-run
```

Live send:

```bash
php admin/scripts/send_appointment_reminders.php --include-today
```

## 6. Send reminders now

```bash
php admin/scripts/send_appointment_reminders.php
```

## 7. Schedule daily on Windows Task Scheduler

Use this action command (run once per day, e.g., 8:00 AM):

Program/script:

```text
C:\xampp\php\php.exe
```

Add arguments:

```text
C:\xampp\htdocs\dentcoms\admin\scripts\send_appointment_reminders.php --include-today
```

Start in:

```text
C:\xampp\htdocs\dentcoms
```

## Behavior Notes

- Sends reminders only for appointments on the target date (tomorrow by default).
- With `--include-today`, it sends both `same_day` (today) and `day_before` (tomorrow) reminders in one run.
- Skips appointments with status outside `Pending`, `Confirmed`, `Rescheduled`.
- Skips rows with empty `patients.email`.
- Prevents duplicate sends by recording successful sends in `appointment_reminder_logs`.
