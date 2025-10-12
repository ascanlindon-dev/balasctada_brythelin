<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class User extends Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Get user by email from buyers table
     */
    public function get_user_by_email($email) {
        return $this->db->table('buyers')->where('email', $email)->get();
    }
    
    /**
     * Create new user in buyers table
     */
    public function create_user($data) {
        return $this->db->table('buyers')->insert($data);
    }
    
    /**
     * Get user by buyer_id
     */
    public function get_user_by_id($buyer_id) {
        return $this->db->table('buyers')->where('buyer_id', $buyer_id)->get();
    }
    
    /**
     * Verify user login credentials
     */
    public function verify_login($email, $password) {
        $user = $this->get_user_by_email($email);
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        
        return false;
    }
    
    /**
     * Check if email exists
     */
    public function email_exists($email) {
        $user = $this->get_user_by_email($email);
        return !empty($user);
    }
    
    /**
     * Update user information
     */
    public function update_user($buyer_id, $data) {
        return $this->db->table('buyers')->where('buyer_id', $buyer_id)->update($data);
    }
}
?>