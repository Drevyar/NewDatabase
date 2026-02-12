<?php
include('config.php');

$id     = $_POST['id'];
$name   = $_POST['productname'];
$detail = $_POST['detail'];
$price  = $_POST['price'];
$img    = $_POST['img'];   // รับ URL

$sql = "UPDATE products 
        SET productname='$name',
            detail='$detail',
            price='$price',
            img='$img'
        WHERE ID='$id'";

mysqli_query($conn, $sql);

header("Location: ../pages/manage_product.php");
exit;
