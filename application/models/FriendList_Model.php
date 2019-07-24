<?php

class FriendList_Model extends CI_Model
{
    public $userId;
    public $friendId;

    public function __construct()
    {
        parent::__construct();
    }

    public function insert($userid, $friendId)
    {
        $this->userId = $userid;
        $this->friendId = $friendId;
        $this->db->insert('friend_list', $this);
    }

    public function delete($userId, $friendId)
    {
        $this->db->where('userId', $userId);
        $this->db->where('friendId', $friendId);
        $this->db->delete('friend_list');
    }

    public function getList($userId, $limit, $start)
    {
        $this->db->select('friendId');
        $this->db->where('userId', $userId);
        if ($start != null && $limit != null) {
            $query = $this->db->get('friend_list', $limit, $start);
        } else {
            $query = $this->db->get('friend_list');
        }

        return $query->result();
    }

    public function getFriendsIdAsArray($userId)
    {
        $this->db->select('friendId');
        $this->db->where('userId', $userId);
        $query = $this->db->get('friend_list');
        $array = array();
        foreach ($query->result() as $id) {
            array_push($array, $id->friendId);
        }

        return $array;
    }

    public function friendExist($userId, $friendId)
    {
        $this->db->where('userId', $userId);
        $this->db->where('friendId', $friendId);
        $this->db->from('friend_list');
        if ($this->db->count_all_results() == 0) {
            return false;
        } else {
            return true;
        }
    }

    public function getTotalFriend($userId)
    {
        $this->db->select('count(friendId) as total');
        $query = $this->db->get('friend_list');

        return $query->row()->total;
    }

    public function arrayToObject($d)
    {
        if (is_array($d)) {
            return (object) array_map(__FUNCTION__, $d);
        } else {
            return $d;
        }
    }

    public function getFriendsIdAsArray_v2($userId, $groupId)
    {
        $query = $this->db->query('SELECT f.uid as friendId
                FROM (select friendId as uid from friend_list where userId='.intval($userId).') as f
                LEFT JOIN (select u_id as uid from im_group_members where g_id='.intval($groupId).') as m
                ON f.uid = m.uid WHERE isnull(m.uid)');
        $array = array();
        foreach ($query->result() as $id) {
            array_push($array, $id->friendId);
        }

        return $array;
    }
}
