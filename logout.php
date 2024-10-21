<?php
session_start();
session_destroy(); // Hapus semua session
header("Location: login.php"); // Redirect ke halaman login
exit();
?>
