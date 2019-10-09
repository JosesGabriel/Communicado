<?php
require APPPATH .'/libraries/REST_Controller.php';

class Activate extends REST_Controller
{   // administrator controller
    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->model('User_Model');
        $this->secret_token = 'Secret123';
    }

    public function index_get()
    {
        // die('test');
        $token = $_GET['token'];
        redirect(base_url('userview/im_invite?token='.$token));
    }
    
    public function user_post()
    {
        $userSecret = $this->post('userSecret', true); 
        $firstName = $this->post('firstName', true); 
        $lastName = $this->post('lastName', true);
        $userEmail = $this->post('userEmail', true);
        $userPassword = password_hash($this->post('userPassword', true), PASSWORD_BCRYPT); 
        // check if email exist
        if (!$this->User_Model->ifExist($userEmail)) {
            // if not register
            $this->User_Model->insert_entry($userSecret, 
                $firstName, 
                $lastName, 
                $userEmail, 
                $userPassword, 
                NULL, 
                NULL, 
                1, 1);
        
            // add user in public group
            $this->User_Model->insertInPublicGroup($userEmail);
            die('activated user');   
        }        
        die('unable to register');
    }
    
}
