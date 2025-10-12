<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Create_buyers_table extends Migration {
    
    public function up() {
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
        
        $this->dbforge->create_table('buyers');
        
        echo "Buyers table created successfully.\n";
    }
    
    public function down() {
        $this->dbforge->drop_table('buyers');
        echo "Buyers table dropped successfully.\n";
    }
}
?>