<?php
session_start();
include('../php/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name     = trim($_POST['name']);
    $password = trim($_POST['password']);
    $email    = trim($_POST['email']);
    $phone    = trim($_POST['phone']);

    if (!empty($name) && !empty($password) && !empty($email) && !empty($phone)) {

        $check = $conn->prepare("SELECT id FROM users WHERE name = ? OR email = ?");
        $check->bind_param("ss", $name, $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $error = "Username or Email already exists!";
        } else {

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO users (name, password, email, phone, role) VALUES (?, ?, ?, ?, 'user')");
            $stmt->bind_param("ssss", $name, $hashedPassword, $email, $phone);
            $stmt->execute();
            $stmt->close();

            header("Location: login.php");
            exit();
        }

        $check->close();
    } else {
        $error = "Please fill all fields.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Register</title>
<link rel="stylesheet" href="../allcss/login.css">
</head>
<body>

<div class="login-box">
    <h2>Register</h2>

    <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>

    <form method="POST">
        <input type="text" name="name" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="phone" placeholder="Phone" required>
        <button type="submit">Create Account</button>
    </form>

    <div style="margin-top:15px;">
        <a href="login.php" class="register-link">Back to Login</a>
    </div>
</div>

</body>
</html>