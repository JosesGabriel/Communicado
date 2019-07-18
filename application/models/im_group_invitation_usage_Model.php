<?php

class Im_group_invitation_usage_Model extends CI_Model
{

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }

    public function add($linkData)
    {
        $data = array( 
            'token_id'	=> $linkData['token_id'], 
            'user_id' => $linkData['user_id'], 
            'timestamp'	=> $linkData['timestamp']
        );
        $res = $this->db->insert('im_group_invitation_usage', $data);
        return($res);
    }
    public function useCounter($token) 
    {
        $this->db->where('token_id', $token);
        $num_rows = $this->db->count_all_results('im_group_invitation_usage');
        return($num_rows); // p
    }
}
