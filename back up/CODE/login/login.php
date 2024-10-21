<?php
session_start();
include 'config.php';
require 'vendor/autoload.php'; // Pastikan PHPMailer terinstall

$error_message = ''; // Tambahkan variabel ini

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Ambil data pengguna dari database
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        // Mengirim OTP
        $otp = rand(100000, 999999);
        $_SESSION['otp'] = $otp;

        // Kirim email dengan OTP
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // SMTP server
        $mail->SMTPAuth = true; // Mengaktifkan autentikasi SMTP
        $mail->Username = 'nugra315@gmail.com'; // Email Anda
        $mail->Password = 'xmxb hxtz daym biru'; // Password email Anda
        $mail->SMTPSecure = 'tls'; // Gunakan 'ssl' jika menggunakan port 465
        $mail->Port = 587; // Port untuk TLS

        $mail->setFrom('Ludang Prasetyo Nugroho', 'Nugra21'); // Format pengirim
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Code OTP N21.WERE';
        $mail->Body = "Code verivikasi anda adalah: $otp";

        if ($mail->send()) {
            header("Location: verify.php");
            exit();
        } else {
            echo "Pesan tidak dapat dikirim. Mailer Error: " . $mail->ErrorInfo;
        }
    } else {
        $error_message = "Email atau password salah!"; // Ubah ini
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="Dasbord/assets/media/icon.png">
</head>
<body>
    <div class="container">
    <div class="login-logo">
            <div>
                <img width="50px" height="50px" src="Dasbord/assets/media/icon.png" alt="">
            </div>
            <div>
                <b>Nugra </b>DEV
            </div>
        </div>
        <form action="login.php" method="POST">
            <h2>Login</h2>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn">Login</button>
            </div>
            <?php if (!empty($error_message)): ?>
                <div class="error-message"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <div class="text-center">
                <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
            </div>
        </form>
    </div>
</body>
</html>