<?php

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH.'/modules/api/controllers/Api.php';

class User extends Api
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_Model');
        $this->load->model('FriendList_Model');
        $this->load->model('Im_group_Model');
        $this->load->model('Im_group_members_Model');
    }

    //region Route methods

    /**
     * Add friends.
     */
    public function add_friend_post()
    {
        $data = $this->post();

        //region Data validation
        if (!isset($data['requester']) ||
            trim($data['requester']) == '') {
            $this->respond([
                'status' => 500,
                'message' => 'Missing argumennts.',
            ]);
        }

        if (!isset($data['responder']) ||
            trim($data['responder']) == '') {
            $this->respond([
                'status' => 500,
                'message' => 'Missing argumennts.',
            ]);
        }
        //endregion Data validation

        //region User fetching
        $requester = $this->fetchUser($data['requester']);
        $responder = $this->fetchUser($data['responder']);

        if (!$this->isResponseSuccess($requester['status'])) {
            $this->respond($requester);
        }

        if (!$this->isResponseSuccess($responder['status'])) {
            $this->respond($responder);
        }
        //endregion User fetching

        //region Add friend relation
        $requester_id = $requester['data']['user']['userId'];
        $responder_id = $responder['data']['user']['userId'];

        // add friend
        $this->FriendList_Model->insert($requester_id, $responder_id);
        $this->FriendList_Model->insert($responder_id, $requester_id);

        // create group
        $group_id = $this->Im_group_Model->insert(null, $this->getISODateTimeWithMilliSeconds(), 1, $requester_id);

        // add group members
        $this->Im_group_members_Model->insert($group_id, $requester_id);
        $this->Im_group_members_Model->insert($group_id, $responder_id);

        //endregion Add friend relation

        $this->respond([
            'status' => 200,
            'message' => 'Successfully added friend',
        ]);
    }

    /**
     * Create a user.
     */
    public function create_post()
    {
        $data = $this->post();

        $this->respond($this->storeUser($data));
    }

    /**
     * TODO Delete a user based on the user's id.
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
     * Fetch a user by email.
     */
    public function fetch_get()
    {
        $data = $this->get();

        //region Data validation
        if (!isset($data['email'])) {
            $this->respond([
                'status' => 500,
                'message' => 'Email is not set.',
            ]);
        }
        //endregion Data validation

        $this->respond($this->fetchUser($data['email']));
    }

    /**
     * Remove friend link.
     */
    public function remove_friend_post()
    {
        $data = $this->post();

        //region Data validation
        if (!isset($data['requester']) ||
            trim($data['requester']) == '') {
            $this->respond([
                'status' => 500,
                'message' => 'Missing argumennts.',
            ]);
        }

        if (!isset($data['responder']) ||
            trim($data['responder']) == '') {
            $this->respond([
                'status' => 500,
                'message' => 'Missing argumennts.',
            ]);
        }
        //endregion Data validation

        //region User fetching
        $requester = $this->fetchUser($data['requester']);
        $responder = $this->fetchUser($data['responder']);

        if (!$this->isResponseSuccess($requester['status'])) {
            $this->respond($requester);
        }

        if (!$this->isResponseSuccess($responder['status'])) {
            $this->respond($responder);
        }
        //endregion User fetching

        //region Add friend relation
        $requester_id = $requester['data']['user']['userId'];
        $responder_id = $responder['data']['user']['userId'];

        $this->FriendList_Model->delete($requester_id, $responder_id);
        $this->FriendList_Model->delete($responder_id, $requester_id);
        //endregion Add friend relation

        $this->respond([
            'status' => 200,
            'message' => 'Successfully removed friend',
        ]);
    }

    /**
     * TODO Update a user based on the user's email.
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

    public function update_avatar_post()
    {
        $data = $this->post();

        //region Data validation
        if (!isset($data['user_secret']) ||
            trim($data['user_secret']) == '') {
            $this->respond([
                'status' => 500,
                'message' => 'User is not set or invalid.',
            ]);
        }

        if (!isset($data['avatar_url']) ||
            trim($data['avatar_url']) == '') {
            $this->respond([
                'status' => 500,
                'message' => 'User avatar is not set or invalid.',
            ]);
        }
        //endregion Data validation

        //region Existence check
        $user = $this->fetchUserBySecret($data['user_secret']);

        if (!$this->isResponseSuccess($user['status'])) {
            $this->respond($user);
        }

        $user = $user['data']['user'];
        //endregion Existence check

        //region Data update
        $update = $this->User_Model->updateAvatar($user['userId'], $data['avatar_url']);

        if ($update === false) {
            $this->respond([
                'status' => 500,
                'message' => 'An error has occurred while updating.',
            ]);
        }
        //endregion Data update

        $this->respond([
            'status' => 200,
            'message' => 'Successfully updated avatar.',
            'data' => [
                'parameters' => $data,
            ],
        ]);
    }

    //endregion Route methods

    //region Repositories

    /**
     * Store a user data.
     *
     * @param array $data
     *
     * @return array
     */
    private function storeUser($data = [])
    {
        //region Data validation
        if (!isset($data['email_id'])) {
            if (!isset($data['user_secret']) ||
                trim($data['user_secret']) == '') {
                return [
                    'status' => 500,
                    'message' => 'User secret is invalid or not set.',
                ];
            }

            if (!isset($data['email']) ||
                trim($data['email']) == '') {
                return [
                    'status' => 500,
                    'message' => 'Email is invalid or not set.',
                ];
            }

            if (!isset($data['password']) ||
                trim($data['password']) == '') {
                return [
                    'status' => 500,
                    'message' => 'Password is invalid or not set.',
                ];
            }

            if (!isset($data['first_name']) ||
                trim($data['first_name']) == '') {
                return [
                    'status' => 500,
                    'message' => 'First name is invalid or not set.',
                ];
            }

            if (!isset($data['last_name']) ||
                trim($data['last_name']) == '') {
                return [
                    'status' => 500,
                    'message' => 'Last name is invalid or not set.',
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
                //region Create new user]
                $this->User_Model->insert_entry(
                    $data['user_secret'],
                    $data['first_name'],
                    $data['last_name'],
                    $data['email'],
                    $data['password'],
                    ($data['address'] ?? ''),
                    ($data['mobile'] ?? ''),
                    1, 1
                );

                $this->User_Model->insertInPublicGroup($this->post('userEmail', true));
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
                    if (isset($map_keys[$field])) {
                        $table_col = $map_keys[$field];

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
     * TODO Delete a user data.
     */
    private function deleteUser($data = [])
    {
    }

    /**
     * Fetch a user data by email.
     */
    private function fetchUser($email = '')
    {
        //region Data validation
        if (!is_string($email) ||
            trim($email) == '') {
            return [
                'status' => 500,
                'message' => 'Email is invalid.',
            ];
        }
        //endregion Data validation

        //region Data query
        $user = $this->User_Model->fetchByEmail($email);

        if (!isset($user[0])) {
            return [
                'status' => 404,
                'message' => 'User not found.',
            ];
        }

        return [
            'status' => 200,
            'message' => 'Successfully fetched user.',
            'data' => [
                'user' => $user[0],
            ],
        ];
        //endregion Data query
    }

    /**
     * Fetch a user by userSecret.
     *
     * @param string $secret
     *
     * @return array
     */
    private function fetchUserBySecret($secret = '')
    {
        //region Data validation
        if (!is_string($secret) ||
            trim($secret) == '') {
            return [
                'status' => 500,
                'message' => 'User is invalid.',
            ];
        }
        //endregion Data validation

        //region Data query
        $user = $this->User_Model->fetchBySecret($secret);

        if (!isset($user[0])) {
            return [
                'status' => 404,
                'message' => 'User not found.',
            ];
        }

        return [
            'status' => 200,
            'message' => 'Successfully fetched user.',
            'data' => [
                'user' => $user[0],
            ],
        ];
        //endregion Data query
    }

    //endregion Repositories

    //region Helpers
    private function getISODateTimeWithMilliSeconds()
    {
        $time = microtime(true);
        // Determining the microsecond fraction
        $microSeconds = sprintf('%06d', ($time - floor($time)) * 1000000);
        // Creating our DT object
        $tz = new DateTimeZone('Etc/UTC'); // NOT using a TZ yields the same result, and is actually quite a bit faster. This serves just as an example.
        $dt = new DateTime(date('Y-m-d H:i:s.'.$microSeconds, $time), $tz);
        // Compiling the date. Limiting to milliseconds, without rounding
        $iso8601Date = sprintf(
            '%s%03d%s',
            $dt->format("Y-m-d\TH:i:s."),
            floor($dt->format('u') / 1000),
            $dt->format('O')
        );
        // Formatting according to ISO 8601-extended
        return $iso8601Date;
    }

    //endregion Helpers
}
