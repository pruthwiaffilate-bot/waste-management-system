<?php
session_start();
include('./config/config.php');
include('./config/db_connect.php');

// Redirect if already logged in
if (isset($_SESSION['login_id'])) {
    header("location: index.php?page=home");
    exit();
}

$error = '';
$success = '';

// Handle registration form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $second_name = $conn->real_escape_string($_POST['second_name']);
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $residence_zip = $conn->real_escape_string($_POST['residence_zip']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validate passwords match
    if ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else if (strlen($password) < 6) {
        $error = "Password must be at least 6 characters!";
    } else {
        // Check if username already exists
        $check_sql = "SELECT id FROM users WHERE username = ? OR email = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param('ss', $username, $email);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        
        if ($check_result->num_rows > 0) {
            $error = "Username or email already exists!";
        } else {
            // Hash password and insert new user
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $role = ROLE_USER; // Default role for new registrations
            
            $insert_sql = "INSERT INTO users (first_name, second_name, username, email, phone, residence_zip, password, role, created_at) 
                          VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
            $insert_stmt = $conn->prepare($insert_sql);
            $insert_stmt->bind_param('ssssssi', $first_name, $second_name, $username, $email, $phone, $residence_zip, $hashed_password, $role);
            
            if ($insert_stmt->execute()) {
                $success = "Registration successful! Please login.";
            } else {
                $error = "Registration failed. Please try again.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/login.css">
</head>
<body>
    <main id="main" class="bg-light">
        <div id="login-left" class="bg-info">
            <img src="./assets/images/collection_personnel.jpeg" alt="Waste Management" width="100%">
        </div>
        
        <div id="login-right" class="bg-light">
            <div class="w-100">
                <h4 class="text-info text-center"><b><?php echo SITE_NAME; ?></b></h4>
                <h6 class="text-center text-muted">Create New Account</h6>
                <br>
                
                <?php if ($error): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $error; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <?php if ($success): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo $success; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <div class="card col-md-8">
                    <div class="card-body">
                        <form method="POST" action="">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label for="first_name" class="form-label">First Name</label>
                                        <input type="text" id="first_name" name="first_name" class="form-control form-control-sm" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label for="second_name" class="form-label">Second Name</label>
                                        <input type="text" id="second_name" name="second_name" class="form-control form-control-sm" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group mb-2">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" id="username" name="username" class="form-control form-control-sm" required>
                            </div>
                            
                            <div class="form-group mb-2">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" class="form-control form-control-sm" required>
                            </div>
                            
                            <div class="form-group mb-2">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" id="phone" name="phone" class="form-control form-control-sm" required>
                            </div>
                            
                            <div class="form-group mb-2">
                                <label for="residence_zip" class="form-label">Residence Area/Zip Code</label>
                                <input type="text" id="residence_zip" name="residence_zip" class="form-control form-control-sm" required>
                            </div>
                            
                            <div class="form-group mb-2">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password" name="password" class="form-control form-control-sm" required>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                <input type="password" id="confirm_password" name="confirm_password" class="form-control form-control-sm" required>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" name="register" class="btn btn-primary btn-sm">Register</button>
                            </div>
                        </form>
                        
                        <hr>
                        <p class="text-center">Already have an account? <a href="login.php">Login here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <script src="./assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>