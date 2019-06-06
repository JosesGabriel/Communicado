<?php
class Im_receiver_Model extends CI_Model{


    public function update($r_id,$g_id,$m_id,$time){
        $update=array(
            "received"=>1,
            "time"=>$time
        );
        $this->db->where("g_id",$g_id);
        $this->db->where("r_id",$r_id);
        $this->db->where("m_id",$m_id);
        $this->db->update("im_receiver",$update);

    }
    public function updateAnnounced($r_id,$g_id,$m_id){
        $update=array(
            "announced"=>1,

        );
        $this->db->where("g_id",$g_id);
        $this->db->where("r_id",$r_id);
        $this->db->where("m_id",$m_id);
        $this->db->update("im_receiver",$update);

    }
    public function addPendingForNewMember($r_id,$g_id,$m_id){

        $this->g_id=$g_id;
        $this->r_id=$r_id;
        $this->m_id=$m_id;
        $this->received=0;

        $this->db->insert("im_receiver",$this);

    }
    public function getTotalReceiver($m_id){
        $query=$this->db->select("count(m_id) as total")
            ->where("m_id",$m_id)
            ->where("received",1)
            ->get("im_receiver");
        
        return $query->row()->total;
        
    }
    public function isExsist($m_id,$r_id,$g_id){
        $this->db->where("m_id",$m_id);
        $this->db->where("r_id",$r_id);
        $this->db->where("g_id",$g_id);
        $this->db->from('im_receiver');
        if ($this->db->count_all_results() == 0) {
            return false;
        } else {
            return true;
        }
    }
    public function isNotReceived($r_id,$g_id,$m_id){
        $this->db->where("g_id",$g_id);
        $this->db->where("r_id",$r_id);
        $this->db->where("m_id",$m_id);
        $this->db->where("received",0);
        $this->db->from('im_receiver');
        if ($this->db->count_all_results() == 0) {
            return false;
        } else {
            return true;
        }
    }

    public function isReceived($r_id,$g_id,$m_id){
        $this->db->where("g_id",$g_id);
        $this->db->where("r_id",$r_id);
        $this->db->where("m_id",$m_id);
        $this->db->where("received",1);
        $this->db->from('im_receiver');
        if ($this->db->count_all_results() == 0) {
            return false;
        } else {
            return true;
        }
    }
    public function isAnnounced($r_id,$g_id,$m_id){
        $this->db->where("g_id",$g_id);
        $this->db->where("r_id",$r_id);
        $this->db->where("m_id",$m_id);
        $this->db->where("announced",1);
        $this->db->from('im_receiver');
        if ($this->db->count_all_results() == 0) {
            return false;
        } else {
            return true;
        }
    }
    public function getReceivedMessageTime($r_id,$g_id,$m_id){
        $this->db->where("g_id",$g_id);
        $this->db->where("r_id",$r_id);
        $this->db->where("m_id",$m_id);
        $this->db->where("received",1);
        return  $this->arrayToObject($this->db->get('im_receiver')->row("time"));
    }
    public function DeleteAll($g_id,$r_id){
        $this->db->where("g_id",$g_id);
        $this->db->where("r_id",$r_id);
        return $this->db->delete("im_receiver");
    }


    public function DeletePendingMessage($g_id,$r_id,$m_id){
        $this->db->where("g_id",$g_id);
        $this->db->where("r_id",$r_id);
        $this->db->where("m_id",$m_id);
        return $this->db->delete("im_receiver");
    }

    public function deleteByMessageId($m_id){

        $this->db->where("m_id",$m_id);
        return $this->db->delete("im_receiver");
    }
    public function deleteByGroupId($g_id){

        $this->db->where("g_id",$g_id);
        return $this->db->delete("im_receiver");
    }

    public function getGroupPendingMessage($g_id,$u_id){
        $this->db->select("(CASE WHEN COUNT(m_id) >= 100 THEN 99 ELSE COUNT(m_id) END) as pending, g_id as groupId")
            ->where("r_id",$u_id)
            ->where("g_id",$g_id)
            ->where("received",0)
            ->group_by("g_id");
        return (int)$this->db->get("im_receiver")->row("pending");
    }

    public function getTotalPendingMessage($u_id){
        //return $u_id;
        $this->db->select("(CASE WHEN COUNT(m_id) >= 100 THEN 99 ELSE COUNT(m_id) END) as pending")
            ->where("r_id",$u_id)
            ->where("received",0)
            ->group_by("g_id");
    
        return (int)$this->db->get("im_receiver")->result();
        //return $this->db->last_query();
    }

    // Ralph 2019-05-27
    public function getTotalPendingMessages($u_id){
        //return $u_id;
        $this->db->select("(CASE WHEN COUNT(m_id) >= 100 THEN 99 ELSE COUNT(m_id) END) as pending")
            ->where("r_id",$u_id)
            ->where("received",0);
           // ->group_by("g_id");
        
        return (int)$this->db->get("im_receiver")->result();
        //return $this->db->last_query();
    }

