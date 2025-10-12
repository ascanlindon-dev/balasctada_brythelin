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
        try {
            $result = $this->db->table('buyers')->where('email', $email)->get();
            return $result;
        } catch (Exception $e) {
            throw new Exception("Database error in get_user_by_email: " . $e->getMessage());
        }
    }
    
    /**
     * Create new user in buyers table
     */
    public function create_user($data) {
        try {
            return $this->db->table('buyers')->insert($data);
        } catch (Exception $e) {
            throw new Exception("Database error in create_user: " . $e->getMessage());
        }
    }
    
    /**
     * Get user by buyer_id
     */
    public function get_user_by_id($buyer_id) {
        try {
            return $this->db->table('buyers')->where('buyer_id', $buyer_id)->get();
        } catch (Exception $e) {
            throw new Exception("Database error in get_user_by_id: " . $e->getMessage());
        }
    }
    
    /**
     * Verify user login credentials
     */
    public function verify_login($email, $password) {
        try {
            $user = $this->get_user_by_email($email);
            
            if ($user && password_verify($password, $user['password'])) {
                return $user;
            }
            
            return false;
        } catch (Exception $e) {
            throw new Exception("Database error in verify_login: " . $e->getMessage());
        }
    }
    
    /**
     * Check if email exists
     */
    public function email_exists($email) {
        try {
            $user = $this->get_user_by_email($email);
            return !empty($user);
        } catch (Exception $e) {
            throw new Exception("Database error in email_exists: " . $e->getMessage());
        }
    }
    
    /**
     * Update user information
     */
    public function update_user($buyer_id, $data) {
        try {
            return $this->db->table('buyers')->where('buyer_id', $buyer_id)->update($data);
        } catch (Exception $e) {
            throw new Exception("Database error in update_user: " . $e->getMessage());
        }
    }
    
    /**
     * Get total number of registered users
     */
    public function get_total_users() {
        try {
            $result = $this->db->query("SELECT COUNT(*) as total FROM buyers");
            $row = $result->fetch_assoc();
            return $row['total'];
        } catch (Exception $e) {
            throw new Exception("Database error in get_total_users: " . $e->getMessage());
        }
    }
    
    /**
     * Get user registration date
     */
    public function get_user_registration_date($buyer_id) {
        try {
            $user = $this->get_user_by_id($buyer_id);
            return $user ? $user['created_at'] : null;
        } catch (Exception $e) {
            throw new Exception("Database error in get_user_registration_date: " . $e->getMessage());
        }
    }
}
?>