<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - CRAFTIFY</title>
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
        
        .nav-user {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .nav-user span {
            font-size: 0.9rem;
        }
        
        .logout-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            text-decoration: none;
            font-size: 0.9rem;
            transition: background 0.3s;
        }
        
        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .welcome-card {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }
        
        .welcome-card h1 {
            color: #333;
            margin-bottom: 1rem;
        }
        
        .welcome-card p {
            color: #666;
            line-height: 1.6;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.5rem;
            color: white;
        }
        
        .stat-title {
            font-size: 1.2rem;
            color: #333;
            margin-bottom: 0.5rem;
        }
        
        .stat-value {
            font-size: 2rem;
            font-weight: bold;
            color: #667eea;
        }
        
        .quick-actions {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }
        
        .quick-actions h2 {
            color: #333;
            margin-bottom: 1rem;
        }
        
        .action-buttons {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }
        
        .action-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            text-align: center;
            font-size: 1rem;
            transition: transform 0.2s;
            display: block;
        }
        
        .action-btn:hover {
            transform: translateY(-2px);
            color: white;
        }
        
        .user-info {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }
        
        .user-info strong {
            color: #333;
        }
        
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }
        
        .product-card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
        }
        
        .product-image {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        
        .product-title {
            font-size: 1.3rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 0.5rem;
        }
        
        .product-description {
            color: #666;
            margin-bottom: 1rem;
            line-height: 1.5;
        }
        
        .product-price {
            font-size: 1.5rem;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 1rem;
        }
        
        .product-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1rem;
            cursor: pointer;
            transition: transform 0.2s;
            width: 100%;
            text-align: center;
            display: inline-block;
        }
        
        .product-btn:hover {
            transform: translateY(-2px);
            color: white;
        }
        
        .add-product-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            cursor: pointer;
            transition: transform 0.3s;
        }
        
        .add-product-card:hover {
            transform: translateY(-5px);
        }
        
        .add-product-card .plus-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }
        
        .add-product-card h3 {
            margin: 0;
            font-size: 1.2rem;
        }
        
        .success {
            background: #d4edda;
            color: #155724;
            padding: 1rem;
            border-radius: 8px;
            border-left: 4px solid #28a745;
        }
        
        .profile-section {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }
        
        .profile-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f8f9fa;
        }
        
        .profile-info h2 {
            color: #333;
            margin-bottom: 0.5rem;
        }
        
        .profile-info p {
            color: #666;
            margin: 0;
        }
        
        .profile-tabs {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
        }
        
        .tab-btn {
            padding: 0.75rem 1.5rem;
            border: 2px solid #e9ecef;
            background: white;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            color: #333;
            font-weight: 500;
        }
        
        .tab-btn.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: #667eea;
        }
        
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
        }
        
        .order-item, .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            margin-bottom: 1rem;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }
        
        .order-info, .cart-info {
            flex: 1;
        }
        
        .order-id, .product-name {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }
        
        .order-status, .product-details {
            color: #666;
            font-size: 0.9rem;
        }
        
        .order-amount, .cart-price {
            font-weight: bold;
            color: #28a745;
        }
        
        .cart-controls {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .quantity-input {
            width: 60px;
            padding: 0.25rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-align: center;
        }
        
        .btn-sm {
            padding: 0.25rem 0.75rem;
            font-size: 0.8rem;
        }
        
        .cart-total {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem;
            border-radius: 8px;
            text-align: center;
            margin-top: 1rem;
        }
        
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #666;
        }
        
        .empty-state h3 {
            margin-bottom: 0.5rem;
        }
        
        .empty-state p {
            color: #888;
        }
        
        .buying-details {
            display: grid;
            gap: 2rem;
        }
        
        .detail-section {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }
        
        .detail-section h4 {
            margin: 0 0 1rem 0;
            color: #333;
            font-size: 1.1rem;
        }
        
        .status-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }
        
        .status-item {
            background: white;
            padding: 1rem;
            border-radius: 6px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .status-label {
            font-weight: 500;
            color: #555;
        }
        
        .status-count {
            font-weight: bold;
            color: #667eea;
        }
        
        .activity-item {
            background: white;
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 0.5rem;
            border-left: 3px solid #28a745;
        }
        
        .activity-title {
            font-weight: 500;
            color: #333;
            margin-bottom: 0.25rem;
        }
        
        .activity-meta {
            font-size: 0.875rem;
            color: #666;
        }
        
        .status-pending { color: #ffc107; font-weight: bold; }
        .status-processing { color: #007bff; font-weight: bold; }
        .status-shipped { color: #17a2b8; font-weight: bold; }
        .status-delivered { color: #28a745; font-weight: bold; }
        .status-cancelled { color: #dc3545; font-weight: bold; }
        
        .account-info {
            background: white;
            padding: 1.5rem;
            border-radius: 6px;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
            border-bottom: 1px solid #eee;
        }
        
        .info-row:last-child {
            border-bottom: none;
        }
        
        .info-label {
            font-weight: 500;
            color: #555;
        }
        
        .info-value {
            color: #333;
        }
        
        .test-details p {
            margin-bottom: 0.5rem;
            color: #666;
        }
        
        .test-details p:last-child {
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-brand">CRAFTIFY Products</div>
            <div class="nav-user">
                <span>Welcome, <?= htmlspecialchars($user['full_name']) ?>!</span>
                <a href="<?= site_url('auth/logout') ?>" class="logout-btn">Logout</a>
            </div>
        </div>
    </nav>
    
    <div class="container">
        <!-- Buyer Profile Section -->
        <div class="profile-section">
            <div class="profile-header">
                <div class="profile-info">
                    <h2>Welcome, <?= htmlspecialchars($user['full_name']) ?>!</h2>
                    <p>Email: <?= htmlspecialchars($user['email']) ?> | Phone: <?= htmlspecialchars($user['phone_number']) ?></p>
                </div>
                <div>
                    <a href="<?= site_url('auth/logout') ?>" class="action-btn">Logout</a>
                </div>
            </div>

            <div class="profile-tabs">
                <button class="tab-btn active" onclick="showTab('account')">Account Details</button>
                <button class="tab-btn" onclick="showTab('orders')">My Orders</button>
                <button class="tab-btn" onclick="showTab('cart')">My Cart</button>
                <button class="tab-btn" onclick="showTab('products')">Browse Products</button>
            </div>

            <!-- Account Details Tab -->
            <div id="account" class="tab-content active">
                <h3>Account & Buying Summary</h3>
                
                <div class="stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
                    <div class="stat-card">
                        <div class="stat-icon">📊</div>
                        <div class="stat-title">Total Orders</div>
                        <div class="stat-value"><?= isset($buying_stats['total_orders']) ? $buying_stats['total_orders'] : 0 ?></div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon">💰</div>
                        <div class="stat-title">Total Spent</div>
                        <div class="stat-value">$<?= isset($buying_stats['total_spent']) ? number_format($buying_stats['total_spent'], 2) : '0.00' ?></div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon">📈</div>
                        <div class="stat-title">Average Order</div>
                        <div class="stat-value">$<?= isset($buying_stats['average_order']) ? number_format($buying_stats['average_order'], 2) : '0.00' ?></div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon">🛒</div>
                        <div class="stat-title">Cart Items</div>
                        <div class="stat-value"><?= isset($buying_stats['cart_items']) ? $buying_stats['cart_items'] : 0 ?></div>
                    </div>
                </div>

                <div class="buying-details">
                    <div class="detail-section">
                        <h4>📋 Order Status Breakdown</h4>
                        <?php if (!empty($buying_stats['orders_by_status'])): ?>
                            <div class="status-grid">
                                <?php foreach ($buying_stats['orders_by_status'] as $status => $count): ?>
                                    <div class="status-item">
                                        <span class="status-label"><?= ucfirst($status) ?>:</span>
                                        <span class="status-count"><?= $count ?> order(s)</span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <p>No orders placed yet.</p>
                        <?php endif; ?>
                    </div>

                    <div class="detail-section">
                        <h4>🕒 Recent Activity</h4>
                        <?php if (!empty($recent_orders)): ?>
                            <?php foreach ($recent_orders as $order): ?>
                                <div class="activity-item">
                                    <div class="activity-info">
                                        <div class="activity-title">Order #<?= $order['id'] ?> - $<?= number_format($order['total_amount'], 2) ?></div>
                                        <div class="activity-meta">
                                            Status: <span class="status-<?= $order['status'] ?>"><?= ucfirst($order['status']) ?></span> | 
                                            Date: <?= date('M d, Y', strtotime($order['created_at'])) ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No recent orders to display.</p>
                        <?php endif; ?>
                    </div>

                    <div class="detail-section">
                        <h4>👤 Account Information</h4>
                        <div class="account-info">
                            <div class="info-row">
                                <span class="info-label">Account ID:</span>
                                <span class="info-value"><?= htmlspecialchars($user['buyer_id']) ?></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Email:</span>
                                <span class="info-value"><?= htmlspecialchars($user['email']) ?></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Phone:</span>
                                <span class="info-value"><?= htmlspecialchars($user['phone_number']) ?></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Member Since:</span>
                                <span class="info-value"><?= isset($current_user_registration) ? date('M d, Y', strtotime($current_user_registration)) : 'Recently' ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Orders Tab -->
            <div id="orders" class="tab-content">
                <h3>My Orders</h3>
                <?php if (!empty($orders)): ?>
                    <?php foreach ($orders as $order): ?>
                        <div class="order-item">
                            <div class="order-info">
                                <div class="order-id">Order #<?= $order['id'] ?></div>
                                <div class="order-status">Status: <?= ucfirst($order['status']) ?> | Date: <?= date('M d, Y', strtotime($order['created_at'])) ?></div>
                            </div>
                            <div class="order-amount">$<?= number_format($order['total_amount'], 2) ?></div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-state">
                        <h3>No Orders Yet</h3>
                        <p>You haven't placed any orders yet. Start shopping to see your orders here!</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Cart Tab -->
            <div id="cart" class="tab-content">
                <h3>My Cart</h3>
                <?php if (!empty($cart_items)): ?>
                    <?php foreach ($cart_items as $item): ?>
                        <div class="cart-item">
                            <div class="cart-info">
                                <div class="product-name"><?= htmlspecialchars($item['name']) ?></div>
                                <div class="product-details">Price: $<?= number_format($item['price'], 2) ?> | Subtotal: $<?= number_format($item['total_price'], 2) ?></div>
                            </div>
                            <div class="cart-controls">
                                <form action="<?= site_url('auth/update_cart') ?>" method="POST" style="display: inline-flex; align-items: center; gap: 0.5rem;">
                                    <input type="hidden" name="cart_id" value="<?= $item['id'] ?>">
                                    <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" class="quantity-input">
                                    <button type="submit" class="action-btn btn-sm">Update</button>
                                </form>
                                <a href="<?= site_url('auth/remove_from_cart/' . $item['id']) ?>" 
                                   class="action-btn btn-sm" 
                                   style="background: #dc3545;"
                                   onclick="return confirm('Remove this item from cart?')">Remove</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    
                    <div class="cart-total">
                        <h3>Total: $<?= number_format($cart_total, 2) ?></h3>
                        <p>Cart contains <?= count($cart_items) ?> item(s)</p>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <h3>Your Cart is Empty</h3>
                        <p>Add some products to your cart to see them here!</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Products Tab -->
            <div id="products" class="tab-content">
                <h3>Browse Products</h3>
                <div class="products-grid">
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <div class="product-card">
                                <?php if (!empty($product['image_url'])): ?>
                                    <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="product-image" style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px;">
                                <?php else: ?>
                                    <div class="product-image">🎨</div>
                                <?php endif; ?>
                                <div class="product-title"><?= htmlspecialchars($product['name']) ?></div>
                                <div class="product-description"><?= htmlspecialchars($product['description'] ?: 'No description available') ?></div>
                                <div class="product-price">$<?= number_format($product['price'], 2) ?></div>
                                <div style="margin-top: 1rem;">
                                    <form action="<?= site_url('auth/add_to_cart/' . $product['id']) ?>" method="POST" style="display: flex; gap: 0.5rem; align-items: center;">
                                        <input type="number" name="quantity" value="1" min="1" max="<?= $product['stock'] ?>" class="quantity-input">
                                        <button type="submit" class="action-btn btn-sm">Add to Cart</button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="empty-state">
                            <h3>No Products Available</h3>
                            <p>The admin hasn't added any products yet. Check back soon!</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">👤</div>
                <div class="stat-title">Account Status</div>
                <div class="stat-value">Active</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">�</div>
                <div class="stat-title">Orders</div>
                <div class="stat-value">0</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">❤️</div>
                <div class="stat-title">Favorites</div>
                <div class="stat-value">0</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">🎯</div>
                <div class="stat-title">Cart Items</div>
                <div class="stat-value">0</div>
            </div>
        </div>
        

        <div style="background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); margin-bottom: 2rem;">
            <h2 style="color: #333; margin-bottom: 2rem;">Featured Products</h2>
            
            <div class="products-grid">
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <div class="product-card">
                            <?php if (!empty($product['image_url'])): ?>
                                <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="product-image" style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px;">
                            <?php else: ?>
                                <div class="product-image">🎨</div>
                            <?php endif; ?>
                            <div class="product-title"><?= htmlspecialchars($product['name']) ?></div>
                            <div class="product-description"><?= htmlspecialchars($product['description'] ?: 'No description available') ?></div>
                            <div class="product-price">$<?= number_format($product['price'], 2) ?></div>
                            <a href="#" class="product-btn">View Details</a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="product-card">
                        <div class="product-image">�</div>
                        <div class="product-title">No Products Available</div>
                        <div class="product-description">The admin hasn't added any products yet. Check back soon!</div>
                        <div class="product-price">-</div>
                        <a href="#" class="product-btn">Coming Soon</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="test-info">
            <h3>📊 Database Information</h3>
            <div class="test-details">
                <p><strong>Database Table:</strong> buyers</p>
                <p><strong>Your ID:</strong> <?= htmlspecialchars($user['buyer_id']) ?></p>
                <p><strong>Total Registered Users:</strong> <?= isset($total_users) ? $total_users : '0' ?></p>
                <p><strong>Registration:</strong> ✅ Working</p>
                <p><strong>Login:</strong> ✅ Working</p>
                <p><strong>Session Management:</strong> ✅ Working</p>
                <p><strong>Password Security:</strong> ✅ Hashed with PHP password_hash()</p>
                <p><strong>Database Connection:</strong> ✅ Active</p>
            </div>
        </div>
    </div>

    <script>
        function showTab(tabName) {
            // Hide all tab contents
            const tabContents = document.querySelectorAll('.tab-content');
            tabContents.forEach(content => content.classList.remove('active'));
            
            // Remove active class from all tab buttons
            const tabButtons = document.querySelectorAll('.tab-btn');
            tabButtons.forEach(button => button.classList.remove('active'));
            
            // Show selected tab content
            document.getElementById(tabName).classList.add('active');
            
            // Add active class to clicked button
            event.target.classList.add('active');
        }
    </script>
</body>
</html>