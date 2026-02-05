<?php
$host = "localhost";
$user = "std6730202050";
$pass = "Pz!4jv9Y";
$db   = "it_std6730202050";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>