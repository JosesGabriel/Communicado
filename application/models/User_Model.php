<?php

class User_Model extends CI_Model
{
    public $userSecret;
    public $firstName;
    public $lastName;
    public $userEmail;
    public $userPassword;
    public $userMobile;
    public $userDateOfBirth;
    public $userGender;
    public $userStatus;
    public $userVerification;
    public $lastModified;

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->library('encryption');
    }

    public function get_last_ten_entries()
    {
        $query = $this->db->get('users', 10);
        return $query->result();
    }

    public function get_user($id,$start,$limit)
    {
        if ($start == null && $limit == null) {
            $array = array('userId' => $id);
            $this->db->where($array);
            $query = $this->db->get('users');
            // base url if this project is in a sub folder of main project
            //$baseurl=preg_replace('~/[^/]*/([^/]*)$~', '/\1', base_url());
            if($query->row('userProfilePicture')!=null){
                $url = base_url()."assets/userImage/".$query->row()->userProfilePicture;
            }
            else{
                $url = base_url()."assets/img/download.png";
            }

           $profileData = array(
               'userId' =>(int)$query-> row('userId'), //required
               'firstName' =>$query-> row('firstName'), //required
               'lastName'=>$query->row('lastName'), // required
               'userEmail'=>$query->row('userEmail'),// required
               'userSecret'=>$query->row('userSecret'),// required
               'userAddress'=>$query->row('userAddress'),//optional
               'userMobile'=>$query-> row('userMobile'), //optional
               'userStatus'=>(int) $query-> row('userStatus'),// required. bool type(0,1). checks user profile is active or not
               'userGender'=>$query-> row('userGender'),//optional
               'profilePictureUrl' => $url, // required
               'active'=>(int)$query-> row('active')// required. checks user is currently login(active) or not

           );
            return $profileData;
        } else {

            $query = $this->db->get('users', $limit, $start);
            return $query->result();
        }
    }
    public function get_Active_user($id,$start,$limit)
    {
        if ($start == null && $limit == null) {
            $array = array('userId' => $id);
            $this->db->where($array);
            $this->db->where("userStatus <>",0);
            $this->db->where("userVerification <>",0);
            $query = $this->db->get('users');

            if($query->row('userProfilePicture')!=null){
                $url = base_url()."assets/userImage/".$query->row()->userProfilePicture;
            }
            else{
                $url = base_url()."assets/img/download.png";
            }

            $profileData = array(
                'userId' =>(int)$query-> row('userId'),
                'firstName' =>$query-> row('firstName'),
                'lastName'=>$query->row('lastName'),
                'userEmail'=>$query->row('userEmail'),
                'userAddress'=>$query->row('userAddress'),
                'userMobile'=>$query-> row('userMobile'),
                'userStatus'=>(int) $query-> row('userStatus'),
                'userGender'=>$query-> row('userGender'),
                'profilePictureUrl' => base_url("image?u=").urlencode($url),
                'active'=>(int)$query-> row('active')

            );
            return $profileData;
        } else {

            $query = $this->db->get('users', $limit, $start);
            return $query->result();
        }
    }

    public function getAllUser($userId){
        $users=[];
        $this->db->select("*");
        $this->db->where("userType=",1);
        $this->db->where("userId <>",$userId);

        $query = $this->db->get('users');
        // base url if this project is in a sub folder of main project
        //$baseurl=preg_replace('~/[^/]*/([^/]*)$~', '/\1', base_url());
        foreach ($query->result() as $user){
            if($user->userProfilePicture!=null){
                $url = base_url()."assets/userImage/".$user->userProfilePicture;
            }
            else{
                $url = base_url()."assets/img/download.png";
            }

            $profileData = array(
                'userId' =>(int)$user->userId,
                'firstName' =>$user->firstName,
                'lastName'=>$user->lastName,
                'userEmail'=>$user->userEmail,
                'userAddress'=>$user->userAddress, // optional
                'userMobile'=>$user-> userMobile, //optional
                'userStatus'=>(int) $user-> userStatus, // profile active or inactive status
                'userGender'=>$user-> userGender, //optional
                'profilePictureUrl' =>$url

            );
            $users[]=$profileData;
        }
        return $users;
    }

    public function filterUser($userIds,$key){
        $users=[];
        $this->db->select("*");
        $this->db->where("userType=",1);
        $this->db->where("userId<>",2);
        if($userIds!=null){
            $this->db->where_in("userId",$userIds);
        }
        $this->db->group_start();
        $this->db->like("firstName",$key);
        $this->db->or_like("lastName",$key);
        $this->db->group_end();
        $this->db->where("userStatus <>",0);
        $this->db->where("userVerification <>",0);

        $query = $this->db->get('users');
        foreach ($query->result() as $user){
            if($user->userProfilePicture!=null){
                $url = base_url()."assets/userImage/".$user->userProfilePicture;
            }
            else{
                $url = base_url()."assets/img/download.png";
            }

            $profileData = array(
                'userId' =>(int)$user->userId,
                'firstName' =>$user->firstName,
                'lastName'=>$user->lastName,
                'userEmail'=>$user->userEmail,
                'userAddress'=>$user->userAddress,
                'userMobile'=>$user-> userMobile,
                'userStatus'=>(int) $user-> userStatus,
                'userGender'=>$user-> userGender,
                'profilePictureUrl' => $url

            );
            $users[]=$profileData;
        }
        return $users;
    }

    public function filterAllUser($userIds,$key){
        $users=[];
        $this->db->select("*");
        $this->db->where("userType=",1);
        $this->db->where("userId<>",2);
        if($userIds!=null){
            $this->db->where_not_in("userId",$userIds);
        }
        $this->db->group_start();
        $this->db->like("firstName",$key);
        $this->db->or_like("lastName",$key);
        $this->db->group_end();
        $this->db->where("userStatus <>",0);
        $this->db->where("userVerification <>",0);

        $query = $this->db->get('users');
        foreach ($query->result() as $user){
            if($user->userProfilePicture!=null){
                $url = base_url()."assets/userImage/".$user->userProfilePicture;
            }
            else{
                $url = base_url()."assets/img/download.png";
            }

            $profileData = array(
                'userId' =>(int)$user->userId,
                'firstName' =>$user->firstName,
                'lastName'=>$user->lastName,
                'userEmail'=>$user->userEmail,
                'userAddress'=>$user->userAddress,
                'userMobile'=>$user-> userMobile,
                'userStatus'=>(int) $user-> userStatus,
                'userGender'=>$user-> userGender,
                'profilePictureUrl' => $url

            );
            $users[]=$profileData;
        }
        return $users;
    }

    public function getAllActiveUser($userId,$limit,$start){
        $users=[];
        $this->db->select("*");
        $this->db->where("userType=",1);
        $this->db->where("userId <>",2);
        $this->db->where("userId <>",$userId);
        $this->db->where("userStatus <>",0);
        $this->db->where("userVerification <>",0);
        $query = $this->db->get('users',$limit,$start);
        foreach ($query->result() as $user){
            if($user->userProfilePicture!=null){
                $url = base_url()."assets/userImage/".$user->userProfilePicture;
            }
            else{
                $url = base_url()."assets/img/download.png";
            }

            $profileData = array(
                'userId' =>(int)$user->userId,
                'firstName' =>$user->firstName,
                'lastName'=>$user->lastName,
                'userEmail'=>$user->userEmail,
                'userAddress'=>$user->userAddress,
                'userMobile'=>$user-> userMobile,
                'userStatus'=>(int) $user-> userStatus,
                'userGender'=>$user-> userGender,
                'profilePictureUrl' => $url

            );
            $users[]=$profileData;
        }
        return $users;
    }

    public function getFirstName($id)
    {
        $array = array('userId' => $id);
        $this->db->where($array);
        $query = $this->db->get('users');

        return $query->row("firstName");
    }


    public function insert_entry($clientSecret, $firstName, $lastName, $userEmail, $userPassword,$userAddress,$userMobile,$userType,$userStatus)
    {
        if($userPassword == null){
            $changedPassword = null;
        }
        else {
            $changedPassword = password_hash($userPassword,PASSWORD_BCRYPT); // default cost for BCRYPT to 12
        }
        $this->userSecret = $clientSecret;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->userEmail = $userEmail;
        $this->userPassword = $changedPassword;
        $this->userAddress = $userAddress;
        $this->userMobile=$userMobile;
        $this->userType = 1;
        $this->userStatus =1;
        $this->userVerification = 1;
        $this->lastModified = date('Y-m-d G:i:s');
        $this->db->insert("users", $this);
    }

    public function update_entry($userId,$firstName,$lastName,$userMobile,$userAddress,$userDateOfBirth,$userGender)
    {
        //$changedPassword= $this->encrypt->encode($userPassword);
        $changes = array(
            'firstName'=> $firstName,
            'lastName' => $lastName,
            'userMobile' => $userMobile,
            'userAddress' => $userAddress,
            'userDateOfBirth' => date('Y-m-d',strtotime($userDateOfBirth)),
            'userGender' => $userGender,
            'lastModified' => date('Y-m-d G:i:s')

        );
        $this->db->where('userId', $userId);
        $this->db->update('users',$changes );


        $query = $this->User_Model->get_user($userId,null,null);
        return $query;
    }

    public function update_password($userId,$newPassword)
    {
        $changedPassword = password_hash($newPassword, PASSWORD_BCRYPT); //default cost for BCRYPT to 12
        $updatingArray=  array('userPassword' => $changedPassword);
        $this->db->where('userId', $userId);
        $this->db->update('users',$updatingArray );

        $query = $this->User_Model->get_user($userId,null,null);
        return $query;

    }

    public function update_type($id,$type)
    {
        $newType = array('userType' => $type);
        $this->db->where('userId', $id);
        $this->db->update('users',$newType );

        return $this;

    }

    public function update_token($id,$token)
    {
        $newToken = array('userSecret' => $token);
        $this->db->where('userId', $id);
        $this->db->update('users',$newToken );

        return $this;

    }

    public function update_picture($id,$picture)
    {
        $this->unlinkFile($id);
        $picName = array('userProfilePicture' => $picture);
        $this->db->where('userId', $id);
        $this->db->update('users',$picName );

        $this->db->where('userId', $id);
        $query = $this->db->get('users');
        $url = base_url()."assets/userImage/".$query->row()->userProfilePicture;

        return $url;

    }
    public function unlinkFile($id){

            $this->db->where('userId', $id);
            $query = $this->db->get('users');
            $image = $query->row()->userProfilePicture;;
            if ($image == null) {
                return;
            }
            $path = "assets/userImage/" . $image;
            if(file_exists($path)){
                unlink($path);
            }

    }

    public function deactivate_entry($id)
    {
        $newStatus = array('userStatus' => 0);
        $this->db->where('userId', $id);
        $this->db->update('users',$newStatus );

        $query = $this->User_Model->get_user($id,null,null);
        return $query;
    }

    public function activate_entry($email)
    {
        $newStatus = array('userStatus' => 1);
        $this->db->where('userEmail', $email);
        $this->db->update('users',$newStatus );

        $this->db->where('userEmail', $email);
        $query = $this->db->get('users');
        return $query->row();
    }

    public function saveResetToken($token,$email)
    {
        $resetToken = array('userResetToken' => $token);
        $this->db->where('userEmail', $email);
        $this->db->update('users',$resetToken );

        $this->db->where('userEmail', $email);
        $query = $this->db->get('users');

        if($query->row('userProfilePicture')!=null){
            $url = base_url()."assets/userImage/".$query->row()->userProfilePicture;
        }
        else{
            $url = base_url()."assets/img/download.png";
        }

        $encryptToken = $this->jwt->encode(array(
            'resetKey' =>  $query->row()->userResetToken,
            'issuedAt' => date(DATE_ISO8601, strtotime("now")),
            'userName' => $query->row()->firstName." ".$query->row()->lastName,
            'profilePicture'=>$url,
            'userEmail' => $query->row()->userEmail,
            'userId' => $query->row()->userId
        ), $this->config->item("CONSUMER_SECRET"));
        return $encryptToken;

    }

    function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }



    function ifExist($email)
    {
        $this->db->where('userEmail', $email);
        $this->db->from('users');
        if ($this->db->count_all_results() == 0) {
            return false;
        } else {
            return true;
        }
    }

    function userExist($id)
    {
        $this->db->where('userId', $id);
        $this->db->from('users');
        if ($this->db->count_all_results() == 0) {
            return false;
        } else {
            return true;
        }
    }

    function checkUser($email, $password)
    {
        $this->db->where('userEmail', $email);
        $query = $this->db->get('users');
        $savedPassword = $query->row()->userPassword;
        //$realPassword = $this->encryption->decrypt($savedPassword);

        if(password_verify($password,$savedPassword)){

            return true;
        }
        return false;
    }

    function checkUserPassword($id, $password)
    {
        $this->db->where('userId', $id);
        $query = $this->db->get('users');
        $savedPassword = $query->row()->userPassword;
        //$realPassword = $this->encrypt->decode($savedPassword);

        if(password_verify($password,$savedPassword)){

            return true;
        }
        return false;
    }

    public function getUserId($email)
    {
        $this->db->where('userEmail', $email);
        $query = $this->db->get('users');

        return $query->row()->userId;
    }

    public function getTokenRAWData($email){
        $userData=$this->get_user($this->getUserId($email),null,null);

        $token = array(
            'firstName'=>$userData['firstName'],
            'userName' => $userData['firstName']." ".$userData['lastName'],
            'profilePicture'=>$userData['profilePictureUrl'],
            'userEmail' => $userData['userEmail'],
            'userId' => $userData['userId'],
        );
        return $token;

    }
    public function getTokenRAWDataById($userId){
        $userData=$this->get_user($userId,null,null);

        $token = array(
            'firstName'=>$userData['firstName'],
            'userName' => $userData['firstName']." ".$userData['lastName'],
            'profilePicture'=>$userData['profilePictureUrl'],
            'userEmail' => $userData['userEmail'],
            'userId' => $userData['userId'],
        );
        return $token;

    }

    public function getToken($email)
    {
        $this->db->where('userEmail', $email);
        $query = $this->db->get('users');
        if($query->row('userProfilePicture')!=null){
            $url = base_url()."assets/userImage/".$query->row()->userProfilePicture;
        }
        else{
            $url = base_url()."assets/img/download.png";
        }
        $token = $this->jwt->encode(array(
            'consumerKey' =>  $query->row()->userSecret,
            'issuedAt' => date(DATE_ISO8601, strtotime("now")),
            'firstName'=>$query->row()->firstName,
            'userName' => $query->row()->firstName." ".$query->row()->lastName,
            'profilePicture'=>$url,
            'userEmail' => $query->row()->userEmail,
            'userId' => $query->row()->userId,
            'userType' => $query->row()->userType
        ), $this->config->item("CONSUMER_SECRET"));

        return $token;
    }


    public function getTokenById($userId)
    {
        $this->db->where('userId', $userId);
        $query = $this->db->get('users');
        if($query->row('userProfilePicture')!=null){
            $url = base_url()."assets/userImage/".$query->row()->userProfilePicture;
        }
        else{
            $url = base_url()."assets/img/download.png";
        }
        $token = $this->jwt->encode(array(
            'consumerKey' =>  $query->row()->userSecret,
            'issuedAt' => date(DATE_ISO8601, strtotime("now")),
            'firstName'=>$query->row()->firstName,
            'userName' => $query->row()->firstName." ".$query->row()->lastName,
            'profilePicture'=>$url,
            'userEmail' => $query->row()->userEmail,
            'userId' => $query->row()->userId,
            'userType' => $query->row()->userType
        ), $this->config->item("CONSUMER_SECRET"));

        return $token;
    }

    public function getTokenAdmin($email)
    {
        $this->db->where('userEmail', $email);
        $query = $this->db->get('users');
        if($query->row('userProfilePicture')!=null){
            $url = base_url()."assets/userImage/".$query->row()->userProfilePicture;
        }
        else{
            $url = base_url()."assets/img/download.png";
        }
        $token = $this->jwt->encode(array(
            'consumerKey' =>  $query->row()->userSecret,
            'issuedAt' => date(DATE_ISO8601, strtotime("now")),
            'firstName'=>$query->row()->firstName,
            'userName' => $query->row()->firstName." ".$query->row()->lastName,
            'profilePicture'=>$url,
            'userEmail' => $query->row()->userEmail,
            'userId' => $query->row()->userId,
            'userType' => $query->row()->userType
        ), $this->config->item("CONSUMER_SECRET"));

        return $token;
    }

    function isValidToken($token)
    {
        try {
            $value = $this->jwt->decode($token, $this->config->item("CONSUMER_SECRET"));
            $this->db->where('userSecret', $value->consumerKey);
            $this->db->from('users');
            if ($this->db->count_all_results() == 0) {
                return false;
            } else {
                return true;
            }
        } catch (Exception $e) {
            // echo 'Message: ' .$e->getMessage();
            return false;
        }

    }

    function checkResetToken($token)
    {
        try {
            $value = $this->jwt->decode($token, $this->config->item("CONSUMER_SECRET"));
            $this->db->where('userResetToken', $value->resetKey);
            $this->db->from('users');
            if ($this->db->count_all_results() == 0) {
                return false;
            } else {
                return true;
            }
        } catch (Exception $e) {
            // echo 'Message: ' .$e->getMessage();
            return false;
        }

    }

    function checkVerification($email)
    {
        $this->db->where('userEmail', $email);
        $query = $this->db->get('users');

        if($query->row()->userVerification == 1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function adminBlock($email){
        $this->db->where('userEmail', $email);
        $query = $this->db->get('users');
        if($query->row()->userVerification == 1 && $query->row()->userStatus==1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    function verifyEmail($key,$id,$userStatus)
    {
        $verification = array('userVerification' => 1, 'userSecret'=> $key, 'userStatus' => $userStatus);
        $this->db->where('userId', $id);
        $this->db->update('users',$verification );
    }

    function getTokenToId($token)
    {
        $value = $this->jwt->decode($token, $this->config->item("CONSUMER_SECRET"));
        $this->db->where('userSecret', $value->consumerKey);
        $query =$this->db->get('users');

        return (int)$query->row('userId');
    }

    function getTokenToType($token)
    {
        $value = $this->jwt->decode($token, $this->config->item("CONSUMER_SECRET"));
        $this->db->where('userSecret', $value->consumerKey);
        $query =$this->db->get('users');

        return $query->row('userType');
    }

    function ifInvited($email)
    {
        $this->db->where('userEmail', $email);
        $query = $this->db->get('users');

        if($query->row()->userStatus == 2)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function getTotalUser(){
        $this->db->select("count(userId) as total");
        $query = $this->db->get('users');
        return $query->row()->total;
    }

    public function arrayToObject($d){
        if(is_array($d)){
            return (object)array_map(__FUNCTION__,$d);
        }
        else{
            return $d;
        }
    }

    public function createTokenfromData(array $data)
    {
        
        return $this->jwt->encode($data, $this->config->item("CONSUMER_SECRET"));

    
    }

    // Ralph 2019-05-10
    public function insertInPublicGroup($email)
    {
        $privateGroupID = 1;
        // check if user is already registered 
        if(!intval($this->ifExist($email))) return;
        // get user id
        $user_id = $this->getUserId($email);
        // check if user is already part of public group
        $query = $this->db->query("SELECT u_id FROM `im_group_members` WHERE g_id = $privateGroupID AND u_id = $user_id");
        if(!$query->num_rows()){
            // insert in public group
            $this->db->query("INSERT IGNORE INTO `im_group_members`(`g_id`, `u_id`) VALUES ($privateGroupID,$user_id);");
        }
    }

    // Ralph 2019-05-15
    public function searchlistAll($userId,$limit,$start)
    {
        $records=[];
        $picture = '';
        $query = $this->db->query("SELECT A.id, A.name, A.picture, A.othername as email, 
            A.type as type_id, B.description as type_description FROM
            (select g.g_id as id,
            if(!isnull(g.name),g.name,GROUP_CONCAT(u.firstName)) as name, 
            g.custom_image as picture, g.type, NULL as othername
            from im_group as g
            left join im_group_members as gm on g.g_id = gm.g_id
            left join users as u on gm.u_id = u.userid
            where g.type<>1
            group by g.g_id
            having GROUP_CONCAT(u.userid) like '%$userId%'
            UNION ALL
            select u.userid as id, concat(u.firstName,' ',u.lastName) as name,
            u.userProfilePicture as picture, 1 as type, u.userEmail as othername  
            from users as u 
            inner join friend_list as fl on u.userid = fl.friendId
            where fl.userid = $userId and
            u.userType=1 and u.userid not in (2)
            and u.userVerification=1) as A
            inner join group_type as B on A.type = B.id
            ORDER BY FIELD(A.type,2,0,1)
            LIMIT $start, $limit;");

        //return $this->db->last_query();

        foreach ($query->result() as $user){

            switch ($user->type_id) {
                case 2: // Group
                case 0:
                    if($user->picture!=null){
                        $picture = base_url()."assets/im/group_".$user->id."/".$user->picture;
                    }
                    else{
                        $picture = base_url()."assets/img/group.png";
                    }
                break;
                
                case 1: // Personal
                    if($user->picture!=null){
                        $picture = base_url()."assets/userImage/".$user->picture;
                    }
                    else{
                        $picture = base_url()."assets/img/download.png";
                    }
                break;
            }

            $data = array(
                'id' =>(int)$user->id,
                'name' =>$user->name,
                'type_id'=>(int)$user->type_id,
                'type_description'=>$user->type_description,
                'email'=>$user->email,
                'picture' => $picture
            );
            $records[]=$data;
        }
        return $records;
    }

    public function hasConversation($friendId,$userId)
    {
            
            $query = $this->db->query("SELECT g.g_id
                from im_group as g
                inner join im_group_members as gm on g.g_id = gm.g_id
                where g.type=1
                group by g.g_id
                having group_concat(gm.u_id) like '%$friendId%' 
                and group_concat(gm.u_id) like '%$userId%';");
 
            return intval($query->row("g_id"));
    
    }

    //region For API
    public function fetchByEmail($email = '')
    {
        return $this->db->where('userEmail', $email)->get('users')->result_array();
    }

    public function fetchBySecret($secret = '')
    {
        return $this->db->where('userSecret', $secret)->get('users')->result_array();
    }
    //endregion For API

}