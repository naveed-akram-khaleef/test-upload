<h1><?php print($strHead);?></h1>
<script>
	$(document).ready(function(){
		$("#contactForm").validate({
			submitHandler: function(form) {
				var url = "<?php print($siteRoot)?>site_services.php";
				$.ajax({
				   type: "POST",
				   url: url,
				   data: $("#contactForm").serialize(),
				   success: function(data){
						var receivedData = data.split(',');
						if(receivedData[0]==1){
							$("#msg").html(receivedData[1]);
							$("#msg_div").attr('style','display:block; visibility:visible;');
							$("#msg_div").show();
							$("#signupFormDiv").hide();
							setTimeout(function() {
								window.location.href = "index.php?id=1";
							}, 2000);
						}
				   }
				});
			return false;
			}
		});
	});
</script>
<div id="msg_div" style="display:none;">
    <div class="alert">
        <div class="close">x</div>
        <div class="alert_inner" align="center">
            <p id="msg"></p>
        </div>
    </div>                        
</div>
<div id="contactFormDiv" class="contact">
	<div class="form_area">
        <form method="post" id="contactForm">
            <ul class="form">
                <li>
                    <div class="label"><?php echo Name;?>:</div><div class="triangle"></div>
                    <input type="text" class="input required" name="cu_name" />
                </li>
                <li>
                    <div class="label"><?php echo Email;?>:</div><div class="triangle"></div>
                    <input type="text" class="input required email" name="cu_email" />
                </li>
                <li>
                    <div class="label"><?php echo Phone;?>:</div><div class="triangle"></div>
                    <input type="text" class="input required" name="cu_phone" />
                </li>
                <li>
                    <div class="label"><?php echo Message;?>:</div><div class="triangle"></div>
                    <input type="text" class="input" name="cu_comment" />
                </li>
                <li class="button">
                    <input type="submit" value="<?php echo Submit;?>" name="contactForm" class="btn" />
                </li>                              
            </ul>
        </form>
    </div>
    <div class="clearfix"></div>  
</div>
