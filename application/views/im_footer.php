<script type="text/javascript" src="<?php echo base_url('assets/newTheme/assets/js/loadingoverlay.js'); ?>"></script>
<script type="text/javascript"
        src="<?php echo base_url('assets/newTheme/assets/js/loadingoverlay_progress.js'); ?>"></script>
<script src="<?php echo base_url('assets/newTheme/assets/js/si.js'); /* . "?" . rand(5, 50000);*/ ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/newTheme/assets/js/twemoji-picker.js'); ?>"></script>
<script type="text/javascript"
        src="<?php echo base_url('assets/newTheme/assets/js/mediaelement-and-player.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/newTheme/assets/js/perfect-scrollbar.jquery.min.js'); ?>"></script>
<!--<script type="text/javascript" src="<?php /*echo base_url("assets/newTheme/twemoji/2/twemoji.min.js")."?".rand(5,50000) */ ?>"></script>-->
<script src="<?php echo base_url('assets/newTheme/assets/js/twemoji/2/twemoji.min.js'); ?>"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
<!-- <script src="<?php /*echo base_url("assets/js/scripts/jwt-decode.min.js") */ ?>"></script> -->

<!--<script type="text/javascript" src="<?php /*echo base_url("assets/newTheme/assets/js/perfect-scrollbar.jquery.js")."?".rand(5,50000) */ ?>"></script>-->
<!--<script type="text/javascript" src="<?php /*echo base_url("assets/newTheme/assets/js/perfect-scrollbar.jquery.min.js") */ ?>"></script>-->

<script>

    // addEventListener support for IE8
    function bindEvent(element, eventName, eventHandler) {
        if (element.addEventListener) {
            element.addEventListener(eventName, eventHandler, false);
        } else if (element.attachEvent) {
            element.attachEvent('on' + eventName, eventHandler);
        }
    }
    // Send a message to the parent
    var sendMessage = function (msg) {
        //console.log('sending postmessage', msg)
        // Make sure you are sending a string, and to stringify JSON
        window.parent.postMessage(msg, '*');
    };

    var $ = jQuery
    $(document).ready(function () {
        //console.log('vyndue readyy')
        sendMessage({key: 'ready', data: {}});

        $(window).on('message', function (e) {
            var data = e.originalEvent.data;
            //console.log(window);
           // window.promptChat(data.data);
        });

        let t = null;
        let name = null;
        let pic = null;
        let tc = null;
        window.Vyndue_cKey = null;
        window.Vyndue_fname = null;
        window.Vyndue_picture = null;
        window.setInterval(function () {
            tc = localStorage.getItem("_r");
            if (tc === null || tc === "" || tc === '') {
                location.href = "<?php echo base_url('userview/logout'); ?>";
            }
            window.scrollTo(0, 0);
            if (String(localStorage.getItem("T")) == "token") {
                t = localStorage.getItem("_r");
                name = jwt_decode(t).firstName;
                pic = jwt_decode(t).profilePicture;
                window.Vyndue_cKey  = jwt_decode(t).consumerKey;
                window.Vyndue_fname  = jwt_decode(t).firstName;
                window.Vyndue_picture = pic;
            } else {
                t = JSON.parse(localStorage.getItem("_r"));
                name = t.firstName;
                pic = t.profilePicture;
                window.Vyndue_cKey = t.consumerKey
                window.Vyndue_fname  = t.firstname;
                window.Vyndue_picture = pic;
            }
            $("#userNameTop").html(name);
            $("#userImageTop").attr("src", pic);

            // set all mention link 
            let hrefAll = $('.fw-im-message-text').find('a[class="mention"]');
            $(hrefAll).each(function(){
                var href = "<?=ARBITRAGE.'/user/'; ?>" + $(this).attr('data-username')+"/";
                $(this).attr("href",href);
                $(this).attr("target","_blank");
            });
        });

        // console.log(jwt_decode(localStorage.getItem("_r")));
        // console.log(jwt_decode(localStorage.getItem("_r")));
        //console.log('profile picture');
        var profpic = jwt_decode(localStorage.getItem("_r")).profilePicture;
        var profnam = jwt_decode(localStorage.getItem("_r")).userName;
        //console.log(profpic);
        $(".prof_image").attr("src", profpic);
        $(".prof_name").text(profnam);

        // Make Side Button Animate
        // $( ".floatBtn-Wrapper" ).mouseenter(function() {
        //     $(this).animate({ width: "150px" },150,"linear",() => {
        //         $(this).find('span').show(100,'linear');
        //     });
        // });

        // $( ".floatBtn-Wrapper" ).mouseleave(function() {
        //     $(this).animate({ width: "45px" },100,"linear",() => {
        //         $(this).find('span').hide(50,'linear');
        //     });
        // });

        // reset community 
        localStorage.setItem("_g",null);

    });

</script>

