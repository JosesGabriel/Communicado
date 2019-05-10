<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class AdminApi extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model("User_Model");
        $this->load->model("Admin_Model");
        $this->load->model("Im_group_Model");
        $this->load->model("Im_group_members_Model");
        $this->load->model("Im_message_Model");

            $headers = apache_request_headers();
            if (isset($headers["Authorizationkeyfortoken"])) {
                if (!$this->User_Model->isValidToken($headers["Authorizationkeyfortoken"])) {
                    $response = array(
                        "stauts" => array(
                            "code" => REST_Controller::HTTP_UNAUTHORIZED,
                            "message" => "Unauthorized"
                        ),
                        "response" => null
                    );
                    $this->response($response, REST_Controller::HTTP_UNAUTHORIZED);
                    return;
                }
            } else {
                $response = array(
                    "stauts" => array(
                        "code" => REST_Controller::HTTP_UNAUTHORIZED,
                        "message" => "Unauthorized"
                    ),
                    "response" => null
                );
                $this->response($response, REST_Controller::HTTP_UNAUTHORIZED);
                return;
            }

    }
    public function getGroups_get(){  //get all groups

        $userId = $this->get("userId",true);
        $limit=$this->get("limit",true);
        $start=$this->get("start",true);
        $group_ids=$this->Im_group_members_Model->getGroups($userId,$limit,$start);
        $groups=array();
        foreach ($group_ids as $g_id){
            $membersInfo=array();
            $groupImage=array();
            $groupInfo=$this->Im_group_Model->get($g_id->g_id);
            $lastActive=$groupInfo->lastActive;
            $groupName=$groupInfo->name;


            $recentMessage=$this->Im_message_Model->getRecentMessage($g_id->g_id);

            $members=$this->Im_group_members_Model->getMembersWihoutSender($g_id->g_id,$userId);
            foreach ($members as $u_id){
                $membersInfo[]=$this->User_Model->get_user($u_id->u_id,null,null);
            }
            $totalMember=$this->Im_group_members_Model->getTotalGroupMember($g_id->g_id);
            if($totalMember>1) {
                if ($totalMember >= 4) {
                    for ($i = 0; $i < 3; $i++) {
                        $groupImage[] = $membersInfo[$i]['profilePictureUrl'];
                    }
                } else if ($totalMember >= 3) {
                    for ($i = 0; $i < 2; $i++) {
                        $groupImage[] = $membersInfo[$i]['profilePictureUrl'];
                    }
                } else if ($totalMember <= 2) {
                    $groupImage[] = $membersInfo[0]['profilePictureUrl'];
                }
                $totalMember = $totalMember - 1;
            }
            else {
                $groupImage[]=base_url()."assets/img/download.png";
                if($groupName==null||$groupName==""|| $groupName=='""'|| $groupName=="''") {
                    $groupName = "No Member";
                }
            }

            if($groupName==null ||$groupName==""|| $groupName=='""'|| $groupName=="''"){
                $groupName="";
                if($totalMember<=2){
                    for ($i=0;$i<$totalMember;$i++){
                        if($i==($totalMember-1)){
                            $groupName.=" ".$membersInfo[$i]['firstName'];
                        }
                        else{
                            $groupName.=" ".$membersInfo[$i]['firstName'].",";
                        }
                    }
                }elseif ($totalMember>=3){
                    for ($i=0;$i<$totalMember;$i++){
                        if($i==($totalMember-1)){
                            $groupName.=" ".$membersInfo[$i]['firstName'];
                        }
                        else{
                            $groupName.=" ".$membersInfo[$i]['firstName'].",";
                        }
                    }
                }else{
                    $groupName = "No Member";
                }
            }
            $lastActive=date_format(date_create($lastActive),DATE_ISO8601);
            if($recentMessage==null){
                $groups[]=array(
                    "groupId"=>(int)$g_id->g_id,
                    "groupImage"=>$groupImage,
                    "groupName"=>trim($groupName),
                    //"totalMember"=>$totalMember,
                    "lastActive"=>$lastActive,
                    //"members"=>$membersInfo,
                    //"me"=>$me,
                    "recentMessage"=>null,
                    "messageType"=>null,
                    //"messageDateTime"=>$recentMessage->date_time,
                );
            }else{
                $groups[]=array(
                    "groupId"=>(int)$g_id->g_id,
                    "groupImage"=>$groupImage,
                    "groupName"=>trim($groupName),
                    //"totalMember"=>$totalMember,
                    "lastActive"=>$lastActive,
                    //"members"=>$membersInfo,
                    //"me"=>$me,
                    "recentMessage"=>$recentMessage->message,
                    "messageType"=>$recentMessage->type,
                    //"messageDateTime"=>$recentMessage->date_time,
                );
            }

        }
        $response = array(
            "status" => array(
                "code" => REST_Controller::HTTP_OK,
                "message" => "Success"
            ),
            "response" =>$groups
        );
        $this->response($response, REST_Controller::HTTP_OK);
    }
    public function getMessage_get(){ //groupId or usersId[] one must not null, date, time


        $g_id=$this->get("groupId",true);
        $start=$this->get("start",true);
        $limit=$this->get("limit",true);

        if($g_id==null){
            $users=$this->get("users");
            if($users==null){
                $response = array(
                    "status" => array(
                        "code" => REST_Controller::HTTP_NOT_ACCEPTABLE,
                        "message" => "Error "
                    ),
                    "response" => "Either user ids or receiver id is required"
                );
                $this->response($response, REST_Controller::HTTP_NOT_ACCEPTABLE);
                return;
            }
            $groupsIds=$this->Im_group_members_Model->getGroups($users,null,null);
            foreach ($groupsIds as $groupId){
                $totalReceiver=$this->Im_group_members_Model->getTotalGroupMember($groupId->g_id);
                if(($totalReceiver-1)==count($users)){
                    $g_id=$groupId->g_id;
                    break;
                }
            }
        }
        $messages=$this->Im_message_Model->getMessage($g_id,$start,$limit);  //get messages
        $totalMessage=$this->Im_message_Model->getTotalMessage($g_id);
        $data=[];
        foreach ($messages as $message){
            $senderProfile=$this->User_Model->get_user($message->sender,null,null);
            $ios_date_time =date_format(date_create($message->date_time),DATE_ISO8601);
            $message->ios_date_time=$ios_date_time;
            $data[]=array(
                //"self"=>true,
                "sender"=>$senderProfile,
                "message"=>$message
            );
            /*if((int)$r_id==(int)$userId){

                $data[]=array(
                    //"self"=>true,
                    "sender"=>$senderProfile,
                    "message"=>$message
                );
            }else{
                $data[]=array(
                    //"self"=>false,
                    "sender"=>$senderProfile,
                    "message"=>$message
                );
            }*/

        }

        $response = array(
            "status" => array(
                "code" => REST_Controller::HTTP_OK,
                "message" => "Success"
            ),
            "totalMessage"=>$totalMessage,
            "response" =>array_reverse($data)

        );
        $this->response($response, REST_Controller::HTTP_OK);

    }
    public function searchUserEmail_get(){
        $email=$this->get("email",true);
        $result=$this->Admin_Model->searchUserEmail($email);
        $response = array(
            "stauts" => array(
                "code" => REST_Controller::HTTP_OK,
                "message" => "Success"
            ),
            "response" => $result
        );
        $this->response($response, REST_Controller::HTTP_OK);
    }



    public function blockUser_post(){
        $this->form_validation->set_rules('userId', 'userId', 'required');

        if ($this->form_validation->run() == FALSE) {
            $response = array(
                "status" => array(
                    "code" => REST_Controller::HTTP_NOT_ACCEPTABLE,
                    "message" => "userId Is Required"
                ),
                "response" => validation_errors()
            );
            $this->response($response, REST_Controller::HTTP_NOT_ACCEPTABLE);

        }else{
            $userId=$this->post('userId',true);
            //$userInfo=$this->User_Model->get_user($this->post('userId',true),null,null);
            //$getContactEmail=$this->Admin_Model->getContactInfo();
            /*$config=array(
                'mailtype'  => 'html',
                'charset'   => 'iso-8859-1'
            );
            $this->load->library('email',$config);
            $this->email->set_newline("\r\n");

            $data=array(
                'userName'=>$userInfo['firstName'],
                'supportEmail'=>"support@im-messenger.com"
            );*/

            /*$message=$this->load->view('emailTemplates/userBlock',$data,true);
            $to_email = $userInfo['userEmail'];

            $this->email->send();
            $this->email->from('admin@vyndue.com', 'Vyndue');
            $this->email->to($this->security->xss_clean($to_email));
            $this->email->subject('Account deactivation');
            $this->email->message($message);
            $this->email->send();
            */

            $this->Admin_Model->blockUser($userId);
            $response = array(
                "status" => array(
                    "code" => REST_Controller::HTTP_OK,
                    "message" => "ok"
                ),
                "response" => true
            );
            $this->response($response, REST_Controller::HTTP_OK);
        }
    }

    public function getMembers_get(){

        $userId = $this->get("userId",true);
        $g_id=$this->get("groupId",true);
        if($g_id==null){
            $response = array(
                "status" => array(
                    "code" => REST_Controller::HTTP_NOT_ACCEPTABLE,
                    "message" => "Error "
                ),
                "response" => "groupId is required"
            );
            $this->response($response, REST_Controller::HTTP_NOT_ACCEPTABLE);
            return ;
        }
        $membersInfo=array();

        $members=$this->Im_group_members_Model->getMembersWihoutSender($g_id,$userId);

        foreach ($members as $u_id){
            $membersInfo[]=$this->User_Model->get_user($u_id->u_id,null,null);
        }

        $meCreator=$this->Im_group_Model->ifThisUserCreator($g_id,$userId);
        $response = array(
            "status" => array(
                "code" => REST_Controller::HTTP_OK,
                "message" => "Success"
            ),
            "response" =>array(
                "meCreator"=>$meCreator,
                "memberList"=>$membersInfo
            )

        );
        $this->response($response, REST_Controller::HTTP_OK);
    }

    public function unblockUser_post(){
        $this->form_validation->set_rules('userId', 'userId', 'required');

        if ($this->form_validation->run() == FALSE) {
            $response = array(
                "status" => array(
                    "code" => REST_Controller::HTTP_NOT_ACCEPTABLE,
                    "message" => "Date Is Required"
                ),
                "response" => validation_errors()
            );
            $this->response($response, REST_Controller::HTTP_NOT_ACCEPTABLE);
        }else{
            $this->Admin_Model->unblockUser($this->post('userId'));
            $response = array(
                "status" => array(
                    "code" => REST_Controller::HTTP_OK,
                    "message" => "ok"
                ),
                "response" => true
            );
            $this->response($response, REST_Controller::HTTP_OK);
        }
    }

    public function verifyUser_post(){
        $this->form_validation->set_rules('userId', 'userId', 'required');

        if ($this->form_validation->run() == FALSE) {
            $response = array(
                "status" => array(
                    "code" => REST_Controller::HTTP_NOT_ACCEPTABLE,
                    "message" => "Date Is Required"
                ),
                "response" => validation_errors()
            );
            $this->response($response, REST_Controller::HTTP_NOT_ACCEPTABLE);
        }else{
            $this->Admin_Model->verifyUser($this->post('userId'));
            $response = array(
                "status" => array(
                    "code" => REST_Controller::HTTP_OK,
                    "message" => "ok"
                ),
                "response" => true
            );
            $this->response($response, REST_Controller::HTTP_OK);
        }
    }
    public function getUserById_get(){

        $userId=$this->get('userId',true);
        if ($userId==null || $userId=="") {
            $response = array(
                "status" => array(
                    "code" => REST_Controller::HTTP_NOT_ACCEPTABLE,
                    "message" => "userId is Required"
                ),
                "response" => validation_errors()
            );
            $this->response($response, REST_Controller::HTTP_NOT_ACCEPTABLE);
        }else{
            $user=$this->User_Model->get_user($userId,null,null);
            //$userBaby=$this->Baby_Model->get_babyByUserId($userId,null,null);
           // $user["totalBaby"]=count($userBaby);

            $user["userUpdate"]=$this->Admin_Model->getUserProfileLastUpdate($userId);
            $user["totalGroups"]=$this->Admin_Model->getTotalGroupByUserId($userId);
            $response = array(
                "status" => array(
                    "code" => REST_Controller::HTTP_OK,
                    "message" => "ok"
                ),
                "response" => $user
            );
            $this->response($response, REST_Controller::HTTP_OK);
        }
    }
    public function getAdminById_get(){

        $userId=$this->get('userId',true);
        if ($userId==null || $userId=="") {
            $response = array(
                "status" => array(
                    "code" => REST_Controller::HTTP_NOT_ACCEPTABLE,
                    "message" => "userId is Required"
                ),
                "response" => "userId is Required"
            );
            $this->response($response, REST_Controller::HTTP_NOT_ACCEPTABLE);
        }else{
            $user=$this->Admin_Model->getAdminById($userId);
            $response = array(
                "status" => array(
                    "code" => REST_Controller::HTTP_OK,
                    "message" => "ok"
                ),
                "response" => $user
            );
            $this->response($response, REST_Controller::HTTP_OK);
        }
    }

    public function createAdmin_post(){
        $this->form_validation->set_rules('userName', 'userName', 'required');
        $this->form_validation->set_rules('userEmail', 'userEmail', 'required');
        $this->form_validation->set_rules('userPass', 'userPass', 'required');
        $this->form_validation->set_rules('userType', 'userType', 'required');

        if ($this->form_validation->run() == FALSE) {
            $response = array(
                "status" => array(
                    "code" => REST_Controller::HTTP_NOT_ACCEPTABLE,
                    "message" => "Empty Field"
                ),
                "response" => validation_errors()
            );
            $this->response($response, REST_Controller::HTTP_NOT_ACCEPTABLE);
        }else{
            $CONSUMER_KEY = $this->User_Model->generateRandomString();

            if ($this->User_Model->ifExist($this->post('userEmail',true))) {
                $response = array(
                    "status" => array(
                        "code" => REST_Controller::HTTP_CONFLICT,
                        "message" => "Email already exist!"
                    ),
                    "response" => "Email already exist!"
                );
                $this->response($response, REST_Controller::HTTP_CONFLICT);
            }else{
                $this->Admin_Model->createAdmin($CONSUMER_KEY,$this->post('userName',true),$this->post('userEmail',true),$this->post('userPass',true),$this->post('userType',true));
                $response = array(
                    "status" => array(
                        "code" => REST_Controller::HTTP_OK,
                        "message" => "ok"
                    ),
                    "response" => true
                );
                $this->response($response, REST_Controller::HTTP_OK);
            }
        }
    }

    public function updateAdmin_post(){
        $this->form_validation->set_rules('userId', 'userId', 'required');
        $this->form_validation->set_rules('userName', 'userName', 'required');
        $this->form_validation->set_rules('userEmail', 'userEmail', 'required|valid_email');
        $superSuperAdmin=$this->post("supersuperAdmin",true);
        if($superSuperAdmin==null){
            $this->form_validation->set_rules('updateUserType', 'updateUserType', 'required');
            $role=$this->post('updateUserType',true);
        }else{
            $this->form_validation->set_rules('supersuperAdmin', 'supersuperAdmin', 'required');
            $role=$role=$this->post('supersuperAdmin',true);
        }


        if ($this->form_validation->run() == FALSE) {
            $response = array(
                "status" => array(
                    "code" => REST_Controller::HTTP_NOT_ACCEPTABLE,
                    "message" => "Empty Field"
                ),
                "response" => validation_errors()
            );
            $this->response($response, REST_Controller::HTTP_NOT_ACCEPTABLE);
        }else{

            if (!$this->User_Model->ifExist($this->post('userEmail'))) {
                $response = array(
                    "status" => array(
                        "code" => REST_Controller::HTTP_CONFLICT,
                        "message" => "User not exist!"
                    ),
                    "response" => "User not exist!"
                );
                $this->response($response, REST_Controller::HTTP_CONFLICT);
            }else{
                $adminId=$this->post('userId',true);
                if(!is_int ((int)$adminId)){
                    $this->response('Invalid UserId', REST_Controller::HTTP_NOT_ACCEPTABLE);
                    return;
                }

                if(DEMO && (int)$adminId===1){
                    $this->response('can not Update super user in Demo.', REST_Controller::HTTP_BAD_REQUEST);
                    return;
                }

                $this->Admin_Model->updateAdmin($adminId,$this->post('userName',true),$this->post('userEmail',true),$this->post('userPass',true),$role);
                $response = array(
                    "status" => array(
                        "code" => REST_Controller::HTTP_OK,
                        "message" => "ok"
                    ),
                    "response" => true
                );
                $this->response($response, REST_Controller::HTTP_OK);
            }
        }
    }

    public function deleteAdmin_get()
    {
       $adminId=$this->get('adminId',true);
        if($adminId==null || $adminId==''){
            $response = array(
                "status" => array(
                    "code" => REST_Controller::HTTP_NOT_ACCEPTABLE,
                    "message" => "User id Is Required"
                ),
                "response" => "User id is Required"
            );
            $this->response($response, REST_Controller::HTTP_NOT_ACCEPTABLE);
        }
        else{
            if(!is_int ((int)$adminId)){
                $this->response('Invalid UserId', REST_Controller::HTTP_NOT_ACCEPTABLE);
                return;
            }

            if((int)$adminId===1){
                $this->response('can not delete super user.', REST_Controller::HTTP_BAD_REQUEST);
                return;
            }
            $this->Admin_Model->deleteAdmin($adminId);
            $response = array(
                "status" => array(
                    "code" => REST_Controller::HTTP_OK,
                    "message" => "ok"
                ),
                "response" => true
            );
            $this->response($response, REST_Controller::HTTP_OK);
        }
    }

    /**
     *admin panel chart data
     */
    public function getChartData_get(){
        $year=$this->get("year",true);
        $data=$this->Admin_Model->getMonthelyMessage($year);

        $response = array(
            "status" => array(
                "code" => REST_Controller::HTTP_OK,
                "message" => "ok"
            ),
            "response" => $data
        );
        $this->response($response, REST_Controller::HTTP_OK);
    }
}