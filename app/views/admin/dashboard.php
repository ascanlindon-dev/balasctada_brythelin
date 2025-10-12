<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - CRAFTIFY</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #333;
            min-height: 100vh;
        }
        
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 1rem 0;
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
        }
        
        .navbar-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 2rem;
        }
        
        .logo {
            font-size: 1.8rem;
            font-weight: bold;
            color: #667eea;
        }
        
        .nav-links {
            display: flex;
            gap: 2rem;
        }
        
        .nav-links a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .nav-links a:hover {
            background: #667eea;
            color: white;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .admin-badge {
            background: #ff6b6b;
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
        }
        
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
        }
        
        .welcome-section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 1.5rem;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            color: #666;
            font-weight: 500;
        }
        
        .recent-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-top: 2rem;
        }
        
        .section-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 1.5rem;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        
        .section-title {
            font-size: 1.3rem;
            font-weight: bold;
            margin-bottom: 1rem;
            color: #333;
        }
        
        .product-item, .buyer-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem;
            margin-bottom: 0.5rem;
            background: #f8f9fa;
            border-radius: 8px;
            transition: background 0.3s ease;
        }
        
        .product-item:hover, .buyer-item:hover {
            background: #e9ecef;
        }
        
        .product-info, .buyer-info {
            flex: 1;
        }
        
        .product-name, .buyer-name {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }
        
        .product-price {
            color: #28a745;
            font-weight: 600;
        }
        
        .buyer-email {
            color: #666;
            font-size: 0.9rem;
        }
        
        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .btn-primary {
            background: #667eea;
            color: white;
        }
        
        .btn-primary:hover {
            background: #5a6fd8;
            transform: translateY(-2px);
        }
        
        .btn-danger {
            background: #dc3545;
            color: white;
        }
        
        .btn-danger:hover {
            background: #c82333;
        }
        
        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }
        
        @media (max-width: 768px) {
            .recent-section {
                grid-template-columns: 1fr;
            }
            
            .nav-links {
                display: none;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-content">
            <div class="logo">CRAFTIFY ADMIN</div>
            <div class="nav-links">
                <a href="<?= site_url('admin/dashboard') ?>">Dashboard</a>
                <a href="<?= site_url('admin/products') ?>">Products</a>
                <a href="<?= site_url('admin/buyers') ?>">Buyers</a>
            </div>
            <div class="user-info">
                <span class="admin-badge">ADMIN</span>
                <span>Welcome, <?= htmlspecialchars($user['full_name']) ?></span>
                <a href="<?= site_url('auth/logout') ?>" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="welcome-section">
            <h1>Admin Dashboard</h1>
            <p>Welcome back, <?= htmlspecialchars($user['full_name']) ?>! Here's an overview of your CRAFTIFY platform.</p>
        </div>

        <?php if (isset($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number"><?= $total_products ?></div>
                <div class="stat-label">Total Products</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= $total_buyers ?></div>
                <div class="stat-label">Total Buyers</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= count($recent_products) ?></div>
                <div class="stat-label">Listed Products</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= count(array_filter($recent_products, function($p) { return $p['status'] === 'active'; })) ?></div>
                <div class="stat-label">Active Products</div>
            </div>
        </div>

        <div class="recent-section">
            <div class="section-card">
                <div class="section-title">Recent Products</div>
                <?php if (!empty($recent_products)): ?>
                    <?php foreach (array_slice($recent_products, 0, 5) as $product): ?>
                        <div class="product-item">
                            <div class="product-info">
                                <div class="product-name"><?= htmlspecialchars($product['name']) ?></div>
                                <div class="product-price">$<?= number_format($product['price'], 2) ?></div>
                            </div>
                            <span class="badge <?= $product['status'] === 'active' ? 'badge-success' : 'badge-secondary' ?>">
                                <?= ucfirst($product['status']) ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                    <a href="<?= site_url('admin/products') ?>" class="btn btn-primary">Manage All Products</a>
                <?php else: ?>
                    <p>No products found. <a href="<?= site_url('admin/add_product') ?>">Add your first product</a></p>
                <?php endif; ?>
            </div>

            <div class="section-card">
                <div class="section-title">Recent Buyers</div>
                <?php if (!empty($all_buyers)): ?>
                    <?php foreach (array_slice($all_buyers, 0, 5) as $buyer): ?>
                        <div class="buyer-item">
                            <div class="buyer-info">
                                <div class="buyer-name"><?= htmlspecialchars($buyer['full_name']) ?></div>
                                <div class="buyer-email"><?= htmlspecialchars($buyer['email']) ?></div>
                            </div>
                            <?php if ($buyer['email'] === 'ascanlindon@gmail.com'): ?>
                                <span class="admin-badge">ADMIN</span>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                    <a href="<?= site_url('admin/buyers') ?>" class="btn btn-primary">Manage All Buyers</a>
                <?php else: ?>
                    <p>No buyers found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>