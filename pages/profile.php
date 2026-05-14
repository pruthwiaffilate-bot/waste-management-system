<?php
// Profile Page
include('./config/db_connect.php');

$user_id = $_SESSION['login_id'];
$message = '';
$error = '';

// Fetch user data
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $second_name = $conn->real_escape_string($_POST['second_name']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $residence_zip = $conn->real_escape_string($_POST['residence_zip']);
    
    $update_sql = "UPDATE users SET first_name = ?, second_name = ?, phone = ?, residence_zip = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param('ssssi', $first_name, $second_name, $phone, $residence_zip, $user_id);
    
    if ($update_stmt->execute()) {
        $message = "Profile updated successfully!";
        // Refresh user data
        $stmt->execute();
        $user = $result->fetch_assoc();
    } else {
        $error = "Failed to update profile.";
    }
}

// Handle password change
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    if (!password_verify($current_password, $user['password'])) {
        $error = "Current password is incorrect!";
    } else if ($new_password !== $confirm_password) {
        $error = "New passwords do not match!";
    } else if (strlen($new_password) < 6) {
        $error = "Password must be at least 6 characters!";
    } else {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $pwd_sql = "UPDATE users SET password = ? WHERE id = ?";
        $pwd_stmt = $conn->prepare($pwd_sql);
        $pwd_stmt->bind_param('si', $hashed_password, $user_id);
        
        if ($pwd_stmt->execute()) {
            $message = "Password changed successfully!";
        } else {
            $error = "Failed to change password.";
        }
    }
}
?>