<script type="text/javascript">

   // alert(window.Vyndue_picture);

   // console.log(window);

    $(".page-contents").hide();
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-bottom-left",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300000",
        "hideDuration": "10000000",
        "timeOut": "5000",
        "extendedTimeOut": "1000000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
    $(document).ready(function () {
        window.mobileAndTabletcheck = function () {
            return false; // prevent mobile 
            let check = false;
            (function (a) {
                if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4))) check = true;
            })(navigator.userAgent || navigator.vendor || window.opera);
            return check;
        };
        let viewHeight = null;
        let viewWidth = null;
        //window.scrollTo(0,0);
        $(window).bind("resize", function () {
            if (window.mobileAndTabletcheck()) {
                location.href = "<?php echo base_url('mobile/im'); ?>";
            }
            //window.scrollTo(0,0);
            viewHeight = $(window).height();
            viewWidth = $(window).width();
            if (viewWidth > 995) {
                $("body").addClass("controlOverflow");
            } else if ($("body").hasClass("controlOverflow")) {
                $("body").removeClass("controlOverflow");
            }
            if (viewWidth < 990) {
                $('#convStart').css("height", 61);
                $('.persons').css({"margin-top": 0});
                $(".rightSection").css({'margin-top': '30px'});
                $(".groupNameDiv").css({"padding-bottom": '32px'});
                $('.video').css({'margin-left': '-34px'});
            }
            else {
                $(".rightSection").css({'margin-top': '0px'});
                $(".groupNameDiv").css({"padding-bottom": '21px'});
                $('.video').css({'margin-left': '0px'});
            }
            /*if(viewHeight<776){
             $("#newMModalBody").css("margin-bottom", "155px");
             }else {
             $("#newMModalBody").css("margin-bottom", "160px");
             }*/
            if (viewWidth < 990) {
                // $(".leftSection").css({"height":(viewHeight-95)});
                $(".middleSection").css({"height": (viewHeight - 95)});
                $(".rightSection").css({"height": (viewHeight - 95)});
            }
            else {
                //$(".leftSection").css({"height":590});
                //$(".middleSection").css({"height":590});
                $(".rightSection").css({"display": "inline-block"});
                //$("body").css({"display": "inline-block"});
            }
            $(".chat").css({"height": (viewHeight - 230)});
            $('#groups').css({"height": (viewHeight - 160)});
            $(".rightSection").css({"height": (viewHeight - 50)});
            //$('.personsList').css({"height":(viewHeight-250)});
        }).trigger("resize");
        /*
           --------Global variables
         */
        twemoji.base = "<?php echo base_url('assets/newTheme/assets/js/twemoji/2/'); ?>";
        let chatBox = $('#chatBox');
        let groupBox = $("#groups");
        let notificationBox = $("#notificationBox");
        let joinrequestBox = $("#joinrequestBox");
        let communitymoderatorBox = $("#communitymoderatorBox");
        let communityBox = $("#communityBox");
        let videoObjects = [];
        let responce = null;
        let userId = null;
        let type = 1;
        let ID_BASED = false;
        if (String(localStorage.getItem("T")) == "token") {
            responce = localStorage.getItem("_r");
            userId = jwt_decode(responce).userId;
            type = jwt_decode(responce).userType;
        } else {
            responce = JSON.parse(localStorage.getItem("_r"));
            userId = responce.userId;
            ID_BASED = true;
        }
        let start = 0;
        let limit = 30;
        let pageNotif = 0;
        let limitNotif = 6;
        let groupLimit = 30;
        let currentCommunityPage = 0;
        let groupStart = 0;
        let totalGroup = null;
        let friendStart = 0;
        let friendLimit = 30;
        let totalFriend = null;
        let totalRetivedMessage = 0;
        let activeGroupId = null;
        let activeGroupmember = null;
        let groupIds = [];
        let time = [];
        let groupImages = {};
        let groupType = null;
        let mute = 0;
        let block = 0;
        let groupObjects = {};
        let scrollPosition = null;
        let notRequested = true;
        let meBlocker = 0;
        let messageLoading = false;
        let typing = false;
        let typingTimeout = undefined;
        let lastMessageDate = null;
        let LastMessageId = null;
        let firstmessageDate = null;
        let topMessage = null;
        let addexpendDropdown = null;
        let addMemberexpendDropdown = null;
        let membersId = [];
        let presentTypingDiv = null;
        let messageFormhtml = $("#messageForm").html();
        let listenType = (navigator.userAgent.toLowerCase().indexOf("edge") != -1) ? 'mouseup' : 'click';
        let notificationPermission = false;
        let messageTyping=true;
        let isDisconnected=false;
        let max_upload_size=20971520; //20mb
        let magicSuggestOption = {
            placeholder: 'Search for people...',
            allowFreeEntries: false,
            maxSelection: null,
            hideTrigger:true,
            expandOnFocus: true,
            selectionRenderer: function(data){
                return '<img class="ms-thumbnail-image" src="' + data.picture + '"/>' + data.name;
            },
            // data: q,
            renderer: function (data) {
                return '<div style="padding: 5px; overflow:hidden;">' +
                    '<div style="float: left;" class="m20"><img style="width: 25px;height: 25px" src="' + data.picture + '" /></div>' +
                    '<div style="float: left; margin-left: 5px" class="m21">' +
                    '<div style="font-weight: bold; color: #333; font-size: 12px; line-height: 11px" class="vvs">' + data.name + '</div>' +
                    '<div style="color: #999; font-size: 9px" class="m">' + data.email + '</div>' +
                    '</div>' +
                    '</div><div style="clear:both;"></div>'; // make sure we have closed our dom stuff
            }
        };
        let addmember = $('#addMemberInput').magicSuggest(magicSuggestOption); // start a new conversation
        let newMemberInput = $('#addNewMemberInput').magicSuggest(magicSuggestOption); // right side, add member
        let totalGroupMembers = 0;
        /*let momentOptions={
            sameDay: '[Today at] h:mm a',
            nextDay: '[Tomorrow at] at h:mm a',
            nextWeek: 'dddd [at] h:mm a',
            lastDay: '[Yesterday at] h:mm a',
            lastWeek: '[Last] dddd [at] h:mm a',
            sameElse: 'MMM DD, YYYY h:mm a'
        };*/
        let momentOptions = {
            sameDay: '[Today at] h:mm a',
            nextDay: '[Tomorrow at] h:mm a',
            nextWeek: 'dddd [at] h:mm a',
            lastDay: 'MMMM DD, YYYY h:mm a',
            lastWeek: 'MMMM DD, YYYY h:mm a',
            sameElse: 'MMMM DD, YYYY h:mm a'
        };
        let momentOptions2 = {
            sameDay: 'h:mm a',
            nextDay: '[Tomorrow at] h:mm a',
            nextWeek: 'dddd [at] h:mm a',
            lastDay: '[Yesterday at] h:mm a',
            lastWeek: '[Last] dddd [at] h:mm a',
            sameElse: 'MMM DD, YYYY h:mm a'
        };
        let momentOptions3 = {
            sameDay: 'MMMM DD, h:mm a',
            nextDay: 'MMMM DD, h:mm a',
            nextWeek: 'MMMM DD, h:mm a',
            lastDay: 'MMMM DD, h:mm a',
            lastWeek: 'MMMM DD, h:mm a',
            sameElse: 'MMMM DD, YYYY h:mm a'
        };
        let sendNewMessageSettings = {
            init: "Your message.....",
            size: '30px',
            icon: 'grinning',
            iconSize: '25px',
            height: '90px',
            width: '100%',
            border: '0',
            category: ['smile', 'cherry-blossom', 'video-game', 'oncoming-automobile', 'symbols'],
            categorySize: '20px',
            pickerPosition: 'bottom',
            pickerHeight: '150px',
            pickerWidth: '100%'
        };
        let sendMessageSettings = {
            init: "Your message.....",
            size: '30px',
            icon: 'grinning',
            iconSize: '25px',
            height: '50px',
            width: '100%',
            border: '0',
            category: ['smile', 'cherry-blossom', 'video-game', 'oncoming-automobile', 'symbols'],
            categorySize: '20px',
            pickerPosition: 'top',
            pickerHeight: '150px',
            pickerWidth: '100%'
        };
        
        // console.log(userId);
        
        //----------start point-------------------
        if (responce != null && responce != '' && type == 1) {
            getGroupList(function (data) {
                if (data.length > 0) {
                    let noPendingGroupId = null;
                    for (let i = 0; i < data.length; i++) {
                        if (data[i].pendingMessage <= 0) {
                            noPendingGroupId = data[i].groupId;
                            break;
                        }
                    }
                    if (noPendingGroupId !== null) {
                        $("#group_" + noPendingGroupId).trigger("click", [{update: true}]);
                    }else{
                        $(".rightBorder").addClass("hidden");
                    }
                }else{
                    $(".rightBorder").addClass("hidden");
                }
            });
        }
        else {
            location.href = "<?php echo base_url('userview/logout'); ?>";
        }
        // --------- Global Functions--------------
        if (("Notification" in window)) {
            if (Notification.permission === "granted") {
                // If it's okay let's create a notification
                notificationPermission = true;
            }
            else if (Notification.permission !== "denied") {
                Notification.requestPermission(function (permission) {
                    // If the user accepts, let's create a notification
                    if (permission === "granted") {
                        notificationPermission = true;
                    }
                });
            }
        }

        /* // working notification
        let icm = [
            'http://dev.vyndue.com/assets/im/group_9/05172019124118impHCVn9.jpg',
        ];
        notifyMe('Header Notification','Hello there!',icm);
        */
        
        function notifyMe(header, message, icon ) {
            let modmsg = message.replace(/(<([^>]+)>)/ig,"");          
            if (notificationPermission && (icon !== undefined || icon !== null)) {
                let image = null;
                let c = document.createElement("canvas");
                let ctx = c.getContext("2d");
                ctx.canvas.width = 500;
                ctx.canvas.height = 500;
                ctx.moveTo(0, 0);
                if (icon.length === 1) {
                    let options = {
                        body: modmsg,
                        dir: "ltr",
                        icon: icon[0],
                        tag: 'soManyNotification'
                    };
                    let notification = new Notification(header, options);
                } else if (icon.length === 2) {
                    // remove html tag
                    let imageObj1 = new Image();
                    let imageObj2 = new Image();
                    imageObj1.src = icon[0];
                    imageObj1.onload = function () {
                        ctx.drawImage(imageObj1, 0, 0, 250, 500);
                        imageObj2.src = icon[1];
                        imageObj2.onload = function () {
                            ctx.drawImage(imageObj2, 251, 0, 500, 500);
                            image = c.toDataURL("image/png");
                            let options = {
                                body: modmsg,
                                dir: "ltr",
                                icon: image,
                                tag: 'soManyNotification'
                            };
                            let notification = new Notification(header, options);
                        }
                    };
                } else if (icon.length === 3) {
                    let imageObj1 = new Image();
                    let imageObj2 = new Image();
                    let imageObj3 = new Image();
                    imageObj1.src = icon[0];
                    imageObj1.onload = function () {
                        ctx.drawImage(imageObj1, 0, 0, 250, 250);
                        imageObj2.src = icon[1];
                        imageObj2.onload = function () {
                            ctx.drawImage(imageObj2, 251, 0, 500, 250);
                            imageObj3.src = icon[2];
                            imageObj3.onload = function () {
                                ctx.drawImage(imageObj3, 0, 251, 500, 250);
                                image = c.toDataURL("image/png");
                                let options = {
                                    body: modmsg,
                                    dir: "ltr",
                                    icon: image,
                                    tag: 'soManyNotification'
                                };
                                let notification = new Notification(header, options);
                            }
                        }
                    };
                }
            }
            pingNotificationButton();
        }
        function typingTimeoutFunction() {
            let data = {
                userId: userId,
                groupId: activeGroupId
            };
            typing = false;
            socket.emit("notTyping", JSON.stringify(data));
        }
        function onKeyDownNotEnter(e) {
            let data = {
                userId: userId,
                groupId: activeGroupId
            };
            if (!typing) {
                typing = true;
                socket.emit("typing", JSON.stringify(data));
                typingTimeout = setTimeout(typingTimeoutFunction, 3000);
            } else {
                userTypeSomething(e);
                clearTimeout(typingTimeout);
                typingTimeout = setTimeout(typingTimeoutFunction, 3000);
            }
        }

        // Ralph 2019-05-20
        function userTypeSomething(e){
            var text = e.target.innerText;
            var char = text[text.length-1];
            if(char=='@' && parseInt(groupType)!=1){
                show_divMentionDiv(); 
            } 

            else if(char=='$'){
                //alert('dollar signed');
                show_divStockDiv(); 
            } 
        }

        // Start of Mention Form
        // inputMentionSearch
        let inputMentionSearch = $('#inputMentionSearch').magicSuggest({
            placeholder: 'Type Member Name...',
            allowFreeEntries: false,
            maxSelection: 1,
            hideTrigger:true,
            useTabKey:true,
            strictSuggest: true,
            expandOnFocus: true,
            sortOrder:"name",
            maxDropHeight: 60, // max height of screen,
            renderer: function (data) {
                let html = '';
                return `<div style="padding: 5px; overflow:hidden;">
                    <div style="float: left;"  class="m22"><img style="width: 25px;height: 25px" src=" ${data.picture} " /></div> 
                    <div style="float: left; margin-left: 5px"  class="m23">
                    <div class="c1">
                    <div style="font-weight: bold; color: #333; font-size: 12px; line-height: 11px"> ${data.name} </div> 
                    <div style="color: #999; font-size: 9px" class="v"> @${ data.username } </div> 
                    </div>
                    </div> 
                    </div><div style="clear:both;"></div>`; 
            }
        });

        $(inputMentionSearch).on('focus', function(e){
            getMention(function (res) {
                let q = [];
                for (i = 0; i < res.length; i++) {    
                    let md = {
                        id: parseInt(res[i].id),
                        name: res[i].name,
                        picture: res[i].picture,
                        username: res[i].usersecret,
                        email: res[i].email
                    };
                    q.push(md);
                }
                inputMentionSearch.setData(q);
                inputMentionSearch.clear();
            });
        });

        $(inputMentionSearch).on('selectionchange', function(){
            let data = this.getSelection()[0];
            let input = $('#message_twemoji')[0];
            if(data===undefined) return;
            hide_divMentionDiv();
            input.focus();
            setTimeout(() => {
                let content = input.innerHTML.slice(0, input.innerHTML.length-1);
                let newcontent = content + '<m><a href="#" data-username="'+ data.username +'" class="mention">@' + data.name + '</a></m>&nbsp;';                
                input.innerHTML = newcontent;
            }, 150);
        });

        $(inputMentionSearch).on('blur', function(c){
            hide_divMentionDiv();
        });

        $(inputMentionSearch).on('keyup', function(e, m, v){
              if(v.keyCode===27){
                hide_divMentionDiv();
                $('#message_twemoji')[0].focus();
              } 
        })

        function hide_divMentionDiv(){
            $('#divMentionDiv').hide(200);
            inputMentionSearch.disable();
            inputMentionSearch.clear();
            inputMentionSearch.empty();
        }

        function show_divMentionDiv(){
            $('#divMentionDiv').show(200);
            setTimeout(() => {
                inputMentionSearch.enable();
                $('#inputMentionSearch :input[type=text]')[0].focus();
            }, 200);
        }

        hide_divMentionDiv();
        // End of Mention Form

        // Start Stock Data
        let inputStockSearch = $('#inputStockSearch').magicSuggest({
            placeholder: 'Type Stock Symbol...',
            allowFreeEntries: false,
            maxSelection: 1,
            hideTrigger:true,
            useTabKey:true,
            strictSuggest: true,
            expandOnFocus: true,
            sortOrder:"description",
            displayField: "symbol",
            maxDropHeight: 60, // max height of screen,
            renderer: function (data) {
                let html = '';
                return `<div style="padding: 5px; overflow:hidden;">
                    <div style="float: left;"  class="m22"></div> 
                    <div style="float: left; margin-left: 5px"  class="m23">
                    <div class="c1">
                    <div style="font-weight: bold; color: #333; font-size: 12px; line-height: 11px"> $${data.symbol} </div> 
                    <div style="color: #999; font-size: 9px" class="v"> ${ data.display_name } </div> 
                    </div>
                    </div> 
                    </div><div style="clear:both;"></div>`;
            }
        });

        $(inputStockSearch).on('focus', function(e){
            let _s = localStorage.getItem("_s");
            if (_s == null || _s == "" || _s=='null') {
                getStock(function (response) {
                    localStorage.setItem("_s",JSON.stringify(response));
                    let q = [];
                    for(i in response){
                        let md = {
                            id: parseInt(response[i].id),
                            symbol: response[i].symbol,
                            description: response[i].description,
                            display_name: response[i].display_name
                        };
                        q.push(md);
                    }
                    inputStockSearch.setData(q);
                    inputStockSearch.clear();
                });    
            }else{
                let data = localStorage.getItem('_s');
                const response = JSON.parse(data);
                let q = [];
                for(i in response){
                    let md = {
                        id: parseInt(response[i].id),
                        symbol: response[i].symbol,
                        description: response[i].description,
                        display_name: response[i].display_name
                    };
                    q.push(md);
                }
                inputStockSearch.setData(q);
                inputStockSearch.clear();
            }
        });

        $(inputStockSearch).on('selectionchange', function(){
            let data = this.getSelection()[0];
            let input = $('#message_twemoji')[0];
            if(data===undefined) return;
            hide_divStockDiv();
            input.focus();
            setTimeout(() => {
                getStockLatest( data.symbol,function(res){
//                  console.log(res); 
                    let color;
                    let icon;
                    let openColor;
                    if(res.change==0){ 
                        color = "stock_change_none";
                        icon = `<span></span>`; 
                    }
                    else if(res.change>0){ 
                        color = "stock_change_inc"; 
                        icon = `<i class="fa fa-arrow-up" aria-hidden="true"></i>`;
                    }
                    else if(res.change<0){ 
                        color = "stock_change_dec"; 
                        icon = `<i class="fa fa-arrow-down stock_change_dec" aria-hidden="true"></i>`;
                    }
                    else { color = "" }

                    if(res.open == res.close){
                        openColor = "text-yellow";
                    }else if(res.open > res.close){
                        openColor = "text-green";
                    }else if(res.open < res.close){
                        openColor = "text-red";
                    }

                    const _52WkLowColor = (res.weekyearlow > res.last) ? 'text-green' : 'text-red';
                    const aveColor = (res.average > res.close) ? 'text-green' : 'text-red';
                    const lowColor = (res.low > res.close) ? 'text-green' : 'text-red';
                    const highColor = (res.high > res.close) ? 'text-green' : 'text-red';
                    const _52WkHighColor = (res.weekyearhigh > res.last) ? 'text-green' : 'text-red';

                    let content = `<m><table class="chat_stock_table">
                                    <tr><td> <b class="stockSymbol">$${res.symbol}</b> </td><td class="chat_stock_value"> ${icon} <b class="${color}">${numeral(res.last).format('0,0.00')}</b><small class="chat_stock_value ${color}"> ${numeral(res.change).format('0,0.00')} </small><small class="chat_stock_value ${color}"> (${numeral(res.changepercentage).format('0,0.00')}%) </small> </td></tr>
                                    <tr><td colspan=2><hr class="hr_divider"/></td></tr>
                                    <tr><td>Previous:</td><td class="chat_stock_value"> ${numeral(res.close).format('0,0.00')} </td></tr>
                                    <tr><td>Open:</td><td class="chat_stock_value ${openColor}"> ${numeral(res.open).format('0,0.00')} </td></tr>
                                    <tr><td>Low:</td><td class="chat_stock_value ${lowColor}"> ${numeral(res.low).format('0,0.00')} </td></tr>
                                    <tr><td>High:</td><td class="chat_stock_value ${highColor}"> ${numeral(res.high).format('0,0.00')} </td></tr>
                                    <tr><td>Trades:</td><td class="chat_stock_value"> ${numeral(res.trades).format('0,0')} </td></tr>
                                    <tr><td>Average:</td><td class="chat_stock_value ${aveColor}"> ${numeral(res.average).format('0,0.00')} </td></tr>
                                    <tr><td>52 Week Low:</td><td class="chat_stock_value ${_52WkLowColor}"> ${numeral(res.weekyearlow).format('0,0.00')} </td></tr>
                                    <tr><td>52 Week High:</td><td class="chat_stock_value ${_52WkHighColor}"> ${numeral(res.weekyearhigh).format('0,0.00')} </td></tr>
                                    <tr><td>Volume:</td><td class="chat_stock_value"> ${numeral(res.volume).format('0.00 a')} </td></tr>
                                    <tr><td>Value:</td><td class="chat_stock_value"> ${numeral(res.value).format('0.00 a')} </td></tr>
                                    <tr><td>Market Cap:</td><td class="chat_stock_value"> ${numeral(res.marketcap).format('0,0.00')} </td></tr>
                                    </table></m>&nbsp;`;
                    input.innerHTML = content;
                });
            }, 150);
        });

        $(inputStockSearch).on('blur', function(c){
            hide_divStockDiv();
        });

        $(inputStockSearch).on('keyup', function(e, m, v){
              if(v.keyCode===27){
                hide_divStockDiv();
                $('#message_twemoji')[0].focus();
              } 
        })

        function hide_divStockDiv(){
            $('#divStockDiv').hide(200);
            inputStockSearch.disable();
            inputStockSearch.clear();
            inputStockSearch.empty();
        }

        function show_divStockDiv(){
            $('#divStockDiv').show(200);
            setTimeout(() => {
                inputStockSearch.enable();
                $('#inputStockSearch :input[type=text]')[0].focus();
            }, 200);
        }

        hide_divStockDiv();
        // End Stock Data 

        // Ralph 2019-05-29
        // This function is to fecth and list a sorts of notification;
        function getTotalNotification(callback){
            let url = "<?php echo base_url('user/notificationTotal'); ?>";
            if (ID_BASED) {
                url = "<?php echo base_url('user/notificationTotal?userId='); ?>" + userId;
            }
            let settings = {
                "async": true,
                "crossDomain": true,
                "url": url,
                "method": "GET",
                "headers": {
                    "authorization": "Basic YWRtaW46MTIzNA==",
                    "Authorizationkeyfortoken": String(responce),
                    "cache-control": "no-cache",
                    "postman-token": "eb27c011-391a-0b70-37c5-609bcd1d7b6d"
                },
                "processData": false,
                "contentType": false
            };
            $.ajax(settings).done(function (response) {
                let count = response.response.count;
                callback(count);
            });
        };

        function getNotification(page) {
            let pageNotif = (parseInt(page)>0) ? page : 0;
            let url = "<?php echo base_url('user/notificationList?limit='); ?>" + limitNotif + "&page=" + pageNotif;
            if (ID_BASED) {
                url = "<?php echo base_url('user/notificationList?limit='); ?>" + limitNotif + "&page=" + pageNotif + "&userid=" + userId;
            }
            let settings = {
                "async": true,
                "crossDomain": true,
                "url": url,
                "method": "GET",
                "headers": {
                    "authorization": "Basic YWRtaW46MTIzNA==",
                    "Authorizationkeyfortoken": String(responce),
                    "cache-control": "no-cache",
                    "postman-token": "eb27c011-391a-0b70-37c5-609bcd1d7b6d"
                },
                "processData": false,
                "contentType": false,
                "beforeSend": function () {
                    notificationBox.html('<br><br><br><p align="center"><i class="fa fa-spinner fa-spin fa-4x fa-fw" aria-hidden="true"></i></p>');
                },
                "success": function () {
                    notificationBox.html('');
                }
            };
            $.ajax(settings).done(function (response) {
                let data = response.response.data;
                let prev = response.response.prev;
                let next = response.response.next;
                let next_page = response.response.next_page;
                let prev_page = response.response.prev_page;
                notificationBox.html("");
                if(data.length===0){
                    notificationBox.html("<div class='no-notf'><i class='far fa-meh-blank'></i><br><h4 class='nonotfreminder'>Notification box is empty.</h4></div>");
                    return;
                }
                let html = '';
                // pages
                html += `<span class="list-group-item list-group-item-info row">
                            <ul class="grplist col-md-6"><span class="arbitrage-button arbitrage-button--info" id="clearAllNotif"><i class="fa fa-trash fa-fw"></i> Clear All</span></ul>
                            <ul class="pager col-md-6" style="margin:0;">
                                <li ${ (!prev) ? 'class="disabled"' : ''  }><a href="#" data-page="${prev_page}" data-prev="${ (prev) ? 1 : 0  }" id="notifPrev"><i class="fas fa-chevron-circle-left"></i></a></a></li>
                                <li ${ (!next) ? 'class="disabled"' : ''  }><a href="#" data-page="${next_page}" data-next="${ (next) ? 1 : 0  }" id="notifNext"><i class="fas fa-chevron-circle-right"></i></a></a></li>
                            </ul>
                            </nav>
                        </span>`;
                // list
                for (let i = 0; i < data.length; i++) {
                   html += `<a style="color:black" data-id="${data[i].group_id}" data-notif-id="${data[i].notif_id}" data-notif-type="${data[i].notif_type}" class="list-group-item"> 
                        <span class="badge"><i class="fa fa-2x fa-${ data[i].badge }" aria-hidden="true"></i></span>      
                        <small>         
                        <label class="label label-default">${ moment(data[i].date_time).fromNow() }</label>  
                        <b><i class="fa fa-fw fa-${ data[i].icon }" aria-hidden="true"></i> ${data[i].group_name}</b>
                        </small>
                        <br>
                        <code>${data[i].sender_name} ${ data[i].message }</code>
                        </a>`;
                }
                notificationBox.html(html);
            });
        }

        $(document).on('click', '#clearAllNotif', function (e) {
            if(!confirm('Are you sure to clear notification box?')){
                return;
            }
            let r_id = jwt_decode(localStorage.getItem("_r")).userId;
            socket.emit("clearNotificationBox",r_id);
            $("#modalNotifications").modal('hide');
            e.preventDefault();
        });


        $(document).on('click', '#notificationBox a.list-group-item', function (e) {
            // console.log('clicked');
            let g_id = $(this).attr('data-id');
            let n_type = parseInt($(this).attr('data-notif-type'));
            let n_id = parseInt($(this).attr('data-notif-id'));
            // console.log(n_id);
            // return;
            socket.emit("seenNotification",n_id);
            doAfterNotification(n_type,g_id);
            $("#modalNotifications").modal('hide');
            e.preventDefault();
        });

        function doAfterNotification(n_type,g_id){
            switch (parseInt(n_type)) {
                case 1:
                    setTimeout(() => {
                        $("#modalJoinRequest").modal("show");
                        getJoinRequest(g_id);
                    },1000);     
                break;
                case 2:
                    getGroupList(function(data){
                        setTimeout(() => {
                            $("li#group_"+g_id).first().trigger("click", [{update: true}]);
                            toastr.success(`Hello ${window.Vyndue_fname}, welcome to your new private community.`);
                        }, 1000);
                    }); 
                break;
                default:
                    $("li#group_"+g_id).first().trigger("click", [{update: true}]);
                break;
            }
        }

        $(document).on('click', 'a#notifPrev', function (e) {
            let page = $(this).attr('data-page');
            let prev = parseInt($(this).attr('data-prev'));
            if(prev){
                getNotification(page);
                return;
            } 
            e.preventDefault();
        });

        $(document).on('click', 'a#notifNext', function (e) {
            let page = $(this).attr('data-page');
            let next = parseInt($(this).attr('data-next'));
            if(next){
                getNotification(page);
                return;
            } 
            e.preventDefault();
        });

        // function get all community moderator
        function getCommunityModerator(groupId, callback) {
            let url = "<?php echo base_url('user/communitymoderatorList?groupId='); ?>" + groupId;
            if (ID_BASED) {
                url = "<?php echo base_url('user/communitymoderatorList?groupId='); ?>" + groupId + "&userId=" + userId;
            }
            let settings = {
                "async": true,
                "crossDomain": true,
                "url": url,
                "method": "GET",
                "headers": {
                    "authorization": "Basic YWRtaW46MTIzNA==",
                    "Authorizationkeyfortoken": String(responce),
                    "cache-control": "no-cache",
                    "postman-token": "eb27c011-391a-0b70-37c5-609bcd1d7b6d"
                },
                "processData": false,
                "contentType": false,
                "beforeSend": function () {
                    communitymoderatorBox.html('<br><br><br><p align="center"><i class="fa fa-spinner fa-spin fa-4x fa-fw" aria-hidden="true"></i></p>');
                },
                "success": function () {
                    communitymoderatorBox.html('');
                }
            };
            $.ajax(settings).done(function (response) {
                let data = response.response.data;
                callback(data);
            });
        }

        function listCommunityModerator(response){
                // console.log(response);
                let data = response;
                if(data.length===0){
                    communitymoderatorBox.html("<div class='no-request'><i class='far fa-meh-blank'></i><br><h4 class='nonotrequest'>Join Request box is empty.</h4></div>");
                    return;
                }
                let html = '';
                for (let i = 0; i < data.length; i++) {
                   html += `<a style="color:black;cursor: default;" data-group-id="${data[i].group_id}" data-username="${data[i].username}" class="list-group-item"> 
                        <img src="${ data[i].picture }" class="communitymoderatorlist_thumbnail">  
                        <label data-username="${data[i].username}" title="View Profile" class="communitymoderatorlist_label">${ data[i].name }</label>` 
                    
                    switch(parseInt(data[i].userlevel)){
                        case 1: // admin 
                            html += `<button title="Administrator" type="button" disabled
                                        class="arbitrage-button arbitrage-button--warning pull-right communitymoderatorlist_btn">
                                        <i class="fa fa-star" aria-hidden="true"></i>  
                                    </button>`;
                        break;
                        case 2: // moderator
                            html += `<button title="Moderator" type="button" 
                                        data-group-id="${data[i].group_id}" data-username="${data[i].username}"
                                        data-id="${data[i].id}" data-name="${data[i].name}" data-userlevel="${data[i].userlevel}"
                                        class="arbitrage-button arbitrage-button--success pull-right communitymoderatorlist_btn">
                                        <i class="fa fa-balance-scale" aria-hidden="true"></i> 
                                    </button>`;
                        break;
                        case 0: // member
                            html += `<button title="Member" type="button" 
                                        data-group-id="${data[i].group_id}" data-username="${data[i].username}"
                                        data-id="${data[i].id}" data-name="${data[i].name}" data-userlevel="${data[i].userlevel}"
                                        class="arbitrage-button arbitrage-button--secondary pull-right communitymoderatorlist_btn">
                                        <i class="fa fa-user" aria-hidden="true"></i> 
                                    </button>`;
                        break;
                    }

                    html += `</a>`;
                }
                communitymoderatorBox.html(html);

            }

        $(document).on('click', '#communitymoderatorBox a.list-group-item button.communitymoderatorlist_btn', function (e) {
            let data = {};
            data.g_id = parseInt($(this).attr('data-group-id'));
            data.r_id = parseInt($(this).attr('data-id'));
            data.username = $(this).attr('data-username');
            data.name = $(this).attr('data-name');
            data.userlevel = parseInt($(this).attr('data-userlevel'));
            data.t_id = (data.userlevel) ? 8 : 7 ;
            //data.u_id = window.Vyndue_cKey;
            data.u_id = jwt_decode(localStorage.getItem("_r")).consumerKey;
            if(!confirm(`Are you sure to ${ data.userlevel ? 'demote' : 'promote' } ${ data.name } as "${ data.userlevel ? 'Member' : 'Moderator' }"?`)){
                return;
            }
            socket.emit('communitymoderatorProcess',data);
            getCommunityModerator(data.g_id, listCommunityModerator);
            e.preventDefault();
        });


        // This function is to fecth and list of communities;
        function getCommunities(callback) {
            let url = "<?php echo base_url('user/communityList?limit='); ?>";
            if (ID_BASED) {
                url = "<?php echo base_url('user/communityList?userId='); ?>" + userId;
            }
            let settings = {
                "async": true,
                "crossDomain": true,
                "url": url,
                "method": "GET",
                "headers": {
                    "authorization": "Basic YWRtaW46MTIzNA==",
                    "Authorizationkeyfortoken": String(responce),
                    "cache-control": "no-cache",
                    "postman-token": "eb27c011-391a-0b70-37c5-609bcd1d7b6d"
                },
                "processData": false,
                "contentType": false,
                "beforeSend": function () {
                    localStorage.setItem("_g",null)
                    communityBox.html('<br><br><br><p align="center"><i class="fa fa-spinner fa-spin fa-4x fa-fw" aria-hidden="true"></i></p>');
                },
                "success": function () {
                    communityBox.html('');
                }
            };
            $.ajax(settings).done(function (res) {
                let data = res.response._g;
                callback(data);
            });
        }

        // function get all join request
        function getJoinRequest(groupId) {
            let url = "<?php echo base_url('user/joinrequestList?groupId='); ?>" + groupId;
            if (ID_BASED) {
                url = "<?php echo base_url('user/joinrequestList?groupId='); ?>" + groupId + "&userId=" + userId;
            }
            let settings = {
                "async": true,
                "crossDomain": true,
                "url": url,
                "method": "GET",
                "headers": {
                    "authorization": "Basic YWRtaW46MTIzNA==",
                    "Authorizationkeyfortoken": String(responce),
                    "cache-control": "no-cache",
                    "postman-token": "eb27c011-391a-0b70-37c5-609bcd1d7b6d"
                },
                "processData": false,
                "contentType": false,
                "beforeSend": function () {
                    joinrequestBox.html('<br><br><br><p align="center"><i class="fa fa-spinner fa-spin fa-4x fa-fw" aria-hidden="true"></i></p>');
                },
                "success": function () {
                    joinrequestBox.html('');
                }
            };
            $.ajax(settings).done(function (response) {
                let data = response.response.data;
                if(data.length===0){
                    joinrequestBox.html("<div class='no-request'><i class='far fa-meh-blank'></i><br><h4 class='nonotrequest'>Join Request box is empty.</h4></div>");
                    return;
                }
                let html = '';
                for (let i = 0; i < data.length; i++) {
                   html += `<a style="color:black;cursor: default;" data-group-id="${data[i].group_id}" data-username="${data[i].username}" class="list-group-item"> 
                        <img src="${ data[i].picture }" class="joinrequestlist_thumbnail">  
                        <label data-username="${data[i].username}" title="View Profile" class="joinrequestlist_label">${ data[i].name }</label> 
                        <button title="Disapprove" type="button" 
                            data-group-id="${data[i].group_id}" data-username="${data[i].username}" 
                            data-id="${data[i].id}" data-name="${data[i].name}"
                            class="arbitrage-button arbitrage-button--warning pull-right joinrequestlist_btn joinrequest-disapprove">
                            <i class="fa fa-thumbs-down fa-fw" aria-hidden="true"></i>
                        </button>
                        <button title="Approve" type="button" 
                            data-group-id="${data[i].group_id}" data-username="${data[i].username}" 
                            data-id="${data[i].id}" data-name="${data[i].name}"
                            class="arbitrage-button arbitrage-button--primary pull-right joinrequestlist_btn joinrequest-approve" style="margin-right:5px;">
                            <i class="fa fa-thumbs-up fa-fw" aria-hidden="true"></i> 
                        </button>
                        </a>`;
                }
                joinrequestBox.html(html);
            });
        }

        $(document).on('click', 'label.joinrequestlist_label', function (e) {
            let url = "<?=ARBITRAGE.'/user/'; ?>"+ $(this).data('username') + "/";
            window.open(url.replace(' ',''), "_blank");
            e.preventDefault();
        });

        $(document).on('click', '#joinrequestBox a.list-group-item button.joinrequest-approve', function (e) {
            let data = {};
            data.g_id = parseInt($(this).attr('data-group-id'));
            data.r_id = parseInt($(this).attr('data-id'));
            data.username = $(this).attr('data-username');
            data.u_id = window.Vyndue_cKey;
            data.name = $(this).attr('data-name');
            data.approve = 1;
            data.t_id = 2;
            if(!confirm('Are you sure to "Approve" '+ data.name +' request to join?')){
                return;
            }
            socket.emit('joinrequestProccess',data);
            getJoinRequest(data.g_id);
            e.preventDefault();
        });

        $(document).on('click', '#joinrequestBox a.list-group-item button.joinrequest-disapprove', function (e) {
            let data = {};
            data.g_id = parseInt($(this).attr('data-group-id'));
            data.r_id = parseInt($(this).attr('data-id'));
            data.username = $(this).attr('data-username');
            data.u_id = window.Vyndue_cKey;
            data.name = $(this).attr('data-name');
            data.approve = 0;
            data.t_id = 6;
            if(!confirm('Are you sure to "Disapprove" '+ data.name +' request to join?')){
                return;
            }
            socket.emit('joinrequestProccess',data);
            getJoinRequest(data.g_id);
            e.preventDefault();
        });


        function initVideo(id, isme) {
            $("#" + id).mediaelementplayer({
                // Do not forget to put a final slash (/)
                pluginPath: 'https://cdnjs.com/libraries/mediaelement/',
                // this will allow the CDN to use Flash without restrictions
                // (by default, this is set as `sameDomain`)
                shimScriptAccess: 'always',
                success: function (player, node) {
                    $(player).closest('.mejs__container').find("div.mejs__overlay-button").css({"height": "110px"});
                    $(player).closest('.mejs__container').find("div.mejs__controls").css({"background": "#32cdc7"});
                    // $(player).closest('.mejs__container').find("div.mejs__controls").css({"background":"transparent"});
                    $(player).closest('.mejs__container').css({"background": "transparent"});
                    if (!isme) {
                        $(player).closest('.mejs__container').css({"margin-left": "auto"});
                    }
                }
            });
        }
        function initAudio(id, isme) {
            $("#" + id).mediaelementplayer({
                // Do not forget to put a final slash (/)
                pluginPath: 'https://cdnjs.com/libraries/mediaelement/',
                // this will allow the CDN to use Flash without restrictions
                // (by default, this is set as `sameDomain`)
                shimScriptAccess: 'always',
                success: function (player, node) {
                    $(player).closest('.mejs__container').find("div.mejs__controls").css({"border-radius": "50px"});
                    $(player).closest('.mejs__container').css({"background": "transparent"});
                    $(player).closest('.mejs__container').find("div.mejs__mediaelement").css({"border-radius": "50px"});
                    $(player).closest('.mejs__container').find("div.mejs__mediaelement").css({"background-color": "transparent"});
                    if (!isme) {
                        $(player).closest('.mejs__container').parent(".fw-im-attachments").css({"margin-left": "auto"});
                    }
                }
            });
        }
        // this function used to clear new message div
        function resetNewMessage() {
            $("#newMessageFile").replaceWith($("#newMessageFile").val('').clone(true));
            $('#newMessagefileIV').attr("src", "<?php echo base_url('assets/img/i-camera.png'); ?>");
            $('.twemoji-textarea').html("");
            $('.twemoji-textarea-duplicate').html("");
            $('#newMessageText').text("");
            $('#newMessageText').val("");
            $('.close').trigger("click");
        }
        // this function used to clear message div
        function reset() {
            $("#messageFile").replaceWith($("#messageFile").val('').clone(true));
            $('#fileIV').attr("src", "<?php echo base_url('assets/img/i-camera.png'); ?>");
            $("#messageFile1").replaceWith($("#messageFile1").val('').clone(true));
            $('#fileIV1').attr("src", "<?php echo base_url('assets/img/fileAttach.png'); ?>");
            $('.twemoji-textarea').html("");
            $('.twemoji-textarea-duplicate').html("");
            $('#message').text("");
            $('#message').val("");
        }
        // function for checking image/video type and size before uploading
        function imageChange(event) {
            let file = this.files[0];
            let imagefile = file.type;
            let size = file.size;
            let match = ["image/jpeg", "image/png", "image/jpg", "video/3gpp", "video/mp4", "video/3gp", "audio/mp3"];
            if (size > max_upload_size) {
                toastr.error("Max limit 20Mb exceeded");
                return;
            }
            if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]) || (imagefile == match[3]) || (imagefile == match[4]) || (imagefile == match[5]) || (imagefile == match[6]))) {
                toastr.error("This type of file is not allowed");
                return false;
            } else {
                $('#sendMessage').trigger(listenType);
                /* let type=null;
                 let url=URL.createObjectURL(this.files[0]);
                 if((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])){
                 type=new Image();
                 type.src=url;
                 type.onload = function() {
                 captureImage(type);
                 };
                 }
                 else{
                 type = document.createElement('video');
                 let source = document.createElement('source');
                 source.setAttribute('src',url);
                 type.appendChild(source);
                 type.muted = true;
                 type.play();
                 setTimeout(function(){
                 type.pause(); // note the [0] to access the native element
                 captureImage(type);
                 }, 3000);
                 }*/
            }
        }
        function getFileExtension(filename) {
            return filename.slice((filename.lastIndexOf(".") - 1 >>> 0) + 2).toLowerCase();
        }
        function attachChange(event) {
            let file = this.files[0];
            let attachFile = getFileExtension(file.name);
            let matched = false;
            let size = file.size;
            let match = ["txt", "rar", "zip", "xlsx", "xls", "ppt", "docx", "pptx", "text", "doc", "ppt", "wma", "mp3", "mp4", "pdf", "3gpp", "3gp", "png", "jpg", "jpeg", "csv"];
            if (size > max_upload_size) {
                toastr.error("Max limit 20Mb exceeded");
                return false;
            }
            for (let i = 0; i < match.length; i++) {
                if (attachFile === match[i]) {
                    matched = true;
                }
            }
            if (matched) {
                $('#sendMessage').trigger(listenType);
            } else {
                toastr.error("This type of file is not allowed");
                return false;
            }
        }
        function imageChangeGroup() {
            let file = this.files[0];
            let attachFile = getFileExtension(file.name);
            let matched = false;
            let size = file.size;
            let match = ["jpg","jpeg","png"];
            if (size > max_upload_size) {
                toastr.error("Max limit 20Mb exceeded");
                return false;
            }
            for (let i = 0; i < match.length; i++) {
                if (attachFile === match[i]) {
                    matched = true;
                }
            }
            if (matched) {
                updateGroupImage(file);
            } else {
                toastr.error("This type of file is not allowed");
                return false;
            }
        }
        // function for checking image/video type and size before uploading
        function imageChangeNewMessage(event) {
            let file = this.files[0];
            let attachFile = getFileExtension(file.name);
            let matched = false;
            let size = file.size;
            let match = ["txt", "rar", "zip", "xlsx", "xls", "ppt", "docx", "pptx", "text", "doc", "ppt", "wma", "mp3", "mp4", "pdf", "3gpp", "3gp", "png", "jpg", "jpeg", "csv"];
            if (size > max_upload_size) {
                toastr.error("Max limit 20Mb exceeded");
                return false;
            }
            for (let i = 0; i < match.length; i++) {
                if (attachFile === match[i]) {
                    matched = true;
                }
            }
            if (!matched) {
                toastr.error("This type of file is not allowed");
                return false;
            } else {
                $('#newSendMessage').trigger(listenType);
                /*let type=null;
                 let url=URL.createObjectURL(this.files[0]);
                 if((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])){
                 type=new Image();
                 type.src=url;
                 type.onload = function() {
                 captureImagenewMessage(type);
                 };
                 }
                 else{
                 type = document.createElement('video');
                 let source = document.createElement('source');
                 source.setAttribute('src',url);
                 type.appendChild(source);
                 type.muted = true;
                 type.play();
                 setTimeout(function(){
                 type.pause(); // note the [0] to access the native element
                 captureImagenewMessage(type);
                 }, 3000);
                 }*/
            }
        }
        // Api pagination functions
        function increaseStart() {
            start += limit;
        }
        function resetStart() {
            start = 0;
        }
        function resetRetiveMessage() {
            totalRetivedMessage = 0;
        }
        function increaseGroupLimit() {
            groupStart += groupLimit;
        }
        function resetFriendStart() {
            friendStart = 0;
        }
        function increaseFriendsLimit() {
            friendStart += friendLimit;
        }
        function createGroupImage(groupId,cb) {
           // console.log('createGroupImage');
           // console.log(groupId);
           //  console.log(cb);

            let c = document.createElement("canvas");
            let ctx = c.getContext("2d");
            ctx.canvas.width = 500;
            ctx.canvas.height = 500;
            ctx.fillStyle = "white";
            ctx.fillRect(0, 0, c.width, c.height);
            ctx.moveTo(0, 0);
            if (groupObjects[groupId].groupImage.length === 1) {
                printGroupIcon(groupObjects[groupId].groupImage[0],groupId,cb);
            } else if (groupObjects[groupId].groupImage.length === 2) {
                let imageObj1 = new Image();
                imageObj1.src = groupObjects[groupId].groupImage[0];
                imageObj1.onload = (function (groupId, cb) {
                    return function () {
                        ctx.drawImage(imageObj1, 0, 0, 250, 500);
                        let imageObj2 = new Image();
                        imageObj2.src = groupObjects[groupId].groupImage[1];
                        imageObj2.onload = (function (groupId,cb) {
                            return function () {
                                ctx.drawImage(imageObj2, 260, 0, 250, 500);
                                printGroupIcon(c.toDataURL("image/png"),groupId,cb);
                            }
                        })(groupId,cb);
                    }
                })(groupId,cb);
            } else if (groupObjects[groupId].groupImage.length === 3) {
                let imageObj1 = new Image();
                imageObj1.src = groupObjects[groupId].groupImage[0];
                imageObj1.onload = (function (groupId,cb) {
                    return function () {
                        ctx.drawImage(imageObj1, 0, 0, 320, 500);
                        let imageObj2 = new Image();
                        imageObj2.src = groupObjects[groupId].groupImage[1];
                        imageObj2.onload = (function (groupId,cb) {
                            return function () {
                                ctx.drawImage(imageObj2, 330, 0, 250, 250);
                                let imageObj3 = new Image();
                                imageObj3.src = groupObjects[groupId].groupImage[2];
                                imageObj3.onload = (function (groupId, cb) {
                                    return function () {
                                        ctx.drawImage(imageObj3, 330, 260, 250, 250);
                                        printGroupIcon(c.toDataURL("image/png"),groupId,cb);
                                    }
                                })(groupId,cb);
                            }
                        })(groupId,cb);
                    }
                })(groupId,cb);
            }
        }
        function printGroupIcon(image,groupId,cb){
            let z = image;
            let x = z.search("https://storage");
            let strippedLink = z.substring(x, (z.length));
            image = strippedLink;
            let html = '';
            if (parseInt(groupObjects[groupId].groupType) === 1 && groupObjects[groupId].members.length > 0) {
                if (groupObjects[groupId].members[0].active == 1) {
                    html += "<img  class='img-responsive img-circle memberActive group_member_" + groupObjects[groupId].members[0].userId + "' style=\"width: 50px; height: 50px;border-radius: 49%\" src=\"" + image + "\" >";
                } else {
                    html += "<img  class='img-responsive img-circle group_member_" + groupObjects[groupId].members[0].userId + "' style=\"width: 50px; height: 50px;border-radius: 49%\" src=\"" + image + "\" >";
                }
            } else {
                html += "<img class=\"img-responsive img-circle\" style=\"width: 50px; height: 50px;border-radius: 49%\" src=\"" + image + "\" >";
                // console.log(image)
            }
            $("#groupImage_" + groupId).html(html);
            groupObjects[groupId].groupImageData = image;
            if(cb){
                cb();
            }
        }
        function addNewGroup(group) {
            let html = "";
            groupIds.push(group.groupId);
            groupObjects[group.groupId] = group;
            time[group.groupId] = group.lastActive;
            if (group.pendingMessage > 0) {
                html += " <li class=\"person font-bold-black\" data-chat=\"person1\" id='group_" + group.groupId + "' data-type=\"" + group.groupType + "\" data-block=\"" + group.block + "\" data-mute=\"" + group.mute + "\" data-group=\"" + group.groupId + "\">";
            } else {
                html += " <li class=\"person\" data-chat=\"person1\" id='group_" + group.groupId + "' data-type=\"" + group.groupType + "\" data-block=\"" + group.block + "\" data-mute=\"" + group.mute + "\" data-group=\"" + group.groupId + "\">";
            }
            groupImages[group.groupId] = group.groupImage;
            html += '<span id="groupImage_' + group.groupId + '">';
            /*for (let j = 0; j < group.groupImage.length; j++) {
                if (parseInt(group.groupType) == 1 && group.members.length > 0) {
                    if ( group.members[0].active == 1) {
                        html += "                        <img class='img-responsive img-circle memberActive group_member_" + group.members[0].userId + "' style=\"width: 40px; height: 40px;border-radius: 50%\" src=\"" + group.groupImage[j] + "\" >";
                    } else {
                        html += "                        <img  class='img-responsive img-circle group_member_" + group.members[0].userId + "' style=\"width: 40px; height: 40px;border-radius: 50%\" src=\"" + group.groupImage[j] + "\" >";
                    }
                } else {
                    html += "                        <img class=\"img-responsive img-circle\" style=\"width: 40px; height: 40px;border-radius: 50%\" src=\"" + group.groupImage[j] + "\" >";
                }
            }*/
            html += '</span>';
            html += "                        <span class=\"name\" id='groupName_" + group.groupId + "' style=\"overflow: hidden\"><div>" + group.groupName + "</div><\/span>";
            let date = moment(group.lastActive, moment.ISO_8601).fromNow();
            html += "                        <span id='time_" + group.groupId + "' class=\"time\">" + date + "<\/span>";
            if (group.messageType === "text") {
                let recentMessage = group.recentMessage;
                if (recentMessage.includes('🐂')){
                        // var str = 'You: <img class="emoj" src="https://vyndue.com/assets/newTheme/assets/js/twemoji/2/72x72/1f402.png" style="background: none;width: 20px !important;height: 20px !important;display: inline-block;float: none;">'
                        recentMessage = recentMessage.replace(/🐂/g,'<img class="emoj" src="https://vyndue.com/assets/newTheme/assets/js/twemoji/2/72x72/1f402.png" style="border-radius: 0;background: none;width: 20px !important;height: 20px !important;display: inline-block;float: none;">');
                        // console.log("test2");
                        // recentMessage = str;
                }else if (recentMessage.includes('🐻')){
                        // var str = 'You: <img class="emoj" src="https://vyndue.com/assets/newTheme/assets/js/twemoji/2/72x72/1f402.png" style="background: none;width: 20px !important;height: 20px !important;display: inline-block;float: none;">'
                        recentMessage = recentMessage.replace(/🐻/g,'<img class="emoj" src="https://vyndue.com/assets/newTheme/assets/js/twemoji/2/72x72/1f43b.png" style="border-radius: 0;background: none;width: 20px !important;height: 20px !important;display: inline-block;float: none;">');
                        // console.log("test2");
                        // recentMessage = str;
                }
                if (recentMessage === null) {
                    recentMessage = '';
                }
                html += "<span style='float: left' id='messageType_" + group.groupId + "' class=\"preview\">" + recentMessage + "<\/span>";
            } else {
                let messageType = group.messageType;
                if (messageType === null) {
                    messageType = '';
                }
                html += "<span style='float: left' id='messageType_" + group.groupId + "' class=\"preview\">" + messageType + "<\/span>";
            }
            if (group.mute) {
                html += "                        <div style='' id='mute_" + group.groupId + "' class=\"mute-pad  text-right\" ><i class=\"fa fa-bell-slash\"></i><\/div>";
            } else {
                html += "                        <div style='' id='mute_" + group.groupId + "' class=\"mute-pad hidden text-right\" ><i class=\"fa fa-bell-slash\"></i><\/div>";
            }
            html += "                    <\/li>";
            $("#groups").prepend(html);
            createGroupImage(group.groupId);
        }
        // this function prints group list on the left side
        function printGroupListAppend(groups) {
        
            let html = "";
            groupIds = [];
            time = {};
            for (let i = 0; i < groups.length; i++) {
                groupObjects[groups[i].groupId] = groups[i];
                groupIds.push(groups[i].groupId);
                time[groups[i].groupId] = groups[i].lastActive;
                if (groups[i].pendingMessage > 0) {
                    html += " <li class=\"person font-bold-black\" data-chat=\"person1\" id='group_" + groups[i].groupId + "' data-mecreator=\"" + groups[i].meCreator + "\"  data-type=\"" + groups[i].groupType + "\" data-block=\"" + groups[i].block + "\" data-mute=\"" + groups[i].mute + "\" data-group=\"" + groups[i].groupId + "\">";
                } else {
                    html += " <li class=\"person \" data-chat=\"person1\" id='group_" + groups[i].groupId + "' data-mecreator=\"" + groups[i].meCreator + "\"  data-type=\"" + groups[i].groupType + "\" data-block=\"" + groups[i].block + "\" data-mute=\"" + groups[i].mute + "\" data-group=\"" + groups[i].groupId + "\">";
                }

                groupImages[groups[i].groupId] = groups[i].groupImage;

                html += '<span id="groupImage_' + groups[i].groupId + '">';
                /*for (let j = 0; j < groups[i].groupImage.length; j++) {
                    if (parseInt(groups[i].groupType) == 1 && groups[i].members.length > 0) {
                        if (  groups[i].members[0].active == 1) {
                            html += "                        <img  class='img-responsive img-circle memberActive group_member_" + groups[i].members[0].userId + "' style=\"width: 40px; height: 40px;border-radius: 50%\" src=\"" + groups[i].groupImage[j] + "\" >";
                        } else {
                            html += "                        <img  class='img-responsive img-circle group_member_" + groups[i].members[0].userId + "' style=\"width: 40px; height: 40px;border-radius: 50%\" src=\"" + groups[i].groupImage[j] + "\" >";
                        }
                    } else {
                        html += "                        <img class=\"img-responsive img-circle\" style=\"width: 40px; height: 40px;border-radius: 50%\" src=\"" + groups[i].groupImage[j] + "\" >";
                    }
                }*/
                html += '</span>';
                html += "                        <span class=\"name\" id='groupName_" + groups[i].groupId + "' style=\"overflow: hidden\"><div>" + groups[i].groupName + "</div><\/span>";
                let date = moment(groups[i].lastActive, moment.ISO_8601).fromNow();
                html += "                        <span id='time_" + groups[i].groupId + "' class=\"time\">" + date + "<\/span>";
                if (groups[i].messageType === "text") {
                    let recentMessage = groups[i].recentMessage;
                    if (recentMessage.includes('🐂')){
                        // var str = 'You: <img class="emoj" src="https://vyndue.com/assets/newTheme/assets/js/twemoji/2/72x72/1f402.png" style="background: none;width: 20px !important;height: 20px !important;display: inline-block;float: none;">'
                        recentMessage = recentMessage.replace(/🐂/g,'<img class="emoj" src="https://vyndue.com/assets/newTheme/assets/js/twemoji/2/72x72/1f402.png" style="background: none;width: 20px !important;height: 20px !important;display: inline-block;float: none;">');
                        // console.log("test2");
                        // recentMessage = str;
                    }
                    else if (recentMessage.includes('🐻')){
                            // var str = 'You: <img class="emoj" src="https://vyndue.com/assets/newTheme/assets/js/twemoji/2/72x72/1f402.png" style="background: none;width: 20px !important;height: 20px !important;display: inline-block;float: none;">'
                            recentMessage = recentMessage.replace(/🐻/g,'<img class="emoj" src="https://vyndue.com/assets/newTheme/assets/js/twemoji/2/72x72/1f43b.png" style="background: none;width: 20px !important;height: 20px !important;display: inline-block;float: none;">');
                            // console.log("test2");
                            // recentMessage = str;
                    }
                    if (recentMessage === null) {
                        recentMessage = '';
                    }
                    html += "<span style='float: left' id='messageType_" + groups[i].groupId + "' class=\"preview\">" + recentMessage + "<\/span>";
                } else {
                    let messageType = groups[i].messageType;
                    if (messageType === null) {
                        messageType = '';
                    }
                    html += "<span style='float: left' id='messageType_" + groups[i].groupId + "' class=\"preview\">" + messageType + "<\/span>";
                }
                if (groups[i].mute) {
                    html += "<div style='' id='mute_" + groups[i].groupId + "' class=\"mute-pad  text-right\" ><i class=\"fa fa-bell-slash\"></i><\/div>";
                } else {
                    html += "<div style='' id='mute_" + groups[i].groupId + "' class=\"mute-pad hidden text-right\" ><i class=\"fa fa-bell-slash\"></i><\/div>";
                }
                html += "                    <\/li>";
            }
            $("#groups").append(html);
            for (let i = 0; i < groups.length; i++) {
                createGroupImage( groups[i].groupId);
            }
            let scrollXClone = $(".ps__scrollbar-x-rail").clone();
            let scrollYClone = $(".ps__scrollbar-y-rail").clone();
            $(".ps__scrollbar-x-rail").remove();
            $(".ps__scrollbar-y-rail").remove();
            $("#groups").append(scrollXClone);
            $("#groups").append(scrollYClone);
        }
        function printGroupList(groups, image) {
            let html = "";
            groupIds = [];
            time = {};
            for (let i = 0; i < groups.length; i++) {
                groupIds.push(groups[i].groupId);
                groupObjects[groups[i].groupId] = groups[i];
                time[groups[i].groupId] = groups[i].lastActive;

                // Communities Group Section ------------------------------------------------------------------------------------
                // if(groups[i].groupType == 2 || groups[i].groupType == 0){
                if (groups[i].pendingMessage > 0) {
                    html += " <li class=\"person font-bold-black\" data-chat=\"person1\" id='group_" + groups[i].groupId + "' data-mecreator=\"" + groups[i].meCreator + "\"  data-type=\"" + groups[i].groupType + "\" data-block=\"" + groups[i].block + "\" data-mute=\"" + groups[i].mute + "\" data-group=\"" + groups[i].groupId + "\">";
                } else {
                    html += " <li class=\"person \" data-chat=\"person1\" id='group_" + groups[i].groupId + "' data-mecreator=\"" + groups[i].meCreator + "\"  data-type=\"" + groups[i].groupType + "\" data-block=\"" + groups[i].block + "\" data-mute=\"" + groups[i].mute + "\" data-group=\"" + groups[i].groupId + "\">";
                    
                }
                groupImages[groups[i].groupId] = groups[i].groupImage;
                html += '<span id="groupImage_' + groups[i].groupId + '">';
                html += '<span id="groupImghandler">';
                for (let j = 0; j < groups[i].groupImage.length; j++) {
                    if (parseInt(groups[i].groupType) == 1 && groups[i].members.length > 0) {
                        if (groups[i].members[0].active == 1) {
                            html += "<img  class='img-responsive img-circle memberActive group_member_" + groups[i].members[0].userId + "' style=\"width: 40px; height: 40px;border-radius: 49%\" src=\"" + groups[i].groupImage[j] + "\" >";
                        } else {
                            html += "<img  class='img-responsive img-circle group_member_" + groups[i].members[0].userId + "' style=\"width: 40px; height: 40px;border-radius: 49%\" src=\"" + groups[i].groupImage[j] + "\" >";
                        }
                    } else {
                        if(groups[i].groupImage.length == 2){
                            // console.log(groups[i].groupImage)
                            html += "<img class=\"img-responsive img-circle ms2\" style=\"width: 40px; height: 40px;border-radius: 49%\" src=\"" + groups[i].groupImage[j] + "\" >";
                        } else if (groups[i].groupImage.length == 3){
                            html += "<img class=\"img-responsive img-circle ms3\" style=\"width: 40px; height: 40px;border-radius: 49%\" src=\"" + groups[i].groupImage[j] + "\" >";
                        }
                    }
                }
                html += '</span>';
                html += '</span>';
                html += "                        <span class=\"name\" id='groupName_" + groups[i].groupId + "' style=\"overflow: hidden\"><div>" + groups[i].groupName + "</div><\/span>";
                let date = moment(groups[i].lastActive, moment.ISO_8601).fromNow();
                html += "                        <span id='time_" + groups[i].groupId + "' class=\"time\">" + date + "<\/span>";
                if (groups[i].messageType === "text") {
                    let recentMessage = groups[i].recentMessage;
                    //console.log(recentMessage);
                    // let message = data[i].message;
                    if (recentMessage.includes('🐂')){
                        // var str = 'You: <img class="emoj" src="https://vyndue.com/assets/newTheme/assets/js/twemoji/2/72x72/1f402.png" style="background: none;width: 20px !important;height: 20px !important;display: inline-block;float: none;">'
                        recentMessage = recentMessage.replace(/🐂/g,'<img class="emoj" src="https://vyndue.com/assets/newTheme/assets/js/twemoji/2/72x72/1f402.png" style="background: none;width: 20px !important;height: 20px !important;display: inline-block;float: none;">');
                        // console.log("test2");
                        // recentMessage = str;
                    }
                    else if (recentMessage.includes('🐻')){
                            // var str = 'You: <img class="emoj" src="https://vyndue.com/assets/newTheme/assets/js/twemoji/2/72x72/1f402.png" style="background: none;width: 20px !important;height: 20px !important;display: inline-block;float: none;">'
                            recentMessage = recentMessage.replace(/🐻/g,'<img class="emoj" src="https://vyndue.com/assets/newTheme/assets/js/twemoji/2/72x72/1f43b.png" style="background: none;width: 20px !important;height: 20px !important;display: inline-block;float: none;">');
                            // console.log("test2");
                            // recentMessage = str;
                    }
                    // if(message.message == '&#x1f402'){
                    //     message.message = '<img src="https://vyndue.com/assets/newTheme/assets/js/twemoji/2/72x72/1f402.png">';
                    // }
                    // console.log(groups[i]);
                    if (recentMessage === null) {
                        recentMessage = '';
                    }
                    html += "<span style='float: left' id='messageType_" + groups[i].groupId + "' class=\"preview lll\">" + recentMessage + "<\/span>";
                } else {
                    let messageType = groups[i].messageType;
                    if (messageType === null) {
                        messageType = '';
                    }
                    html += "<span style='float: left' id='messageType_" + groups[i].groupId + "' class=\"preview mmmm\">" + messageType + "<\/span>";
                }
                if (groups[i].mute) {
                    html += "<div style='' id='mute_" + groups[i].groupId + "' class=\"mute-pad  text-right\" ><i class=\"fa fa-bell-slash\"></i><\/div>";
                } else {
                    html += "<div style='' id='mute_" + groups[i].groupId + "' class=\"mute-pad hidden text-right\" ><i class=\"fa fa-bell-slash\"></i><\/div>";
                }
                html += "                    <\/li>";
                // }
                // End Communities Section ------------------------------------------------------------------------------------
            }
            $("#groups").html(html);
            for (let i = 0; i < groups.length; i++) {
                createGroupImage(groups[i].groupId);
            }
            
        }

        //This function is used to get the group list
        function getGroupList_v2(callback) {
            let url = "<?php echo base_url('imApi/getGroups?limit='); ?>" + groupLimit + "&start=0";
            if (ID_BASED) {
                url = "<?php echo base_url('imApi/getGroups?limit='); ?>" + groupLimit + "&start=0&userId=" + userId;
            }
            let settings = {
                "async": true,
                "crossDomain": true,
                "url": url,
                "method": "GET",
                "headers": {
                    "authorization": "Basic YWRtaW46MTIzNA==",
                    "Authorizationkeyfortoken": String(responce),
                    "cache-control": "no-cache",
                    "postman-token": "eb27c011-391a-0b70-37c5-609bcd1d7b6d"
                },
                "processData": false,
                "contentType": false,
                "statusCode": {
                    401: function (error) {
                        location.href = "<?php echo base_url('userview/logout'); ?>";
                    }
                },
                "beforeSend": function () {
                },
                "complete": function () {
                }
            };
            $.ajax(settings).done(function (response) {
                let groups = response.response;
                totalGroup = parseInt(response.status.total);
                if (totalGroup == 0) {
                    $('#addMember').attr('data-group', null);
                    $('#addMember').addClass("hidden");
                    chatBox.html('');
                    chatBox.addClass("text-center");
                    $(".groupInfoContent").addClass("hidden");
                } else {
                    $(".groupInfoContent").removeClass("hidden");
                    printGroupList(groups);
                    if (callback != null || callback != "") {
                        callback(groups);
                        setTimeout(() => {
                            $("#groups li").first().trigger("click", [{update: true}]);                           
                        }, 500);
                    } else {
                        $("#groups li").first().trigger("click", [{update: true}]);
                    }
                }
            });
        }


        //This function is used to get the group list
        function getGroupList(callback) {
            let url = "<?php echo base_url('imApi/getGroups?limit='); ?>" + groupLimit + "&start=0";
            if (ID_BASED) {
                url = "<?php echo base_url('imApi/getGroups?limit='); ?>" + groupLimit + "&start=0&userId=" + userId;
            }
            let settings = {
                "async": true,
                "crossDomain": true,
                "url": url,
                "method": "GET",
                "headers": {
                    "authorization": "Basic YWRtaW46MTIzNA==",
                    "Authorizationkeyfortoken": String(responce),
                    "cache-control": "no-cache",
                    "postman-token": "eb27c011-391a-0b70-37c5-609bcd1d7b6d"
                },
                "processData": false,
                "contentType": false,
                "statusCode": {
                    401: function (error) {
                        location.href = "<?php echo base_url('userview/logout'); ?>";
                    }
                },
                "beforeSend": function () {
                },
                "complete": function () {
                }
            };
            $.ajax(settings).done(function (response) {
                $(".page-contents").show();
                init_twemoji();
                let groups = response.response;


                totalGroup = parseInt(response.status.total);
                if (totalGroup == 0) {
                    $('#addMember').attr('data-group', null);
                    $('#addMember').addClass("hidden");
                    chatBox.html('');
                    chatBox.addClass("text-center");
                    $(".groupInfoContent").addClass("hidden");
                    //$('#groupMembers').html("");
                    //$('#groups').html('');
                    //$("#editGroupName").addClass("hidden");
                    //$('.UserNames').html('');
                } else {
                    //$('#addMember').removeClass("hidden");
                    //$("#editGroupName").removeClass("hidden");
                    $(".groupInfoContent").removeClass("hidden");
                    printGroupList(groups);
                    // $("#groups li").first().trigger("click");
                    if (callback != null || callback != "") {
                        //if (groups.length > 0) {
                        callback(groups); //true
                        /*} else {
                            callback(groups); //false
                        }*/
                    } else {
                        $("#groups li").first().trigger("click", [{update: true}]);
                    }
                }
            });
        }
        function getFileIcon(type) {
            let defaultIcon = "fa fa-file";
            let iconArray = [
                {type: "text", icon: "fas fa-file-alt"}, {type: "txt", icon: "fas fa-file-alt"},
                {type: "video", icon: "fas fa-file-video"},
                {type: "audio", icon: "fa fa-file-audio-o"},
                {type: "pdf", icon: "fa fa-file-pdf-o"},
                {type: "doc", icon: "fa fa-file-word-o"}, {type: "docx", icon: "fa fa-file-word-o"},
                {type: "ppt", icon: "fa fa-file-powerpoint-o"}, {type: "pptx", icon: "fa fa-file-powerpoint-o"},
                {type: "xls", icon: "fa fa-file-excel-o"}, {type: "xlsx", icon: "fa fa-file-excel-o"},
                {type: "rar", icon: "fa fa-file-archive-o"}, {type: "zip", icon: "fa fa-file-archive-o"},
            ];
            for (let i = 0; i < iconArray.length; i++) {
                if (iconArray[i].type == type) {
                    return iconArray[i].icon;
                }
            }
            return defaultIcon;
        }
        //this function is used to print the group member list on the right side
        function printGroupMembers(members, meCreator, groupId, data={}) {

            let creatorEmail = (data.creatorEmail!=undefined) ? data.creatorEmail : null ;
            let moderator = (data.moderator!=undefined) ? data.moderator : 0 ;

            let html = "";
            membersId = [];
            html += "<div class='row topor'><div class='col-md-12'><div class='TitleUpper'>Community Members:</div></div></div>";
            if (members.length <= 0) {
                if (!$("#groupMembers").hasClass("hidden")) {
                    $("#groupMembers").addClass("hidden");
                }
            } else {
                if ($("#groupMembers").hasClass("hidden")) {
                    $("#groupMembers").removeClass("hidden");
                }
            }
            html += "<div class='l23-container'>";
            for (let i = 0; i < members.length; i++) {

                membersId.push(members[i].userId);
                
                <?php

                    $hash = rand(123456789, 987654321).rand(123456789, 987654321).rand(123456789, 987654321).rand(123456789, 987654321).rand(123456789, 987654321).rand(123456789, 987654321).rand(123456789, 987654321).rand(123456789, 987654321).rand(123456789, 987654321).rand(123456789, 987654321);

                ?>

                let userlevel = 0;
                if (members[i].userEmail==creatorEmail) userlevel = 1;
                else if (parseInt(members[i].moderator)>0) userlevel = 2;
                else userlevel = 0;  

                html += "<li class=\"person\"  style=\"padding-top: 5px;padding-bottom: 0px;height:50px;cursor: default;\">";
                if (members[i].active === 1) {
                    html += "<img class='' id='member_" + members[i].userId + "' src=\"" + members[i].profilePictureUrl + "\" alt=\"\" \/><span class='memberStatus memberActive'></span>";
                } else {
                    html += "<img class='' id='member_" + members[i].userId + "' src=\"" + members[i].profilePictureUrl + "\" alt=\"\" \/><span class='memberStatus memberOffline'></span>";
                }
                html += "<span  class=\"name\"><div><a href='https://arbitrage.ph/getuser/?hsh=<?php echo $hash; ?>&eml=" + members[i].userEmail + "'  target='_self'>" + members[i].firstName + " " + members[i].lastName +"<\/a><\/div><\/span>";
                html += "<span class='vyndue_at_email'><a href='https://arbitrage.ph/getuser/?hsh=<?php echo $hash; ?>&eml=" + members[i].userEmail + "' target='_self'>View Profile<\/a><\/span>";   

                switch (userlevel) {
                    case 1: // admin
                        html += `<span class="time" style='padding-top: 5px'>
                                    <div class="arbitrage-button arbitrage-button--warning disabled" style="cursor: default;">
                                        <i class="fa fa-star fa-fw" title="Community Administrator"></i>
                                    </div>
                                </span>`; 
                    break;
                    case 2: // moderator
                        html += `<span class="time" style='padding-top: 5px'>
                                    <div class="arbitrage-button arbitrage-button--success disabled" style="cursor: default;">
                                        <i class="fa fa-balance-scale" title="Community Moderator"></i>
                                    </div>
                                </span>`;
                    break;
                    case 0: // member
                        if(meCreator || moderator){
                            html += `<span class="time" style='padding-top: 5px;'>
                                            <a href="#" data-group="${ groupId } " data-member="${ members[i].userId }" class="btn-danger btn-extra-small btnMemberDelete">
                                                    <i class="fa fa-trash"></i>
                                            </a>
                                    </span>`;
                        }
                    break;
                }                
                html += "</li>";

            }
            html += "</div>";
            $('#groupMembers').html(html);
        }
        function printGroupFiles(groupFiles) {
            if (groupFiles.length > 0) {
                if ($("#attachment").hasClass("hidden")) {
                    $("#attachment").removeClass("hidden");
                }
            }
            else {
                if (!$("#attachment").hasClass("hidden")) {
                    $("#attachment").addClass("hidden");
                }
            }
            let strVar = "";
            for (let i = 0; i < groupFiles.length; i++) {
                let strdocslink = groupFiles[i].message;
                
                if (!strdocslink.includes('https://')){
                    strdocslink = "../assets/temp/"+ groupFiles[i].message;
                }
                strVar += "<li>";
                strVar += "                        <i class='" + getFileIcon(groupFiles[i].type) + "'><\/i>";
                strVar += "                        <span>";
                strVar += "                            <a  target='_blank'style=\"color: #75aef3;\" href='" + strdocslink + "'>";
                strVar += groupFiles[i].fileName;
                strVar += "                            <\/a>";
                strVar += "                        <\/span>";
                strVar += "                    <\/li>";
            }
            $("#attachmentList").html(strVar);
        }
        function printGroupImages(groupImages) {
        
            if (groupImages.length > 0) {
                if ($("#imageAttachment").hasClass("hidden")) {
                    $("#imageAttachment").removeClass("hidden");
                }
            }
            else {
                if (!$("#imageAttachment").hasClass("hidden")) {
                    $("#imageAttachment").addClass("hidden");
                }
            }
            let strVar = "";
            for (let i = 0; i < groupImages.length; i++) {
                let strlink = groupImages[i].message;
    
                if (!strlink.includes('https://')){
                    strlink = "../assets/temp/"+ groupImages[i].message;
                }
                strVar += "<div class=\" pad-5\" style='float: left;'>";
                strVar += "                            <a href='" + strlink + "' class=\"hover-5 ol-lightbox\">";
                strVar += "                                <img src='" + strlink + "' alt=\"image hover\">";
                strVar += "                                <div class=\"ol-overlay ov-light-alpha-80\"><\/div>";
                strVar += "                                <div class=\"icons\"><i class=\"fa fa-camera\"><\/i><\/div>";
                strVar += "                            <\/a>";
                strVar += "                    <\/div>";
            }
            $("#ImageAttachmentList").html(strVar);
            lightBox.init();
        }
        //This function is used to get the group member list
        function getGroupMembers(groupId) {
            let url = "<?php echo base_url('imApi/getMembers?groupId='); ?>" + groupId;
            if (ID_BASED) {
                url = "<?php echo base_url('imApi/getMembers?groupId='); ?>" + groupId + "&userId=" + userId;
            }
            let settings = {
                "async": true,
                "crossDomain": true,
                "url": url,
                "method": "GET",
                "headers": {
                    "authorization": "Basic YWRtaW46MTIzNA==",
                    "Authorizationkeyfortoken": String(responce),
                    "cache-control": "no-cache",
                    "postman-token": "eb27c011-391a-0b70-37c5-609bcd1d7b6d"
                },
                "processData": false,
                "contentType": false,
                "beforeSend": function () {
                    $('#groupMembers').html('<li id="loadinggroupmembers" class="text-center"><img src="<?php echo base_url('assets/img/arb_preloader.svg'); ?>" style="width:50px;margin-top: 20px;"></li>');
                },
                "success": function () {
                    $("#loadinggroupmembers").remove();
                }
            };
            $.ajax(settings).done(function (response) {
                // console.log('test');
                // console.log(response);
                let members = response.response.memberList;
                let meCreator = response.response.meCreator;
                let creatorEmail = response.response.creatorEmail;
                let moderator = response.response.moderator;
                //let groupFiles = response.response.groupFiles;
                //let groupImages = response.response.groupImages; 
                printGroupMembers(members, meCreator, groupId, { creatorEmail , moderator } );
                //printGroupFiles(groupFiles);
                //printGroupImages(groupImages);
            });
        }
        function getGroupFiles(groupId) {
            /* if (!$("#imageAttachment").hasClass("hidden")) {
                 $("#imageAttachment").addClass("hidden");
             }
             if (!$("#attachment").hasClass("hidden")) {
                 $("#attachment").addClass("hidden");
             }*/
            //$("#ImageAttachmentList").html("");
            //$("#attachmentList").html("");
            let url = "<?php echo base_url('imApi/getGroupFiles?groupId='); ?>" + groupId;
            if (ID_BASED) {
                url = "<?php echo base_url('imApi/getGroupFiles?groupId='); ?>" + groupId + "&userId=" + userId;
            }
            let settings = {
                "async": true,
                "crossDomain": true,
                "url": url,
                "method": "GET",
                "headers": {
                    "Authorization": "Basic YWRtaW46MTIzNA==",
                    "Authorizationkeyfortoken": String(responce),
                    "Cache-Control": "no-cache",
                    "Postman-Token": "fc25d304-c91a-4a8e-babf-0676ba176084"
                }
            };
            $.ajax(settings).done(function (response) {
                let groupFiles = response.response.groupFiles;
                let groupImages = response.response.groupImages;
                printGroupFiles(groupFiles);
                printGroupImages(groupImages);
            });
        }
        // callback function to get user info by its username
        function getUrlParameter(sParam) {
            var sPageURL = window.location.search.substring(1),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;

            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');

                if (sParameterName[0] === sParam) {
                    return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
                }
            }
        };
        //This function is used to print the group name and three member image on the right side top
        function printGroupInfo(groupId, groupImages, groupName) {
            if(groupObjects[groupId].hasOwnProperty('groupImageData')) {
                let image = groupObjects[groupId].groupImageData;
                let html = "<img class=\"img-responsive img-circle\" style=\"width: 50px; height: 50px;border-radius: 50%\" src=\"" + image + "\" >";
                $('.rightGroupImages').html(html);
            }else{
                let c = document.createElement("canvas");
                let ctx = c.getContext("2d");
                ctx.canvas.width = 500;
                ctx.canvas.height = 500;
                ctx.fillStyle = "white";
                ctx.fillRect(0, 0, c.width, c.height);
                ctx.moveTo(0, 0);
                if (groupObjects[groupId].groupImage.length === 1) {
                    let html = "<img class=\"img-responsive img-circle\" style=\"width: 50px; height: 50px;border-radius: 50%\" src=\"" + groupObjects[groupId].groupImage[0] + "\" >";
                    $('.rightGroupImages').html(html);
                } else if (groupObjects[groupId].groupImage.length === 2) {
                    let imageObj1 = new Image();
                    imageObj1.src = groupObjects[groupId].groupImage[0];
                    imageObj1.onload = (function (groupId) {
                        return function () {
                            ctx.drawImage(imageObj1, 0, 0, 250, 500);
                            let imageObj2 = new Image();
                            imageObj2.src = groupObjects[groupId].groupImage[1];
                            imageObj2.onload = (function (groupId) {
                                return function () {
                                    ctx.drawImage(imageObj2, 260, 0, 250, 500);
                                    let html = "<img class=\"img-responsive img-circle\" style=\"width: 50px; height: 50px;border-radius: 50%\" src=\"" + c.toDataURL("image/png") + "\" >";
                                    $('.rightGroupImages').html(html);
                                }
                            })(groupId);
                        }
                    })(groupId);
                } else if (groupObjects[groupId].groupImage.length === 3) {
                    let imageObj1 = new Image();
                    imageObj1.src = groupObjects[groupId].groupImage[0];
                    imageObj1.onload = (function (groupId) {
                        return function () {
                            ctx.drawImage(imageObj1, 0, 0, 320, 500);
                            let imageObj2 = new Image();
                            imageObj2.src = groupObjects[groupId].groupImage[1];
                            imageObj2.onload = (function (groupId) {
                                return function () {
                                    ctx.drawImage(imageObj2, 330, 0, 250, 250);
                                    let imageObj3 = new Image();
                                    imageObj3.src = groupObjects[groupId].groupImage[2];
                                    imageObj3.onload = (function (groupId) {
                                        return function () {
                                            ctx.drawImage(imageObj3, 330, 260, 250, 250);
                                            let html = "<img class=\"img-responsive img-circle\" style=\"width: 50px; height: 50px;border-radius: 50%\" src=\"" + c.toDataURL("image/png") + "\" >";
                                            $('.rightGroupImages').html(html);
                                        }
                                    })(groupId);
                                }
                            })(groupId);
                        }
                    })(groupId);
                }
            }
            $('.be-use-name').html(groupName);
            $clamp($('.be-use-name')[0], {clamp: 2, useNativeClamp: false});
        }
        function clampData() {
            $('.clamp-desc').each(function (index, element) {
                $clamp(element, {clamp: 3, useNativeClamp: false});
            });
            $('.clamp-title').each(function (index, element) {
                $clamp(element, {clamp: 3, useNativeClamp: false});
            });
        }
        // callback function to fetch all membered group and mingled friends
        function getSearchList(callback){
            resetFriendStart();
            let url = "<?php echo base_url('user/searchList?start='); ?>" + friendStart + "&limit=" + friendLimit;
            if (ID_BASED) {
                url = "<?php echo base_url('user/searchList?start='); ?>" + friendStart + "&limit=" + friendLimit + "&userId=" + userId;
            }
            let settings = {
                "async": true,
                "crossDomain": true,
                "url": url,
                "method": "GET",
                "headers": {
                    "authorization": "Basic YWRtaW46MTIzNA==",
                    "Authorizationkeyfortoken": String(responce),
                    "cache-control": "no-cache",
                    "postman-token": "eb27c011-391a-0b70-37c5-609bcd1d7b6d"
                },
                "dataType": 'json'
            };
            $.ajax(settings).done(function (response) {
               callback(response);
            });
        }

        //This function is userd to get memntion person in a group
        function getMention(callback) {
            let url = "<?php echo base_url('user/mentionList?groupId='); ?>" + activeGroupId;
            if (ID_BASED) {
                url = "<?php echo base_url('user/mentionList?groupId='); ?>" + activeGroupId + "&userId=" + userId;
            }
            let settings = {
                "async": true,
                "crossDomain": true,
                "url": url,
                "method": "GET",
                "headers": {
                    "authorization": "Basic YWRtaW46MTIzNA==",
                    "Authorizationkeyfortoken": String(responce),
                    "cache-control": "no-cache",
                    "postman-token": "eb27c011-391a-0b70-37c5-609bcd1d7b6d"
                },
                "dataType": 'json'
            };
            $.ajax(settings).done(function (response) {
               let res = response.response.data;
               callback(res);
            });
        }

        //This function is used to get all stock list
        function getStock(callback) {
            let url = "/data-api/stocklist/";
            let settings = {
                "async": true,
                "crossDomain": true,
                "url": url,
                "method": "GET",
                "dataType": 'json'
            };
            $.ajax(settings).done(function (response) {
               let res = response.data;
               callback(res);
            });
        }

        //This function is used to get stock current state 
        function getStockLatest(symbol, callback) {
            let url = "/data-api/history/PSE/" + symbol;
            let settings = {
                "async": true,
                "crossDomain": true,
                "url": url,
                "method": "GET",
                "dataType": 'json'
            };
            $.ajax(settings).done(function (response) {
               let res = response.data;
               callback(res);
            });
        }

        //This function is used to  get friend list of user
        function getMembers(callback) {   // get friends list
            resetFriendStart();
            let url = "<?php echo base_url('user/friendList?start='); ?>" + friendStart + "&limit=" + friendLimit;
            if (ID_BASED) {
                url = "<?php echo base_url('user/friendList?start='); ?>" + friendStart + "&limit=" + friendLimit + "&userId=" + userId;
            }
            let settings = {
                "async": true,
                "crossDomain": true,
                "url": url,
                "method": "GET",
                "headers": {
                    "authorization": "Basic YWRtaW46MTIzNA==",
                    "Authorizationkeyfortoken": String(responce),
                    "cache-control": "no-cache",
                    "postman-token": "eb27c011-391a-0b70-37c5-609bcd1d7b6d"
                },
                "dataType": 'json'
            };
            $.ajax(settings).done(function (response) {
                let data = response.response.friends;
                totalFriend = response.response.total;
                callback(data);
            });
        }

        // callback function to get user info by its username
        window.promptChat = function(name) {
            return;
            var username = name.substring(3);
            //var username = location.search.split('us=')[1];
            if(!username.length) return;
            
            let url = "<?php echo base_url('user/hasConversation_byUserSecret?username='); ?>" + username;
            if (ID_BASED) {
                url = "<?php echo base_url('user/hasConversation_byUserSecret?username='); ?>" + username + "&userId=" + userId;
            }

            let settings = {
                "async": true,
                "crossDomain": true,
                "url": url,
                "method": "GET",
                "headers": {
                    "authorization": "Basic YWRtaW46MTIzNA==",
                    "Authorizationkeyfortoken": String(responce),
                    "cache-control": "no-cache",
                    "postman-token": "eb27c011-391a-0b70-37c5-609bcd1d7b6d"
                },
                "dataType": 'json'
            };
            $.ajax(settings).done(function (response) {
                var groupId = response.response.groupId;
                var fid = response.response.fid;
                var mingled = response.response.mingled;
                if(!mingled){
                    //alert("Error: You are not mingled with this person");
                    console.log("Error: You are not mingled with this person");
                    return;
                }
                if(groupId>0){
                    $("li#group_"+groupId).first().trigger("click", [{update: true}]);
                }else{
                    addmember.empty();
                    addmember.clear();
                    addmember.disable();
                    $("div#newMessage").first().trigger("click", [{update: true}]);
                        setTimeout(() => {
                            addmember.setValue({id:fid});
                            addmember.enable();
                        }, 1000);
                }
            });
        }

        //This function is used to clear the current chat box for retrieving new message for the new group
        function clearChatBox() {
            chatBox.html('');
        }
        function getImagePreview(message){
            let defaultImage = "<?php echo base_url('/assets/img/compact_camera1600.png'); ?>";
            let linkData=JSON.parse(message.linkData);
            let z = message.message;
            let x = z.search("https://storage");
            let strippedLink = z.substring(x, (z.length));
            if(x == -1) {
                var limiter = strippedLink.search("/im/");
                var dir = strippedLink.substring(0, limiter + 1);
                var fileName = strippedLink.lastIndexOf("/");
                strippedLink = dir + "temp" + strippedLink.substring(fileName, strippedLink.length);
            }
            let  html = "<div id='message_" + message.m_id + "' class=\"fw-im-attachments fw-im-message-text\"><a style='display: inline-block; max-height: 450px;' href=\"" + strippedLink + "\" class=\"hover-5 ol-lightbox\"><img onerror='this.style.display=\"none\";' style='max-height: 450px; width: auto;' src=\"" + strippedLink + "\" alt=\"image hover\">";
            if(linkData!=null && linkData.hasOwnProperty("playerOrImageUrl") && linkData.playerOrImageUrl.hasOwnProperty("size") && linkData.playerOrImageUrl.size!=null && linkData.playerOrImageUrl.size.hasOwnProperty("height") && linkData.playerOrImageUrl.size.height!=null &&linkData.playerOrImageUrl.size.hasOwnProperty("width") && linkData.playerOrImageUrl.size.width!=null ){
                html = "<div id='message_" + message.m_id + "' class=\"fw-im-attachments fw-im-message-text\"><a style='display: inline-block; max-height: 450px;' href=\"" + strippedLink + "\"  class=\"hover-5 ol-lightbox\"><img onerror='this.style.display=\"none\";' style='max-height: 450px; width: auto;' src=\"" + strippedLink + "\" alt=\"image hover\">";
            }
            html += "                            <div class=\"ol-overlay ov-light-alpha-80\"><\/div>";
            html += "                            <div class=\"icons\"><i class=\"fa fa-camera\"><\/i><\/div><\/a>";
            html += "                            <\/div>";
         
            return html;
        }
        //This function is used to create the preview for a link sheared in message
        function getLinkPreview(linkData, link) {
            let defaultImage = "<?php echo base_url('/assets/img/compact_camera1600.png'); ?>";
            if (linkData.playerOrImageUrl.type === 'player') {
                return "<div class='i-wrapper'><iframe src='" + linkData.playerOrImageUrl.url + "' class='medea-frame iframe-wrapper' allowfullscreen></iframe></div>";
            }
            else if (linkData.playerOrImageUrl.type === 'file') {
                let image = "<img src='" + linkData.playerOrImageUrl.url + "' id='tImg' width='100%' onerror='this.style.display=\"none\";' >";
                if(linkData.playerOrImageUrl.hasOwnProperty("size") && linkData.playerOrImageUrl.size!=null && linkData.playerOrImageUrl.size.hasOwnProperty("height") && linkData.playerOrImageUrl.size.height!=null &&linkData.playerOrImageUrl.size.hasOwnProperty("width") && linkData.playerOrImageUrl.size.width!=null ){
                    image = "<img src='" + linkData.playerOrImageUrl.url + "' id='tImg' width='100%' onerror='this.style.display=\"none\";' style='height:"+linkData.playerOrImageUrl.size.height+"px; width:"+linkData.playerOrImageUrl.size.width +"px;' >";
                }
                return "<a href='" + link + "' target=\"_blank\" >" +
                    "<div class='linkPreview-wrapper'>" +
                    "<div class='link-file' >" + image +
                    "</div> " +
                    "</div>" +
                    "</a>";
            }
            else {
                let image = "<img src='<?php echo base_url('/assets/img/compact_camera1600.png'); ?>' id='tImg_blank' width='100%'>";
                let returnString="";
                if (linkData.playerOrImageUrl.url != null) {
                    image = "<img src='" + linkData.playerOrImageUrl.url + "' id='tImg' width='100%' onerror='this.style.display=\"none\";' >";
                    returnString= "<a href='" +link + "' target=\"_blank\" >" +
                        "<div class='linkPreview-wrapper'>" +
                        "<div id='texts'>" +
                        "<div id='thumbnail' >" + image +
                        "</div> " +
                        "<div id='desc'>" +
                        "<div id='title'>" +
                        "<div class='clamp-title'>" + linkData.title +
                        "</div>" +
                        "</div>" +
                        "<div class='clamp-desc'>" + linkData.description +
                        "</div> " +
                        "<div id='meta'>" +
                        "<div id='domain'>" + linkData.host +
                        "</div>" +
                        "<div class='clear'></div>" +
                        "</div>" +
                        "</div>" +
                        "</div>" +
                        "</div>" +
                        "</a>";
                }
                returnString= "<a href='" + link + "' target=\"_blank\" >" +
                    "<div class='linkPreview-wrapper'>" +
                    "<div id='texts'>" +
                    "<div id='thumbnail' >" + image +
                    "</div> " +
                    "<div id='desc'>" +
                    "<div id='title'>" +
                    "<div class='clamp-title'>" + linkData.title +
                    "</div>" +
                    "</div> " +
                    "<div class='clamp-desc'>" + linkData.description +
                    "</div> " +
                    "<div id='meta'>" +
                    "<div id='domain'>" + linkData.host +
                    "</div>" +
                    "<div class='clear'></div>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</a>";
               /* if(String(linkData.description).length===0){
                    returnString="";
                }*/
                return returnString;
            }
        }
        //This function is used to format the links and add the emojis send by user
        function parseMessage(message, onlyemoji) {
            if (onlyemoji) {
                return twemoji.parse(
                    anchorme(message, {
                        //truncate:[15,10],
                        attributes: [
                            function (urlObj) {
                                if (urlObj.protocol !== "mailto:")
                                    return {name: "target", value: "blank"};
                            }
                        ]
                    }), {className: "emoji2x"}
                );
            }
            return twemoji.parse(
                anchorme(message, {
                    //truncate:[15,10],
                    attributes: [
                        function (urlObj) {
                            if (urlObj.protocol !== "mailto:")
                                return {name: "target", value: "blank"};
                        }
                    ]
                })
            );
        }
        //This function is used to retrieve messages from server based on group id
        function getMessage(groupId) {
            if (start == 1) {
                start = 0;
            }
            let url = "<?php echo base_url('imApi/getMessage?groupId='); ?>" + groupId + "&limit=" + limit + "&start=" + start;
            if (ID_BASED) {
                url = "<?php echo base_url('imApi/getMessage?groupId='); ?>" + groupId + "&limit=" + limit + "&start=" + start + "&userId=" + userId;
            }
            let settings = {
                "async": true,
                "crossDomain": true,
                "url": url,
                "method": "GET",
                "headers": {
                    "authorization": "Basic YWRtaW46MTIzNA==",
                    "Authorizationkeyfortoken": String(responce),
                    "cache-control": "no-cache",
                    "postman-token": "eb27c011-391a-0b70-37c5-609bcd1d7b6d"
                },
                "processData": false,
                "contentType": false,
                "beforeSend": function () {
                    messageLoading = true;
                    chatBox.html('<img id="loadingMessage" src="<?php echo base_url('assets/img/arb_preloader.svg'); ?>" class="img-responsive blankImg" style="width:60px;">');
                    chatBox.addClass("text-center");
                    chatBox.addClass("vertical-alignment");
                },
                "success": function () {
                    messageLoading = false;
                    $("#loadingMessage").remove();
                    chatBox.removeClass("text-center");
                    chatBox.removeClass("vertical-alignment");
                }
            };
            $.ajax(settings).done(function (result) {
                let data = result.response;
                let html = "";
                totalRetivedMessage += data.length;
                if (data.length === 0) {
                    chatBox.html('');
                    // <img id="blankImg" src="<?php echo base_url('assets/img/nomess.png'); ?>" class="img-responsive blankImg">
                    chatBox.addClass("text-center");
                    chatBox.addClass("vertical-alignment");
                } else {
                    chatBox.removeClass("text-center");
                    chatBox.removeClass("vertical-alignment");
                    lastMessageDate = moment(data[data.length - 1].message.ios_date_time);
                    LastMessageId = parseInt(data[data.length - 1].message.m_id);
                    let currentDate = moment(moment().toISOString());
                    topMessage = data[0].message.m_id;
                    let today = false;
                    
                    for (let i = 0; i < data.length; i++) {
                        let sender = data[i].sender;
                        let message = data[i].message;
                        let senderId = data[i].sender.userId;
                        let messageDate = moment(data[i].message.ios_date_time);
                        let seen = data[i].seen;
                        
                        if (moment(moment().toISOString()).diff(messageDate, 'days') === 0 && !today) {
                            html += "<div class=\"fw-im-message  text-center fw-im-othersender\" data-og-container=\"\">";
                            html += "<div class=\"centerblock\">";
                            html += moment(message.ios_date_time, moment.ISO_8601).calendar(null, momentOptions2);
                            html += "                <\/div>";
                            html += "                <\/div>";
                            currentDate = messageDate;
                            today = true;
                        }
                        else if (currentDate.diff(messageDate, 'days') !== 0 && (currentDate.diff(messageDate, 'days') >= 1 || currentDate.diff(messageDate, 'days') <= -1)) {
                            html += "<div class=\"fw-im-message  text-center fw-im-othersender\" data-og-container=\"\">";
                            html += "<div class=\"centerblock\">";
                            html += moment(message.ios_date_time, moment.ISO_8601).calendar(null, momentOptions2);
                            html += "                <\/div>";
                            html += "                <\/div>";
                            currentDate = messageDate;
                        }
                        else if (moment(moment().toISOString()).diff(messageDate, 'days') === 0 && (currentDate.diff(messageDate, 'minutes') <= -30 || currentDate.diff(messageDate, 'minutes') >= 30)) {
                            html += "<div class=\"fw-im-message  text-center fw-im-othersender\" data-og-container=\"\">";
                            html += "<div class=\"centerblock\">";
                            html += moment(message.ios_date_time, moment.ISO_8601).calendar(null, momentOptions2);
                            html += "                <\/div>";
                            html += "                <\/div>";
                            currentDate = messageDate;
                        }
                        if (message.type === "update") {
                            html += "<div id='message_" + message.m_id + "' class=\"fw-im-message  text-center fw-im-othersender update-message-font\"  data-og-container=\"\">";
                            html += "<div class=\"centerblock\">";
                            html += "<i  class='fa fa-tags'></i> " + message.message;
                            html += "                <\/div>";
                            html += "                <\/div>";
                        }
                        else {
                            if (parseInt(senderId) === parseInt(userId)) {
                                html += "<div class=\"fw-im-message  fw-im-isme fw-im-othersender \"  data-og-container=\"\" title=\"" + moment(message.ios_date_time, moment.ISO_8601).calendar(null, momentOptions) + "\" >";
                                if (message.type === "text") {
                                    if (message.onlyemoji) {
                                        html += "                    <div id='message_" + message.m_id + "' class=\"fw-im-message-text ss\" style='background-color:transparent;'>" + parseMessage(message.message, true) + "<\/div>";
                                    } else {
                                        html += "                    <div id='message_" + message.m_id + "' class=\"fw-im-message-text\">" + parseMessage(message.message, false) + "<\/div>";
                                    }
                                    if (message.linkData !== null) {
                                        html += getLinkPreview(JSON.parse(message.linkData), message.link);
                                    }
                                }
                                if (message.type === "image") {
                                    html += getImagePreview(message);
                                }
                                if (message.type === "video") {
                                    html += "<div id='message_" + message.m_id + "' class=\"fw-im-attachments\" >";
                                    html += "                        <video class='mediaVideo' id='video_" + message.m_id + "' poster='" + message.poster + "'  width=\"100%\" height=\"\" controls=\"true\" preload='none' name=\"media\"><source src=\"" + message.message + "\" type=\"video\/mp4\"><\/video>";
                                    html += "                    <\/div>";
                                }
                                if (message.type === "audio") {
                                    html += "<div id='message_" + message.m_id + "' class=\"fw-im-attachments mediaAudio-player-wrapper\" >";
                                    html += "                        <audio class='mediaAudio' id='audio_" + message.m_id + "' style='width:100%;height:100%;' width='100%' height='100%' controls=\"true\" preload='none' name=\"media\"><source src=\"" + message.message + "\" type=\"audio\/mp3\"><\/audio>";
                                    html += "                    <\/div>";
                                }
                                if (message.type === "document") {
                                    // html += "<div id='message_" + message.m_id + "' class=\"fw-im-attachments\" >";
                                    html += "                        <div class=\"fw-im-message-text\"><a target='_blank' id='document_" + message.m_id + "' href=" + message.message + " ><i class=\"fa fa-arrow-circle-down\"></i> " + message.fileName + "<\/a></div>";
                                    //html += "                    <\/div>";
                                }
                                html += "                    <div class=\"fw-im-message-author\"  title=\"" + sender.firstName + " " + sender.lastName + "\">";
                                html += "                        <img src=\"" + sender.profilePictureUrl + "\" >";
                                html += "                    <\/div>";
                                if (seen) {
                                    if (seen.time) {
                                        html += "                    <div class=\"fw-im-message-time seen  seenId_" + message.m_id + "\">";
                                        html += "                        <span class='seenMessage_" + message.m_id + "'>" + seen.seen + moment(seen.time, moment.ISO_8601).calendar(null, momentOptions2) + "<\/span>";
                                        html += "                    <\/div>";
                                    } else {
                                        html += "                    <div class=\"fw-im-message-time seen  seenId_" + message.m_id + "\">";
                                        html += "                        <span class='seenMessage_" + message.m_id + "'>" + seen.seen + "<\/span>";
                                        html += "                    <\/div>";
                                    }
                                }
                                else {
                                    html += "                    <div class=\"fw-im-message-time seen hidden  seenId_" + message.m_id + "\">";
                                    html += "                        <span class='seenMessage_" + message.m_id + "'>" + "<\/span>";
                                    html += "                    <\/div>";
                                }
                                html += "                <\/div>";
                            }else {
                                html += "                <div class=\"fw-im-message  fw-im-isnotme fw-im-othersender\" data-og-container=\"\" title=\"" + moment(message.ios_date_time, moment.ISO_8601).calendar(null, momentOptions) + "\">";
                                if (isUnicode(sender.firstName)) {
                                    html += "<div class='fw-im-message-author-name font-Tahoma'>" + sender.firstName + "</div>";
                                } else {
                                    html += "<div class='fw-im-message-author-name'>" + sender.firstName + "</div>";
                                }
                                if (message.type === "text") {
                                    if (message.onlyemoji) {
                                        html += "                    <div id='message_" + message.m_id + "' class=\"fw-im-message-text\" style='background-color:transparent;'>" + parseMessage(message.message, true) + "<\/div>";
                                    } else {
                                        html += "                    <div id='message_" + message.m_id + "' class=\"fw-im-message-text\">" + parseMessage(message.message, false) + "<\/div>";
                                    }
                                    if (message.linkData !== null) {
                                        html += getLinkPreview(JSON.parse(message.linkData), message.link);
                                    }
                                }
                                if (message.type === "image") {
                                    html += getImagePreview(message);
                                }
                                if (message.type === "video") {
                                    html += "<div id='message_" + message.m_id + "' class=\"fw-im-attachments\">";
                                    html += "                        <video class='mediaVideo' id='video_" + message.m_id + "' poster='" + message.poster + "' width=\"100%\" height=\"\" controls=\"true\" preload='none'  name=\"media\"><source src=\"" + message.message + "\" type=\"video\/mp4\"><\/video>";
                                    html += "                    <\/div>";
                                }
                                if (message.type === "audio") {
                                    html += "<div id='message_" + message.m_id + "' class=\"fw-im-attachments mediaAudio-player-wrapper\" >";
                                    html += "                        <audio class='mediaAudio' id='audio_" + message.m_id + "' style='width:100%;height:100%;' width='100%' height='100%' controls=\"true\" preload='none' name=\"media\"><source src=\"" + message.message + "\" type=\"audio\/mp3\"><\/audio>";
                                    html += "                    <\/div>";
                                }
                                if (message.type === "document") {
                                    // html += "<div id='message_" + message.m_id + "' class=\"fw-im-attachments\" >";
                                    html += "                        <div class=\"fw-im-message-text\"><a target='_blank' id='document_" + message.m_id + "' href=" + message.message + "   ><i class=\"fa fa-arrow-circle-down\"></i> " + message.fileName + "<\/a></div>";
                                    //html += "                    <\/div>";
                                }
                                html += "                    <div class=\"fw-im-message-author\"  title=\"" + sender.firstName + " " + sender.lastName + "\">";
                                if (sender.active === 1) {
                                    html += "                        <img class='auth_" + senderId + "'  src=\"" + sender.profilePictureUrl + "\" ><span class='authStatus memberActive'></span>";
                                } else {
                                    html += "                        <img class='auth_" + senderId + " authStatus' src=\"" + sender.profilePictureUrl + "\" ><span class='authStatus memberOffline'></span>";
                                }
                                html += "                    <\/div>";
                                /* html += "                    <div class=\"fw-im-message-time\">";
                                 html += "                        <span title=\""+moment(message.ios_date_time,moment.ISO_8601).format('LLLL')+"\">"+moment(message.ios_date_time,moment.ISO_8601).calendar(null,momentOptions)+"<\/span>";
                                 html += "                    <\/div>";*/
                                html += "                <\/div>";
                            }
                        }
                    }
                    

                    firstmessageDate = currentDate;
                    chatBox.html("");
                    chatBox.append(html);
                    chatBox.scrollTop(0);
                    for (let i = 0; i < data.length; i++) {
                        let allMessage = data[i].message;
                        let sender = data[i].sender;
                        let isme = parseInt(sender.userId) !== parseInt(userId);
                        // console.log(sender);
                        if (allMessage.type == "video") {
                            initVideo("video_" + allMessage.m_id, isme);
                        } else if (allMessage.type == "audio") {
                            initAudio("audio_" + allMessage.m_id, isme);
                        } else if (allMessage.type == "text" && isUnicode(allMessage.message)) {
                            $("#message_" + allMessage.m_id).css({
                                "direction": "rtl",
                                "font-family": "Tahoma"
                            });
                        }
                    }
                    let height = chatBox[0].scrollHeight;
                    //scrollPosition=height;
                    //chatBox.scrollTop( chatBox.prop( "scrollHeight" ) );
                    chatBox.scrollTop(height);
                    //$('#notice_'+groupId).addClass("hidden");
                    lightBox.init();
                    chatBox.perfectScrollbar({suppressScrollX: true});
                    clampData();
                }
            });
        }
        function updateGroupImage(file) {
            if(navigator.onLine==false){
                toastr.error("Send Failed. No Internet");
                return;
            }
            let form=new FormData();
                form.append("file",file);
                form.append("groupId", activeGroupId);
            let progress1 = new LoadingOverlayProgress();
            let url = "<?php echo base_url('imApi/updateGroupImage'); ?>";
           let settings = {
                "async": true,
                "crossDomain": true,
                "url": url,
                "method": "POST",
                "headers": {
                    "authorization": "Basic YWRtaW46MTIzNA==",
                    "Authorizationkeyfortoken": String(responce),
                    "cache-control": "no-cache",
                    "postman-token": "58e7510b-ad46-6037-fc4d-028915069e2b"
                },
                "xhr": function () {
                    let xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function (evt) {
                            let percentComplete = evt.loaded / evt.total;
                            percentComplete = parseInt(percentComplete * 100);
                            if (percentComplete >= 100) {
                                //clearInterval(iid1);
                                delete progress1;
                                $("body").LoadingOverlay("hide");
                                return;
                            }
                            progress1.Update(percentComplete);
                    }, false);
                    return xhr;
                },
                "processData": false,
                "contentType": false,
                "mimeType": "multipart/form-data",
                "data": form,
                "error": function (e) {
                    let err = JSON.parse(e.responseText);
                    toastr.error(err.response);
                },
                "beforeSend": function () {
                   // $('.close').trigger("click");
                        $("body").LoadingOverlay("show", {
                            custom: progress1.Init()
                        });
                },
                "complete": function () {
                    delete progress1;
                    $("body").LoadingOverlay("hide");
                }
            };
            $.ajax(settings);
        }
        //This function is used to send message to the server
        function sendMessage(form, sendFile, newmessage, socketData) {
            if(navigator.onLine==false){
                toastr.error("Send Failed. No Internet");
                return;
            }
            let settings = null;
            if (ID_BASED) {
                form.append("userId", userId);
                socketData.userId = userId;
            }
            let url = "<?php echo base_url('imApi/sendMessage'); ?>";
            if (sendFile) {
                let progress1 = new LoadingOverlayProgress();
                settings = {
                    "async": true,
                    "crossDomain": true,
                    "url": url,
                    "method": "POST",
                    "headers": {
                        "authorization": "Basic YWRtaW46MTIzNA==",
                        "Authorizationkeyfortoken": String(responce),
                        "cache-control": "no-cache",
                        "postman-token": "58e7510b-ad46-6037-fc4d-028915069e2b"
                    },
                    "xhr": function () {
                        let xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function (evt) {
                            if (sendFile) {
                                let percentComplete = evt.loaded / evt.total;
                                percentComplete = parseInt(percentComplete * 100);
                                if (percentComplete >= 100) {
                                    //clearInterval(iid1);
                                    delete progress1;
                                    $("body").LoadingOverlay("hide");
                                    return;
                                }
                                progress1.Update(percentComplete);
                            }
                        }, false);
                        return xhr;
                    },
                    "processData": false,
                    "contentType": false,
                    "mimeType": "multipart/form-data",
                    "data": form,
                    "error": function (e) {
                        let err = JSON.parse(e.responseText);
                        toastr.error(err.response);
                    },
                    "beforeSend": function () {
                        $('.close').trigger("click");
                        if (sendFile) {
                            $("body").LoadingOverlay("show", {
                                custom: progress1.Init()
                            });
                        }
                    },
                    "complete": function () {
                        delete progress1;
                        $("body").LoadingOverlay("hide");
                    }
                };
                $.ajax(settings).done(function (res) {
                    let json = JSON.parse(res);
                    let group = json.response;
                    if(json.status.file){
                        // execute upload
                        console.log('file uploaded');
                    }
                    resetNewMessage();
                    if (newmessage) {
                        $("#group_" + group.groupId).remove();
                        $('.person').removeClass('active');
                        addNewGroup(group);
                        $('#groups li').first().trigger("click", [{update: true}]);
                    }else{
                        placeGroupOnTop(activeGroupId);
                    }
                });
            }
            else {
                typingTimeoutFunction();
                $('.close').trigger("click");
                socketData._r = String(responce);
                socket.emit("sendText", socketData);
                messageTyping=false;
                placeGroupOnTop(activeGroupId);
            }
        }

        function placeGroupOnTop(groupId) {
            if(!parseInt(groupId)) return;
            let elementData = $("#group_" + groupId).clone();
            $("#group_" + groupId).remove();
            $("#groups").prepend(elementData);
            $("#groups").scrollTop(0);
            $("li#group_"+groupId).first().trigger("click", [{update: true}]);
        }

        // unused function. have a plan used in the future
        function captureImage(file) {
            let canvas = document.createElement("canvas");
            canvas.width = 40;
            canvas.height = 40;
            canvas.strokeStyle = 'black';
            canvas.lineWidth = 1;
            canvas.getContext('2d').strokeRect(0, 0, canvas.width, canvas.height);
            canvas.getContext('2d').drawImage(file, 0, 0, canvas.width - 1, canvas.height - 1);
            let img = document.getElementById("fileIV");
            img.src = canvas.toDataURL("image/png");
            //$output.prepend(img);
        };
        function captureImagenewMessage(file) {
            let canvas = document.createElement("canvas");
            canvas.width = 40;
            canvas.height = 40;
            canvas.strokeStyle = 'black';
            canvas.lineWidth = 1;
            canvas.getContext('2d').strokeRect(0, 0, canvas.width, canvas.height);
            canvas.getContext('2d').drawImage(file, 0, 0, canvas.width - 1, canvas.height - 1);
            let img = document.getElementById("newMessagefileIV");
            img.src = canvas.toDataURL("image/png");
            //$output.prepend(img);
        };
        //update the message time on the left side
        function updateTime() {
            $.each(groupObjects, function (index, value) {
                let date = moment(groupObjects[index].lastActive, moment.ISO_8601).fromNow();
                $('#time_' + index).html(date);
            });
        }
        function updateGroupsStatus() {
            if (activeGroupId) {
                let loopGroupObject = groupObjects[activeGroupId];
                //block part
                if (loopGroupObject.block) {
                    if (parseInt(loopGroupObject.meBlocker)) {
                        if (!$("#block").hasClass("hidden")) {
                            $("#block").addClass("hidden");
                        }
                        if ($("#unblock").hasClass("hidden")) {
                            $("#unblock").removeClass("hidden");
                        }
                    } else {
                        if ($("#block").hasClass("hidden")) {
                            $("#block").removeClass("hidden");
                        }
                        if (!$("#unblock").hasClass("hidden")) {
                            $("#unblock").addClass("hidden");
                        }
                    }
                    if ($("#blockmessage").hasClass("hidden")) {
                        $("#blockmessage").removeClass("hidden");
                    }
                    $("#messageForm").hide();
                } else {
                    if (!parseInt(loopGroupObject.meBlocker)) {
                        if ($("#block").hasClass("hidden")) {
                            $("#block").removeClass("hidden");
                        }
                        if (!$("#unblock").hasClass("hidden")) {
                            $("#unblock").addClass("hidden");
                        }
                    }
                    if (!$("#blockmessage").hasClass("hidden")) {
                        $("#blockmessage").addClass("hidden");
                    }
                    $("#messageForm").show();
                }
                //mute Part
                if (!loopGroupObject.mute) {
                    if ($("#mute").hasClass("hidden")) {
                        $("#mute").removeClass("hidden");
                    }
                    if (!$("#unmute").hasClass("hidden")) {
                        $("#unmute").addClass("hidden");
                    }
                    if (!$("#mute_" + loopGroupObject.groupId).hasClass("hidden")) {
                        $("#mute_" + loopGroupObject.groupId).addClass("hidden");
                    }
                } else {
                    if (!$("#mute").hasClass("hidden")) {
                        $("#mute").addClass("hidden");
                    }
                    if ($("#unmute").hasClass("hidden")) {
                        $("#unmute").removeClass("hidden");
                    }
                    if ($("#mute_" + loopGroupObject.groupId).hasClass("hidden")) {
                        $("#mute_" + loopGroupObject.groupId).removeClass("hidden");
                    }
                }
            }
        }
