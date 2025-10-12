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
            $stmt = $this->call->database->raw("SHOW TABLES LIKE 'buyers'");
            $query = $stmt->fetchAll();
            $table_exists = count($query) > 0;
            
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
                
                if ($this->call->database->raw($create_table)) {
                    echo "<div class='success'>✓ Buyers table created successfully</div>";
                } else {
                    echo "<div class='error'>✗ Failed to create buyers table</div>";
                }
            } else {
                echo "<div class='success'>✓ Buyers table exists</div>";
            }
            
            // Check if products table exists
            echo "<h2>2b. Checking products table...</h2>";
            $stmt = $this->call->database->raw("SHOW TABLES LIKE 'products'");
            $query = $stmt->fetchAll();
            $products_table_exists = count($query) > 0;
            
            if (!$products_table_exists) {
                echo "<div class='error'>✗ Products table does not exist. Creating...</div>";
                
                // Create products table
                $create_products_table = "
                CREATE TABLE products (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(100) NOT NULL,
                    description TEXT,
                    price DECIMAL(10, 2) NOT NULL,
                    stock INT DEFAULT 1,
                    image_url VARCHAR(255),
                    created_by VARCHAR(255)
                )";
                
                if ($this->call->database->raw($create_products_table)) {
                    echo "<div class='success'>✓ Products table created successfully</div>";
                    
                    // Add some sample products
                    $sample_products = array(
                        array(
                            'name' => 'Handcrafted Wooden Bowl',
                            'description' => 'Beautiful handcrafted wooden bowl made from premium oak wood.',
                            'price' => 29.99,
                            'stock' => 15,
                            'image_url' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=400',
                            'created_by' => 'ascanlindon@gmail.com'
                        ),
                        array(
                            'name' => 'Ceramic Coffee Mug',
                            'description' => 'Hand-painted ceramic coffee mug with unique designs.',
                            'price' => 15.50,
                            'stock' => 30,
                            'image_url' => 'https://images.unsplash.com/photo-1544787219-7f47ccb76574?w=400',
                            'created_by' => 'ascanlindon@gmail.com'
                        ),
                        array(
                            'name' => 'Artisan Leather Wallet',
                            'description' => 'Premium leather wallet with multiple card slots and coin pocket.',
                            'price' => 45.00,
                            'stock' => 20,
                            'image_url' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=400',
                            'created_by' => 'ascanlindon@gmail.com'
                        )
                    );
                    
                    foreach ($sample_products as $product) {
                        $this->call->database->table('products')->insert($product);
                    }
                    
                    echo "<div class='success'>✓ Sample products added</div>";
                } else {
                    echo "<div class='error'>✗ Failed to create products table</div>";
                }
            } else {
                echo "<div class='success'>✓ Products table exists</div>";
            }
            
            // Check if orders table exists
            echo "<h2>2c. Checking orders table...</h2>";
            $stmt = $this->call->database->raw("SHOW TABLES LIKE 'orders'");
            $query = $stmt->fetchAll();
            $orders_table_exists = count($query) > 0;
            
            if (!$orders_table_exists) {
                echo "<div class='error'>✗ Orders table does not exist. Creating...</div>";
                
                // Create orders table
                $create_orders_table = "
                CREATE TABLE orders (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    buyer_id INT NOT NULL,
                    total_amount DECIMAL(10,2) NOT NULL,
                    status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
                    shipping_address TEXT,
                    created_at DATETIME NULL,
                    FOREIGN KEY (buyer_id) REFERENCES buyers(buyer_id)
                )";
                
                if ($this->call->database->raw($create_orders_table)) {
                    echo "<div class='success'>✓ Orders table created successfully</div>";
                } else {
                    echo "<div class='error'>✗ Failed to create orders table</div>";
                }
            } else {
                echo "<div class='success'>✓ Orders table exists</div>";
            }
            
            // Check if cart table exists
            echo "<h2>2d. Checking cart table...</h2>";
            $stmt = $this->call->database->raw("SHOW TABLES LIKE 'cart'");
            $query = $stmt->fetchAll();
            $cart_table_exists = count($query) > 0;
            
            if (!$cart_table_exists) {
                echo "<div class='error'>✗ Cart table does not exist. Creating...</div>";
                
                // Create cart table
                $create_cart_table = "
                CREATE TABLE cart (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    buyer_id INT NOT NULL,
                    product_id INT NOT NULL,
                    quantity INT DEFAULT 1,
                    created_at DATETIME NULL,
                    FOREIGN KEY (buyer_id) REFERENCES buyers(buyer_id),
                    FOREIGN KEY (product_id) REFERENCES products(id)
                )";
                
                if ($this->call->database->raw($create_cart_table)) {
                    echo "<div class='success'>✓ Cart table created successfully</div>";
                } else {
                    echo "<div class='error'>✗ Failed to create cart table</div>";
                }
            } else {
                echo "<div class='success'>✓ Cart table exists</div>";
            }
            
            // Check for test users
            echo "<h2>3. Checking admin and test users...</h2>";
            
            // Check for main admin user
            $stmt = $this->call->database->raw("SELECT * FROM buyers WHERE email = 'ascanlindon@gmail.com'");
            $main_admin_check = $stmt->fetchAll();
            
            if (count($main_admin_check) == 0) {
                echo "<div class='error'>✗ Main admin user does not exist. Creating...</div>";
                
                // Create main admin user
                $main_admin_data = array(
                    'full_name' => 'Admin Ascanlindon',
                    'email' => 'ascanlindon@gmail.com',
                    'phone_number' => '+1234567890',
                    'password' => 'admin123', // RAW password, not hashed
                    'created_at' => date('Y-m-d H:i:s')
                );
                
                if ($this->call->database->table('buyers')->insert($main_admin_data)) {
                    echo "<div class='success'>✓ Main admin user created (ascanlindon@gmail.com / admin123)</div>";
                } else {
                    echo "<div class='error'>✗ Failed to create main admin user</div>";
                }
            } else {
                echo "<div class='success'>✓ Main admin user exists</div>";
            }
            
            $stmt = $this->call->database->raw("SELECT * FROM buyers WHERE email = 'admin@craftify.com'");
            $admin_check = $stmt->fetchAll();
            
            if (count($admin_check) == 0) {
                echo "<div class='error'>✗ Admin user does not exist. Creating...</div>";
                
                // Create admin user
                $admin_data = array(
                    'full_name' => 'Admin User',
                    'email' => 'admin@craftify.com',
                    'phone_number' => '+1234567890',
                    'password' => 'admin123', // RAW password, not hashed
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
            $stmt = $this->call->database->raw("SELECT * FROM buyers WHERE email = 'user@craftify.com'");
            $user_check = $stmt->fetchAll();
            
            if (count($user_check) == 0) {
                echo "<div class='error'>✗ Test user does not exist. Creating...</div>";
                
                // Create test user
                $user_data = array(
                    'full_name' => 'Test User',
                    'email' => 'user@craftify.com',
                    'phone_number' => '+0987654321',
                    'password' => 'user123', // RAW password, not hashed
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
            $stmt = $this->call->database->raw("SELECT buyer_id, full_name, email, phone_number, created_at FROM buyers ORDER BY buyer_id");
            $all_users = $stmt->fetchAll();
            
            if (count($all_users) > 0) {
                echo "<table border='1' style='border-collapse:collapse; width:100%;'>";
                echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Created</th></tr>";
                
                foreach ($all_users as $row) {
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
            $this->call->database->raw("DROP TABLE IF EXISTS buyers");
            echo "<div class='success'>✓ Table dropped</div>";
            
            // Redirect back to setup
            echo "<p><a href='" . site_url('setup_web') . "'>Run Setup Again</a></p>";
            
        } catch (Exception $e) {
            echo "<div class='error'>Error: " . $e->getMessage() . "</div>";
        }
    }
}
?>