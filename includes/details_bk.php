<?php
/*session_start();
include("../lib/openCon.php");
include("../lib/functions.php");
include("../lib/functions_mail.php");
include("../lib/site_settings.php");*/
/*if(!isset($_REQUEST['preview'])){
	$Query = mysql_query("SELECT * FROM mem_logs WHERE mem_id=".$_SESSION["memID"]." AND cat_id=".$_REQUEST["cat_id"]." AND ustype_id=".$_REQUEST['consume']." AND pr_id=".$_REQUEST['pr_id']." AND counter<5");
	$total = mysql_num_rows($Query);
	$row = $row=mysql_fetch_object($Query);
	if($total>0){
		mysql_query("UPDATE mem_logs SET counter = (counter + 1) WHERE mem_id=".$_SESSION["memID"]." AND cat_id=".$_REQUEST["cat_id"]." AND ustype_id=".$_REQUEST['consume']." AND pr_id=".$_REQUEST['pr_id']." AND counter<5");
	}
	else {
		$MaxID = getMaximum("mem_logs","mlog_id");
		mysql_query("INSERT INTO mem_logs (mlog_id, mem_id, cat_id, ustype_id, pr_id, mlog_date, mlog_time, counter) VALUES (".$MaxID.", ".$_SESSION["memID"].", ".$_REQUEST['cat_id'].", ".$_REQUEST['consume'].", ".$_REQUEST['pr_id'].", NOW(), NOW(), 1)");
		
		$MaxID = getMaximum("my_consumption","myc_id");
		mysql_query("INSERT INTO my_consumption (myc_id, pr_id, mem_id, myc_added_date, cat_id, consume_type) VALUES (".$MaxID.", ".$_REQUEST['pr_id'].", ".$_SESSION["memID"].", NOW(), ".$_REQUEST['cat_id'].", '1')");
		
		if($_REQUEST['pat_id']==1){
			mysql_query("UPDATE mem_pak_limits SET mem_pak_stream_con = (mem_pak_stream_con + 1) WHERE mem_id = ".$_SESSION["memID"]." AND mpl_id=".$_REQUEST['mpl_id']." AND mem_pak_isexpired=0 ");
			mysql_query("UPDATE my_package_history SET mem_pak_stream_con = (mem_pak_stream_con + 1) WHERE mem_id = ".$_SESSION["memID"]." AND mpl_id=".$_REQUEST['mpl_id']." AND mem_pak_isexpired=0 ");
		}
		elseif($_REQUEST['pat_id']==2){
			mysql_query("UPDATE mem_pak_limits SET mem_pak_credits = (mem_pak_credits - 1) WHERE mem_id = ".$_SESSION["memID"]." AND mpl_id=".$_REQUEST['mpl_id']." AND mem_pak_isexpired=0 ");
			mysql_query("UPDATE my_package_history SET mem_pak_credits = (mem_pak_credits - 1) WHERE mem_id = ".$_SESSION["memID"]." AND mpl_id=".$_REQUEST['mpl_id']." AND mem_pak_isexpired=0 ");
		}
	}
}*/
echo 'Success';
?>