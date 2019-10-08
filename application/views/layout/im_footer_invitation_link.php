
<div id="message">
    
    <h1>Redirecting...</h1>
    <p>will be redirect to validate your invitation token.</p>
    
</div>

</body>
</html>
<style>
    #message{
        width: 300px;
        height: 300px;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
    }
</style>
<script src="<?php echo base_url('assets/newTheme/assets/js/vendors/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/newTheme/assets/js/vendors/vendors.js'); ?>"></script>
<script src="<?php echo base_url('assets/newTheme/assets/js/custom.js'); ?>"></script>
<script>
    $(document).ready(function () {
              
            var token = location.search.split('token=')[1];
            if(token.length){
                //console.log(token);
                location.href="<?=MAIN_URL?>/userview/im?token=" + token;
            }
           
    });
</script>
