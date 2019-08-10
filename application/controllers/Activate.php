<?php

class Activate extends CI_Controller
{   // administrator controller
    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->model('Im_group_invitations_Model');
        $this->load->model('Im_group_invitation_usage_Model');
        $this->load->model('Im_group_members_Model');
    }

    public function index()
    {
        // die('test');
        $token = $_GET['token'];
        redirect(base_url('userview/im_invite?token='.$token));
    }
}
