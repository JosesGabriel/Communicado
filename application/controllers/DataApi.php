<?php
require APPPATH .'/libraries/REST_Controller.php';
require APPPATH .'/helper-classes/guzzle-class.php';

class DataApi extends REST_Controller
{   // administrator controller
    protected $guzzleClient;

    public function __construct()
    {
        parent::__construct();
        $this->guzzleClient = new GuzzleRequest();
        $this->client_secret = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJjbGllbnRfbmFtZSI6IjRSQjErUjQ5MyJ9.SZzdF4-L3TwqaGxfb8sR-xeBWWHmGyM4SCuBc1ffWUs';
        $this->load->model('User_Model');
        $this->load->library('session');
    }

    public function index_get()
    {
        
        $this->guzzleClient->test();

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
        if (!$this->isUserLoggedIn()) {
            $response = array(  
                'status' => array(
                    'code' => REST_Controller::HTTP_UNAUTHORIZED,
                    'message' => 'Unauthorized Access!',
                
                ),
                'response' => null,
            );
            $this->response($response, REST_Controller::HTTP_UNAUTHORIZED);
        }

        $result = $this->forwardRequest("https://data-api.arbitrage.ph/api/v1/stocks/list");
        $this->response(json_decode($result->content), $result->status_code);
    }

    public function history_get($exchange, $symbol){
        print('history of '.$exchange.' - '.$symbol);
    }

    public function forwardRequest($url){
        $request = $this->guzzleClient->request("GET", $url, [
            "headers" => [
                "Content-type" => "application/json",
                "Authorization" => "Bearer {$this->client_secret}",
                ]
            ]);
 
         return $request;
    }

    public function isUserLoggedIn(){
        $resToken = $this->session->userdata('responseToken');

        if ($this->session->userdata('session_token') == null) {
            return false;
        }   

        return true;
    }
}
