<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Auth extends Controller {
    
    public function __construct() {
        parent::__construct();
        $this->call->model('User');
    }
    
    /**
     * Display login form
     */
    public function login() {
        // If user is already logged in, redirect to dashboard
        if ($this->call->session->userdata('buyer_id')) {
            redirect('auth/dashboard');
        }
        
        $data['error'] = $this->call->session->flashdata('error');
        $data['success'] = $this->call->session->flashdata('success');
        $this->call->view('auth/login', $data);
    }
    
    /**
     * Process login form
     */
    public function do_login() {
        $email = $this->call->io->post('email');
        $password = $this->call->io->post('password');
        
        // Basic validation
        if (empty($email) || empty($password)) {
            $this->call->session->set_flashdata('error', 'Please fill in all fields');
            redirect('auth/login');
            return;
        }
        
        // Debug: Check if user exists in database
        try {
            $user = $this->User->get_user_by_email($email);
            
            if (!$user) {
                $this->call->session->set_flashdata('error', 'Email not found in database. Please register first or use: admin@craftify.com / admin123');
                redirect('auth/login');
                return;
            }
            
            // Debug: Check password verification
            if (!password_verify($password, $user['password'])) {
                $this->call->session->set_flashdata('error', 'Password is incorrect. For testing use: admin@craftify.com / admin123');
                redirect('auth/login');
                return;
            }
            
            // If we reach here, login is successful
            $session_data = array(
                'buyer_id' => $user['buyer_id'],
                'email' => $user['email'],
                'full_name' => $user['full_name'],
                'phone_number' => $user['phone_number'],
                'logged_in' => true
            );
            
            $this->call->session->set_userdata($session_data);
            redirect('auth/dashboard');
            
        } catch (Exception $e) {
            $this->call->session->set_flashdata('error', 'Database error: ' . $e->getMessage() . ' - Please run setup first: /setup');
            redirect('auth/login');
        }
    }
    
    /**
     * Display dashboard (protected page)
     */
    public function dashboard() {
        // Check if user is logged in
        if (!$this->call->session->userdata('buyer_id')) {
            redirect('auth/login');
            return;
        }
        
        $data['user'] = array(
            'buyer_id' => $this->call->session->userdata('buyer_id'),
            'email' => $this->call->session->userdata('email'),
            'full_name' => $this->call->session->userdata('full_name'),
            'phone_number' => $this->call->session->userdata('phone_number')
        );
        
        // Get real statistics from database
        try {
            $data['total_users'] = $this->User->get_total_users();
            $data['current_user_registration'] = $this->User->get_user_registration_date($data['user']['buyer_id']);
        } catch (Exception $e) {
            $data['total_users'] = 0;
            $data['current_user_registration'] = 'Unknown';
        }
        
        $this->call->view('auth/dashboard', $data);
    }
    
    /**
     * Logout user
     */
    public function logout() {
        $this->call->session->sess_destroy();
        redirect('auth/login');
    }
    
    /**
     * Display registration form
     */
    public function register() {
        // If user is already logged in, redirect to dashboard
        if ($this->call->session->userdata('buyer_id')) {
            redirect('auth/dashboard');
        }
        
        $data['error'] = $this->call->session->flashdata('error');
        $data['success'] = $this->call->session->flashdata('success');
        $this->call->view('auth/register', $data);
    }
    
    /**
     * Process registration form
     */
    public function do_register() {
        $full_name = $this->call->io->post('full_name');
        $email = $this->call->io->post('email');
        $phone_number = $this->call->io->post('phone_number');
        $password = $this->call->io->post('password');
        $confirm_password = $this->call->io->post('confirm_password');
        
        // Basic validation
        if (empty($full_name) || empty($email) || empty($phone_number) || empty($password) || empty($confirm_password)) {
            $this->call->session->set_flashdata('error', 'Please fill in all fields');
            redirect('auth/login');
            return;
        }
        
        if ($password !== $confirm_password) {
            $this->call->session->set_flashdata('error', 'Passwords do not match');
            redirect('auth/login');
            return;
        }
        
        if (strlen($password) < 6) {
            $this->call->session->set_flashdata('error', 'Password must be at least 6 characters');
            redirect('auth/login');
            return;
        }
        
        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->call->session->set_flashdata('error', 'Please enter a valid email address');
            redirect('auth/login');
            return;
        }
        
        // Check if email already exists
        try {
            if ($this->User->email_exists($email)) {
                $this->call->session->set_flashdata('error', 'Email already exists. Please use a different email or try logging in.');
                redirect('auth/login');
                return;
            }
            
            // Hash password and create user in buyers table
            $user_data = array(
                'full_name' => trim($full_name),
                'email' => trim(strtolower($email)),
                'phone_number' => trim($phone_number),
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s')
            );
            
            if ($this->User->create_user($user_data)) {
                $this->call->session->set_flashdata('success', 'Registration successful! You can now login with your credentials.');
                redirect('auth/login');
            } else {
                $this->call->session->set_flashdata('error', 'Registration failed. Please try again.');
                redirect('auth/login');
            }
            
        } catch (Exception $e) {
            $this->call->session->set_flashdata('error', 'Database error during registration: ' . $e->getMessage() . ' - Please ensure database is set up properly.');
            redirect('auth/login');
        }
    }
}
?>