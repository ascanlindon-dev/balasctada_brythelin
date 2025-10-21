<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Admin extends Controller {
    
    public function __construct() {
        parent::__construct();
        $this->call->model('User');
        $this->call->model('Product');
        
        // Check if user is logged in and is admin
        if (!$this->call->session->userdata('buyer_id')) {
            redirect('auth/login');
        }
        
        $email = $this->call->session->userdata('email');
        if ($email !== 'ascanlindon@gmail.com') {
            redirect('auth/dashboard');
        }
    }
    
    /**
     * Admin Dashboard
     */
    public function dashboard() {
        $data['user'] = array(
            'buyer_id' => $this->call->session->userdata('buyer_id'),
            'email' => $this->call->session->userdata('email'),
            'full_name' => $this->call->session->userdata('full_name'),
            'phone_number' => $this->call->session->userdata('phone_number')
        );
        
        // Get statistics
        try {
            $data['total_products'] = $this->Product->get_total_products();
            $data['total_buyers'] = $this->User->get_total_users();
            $data['recent_products'] = $this->Product->get_all_products();
            $data['all_buyers'] = $this->User->get_all_users();
        } catch (Exception $e) {
            $data['total_products'] = 0;
            $data['total_buyers'] = 0;
            $data['recent_products'] = array();
            $data['all_buyers'] = array();
            $data['error'] = $e->getMessage();
        }
        
        $this->call->view('admin/dashboard', $data);
    }
    
    /**
     * Product Management
     */
    public function products() {
        try {
            $data['products'] = $this->Product->get_all_products();
            $data['success'] = $this->call->session->flashdata('success');
            $data['error'] = $this->call->session->flashdata('error');
        } catch (Exception $e) {
            $data['products'] = array();
            $data['error'] = $e->getMessage();
        }
        
        $this->call->view('admin/products', $data);
    }
    
    /**
     * Add Product Form
     */
    public function add_product() {
        $data['error'] = $this->call->session->flashdata('error');
        $data['success'] = $this->call->session->flashdata('success');
        $this->call->view('admin/add_product', $data);
    }
    
    /**
     * Process Add Product
     */
    public function do_add_product() {
    $product_name = $this->call->io->post('name');
        $description = $this->call->io->post('description');
        $price = $this->call->io->post('price');
        $image_url = $this->call->io->post('image_url');
        $stock = $this->call->io->post('stock');
        
        // Validation
        if (empty($product_name) || empty($price)) {
            $this->call->session->set_flashdata('error', 'Name and price are required');
            redirect('admin/add_product');
            return;
        }
        
        if (!is_numeric($price) || $price < 0) {
            $this->call->session->set_flashdata('error', 'Price must be a valid number');
            redirect('admin/add_product');
            return;
        }
        
        try {
            $product_data = array(
                'product_name' => trim($product_name),
                'description' => trim($description),
                'price' => floatval($price),
                'stock' => intval($stock),
                'image_url' => trim($image_url)
            );
            
            if ($this->Product->create_product($product_data)) {
                $this->call->session->set_flashdata('success', 'Product added successfully');
                redirect('admin/products');
            } else {
                $this->call->session->set_flashdata('error', 'Failed to add product');
                redirect('admin/add_product');
            }
        } catch (Exception $e) {
            $this->call->session->set_flashdata('error', 'Database error: ' . $e->getMessage());
            redirect('admin/add_product');
        }
    }
    
    /**
     * Edit Product Form
     */
    public function edit_product($id = null) {
        if (!$id) {
            redirect('admin/products');
        }
        
        try {
            $data['product'] = $this->Product->get_product_by_id($id);
            if (!$data['product']) {
                $this->call->session->set_flashdata('error', 'Product not found');
                redirect('admin/products');
                return;
            }
            
            $data['error'] = $this->call->session->flashdata('error');
            $data['success'] = $this->call->session->flashdata('success');
            $this->call->view('admin/edit_product', $data);
        } catch (Exception $e) {
            $this->call->session->set_flashdata('error', 'Database error: ' . $e->getMessage());
            redirect('admin/products');
        }
    }
    
    /**
     * Process Edit Product
     */
    public function do_edit_product($id = null) {
        if (!$id) {
            redirect('admin/products');
        }
        
    $product_name = $this->call->io->post('name');
        $description = $this->call->io->post('description');
        $price = $this->call->io->post('price');
        $image_url = $this->call->io->post('image_url');
        $stock = $this->call->io->post('stock');
        
        // Validation
        if (empty($product_name) || empty($price)) {
            $this->call->session->set_flashdata('error', 'Name and price are required');
            redirect('admin/edit_product/' . $id);
            return;
        }
        
        if (!is_numeric($price) || $price < 0) {
            $this->call->session->set_flashdata('error', 'Price must be a valid number');
            redirect('admin/edit_product/' . $id);
            return;
        }
        
        try {
            $product_data = array(
                'product_name' => trim($product_name),
                'description' => trim($description),
                'price' => floatval($price),
                'stock' => intval($stock),
                'image_url' => trim($image_url)
            );
            
            if ($this->Product->update_product($id, $product_data)) {
                $this->call->session->set_flashdata('success', 'Product updated successfully');
                redirect('admin/products');
            } else {
                $this->call->session->set_flashdata('error', 'Failed to update product');
                redirect('admin/edit_product/' . $id);
            }
        } catch (Exception $e) {
            $this->call->session->set_flashdata('error', 'Database error: ' . $e->getMessage());
            redirect('admin/edit_product/' . $id);
        }
    }
    
    /**
     * Delete Product
     */
    public function delete_product($id = null) {
        if (!$id) {
            redirect('admin/products');
        }
        
        try {
            if ($this->Product->delete_product($id)) {
                $this->call->session->set_flashdata('success', 'Product deleted successfully');
            } else {
                $this->call->session->set_flashdata('error', 'Failed to delete product');
            }
        } catch (Exception $e) {
            $this->call->session->set_flashdata('error', 'Database error: ' . $e->getMessage());
        }
        
        redirect('admin/products');
    }
    
    /**
     * Buyer Management
     */
    public function buyers() {
        try {
            $data['buyers'] = $this->User->get_all_users();
            $data['success'] = $this->call->session->flashdata('success');
            $data['error'] = $this->call->session->flashdata('error');
        } catch (Exception $e) {
            $data['buyers'] = array();
            $data['error'] = $e->getMessage();
        }
        
        $this->call->view('admin/buyers', $data);
    }
    
    /**
     * Delete Buyer
     */
    public function delete_buyer($buyer_id = null) {
        if (!$buyer_id) {
            redirect('admin/buyers');
        }
        
        // Don't allow deletion of admin account
        $buyer = $this->User->get_user_by_id($buyer_id);
        if ($buyer && $buyer['email'] === 'ascanlindon@gmail.com') {
            $this->call->session->set_flashdata('error', 'Cannot delete admin account');
            redirect('admin/buyers');
            return;
        }
        
        try {
            if ($this->User->delete_user($buyer_id)) {
                $this->call->session->set_flashdata('success', 'Buyer deleted successfully');
            } else {
                $this->call->session->set_flashdata('error', 'Failed to delete buyer');
            }
        } catch (Exception $e) {
            $this->call->session->set_flashdata('error', 'Database error: ' . $e->getMessage());
        }
        
        redirect('admin/buyers');
    }
}
?>