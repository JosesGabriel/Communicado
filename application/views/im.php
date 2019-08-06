<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
    <style>
    <?php if (isset($_GET['b'])) {
    $getrand = $_GET['b'];
    $get_bgfimage = 'loginbg'.$getrand.'.jpg'; ?>
        html {background: url("<?php echo $homeurlgen; ?>/images/<?php echo $get_bgfimage; ?>") 50% 0 no-repeat #2c3e50 fixed;background-size: cover;}
    <?php alert($homeurlgen);
} ?>
    html {margin-top: 0 !important;}
    #wpadminbar {
        display: none !important;
        z-index: -1 !important;
    }
    #preloader {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #0d1f33;
        z-index: 999999;
        /* height: 100%; */
        /* overflow: hidden; */
    }
    #status {
        width: 50px;
        height: 50px;
        position: absolute;
        left: 50%;
        top: 35%;
        background-image: url(<?php echo $homeurlgen; ?>/images/arb_preloader.svg);
        background-size:50px;
        background-repeat: no-repeat;
        background-position: center;
        margin: -25px 0 0 -25px;
    }
    #status_txt {
        width:100%;
        position: absolute;
        top:50%;
        left:0;
        z-index:99;
        color:#fff;
        text-align:center;
        font-size:11px;
    }
    .page-template-template-login a:hover {
        color:#FFFFFF;
        text-decoration: underline;
    }
    body, #page-container {background-color: transparent !important;}
    span.um-field-checkbox-option {
        display: none;
    }
    </style>
<link href="https://arbitrage.ph/assets/css/preloader.css" rel="stylesheet">
<script
  src="https://code.jquery.com/jquery-3.4.1.js"
  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
  crossorigin="anonymous"></script>
    <script language="javascript">
    
        jQuery(window).on('load', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const token = urlParams.get('token');
            if(token) {
                $('#inviteLinkValidator').click();
            }
            jQuery("#status, #status_txt").fadeOut();
            jQuery("#preloader").delay(300).fadeOut("fast");
        })
    </script>
    <div id="preloader">
        <div id="status">&nbsp;</div>
        <div id="status_txt"></div>
    </div>

