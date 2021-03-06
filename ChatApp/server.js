/* eslint-disable no-console */
/* eslint-disable no-undef */
/**
 * Created by Farhad Zaman on 2/13/2017.
 */
"use strict";
const express = require("express");
const app = express();
const serverConf = require("./serverConf");
const server = serverConf.createServer(app);
const io = require("socket.io").listen(server, {'pingTimeout': 5000, 'pingInterval': 1000});
const socketApi = require("socket.io-client")('https://socket.vyndue.com');
//const jwt_decode = require("jwt-decode");
const jwt = require('jwt-simple');
const moment = require('moment');
const database = require('./databaseConfig');
const mysql = database.mysql;
const extract = require('meta-extractor');
const getUrl = require('get-urls');
//const {URL} = require('url');
//const url2 = require('url');
const cron = require('node-cron');
const group = require("./group");
const emojiExists = require('emoji-exists');

const emoji = require("./emojione");
const _ = require('lodash');
const sMM = require("./sendmessageModel");
const empty = require('is-empty');
const probe = require('probe-image-size');
const fetch = require('node-fetch');
const FormData = require('form-data');
const fs = require('fs');
const path = require('path');

let CONSUMER_SECRET = "D6DMxSiGSarZehUZSADADsdawe"; //need to verify jwt tokens;
let users = {};
let connections = [];

serverConf.startServer(server);


const mysqlCon = database.mysqlCon;
const mysqlCon2 = database.mysqlCon2;

let db = function (conn, query, calback) {
    conn.getConnection(function (err, connection) {
        if (err) {
            console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "error connecting : " + err.stack);
            return;
        }
        console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "DB connected as id :" + connection.threadId);


        connection.query(query, function (error, results, fields) {
            connection.release();
            if (error) {
                console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + error.code); // 'ECONNREFUSED'
                console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + error.fatal); // true
            }
            // connected!
           // console.log(results);
            calback(results, error);

        });
    });
};


app.use(express.static(__dirname + '/public'));


app.get("/chat", function (req, res) {
    res.sendFile(__dirname + "/index.html");

});
// corn job for deleting invalid user session data from im_usersessions table every sunday 2300 hours utc
cron.schedule('* 59 23 * * 6', function () {
    console.log("\n\n---------------------------- Corn Job Start At " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ----------------------------\n");
    let getAllSession = "SELECT * FROM `im_usersessions`";
    db(mysqlCon, getAllSession, function (getAllSessionData, err) {
        if (!err) {
            for (let i = 0; i < getAllSessionData.length; i++) {
                let validity = moment(getAllSessionData[i].validity);
                let today = moment(moment().utc().format("YYYY-MM-DDTHH:mm:ss.SSSZZ"));
                let diff = validity.diff(today, 'days');
                if (diff < 0) {
                    let deleteSessionId = "DELETE from `im_usersessions` where `token`='" + getAllSessionData[i].token+"'";
                    db(mysqlCon, deleteSessionId, function (res, err) {
                        if (err) {
                            console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "deleteSessionId failed " + err);
                        } else {
                            console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "deleteSessionId success");
                        }
                    });
                }
            }
        } else {
            console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "getAllSession failed " + err);
        }
    });
    //console.log("\n\n---------------------------- Corn Job End At " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ----------------------------\n");
});

function stopServer() {
    console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "Im server is closed");
    process.exit(0);
}

function clearDisconnectedOldSockets() {
    let query = "TRUNCATE `im_usersocket`";
    db(mysqlCon, query, function (res, err) {
        if (err) {
            console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "usersocket table clear failed on server stop");
        }
        else {
            console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "usersocket table clear success on server stop");
            stopServer();
        }
    });
    let updateActiveQuery = "UPDATE `users` SET `active` = 0";
    db(mysqlCon, updateActiveQuery, function (res, err) {
        if (err) {
            console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "all user deactivate failed on server stop");
        }
        else {
            console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "all user deactivate success on server stop");
            stopServer();
        }
    });
}


process.on("SIGINT", function () {
    let disconnectTime = moment().utc().format("YYYY-MM-DDTHH:mm:ss.SSSZZ");
    updateSessionDisconnectTime(null, disconnectTime, function () {
        clearDisconnectedOldSockets();
    });

});

function deletePendingMessages(g_id, r_id) {
    let query = "DELETE FROM `im_receiver` WHERE g_id=" + mysql.escape(g_id) + " and r_id=" + mysql.escape(r_id);
    db(mysqlCon, query, function (res, err) {
        if (err) {
            console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "pending message clear failed");
        }
        else {
            console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "pending message clear success");
        }
    });
}

function updateSessionDisconnectTime(socket, disconnectTime, cb) {
    let updateLastActive;
    if (socket === undefined || socket === null) {
        updateLastActive = "UPDATE `im_usersessions` SET `lastActiveTime`='" + disconnectTime + "'";
    } else {
        updateLastActive = "UPDATE `im_usersessions` SET `lastActiveTime`='" + disconnectTime + "' where `socketId`='" + socket.id + "'";
    }
    db(mysqlCon, updateLastActive, function (res, err) {
        if (err) {
            console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "updateLastActive failed");
            cb(false);
        } else {
            cb(true);
        }
    });
}

function generateRandomString(length = 60) {
    let characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    let charactersLength = characters.length;
    let randomString = '';
    for (let i = 0; i < length; i++) {
        randomString += characters[Math.floor((Math.random() * (charactersLength - 1)))];
    }
    return randomString;
}

socketApi.on('connection', function (socket) {
    console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "connected to SOCKET-API");

    socketApi.emit('vyndue:connect', {user_secret: ''})

    socket.on('vyndue:message', function (data) {
        console.log('vyndue:message', data)
    })

    // socket.on('arbitrage:logout', function () {
    //     console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "logout");
    //     location.href = 'https://vyndue.com/userview/logout';
    // })

})

socketApi.on('arbitrage:logout', async function (userSecret) {

    let socketId = await sMM.Im_user_Model.getUserSocketIdByUserSecret(userSecret);
    users[socketId].emit("executeLogout");            
    //DeleteSocket(socketId);

})

