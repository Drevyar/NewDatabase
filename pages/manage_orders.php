<?php
session_start();
require '../php/config.php';
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Manage Orders</title>
    <link rel="stylesheet" href="../allcss/manage_orders.css">
    <link rel="stylesheet" href="../allcss/style.css">
    <link rel="stylesheet" href="../allcss/components.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<?php include('navbar.php'); ?>

<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

$sql = "SELECT 
            orders.id AS order_id,
            COALESCE(users.name, 'Unknown User') AS user_name,
            GROUP_CONCAT(CONCAT(products.productname, ' (x', order_items.quantity, ')') SEPARATOR '<br>') AS products_list,
            SUM(order_items.quantity) AS total_qty,
            SUM(order_items.price * order_items.quantity) AS total_price,
            orders.status,
            orders.created_at
        FROM orders
        LEFT JOIN users ON orders.user_id = users.id
        JOIN order_items ON orders.id = order_items.order_id
        JOIN products ON order_items.product_id = products.ID
        GROUP BY orders.id
        ORDER BY orders.id DESC";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
}
?>

<div class="dashboard-container">
    <h2 class="page-title">Manage Orders</h2>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <div class="table-card">
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>User</th>
                        <th>Products</th>
                        <th>Total Qty</th>
                        <th>Total Price</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td>#<?= htmlspecialchars($row['order_id']) ?></td>
                            <td><?= htmlspecialchars($row['user_name']) ?></td>
                            <td><?= $row['products_list'] ?></td>
                            <td><?= htmlspecialchars($row['total_qty']) ?></td>
                            <td>฿<?= number_format($row['total_price'], 2) ?></td>
                            <td>
                                <span class="status-badge <?= strtolower($row['status']) ?>">
                                    <?= ucfirst(htmlspecialchars($row['status'])) ?>
                                </span>
                            </td>
                            <td><?= date('d M Y H:i', strtotime($row['created_at'])) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="no-data">
            <p>No orders found in the system.</p>
        </div>
    <?php endif; ?>
</div>

</body>
</html>