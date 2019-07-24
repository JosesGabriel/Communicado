<?php

class Im_group_members_Model extends CI_Model
{
    public $g_id;
    public $u_id;

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->model('Im_group_Model');
    }

    public function insert($g_id, $u_id)
    {
        if ($this->ifExist($g_id, $u_id)) {
            return '1'; //changed this line from return; to return NULL. Needed return val if user exist / joses
        }
        $this->g_id = $g_id;
        $this->u_id = $u_id;
        $this->db->insert('im_group_members', $this);
        $this->Im_group_Model->updateLastActiveDate($g_id, null);
    }

    public function delete($g_id, $u_id)
    {
        $this->Im_group_Model->updateLastActiveDate($g_id, null);
        $this->db->where('g_id', $g_id);
        $this->db->where('u_id', $u_id);

        return $this->db->delete('im_group_members');
    }

    public function getMembers($g_id)
    {
        $this->db->select('u_id');
        $this->db->where('g_id', $g_id);
        $query = $this->db->get('im_group_members');

        return $query->result();
    }

    public function getMembersWihoutSender($g_id, $u_id)
    {
        $this->db->select('u_id');
        $this->db->where('g_id', $g_id);
        $this->db->where('u_id <>', $u_id);
        $query = $this->db->get('im_group_members');

        return $query->result();
    }

    public function getTotalGroups($u_ids)
    {
        //$this->db->distinct();
        $this->db->select('count(DISTINCT ig.g_id) as total,ig.lastActive');
        $this->db->from('im_group ig');
        $this->db->join('im_group_members igm', 'ig.g_id=igm.g_id', 'INNER');
        $this->db->where_in('igm.u_id', $u_ids);
        $this->db->order_by('ig.lastActive DESC');
        $query = $this->db->get('im_group');

        return (int) $query->row('total');
    }

    public function getTotalPendingGroups($u_ids)
    {
        //$this->db->distinct();
        $this->db->select('count(DISTINCT ig.g_id) as total,ig.lastActive');
        $this->db->from('im_group ig');
        $this->db->join('im_group_members igm', 'ig.g_id=igm.g_id', 'INNER');
        $this->db->where_in('igm.u_id', $u_ids);
        $this->db->order_by('ig.lastActive DESC');
        $query = $this->db->get('im_group');

        return (int) $query->row('total');
    }

    // $u_ids is array
    public function getGroups($u_ids, $limit, $start)
    {
        $this->db->distinct();
        $this->db->select('igm.g_id,ig.type,ig.lastActive');
        $this->db->from('im_group_members igm');
        $this->db->join('im_group ig', 'ig.g_id=igm.g_id', 'INNER');
        $this->db->where_in('igm.u_id', $u_ids);
        $this->db->order_by('ig.lastActive DESC');
//        $this->db->order_by("field(ig.type, 2,0,1) ASC, ig.lastActive DESC");
        $query = $this->db->get('im_group_members', $limit, $start);
        //return $this->db->last_query();
        return $query->result();
    }

    public function getPendingMessageGroups($u_ids)
    {
        $this->db->distinct()
            ->select('igm.g_id,ig.type,ig.lastActive')
            ->from('im_group_members igm')
            ->join('im_group ig', 'ig.g_id=igm.g_id', 'INNER')
            ->join('im_receiver ir', 'ir.r_id=igm.u_id and ig.g_id=ir.g_id and and ir.received=0', 'INNER')
            ->where_in('igm.u_id', $u_ids)
            ->order_by('ig.lastActive');
        $query = $query = $this->db->get('im_group_members');

        return $query->result();
    }

    public function getPersonalGroups($u_ids, $limit, $start)
    {
        $this->db->distinct();
        $this->db->select('igm.g_id,ig.type,ig.lastActive');
        $this->db->from('im_group_members igm');
        $this->db->join('im_group ig', 'ig.g_id=igm.g_id', 'INNER');
        $this->db->where('ig.type', 1);
        $this->db->where_in('igm.u_id', $u_ids);
        $this->db->order_by('ig.lastActive DESC');
        $query = $this->db->get('im_group_members', $limit, $start);

        return $query->result();
    }

    public function getNonPersonalGroups($u_ids, $limit, $start)
    {
        $this->db->distinct();
        $this->db->select('igm.g_id,ig.type,ig.lastActive');
        $this->db->from('im_group_members igm');
        $this->db->join('im_group ig', 'ig.g_id=igm.g_id', 'INNER');
        $this->db->where('ig.type', 0);
        $this->db->where_in('igm.u_id', $u_ids);
        $this->db->order_by('ig.lastActive DESC');
        $query = $this->db->get('im_group_members', $limit, $start);

        return $query->result();
    }

    public function getTotalGroupMember($g_id)
    {
        $this->db->select('count(u_id) as total');
        $this->db->where('g_id', $g_id);
        $query = $this->db->get('im_group_members');

        return $query->row()->total;
    }

    public function ifExist($g_id, $u_id)
    {
        $this->db->where('g_id', $g_id);
        $this->db->where('u_id', $u_id);

        $this->db->from('im_group_members');
        if ($this->db->count_all_results() == 0) {
            return false;
        } else {
            return true;
        }
    }

    public function DeleteAll($g_id)
    {
        $this->db->where('g_id', $g_id);

        return $this->db->delete('im_group_members');
    }

    public function arrayToObject($d)
    {
        if (is_array($d)) {
            return (object) array_map(__FUNCTION__, $d);
        } else {
            return $d;
        }
    }

    // Ralph 2019-05-21
    public function getMentionlist($u_id, $g_id)
    {
        $records = [];
        $picture = '';
        $query = $this->db->query("SELECT u.userid as id, concat(u.firstName,' ',u.lastName) as name,
        u.userEmail as email, u.userProfilePicture as picture, u.userSecret  
        FROM im_group_members as gm 
        inner join users as u on gm.u_id = u.userid
        where gm.g_id=$g_id and gm.u_id not in ($u_id,2)");

        //return $this->db->last_query();

        foreach ($query->result() as $user) {
            if ($user->picture != null) {
                $picture = base_url().'assets/userImage/'.$user->picture;
            } else {
                $picture = base_url().'assets/img/download.png';
            }

            $data = array(
                'id' => (int) $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'picture' => $picture,
                'usersecret' => $user->userSecret,
            );
            $records[] = $data;
        }

        return $records;
    }
}
