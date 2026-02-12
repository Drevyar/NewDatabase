<?php
include('config.php');

$id = $_GET['id'];
mysqli_query($conn,"DELETE FROM products WHERE ID='$id'");

header("Location: ../pages/manage_product.php");
