<?php
// Simple cart table creator for Render deployment
// Access this file directly: yourdomain.com/create_cart.php

// Database configuration - update these with your Render database details
$host = getenv('DB_HOST') ?: 'localhost';
$dbname = getenv('DB_NAME') ?: 'your_database_name';
$username = getenv('DB_USER') ?: 'your_username';
$password = getenv('DB_PASS') ?: 'your_password';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h1>Creating Cart Table</h1>";
    
    // Check if tables exist
    echo "<h2>Checking existing tables...</h2>";
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    echo "<ul>";
    foreach ($tables as $table) {
        echo "<li>$table</li>";
    }
    echo "</ul>";
    
    // Create cart table
    echo "<h2>Creating cart table...</h2>";
    $sql = "CREATE TABLE IF NOT EXISTS cart (
        cart_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        buyer_id INT UNSIGNED NOT NULL,
        product_id INT UNSIGNED NOT NULL,
        quantity INT NOT NULL DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB";
    
    $pdo->exec($sql);
    echo "✅ Cart table created successfully!<br>";
    
    // Add foreign keys if tables exist
    if (in_array('buyers', $tables)) {
        try {
            $pdo->exec("ALTER TABLE cart ADD CONSTRAINT fk_cart_buyer FOREIGN KEY (buyer_id) REFERENCES buyers(buyer_id) ON DELETE CASCADE ON UPDATE CASCADE");
            echo "✅ Buyer foreign key added!<br>";
        } catch (Exception $e) {
            echo "⚠️ Buyer foreign key already exists or failed: " . $e->getMessage() . "<br>";
        }
    }
    
    if (in_array('products', $tables)) {
        try {
            $pdo->exec("ALTER TABLE cart ADD CONSTRAINT fk_cart_product FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE ON UPDATE CASCADE");
            echo "✅ Product foreign key added!<br>";
        } catch (Exception $e) {
            echo "⚠️ Product foreign key already exists or failed: " . $e->getMessage() . "<br>";
        }
    }
    
    // Verify cart table structure
    echo "<h2>Cart table structure:</h2>";
    $structure = $pdo->query("DESCRIBE cart")->fetchAll();
    echo "<table border='1'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
    foreach ($structure as $column) {
        echo "<tr>";
        echo "<td>{$column['Field']}</td>";
        echo "<td>{$column['Type']}</td>";
        echo "<td>{$column['Null']}</td>";
        echo "<td>{$column['Key']}</td>";
        echo "<td>{$column['Default']}</td>";
        echo "<td>{$column['Extra']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    echo "<h2>✅ Setup Complete!</h2>";
    echo "<p>You can now test adding items to cart. <a href='auth/dashboard'>Go to Dashboard</a></p>";
    
} catch (PDOException $e) {
    echo "<h1>❌ Database Error</h1>";
    echo "<p>Error: " . $e->getMessage() . "</p>";
    echo "<p>Please check your database connection settings.</p>";
}
?>