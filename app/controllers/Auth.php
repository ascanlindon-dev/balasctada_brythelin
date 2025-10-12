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
        $this->call->view('auth/login', $data);
    }
    
    /**
     * Process login form
     */
    public function do_login() {
        $email = $this->io->post('email');
        $password = $this->io->post('password');
        
        // Basic validation
        if (empty($email) || empty($password)) {
            $this->call->session->set_flashdata('error', 'Please fill in all fields');
            redirect('auth/login');
            return;
        }
        
        // Verify credentials
        $user = $this->User->verify_login($email, $password);
        
        if ($user) {
            // Set session data using buyers table structure
            $session_data = array(
                'buyer_id' => $user['buyer_id'],
                'email' => $user['email'],
                'full_name' => $user['full_name'],
                'phone_number' => $user['phone_number'],
                'logged_in' => true
            );
            
            $this->call->session->set_userdata($session_data);
            redirect('auth/dashboard');
        } else {
            $this->call->session->set_flashdata('error', 'Invalid email or password');
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
        $full_name = $this->io->post('full_name');
        $email = $this->io->post('email');
        $phone_number = $this->io->post('phone_number');
        $password = $this->io->post('password');
        $confirm_password = $this->io->post('confirm_password');
        
        // Basic validation
        if (empty($full_name) || empty($email) || empty($phone_number) || empty($password) || empty($confirm_password)) {
            $this->call->session->set_flashdata('error', 'Please fill in all fields');
            redirect('auth/register');
            return;
        }
        
        if ($password !== $confirm_password) {
            $this->call->session->set_flashdata('error', 'Passwords do not match');
            redirect('auth/register');
            return;
        }
        
        if (strlen($password) < 6) {
            $this->call->session->set_flashdata('error', 'Password must be at least 6 characters');
            redirect('auth/register');
            return;
        }
        
        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->call->session->set_flashdata('error', 'Please enter a valid email address');
            redirect('auth/register');
            return;
        }
        
        // Check if email already exists
        if ($this->User->email_exists($email)) {
            $this->call->session->set_flashdata('error', 'Email already exists');
            redirect('auth/register');
            return;
        }
        
        // Hash password and create user in buyers table
        $user_data = array(
            'full_name' => $full_name,
            'email' => $email,
            'phone_number' => $phone_number,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'created_at' => date('Y-m-d H:i:s')
        );
        
        if ($this->User->create_user($user_data)) {
            $this->call->session->set_flashdata('success', 'Registration successful! Please login.');
            redirect('auth/login');
        } else {
            $this->call->session->set_flashdata('error', 'Registration failed. Please try again.');
            redirect('auth/register');
        }
    }
}
?>