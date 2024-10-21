<?php
include '../API/config.php';

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
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="icon" href="../assets/media/icon.png">
</head>
<body>
    <div class="container">
    <div class="login-logo">
            <div>
                <img width="50px" height="50px" src="../assets/media/icon.png" alt="">
            </div>
            <div>
                <b>Nugra </b>DEV
            </div>
        </div>
        <form action="index.php" method="POST">
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
                <p>Sudah punya akun? <a href="../login/index.php">Login di sini</a></p>
            </div>
        </form>
    </div>
</body>
</html>
