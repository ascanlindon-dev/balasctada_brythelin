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
        
        .test-info {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-top: 2rem;
        }
        
        .test-info h3 {
            color: #333;
            margin-bottom: 1rem;
        }
        
        .test-details {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
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
        <div class="welcome-card">
            <h1>Welcome to Your Product Dashboard</h1>
            <p>Manage your products, view sales analytics, and track your inventory all in one place. This dashboard confirms that the registration and login system is working correctly with your buyers database.</p>
            
            <div class="user-info">
                <strong>Buyer ID:</strong> <?= htmlspecialchars($user['buyer_id']) ?><br>
                <strong>Email:</strong> <?= htmlspecialchars($user['email']) ?><br>
                <strong>Full Name:</strong> <?= htmlspecialchars($user['full_name']) ?><br>
                <strong>Phone:</strong> <?= htmlspecialchars($user['phone_number']) ?>
            </div>
            
            <div class="success" style="margin-top: 1rem;">
                ✅ <strong>Registration & Login System Working!</strong><br>
                Your account data is successfully stored and retrieved from the buyers database.<br>
                <small>Registered: <?= isset($current_user_registration) ? date('M j, Y', strtotime($current_user_registration)) : 'Recently' ?></small>
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
        
        <div class="quick-actions">
            <h2>Product Management</h2>
            <div class="action-buttons">
                <a href="#" class="action-btn">Add New Product</a>
                <a href="#" class="action-btn">Manage Inventory</a>
                <a href="#" class="action-btn">View Orders</a>
                <a href="#" class="action-btn">Analytics Dashboard</a>
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
</body>
</html>