<?php
session_start();
require 'config/conn.php';

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($password, $user['password_hash'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role_id'] = $user['role_id'];
    $_SESSION['name'] = $user['first_name'];

    // 🔥 ROLE-BASED REDIRECT
    if ($user['role_id'] == 1) {
        header("Location: admin/dashboard.php");
    } elseif ($user['role_id'] == 2) {
        header("Location: dentist/dashboard.php");
    } else {
        header("Location: index.html");
    }

    exit();
} else {
    header("Location: index.html?error=invalid");
    exit();
}
?>