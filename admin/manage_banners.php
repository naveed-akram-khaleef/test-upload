<?php
ob_start();
session_start();
include("../lib/openCon.php");
include("../lib/functions.php");
if(!isset($_SESSION['UID'])){
	header("Location: login.php");
}
include("includes/php_includes_top.php");
$msg_class='';
$strMSG = "";
$FormHead = "";
include("../lib/class.pager1.php");
$p = new Pager1;

if(isset($_REQUEST['btnAdd'])){
	$ban_id = getMaximum("banners","ban_id");
	$mfileName = "";
	$dirName = "../files/banners/";
	if (!empty($_FILES["mFile"]["name"])){
		$mfileName = $ban_id."_".$_FILES["mFile"]["name"];
		if(move_uploaded_file($_FILES['mFile']['tmp_name'], $dirName.$mfileName)){
			createThumbnail2($dirName, $mfileName, $dirName."th/", "250", "250");
		}
	}
	mysql_query("INSERT INTO banners (ban_id, ban_name, ban_file) VALUES (".$ban_id.",'".$_REQUEST['ban_name']."', '".$mfileName."')");
	header("Location: manage_banners.php?op=1");
}
elseif(isset($_REQUEST['btnEdit'])){
	$dirName = "../files/banners/";
	$mfileName = $_REQUEST['mfileName'];
	if (!empty($_FILES["mFile"]["name"])){
		@unlink("../files/banners/".$_REQUEST['mfileName']);
		@unlink("../files/banners/th/".$_REQUEST['mfileName']);
		$mfileName = $_REQUEST['ban_id']."_".$_FILES["mFile"]["name"];
		if(move_uploaded_file($_FILES['mFile']['tmp_name'], $dirName.$mfileName)) {
			createThumbnail2($dirName, $mfileName, $dirName."th/", "250", "250");
		}
	}
mysql_query("UPDATE banners SET ban_name='".$_REQUEST['ban_name']."', ban_file='".$mfileName."' WHERE ban_id=".$_REQUEST['ban_id']);
	header("Location: manage_banners.php?op=2");}
elseif(isset($_REQUEST['action'])){
	if($_REQUEST['action'] == 2){
		$FormHead = "Edit Details";
		$grs = mysql_query("SELECT * FROM banners WHERE ban_id = ".$_REQUEST['ban_id']);
		if(mysql_num_rows($grs) > 0){
			$grow = mysql_fetch_object($grs);
			$ban_name	= $grow->ban_name;
			$ban_title	= $grow->ban_title;
			$mfileName  = $grow->ban_file;
		}
	}
	else{
		$FormHead = "Add Details ";
		if(!isset($_REQUEST['btnAdd'])){
			$ban_name	= "";
			$ban_title	= "";
			$mfileName  = "";
		}
	}
}

