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

        // echo "<pre>";
        // print_r($token->getClaims());
        // exit;

        // initialize all claims
        $user_login = $token->getClaim('user_login');        
        $id = $token->getClaim('id');  // Arbi user id
        $userSecret = $token->getClaim('user_secret');
        $firstName = $token->getClaim('first_name'); 
        $lastName = $token->getClaim('last_name');
        $userEmail = $token->getClaim('email');
        $userProfilePicture = 'https://arbitrage.ph/wp-content/uploads/ultimatemember/'.intval($id).'/profile_photo.png';
        $default_password = '123456';
        $userPassword = password_hash($default_password, PASSWORD_BCRYPT); 

        if (!$this->User_Model->ifExist($userEmail)) {
            // if not register
            $this->User_Model->insert_entry_v2($userSecret, 
                $firstName, 
                $lastName, 
                $userEmail, 
                $userPassword, 
                NULL, 
                NULL, 
                1, 1,
                $userProfilePicture,
                $user_login);
        
            // add user in public group
            $this->User_Model->insertInPublicGroup($userEmail); 
        }
        // if (!isset($user[0])) {
        //     $this->respond([
        //         'status' => 404,
        //         'message' => 'User not found.',
        //     ]);
        // }
        //endregion Existence check

        //region User validation
        $record = $this->User_Model->fetchBySecret($userSecret);
        $user = $record[0];

        // echo "<pre>";
        // print_r($user);
        // exit;

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

       // $this->User_Model->activate_entry($email);

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
        $this->User_Model->update_arby_userlogin($user['userId'], $user_login);

        $this->load->view('login', compact('login_token', 'type'));
    }

}