io.on("connection", function (socket) {
    
    connections.push(socket);
    users[socket.id] = socket;
    let roomId = null;
    console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "connected %s", connections.length);


    socket.on("disconnect", function (reason) {

        let disconnectTime = moment().subtract(5, 'seconds').utc().format("YYYY-MM-DDTHH:mm:ss.SSSZZ"); //  seconds depends on ping time out
        let connectionIndex = connections.indexOf(socket);
        updateSessionDisconnectTime(socket, disconnectTime, function () {
            DeleteSocket(socket.id);
        });
        if (roomId !== null) {
            socket.leave(roomId);
            console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "leaving room '%s' on disconnect", roomId);
        }

        connections.splice(connectionIndex, 1);
        if (socket.id in users) {
            delete users[socket.id];
        }

        console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "disconnected %s", connections.length);
        console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "disconnected reason:" + reason);

    });

    socket.on("muteUpdate", function (data) {
        let findSocketIdQ = "select socketId from im_usersocket where userId=" + data.userId;
        db(mysqlCon, findSocketIdQ, function (result, error) {
            if (error) {
                console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "get socketId failed");
            } else {
                for (let i = 0; i < result.length; i++) {
                    try {

                        users[result[i].socketId].emit("muteStatus", data);

                    }
                    catch (err) {
                        DeleteSocket(result[i].socketId);
                        console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + err);
                    }
                }
            }
        });
    });


    socket.on("blockUpdate", async function (data) {

        for (let i = 0; i < data.memberIds.length; i++) {

            data.blockGroup = await group.get_group(data.groupId, data.memberIds[i].u_id);
            let findSocketIdQ = "select socketId from im_usersocket where userId=" + data.memberIds[i].u_id;
            let [result, f1] = await mysqlCon2.execute(findSocketIdQ);
            for (let j = 0; j < result.length; j++) {
                try {
                    users[result[j].socketId].emit("blockStatus", data);
                }
                catch (err) {
                    console.log(data.memberIds);
                    DeleteSocket(result[j].socketId);
                    console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ]" + err);
                }
            }
        }
    });

    socket.on("joinRoom", function (groupId) {
        if (groupId !== undefined) {
            let RId = parseInt(groupId);
            if (!isNaN(RId) && RId !== 0 && RId != null) {
                roomId = "room-" + RId;
                socket.join(roomId);
                console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "joinRoom:" + RId);
            }
        }
    });

    socket.on("leaveRoom", function (groupId) {
        if (groupId !== undefined) {
            let RId = parseInt(groupId);
            if (!isNaN(RId) && RId !== 0 && RId != null) {
                socket.leave("room-" + RId);
                console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "leaveRoom:" + RId);
            }
        }
    });

    socket.on("notTyping", async function (responce) {
        let data = null;
        if (typeof responce === "object") {
            data = responce;
        } else {
            data = JSON.parse(responce);
        }
        let User = await group.get_user(data.userId);

        let senderData = {
            userName: User.firstName,
            profilePicture: User.profilePictureUrl,
            userId: data.userId,
            groupId: data.groupId
        };

        io.sockets.in("room-" + data.groupId).emit("userNotTyping", senderData);

    });

    socket.on("typing", async function (responce) {
        let data = null;
        if (typeof responce === "object") {
            data = responce;
        } else {
            data = JSON.parse(responce);
        }

        let User = await group.get_user(data.userId);

        let senderData = {
            userName: User.firstName,
            profilePicture: User.profilePictureUrl,
            userId: data.userId,
            groupId: data.groupId
        };
        io.sockets.in("room-" + data.groupId).emit("userTyping", senderData);

    });

    socket.on("register", function (responce) {

        try {

            let data = null;
            if (typeof responce === 'object') {
                data = responce;
            } else {
                data = JSON.parse(responce);
            }
            isValidToken(data._r, async function (res) {
                if (res) {

                    try {
                        if (group.getHost() == null) {
                            group.setHost(data.url);
                        }
                        let user = [];
                        if (serverConf.ID_LOGIN) {
                            user = data._r;
                        } else {
                            try {
                                user = jwt.decode(data._r, CONSUMER_SECRET);
                            } catch (err) {
                                console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "register data._r Invalid jwt Signature " + err);
                                socket.disconnect();
                            }

                        }
                        if (data.hasOwnProperty("registrarType") && data.registrarType === "client") {
                            let insertSocketQ = "INSERT INTO `im_usersocket` (`userId`, `socketId`) VALUES (?, ?)";
                            try {
                                await mysqlCon2.execute(insertSocketQ, [user.userId, socket.id]);
                                console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "socket id insert success");
                                activeUser(user.userId);

                                // connect to socket-api
                                socketApi.emit('vyndue:connect', {user_secret: user.consumerKey})
                            } catch (err) {
                                console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "socket id insert failed " + err);
                            }


                            let sessionId = null;
                            let sessionToken = data.sId;
                            if (sessionToken != null) {
                                try {
                                    sessionId = jwt.decode(sessionToken, CONSUMER_SECRET).sId;
                                } catch (err) {
                                    console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "sessionToken Invalid jwt Signature " + err);
                                    socket.disconnect();
                                    return 0;
                                }
                            }
                            if (sessionId == null) {
                                sessionId = generateRandomString();// generating a 60 char length unique session Id
                                let tokenData = jwt.encode({sId: sessionId}, CONSUMER_SECRET);
                                socket.emit("getSessionId", tokenData); // sending a unique session id to identify the user browser after disconnect and reconnect happens
                            }
                            try {
                                // removing duplicate tokens
                                let checkSameTokenWithDifferentUser = "SELECT * FROM `im_usersessions` where u_id<>? and `token`=?";
                                let [checkSameTokenWithDifferentUserData, f1] = await mysqlCon2.execute(checkSameTokenWithDifferentUser, [user.userId, sessionId]);
                                if (checkSameTokenWithDifferentUserData.length > 0) {
                                    let DeleteCheckSameTokenWithDifferentUser = "DELETE FROM `im_usersessions` where u_id<>? and `token`=?";
                                    await mysqlCon2.execute(DeleteCheckSameTokenWithDifferentUser, [user.userId, sessionId]);
                                }
                            } catch (err) {
                                console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "removing duplicate tokens failed " + err);
                            }
                            try {
                                let checkTokenExist = "SELECT * FROM `im_usersessions` where u_id=? and `token`=?";
                                let [checkTokenExistData, f2] = await mysqlCon2.execute(checkTokenExist, [user.userId, sessionId]);
                                if (checkTokenExistData.length > 0) {
                                    let validity = moment(moment().add(5, 'days')).utc().format("YYYY-MM-DDTHH:mm:ss.SSSZZ");
                                    let updateSocketId = "Update `im_usersessions` SET `socketId`=?,`validity`=? where `u_id`=? and `token`=?";
                                    try {
                                        await mysqlCon2.execute(updateSocketId, [socket.id, validity, user.userId, sessionId]);
                                    } catch (e) {
                                        console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "updateSocketId failed " + e);
                                    }
                                } else {
                                    let validity = moment(moment().add(5, 'days')).utc().format("YYYY-MM-DDTHH:mm:ss.SSSZZ");
                                    let insertData = "INSERT INTO `im_usersessions` (`u_id`,`socketId`,`token`,`validity`) VALUES(?,?,?,?)";
                                    try {
                                        await mysqlCon2.execute(insertData, [user.userId, socket.id, sessionId, validity]);
                                    } catch (e) {
                                        console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "insertData failed " + e);
                                    }
                                }
                            } catch (e) {
                                console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "checkTokenExist failed " + e);
                            }

                            let getAllSession = "SELECT * FROM `im_usersessions` where u_id='" + mysql.escapeId(user.userId)+"'";
                            db(mysqlCon, getAllSession, function (getAllSessionData, err) {
                                if (!err) {
                                    for (let i = 0; i < getAllSessionData.length; i++) {
                                        let validity = moment(getAllSessionData[i].validity);
                                        let today = moment(moment().utc().format("YYYY-MM-DDTHH:mm:ss.SSSZZ"));
                                        let diff = validity.diff(today, 'days');
                                        if (diff < 0) {
                                            let deleteSessionId = "DELETE from `im_usersessions` where `token`=" + getAllSessionData[i].token + " and u_id='" + mysql.escapeId(user.userId)+"'";
                                            db(mysqlCon, deleteSessionId, function (res, err) {
                                                if (err) {
                                                    console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "deleteSessionId failed " + err);
                                                } else {
                                                    console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "deleteSessionId success");
                                                }
                                            });
                                        }
                                    }
                                } else {
                                    console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "getAllSession failed " + err);
                                }
                            });

                        }

                    } catch (err) {
                        console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + err);
                    }

                } else {

                    socket.disconnect();
                    console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "invalid user");
                }
            });
        } catch (err) {
            console.log(err);
        }

    });

    socket.on("addMember", function (res) {
        let data = null;

        if (typeof res === 'object') {
            data = res;
        } else {
            data = JSON.parse(res);
        }
        isValidToken(data._r, function (result) {
            if (result) {
                try {

                    data._r = "";
                    let memberId = data.memberId;
                    if (memberId !== null) {
                        //for (let i = 0; i < members.length; i++) {
                        let findSocketIdQ = "select socketId from im_usersocket where userId=" + memberId;
                        db(mysqlCon, findSocketIdQ, function (result, error) {
                            if (error) {
                                console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "get socketId failed");
                            } else {
                                for (let i = 0; i < result.length; i++) {
                                    try {

                                        users[result[i].socketId].emit("addNewMember", data);

                                    }
                                    catch (err) {
                                        DeleteSocket(result[i].socketId);
                                        console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + err);
                                    }
                                }
                            }
                        });
                        // }
                    }

                } catch (err) {
                    console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + err);
                }
            } else {
                socket.disconnect();
                console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "invalid user");
            }


        });
    });

    socket.on("deleteMember", function (res) {
        let data = null;

        if (typeof res === 'object') {
            data = res;
        } else {
            data = JSON.parse(res);
        }
        isValidToken(data._r, function (result) {
            if (result) {
                try {
                    data._r = "";
                    let memberId = data.memberId;
                    if (memberId !== null) {
                        //for (let i = 0; i < members.length; i++) {
                        let findSocketIdQ = "select socketId from im_usersocket where userId=" + memberId;
                        db(mysqlCon, findSocketIdQ, function (result, error) {
                            if (error) {
                                console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "get socketId failed");
                            } else {
                                for (let i = 0; i < result.length; i++) {
                                    try {
                                        users[result[i].socketId].emit("deleteAMember", data);
                                    }
                                    catch (err) {
                                        DeleteSocket(result[i].socketId);
                                        console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + err);
                                    }
                                }
                            }
                        });

                    }

                } catch (err) {
                    console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + err);
                }
            } else {
                socket.disconnect();
                console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "invalid user");
            }


        });
    });

   
    socket.on("updateGroupImage",function (data) {
        let g_id = data.g_id;
        // change path to current temp location
        let tempPath = data.imageData;
        const form = new FormData();
        form.append('file', fs.createReadStream(tempPath[0]));
        fetch('https://dev-api.arbitrage.ph/api/storage/upload', { method: 'POST', body: form })
        .then(res => res.json())
        .then(json => {
            let fileURL = JSON.stringify(json.data.file.url);
            let updateQuery = "UPDATE `im_group` SET `custom_image` = " + fileURL + " WHERE `im_group`.`g_id` = " + g_id + ";";
            mysqlCon2.execute(updateQuery);
            // //delete file after db update
            fs.unlinkSync(tempPath[0]);
        });
        try {
            let members = data.memberIds;
            if (members !== null) {
                for (let i = 0; i < members.length; i++) {
                    let findSocketIdQ = "select socketId from im_usersocket where userId=" + members[i].u_id;
                    db(mysqlCon, findSocketIdQ, function (result, error) {
                        if (error) {
                            console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "get socketId failed");
                        } else {
                            for (let j = 0; j < result.length; j++) {
                                try {
                                    let socketData={
                                        g_id:data.g_id,
                                        imageData:data.imageData
                                    }
                                    users[result[j].socketId].emit("updateGroupImage", socketData);
                                }
                                catch (err) {
                                    DeleteSocket(result[j].socketId);
                                    console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + err);
                                }
                            }
                        }
                    });
                }
            }

        } catch (err) {
            console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + err);
        }
    })

    socket.on("updateGroupName", function (res) {
        let data = null;

        if (typeof res === 'object') {
            data = res;
        } else {
            data = JSON.parse(res);
        }
        isValidToken(data._r, function (result) {
            if (result) {
                try {
                    data._r = "";
                    let members = data.memberIds;
                    if (members !== null) {
                        for (let i = 0; i < members.length; i++) {
                            let findSocketIdQ = "select socketId from im_usersocket where userId=" + members[i].u_id;
                            db(mysqlCon, findSocketIdQ, function (result, error) {
                                if (error) {
                                    console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "get socketId failed");
                                } else {
                                    for (let j = 0; j < result.length; j++) {
                                        try {
                                            users[result[j].socketId].emit("updateGroupNameData", data);
                                        }
                                        catch (err) {
                                            DeleteSocket(result[j].socketId);
                                            console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + err);
                                        }
                                    }
                                }
                            });
                        }
                    }

                } catch (err) {
                    console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + err);
                }
            } else {
                socket.disconnect();
                console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "invalid user");
            }


        });

    });

    socket.on('sendNotification', function (n_id){
        let result = sMM.Im_notifications_Model.fetchDetails(n_id);
        result.then(res => {
            //console.log(res);
            if(parseInt(res.active)){
                users[res.socketId].emit("notifyUser", res);
            } 
        })
    });

    socket.on('seenNotification', function (n_id){
        
        let SQLQuery = "update im_notifications set seen=1, seen_tstamp=now() where n_id=? and seen=0";
        mysqlCon2.execute(SQLQuery, [n_id]);
        
    });

    socket.on('clearNotificationBox', function (r_id){

        let SQLQuery1 = "update im_notifications set seen=1, seen_tstamp=now() where r_id=? and seen=0";
        let SQLQuery2 = "UPDATE im_receiver SET received=1 WHERE r_id = ?";
        let SQLQuery3 = "UPDATE im_mention SET seen=1, seen_tstamp=now() where r_id=? and seen=0";
        mysqlCon2.execute(SQLQuery1, [r_id]);
        mysqlCon2.execute(SQLQuery2, [r_id]);
        mysqlCon2.execute(SQLQuery3, [r_id]);

    });

    socket.on('joinrequestProccess', function (data){
        
        let result = JoinRequestNotification(data);
        result.then(response => {
            if(parseInt(response.active)){
                users[response.socketId].emit("notifyUser", response);
            } 
        });

    });

    async function JoinRequestNotification(data) {

        data.u_id = await sMM.Im_user_Model.getUserIdByUserSecret(data.u_id);
        let { u_id,r_id,g_id,t_id } = data;

        if(parseInt(data.approve)===1){
            //update request 
            await sMM.Im_group_requests_Model.approveJoinRequest(r_id,g_id);
            //add user in the group
            await sMM.Im_group_members_Model.insert(g_id,r_id);
        }else{
            // remove request
            await sMM.Im_group_requests_Model.removeJoinRequest(r_id,g_id);
        }

        // send notification
        let n_id = await sMM.Im_notifications_Model.insert(u_id,r_id,g_id,t_id);
        let result = await sMM.Im_notifications_Model.fetchDetails(n_id);
        return result;

    }
    
    socket.on('invitationaccept', function(data){
        //console.log(data);
        let result = InvitationAcceptNotification(data);
        result.then(response => {
            //console.log('response from fetch')
            //console.log(response);
            if(parseInt(response.active)){
                users[response.socketId].emit("notifyUser", response);
            } 
        });
    });

    async function InvitationAcceptNotification(data) {
        let n_id = 0;
        if(data.generator_id>0){
            n_id = await sMM.Im_notifications_Model.insert(data.user_id,data.generator_id,data.group_id,9);
        }else{
            n_id = await sMM.Im_notifications_Model.insert(data.user_id,data.admin_id,data.group_id,9);
        }
        let result = await sMM.Im_notifications_Model.fetchDetails(n_id);
        return result;
    }


    socket.on('communitymoderatorProcess', function (data){
        //console.log(data);
        let result = CommunityModeratortNotification(data);
        result.then(response => {
            if(parseInt(response.active)){
                users[response.socketId].emit("notifyUser", response);
            } 
        });
    });

    async function CommunityModeratortNotification(data) {

        data.userSecret = data.u_id;
        data.u_id = await sMM.Im_user_Model.getUserIdByUserSecret(data.u_id);
        let { u_id,r_id,g_id,t_id } = data;

        // verify admin 
        let admin_id = await sMM.Im_group_Model.getAdminUserIdbyGroupId(data.g_id);
        if(parseInt(admin_id)!=parseInt(u_id)){
            return false;
        }

        if(parseInt(data.userlevel)===0){
            // limit moderators, 10 max
            let limit_moderator = await sMM.Im_group_Model.getGroupMaxModerator(data.g_id);
            if(parseInt(limit_moderator)){
                let socketId = await sMM.Im_user_Model.getUserSocketIdByUserSecret(data.userSecret);
               // console.log(socketId);
                users[socketId].emit("promptWarning", "You reached maximum count of moderators per community.");
               // console.log(users[socketId]);
                return;
            }
            //make moderator
            await sMM.Im_group_moderators_Model.insert(g_id,r_id);
        }else{
            //remove moderator authority
            await sMM.Im_group_moderators_Model.remove(g_id,r_id);
        }

        // send notification
        let n_id = await sMM.Im_notifications_Model.insert(u_id,r_id,g_id,t_id);
        let result = await sMM.Im_notifications_Model.fetchDetails(n_id);
        return result;

    }

      socket.on("sendText", function (response) {
        let data = null;
        if (typeof response === 'object') {
            data = response;
        } else {
            data = JSON.parse(response);
        }

        isValidToken(data._r, async function (ret) {
            if (ret) {

                try {
                    let senderId = null;
                    let date = moment().utc().format("YYYY-MM-DD");
                    let time = moment().utc().format("HH:mm:ss");
                    let date_time = moment().utc().format("YYYY-MM-DDTHH:mm:ss.SSSZZ");
                    let receiverId = null;
                    let userIds = [];
                    let g_ids = [];
                    let groupsIds = null;
                    let name = null;
                    let message = null;
                    let fileType = "text";

                    // emoji.ascii=true;

                    if (serverConf.ID_LOGIN) {
                        senderId = parseInt(data.userId);
                    } else {
                        senderId = parseInt(jwt.decode(data._r, CONSUMER_SECRET).userId);
                    }
                    if (_.has(data, "groupId")) {
                        receiverId = data.groupId;
                    }

                    // Raplh Mention;
                    if(data.message.includes('class="mention"')==true){
                        let rex = /<a\s+(?:[^>]*?\s+)?data-username=(["'])(.*?)\1/g;
                        let arrMention = [];
                        let m = [];
                        while ( m = rex.exec( data.message ) ) {
                            //console.log(m);
                            let mention_id = await sMM.Im_user_Model.getUserIdByUserSecret(m[2]);
                            //console.log(mention_id);
                            if(parseInt(mention_id)>0 && (arrMention.indexOf(mention_id)==-1)){
                                await sMM.Im_group_members_Model.insertUserMention(senderId,mention_id,receiverId,date_time);
                                arrMention.push(mention_id);

                                let findUser = `Select concat(firstName, ' ', lastName) as full_name FROM users WHERE userId = ?`
                                let [sender, findUserErr] = await mysqlCon2.execute(findUser, [senderId]);

                                let socketApiData = {
                                    sender: sender[0].full_name,
                                }

                                // send notification to socket-api
                                socketApi.emit('vyndue:mention', {user_secret: m[2], data: socketApiData})

                                // check if user is active then trigger a push notification
                                let socketQuery = `select u.active, concat(u2.firstName,' ',u2.lastName) as fromname, m.g_id as group_id, u.userSecret, u.userId, s.socketId
                                                    from im_mention as m 
                                                    inner join im_usersocket as s on m.r_id = s.userId
                                                    left join users as u on m.r_id = u.userId
                                                    left join users as u2 on m.u_id = u2.userId
                                                    where m.u_id = ? and m.r_id = ? and m.g_id = ? and m.date_time=? limit 1`;
                                let [result,err] = await mysqlCon2.execute(socketQuery,[senderId,mention_id,receiverId,date_time]);
                                for (let i = 0; i < result.length; i++) {
                                    try{
                                         if(parseInt(result[i].active)>0){
                                            users[result[i].socketId].emit("notifyMentionUser", result[i]);
                                         } 
                                    } catch (err) {
                                      //  console.log('error here');
                                        console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + err);
                                    }
                                }
                            }
                        }
                    }


                    if (receiverId == null) {
                        if (_.has(data, "memberId") && _.isArray(data.memberId) && !empty(data.memberId)) {
                            userIds = data.memberId;
                        } else {
                            socket.emit("errorMessage", "Either memberId or groupId is required,memberId is an array.");
                            return 0;
                        }
                        if (await sMM.Im_blocklist.ifExistInList(senderId, userIds)) {
                            socket.emit("errorMessage", "Block member detected. Can't send message.");
                            return 0;
                        }

                        userIds.push(senderId);
                        userIds = userIds.map(function (x) {
                            return parseInt(x);
                        });
                        userIds = _.uniq(userIds);

                        if (userIds.length <= 1 || userIds.includes(0) || userIds.includes(NaN) || userIds.includes(undefined)) {
                            socket.emit("errorMessage", "Invalid member Ids provided.");
                            return 0;
                        }

                        if (userIds.length == 2) {
                            // chat
                            groupsIds = await sMM.Im_group_members_Model.getPersonalGroups(userIds, null, null)
                        } else {
                            // community
                            groupsIds = await sMM.Im_group_members_Model.getNonPersonalGroups(userIds, null, null);
                        }

                        for (let i = 0; i < groupsIds.length; i++) {
                            let $totalReceiver = await sMM.Im_group_members_Model.getTotalGroupMember(groupsIds[i].g_id);
                            let $getMembers = await sMM.Im_group_members_Model.getMembers(groupsIds[i].g_id);
                            let $member = [];
                            for (let j = 0; j < $getMembers.length; j++) {
                                $member.push($getMembers[j].u_id);
                            }

                            let diff = _.difference($member, userIds);
                            if (parseInt($totalReceiver) == userIds.length && diff.length == 0) {
                                g_ids.push(groupsIds[i].g_id);
                                break;
                            }
                        }
                        if (g_ids.length > 0) {
                            receiverId = g_ids[0];
                        } else {
                            if (_.has(data, "g_name")) {
                                name = date.g_name;
                            }
                            if (name == null || name == "" || name == '""' || name == "''") {
                                name = null;
                            }
                            let $groupType = 0;
                            if (userIds.length == 2) {
                                $groupType = 1;
                            }
                            receiverId = await sMM.Im_group_Model.insert(name, date_time, $groupType, senderId);
                            //newGroup = true;
                            for (let i = 0; i < userIds.length; i++) {
                                await sMM.Im_group_members_Model.insert(receiverId, userIds[i]);
                            }

                        }

                    }
                    else {
                        // Here
                        let groupMembers = await sMM.Im_group_members_Model.getMembers(receiverId);
                        let groupMembersIds = [];
                        for (let i = 0; i < groupMembers.length; i++) {
                            groupMembersIds.push(parseInt(groupMembers[i].u_id));
                        }
                        if (!_.includes(groupMembersIds, parseInt(senderId))) {
                            socket.emit("errorMessage", "You are not a member of this group.");
                            return 0;
                        }
                    }
                    if (await sMM.Im_group_Model.isBlocked(receiverId)) {
                        socket.emit("errorMessage", "message is blocked");
                        return 0;
                    }
                    message = emoji.unicodeToImage(data.message);
                    let receiverType = "personal";
                    let totalReceiver = await sMM.Im_group_members_Model.getTotalGroupMember(receiverId);
                    if (totalReceiver > 2) {
                        receiverType = "group";
                    }
                    let oldMessage = await sMM.Im_message_Model.getRecentMessage(receiverId);
                    if (oldMessage != null) {
                        await sMM.Im_receiver_Model.deleteByGroupId(receiverId);
                    }
                    let memberIds = await sMM.Im_group_members_Model.getMembers(receiverId);
                    await sMM.Im_message_Model.insert(senderId, receiverId, message, fileType, null, receiverType, date, time, date_time);
                    let fullMessage = await sMM.Im_message_Model.getRecentMessageWithUpdate(receiverId);

                    let senderInfo = await group.get_user(senderId);
                    await sMM.Im_group_Model.updateLastActiveDate(receiverId, date_time);
                    fullMessage.ios_date_time = fullMessage.date_time;

                    let sendMessageData = {};
                    sendMessageData.to = receiverId;
                    sendMessageData.receiversId = memberIds;
                    sendMessageData.message = fullMessage;
                    sendMessageData.sender = senderInfo;
                    await sendMessage(sendMessageData, socket);
                    //if (newGroup) {
                    let groupInfo = await group.get_group(receiverId, senderId);
                    let findSocketIdQ = "select socketId from im_usersocket where userId=" + senderId;                    
                    let result = await mysqlCon2.execute(findSocketIdQ);
                    for (let i = 0; i < result.length; i++) {
                        users[result[i].socketId].emit("addNewGroup", groupInfo);
                    }
                    //}

                   /* socketApi.emit('vyndue:new_message', {
                        receivers: memberIds,
                        message: fullMessage,
                        sender: senderInfo,
                    }) */

                } catch (err) {
                    console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + err);
                }
            } else {
                socket.disconnect();
                console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "invalid user");
            }

        });
    });

    socket.on("sendMessage", async function (responce) {
        await sendMessage(responce, socket);
    });

    socket.on("generateInviteLink", async function (responce) {
        await generateInviteLink(responce, socket);
    });
    socket.on("announceSeen", announceSeen);

    socket.on("fetchOnReconnect", function (response) {
        let dateTimeNow = moment().utc().format("YYYY-MM-DDTHH:mm:ss.SSSZZ");
        let data = null;
        if (typeof response === 'object') {
            data = response;
        } else {
            data = JSON.parse(response);
        }

        isValidToken(data._r, async function (ret) {
            if (ret) {
                try {
                    if (data.userId !== undefined) {
                        let fetchGroups = [];
                        let fetchMessage = [];
                        let activeGroupMembers = [];
                        let userId = parseInt(data.userId);
                        let domGroups = [];
                        if (data.hasOwnProperty("domGroups")) {
                            domGroups = data.domGroups;
                        }
                        if (!isNaN(userId) && userId !== 0 && userId != null && data.hasOwnProperty("sId")) {
                            let sessionId = null;
                            let sessionToken = data.sId;
                            try {
                                sessionId = jwt.decode(sessionToken, CONSUMER_SECRET).sId;
                            } catch (e) {
                                console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] fetchOnReconnect(catch) sessionId Invalid:" + e);
                                socket.disconnect();
                                return 0;
                            }
                            let getLastActiveTime = "SELECT lastActiveTime FROM `im_usersessions` where token=? and u_id=?";
                            let [sessionData, f1] = await mysqlCon2.execute(getLastActiveTime, [sessionId, userId]);
                            if (sessionData.length > 0) {
                                let lastActiveTime = sessionData[0].lastActiveTime;
                                let requestTime = dateTimeNow;
                                //let receiverQuery = "SELECT ir.* FROM `im_receiver` ir INNER JOIN `im_message` im on im.m_id=ir.m_id and im.sender<>ir.r_id where ir.r_id=? and ir.time BETWEEN ? and ?";
                                let receiverQuery = "SELECT DISTINCT igm.g_id,ig.type,ig.lastActive FROM im_group_members igm INNER JOIN im_group ig ON ig.g_id=igm.g_id WHERE igm.u_id=? and ig.lastActive BETWEEN ? and ? ORDER BY ig.lastActive DESC";
                                let [resdata, f] = await mysqlCon2.execute(receiverQuery, [userId, lastActiveTime, requestTime]);
                                for (let i = 0; i < resdata.length; i++) {
                                    fetchGroups.push(await group.get_group(resdata[i].g_id, userId));
                                }
                                if (data.activeGroupId != null && data.activeGroupId != undefined) {

                                    let messageQuery = "SELECT * FROM `im_message` WHERE receiver=? and date_time BETWEEN ? and ?  ORDER by date_time DESC, m_id DESC";
                                    let [message, f] = await mysqlCon2.execute(messageQuery, [parseInt(data.activeGroupId), lastActiveTime, requestTime]);
                                    let processedMessage = {};
                                    for (let i = 0; i < message.length; i++) {
                                        //if (checkReceiveRecord(message[i].m_id, userId, data.activeGroupId)) {
                                        processedMessage = await group.messageProcess(message[i]);
                                        processedMessage.seen = null;
                                        if ((message.length - 1) === i && parseInt(message[message.length - 1].sender) === userId) {
                                            let receiverIdQuery = "select r_id from `im_receiver` where g_id=? and m_id=? and received=1 and announced=1";
                                            let [receiverIds, f] = await mysqlCon2.execute(receiverIdQuery, [parseInt(data.activeGroupId), message[i].m_id]);
                                            for (let j = 0; j < receiverIds.length; j++) {
                                                activeGroupMembers.push(receiverIds[j].r_id);
                                            }
                                            processedMessage.seen = await group.processSeen(processedMessage.ios_date_time, parseInt(data.activeGroupId), activeGroupMembers);
                                        }
                                        fetchMessage.push({
                                            message: processedMessage,
                                            sender: await group.get_user(message[i].sender),
                                        });
                                        //}
                                    }

                                }
                                let removedGroupIds = [];
                                for (let i = 0; i < domGroups.length; i++) {
                                    let groupMembers = await sMM.Im_group_members_Model.getMembers(domGroups[i]);
                                    let groupMembersIds = [];
                                    for (let i = 0; i < groupMembers.length; i++) {
                                        groupMembersIds.push(parseInt(groupMembers[i].u_id));
                                    }
                                    if (!_.includes(groupMembersIds, parseInt(userId))) {
                                        removedGroupIds.push(domGroups[i]);
                                    }
                                }
                                let socketData = {
                                    groups: fetchGroups,
                                    activeGroupMessages: fetchMessage.reverse(),
                                    removedGroupIds: removedGroupIds,
                                };

                                socket.emit("getFetchOnReconnect", socketData);
                                if (fetchMessage.length > 0) {
                                    let recentMessage = fetchMessage[fetchMessage.length - 1].message;
                                    if (await isNotReceived(userId, recentMessage.receiver, recentMessage.m_id)) {
                                        let updateRecentQuery = "update im_receiver set received=1, announced=1, time=? where r_id=? and g_id=? and m_id=?";
                                        await mysqlCon2.execute(updateRecentQuery, [dateTimeNow, userId, recentMessage.receiver, recentMessage.m_id]);
                                        let seenData = {
                                            recentMessage: parseInt(recentMessage.m_id),
                                            receivedTime: dateTimeNow
                                        };

                                        announceSeen(seenData);
                                    }
                                }
                            }
                        }

                    }
                } catch (err) {
                    console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] fetchOnReconnect(catch):" + err);
                }
            }
        });
    });

    socket.on("error", function (err) {
        console.log(err);
    });

});

