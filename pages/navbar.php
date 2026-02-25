<?php
$count = 0;
if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $qty) {
        if (is_numeric($qty)) {
            $count += $qty;
        }
    }
}

$currentSort = $_GET['sort'] ?? '';
$currentSearch = $_GET['search'] ?? '';
?>

<div class="sidebar">

    <!-- Home -->
    <a href="show_product.php" class="nav-icon" title="Home">
        <i class="fa-solid fa-house"></i>
    </a>

    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>

        <a href="manage_product.php" class="nav-icon" title="Manage Products">
            <i class="fa-solid fa-gear"></i>
        </a>

        <a href="add_product.php" class="nav-icon" title="Add Product">
            <i class="fa-solid fa-plus"></i>
        </a>

        <a href="manage_users.php" class="nav-icon" title="Manage Users">
            <i class="fa-solid fa-users"></i>
        </a>

        <a href="manage_orders.php" class="nav-icon" title="Manage Orders">
            <i class="fa-solid fa-receipt"></i>
        </a>

    <?php endif; ?>

    <!-- SORT -->
    <div class="nav-sort">
        <div class="nav-icon sort-toggle" title="Sort by Price">
            <i class="fa-solid fa-sliders"></i>
        </div>

        <div class="sort-dropdown">
            <a href="show_product.php?sort=high<?= !empty($currentSearch) ? '&search=' . urlencode($currentSearch) : '' ?>"
               class="<?= $currentSort === 'high' ? 'active' : '' ?>">
                Price: High → Low
            </a>

            <a href="show_product.php?sort=low<?= !empty($currentSearch) ? '&search=' . urlencode($currentSearch) : '' ?>"
               class="<?= $currentSort === 'low' ? 'active' : '' ?>">
                Price: Low → High
            </a>
        </div>
    </div>

    <!-- Cart -->
    <a href="cart.php" class="cart-btn" title="Cart">
        <i class="fa-solid fa-cart-shopping"></i>
        <?php if ($count > 0): ?>
            <span class="cart-badge"><?= $count ?></span>
        <?php endif; ?>
    </a>

    <!-- Logout -->
    <a href="../auth/logout.php" class="nav-icon" title="Logout">
        <i class="fa-solid fa-right-from-bracket"></i>
    </a>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sortToggle = document.querySelector('.sort-toggle');
    const sortDropdown = document.querySelector('.sort-dropdown');

    if (sortToggle && sortDropdown) {
        sortToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            sortDropdown.classList.toggle('active');
        });

        document.addEventListener('click', function(e) {
            if (!sortToggle.contains(e.target) && !sortDropdown.contains(e.target)) {
                sortDropdown.classList.remove('active');
            }
        });
    }
});
</script>