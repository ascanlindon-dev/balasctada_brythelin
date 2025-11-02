<?php
// Simple cart debug file for Render
// Access this directly: yourdomain.com/debug_cart.php

session_start();

// Check if user is logged in
if (!isset($_SESSION['buyer_id'])) {
    echo "<h1>❌ Not Logged In</h1>";
    echo "<p>Please log in first. <a href='auth/login'>Login</a></p>";
    exit;
}

$buyer_id = $_SESSION['buyer_id'];

// Database configuration
$host = getenv('DB_HOST') ?: 'localhost';
$dbname = getenv('DB_NAME') ?: 'your_database_name';
$username = getenv('DB_USER') ?: 'your_username';
$password = getenv('DB_PASS') ?: 'your_password';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h1>Cart Debug Information</h1>";
    echo "<p><strong>Buyer ID:</strong> $buyer_id</p>";
    
    // Check if cart table exists
    echo "<h2>1. Table Check</h2>";
    $tables = $pdo->query("SHOW TABLES LIKE 'cart'")->fetchAll();
    if (empty($tables)) {
        echo "❌ Cart table does not exist!<br>";
        echo "<a href='create_cart.php'>Create Cart Table</a>";
        exit;
    } else {
        echo "✅ Cart table exists<br>";
    }
    
    // Check cart contents
    echo "<h2>2. Cart Contents</h2>";
    $stmt = $pdo->prepare("SELECT * FROM cart WHERE buyer_id = ?");
    $stmt->execute([$buyer_id]);
    $cart_items = $stmt->fetchAll();
    
    if (empty($cart_items)) {
        echo "❌ No items in cart for buyer ID $buyer_id<br>";
    } else {
        echo "✅ Found " . count($cart_items) . " items in cart:<br>";
        echo "<pre>" . print_r($cart_items, true) . "</pre>";
    }
    
    // Check cart with product details
    echo "<h2>3. Cart with Product Details</h2>";
    $stmt = $pdo->prepare("
        SELECT c.cart_id, c.quantity, p.product_id, p.product_name, p.price, p.image_url, p.stock 
        FROM cart c 
        JOIN products p ON c.product_id = p.product_id 
        WHERE c.buyer_id = ?
    ");
    $stmt->execute([$buyer_id]);
    $detailed_cart = $stmt->fetchAll();
    
    if (empty($detailed_cart)) {
        echo "❌ No detailed cart items found<br>";
    } else {
        echo "✅ Found detailed cart items:<br>";
        echo "<pre>" . print_r($detailed_cart, true) . "</pre>";
    }
    
    // Test adding an item manually
    echo "<h2>4. Manual Add Test</h2>";
    if (isset($_GET['test_add'])) {
        $product_id = 1; // Assuming product ID 1 exists
        $quantity = 1;
        
        $stmt = $pdo->prepare("INSERT INTO cart (buyer_id, product_id, quantity) VALUES (?, ?, ?)");
        $result = $stmt->execute([$buyer_id, $product_id, $quantity]);
        
        if ($result) {
            echo "✅ Manually added item to cart successfully!<br>";
            echo "<a href='?'>Refresh to see changes</a><br>";
        } else {
            echo "❌ Failed to add item manually<br>";
        }
    } else {
        echo "<a href='?test_add=1'>Test Manual Add</a><br>";
    }
    
    // Show all products
    echo "<h2>5. Available Products</h2>";
    $products = $pdo->query("SELECT * FROM products LIMIT 5")->fetchAll();
    if (empty($products)) {
        echo "❌ No products found<br>";
    } else {
        echo "✅ Found products:<br>";
        foreach ($products as $product) {
            echo "- ID: {$product['product_id']}, Name: {$product['product_name']}<br>";
        }
    }
    
    echo "<br><a href='auth/dashboard'>Back to Dashboard</a>";
    
} catch (PDOException $e) {
    echo "<h1>❌ Database Error</h1>";
    echo "<p>Error: " . $e->getMessage() . "</p>";
}
?>