async function sendMessage(response, socket) {

    let data = null;
    let message = null;
    if (typeof response === 'object') {
        data = response;
         //store attachment to cloud
         if (data.file) {
            let msg_id = data.message.m_id;
            // change path to current temp location
            let tempPath = '../assets/temp/' + data.file;
            const form = new FormData();
            form.append('file', fs.createReadStream(tempPath));
            fetch('https://dev-api.arbitrage.ph/api/storage/upload', { method: 'POST', body: form })
            .then(res => res.json())
            .then(json => {
                let fileURL = JSON.stringify(json.data.file.url);
                let updateQuery = "UPDATE `im_message` SET `message` = " + fileURL + " WHERE `im_message`.`m_id` = " + msg_id + ";";
                mysqlCon2.execute(updateQuery);
                //delete file after db update
                // wont be able to access uploaded files bc its deleted, consider adding time expiry on when to delete files
                // setTimeout(function() {
                //     fs.unlinkSync(tempPath);
                // }, 5000);
            });
        }
    } else {
        data = JSON.parse(response);
    }


            //isValidToken(data._r, async function (ret) {
            //if (ret) {
            try {
                let res = data.receiversId;
                let receiversRoomId = data.to;
                let availableUsers = [];
                let messageSender = data.sender.userId;
                    if (data.message.type !== "update") {

                        let userIds = res.join(',');
                        let findSocketIdQ = `SELECT * 
                                            FROM im_usersocket
                                            WHERE userId IN (?)
                                            AND socketId<>?`;
                        let [result, f1] = await mysqlCon2.execute(findSocketIdQ, [userIds, socket.id]);
                    
                    // let offlineUsers = res.filter(groupMember => !result.find(user => groupMember.u_id == user.userId));

                    for (let i = 0; i < res.length; i++) {
                        let uid = res[i].u_id;
                        // let findSocketIdQ = "select socketId from im_usersocket where userId=? and socketId<>?";
                        // let [result, f1] = await mysqlCon2.execute(findSocketIdQ, [uid, socket.id]);
                        let userIsOnline = result.filter(online => uid == online.userId);
                                if (userIsOnline.length > 0) {
                                    for (let i = 0; i < userIsOnline.length; i++) {

                                        try {
                                            if (!io.sockets.adapter.sids[userIsOnline[i].socketId]["room-" + receiversRoomId]) {
                                                if (!await checkReceiveRecord(data.message.m_id, uid, data.to)) {
                                                    let receiverQuery = "INSERT INTO `im_receiver` (`g_id`, `m_id`, `r_id`, `received`, `announced`,`time`) VALUES ('" + data.to + "', '" + data.message.m_id + "', '" + uid + "', '0','0', '" + data.message.ios_date_time + "');";
                                                    mysqlCon2.execute(receiverQuery);
                                                    console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "message saved to receiver DB");

                                                } else {
                                                    pendingMessage(uid, data.to, data.sender.userId, userIsOnline[i].socketId);
                                                }
                                            }
                                            else {
                                                if (parseInt(messageSender) !== parseInt(uid)) {
                                                    if (!await checkReceiveRecord(data.message.m_id, uid, data.to)) {
                                                        let receiverQuery = "INSERT INTO `im_receiver` (`g_id`, `m_id`, `r_id`, `received`, `announced`,`time`) VALUES ('" + data.to + "', '" + data.message.m_id + "', '" + uid + "','1' ,'1', '" + data.message.ios_date_time + "');";
                                                        mysqlCon2.execute(receiverQuery);

                                                        availableUsers.push(uid);
                                                    }
                                                }

                                            }
                                        } catch (app) {
                                            console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + app);
                                        }
                                    }
                                } else {         //user has no active session
                                    if (!await checkReceiveRecord(data.message.m_id, uid, data.to) && parseInt(messageSender) !== parseInt(uid)) {
                                        let receiverQuery = "INSERT INTO `im_receiver` (`g_id`, `m_id`, `r_id`, `received`,`announced` ,`time`) VALUES ('" + data.to + "', '" + data.message.m_id + "', '" + uid + "', '0','0', '" + data.message.ios_date_time + "');";
                                        mysqlCon2.execute(receiverQuery);

                                        console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "message saved to receiver DB");
                                    }
                                }

                    }
                }
                messageConstructLinkConvert(data, async function (data) {
                    message = data;
                    message.seen = await group.processSeen(message.message.ios_date_time, receiversRoomId, availableUsers);
                    message.message.onlyemoji = emojiExists(message.message.message) ? 1 : 0;
                    if (message.message.onlyemoji) {
                        let updateQuery = "UPDATE `im_message` SET `onlyemoji` = '" + message.message.onlyemoji + "' WHERE `im_message`.`m_id` = " + message.message.m_id + ";";
                        await mysqlCon2.execute(updateQuery);
                    }
                    io.sockets.in("room-" + receiversRoomId).emit('newMessage', message);
                });
            } catch (app) {
                console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + app);
            }

        // } else {
        //         socket.disconnect();
        //         console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "invalid user");
        // }
    
    //});

}
async function generateInviteLink(responce, socket) {
    let updateQuery = "INSERT INTO `im_group_invitations` (`u_id`, `time_stamp`, `token`) VALUES ('" + responce.senderId + "', '" + responce.timestamp + "', '" + responce.token + "');" ;
    mysqlCon2.execute(updateQuery);
}		

