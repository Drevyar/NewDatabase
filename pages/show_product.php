<?php
session_start();
include('../php/config.php');

// ใช้ ID ตัวใหญ่ให้ตรงกับ DB
$result = mysqli_query($conn, "SELECT * FROM products ORDER BY ID DESC");

// นับจำนวนสินค้าใน cart แบบปลอดภัย
$count = 0;
if(isset($_SESSION['cart']) && is_array($_SESSION['cart'])){
    foreach($_SESSION['cart'] as $qty){
        if(is_numeric($qty)){
            $count += $qty;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Product List</title>

<link rel="stylesheet" href="../allcss/style.css">
<link rel="stylesheet" href="../allcss/productlist.css">
<link rel="stylesheet" href="../allcss/components.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body>
<div class="container">

<!-- ===== HEADER BAR ===== -->
<div class="top-bar">
    <h1>Product List</h1>

    <a href="cart.php" class="cart-btn">
        <i class="fa-solid fa-cart-shopping"></i>
        <?php if($count > 0): ?>
            <span class="cart-badge"><?= $count ?></span>
        <?php endif; ?>
    </a>
</div>

<!-- ===== PRODUCT GRID ===== -->
<div class="grid">
<?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <div class="card">

        <?php
        $img = $row['img'];
        if (!empty($img)) {
            if (filter_var($img, FILTER_VALIDATE_URL)) {
                echo '<img src="'.htmlspecialchars($img).'">';
            } else {
                echo '<img src="../uploads/'.htmlspecialchars($img).'">';
            }
        }
        ?>

        <h3><?= htmlspecialchars($row['productname']) ?></h3>
        <p><?= nl2br(htmlspecialchars($row['detail'])) ?></p>
        <span class="price">฿<?= number_format($row['price'],2) ?></span>

        <!-- ปุ่มเพิ่มตะกร้า -->
        <div class="card-footer">
            <a href="../php/add_to_cart.php?id=<?= $row['ID'] ?>" class="cart-btn">
                <i class="fa-solid fa-cart-plus"></i>
            </a>
        </div>

    </div>
<?php } ?>
</div>

</div>
</body>
</html>
