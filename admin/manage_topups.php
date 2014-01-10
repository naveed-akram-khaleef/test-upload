<?php
ob_start();
include("../lib/openCon.php");
include("../lib/functions.php");
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
if(isset($_REQUEST['btnAdd'])){
	$MaxID = getMaximum("topups","tup_id");
	mysql_query("INSERT INTO topups (tup_id, tup_name, tup_fee, tup_videos_downloads, tup_videos_streams, tup_audios_downloads, tup_audios_streams, tup_wallpapers_downloads, tup_ringtones_downlaods, tup_gifts) VALUES('".$MaxID."', '".$_REQUEST['tup_name']."', '".$_REQUEST['tup_fee']."', '".$_REQUEST['tup_videos_downloads']."', '".$_REQUEST['tup_videos_streams']."', '".$_REQUEST['tup_audios_downloads']."', '".$_REQUEST['tup_audios_streams']."', '".$_REQUEST['tup_wallpapers_downloads']."', '".$_REQUEST['tup_ringtones_downlaods']."', '".$_REQUEST['tup_gifts']."')") or die(mysql_error());
	header("Location: manage_topups.php?op=2");
}
if(isset($_REQUEST['btnEdit'])){
	mysql_query(" UPDATE topups SET tup_name='".$_REQUEST['tup_name']."', tup_fee='".$_REQUEST['tup_fee']."', tup_videos_downloads='".$_REQUEST['tup_videos_downloads']."', tup_videos_streams='".$_REQUEST['tup_videos_streams']."', tup_audios_downloads='".$_REQUEST['tup_audios_downloads']."', tup_audios_streams='".$_REQUEST['tup_audios_streams']."', tup_wallpapers_downloads='".$_REQUEST['tup_wallpapers_downloads']."', tup_ringtones_downlaods='".$_REQUEST['tup_ringtones_downlaods']."', tup_gifts='".$_REQUEST['tup_gifts']."' WHERE tup_id=".$_REQUEST['tup_id']." ") or die(mysql_error());
	header("Location: manage_topups.php?op=3");
} elseif(isset($_REQUEST['action'])){
	$tup_id = '';
	$tup_name = '';
	$tup_fee = '';
	$tup_videos_downloads = '';
	$tup_videos_streams = '';
	$tup_audios_downloads = '';
	$tup_audios_streams = '';
	$tup_wallpapers_downloads = '';
	$tup_ringtones_downlaods = '';
	$tup_gifts = '';
	$form_head = "Add New";
	if($_REQUEST['action'] == 2){
		$rs = mysql_query("SELECT * FROM topups WHERE tup_id=".$_REQUEST['tup_id']);
		if(mysql_num_rows($rs)>0){
			$row=mysql_fetch_object($rs);
			$tup_id = $row->tup_id;
			$tup_name = $row->tup_name;
			$tup_fee = $row->tup_fee;
			$tup_videos_downloads = $row->tup_videos_downloads;
			$tup_videos_streams = $row->tup_videos_streams;
			$tup_audios_downloads = $row->tup_audios_downloads;
			$tup_audios_streams = $row->tup_audios_streams;
			$tup_wallpapers_downloads = $row->tup_wallpapers_downloads;
			$tup_ringtones_downlaods = $row->tup_ringtones_downlaods;
			$tup_gifts = $row->tup_gifts;
			$form_head = "Edit Details";
		}
	}
}
if(isset($_REQUEST['btnDelete'])){
	for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
		mysql_query("DELETE FROM topups WHERE tup_id = ".$_REQUEST['chkstatus'][$i]);
	}
	$msg_class='msg_box msg_ok';
	$strMSG = "Record(s) updated successfully";
}
if(isset($_REQUEST['op'])){
	switch ($_REQUEST['op']) {
		case 1:
			$msg_class='msg_box msg_ok';
			$strMSG = "Password Changed successfully";
			break;
		case 2:
			$msg_class='msg_box msg_ok';
			$strMSG = "Added Successfully";
			break;
		case 3:
			$msg_class='msg_box msg_ok';
			$strMSG = "Updated Successfully";
			break;
	}
}

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
                            <div class="sepH_c">
                                <h1 class="sepH_c">Topups Management</h1>

								<?php if(isset($_REQUEST['reset'])){ ?>
                                <?php }else if(isset($_REQUEST['show'])){ ?>
                                    <div class="formEl_a">
                                    <fieldset class="sepH_b">
                                    <legend>Details</legend>
                                        <table cellpadding="0" cellspacing="0" border="0" class="table_a smpl_tbl">
                                        <?php
                                            $strQry = "SELECT tup.* FROm topups AS tup WHERE tup.tup_id=".$_REQUEST['tup_id']." ";
                                            $rs = mysql_query($strQry);
                                            if(mysql_num_rows($rs)>0){
                                                $row=mysql_fetch_object($rs);
                                        ?>
                                            <tr>
                                                <td width="150" align="right">Name:</td>
                                                <td width="400" align="left" style="padding-left:4px;padding-right:4px;"><?php print($row->tup_name);?></td>
                                            </tr>
                                            <tr>
                                                <td align="right">Fee:</td>
                                                <td align="left" style="padding-left:4px;padding-right:4px;"><?php echo $row->tup_fee;?></td>
                                            </tr>
                                            <tr>
                                                <td align="right">Video Downloads:</td>
                                                <td align="left" style="padding-left:4px;padding-right:4px;"><?php echo $row->tup_videos_downloads;?></td>
                                            </tr>
                                            <tr>
                                                <td align="right">Video Streams:</td>
                                                <td align="left" style="padding-left:4px;padding-right:4px;"><?php echo $row->tup_videos_streams;?></td>
                                            </tr>
                                            <tr>
                                                <td align="right">Audio Downloads:</td>
                                                <td align="left" style="padding-left:4px;padding-right:4px;"><?php echo $row->tup_audios_downloads;?></td>
                                            </tr>
                                            <tr>
                                                <td align="right">Audio Streams:</td>
                                                <td align="left" style="padding-left:4px;padding-right:4px;"><?php echo $row->tup_audios_streams;?></td>
                                            </tr>
                                            <tr>
                                                <td align="right">Wallpaper Downloads:</td>
                                                <td align="left" style="padding-left:4px;padding-right:4px;"><?php echo $row->tup_wallpapers_downloads;?></td>
                                            </tr>
                                            <tr>
                                                <td align="right">Ringtone Downloads:</td>
                                                <td align="left" style="padding-left:4px;padding-right:4px;"><?php echo $row->tup_ringtones_downlaods;?></td>
                                            </tr>
                                            <tr>
                                                <td align="right">Gifts:</td>
                                                <td align="left" style="padding-left:4px;padding-right:4px;"><?php echo $row->tup_gifts;?></td>
                                            </tr>
                                        <?php
                                            } else {
                                        ?>
                                            <tr>
                                                <tr><td colspan="100%" align="center" class="ListRow1">No Record Found</td></tr>
                                            </tr>
                                        <?php
                                            }
                                        ?>
                                
                                        </table>
                                    </fieldset>
                                </div>
                                    <?php if(isset($_REQUEST['pg'])){ ?>
                                        <input type="button" name="btnCancel" class="submitButton" value="BACK" onClick="javascipt:window.location='manage_order.php';">
                                    <?php } else{ ?>
                                        <input type="button" name="btnCancel" class="submitButton" value="BACK" onClick="javascipt:window.location='manage_topups.php';">
                                    <?php } ?>
                                <?php } else if(isset($_REQUEST['action'])) {?>

									<form id="validateFormData" class="table-form" method="post" action="<?php echo $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'];?>">
                                        <div class="formEl_a">
                                            <fieldset class="sepH_b">
                                                <legend><?php print($form_head);?></legend>
                                                <div class="sepH_b">
                                                    <label for="mem_login" class="lbl_a">Name</label>
                                                    <input type="text" class="inpt_a required" id="tup_name" name="tup_name" value="<?php echo $tup_name;?>" />
                                                </div>
                                                <div class="sepH_b">
                                                    <label for="mem_password" class="lbl_a">Fee</label>
                                                    <input type="text" class="inpt_a required" id="tup_fee" name="tup_fee" value="<?php echo $tup_fee;?>" />
                                                </div>
                                                <div class="sepH_b">
                                                    <label for="tup_videos_downloads" class="lbl_a">Video Downloads</label>
                                                    <input type="text" class="inpt_a" id="tup_videos_downloads" name="tup_videos_downloads" value="<?php echo $tup_videos_downloads;?>" />
                                                </div>
                                                <div class="sepH_b">
                                                    <label for="tup_videos_streams" class="lbl_a">Video Streams</label>
                                                    <input type="text" class="inpt_a" id="tup_videos_streams" name="tup_videos_streams" value="<?php echo $tup_videos_streams;?>" />
                                                </div>
                                                <div class="sepH_b">
                                                    <label for="tup_audios_downloads" class="lbl_a">Audio Downloads</label>
                                                    <input type="text" class="inpt_a" id="tup_audios_downloads" name="tup_audios_downloads" value="<?php echo $tup_audios_downloads;?>" />
                                                </div>
                                                <div class="sepH_b">
                                                    <label for="tup_audios_streams" class="lbl_a">Audio Streams</label>
                                                    <input type="text" class="inpt_a required" id="tup_audios_streams" name="tup_audios_streams" value="<?php echo $tup_audios_streams;?>" />
                                                </div>
                                                <div class="sepH_b">
                                                    <label for="tup_wallpapers_downloads" class="lbl_a">Wallpaper Downloads</label>
                                                    <input type="text" class="inpt_a required" id="tup_wallpapers_downloads" name="tup_wallpapers_downloads" value="<?php echo $tup_wallpapers_downloads;?>" />
                                                </div>
                                                <div class="sepH_b">
                                                    <label for="tup_ringtones_downlaods" class="lbl_a">Ringtone Downloads</label>
                                                    <input type="text" class="inpt_a required" id="tup_ringtones_downlaods" name="tup_ringtones_downlaods" value="<?php echo $tup_ringtones_downlaods;?>" />
                                                </div>
                                                <div class="sepH_b">
                                                    <label for="tup_gifts" class="lbl_a">Gifts</label>
                                                    <input type="text" class="inpt_a required" id="tup_gifts" name="tup_gifts" value="<?php echo $tup_gifts;?>" />
                                                </div>
                                              </fieldset>
                                              <?php if($_REQUEST['action'] == 2) {?>
                                                <input type="submit" name="btnEdit" value="Update" class="submitButton">
                                              <?php } else { ?>
                                                <input type="submit" name="btnAdd" value="Add" class="submitButton">
                                              <?php } ?>
                                              <input type="button" value="Cancel" class="submitButton" onClick="javascript: window.location= '<?php echo @$_SERVER['HTTP_REFERER'];?>';">
                                              </div>
                                            </form>
                                <?php } else {?>
									<div style="float:right; width:100px; text-align:right;"><a href="<?php print($_SERVER['PHP_SELF']."?action=1");?>" rel="tooltip" title="Add New Record">Add New</a></div>
                                    <form name="frm" id="frm" method="post" action="<?php @print($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);?>" enctype="multipart/form-data" onSubmit="return chkRequired(this);">
                                        <table cellpadding="0" cellspacing="0" border="0" class="display">
                                            <thead>
                                                <tr>
                                                    <th class="chb_col"  align="center" width="30"><div class="th_wrapp"><input type="checkbox" name="chkAll" onClick="setAll();"></div></th>
<th><div class="th_wrapp">Name</div></th>
<th><div class="th_wrapp">Price</div></th>
<th><div class="th_wrapp">Audio Downloads</div></th>
<th><div class="th_wrapp">Video Downloads</div></th>
<th><div class="th_wrapp">Ringtone Downloads</div></th>
<th><div class="th_wrapp">Wallpaper Downloads</div></th>
<th><div class="th_wrapp">Actions</div></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                $Query = "SELECT * FROM topups";
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
                                              <td class="chb_col" align="center"><input type="checkbox" name="chkstatus[]" value="<?php print($row->tup_id);?>" class="inpt_c1" /></td>
                                              <td  style="padding-left:4px;padding-right:4px;"><a href="<?php print($_SERVER['PHP_SELF']);?>?show=1&tup_id=<?php print($row->tup_id);?>" title="View Details"><?php print($row->tup_name);?></a></td>
                                              <td align="left"><?php print($row->tup_fee);?></td>
                                              <td align="left"><?php print($row->tup_audios_downloads);?></td>
                                              <td align="left"><?php print($row->tup_videos_downloads);?></td>
                                              <td align="left"><?php print($row->tup_ringtones_downlaods);?></td>
                                              <td align="left"><?php print($row->tup_wallpapers_downloads);?></td>
                                              <td class="content_actions" width="10px">
                                              <a href="<?php print($_SERVER['PHP_SELF']."?action=2&tup_id=".$row->tup_id);?>" class="sepV_a" title="EDIT"><img src="images/icons/pencil_gray.png" alt="EDIT" /></a>
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
													$next_prev = $p->nextPrev($_GET['page'], $pages, ((isset($_REQUEST['dg_id'])?"&dg_id=".$_REQUEST['dg_id']:'')).((isset($_REQUEST['memid'])?"&memid=".$_REQUEST['memid']:'')));
													print($next_prev);
												?>
												</td>
											</tr>
										</table>
                                        <?php }?>
                                        
										<?php if($counter != 0){?>
                                        
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
                                <?php }?>

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
						null,
						null,
						null,
						{ "bSortable": false },
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
						$("#frm").submit();
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