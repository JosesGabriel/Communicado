//const mysql2 = require("mysql2/promise");
const database = require("./databaseConfig");
//const moment = require('moment');
const mysqlCon = database.mysqlCon2;
const group=require("./group");
let baseUrl=group.getHost();
let app={};
let Im_user_Model={};
let Im_blocklist={};
let Im_group_members_Model={};
let Im_group_Model={};
let Im_message_Model={};
let Im_receiver_Model={};
let Im_notifications_Model={};
let Im_group_requests_Model={};
let Im_group_moderators_Model={};


//--------- Im_block_list_model-------//

Im_blocklist.ifExistInList=async (userId,memberIds)=>{
    let ids=memberIds.map(String).join(",");
    let query="select distinct igm.u_id from im_group_members igm INNER JOIN im_blocklist ibl on ibl.g_id=igm.g_id where ibl.u_id=? and igm.u_id<>? and igm.u_id IN (?)";
    let [result,err]=await mysqlCon.execute(query,[userId,userId,ids]);
    if(result.length === 0){
        return 0;
    }else{
        return 1;
    }
};

//-------- Im_group_members_Model---------//

Im_group_members_Model.getPersonalGroups=async function(userIds,limit,start){
    userIds=userIds.map(String).join(",");
    let query="select distinct igm.g_id,ig.type,ig.lastActive from im_group_members igm INNER JOIN im_group ig ON ig.g_id=igm.g_id where ig.type=1 and igm.u_id IN (?) ORDER BY ig.lastActive DESC ";
    let [result,err]=await mysqlCon.execute(query,[userIds]);
    return result;
};

Im_group_members_Model.getNonPersonalGroups = async function(userIds,limit,start){
    userIds=userIds.map(String).join(",");
    let query="select distinct igm.g_id,ig.type,ig.lastActive from im_group_members igm INNER JOIN im_group ig ON ig.g_id=igm.g_id where ig.type=0 and igm.u_id IN (?) ORDER BY ig.lastActive DESC";
    let [result,err]=await mysqlCon.execute(query,[userIds]);
    return result;
};

Im_group_members_Model.getTotalGroupMember= async function(g_id){
    let query="SELECT count(u_id) as total from im_group_members where g_id=?";
    let [result,err]=await mysqlCon.execute(query,[g_id]);
    return result[0].total;
};

Im_group_members_Model.getMembers=async function(g_id){
    let query = "SELECT igm.u_id, u.userSecret, u.firstName, u.lastName, u.userId, u.userEmail, u.userAddress, u.userMobile, u.userStatus, u.userGender, u.userProfilePicture, u.active FROM im_group_members igm INNER JOIN users u ON igm.u_id = u.userId WHERE igm.g_id = ?";
    let [result,err]=await mysqlCon.execute(query,[g_id]);
    return result;
};

Im_group_members_Model.insert=async function (g_id,u_id){
  let query="INSERT IGNORE INTO im_group_members (g_id,u_id) VALUES (?,?)";
    await mysqlCon.execute(query,[g_id,u_id]);
};

Im_group_members_Model.insertUserMention=async (u_id,r_id,g_id,date_time)=>{
    let query="INSERT INTO im_mention (u_id,r_id,g_id,date_time) VALUES (?,?,?,?)";
    let[res,err]=await mysqlCon.execute(query,[u_id,r_id,g_id,date_time]);
    return res.insertId;
};

//-------------- Im_group_Model -----------//

Im_group_Model.insert=async (name,lastActive,type,createdBy)=>{
    let query="INSERT INTO im_group (name,lastActive,type,createdBy) VALUES (?,?,?,?)";
    let[res,err]=await mysqlCon.execute(query,[name,lastActive,type,createdBy]);
    return res.insertId;
};

Im_group_Model.isBlocked=async (g_id)=>{
    let query="select * from im_group where g_id=? and block=1";
    let [result,err]=await mysqlCon.execute(query,[g_id]);
    if(result.length === 0){
        return 0;
    }else{
        return 1;
    }
};

Im_group_Model.updateLastActiveDate=async (g_id,lastActive)=>{
    let query="UPDATE im_group SET lastActive=? WHERE g_id=?";
    await mysqlCon.execute(query,[lastActive,g_id]);
};

Im_group_Model.getAdminUserIdbyGroupId=async (g_id)=>{
    let query="select createdBy as userId from im_group where g_id=?";
    let[result,err]=await mysqlCon.execute(query,[g_id]);
    return parseInt(result[0].userId);
};

Im_group_Model.getGroupMaxModerator=async (g_id)=>{
    let query="select if(count(u_id)>=10,1,0) as maximum from im_group_moderators where g_id=?";
    let[result,err]=await mysqlCon.execute(query,[g_id]);
    return parseInt(result[0].maximum);
};

//---------------- Im_message_Model -------------//

Im_message_Model.getRecentMessage = async (g_id)=>{
    let query="select * from im_message where receiver=? and type <> 'update'  order by m_id DESC LIMIT 1";
    let [result,err]=await mysqlCon.execute(query,[g_id]);
    if(result.length>0){
        let prepareData=result[0];
        prepareData.poster="";
        if(prepareData.type!="text" && prepareData.type!="update" && prepareData.type!="document"){
            prepareData.message= baseUrl+"assets/im/group_"+g_id+"/"+prepareData.message;
        }
        if(prepareData.type=="document"){
            let fileUrl=encodeURIComponent("assets/im/group_"+prepareData.receiver+"/"+prepareData.message)+"&fn="+encodeURIComponent(prepareData.fileName);
            prepareData.message=baseUrl+"download?f="+fileUrl;
        }
        if(prepareData.type=="video"){
            prepareData.poster=baseUrl+"assets/img/poster.jpg";
        }
        return prepareData;
    }
};

