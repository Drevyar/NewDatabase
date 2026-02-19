<?php
session_start();
include('../php/config.php');
$total = 0;
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Your Cart</title>
<link rel="stylesheet" href="../allcss/style.css">
</head>
<body>

<div class="container">
<h2>Your Cart</h2>

<?php
if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0){

    foreach($_SESSION['cart'] as $id => $qty){

        $id = (int)$id; // กัน error
        $qty = (int)$qty;

        $sql = "SELECT * FROM products WHERE ID = $id";
        $result = mysqli_query($conn,$sql);

        if(!$result){
            die(mysqli_error($conn));
        }

        $row = mysqli_fetch_assoc($result);

        if(!$row){
            continue; // ถ้า ID ไม่มีใน DB ข้าม
        }

        $subtotal = $row['price'] * $qty;
        $total += $subtotal;
?>
        <p>
            <?= htmlspecialchars($row['productname']) ?>
            - <?= $qty ?> ชิ้น
            - ฿<?= number_format($subtotal,2) ?>
            <a href="../php/remove_cart.php?id=<?= $id ?>">ลบ</a>
        </p>
<?php
    }

    echo "<h3>Total: ฿".number_format($total,2)."</h3>";

}else{
    echo "<p>ไม่มีสินค้าในตะกร้า</p>";
}
?>

<br>
<a href="show_product.php">← กลับไปหน้าสินค้า</a>

</div>
</body>
</html>
