<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Setup_web extends Controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Web-based setup for authentication system
     */
    public function index() {
        echo "<h1>CRAFTIFY Authentication Setup</h1>";
        echo "<style>body{font-family:Arial;padding:20px;} .success{color:green;} .error{color:red;} pre{background:#f5f5f5;padding:10px;}</style>";
        
        try {
            // Test database connection
            echo "<h2>1. Testing Database Connection...</h2>";
            $this->call->library('database');
            echo "<div class='success'>✓ Database connection successful</div>";
            
            // Check if buyers table exists
            echo "<h2>2. Checking buyers table...</h2>";
            $query = $this->call->database->query("SHOW TABLES LIKE 'buyers'");
            $table_exists = $query->num_rows() > 0;
            
            if (!$table_exists) {
                echo "<div class='error'>✗ Buyers table does not exist. Creating...</div>";
                
                // Create buyers table
                $create_table = "
                CREATE TABLE buyers (
                    buyer_id INT(11) AUTO_INCREMENT PRIMARY KEY,
                    full_name VARCHAR(150) NOT NULL,
                    email VARCHAR(150) NOT NULL UNIQUE,
                    phone_number VARCHAR(20) NOT NULL,
                    password VARCHAR(255) NOT NULL,
                    created_at DATETIME NULL
                )";
                
                if ($this->call->database->query($create_table)) {
                    echo "<div class='success'>✓ Buyers table created successfully</div>";
                } else {
                    echo "<div class='error'>✗ Failed to create buyers table</div>";
                }
            } else {
                echo "<div class='success'>✓ Buyers table exists</div>";
            }
            
            // Check for test users
            echo "<h2>3. Checking test users...</h2>";
            $admin_check = $this->call->database->query("SELECT * FROM buyers WHERE email = 'admin@craftify.com'");
            
            if ($admin_check->num_rows() == 0) {
                echo "<div class='error'>✗ Admin user does not exist. Creating...</div>";
                
                // Create admin user
                $admin_data = array(
                    'full_name' => 'Admin User',
                    'email' => 'admin@craftify.com',
                    'phone_number' => '+1234567890',
                    'password' => password_hash('admin123', PASSWORD_DEFAULT),
                    'created_at' => date('Y-m-d H:i:s')
                );
                
                if ($this->call->database->table('buyers')->insert($admin_data)) {
                    echo "<div class='success'>✓ Admin user created (admin@craftify.com / admin123)</div>";
                } else {
                    echo "<div class='error'>✗ Failed to create admin user</div>";
                }
            } else {
                echo "<div class='success'>✓ Admin user exists</div>";
            }
            
            // Check for regular user
            $user_check = $this->call->database->query("SELECT * FROM buyers WHERE email = 'user@craftify.com'");
            
            if ($user_check->num_rows() == 0) {
                echo "<div class='error'>✗ Test user does not exist. Creating...</div>";
                
                // Create test user
                $user_data = array(
                    'full_name' => 'Test User',
                    'email' => 'user@craftify.com',
                    'phone_number' => '+0987654321',
                    'password' => password_hash('user123', PASSWORD_DEFAULT),
                    'created_at' => date('Y-m-d H:i:s')
                );
                
                if ($this->call->database->table('buyers')->insert($user_data)) {
                    echo "<div class='success'>✓ Test user created (user@craftify.com / user123)</div>";
                } else {
                    echo "<div class='error'>✗ Failed to create test user</div>";
                }
            } else {
                echo "<div class='success'>✓ Test user exists</div>";
            }
            
            // List all users
            echo "<h2>4. Current Users in Database:</h2>";
            $all_users = $this->call->database->query("SELECT buyer_id, full_name, email, phone_number, created_at FROM buyers ORDER BY buyer_id");
            
            if ($all_users->num_rows() > 0) {
                echo "<table border='1' style='border-collapse:collapse; width:100%;'>";
                echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Created</th></tr>";
                
                while ($row = $all_users->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['buyer_id'] . "</td>";
                    echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['phone_number']) . "</td>";
                    echo "<td>" . $row['created_at'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<div class='error'>No users found in database</div>";
            }
            
            echo "<h2>5. Test Login</h2>";
            echo "<p>You can now test the login system:</p>";
            echo "<ul>";
            echo "<li><strong>Admin:</strong> admin@craftify.com / admin123</li>";
            echo "<li><strong>User:</strong> user@craftify.com / user123</li>";
            echo "</ul>";
            echo "<p><a href='" . site_url('auth/login') . "' style='background:#667eea;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;'>Go to Login Page</a></p>";
            
        } catch (Exception $e) {
            echo "<div class='error'>Error: " . $e->getMessage() . "</div>";
            echo "<pre>" . $e->getTraceAsString() . "</pre>";
        }
    }
    
    /**
     * Reset the authentication system
     */
    public function reset() {
        echo "<h1>Resetting Authentication System</h1>";
        echo "<style>body{font-family:Arial;padding:20px;} .success{color:green;} .error{color:red;}</style>";
        
        try {
            $this->call->library('database');
            
            // Drop table if exists
            echo "<h2>Dropping buyers table...</h2>";
            $this->call->database->query("DROP TABLE IF EXISTS buyers");
            echo "<div class='success'>✓ Table dropped</div>";
            
            // Redirect back to setup
            echo "<p><a href='" . site_url('setup_web') . "'>Run Setup Again</a></p>";
            
        } catch (Exception $e) {
            echo "<div class='error'>Error: " . $e->getMessage() . "</div>";
        }
    }
}
?>