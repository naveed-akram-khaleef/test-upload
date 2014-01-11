<?php
$SITE_TITLE = "Wap Portal";
$SITE_META_KEYWORDS = "audio, videos, ringtones, wallpapers";
$SITE_META_DESCRIPTION = "audio, videos, ringtones, wallpapers";
if(isset($_REQUEST['pr'])){
	$QryConfig = "SELECT prl.pr_title, prl.pr_meta_keyword, prl.pr_meta_description FROM products_ln AS prl WHERE prl.pr_id=".$_REQUEST['pr']." ";
	$RsConfig = mysql_query($QryConfig) or die(mysql_error());
	if (mysql_num_rows($RsConfig)>=1){
		$rowConfig=mysql_fetch_object($RsConfig);
		$SITE_TITLE = $rowConfig->pr_title;
		$SITE_META_KEYWORDS = $rowConfig->pr_meta_keyword;
		$SITE_META_DESCRIPTION =  $rowConfig->pr_meta_description;
		$SITE_EMAIL = returnName("config_site_email", "site_config", "config_id", 1);
	}
} else if(isset($_REQUEST['id'])){
	$QryConfig = "SELECT cn.cnt_title, cn.cnt_keywords, cn.cnt_description FROM contents AS cn WHERE cn.cnt_id=".$_REQUEST['id']." ";
	$RsConfig = mysql_query($QryConfig) or die(mysql_error());
	if (mysql_num_rows($RsConfig)>=1){
		$rowConfig=mysql_fetch_object($RsConfig);
		$SITE_TITLE = $rowConfig->cnt_title;
		$SITE_META_KEYWORDS = $rowConfig->cnt_keywords;
		$SITE_META_DESCRIPTION =  $rowConfig->cnt_description;
		$SITE_EMAIL = returnName("config_site_email", "site_config", "config_id", 1);
	}
} else {
	$QryConfig = "SELECT * FROM site_config WHERE config_id = 1";
	$RsConfig = mysql_query($QryConfig) or die(mysql_error());
	if (mysql_num_rows($RsConfig)>=1){
		$rowConfig=mysql_fetch_object($RsConfig);
		$SITE_TITLE = $rowConfig->config_sitetitle;
		$SITE_META_KEYWORDS = $rowConfig->config_metakey;
		$SITE_META_DESCRIPTION =  $rowConfig->config_metades;
		$SITE_EMAIL = $rowConfig->config_site_email;
	}
	if($rowConfig->status_id == 0){
		include("not_available.php");
		die();
	}
}
define("SITE_TITLE", $SITE_TITLE);
define("SITE_META_KEYWORDS", $SITE_META_KEYWORDS);
define("SITE_META_DESCRIPTION", $SITE_META_DESCRIPTION);
define("SITE_EMAIL", $SITE_EMAIL);
$_SESSION['sessID'] = session_id();

//Detect special conditions devices
$_SESSION['isIPhone']=0;
$iPod    = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
$iPhone  = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
$iPad    = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
$Android = stripos($_SERVER['HTTP_USER_AGENT'],"Android");
$webOS   = stripos($_SERVER['HTTP_USER_AGENT'],"webOS");
if( $iPod || $iPhone ){
	$_SESSION['isIPhone']=1;
}else if($iPad){
	$_SESSION['isIPhone']=1;
}else if($Android){
	$_SESSION['isIPhone']=0;
}else if($webOS){
	$_SESSION['isIPhone']=0;
}

// Local
// http://localhost/esol/2013/wap_portal2/code/
$siteRoot = "http://54.201.33.172/wap-portal/";
// Live
// http://180.92.158.4/wap_portal/ 
$_SESSION['site_root'] = $siteRoot;

?>
