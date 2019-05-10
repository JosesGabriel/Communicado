<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_users extends CI_Migration
{

    /*
 |--------------------------------------------------------------------------
 | Creating user table
 |--------------------------------------------------------------------------
 */
    public function up()
    {
        $this->dbforge->add_field(array(
            'userId' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'userSecret' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
            ),
            'firstName' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'lastName' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE,
            ),
            'userEmail' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'userPassword' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
            ),
            'userMobile' => array(
                'type' => 'VARCHAR',
                'constraint' => '30',
                'null' => TRUE,
            ),
            'userDateOfBirth' => array(
                'type' => 'TIMESTAMP',
                'null' => TRUE,
            ),
            'userGender' => array(
                'type' => 'VARCHAR',
                'constraint' => '15',
                'null' => TRUE,
            ),
            'userType' => array(
                'type' => 'INT',
                'constraint' => 11,
            ),
            'lastModified' => array(
                'type' => 'TIMESTAMP',
            ),
        ));
        $this->dbforge->add_key('userId', TRUE); // setting userId as primary key
        $this->dbforge->create_table('users');   // creating the user table
    }

    public function down()
    {
        $this->dbforge->drop_table('users');  //deleting the user table
    }
}
