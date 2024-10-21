<?php
include '.../API/config.php';
$message = '';

if (isset($_GET['email'])) {
    $email = $_GET['email'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $otpInput = $_POST['otp'];

        // Cek OTP dari database
        $sql = "SELECT * FROM users WHERE email='$email' AND otp_code='$otpInput' AND otp_expiry > NOW()";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // OTP valid, redirect ke halaman reset password
            header("Location: reset_password.php?email=$email");
            exit();
        } else {
            $message = "OTP tidak valid atau sudah kedaluwarsa.";
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
    <title>Verifikasi OTP</title>
    <link rel="stylesheet" href=".../assets/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Verifikasi OTP</h2>
        <form action="index.php" method="POST">
            <div class="form-group">
                <label for="otp">Masukkan OTP:</label>
                <input type="text" name="otp" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn">Verifikasi OTP</button>
            </div>
            <?php if (!empty($message)): ?>
                <div class="message"><?php echo $message; ?></div>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
