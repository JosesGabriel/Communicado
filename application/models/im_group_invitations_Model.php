<?php

class Im_group_invitations_Model extends CI_Model
{
    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }

    public function add($linkData)
    {
        $data = array(
            'token' => $linkData['token'],
            'group_id' => $linkData['group_id'],
            'user_id' => $linkData['sender_id'],
            'timestamp' => $linkData['timestamp'],
            'expires_in' => $linkData['expires_in'],
        );
        $res = $this->db->insert('im_group_invitations', $data);

        return $res;
    }

    public function checkValidity($token)
    {
        $query = $this->db->query("SELECT * FROM `im_group_invitations` WHERE `token` LIKE '".$token."' AND `expired` LIKE '0'");
        $res = $query->result();
        if ($res) {
            $res = $res[0];
            $data = array(
                'g_id' => $res->group_id,
                'u_id' => $res->user_id,
                'id' => $res->id,
            );

            return $data;
        } else {
            return false;
        }
    }

    public function checkExpiration($token)
    {
        $query = $this->db->query("SELECT * FROM `im_group_invitations` WHERE `token` LIKE '".$token."'");
        $res = $query->result();
        $res = $res[0];
        $expiry = $res->expires_in;

        if ($expiry > $_SERVER['REQUEST_TIME']) {
            return true;
        } else {
            return false;
        }
    }

    public function setExpiredFlag($token_id)
    {
        $query = $this->db->query("UPDATE `im_group_invitations` SET `expired` = '1' WHERE `im_group_invitations`.`id` = ".$token_id.';');

        return;
    }
}
