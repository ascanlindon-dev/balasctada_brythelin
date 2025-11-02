-- Create cart table for CRAFTIFY project
-- Run this SQL in your database management tool

CREATE TABLE IF NOT EXISTS cart (
    cart_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    buyer_id INT UNSIGNED NOT NULL,
    product_id INT UNSIGNED NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Add foreign key constraints (run these after the table is created)
-- Note: Make sure buyers and products tables exist first

ALTER TABLE cart 
ADD CONSTRAINT fk_cart_buyer 
FOREIGN KEY (buyer_id) REFERENCES buyers(buyer_id) 
ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE cart 
ADD CONSTRAINT fk_cart_product 
FOREIGN KEY (product_id) REFERENCES products(product_id) 
ON DELETE CASCADE ON UPDATE CASCADE;

-- Verify the table was created
DESCRIBE cart;

-- Check if tables exist
SHOW TABLES;