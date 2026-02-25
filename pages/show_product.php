<?php
session_start();
include('../auth/check_user.php');
include('../php/config.php');

/* ================= รับค่า ================= */
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$sort   = isset($_GET['sort']) ? $_GET['sort'] : '';

$sql = "SELECT * FROM products";
$params = [];
$types = "";

/* ================= SEARCH ================= */
if (!empty($search)) {
    $sql .= " WHERE productname LIKE ? OR detail LIKE ?";
    $like = "%".$search."%";
    $params[] = $like;
    $params[] = $like;
    $types .= "ss";
}

/* ================= SORT ================= */
if ($sort === "high") {
    $sql .= " ORDER BY price DESC";
} elseif ($sort === "low") {
    $sql .= " ORDER BY price ASC";
} else {
    $sql .= " ORDER BY ID DESC";
}

/* ================= EXECUTE ================= */
$stmt = mysqli_prepare($conn, $sql);
if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Product List</title>

<link rel="stylesheet" href="../allcss/components.css">
<link rel="stylesheet" href="../allcss/style.css">
<link rel="stylesheet" href="../allcss/productlist.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="product-list-page">

<div class="container">

<?php include('navbar.php'); ?>

<div class="page-top">
    <h1>Product List</h1>

    <!-- เหลือแค่ Search อย่างเดียว -->
    <form class="search-form" method="GET">
        <div class="search-box">
            <input type="text" 
                   name="search" 
                   placeholder="Search products..."
                   value="<?= htmlspecialchars($search) ?>">

            <?php if(!empty($sort)): ?>
                <input type="hidden" name="sort" value="<?= htmlspecialchars($sort) ?>">
            <?php endif; ?>

            <button type="submit">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </div>
    </form>
</div>

<div class="grid">
<?php if(mysqli_num_rows($result) > 0): ?>
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
            } else {
                echo '<div class="no-image">No Image</div>';
            }
            ?>

            <h3><?= htmlspecialchars($row['productname']) ?></h3>
            <p><?= nl2br(htmlspecialchars($row['detail'])) ?></p>
            <span class="price">฿<?= number_format($row['price'],2) ?></span>

            <div class="card-footer">
                <a href="../php/add_to_cart.php?id=<?= $row['ID'] ?>" class="cart-btn">
                    <i class="fa-solid fa-cart-plus"></i>
                </a>
            </div>

        </div>
    <?php } ?>
<?php else: ?>
    <p class="no-products">No products found.</p>
<?php endif; ?>
</div>

</div>
</body>
</html>