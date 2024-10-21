<?php
$servername = "localhost";
$username = "root"; // Ganti jika menggunakan username berbeda
$password = ""; // Ganti jika menggunakan password
$dbname = "nugra"; // Ganti dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>



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

<?php
session_start();
session_destroy(); // Hapus semua session
header("Location: login.php"); // Redirect ke halaman login
exit();
?>

<?php
include 'config.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Simpan ke database
    $sql = "INSERT INTO users (email, password) VALUES ('$email', '$password')";
    
    if ($conn->query($sql) === TRUE) {
        $message = "Pendaftaran berhasil! Silakan login.";
    } else {
        $message = "Error: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar</title>
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
        <form action="register.php" method="POST">
            <h2>Daftar</h2>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn">Daftar</button>
            </div>
            <?php if (!empty($message)): ?>
                <div class="message <?php echo strpos($message, 'Error') !== false ? 'error' : 'success'; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            <div class="text-center">
                <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
            </div>
        </form>
    </div>
</body>
</html>

<?php
session_start();

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $otpInput = $_POST['otp'];

    if ($otpInput == $_SESSION['otp']) {
        // Verifikasi berhasil
        header("Location: Dasbord\index.php");
        exit();
    } else {
        $error_message = "OTP tidak valid!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verifikasi OTP</title>
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
        <form action="verify.php" method="POST">
            <h2>Verifikasi OTP</h2>
            <div class="form-group">
                <label for="otp">Masukkan OTP:</label>
                <input type="text" name="otp" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn">Verifikasi</button>
            </div>
            <?php if (!empty($error_message)): ?>
                <div class="error-message">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
