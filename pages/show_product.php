<?php
include('../php/config.php');
$result = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Product List</title>
<link rel="stylesheet" href="../allcss/style.css">
<link rel="stylesheet" href="../allcss/productlist.css">
<link rel="stylesheet" href="../allcss/manage.css">
</head>

<body>
<div class="container">

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
        <span>฿<?= number_format($row['price'],2) ?></span>

    </div>
<?php } ?>
</div>

</div>
</body>
</html>
