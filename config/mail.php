<?php

return [
    // Set APP_TIMEZONE in your web server or task scheduler env. Example: Asia/Manila
    'timezone' => getenv('APP_TIMEZONE') ?: 'Asia/Manila',

    // Sender identity
    'from_email' => getenv('MAIL_FROM_ADDRESS') ?: 'von.graycode@gmail.com',
    'from_name' => getenv('MAIL_FROM_NAME') ?: 'Dentcoms Clinic',

    // SMTP settings
    'smtp_host' => getenv('MAIL_HOST') ?: 'smtp.gmail.com',
    'smtp_port' => (int) (getenv('MAIL_PORT') ?: 587),
    'smtp_username' => getenv('MAIL_USERNAME') ?: 'von.graycode@gmail.com',
    'smtp_password' => getenv('MAIL_PASSWORD') ?: 'wxjw prch jxgh pqxj',

    // tls, ssl, or empty string
    'smtp_encryption' => getenv('MAIL_ENCRYPTION') ?: 'tls',

    // true to use SMTP auth, false to send without auth
    'smtp_auth' => strtolower((string) (getenv('MAIL_SMTP_AUTH') ?: 'true')) === 'true',
];
