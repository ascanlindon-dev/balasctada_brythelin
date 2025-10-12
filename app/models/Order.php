<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Order extends Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Get orders by buyer ID
     */
    public function get_orders_by_buyer($buyer_id) {
        try {
            return $this->db->table('orders')->where('buyer_id', $buyer_id)->order_by('id', 'DESC')->get_all();
        } catch (Exception $e) {
            throw new Exception("Database error in get_orders_by_buyer: " . $e->getMessage());
        }
    }
    
    /**
     * Get order by ID
     */
    public function get_order_by_id($order_id) {
        try {
            return $this->db->table('orders')->where('id', $order_id)->get();
        } catch (Exception $e) {
            throw new Exception("Database error in get_order_by_id: " . $e->getMessage());
        }
    }
    
    /**
     * Create new order
     */
    public function create_order($data) {
        try {
            return $this->db->table('orders')->insert($data);
        } catch (Exception $e) {
            throw new Exception("Database error in create_order: " . $e->getMessage());
        }
    }
    
    /**
     * Get cart items by buyer ID
     */
    public function get_cart_items($buyer_id) {
        try {
            $sql = "SELECT c.*, p.name, p.price, p.image_url, (c.quantity * p.price) as total_price 
                    FROM cart c 
                    JOIN products p ON c.product_id = p.id 
                    WHERE c.buyer_id = ?";
            $stmt = $this->db->raw($sql, [$buyer_id]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            throw new Exception("Database error in get_cart_items: " . $e->getMessage());
        }
    }
    
    /**
     * Add item to cart
     */
    public function add_to_cart($buyer_id, $product_id, $quantity = 1) {
        try {
            // Check if item already exists in cart
            $existing = $this->db->table('cart')->where('buyer_id', $buyer_id)->where('product_id', $product_id)->get();
            
            if ($existing) {
                // Update quantity
                $new_quantity = $existing['quantity'] + $quantity;
                return $this->db->table('cart')->where('id', $existing['id'])->update(['quantity' => $new_quantity]);
            } else {
                // Add new item
                $data = array(
                    'buyer_id' => $buyer_id,
                    'product_id' => $product_id,
                    'quantity' => $quantity,
                    'created_at' => date('Y-m-d H:i:s')
                );
                return $this->db->table('cart')->insert($data);
            }
        } catch (Exception $e) {
            throw new Exception("Database error in add_to_cart: " . $e->getMessage());
        }
    }
    
    /**
     * Remove item from cart
     */
    public function remove_from_cart($cart_id) {
        try {
            return $this->db->table('cart')->where('id', $cart_id)->delete();
        } catch (Exception $e) {
            throw new Exception("Database error in remove_from_cart: " . $e->getMessage());
        }
    }
    
    /**
     * Update cart item quantity
     */
    public function update_cart_quantity($cart_id, $quantity) {
        try {
            return $this->db->table('cart')->where('id', $cart_id)->update(['quantity' => $quantity]);
        } catch (Exception $e) {
            throw new Exception("Database error in update_cart_quantity: " . $e->getMessage());
        }
    }
    
    /**
     * Get cart total
     */
    public function get_cart_total($buyer_id) {
        try {
            $sql = "SELECT SUM(c.quantity * p.price) as total 
                    FROM cart c 
                    JOIN products p ON c.product_id = p.id 
                    WHERE c.buyer_id = ?";
            $stmt = $this->db->raw($sql, [$buyer_id]);
            $result = $stmt->fetch();
            return $result['total'] ?: 0;
        } catch (Exception $e) {
            throw new Exception("Database error in get_cart_total: " . $e->getMessage());
        }
    }
    
    /**
     * Clear cart
     */
    public function clear_cart($buyer_id) {
        try {
            return $this->db->table('cart')->where('buyer_id', $buyer_id)->delete();
        } catch (Exception $e) {
            throw new Exception("Database error in clear_cart: " . $e->getMessage());
        }
    }
}
?>