<?php
session_start();
include '../API/config.php'; // Pastikan koneksi ke database ada

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Ambil informasi pengguna dari database
$stmt = $conn->prepare("SELECT username, email FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$username = $user['username'];
$email = $user['email'];

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Nugra21</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        /* Style untuk card dashboard */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        /* Style untuk menyembunyikan sidebar saat toggled */
        #wrapper.toggled #sidebar-wrapper {
            display: none; /* Hide sidebar */
        }

        #wrapper {
            transition: all 0.3s ease; /* Smooth transition */
        }
    </style>
</head>
<body>
    <!-- Sidebar and Content Wrapper -->
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-dark" id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4">🔸<?php echo $username; ?> Dashboard</div>
            <div class="list-group list-group-flush">
                <a href="#homeSection" class="list-group-item list-group-item-action bg-dark text-white" id="homeLink"><i class="fas fa-home"></i> Home</a>
                <a href="#profileSection" class="list-group-item list-group-item-action bg-dark text-white" id="profileLink"><i class="fas fa-user"></i> Profile</a>
                <a href="#activitySection" class="list-group-item list-group-item-action bg-dark text-white" id="activityLink"><i class="fas fa-chart-line"></i> Recent Activity</a>
                <a href="#settingsSection" class="list-group-item list-group-item-action bg-dark text-white" id="settingsLink"><i class="fas fa-cog"></i> Settings</a>
                <a href="#helpSection" class="list-group-item list-group-item-action bg-dark text-white" id="helpLink"><i class="fas fa-question-circle"></i> Help</a>
                <a href="#contactSection" class="list-group-item list-group-item-action bg-dark text-white" id="contactLink"><i class="fas fa-envelope"></i> Contact</a>
                <a href="logout.php" style="background-color: red;" class="list-group-item list-group-item-action  text-white"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <button class="btn btn-custom" id="menu-toggle"><i class="fas fa-bars"></i> Toggle Menu</button>
                <div class="ml-auto">
                    <span>Welcome, <?php echo $username; ?>!</span>
                </div>
            </nav>

            <div class="container-fluid mt-4">
                <h1 class="mb-4">Dashboard</h1>

                <!-- Home Section -->
                <section id="homeSection" class="mb-5">
                    <div class="row">
                        <!-- --- -->
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">Selamat datang <?php echo $username; ?></div>
                                <div class="card-body">
                                    <p>Anda di sini dapat memonitoring data anda bila anda butuh bantun bisa hubungi <a href="https://nugra.online">Admin</a></p>
                                    <h5>Menu Navigasi:</h5>
                                    <ul>
                                        <li><a href="#profileSection">View Profile</a></li>
                                        <li><a href="#activitySection">Recent Activity</a></li>
                                        <li><a href="#settingsSection">Settings</a></li>
                                        <li><a href="#helpSection">Help</a></li>
                                        <li><a href="#contactSection">Contact Support</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- --- -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">Profile Overview</div>
                                <div class="card-body">
                                    <p><strong>Username:</strong> <?php echo $username; ?></p>
                                    <p><strong>Email:</strong> <?php echo $email; ?></p>
                                    <a href="ganti_nama.php" class="btn btn-custom">Edit Profile</a>
                                </div>
                            </div>
                        </div>
                        <!-- --- -->
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">Aktifitas terbaru</div>
                                <div class="card-body">
                                    <p>Anda belum memasukan rekam aktifitas.</p>
                                </div>
                            </div>
                        </div>
                        <!-- --- -->
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">Settings</div>
                                <div class="card-body">
                                    <p>Kelola data anda.</p>
                                    <a href="../password/index.php" class="btn btn-custom">Change Password</a>
                                </div>
                            </div>
                        </div>
                        <!-- --- -->
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">Help</div>
                                <div class="card-body">
                                    <p>Bila anda butuh bantuan anda bisa menghubungi suportkami / <a href="https://nugra.online">Admin</a>.</p>
                                    <!-- <a href="#" class="btn btn-custom">View FAQ</a> -->
                                </div>
                            </div>
                        </div>
                        <!-- --- -->
                        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Contact Support</div>
                <div class="card-body">
                    <p>If you have any questions or need assistance, feel free to reach out to us through the following platforms:</p>
                    <ul class="list-unstyled">
                        <li><a href="https://github.com/Nugraa21" target="_blank"><i class="fab fa-github"></i> GitHub</a></li>
                        <li><a href="https://www.instagram.com/nugraa_21/" target="_blank"><i class="fab fa-instagram"></i> Instagram</a></li>
                        <li><a href="https://www.youtube.com/@nugra21" target="_blank"><i class="fab fa-youtube"></i> YouTube</a></li>
                        <li><a href="https://facebook.com" target="_blank"><i class="fab fa-facebook"></i> Facebook</a></li>
                        <li><a href="https://x.com" target="_blank"><i class="fab fa-twitter"></i> X (Twitter)</a></li>
                        <li><a href="https://wa.me/085740993739" target="_blank"><i class="fab fa-whatsapp"></i> WhatsApp</a></li>
                    </ul>
                    <p>You can also email us at: <a href="mailto:support@yourwebsite.com">nugra21.admin@were.io</a></p>
                </div>
            </div>
        </div>
                        <!-- --- -->
                    </div>
                </section>

                <!-- Profile Section -->
                <section id="profileSection" class="mb-5" style="display: none;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">Profile Overview</div>
                                <div class="card-body">
                                    <p><strong>Username:</strong> <?php echo $username; ?></p>
                                    <p><strong>Email:</strong> <?php echo $email; ?></p>
                                    <a href="ganti_nama.php" class="btn btn-custom">Edit Profile</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Activity Section -->
                <section id="activitySection" class="mb-5" style="display: none;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">Aktifitas terbaru</div>
                                <div class="card-body">
                                    <p>Anda belum memasukan rekam aktifitas.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Settings Section -->
                <section id="settingsSection" class="mb-5" style="display: none;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">Settings</div>
                                <div class="card-body">
                                    <p>Kelola data anda.</p>
                                    <a href="../password/index.php" class="btn btn-custom">Change Password</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Help Section -->
                <section id="helpSection" class="mb-5" style="display: none;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">Help</div>
                                <div class="card-body">
                                    <p>Bila anda butuh bantuan anda bisa menghubungi suportkami / <a href="https://nugra.online">Admin</a>.</p>
                                    <!-- <a href="#" class="btn btn-custom">View FAQ</a> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Contact Section -->
                <section id="contactSection" class="mb-5" style="display: none;">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Contact Support</div>
                <div class="card-body">
                    <p>If you have any questions or need assistance, feel free to reach out to us through the following platforms:</p>
                    <ul class="list-unstyled">
                        <li><a href="https://github.com/Nugraa21" target="_blank"><i class="fab fa-github"></i> GitHub</a></li>
                        <li><a href="https://www.instagram.com/nugraa_21/" target="_blank"><i class="fab fa-instagram"></i> Instagram</a></li>
                        <li><a href="https://www.youtube.com/@nugra21" target="_blank"><i class="fab fa-youtube"></i> YouTube</a></li>
                        <li><a href="https://facebook.com" target="_blank"><i class="fab fa-facebook"></i> Facebook</a></li>
                        <li><a href="https://x.com" target="_blank"><i class="fab fa-twitter"></i> X (Twitter)</a></li>
                        <li><a href="https://wa.me/085740993739" target="_blank"><i class="fab fa-whatsapp"></i> WhatsApp</a></li>
                    </ul>
                    <p>You can also email us at: <a href="mailto:support@yourwebsite.com">nugra21.admin@were.io</a></p>
                </div>
            </div>
        </div>
    </div>