<style>
    .profile-container {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 40px 20px;
        border-radius: 0 0 20px 20px;
        margin: -1rem -1rem 0 -1rem;
        min-height: 100vh;
    }

    .profile-header {
        text-align: center;
        color: white;
        margin-bottom: 40px;
        animation: slideInDown 0.6s ease-out;
    }

    @keyframes slideInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .profile-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 10px;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }

    .profile-header p {
        font-size: 1.1rem;
        opacity: 0.95;
    }

    .profile-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        overflow: hidden;
        animation: slideInUp 0.6s ease-out;
    }

    .profile-card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 25px;
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .profile-avatar {
        width: 80px;
        height: 80px;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        border: 3px solid white;
    }

    .profile-header-info h2 {
        color: white;
        margin: 0;
        font-size: 1.8rem;
        font-weight: 700;
    }

    .profile-header-info p {
        color: rgba(255, 255, 255, 0.9);
        margin: 5px 0 0 0;
        font-size: 0.95rem;
    }

    .nav-tabs {
        border-bottom: 2px solid #e2e8f0;
        background: #f7fafc;
    }

    .nav-tabs .nav-link {
        color: #4a5568;
        border: none;
        font-weight: 600;
        padding: 1rem 2rem;
        position: relative;
        transition: all 0.3s ease;
    }

    .nav-tabs .nav-link:hover {
        color: #667eea;
    }

    .nav-tabs .nav-link.active {
        color: #667eea;
        background: transparent;
        border-bottom: 3px solid #667eea;
    }

    .nav-tabs .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 100%;
        height: 3px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .tab-content {
        padding: 30px;
    }

    .form-group label {
        font-weight: 600;
        color: #1a202c;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-control {
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 12px 15px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .form-control:disabled {
        background-color: #f7fafc;
        color: #718096;
    }

    .btn-update {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 12px 40px;
        font-weight: 600;
        border-radius: 50px;
        font-size: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .btn-update:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
        color: white;
    }

    .alert {
        border: none;
        border-radius: 12px;
        padding: 15px 20px;
        margin-bottom: 20px;
        animation: slideInDown 0.3s ease-out;
    }

    .alert-success {
        background: linear-gradient(135deg, rgba(34, 197, 94, 0.1) 0%, rgba(34, 197, 94, 0.1) 100%);
        color: #15803d;
        border-left: 4px solid #22c55e;
    }

    .alert-danger {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(239, 68, 68, 0.1) 100%);
        color: #b91c1c;
        border-left: 4px solid #ef4444;
    }

    .profile-info-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }

    .info-box {
        background: #f7fafc;
        padding: 20px;
        border-radius: 12px;
        border-left: 4px solid #667eea;
    }

    .info-box label {
        font-size: 0.85rem;
        color: #718096;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin: 0 0 8px 0;
        display: block;
    }

    .info-box-value {
        font-size: 1.1rem;
        color: #1a202c;
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .profile-container {
            padding: 20px 15px;
        }

        .profile-header h1 {
            font-size: 1.8rem;
        }

        .profile-card-header {
            flex-direction: column;
            text-align: center;
        }

        .nav-tabs .nav-link {
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
        }

        .tab-content {
            padding: 20px;
        }

        .profile-info-row {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="profile-container">
    <!-- Profile Header -->
    <div class="profile-header">
        <h1><i class="fas fa-user-circle"></i> My Profile</h1>
        <p>Manage your account settings and preferences</p>
    </div>

    <!-- Profile Card -->
    <div class="profile-card" style="max-width: 900px; margin: 0 auto;">
        <div class="profile-card-header">
            <div class="profile-avatar">
                <i class="fas fa-user"></i>
            </div>
            <div class="profile-header-info">
                <h2><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['second_name']); ?></h2>
                <p><?php echo htmlspecialchars($user['email']); ?></p>
            </div>
        </div>

        <div class="card-body" style="padding: 0;">
            <?php if ($message): ?>
                <div style="padding: 20px;">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> <?php echo $message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if ($error): ?>
                <div style="padding: 20px;">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                </div>
            <?php endif; ?>
            
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-info">
                        <i class="fas fa-user-edit"></i> Profile Information
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#change-password">
                        <i class="fas fa-lock"></i> Change Password
                    </button>
                </li>
            </ul>
            
            <div class="tab-content">
                <!-- Profile Information Tab -->
                <div class="tab-pane fade show active" id="profile-info">
                    <form method="POST" action="">
                        <div class="profile-info-row mb-4">
                            <div class="info-box">
                                <label>Member Since</label>
                                <div class="info-box-value">
                                    <i class="fas fa-calendar"></i> <?php echo date('M d, Y', strtotime($user['created_at'] ?? date('Y-m-d'))); ?>
                                </div>
                            </div>
                            <div class="info-box">
                                <label>Account Status</label>
                                <div class="info-box-value">
                                    <span class="badge bg-success">Active</span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="first_name"><i class="fas fa-user"></i> First Name</label>
                                    <input type="text" id="first_name" name="first_name" class="form-control" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="second_name"><i class="fas fa-user"></i> Last Name</label>
                                    <input type="text" id="second_name" name="second_name" class="form-control" value="<?php echo htmlspecialchars($user['second_name']); ?>" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="email"><i class="fas fa-envelope"></i> Email Address</label>
                            <input type="email" id="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
                            <small class="text-muted d-block mt-2"><i class="fas fa-info-circle"></i> Email cannot be changed</small>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="phone"><i class="fas fa-phone"></i> Phone Number</label>
                                    <input type="tel" id="phone" name="phone" class="form-control" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="residence_zip"><i class="fas fa-map-marker-alt"></i> Residence Area/Zip Code</label>
                                    <input type="text" id="residence_zip" name="residence_zip" class="form-control" value="<?php echo htmlspecialchars($user['residence_zip']); ?>" required>
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" name="update_profile" class="btn btn-update">
                            <i class="fas fa-save"></i> Update Profile
                        </button>
                    </form>
                </div>
                
                <!-- Change Password Tab -->
                <div class="tab-pane fade" id="change-password">
                    <form method="POST" action="">
                        <p class="text-muted mb-4"><i class="fas fa-info-circle"></i> Please enter a password with at least 6 characters</p>
                        
                        <div class="form-group mb-3">
                            <label for="current_password"><i class="fas fa-lock"></i> Current Password</label>
                            <input type="password" id="current_password" name="current_password" class="form-control" placeholder="Enter your current password" required>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="new_password"><i class="fas fa-key"></i> New Password</label>
                            <input type="password" id="new_password" name="new_password" class="form-control" placeholder="Enter new password" required>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="confirm_password"><i class="fas fa-key"></i> Confirm New Password</label>
                            <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Confirm new password" required>
                        </div>
                        
                        <button type="submit" name="change_password" class="btn btn-update">
                            <i class="fas fa-check"></i> Change Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
