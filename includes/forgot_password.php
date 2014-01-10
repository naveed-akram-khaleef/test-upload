<script>
		$(document).ready(function(){
				$("#forgotForm").validate({
						submitHandler: function(form) {
								var url = "<?php print($siteRoot)?>site_services.php";
								$.ajax({
									 type: "POST",
									 url: url,
									 data: $("#forgotForm").serialize(),
									 success: function(data){
					 //alert(data);
					var receivedData = data.split(',');
					if(receivedData[0]==1){
						$("#msg").html(receivedData[1]);
						$("#msg_div").attr('style','display:block; visibility:visible;');
						$("#msg_div").show();
						$("#forgotFormDiv").hide();
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
<div id="forgotFormDiv" class="contact login">
    <div class="form_area">
        <form method="post" id="forgotForm">
            <ul>
                <li>
                    <div class="label">Email Address:</div><div class="triangle"></div>
                    <input type="text" class="input required email" name="mem_login" />
                </li>
                <li class="button">
                    <input type="submit" class="btn" name="forgotForm" value="Submit" />
                </li>
            </ul>
        </form>    
    </div>
</div>