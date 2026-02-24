<?php
session_start();
include('../auth/check_user.php');
include('../php/config.php');

$result = mysqli_query($conn, "SELECT * FROM products ORDER BY ID DESC");
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

<?php include('navbar.php'); ?>

<h1>Product List</h1>

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