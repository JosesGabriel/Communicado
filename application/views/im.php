<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<section class="page-contents">
        <!-- START LEFT SECTION -->
        <div class="leftSection col-xl-3 col-md-3 col-sm-12 col-xs-12" style="padding: 0;">
            
            <!-- chat header start -->
            <div class="chat-search col-md-12" id="convStart">
 
            <input type="text" id="searchGroupInput">
                

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
            
            <div style="float:left; width: 100%" id="groupDiv">
                <ul class="persons" id="groups"></ul>
            </div>
        </div>
        <!-- END LEFT SECTION -->
        <div class="middleSection col-xl-6 col-md-6 col-sm-12 col-xs-12" style="padding: 0;border-left: 1px solid rgba(0, 0, 0, .10)"  id="dropZone">
           <div class="chat-search col-md-12 groupNameDiv" style="text-align: left; padding-bottom: 21px;">
           
               <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
                    <span class="UserNames group-name group-name-style text-center">&nbsp;</span>
               </div
               >
           </div>
            <div class="chat col-md-12 col-xl-12 col-sm-12 col-xs-12 " style="overflow: scroll;overflow-x: hidden;" id="chatBox" ></div>
            <form id="messageForm">
                 <div class="form-group col-md-10 col-xl-10 col-sm-10 col-xs-8 " style="padding-top: 5px;padding-right: 5px" >
                 <div id="divMentionDiv">
                        <input type="text" id="inputMentionSearch">
                </div>  
                 <textarea style="max-height: 50px; border: 0"  id="message" type="text" name="message" class="form-control" placeholder="Your message..."></textarea>    
                </div>
                <div class="form-group col-md-2 col-xl-2 col-sm-2 col-xs-4 pad-1" style="margin-top: 10px">
                    <img title="Send File/Audio" src="<?php echo base_url('assets/img/fileAttach.png')?>" id="fileIV1" style="float:left;cursor: pointer; width: 25px;height: 22px;margin-left: 0px;">
                    <img title="Send Picture/Video" src="<?php echo base_url('assets/img/cam.png')?>" id="fileIV" style="float:left;cursor: pointer; width: 25px;height: 25px;margin-left: 10px;">
                    <input type="file" class="hidden" id="messageFile1" name="documents" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.csv,.txt,.text,.mp3,.mp4,.wma,.rar,.zip">
                    <input type="file" class="hidden" id="messageFile" name="pictureVideo" accept=".3gpp,.mp4,.3gp,.png,.jpeg,.jpg">
                    <!--<i id="sendMessage" class="fa fa-send fa-2x pad-5" style="color: #82d6d5;cursor: pointer; margin-left: 10px;width: 25px;height: 25px"></i>-->
                    <img title="Send Message" src="<?php echo base_url('assets/img/pp.png')?>" id="sendMessage" style="cursor: pointer; margin-left: 10px;width: 25px;height: 25px">
                </div>
            </form>
            <div class="col-md-12 col-xl-12 col-sm-12 col-xs-12 text-center pad-20 hidden" id="blockmessage" >You cannot reply to this conversation.</div>
        </div>
        <div class="rightSection col-xl-3 col-md-3 col-sm-12 col-xs-12 persons2 " style="padding: 0;border-left: 1px solid rgba(0, 0, 0, .10);border-top: 1px solid rgba(0, 0, 0, .10); text-overflow: ellipsis;overflow-x: hidden;overflow-y: hidden " id="rightSection">
            <div class="groupInfoContent">
            <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12 text-center pad-10" style="display:none">
                <div class="be-use-name group-name" ></div>
            </div>
            <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12 text-center pad-2 rightBorder" style="padding-bottom: 5px; display:none" >
                <div class="preview be-user-info" style="font-size: 10px; padding-bottom:5px;border-bottom:1px solid rgba(0, 0, 0, .10) "></div>
            </div>
            <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12  pad-5 hidden optionHubar" id="editGroupName">
                <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12 pad-5"  style="cursor: pointer;color: #75aef3;padding-right: 0;"> 
                <i class="fa fa-pencil"></i>Change Community Name</div>
            </div>
            <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12  pad-5 hidden optionHubar" id="changeGroupImage">
                 <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12 pad-5"  style="cursor: pointer;color: #75aef3;padding-right: 0;"> 
                 <i class="fa fa-image"></i>Edit Community Thumbnail</div>
             </div>
             <input type="file" class="hidden" id="groupImageFile" name="documents" accept=".jpg,.jpeg,.png">
            <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12  pad-5 hidden optionHubar" id="addMember" data-group="">
                <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12 pad-5" style="cursor: pointer;color: #75aef3;padding-right: 0;">
                <i class="fa fa-plus"></i>Add People</div>
            </div>
            <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12  pad-5 hidden optionHubar" id="blockOptions"  >
                <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12 pad-5 hidden" id="block" style="cursor: pointer;color: #75aef3;padding-right: 0;">
                <i class="fa  fa-toggle-off"></i>Block</div>
                <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12 pad-5 hidden" id="unblock" style="cursor: pointer;color: #75aef3;padding-right: 0;">
                <i class="fa fa-toggle-on"></i>Unblock</div>
            </div>
            <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12  pad-5 hidden optionHubar" id="leaveGroup">
                <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12 pad-5"  style="cursor: pointer;color: #75aef3;padding-right: 0;">
                <i class="fa fa-sign-out"></i>Leave Group</div>
            </div>
            <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12  pad-5 optionHubar" id="muteOptions" >
                <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12 pad-5 hidden" id="mute" style="cursor: pointer;color: #75aef3;padding-right: 0;">
                <i class="fa fa-bell-slash"></i>Mute</div>
                <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12 pad-5 hidden" id="unmute" style="cursor: pointer;color: #75aef3;padding-right: 0;">
                <i class="fa fa-bell"></i>Unmute</div>
            </div>

            <!--<div class="col-md-12 col-xl-12 col-xs-12 col-sm-12 text-center pad-2 rightBorder" style="padding-bottom: 5px" >
                <div class="preview be-user-info" style="font-size: 10px; padding-bottom:5px;border-bottom:1px solid rgba(0, 0, 0, .10) "></div>
            </div>-->
            
            <ul class="persons personsList" id="groupMembers" ></ul>
            <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12 hidden" id="attachment">
                <div class="pad10bgradius">
                    <div class="sectionName text-center">Shared Files</div>
                    <ul class="attachment" id="attachmentList" ></ul>
                </div>
            </div>
            <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12 hidden" id="imageAttachment">
                <div class="pad10bgradius">
                    <div class="sectionName text-center" >Shared Images</div>
                    <div class="row ol-lightbox-gallery" style="list-style: none;padding: 0;" id="ImageAttachmentList" >
                    </div>
                </div>
            </div>
            </div>
        </div>

        <!--
        <div class=" col-md-2 col-sm-2 col-xs-2" id="newMessage" title="New Message" style="padding: 0;text-align: right;">
            <div class="col-md-12" style="padding: 0;font-size: 25px;font-weight: bold">
                <span class="" style="padding: 0;cursor: pointer;">
                        <i class="ico-new-message" style="color: #388ded" ></i>
                </span>
            </div>
        </div>-->

        <div id="vyndue-floatBtn-container_1">
            <div title="Compose new message" id="newMessage">
                <i class="ico-new-message"></i>
            </div>
        </div>

        <div id="vyndue-floatBtn-container_2">
            <div title="Get messages" id="unreadMessage">
                <i class="fa fa-refresh"></i>
            </div>
        </div>

        <div style="display:none;" id="vyndue-floatBtn-container_3">
            <div id="btnSettings">
                <i class="fa fa-gear"></i>
            </div>
        </div>
