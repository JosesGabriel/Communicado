<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH . '/libraries/REST_Controller.php');

class Api extends REST_Controller
{
    public function __construct(){
        parent::__construct();
    }

    public function respond($data)
    {
        $status = $data['status'] ?? 200;

        $response = [
            'status' => $status,
            'success' => $status >= 200 || $status <= 299,
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
}