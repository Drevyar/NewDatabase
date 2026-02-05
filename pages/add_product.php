<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product</title>
    <link rel="stylesheet" href="../allcss/style.css">
    <link rel="stylesheet" href="../allcss/addproduct.css">
</head>
<body>

<div class="container">
    <h1>Add New Product</h1>

    <form method="POST" action="../php/create.php" enctype="multipart/form-data">
        <div class="form-group">
            <label>Product Name *</label>
            <input type="text" name="productname" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Product Detail *</label>
            <textarea name="detail" class="form-control" required></textarea>
        </div>

        <div class="form-group">
            <label>Price *</label>
            <input type="number" name="price" class="form-control" step="0.01" required>
        </div>

        <div class="form-group">
            <label>Image URL</label>
            <input type="url" name="img_url" class="form-control">
        </div>

        <div class="form-group">
            <label>Upload Image</label>
            <input type="file" name="img_upload" class="form-control">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">Create Product</button>
        </div>
    </form>
</div>

</body>
</html>