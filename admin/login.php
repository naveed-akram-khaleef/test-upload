<?php
ob_start();
include("../lib/openCon.php");
include("../lib/functions.php");
include("includes/php_includes_top.php");
session_start();
$msg_class='';
$strMSG = "";
$FormHead = "";
if (isset($_REQUEST['btnLogin'])){
	$nRes=checkAdminLogin($_REQUEST['txtuname'],md5($_REQUEST['txtpass']));
	switch ($nRes) {
		case 0:
			$msg_class='msg_box msg_error';
			$strMSG="Invalid Login / Password";
			break;
		case 1:
			// Creating Session
			$strQry="SELECT * FROM user WHERE user_name='".$_REQUEST['txtuname']."' AND user_password='".md5($_REQUEST['txtpass'])."'";
			$nResult=mysql_query($strQry);
			if (mysql_num_rows($nResult)>=1){
				$row=mysql_fetch_object($nResult);
				$SessionID = session_id();

				$_SESSION["UID"] = $row->user_id;
				$_SESSION["UserName"] = $row->user_name;
				$_SESSION["UType"] = $row->utype_id;
				
				if($row->utype_id == 4){
					$_SESSION["ClientID"] = $row->clt_id;
				}
			else{
					$_SESSION["ClientID"] = 0;
				}
				header("Location: manage_content.php");
				break;
			}
	}
}
ob_end_flush();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title> Admin Login </title>
	<link rel="stylesheet" type="text/css" href="css/style.css" media="all" />
	<script type="text/javascript" src="js/head.load.min.js"></script>
</head>
<body class="bg_c">

	<div class="login_wrapper">
		<div class="loginBox">
			<div class="heading cf">
<!--				<ul class="login_tabs fr cf">
					<li><a href="#login">Login</a></li>
					<li><a href="#register">Register</a></li>
					<li style="display:none"><a href="#password">Forgoten password</a></li>
				</ul>-->
				<img src="images/logo.png" alt="" class="fl"/>
			</div>
			<div class="content">
				<div class="login_panes formEl_a">
					<div>
						<?php if($msg_class != ''){?>
                            <div class="<?php echo $msg_class;?>"><?php echo $strMSG;?><img src="images/blank.gif" class="msg_close" alt="" /></div>
                        <?php }?>

						<form name="frmlogin" method="post" action="<?php print($_SERVER['PHP_SELF']);?>">
							<div class="msg_box msg_error" id="allErrors" style="display:none"></div>
							<div class="sepH_a">
								<label for="lusername" class="lbl_a">Username:</label>
								<input type="text" id="lusername" name="txtuname"  class="inpt_a" />
							</div>
							<div class="sepH_b">
								<label for="lpassword" class="lbl_a">Password:</label>
								<input type="password" id="lpassword" name="txtpass"  class="inpt_a" />
							</div>
<!--							<div class="sepH_b">
								<input type="checkbox" class="inpt_c" id="remember" />
								<label for="remember" class="lbl_c">Remember me</label>
							</div>
-->							<input type="submit" name="btnLogin" value="Login" class="submitButton">
						</form>
					<!--	<div class="content_btm">
							<a href="#" class="small">Forgot your username or password?</a>
						</div>-->
					</div>
<!--					<div>
						<div class="msg_box msg_error">You must enter E-mail adress.</div>
						<p class="sepH_b">You just need to enter a username and your e-mail adress. Password will be e-mailed to You.</p>
						<form action="" method="post" class="formEl sepH_c">
							<div class="sepH_a">
								<label for="rusername" class="lbl_a">Username:</label>
								<input type="text" id="rusername" class="inpt_a" />
							</div>
							<div class="sepH_b error">
								<label for="remail" class="lbl_a">E-mail:</label>
								<input type="text" id="remail" class="inpt_a" />
							</div>
							<button class="btn_a btn">Register</button>
						</form>
					</div>-->
<!--					<div>
						<p class="sepH_b">Please enter your username or email address. You will receive a link to create a new password via email.</p>
						<form action="" method="post" class="formEl sepH_c">
							<div class="sepH_b">
								<label for="user_email" class="lbl_a">Username or E-mail:</label>
								<input type="text" id="user_email" name="user_email" class="inpt_a" />
							</div>
							<button class="btn_a btn">Get new password</button>
						</form>
					</div>-->

				</div>
			</div>
		</div>
	</div>

    <style>
        .submitButton{
            background-color: #FFFFFF;
            color: #000000;
            text-shadow:#FFF;
            
            border: 1px solid #A2A2A2;
            border-radius: 4px 4px 4px 4px;
            font-family: Arial,Helvetica,sans-serif;
            font-size: 11px;
            font-weight: bold;
            padding-left: 5px;
            padding-right: 5px;
            padding-top: 4px;
            padding-bottom: 4px;
            margin-left:2px;
            margin-bottom:20px;
            text-transform:uppercase;
        }				
        .submitButton:hover{
            background-color: #E3E3E3;
            color: #000000;
            text-shadow:#FFF;
        }				
    </style>

	<script type="text/javascript">
		head.js(
			"js/jquery-1.6.2.min.js",
			"js/jquery.tools.min.js",
			"lib/jquery-validation/jquery.validate.js",
			"js/login.js",
			function(){
				lga_loginTabs.init();
				lga_formFocus.init();
				lga_validation.init();
			}
		)
	</script>

</body>
</html>