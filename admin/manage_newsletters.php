<?php
ob_start();
include("../lib/openCon.php");
include("../lib/functions.php");
include("../lib/functions_main.php");
session_start();
if(!isset($_SESSION['UID'])){
	header("location: login.php");
}
include("includes/php_includes_top.php");
include("../lib/class.pager1.php");
$p = new Pager1;
$msg_class='';
$strMSG = "";
$FormHead = "";

if(isset($_REQUEST['send_msg'])){
	/*$Query = mysql_query("SELECT DISTINCT n.nletters_title, n.nletters_subject, n.nletters_details, s.sub_email, s.sub_name FROM newsletters AS n, subscribers AS s WHERE n.nletters_id='".$_REQUEST["msg_id"]."' ");
	while($row=mysql_fetch_object($Query)){
		$nw_email = $row->sub_email;
		$nw_name  = $row->sub_name;
		$nw_title   = $row->nletters_title;
		$nw_subject = $row->nletters_subject;
		$nw_details = $row->nletters_details;*/
		
		//mailToAllSubscribers($nw_name, $nw_email, $nw_title, $nw_subject, $nw_details);
	//}
	mysql_query("UPDATE newsletters SET nletters_sent_date=now(), status_id=1 WHERE nletters_id='".$_REQUEST["msg_id"]."' ");
	header("Location: manage_newsletters.php?op=3");
}