<section class="page-contents">
        <input type="hidden" id="inviteLinkValidator">
        <!-- START LEFT SECTION -->
        <div class="leftSection col-xl-3 col-md-3 col-sm-12 col-xs-12" style="padding: 0;">
            
            <!-- profile section-->
            <div class="col-md-12 profile_container">
                <span class="prof_image_container"><img src="" alt="" class="prof_image" /></span>
                <span class="prof_name"></span>
            </div>
            <!-- chat header start -->
            <div class="chat-search col-md-12" id="convStart">
 
            <input type="text" id="searchGroupInput">
                <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
                
                <!--
                <textarea style="max-height: 100px; height: 90px border: 0"  id="newMessageText" type="text" name="message" class="form-control" placeholder="Your message....."></textarea>
                -->
                <!-- 
                <div style="display:none;" class=" col-md-2 col-sm-2 col-xs-2" id="unreadMessage" title="Unread Messages">
                    <div class="col-md-12" style="padding: 0;font-size: 25px;font-weight: bold">
                        <span class="" style="padding: 0;cursor: pointer;">
                            <i class="ico-pending-message" style="color: #388ded" ></i>
                        </span>
                    </div>
                </div>
                -->
                
                <!--
                <div class=" col-md-10 col-sm-10 col-xs-10" id="" style="padding: 6px 0 0 5px;text-align: left;">
                    <div style="padding: 0;font-size: 16px;font-weight: bold">Vyndue Messenger</div>
               </div>
               -->
                
                <!--
                <div class=" col-md-2 col-sm-2 col-xs-2" id="newMessage" title="New Message" style="padding: 0;text-align: right;">
                    <div class="col-md-12" style="padding: 0;font-size: 25px;font-weight: bold">
                        <span class="" style="padding: 0;cursor: pointer;">
                                <i class="ico-new-message" style="color: #388ded" ></i>
                        </span>
                    </div>
                </div>-->
               
            </div>
            <!-- chat header end -->
            <div class="notif-cont col-md-12">
                <div id="vyndue-floatBtn-container_3">   
                    <div title="New Message" id="newMessage" class="floatBtn-Wrapper">
                        <i class="fas fa-envelope" aria-hidden="true"><br><span>New Message</span></i>
                    </div>
                </div>
                <div id="vyndue-floatBtn-container_1">
                    <div title="Communities" id="btnCommunities" class="floatBtn-Wrapper">
                        <i class="fa fa-users" aria-hidden="true"><br><span>Communities</span></i>
                        
                    </div>
                </div>
                <div id="vyndue-floatBtn-container_2">
                    <div title="Notifications" id="btnNotifications" class="floatBtn-Wrapper">
                        <i class="fa fa-bell" aria-hidden="true"><span class="badgenotification"></span><br><span>Notifications</span></i>
                        
                    </div>
                </div>
                <div style="display:none;" id="vyndue-floatBtn-container_4">
                    <div title="Settings" id="btnSettings" class="floatBtn-Wrapper">
                        <i class="fa fa-gear" aria-hidden="true"><br><span>Settings</span></i>
                        
                    </div>
                </div>
                <hr class="style14 style11">
            </div>
            
            <div style="float:left; width: 100%" id="groupDiv">
                <ul class="persons" id="groups"></ul>
            </div>
        </div>
        <!-- END LEFT SECTION -->
        <div class="middleSection col-md-9 col-sm-12 col-xs-12" style="padding: 0;"  id="dropZone">
           <div class="chat-search col-md-12 groupNameDiv" style="text-align: left; padding-bottom: 21px;">
               <div class="col-md-11">
                    <div class="sel-left">
                        <div class="imgselecteds ">
                            
                        </div>
                    </div>
                    <div class="sel-right">
                        <span class="UserNames group-name group-name-style text-center">&nbsp;</span><br>
                        <span class="numbermember">&nbsp;</span>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="lefty">
                        <div id="nav-icon1">
                          <span></span>
                          <span></span>
                          <span></span>
                        </div>
                    </div>
                </div>
           </div>

            <div class="chat col-md-12 col-xl-12 col-sm-12 col-xs-12 " style="overflow: scroll;overflow-x: hidden;" id="chatBox" ><div class="container"></div></div>
            <form id="messageForm">
                <div class="form-group col-md-12 col-xl-10 col-sm-10 col-xs-8 " style="" >
                    <div class="row kosaks">
                        <div class="col-md-12">
                            <div id="divMentionDiv">
                                <input type="text" id="inputMentionSearch">
                            </div>
                         
                            <textarea style="max-height: 50px; border: 0"  id="message" type="text" name="message" class="form-control" placeholder="Type your message here..."></textarea>    
                        
                            <div class="form-group pad-1" style="margin-top: 10px">
                                <div class="tolft-cont">
                                    <!-- <img style="cursor: pointer; margin-left: 10px;width: 25px;height: 25px"> -->
                                    <i class="mida" id="sendMessage" title="Send Message">
                                        <img src="https://arbitrage.ph/svg/paper-plane.svg">
                                    </i>
                                    <!-- <img style="float:left;cursor: pointer; width: 25px;height: 22px;margin-left: 0px;"> -->
                                    <i class="mida" id="fileIV1" title="Send File/Audio">
                                        <img src="https://arbitrage.ph/svg/clip.svg">
                                    </i>
                                    <!-- <img style="float:left;cursor: pointer; width: 25px;height: 25px;margin-left: 10px;"> -->
                                    <i class="mida" id="fileIV" title="Send Picture/Video">
                                        <img src="https://arbitrage.ph/svg/gallery.svg">
                                    </i>

                                   <!--  <i class="mida far fa-smile emoji emoji_header" id="message_icon_picker" title="Select Emoji"></i> -->

                                    <input type="file" class="hidden" id="messageFile1" name="documents" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.csv,.txt,.text,.mp3,.mp4,.wma,.rar,.zip">
                                    <input type="file" class="hidden" id="messageFile" name="pictureVideo" accept=".3gpp,.mp4,.3gp,.png,.jpeg,.jpg">
                                    <!--<i id="sendMessage" class="fa fa-send fa-2x pad-5" style="color: #82d6d5;cursor: pointer; margin-left: 10px;width: 25px;height: 25px"></i>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="col-md-12 col-xl-12 col-sm-12 col-xs-12 text-center pad-20 hidden" id="blockmessage" >You cannot reply to this conversation.</div>
        </div>
        <div class="rightSection col-xl-3 col-md-3 col-sm-12 col-xs-12 persons2 " style="padding: 0;border-left: none;border-top: 1px solid rgba(0, 0, 0, .10); text-overflow: ellipsis;overflow-x: hidden;overflow-y: hidden;background: #0d2539;z-index: 99;" id="rightSection">
            <div class="groupInfoContent">

            <div class="selTitleUpper col-md-12">

            </div>
            <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12 text-center pad-10" style="display:none">
                <div class="be-use-name group-name" ></div>
            </div>
            <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12 text-center pad-2 rightBorder" style="padding-bottom: 5px; display:none" >
                <div class="preview be-user-info" style="font-size: 10px; padding-bottom:5px;border-bottom:1px solid rgba(0, 0, 0, .10) "></div>
            </div>
            <div class="col-md-12">
                <!-- <div class="settingname" >Settings</div> -->
                <hr class="style14 style12">
                <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12  pad-5 hidden optionHubar" id="editGroupName">
                    <div class="pad-5" id="changecomm"  style="cursor: pointer;color: #75aef3;padding-right: 0;"> 
                    <!-- <i class="fa fa-pencil"></i> -->
                    Change Community Name</div>
                </div>
                <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12  pad-5 hidden optionHubar" id="changeGroupImage">
                     <div class="pad-5" id="editcomm"  style="cursor: pointer;color: #75aef3;padding-right: 0;"> 
                     <!-- <i class="fa fa-image"></i> -->
                     Edit Community Thumbnail</div>
                 </div>
                 <input type="file" class="hidden" id="groupImageFile" name="documents" accept=".jpg,.jpeg,.png">
            
                 <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12  pad-5 hidden optionHubar" id="communityModerator">
                    <div class="pad-5" id="commmod" style="cursor: pointer;color: #75aef3;padding-right: 0;"> 
                    Community Moderators</div>
                </div>
                
                <div class="col-md-6 col-xl-6 col-xs-12 col-sm-12  pad-5 hidden optionHubar" id="addMember" data-group="">
                    <div class="pad-5" id="plusmember" style="cursor: pointer;color: #75aef3;padding-right: 0;">
                    <!-- <i class="fa fa-plus"></i> -->
                    Add People</div>
                </div>
                <div class="col-md-6 col-xl-6 col-xs-12 col-sm-12  pad-5 hidden optionHubar" id="joinRequest" data-group="">
                    <div class="pad-5" id="joinrequest" style="cursor: pointer;color: #75aef3;padding-right: 0;">
                    <!-- <i class="fa fa-user-plus"></i> -->
                    Join Request</div>
                </div>
                <div class="col-md-6 col-xl-6 col-xs-12 col-sm-12  pad-5 hidden optionHubar" id="blockOptions"  >
                    <div class="pad-5 hidden" id="block" style="cursor: pointer;color: #75aef3;padding-right: 0;">
                    <!-- <i class="fa  fa-toggle-off"></i> -->
                    Block</div>
                    <div class="pad-5 hidden" id="unblock" style="cursor: pointer;color: #75aef3;padding-right: 0;">
                    <!-- <i class="fa fa-toggle-on"></i> -->
                    Unblock</div>
                </div>
                <div class="col-md-6 col-xl-6 col-xs-12 col-sm-12  pad-5 hidden optionHubar hdmpls" id="leaveGroup">
                    <div class="pad-5 leavebtn"  style="cursor: pointer;color: #75aef3;padding-right: 0;">
                    <!-- <i class="fas fa-sign-out-alt"></i> -->
                    <span class="x1x2-3">Leave Group</span>
                    </div>
                </div>
                <div class="col-md-6 col-xl-6 col-xs-12 col-sm-12  pad-5 optionHubar hdmpls" id="muteOptions" >
                    <div class="pad-5 hidden righty" id="mute" style="cursor: pointer;color: #fffffe;padding-right: 0;">
                        <!-- <i class="fas fa-bell-slash m5sit"></i> -->
                        <span class="x1x2-2">Mute</span>
                    </div>
                    <div class="pad-5 hidden hdmpls" id="unmute" style="cursor: pointer;color: #fffffe;padding-right: 0;">
                    <!-- <i class="fas fa-bell m5sit"></i> -->
                    <span class="x1x2-1">Unmute</span></div>
                </div>
                <div class="col-md-6 col-xl-6 col-xs-12 col-sm-12 pad-5 optionHubar hdmpls" id="inviteLinkBtn" >
                    <div class="pad-5 hdmpls righty" id="inviteLink" style="cursor: pointer;color: #fffffe;padding-right: 0;">
                        <!-- <i class="fas fa-bell m5sit"></i> -->
                        <span class="x1x2-2">Invitation Link</span>
                    </div>
                </div>
            </div>
            <ul class="persons personsList" id="groupMembers" >
                
            </ul>
            <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12 hidden" id="attachment">
                <div class="pad10bgradius">
                    <div class="sectionName text-center">Shared Files<div id='nav-icon3'><span></span><span></span><span></span></div></div>
                    <ul class="attachment" id="attachmentList" ></ul>
                </div>
            </div>
            <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12 hidden" id="imageAttachment">
                <div class="pad10bgradius">
                    <div class="sectionName text-center" >Shared Images<div id='nav-icon3-c'><span></span><span></span><span></span></div></div>
                    <div class="row ol-lightbox-gallery" style="list-style: none;padding: 0;" id="ImageAttachmentList" >
                    </div>
                </div>
            </div>
            <!--<div class="col-md-12 col-xl-12 col-xs-12 col-sm-12 text-center pad-2 rightBorder" style="padding-bottom: 5px" >
                <div class="preview be-user-info" style="font-size: 10px; padding-bottom:5px;border-bottom:1px solid rgba(0, 0, 0, .10) "></div>
            </div>-->
            <!-- <div class='Menuselupper'><div id='nav-icon3-a'><span></span><span></span><span></span></div></div> -->



            </div>
        <div class="xcvz"></div>
        </div>

        <!--
        <div class=" col-md-2 col-sm-2 col-xs-2" id="newMessage" title="New Message" style="padding: 0;text-align: right;">
            <div class="col-md-12" style="padding: 0;font-size: 25px;font-weight: bold">
                <span class="" style="padding: 0;cursor: pointer;">
                        <i class="ico-new-message" style="color: #388ded" ></i>
                </span>
            </div>
        </div>-->
