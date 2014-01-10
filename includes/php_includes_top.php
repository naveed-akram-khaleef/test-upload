<?php
ob_start();
session_start();
include("lib/openCon.php");
include("lib/functions.php");
include("lib/functions_mail.php");
include("lib/site_settings.php");
include("lib/class.pager2.php");
$p = new Pager1;
$mpl_id	  = 0;
$dw_limit = 0;
$st_limit = 0;
$gf_limit = 0;
$pkcredits = 0;
$pat_id = "";
if(isset($_SESSION["memID"])){
	$Qry = mysql_query("SELECT mpl.mpl_id, mpl.mem_pak_expiry FROM mem_pak_limits AS mpl WHERE mpl.mem_id=".$_SESSION["memID"]." ORDER BY mpl.mpl_id DESC");
	if(mysql_num_rows($Qry)>0){
		while($row=mysql_fetch_object($Qry)){
			if($row->mem_pak_expiry<=(date('Y-m-d'))){
				mysql_query("UPDATE mem_pak_limits SET mem_pak_isexpired='1' WHERE mem_id=".$_SESSION["memID"]." AND mem_pak_isexpired='0' AND mpl_id=".$row->mpl_id." ");
				mysql_query("DELETE FROM mem_pak_limits WHERE mem_id=".$_SESSION["memID"]." AND mem_pak_isexpired='1' AND mpl_id=".$row->mpl_id." ");
			}
		}
	}
	$Qry11 = mysql_query("SELECT * FROM my_package_history WHERE mph_expiry<'".(date('Y-m-d'))."' ");
	if(mysql_num_rows($Qry11)>0){
		while($row11=mysql_fetch_object($Qry11)){
			if($row11->mph_expiry<(date('Y-m-d'))){
				mysql_query("UPDATE my_package_history SET mem_pak_isexpired='1' WHERE mph_id=".$row11->mph_id." ");
			}
		}
	}
	$Qry1 = mysql_query("SELECT mpl.*, pk.pat_id FROM mem_pak_limits AS mpl LEFT OUTER JOIN packages AS pk ON mpl.pak_id=pk.pak_id WHERE mpl.mem_id=".$_SESSION["memID"]." AND mpl.mem_pak_isexpired='0' ORDER BY mpl.mpl_id DESC LIMIT 1");
	if(mysql_num_rows($Qry1)>0){
		$row1=mysql_fetch_object($Qry1);
		$mpl_id = $row1->mpl_id;
		$downloads = $row1->mem_pak_downloads;
		$streams = $row1->mem_pak_stream;
		$gifts = $row1->mem_pak_gift;
		$downloadsc = $row1->mem_pak_downloads_con;
		$streamsc = $row1->mem_pak_stream_con;
		$giftsc = $row1->mem_pak_gift_con;
		$pkcredits = $row1->mem_pak_credits;
		$pat_id = $row1->pat_id;
		if($downloads!=$downloadsc){ $dw_limit = 1; }
		if($streams!=$streamsc){ $st_limit = 1; }
		if($gifts!=$giftsc){ $gf_limit = 1; }
		if(($downloads==$downloadsc)&&($streams==$streamsc)&&($gifts==$giftsc)){
			mysql_query("UPDATE mem_pak_limits SET mem_pak_isexpired='1' WHERE mem_id=".$_SESSION["memID"]." AND mem_pak_isexpired='0' AND mpl_id=".$row1->mpl_id." ");
		}
	}
}

if(isset($_REQUEST['lang_id'])&&($_REQUEST['lang_id'])!=''){
	$_SESSION['lang_id'] = $_REQUEST['lang_id'];
}
if(!isset($_SESSION['lang_id'])){
	$_SESSION['lang_id'] = 1;
}
$rtl = (($_SESSION['lang_id']>=2)?"style='direction:rtl;'":'');

$query = "SELECT lang_file FROM language WHERE lang_id=".$_SESSION['lang_id']." LIMIT 1 ";
$res = mysql_query($query);
$row = mysql_fetch_object($res);
include("language/".$row->lang_file);
?>