<?php
// Migration for new buyers, products, and orders tables
class Migration_NewTables extends Migration {
    public function up() {
        // Buyers table
        $this->dbforge->add_field(array(
            'buyer_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'full_name' => array(
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => FALSE
            ),
            'email' => array(
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => FALSE
            ),
            'phone_number' => array(
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => FALSE
            ),
            'password' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ),
            'created_at' => array(
                'type' => 'DATETIME',
                'null' => TRUE
            )
        ));
        $this->dbforge->add_key('buyer_id', TRUE);
        $this->dbforge->add_key('email');
        $this->dbforge->create_table('buyers', TRUE);

        // Products table
        $this->dbforge->add_field(array(
            'product_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'product_name' => array(
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => FALSE
            ),
            'description' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'price' => array(
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => '0.00',
                'null' => FALSE
            ),
            'stock' => array(
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
                'null' => FALSE
            ),
            'category' => array(
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => TRUE
            ),
            'image_url' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            )
        ));
        $this->dbforge->add_key('product_id', TRUE);
        $this->dbforge->add_key('product_name');
        $this->dbforge->create_table('products', TRUE);

        // Orders table
        $this->dbforge->add_field(array(
            'order_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'buyer_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'null' => FALSE
            ),
            'order_date' => array(
                'type' => 'DATETIME',
                'null' => TRUE
            ),
            'total_amount' => array(
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => '0.00',
                'null' => FALSE
            ),
            'status' => array(
                'type' => "ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled')",
                'default' => 'pending',
                'null' => FALSE
            ),
            'payment_method' => array(
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => TRUE
            ),
            'shipping_address' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            ),
            'notes' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'created_at' => array(
                'type' => 'DATETIME',
                'null' => TRUE
            ),
            'updated_at' => array(
                'type' => 'DATETIME',
                'null' => TRUE
            )
        ));
        $this->dbforge->add_key('order_id', TRUE);
        $this->dbforge->add_key('buyer_id');
        $this->dbforge->add_field("CONSTRAINT fk_orders_buyer FOREIGN KEY (buyer_id) REFERENCES buyers(buyer_id) ON DELETE CASCADE");
        $this->dbforge->create_table('orders', TRUE);
    }

    public function down() {
        $this->dbforge->drop_table('orders', TRUE);
        $this->dbforge->drop_table('products', TRUE);
        $this->dbforge->drop_table('buyers', TRUE);
    }
}