async function pendingMessage(userId, groupId, senderId, socketId) {

    let groupData = await group.get_group(groupId, userId);

    let sendData = {"groupData": groupData, "senderId": senderId};
    try {

        users[socketId].emit("pendingMessage", JSON.stringify(sendData));
    }
    catch (err) {
        DeleteSocket(socketId);
        console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + err);
    }

}

async function checkReceiveRecord(m_id, userId, groupid) {
    let receiverQuery = "Select * from `im_receiver` where `g_id`=" + groupid + " and `m_id`=" + m_id + " and `r_id`=" + userId;
    let [res, f] = await mysqlCon2.execute(receiverQuery);
    return res.length !== 0;


}

async function isNotReceived(receiverId, groupId, messageId) {
    let query = "SELECT * FROM `im_receiver` where r_id=? and g_id=? and m_id=? and received=0";
    let [result, f] = await mysqlCon2.execute(query, [receiverId, groupId, messageId]);

    return result.length !== 0;
}

function announceSeen(response) {

    let data = null;
    let m_id = null;

    if (typeof response === 'object') {
        data = response;
    } else {
        data = JSON.parse(response);
    }
    m_id = data.recentMessage;
    let receivedTime = data.receivedTime;
    let query = "SELECT sender,receiver FROM `im_message` WHERE m_id=" + mysql.escape(m_id);
    db(mysqlCon, query, function (result, error) {
        if (error) {
            console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + error);
        } else {
            let senderId = result[0].sender;
            let groupId = result[0].receiver;
            let query = "SELECT r_id FROM `im_receiver` WHERE received=1 and m_id=" + mysql.escape(m_id);
            db(mysqlCon, query, function (res, err) {
                if (err) {
                    console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + err);
                } else {
                    let receiversIds = [];
                    for (let i = 0; i < res.length; i++) {
                        if (res[i].r_id !== senderId) {
                            receiversIds.push(res[i].r_id);
                        }
                    }
                    let findSocketIdQ = "select socketId from im_usersocket where userId=" + senderId;
                    db(mysqlCon, findSocketIdQ, async function (r, e) {
                        if (e) {
                            console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + e);
                        } else {
                            for (let i = 0; i < r.length; i++) {
                                try {
                                    let data = {
                                        seen: await group.processSeen(receivedTime, groupId, receiversIds),
                                        forMessage: m_id
                                    };
                                    if (!empty(data.seen)) {
                                        users[r[i].socketId].emit("receiveSeen", data);
                                    }
                                }
                                catch (err) {
                                    DeleteSocket(r[i].socketId);
                                    console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + err);
                                }
                            }
                        }
                    });
                }
            });
        }
    });

}