</section>


            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Toggle the menu when button is clicked
$("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
});

// Show the Home section by default
$("#homeSection").show();

// Handle home link click
$("#homeLink").click(function(e) {
    e.preventDefault();
    $("#homeSection").show();
    $("#profileSection").hide();
    $("#activitySection").hide();
    $("#settingsSection").hide();
    $("#helpSection").hide();
    $("#contactSection").hide();
});

// Handle profile link click
$("#profileLink").click(function(e) {
    e.preventDefault();
    $("#homeSection").hide();
    $("#profileSection").show();
    $("#activitySection").hide();
    $("#settingsSection").hide();
    $("#helpSection").hide();
    $("#contactSection").hide();
});

// Handle activity link click
$("#activityLink").click(function(e) {
    e.preventDefault();
    $("#homeSection").hide();
    $("#profileSection").hide();
    $("#activitySection").show();
    $("#settingsSection").hide();
    $("#helpSection").hide();
    $("#contactSection").hide();
});

// Handle settings link click
$("#settingsLink").click(function(e) {
    e.preventDefault();
    $("#homeSection").hide();
    $("#profileSection").hide();
    $("#activitySection").hide();
    $("#settingsSection").show();
    $("#helpSection").hide();
    $("#contactSection").hide();
});

// Handle help link click
$("#helpLink").click(function(e) {
    e.preventDefault();
    $("#homeSection").hide();
    $("#profileSection").hide();
    $("#activitySection").hide();
    $("#settingsSection").hide();
    $("#helpSection").show();
    $("#contactSection").hide();
});

// Handle contact link click
$("#contactLink").click(function(e) {
    e.preventDefault();
    $("#homeSection").hide();
    $("#profileSection").hide();
    $("#activitySection").hide();
    $("#settingsSection").hide();
    $("#helpSection").hide();
    $("#contactSection").show();
});

    </script>
    <style>
        /* Style to hide the sidebar when toggled */
        #wrapper.toggled #sidebar-wrapper {
            display: none; /* Hide sidebar */
        }
        #wrapper {
            transition: all 0.3s ease; /* Smooth transition */
        }
    </style>
</body>
</html>
