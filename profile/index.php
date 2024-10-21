<?php
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['email'])) {
    header("Location: ../logout.php");
    exit();
}

$username = $_SESSION['username'];
$email = $_SESSION['email'];
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
</head>
<body>

    <!-- Sidebar and Content Wrapper -->
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-dark" id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4">Nugra21 Dashboard</div>
            <div class="list-group list-group-flush">
                <a href="dashboard.php" class="list-group-item list-group-item-action bg-dark text-white"><i class="fas fa-home"></i> Home</a>
                <a href="#profileSection" class="list-group-item list-group-item-action bg-dark text-white"><i class="fas fa-user"></i> Profile</a>
                <a href="#activitySection" class="list-group-item list-group-item-action bg-dark text-white"><i class="fas fa-chart-line"></i> Recent Activity</a>
                <a href="logout.php" class="list-group-item list-group-item-action bg-dark text-white"><i class="fas fa-sign-out-alt"></i> Logout</a>
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
                
                <!-- Profile Section -->
                <section id="profileSection" class="mb-5">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">Profile Overview</div>
                                <div class="card-body">
                                    <p><strong>Username:</strong> <?php echo $username; ?></p>
                                    <p><strong>Email:</strong> <?php echo $email; ?></p>
                                    <a href="edit_profile.php" class="btn btn-custom">Edit Profile</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Activity Section -->
                <section id="activitySection" class="mb-5">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">Recent Activity</div>
                                <div class="card-body">
                                    <p>You haven't performed any activity yet.</p>
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
    </script>

</body>
</html>
