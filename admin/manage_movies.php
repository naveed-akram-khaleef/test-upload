<?php
ob_start();
include("../lib/openCon.php");
include("../lib/functions.php");
session_start();
$fileOrgPath = "../files/audio/";
if(!isset($_SESSION['UID'])){
	header("location: login.php");
}
include("includes/php_includes_top.php");
$msg_class = "";
$strMSG = "";
$FormHead = "";
$mfileName = "";
$hddn='';
include("../lib/class.pager1.php");
$p = new Pager1;

$_SESSION['cat_id'] = 2;

if(isset($_REQUEST["cid"])){
	$cid = $_REQUEST["cid"];
}

include('../sftp_lib/Net/SFTP.php');
define('NET_SFTP_LOGGING', NET_SFTP_LOG_COMPLEX);

if(isset($_REQUEST['btnDefault'])){
	mysql_query("UPDATE pr_files SET is_default=0 WHERE pr_id = ".$_REQUEST['pr_id']);
	mysql_query("UPDATE pr_files SET is_default=1 WHERE prf_id = ".$_REQUEST['prf_id']);
	$msg_class='msg_box msg_ok';
	$strMSG = "Status Changed successfully";
}

if(isset($_REQUEST['action'])){
	if(isset($_REQUEST['btnEdit'])){
		$chk = chkExist("pr_id", "products_ln", "WHERE pr_id=".$_REQUEST['pr_id']." AND lang_id=".$_SESSION["lang_id"]);
		if($chk > 0){
			$strQRY22="UPDATE products SET cat_id='".$_REQUEST['cat_id']."', pr_modified_date=NOW() WHERE pr_id = ".$_REQUEST['pr_id']." ";
			$nRst=mysql_query($strQRY22) or die(mysql_error()."Unable 2 Edit");

			$strQRY4="UPDATE products_ln SET pr_title='".$_REQUEST['pr_title']."', pr_short_details='".$_REQUEST['pr_short_details']."', pr_long_details='".$_REQUEST['pr_long_details']."', pr_meta_keyword='".$_REQUEST['pr_meta_keyword']."', pr_meta_description='".$_REQUEST['pr_meta_description']."' WHERE pr_id = ".$_REQUEST['pr_id']." AND lang_id=".$_SESSION['lang_id']." ";
			$nRst=mysql_query($strQRY4);
		}
		else{
			$strQRY3="INSERT INTO products_ln (pr_id, pr_title, pr_short_details, pr_long_details,pr_meta_keyword, pr_meta_description, lang_id) VALUES(".$_REQUEST['pr_id'].", '".$_REQUEST['pr_title']."', '".$_REQUEST['pr_short_details']."', '".$_REQUEST['pr_long_details']."', '".$_REQUEST['pr_meta_keyword']."', '".$_REQUEST['pr_meta_description']."', '".$_SESSION['lang_id']."')";
			$nRst=mysql_query($strQRY3);
		}
		for($i=0; $i<count($_REQUEST['formatID']); $i++){
			$MaxID_prf = getMaximum("pr_files","prf_id");
			$mfileName = "";
			$pfileName = "";
			$randNum = rand(0000,9999);
			$tfileName = "";
			$tfileName1 = "";
			$dirName = "../files/products/";
			if (!empty($_FILES["tFile"]["name"][$i])){
				@unlink("../files/products/img/".$_REQUEST['tfileName'][$i]);
				@unlink("../files/products/th/".$_REQUEST['tfileName'][$i]);
				$ext = @pathinfo($_FILES['tFile']['name'][$i],PATHINFO_EXTENSION);
				$tfileName = $_REQUEST['pr_id'].'_'.$randNum.".".$ext;
				if(move_uploaded_file($_FILES['tFile']['tmp_name'][$i], $dirName.'img/'.$tfileName)){
					createThumbnail2($dirName.'img/', $tfileName, $dirName.'th/', 200, 200);
					$tfileName1 = " , prf_thumb='".$tfileName."' ";
				}
			}
			$mfileName1 = "";
			$dirName = "../files/products/file/";
			if (!empty($_FILES["mFile"]["name"][$i])){
				@unlink("../files/products/file/".$_REQUEST['mfileName'][$i]);
				$mfileName = $_REQUEST['mfileName'][$i];
				include("../lib/transfer_d_file.php");
				$mfileName='';
				$ext = @pathinfo(@$_FILES['mFile']['name'][$i], @PATHINFO_EXTENSION);
				$mfileName = $_REQUEST['pr_id']."_".$randNum.".".$ext;
				if(move_uploaded_file($_FILES['mFile']['tmp_name'][$i], $dirName.$mfileName)){
					$mfileName1 = " , prf_file='".$mfileName."' ";
					include("../lib/transfer.php");
				}
			}
			$pfileName1 = "";
			$dirName = "../files/products/preview/";
			if (!empty($_FILES["pFile"]["name"][$i])){
				@unlink("../files/products/preview/".$_REQUEST['pfileName'][$i]);
				$pfileName = $_REQUEST['pfileName'][$i];
				include("../lib/transfer_d_preview.php");
				$pfileName = "";
				$ext = @pathinfo(@$_FILES['pFile']['name'][$i], @PATHINFO_EXTENSION);
				$pfileName = $_REQUEST['pr_id']."_".$randNum.".".$ext;
				if(move_uploaded_file($_FILES['pFile']['tmp_name'][$i], $dirName.$pfileName)){
					$pfileName1 = " , prf_preview='".$pfileName."' ";
					include("../lib/transfer.php");
				}
			}
			$Qry0 = mysql_query("SELECT * FROM pr_files WHERE pr_id = ".$_REQUEST['pr_id']." ");
			if(mysql_num_rows($Qry0)>0){
				$strQRY1="UPDATE pr_files SET ptype_id=".$_REQUEST['formatID'][$i]." ".$tfileName1." ".$mfileName1." ".$pfileName1."  WHERE pr_id = ".$_REQUEST['pr_id']." AND ptype_id=".$_REQUEST['formatID'][$i]." ";
				$nRst=mysql_query($strQRY1) or die(mysql_error()."Unable 2 Add New Record");
			} else {
				$MaxID_prf = getMaximum("pr_files","prf_id");
				$strQRY2="INSERT INTO pr_files (prf_id, prf_thumb, prf_file, prf_preview, ptype_id, pr_id, mem_id, prf_added_date) VALUES (".$MaxID_prf.", '".$tfileName."', '".$mfileName."', '".$pfileName."', '".$_REQUEST['formatID'][$i]."', '".$_REQUEST['pr_id']."', '".$_SESSION['UID']."', NOW())";
				$nRst=mysql_query($strQRY2) or die(mysql_error()."Unable 2 Add New Record");
			}
		}
		header("Location: manage_movies.php?op=1&hddn=".$hddn);
	}
	if(isset($_REQUEST['action']) && $_REQUEST['action']==2){
		$strQry="SELECT p.*, pl.pr_title, pl.pr_short_details, pl.pr_long_details, pl.pr_meta_keyword, pl.pr_meta_description, prf.* From products AS p LEFT OUTER JOIN products_ln AS pl ON pl.pr_id=p.pr_id AND pl.lang_id=".$_SESSION['lang_id']." LEFT OUTER JOIN pr_files AS prf ON prf.pr_id=p.pr_id AND prf.is_default=1 WHERE p.pr_id=".$_REQUEST['pr_id']." ORDER BY p.pr_id LIMIT 1";
		$nResult = mysql_query($strQry);
		$rs = mysql_fetch_object($nResult);
		$pr_title = $rs->pr_title;
		$pr_short_details = $rs->pr_short_details;
		$pr_long_details = $rs->pr_long_details;
		$pr_meta_keyword = $rs->pr_meta_keyword;
		$pr_meta_description = $rs->pr_meta_description;
		$cat_id = $rs->cat_id;
		$ptype_id = $rs->ptype_id;
		$strHead = "Edit Details";
	} else {
		$pr_title = '';
		$pr_short_details = '';
		$pr_long_details = '';
		$pr_meta_keyword = '';
		$pr_meta_description = '';
		$cat_id = 1;
		$pr_file = '';
		$pr_thumb = '';
		$ptype_id = 0;
		$strHead = "Add Details";
	}
}
if(isset($_REQUEST['btnDelete'])){
	for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
		$rs = mysql_query("SELECT prf_file, prf_thumb, prf_preview FROM pr_files WHERE pr_id=".$_REQUEST['chkstatus'][$i]." ");
		$row = mysql_fetch_object($rs);
		@unlink("../files/products/preview/".$row->prf_preview);
		@unlink("../files/products/file/".$row->prf_file);
		@unlink("../files/products/img/".$row->prf_thumb);
		@unlink("../files/products/th/".$row->prf_thumb);
		mysql_query("DELETE FROM votes WHERE pro_id = ".$_REQUEST['chkstatus'][$i]);
		mysql_query("DELETE FROM pr_files WHERE pr_id = ".$_REQUEST['chkstatus'][$i]);
		mysql_query("DELETE FROM products_ln WHERE pr_id = ".$_REQUEST['chkstatus'][$i]);
		mysql_query("DELETE FROM products WHERE pr_id = ".$_REQUEST['chkstatus'][$i]);
	}
	$msg_class='msg_box msg_ok';
	$strMSG = "Record(s) Deleted Successfully";
}
if(isset($_REQUEST['btnAdd'])){
	$chk = IsExist("pr_id", "products", "pr_title", $_REQUEST['pr_title']);
	if ($chk == 1){
		header("Location: manage_movies.php?op=4");
	} else {
		$MaxID = getMaximum("products","pr_id");
		for($i=0; $i<count($_REQUEST['formatID']); $i++){
			$MaxID_prf = getMaximum("pr_files","prf_id");
			$mfileName = "";
			$pfileName = "";
			$randNum = rand(0000,9999);
			$tfileName = "";
			$dirName = "../files/products/";
			if (!empty($_FILES["tFile"]["name"][$i])){
				$ext = @pathinfo($_FILES['tFile']['name'][$i],PATHINFO_EXTENSION);
				$tfileName = $MaxID.'_'.$randNum.".".$ext;
				if(move_uploaded_file($_FILES['tFile']['tmp_name'][$i], $dirName.'img/'.$tfileName)){
					createThumbnail2($dirName.'img/', $tfileName, $dirName.'th/', 200, 200);
				}
			}
			$dirName = "../files/products/file/";
			if (!empty($_FILES["mFile"]["name"][$i])){
				$ext = @pathinfo(@$_FILES['mFile']['name'][$i], @PATHINFO_EXTENSION);
				$mfileName = $MaxID."_".$randNum.".".$ext;
				if(move_uploaded_file($_FILES['mFile']['tmp_name'][$i], $dirName.$mfileName)){
					include("../lib/transfer.php");
				}
			}
			$dirName = "../files/products/preview/";
			if (!empty($_FILES["pFile"]["name"][$i])){
				$ext = @pathinfo(@$_FILES['pFile']['name'][$i], @PATHINFO_EXTENSION);
				$pfileName = $MaxID."_".$randNum.".".$ext;
				if(move_uploaded_file($_FILES['pFile']['tmp_name'][$i], $dirName.$pfileName)){
					include("../lib/transfer.php");
				}
			}
			$strQry0=mysql_query("SELECT prf_id FROM pr_files WHERE pr_id = ".$MaxID." ");
			$res0 = mysql_num_rows($strQry0);
			if($res0>0){
				$isdefault = 0;
			} else {
				$isdefault = 1;
			}
			$strQRY1="INSERT INTO pr_files (prf_id, prf_thumb, prf_file, prf_preview, ptype_id, pr_id, mem_id, prf_added_date, is_default) VALUES (".$MaxID_prf.", '".$tfileName."', '".$mfileName."', '".$pfileName."', '".$_REQUEST['formatID'][$i]."', '".$MaxID."', '".$_SESSION['UID']."', NOW(), ".$isdefault.")";
			$nRst=mysql_query($strQRY1) or die(mysql_error()."Unable 2 Add New Record");
		}
		$strQRY2="INSERT INTO products (pr_id, pr_title, pr_short_details, pr_long_details,pr_meta_keyword, pr_meta_description, pr_added_date, cat_id) VALUES(".$MaxID.", '".$_REQUEST['pr_title']."', '".$_REQUEST['pr_short_details']."', '".$_REQUEST['pr_long_details']."', '".$_REQUEST['pr_meta_keyword']."', '".$_REQUEST['pr_meta_description']."', NOW(), '".$_REQUEST['cat_id']."')";
		$nRst=mysql_query($strQRY2);
		$strQRY3="INSERT INTO products_ln (pr_id, pr_title, pr_short_details, pr_long_details,pr_meta_keyword, pr_meta_description, lang_id) VALUES(".$MaxID.", '".$_REQUEST['pr_title']."', '".$_REQUEST['pr_short_details']."', '".$_REQUEST['pr_long_details']."', '".$_REQUEST['pr_meta_keyword']."', '".$_REQUEST['pr_meta_description']."', '".$_SESSION['lang_id']."')";
		$nRst=mysql_query($strQRY3);
		header("Location: manage_movies.php?op=1&hddn=".$hddn);

	}
}
if(isset($_REQUEST['active'])){
	if(isset($_REQUEST['chkstatus'])){
		for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
			mysql_query("UPDATE products SET status_id=1 WHERE pr_id = ".$_REQUEST['chkstatus'][$i]);
		}
		$msg_class='msg_box msg_ok';
		$strMSG = "Record(s) updated successfully";
	}
	else{
		$strMSG = "Please check atleast one checkbox";
	}
}
if(isset($_REQUEST['nactive'])){
	if(isset($_REQUEST['chkstatus'])){
		for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
			mysql_query("UPDATE products SET status_id=0 WHERE pr_id = ".$_REQUEST['chkstatus'][$i]);
		}
		$msg_class='msg_box msg_ok';
		$strMSG = "Record(s) updated successfully";
	}
	else{
		$strMSG = "Please check atleast one checkbox";
	}
}
if(isset($_REQUEST['featured'])){
	if(isset($_REQUEST['chkstatus'])){
		for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
			mysql_query("UPDATE products SET is_featured=1 WHERE pr_id = ".$_REQUEST['chkstatus'][$i]);
		}
		$msg_class='msg_box msg_ok';
		$strMSG = "Record(s) updated successfully";
	}
	else{
		$strMSG = "Please check atleast one checkbox";
	}
}
if(isset($_REQUEST['nfeatured'])){
	if(isset($_REQUEST['chkstatus'])){
		for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
			mysql_query("UPDATE products SET is_featured=0 WHERE pr_id = ".$_REQUEST['chkstatus'][$i]);
		}
		$msg_class='msg_box msg_ok';
		$strMSG = "Record(s) updated successfully";
	}
	else{
		$strMSG = "Please check atleast one checkbox";
	}
}
if(isset($_REQUEST['home'])){
	if(isset($_REQUEST['chkstatus'])){
		for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
			mysql_query("UPDATE products SET is_home=1 WHERE pr_id = ".$_REQUEST['chkstatus'][$i]);
		}
		$msg_class='msg_box msg_ok';
		$strMSG = "Record(s) updated successfully";
	}
	else{
		$strMSG = "Please check atleast one checkbox";
	}
}
if(isset($_REQUEST['nhome'])){
	if(isset($_REQUEST['chkstatus'])){
		for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
			mysql_query("UPDATE products SET is_home=0 WHERE pr_id = ".$_REQUEST['chkstatus'][$i]);
		}
		$msg_class='msg_box msg_ok';
		$strMSG = "Record(s) updated successfully";
	}
	else{
		$strMSG = "Please check atleast one checkbox";
	}
}
if(isset($_REQUEST['resetVotings'])){
	if(isset($_REQUEST['chkstatus'])){
		for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
			mysql_query("DELETE FROM votes WHERE pro_id = ".$_REQUEST['chkstatus'][$i]);
		}
		$msg_class='msg_box msg_ok';
		$strMSG = "Record(s) updated successfully";
	}
	else{
		$strMSG = "Please check atleast one checkbox";
	}
}
/*if(isset($_REQUEST["op"])){
	switch ($_REQUEST["op"]) {
		case 1:
			$msg_class='msg_box msg_ok';
			$strMSG = "Record Added Successfully";
			break;
		case 2:
			$msg_class='msg_box msg_ok';
			$strMSG = "Record Updated Successfully";
			break;
		case 3:
			$msg_class='msg_box msg_ok';
			$strMSG = "Record Deleted Successfully";
			break;
	}
}*/