// -----------------End of Global functions --------------------------//
        $('#groups').perfectScrollbar({suppressScrollX: true});
        //$('#groupMembers').perfectScrollbar({suppressScrollX:true});
        $('#rightSection').perfectScrollbar({suppressScrollX: true});
        chatBox.perfectScrollbar({suppressScrollX: true});
        $(addmember).on('expand', function (c) {
            addexpendDropdown = $('.ms-res-ctn.dropdown-menu').perfectScrollbar({suppressScrollX: true});
            initaddexpendDropdown();
        });
        $(addmember).on('collapse', function (c) {
            addexpendDropdown.perfectScrollbar("destroy");
        });
        $(newMemberInput).on('expand', function (c) {
            addMemberexpendDropdown = $('.ms-res-ctn.dropdown-menu').perfectScrollbar({suppressScrollX: true});
            initaddMemberexpendDropdown();
        });
        $(newMemberInput).on('collapse', function (c) {
            addMemberexpendDropdown.perfectScrollbar("destroy");
        });
        $(newMemberInput).on('keyup', function (e, m, v) {
            let value = this.getRawValue().replace(/<script[^>]*>/gi, "&lt;script&gt;").replace(/<\/script[^>]*>/gi, "&lt;/script&gt;").replace(/(<([^>]+)>)/ig, "").replace(/&nbsp;/gi, " ").replace(/&nbsp;/gi, " ").trim();
            let settings = {
                "async": true,
                "crossDomain": true,
                "url": "<?php echo base_url('user/filterFriendList?key='); ?>" + value,
                "method": "GET",
                "headers": {
                    "authorization": "Basic YWRtaW46MTIzNA==",
                    "Authorizationkeyfortoken": String(responce),
                    "cache-control": "no-cache",
                    "postman-token": "eb27c011-391a-0b70-37c5-609bcd1d7b6d"
                },
                "dataType": 'json'
            };
            $.ajax(settings).done(function (response) {
                request = true;
                let res = response.response;
                let oldData = [];
                for (let i = 0; i < res.length; i++) {
                    if (res[i].userStatus !== 0) {
                        let md = {
                            id: parseInt(res[i].userId),
                            name: res[i].firstName + " " + res[i].lastName,
                            picture: res[i].profilePictureUrl,
                            email: res[i].userEmail
                        };
                        oldData.push(md);
                        //expendDropdown.append(getMagicData(md));
                    }
                }
                //addmember.setData(oldData);
                newMemberInput.setData(oldData);
            });
        });
        $(addmember).on('keyup', function (e, m, v) {
            let value = this.getRawValue().replace(/<script[^>]*>/gi, "&lt;script&gt;").replace(/<\/script[^>]*>/gi, "&lt;/script&gt;").replace(/(<([^>]+)>)/ig, "").replace(/&nbsp;/gi, " ").replace(/&nbsp;/gi, " ").trim();
            let settings = {
                "async": true,
                "crossDomain": true,
                "url": "<?php echo base_url('user/filterFriendList?key='); ?>" + value,
                "method": "GET",
                "headers": {
                    "authorization": "Basic YWRtaW46MTIzNA==",
                    "Authorizationkeyfortoken": String(responce),
                    "cache-control": "no-cache",
                    "postman-token": "eb27c011-391a-0b70-37c5-609bcd1d7b6d"
                },
                "dataType": 'json'
            };
            $.ajax(settings).done(function (response) {
                request = true;
                let res = response.response;
                let oldData = [];
                for (let i = 0; i < res.length; i++) {
                    if (res[i].userStatus !== 0) {
                        let md = {
                            id: parseInt(res[i].userId),
                            name: res[i].firstName + " " + res[i].lastName,
                            picture: res[i].profilePictureUrl,
                            email: res[i].userEmail
                        };
                        oldData.push(md);
                        //expendDropdown.append(getMagicData(md));
                    }
                }
                addmember.setData(oldData);
                //newMemberInput.setData(oldData);
            });
        });
        function initaddexpendDropdown() {
            let request = true;
            addexpendDropdown.on("ps-y-reach-end", function () {
                increaseFriendsLimit();
                if (request && friendStart < totalFriend) {
                    request = false;
                    let settings = {
                        "async": true,
                        "crossDomain": true,
                        "url": "<?php echo base_url('user/friendList?start='); ?>" + friendStart + "&limit=" + friendLimit,
                        "method": "GET",
                        "headers": {
                            "authorization": "Basic YWRtaW46MTIzNA==",
                            "Authorizationkeyfortoken": String(responce),
                            "cache-control": "no-cache",
                            "postman-token": "eb27c011-391a-0b70-37c5-609bcd1d7b6d"
                        },
                        "dataType": 'json'
                    };
                    $.ajax(settings).done(function (response) {
                        request = true;
                        let res = response.response.friends;
                        let oldData = addmember.getData();
                        for (let i = 0; i < res.length; i++) {
                            if (res[i].userStatus !== 0) {
                                let md = {
                                    id: parseInt(res[i].userId),
                                    name: res[i].firstName + " " + res[i].lastName,
                                    picture: res[i].profilePictureUrl,
                                    email: res[i].userEmail
                                };
                                oldData.push(md);
                                //expendDropdown.append(getMagicData(md));
                            }
                        }
                        addmember.setData(oldData);
                        //newMemberInput.setData(oldData);
                    });
                }
            });
        }
        function initaddMemberexpendDropdown() {
            let request = true;
            addMemberexpendDropdown.on("ps-y-reach-end", function () {
                increaseFriendsLimit();
                if (request && friendStart < totalFriend) {
                    request = false;
                    let settings = {
                        "async": true,
                        "crossDomain": true,
                        "url": "<?php echo base_url('user/friendList?start='); ?>" + friendStart + "&limit=" + friendLimit,
                        "method": "GET",
                        "headers": {
                            "authorization": "Basic YWRtaW46MTIzNA==",
                            "Authorizationkeyfortoken": String(responce),
                            "cache-control": "no-cache",
                            "postman-token": "eb27c011-391a-0b70-37c5-609bcd1d7b6d"
                        },
                        "dataType": 'json'
                    };
                    $.ajax(settings).done(function (response) {
                        request = true;
                        let res = response.response.friends;
                        let oldData = newMemberInput.getData();
                        for (let i = 0; i < res.length; i++) {
                            if (res[i].userStatus !== 0) {
                                let md = {
                                    id: parseInt(res[i].userId),
                                    name: res[i].firstName + " " + res[i].lastName,
                                    picture: res[i].profilePictureUrl,
                                    email: res[i].userEmail
                                };
                                oldData.push(md);
                                //expendDropdown.append(getMagicData(md));
                            }
                        }
                        // addmember.setData(oldData);
                        newMemberInput.setData(oldData);
                    });
                }
            });
        }
        let requested = true;
        groupBox.on("ps-y-reach-end", function () {
            increaseGroupLimit();
            if (requested && groupStart < totalGroup) {
                requested = false;
                let url = "<?php echo base_url('imApi/getGroups?limit='); ?>" + groupLimit + "&start=" + groupStart;
                let settings = {
                    "async": true,
                    "crossDomain": true,
                    "url": url,
                    "method": "GET",
                    "headers": {
                        "authorization": "Basic YWRtaW46MTIzNA==",
                        "Authorizationkeyfortoken": String(responce),
                        "cache-control": "no-cache",
                        "postman-token": "eb27c011-391a-0b70-37c5-609bcd1d7b6d"
                    },
                    "processData": false,
                    "contentType": false,
                    "beforeSend": function () {
                        groupBox.append("<div class='text-center groupLoader'><div class='loader'></div></div>");
                    },
                    "complete": function () {
                        $('.groupLoader').remove();
                    }
                };
                $.ajax(settings).done(function (response) {
                    let groups = response.response;
                    printGroupListAppend(groups);
                    requested = true;
                });
            }
        });
        chatBox.on("ps-scroll-up", function (e) {
            if (notRequested && chatBox.scrollTop() === 0) {
                notRequested = false;
                increaseStart();
                let url = "<?php echo base_url('imApi/getMessage?groupId='); ?>" + activeGroupId + "&limit=" + limit + "&start=" + start + "&userId=" + userId;
                let settings = {
                    "async": true,
                    "crossDomain": true,
                    "url": url,
                    "method": "GET",
                    "headers": {
                        "authorization": "Basic YWRtaW46MTIzNA==",
                        "Authorizationkeyfortoken": String(responce),
                        "cache-control": "no-cache",
                        "postman-token": "eb27c011-391a-0b70-37c5-609bcd1d7b6d"
                    },
                    "processData": false,
                    "contentType": false,
                    "beforeSend": function () {
                        chatBox.prepend("<div class='loader'></div>");
                    },
                    "complete": function () {
                        $('.loader').remove();
                    }
                };
                $.ajax(settings).done(function (result) {
                    $('.loader').remove();
                    notRequested = true;
                    let data = result.response;
                    if (data.length === 0) {
                        notRequested = false;
                        return;
                    }
                    if (totalRetivedMessage === result.totalMessage) {
                        resetStart();
                        return;
                    }
                    let html = "";
                    let currentDate = firstmessageDate;
                    let currentTopMessage = topMessage;
                    topMessage = data[0].message.m_id;
                    for (let i = 0; i < data.length; i++) {
                        let self = data[i].self;
                        let sender = data[i].sender;
                        let message = data[i].message;
                        let senderId = data[i].sender.userId;
                        let messageDate = moment(data[i].message.ios_date_time, moment.ISO_8601);
                        if (currentDate.date() - messageDate.date() >= 1 || currentDate.date() - messageDate.date() <= -1) {
                            
                            if (currentDate !== messageDate) {
                                html += "<div class=\"fw-im-message  text-center fw-im-othersender\" data-og-container=\"\">";
                                html += "<div class=\"centerblock\">";
                                html += moment(message.ios_date_time, moment.ISO_8601).calendar(null, momentOptions2);
                                html += "                <\/div>";
                                html += "                <\/div>";
                                currentDate = messageDate;
                            }
                        }
                        if (message.type === "update") {
                            html += "<div id='message_" + message.m_id + "' class=\"fw-im-message  text-center fw-im-othersender update-message-font\"  data-og-container=\"\">";
                            html += "<div class=\"centerblock\">";
                            html += "<i   class='fa fa-tags'></i> " + message.message;
                            html += "                <\/div>";
                            html += "                <\/div>";
                        }
                        else {
                            if (parseInt(senderId) === parseInt(userId)) {
                                html += "<div  class=\"fw-im-message  fw-im-isme fw-im-othersender\" data-og-container=\"\" title=\"" + moment(message.ios_date_time, moment.ISO_8601).calendar(null, momentOptions) + "\">";
                                if (message.type === "text") {
                                    if (message.onlyemoji) {
                                        html += "                    <div id='message_" + message.m_id + "' class=\"fw-im-message-text\" style='background-color:transparent;'>" + parseMessage(message.message, true) + "<\/div>";
                                    } else {
                                        html += "                    <div id='message_" + message.m_id + "' class=\"fw-im-message-text\">" + parseMessage(message.message, false) + "<\/div>";
                                    }
                                    if (message.linkData != null) {
                                        html += getLinkPreview(JSON.parse(message.linkData), message.link);
                                    }
                                }
                                if (message.type === "image") {
                                    html += getImagePreview(message);
                                }
                                if (message.type === "video") {
                                    html += "<div id='message_" + message.m_id + "' class=\"fw-im-attachments\" >";
                                    html += "                        <video class='mediaVideo' id='video_" + message.m_id + "' poster='" + message.poster + "'  width=\"100%\" height=\"\" controls=\"true\" preload='none'  name=\"media\"><source src=\"" + message.message + "\" type=\"video\/mp4\"><\/video>";
                                    html += "                    <\/div>";
                                }
                                if (message.type === "audio") {
                                    html += "<div id='message_" + message.m_id + "' class=\"fw-im-attachments mediaAudio-player-wrapper\" >";
                                    html += "                        <audio class='mediaAudio' id='audio_" + message.m_id + "' style='width:100%;height:100%;' width='100%' height='100%'  controls=\"true\" preload='none' name=\"media\"><source src=\"" + message.message + "\" type=\"audio\/mp3\"><\/audio>";
                                    html += "                    <\/div>";
                                }
                                if (message.type === "document") {
                                    //html += "<div id='message_" + message.m_id + "' class=\"fw-im-attachments\" >";
                                    html += "                        <div class=\"fw-im-message-text\"><a target='_blank' id='document_" + message.m_id + "' href=" + message.message + "  ><i class=\"fa fa-arrow-circle-down\"></i> " + message.fileName + "<\/a></div>";
                                    //html += "                    <\/div>";
                                }
                                html += "                    <div class=\"fw-im-message-author\"   title=\"" + sender.firstName + " " + sender.lastName + "\">";
                                html += "                        <img src=\"" + sender.profilePictureUrl + "\" >";
                                html += "                    <\/div>";
                                // console.log(sender.profilePictureUrl);
                                /*html += "                    <div class=\"fw-im-message-time\">";
                                html += "                        <span title=\"" + moment(message.ios_date_time,moment.ISO_8601).format('LLLL') + "\">" + moment(message.ios_date_time,moment.ISO_8601).calendar(null,momentOptions) + "<\/span>";
                                html += "                    <\/div>";*/
                                html += "                <\/div>";
                            }
                            else {
                                html += "                <div class=\"fw-im-message  fw-im-isnotme fw-im-othersender\" data-og-container=\"\" title=\"" + moment(message.ios_date_time, moment.ISO_8601).calendar(null, momentOptions) + "\">";
                                if (isUnicode(sender.firstName)) {
                                    html += "<div class='fw-im-message-author-name font-Tahoma'>" + sender.firstName + "</div>";
                                } else {
                                    html += "<div class='fw-im-message-author-name'>" + sender.firstName + "</div>";
                                }
                                if (message.type === "text") {
                                    if (message.onlyemoji) {
                                        html += "                    <div id='message_" + message.m_id + "' class=\"fw-im-message-text\" style='background-color:transparent;'>" + parseMessage(message.message, true) + "<\/div>";
                                    } else {
                                        html += "                    <div id='message_" + message.m_id + "' class=\"fw-im-message-text\">" + parseMessage(message.message, false) + "<\/div>";
                                    }
                                    if (message.linkData !== null) {
                                        html += getLinkPreview(JSON.parse(message.linkData), message.link);
                                    }
                                }
                                if (message.type === "image") {
                                    html += getImagePreview(message);
                                }
                                if (message.type === "video") {
                                    html += "<div id='message_" + message.m_id + "' class=\"fw-im-attachments\">";
                                    html += "                        <video class='mediaVideo' id='video_" + message.m_id + "' poster='" + message.poster + "'   width=\"100%\" height=\"\" controls=\"true\"  preload='none' name=\"media\"><source src=\"" + message.message + "\" type=\"video\/mp4\"><\/video>";
                                    html += "                    <\/div>";
                                }
                                if (message.type === "audio") {
                                    html += "<div id='message_" + message.m_id + "' class=\"fw-im-attachments mediaAudio-player-wrapper\" >";
                                    html += "                        <audio class='mediaAudio' id='audio_" + message.m_id + "' style='width:100%;height:100%;' width='100%' height='100%'  controls=\"true\" preload='none'  name=\"media\"><source src=\"" + message.message + "\" type=\"audio\/mp3\"><\/audio>";
                                    html += "                    <\/div>";
                                }
                                if (message.type === "document") {
                                    //html += "<div id='message_" + message.m_id + "' class=\"fw-im-attachments\" >";
                                    html += "                        <div class=\"fw-im-message-text\"><a target='_blank' id='document_" + message.m_id + "' href=" + message.message + " ><i class=\"fa fa-arrow-circle-down\"></i> " + message.fileName + "<\/a></div>";
                                    //html += "                    <\/div>";
                                }
                                html += "                    <div class=\"fw-im-message-author\"  title=\"" + sender.firstName + " " + sender.lastName + "\">";
                                if (sender.active === 1) {
                                    html += "                        <img class='auth_" + senderId + "'  src=\"" + sender.profilePictureUrl + "\" ><span class='authStatus memberActive'></span>";
                                } else {
                                    html += "                        <img class='auth_" + senderId + " authStatus' src=\"" + sender.profilePictureUrl + "\" >";
                                }
                                html += "                    <\/div>";
                                /* html += "                    <div class=\"fw-im-message-time\">";
                                 html += "                        <span title=\"" + moment(message.ios_date_time,moment.ISO_8601).format('LLLL') + "\">" + moment(message.ios_date_time,moment.ISO_8601).calendar(null,momentOptions) + "<\/span>";
                                 html += "                    <\/div>";*/
                                html += "                <\/div>";
                            }
                        }
                    }
                    totalRetivedMessage += data.length;
                    chatBox.prepend(html);
                    for (let i = 0; i < data.length; i++) {
                        let allMessage = data[i].message;
                        let sender = data[i].sender;
                        let isme = parseInt(sender.userId) !== parseInt(userId);
                        if (allMessage.type == "video") {
                            initVideo("video_" + allMessage.m_id, isme);
                        } else if (allMessage.type == "audio") {
                            initAudio("audio_" + allMessage.m_id, isme);
                        } else if (allMessage.type == "text" && isUnicode(allMessage.message)) {
                            $("#message_" + allMessage.m_id).css({
                                "direction": "rtl",
                                "font-family": "Tahoma"
                            });
                        }
                    }
                    /*if(data.length>0){
                     let m_id=data[data.length-1].message.m_id;
                     chatBox.animate({scrollTop:$("#message_"+m_id).offset().top},3);
                     }*/
                    //let height=chatBox[0].scrollHeight;
                    let elmnt = document.getElementById("message_" + currentTopMessage);
                    if (data.length !== 0) {
                        if (!elmnt) {
                            chatBox.scrollTop(scrollPosition);
                        }
                        else {
                            chatBox.perfectScrollbar('update');
                            elmnt.scrollIntoView(false);
                        }
                    }
                    lightBox.init();
                    $('.loader').hide();
                    clampData();
                    //window.scrollTo(0,0);
                });
            }
        });
        function disconnectModal(){
            setTimeout(function () {
                if(isDisconnected){
                    $('#connectionErrorModal').modal({backdrop: 'static', keyboard: false, show: true});
                }
            },5000)
        }

        function showComponents(obj=[]){
            if(obj.length){
                for(j in obj){
                    $(`#${obj[j]}`).removeClass("hidden");
                } 
            }
        }

        //$(".rightSection").perfectScrollbar();
        $('#groups').on("click", ".person", function (e, update) {
            if ($(this).hasClass('active')) {
                return false;
            }
            messageTyping=true;
            if (mejs) {
                delete mejs.players;
                mejs.players = [];
            }
            if ($(".groupInfoContent").hasClass("hidden")) {
                $(".groupInfoContent").removeClass("hidden");
            }
            if ($(".rightBorder").hasClass("hidden")) {
                $(".rightBorder").removeClass("hidden");
            }
            if ($(this).hasClass("person-hover")) {
                $(this).removeClass('person-hover');
            }
            let oldGroupId = activeGroupId;
            if ($("#group_" + oldGroupId).hasClass("font-bold-black")) {
                $("#group_" + oldGroupId).removeClass("font-bold-black");
            }
            if (oldGroupId !== null || oldGroupId !== "") {
                socket.emit("leaveRoom", oldGroupId);
            }
            let groupId = parseInt($(this).attr('data-group'));
            activeGroupId = groupId;

            notRequested = true;
            $('#chatBox').perfectScrollbar('destroy');
            $("#rightSection").scrollTop(0);
            resetStart();
            resetRetiveMessage();

            groupType = parseInt(groupObjects[groupId].groupType);
            mute = parseInt(groupObjects[groupId].mute);
            block = parseInt(groupObjects[groupId].block);
            meBlocker = parseInt(groupObjects[groupId].meBlocker);

            totalGroupMembers = groupObjects[groupId].groupType==1 ? 0 : groupObjects[groupId].totalMember;
        
            // Ralph 2019-07-10
            let userlevel = 0;
            if (parseInt(groupObjects[groupId].meCreator)>0) userlevel = 1;
            else if (parseInt(groupObjects[groupId].moderator)>0) userlevel = 2;
            else userlevel = 0;      

            // mute
            if (!$('#muteOptions').hasClass('hidden')) $('#muteOptions').addClass('hidden');
            // block
            if (!$('#blockOptions').hasClass('hidden')) $('#blockOptions').addClass('hidden');
            // leave group
            if (!$('#leaveGroup').hasClass('hidden')) $('#leaveGroup').addClass('hidden');
            // add people
            if (!$('#addMember').hasClass('hidden')) $('#addMember').addClass('hidden');
            // edit thumbnail
            if (!$('#changeGroupImage').hasClass('hidden')) $('#changeGroupImage').addClass('hidden');
            // change name
            if (!$('#editGroupName').hasClass('hidden')) $('#editGroupName').addClass('hidden');
            // join request
            if (!$('#joinRequest').hasClass('hidden')) $('#joinRequest').addClass('hidden');
            // assign moderator
            if (!$('#communityModerator').hasClass('hidden')) $('#communityModerator').addClass('hidden');
            // invitation link
            if (!$('#inviteLinkBtn').hasClass('hidden')) $('#inviteLinkBtn').addClass('hidden');
            //console.log(groupType);
            //console.log(userlevel);

            switch(groupType){

                case 1: // Personal
                   $("#groupMembers").html("");
                    switch(userlevel){
                        case 0: // Member
                        case 1: // Admin
                            showComponents(['muteOptions','blockOptions']);
                        break;                    
                        case 2: // Moderator
                            showComponents([]);
                        break; 
                    }
                break;

                case 2: // Public Community
                    switch(userlevel){
                        case 0: // Member
                            showComponents(['muteOptions']);
                        break;
                        case 1: // Admin
                            showComponents(['muteOptions','changeGroupImage','editGroupName']);
                        break;                    
                        case 2: // Moderator
                            showComponents(['muteOptions']);
                        break; 
                    }
                break;

                case 0: // Private Community
                    switch(userlevel){
                        case 0: // Member
                            showComponents(['muteOptions']);
                        break;
                        case 1: // Admin
                            showComponents(['muteOptions','addMember','changeGroupImage','editGroupName','joinRequest','communityModerator','inviteLinkBtn']);
                        break;                    
                        case 2: // Moderator
                            showComponents(['muteOptions','joinRequest','inviteLinkBtn']);
                        break; 
                    }
                break;

            }

            // Specific Function for Block and Mute
            // Block
            if (block) {
                $("#messageForm").hide();
                if ($("#blockmessage").hasClass("hidden")) {
                    $("#blockmessage").removeClass("hidden");
                }
                if (meBlocker) {
                    if ($("#unblock").hasClass("hidden")) {
                        $("#unblock").removeClass("hidden");
                    }
                    if (!$("#block").hasClass("hidden")) {
                        $("#block").addClass("hidden");
                    }
                } else {
                    if (!$("#unblock").hasClass("hidden")) {
                        $("#unblock").addClass("hidden");
                    }
                    if ($("#block").hasClass("hidden")) {
                        $("#block").removeClass("hidden");
                    }
                }
            } else {
                if (!$("#blockmessage").hasClass("hidden")) {
                    $("#blockmessage").addClass("hidden");
                }
                $("#messageForm").show();
                if (!meBlocker) {
                    if (!$("#unblock").hasClass("hidden")) {
                        $("#unblock").addClass("hidden");
                    }
                    if ($("#block").hasClass("hidden")) {
                        $("#block").removeClass("hidden");
                    }
                } else {
                    if ($("#unblock").hasClass("hidden")) {
                        $("#unblock").removeClass("hidden");
                    }
                    if (!$("#block").hasClass("hidden")) {
                        $("#block").addClass("hidden");
                    }
                }
            }

            // Mute
            if (mute) {
                if ($("#unmute").hasClass("hidden")) {
                    $("#unmute").removeClass("hidden");
                }
                if (!$("#mute").hasClass("hidden")) {
                    $("#mute").addClass("hidden");
                }
            } else {
                if (!$("#unmute").hasClass("hidden")) {
                    $("#unmute").addClass("hidden");
                }
                if ($("#mute").hasClass("hidden")) {
                    $("#mute").removeClass("hidden");
                }
            }

            
            let numbermembers = parseInt(totalGroupMembers);
            function formatNumber(num) {
                return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
            }

/*
            let numbermembers = totalGroupMembers;
            if(groupObjects[groupId].groupType == 2 || groupObjects[groupId].groupType == 0) {
                //$('.numbermember').html(numbermembers);
                //$('.numbermember').append(" Participants");
*/
            let totalmnumbers = numbermembers;
            if(groupObjects[groupId].groupType == 2 ) {
                $('.numbermember').html(formatNumber(totalmnumbers));
                $('.par-label').html(" Participants");
            }else if(groupObjects[groupId].groupType == 1){
                $('.numbermember').html('');
                $('.par-label').html('');
            }else if(groupObjects[groupId].groupType == 0){
                $('.numbermember').html(numbermembers);
                $('.par-label').html(" Participants");
            }

            let appendhtmlimg = groupObjects[groupId].groupImage;
            let appendhtmlimgs = '';
            $('.imgselecteds').empty();
            for (i = 0; i < groupObjects[groupId].groupImage.length; i++){
                let appendhtmlimgs = '<img src="'+ groupObjects[groupId].groupImage[i] +'" class="imgst" draggable="false">';
                $('.imgselecteds').append(appendhtmlimgs);
            }
            if ($("#group_" + groupId).hasClass("font-bold-black")) {
                $("#group_" + groupId).removeClass("font-bold-black");
            }
            let personName = groupObjects[groupId].groupName;
            let namesls = personName;
            if (groupObjects[groupId].groupType != 1){
                let namesMem = groupObjects[groupId].groupName;
                let nameArr = namesMem.split(',');
                if (nameArr.length == 1){
                    $('.UserNames').text(namesls);
                } else if (nameArr.length >= 2){
                    $('.UserNames').text(namesls).append(", You");
                }
            }else{
                $('.UserNames').text(namesls);
            }
            // console.log(groupObjects[groupId]);
            $('.person').removeClass('active');
            $(this).addClass('active');
            $('#addMember').attr('data-group', groupId);
            $('#editGroupName').attr('data-group', groupId);
            let updateList = true;
            if (typeof update !== 'undefined') {
                updateList = update.update;
            }
            if (updateList && groupType != 1) {
                getGroupMembers(groupId);
                //printGroupMembers(groupObjects[groupId].members, groupObjects[groupId].meCreator, groupId);
            }


            //console.log(totalGroupMembers);
            getGroupFiles(groupId);
            clearChatBox();
            getMessage(groupId, start, limit);
            reset();
            printGroupInfo(groupId, groupImages, personName);
            socket.emit("joinRoom", groupId);
        });

        $('#groupMembers').on("click", ".btnMemberDelete", function (e) {
            
            if(!confirm('Are you sure to remove this member?')){
                return;
            }

            let groupId = activeGroupId;
            let memberId = $(this).attr('data-member');
            let form = new FormData();
            form.append("groupId", groupId);
            form.append("memberId", memberId);
            form.append("userId", userId);
            let settings = {
                "async": true,
                "crossDomain": true,
                "url": "<?php echo base_url('imApi/deleteMember'); ?>",
                "method": "POST",
                "headers": {
                    "authorization": "Basic YWRtaW46MTIzNA==",
                    "Authorizationkeyfortoken": String(responce),
                    "cache-control": "no-cache",
                    "postman-token": "eb27c011-391a-0b70-37c5-609bcd1d7b6d"
                },
                "processData": false,
                "contentType": false,
                "data": form,
                "error": function (e) {
                    let err = JSON.parse(e.responseText);
                    toastr.error(err.response);
                },
            };
            $.ajax(settings).done(function (res) {
                //let data=JSON.parse(response)
                printGroupMembers(res.response.memberList, res.response.meCreator, groupId);
                groupObjects[groupId] = res.response.groupInfo;
                groupImages[groupId] = res.response.groupInfo.groupImage;
                createGroupImage(groupId,function () {
                    printGroupInfo(groupId,groupImages, res.response.groupInfo.groupName);
                });
                $("#groupName_" + groupId).html("<div>" + res.response.groupInfo.groupName + "</div>");
                $(".UserNames").html(res.response.groupInfo.groupName);
                printGroupInfo(groupId, groupImages, res.response.groupInfo.groupName);
                toastr.info("Member deleted");
                // getGroupMembers(groupId);
            });
        });


        // Ralph 2019-05-15
        let searchGroupInput = $('#searchGroupInput').magicSuggest({
            placeholder: 'Search Vyndue...',
            allowFreeEntries: false,
            maxSelection: 1,
            hideTrigger:true,
            expandOnFocus: true,
            cls: 'searchGroupInput',
            groupBy: 'type_description',
            maxDropHeight: 680, // max height of screen,
            renderer: function (data) {
                let html = '';
                return `<div style="padding: 5px; overflow:hidden;">
                    <div style="float: left;" class="mxjak-left"><img style="width: 25px;height: 25px" src=" ${data.picture} " /></div> 
                    <div style="float: left; margin-left: 9px" class="mxjak-right"> 
                    <div style="font-weight: bold; color: #333; font-size: 12px; line-height: 11px"> ${data.name} </div> 
                    <div style="color: #999; font-size: 9px" class="s"> ${ data.email==null ? '&nbsp;' : data.email  } </div> 
                    </div> 
                    </div><div style="clear:both;"></div>`; 
            }
        });

        $(searchGroupInput).on('focus', function(e){
            getSearchList(function(response){
                let res = response.response.friends;
                let q = [];
                    for (i = 0; i < res.length; i++) {
                        if (res[i].userStatus != 0) {
                            let md = {
                                id: parseInt(res[i].id),
                                name: res[i].name,
                                picture: res[i].picture,
                                email: res[i].email,
                                type_id: res[i].type_id,
                                type_description: res[i].type_description
                            };
                            q.push(md);
                        }
                    }
                    searchGroupInput.setData(q);
                    searchGroupInput.clear();
            });
        });

        // if user selected an item
        $(searchGroupInput).on('selectionchange', function(){
            let data = this.getSelection()[0];
            if(data===undefined) return;
            switch (parseInt(data.type_id)) {
                case 2:
                case 0:
                    $("li#group_"+data.id).first().trigger("click", [{update: true}]);
                break;
            
                case 1:
                    let url = "<?php echo base_url('user/hasConversation?friendId='); ?>" + data.id;
                    if (ID_BASED) {
                        url = "<?php echo base_url('user/hasConversation?friendId='); ?>" + data.id + "&userId=" + userId;
                    }
                    let settings = {
                        "async": true,
                        "crossDomain": true,
                        "url": url,
                        "method": "GET",
                        "headers": {
                            "authorization": "Basic YWRtaW46MTIzNA==",
                            "Authorizationkeyfortoken": String(responce),
                            "cache-control": "no-cache",
                            "postman-token": "eb27c011-391a-0b70-37c5-609bcd1d7b6d"
                        },
                        "dataType": 'json'
                    };
                    $.ajax(settings).done(function (response) {
                        let groupId = response.response.groupId;
                        if(groupId>0){
                            $("li#group_"+groupId).first().trigger("click", [{update: true}]);
                        }else{
                            
                            addmember.empty();
                            addmember.clear();
                            addmember.disable();
                            $("div#newMessage").first().trigger("click", [{update: true}]);

                             setTimeout(() => {
                                 
                                addmember.setValue({id:data.id});
                                addmember.enable();
                             }, 1000);
                             
                        }
                    });
                break;
            }
            searchGroupInput.clear();
            searchGroupInput.collapse();

        });


        // add member at the right side bar
        $('#addMember').on("click", function (e) {
            getMembers(function (res) {
                let q = [];
                for (i = 0; i < res.length; i++) {
                    if (res[i].userStatus != 0) {
                        let md = {
                            id: parseInt(res[i].userId),
                            name: res[i].firstName + " " + res[i].lastName,
                            picture: res[i].profilePictureUrl,
                            email: res[i].userEmail
                        };
                        q.push(md);
                    }
                }
                newMemberInput.setData(q);
                newMemberInput.clear();
                $('#addNewMemberModal').modal('show');
            });
        });
        $("#newMemberAddBtn").on("click", function (e) {
            let userIds = newMemberInput.getValue();
            let groupId = activeGroupId;
            if (userIds.length > 0) {
                let form = new FormData();
                for (i = 0; i < userIds.length; i++) {
                    form.append("memberId[]", userIds[i]);
                }
                form.append("groupId", groupId);
                form.append("userId", userId);
                let settings = {
                    "async": true,
                    "crossDomain": true,
                    "url": "<?php echo base_url('imApi/addGroupMember/'); ?>",
                    "method": "POST",
                    "headers": {
                        "authorization": "Basic YWRtaW46MTIzNA==",
                        "Authorizationkeyfortoken": String(responce),
                        "cache-control": "no-cache",
                        "postman-token": "eb27c011-391a-0b70-37c5-609bcd1d7b6d"
                    },
                    "processData": false,
                    "contentType": false,
                    "data": form,
                    "error": function (e) {
                        let err = JSON.parse(e.responseText);
                        toastr.error(err.response);
                    },
                };
                $.ajax(settings).done(function (res) {
                    printGroupMembers(res.response.memberList, res.response.meCreator, groupId);
                    groupImages[groupId] = res.response.groupInfo.groupImage;
                    groupObjects[groupId] = res.response.groupInfo;
                    createGroupImage(groupId,function () {
                        printGroupInfo(groupId,groupImages, res.response.groupInfo.groupName);
                    });
                    $("#groupName_" + groupId).html("<div>" + res.response.groupInfo.groupName + "</div>");
                    $(".UserNames").html(res.response.groupInfo.groupName);
                    printGroupInfo(groupId, groupImages, res.response.groupInfo.groupName);
                    newMemberInput.clear();
                    toastr.info("member add successful");
                    $('#addNewMemberModal').modal('hide');
                    // getGroupMembers(groupId);
                });
            }
        });
        $('#invitationLinkCopyBtn').on('click', function() {
            var copyText = document.getElementById("invitationLink");
            copyText.select();
            document.execCommand("copy");
            toastr.success('Link copied!')
        });
        $('#inviteLinkBtn').on('click', function (e) {
            let form=new FormData();
            form.append("groupId", activeGroupId);
            let settings = {
                "async": true,
                "crossDomain": true,
                "url": "<?php echo base_url('imApi/generateInviteLink'); ?>",
                "method": "POST",
                "headers": {
                    "authorization": "Basic YWRtaW46MTIzNA==",
                    "Authorizationkeyfortoken": String(responce),
                    "cache-control": "no-cache",
                    "postman-token": "2a391657-45a9-1a7b-9a67-9b16b0dda13a"
                },
                "processData": false,
                "contentType": false,
                "mimeType": "multipart/form-data",
                "data": form,
                "error": function (e) {
                    let err = JSON.parse(e.responseText);
                    toastr.error(e);
                },
            };
            $.ajax(settings).done(function (response) {
                response = JSON.parse(response);
                let link = response.base_url + 'activate.php?token=' + response.token;
                $('#invitationLink').val(link);
                $('#generateInviteLinkModal').modal('show');
                
            })
        });

        $('#inviteLinkValidator').on('click', function(){
            let userData = jwt_decode(localStorage.getItem("_r"));

            const urlParams = new URLSearchParams(window.location.search);
            const token = urlParams.get('token');

            let form=new FormData();
            form.append("userId", userData['userId']);
            form.append("token", token);
            let settings = {
                "async": true,
                "crossDomain": true,
                "url": "<?php echo base_url('imApi/inviteActivate'); ?>",
                "method": "POST",
                "headers": {
                    "authorization": "Basic YWRtaW46MTIzNA==",
                    "Authorizationkeyfortoken": String(responce),
                    "cache-control": "no-cache",
                    "postman-token": "2a391657-45a9-1a7b-9a67-9b16b0dda13a"
                },
                "processData": false,
                "contentType": false,
                "mimeType": "multipart/form-data",
                "data": form,
                "error": function (e) {
                    let err = JSON.parse(e.responseText);
                    // toastr.error(e);
                },
            };
            $.ajax(settings).done(function (response) {
                $response = JSON.parse(response);
                if($response.success) {
                    toastr.success($response.message);
                    $data = {user_id: $response.user_id, group_id: $response.group_id, admin_id: $response.admin_id.createdBy, generator_id: $response.generator_id};
                    socket.emit("invitationaccept",$data);
                    // location.href="<?php echo base_url('userview/im'); ?>"; //IF LOCAL TESTING
                    location.href="https://vyndue.com/userview/im";    //LIVE TESTING
                }
                else{
                    toastr.error($response);
                    location.href="https://vyndue.com/userview/im";
                }
            })
        });
        // getmembers creating a new conversation, found at the left side bar
        $('#newMessage').on("click", function (e) {
            resetNewMessage();
            getMembers(function (res) {
                let q = [];
                for (i = 0; i < res.length; i++) {
                    if (res[i].userStatus != 0) {
                        let md = {
                            id: parseInt(res[i].userId),
                            name: res[i].firstName + " " + res[i].lastName,
                            picture: res[i].profilePictureUrl,
                            email: res[i].userEmail
                        };
                        q.push(md);
                    }
                }
                addmember.setData(q);
                addmember.clear();
                addmember.empty();
                $('#newMessageModal').modal('show');
            });
        });
        $('#newMessagefileIV').on("click", function () {
            $("#newMessageFile").click();
        });
        $('#fileIV').on("click", function () {
            $("#messageFile").click();
        });
        $('#fileIV1').on("click", function () {
            $("#messageFile1").click();
        });
        $("#messageFile").change(imageChange);
        $("#messageFile1").change(attachChange);
        $("#newMessageFile").change(imageChangeNewMessage);
        $("#changeGroupImage").on("click",function () {
            $("#groupImageFile").click();
        });
        $("#groupImageFile").change(imageChangeGroup);
        function init_twemoji() {
            $('#message').twemojiPicker(sendMessageSettings);
            $(".twemoji-list").perfectScrollbar({suppressScrollX: true});
            $('#message_twemoji').on("keyup input", function (e) {
                if (e.which == 13) {
                    $('#sendMessage').trigger('click');
                } else {
                    onKeyDownNotEnter(e);
                }
                if (isUnicode($(this).text())) {
                    $(this).css('direction', 'rtl');
                    $("#message_icon_picker").find(".emoji.emoji_header").css({"left": "21px", "right": "unset"});
                    $("#message_twemoji").css({"padding-left": "50px"});
                    $("#message_twemoji").css({"padding-right": "12px"});
                }
                else {
                    $(this).css('direction', 'ltr');
                    $("#message_icon_picker").find(".emoji.emoji_header").css({"left": "unset", "right": "21px"});
                    $("#message_twemoji").css({"padding-right": "50px"});
                    $("#message_twemoji").css({"padding-left": "12px"});
                }
            });
            $('#newMessageText').twemojiPicker(sendNewMessageSettings);
            $('#newMessageText_twemoji').on("keyup input", function (e) {
                if (e.which == 13) {
                    $('#newSendMessage').trigger('click');
                }
                if (isUnicode($(this).text())) {
                    $(this).css('direction', 'rtl');
                    $("#newMessageText_icon_picker").find(".emoji.emoji_header").css({
                        "left": "21px",
                        "right": "unset"
                    });
                    $("#newMessageText_twemoji").css({"padding-left": "50px"});
                    $("#newMessageText_twemoji").css({"padding-right": "12px"});
                }
                else {
                    $(this).css('direction', 'ltr');
                    $("#newMessageText_icon_picker").find(".emoji.emoji_header").css({
                        "left": "unset",
                        "right": "21px"
                    });
                    $("#newMessageText_twemoji").css({"padding-right": "50px"});
                    $("#newMessageText_twemoji").css({"padding-left": "12px"});
                }
            });
        }

        $('#sendMessage').on("click mouseup", function (event) {
            if(!messageTyping){
                return;
            }
            let receiverId = activeGroupId;
            if (receiverId === null || receiverId === "") {
                return;
            }
            if (messageLoading) {
                return;
            }
            $('.close').trigger("click");
            $("#message").find("div:has(br)").each(function () {
                if ($(this).html() === '<br>' || $(this).html() === '<br />') {
                    $(this).remove();
                }
            });
            let message = $('#message').text();
            //console.log(message);
            //return;
            let mainFileObject = null;
            let file = $("#messageFile").val();
            if (file === null || file === "") {
                file = $("#messageFile1").val();
                mainFileObject = $("#messageFile1")[0].files[0];
            }
            else {
                mainFileObject = $("#messageFile")[0].files[0];
            }

            let modmessage = message;

            if(!message.includes('<m>')){
                modmessage = message.replace(/(<([^>]+)>)/ig, "").replace(/&nbsp;/gi, " ").replace(/&nbsp;/gi, " ").trim();
            }else{
                if(message.includes('chat_stock_table')){
                    //console.log('stock');
                }else{
                    modmessage = message.replace(/(<\/?(?:a)[^>]*>)|<[^>]+>/ig, '$1').replace(/&nbsp;/gi, " ").replace(/&nbsp;/gi, " ").trim();
                }
            }
           
            // send message event
            if ((modmessage === null || modmessage === "") && (file === null || file === "")) {
                reset();
                return;
            }
            if (modmessage != null || modmessage != "") {
                $('#message').val(modmessage);
            }
            let date = moment().format("YYYY-MM-DD");
            let time = moment().format("HH:mm:ss");
            let form = new FormData($('#messageForm')[0]);
            let socketData = $('#messageForm').serializeFormJSON();
            socketData.groupId = receiverId;
            form.append("groupId", receiverId);
            form.append("file", mainFileObject);
            reset();  
            if (file === null || file === "") {
                sendMessage(form, false, false, socketData);
            }
            else {
                sendMessage(form, true, false, socketData);
            }
        });
        $('#newSendMessage').on("click", function (event) {
            //$('.close').trigger("click");
            let message = $('#newMessageText').text();
            let modmessage = message.replace(/(<([^>]+)>)/ig, "").replace(/&nbsp;/gi, " ").replace(/&nbsp;/gi, " ").trim();
            let file = $("#newMessageFile").val();
            if ((modmessage == null || modmessage == "") && (file == null || file == "")) {
                //resetNewMessage();
                $('#newMessageText_twemoji').focus();
                event.preventDefault();
                return;
            }
            if (modmessage != null || modmessage != "") {
                $('#newMessageText').val(modmessage);
            }
            let date = moment().format("YYYY-MM-DD");
            let time = moment().format("HH:mm:ss");
            let userIds = addmember.getValue();
            if (userIds.length == 0) {
                $('#addMemberInput :input[type=text]')[0].focus();
                event.preventDefault();
                return;
            }
            let form = new FormData($('#newMessageForm')[0]);
            let socketData = $('#newMessageForm').serializeFormJSON();
            socketData.memberId = userIds;
            for (i = 0; i < userIds.length; i++) {
                form.append("memberId[]", userIds[i]);
            }
            sendMessage(form, false, true, socketData);
            $('#groups').scrollTop(0);
            getGroupList_v2(function(resp){
                // console.log(resp);
            })
            event.preventDefault();
        });

       
        $('#editGroupName').on("click", function (event) {
            $("#groupName").css("border", "1px solid #ccc");
            $("#changeNameModal").modal("show");
        });
        $('#editGroupImage').on("click", function (event) {
            $("#groupName").css("border", "1px solid #ccc");
            $("#changeNameModal").modal("show");
        });
        $("#groupName").focus(function () {
            $(this).css("border", "1px solid #ccc");
        });
        $('#changeNameBtn').on("click", function () {
            let groupId = activeGroupId;
            let groupName = $("#groupName").val();
            groupName = groupName.replace(/<script[^>]*>/gi, "&lt;script&gt;").replace(/<\/script[^>]*>/gi, "&lt;/script&gt;").replace(/(<([^>]+)>)/ig, "").replace(/&nbsp;/gi, " ").replace(/&nbsp;/gi, " ").trim();
            if (groupName == null || groupName == "") {
                $('#groupName').css("border", "1px solid red");
                toastr.error("Group name is empty");
                return;
            }

            let form = new FormData();
            form.append("groupId", groupId);
            form.append("groupName", groupName);
            form.append("userId", userId);
            let settings = {
                "async": true,
                "crossDomain": true,
                "url": "<?php echo base_url('imApi/changeGroupName'); ?>",
                "method": "POST",
                "headers": {
                    "authorization": "Basic YWRtaW46MTIzNA==",
                    "Authorizationkeyfortoken": String(responce),
                    "cache-control": "no-cache",
                    "postman-token": "2a391657-45a9-1a7b-9a67-9b16b0dda13a"
                },
                "processData": false,
                "contentType": false,
                "mimeType": "multipart/form-data",
                "data": form,
                "error": function (e) {
                    let err = JSON.parse(e.responseText);
                    toastr.error(err.response);
                },
            };
            $.ajax(settings).done(function (response) {
                toastr.info("Group name update successful");
                $("#changeNameModal").modal("hide");
                groupObjects[groupId].groupName = groupName;
                $("#groupName").val("");
            })
        });
        $("#block").on("click", function () {

            if(!confirm("Are you sure to block this person?")){
                return false;
            }

            let groupId = activeGroupId;
            let form = new FormData();
            form.append("groupId", groupId);
            form.append("userId", userId);
            let settings = {
                "async": true,
                "crossDomain": true,
                "url": "<?php echo base_url('imApi/blockGroup'); ?>",
                "method": "POST",
                "headers": {
                    "Authorization": "Basic YWRtaW46MTIzNA==",
                    "Authorizationkeyfortoken": String(responce),
                    "Cache-Control": "no-cache",
                    "Postman-Token": "4272ac4e-661d-4865-b1dd-857fcd936e96"
                },
                "processData": false,
                "contentType": false,
                "mimeType": "multipart/form-data",
                "data": form,
                "error": function (e) {
                    let err = JSON.parse(e.responseText);
                    toastr.error(err.response);
                },
            };
            $.ajax(settings).done(function (response) {
                toastr.info("Block successful");
            });
        });
        $("#unblock").on("click", function () {

            if(!confirm("Are you sure to unblock this person?")){
                return false;
            }

            let groupId = activeGroupId;
            let form = new FormData();
            form.append("groupId", groupId);
            form.append("userId", userId);
            let settings = {
                "async": true,
                "crossDomain": true,
                "url": "<?php echo base_url('imApi/unblockGroup'); ?>",
                "method": "POST",
                "headers": {
                    "Authorization": "Basic YWRtaW46MTIzNA==",
                    "Authorizationkeyfortoken": String(responce),
                    "Cache-Control": "no-cache",
                    "Postman-Token": "4272ac4e-661d-4865-b1dd-857fcd936e96"
                },
                "processData": false,
                "contentType": false,
                "mimeType": "multipart/form-data",
                "data": form,
                "error": function (e) {
                    let err = JSON.parse(e.responseText);
                    toastr.error(err.response);
                },
            };
            $.ajax(settings).done(function (response) {
                toastr.info("Unblock successful");
            });
        });
        $("#mute").on("click", function () {

            if(!confirm('Are you sure to mute this conversation?')){
                return;
            }

            let groupId = activeGroupId;
            let form = new FormData();
            form.append("groupId", groupId);
            form.append("userId", userId);
            let settings = {
                "async": true,
                "crossDomain": true,
                "url": "<?php echo base_url('imApi/muteGroup'); ?>",
                "method": "POST",
                "headers": {
                    "Authorization": "Basic YWRtaW46MTIzNA==",
                    "Authorizationkeyfortoken": String(responce),
                    "Cache-Control": "no-cache",
                    "Postman-Token": "4272ac4e-661d-4865-b1dd-857fcd936e96"
                },
                "processData": false,
                "contentType": false,
                "mimeType": "multipart/form-data",
                "data": form,
                "error": function (e) {
                    let err = JSON.parse(e.responseText);
                    toastr.error(err.response);
                },
            };
            $.ajax(settings).done(function (response) {
                toastr.info("Message muted successful");
            });
        });
        $("#unmute").on("click", function () {

            if(!confirm('Are you sure to unmute this conversation?')){
                return;
            }

            let groupId = activeGroupId;
            let form = new FormData();
            form.append("groupId", groupId);
            form.append("userId", userId);
            let settings = {
                "async": true,
                "crossDomain": true,
                "url": "<?php echo base_url('imApi/unmuteGroup'); ?>",
                "method": "POST",
                "headers": {
                    "Authorization": "Basic YWRtaW46MTIzNA==",
                    "Authorizationkeyfortoken": String(responce),
                    "Cache-Control": "no-cache",
                    "Postman-Token": "4272ac4e-661d-4865-b1dd-857fcd936e96"
                },
                "processData": false,
                "contentType": false,
                "mimeType": "multipart/form-data",
                "data": form,
                "error": function (e) {
                    let err = JSON.parse(e.responseText);
                    toastr.error(err.response);
                },
            };
            $.ajax(settings).done(function (response) {
                toastr.info("Unmuting successful");
            });
        });
        $(".persons").on("mouseenter", ".person", function () {
            if ($(this).hasClass("active")) {
                return;
            } else {
                if (!$(this).hasClass("person-hover")) {
                    $(this).addClass('person-hover');
                }
            }
        });
        $(".persons").on("mouseleave", ".person", function () {
            if ($(this).hasClass("person-hover")) {
                $(this).removeClass('person-hover')
            }
        });
        $("#leaveGroup").on("click", function () {

            if(!confirm('Are you sure to leave this conversation?')){
                return;
            }

            let form = new FormData();
            form.append("groupId", activeGroupId);
            form.append("userId", userId);
            let settings = {
                "async": true,
                "crossDomain": true,
                "url": "<?php echo base_url('imApi/leaveGroup'); ?>",
                "method": "POST",
                "headers": {
                    "Authorization": "Basic YWRtaW46MTIzNA==",
                    "Authorizationkeyfortoken": String(responce),
                    "Cache-Control": "no-cache",
                    "Postman-Token": "a64d0529-ed6e-434b-8b39-1f5331ba0b0c"
                },
                "processData": false,
                "contentType": false,
                "mimeType": "multipart/form-data",
                "data": form,
                "error": function (e) {
                    let err = JSON.parse(e.responseText);
                    toastr.error(err.response);
                },
            };
            $.ajax(settings).done(function (response) {
                toastr.info("You successfully leave the group.");
            });
        });
        $("#unreadMessage").on("click", function () {
            // spin the refresh
            let progress1 = new LoadingOverlayProgress();
            const icon = $(this).find('i');
            icon.toggleClass('fa-spin');
            $("body").LoadingOverlay("show");
            groupBox.append("<div class='text-center groupLoader'><div class='loader'></div></div>");
            let settings = {
                "async": true,
                "crossDomain": true,
                "url": "<?php echo base_url('imApi/getUnreadMessageGroups'); ?>",
                "method": "GET",
                "headers": {
                    "Authorization": "Basic YWRtaW46MTIzNA==",
                    "Authorizationkeyfortoken": String(responce),
                    "Cache-Control": "no-cache",
                    "Postman-Token": "a76cef82-b4f1-462f-aea9-b2106968c16a"
                }
            };
            $.ajax(settings).done(function (response) {
                let groups = response.response;
                for (let i = 0; i < groups.length; i++) {
                    if (document.getElementById("group_" + groups[i].groupId)) {
                        $("#group_" + groups[i].groupId).remove();
                    }
                    addNewGroup(groups[i]);
                }
                delete progress1;
                $("body").LoadingOverlay("hide");
                $('.groupLoader').remove();
                icon.toggleClass('fa-spin');
            });
        });
    
        // Ralph 2019-05-22
        $('#btnSettings').on("click", function (e) {
            //return;

            return;

            var data = {
                groupId:10,
                message:'hello <a href="#" data-username="uBNvSBrIXg" class="mention">@John Doe</a>  and <a href="#" data-username="Zjk3hVyYNy" class="mention">@Billy Cruz</a>',
                _r:"eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6ImIxN1p5aFJSNXkiLCJpc3N1ZWRBdCI6IjIwMTktMDUtMjJUMDQ6MTI6NDUrMDAwMCIsImZpcnN0TmFtZSI6IlJhbHBoIiwidXNlck5hbWUiOiJSYWxwaCBUb2xpcGFzIiwicHJvZmlsZVBpY3R1cmUiOiJodHRwOlwvXC9kZXYudnluZHVlLmNvbVwvYXNzZXRzXC9pbWdcL2Rvd25sb2FkLnBuZyIsInVzZXJFbWFpbCI6InJhbHBoQGVtYWlsLmNvbSIsInVzZXJJZCI6IjMiLCJ1c2VyVHlwZSI6IjEifQ.MiAoPJkiOVfTcl28bDhF8dXcFE3-Ofc51RSpiIEZNnY"
            };


            return;

        });

        //Join Request Modal
        $('#communityModerator').on("click", function (e) {

            $("#modalCommunityModerator").modal("show");
            getCommunityModerator(activeGroupId, listCommunityModerator);

        });
        
        //Join Request Modal
        $('#joinRequest').on("click", function (e) {

            $("#modalJoinRequest").modal("show");
            getJoinRequest(activeGroupId);

        });


        $('#btnNotifications').on("click", function (e) {

            $("#modalNotifications").modal("show");
            $("#btnNotifications").removeClass('hasNotifications');
            getNotification();

        });

        $('#btnCommunities').on("click", function (e) {
            let _g = localStorage.getItem("_g");
            if (_g == null || _g == "" || _g=='null') {
                getCommunities(function(response){
                    localStorage.setItem("_g",JSON.stringify(response));
                    let data = localStorage.getItem('_g');
                    listCommunities(data,1,false);
                    $("#modalCommunities").modal("show");
                    $('#findCommunity').focus();
                });
            }else{
                let data = localStorage.getItem('_g');
                listCommunities(data,1,false);
                $("#modalCommunities").modal("show");
                $('#findCommunity').focus();
            }
        });

        function pageCommunities(page,lastpage){
            //init pagination
            let ret = {};
        
            ret.page = currentCommunityPage = 1;
            ret.prev = 0;
            ret.next = 0;
            ret.prev_page = 1;
            ret.next_page = 2;
            ret.last_page = (parseInt(lastpage)>1) ? lastpage : 1 ;
            if(parseInt(page)>1){
                ret.page = currentCommunityPage = parseInt(page);
                ret.prev = 1;
                ret.prev_page = parseInt(ret.page)-1;
                ret.next_page = parseInt(ret.page)+1;
            }else{
                ret.page = currentCommunityPage = 1;
                ret.prev = 0;
            }
            ret.next = (ret.page==ret.last_page) ? 0 : 1;
            let html = `<span class="list-group-item list-group-item-info row">
                    <ul class="grplist col-md-6">
                    <!--<span class="arbitrage-button arbitrage-button--info" id="createCommunity">
                        <i class="fa fa-plus-circle fa-fw"></i> Create Community</span>-->
                    </ul>
                    <ul class="pager col-md-6" style="margin:0;">
                        <li ${ (!ret.prev) ? 'class="disabled"' : '' }><a href="#" data-page="${ret.prev_page}" data-prev="${ (ret.prev) ? 1 : 0  }" id="communityPrev"><i class="fas fa-chevron-circle-left"></i></a></li>
                        <li ${ (!ret.next) ? 'class="disabled"' : '' }><a href="#" data-page="${ret.next_page}" data-next="${ (ret.next) ? 1 : 0  }" id="communityNext"><i class="fas fa-chevron-circle-right"></i></a></li>
                    </ul>
                    </nav>
                </span>`;
            return html;

        }

        function loopCommunities(records){
            let html = '';
            for (let i = 0; i < records.length; i++) {
                let raw = records[i];
                let rec = jwt_decode(records[i].data);
                let btn_icon, btn_color, btn_label, btn_disabled;
                switch (rec.status_id) {
                    case 0:
                        btn_icon = 'fas fa-plus-circle';
                        btn_color = 'info';
                        btn_label = 'Join';
                        btn_disabled = '';
                    break;
        
                    case 1:
                        btn_icon = 'fas fa-clock';
                        btn_color = 'primary';
                        btn_label = 'Requested';
                        btn_disabled = 'disabled';
                    break;

                    case 2:
                        btn_icon = 'fas fa-check-circle';
                        btn_color = 'success';
                        btn_label = 'Joined';
                        btn_disabled = 'disabled';
                    break;

                    case 3:
                        btn_icon = 'fas fa-star';
                        btn_color = 'warning';
                        btn_label = 'Admin';
                        btn_disabled = 'disabled';
                    break;
                }
                html += `<a style="color:black" class="list-group-item"> 
                        <img src="${ rec.picture }" class="communitylist_thumbnail">  
                        <label class="communitylist_label">${ rec.name }</label> 
                        <button type="button" ${btn_disabled} class="btn-xs btn-${btn_color} pull-right communitylist_btn"
                            data-raw-id="${ parseInt(raw.id) }" 
                            data-raw-data="${ raw.data }"
                            data-raw-page="${ raw.page }" 
                            data-id="${rec.id}" data-name="${ rec.name }" >
                            <i class="${btn_icon} fa-fw" aria-hidden="true"></i> <span>${btn_label}</span>
                        </button></a>`;       
            }
            return html;
        }

        $(document).on('click', 'button.communitylist_btn', function (e) {
            let group_btn = $(this);
            let group_id = parseInt($(this).attr('data-id'));
            let group_name = $(this).attr('data-name');
            let raw_id = parseInt($(this).attr('data-raw-id'));
            let raw_data = $(this).attr('data-raw-data');
            let raw_page = parseInt($(this).attr('data-raw-page'));

            if(!confirm("Are you sure to join "+ group_name )){
                return;
            }
            //  request send
            if(navigator.onLine==false){
                toastr.error("Request Failed. No Internet");
                return;
            }
            let form=new FormData();
            form.append("groupId", group_id);
            form.append("rawData", raw_data);
            let url = "<?php echo base_url('user/communityJoin'); ?>";
            let settings = {
                "async": true,
                "crossDomain": true,
                "url": url,
                "method": "POST",
                "headers": {
                    "authorization": "Basic YWRtaW46MTIzNA==",
                    "Authorizationkeyfortoken": String(responce),
                    "cache-control": "no-cache",
                    "postman-token": "58e7510b-ad46-6037-fc4d-028915069e2b"
                },
                "processData": false,
                "contentType": false,
                "mimeType": "multipart/form-data",
                "data": form,
                "error": function (e) {
                    let err = JSON.parse(e.responseText);
                    group_btn.prop('disabled', false);
                    group_btn.find('span').text('Join');
                    group_btn.find('i').addClass('fa-plus-square');
                    group_btn.find('i').removeClass('fa-paper-plane-o');
                    group_btn.addClass("btn-info");
                    group_btn.removeClass("btn-primary");
                    toastr.error(err.response);
                },
                "beforeSend": function () {
                    group_btn.prop('disabled', true);
                    group_btn.find('span').text('Sending...');
                }
            };
            $.ajax(settings).done(function (response) {
                group_btn.removeClass("btn-info");
                group_btn.addClass("btn-primary");
                group_btn.prop('disabled', true);
                group_btn.find('span').text('Requested');
                group_btn.find('i').removeClass('fa-plus-square');
                group_btn.find('i').addClass('fa-paper-plane-o');
                toastr.info("Your request to join has been sent to community administrator of " + group_name);
                // update cache
                let result = JSON.parse(response).response;    
                let obj = { id:raw_id, page:raw_page, data: result.rawData };
                let local = JSON.parse(localStorage.getItem('_g'));
                localStorage.removeItem('_g')
                let newData = local.filter(row => row.id!==raw_id);
                newData.push(obj);
                newData.sort((a, b) => (a.id > b.id) ? 1 : -1)
                localStorage.setItem('_g',JSON.stringify(newData));
                // send message to admin
                socket.emit("sendNotification",result.n_id)
            });
            e.preventDefault();
        });
        
        function listCommunities(data,page,find){
            if(!data){
                communityBox.html("<h4>Community box is empty.</h4>");
                return;
            }
            communityBox.html('<br><br><br><p align="center"><i class="fa fa-spinner fa-spin fa-4x fa-fw" aria-hidden="true"></i></p>');
            let html = '';
            let records = '';
            let jwtdata =  JSON.parse(data);
            if(!find || find==undefined){
                // pages
                html += pageCommunities(page,parseInt(jwtdata[jwtdata.length-1].page));
                // list
                let records = jwtdata.filter(row => parseInt(row.page)==parseInt(page));
                html += loopCommunities(records);
            }else{              
     
                if(find.length==undefined || find.length<3){
                    communityBox.html('<p align="center"><i class="fa fa-ellipsis-h fa-4x fa-fw" aria-hidden="true"></i></p><h2 align=center>Then Hit Enter</h2><p align="center"><small><b>Simply click "ESC" to get back in Normal List</b></small></p>');
                    return; 
                }
                
                const regexp = new RegExp(find.replace(/[^a-zA-Z0-9]/g, ''), 'i');
                let records = jwtdata.filter(row => {
                    let rec = jwt_decode(row.data);
                    if(regexp.test(rec.name)==true){
                        return rec;
                    }
                });

                if(records.length===0 && find.length>2){
                    communityBox.html('<br><br><br><p align="center"><i class="fa fa-frown-o fa-4x fa-fw" aria-hidden="true"></i></p><br><h2 align=center>No Record Found</h2><p align="center"><small><b>Simply click "ESC" to get back in Normal List</b></small></p>');
                    return;
                }else{
                    html += loopCommunities(records);
                }
            }
            
            communityBox.html(html);
        }

        $(document).on('click', 'a#communityPrev', function (e) {
            let page = $(this).attr('data-page');
            let prev = parseInt($(this).attr('data-prev'));
            if(prev){
                listCommunities(localStorage.getItem('_g'),page);
                return;
            } 
            e.preventDefault();
        });

        $(document).on('click', 'a#communityNext', function (e) {
            let page = $(this).attr('data-page');
            let next = parseInt($(this).attr('data-next'));
            if(next){
                listCommunities(localStorage.getItem('_g'),page);
                return;
            } 
            e.preventDefault();
        });

        $('#findCommunity').on('keyup', function(e) {
            var input = $(this);
            if(input.val().length === 0) {
                input.addClass('searchAwesome');
            } else {
                input.removeClass('searchAwesome');
            }
            if(e.which==27){
                listCommunities(localStorage.getItem('_g'),currentCommunityPage,false);
                $(this).val(null);
            }
        });

        $('#findCommunity').on('keypress',function(e) {
            if(e.which == 13) {
                let find = e.target.value;
                find = find.trim();
                if(find.length<=2){
                    communityBox.html('<p align="center"><i class="fa fa-ellipsis-h fa-4x fa-fw" aria-hidden="true"></i></p><br><h2 align=center>Then Hit Enter</h2><p align="center"><small><b>Simply click "ESC" to get back in Normal List</b></small></p>');
                    toastr.error('Notice: Please enter a minimum of 3 characters');
                    return;
                }else{
                    listCommunities(localStorage.getItem('_g'),1,find);
                }
            }
        });

        $('#findCommunity').on('focus', function() {
            listCommunities(localStorage.getItem('_g'),1,true);
        });

        // $('#findCommunity').on('blur', function() {
        //     $(this).val(null);
        //     listCommunities(localStorage.getItem('_g'),currentCommunityPage,false);
        // });


        $(document).on('click', 'span.vyndue_email div', function (e) {
            let url = "<?=ARBITRAGE.'/user/'; ?>"+ $(this).text() + "/";
            window.open(url.replace(' ',''), "_blank");
            e.preventDefault();
        });
        

