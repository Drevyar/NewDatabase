<?php
session_start();
include('../auth/check_user.php');
include('../php/config.php'); 
$total = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart</title>
    <link rel="stylesheet" href="../allcss/style.css">
    <link rel="stylesheet" href="../allcss/components.css">
    <link rel="stylesheet" href="../allcss/cart.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="container">
    <?php include('navbar.php'); ?>

    <h2 class="cart-title">Your Cart</h2>

    <?php if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
        <div class="cart-wrapper">
            <?php foreach($_SESSION['cart'] as $id => $qty): 
                $id = (int)$id;
                $qty = (int)$qty;

                $sql = "SELECT * FROM products WHERE ID = $id";
                $result = mysqli_query($conn, $sql);
                if(!$result) die(mysqli_error($conn));

                $row = mysqli_fetch_assoc($result);
                if(!$row) continue;

                $subtotal = $row['price'] * $qty;
                $total += $subtotal;
            ?>
                <div class="cart-item">
                    <div class="cart-img-wrapper">
                        <?php 
                        $img_url = $row['img'] ?? '';
                        if(!empty($img_url) && filter_var($img_url, FILTER_VALIDATE_URL)): ?>
                            <img src="<?= htmlspecialchars($img_url) ?>" alt="<?= htmlspecialchars($row['productname']) ?>" class="cart-img" onerror="this.src='https://via.placeholder.com/90?text=Image+Error';">
                        <?php else: ?>
                            <div class="no-image-cart">No Image</div>
                        <?php endif; ?>
                    </div>

                    <div class="cart-details">
                        <h3><?= htmlspecialchars($row['productname']) ?></h3>
                        <p class="quantity">Quantity: <?= $qty ?></p>
                        <p class="price-item">฿<?= number_format($row['price'], 2) ?></p>
                    </div>

                    <div class="cart-subtotal">
                        ฿<?= number_format($subtotal, 2) ?>
                    </div>

                    <a class="remove-btn" href="../php/remove_cart.php?id=<?= $id ?>" title="Remove item">
                        <i class="fa-solid fa-trash-can"></i>
                    </a>
                </div>
            <?php endforeach; ?>

            <div class="cart-total">
                <span>Total:</span>
                <strong>฿<?= number_format($total, 2) ?></strong>
            </div>

            <div class="cart-actions">
                <a href="checkout.php" class="btn-checkout">Proceed to Checkout</a>
            </div>
        </div>
    <?php else: ?>
        <p class="empty-cart">Your cart is empty 🐱</p>
    <?php endif; ?>
</div>

</body>
</html>