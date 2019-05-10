<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Im_group_members extends CI_Migration
{
    /*
   |--------------------------------------------------------------------------
   | Creating message group member table. here every group member information will be kept
     by group id and user id
   |--------------------------------------------------------------------------
   */
    public function up()
    {
        $this->dbforge->add_field(array(
            'serial' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'g_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ),
            'u_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ),
        ));
        $this->dbforge->add_key('serial', TRUE);
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (u_id) REFERENCES users(userId)');
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (g_id) REFERENCES im_group(g_id)');
        $this->dbforge->create_table('im_group_members');
    }

    public function down()
    {
        $this->dbforge->drop_table('im_group_members');
    }
}