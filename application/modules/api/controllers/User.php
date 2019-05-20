<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH . '/modules/api/controllers/Api.php');

class User extends Api
{
    public function __construct(){
        parent::__construct();
        $this->load->model("User_Model");
    }
}