//-------------------- Drop Zone ---------------------------------------
        //dropZone
        function preventDefaults (e) {
            e.preventDefault();
            e.stopPropagation();
        }
        function highlight(e) {
            dropArea.classList.add('highlight');
        }
        function unhighlight(e) {
            dropArea.classList.remove('highlight');
        }
        function handleDrop(e) {
            let dt = e.dataTransfer;
            let files = dt.files;
            handleFiles(files);
        }
        function handleFiles(files) {
            files = [...files];
            /*if(files.length>1){
                toastr.error("Can't Upload Multiple Files. Only One File Is Allowed.");
                return false;
            }*/
            files.forEach(uploadFile);

        }
        function uploadFile(file) {
            let attachFile = getFileExtension(file.name);
            let matched = false;
            let size = file.size;
            let match = ["txt","rar","zip","xlsx","xls","ppt","docx","pptx","text","doc","ppt","wma","mp3","mp4","pdf","3gpp","3gp","png","jpg","jpeg","csv"];
            if (size > max_upload_size) {
                toastr.error("Can't upload "+file.name);
                toastr.error("Max limit 20Mb exceeded");
                return false;
            }
            for (let i = 0; i < match.length; i++) {
                if (attachFile === match[i]) {
                    matched = true;
                }
            }
            if (matched) {
                if(!messageTyping){
                    return;
                }
                let receiverId = activeGroupId;
                if (receiverId === null || receiverId === "") {
                    return;
                }
                if (messageLoading) {
                    return;
                }
                var formData = new FormData();
                formData.append("file", file);
                formData.append("groupId", receiverId);
                sendMessage(formData, true, false, {});
            } else {
                toastr.error("This type of file is not allowed.");
                return false;
            }
        }
        let dropArea = document.getElementById('dropZone');
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false);
        });
        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, highlight, false);
        });
        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, unhighlight, false);
        });
        dropArea.addEventListener('drop', handleDrop, false);
