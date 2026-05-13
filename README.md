# Cleanv: Waste Management System

An efficient web-based waste management system designed to help maintain and conserve the environment through proper waste disposal and management.

## Features

- **User Registration & Authentication**: Secure login and registration system with role-based access
- **Waste Reporting**: Report improper waste disposal issues in your area
- **Collection Services**: Connect with waste collection companies
- **Recycling Support**: Access recycling companies for proper waste recycling
- **Campaigns**: Create and join cleaning campaigns in your area
- **Admin Dashboard**: Manage users, reports, and system operations
- **User Profiles**: Manage personal information and change passwords

## Technology Stack

- **Frontend**: HTML5, CSS3, Bootstrap 5, JavaScript
- **Backend**: PHP 7+
- **Database**: MySQL
- **Server**: Apache (Xampp/Wamp)

## Installation

### Prerequisites

- Apache Server (Xampp or Wamp)
- PHP 7.0 or higher
- MySQL 5.7 or higher

### Setup Steps

1. **Extract the application folder** to your server directory:
   - For Xampp: `C:\xampp\htdocs\waste-management-system`
   - For Wamp: `C:\wamp\www\waste-management-system`

2. **Create the database**:
   - Open phpMyAdmin
   - Import the `database/schema.sql` file to create the database and tables

3. **Update database configuration** (if needed):
   - Edit `config/db_connect.php` with your database credentials

4. **Start your local server**:
   - Start Apache and MySQL services
   - For Xampp: Use the Xampp Control Panel
   - For Wamp: Use the Wamp Control Panel

5. **Access the application**:
   - User portal: `http://localhost/waste-management-system/`
   - Admin portal: `http://localhost/waste-management-system/admin/`

## Default Admin Account

After running the schema, you can create an admin account or use:
- **Username**: admin
- **Password**: admin123

## User Roles

1. **Admin** (Role ID: 1)
   - Manage all users
   - View all reports
   - Manage collection companies
   - System configuration

2. **User** (Role ID: 2)
   - Report waste issues
   - Connect with collection services
   - Join campaigns
   - Manage profile

3. **Collection Personnel** (Role ID: 3)
   - View assigned reports
   - Update collection status
   - Connect with recycling companies

4. **Recycling Company** (Role ID: 4)
   - View available waste materials
   - Schedule collection
   - Update recycling status

## Directory Structure

```
waste-management-system/
├── assets/
│   ├── css/
│   │   ├── style.css
│   │   └── login.css
│   ├── js/
│   │   └── main.js
│   └── images/
├── config/
│   ├── config.php
│   └── db_connect.php
├── database/
│   └── schema.sql
├── includes/
│   └── navbar.php
├── pages/
│   ├── home.php
│   ├── profile.php
│   ├── waste_report.php
│   ├── collection_services.php
│   ├── campaigns.php
│   └── dashboard.php
├── index.php
├── login.php
├── register.php
├── logout.php
└── README.md
```

## Database Tables

- **users**: User accounts and credentials
- **collection_personnel**: Waste collection staff information
- **recycling_companies**: Recycling company details
- **collection_companies**: Waste collection company details
- **waste_reports**: User waste disposal reports
- **campaigns**: Cleaning campaigns
- **campaign_participants**: Campaign participation tracking
- **system_settings**: System configuration

## Security Features

- Password hashing using PHP's password_hash()
- SQL prepared statements to prevent SQL injection
- Session-based authentication
- Role-based access control
- Input validation and sanitization

## Troubleshooting

### Database Connection Error
- Verify MySQL service is running
- Check database credentials in `config/db_connect.php`
- Ensure the database exists

### Port Already in Use
- Change Apache port in httpd.conf
- Or stop other services using port 80

### PHP Errors
- Verify PHP version is 7.0 or higher
- Enable required PHP extensions in php.ini
- Check error logs in Apache/Xampp

## Future Enhancements

- Mobile application (iOS/Android)
- GPS integration for location tracking
- Real-time notifications
- Payment gateway integration
- Advanced analytics and reporting
- IoT sensor integration for waste level monitoring
- SMS/Email notifications

## License

This project is licensed under the MIT License.

## Support

For issues or questions, please contact the development team or check the documentation.

## Author

Cleanv Development Team

---

**Last Updated**: 2026-05-13