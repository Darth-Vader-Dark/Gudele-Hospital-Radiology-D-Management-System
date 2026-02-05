# Setup Guide - Gudele Hospital Radiology Management System

## Quick Start Guide

### Step 1: Install Dependencies

Open Command Prompt/PowerShell in the project directory and run:

```bash
composer install
```

This will install all required PHP packages defined in `composer.json`.

### Step 2: Configure Environment

1. The `.env` file is already included with default settings
2. Update database credentials if needed:
   - `DB_HOST` - Database server (default: 127.0.0.1)
   - `DB_DATABASE` - Database name (default: gudele_radiology)
   - `DB_USERNAME` - Database user (default: root)
   - `DB_PASSWORD` - Database password (leave blank for default)

### Step 3: Generate Application Key

```bash
php artisan key:generate
```

### Step 4: Create Database

Using MySQL, create a new database:

```sql
CREATE DATABASE gudele_radiology CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Step 5: Run Database Migrations

```bash
php artisan migrate
```

This will create all necessary tables.

### Step 6: Create Initial Admin User

Open PHP Tinker (interactive shell):

```bash
php artisan tinker
```

Then execute these commands to create an admin user:

```php
App\Models\User::create([
    'name' => 'Administrator',
    'email' => 'admin@gudele-hospital.com',
    'password' => bcrypt('admin@123'),
    'role' => 'admin',
    'status' => 'active'
]);

exit();
```

### Step 7: Create Sample Doctor & Registration User (Optional)

Still in Tinker, you can create sample users:

```php
// Sample Doctor
App\Models\User::create([
    'name' => 'Dr. Abebe Haile',
    'email' => 'doctor@gudele-hospital.com',
    'phone' => '+251-911-234-567',
    'password' => bcrypt('doctor@123'),
    'role' => 'doctor',
    'status' => 'active'
]);

// Sample Registration Staff
App\Models\User::create([
    'name' => 'Meskerem Tadesse',
    'email' => 'reception@gudele-hospital.com',
    'phone' => '+251-922-345-678',
    'password' => bcrypt('reception@123'),
    'role' => 'registration',
    'status' => 'active'
]);

exit();
```

### Step 8: Start Development Server

```bash
php artisan serve
```

The application will be available at: **http://localhost:8000**

## Login Credentials

After setup, you can login with:

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@gudele-hospital.com | admin@123 |
| Doctor | doctor@gudele-hospital.com | doctor@123 |
| Reception | reception@gudele-hospital.com | reception@123 |

## Troubleshooting

### Database Connection Error

**Error:** "SQLSTATE[HY000] [2002] No connection could be made because the target machine actively refused it"

**Solution:**
- Ensure MySQL is running
- Check database connection settings in `.env`
- Verify database exists: `SHOW DATABASES;`

### Permission Denied on Storage

**Error:** "Permission denied" when accessing storage folder

**Solution (Windows Command Prompt):**
```bash
icacls "storage" /grant Everyone:F /T /C
icacls "bootstrap\cache" /grant Everyone:F /T /C
```

### Class Not Found Error

**Error:** "Class App\Http\Controllers\YourController not found"

**Solution:**
```bash
composer dump-autoload
```

### Middleware Not Found

**Error:** "Class 'App\Http\Middleware\CheckRole' not found"

**Ensure the CheckRole middleware file exists at:**
```
app/Http/Middleware/CheckRole.php
```

## Project Structure

```
root/
├── app/
│   ├── Models/          - Database models
│   ├── Http/
│   │   ├── Controllers/ - Business logic
│   │   └── Middleware/  - Request filters
├── database/
│   └── migrations/      - Database schemas
├── routes/
│   └── web.php          - URL routes
├── resources/
│   └── views/           - Blade templates
├── .env                 - Configuration file
└── README.md            - Full documentation
```

## Default Features by Role

### Administrator
- ✅ Create, edit, and delete users
- ✅ View system audit logs
- ✅ Configure system settings
- ✅ Manage user roles and status

### Doctor
- ✅ Search patient records
- ✅ Add radiology results with images
- ✅ Create prescriptions
- ✅ Schedule appointments
- ✅ View patient medical history

### Registration/Reception
- ✅ Register new patients
- ✅ Update patient information
- ✅ Create and manage appointments
- ✅ Search patient records
- ✅ View upcoming appointments

## Development Tips

### Clear Cache
If experiencing cache issues:
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Reset Database
To completely reset the database:
```bash
php artisan migrate:reset
php artisan migrate
```

### Check Application Status
```bash
php artisan tinker
```

Then in Tinker:
```php
DB::connection()->getPdo();  // Tests database connection
User::count();               // Counts users
exit();
```

## Production Deployment

Before deploying to production:

1. Set `.env` to `APP_ENV=production`
2. Set `.env` to `APP_DEBUG=false`
3. Generate new `APP_KEY`: `php artisan key:generate`
4. Run migrations: `php artisan migrate --force`
5. Optimize autoloader: `composer install --optimize-autoloader --no-dev`
6. Cache configuration: `php artisan config:cache`
7. Cache routes: `php artisan route:cache`

## Useful Commands

```bash
# Create a new database model
php artisan make:model ModelName -m

# Create a new controller
php artisan make:controller ControllerName

# Create a new migration
php artisan make:migration create_table_name

# List all routes
php artisan route:list

# Check Laravel version
php artisan --version
```

## Support

For issues or questions about this setup, refer to:
- Main README.md for feature documentation
- Laravel Documentation: https://laravel.com/docs
- Project source files and inline comments

---

**Last Updated:** February 5, 2026
