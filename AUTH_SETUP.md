# CRAFTIFY Authentication Setup

This LavaLust project now includes a complete authentication system with login, registration, and dashboard functionality.

## Quick Setup

1. **Run the setup command to create the database table and default users:**
   ```bash
   php console/cli.php Setup auth
   ```

2. **Access the authentication system:**
   - Login: http://your-domain/auth/login
   - Register: http://your-domain/auth/register

## Default Test Accounts

After running the setup, you can use these test accounts:

- **Admin Account:**
  - Email: admin@craftify.com
  - Password: admin123

- **User Account:**
  - Email: user@craftify.com
  - Password: user123

## Features Included

### 🔐 Authentication System
- **Login/Logout** - Secure user authentication with session management
- **Registration** - New user registration with validation
- **Dashboard** - Protected user dashboard
- **Password Security** - Passwords are hashed using PHP's password_hash()

### 📁 Files Created
- `app/controllers/Auth.php` - Authentication controller
- `app/models/User.php` - User model for database operations
- `app/views/auth/login.php` - Login page
- `app/views/auth/register.php` - Registration page
- `app/views/auth/dashboard.php` - User dashboard
- `app/migrations/001_create_users_table.php` - Database migration
- `app/seeders/UserSeeder.php` - Default users seeder
- `app/controllers/Setup.php` - Setup command controller

### 🛣️ Routes Added
```php
$router->get('/auth/login', 'Auth::login');
$router->post('/auth/do_login', 'Auth::do_login');
$router->get('/auth/register', 'Auth::register');
$router->post('/auth/do_register', 'Auth::do_register');
$router->get('/auth/dashboard', 'Auth::dashboard');
$router->get('/auth/logout', 'Auth::logout');
```

### 🗄️ Database Schema
The users table includes:
- `id` - Primary key
- `name` - User's full name
- `email` - User's email (unique)
- `password` - Hashed password
- `created_at` - Registration timestamp
- `updated_at` - Last update timestamp

## Security Features

- **Password Hashing** - Uses PHP's `password_hash()` and `password_verify()`
- **Session Management** - Secure session handling
- **Input Validation** - Form validation for registration and login
- **CSRF Protection** - Built into LavaLust framework
- **SQL Injection Prevention** - Using LavaLust's query builder

## Customization

You can easily customize the authentication system:

1. **Styling** - Modify the CSS in the view files
2. **Validation** - Add more validation rules in `Auth.php`
3. **User Fields** - Add more fields to the users table and forms
4. **Redirects** - Customize redirect URLs after login/logout
5. **Permissions** - Add role-based access control

## Troubleshooting

If you encounter issues:

1. **Database Connection** - Verify your database settings in `app/config/database.php`
2. **Session Issues** - Check if sessions are enabled in your PHP configuration
3. **Migration Errors** - Make sure your database user has CREATE TABLE permissions
4. **Reset System** - Run `php console/cli.php Setup reset_auth` to reset everything

## Next Steps

1. Run the setup command
2. Test the authentication system
3. Customize the design and add your features
4. Add more protected routes and functionality

Enjoy your new authentication system! 🚀