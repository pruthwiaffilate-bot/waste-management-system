<?php
// Home Page
?>
<div class="row mt-4">
    <div class="col-md-12">
        <div class="jumbotron bg-info text-white p-4 rounded">
            <h1 class="display-4">Welcome to <?php echo SITE_NAME; ?></h1>
            <p class="lead">Efficient waste management for a cleaner environment</p>
            <hr class="my-4">
            <?php if ($_SESSION['role'] == ROLE_USER): ?>
                <p>Help us keep the environment clean by reporting improper waste disposal and connecting with collection services.</p>
                <a class="btn btn-light btn-lg" href="index.php?page=waste_report" role="button">Report Waste Issue</a>
            <?php elseif ($_SESSION['role'] == ROLE_ADMIN): ?>
                <p>Manage the waste management system efficiently.</p>
                <a class="btn btn-light btn-lg" href="index.php?page=dashboard" role="button">Go to Dashboard</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-trash text-info"></i> Easy Reporting</h5>
                <p class="card-text">Report improper waste disposal issues in your area quickly and easily.</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-truck text-success"></i> Collection Services</h5>
                <p class="card-text">Connect with reliable waste collection companies in your area.</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-leaf text-success"></i> Recycling Support</h5>
                <p class="card-text">Access recycling companies to ensure waste is properly recycled.</p>
            </div>
        </div>
    </div>
</div>