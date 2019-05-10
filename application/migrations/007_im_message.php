<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Im_message extends CI_Migration
{
    /*
   |--------------------------------------------------------------------------
   | Creating message table. here every message will be saved with sender and receiver information.
    here receiver is a id which ref group id
   |--------------------------------------------------------------------------
   */
    public function up()
    {
        $this->dbforge->add_field(array(
            'm_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'sender'=>array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE
            ),
            'receiver'=>array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE
            ),
            'message'=>array(
                'type' => 'VARCHAR',
                'constraint' => '500',
                'null' => FALSE,
            ),
            'type'=>array(
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => FALSE,
            ),
            'receiver_type'=>array(
                'type' => 'ENUM("group","user")',
                'DEFAULT' => 'user',
            ),
            'date'=>array(
                'type' => 'DATE',
            ),
            'time'=>array(
                'type' => 'TIME',
            ),
            'date_time'=>array(
                'type' => 'TIMESTAMP',
            )


        ));

        $this->dbforge->add_key('m_id', TRUE);
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (sender) REFERENCES users(userId)');
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (receiver) REFERENCES im_group(g_id)');
        $this->dbforge->create_table('im_message');
    }

    public function down()
    {
        $this->dbforge->drop_table('im_message');
    }
}