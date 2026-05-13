// Main JavaScript File

// Alert auto-close
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
});

// Form validation
const form = document.querySelector('form');
if (form) {
    form.addEventListener('submit', function(e) {
        if (!form.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
        }
        form.classList.add('was-validated');
    });
}

// Logout confirmation
function confirmLogout() {
    if (confirm('Are you sure you want to logout?')) {
        window.location.href = 'logout.php';
    }
}

console.log('Waste Management System Initialized');