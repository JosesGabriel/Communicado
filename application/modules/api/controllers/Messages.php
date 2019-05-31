<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH . '/modules/api/controllers/Api.php');

class Messages extends Api
{
    public function __construct(){
        parent::__construct();

        $this->load->model('User_Model');
        $this->load->model('Im_receiver_Model');
    }

    //region Route methods
    public function get_unread_post()
    {
        $data = $this->post();

        //region Data validation
        if (!isset($data['user_secret']) ||
            trim($data['user_secret']) == '') {
            $this->respond([
                'status' => 500,
                'message' => 'User secret is invalid or not set.',
            ]);
        }
        //endregion Data validation

        //region Existence check
        $user = $this->User_Model->fetchBySecret($data['user_secret']);

        if (!isset($user[0])) {
            $this->respond([
                'status' => 404,
                'message' => 'User not found.',
            ]);
        }

        $user = $user[0];
        //endregion Existence check

        $unread = $this->Im_receiver_Model->notificationList($user['userId'], 100, 0)['count'];

        $this->respond([
            'status' => 200,
            'message' => 'Successfully retrieved unread messages.',
            'data' => [
                'unread' => $unread,
            ],
        ]);
    }
    //endregion Route methods
}