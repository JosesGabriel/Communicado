<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_column_in_users extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    /*
    |--------------------------------------------------------------------------
    | Adding a new column in user table
    |--------------------------------------------------------------------------
    */
    public function up()
    {
        $fields = array(
            'userStatus' => array(
                'type' => 'INT',
                'constraint' => '11',
                'after' => 'userGender'
            )
        );
        $this->dbforge->add_column('users', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('users', 'userStatus');
    }
}