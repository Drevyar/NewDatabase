<?php
session_start();
include('../auth/check.php');
include('../php/config.php');

$search = "";
if(isset($_GET['search'])){
    $search = mysqli_real_escape_string($conn, $_GET['search']);
}

$sql = "SELECT * FROM users 
        WHERE name LIKE '%$search%' 
        OR email LIKE '%$search%'
        ORDER BY id DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Manage Users</title>

<link rel="stylesheet" href="../allcss/style.css">
<link rel="stylesheet" href="../allcss/manage_users.css">
<link rel="stylesheet" href="../allcss/components.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body>

<?php include('navbar.php'); ?>
<div class="dashboard-container">

<h1 class="page-title">Manage Users</h1>

<div class="top-bar">
    <a href="add_user.php" class="add-btn">
        + Add User
    </a>

    <form method="GET" class="search-form">
        <input type="text" name="search" placeholder="Search..." value="<?= htmlspecialchars($search) ?>">
        <button type="submit">Search</button>
    </form>
</div>

<div class="table-card">
<table>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Role</th>
        <th>Created</th>
        <th>Actions</th>
    </tr>

    <?php while($row = mysqli_fetch_assoc($result)): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td>
            <span class="role-badge <?= $row['role'] ?>">
                <?= $row['role'] ?>
            </span>
        </td>
        <td><?= $row['created_at'] ?></td>
        <td>
            <a href="edit_user.php?id=<?= $row['id'] ?>" class="edit-btn">Edit</a>
            <a href="delete_user.php?id=<?= $row['id'] ?>" class="delete-btn"
               onclick="return confirm('Delete this user?')">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
</div>

</div>

</body>
</html>