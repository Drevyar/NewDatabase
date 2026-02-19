<?php
session_start();

if(isset($_GET['id'])){

    $id = (int)$_GET['id'];

    if(!isset($_SESSION['cart'])){
        $_SESSION['cart'] = [];
    }

    if(isset($_SESSION['cart'][$id])){
        $_SESSION['cart'][$id] += 1;
    }else{
        $_SESSION['cart'][$id] = 1;
    }
}

header("Location: ../pages/show_product.php");
exit();
