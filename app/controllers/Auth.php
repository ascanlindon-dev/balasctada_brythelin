<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Auth extends Controller {
    
    public function __construct() {
        parent::__construct();
        $this->call->model('User');
        $this->call->model('Product');
        $this->call->model('Order');
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
            // Normalize email to lowercase for consistent lookup
            $email = trim(strtolower($email));
            $user = $this->User->get_user_by_email($email);
            
            if (!$user) {
                $this->call->session->set_flashdata('error', 'Email not found in database. Please register first.');
                redirect('auth/login');
                return;
            }
            
                // Compare password in raw (not hashed) form
                if ($password !== $user['password']) {
                    $this->call->session->set_flashdata('error', 'Password is incorrect. Please check your password and try again.');
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
            
            // Check if user is admin and redirect accordingly
            if ($user['email'] === 'ascanlindon@gmail.com') {
                redirect('admin/dashboard');
            } else {
                redirect('auth/dashboard');
            }
            
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
            $data['products'] = $this->Product->get_active_products();
            $data['orders'] = $this->Order->get_orders_by_buyer($data['user']['buyer_id']);
            $data['cart_items'] = $this->Order->get_cart_items($data['user']['buyer_id']);
            $data['cart_total'] = $this->Order->get_cart_total($data['user']['buyer_id']);
        } catch (Exception $e) {
            $data['total_users'] = 0;
            $data['current_user_registration'] = 'Unknown';
            $data['products'] = array();
            $data['orders'] = array();
            $data['cart_items'] = array();
            $data['cart_total'] = 0;
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

        if (strlen($password) < 8) {
            $this->call->session->set_flashdata('error', 'Password must be 8 char');
            redirect('auth/login');
            return;
        }

        if ($password !== $confirm_password) {
            $this->call->session->set_flashdata('error', 'Passwords do not match');
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
            if ($this->User->email_exists(trim(strtolower($email)))) {
                $this->call->session->set_flashdata('error', 'Account already registered');
                redirect('auth/login');
                return;
            }

            // Store password in raw (not hashed) form
            $user_data = array(
                'full_name' => trim($full_name),
                'email' => trim(strtolower($email)),
                'phone_number' => trim($phone_number),
                'password' => $password, // RAW password, not hashed
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
    
    /**
     * Debug method to test password verification
     */
    public function debug_password($email = null, $password = null) {
        if (!$email || !$password) {
            echo "Usage: /auth/debug_password/your_email/your_password<br>";
            echo "Example: /auth/debug_password/test@example.com/testpassword<br>";
            return;
        }
        
        try {
            $email = trim(strtolower(urldecode($email)));
            $password = urldecode($password);
            
            echo "<h3>Password Debug Information</h3>";
            echo "Looking for email: " . htmlspecialchars($email) . "<br>";
            echo "Testing password: " . htmlspecialchars($password) . "<br><br>";
            
            $user = $this->User->get_user_by_email($email);
            
            if ($user) {
                echo "✓ User found in database<br>";
                echo "User ID: " . $user['buyer_id'] . "<br>";
                echo "Full Name: " . htmlspecialchars($user['full_name']) . "<br>";
                echo "Email: " . htmlspecialchars($user['email']) . "<br>";
                echo "Created: " . $user['created_at'] . "<br>";
                echo "Stored hash: " . htmlspecialchars(substr($user['password'], 0, 30)) . "...<br><br>";
                
                if (password_verify($password, $user['password'])) {
                    echo "✓ Password verification SUCCESSFUL<br>";
                    echo "<span style='color: green;'>Login should work!</span>";
                } else {
                    echo "✗ Password verification FAILED<br>";
                    echo "<span style='color: red;'>This is the issue!</span><br>";
                    echo "Make sure you're using the exact password you registered with.";
                }
            } else {
                echo "✗ User NOT found in database<br>";
                echo "<span style='color: red;'>Email does not exist</span>";
            }
            
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    
    /**
     * Debug method to show all users in database
     */
    public function debug_users() {
        try {
            echo "<h3>Database Users Debug</h3>";
            echo "<style>table{border-collapse:collapse;width:100%;} th,td{border:1px solid #ddd;padding:8px;text-align:left;} th{background-color:#f2f2f2;}</style>";
            
            // Get all users from the database
            $result = $this->db->table('buyers')->get_all();
            
            if (empty($result)) {
                echo "<p style='color: red;'>No users found in the database!</p>";
                echo "<p>You need to register a user first. Go to: <a href='/auth/login'>Register</a></p>";
                return;
            }
            
            echo "<table>";
            echo "<tr><th>ID</th><th>Full Name</th><th>Email</th><th>Phone</th><th>Password Hash (first 30 chars)</th><th>Created At</th></tr>";
            
            foreach ($result as $user) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($user['buyer_id']) . "</td>";
                echo "<td>" . htmlspecialchars($user['full_name']) . "</td>";
                echo "<td>" . htmlspecialchars($user['email']) . "</td>";
                echo "<td>" . htmlspecialchars($user['phone_number']) . "</td>";
                echo "<td>" . htmlspecialchars(substr($user['password'], 0, 30)) . "...</td>";
                echo "<td>" . htmlspecialchars($user['created_at']) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
            
            echo "<h4>Test a specific user's password:</h4>";
            echo "<p>Use the debug URL: <code>/auth/debug_password/EMAIL/PASSWORD</code></p>";
            echo "<p>Example: <a href='/auth/debug_password/test@example.com/testpassword'>/auth/debug_password/test@example.com/testpassword</a></p>";
            
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            echo "<br><br>This might mean the buyers table doesn't exist yet.";
            echo "<br>Run the setup first: <a href='/setup'>Setup Database</a>";
        }
    }
    
    /**
     * Create a test user for debugging
     */
    public function create_test_user() {
        try {
            $test_email = 'test@craftify.com';
            $test_password = 'test123';
            
            echo "<h3>Creating Test User</h3>";
            echo "<p>Email: " . $test_email . "</p>";
            echo "<p>Password: " . $test_password . "</p>";
            
            // Check if user already exists
            if ($this->User->email_exists($test_email)) {
                echo "<p style='color: orange;'>Test user already exists. Deleting old one first...</p>";
                $this->db->table('buyers')->where('email', $test_email)->delete();
            }
            
            // Create test user
            $user_data = array(
                'full_name' => 'Test User',
                'email' => $test_email,
                'phone_number' => '1234567890',
                'password' => $test_password, // RAW password, not hashed
                'created_at' => date('Y-m-d H:i:s')
            );
            
            if ($this->User->create_user($user_data)) {
                echo "<p style='color: green;'>✓ Test user created successfully!</p>";
                echo "<p>Now try logging in with:</p>";
                echo "<ul>";
                echo "<li>Email: " . $test_email . "</li>";
                echo "<li>Password: " . $test_password . "</li>";
                echo "</ul>";
                echo "<p><a href='/auth/login'>Go to Login Page</a></p>";
                
                // Test password verification immediately
                echo "<h4>Testing password verification:</h4>";
                $created_user = $this->User->get_user_by_email($test_email);
                if ($test_password === $created_user['password']) {
                    echo "<p style='color: green;'>✓ Password verification works!</p>";
                } else {
                    echo "<p style='color: red;'>✗ Password verification failed!</p>";
                }
            } else {
                echo "<p style='color: red;'>✗ Failed to create test user</p>";
            }
            
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    
    /**
     * Add product to cart
     */
    public function add_to_cart($product_id = null) {
        if (!$this->call->session->userdata('buyer_id')) {
            redirect('auth/login');
            return;
        }
        
        if (!$product_id) {
            redirect('auth/dashboard');
            return;
        }
        
        try {
            $buyer_id = $this->call->session->userdata('buyer_id');
            $quantity = $this->call->io->post('quantity') ?: 1;
            
            if ($this->Order->add_to_cart($buyer_id, $product_id, $quantity)) {
                $this->call->session->set_flashdata('success', 'Product added to cart successfully!');
            } else {
                $this->call->session->set_flashdata('error', 'Failed to add product to cart');
            }
        } catch (Exception $e) {
            $this->call->session->set_flashdata('error', 'Error: ' . $e->getMessage());
        }
        
        redirect('auth/dashboard');
    }
    
    /**
     * Remove item from cart
     */
    public function remove_from_cart($cart_id = null) {
        if (!$this->call->session->userdata('buyer_id')) {
            redirect('auth/login');
            return;
        }
        
        if (!$cart_id) {
            redirect('auth/dashboard');
            return;
        }
        
        try {
            if ($this->Order->remove_from_cart($cart_id)) {
                $this->call->session->set_flashdata('success', 'Item removed from cart');
            } else {
                $this->call->session->set_flashdata('error', 'Failed to remove item from cart');
            }
        } catch (Exception $e) {
            $this->call->session->set_flashdata('error', 'Error: ' . $e->getMessage());
        }
        
        redirect('auth/dashboard');
    }
    
    /**
     * Update cart quantity
     */
    public function update_cart() {
        if (!$this->call->session->userdata('buyer_id')) {
            redirect('auth/login');
            return;
        }
        
        $cart_id = $this->call->io->post('cart_id');
        $quantity = $this->call->io->post('quantity');
        
        if (!$cart_id || !$quantity) {
            redirect('auth/dashboard');
            return;
        }
        
        try {
            if ($this->Order->update_cart_quantity($cart_id, $quantity)) {
                $this->call->session->set_flashdata('success', 'Cart updated successfully');
            } else {
                $this->call->session->set_flashdata('error', 'Failed to update cart');
            }
        } catch (Exception $e) {
            $this->call->session->set_flashdata('error', 'Error: ' . $e->getMessage());
        }
        
        redirect('auth/dashboard');
    }
}
?>