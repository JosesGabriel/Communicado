<script src="<?php echo base_url("assets/newTheme/assets/js/vendors/jquery.min.js") ?>"></script>
<script src="<?php echo base_url("assets/newTheme/assets/js/vendors/vendors.js") ?>"></script>
<!-- Local Revolution tools-->
<!-- Only for local and can be removed on server-->

<script src="<?php echo base_url("assets/newTheme/assets/js/custom.js") ?>"></script>

<script src="<?php echo base_url("assets/newTheme/assets/js/jquery.playSound.js") ?>"></script>
<script src="<?php echo base_url("assets/newTheme/assets/js/toastr.min.js") ?>"></script>
<script src="<?php echo base_url("assets/newTheme/assets/js/anchorme.min.js") ?>"></script>

<script src="<?php echo base_url("assets/newTheme/assets/js/magicsuggest.js") ?>"></script>
<script src="<?php echo base_url("assets/newTheme/assets/js/moment.min.js") ?>"></script>

<script src="<?php echo base_url("assets/newTheme/assets/js/socket.io.js") ?>"></script>


<script src="<?php echo base_url("assets/js/scripts/jwt-decode.min.js") ?>"></script>

<script src="<?php echo base_url("assets/newTheme/assets/js/clamp.min.js") ?>"></script>


<script>
    var baseUrl="<?php echo base_url() ?>";
    function isUnicode(str) {
        let textareavalue = str; //Getting input value
        let arabic = /[\u0600-\u06FF]/g; //setting arabic unicode
        let hebrew = /[\u0590-\u05FF]/g;
        let match = textareavalue.match(arabic) || textareavalue.match(hebrew);
        let spacesMatch = textareavalue.match(new RegExp(" ", 'g'));
        let allcount = textareavalue.length;
        let farsicount = match ? match.length : 0;
        let spacesCount = spacesMatch ? spacesMatch.length : 0;
        let Englishcount = allcount - farsicount - spacesCount;

        return farsicount > Englishcount;
    }
    (function ($) {
        $.fn.serializeFormJSON = function () {

            let o = {};
            let a = this.serializeArray();
            $.each(a, function () {
                if (o[this.name]) {
                    if (!o[this.name].push) {
                        o[this.name] = [o[this.name]];
                    }
                    o[this.name].push(this.value || '');
                } else {
                    o[this.name] = this.value || '';
                }
            });
            return o;
        };
    })(jQuery);
</script>



<script>
    let $buoop = {
        notify:{e:-1,f:-1,o:-1,s:-1,c:-1},
        insecure:true,
        api:5,
        text:"Your browser, {brow_name}, is too old for Vyndue: <a{up_but}>update</a>.",
        style: "top",
        container: document.body,
        jsshowurl: "//browser-update.org/update.show.min.js",
        l: false,
    };
    function $buo_f(){
        let e = document.createElement("script");
        e.src = "//browser-update.org/update.min.js";
        document.body.appendChild(e);
    };
    try {document.addEventListener("DOMContentLoaded", $buo_f,false)}
    catch(e){window.attachEvent("onload", $buo_f)}
</script>
