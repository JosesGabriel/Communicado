<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH . '/libraries/REST_Controller.php');

class Api extends REST_Controller
{
    public function __construct(){
        
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: *");
        // header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
            die();
        }
        parent::__construct();
    }

    public function respond($data)
    {
        $status = $data['status'] ?? 200;

        $response = [
            'status' => $status,
            'success' => $this->isResponseSuccess($status),
            'message' => $data['message'] ?? '',
            'data' => $data['data'] ?? [],
        ];

        if (!$response['success']) {
            $response['error'] = [
                'message' => $response['message'],
            ];
            unset($response['message']);
        }

        $this->response($response, $status);
    }

    public function isResponseSuccess($status)
    {
        return $status >= 200 && $status <= 299;
    }
}