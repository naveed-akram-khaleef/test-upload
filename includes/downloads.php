<?php
session_start();
include("../lib/openCon.php");
include("../lib/functions.php");
include("../lib/site_settings.php");

$Query = mysql_query("SELECT * FROM mem_logs WHERE mem_id=".$_SESSION["memID"]." AND cat_id=".$_REQUEST["cat_id"]." AND ustype_id=".$_REQUEST['consume']." AND pr_id=".$_REQUEST['pr_id']." AND counter<5");
$total = mysql_num_rows($Query);
$row = $row=mysql_fetch_object($Query);
if($total>0){
	mysql_query("UPDATE mem_logs SET counter = (counter + 1) WHERE mem_id=".$_SESSION["memID"]." AND cat_id=".$_REQUEST["cat_id"]." AND ustype_id=".$_REQUEST['consume']." AND pr_id=".$_REQUEST['pr_id']." AND counter<5");

	$file_without_spaces =  preg_replace('/\s+/', '%20', returnName("prf_file", "pr_files", "prf_id", $_REQUEST['prf_id']));	
	$prf_file = $_SESSION['site_root'].'files/products/file/'.$file_without_spaces;
	if($_REQUEST['cat_id']==4){
		$fileType = 'image/jpeg';
	} elseif($_REQUEST['cat_id']==1||$_REQUEST['cat_id']==3){
		$fileType = 'audio/mp3';
	} elseif($_REQUEST['cat_id']==2){
		$fileType = 'video/3gpp';
	}
	header("Content-Type: ".$fileType."");
	header("Content-Disposition: attachment; filename=".basename($prf_file)."; ");
	$size = getimagesize($prf_file); 
	$chunksize = 1 * (2 * 2);
	if ($size > $chunksize) {
		   $handle = fopen($prf_file, 'rb');
		   $buffer = '';
		   while (!feof($handle)) {
				 $buffer = fread($handle, $chunksize);
				 echo $buffer;
				 ob_flush();
				 flush();
		   }
		  fclose($handle);
	} else {
		readfile($prf_file);
	}
	exit();
}
else {
	$MaxID = getMaximum("mem_logs","mlog_id");
	mysql_query("INSERT INTO mem_logs (mlog_id, mem_id, cat_id, ustype_id, pr_id, mlog_date, mlog_time, counter) VALUES (".$MaxID.", ".$_SESSION["memID"].", ".$_REQUEST['cat_id'].", ".$_REQUEST['consume'].", ".$_REQUEST['pr_id'].", NOW(), NOW(), 1)");

	$MaxID = getMaximum("my_consumption","myc_id");
	mysql_query("INSERT INTO my_consumption (myc_id, pr_id, mem_id, myc_added_date, cat_id, consume_type) VALUES (".$MaxID.", ".$_REQUEST['pr_id'].", ".$_SESSION["memID"].", NOW(), ".$_REQUEST['cat_id'].", '2')") or die(mysql_error());
	if($_REQUEST['consume']==1){
	
	} elseif($_REQUEST['consume']==2){
		if($_REQUEST['pat_id']==1){
			mysql_query("UPDATE mem_pak_limits SET mem_pak_downloads_con = (mem_pak_downloads_con + 1) WHERE mem_id = ".$_SESSION["memID"]." AND mpl_id=".$_REQUEST['mpl_id']." AND mem_pak_isexpired=0 ");
			mysql_query("UPDATE my_package_history SET mem_pak_downloads_con = (mem_pak_downloads_con + 1) WHERE mem_id = ".$_SESSION["memID"]." AND mpl_id=".$_REQUEST['mpl_id']." AND mem_pak_isexpired=0 ");
		}
		elseif($_REQUEST['pat_id']==2){
			mysql_query("UPDATE mem_pak_limits SET mem_pak_credits = (mem_pak_credits - 2) WHERE mem_id = ".$_SESSION["memID"]." AND mpl_id=".$_REQUEST['mpl_id']." AND mem_pak_isexpired=0 ");
			mysql_query("UPDATE my_package_history SET mem_pak_credits = (mem_pak_credits - 2) WHERE mem_id = ".$_SESSION["memID"]." AND mpl_id=".$_REQUEST['mpl_id']." AND mem_pak_isexpired=0 ");
		}
	}

	$file_without_spaces =  preg_replace('/\s+/', '%20', returnName("prf_file", "pr_files", "prf_id", $_REQUEST['prf_id']));	
	$prf_file = $_SESSION['site_root'].'files/products/file/'.$file_without_spaces;
	if($_REQUEST['cat_id']==4){
		$fileType = 'image/jpeg';
	} elseif($_REQUEST['cat_id']==1||$_REQUEST['cat_id']==3){
		$fileType = 'audio/mp3';
	} elseif($_REQUEST['cat_id']==2){
		$fileType = 'video/3gpp';
	}
	header("Content-Type: ".$fileType."");
	header("Content-Disposition: attachment; filename=".basename($prf_file)."; ");
	$size = getimagesize($prf_file); 
	$chunksize = 1 * (2 * 2);
	if ($size > $chunksize) {
		   $handle = fopen($prf_file, 'rb');
		   $buffer = '';
		   while (!feof($handle)) {
				 $buffer = fread($handle, $chunksize);
				 echo $buffer;
				 ob_flush();
				 flush();
		   }
		  fclose($handle);
	} else {
		readfile($prf_file);
	}
	exit();
}
?>