//------------------  Web sockt section ------------------------------
        socket.on('newMessage', function (res) {
            messageTyping=true;
            chatBox.find('#blankImg').hide();
            chatBox.removeClass("text-center");
            chatBox.removeClass("vertical-alignment");
            chatBox.perfectScrollbar({suppressScrollX: true});
            if ($(".groupInfoContent").hasClass("hidden")) {
                $(".groupInfoContent").removeClass("hidden");
            }
            let data = res;
            let sender = data.sender;
            let message = data.message;
            let html = "";
            let seen = data.seen;
            // console.log(seen);
            let messageDate = moment(message.ios_date_time, moment.ISO_8601);
            LastMessageId = parseInt(message.m_id);
            if (!lastMessageDate) {
                html += "<div class=\"fw-im-message  text-center fw-im-othersender\" data-og-container=\"\">";
                html += "<div class=\"centerblock\">";
                html += moment(message.ios_date_time, moment.ISO_8601).calendar(null, momentOptions2);
                html += "                <\/div>";
                html += "                <\/div>";
                lastMessageDate = messageDate;
            }
            else if (lastMessageDate.date() - messageDate.date() >= 1 || lastMessageDate.date() - messageDate.date() <= -1) {
                if (lastMessageDate !== messageDate) {
                    html += "<div class=\"fw-im-message  text-center fw-im-othersender\" data-og-container=\"\">";
                    html += "<div class=\"centerblock\">";
                    html += moment(message.ios_date_time, moment.ISO_8601).calendar(null, momentOptions2);
                    html += "                <\/div>";
                    html += "                <\/div>";
                    lastMessageDate = messageDate;
                }
            } else if (lastMessageDate.diff(messageDate, 'minutes') <= -30) {
                html += "<div class=\"fw-im-message  text-center fw-im-othersender\" data-og-container=\"\">";
                html += "<div class=\"centerblock\">";
                html += moment(message.ios_date_time, moment.ISO_8601).calendar(null, momentOptions2);
                html += "                <\/div>";
                html += "                <\/div>";
                lastMessageDate = messageDate;
            }
            if (message.type === "update") {
                html += "<div id='message_" + message.m_id + "' class=\"fw-im-message  text-center fw-im-othersender update-message-font\" data-og-container=\"\">";
                html += "<div class=\"centerblock\">";
                html += "<i class='fa fa-tags'></i> " + message.message;
                html += "                <\/div>";
                html += "                <\/div>";
            }
            else {
                $(".fw-im-message-time").addClass("hidden");
                if (parseInt(sender.userId) !== parseInt(userId)) {
                    html += "<div  class=\"fw-im-message fw-im-isnotme fw-im-othersender\" data-og-container=\"\" title=\"" + moment(message.ios_date_time, moment.ISO_8601).calendar(null, momentOptions) + "\">";
                    if (isUnicode(sender.firstName)) {
                        html += "<div class='fw-im-message-author-name font-Tahoma'>" + sender.firstName + "</div>";
                    } else {
                        html += "<div class='fw-im-message-author-name'>" + sender.firstName + "</div>";
                    }
                    if (message.type === "text") {
                        if (message.onlyemoji) {
                            html += "                    <div id='message_" + message.m_id + "' class=\"fw-im-message-text\" style='background-color:transparent;'>" + parseMessage(message.message, true) + "<\/div>";
                        } else {
                            html += "                    <div id='message_" + message.m_id + "' class=\"fw-im-message-text\">" + parseMessage(message.message, false) + "<\/div>";
                        }
                        if (message.linkData !== null) {
                            html += getLinkPreview(JSON.parse(message.linkData), message.link);
                        }
                    }
                    if (message.type === "image") {
                        html += getImagePreview(message);
                    }
                    if (message.type === "video") {
                        html += "<div id='message_" + message.m_id + "' class=\"fw-im-attachments\" >";
                        html += "                        <video class='mediaVideo' id='video_" + message.m_id + "' poster='" + message.poster + "'  width=\"100%\" height=\"\" controls=\"true\" preload='none' name=\"media\"><source src=\"" + message.message + "\" type=\"video\/mp4\"><\/video>";
                        html += "                    <\/div>";
                    }
                    if (message.type === "audio") {
                        html += "<div id='message_" + message.m_id + "' class=\"fw-im-attachments mediaAudio-player-wrapper\" >";
                        html += "                        <audio class='mediaAudio' id='audio_" + message.m_id + "' style='width:100%;height:100%;' width='100%' height='100%'  controls=\"true\" preload='none' name=\"media\"><source src=\"" + message.message + "\" type=\"audio\/mp3\"><\/audio>";
                        html += "                    <\/div>";
                    }
                    if (message.type === "document") {
                        let strippedDocLink = message.message;
                        var limiter = strippedDocLink.search("%2Fim%2F");
                        if(limiter != -1) {
                            var dir = strippedDocLink.lastIndexOf("/");
                            dir = strippedDocLink.substring(0, dir + 1);
                            var fileName = strippedDocLink.lastIndexOf("%2F");
                            strippedDocLink = dir + "assets/temp/" + strippedDocLink.substring(fileName + 3, strippedDocLink.lastIndexOf('&fn='));
                        }
                        //html += "<div id='message_" + message.m_id + "' class=\"fw-im-attachments\" >";
                        html += "                        <div class=\"fw-im-message-text\"><a target='_blank' id='document_" + message.m_id + "' href=" + strippedDocLink + " ><i class=\"fa fa-arrow-circle-down\"></i> " + message.fileName + "<\/a></div>";
                        //html += "                    <\/div>";
                    }
                    html += "                    <div class=\"fw-im-message-author\"  title=\"" + sender.firstName + " " + sender.lastName + "\">";
                    if (sender.active === 1) {
                        html += "                        <img class='auth_" + sender.userId + "'  src=\"" + sender.profilePictureUrl + "\" ><span class='authStatus memberActive'></span>";
                    } else {
                        html += "                        <img class='auth_" + sender.userId + " authStatus' src=\"" + sender.profilePictureUrl + "\" >";
                    }
                    html += "                    <\/div>";
                    html += "                <\/div>";
                    if (!mute) {
                        $.playSound("<?php echo base_url('assets/img/nf'); ?>");
                        toastr.info("New Message from " + sender.firstName + " " + sender.lastName);
                    }
                } else {
                    html += "<div  class=\"fw-im-message  fw-im-isme fw-im-othersender\" data-og-container=\"\" title=\"" + moment(message.ios_date_time, moment.ISO_8601).calendar(null, momentOptions) + "\">";
                    if (message.type === "text") {
                        if (message.onlyemoji) {
                            html += "<div id='message_" + message.m_id + "' class=\"fw-im-message-text asdasd\" style='background-color:transparent;'>" + parseMessage(message.message, true) + "<\/div>";
                        } else {
                            html += "<div id='message_" + message.m_id + "' class=\"fw-im-message-text \">" + parseMessage(message.message, false) + "<\/div>";
                        }
                        if (message.linkData !== null) {
                            html += getLinkPreview(JSON.parse(message.linkData), message.link);
                        }
                    }
                    if (message.type === "image") {
                        html += getImagePreview(message);
                    }
                    if (message.type === "video") {
                        html += "<div id='message_" + message.m_id + "' class=\"fw-im-attachments\" >";
                        html += "                        <video class='mediaVideo' class='mediaVideo' id='video_" + message.m_id + "' poster='" + message.poster + "' width=\"100%\" height=\"\" controls=\"true\" preload='none'  name=\"media\"><source src=\"" + message.message + "\" type=\"video\/mp4\"><\/video>";
                        html += "                    <\/div>";
                    }
                    if (message.type === "audio") {
                        html += "<div id='message_" + message.m_id + "' class=\"fw-im-attachments mediaAudio-player-wrapper\" >";
                        html += "<audio class='mediaAudio' id='audio_" + message.m_id + "' style='width:100%;height:100%;' width='100%' height='100%'  controls=\"true\" preload='none' name=\"media\"><source src=\"" + message.message + "\" type=\"audio\/mp3\"><\/audio>";
                        html += "                    <\/div>";
                    }
                    if (message.type === "document") {
                        //html += "<div id='message_" + message.m_id + "' class=\"fw-im-attachments\" >";
                        html += "<div class=\"fw-im-message-text\"><a target='_blank' id='document_" + message.m_id + "' href=" + message.message + " ><i class=\"fa fa-arrow-circle-down\"></i> " + message.fileName + "<\/a></div>";
                        //html += "                    <\/div>";
                    }
                    html += "                    <div class=\"fw-im-message-author\"  title=\"" + sender.firstName + " " + sender.lastName + "\">";
                    html += "                        <img src=\"" + sender.profilePictureUrl + "\" >";
                    html += "                    <\/div>";
                    // console.log(seen.seen);
                    if (seen) {
                        if (seen.time) {
                            html += "                    <div class=\"fw-im-message-time seen  seenId_" + message.m_id + "\">";
                            html += "                        <span class='seenMessage_" + message.m_id + "'>" + seen.seen + moment(seen.time, moment.ISO_8601).calendar(null, momentOptions2) + "<\/span>";
                            html += "                    <\/div>";
                        } else {
                            html += "                    <div class=\"fw-im-message-time seen  seenId_" + message.m_id + "\">";
                            html += "                        <span class='seenMessage_" + message.m_id + "'>" + seen.seen + "<\/span>";
                            html += "                    <\/div>";
                        }
                    } else {
                        html += "                    <div class=\"fw-im-message-time seen hidden seenId_" + message.m_id + "\">";
                        html += "                        <span class='seenMessage_" + message.m_id + "'><\/span>";
                        html += "                    <\/div>";
                    }
                    html += "                <\/div>";
                }
            }

            if (presentTypingDiv) {
                $(html).insertBefore(presentTypingDiv);
            } else {
                chatBox.append(html);
            }


            let isme = parseInt(sender.userId) !== parseInt(userId);
            if (message.type == "video") {
                initVideo("video_" + message.m_id, isme);
            } else if (message.type == "audio") {
                initAudio("audio_" + message.m_id, isme);
            } else if (message.type == "text" && isUnicode(message.message)) {
                $("#message_" + message.m_id).css({"direction": "rtl", "font-family": "Tahoma"});
            }


            let groupId = data.to;
            if (message.type == "text") {
                if (parseInt(sender.userId) == parseInt(userId)) {
                    $('#messageType_' + groupId).html("You: " + message.message);
                } else {
                    $('#messageType_' + groupId).html(sender.firstName + ": " + message.message);
                }
            } else if (message.type !== "update") {
                $('#messageType_' + groupId).html(message.type);
                lightBox.init();
                getGroupFiles(groupId);
            }

            $('#time_' + groupId).html(moment(message.ios_date_time, moment.ISO_8601).fromNow());
            time[groupId] = message.ios_date_time;
            groupObjects[groupId].lastActive = message.ios_date_time;
            let height = chatBox[0].scrollHeight;
            //chatBox.scrollTop(height);
            clampData();
            /*if (activeGroupId === parseInt(data.to)) {
                let elementData = $("#group_" + activeGroupId).clone();
                $("#group_" + activeGroupId).remove();
                $("#groups").prepend(elementData);
                $("#groups").scrollTop(0);
            }*/
        });
        socket.on("getFetchOnReconnect", function (data) {
            //message section
            let messages = data.activeGroupMessages;
            let html = "";
            let message = null;
            let seen = null;
            let messageDate = null;
            let sender = null;
            let isme = parseInt(userId);
            
            if (messages.length > 0) {
                LastMessageId = parseInt(messages[messages.length - 1].message.m_id);
                time[activeGroupId] = messages[messages.length - 1].message.ios_date_time;
                $(".fw-im-message-time").addClass("hidden");
                for (let i = 0; i < messages.length; i++) {
                    message = messages[i].message;
                    sender = messages[i].sender;
                    seen = message.seen;
                    // console.log(seen);
                    messageDate = moment(message.ios_date_time, moment.ISO_8601);
                    if (!lastMessageDate) {
                        html += "<div class=\"fw-im-message  text-center fw-im-othersender\" data-og-container=\"\">";
                        html += "<div class=\"centerblock\">";
                        html += moment(message.ios_date_time, moment.ISO_8601).calendar(null, momentOptions2);
                        html += "                <\/div>";
                        html += "                <\/div>";
                        lastMessageDate = messageDate;
                    }
                    else if (lastMessageDate.date() - messageDate.date() >= 1 || lastMessageDate.date() - messageDate.date() <= -1) {
                        if (lastMessageDate !== messageDate) {
                            html += "<div class=\"fw-im-message  text-center fw-im-othersender\" data-og-container=\"\">";
                            html += "<div class=\"centerblock\">";
                            html += moment(message.ios_date_time, moment.ISO_8601).calendar(null, momentOptions2);
                            html += "                <\/div>";
                            html += "                <\/div>";
                            lastMessageDate = messageDate;
                        }
                    } else if (lastMessageDate.diff(messageDate, 'minutes') <= -30) {
                        html += "<div class=\"fw-im-message  text-center fw-im-othersender\" data-og-container=\"\">";
                        html += "<div class=\"centerblock\">";
                        html += moment(message.ios_date_time, moment.ISO_8601).calendar(null, momentOptions2);
                        html += "                <\/div>";
                        html += "                <\/div>";
                        lastMessageDate = messageDate;
                    }
                    if (message.type === "update") {
                        html += "<div id='message_" + message.m_id + "' class=\"fw-im-message  text-center fw-im-othersender update-message-font\" data-og-container=\"\">";
                        html += "<div class=\"centerblock\">";
                        html += "<i class='fa fa-tags'></i> " + message.message;
                        html += "                <\/div>";
                        html += "                <\/div>";
                    }
                    else {
                        if (parseInt(sender.userId) !== parseInt(userId)) {
                            html += "<div  class=\"fw-im-message fw-im-isnotme fw-im-othersender\" data-og-container=\"\" title=\"" + moment(message.ios_date_time, moment.ISO_8601).calendar(null, momentOptions) + "\">";
                            if (isUnicode(sender.firstName)) {
                                html += "<div class='fw-im-message-author-name font-Tahoma'>" + sender.firstName + "</div>";
                            } else {
                                html += "<div class='fw-im-message-author-name'>" + sender.firstName + "</div>";
                            }
                            if (message.type === "image") {
                                if (message.onlyemoji) {
                                    html += "                    <div id='message_" + message.m_id + "' class=\"fw-im-message-text\" style='background-color:transparent;'>" + parseMessage(message.message, true) + "<\/div>";
                                } else {
                                    html += "                    <div id='message_" + message.m_id + "' class=\"fw-im-message-text\">" + parseMessage(message.message, false) + "<\/div>";
                                }
                                if (message.linkData !== null) {
                                    html += getLinkPreview(JSON.parse(message.linkData), message.link);
                                }
                            }
                            if (message.type === "image") {
                                html += getImagePreview(message);
                            }
                            if (message.type === "video") {
                                html += "<div id='message_" + message.m_id + "' class=\"fw-im-attachments\" >";
                                html += "                        <video class='mediaVideo' id='video_" + message.m_id + "' poster='" + message.poster + "' width=\"100%\" height=\"\" controls=\"true\" preload='none' name=\"media\"><source src=\"" + message.message + "\" type=\"video\/mp4\"><\/video>";
                                html += "                    <\/div>";
                            }
                            if (message.type === "audio") {
                                html += "<div id='message_" + message.m_id + "' class=\"fw-im-attachments mediaAudio-player-wrapper\" >";
                                html += "                        <audio class='mediaAudio' id='audio_" + message.m_id + "' style='width:100%;height:100%;' width='100%' height='100%'  controls=\"true\" preload='none' name=\"media\"><source src=\"" + message.message + "\" type=\"audio\/mp3\"><\/audio>";
                                html += "                    <\/div>";
                            }
                            if (message.type === "document") {
                                //html += "<div id='message_" + message.m_id + "' class=\"fw-im-attachments\" >";
                                html += "                        <div class=\"fw-im-message-text\"><a target='_blank' id='document_" + message.m_id + "' href=" + message.message + " ><i class=\"fa fa-arrow-circle-down\"></i> " + message.fileName + "<\/a></div>";
                                //html += "                    <\/div>";
                            }
                            html += "                    <div class=\"fw-im-message-author\"  title=\"" + sender.firstName + " " + sender.lastName + "\">";
                            if (sender.active === 1) {
                                html += "                        <img class='auth_" + sender.userId + "'  src=\"" + sender.profilePictureUrl + "\" ><span class='authStatus memberActive'></span>";
                            } else {
                                html += "                        <img class='auth_" + sender.userId + " authStatus' src=\"" + sender.profilePictureUrl + "\" >";
                            }
                            html += "                    <\/div>";
                            html += "                <\/div>";
                        } else {


                            


                            html += "<div  class=\"fw-im-message  fw-im-isme fw-im-othersender\" data-og-container=\"\" title=\"" + moment(message.ios_date_time, moment.ISO_8601).calendar(null, momentOptions) + "\">";
                            if (message.type === "text") {
                                if (message.onlyemoji) {
                                    html += "                    <div id='message_" + message.m_id + "' class=\"fw-im-message-text\" style='background-color:transparent;'>" + parseMessage(message.message, true) + "<\/div>";
                                } else {
                                    html += "                    <div id='message_" + message.m_id + "' class=\"fw-im-message-text\">" + parseMessage(message.message, false) + "<\/div>";
                                }
                                if (message.linkData !== null) {
                                    html += getLinkPreview(JSON.parse(message.linkData), message.link);
                                }
                            }
                            if (message.type === "image") {
                                html += getImagePreview(message);
                            }
                            if (message.type === "video") {
                                html += "<div id='message_" + message.m_id + "' class=\"fw-im-attachments\" >";
                                html += "                        <video class='mediaVideo' class='mediaVideo' id='video_" + message.m_id + "' poster='" + message.poster + "' width=\"100%\" height=\"\" controls=\"true\" preload='none'  name=\"media\"><source src=\"" + message.message + "\" type=\"video\/mp4\"><\/video>";
                                html += "                    <\/div>";
                            }
                            if (message.type === "audio") {
                                html += "<div id='message_" + message.m_id + "' class=\"fw-im-attachments mediaAudio-player-wrapper\" >";
                                html += "                        <audio class='mediaAudio' id='audio_" + message.m_id + "' style='width:100%;height:100%;' width='100%' height='100%'  controls=\"true\" preload='none' name=\"media\"><source src=\"" + message.message + "\" type=\"audio\/mp3\"><\/audio>";
                                html += "                    <\/div>";
                            }
                            if (message.type === "document") {
                                //html += "<div id='message_" + message.m_id + "' class=\"fw-im-attachments\" >";
                                html += "                        <div class=\"fw-im-message-text\"><a target='_blank' id='document_" + message.m_id + "' href=" + message.message + " ><i class=\"fa fa-arrow-circle-down\"></i> " + message.fileName + "<\/a></div>";
                                //html += "                    <\/div>";
                            }
                            html += "                    <div class=\"fw-im-message-author\"  title=\"" + sender.firstName + " " + sender.lastName + "\">";
                            html += "                        <img src=\"" + sender.profilePictureUrl + "\" >";
                            html += "                    <\/div>";
                            if (seen) {
                                if (seen.time) {
                                    html += "                    <div class=\"fw-im-message-time seen  seenId_" + message.m_id + "\">";
                                    html += "                        <span class='seenMessage_" + message.m_id + "'>" + seen.seen + moment(seen.time, moment.ISO_8601).calendar(null, momentOptions2) + "<\/span>";
                                    html += "                    <\/div>";
                                } else {
                                    html += "                    <div class=\"fw-im-message-time seen  seenId_" + message.m_id + "\">";
                                    html += "                        <span class='seenMessage_" + message.m_id + "'>" + seen.seen + "<\/span>";
                                    html += "                    <\/div>";
                                }
                            } else {
                                html += "                    <div class=\"fw-im-message-time seen hidden seenId_" + message.m_id + "\">";
                                html += "                        <span class='seenMessage_" + message.m_id + "'><\/span>";
                                html += "                    <\/div>";
                            }
                            html += "                <\/div>";
                        }
                    }
                }
                if (presentTypingDiv) {
                    $(html).insertBefore(presentTypingDiv);
                } else {
                    chatBox.append(html);
                }
                for (let i = 0; i < messages.length; i++) {
                    message = messages[i].message;
                    let sender = messages[i].sender;
                    let isme = parseInt(sender.userId) !== parseInt(userId);
                    if (message.type == "video") {
                        initVideo("video_" + message.m_id, isme);
                    } else if (message.type == "audio") {
                        initAudio("audio_" + message.m_id, isme);
                    }
                }
                let lastMessage = messages[messages.length - 1].message;
                let lastMessageSender = messages[messages.length - 1].sender;
                if (lastMessage.type == "text") {
                    // console.log(lastmessage);
                    if (parseInt(lastMessageSender.userId) == parseInt(userId)) {
                        $('#messageType_' + activeGroupId).html("You: " + message.message);
                    } else {
                        $('#messageType_' + activeGroupId).html(sender.firstName + ": " + message.message);
                    }
                } else if (lastMessage.type !== "update") {
                    $('#messageType_' + activeGroupId).html(message.type);
                    //lightBox.init();
                }
                $('#time_' + activeGroupId).html(moment(lastMessage.ios_date_time, moment.ISO_8601).fromNow());
                time[activeGroupId] = lastMessage.ios_date_time;
                lightBox.init();
                let height = chatBox[0].scrollHeight;
                //chatBox.scrollTop(height);
                clampData();
            }
            //group section
            let groups = data.groups;
            for (let i = (groups.length - 1); i >= 0; i--) {
                groupObjects[groups[i].groupId] = groups[i];
                if (document.getElementById("group_" + groups[i].groupId)) {
                    $("#group_" + groups[i].groupId).remove();
                }
                addNewGroup(groups[i]);
                if (activeGroupId === parseInt(groups[i].groupId)) {
                    $(".person").removeClass("active");
                    $("#group_" + activeGroupId).addClass("active");
                    $(".UserNames").html(groups[i].groupName);
                    let meCreator = groups[i].meCreator;
                    printGroupMembers(groups[i].members, meCreator, groups[i].groupId);
                    groupImages[data.groupId] = groups[i].groupImage;
                    printGroupInfo(groups[i].groupId, groupImages, groups[i].groupName);
                }
            }
            if (messages.length !== 0 || groups.length !== 0) {
                $.playSound("<?php echo base_url('assets/img/nf'); ?>");
            }
            // removing not present groups
            let difference = data.removedGroupIds;
            for (let i = 0; i < difference.length; i++) {
                if (activeGroupId == difference[i]) {
                    $("#group_" + difference[i]).next("li").trigger("click");
                }
                $("#group_" + difference[i]).remove();
                delete groupObjects[difference[i]];
            }
            updateGroupsStatus();
        });
        socket.on("userTyping", function (data) {
            let typerGroupId = parseInt(data.groupId);
            if (parseInt(data.userId) !== parseInt(userId) && typerGroupId === activeGroupId) {
                let html = "";
                html += "<div id='group_" + data.groupId + data.userId + "' class=\"fw-im-message fw-im-isnotme fw-im-othersender\" data-og-container=\"\" title=\"" + moment(message.ios_date_time, moment.ISO_8601).calendar(null, momentOptions) + "\">";
                html += "                    <div  class=\"fw-im-message-text\" style='background-color: transparent;white-space: unset;'>";
                html+="<div class=\"fw-im-message-author-name\">"+data.userName+"</div>";
                html += "<div class=\"typing-indicator\">";
                html += "  <span><\/span>";
                html += "  <span><\/span>";
                html += "  <span><\/span>";
                html += "<\/div>";
                html += "<\/div>";
                html += "                    <div class=\"fw-im-message-author\" title=\"" + data.userName + "\">";
                html += "                        <img src=\"" + data.profilePicture + "\" title=\"" + data.userName + "\">";
                html += "                    <\/div>";
                html += "                <\/div>";
                chatBox.append(html);
                let height = chatBox[0].scrollHeight;
                //chatBox.scrollTop(height);
                presentTypingDiv = $("#group_" + data.groupId + data.userId);
                if (!mute) {
                    $.playSound("<?php echo base_url('assets/img/typing'); ?>");
                }
            }
        });
        socket.on("receiveSeen", function (data) {
            let m_id = data.forMessage;
            let seenMessage = data.seen;
            // console.log(data);
            $(".seenId_" + m_id).removeClass("hidden");
            if (seenMessage) {
                if (seenMessage.time && seenMessage.seen) {
                    $(".seenMessage_" + m_id).html(seenMessage.seen + moment(seenMessage.time, moment.ISO_8601).calendar(null, momentOptions2));
                    // console.log(seenMessage);
                } else if (seenMessage.seen) {
                    // console.log(seenMessage);
                    $(".seenMessage_" + m_id).html(seenMessage.seen);
                }
            }
            let elmnt = $(".seenMessage_" + m_id)[0];
            if (elmnt) {
                elmnt.scrollIntoView(false);
            }
        });
        socket.on("userNotTyping", function (data) {
            let typerGroupId = parseInt(data.groupId);
            let currentGroupId = activeGroupId;
            $("#group_" + data.groupId + data.userId).remove();
            if (presentTypingDiv && presentTypingDiv.is("#group_" + data.groupId + data.userId)) {
                presentTypingDiv = null;
            }
            let height = chatBox[0].scrollHeight;
            //chatBox.scrollTop(height);
        });
        socket.on("reconnect", function () {
            isDisconnected=false;
            socket.emit("register", JSON.stringify(tokenData));
            let groupId = activeGroupId;
            if (groupId != null || groupId != "") {
                socket.emit("joinRoom", parseInt(groupId));
            }
            // collecting all groupids preset in groupList left side
            let allDomGroups = $("#groups").find("li");
            let objectGroupIds = [];
            allDomGroups.each(function (i) {
                objectGroupIds.push(parseInt($(this).attr("data-group")));
            });
            let data = {
                _r: token,
                userId: userId,
                activeGroupId: activeGroupId, //current active group id
                //lastMessageId: LastMessageId, // current active group last massage id
                domGroups: objectGroupIds, // all fetched group ids from server
                sId: sessionId
            };
            if (sessionId == null) {
                setTimeout(function () {
                    data.sId = sessionId;
                    socket.emit("fetchOnReconnect", data);
                }, 3000);
            } else {
                socket.emit("fetchOnReconnect", data);
            }
            messageTyping=true;
            $('#connectionErrorModal').modal('hide');
        });
        socket.on("reconnecting", function () {
                $(".memberStatus").removeClass("memberActive");
                $(".authStatus").removeClass("memberActive");
                if(!isDisconnected){
                    disconnectModal();
                    isDisconnected=true;
                }
        });
        socket.on("updateGroupNameData", function (res) {
            let data = {
                "groupId": parseInt(res.groupId),
                "groupName": res.groupName
            };
            if (document.getElementById('group_' + data.groupId)) {
                // group is present and user is currently in this group
                if (activeGroupId === data.groupId) {
                    $("#groupName_" + data.groupId).html("<div>" + data.groupName + "</div>");
                    $('.be-use-name').html(data.groupName);
                    $(".UserNames").html(data.groupName);
                    $clamp($('.be-use-name')[0], {clamp: 2, useNativeClamp: false});
                }
                // group is present but user currently not chatting on this group
                else {
                    $("#groupName_" + data.groupId).html("<div>" + data.groupName + "</div>");
                }
            }
        });
        socket.on("addNewMember", function (res) {
            let data = {
                "groupId": parseInt(res.groupId),
                "group": res.groupInfo,
                "members": res.memberList
            };
            groupObjects[data.groupId] = data.group;
            let currentGroupId = parseInt(activeGroupId);
            // check group is present but user is not chatting on this group
            if (document.getElementById('group_' + data.groupId) && currentGroupId !== data.groupId) {
                createGroupImage(data.groupId);
                //$("#groupImage_" + data.groupId).html(html);
                $("#groupName_" + data.groupId).html("<div>" + data.group.groupName + "</div>");
            }
            // check group is present and user is currently chatting on this group
            else if (currentGroupId === data.groupId && document.getElementById('group_' + currentGroupId)) {
                createGroupImage(data.groupId);
               // $("#groupImage_" + data.groupId).html(html);
                $("#groupName_" + data.groupId).html("<div>" + data.group.groupName + "</div>");
                $(".UserNames").html(data.group.groupName);
                let meCreator = $("#group_" + data.groupId).attr("data-mecreator");
                printGroupMembers(data.members, meCreator, data.groupId);
                groupImages[data.groupId] = data.group.groupImage;
                printGroupInfo(data.groupId, groupImages, data.group.groupName);
            }
            // check group is not present
            else {
                addNewGroup(data.group);
            }
        });
        socket.on("deleteAMember", function (res) {
            let data = {
                "groupId": parseInt(res.groupId),
                "group": res.groupInfo,
                "members": res.memberList,
                "removeGroup": res.removeGroup
            };
            groupObjects[data.groupId] = data.group;
            let currentGroupId = parseInt(activeGroupId);
            // current user is the removed one
            if (data.removeGroup === true && document.getElementById('group_' + data.groupId)) {
                delete groupObjects[data.group];
                // group is present and user is currently on this group
                if (currentGroupId == data.groupId) {
                    $("#group_" + currentGroupId).remove();
                    let allDomGroups = $("#groups").find("li");
                    let domGroupIds = [];
                    allDomGroups.each(function (i) {
                        domGroupIds.push(parseInt($(this).attr("data-group")));
                    });
                    let noPendingGroupId = null;
                    for (let i = 0; i < domGroupIds.length; i++) {
                        if (groupObjects[domGroupIds[i]].pendingMessage <= 0) {
                            noPendingGroupId = domGroupIds[i];
                            let elmnt = document.getElementById("group_" + noPendingGroupId);
                            elmnt.scrollIntoView();
                            $("#group_" + noPendingGroupId).trigger("click", [{update: true}]);
                            break;
                        }
                    }
                }
                // group is present and user is not chatting on this group
                else {
                    $("#group_" + data.groupId).remove();
                }
            }
            // group is present and user is currently on this group
            else if (!data.removeGroup && document.getElementById('group_' + data.groupId) && currentGroupId === data.groupId) {
                createGroupImage(data.groupId);
                $("#groupName_" + data.groupId).html("<div>" + data.group.groupName + "</div>");
                $(".UserNames").html(data.group.groupName);
                let meCreator = $("#group_" + data.groupId).attr("data-mecreator");
                printGroupMembers(data.members, meCreator, data.groupId);
                groupImages[data.groupId] = data.group.groupImage;
                printGroupInfo(data.groupId, groupImages, data.group.groupName);
            }
            // group is present and user is not chatting on this group
            else if (document.getElementById('group_' + data.groupId)) {
                createGroupImage(data.groupId);
                $("#groupName_" + data.groupId).html("<div>" + data.group.groupName + "</div>");
            }
        });
        socket.on("pendingMessage", function (res) {
                
            let currentGroupId = parseInt(activeGroupId);
            let data = JSON.parse(res);
            let groupData = data.groupData;
            let senderId = parseInt(data.senderId);
            //if sender is not the current user
            if (senderId === parseInt(userId)) {
                if (document.getElementById('group_' + groupData.groupId)) {
                    $("#group_" + groupData.groupId).remove();
                }
                //if group is not present on grouplist or removed from grouplist then add the group on top
                addNewGroup(groupData);
                $('#group_' + groupData.groupId).trigger("click");
            }
            else if (senderId !== parseInt(userId)) {
                // if group present in list then remove the group
                if (document.getElementById('group_' + groupData.groupId)) {
                    $("#group_" + groupData.groupId).remove();
                }
                //if group is not present on grouplist or removed from grouplist then add the group on top
                addNewGroup(groupData);
                $('.person').removeClass('active');
                $('#group_' + currentGroupId).addClass('active');
                // if(parseInt(data.totalPending)!=0){
                if (!groupObjects[groupData.groupId].mute) {
                    $.playSound("<?php echo base_url('assets/img/nf'); ?>");
                    //toastr.info("New message received");
                    let NotifyMessage = "";
                    if (groupData.messageType === "text") {
                        NotifyMessage = groupData.recentMessage;
                    } else {
                        NotifyMessage = groupData.messageType;
                    }
                    notifyMe("New Message Received", NotifyMessage, groupData.groupImage);
                }
                //}
            }
            // if group is present in the group list on left
            else if (document.getElementById('group_' + groupData.groupId)) {
                $("#group_" + groupData.groupId).remove();
                addNewGroup(groupData);
                if (parseInt(groupData.groupId) === parseInt(activeGroupId)) {
                    $('.person').removeClass('active');
                    $('#group_' + groupData.groupId).addClass('active');
                    $("#groups").scrollTop(0);
                } else {
                    if ($("#group_" + groupData.groupId).hasClass("font-bold-black")) {
                        $("#group_" + groupData.groupId).removeClass("font-bold-black");
                    }
                }
                // }
                /* if(groupData.messageType==="text"){
                                $('#messageType_'+groupData.groupId).html(groupData.recentMessage);
                            }else{
                                $('#messageType_'+groupData.groupId).html(groupData.messageType);
                            }
                            $('#time_'+groupData.groupId).html(moment(groupData.lastActive,moment.ISO_8601).fromNow());
                            time[groupData.groupId]=groupData.lastActive;*/
            }
            // otherwise do nothimg
        });
        socket.on("updateStatus", function (res) {
            let data = res;
            if (parseInt(data.status) === 1) {
                if (!$("#member_" + data.userId).hasClass("memberActive")) {
                    $("#member_" + data.userId).addClass("memberActive");
                }
                if (!$(".auth_" + data.userId + ".authStatus").hasClass("memberActive")) {
                    $(".auth_" + data.userId + ".authStatus").addClass("memberActive");
                }
                if (!$(".group_member_" + data.userId).hasClass("memberActive")) {
                    $(".group_member_" + data.userId).addClass("memberActive");
                }
            } else {
                if ($("#member_" + data.userId).hasClass("memberActive")) {
                    $("#member_" + data.userId).removeClass("memberActive");
                }
                if ($(".auth_" + data.userId + ".authStatus").hasClass("memberActive")) {
                    $(".auth_" + data.userId + ".authStatus").removeClass("memberActive");
                }
                if ($(".group_member_" + data.userId).hasClass("memberActive")) {
                    $(".group_member_" + data.userId).removeClass("memberActive");
                }
            }
        });
        socket.on("updateStatusOnReconnect", function (res) {
            let data = res;
            for (let i = 0; i < data.friendsIds.length; i++) {
                if (!$("#member_" + data.friendsIds[i].userId).hasClass("memberActive")) {
                    $("#member_" + data.friendsIds[i].userId).addClass("memberActive");
                }
                if (!$(".auth_" + data.friendsIds[i].userId + ".authStatus").hasClass("memberActive")) {
                    $(".auth_" + data.friendsIds[i].userId + ".authStatus").addClass("memberActive");
                }
                if (!$(".group_member_" + data.userId).hasClass("memberActive")) {
                    $(".group_member_" + data.userId).addClass("memberActive");
                }
            }
        });
        socket.on("blockStatus", function (data) {
            if (activeGroupId === data.groupId) {
                if (data.block) {
                    if (parseInt(userId) === parseInt(data.userId)) {
                        if (!$("#block").hasClass("hidden")) {
                            $("#block").addClass("hidden");
                        }
                        if ($("#unblock").hasClass("hidden")) {
                            $("#unblock").removeClass("hidden");
                        }
                    }
                } else {
                    if (parseInt(userId) === parseInt(data.userId)) {
                        if ($("#block").hasClass("hidden")) {
                            $("#block").removeClass("hidden");
                        }
                        if (!$("#unblock").hasClass("hidden")) {
                            $("#unblock").addClass("hidden");
                        }
                    }
                }
                if (data.fullUnblock) {
                    if ($("#blockmessage").hasClass("hidden")) {
                        $("#blockmessage").removeClass("hidden");
                    }
                    $("#messageForm").hide();
                } else {
                    if (!$("#blockmessage").hasClass("hidden")) {
                        $("#blockmessage").addClass("hidden");
                    }
                    $("#messageForm").show();
                }
            }
            groupObjects[data.groupId] = data.blockGroup;
            block = data.block;
        });
        socket.on("errorMessage", function (data) {
            toastr.error(data);
        });
        socket.on("muteStatus", function (data) {
            if (activeGroupId === data.groupId && document.getElementById("group_" + data.groupId)) {
                if (!data.mute) {
                    if ($("#mute").hasClass("hidden")) {
                        $("#mute").removeClass("hidden");
                    }
                    if (!$("#unmute").hasClass("hidden")) {
                        $("#unmute").addClass("hidden");
                    }
                    if (!$("#mute_" + data.groupId).hasClass("hidden")) {
                        $("#mute_" + data.groupId).addClass("hidden");
                    }
                } else {
                    if (!$("#mute").hasClass("hidden")) {
                        $("#mute").addClass("hidden");
                    }
                    if ($("#unmute").hasClass("hidden")) {
                        $("#unmute").removeClass("hidden");
                    }
                    if ($("#mute_" + data.groupId).hasClass("hidden")) {
                        $("#mute_" + data.groupId).removeClass("hidden");
                    }
                }
            } else {
                if (document.getElementById("group_" + data.groupId)) {
                    if (!data.mute) {
                        if (!$("#mute_" + data.groupId).hasClass("hidden")) {
                            $("#mute_" + data.groupId).addClass("hidden");
                        }
                    } else {
                        if ($("#mute_" + data.groupId).hasClass("hidden")) {
                            $("#mute_" + data.groupId).removeClass("hidden");
                        }
                    }
                }
            }
            groupObjects[data.groupId].mute = data.mute;
            mute = data.mute;
            updateGroupsStatus();
        });
        socket.on("addNewGroup", function (group) {
            $("#group_" + group.groupId).remove();
            $('.person').removeClass('active');
            addNewGroup(group);
            if (parseInt(activeGroupId) !== parseInt(group.groupId)) {
                $('#group_' + group.groupId).trigger("click", [{update: true}]);
            }
            $('#group_' + group.groupId).addClass('active');
        });
        socket.on("updateGroupImage",function (data){

//            console.log('update image');
 //           console.log(data);

            groupObjects[data.g_id].groupImage=data.imageData;
            createGroupImage(data.g_id);
            $('.imgselecteds img').remove();
            $('.imgselecteds').append('<img src="'+  data.imageData[0] +'" class="imgst" draggable="false">');
            $('#groupImage_'+ activeGroupId +' .img-circle').attr('src', data.imageData[0]);
            if(parseInt(data.g_id)=== parseInt(activeGroupId)){
                let html = "<img class=\"img-responsive img-circle\" style=\"width: 50px; height: 50px;border-radius: 50%\" src=\"" + groupObjects[data.g_id].groupImage[0] + "\" >";
                $('.rightGroupImages').html(html);
            }
        });

        socket.on("notifyMentionUser", function (data) {
           toastr.info(`${data.fromname} has mentioned you.`);
           pingNotificationButton();
        });

        socket.on("notifyUser", function (data) {
           toastr.info(`${data.fromname} ${data.notdesc} ${data.group_name}`);
           pingNotificationButton();
        });

        function pingNotificationButton(){
            if($('#modalNotifications').is(':visible')){
                $('#btnNotifications').addClass('hasNotifications');
                setTimeout(function(){
                    $('#btnNotifications').removeClass('hasNotifications');
                },1500)
                // request
                getNotification(0);
           }else{   
                $('#btnNotifications').addClass('hasNotifications');
           }
        }
        
        getTotalNotification(function(count){
            if(parseInt(count)>0){
                pingNotificationButton();
            }
        });
        //$('#connectionErrorModal').show();
        // console.log('test')
        // console.log(window.Vyndue_fname);
        // console.log(window);

        socket.on("promptWarning", function (message) {
           toastr.warning(message);
        });

