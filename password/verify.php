<?php
include '../API/config.php'; // Perbaiki path jika salah
$message = '';

if (isset($_GET['email'])) {
    $email = $_GET['email'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $otpInput = $_POST['otp'];

        // Cek OTP dari database
        $stmt = $conn->prepare("SELECT * FROM users WHERE email=? AND otp_code=? AND otp_expiry > NOW()");
        $stmt->bind_param("ss", $email, $otpInput);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // OTP valid, redirect ke halaman reset password
            header("Location: new.php?email=" . urlencode($email));
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
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Verifikasi OTP</h2>
        <form action="verify.php?email=<?php echo urlencode($email); ?>" method="POST">
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
