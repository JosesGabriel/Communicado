<?php

class Activate extends CI_Controller
{   // administrator controller
    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }

    public function index()
    {
        // die('test');
        $token = $_GET['token'];
        redirect(base_url('userview/im_invite?token='.$token));
    }
}
