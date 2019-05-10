<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_friend_list extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field(array(
            'serial' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'userId' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ),
            'friendId' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ),
        ));
        $this->dbforge->add_key('serial', TRUE);
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (userId) REFERENCES users(userId)');
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (friendId) REFERENCES users(userId)');
        $this->dbforge->create_table('friend_list');
    }

    public function down()
    {
        $this->dbforge->drop_table('friend_list');
    }
}