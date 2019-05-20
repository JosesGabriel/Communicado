<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH . '/modules/api/controllers/Api.php');

class User extends Api
{
    public function __construct(){
        parent::__construct();
        $this->load->model("User_Model");
    }

    //region Route methods
    /**
     * Create a user
     * 
     * @return Void
     */
    public function create_post()
    {
        $data = $this->post();
        
        $this->respond($this->store($data));
    }
    //endregion Route methods

    //region Repositories
    /**
     * Store a user data
     * 
     * @param Array $data
     * @return Array
     */
    private function store($data = [])
    {
        //region Data validation
        if (!isset($data['id'])) {

            if (!isset($data['username']) ||
                trim($data['username']) == '') {
                return [
                    'status' => 500,
                    'message' => 'Username is invalid or not set.',
                ];
            }
    
            if (!isset($data['email']) ||
                trim($data['email']) == '') {
                return [
                    'status' => 500,
                    'message' => 'Email is invalid or not set.'
                ];
            }
    
            if (!isset($data['password']) ||
                trim($data['password']) == '') {
                return [
                    'status' => 500,
                    'message' => 'Password is invalid or not set.'
                ];
            }
    
            if (!isset($data['first_name']) ||
                trim($data['first_name']) == '') {
                return [
                    'status' => 500,
                    'message' => 'First name is invalid or not set.'
                ];
            }
    
            if (!isset($data['last_name']) ||
                trim($data['last_name']) == '') {
                return [
                    'status' => 500,
                    'message' => 'Last name is invalid or not set.'
                ];
            }
        }
        //endregion Data validation

        //region Existence check
        if ($this->User_Model->ifExist($data['email'])) {
            return[
                'status' => 500,
                'message' => 'Email already exists.',
            ];
        }
        //endregion Existence check

        //region Data insertion
        try {
            if (!isset($data['id'])) {
                //region Create new user
                $CONSUMER_KEY = $this->User_Model->generateRandomString();
        
                $this->User_Model->insert_entry(
                    $CONSUMER_KEY, 
                    $data['first_name'], 
                    $data['last_name'], 
                    $data['email'],
                    $data['password'], 
                    ($data['address'] ?? ''),
                    ($data['mobile'] ?? ''),
                    1, 1
                );
                
                $this->User_Model->insertInPublicGroup($this->post('userEmail',true));
                //endregion Create new user
            } else {
                //region Update user
                
                //endregion Update user
            }
        } catch (Exception $e) {
            return [
                'status' => 500,
                'message' => 'An error occurred.',
            ];
        }
        //endregion Data insertion

        //region Format data response
        if (isset($data['password'])) {
            unset($data['password']);
        }
        //endregion Formate data response

        return [
            'status' => 200,
            'message' => 'Successfully created user.',
            'data' => [
                'user' => $data,
            ],
        ];
    }
    //endregion Repositories
}