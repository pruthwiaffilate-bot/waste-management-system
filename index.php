<?php
session_start();
include('./config/config.php');
include('./config/db_connect.php');

// Check if user is logged in
if (!isset($_SESSION['login_id'])) {
    header("location: login.php");
    exit();
}

// Get page from URL
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$allowed_pages = array('home', 'profile', 'waste_report', 'collection_services', 'recycling_companies', 'campaigns', 'dashboard');

if (!in_array($page, $allowed_pages)) {
    $page = 'home';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="wrapper">
        <!-- Navigation Bar -->
        <?php include('./includes/navbar.php'); ?>
        
        <!-- Main Content -->
        <main class="main-content">
            <div class="container-fluid">
                <?php 
                    $page_path = './pages/' . $page . '.php';
                    if (file_exists($page_path)) {
                        include($page_path);
                    } else {
                        include('./pages/home.php');
                    }
                ?>
            </div>
        </main>
    </div>
    
    <script src="./assets/js/jquery-3.6.0.min.js"></script>
    <script src="./assets/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/js/main.js"></script>
</body>
</html>