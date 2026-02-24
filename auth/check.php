<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// ยังไม่ได้ login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

// ไม่ใช่ admin ห้ามเข้า
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../pages/index.php");
    exit();
}
?>