<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Setup extends Controller {
    
    public function __construct() {
        parent::__construct();
        
        // Only allow CLI access
        if (!is_cli()) {
            exit('Access denied. This script can only be run from command line.');
        }
    }
    
    /**
     * Setup the authentication system
     */
    public function auth() {
        echo "Setting up authentication system...\n";
        echo "=====================================\n\n";
        
        try {
            // Run migration
            echo "1. Creating buyers table...\n";
            $this->call->library('migration');
            $this->migration->version(1);
            
            // Run seeder
            echo "\n2. Creating default users...\n";
            require_once APPPATH . 'seeders/UserSeeder.php';
            $seeder = new UserSeeder();
            $seeder->run();
            
            echo "\n=====================================\n";
            echo "Authentication system setup complete!\n";
            echo "=====================================\n\n";
            
            echo "You can now access the login system at:\n";
            echo "- Login: " . site_url('auth/login') . "\n";
            echo "- Register: " . site_url('auth/register') . "\n\n";
            
            echo "Default users created:\n";
            echo "- Admin: admin@craftify.com / admin123\n";
            echo "- User: user@craftify.com / user123\n\n";
            
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "\n";
        }
    }
    
    /**
     * Reset authentication system
     */
    public function reset_auth() {
        echo "Resetting authentication system...\n";
        echo "==================================\n\n";
        
        try {
            // Drop and recreate table
            echo "1. Dropping buyers table...\n";
            $this->call->library('migration');
            $this->migration->version(0);
            
            echo "2. Recreating buyers table...\n";
            $this->migration->version(1);
            
            echo "3. Recreating default users...\n";
            require_once APPPATH . 'seeders/UserSeeder.php';
            $seeder = new UserSeeder();
            $seeder->run();
            
            echo "\n==================================\n";
            echo "Authentication system reset complete!\n";
            echo "==================================\n\n";
            
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "\n";
        }
    }
}
?>