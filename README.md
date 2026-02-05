# Gudele Hospital Radiology Department Management System

A comprehensive Laravel-based management system for the Radiology Department at Gudele Hospital.

## Features

### Admin Dashboard
- **User Management**: Create, edit, and manage doctors and registration staff
- **Audit Logs**: Monitor all system activities and changes
- **System Settings**: Configure hospital and system settings
- **Dashboard**: Overview of user counts, recent activities, and system status

### Doctor Portal
- **Patient Search**: Quickly find patient records by name, ID, email, or phone
- **Patient Details**: View comprehensive patient information including medical history and allergies
- **Add Radiology Results**: Record test types, findings, diagnosis, and recommendations with image uploads
- **Add Prescriptions**: Create prescriptions with medication details, dosage, and frequency
- **Schedule Appointments**: Set next appointments for patients
- **Manage Appointments**: View and update appointment statuses (completed, cancelled, no-show)

### Registration/Reception Portal
- **Patient Registration**: Enroll new patients with complete information
  - Basic Information: Name, age, sex, date of birth
  - Contact Details: Phone, email, address, city, state
  - Medical Information: Blood type, medical history, allergies
  - Emergency Contact: Name and phone number
- **Patient Management**: View, search, and edit patient records
- **Appointment Management**: Create, view, and manage appointments
- **Upcoming Appointments**: View scheduled appointments in an organized card layout

## Database Structure

### Tables
- **users**: System users (Admin, Doctor, Registration)
- **patients**: Patient information and records
- **appointments**: Scheduled appointments with doctors
- **radiology_results**: Medical test results and diagnoses
- **prescriptions**: Medication prescriptions
- **audit_logs**: System activity tracking

## Installation & Setup

### Requirements
- PHP 8.0 or higher
- MySQL 5.7 or higher
- Composer
- Node.js (optional, for asset compilation)

### Steps

1. **Clone or Extract Project**
   ```bash
   cd path/to/GH_RadiologyD_Management System
   ```

2. **Install Dependencies**
   ```bash
   composer install
   ```

3. **Environment Configuration**
   - Copy `.env.example` to `.env` (already provided)
   - Update database credentials:
     ```
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=gudele_radiology
     DB_USERNAME=root
     DB_PASSWORD=
     ```

4. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

5. **Run Database Migrations**
   ```bash
   php artisan migrate
   ```

6. **Create Initial Admin User** (Optional)
   ```bash
   php artisan tinker
   ```
   
   Then in Tinker:
   ```php
   App\Models\User::create([
       'name' => 'Admin User',
       'email' => 'admin@gudele-hospital.com',
       'password' => bcrypt('password'),
       'role' => 'admin',
       'status' => 'active'
   ]);
   ```

7. **Start Development Server**
   ```bash
   php artisan serve
   ```
   
   Access at: `http://localhost:8000`

## User Roles & Permissions

### Admin
- Full system access
- User management (create, edit, delete)
- View audit logs
- System settings
- Cannot access patient or appointment data directly

### Doctor
- Search and view patient records
- Add radiology results with findings and recommendations
- Create prescriptions
- Schedule appointments
- Manage appointment statuses
- View patient medical history

### Registration/Reception
- Register new patients
- Search and view patient records
- Edit patient information
- Create and manage appointments
- View all appointments

## Key Features

### Audit Logging
- Automatic tracking of all user actions
- IP address and user agent recording
- Filterable audit log reports
- Track user creation, updates, and deletions

### Patient Records
- Comprehensive patient information storage
- Automatic patient ID generation (RAD-YYYY-##### format)
- Medical history and allergy tracking
- Emergency contact information

### Appointment Management
- Flexible appointment scheduling
- Status tracking (scheduled, completed, cancelled, no-show)
- Doctor assignment
- Linked to patient radiology results and prescriptions

### Radiology Results
- Test type documentation
- Detailed findings and diagnosis
- Image/report uploads
- Status tracking (pending, completed, reviewed)

### Prescriptions
- Medication details with dosage and frequency
- Automatic expiry date calculation
- Status management (active, completed, cancelled)
- Special instructions for patients

## File Structure

```
app/
├── Models/
│   ├── User.php
│   ├── Patient.php
│   ├── Appointment.php
│   ├── RadiologyResult.php
│   ├── Prescription.php
│   └── AuditLog.php
├── Http/
│   └── Controllers/
│       ├── AuthController.php
│       ├── AdminController.php
│       ├── DoctorController.php
│       └── RegistrationController.php

database/
└── migrations/
    ├── 2026_02_05_000001_create_users_table.php
    ├── 2026_02_05_000002_create_patients_table.php
    ├── 2026_02_05_000003_create_appointments_table.php
    ├── 2026_02_05_000004_create_radiology_results_table.php
    ├── 2026_02_05_000005_create_prescriptions_table.php
    └── 2026_02_05_000006_create_audit_logs_table.php

resources/views/
├── auth/
│   ├── login.blade.php
│   └── profile.blade.php
├── admin/
│   ├── dashboard.blade.php
│   ├── users/
│   ├── audit-logs.blade.php
│   └── settings.blade.php
├── doctor/
│   ├── dashboard.blade.php
│   ├── patients/
│   ├── results/
│   ├── prescriptions/
│   └── appointments/
├── registration/
│   ├── dashboard.blade.php
│   ├── patients/
│   └── appointments/
└── layouts/
    ├── app.blade.php
    └── sidebar.blade.php

routes/
└── web.php
```

## Security Features

- Role-based access control
- Password hashing (bcrypt)
- CSRF protection
- SQL injection prevention through Eloquent ORM
- Audit logging of all administrative actions
- User status management (active/inactive)

## Customization

### Adding New Roles
Modify the `role` enum in the users table migration and add logic in controllers.

### Changing Patient ID Format
Edit the `storePatient` method in `RegistrationController.php`:
```php
$validated['patient_id'] = 'RAD-' . date('Y') . '-' . str_pad(Patient::count() + 1, 5, '0', STR_PAD_LEFT);
```

### Email Configuration
Update `.env` file with your email service:
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
```

## Troubleshooting

### Database Connection Error
- Verify MySQL is running
- Check database name, username, and password in `.env`
- Ensure database exists: `CREATE DATABASE gudele_radiology;`

### Migration Errors
- Clear migrations: `php artisan migrate:reset`
- Re-run migrations: `php artisan migrate`

### Permission Issues
- Ensure storage and bootstrap directories are writable
- Run: `chmod -R 775 storage bootstrap/cache`

## Support & Maintenance

For issues or feature requests, please contact the development team.

## License

This project is proprietary software for Gudele Hospital.

---

**Version**: 1.0.0
**Last Updated**: February 5, 2026