$strMSG2='';
if(isset($_REQUEST['op'])){
	switch ($_REQUEST['op']) {
		case 1:
			$strMSG2 = "";
			if($_REQUEST['hddn']==0){
				$strMSG2 = " but your file is not transferred at our Media Server. Please try again and if see the same message again and contact our site admin.";
			}
			$strMSG = "Record Added Successfully".$strMSG2;
			$msg_class='msg_box msg_ok';
			break;
		case 2:
			if($_REQUEST['hddn']==0){
				$strMSG2 = " but your file is not transferred at our Media Server. Please try again and if see the same message again and contact our site admin.";
			}
			$strMSG = "Record Updated Successfully".$strMSG2;
			$msg_class='msg_box msg_ok';
			break;
		case 3:
			$msg_class='msg_box msg_ok';
			$strMSG = "Record Deleted Successfully";
			break;
		case 4:
			$msg_class='msg_box msg_alert';
			$strMSG = "Already exists";
			break;
	}
}
@$_SESSION["progress_bar"] = "";
ob_end_flush();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<?php
	include("includes/html_header.php");
?>  
</head>
<body class="bg_c sidebar fixed">
	<?php include("includes/top_bar.php");?>
	<div id="main">
		<div class="wrapper">
			<div id="main_section" class="cf brdrrad_a">
				<?php include("includes/bread_crum.php");?>
				<div id="content_wrapper">
					<div id="main_content" class="cf">

						<?php if($msg_class != ''){?>
                            <div class="<?php echo $msg_class;?>"><?php echo $strMSG;?><img src="images/blank.gif" class="msg_close" alt="" /></div>
                        <?php }?>
						<?php if($strMSG2 != ''){?>
                            <div class="<?php echo $msg_class;?>"><?php echo $strMSG2;?><img src="images/blank.gif" class="msg_close" alt="" /></div>
                        <?php }?>

                        <div class="sepH_c">
                            <h1 class="sepH_c">Movies Management</h1>
							<?php
                                if(isset($_REQUEST['show'])){
                            ?>
                                <div class="formEl_a">
                                    <fieldset class="sepH_b">
                                        <legend>Details</legend>
                                        <table cellpadding="0" cellspacing="0" border="0" class="table_a smpl_tbl">
                                        <?php
                                            $Query="SELECT p.pr_id, p.pr_added_date, p.pr_modified_date, p.status_id, p.cat_id, p.pr_hits, p.is_home, p.is_featured, p.mem_id, p.ptype_id, pl.*, ca.cat_name, m.mem_login from products AS p LEFT OUTER JOIN categories AS ca ON p.cat_id=ca.cat_id LEFT OUTER JOIN members AS m ON p.mem_id=m.mem_id LEFT OUTER JOIN products_ln AS pl ON p.pr_id=pl.pr_id WHERE p.pr_id=".$_REQUEST['pr_id']." AND pl.lang_id=".$_SESSION['lang_id']." ";
                                            $rs = mysql_query($Query);
                                                if(mysql_num_rows($rs)>0){
                                                    $row=mysql_fetch_object($rs);
                                        ?>
                                                <tr>
                                                    <td>Category:</td>
                                                    <td><?php print($row->cat_name);?></td>
                                                </tr>
                                                <tr>
                                                    <td>Name:</td>
                                                    <td><?php print($row->pr_title);?></td>
                                                </tr>
                                                <tr>
                                                    <td>Short Details:</td>
                                                    <td><?php print($row->pr_short_details);?></td>
                                                </tr>
                                                <tr>
                                                    <td>Long Details:</td>
                                                    <td><?php print($row->pr_long_details);?></td>
                                                </tr>
                                                <tr>
                                                    <td>Meta Keyword:</td>
                                                    <td><?php print($row->pr_meta_keyword);?></td>
                                                </tr>
                                                <tr>
                                                    <td>Meta Description:</td>
                                                    <td><?php print($row->pr_meta_description);?></td>
                                                </tr>
                                                <tr>
                                                    <td>Added:</td>
                                                    <td><?php print($row->pr_added_date);?></td>
                                                </tr>
                                                <tr>
                                                    <td>Modified:</td>
                                                    <td><?php print($row->pr_modified_date);?></td>
                                                </tr>
                                                <tr>
                                                    <td>Status:</td>
                                                    <td><?php echo (($row->status_id==1)?"<span class='notification ok_bg'>Active</span>":"<span class='notification alert_bg'>Not Active</span>");?> </td>
                                                </tr>
                                                <tr>
                                                    <td>Total Hits:</td>
                                                    <td><?php print($row->pr_hits);?></td>
                                                </tr>
                                                <tr>
                                                    <td>Member:</td>
                                                    <td><?php print($row->mem_login);?></td>
                                                </tr>
                                                <tr>
                                                    <td>Featured:</td>
                                                    <td><?php echo (($row->is_featured==1)?"<span class='notification ok_bg'>Yes</span>":"<span class='notification alert_bg'>No</span>");?> </td>
                                                </tr>
                                                <tr>
                                                  <td>Rating:</td>
                                                  <td>
                                                    <?php 
                                                      $total_ratings = 0;
                                                      $total_vots = 0;
                                                      $avg = 0.0;
                                                      $qry1 = mysql_query("SELECT COUNT( 1 ) AS total_records, SUM( rate ) AS total FROM votes WHERE section_id=1 AND pro_id=".$row->pr_id);
                                                      if( mysql_num_rows($qry1)>0 ){
                                                        $row1 = mysql_fetch_object($qry1);
                                                        $total_ratings = $row1->total;
                                                        $total_vots = $row1->total_records;
                                                      }
                                                      if($total_ratings!=0 && $total_vots!=0) {
                                                        $avg = ( $total_ratings / $total_vots );
                                                        $avg = round($avg, 1);
                                                      }
                                                      echo 'Average '.$avg.' of '.$total_vots.' Rating';
                                                    ?>
                                                  </td>
                                                </tr>
                                                <?php
                                                    $counter=0;
                                                    $Query = "SELECT pt.*, prf.* FROM pr_types AS pt LEFT OUTER JOIN pr_files AS prf ON pt.ptype_id=prf.ptype_id WHERE pt.cat_id=2 AND prf.pr_id=".$row->pr_id." ";
                                                    $count = mysql_num_rows(mysql_query($Query)); 
                                                    $rs = mysql_query($Query);
                                                    if($count>0){
                                                        while($row=mysql_fetch_object($rs)){
                                                            $counter++;
                                                ?>
                                                  <tr>
                                                      <td>&nbsp;</td>
                                                      <td>&nbsp;</td>
                                                  </tr>
                                                  <tr>
                                                      <td>Default <?=$counter?>:</td>
                                                      <td>                                    
                                                        <?php 
                                                          if($row->is_default==0 || $row->is_default==''){
                                                        ?>
                                                            <a href="<?php print($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']."&btnDefault=1&prf_id=".$row->prf_id);?>">Set As Default</a> 
                                                        <?php
                                                          } else {
                                                            print("<b>Default</b>");
                                                          }
                                                        ?>
                                                    </td>
                                                  </tr>
                                                  <tr>
                                                      <td>Format <?=$counter?>:</td>
                                                      <td><?php print($row->ptype_value);?></td>
                                                  </tr>
                                                  <tr>
                                                      <td>File <?=$counter?>:</td>
                                                      <td><?php $file_link = @file_get_contents("http://178.79.149.95:82/prepare/?fname=file/".$row->prf_file);?><a href="http://178.79.149.95:82/downloads/<?php echo $file_link;?>" alt="">Download File</a></td>
                                                  </tr>
                                                  <tr>
                                                      <td>Preview <?=$counter?>:</td>
                                                      <td><?php $file_link = @file_get_contents("http://178.79.149.95:82/prepare/?fname=preview/".$row->prf_preview);?><a href="http://178.79.149.95:82/downloads/<?php echo $file_link;?>" alt="">Download File</a></td>
                                                  </tr>
                                                  <tr>
                                                      <td>Thumbnail <?=$counter?>:</td>
                                                      <td><img src="../files/products/th/<?php print($row->prf_thumb);?>" style="max-height:150px;" alt=""  /></td>
                                                  </tr>
                                                <?php
                                                    }
                                                  }
                                                ?>
                                        <?php
                                                } else {	
                                        ?>
                                                <tr><td colspan="100%" align="center" class="ListRow1">No Record Found</td></tr>
                                        <?php
                                            }
                                        ?>
                                        </table>
                                    </fieldset>
                                </div>
                                <input type="button" name="btnCancel" class="submitButton" value="BACK" onClick="javascript: window.location= 'manage_movies.php';">  
                            <?php	
                                } elseif(isset($_REQUEST['action'])){ 
                            ?>
                                <form name="form" method="post" action="<?php @print($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);?>" enctype="multipart/form-data">
                                    <div class="formEl_a">
                                        <fieldset class="sepH_b">
                                            <legend><?php echo @$strHead;?>
                                            </legend>
                                            <div class="sepH_b">
                                                <label for="a_text" class="lbl_a">Name:</label>
                                                <input  type="text" id="a_text" name="pr_title" value="<?php @print($pr_title);?>" class="inpt_a" />
                                            </div>
                                            <div class="sepH_b">
                                                <label for="a_textarea" class="lbl_a">Short Details:</label>
                                                <input  type="text" id="a_text" name="pr_short_details" value="<?php @print($pr_short_details);?>" class="inpt_a" />
                                            </div>
                                            <div class="sepH_b">
                                                <label for="a_textarea" class="lbl_a">Long Details:</label>
                                                <textarea   id="a_textarea" name="pr_long_details" cols="30" rows="10"><?php @print($pr_long_details);?></textarea>
                                            </div>
                                            <div class="sepH_b">
                                                <label for="a_textarea" class="lbl_a">Meta Keywords:</label>
                                                <input   type="text" id="a_text" name="pr_meta_keyword" value="<?php @print($pr_meta_keyword);?>" class="inpt_a" />
                                            </div>
                                            <div class="sepH_b">
                                                <label for="a_textarea" class="lbl_a">Meta Description:</label>
                                                <textarea  id="a_textarea" name="pr_meta_description" cols="30" rows="10"><?php @print($pr_meta_description);?></textarea>
                                            </div>
                                            <br />
											<?php
                                                //if($_REQUEST['action']!=3){
                                            ?>
                                                    <div class="sepH_b">
                                                        <label for="a_text" class="lbl_a">Category:</label>
                                                        <select name="cat_id">
                                                            <?php echo FillSelected2("categories AS c LEFT OUTER JOIN categories_ln AS cl ON c.cat_id=cl.cat_id ", "c.cat_id", "cl.cat_name", $cat_id, " c.cat_parentid=2 AND cl.lang_id=".$_SESSION['lang_id']." ");?>
                                                        </select>
                                                    </div>
                                            <?php		
												if(isset($_REQUEST['pr_id'])){
													$Query = "SELECT DISTINCT pt.*, prf.prf_thumb, prf.prf_file, prf.prf_preview FROM pr_types AS pt LEFT OUTER JOIN pr_files AS prf ON pt.ptype_id=prf.ptype_id WHERE pt.cat_id=2 AND prf.pr_id=".$_REQUEST['pr_id']." ";
												} else {
													$Query = "SELECT DISTINCT pt.* FROM pr_types AS pt WHERE pt.cat_id=2 ";
												}
                                                $counter=0;
                                                $count = mysql_num_rows(mysql_query($Query)); 
                                                $rs = mysql_query($Query);
                                                if($count>0){
                                                    while($row=mysql_fetch_object($rs)){
                                                        $counter++;
                                            ?>
                                              <div class="sepH_b">
                                                  <label for="a_text" class="lbl_a">Thumbnail <?php echo @$counter?>:</label>
                                                  <input type="file" name="tFile[]" class="fileInputs" />
                                              </div>
                                              <div class="sepH_b">
                                                  <label for="a_text" class="lbl_a">File <?php echo @$counter?>:</label>
                                                  <input type="file" name="mFile[]" class="fileInputs" />
                                              </div>
                                              <div class="sepH_b">
                                                  <label for="a_text" class="lbl_a">Preview <?php echo @$counter?>:</label>
                                                  <input type="file" name="pFile[]" class="fileInputs" />
                                              </div>
                                              <div class="sepH_b">
                                                  <label for="a_text" class="lbl_a">Format <?php echo @$counter?>:</label>
                                                  <input type="hidden" name="format[]" value="<?php echo @$row->ptype_value?>" class="inpt_a" disabled="disabled"  />
                                                  <input type="hidden" name="formatID[]" value="<?php echo @$row->ptype_id?>" class="inpt_a" />
                                                  <input type="hidden" name="tfileName[]" value="<?php echo @$row->prf_thumb?>">
                                                  <input type="hidden" name="mfileName[]" value="<?php echo @$row->prf_file?>">
                                                  <input type="hidden" name="pfileName[]" value="<?php echo @$row->prf_preview?>">
                                              </div>
                                              <br />
                                            <?php
														}
													}
												//}
                                            ?>
                                        </fieldset>
                                        <?php
                                            if(isset($_REQUEST['action']) && $_REQUEST['action']==2){
                                        ?>
                                            <input type="submit" name="btnEdit" value="UPDATE" class="submitButton">
                                        <?php
                                            }
                                            else{
                                        ?>
                                              <input type="submit" name="btnAdd" value="ADD" class="submitButton">
                                        <?php
                                            }
                                        ?>
                                        <input type="button" name="btnCancel" value="BACK" class="submitButton" onClick="javascript: window.location= 'manage_movies.php';">
                                    </div>
                                </form>
                            <?php } else{ ?>
                                <div class="sepH_a" align="right">
                                    <a href="<?php print($_SERVER['PHP_SELF']."?action=1");?>" title="Add New">Add New</a>
                                </div>
                                <form name="frm" id="frm" method="post" action="<?php @print($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);?>" enctype="multipart/form-data" onSubmit="return chkRequired(this);">
                                    <table cellpadding="0" cellspacing="0" border="0" class="display" >
                                        <thead>
                                            <tr>
                                                <th class="chb_col"  align="center" width="30"><div class="th_wrapp"><input type="checkbox" name="chkAll" onClick="setAll();"></div></th>
                                                <th><div class="th_wrapp">ID </div></th>
                                                <th><div class="th_wrapp">Name </div></th>
                                                <th><div class="th_wrapp">Rating</div></th>
                                                <th><div class="th_wrapp">Status </div></th>
                                                <th><div class="th_wrapp">Featured </div></th>
                                                <!--<th><div class="th_wrapp">Add Language</div></th>-->
                                                <th><div class="th_wrapp">Action </div></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
											$Query="SELECT p.*, pl.pr_title, pl.pr_short_details, pl.pr_long_details, pl.pr_meta_keyword, pl.pr_meta_description, c.cat_name From products AS p LEFT OUTER JOIN categories AS c ON p.cat_id=c.cat_id LEFT OUTER JOIN products_ln AS pl ON pl.pr_id=p.pr_id AND pl.lang_id=".$_SESSION['lang_id']." WHERE c.cat_parentid=2 ORDER BY p.pr_id";
                                            $counter=0;
                                            $limit = 15;
                                            $start = $p->findStart($limit); 
                                            $count = mysql_num_rows(mysql_query($Query)); 
                                            $pages = $p->findPages($count, $limit); 
                                            $rs = mysql_query($Query." LIMIT ".$start.", ".$limit);
                                            if($count>0){
                                                while($row=mysql_fetch_object($rs)){
                                                    $counter++;
                                        ?>
                                            <tr>
                                                <td class="chb_col" align="center">
                                                    <input type="checkbox" name="chkstatus[]" value="<?php print($row->pr_id);?>" class="inpt_c1" />
                                                </td>
                                                <td align="left"><?php print($row->pr_id);?></td>
                                                <td align="left"><?php print($row->pr_title);?></td>
                                                <!--<td align="left"><?php print($row->cat_name);?></td>-->
                                                <td>
													<?php 
                                                        $total_ratings = 0;
                                                        $total_vots = 0;
                                                        $avg = 0.0;
                                                        $qry1 = mysql_query("SELECT COUNT( 1 ) AS total_records, SUM( rate ) AS total FROM votes WHERE section_id=2 AND pro_id=".$row->pr_id);
                                                        if( mysql_num_rows($qry1)>0 ){
                                                            $row1 = mysql_fetch_object($qry1);
                                                            $total_ratings = $row1->total;
                                                            $total_vots = $row1->total_records;
                                                        }
                                                        if($total_ratings!=0 && $total_vots!=0) {
                                                            $avg = ( $total_ratings / $total_vots );
                                                            $avg = round($avg, 1);
                                                        }
                                                        echo 'Average '.$avg.' of '.$total_vots.' Rating';
                                                    ?>
                                                </td>
                                                <td><?php echo (($row->status_id==1)?"<span class='notification ok_bg'>Active</span>":"<span class='notification alert_bg'>Not Active</span>");?> </td>
                                                <td><?php echo (($row->is_featured==1)?"<span class='notification ok_bg'>Yes</span>":"<span class='notification alert_bg'>No</span>");?> </td>
                                                <!--<td><?php echo (($row->is_home==1)?"<span class='notification ok_bg'>Yes</span>":"<span class='notification alert_bg'>No</span>");?> </td>-->
                                                <!--<td align="center"><a href="manage_movies.php?action=3&pr_id=<?php echo $row->pr_id;?>"> Add </a></td>-->
                                                <td class="content_actions" width="50px">
                                                    <a href="<?php print($_SERVER['PHP_SELF']."?action=2&pr_id=".$row->pr_id);?>" class="sepV_a" title="Edit"><img src="images/icons/pencil.png" /></a>
                                                    <a href="<?php print($_SERVER['PHP_SELF']."?show=1&pr_id=".$row->pr_id);?>" class="sepV_a" title="View"><img src="images/icons/preview.png" /></a>
                                                </td>
                                            </tr>
                                        <?php
                                                }
                                            } else{
                                        ?>
                                                <tr><td colspan="100%" align="center"> No records found. </td></tr>
                                        <?php
                                            }
                                        ?>
                                        </tbody>
                                    </table>
                                    <?php if($counter > 0) {?>
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td><?php print("Page <b>".$_GET['page']."</b> of ".$pages);?></td>
                                                <td align="right">
                                                <?php	
                                                    $next_prev = $p->nextPrev($_GET['page'], $pages, '');
                                                    print($next_prev);
                                                ?>
                                                </td>
                                            </tr>
                                        </table>
                                        <input type="submit" name="active" value="Active" class="submitButton">
                                        <input type="submit" name="nactive" value="In Active" class="submitButton">
                                        <input type="submit" name="featured" value="Featured" class="submitButton">
                                        <input type="submit" name="nfeatured" value="Not Featured" class="submitButton">
                                        <input type="submit" name="resetVotings" value="Reset Rating" class="submitButton">

                                        <!--<input type="submit" name="home" value="Show on Home" class="submitButton">
                                        <input type="submit" name="nhome" value="Not Show on Home" class="submitButton">-->
                                        <a href="#confModal" class="btn btn_c" rel="fancyConf">DELETE</a>
                                        <div style="display:none">
                                            <div id="confModal">
                                                <h4 class="sepH_a">Confirmation</h4>
                                                <div class="fancyQ">
                                                    <p class="sepH_c">Are you sure?</p>
                                                    <p class="tac sepH_b">
                                                        <a href="#" class="btn btn_c fancyYes">Yes</a>
                                                        <a href="#" class="btn btn_a fancyNo">No</a>
                                                    </p>
                                                </div>
                                                <div class="fancyA" style="display:none">
                                                    <p class="sepH_b"><strong class="fancyT"></strong></p>
                                                    <p class="tac sepH_b">
                                                        <a href="#" class="btn btn_bS fancyClose">Close</a>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <span style="visibility:hidden;"><input type="submit" name="btnDelete" id="btnDelete"></span>
                                    <?php }?>
                                </form>
                            <?php } ?>
                        </div>
                    </div>
                </div>
				<?php include("includes/left_side_navigation.php");?>
            </div>
        </div>
    </div>
	<?php include("includes/footer.php");?>
	<script type="text/javascript">
		head.js(
			"js/jquery-1.6.2.min.js",
			"lib/jquery-ui/jquery-ui-1.8.15.custom.min.js",
			"lib/harvesthq-chosen/chosen.jquery.min.js",
			"lib/fusion-charts/FusionCharts.js",
			"lib/fancybox/jquery.easing-1.3.pack.js",
			"lib/fancybox/jquery.fancybox-1.3.4.pack.js",
			"lib/file-uploader/fileuploader.js",
			"lib/tiny-mce/jquery.tinymce.js",
			"js/jquery.microaccordion.js",
			"js/jquery.tools.min.js",
			"js/jquery.stickyPanel.js",
			"js/xbreadcrumbs.js",
			"lib/jquery-validation/jquery.validate.js",
			"lib/styled-checkboxes/iphone-style-checkboxes.js",
			"lib/jquery-raty/jquery.raty.min.js",
			"lib/timepicker-addon/jquery-ui-timepicker-addon.js",
			"js/lagu.js",
			"lib/datatables/jquery.dataTables.min.js",
			"lib/datatables/dataTables.plugins.js",
			function(){
				lga_selectBox.init();
				lga_datepicker.init();
				lga_datepicker_inline.init();
				lga_editor_default.init();
				lga_clearForm.init();
				lga_styledCheckboxes.init();
				lga_uiSliders.init();
				lga_uiProgressBar.init();
				lga_rating.init();
				lga_timepicker.init();
				lga_form_a_validation.init();
				lga_form_b_validation.init();
				lga_formSubmit.init();
				lga_dataTables.lga_contentTable();

				$('.chSel_all').click(function () {
					$(this).closest('table').find('input[name=row_sel]').attr('checked', this.checked);
				});
				$(".delete_all_simple").click(function () {
					$('input[name=row_sel]:checked', '.smpl_tbl').closest('tr').fadeTo(600, 0, function () {
						$(this).remove();
						$('.chSel_all','.smpl_tbl').attr('checked',false);
					});
					return false;
				});
				$('.delete_all_dt').click( function() {
					oTable = $('#data_table').dataTable();
					$('input[@name=row_sel]:checked', oTable.fnGetNodes()).closest('tr').fadeTo(600, 0, function () {
						oTable.fnDeleteRow( this );
						$('.chSel_all','#data_table').attr('checked',false);
						return false;
					});
				});
				$('#data_table').dataTable({
					"aaSorting": [[ 1, "asc" ]],
					"aoColumns": [
						{ "bSortable": false },
						null,
						null,
						{ "bSortable": false },
						{ "bSortable": false }
					]
				});
				
				//confirmation dialog
				$("a[rel='fancyConf']").fancybox({
					'transitionIn'	: 'fade',
					'autoDimensions'	: true,
					'showCloseButton'	: false,
					'overlayOpacity'	: '0',
					'hideOnOverlayClick': false,
					'onClosed'	: function() {
						$('.fancyA').hide();
						$('.fancyQ').show();
					}
				});
				$('.fancyClose').click(function(){
					$.fancybox.close();
					return false;
				});
				$('.fancyQ a').click(function(){
					var thisTxt = $(this).text();
					if(thisTxt == 'Yes'){
						if (Checkbox("frm", 'chkstatus[]') == false){
							$('.fancyT').text("You must check atleast one check box");
							$('.fancyQ').slideUp('fast');
							$('.fancyA').slideDown('fast');
							$.fancybox.resize();
							return (false);
						}
						$.fancybox.close();
						$("#btnDelete").click();
						//$("#frm").submit();
						return (true);
					} else {
						$.fancybox.close();
					}
				});				

				$("a[rel='fancyReg']").click(function(){
					if (Checkbox("frm", 'chkstatus[]') == false){
						$("a[rel='fancyReg']").fancybox({
							'transitionIn'	: 'elastic',
							'width'				: 300,
							'height'			: 150,
							'autoDimensions'	: false,
							'overlayOpacity'	: '0',
							'hideOnOverlayClick': false
						});
						return false;
					}
					return true;
				});
			}
		)
	</script>
</body>
</html>