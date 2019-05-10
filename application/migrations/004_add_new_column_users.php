<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_new_column_users extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    /*
       |--------------------------------------------------------------------------
       | Adding some new column in user table for gathering user information like reset password
       |  token. profile picture location in file system, user address.
       |--------------------------------------------------------------------------
       */
    public function up()
    {
        $fields = array(
            'userResetToken' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'after' => 'userVerification'
            ),
            'userProfilePicture' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'after' => 'userVerification'
            ),
            'userAddress' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'after' => 'userVerification',
                'null'=>TRUE
            )


        );
        $this->dbforge->add_column('users', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('users', 'userResetToken');
        $this->dbforge->drop_column('users', 'userProfilePicture');
    }
}