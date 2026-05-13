<?php
// System Configuration
define('SITE_NAME', 'Cleanv: Waste Management System');
define('SITE_URL', 'http://localhost/waste-management-system');
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'waste_management_db');

// Session Configuration
define('SESSION_TIMEOUT', 1800); // 30 minutes

// User Roles
define('ROLE_ADMIN', 1);
define('ROLE_USER', 2);
define('ROLE_COLLECTION_PERSONNEL', 3);
define('ROLE_RECYCLING_COMPANY', 4);

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

?>