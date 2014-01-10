<?php

$QryConfig = "SELECT * FROM site_config WHERE config_id = 1";
$RsConfig = mysql_query($QryConfig);
if (mysql_num_rows($RsConfig)>=1){
	$rowConfig=mysql_fetch_object($RsConfig);
	define("SITE_NAME", $rowConfig->config_sitename);
	define("SITE_TITLE", $rowConfig->config_sitetitle);
	define("SITE_META_KEYWORDS", $rowConfig->config_metakey);
	define("SITE_META_DESCRIPTION", $rowConfig->config_metades);
}
else{
	define("SITE_NAME", "Membership");
	define("SITE_TITLE", "Membership");
	define("SITE_META_KEYWORDS", "Membership");
	define("SITE_META_DESCRIPTION", "Membership");
}

if($rowConfig->status_id == 0){
	include("not_available.php");
	die();
}

$_SESSION['sessID'] = session_id();
?>