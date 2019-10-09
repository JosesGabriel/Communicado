<?php

class Im_group_requests_Model extends CI_Model
{
    public $g_id;
    public $u_id;

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->model('Im_group_Model');
        $this->load->model('Im_group_members_Model');
    }

    public function insert($g_id, $u_id)
    {
        // check if user alreay sent a request
        if ($this->ifExist($g_id, $u_id)) {
            return;
        }
        $this->g_id = $g_id;
        $this->u_id = $u_id;
        $this->requested_date = date('Y-m-d G:i:s');
        $this->accepted_date = null;
        $this->db->insert('im_group_requests', $this);
        $this->Im_group_Model->updateLastActiveDate($g_id, null);
    }

    public function delete($g_id, $u_id)
    {
        $this->Im_group_Model->updateLastActiveDate($g_id, null);
        $this->db->where('g_id', $g_id);
        $this->db->where('u_id', $u_id);

        return $this->db->delete('im_group_requests');
    }

    public function ifExist($g_id, $u_id)
    {
        $this->db->where('g_id', $g_id);
        $this->db->where('u_id', $u_id);

        $this->db->from('im_group_requests');
        if ($this->db->count_all_results() == 0) {
            return false;
        } else {
            return true;
        }
    }

    public function arrayToObject($d)
    {
        if (is_array($d)) {
            return (object) array_map(__FUNCTION__, $d);
        } else {
            return $d;
        }
    }

    public function joinrequestList($g_id)
    {
        $sql = "SELECT u.userid as id, concat(u.firstName,' ',u.lastName) as name,
            u.userProfilePicture as picture, u.userEmail as email, u.userSecret, g.g_id as group_id,
            u.user_login 
            from im_group_requests as r
            inner join im_group as g on r.g_id = g.g_id
            inner join users as u on r.u_id = u.userId
            where r.g_id=$g_id and isnull(r.accepted_date)";
        $query = $this->db->query($sql);

        //return $this->db->last_query();

        $records = [];
        foreach ($query->result() as $user) {
            if ($user->picture != null) {
               // $picture = base_url().'assets/userImage/'.$user->picture;
                $picture = $user->picture;
            } else {
                $picture = base_url().'assets/img/download.png';
            }

            $data = array(
                'id' => (int) $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'picture' => $picture,
                'group_id' => (int) $user->group_id,
                'username' => $user->userSecret,
                'userlogin' => $user->user_login,
            );
            $records[] = $data;
        }

        return $records;
    }

    public function grantRequest($g_id, $u_id, $admin_id)
    {
    }
}