function messageConstructLinkConvert(data, callback) {
    let message = null;
    let mainMessage = data.message.message;
    let mainUrl = null;
    let host = null;
    let title = null;
    let description = null;
    let playerOrImageUrl = null;

    if (hasUrl(mainMessage)) {
        let url = getFirstUrl(mainMessage);
        let responded = false;
        let optionsWihHeader = {
            uri: url,
            timeout: 3000,
            headers: {'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.98 Mobile Safari/537.36'},
            limit: 2097152,
        };
        let options = {
            uri: url,
            timeout: 3000,
            limit: 2097152,
        };

        if (url.match(/@(-?\d+\.\d+),(-?\d+\.\d+),(\d+\.?\d?)+z/g)) { // checking latitude and longitude points are present or not
            options = optionsWihHeader;
        }
        const regex = /assets\/im\/group_[0-9]+\/(\w+\.(jpg|png|gif|jpeg))/gm;

        extract(options,
            function (err, res) {
                if (!err) {
                    responded = true;
                    res.url = url;
                    mainUrl = res.url;
                    host = res.host;
                    title = getTitle(res);
                    description = getDescription(res);
                    playerOrImageUrl = getPlayerOrImageUrl(res);
                    if (playerOrImageUrl.type === "file") {
                        probe(playerOrImageUrl.mainUrl, {timeout: 1000}).then(function (result) {
                            playerOrImageUrl.size = result;
                            let linkData = {
                                mainUrl: mainUrl,
                                host: host,
                                title: title,
                                description: description,
                                playerOrImageUrl: playerOrImageUrl
                            };
                            let linkDataQ = "update `im_message` set `link`=" + mysqlCon.escape(mainUrl) + ",`linkData`=" + mysqlCon.escape(JSON.stringify(linkData)) + " where m_id=" + data.message.m_id;
                            db(mysqlCon, linkDataQ, function (res, err) {
                                if (err) {
                                    console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "Message link data update failed");
                                    callback(messageWithOutLink(data));
                                }
                                else {
                                    console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "Message link data update Success");

                                    callback(messageWithLink(data, mainUrl, linkData));
                                }
                            });
                        }).catch(function (e) {
                            console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "image size fetch failed");
                        });


                    } else {
                        let linkData = {
                            mainUrl: mainUrl,
                            host: host,
                            title: title,
                            description: description,
                            playerOrImageUrl: playerOrImageUrl
                        };
                        let linkDataQ = "update `im_message` set `link`=" + mysqlCon.escape(mainUrl) + ",`linkData`=" + mysqlCon.escape(JSON.stringify(linkData)) + " where m_id=" + data.message.m_id;
                        db(mysqlCon, linkDataQ, function (res, err) {
                            if (err) {
                                console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "Message link data update failed");
                                callback(messageWithOutLink(data));
                            }
                            else {
                                console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "Message link data update Success");

                                callback(messageWithLink(data, mainUrl, linkData));
                            }
                        });
                    }
                } else if (!responded) {
                    responded = true;
                    console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "Message link fetch failed " + err);
                    callback(messageWithOutLink(data));
                }

            });
    } else {

        callback(messageWithOutLink(data));
    }

}

