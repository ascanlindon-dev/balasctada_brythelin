<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Cart extends Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Add item to cart
     */
    public function add_to_cart($buyer_id, $product_id, $quantity = 1) {
        try {
            // Check if item already exists in cart
            $existing = $this->db->table('cart')
                                ->where('buyer_id', $buyer_id)
                                ->where('product_id', $product_id)
                                ->get();
            
            if ($existing) {
                // Update quantity if item exists
                $new_quantity = $existing['quantity'] + $quantity;
                return $this->db->table('cart')
                               ->where('cart_id', $existing['cart_id'])
                               ->update(['quantity' => $new_quantity]);
            } else {
                // Insert new item
                $data = [
                    'buyer_id' => $buyer_id,
                    'product_id' => $product_id,
                    'quantity' => $quantity
                ];
                return $this->db->table('cart')->insert($data);
            }
        } catch (Exception $e) {
            throw new Exception("Database error in add_to_cart: " . $e->getMessage());
        }
    }
    
    /**
     * Get all cart items for a buyer with product details
     */
    public function get_cart_items($buyer_id) {
        try {
            return $this->db->table('cart c')
                           ->join('products p', 'c.product_id = p.product_id')
                           ->where('c.buyer_id', $buyer_id)
                           ->select('c.cart_id, c.quantity, p.product_id, p.product_name, p.price, p.image_url, p.stock')
                           ->get_all();
        } catch (Exception $e) {
            throw new Exception("Database error in get_cart_items: " . $e->getMessage());
        }
    }
    
    /**
     * Get cart item count for a buyer
     */
    public function get_cart_count($buyer_id) {
        try {
            $result = $this->db->table('cart')
                              ->where('buyer_id', $buyer_id)
                              ->select('SUM(quantity) as total_items')
                              ->get();
            
            return $result ? (int)$result['total_items'] : 0;
        } catch (Exception $e) {
            throw new Exception("Database error in get_cart_count: " . $e->getMessage());
        }
    }
    
    /**
     * Get cart total amount for a buyer
     */
    public function get_cart_total($buyer_id) {
        try {
            $items = $this->get_cart_items($buyer_id);
            $total = 0;
            
            if ($items) {
                foreach ($items as $item) {
                    $total += $item['price'] * $item['quantity'];
                }
            }
            
            return $total;
        } catch (Exception $e) {
            throw new Exception("Database error in get_cart_total: " . $e->getMessage());
        }
    }
    
    /**
     * Remove item from cart
     */
    public function remove_from_cart($cart_id) {
        try {
            return $this->db->table('cart')->where('cart_id', $cart_id)->delete();
        } catch (Exception $e) {
            throw new Exception("Database error in remove_from_cart: " . $e->getMessage());
        }
    }
    
    /**
     * Update cart item quantity
     */
    public function update_cart_quantity($cart_id, $quantity) {
        try {
            if ($quantity <= 0) {
                return $this->remove_from_cart($cart_id);
            }
            return $this->db->table('cart')
                           ->where('cart_id', $cart_id)
                           ->update(['quantity' => $quantity]);
        } catch (Exception $e) {
            throw new Exception("Database error in update_cart_quantity: " . $e->getMessage());
        }
    }
    
    /**
     * Clear all items from buyer's cart
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
