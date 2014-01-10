<?php
session_start();
$str = '
<style>
.alert{width:100%; background-color:#F2DEDE; border-radius:6px; position:relative; margin-bottom:16px;}
.alert_inner{padding:15px;}
.alert .close{position:absolute; top:5px; right:15px; color:#C1B1B1; z-index:10; text-shadow:1px 1px 1px rgba(255,255,255,0.65);}
.alert .close:hover{cursor:pointer; color:#000000;}
.alert h1{font-size:20px; color:#B94A48; margin:0px; padding:0px; margin-bottom:5px;}
.alert p{margin:0px; padding:0px; color:#B94A48; font-size:13px;}
label { width: 10em; float: left; }
label.error { float: none; color: red; padding-left: .5em; vertical-align: top; }
</style>
<script>
	$(document).ready(function(){
		$("#loginForm").validate({
			submitHandler: function(form) {
				var url = "site_services.php";
				$.ajax({
					type: "POST",
					url: url,
					data: $("#loginForm").serialize(),
					success: function(data){
					var receivedData = data.split(",");
						if(receivedData[0]==1){
							$("#msg").html(receivedData[1]);
							$("#msg_div").attr("style"," display:block; visibility:visible; margin-left:58%; ");
							$("#msg_div").show();
							$("#loginFormDiv").hide();
							setTimeout(function() {
								window.location.href = "'.$_REQUEST['url'].'";
							}, 2000);
						} else {
							$("#msg").html(receivedData[1]);
							$("#msg_div").attr("style"," display:block; visibility:visible; margin-left:58%; ");
							$("#loginFormDiv").show();
						}
					}
				});
				return false;
			}
		});
	});
</script>
<div id="loginFormDiv" class="register">
		<form method="post" id="loginForm">
			<ul>
				<li class="">
					<input type="text" placeholder="'.$_SESSION['Enter_Number'].'" class=" input required number " name="mem_login" style="width:165px;" />
					<input type="submit" class="btn" name="loginForm" value="'.$_SESSION['Login'].'" onclick="javascript: chkSubscriber();" />
				</li>
			</ul>
		</form>
</div>
<div id="msg_div" style=" display:none; margin-left:58%; ">
	<div class="alert">
		<div class="alert_inner" align="center">
			<p id="msg"></p>
		</div>
	</div>                        
</div>';
echo $str;
?>