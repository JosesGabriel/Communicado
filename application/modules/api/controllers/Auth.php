<?php

defined('BASEPATH') or exit('No direct script access allowed');
require(APPPATH . '/modules/api/controllers/Api.php');

class Auth extends Api
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model("User_Model");
    }

    public function login_get()
    {
        $data = $this->get();

        $is_valid = $this->jwtbuilder->setToken($data['sso_token'])->validateLoginToken();

        //region Data validation
        if (!$is_valid) {
            $this->respond([
                'status' => 500,
                'message' => 'Unauthorized access.',
            ]);
        }
        //endregion Data validation

        //region Existence check
        $token = $this->jwtbuilder->getToken();
        $user_secret = $token->getClaim('user_secret');
        $user = $this->User_Model->fetchBySecret($user_secret);

        if (!isset($user[0])) {
            $this->respond([
                'status' => 404,
                'message' => 'User not found.',
            ]);
        }
        //endregion Existence check

        //region User validation
        $user = $user[0];
        $email = $user['userEmail'];

        if (!$this->User_Model->checkVerification($email)) {
            $this->respond([
                'status' => 500,
                'message' => 'Email is not verified.',
            ]);
        }

        if (!$this->User_Model->adminBlock($email)) {
            $this->respond([
                'status' => 500,
                'message' => 'Account is BLOCKED by Administrator.',
            ]);
        }
        //endregion User validation

        $this->User_Model->activate_entry($email);

        if(!ID_LOGIN){
            $login_token = $this->User_Model->getToken($email);
            $type="token";
        }else{
            $login_token=$this->User_Model->getTokenRAWData($email);
            $type="raw";
        }

        // $response = array(
        //     "status" => array(
        //         "code" => REST_Controller::HTTP_OK,
        //         "message" => "Success"
        //     ),
        //     "response" => $login_token,
        //     "type"=>$type
        // );
        
        // add user in public group
        $this->User_Model->insertInPublicGroup($email);
        
        $this->load->view('login', compact('login_token', 'type'));
    }

}
