<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - CRAFTIFY</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            min-height: 100vh;
        }
        
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .nav-brand {
            font-size: 1.5rem;
            font-weight: bold;
        }
        
        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }
        
        .nav-links a {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        
        .nav-links a:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .cart-header {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }
        
        .cart-header h1 {
            color: #333;
            margin-bottom: 0.5rem;
        }
        
        .cart-summary {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #eee;
        }
        
        .cart-items {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .cart-item {
            display: flex;
            align-items: center;
            padding: 1.5rem;
            border-bottom: 1px solid #eee;
            transition: background-color 0.3s;
        }
        
        .cart-item:hover {
            background-color: #f9f9f9;
        }
        
        .cart-item:last-child {
            border-bottom: none;
        }
        
        .product-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 1rem;
        }
        
        .product-info {
            flex: 1;
            margin-right: 1rem;
        }
        
        .product-name {
            font-size: 1.1rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }
        
        .product-price {
            color: #667eea;
            font-weight: 600;
            font-size: 1rem;
        }
        
        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-right: 1rem;
        }
        
        .quantity-btn {
            background: #667eea;
            color: white;
            border: none;
            width: 30px;
            height: 30px;
            border-radius: 5px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s;
        }
        
        .quantity-btn:hover {
            background: #5a6fd8;
        }
        
        .quantity-input {
            width: 60px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 0.3rem;
        }
        
        .item-total {
            font-weight: 600;
            color: #333;
            min-width: 80px;
            text-align: right;
            margin-right: 1rem;
        }
        
        .remove-btn {
            background: #dc3545;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .remove-btn:hover {
            background: #c82333;
        }
        
        .empty-cart {
            text-align: center;
            padding: 3rem;
            color: #666;
        }
        
        .empty-cart h3 {
            margin-bottom: 1rem;
        }
        
        .btn {
            background: #667eea;
            color: white;
            padding: 0.8rem 2rem;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .btn:hover {
            background: #5a6fd8;
        }
        
        .btn-secondary {
            background: #6c757d;
        }
        
        .btn-secondary:hover {
            background: #5a6268;
        }
        
        .btn-danger {
            background: #dc3545;
        }
        
        .btn-danger:hover {
            background: #c82333;
        }
        
        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 5px;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .alert-warning {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }
        
        .cart-actions {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-top: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .total-display {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
        }
        
        .action-buttons {
            display: flex;
            gap: 1rem;
        }
        
        @media (max-width: 768px) {
            .cart-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            
            .cart-actions {
                flex-direction: column;
                gap: 1rem;
            }
            
            .action-buttons {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-brand">CRAFTIFY</div>
            <div class="nav-links">
                <a href="<?= site_url('auth/dashboard') ?>">Dashboard</a>
                <a href="<?= site_url('cart') ?>" class="active">Cart (<?= $cart_count ?>)</a>
                <a href="<?= site_url('auth/logout') ?>">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <!-- Cart Header -->
        <div class="cart-header">
            <h1>Shopping Cart</h1>
            <div class="cart-summary">
                <span><?= $cart_count ?> item(s) in cart</span>
                <span class="total-display">Total: $<?= number_format($cart_total, 2) ?></span>
            </div>
        </div>

        <!-- Flash Messages -->
        <?php if($this->call->session->flashdata('success')): ?>
            <div class="alert alert-success">
                <?= $this->call->session->flashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if($this->call->session->flashdata('error')): ?>
            <div class="alert alert-error">
                <?= $this->call->session->flashdata('error') ?>
            </div>
        <?php endif; ?>

        <!-- Invalid Items Warning -->
        <?php if(!empty($invalid_items)): ?>
            <div class="alert alert-warning">
                <strong>Warning:</strong> Some items in your cart are no longer available or have insufficient stock.
            </div>
        <?php endif; ?>

        <!-- Cart Items -->
        <?php if(empty($cart_items)): ?>
            <div class="cart-items">
                <div class="empty-cart">
                    <h3>Your cart is empty</h3>
                    <p>Start shopping to add items to your cart.</p>
                    <a href="<?= site_url('auth/dashboard') ?>" class="btn">Continue Shopping</a>
                </div>
            </div>
        <?php else: ?>
            <div class="cart-items">
                <?php foreach($cart_items as $item): ?>
                    <div class="cart-item" data-cart-id="<?= $item['cart_id'] ?>">
                        <img src="<?= $item['image_url'] ?: 'https://via.placeholder.com/80x80?text=No+Image' ?>" 
                             alt="<?= htmlspecialchars($item['product_name']) ?>" class="product-image">
                        
                        <div class="product-info">
                            <div class="product-name"><?= htmlspecialchars($item['product_name']) ?></div>
                            <div class="product-price">$<?= number_format($item['price'], 2) ?> each</div>
                            <?php if($item['stock'] < $item['quantity']): ?>
                                <div style="color: #dc3545; font-size: 0.9rem;">
                                    Only <?= $item['stock'] ?> in stock
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="quantity-controls">
                            <button class="quantity-btn" onclick="updateQuantity(<?= $item['cart_id'] ?>, <?= $item['quantity'] - 1 ?>)">-</button>
                            <input type="number" class="quantity-input" value="<?= $item['quantity'] ?>" 
                                   min="1" max="<?= $item['stock'] ?>"
                                   onchange="updateQuantity(<?= $item['cart_id'] ?>, this.value)">
                            <button class="quantity-btn" onclick="updateQuantity(<?= $item['cart_id'] ?>, <?= $item['quantity'] + 1 ?>)">+</button>
                        </div>
                        
                        <div class="item-total">
                            $<?= number_format($item['price'] * $item['quantity'], 2) ?>
                        </div>
                        
                        <button class="remove-btn" onclick="removeItem(<?= $item['cart_id'] ?>)">Remove</button>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Cart Actions -->
            <div class="cart-actions">
                <div class="total-display">
                    Total: $<?= number_format($cart_total, 2) ?>
                </div>
                <div class="action-buttons">
                    <a href="<?= site_url('auth/dashboard') ?>" class="btn btn-secondary">Continue Shopping</a>
                    <a href="<?= site_url('cart/clear') ?>" class="btn btn-danger" 
                       onclick="return confirm('Are you sure you want to clear your cart?')">Clear Cart</a>
                    <button class="btn" onclick="proceedToCheckout()">Proceed to Checkout</button>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script>
        function updateQuantity(cartId, newQuantity) {
            if(newQuantity < 0) return;
            
            fetch('<?= site_url('cart/update') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `cart_id=${cartId}&quantity=${newQuantity}`
            })
            .then(response => response.json())
            .then(data => {
                if(data.status === 'success') {
                    location.reload(); // Reload to update totals
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating the cart');
            });
        }

        function removeItem(cartId) {
            if(!confirm('Remove this item from cart?')) return;
            
            fetch('<?= site_url('cart/remove') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `cart_id=${cartId}`
            })
            .then(response => response.json())
            .then(data => {
                if(data.status === 'success') {
                    location.reload();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while removing the item');
            });
        }

        function proceedToCheckout() {
            // Implement checkout functionality
            alert('Checkout functionality will be implemented here');
        }
    </script>
</body>
</html>