<!-- 
        <div title="Get Messages" id="unreadMessage" class="floatBtn-Wrapper">
                <i class="fa fa-refresh" aria-hidden="true"></i>
                <span>Get Messages</span>
            </div> -->
        
</section>


<div id="modalCommunities" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" class="modal fade in" style="display: none;padding-right: 17px;" data-backdrop="static" data-keyboard="false">
    <div role="document" class="modal-dialog" style="width:600px !important;">
        <div class="modal-content" >
            <div class="modal-header" style="padding-bottom: 0 !important;">
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="fas fa-times"></i></span></button>
                <h4 class="modal-title myUpdateModalLabel" style="background-color: #75aef3">  <i class="fa fa-users" aria-hidden="true"></i> Communities</h4>
                <div class="modal-body">
                <i class="fas fa-search ml-search"></i>
                <input type="text" class="form-control" id="findCommunity" placeholder="Search Community">
                <div id="communityBox" class="list-group">
                    <h4>Community box is empty.</h4>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modalNotifications" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" class="modal fade in" style="display: none;padding-right: 17px;" data-backdrop="static" data-keyboard="false">
    <div role="document" class="modal-dialog" style="width:500px !important;">
        <div class="modal-content" >
            <div class="modal-header" style="padding-bottom: 0 !important;">
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="fas fa-times"></i></span></button>
                <h4 class="modal-title myUpdateModalLabel" style="background-color: #75aef3">  <i class="fa fa-bullhorn" aria-hidden="true"></i> Notifications</h4>
                <div class="modal-body">
                    <div id="notificationBox" class="list-group">
                        <i class="far fa-meh-blank"></i>
                        <h4>Notification box is empty.</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modalCommunityModerator" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" class="modal fade in" style="display: none;padding-right: 17px;" data-backdrop="static" data-keyboard="false">
    <div role="document" class="modal-dialog" style="width:500px !important;">
        <div class="modal-content" >
            <div class="modal-header" style="padding-bottom: 0 !important;">
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="fas fa-times"></i></span></button>
                <h4 class="modal-title myUpdateModalLabel" style="background-color: #75aef3">  <i class="fa fa-balance-scale" aria-hidden="true"></i> Community Moderators</h4>
                <div class="modal-body">
                    <div id="communitymoderatorBox" class="list-group">
                        <h4>Community Moderator box is empty.</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modalJoinRequest" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" class="modal fade in" style="display: none;padding-right: 17px;" data-backdrop="static" data-keyboard="false">
    <div role="document" class="modal-dialog" style="width:500px !important;">
        <div class="modal-content" >
            <div class="modal-header" style="padding-bottom: 0 !important;">
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="fas fa-times"></i></span></button>
                <h4 class="modal-title myUpdateModalLabel" style="background-color: #75aef3">  <i class="fa fa-user-plus" aria-hidden="true"></i> Join Request</h4>
                <div class="modal-body">
                    <div id="joinrequestBox" class="list-group">
                        <h4>Join Request box is empty.</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="addNewMemberModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" class="modal fade in" style="display: none;padding-right: 17px;">
    <div role="document" class="modal-dialog">
        <div class="modal-content" >
            <div class="modal-header">
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="fas fa-times"></i></span></button>
                <h4 class="modal-title myUpdateModalLabel" style="background-color: #75aef3"><i class="fas fa-user-plus"></i> Add People</h4>
                <div class="modal-body" >
                    <p>Search people by there name</p>
                    <div class="form-group">
                        <input type="text" id="addNewMemberInput" multiple class="form-control" >
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-small btn-round btn-skin-green"  data-toggle="modal" id="newMemberAddBtn"><i class="fas fa-plus"></i>Add</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="generateInviteLinkModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" class="modal fade in" style="display: none;padding-right: 17px;">
    <div role="document" class="modal-dialog">
        <div class="modal-content" >
            <div class="modal-header">
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="fas fa-times"></i></span></button>
                <h4 class="modal-title myUpdateModalLabel" style="background-color: #75aef3"><i class="fas fa-user-plus"></i> Invite People</h4>
                <div class="modal-body" >
                    <p>Copy the link below to invite a new member to your private community.</p>
                    <div class="flex">
                        <input type="text" id="invitationLink" multiple class="invitationLinkBox form-control" readonly>
                        <input type="button" value="Copy Link" class="invitationLinkCopyBtn" id="invitationLinkCopyBtn">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="changeNameModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" class="modal fade in" style="display: none;padding-right: 17px;">
    <div role="document" class="modal-dialog">
        <div class="modal-content" >
            <div class="modal-header">
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="fas fa-times"></i></span></button>
                <h4 class="modal-title myUpdateModalLabel" style="background-color: #75aef3"><i class="fas fa-pen-square"></i> Change Community Name</h4>
                <div class="modal-body" >
                    <p>Give a new name</p>
                    <div class="form-group">
                        <input type="text" id="groupName" class="form-control" placeholder="Community Name" required="required">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-small btn-round btn-skin-green"  data-toggle="modal" id="changeNameBtn"><i class="fas fa-save"></i>Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="newMessageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" class="modal fade in" style="display: none;padding-right: 17px;" data-backdrop="static" data-keyboard="false">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="border-radius: 6px;">
                <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                    <span aria-hidden="true"><i class="fas fa-times"></i></span>
                </button>
                <h4 id="myModalLabel" class="modal-title" style="background-color: #75aef3">
                    <i class="fas fa-envelope" aria-hidden="true"></i> New Message
                </h4>
                <div class="modal-body " id="newMModalBody" style="">
                    <form id="newMessageForm" role="form">
                        <div class="form-group m-bottom-20">
                            <input type="text" id="addMemberInput" class="form-control" />
                            <i class="fas fa-search"></i>
                        </div>
                        <div class="form-group m-bottom-20" style="height: 90px" >
                            <textarea style="max-height: 100px; height: 90px border: 0"  id="newMessageText" type="text" name="message" class="form-control" placeholder="Your message....."></textarea>
                        </div>
                        <!--<div class="form-group col-md-2 col-xl-2 col-sm-2 col-xs-2 pad-1 m-bottom-20 " style="margin-top: 10px;">
                            <img src="<?php /*echo base_url('assets/img/i-camera.png')*/?>" id="newMessagefileIV"  style="float:left;cursor: pointer; width: 50px;height: 50px">
                            <input type="file" class="hidden" id="newMessageFile" name="file" accept="video/3gpp,video/mp4,video/3gp,image/x-png,image/jpeg">
                        </div>-->
                        <div class="form-group notomrginbtm col-md-offset-3 col-md-9">
                            <a href="#" class="btn-primary btn-small btn-rounded btn-skin-green" id="newSendMessage"><i class="fa fa-send"></i>  Send</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="connectionErrorModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" class="modal fade in" style="display: none;padding-right: 17px;">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="border-radius: 6px;">
                <!--<button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="oli oli-delete_sign"></i></span></button>-->
                <h4 id="myModalLabel" class="modal-title" style="background-color: #bc0200">
                    <span class="fa-stack">
                        <i class="fa fa-wifi fa-stack-1x"></i>
                        <i class="fa fa-ban fa-stack-2x"></i>
                    </span>
                    Connection Lost
                </h4>
                <div class="modal-body" style="text-align:center" >
                    <p>Connecting...</p>
                    <p><i class="fa fa-spinner fa-spin fa-4x fa-fw" aria-hidden="true"></i></p>
                    <br />
                </div>
            </div>
        </div>
    </div>
</div>
