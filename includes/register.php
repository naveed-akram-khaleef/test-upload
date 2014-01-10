<?php
	if(isset($_SESSION["memID"])){
		$nResult = mysql_query("SELECT * FROM members WHERE mem_id=".$_SESSION["memID"]);
		if(mysql_num_rows($nResult)>0){
			$row = mysql_fetch_object($nResult);
			$mem_fname = $row->mem_fname;
			$mem_lname = $row->mem_lname;
			$mem_email = $row->mem_email;
			$mem_login = $row->mem_login;
			$mem_phone = $row->mem_phone;
			$mem_address = $row->mem_address;
			$mem_city = $row->mem_city;
			$mem_state = $row->mem_state;
			$mem_zcode = $row->mem_zcode;
			$addNew = 0;
			$btnValue = "Update";
		}
	} else {
		$mem_fname = "";
		$mem_lname = "";
		$mem_email = "";
		$mem_login = "";
		$mem_phone = "";
		$mem_address = "";
		$mem_city = "";
		$mem_state = "";
		$mem_zcode = "";
		$addNew = 1;
		$btnValue = "Register Now";
	}
?>
<script>
	$(document).ready(function(){
		$("#signupForm").validate({
			submitHandler: function(form) {
				var url = "<?php print($siteRoot)?>site_services.php";
				$.ajax({
				   type: "POST",
				   url: url,
				   data: $("#signupForm").serialize(),
				   success: function(data){
						var receivedData = data.split(',');
						if(receivedData[0]==1){
							$("#msg").html(receivedData[1]);
							$("#msg_div").attr('style','display:block; visibility:visible;');
							$("#msg_div").show();
							$("#signupFormDiv").hide();
							setTimeout(function() {
								window.location.href = "index.php?id=4";
							}, 2000);
						}else if(receivedData[0]==3){
							$("#msg").html(receivedData[1]);
							$("#msg_div").attr('style','display:block; visibility:visible;');
							$("#msg_div").show();
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
<div id="signupFormDiv" class="register">
	<div class="form_area">
        <form method="post" id="signupForm">
            <ul class="form">
							<?php if(!isset($_SESSION["memID"])){?>
                  <li>
                      <div class="label">Phone No:</div><div class="triangle"></div>
                      <input type="text" class="input required" name="mem_login" />
                  </li>
<!--                  <li>
                      <div class="label">Password:</div><div class="triangle"></div>
                      <input id="password" type="password" class="input required" name="mem_password" />
                  </li>
-->                <?php } ?>
                <li>
                    <div class="label">First Name:</div><div class="triangle"></div>
                    <input type="text" class="input required" name="mem_fname" value="<?php print($mem_fname);?>" />
                </li>
                <li>
                    <div class="label">Last Name:</div><div class="triangle"></div>
                    <input type="text" class="input required" name="mem_lname" value="<?php print($mem_lname);?>" />
                </li>
                <li>
                    <div class="label">Email:</div><div class="triangle"></div>
                    <input type="text" class="input required" name="mem_email" value="<?php print($mem_email);?>" />
                </li>
                <li>
                    <div class="label">Phone:</div><div class="triangle"></div>
                    <input type="text" class="input" name="mem_phone" value="<?php print($mem_phone);?>" />
                </li>
                <li>
                    <div class="label">Address:</div><div class="triangle"></div>
                    <input type="text" class="input" name="mem_address" value="<?php print($mem_address);?>" />
                </li>
                <li>
                    <div class="label">City:</div><div class="triangle"></div>
                    <input type="text" class="input" name="mem_city" value="<?php print($mem_city);?>" />
                </li>
                <li>
                    <div class="label">State:</div><div class="triangle"></div>
                    <input type="text" class="input" name="mem_state" value="<?php print($mem_state);?>" />
                </li>
                <li>
                    <div class="label">Zip Code:</div><div class="triangle"></div>
                    <input type="text" class="input" name="mem_zcode" value="<?php print($mem_zcode);?>" />
                </li>
                <li class="button">
                    <input type="hidden" value="<?php print($addNew);?>" name="addNew" />
                    <input type="submit" value="<?php print($btnValue);?>" name="signupForm" class="btn" />
                </li>                              
            </ul>
        </form>
    </div>    
</div>