function hasUrl(message) {
    let surl = getUrl(message);
    let urlArray = Array.from(surl);
    return urlArray.length > 0;
}

function getFirstUrl(message) {
    let surl = getUrl(message, {stripWWW: false});
    let urlArray = Array.from(surl);
    return urlArray[0];

}

function getTitle(res) {
    let mainTitle = null;
    if (res.ogTitle !== undefined) {
        mainTitle = res.ogTitle;
    } else if (res.twitterTitle !== undefined) {
        mainTitle = res.twitterTitle;
    } else if (res.title !== undefined) {
        mainTitle = res.title;
    } else {
        mainTitle = res.host;
    }
    // return mainTitle;
    return mainTitle.replace(/[\n\r]+/g, '').replace(/\s{2,10}/g, ' ').trim();
}

function getDescription(res) {
    let description = null;
    if (res.ogDescription !== undefined) {
        description = res.ogDescription;
    } else if (res.twitterDescription !== undefined) {
        description = res.twitterDescription;
    } else if (res.description !== undefined) {
        description = res.description;
    } else {
        description = ''
    }

    return description.replace(/[\n\r]+/g, '').replace(/\s{2,10}/g, ' ').trim();

}

function getPlayerOrImageUrl(res) {
    let url = {url: null, type: null, size: null, mainUrl: null};
    /* if (res.twitterPlayer !== undefined) {     // for iframe video player
         url.url = res.twitterPlayer;
         url.type = 'player';
     } else if (res.ogVideoUrl !== undefined) {
         url.url = res.ogVideoUrl;
         url.type = 'player';
     } else*/
    if (res.twitterImage !== undefined) {
        url.url = imageUrlFormat(res.twitterImage);
        url.type = 'image';
        url.mainUrl = res.twitterImage;
    } else if (res.ogImage !== undefined) {
        url.url = imageUrlFormat(res.ogImage);
        url.type = 'image';
        url.mainUrl = res.ogImage;
    } else if (res.file !== undefined) {
        if (res.file.mime === 'image/jpeg' || res.file.mime === 'image/jpg' || res.file.mime === 'image/png') {
            url.url = imageUrlFormat(res.url);
            url.type = 'file';
            url.mainUrl = res.url;
        }
        if (res.file.mime === 'image/gif') {
            url.url = imageUrlFormat(res.url);
            url.type = 'file';
            url.mainUrl = res.url;
        }
    }
    return url;
}

