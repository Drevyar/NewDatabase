<?php
include('../php/config.php');
$result = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link rel="stylesheet" href="../allcss/style.css">
    <link rel="stylesheet" href="../allcss/productlist.css">
</head>

<body>

<div class="container">

    <!-- ปุ่ม Back สีเหลือง ขวาบน -->
    <div class="back-btn-wrapper">
        <a href="add_product.php" class="back-btn">Back</a>
    </div>

    <h1>Product List</h1>

    <div class="grid">
        <?php 
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) { 
        ?>
            <div class="card">

                <?php if (!empty($row['img'])) { ?>
                    <img src="<?= htmlspecialchars($row['img']) ?>" 
                         alt="<?= htmlspecialchars($row['productname']) ?>">
                <?php } else { ?>
                    <div class="no-image">No Image</div>
                <?php } ?>

                <h3><?= htmlspecialchars($row['productname']) ?></h3>
                <p><?= nl2br(htmlspecialchars($row['detail'])) ?></p>
                <span>฿<?= number_format($row['price'], 2) ?></span>

            </div>
        <?php 
            }
        } else {
            echo '<p class="no-products">No products available at the moment</p>';
        }
        ?>
    </div>
</div>

</body>
</html>
