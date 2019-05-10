<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Im_receiver extends CI_Migration
{
    /*
   |--------------------------------------------------------------------------
   | Creating receiver table. here non received message will be kept
   |--------------------------------------------------------------------------
   */
    public function up(){
        $this->dbforge->add_field(array(
            'serial' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'g_id'=>array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ),
            'm_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ),
            'r_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,

            ),
            'received' => array(
                'type' => 'INT',
                'constraint' => 1,
                'null' => FALSE,
            ),
            'time'=>array(
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => FALSE,
            )
        ));
        $this->dbforge->add_key('serial', TRUE);
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (g_id) REFERENCES im_group(g_id)');
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (m_id) REFERENCES im_message(m_id)');
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (r_id) REFERENCES users(userId)');
        $this->dbforge->create_table('im_receiver');
    }

    public function down(){
        $this->dbforge->drop_table('im_receiver');
    }
}