    // ralph 2019-05-29
    public function notificationTotaluser($u_id)
    {
        $SQL = "SELECT im.g_id as group_id, concat(u.firstName,' ',u.lastName) as sender_name,
        nt.description as message, if(g.type=1,'Personal Chat',if(!isnull(g.name),g.name,'Unnamed Community')) as group_name,
        date_format(im.date_time,'%Y-%m-%dT%H:%i:%s.000Z') as date_time,
        nt.id as notif_type, 0 as notif_id, nt.icon, nt.badge
        from im_mention as im 
        left join im_group as g on im.g_id = g.g_id
        left join users as u on im.u_id = u.userId
        left join im_notification_types as nt on nt.id = 4
        left join im_blocklist as bl on bl.g_id = im.g_id
        left join im_mutelist as ml on ml.g_id = im.g_id
        where im.r_id=$u_id and im.seen=0 and isnull(ml.g_id) and isnull(bl.g_id)
        UNION ALL
        select ir.g_id as group_id, concat(u.firstName,' ',u.lastName) as sender_name,
        nt.description as message, if(g.type=1,'Personal Chat',if(!isnull(g.name),g.name,'Unnamed Community')) as group_name, 
        date_format(concat(m.date,' ',m.time),'%Y-%m-%dT%H:%i:%s.000Z') as date_time,
        nt.id as notif_type, 0 as notif_id, nt.icon, nt.badge
        from im_receiver as ir
        left join im_group as g on ir.g_id = g.g_id
        left join im_message as m using(m_id)
        left join users as u on m.sender = u.userId
        left join im_blocklist as bl on bl.g_id = ir.g_id
        left join im_mutelist as ml on ml.g_id = ir.g_id
        left join im_notification_types as nt on nt.id = if(g.type=1,5,3)
        where ir.r_id=$u_id and ir.received=0 
        and isnull(ml.g_id) and isnull(bl.g_id)
        UNION ALL
        select n.g_id as group_id,concat(u2.firstName,' ',u2.lastName) as sender_name, 
        nt.description as message, if(!isnull(g.name),g.name,'Unnamed Community') as group_name,
        date_format(n.date_time,'%Y-%m-%dT%H:%i:%s.000Z') as date_time, 
        nt.id as notif_type, n.n_id as notif_id, nt.icon, nt.badge
        from im_notifications as n
        inner join im_group as g on n.g_id = g.g_id
        inner join im_notification_types as nt on n.t_id = nt.id
        inner join users as u2 on u2.userid = n.u_id
        where n.r_id=$u_id and n.seen=0";
            $query = $this->db->query($SQL);
            return $query->num_rows();
    }

    public function notificationList($u_id,$limit,$offset)
    {
        
        $return = [];
        $SQL = "SELECT im.g_id as group_id, concat(u.firstName,' ',u.lastName) as sender_name,
        nt.description as message, if(g.type=1,'Personal Chat',if(!isnull(g.name),g.name,'Unnamed Community')) as group_name,
        date_format(im.date_time,'%Y-%m-%dT%H:%i:%s.000Z') as date_time,
        nt.id as notif_type, 0 as notif_id, nt.icon, nt.badge
        from im_mention as im 
        left join im_group as g on im.g_id = g.g_id
        left join users as u on im.u_id = u.userId
        left join im_notification_types as nt on nt.id = 4
        left join im_blocklist as bl on bl.g_id = im.g_id
        left join im_mutelist as ml on ml.g_id = im.g_id
        where im.r_id=$u_id and im.seen=0 and isnull(ml.g_id) and isnull(bl.g_id)
        UNION ALL
        select ir.g_id as group_id, concat(u.firstName,' ',u.lastName) as sender_name,
        nt.description as message, if(g.type=1,'Personal Chat',if(!isnull(g.name),g.name,'Unnamed Community')) as group_name, 
        date_format(concat(m.date,' ',m.time),'%Y-%m-%dT%H:%i:%s.000Z') as date_time,
        nt.id as notif_type, 0 as notif_id, nt.icon, nt.badge
        from im_receiver as ir
        left join im_group as g on ir.g_id = g.g_id
        left join im_message as m using(m_id)
        left join users as u on m.sender = u.userId
        left join im_blocklist as bl on bl.g_id = ir.g_id
        left join im_mutelist as ml on ml.g_id = ir.g_id
        left join im_notification_types as nt on nt.id = if(g.type=1,5,3)
        where ir.r_id=$u_id and ir.received=0 
        and isnull(ml.g_id) and isnull(bl.g_id)
        UNION ALL
        select n.g_id as group_id,concat(u2.firstName,' ',u2.lastName) as sender_name, 
        nt.description as message, if(!isnull(g.name),g.name,'Unnamed Community') as group_name,
        date_format(n.date_time,'%Y-%m-%dT%H:%i:%s.000Z') as date_time, 
        nt.id as notif_type, n.n_id as notif_id, nt.icon, nt.badge
        from im_notifications as n
        inner join im_group as g on n.g_id = g.g_id
        inner join im_notification_types as nt on n.t_id = nt.id
        inner join users as u2 on u2.userid = n.u_id
        where n.r_id=$u_id and n.seen=0
        ORDER BY date_time DESC LIMIT $limit OFFSET $offset";

        $query = $this->db->query("$SQL");
        
        $return['data'] = $query->result();
        $return['count'] = $query->num_rows();
        //return $this->db->last_query();
        return $return;

    }

    public function checkMentionedMessages($r_id,$g_id)
    {
        $SQL = "SELECT r_id from im_mention where r_id=$r_id and g_id=$g_id and seen=0;";
        $query = $this->db->query($SQL);
        return $query->num_rows();
    }

    public function updateMentionAsRead($r_id,$g_id)
    {
        $SQL = "UPDATE im_mention SET seen=1, seen_tstamp=now() where r_id=$r_id and g_id=$g_id";
        $query = $this->db->query($SQL);
    }


    public function arrayToObject($d){
        if(is_array($d)){
            return (object)array_map(__FUNCTION__,$d);
        }
        else{
            return $d;
        }
    }
}