<?php
if (!isset($_SESSION['login_id'])) {
    header("location: login.php");
    exit();
}
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-info">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php?page=home">
            <i class="fas fa-trash"></i> <?php echo SITE_NAME; ?>
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=home">Home</a>
                </li>
                
                <?php if ($_SESSION['role'] == ROLE_USER): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=waste_report">Report Waste</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=collection_services">Collection Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=campaigns">Campaigns</a>
                    </li>
                <?php elseif ($_SESSION['role'] == ROLE_ADMIN): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=dashboard">Dashboard</a>
                    </li>
                <?php endif; ?>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user"></i> <?php echo $_SESSION['username']; ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="index.php?page=profile">My Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>