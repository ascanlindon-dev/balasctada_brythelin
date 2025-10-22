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
            $allowed = ['product_name', 'description', 'price', 'stock', 'category', 'image_url'];
            $insert = array_intersect_key($data, array_flip($allowed));
            return $this->db->table('products')->insert($insert);
        } catch (Exception $e) {
            throw new Exception("Database error in create_product: " . $e->getMessage());
        }
    }
    
    /**
     * Update product
     */
    public function update_product($product_id, $data) {
        try {
            $allowed = ['product_name', 'description', 'price', 'stock', 'category', 'image_url'];
            $update = array_intersect_key($data, array_flip($allowed));
            return $this->db->table('products')->where('product_id', $product_id)->update($update);
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
     * Get active products (since your schema doesn't have status, get all products)
     */
    public function get_active_products() {
        try {
            // Only show products with stock > 0 (fix for LavaLust query builder)
            return $this->db->table('products')->where('stock', '>', 0)->order_by('product_id', 'DESC')->get_all();
        } catch (Exception $e) {
            throw new Exception("Database error in get_active_products: " . $e->getMessage());
        }
    }
    
    /**
     * Get products by creator
     */
    // Removed get_products_by_creator since 'created_by' is not in new schema
}
?>