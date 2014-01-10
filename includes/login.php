<script>
	$(document).ready(function(){
		$("#loginForm").validate({
			submitHandler: function(form) {
				var url = "<?php print($siteRoot)?>site_services.php";
				$.ajax({
					type: "POST",
					url: url,
					data: $("#loginForm").serialize(),
					success: function(data){
					var receivedData = data.split(',');
						if(receivedData[0]==1){
							$("#msg").html(receivedData[1]);
							$("#msg_div").attr('style','display:block; visibility:visible;');
							$("#msg_div").show();
							$("#loginFormDiv").hide();
							setTimeout(function() {
								window.location.href = "index.php?id=1";
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
<div id="loginFormDiv" class="contact login">
    <div class="form_area">
        <form method="post" id="loginForm">
            <ul>
                <li>
                    <div class="label">Phone No:</div><div class="triangle"></div>
                    <input type="text" class="input required" name="mem_login" />
                </li>
                <!--<li>
                    <div class="label">Password:</div><div class="triangle"></div>
                    <input type="password" class="input required" name="mem_password" />
                </li>-->
                <li class="button">
                    <input type="submit" id="loginForm" class="btn" name="loginForm" value="Login" />
                </li>
                <!--<li>
                    <div><a href="index.php?id=14">Forgot Password</a></div>
                </li>-->
            </ul>
        </form>    
    </div>
</div>