if(isset($_REQUEST['btnEdit'])){
	mysql_query("UPDATE newsletters SET nletters_title='".$_REQUEST['title']."', nletters_subject='".$_REQUEST['subject']."', nletters_details='".$_REQUEST['details']."' WHERE nletters_id=".$_REQUEST['nws_id']) or die(mysql_error());
	header("Location: manage_newsletters.php?op=2");
}
if(isset($_REQUEST['btnAdd'])){
	$maxID = getMaximum("newsletters","nletters_id");
	mysql_query("INSERT INTO newsletters (nletters_id, nletters_title, nletters_subject, nletters_details) VALUES ('".$maxID."', '".$_REQUEST['title']."', '".$_REQUEST['subject']."', '".$_REQUEST['details']."')");
	header("Location: manage_newsletters.php?op=1");
}
if(isset($_REQUEST['show'])){
	$FormHead = "Content Details";
}
elseif(isset($_REQUEST['action'])){
	if($_REQUEST['action'] == 2){
		$FormHead = "Edit Details";
		$rs = mysql_query("SELECT * FROM newsletters WHERE nletters_id = ".$_REQUEST['nws_id']);
		if(mysql_num_rows($rs) > 0){
			$row = mysql_fetch_object($rs);
			$title = $row->nletters_title;
			$subject = $row->nletters_subject;
			$details = $row->nletters_details;
		}
	}
	if($_REQUEST['action'] == 1){
		$FormHead = "Add Details";
		$title = "";
		$subject = "";
		$details = "";
	}
}
if(isset($_REQUEST['btnDelete'])){ 
	if(isset($_REQUEST['chkstatus'])){
		for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
			mysql_query("DELETE FROM newsletters WHERE nletters_id = ".$_REQUEST['chkstatus'][$i]);
		}
		$msg_class='msg_box msg_ok';
		$strMSG = "Deleted successfully";
	}
	else{
		$msg_class='msg_box msg_error';
		$strMSG = "Please check atleast one checkbox";
	}
}
if(isset($_REQUEST["op"])){
	switch ($_REQUEST["op"]) {
		case 1:
			$msg_class='msg_box msg_ok';
			$strMSG = "Added Successfully";
			break;
		case 2:
			$msg_class='msg_box msg_ok';
			$strMSG = "Updated Successfully";
			break;
		case 3:
			$msg_class='msg_box msg_ok';
			$strMSG = "Message Was Send To All Subscribers Successfully";
			break;
	}
}
include("../fckeditor/fckeditor.php");
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
						<?php if($msg_class!=''){?>
                            <div class="<?php echo $msg_class;?>"><?php echo $strMSG;?><img src="images/blank.gif" class="msg_close" alt="" /></div>
                        <?php }?>
                            <div class="sepH_c">
							<h1 class="sepH_c">Newsletters Management</h1>

					<?php
						if(isset($_REQUEST['show'])){
					?>	
            <div class="formEl_a">
                <fieldset class="sepH_b">
                    <legend>Details</legend>
                    	<table cellpadding="0" cellspacing="0" border="0" class="table_a smpl_tbl">
                    <?php    
							$Query = "SELECT n.* FROM newsletters AS n WHERE n.nletters_id='".$_REQUEST["id"]."' LIMIT 1";
							$rs = mysql_query($Query);
							if(mysql_num_rows($rs)>0){
								while($row=mysql_fetch_object($rs)){	
					?>
							<tr>
								<td>Title:</td>
								<td><?php print($row->nletters_title);?></td>
							</tr>
							<tr>
								<td>Subject:</td>
								<td><?php print($row->nletters_subject);?></td>
							</tr>
							<tr>
								<td>Status:</td>
								<td>
									<?php 
                                        echo (($row->status_id==1)?
                                        "<span class='notification ok_bg'>Delivered</span>":
                                        "<span class='notification error_bg'>Pending</span>");
                                    ?>                                
                                </td>
							</tr>
							<tr>
								<td>Send Date:</td>
								<td><?php print($row->nletters_sent_date);?></td>
							</tr>
							<tr>
								<td>Message Details:</td>
								<td><?php print($row->nletters_details);?></td>
							</tr>
							<?php
                                    }
                                }
                                else{	
                            ?>
                                    <tr><td colspan="20" align="center" class="ListRow1">No Record Found.</td></tr>
                            <?php
                                }
                            ?>
                        </table>
                    </fieldset>
                </div>
                <input type="button" name="btnCancel" class="submitButton" value="BACK" onClick="javascript: window.location= 'manage_newsletters.php';">            

					<?php
						} else
						if(isset($_REQUEST['action'])){
					?>
  
                        <form name="form" id="validateFormData" method="post" action="<?php @print($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);?>" enctype="multipart/form-data">
							<div class="formEl_a">
								<fieldset class="sepH_b">
									<legend><?php print($FormHead);?></legend>
									<div class="sepH_b">
										<label for="a_text" class="lbl_a">Title:</label>
										<input type="text" id="a_text" name="title" value="<?php print($title);?>" class="inpt_a required" />
									</div>
									<div class="sepH_b">
										<label for="a_text" class="lbl_a">Subject:</label>
										<input type="text" id="a_text" name="subject" value="<?php print($subject);?>" class="inpt_a" />
									</div>
									<div class="sepH_b">
										<label for="a_textarea" class="lbl_a">Message Details:</label>
                                         <textarea id="a_textarea" name="details"  cols="30" rows="10" style="resize:none;"><?php print $details;?></textarea>
									</div>
								</fieldset>
    
									<input type="hidden" name="action" value="<?php print($_REQUEST['action']);?>">
									<?php
                                        if($_REQUEST['action'] == 2){
                                    ?>
                                            <input type="submit" name="btnEdit" class="submitButton" value="UPDATE" />
                                    <?php	
                                        }
                                        else{
                                    ?>
                                            <input type="submit" name="btnAdd" class="submitButton" value="ADD" />
                                    <?php
                                        }
                                    ?>
                                    <input type="button" name="btnCancel" class="submitButton" value="BACK" onClick="javascript: window.location= 'manage_newsletters.php';">
							</div>
						</form>                  
	
                    <?php
						}
						else{
					?>

                        <div class="sepH_a" align="right">
                            <a href="<?php print($_SERVER['PHP_SELF']."?action=1");?>" title="Add New">Add New</a>
                        </div>

                         <form name="frm" id="frm" method="post" action="<?php @print($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);?>" enctype="multipart/form-data" onSubmit="return chkRequired(this);">
							<table cellpadding="0" cellspacing="0" border="0" class="display" id="">
								<thead>
									<tr>
<!--                                        <th width="30"><div class="th_wrapp"><input type="checkbox" name="chkAll" onClick="setAll();"></div></th>
-->                                        <th><div class="th_wrapp">Title</div></th>
                                        <th><div class="th_wrapp">Subject</div></th>
                                        <th><div class="th_wrapp">Status</div></th>
                                        <th><div class="th_wrapp">Send Date</div></th>
                                        <th><div class="th_wrapp">Actions</div></th>
									</tr>
								</thead>
								<tbody>
								<?php
									$Query = "SELECT n.*, s.status_name FROM newsletters AS n LEFT OUTER JOIN status AS s ON n.status_id=s.status_id ORDER BY n.nletters_id DESC";
									$counter=0;
									$limit = 25;
									$start = $p->findStart($limit); 
									$count = mysql_num_rows(mysql_query($Query)); 
									$pages = $p->findPages($count, $limit); 
									$rs = mysql_query($Query." LIMIT ".$start.", ".$limit);
									if(mysql_num_rows($rs)>0){
										while($row=mysql_fetch_object($rs)){	
											$counter++;
                                ?>
                                    <tr>
<!--                                        <td class="chb_col" align="center"><input type="checkbox" name="chkstatus[]" value="<?php print($row->nletters_id);?>" class="inpt_c1" /></td>
-->                                        <td><a href="manage_newsletters.php?show&id=<?php echo $row->nletters_id;?>"><?php echo $row->nletters_title;?></a></td>
                                        <td><?php echo $row->nletters_subject;?></td>
                                        <td>
											<?php 
                                                echo (($row->status_id==1)?
                                                "<span class='notification ok_bg'>Delivered</span><br/><br/>
                                                 <a href='manage_newsletters.php?send_msg=1&msg_id=$row->nletters_id'>Send Again</a>":
                                                "<span class='notification error_bg'>Pending</span><br/><br/>
                                                 <a href='manage_newsletters.php?send_msg=1&msg_id=$row->nletters_id'>Send Now</a>");
                                            ?>
                                        </td>
                                        <td><?php echo (($row->nletters_sent_date=='')?"<span class='notification error_bg'>Not Send Yet</span>":$row->nletters_sent_date);?>
                                        <td class="content_actions" width="70px">
                                            <a href="<?php print($_SERVER['PHP_SELF']."?nws_id=".$row->nletters_id."&udt=1&action=2");?>" class="sepV_a" title="Edit">
                                                <img src="images/icons/pencil_gray.png" alt="" />
                                            </a>
                                            <a href="<?php print($_SERVER['PHP_SELF']."?btnDelete=1&chkstatus[]=".$row->nletters_id);?>" title="Delete" onClick="javascript: return confirm('Are you sure you want to delete this record');">
                                                <img src="images/icons/trashcan_gray.png" alt="" />
                                            </a>
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
						null,
						null,
						null,
						null,
						{ "bSortable": false }
					]
				});
			}
		)
	</script>
</body>
</html>