</section>


<!-- Modals -->
<div id="addNewMemberModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" class="modal fade in" style="display: none;padding-right: 17px;">
    <div role="document" class="modal-dialog">
        <div class="modal-content" >
            <div class="modal-header">
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="oli oli-delete_sign"></i></span></button>
                <h4 class="modal-title myUpdateModalLabel" style="background-color: #75aef3">Add new member </h4>
                <div class="modal-body" >
                    <p>Search members by there name</p>
                    <div class="form-group">
                        <input type="text" id="addNewMemberInput" multiple class="form-control" >
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-small btn-round btn-skin-green"  data-toggle="modal" id="new~rAddBtn">Add</button>
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
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="oli oli-delete_sign"></i></span></button>
                <h4 class="modal-title myUpdateModalLabel" style="background-color: #75aef3">Change name</h4>
                <div class="modal-body" >
                    <p>Give a new name</p>
                    <div class="form-group">
                        <input type="text" id="groupName" class="form-control" placeholder="Community Name" required="required">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-small btn-round btn-skin-green"  data-toggle="modal" id="changeNameBtn">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="newMessageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" class="modal fade in" style="display: none;padding-right: 17px;">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="border-radius: 6px;">
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="oli oli-delete_sign"></i></span></button>
                <h4 id="myModalLabel" class="modal-title" style="background-color: #75aef3">Start a new conversation</h4>
                <div class="modal-body " id="newMModalBody" style="margin-bottom: 110px">
                    <form id="newMessageForm" role="form">
                        <div class="form-group m-bottom-20">
                            <input type="text" id="addMemberInput" class="form-control" >
                        </div>
                        <div class="form-group col-md-12 col-xl-12 col-sm-12 col-xs-12 m-bottom-20" style="padding-top: 5px;padding-right: 5px; height: 90px" >
                            <textarea style="max-height: 100px; height: 90px border: 0"  id="newMessageText" type="text" name="message" class="form-control" placeholder="Your message....."></textarea>
                        </div>
                        <!--<div class="form-group col-md-2 col-xl-2 col-sm-2 col-xs-2 pad-1 m-bottom-20 " style="margin-top: 10px;">
                            <img src="<?php /*echo base_url('assets/img/i-camera.png')*/?>" id="newMessagefileIV"  style="float:left;cursor: pointer; width: 50px;height: 50px">
                            <input type="file" class="hidden" id="newMessageFile" name="file" accept="video/3gpp,video/mp4,video/3gp,image/x-png,image/jpeg">
                        </div>-->
                    </form>
                </div>
                <div class="modal-footer" style="background-color: white;">
                    <div class="form-group col-md-12 col-xl-12 col-sm-12 col-xs-12">
                        <a href="#" class="btn-primary btn-small btn-rounded btn-skin-green col-md-12 col-xl-12 col-sm-12 col-xs-12" id="newSendMessage"><i class="fa fa-send"></i>  Send</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="_connectionErrorModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" class="modal fade in" style="display: none;padding-right: 17px;">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="border-radius: 6px;">
                <!--<button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="oli oli-delete_sign"></i></span></button>-->
                <h4 id="myModalLabel" class="modal-title" style="background-color: #bc0200">Connection lost</h4>
                <div class="modal-body " >
                    <p>Connecting...</p>
                </div>
                <!--<div class="modal-footer" style="background-color: white;">
                    <div class="form-group col-md-12 col-xl-12 col-sm-12 col-xs-12">
                        <a href="#" class="btn-primary btn-small btn-rounded btn-skin-green col-md-12 col-xl-12 col-sm-12 col-xs-12" id="newSendMessage"><i class="fa fa-envelope"></i>  Send</a>
                    </div>
                </div>-->
            </div>
        </div>
    </div>
</div>