<?php
session_start();
include('../auth/check.php');
include('../php/config.php');

$search = "";

if (isset($_GET['search']) && $_GET['search'] != "") {

    $search = mysqli_real_escape_string($conn, $_GET['search']);

    $sql = "SELECT * FROM products 
            WHERE ID LIKE '%$search%' 
            OR productname LIKE '%$search%' 
            ORDER BY ID DESC";

} else {

    $sql = "SELECT * FROM products ORDER BY ID DESC";
}

$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Products</title>

    <link rel="stylesheet" href="../allcss/manage.css">
    <link rel="stylesheet" href="../allcss/components.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="container">

<?php include('navbar.php'); ?>

<h1 class="page-title">Manage Products</h1>

<div class="manage-header">
    <a href="add_product.php" class="btn-add">+ Add Product</a>

    <form method="GET" class="search-box">
        <input type="text" name="search" placeholder="Search..."
               value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
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
    <th style="text-align:center;">Actions</th>
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
        <div class="action-wrap">
            <a href="edit_product.php?id=<?= $row['ID'] ?>" class="btn-edit">Edit</a>
            <a href="../php/delete.php?id=<?= $row['ID'] ?>" 
               class="btn-delete"
               onclick="return confirm('Delete this product?')">Delete</a>
        </div>
    </td>
</tr>
<?php } ?>
</tbody>
</table>

</div>
</body>
</html>