if(isset($_REQUEST['btnActive'])){
	for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
		mysql_query("UPDATE banners SET status_id = 1 WHERE ban_id = ".$_REQUEST['chkstatus'][$i]);
	}
	$msg_class='msg_box msg_ok';
	$strMSG = "Record(s) updated successfully";
}
if(isset($_REQUEST['btnInactive'])){
	for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
		mysql_query("UPDATE banners SET status_id = 0 WHERE ban_id = ".$_REQUEST['chkstatus'][$i]);
	}
	$msg_class='msg_box msg_ok';
	$strMSG = "Record(s) updated successfully";
}
if(isset($_REQUEST['btnDelete'])){ 
	if(isset($_REQUEST['chkstatus'])){
		for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
			DeleteFileWithThumb("ban_file", "banners", "ban_id", $_REQUEST['chkstatus'][$i], "../images/banners/", "../images/banners/th/");
			mysql_query("DELETE FROM banners WHERE ban_id = ".$_REQUEST['chkstatus'][$i]);
		}
		$msg_class='msg_box msg_ok';
		$strMSG = "Record(s) deleted successfully";
	}
	else{
		$msg_class='msg_box msg_alert';
		$strMSG = "Please check atleast one checkbox";
	}
}
if(isset($_REQUEST["op"])){
	switch ($_REQUEST["op"]) {
		case 1:
			$msg_class='msg_box msg_ok';
			$strMSG = "Record Added Successfully";
			break;
		case 2:
			$msg_class='msg_box msg_ok';
			$strMSG = "Record Updated Successfully";
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
                                <h1 class="sepH_c">Banners Management</h1>


					<?php
						if(isset($_REQUEST['action']) == 1){
					?>
                    <form name="form" method="post" action="<?php @print($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);?>" enctype="multipart/form-data">
                        <div class="formEl_a">
                            <fieldset class="sepH_b">
                                <legend><?php print($FormHead);?></legend>
                                <div class="sepH_b">
                                    <label for="a_text" class="lbl_a">Name:</label>
                                    <input type="text" id="a_text" name="ban_name" value="<?php print($ban_name);?>"  class="inpt_a" />
                                </div>
                                <!--<div class="sepH_b">
                                    <label for="a_text" class="lbl_a">Title (alt):</label>
                                    <input type="text" id="a_text" name="ban_title" value="<?php print($ban_title);?>"  class="inpt_a" />
                                </div>-->
                                <div class="sepH_b">
                                    <label for="a_text" class="lbl_a">File:</label>
                                    <input type="file" name="mFile" class="fileInputs" />
                                </div>   
                            </fieldset>

                            <input type="hidden" name="action" value="<?php print($_REQUEST['action']);?>">
                            <?php
								if($_REQUEST['action'] == 2){
							?>
                            		<input type="hidden" name="mfileName" value="<?php print($mfileName);?>">
                              		<input name="btnEdit" type="submit" class="submitButton" value="SUBMIT">
							<?php	
								}
								else{
							?>
									<input name="btnAdd" type="submit" class="submitButton" value="SUBMIT">
							<?php
								}
							?>
                            <input name="btnCancel" type="button" class="submitButton" value="BACK" onClick="javascript: window.location = 'manage_banners.php';">
                    
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
                                <th class="chb_col"  align="center" width="30"><div class="th_wrapp"><input type="checkbox" name="chkAll" onClick="setAll();"></div></th>
                                <th><div class="th_wrapp">Name </div></th>
                                <!--<th><div class="th_wrapp">Title </div></th>-->
                                <th><div class="th_wrapp">Banner Image </div></th>
                                <th><div class="th_wrapp">Status</div></th>
                                <th><div class="th_wrapp">Actions </div></th>
                            </tr>
                        </thead>
                        <tbody>
						<?php
							$Query = "SELECT * FROM banners ORDER BY ban_id";
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
                                <td class="chb_col" align="center"><input type="checkbox" name="chkstatus[]" value="<?php print($row->ban_id);?>" class="inpt_c1" /><input type="hidden" name="imgFile_<?php print($row->ban_id);?>" value="<?php print($row->ban_file);?>"></td>
                                <td><?php print($row->ban_name);?> </td>
                                <!--<td><?php print($row->ban_title);?> </td>-->
                                <td><img src="../files/banners/th/<?php print($row->ban_file);?>" width="40" height="40" alt="<?php print($row->ban_title);?>" border="0"> </td>
                                <td><?php echo (($row->status_id==1)?"<span class='notification ok_bg'>Active</span>":"<span class='notification alert_bg'>Not Active</span>");?> </td>
                                <td class="content_actions" width="70px"><a href="<?php print($_SERVER['PHP_SELF']."?action=2&ban_id=".$row->ban_id);?>" class="sepV_a" title="Edit">
<img src="images/icons/pencil_gray.png" alt="" />
</a> </td>
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
                            <input type="submit" name="btnActive" value="ACTIVE" class="submitButton">
                            <input type="submit" name="btnInactive" value="INACTIVE" class="submitButton">
            
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