function imageUrlFormat(imageUrl) {
    return group.getHost() + "image?u=" + encodeURIComponent(imageUrl);
    //return imageUrl;
}

function messageWithLink(data, mainUrl, linkData) {
    return {
        "to": data.to,
        "message": {
            "m_id": data.message.m_id,
            "message": data.message.message,
            "type": data.message.type,
            "fileName": data.message.fileName,
            "receiver_type": data.message.receiver_type,
            "date": data.message.date,
            "time": data.message.time,
            "poster": data.message.poster,
            // "date_time": data.message.date_time,
            "link": mainUrl,
            "linkData": JSON.stringify(linkData),
            "ios_date_time": data.message.ios_date_time

        },
        "sender": {
            "userId": data.sender.userId,
            "firstName": data.sender.firstName,
            "lastName": data.sender.lastName,
            "userEmail": data.sender.userEmail,
            "userStatus": data.sender.userStatus,
            "profilePictureUrl": data.sender.profilePictureUrl,
            "active": data.sender.active
        }

    };
}

function messageWithOutLink(data) {
    return {
        "to": data.to,
        "message": {
            "m_id": data.message.m_id,
            "message": data.message.message,
            "type": data.message.type,
            "fileName": data.message.fileName,
            "receiver_type": data.message.receiver_type,
            "date": data.message.date,
            "time": data.message.time,
            "poster": data.message.poster,
            // "date_time": data.message.date_time,
            "link": null,
            "linkData": null,
            "ios_date_time": data.message.ios_date_time

        },
        "sender": {
            "userId": data.sender.userId,
            "firstName": data.sender.firstName,
            "lastName": data.sender.lastName,
            "userEmail": data.sender.userEmail,
            "userStatus": data.sender.userStatus,
            "profilePictureUrl": data.sender.profilePictureUrl,
            "active": data.sender.active
        }

    };
}

