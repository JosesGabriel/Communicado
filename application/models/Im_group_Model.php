<?php

class Im_group_Model extends CI_Model{

    public $name;
    public $lastActive; // track this last active for block,mute,add/remove member,send message, change name
    public $createdBy;
    public $type;
    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }

    private function getISODateTimeWithMilliSeconds(){
        $time = microtime(true);
// Determining the microsecond fraction
        $microSeconds = sprintf("%06d", ($time - floor($time)) * 1000000);
// Creating our DT object
        $tz = new DateTimeZone("Etc/UTC"); // NOT using a TZ yields the same result, and is actually quite a bit faster. This serves just as an example.
        $dt = new DateTime(date('Y-m-d H:i:s.'. $microSeconds, $time), $tz);
// Compiling the date. Limiting to milliseconds, without rounding
        $iso8601Date = sprintf(
            "%s%03d%s",
            $dt->format("Y-m-d\TH:i:s."),
            floor($dt->format("u")/1000),
            $dt->format("O")
        );
// Formatting according to ISO 8601-extended
        return $iso8601Date;
    }


    public function insert($name,$lastActive,$type,$createdBy)
    {
        $this->name=$name;
        $this->lastActive=$lastActive;
        $this->type=$type;
        $this->createdBy=$createdBy;
        $this->db->insert("im_group",$this);
        return $this->db->insert_id();
    }


    public function update($g_id,$name)
    {
        $update=array(
            "name"=>$name,
            "lastActive"=>$this->getISODateTimeWithMilliSeconds()
        );
        $this->db->where("g_id",$g_id);
        return $this->db->update("im_group",$update);
    }

    public function updateLastActiveDate($g_id,$lastActive){
        if($lastActive==null){
            $update=array(
                "lastActive"=>$this->getISODateTimeWithMilliSeconds()
            );
        }else{
            $update=array(
                "lastActive"=>$lastActive
            );
        }

        $this->db->where("g_id",$g_id);
        return $this->db->update("im_group",$update);
    }

    public function updateBlock($g_id,$block){
        $update=array(
            "block"=>$block,
        );
        $this->db->where("g_id",$g_id);
        return $this->db->update("im_group",$update);
    }

    public function delete($g_id)
    {
        $this->db->where("g_id",$g_id);
        return $this->db->delete("im_group");
    }


    public function get($g_id)
    {
        $this->db->where("g_id",$g_id);
        $this->db->order_by("lastActive DESC");
        $query = $this->db->get("im_group");

        return $query->row();
    }
    public function getName($g_id)
    {
        $this->db->select("name");
        $this->db->where("g_id",$g_id);
        $this->db->order_by("lastActive DESC");
        $query = $this->db->get("im_group");

        return $query->row()->name;
    }
    public function getType($g_id)
    {
        $this->db->select("type");
        $this->db->where("g_id",$g_id);
        //$this->db->order_by("lastActive DESC");
        $query = $this->db->get("im_group");

        return (int)$query->row()->type;
    }
    public function DeleteAll($g_id){

        $this->db->where("g_id",$g_id);
        return $this->db->delete("im_group");
    }
    public function ifThisUserCreator($g_id,$u_id)
    {
        $this->db->where("g_id",$g_id);
        $this->db->where("createdBy",$u_id);
        $this->db->from('im_group');
        if ($this->db->count_all_results() == 0) {
            return false;
        } else {
            return true;
        }
    }
    public function arrayToObject($d){
        if(is_array($d)){
            return (object)array_map(__FUNCTION__,$d);
        }
        else{
            return $d;
        }
    }

    public function isBlocked($g_id){
        $this->db->where('g_id', $g_id);
        $this->db->where('block', 1);

        $this->db->from('im_group');
        if ($this->db->count_all_results() == 0) {
            return false;
        } else {
            return true;
        }
    }

    public function isPersonal($g_id){
        $this->db->where('g_id', $g_id);
        $this->db->where('type', 1);

        $this->db->from('im_group');
        if ($this->db->count_all_results() == 0) {
            return false;
        } else {
            return true;
        }
    }

    public function updateImage($g_id,$image){
        $update=array(
            "custom_image"=>$image,
        );
        $this->db->where("g_id",$g_id);
        return $this->db->update("im_group",$update);
    }
    public function getGroupAdminIdbyGroupId($g_id)
    {
        
        $query = $this->db->query("SELECT `createdBy` from im_group where `g_id` = $g_id limit 1");

        return $query->row();
    }
    public function getGroupAdminInfobyGroupId($g_id)
    {
        
        $query = $this->db->query("SELECT u.userId,u.userEmail,u.userSecret from im_group as ig
                        left join users as u on ig.createdBy=u.userId
                        where ig.g_id=$g_id limit 1");

        return $query->row();
    }

    public function getCommunitylist($u_id){

        $records=[];
        $query = $this->db->query("SELECT g.g_id as id, if(!isnull(g.name),g.name,'Unnamed Community') as name, 
            g.custom_image as picture, 
            if(g.createdBy=$u_id,3,if(isnull(r.g_id),0,if(isnull(gm.g_id),1,2))) as status_id
            FROM im_group AS g 
            LEFT JOIN im_group_requests as r ON g.g_id = r.g_id and r.u_id=$u_id
            LEFT JOIN im_group_members as gm ON r.g_id = gm.g_id and gm.u_id=$u_id
            WHERE g.type=0
            GROUP BY g.g_id");

        //return $this->db->last_query();
        foreach ($query->result() as $community){

            if($community->picture!=null){
                $picture = base_url()."assets/im/group_".$community->id."/".$community->picture;
            }
            else{
                $picture = base_url()."assets/img/group.png";
            }

            // 0 = Join / 1 = Requested / 2 = Joined 
            $data = array(
                'id' =>(int)$community->id,
                'name' =>$community->name,
                'picture' => $picture,
                'status_id' => (int)$community->status_id
            );
            $records[]=$data;
        }
        
        return $records;

    }

}