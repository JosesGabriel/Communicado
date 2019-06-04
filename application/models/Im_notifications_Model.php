<?php

class Im_notifications_Model extends CI_Model{

    public $g_id;
    public $u_id;
    public $r_id;
    public $t_id;

    public function __construct()
    {
        parent::__construct();
    }

    public function insert($u_id,$r_id,$g_id,$t_id)
    {
        $this->u_id=$u_id;
        $this->r_id=$r_id;
        $this->g_id=$g_id;
        $this->t_id=$t_id;
        $this->date_time= date('Y-m-d G:i:s');
        $this->db->insert("im_notifications",$this);
        return $this->db->insert_id();
    }

    public function arrayToObject($d){
        if(is_array($d)){
            return (object)array_map(__FUNCTION__,$d);
        }
        else{
            return $d;
        }
    }

    public function getTotalPendingRequests($g_id)
    {

    }

}