async function isValidToken(token, callback) {
    if (!serverConf.ID_LOGIN) {
        try {
            let userSecret = jwt.decode(token, CONSUMER_SECRET).consumerKey;
            let query = "select `userId` from `users` where `userSecret`=?";
            let [res, f] = await mysqlCon2.execute(query, [userSecret]);
            if (res.length === 0) {
                callback(false);
            }
            else {
                callback(true);
            }
        } catch (err) {
            console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + err);
            callback(false);
        }
    }
    else {
        callback(true);
    }

}

function DeleteSocket(socketId) {
    let findUserIdBySocketId = "select DISTINCT userId from `im_usersocket` WHERE socketId='" + socketId + "'";
    db(mysqlCon, findUserIdBySocketId, function (result, err) {
        if (err) {
            console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "userId fetch failed");
        } else {
            if (result.length > 0) {
                let deleteSocketIdQ = "DELETE FROM `im_usersocket` WHERE  socketId='" + socketId + "'";
                db(mysqlCon, deleteSocketIdQ, function (res, err) {
                    if (err) {
                        console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "socket id delete failed");
                    }
                    else {
                        console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "socket id delete success");
                        deactivateUser(result[0].userId);
                    }
                });
            }

        }
    });

}

// Make user online
function activeUser(userId) {
    let updateActiveQuery = "UPDATE `users` SET `active` = 1 WHERE `users`.`userId` = " + userId;
    db(mysqlCon, updateActiveQuery, function (res, err) {
        if (err) {
            console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "socket user active insert failed");

        } else {

            let selectAllSocketQuery = "select userId, socketId from im_usersocket where userId <>" + userId;
            // friendsSocketQuery for friend list only. replace it with selectAllSocketQuery if you want friendlist based system
            let friendsSocketQuery = "SELECT DISTINCT ims.userId, ims.socketId FROM im_usersocket ims INNER JOIN friend_list fl1 on fl1.userId=ims.userId AND fl1.friendId=" + userId + " WHERE ims.userId<>" + userId;
            db(mysqlCon, selectAllSocketQuery, async function (res, err) {
                if (err) {
                    console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "user socket id fetch failed");
                }
                else {
                    let activeFriendsId = [];
                    if (res.length > 0) {
                        try {
                            let data = {
                                userId: userId,
                                status: 1,
                                userInfo: await group.get_user(parseInt(userId)),
                            };
                            for (let i = 0; i < res.length; i++) {
                                activeFriendsId.push({
                                    userId: res[i].userId,
                                    userInfo: await group.get_user(parseInt(res[i].userId)),
                                });

                                users[res[i].socketId].emit("updateStatus", data);
                                console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "socket user status activated");

                            }
                        } catch (err) {
                            console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + err);
                        }

                        let selectUserSocketQuery = "select socketId from im_usersocket where userId=" + userId;
                        db(mysqlCon, selectUserSocketQuery, function (res, err) {
                            if (err) {
                                console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "user socket id fetch failed");
                            }
                            else {
                                for (let i = 0; i < res.length; i++) {
                                    let data = {
                                        friendsIds: _.uniqWith(activeFriendsId, _.isEqual),
                                        status: 1
                                    };
                                    try {
                                        users[res[i].socketId].emit("updateStatusOnReconnect", data);
                                    } catch (err) {
                                        console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + err);
                                    }
                                }
                            }
                        });
                    }
                }
            });


        }
    });

}

// Make user offline
function deactivateUser(userId) {

    let findUserId = "select socketId from `im_usersocket` WHERE userId=" + userId;
    db(mysqlCon, findUserId, function (res, err) {
        if (err) {
            console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "user id deactivation failed");
        }
        else {
            if (res.length === 0) {
                let updateActiveQuery = "UPDATE `users` SET `active` = 0 WHERE `users`.`userId` = " + userId;
                db(mysqlCon, updateActiveQuery, function (res, err) {
                    if (err) {
                        console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "socket user active insert failed");

                    } else {
                        let selectAllSocketQuery = "select socketId from im_usersocket where userId <>" + userId;
                        // for friend list only
                        let friendsSocketQuery = "SELECT DISTINCT ims.userId, ims.socketId FROM im_usersocket ims INNER JOIN friend_list fl1 on fl1.userId=ims.userId AND fl1.friendId=" + userId + " WHERE ims.userId<>" + userId;
                        db(mysqlCon, selectAllSocketQuery, function (res, err) {
                            if (err) {
                                console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "user socket id fetch failed");
                            }
                            else {
                                if (res.length > 0) {
                                    let data = {
                                        userId: userId,
                                        status: 0
                                    };
                                    for (let i = 0; i < res.length; i++) {

                                        try {
                                            users[res[i].socketId].emit("updateStatus", data);
                                            console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + "socket user status deactivate");
                                        } catch (err) {
                                            console.log("[ " + moment().format('MMMM Do YYYY, hh:mm:ss') + " ] " + err);
                                        }
                                    }
                                }
                            }
                        });

                    }
                });
            }
        }
    });


}