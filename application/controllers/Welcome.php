<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

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



	public function index()

	{


        $data["token"]=$this->input->get('token', TRUE);

        $data["demo"]=DEMO;

        //if block determines if a user is already login in this system

        if($this->session->userdata("session_token")!=null){ // if session has a token

            if($this->session->userdata("type")=="user"){    // and the type is 'user'


                if ($this->agent->is_mobile())  // if mobile phone

                {

                    redirect(base_url("mobile"));  // then redirect him to mobile page

                }else{
                    
                    redirect(base_url("userview")); // then redirect him to userview page

                }



            }

            else if($this->session->userdata("type")=="admin"){   // and if the type is 'admin'

                $this->session->set_userdata("session_token",null);  // set the session token variable to null

                $this->load->view('welcome_message',$data);  //then show him the user login page. because admin url is different

            }                                                // admin url is http://www.example.com/admin

        }

        // if no user is login then this else block will be execute

        else{

            $this->load->view('layout/header');   // loading application/views/layout/header.php

            $this->load->view('layout/navbar_empty');// loading application/views/layout/navbar_empty.php

            $this->load->view('welcome_message',$data);// loading application/welcome_message.php

            $this->load->view('layout/header_script');

            $this->load->view('welcome_script',$data);



        }



	}



}