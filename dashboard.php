<?php
session_start();
if (!isset($_SESSION['otp'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Selamat datang di Dashboard</h2>
        <p>Anda telah berhasil login dan memverifikasi akun Anda!</p>
        <a href="logout.php" class="btn">Logout</a>
    </div>
</body>
</html>
