<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class UserSeeder {
    
    private $db;
    
    public function __construct() {
        $this->db = database();
    }
    
    public function run() {
        // Check if admin user already exists
        $existing_admin = $this->db->table('buyers')->where('email', 'admin@craftify.com')->get();
        
        if (!$existing_admin) {
            // Create default admin user
            $admin_data = array(
                'full_name' => 'Admin User',
                'email' => 'admin@craftify.com',
                'phone_number' => '+1234567890',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s')
            );
            
            $this->db->table('buyers')->insert($admin_data);
            echo "Default admin user created successfully.\n";
            echo "Email: admin@craftify.com\n";
            echo "Password: admin123\n";
        } else {
            echo "Admin user already exists.\n";
        }
        
        // Create sample user
        $existing_user = $this->db->table('buyers')->where('email', 'user@craftify.com')->get();
        
        if (!$existing_user) {
            $user_data = array(
                'full_name' => 'Sample User',
                'email' => 'user@craftify.com',
                'phone_number' => '+0987654321',
                'password' => password_hash('user123', PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s')
            );
            
            $this->db->table('buyers')->insert($user_data);
            echo "Sample user created successfully.\n";
            echo "Email: user@craftify.com\n";
            echo "Password: user123\n";
        } else {
            echo "Sample user already exists.\n";
        }
    }
}
?>