//------------------ End of web socket section -------------------------
        setInterval(updateTime, 60000);
        setInterval(disconnectModal,9999);
        let AllInputTag = $('input[type=text]');
        AllInputTag.keyup(function (e) {
            if (isUnicode($(this).val())) {
                $(this).css('direction', 'rtl');
            }
            else {
                $(this).css('direction', 'ltr');
            }
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.searchGroupInput').prepend('<i class="fas fa-search"></i>');

        $('#nav-icon1').click(function(){
            $(this).toggleClass('open');
            var rhidesection = $('.rightSection').hasClass('hideshowme');
            var sidebtn = $('#nav-icon1').hasClass('open')
            if (rhidesection) {
                $('.rightSection').hide().addClass('hideshowme');
            } else {
                $('.rightSection').show().removeClass('hideshowme');
            }
            if(sidebtn){
                $(".kosaks").css("width","80%");
            } else {
                $(".kosaks").css("width","86%");
            }
        });
        $('#nav-icon1').click(function(){
            $('.middleSection').toggleClass('tosix');
        });

        $('.attachment').hide();
        $('#nav-icon3').click(function(){
            $(this).toggleClass('open');
            $('.attachment').toggle('hideshowme');
        });
        $('#ImageAttachmentList').hide();
        $('#nav-icon3-c').click(function(){
            $(this).toggleClass('open');
            $('#ImageAttachmentList').toggle('lllx');
        });
    });
</script>
</body>
</html>