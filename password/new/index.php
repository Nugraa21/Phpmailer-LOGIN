<?php
include '.../API/config.php';
$message = '';

if (isset($_GET['email'])) {
    $email = $_GET['email'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

        // Update password di database
        $sql = "UPDATE users SET password='$new_password', otp_code=NULL, otp_expiry=NULL WHERE email='$email'";
        if ($conn->query($sql) === TRUE) {
            $message = "Password berhasil diubah. Silakan login.";
            header("Location: login.php");
            exit();
        } else {
            $message = "Error: " . $conn->error;
        }
    }
} else {
    $message = "Email tidak ditemukan!";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href=".../assets/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Reset Password</h2>
        <form action="index.php" method="POST">
            <div class="form-group">
                <label for="new_password">Password Baru:</label>
                <input type="password" name="new_password" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn">Reset Password</button>
            </div>
            <?php if (!empty($message)): ?>
                <div class="message"><?php echo $message; ?></div>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
