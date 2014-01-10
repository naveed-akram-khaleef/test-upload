<?php
if(isset($_SESSION["memID"])){
	//if(isset($_REQUEST['edit'])){
		$nResult = mysql_query("SELECT * FROM members WHERE mem_id=".$_SESSION["memID"]);
		if(mysql_num_rows($nResult)>0){
			$row = mysql_fetch_object($nResult);
			$mem_fname = $row->mem_fname;
			$mem_lname = $row->mem_lname;
			$mem_company_name = $row->mem_company_name;
			$mem_email = $row->mem_email;
			$mem_phone = $row->mem_phone;
			$mem_address = $row->mem_address;
			$mem_city = $row->mem_city;
			$state_id = $row->state_id;
			$mem_zcode = $row->mem_zcode;
			$mem_ssn = $row->mem_ssn;
			$mem_fax = $row->mem_fax;
			$mem_details = $row->mem_details;
			$mem_logo = $row->mem_logo;
			$mem_gmail = $row->mem_gmail;
			$mem_gm_pass = $row->mem_gm_pass;
			$addNew = 0;
			$btnValue = "Update";
		}
	//}
}
else{
	$mem_fname = "";
	$mem_lname = "";
	$mem_company_name = "";
	$mem_email = "";
	$mem_phone = "";
	$mem_address = "";
	$mem_city = "";
	$state_id = 0;
	$mem_zcode = "";
	$mem_ssn = "";
	$mem_fax = "";
	$mem_details = "";
	$mem_logo = "";
	$mem_gmail = "";
	$mem_gm_pass = "";
	$addNew = 1;
	$btnValue = "Register Now";
}
?>
<!-- Form Validation Jquery -->
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
						//alert( data );
						var receivedData = data.split(',');
						if(receivedData[0]==1){
							$("#msg").html(receivedData[1]);
							$("#msg_div").attr('style','display:block; visibility:visible;');
							$("#msg_div").show();
							$("#signupFormDiv").hide();
							setTimeout(function() {
								window.location.href = "index.php?id=14";
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
	<form method="post" id="signupForm">
		<ul class="form">
	<?php if(!isset($_SESSION["memID"])){?>
			<li>
				<ul class="left">
					<li>Username:</li>
					<li><input type="text" class="input required" name="mem_login" /></li>
				</ul>
				<ul class="right">
					<li>Password:</li>
					<li><input id="password" type="password" class="input required" name="mem_password" /></li>
				</ul>
				<div class="clearfix"></div>
			</li>
	<?php } ?>
			<li>
				<ul class="left">
					<li>First Name:</li>
					<li><input type="text" class="input required" name="mem_fname" value="<?php print($mem_fname);?>" /></li>
				</ul>
				<ul class="right">
					<li>Last Name:</li>
					<li><input type="text" class="input required" name="mem_lname" value="<?php print($mem_lname);?>" /></li>
				</ul>
				<div class="clearfix"></div>
			</li>
			<li>
				<ul class="left">
					<li>Company Name:</li>
					<li><input type="text" class="input required" name="mem_company_name" value="<?php print($mem_company_name);?>" /></li>
				</ul>
				<ul class="right">
					<li>Email:</li>
					<li><input type="text" class="input required email" name="mem_email" value="<?php print($mem_email);?>" /></li>
				</ul>
				<div class="clearfix"></div>
			</li>
			<li>
				<ul class="left">
					<li>Address:</li>
					<li><input type="text" class="input required" name="mem_address" value="<?php print($mem_address);?>" /></li>
				</ul>
				<ul class="right">
					<li>City:</li>
					<li><input type="text" class="input required" name="mem_city" value="<?php print($mem_city);?>" /></li>
				</ul>
				<div class="clearfix"></div>
			</li>
			<li>
				<ul class="left">
					<li>State:</li>
					<li>
						<select name="state_id" id="state_id" class="cb" >
                            <?php FillSelected("states", "state_id", "state_name", $state_id); ?>
                        </select>
					</li>
				</ul>
				<ul class="right">
					<li>Zip Code:</li>
					<li><input type="text" class="input" name="mem_zcode" value="<?php print($mem_zcode);?>" /></li>
				</ul>
			</li>
			<li>
				<ul class="left">
					<li>Phone No:</li>
					<li><input type="text" class="input required" name="mem_phone" value="<?php print($mem_phone);?>" /></li>
				</ul>
				<ul class="right">
					<li>Fax No:</li>
					<li><input type="text" class="input" name="mem_fax" value="<?php print($mem_fax);?>" /></li>
				</ul>
				<div class="clearfix"></div>
			</li>
			<li>
				<ul class="left">
					<li>TAX ID / Social Security Number:</li>
					<li><input type="text" class="input  required" name="mem_ssn" value="<?php print($mem_ssn);?>" /></li>
				</ul>
				<ul class="right">
					<li>Details:</li>
					<li><textarea class="ta required" cols="52" style="height:88px;" name="mem_details"><?php echo @$mem_details;?></textarea></li>
				</ul>
				<ul class="left">
					<li>Logo:</li>
					<li><input type="file" name="mFile" class="input" /></li>
				</ul>
				<div class="clearfix"></div>
			</li>
			<li style="margin-top:22px;"><h3>Google Calendar Info</h3></li>
			<div class="clearfix"></div>
			<li>
				<ul class="left">
					<li>Gmail Account:</li>
					<li><input type="text" class="input" name="mem_gmail" value="<?php print($mem_gmail);?>" /></li>
				</ul>
				<ul class="right">
					<li>Gmail Password:</li>
					<li><input type="text" class="input" name="mem_gm_pass" value="<?php print($mem_gm_pass);?>" /></li>
				</ul>
				<div class="clearfix"></div>
			</li>
			<div class="clearfix"></div>
			<li>
				<input type="hidden" name="mem_logo" value="<?php print($mem_logo);?>" />
				<input type="hidden" name="addNew" value="<?php print($addNew);?>" />
				<input type="submit" value="<?php print($btnValue);?>" name="signupForm" class="btn" />
			</li>                              
		</ul>
	</form>
</div>