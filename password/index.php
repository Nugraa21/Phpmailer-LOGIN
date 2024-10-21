<?php
include '../API/config.php';
require '../API/vendor/autoload.php'; // Pastikan PHPMailer sudah terinstal
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    
    // Cek apakah email terdaftar
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // Buat OTP
        $otp = rand(100000, 999999);
        $expiry = date("Y-m-d H:i:s", strtotime('+15 minutes')); // OTP valid selama 15 menit
        
        // Simpan OTP dan waktu kedaluwarsa di database
        $sql = "UPDATE users SET otp_code='$otp', otp_expiry='$expiry' WHERE email='$email'";
        if ($conn->query($sql) === TRUE) {
            // Kirim OTP melalui email
            $mail = new PHPMailer\PHPMailer\PHPMailer();
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'nugra315@gmail.com'; // Email Anda
            $mail->Password = 'xmxb hxtz daym biru'; // Password email Anda
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            
            $mail->setFrom('nugra315@gmail.com', 'Nugra21');
            $mail->addAddress($email);
            
            $mail->isHTML(true);
            $mail->Subject = 'Kode OTP untuk Reset Password';
            $mail->Body = "Kode OTP Anda adalah: $otp";
            
            if ($mail->send()) {
                header("Location: verify/index.php $email");
                exit();
            } else {
                $message = "Pesan tidak dapat dikirim. Error: " . $mail->ErrorInfo;
            }
        }
    } else {
        $message = "Email tidak terdaftar!";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lupa Password</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Lupa Password</h2>
            <form action="index.php" method="POST">
            <div class="form-group">
                <label for="email">Masukkan Email Anda:</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn">Kirim OTP</button>
            </div>
            <?php if (!empty($message)): ?>
                <div class="message"><?php echo $message; ?></div>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>