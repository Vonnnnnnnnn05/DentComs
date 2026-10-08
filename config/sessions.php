<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ✅ Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    $redirectPath = file_exists('index.php') ? 'index.php' : '../index.php';
    header("Location: {$redirectPath}");
    exit();
}
?>