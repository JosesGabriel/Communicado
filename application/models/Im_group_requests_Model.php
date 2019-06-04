<?php

class Im_group_requests_Model extends CI_Model{

    public $g_id;
    public $u_id;

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->model("Im_group_Model");
        $this->load->model("Im_group_members_Model");
    }

    public function insert($g_id,$u_id)
    {
        // check if user alreay sent a request
        if($this->ifExist($g_id,$u_id)){
            return;
        }
        $this->g_id=$g_id;
        $this->u_id=$u_id;
        $this->requested_date = date('Y-m-d G:i:s');
        $this->accepted_date = null;
        $this->db->insert("im_group_requests",$this);
        $this->Im_group_Model->updateLastActiveDate($g_id,null);
    }

    public function delete($g_id,$u_id)
    {
        $this->Im_group_Model->updateLastActiveDate($g_id,null);
        $this->db->where("g_id",$g_id);
        $this->db->where("u_id",$u_id);
        return $this->db->delete("im_group_requests");
    }

    public function ifExist($g_id,$u_id){
        $this->db->where('g_id', $g_id);
        $this->db->where('u_id', $u_id);

        $this->db->from('im_group_requests');
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

    public function getTotalPendingRequests($g_id)
    {

    }

    public function grantRequest($g_id,$u_id,$admin_id){

    }

}