<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Im_group extends CI_Migration
{
    /*
   |--------------------------------------------------------------------------
   | Creating message group table. here every chat is considered as a group message
   | and every group has a unique id and saving the group creator id
   |--------------------------------------------------------------------------
   */
    public function up()
    {
        $this->dbforge->add_field(array(
            'g_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'name'=>array(
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => TRUE,
            ),
            "createdBy"=>array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ),
            "lastActive"=>array(
                'type' => 'TIMESTAMP',
                'null' => TRUE,
            )
        ));
        $this->dbforge->add_key('g_id', TRUE);
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (createdBy) REFERENCES users(userId)');
        $this->dbforge->create_table('im_group');
    }

    public function down()
    {
        $this->dbforge->drop_table('im_group');
    }
}