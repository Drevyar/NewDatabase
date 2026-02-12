<?php
include('../php/config.php');

$id = $_GET['id'];
$result = mysqli_query($conn,"SELECT * FROM products WHERE ID='$id'");
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Edit Product</title>

<link rel="stylesheet" href="../allcss/style.css">
<link rel="stylesheet" href="../allcss/edit.css">

</head>

<body>

<div class="container">

    <h1>Edit Product</h1>

    <form action="../php/update.php" method="POST">

        <input type="hidden" name="id" value="<?= $row['ID'] ?>">

        <div class="form-grid">

            <div class="form-group">
                <label>Product Name</label>
                <input type="text" name="productname"
                       value="<?= htmlspecialchars($row['productname']) ?>">
            </div>

            <div class="form-group">
                <label>Detail</label>
                <input type="text" name="detail"
                       value="<?= htmlspecialchars($row['detail']) ?>">
            </div>

            <div class="form-group">
                <label>Price</label>
                <input type="number" step="0.01" name="price"
                       value="<?= $row['price'] ?>">
            </div>

            <div class="form-group">
                <label>Image Address (URL)</label>
                <input type="text"
                       name="img"
                       id="imgInput"
                       value="<?= htmlspecialchars($row['img']) ?>"
                       placeholder="https://example.com/image.jpg"
                       oninput="previewImage()">
            </div>

        </div>

        <div class="image-box">
            <img id="previewImg"
                 src="<?= htmlspecialchars($row['img']) ?>"
                 onerror="this.style.display='none'">
        </div>

        <div class="btn-box">
            <button type="submit" class="btn-update">Update</button>
            <a href="manage_product.php" class="btn-back">Back</a>
        </div>

    </form>

</div>

<script>
function previewImage() {
    const input = document.getElementById("imgInput");
    const img = document.getElementById("previewImg");

    if (input.value.trim() !== "") {
        img.src = input.value;
        img.style.display = "block";
    } else {
        img.style.display = "none";
    }
}
</script>

</body>
</html>
