<?php
include '../php/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request method");
}

$productname = trim($_POST['productname'] ?? '');
$detail      = trim($_POST['detail'] ?? '');
$price       = floatval($_POST['price'] ?? 0);
$img         = '';

if (!empty($_FILES['img_upload']['name']) && $_FILES['img_upload']['error'] === UPLOAD_ERR_OK) {
    $targetDir = "../uploads/";

    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    $fileName = time() . "_" . basename($_FILES["img_upload"]["name"]);
    $targetFile = $targetDir . $fileName;

    $allowed = ['jpg','jpeg','png','gif','webp'];
    $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if (in_array($ext, $allowed) && move_uploaded_file($_FILES["img_upload"]["tmp_name"], $targetFile)) {
        $img = $fileName;
    } else {
        $img = trim($_POST['img_url'] ?? '');
    }
} else {
    $img = trim($_POST['img_url'] ?? '');
}

if (empty($productname) || empty($detail) || $price <= 0) {
    die("Please fill in all required fields");
}

$stmt = $conn->prepare("INSERT INTO products (productname, detail, price, img) VALUES (?, ?, ?, ?)"); // แก้ตามชื่อ database ไม่ใช่
$stmt->bind_param("ssds", $productname, $detail, $price, $img);

$stmt->execute();

$stmt->close();
$conn->close();

header("Location: ../pages/show_product.php");
exit;