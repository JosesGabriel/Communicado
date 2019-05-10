<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mobile extends CI_Controller {

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();

        $this->load->model('User_Model');
        $this->load->library("session");
        $this->load->helper('url');
        if($this->load->is_loaded("CI_Minifier")){
            $this->ci_minifier->enable_obfuscator(3);
        }
    }

    function index(){
        $this->load->view('layout/header');
        $this->load->view('mobile/desktop_please_navbar');
        $this->load->view('mobile/desktop_please');
    }

    function im(){
        $this->load->view('layout/header');
        $this->load->view('mobile/desktop_please_navbar');
        $this->load->view('mobile/desktop_please');
    }

    function loginSuccess(){ //http://www.example.com/admin/loginSuccess
        $data["token"]=$this->input->get('r', TRUE); // collecting response token from url query param
        $token=md5(date(DATE_ISO8601, strtotime("now"))); // creating a session token
        $this->session->set_userdata("session_token",$token); // assigning the session to the current session
        $this->session->set_userdata("responseToken",$data["token"]);// assigning the response token to the current session
        $this->session->set_userdata("type","user"); // setting up the user type
        if(!ID_LOGIN) {
            if ($this->User_Model->isValidToken($data["token"])) {
                redirect(base_url("mobile")); // redirecting to http://www.example.com/admin/dashboadr
            } else {
                redirect(base_url('mobile/logout')); // then calling the logout url. http//www.example.com/admin/logout
            }
        }else{
            if ($data["token"]!=null ||trim($data["token"])!="") {
                redirect(base_url("mobile")); // redirecting to http://www.example.com/admin/dashboadr
            } else {
                redirect(base_url('mobile/logout')); // then calling the logout url. http//www.example.com/admin/logout
            }
        }
    }

    function logout(){
        $this->session->set_userdata("session_token",null); // setting the session token to null
        $this->session->set_userdata("responseToken",null);// setting the response token to null
        $this->session->sess_destroy(); // destroying the current session
        redirect(base_url());
    }

}

?>