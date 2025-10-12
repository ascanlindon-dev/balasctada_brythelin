<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
/**
 * ------------------------------------------------------------------
 * LavaLust - an opensource lightweight PHP MVC Framework
 * ------------------------------------------------------------------
 *
 * MIT License
 *
 * Copyright (c) 2020 Ronald M. Marasigan
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package LavaLust
 * @author Ronald M. Marasigan <ronald.marasigan@yahoo.com>
 * @since Version 1
 * @link https://github.com/ronmarasigan/LavaLust
 * @license https://opensource.org/licenses/MIT MIT License
 */

/*
| -------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------
| Here is where you can register web routes for your application.
|
|
*/

$router->get('/', 'Auth::login');

// Setup routes
$router->get('/setup', 'Setup_web::index');
$router->get('/setup_web', 'Setup_web::index');
$router->get('/setup_web/reset', 'Setup_web::reset');

// Authentication routes
$router->get('/auth/login', 'Auth::login');
$router->post('/auth/do_login', 'Auth::do_login');
$router->post('/auth/do_register', 'Auth::do_register');
$router->get('/auth/dashboard', 'Auth::dashboard');
$router->get('/auth/logout', 'Auth::logout');
$router->get('/auth/debug_password/(:any)/(:any)', 'Auth::debug_password/$1/$2');
$router->get('/auth/debug_users', 'Auth::debug_users');
$router->get('/auth/create_test_user', 'Auth::create_test_user');

// Admin routes
$router->get('/admin/dashboard', 'Admin::dashboard');
$router->get('/admin/products', 'Admin::products');
$router->get('/admin/add_product', 'Admin::add_product');
$router->post('/admin/do_add_product', 'Admin::do_add_product');
$router->get('/admin/edit_product/(:any)', 'Admin::edit_product/$1');
$router->post('/admin/do_edit_product/(:any)', 'Admin::do_edit_product/$1');
$router->get('/admin/delete_product/(:any)', 'Admin::delete_product/$1');
$router->get('/admin/buyers', 'Admin::buyers');
$router->get('/admin/delete_buyer/(:any)', 'Admin::delete_buyer/$1');