<?php

class Im_group_moderators_Model extends CI_Model
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
        $this->db->insert('im_group_moderators', $this);
        $this->Im_group_Model->updateLastActiveDate($g_id, null);
    }

    public function delete($g_id, $u_id)
    {
        $this->Im_group_Model->updateLastActiveDate($g_id, null);
        $this->db->where('g_id', $g_id);
        $this->db->where('u_id', $u_id);

        return $this->db->delete('im_group_moderators');
    }

    public function ifExist($g_id, $u_id)
    {
        $this->db->where('g_id', $g_id);
        $this->db->where('u_id', $u_id);

        $this->db->from('im_group_moderators');
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

    public function communitymoderatorList($userId, $g_id)
    {
        $sql = "Select u.userid as id, concat(u.firstName,' ',u.lastName) as name,
        u.userProfilePicture as picture, u.userEmail as email, u.userSecret, g.g_id as group_id,
        if(g.createdBy=gm.u_id,1,if(!isnull(gmo.u_id),2,0)) as userlevel
        from im_group as g
        inner join im_group_members as gm on g.g_id=gm.g_id
        inner join users as u on gm.u_id = u.userId
        left join im_group_moderators as gmo on g.g_id=gmo.g_id and gm.u_id = gmo.u_id
        where g.g_id=".$g_id." and g.createdBy=".$userId." order by field (userlevel, 1,2,0), name asc";
        $query = $this->db->query($sql);
        //die($sql);
        // return $this->db->last_query();

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
                'userlevel' => (int) $user->userlevel,
            );
            $records[] = $data;
        }

        return $records;
    }
}
