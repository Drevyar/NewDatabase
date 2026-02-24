<?php
session_start();
include('../php/config.php');

if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$cart = $_SESSION['cart'];

if(empty($cart)){
    die("Cart is empty");
}

$total = 0;

// คำนวณราคารวม
foreach($cart as $product_id => $qty){
    $result = mysqli_query($conn, "SELECT price FROM products WHERE ID=$product_id");
    $row = mysqli_fetch_assoc($result);
    $total += $row['price'] * $qty;
}

// บันทึกลง orders
mysqli_query($conn, "INSERT INTO orders (user_id, total_price, status, created_at) 
                     VALUES ($user_id, $total, 'pending', NOW())");

$order_id = mysqli_insert_id($conn);

// บันทึกลง order_items
foreach($cart as $product_id => $qty){
    $result = mysqli_query($conn, "SELECT price FROM products WHERE ID=$product_id");
    $row = mysqli_fetch_assoc($result);
    $price = $row['price'];

    mysqli_query($conn, "INSERT INTO order_items (order_id, product_id, quantity, price)
                         VALUES ($order_id, $product_id, $qty, $price)");
}

// ล้างตะกร้า
unset($_SESSION['cart']);

echo "<script>
alert('Order successful!');
window.location='../pages/show_product.php';
</script>";
?>