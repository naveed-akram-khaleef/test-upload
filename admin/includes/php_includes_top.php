<?php
	$pageName = basename($_SERVER["PHP_SELF"]);
	$posName = strpos($pageName, '.php');
	$pageName = (substr($pageName, 0, $posName));
	$show_image = "<img class='tick tick_a' alt='' src='images/blank.gif' />";

	if(isset($_REQUEST['lang_id'])&&($_REQUEST['lang_id'])!=''){
		$_SESSION['lang_id'] = $_REQUEST['lang_id'];
	}
	if(!isset($_SESSION['lang_id'])){
		$_SESSION['lang_id'] = 1;
	}
	$rtl = (($_SESSION['lang_id']>=2)?"style='direction:rtl;'":'');
?>
