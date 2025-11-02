<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Setup extends Controller {
    
    public function __construct() {
        parent::__construct();
        $this->call->model('User');
    }
    
    /**
     * Manually run migrations for development
     */
    public function run_migrations() {
        echo "<h2>Running Migrations</h2>";
        
        try {
            // Load migration library
            $this->call->library('Migration');
            
            // Include migration files
            require_once APPPATH . 'migrations/001_create_users_table.php';
            require_once APPPATH . 'migrations/002_new_tables.php';
            
            // Run first migration
            echo "<h3>Running 001_create_users_table</h3>";
            $migration1 = new Create_buyers_table();
            $migration1->up();
            
            // Run second migration
            echo "<h3>Running 002_new_tables</h3>";
            $migration2 = new Migration_NewTables();
            $migration2->up();
            
            echo "<p style='color: green;'>✅ All migrations completed successfully!</p>";
            
        } catch (Exception $e) {
            echo "<p style='color: red;'>❌ Migration failed: " . $e->getMessage() . "</p>";
        }
        
        echo "<br><a href='" . site_url('auth/dashboard') . "'>Back to Dashboard</a>";
    }
    
    /**
     * Check session and database status
     */
    public function debug_session() {
        echo "<h2>Session Debug Information</h2>";
        
        echo "<h3>Session Data:</h3>";
        echo "<pre>";
        print_r($this->call->session->all_userdata());
        echo "</pre>";
        
        echo "<h3>Database Tables:</h3>";
        try {
            $tables = $this->db->query("SHOW TABLES")->result_array();
            echo "<pre>";
            print_r($tables);
            echo "</pre>";
        } catch (Exception $e) {
            echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
        }
        
        echo "<br><a href='" . site_url('auth/dashboard') . "'>Back to Dashboard</a>";
    }
    
    /**
     * Create cart table manually
     */
    public function create_cart_table() {
        echo "<h2>Creating Cart Table</h2>";
        
        try {
            $sql = "CREATE TABLE IF NOT EXISTS cart (
                cart_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                buyer_id INT UNSIGNED NOT NULL,
                product_id INT UNSIGNED NOT NULL,
                quantity INT NOT NULL DEFAULT 1,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (buyer_id) REFERENCES buyers(buyer_id) ON DELETE CASCADE ON UPDATE CASCADE,
                FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB";
            
            $this->db->query($sql);
            echo "<p style='color: green;'>✅ Cart table created successfully!</p>";
            
            // Verify table exists
            $tables = $this->db->query("SHOW TABLES LIKE 'cart'")->result_array();
            if (!empty($tables)) {
                echo "<p style='color: green;'>✅ Cart table verified to exist</p>";
                
                // Show table structure
                $structure = $this->db->query("DESCRIBE cart")->result_array();
                echo "<h3>Cart Table Structure:</h3>";
                echo "<pre>";
                print_r($structure);
                echo "</pre>";
            }
            
        } catch (Exception $e) {
            echo "<p style='color: red;'>❌ Error creating cart table: " . $e->getMessage() . "</p>";
        }
        
        echo "<br><a href='" . site_url('auth/dashboard') . "'>Back to Dashboard</a>";
    }
}
?>