<?php

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';

class User extends REST_Controller
{
    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->model('User_Model');
        $this->load->model('FriendList_Model');
        $this->load->model('Im_group_members_Model');
        $this->load->model('Im_group_requests_Model');
        $this->load->model('Im_group_moderators_Model');
        $this->load->model('Im_receiver_Model');
        $this->load->model('Im_group_Model');
        $this->load->model('Im_notifications_Model');

        if (!ID_LOGIN) {
            $headers = apache_request_headers();
            if (isset($headers['Authorizationkeyfortoken'])) {
                if (!$this->User_Model->isValidToken($headers['Authorizationkeyfortoken'])) {
                    $response = array(
                        'stauts' => array(
                            'code' => REST_Controller::HTTP_UNAUTHORIZED,
                            'message' => 'Unauthorized',
                        ),
                        'response' => null,
                    );
                    $this->response($response, REST_Controller::HTTP_UNAUTHORIZED);

                    return;
                }
            } else {
                $response = array(
                    'stauts' => array(
                        'code' => REST_Controller::HTTP_UNAUTHORIZED,
                        'message' => 'Unauthorized',
                    ),
                    'response' => null,
                );
                $this->response($response, REST_Controller::HTTP_UNAUTHORIZED);

                return;
            }
        }
    }

    public function changePassword_post()
    {
        if (!ID_LOGIN) {
            $headers = apache_request_headers();
            $id = $this->User_Model->getTokenToId($headers['Authorizationkeyfortoken']);
        } else {
            $id = $this->post('userId');
        }

        $this->form_validation->set_rules('userPassword', 'Old Password', 'required');
        $this->form_validation->set_rules('newPassword', 'New Password', 'required');

        if ($this->form_validation->run() == false) {
            $response = array(
                'status' => array(
                    'code' => REST_Controller::HTTP_NOT_ACCEPTABLE,
                    'message' => 'Validation Error',
                ),
                'response' => validation_errors(),
            );
            $this->response($response, REST_Controller::HTTP_NOT_ACCEPTABLE);
        } else {
            if (!$this->User_Model->userExist($id)) {
                $response = array(
                    'status' => array(
                        'code' => REST_Controller::HTTP_NOT_FOUND,
                        'message' => 'User Not Found',
                    ),
                    'response' => null,
                );
                $this->response($response, REST_Controller::HTTP_NOT_FOUND);
            } else {
                if ($this->User_Model->checkUserPassword($id, $this->post('userPassword'))) {
                    $user = $this->User_Model->update_password($id, $this->post('newPassword'));

                    //$value = $this->jwt->decode($user, $CONSUMER_SECRET);
                    $response = array(
                        'status' => array(
                            'code' => REST_Controller::HTTP_OK,
                            'message' => 'Success',
                        ),
                        'response' => $user,
                    );
                    $this->response($response, REST_Controller::HTTP_OK);
                } else {
                    //$value = $this->jwt->decode($user, $CONSUMER_SECRET);
                    $response = array(
                        'status' => array(
                            'code' => REST_Controller::HTTP_NOT_FOUND,
                            'message' => 'Old Password is not correct',
                        ),
                        'response' => null,
                    );
                    $this->response($response, REST_Controller::HTTP_NOT_FOUND);
                }
            }
        }
    }

    public function friendList_get()
    {
        if (!ID_LOGIN) {
            $headers = apache_request_headers();
            $userId = (int) $this->User_Model->getTokenToId($headers['Authorizationkeyfortoken']);
        } else {
            $userId = $this->get('userId');
        }
        $start = $this->get('start');
        $limit = $this->get('limit', true);
        // ------------------- Section 1 starts----------------//
        $friendIds = $this->FriendList_Model->getList($userId, $limit, $start);           // if you want friend list design uncomment
                                                                              // this section and comment out section 2
        $friends = array();
        foreach ($friendIds as $friendId) {
            $friends[] = $this->User_Model->get_Active_user($friendId->friendId, null, null);
        }
        $responseData = array(
            'friends' => $friends,
            'total' => (int) $this->FriendList_Model->getTotalFriend($userId),
        );
        //------------------ section 1 ends ----------------//
        //------------------section 2 starts ---------------//
        /*$friends=$this->User_Model->getAllActiveUser($userId,$limit,$start);
        $responseData=array(
            "friends"=> $friends,
            "total"=>(int)$this->User_Model->getTotalUser(),
        );*/
        //------------------ section 2 ends ----------------//

        $response = array(
            'status' => array(
                'code' => REST_Controller::HTTP_OK,
                'message' => true,
            ),
            'response' => $responseData,
        );
        $this->response($response, REST_Controller::HTTP_OK);
    }

    public function filterFriendList_get()
    {
        if (!ID_LOGIN) {
            $headers = apache_request_headers();
            $userId = (int) $this->User_Model->getTokenToId($headers['Authorizationkeyfortoken']);
        } else {
            $userId = $this->get('userId');
        }
        $key = $this->get('key', true);

        $friendsIds = $this->FriendList_Model->getFriendsIdAsArray($userId); //only for friend LIST
        $friends = $this->User_Model->filterUser($friendsIds, $key);

        // for all user
        //$friends=$this->User_Model->filterAllUser($userId,$key);

        $response = array(
            'status' => array(
                'code' => REST_Controller::HTTP_OK,
                'message' => true,
            ),
            'response' => $friends,
        );
        $this->response($response, REST_Controller::HTTP_OK);
    }

    public function friendAdd_post()
    {
        if (!ID_LOGIN) {
            $headers = apache_request_headers();
            $userId = (int) $this->User_Model->getTokenToId($headers['Authorizationkeyfortoken']);
        } else {
            $userId = $this->post('userId');
        }
        $this->form_validation->set_rules('friendId', 'friendId', 'required');
        $friendId = $this->post('friendId');
        if ($this->form_validation->run() == false) {
            $response = array(
                'status' => array(
                    'code' => REST_Controller::HTTP_NOT_ACCEPTABLE,
                    'message' => 'Validation Error',
                ),
                'response' => validation_errors(),
            );
            $this->response($response, REST_Controller::HTTP_NOT_ACCEPTABLE);
        } else {
            if (!$this->FriendList_Model->friendExist($userId, $friendId) && !$this->FriendList_Model->friendExist($friendId, $userId) && (int) $userId != (int) $friendId) {
                $this->FriendList_Model->insert($userId, $friendId);
                $this->FriendList_Model->insert($friendId, $userId);
            }
            $response = array(
                'status' => array(
                    'code' => REST_Controller::HTTP_OK,
                    'message' => 'friend added successfully',
                ),
                'response' => true,
            );
            $this->response($response, REST_Controller::HTTP_OK);
        }
    }

    public function userProfile_get()
    {
        if (!ID_LOGIN) {
            $headers = apache_request_headers();
            $id = (int) $this->User_Model->getTokenToId($headers['Authorizationkeyfortoken']);
        } else {
            $id = $this->get('userId');
        }
        $users = $this->User_Model->get_user($id, $this->get('start'), $this->get('limit'));
        $response = array(
            'status' => array(
                'code' => REST_Controller::HTTP_OK,
                'message' => 'Success',
            ),
            'response' => $users,
        );
        $this->response($response, REST_Controller::HTTP_OK);
    }

    public function edit_post()
    {
        if (!ID_LOGIN) {
            $headers = apache_request_headers();
            $id = (int) $this->User_Model->getTokenToId($headers['Authorizationkeyfortoken']);
        } else {
            $id = $this->post('userId');
        }
        $this->form_validation->set_rules('firstName', 'First Name', 'required');
        $this->form_validation->set_rules('userType', 'userType', 'required');

        if ($this->post('userType') == 2) {
            $this->form_validation->set_rules('userAddress', 'userAddress', 'required');
            $this->form_validation->set_rules('userMobile', 'userMobile', 'required');
        }

        if ($this->form_validation->run() == false) {
            $response = array(
                'status' => array(
                    'code' => REST_Controller::HTTP_NOT_ACCEPTABLE,
                    'message' => 'Validation Error',
                ),
                'response' => validation_errors(),
            );
            $this->response($response, REST_Controller::HTTP_NOT_ACCEPTABLE);
        } else {
            if (!$this->User_Model->userExist($id)) {
                $response = array(
                    'status' => array(
                        'code' => REST_Controller::HTTP_NOT_FOUND,
                        'message' => 'User Not Found',
                    ),
                    'response' => null,
                );
                $this->response($response, REST_Controller::HTTP_NOT_FOUND);
            } else {
                $user = $this->User_Model->update_entry($id, $this->post('firstName'), $this->post('lastName'), $this->post('userMobile'), $this->post('userAddress'), $this->post('userGender'), $this->post('userDateOfBirth'));
                if (!ID_LOGIN) {
                    $token = $this->User_Model->getTokenById($id);
                    $type = 'token';
                } else {
                    $token = $this->User_Model->getTokenRAWDataById($id);
                    $type = 'raw';
                }

                //$value = $this->jwt->decode($user, $CONSUMER_SECRET);
                $response = array(
                    'status' => array(
                        'code' => REST_Controller::HTTP_OK,
                        'message' => 'Success',
                    ),
                    'response' => $user,
                    'token' => $token,
                    'type' => $type,
                );
                $this->response($response, REST_Controller::HTTP_OK);
            }
        }
    }

    public function profilePictureUpload_post()
    {
        if (!ID_LOGIN) {
            $headers = apache_request_headers();
            $id = (int) $this->User_Model->getTokenToId($headers['Authorizationkeyfortoken']);
        } else {
            $id = $this->post('userId');
        }

        $userProfilePicture = null;
        if (!$this->User_Model->userExist($id)) {
            $response = array(
                'status' => array(
                    'code' => REST_Controller::HTTP_NOT_FOUND,
                    'message' => 'User Not Found',
                ),
                'response' => null,
            );
            $this->response($response, REST_Controller::HTTP_NOT_FOUND);
        } else {
            //$users = $this->User_Model->get_user($this->post('userId'),null,null);
            $date = date('mjYGis');
            //image uploading section
            $config['upload_path'] = './assets/userImage/';
            $config['allowed_types'] = 'jpg|png';
            $config['file_name'] = $date.'profile'.$id;
            $config['max_size'] = '5120';

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('file')) {
                $response = array(
                    'status' => array(
                        'code' => REST_Controller::HTTP_NOT_FOUND,
                        'message' => 'Image upload Error',
                    ),
                    'response' => $this->upload->display_errors(),
                );
                $this->response($response, REST_Controller::HTTP_NOT_FOUND);
            } else {
                //here $file_data receives an array that has all the info
                //pertaining to the upload, including 'file_name'
                $file_data = $this->upload->data();
                $config['image_library'] = 'gd2';
                $config['source_image'] = $file_data['full_path']; //get original image
                $config['maintain_ratio'] = true;
                $config['width'] = 600;
                $config['height'] = 600;
                $this->load->library('image_lib', $config);
                if (!$this->image_lib->resize()) {
                    $response = array(
                        'status' => array(
                            'code' => REST_Controller::HTTP_BAD_REQUEST,
                            'message' => 'File upload Error',
                        ),
                        'response' => $this->image_lib->display_errors(),
                    );
                    $this->response($response, REST_Controller::HTTP_BAD_REQUEST);
                }

                $userProfilePicture = $file_data['file_name'];
                $user = $this->User_Model->update_picture($id, $userProfilePicture);
                if (!ID_LOGIN) {
                    $token = $this->User_Model->getTokenById($id);
                    $type = 'token';
                } else {
                    $token = $this->User_Model->getTokenRAWDataById($id);
                    $type = 'raw';
                }
                $response = array(
                    'status' => array(
                        'code' => REST_Controller::HTTP_OK,
                        'message' => 'Success',
                    ),
                    'response' => $user,
                    'token' => $token,
                    'type' => $type,
                );
                $this->response($response, REST_Controller::HTTP_OK);
            }
        }
    }

    // Ralph 2019-05-15
    public function searchList_get()
    {
        if (!ID_LOGIN) {
            $headers = apache_request_headers();
            $userId = (int) $this->User_Model->getTokenToId($headers['Authorizationkeyfortoken']);
        } else {
            $userId = $this->get('userId');
        }
        $start = $this->get('start');
        $limit = $this->get('limit', true);

        $friends = $this->User_Model->searchlistAll($userId, $limit, $start);
        $responseData = array(
            'friends' => $friends,
           // "total"=>(int)$this->User_Model->getTotalUser(),
        );

        $response = array(
            'status' => array(
                'code' => REST_Controller::HTTP_OK,
                'message' => true,
            ),
            'response' => $responseData,
        );
        $this->response($response, REST_Controller::HTTP_OK);
    }

    public function hasConversation_get()
    {
        if (!ID_LOGIN) {
            $headers = apache_request_headers();
            $userId = (int) $this->User_Model->getTokenToId($headers['Authorizationkeyfortoken']);
        } else {
            $userId = $this->get('userId');
        }
        $friendId = $this->get('friendId', true);

        $groupId = $this->User_Model->hasConversation($userId, $friendId);
        $responseData = array(
            'groupId' => $groupId,
        );

        $response = array(
            'status' => array(
                'code' => REST_Controller::HTTP_OK,
                'message' => true,
            ),
            'response' => $responseData,
        );
        $this->response($response, REST_Controller::HTTP_OK);
    }

    public function mentionList_get()
    {
        if (!ID_LOGIN) {
            $headers = apache_request_headers();
            $userId = (int) $this->User_Model->getTokenToId($headers['Authorizationkeyfortoken']);
        } else {
            $userId = $this->get('userId');
        }
        $groupId = $this->get('groupId');

        $data = $this->Im_group_members_Model->getMentionlist($userId, $groupId);
        $responseData = array(
            'data' => $data,
        );

        $response = array(
            'status' => array(
                'code' => REST_Controller::HTTP_OK,
                'message' => true,
            ),
            'response' => $responseData,
        );
        $this->response($response, REST_Controller::HTTP_OK);
    }

    public function notificationList_get()
    {
        if (!ID_LOGIN) {
            $headers = apache_request_headers();
            $userId = (int) $this->User_Model->getTokenToId($headers['Authorizationkeyfortoken']);
        } else {
            $userId = $this->get('userid');
        }

        $limit = intval($this->get('limit', true));
        $page = intval($this->get('page', true));
        $pagemod = ($page > 0) ? $page * $limit : 0;

        $data = $this->Im_receiver_Model->notificationList($userId, $limit, $pagemod);
        $data['counttotal'] = $this->Im_receiver_Model->getTotalNotification($userId);
        // pagination
        if ($data['count'] > 0) {
            $data['prev'] = $page != 0 ? 1 : 0;
            $data['next'] = ($data['count'] + max($pagemod, 1)) >= $data['counttotal'] ? 0 : 1;
        } else {
            $data['prev'] = 0;
            $data['next'] = 0;
        }

        $responseData = array(
            'data' => $data['data'],
            'prev' => (int) $data['prev'],
            'next' => (int) $data['next'],
            'prev_page' => intval(max($page - 1, 0)),
            'next_page' => intval($page + 1),
        );

        $response = array(
            'status' => array(
                'code' => REST_Controller::HTTP_OK,
                'message' => true,
            ),
            'response' => $responseData,
        );
        $this->response($response, REST_Controller::HTTP_OK);
    }

    public function communityList_get()
    {
        if (!ID_LOGIN) {
            $headers = apache_request_headers();
            $userId = (int) $this->User_Model->getTokenToId($headers['Authorizationkeyfortoken']);
        } else {
            $userId = $this->get('userId');
        }

        $data = $this->Im_group_Model->getCommunitylist($userId);

        $token = [];
        $page = 1;
        $ctr = 1;
        $perRow = 7;
        $ctr_id = 1;
        foreach ($data as $datum) {
            $token[] = ['id' => $ctr_id++, 'page' => $page, 'data' => $this->jwt->encode($datum, $this->config->item('CONSUMER_SECRET'))];
            if ($ctr != $perRow) {
                ++$ctr;
            } else {
                $ctr = 1;
                ++$page;
            }
        }

        $responseData = array(
            // "_g"=> $this->jwt->encode($token, $this->config->item("CONSUMER_SECRET")),
            '_g' => $token,
        );

        $response = array(
            'status' => array(
                'code' => REST_Controller::HTTP_OK,
                'message' => true,
            ),
            'response' => $responseData,
        );
        $this->response($response, REST_Controller::HTTP_OK);
    }

    public function communityJoin_post()
    {
        if (!ID_LOGIN) {
            $headers = apache_request_headers();
            $userId = (int) $this->User_Model->getTokenToId($headers['Authorizationkeyfortoken']);
        } else {
            $userId = $this->post('userId', true);
        }

        $groupId = $this->post('groupId', true);
        $rawData = $this->post('rawData', true);

        if (!$this->User_Model->userExist($userId)) {
            $response = array(
                'status' => array(
                    'code' => REST_Controller::HTTP_NOT_FOUND,
                    'message' => 'User Not Found',
                ),
                'response' => null,
            );
            $this->response($response, REST_Controller::HTTP_NOT_FOUND);
        } else {
            if ($this->Im_group_Model->getType($groupId) > 0) {
                $response = array(
                    'status' => array(
                        'code' => REST_Controller::HTTP_NOT_FOUND,
                        'message' => 'Invalid Community',
                    ),
                    'response' => null,
                );
                $this->response($response, REST_Controller::HTTP_NOT_FOUND);
            } else {
                $this->Im_group_requests_Model->insert($groupId, $userId);
                // check the admin of the community
                $admin = $this->Im_group_Model->getGroupAdminInfobyGroupId($groupId);
                $notification_type_id = 1; // Tell community admin regarding join request
                $n_id = $this->Im_notifications_Model->insert($userId, $admin->userId, $groupId, $notification_type_id);

                $newData = $this->jwt->decode($rawData, $this->config->item('CONSUMER_SECRET'));
                $newData->status_id = 1;

                $return['n_id'] = (int) $n_id;
                $return['rawData'] = $this->jwt->encode($newData, $this->config->item('CONSUMER_SECRET'));

                $response = array(
                    'status' => array(
                        'code' => REST_Controller::HTTP_OK,
                        'message' => 'Success',
                    ),
                    'response' => $return,
                    'token' => null,
                    'type' => null,
                );
                $this->response($response, REST_Controller::HTTP_OK);
            }
        }
    }

    public function joinrequestList_get()
    {
        if (!ID_LOGIN) {
            $headers = apache_request_headers();
            $userId = (int) $this->User_Model->getTokenToId($headers['Authorizationkeyfortoken']);
        } else {
            $userId = $this->get('userId');
        }

        $g_id = $this->get('groupId', true);

        /* Auth Function */ 
        $admin = $this->Im_group_Model->ifThisUserCreator($g_id, $userId);
        $moderator = $this->Im_group_moderators_Model->ifExist($g_id, $userId); 
        if(!$admin && !$moderator){
            $response = array(
                'status' => array(
                    'code' => REST_Controller::HTTP_UNAUTHORIZED,
                    'message' => 'Unauthorized',
                ),
                'response' => null,
            );
            $this->response($response, REST_Controller::HTTP_UNAUTHORIZED);
        };
        /* ----- */

        $data = $this->Im_group_requests_Model->joinrequestList($g_id);

        $responseData = array(
            'data' => $data,
        );

        $response = array(
            'status' => array(
                'code' => REST_Controller::HTTP_OK,
                'message' => true,
            ),
            'response' => $responseData,
        );
        $this->response($response, REST_Controller::HTTP_OK);
    }

    public function notificationTotal_get()
    {
        if (!ID_LOGIN) {
            $headers = apache_request_headers();
            $userId = (int) $this->User_Model->getTokenToId($headers['Authorizationkeyfortoken']);
        } else {
            $userId = $this->get('userid');
        }

        $count = $this->Im_receiver_Model->getTotalNotification($userId);

        $responseData = array(
            'count' => $count,
        );

        $response = array(
            'status' => array(
                'code' => REST_Controller::HTTP_OK,
                'message' => true,
            ),
            'response' => $responseData,
        );
        $this->response($response, REST_Controller::HTTP_OK);
    }

    public function hasConversation_byUserSecret_get()
    {
        if (!ID_LOGIN) {
            $headers = apache_request_headers();
            $userId = (int) $this->User_Model->getTokenToId($headers['Authorizationkeyfortoken']);
        } else {
            $userId = $this->get('userId');
        }

        $userSecret = $this->get('username', true); // friend usersecret

        // get userid by username to check if user is existing
        $friend = $this->User_Model->fetchBySecret($userSecret);
        $groupId = ($friend) ? $this->User_Model->hasConversation($userId, $friend[0]['userId']) : 0;
        $fID = ($friend) ? intval($friend[0]['userId']) : 0;
        $mingled = $this->FriendList_Model->friendExist($userId, $fID);
        $responseData = array(
            'groupId' => $groupId,
            'fid' => $fID,
            'mingled' => $mingled,
        );

        $response = array(
            'status' => array(
                'code' => REST_Controller::HTTP_OK,
                'message' => true,
            ),
            'response' => $responseData,
        );
        $this->response($response, REST_Controller::HTTP_OK);
    }

    public function communitymoderatorList_get()
    {
        if (!ID_LOGIN) {
            $headers = apache_request_headers();
            $userId = (int) $this->User_Model->getTokenToId($headers['Authorizationkeyfortoken']);
        } else {
            $userId = $this->get('userId');
        }

        $g_id = $this->get('groupId', true);

        //die($g_id);

        $data = $this->Im_group_moderators_Model->communitymoderatorList($userId, $g_id);

        $responseData = array(
            'data' => $data,
        );

        $response = array(
            'status' => array(
                'code' => REST_Controller::HTTP_OK,
                'message' => true,
            ),
            'response' => $responseData,
        );
        $this->response($response, REST_Controller::HTTP_OK);
    }
}
