<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class CartController extends Controller {
    
    public function __construct() {
        parent::__construct();
        $this->call->model('Cart');
        $this->call->model('Product');
        $this->call->model('User');
    }
    
    /**
     * Check if user is logged in
     */
    private function check_auth() {
        if (!$this->call->session->userdata('buyer_id')) {
            $this->call->session->set_flashdata('error', 'Please login to access cart');
            redirect('auth/login');
            return false;
        }
        return true;
    }
    
    /**
     * Display cart items
     */
    public function index() {
        if (!$this->check_auth()) return;
        
        $buyer_id = $this->call->session->userdata('buyer_id');
        
        try {
            $data['cart_items'] = $this->Cart->get_cart_items($buyer_id);
            $data['cart_total'] = $this->Cart->get_cart_total($buyer_id);
            $data['cart_count'] = $this->Cart->get_cart_count($buyer_id);
            
            // Validate cart items
            $data['invalid_items'] = $this->Cart->validate_cart($buyer_id);
            
            $this->call->view('cart/index', $data);
        } catch (Exception $e) {
            $this->call->session->set_flashdata('error', 'Error loading cart: ' . $e->getMessage());
            redirect('auth/dashboard');
        }
    }
    
    /**
     * Add item to cart (AJAX)
     */
    public function add() {
        if (!$this->check_auth()) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => 'Please login first']);
            return;
        }
        
        $buyer_id = $this->call->session->userdata('buyer_id');
        $product_id = $this->call->io->post('product_id');
        $quantity = $this->call->io->post('quantity') ?: 1;
        
        // Validate input
        if (!$product_id || $quantity <= 0) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => 'Invalid product or quantity']);
            return;
        }
        
        try {
            // Check if product exists and has enough stock
            $product = $this->Product->get_product_by_id($product_id);
            if (!$product) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Product not found']);
                return;
            }
            
            if ($product['stock'] < $quantity) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Not enough stock available']);
                return;
            }
            
            // Add to cart
            $result = $this->Cart->add_to_cart($buyer_id, $product_id, $quantity);
            
            if ($result) {
                $cart_count = $this->Cart->get_cart_count($buyer_id);
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Item added to cart successfully',
                    'cart_count' => $cart_count
                ]);
            } else {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Failed to add item to cart']);
            }
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
        }
    }
    
    /**
     * Update cart item quantity
     */
    public function update() {
        if (!$this->check_auth()) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => 'Please login first']);
            return;
        }
        
        $cart_id = $this->call->io->post('cart_id');
        $quantity = $this->call->io->post('quantity');
        
        if (!$cart_id || $quantity < 0) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => 'Invalid cart item or quantity']);
            return;
        }
        
        try {
            // Verify cart item belongs to current user
            $cart_item = $this->Cart->get_cart_item($cart_id);
            $buyer_id = $this->call->session->userdata('buyer_id');
            
            if (!$cart_item || $cart_item['buyer_id'] != $buyer_id) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Cart item not found']);
                return;
            }
            
            // Check product stock if increasing quantity
            if ($quantity > 0) {
                $product = $this->Product->get_product_by_id($cart_item['product_id']);
                if (!$product || $product['stock'] < $quantity) {
                    header('Content-Type: application/json');
                    echo json_encode(['status' => 'error', 'message' => 'Not enough stock available']);
                    return;
                }
            }
            
            $result = $this->Cart->update_cart_quantity($cart_id, $quantity);
            
            if ($result) {
                $cart_count = $this->Cart->get_cart_count($buyer_id);
                $cart_total = $this->Cart->get_cart_total($buyer_id);
                
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Cart updated successfully',
                    'cart_count' => $cart_count,
                    'cart_total' => number_format($cart_total, 2)
                ]);
            } else {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Failed to update cart']);
            }
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
        }
    }
    
    /**
     * Remove item from cart
     */
    public function remove() {
        if (!$this->check_auth()) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => 'Please login first']);
            return;
        }
        
        $cart_id = $this->call->io->post('cart_id');
        
        if (!$cart_id) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => 'Invalid cart item']);
            return;
        }
        
        try {
            // Verify cart item belongs to current user
            $cart_item = $this->Cart->get_cart_item($cart_id);
            $buyer_id = $this->call->session->userdata('buyer_id');
            
            if (!$cart_item || $cart_item['buyer_id'] != $buyer_id) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Cart item not found']);
                return;
            }
            
            $result = $this->Cart->remove_from_cart($cart_id);
            
            if ($result) {
                $cart_count = $this->Cart->get_cart_count($buyer_id);
                $cart_total = $this->Cart->get_cart_total($buyer_id);
                
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Item removed from cart',
                    'cart_count' => $cart_count,
                    'cart_total' => number_format($cart_total, 2)
                ]);
            } else {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Failed to remove item']);
            }
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
        }
    }
    
    /**
     * Clear entire cart
     */
    public function clear() {
        if (!$this->check_auth()) return;
        
        $buyer_id = $this->call->session->userdata('buyer_id');
        
        try {
            $result = $this->Cart->clear_cart($buyer_id);
            
            if ($result) {
                $this->call->session->set_flashdata('success', 'Cart cleared successfully');
            } else {
                $this->call->session->set_flashdata('error', 'Failed to clear cart');
            }
        } catch (Exception $e) {
            $this->call->session->set_flashdata('error', 'Error: ' . $e->getMessage());
        }
        
        redirect('cart');
    }
    
    /**
     * Get cart count (AJAX)
     */
    public function get_count() {
        if (!$this->call->session->userdata('buyer_id')) {
            header('Content-Type: application/json');
            echo json_encode(['cart_count' => 0]);
            return;
        }
        
        $buyer_id = $this->call->session->userdata('buyer_id');
        
        try {
            $count = $this->Cart->get_cart_count($buyer_id);
            header('Content-Type: application/json');
            echo json_encode(['cart_count' => $count]);
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(['cart_count' => 0]);
        }
    }
    
    /**
     * Check if product is in cart (AJAX)
     */
    public function check_product() {
        if (!$this->call->session->userdata('buyer_id')) {
            header('Content-Type: application/json');
            echo json_encode(['in_cart' => false]);
            return;
        }
        
        $buyer_id = $this->call->session->userdata('buyer_id');
        $product_id = $this->call->io->post('product_id');
        
        if (!$product_id) {
            header('Content-Type: application/json');
            echo json_encode(['in_cart' => false]);
            return;
        }
        
        try {
            $in_cart = $this->Cart->is_in_cart($buyer_id, $product_id);
            header('Content-Type: application/json');
            echo json_encode(['in_cart' => $in_cart]);
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(['in_cart' => false]);
        }
    }
}
?>