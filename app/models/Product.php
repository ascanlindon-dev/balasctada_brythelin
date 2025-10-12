<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Product extends Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Get all products
     */
    public function get_all_products() {
        try {
            return $this->db->table('products')->order_by('product_id', 'DESC')->get_all();
        } catch (Exception $e) {
            throw new Exception("Database error in get_all_products: " . $e->getMessage());
        }
    }
    
    /**
     * Get product by ID
     */
    public function get_product_by_id($product_id) {
        try {
            return $this->db->table('products')->where('product_id', $product_id)->get();
        } catch (Exception $e) {
            throw new Exception("Database error in get_product_by_id: " . $e->getMessage());
        }
    }
    
    /**
     * Create new product
     */
    public function create_product($data) {
        try {
            return $this->db->table('products')->insert($data);
        } catch (Exception $e) {
            throw new Exception("Database error in create_product: " . $e->getMessage());
        }
    }
    
    /**
     * Update product
     */
    public function update_product($product_id, $data) {
        try {
            return $this->db->table('products')->where('product_id', $product_id)->update($data);
        } catch (Exception $e) {
            throw new Exception("Database error in update_product: " . $e->getMessage());
        }
    }
    
    /**
     * Delete product
     */
    public function delete_product($product_id) {
        try {
            return $this->db->table('products')->where('product_id', $product_id)->delete();
        } catch (Exception $e) {
            throw new Exception("Database error in delete_product: " . $e->getMessage());
        }
    }
    
    /**
     * Get total number of products
     */
    public function get_total_products() {
        try {
            return $this->db->table('products')->count();
        } catch (Exception $e) {
            throw new Exception("Database error in get_total_products: " . $e->getMessage());
        }
    }
    
    /**
     * Get products by category
     */
    public function get_products_by_category($category) {
        try {
            return $this->db->table('products')->where('category', $category)->get_all();
        } catch (Exception $e) {
            throw new Exception("Database error in get_products_by_category: " . $e->getMessage());
        }
    }
    
    /**
     * Get active products
     */
    public function get_active_products() {
        try {
            return $this->db->table('products')->where('status', 'active')->get_all();
        } catch (Exception $e) {
            throw new Exception("Database error in get_active_products: " . $e->getMessage());
        }
    }
}
?>