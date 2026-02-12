<?php
include('../php/config.php');
$result = mysqli_query($conn, "SELECT * FROM products ORDER BY ID DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Products</title>
<link rel="stylesheet" href="../allcss/style.css">
<link rel="stylesheet" href="../allcss/manage.css">
</head>

<body>
<div class="container">

<h1>Manage Products</h1>

<div class="manage-header">
    <a href="add_product.php" class="btn-add">+ Add Product</a>

    <form method="GET" class="search-box">
        <input type="text" name="search" placeholder="Search...">
        <button type="submit">Search</button>
    </form>
</div>

<table class="manage-table">
<thead>
<tr>
    <th>ID</th>
    <th>Image</th>
    <th>Product Name</th>
    <th>Detail</th>
    <th>Price</th>
    <th>Actions</th>
</tr>
</thead>

<tbody>
<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
    <td><?= $row['ID'] ?></td>

    <td>
        <?php
        $img = $row['img'];
        if (!empty($img)) {
            if (filter_var($img, FILTER_VALIDATE_URL)) {
                echo '<img src="'.htmlspecialchars($img).'" class="manage-img">';
            } else {
                echo '<img src="../uploads/'.htmlspecialchars($img).'" class="manage-img">';
            }
        }
        ?>
    </td>

    <td><?= htmlspecialchars($row['productname']) ?></td>
    <td><?= htmlspecialchars($row['detail']) ?></td>
    <td>฿<?= number_format($row['price'],2) ?></td>

    <td>
        <a href="edit_product.php?id=<?= $row['ID'] ?>" class="btn-edit">Edit</a>
        <a href="../php/delete.php?id=<?= $row['ID'] ?>" class="btn-delete"
           onclick="return confirm('Delete this product?')">Delete</a>
    </td>
</tr>
<?php } ?>
</tbody>
</table>

</div>
</body>
</html>
