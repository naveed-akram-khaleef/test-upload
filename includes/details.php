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

echo '0 Success 1';


//header("Location: rtsp://178.79.149.95/vod/videos/mp3:line");
//header("Location: http://www.google.com/");

/*$Query = "SELECT prf.*, pt.ptype_value, pt.cat_id FROM pr_files AS prf LEFT OUTER JOIN pr_types AS pt ON prf.ptype_id=pt.ptype_id WHERE prf.prf_id=".$_REQUEST['prf_id']." AND prf.pr_id=".$_REQUEST['pr_id']." LIMIT 1";
$rs = mysql_query($Query);
$count = mysql_num_rows(mysql_query($Query)); 
if($count>0){
	$row=mysql_fetch_object($rs);
	if(isset($_REQUEST['preview'])){
		$name = @pathinfo($row->prf_preview,PATHINFO_FILENAME);
		$ext  = @pathinfo($row->prf_preview,PATHINFO_EXTENSION);
		$redirect_url = "rtsp://178.79.149.95/vod/videos/preview/".$ext.":".$name."";

		//$contents = @file_get_contents("http://178.79.149.95:82/prepare/?fname=preview/".$row->prf_preview);
		//$download_link = "http://178.79.149.95:82/downloads/".$contents;
	} else {
		$name = @pathinfo($row->prf_file,PATHINFO_FILENAME);
		$ext  = @pathinfo($row->prf_file,PATHINFO_EXTENSION);
		$redirect_url = "rtsp://178.79.149.95/vod/videos/file/".$ext.":".$name."";

		//$contents = @file_get_contents("http://178.79.149.95:82/prepare/?fname=file/".$row->prf_file);
		//$download_link = "http://178.79.149.95:82/downloads/".$contents;
	}

	//$redirect_url = "http://www.google.com/";
	$redirect_url = $redirect_url;
	echo '1here';
	//echo redirect($redirect_url);
	echo '2here';
	
	$res='';
	$res.='<script type="text/javascript">';
		//$res.='window.location.href="'.$redirect_url.'";';
		//$res.='window.location.replace("'.$redirect_url.'");';
		//$res.='$(window).attr("location","'.$redirect_url.'");';
	$res.='</script>';
	//echo $res;
}
*/

?>

<!--<form action="rtsp://178.79.149.95/vod/videos/mp3:line" method="get" id="someID">
</form>
<script>

document.getElementById("someID").submit();
alert('here');

	$("#redirect_using_jquery").click();
	$('#redirect_using_jquery').trigger('click');
	$('#redirect_using_jquery').triggerHandler('click');
	alert('ok1');


	autoclick = function() {
		$('#redirect_using_jquery').triggerHandler('click');
	};
	window.setInterval(autoclick,2000);
	alert('ok2');

	function performClick() {
		$("#redirect_using_jquery").trigger("click");
	}
	window.setTimeout(performClick, 2000);
	alert('ok3');
	
	$(function() {
		var timeout;
		$('#redirect_using_jquery').click(function() {
			timeout = setTimeout(function() {
						$('#redirect_using_jquery').trigger('click');
					}, 2000);
		})
		timeout = setTimeout(function() {
			$('#redirect_using_jquery').trigger('click');
		}, 2000);
	})
	alert('ok4');
	
	$(document).ready(function(){
		$('.redirect_using_jquery').trigger('click');
	});
	//alert('ok5');

	$(document).ready(function(){
	   $('.redirect_using_jquery').click();
	});
	alert('ok6');

</script>

-->