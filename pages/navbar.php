<?php
$count = 0;
if(isset($_SESSION['cart']) && is_array($_SESSION['cart'])){
    foreach($_SESSION['cart'] as $qty){
        if(is_numeric($qty)){
            $count += $qty;
        }
    }
}
?>

<div class="sidebar">

    <a href="show_product.php" class="nav-icon">
        <i class="fa-solid fa-house"></i>
    </a>

    <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>

    <a href="manage_product.php" class="nav-icon">
        <i class="fa-solid fa-gear"></i>
    </a>

    <a href="add_product.php" class="nav-icon">
        <i class="fa-solid fa-plus"></i>
    </a>

    <a href="manage_users.php" class="nav-icon">
    <i class="fa-solid fa-users"></i>
    </a>

    <a href="manage_orders.php" class="nav-icon">
    <i class="fa-solid fa-receipt"></i>
    </a>

    <?php endif; ?>

    <a href="cart.php" class="cart-btn">
        <i class="fa-solid fa-cart-shopping"></i>

        <?php if($count > 0): ?>
            <span class="cart-badge"><?= $count ?></span>
        <?php endif; ?>
    </a>

    <a href="../auth/logout.php" class="nav-icon">
    <i class="fa-solid fa-right-from-bracket"></i>
</a>

</div>