Im_message_Model.getRecentMessageWithUpdate = async (g_id)=>{
    let query="select * from im_message where receiver=? order by m_id DESC LIMIT 1";
    let [result,err]=await mysqlCon.execute(query,[g_id]);
    if(result.length>0){
        let prepareData=result[0];
        prepareData.poster="";
        if(prepareData.type!="text" && prepareData.type!="update" && prepareData.type!="document"){
            prepareData.message= baseUrl+"assets/im/group_"+g_id+"/"+prepareData.message;
        }
        if(prepareData.type=="document"){
            let fileUrl=encodeURIComponent(baseUrl + "assets/im/group_"+prepareData.receiver+"/"+prepareData.message)+"&fn="+encodeURIComponent(prepareData.fileName);
            prepareData.message=baseUrl+"download?f="+fileUrl;
        }
        if(prepareData.type=="video"){
            prepareData.poster=baseUrl+"assets/img/poster.jpg";
        }
        return prepareData;
    }
};

Im_message_Model.insert= async (u_id,g_id,message,type,fileName,receiver_type,date,time,date_time)=>{
    let query="INSERT INTO im_message (sender,receiver,message,type,fileName,receiver_type,date,time,date_time) VALUES (?,?,?,?,?,?,?,?,?)";
    let[res,err]= await mysqlCon.execute(query,[u_id,g_id,message,type,fileName,receiver_type,date,time,date_time]);
    return res.insertId;
};


//------------ Im_receiver_Model --------------//

Im_receiver_Model.deleteByGroupId=async (g_id)=>{
    let query="DELETE from im_receiver where g_id=?";
    await mysqlCon.execute(query,[g_id]);
};

//------------ notifications --------------//

Im_notifications_Model.insert= async (u_id,r_id,g_id,t_id)=>{
    let query="insert into im_notifications (u_id,r_id,g_id,t_id,date_time) values (?,?,?,?,now());";
    let [res,err] = await mysqlCon.execute(query,[u_id,r_id,g_id,t_id]);
    return res.insertId;
};

Im_notifications_Model.fetchDetails = async function(n_id){
    let query=`select concat(u2.firstName,' ',u2.lastName) as fromname, nt.description as notdesc, n.g_id,  
        if(!isnull(g.name),g.name,'Unnamed Community') as group_name, 
        u.active, u.userSecret, u.userId, s.socketId 
        from im_notifications as n
        inner join im_group as g on n.g_id = g.g_id
        inner join im_notification_types as nt on n.t_id = nt.id
        inner join users as u2 on u2.userid = n.u_id
        inner join users as u on n.r_id = u.userId
        left join im_usersocket as s on u.userId = s.userId
        where n.n_id=${n_id}`;
    let [result,err]= await mysqlCon.execute(query,[n_id]);
    return result[0];
};

//------------ join request --------------//

Im_group_requests_Model.approveJoinRequest = async function(member_id,group_id){
    let query=`update im_group_requests as r
        inner join im_group as g on r.g_id = g.g_id 
        set r.accepted_date=now()
        where r.g_id=? and r.u_id=? and isnull(r.accepted_date);`;
    await mysqlCon.execute(query,[group_id,member_id]);
}; 

Im_group_requests_Model.removeJoinRequest = async function(member_id,group_id){
    let query=`delete r from im_group_requests as r
        inner join im_group as g on r.g_id = g.g_id     
        where r.g_id=? and r.u_id=? and isnull(r.accepted_date);`;
    await mysqlCon.execute(query,[group_id,member_id]);
}; 

//------------ Community moderator --------------//

Im_group_moderators_Model.insert = async function(group_id,user_id){
    let query=`insert ignore into im_group_moderators (g_id,u_id) values (?,?);`;
    await mysqlCon.execute(query,[group_id,user_id]);
}; 

Im_group_moderators_Model.remove = async function(group_id,user_id){
    let query=`delete from im_group_moderators where g_id=? and u_id=?;`;
    await mysqlCon.execute(query,[group_id,user_id]);
}; 

// ralph 2019-05-24
Im_user_Model.getUserIdByUserSecret=async function (usersecret){
    let query="select userid from users where usersecret=?";
    let [result,err]=await mysqlCon.execute(query,[usersecret]);
    return parseInt(result[0].userid);
};

Im_user_Model.getUserSocketIdByUserSecret=async function (usersecret){
    let query="SELECT s.socketId FROM im_usersocket s LEFT JOIN users u ON u.userSecret=?";
    let [result,err]=await mysqlCon.execute(query,[usersecret]);
    return result[0].socketId;
};

app.Im_user_Model=Im_user_Model;
app.Im_blocklist=Im_blocklist;
app.Im_group_members_Model=Im_group_members_Model;
app.Im_group_Model=Im_group_Model;
app.Im_message_Model=Im_message_Model;
app.Im_receiver_Model=Im_receiver_Model;
app.Im_notifications_Model=Im_notifications_Model;
app.Im_group_requests_Model=Im_group_requests_Model;
app.Im_group_moderators_Model=Im_group_moderators_Model;
module.exports=app;