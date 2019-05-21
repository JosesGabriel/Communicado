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
        
        $this->respond($this->storeUser($data));
    }

    /**
     * TODO Delete a user based on the user's id
     */
    public function delete_post()
    {
        $data = $this->post();

        //region Data validation
        if (!isset($data['id'])) {
            $this->respond([
                'status' => 500,
                'message' => 'User ID is not set.',
            ]);
        }
        //endregion Data validaiton

        $this->respond($this->deleteUser($data));
    }

    /**
     * TODO Fetch a user
     */
    public function fetch_get()
    {
        $data = $this->get();

        $this->respond($this->fetchUser($data));
    }

    /**
     * TODO Update a user based on the user's email
     */
    public function update_post()
    {
        $data = $this->post();

        //region Data validation
        // check for the user's original email
        if (!isset($data['email_id'])) {
            $this->respond([
                'status' => 500,
                'message' => 'User email is not set.',
            ]);
        }
        //endregion Data validaiton

        $this->respond($this->storeUser($data));
    }
    //endregion Route methods

    //region Repositories
    /**
     * Store a user data
     * 
     * @param Array $data
     * @return Array
     */
    private function storeUser($data = [])
    {
        //region Data validation
        if (!isset($data['email_id'])) {
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
        if (!isset($data['email_id'])) {
            if ($this->User_Model->ifExist($data['email'])) {
                return[
                    'status' => 500,
                    'message' => 'Email already exists.',
                ];
            }
        }
        //endregion Existence check

        //region Data insertion
        try {
            if (!isset($data['email_id'])) {
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
                $map_keys = [
                    'first_name' => 'firstName',
                    'last_name' => 'lastName',
                    'email' => 'userEmail',
                    'password' => 'userPassword',
                    'address' => 'userAddress',
                    'mobile' => 'userMobile',
                ];

                $update = [];

                foreach ($data as $field => $value) {
                    if (isset($map_keys[ $field ])) {
                        $table_col = $map_keys[ $field ];

                        if ($field == 'password') {
                            $value = password_hash($value, PASSWORD_BCRYPT);
                        }

                        $update[$table_col] = $value;
                    }
                }
                
                $this->User_Model->db->update('users', $update, ['userEmail' => $data['email_id']]);
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

    /**
     * TODO Delete a user data
     */
    private function deleteUser($data = [])
    {

    }

    /**
     * TODO Fetch a user data
     */
    private function fetchUser($data = [])
    {

    }
    //endregion Repositories
}