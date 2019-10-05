<?php
require APPPATH.'/libraries/REST_Controller.php';

class DataApi extends REST_Controller
{   // administrator controller
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_Model');
        $this->load->library('session');
    }

    public function index_get()
    {
        $resToken = $this->session->userdata('responseToken');
        if ($this->session->userdata('session_token') != null) { // login
            $response = array(
                'status' => array(
                    'code' => REST_Controller::HTTP_OK,
                    'message' => 'OK'
                ),
                'response' => [],
            );
            $this->response($response, REST_Controller::HTTP_OK);
        }else{
            $response = array(
                'status' => array(
                    'code' => REST_Controller::HTTP_UNAUTHORIZED,
                    'message' => 'Unauthorized Access!',
                
                ),
                'response' => null,
            );
            $this->response($response, REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    public function stocklist_get(){
        die('stocklist');
    }

    public function history_get($exchange, $symbol){
        print('history of '.$exchange.' - '.$symbol);
    }

}
