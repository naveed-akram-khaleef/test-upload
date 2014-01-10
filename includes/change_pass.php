<script>
	$(document).ready(function(){
		$("#changepassForm").validate({
			submitHandler: function(form) {
				var url = "<?php print($siteRoot)?>site_services.php";
				$.ajax({
				   type: "POST",
				   url: url,
				   data: $("#changepassForm").serialize(),
				   success: function(data){
						var receivedData = data.split(',');
						if(receivedData[0]==1){
							$("#msg").html(receivedData[1]);
							$("#msg_div").attr('style','display:block; visibility:visible;');
							$("#msg_div").show();
							$("#signupFormDiv").hide();
							setTimeout(function() {
								//window.location.href = "index.php?id=4";
							}, 2000);
						} else {
							$("#msg").html(receivedData[1]);
							$("#msg_div").attr('style','display:block; visibility:visible;');
							$("#msg_div").show();
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
<div id="changepassFormDiv" class="register">
	<div class="form_area">
        <form method="post" id="changepassForm">
            <ul class="form">
                <li>
                    <div class="label">Old Password:</div><div class="triangle"></div>
                    <input type="text" class="input required" name="mem_password_o" />
                </li>
                <li>
                    <div class="label">New Password:</div><div class="triangle"></div>
                    <input id="ps" type="text" class="input required" name="mem_password_n" />
                </li>
                <li>
                    <div class="label">Confirm New Password:</div><div class="triangle"></div>
                    <input type="text" class="input required" equalTo='#ps'/>
                </li>
                <li class="button">
                    <input type="submit" value="Update" name="changepassForm" class="btn" />
                </li>
            </ul>
        </form>
    </div>    
</div>