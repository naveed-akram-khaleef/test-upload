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
	$chk = IsExist("cnt_id", "contents", "cnt_heading", $_REQUEST['cnt_heading']);
	if ($chk == 1){
		header("Location: manage_content.php?op=3");
	} else {
		$MaxID = getMaximum("contents","cnt_id");
		$strQRY1="INSERT INTO contents (cnt_id, cnt_heading, cnt_details, cnt_title, cnt_description, cnt_keywords) VALUES(".$MaxID.", '".str_replace("'", "''", $_REQUEST['cnt_heading'])."', '".str_replace("'", "''", $_REQUEST['cnt_details'])."', '".str_replace("'", "''", $_REQUEST['cnt_title'])."', '".str_replace("'", "''", $_REQUEST['cnt_description'])."', '".str_replace("'", "''", $_REQUEST['cnt_keywords'])."')";
		$nRst=mysql_query($strQRY1) or die(mysql_error());
		$strQRY2="INSERT INTO contents_ln (cnt_id, lang_id, cnt_heading, cnt_details, cnt_title, cnt_description, cnt_keywords) VALUES(".$MaxID.", ".$_SESSION['lang_id'].", '".str_replace("'", "''", $_REQUEST['cnt_heading'])."', '".str_replace("'", "''", $_REQUEST['cnt_details'])."', '".str_replace("'", "''", $_REQUEST['cnt_title'])."', '".str_replace("'", "''", $_REQUEST['cnt_description'])."', '".str_replace("'", "''", $_REQUEST['cnt_keywords'])."')";
		$nRst=mysql_query($strQRY2) or die(mysql_error());
		header("Location: manage_content.php?op=1");
	}
}
else if(isset($_REQUEST['btnEdit'])){
	$chk = chkExist("cnt_id", "contents_ln", "WHERE cnt_id=".$_REQUEST['cnt_id']." AND lang_id=".$_SESSION["lang_id"]);
	if($chk > 0){
		mysql_query("UPDATE contents_ln SET cnt_heading='".str_replace("'", "''", $_REQUEST['cnt_heading'])."', cnt_details='".str_replace("'", "''", $_REQUEST['cnt_details'])."', cnt_title='".str_replace("'", "''", $_REQUEST['cnt_title'])."', cnt_description='".str_replace("'", "''", $_REQUEST['cnt_description'])."', cnt_keywords='".str_replace("'", "''", $_REQUEST['cnt_keywords'])."' WHERE cnt_id=".$_REQUEST['cnt_id']." AND lang_id=".$_SESSION['lang_id']." ");
	}
	else{
		$strQRY2="INSERT INTO contents_ln (cnt_id, lang_id, cnt_heading, cnt_details, cnt_title, cnt_description, cnt_keywords) VALUES(".$_REQUEST['cnt_id'].", ".$_SESSION['lang_id'].", '".str_replace("'", "''", $_REQUEST['cnt_heading'])."', '".str_replace("'", "''", $_REQUEST['cnt_details'])."', '".str_replace("'", "''", $_REQUEST['cnt_title'])."', '".str_replace("'", "''", $_REQUEST['cnt_description'])."', '".str_replace("'", "''", $_REQUEST['cnt_keywords'])."')";
		$nRst=mysql_query($strQRY2) or die(mysql_error());
	}
	header("Location: manage_content.php?op=2");
}
if(isset($_REQUEST['show'])){
	$FormHead = "Content Details";
}
elseif(isset($_REQUEST['action'])){
	if($_REQUEST['action'] == 2){
		$FormHead = "Edit Content Details";
		$rs=mysql_query("SELECT c.cnt_id, cl.cnt_heading, cl.cnt_details, cl.cnt_title, cl.cnt_description, cl.cnt_keywords From contents AS c LEFT OUTER JOIN contents_ln AS cl ON cl.cnt_id=c.cnt_id AND cl.lang_id=".$_SESSION['lang_id']." WHERE c.cnt_id=".$_REQUEST['cnt_id']." ");
		if(mysql_num_rows($rs) > 0){
			$FormHead = "Edit Content Details";
			$row = mysql_fetch_object($rs);
			$cnt_heading = $row->cnt_heading;
			$cnt_details = $row->cnt_details;
			$cnt_title = $row->cnt_title;
			$cnt_description = $row->cnt_description;
			$cnt_keywords = $row->cnt_keywords;
		}
	}else{
		$FormHead = "Add Content Details";
		$cnt_heading = '';
		$cnt_details = '';
		$cnt_title = '';
		$cnt_description = '';
		$cnt_keywords = '';
		$lang_id= 1;
	}
}
if(isset($_REQUEST['btnDelete'])){ 
	if(isset($_REQUEST['chkstatus'])){
		for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
			mysql_query("DELETE FROM contents WHERE cnt_id = ".$_REQUEST['chkstatus'][$i]);
			mysql_query("DELETE FROM contents_ln WHERE cnt_id = ".$_REQUEST['chkstatus'][$i]);
		}
		$msg_class='msg_box msg_ok';
		$strMSG = "Records Deleted successfully";
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
			$strMSG = "Records Added Successfully";
			break;
		case 2:
			$msg_class='msg_box msg_ok';
			$strMSG = "Records Updated Successfully";
			break;
		case 3:
			$msg_class='msg_box msg_alert';
			$strMSG = "Already exists";
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
							<h1 class="sepH_c">Contents Management</h1>

					<?php
						if(isset($_REQUEST['show'])){
					?>
                        <div class="formEl_a">
                            <fieldset class="sepH_b">
                                <legend>Details</legend>
                                    <table cellpadding="0" cellspacing="0" border="0" class="table_a smpl_tbl">
                                <?php    
										$Query = "SELECT c.cnt_id, cl.* FROM contents AS c LEFT OUTER JOIN contents_ln AS cl ON c.cnt_id=cl.cnt_id WHERE c.cnt_id = ".$_REQUEST['id']." AND cl.lang_id=".$_SESSION['lang_id']." LIMIT 1";
                                        $rs = mysql_query($Query);
                                        if(mysql_num_rows($rs)>0){
                                            while($row=mysql_fetch_object($rs)){	
                                ?>
                                        <tr>
                                            <td>Content Heading:</td>
                                            <td><?php print($row->cnt_heading);?></td>
                                        </tr>
                                        <tr>
                                            <td>Content Details:</td>
                                            <td><?php print($row->cnt_details);?></td>
                                        </tr>
                                        <tr>
                                            <td>Page Title:</td>
                                            <td><?php print($row->cnt_title);?></td>
                                        </tr>
                                        <tr>
                                            <td>Meta Description:</td>
                                            <td><?php print($row->cnt_description);?></td>
                                        </tr>
                                        <tr>
                                            <td>Meta keywords:</td>
                                            <td><?php print($row->cnt_keywords);?></td>
                                        </tr>
                                        <?php
                                                }
                                            }
                                            else{	
                                        ?>
                                                <tr><td colspan="100" align="center" class="ListRow1">No Record Found</td></tr>
                                        <?php
                                            }
                                        ?>
                                    </table>
                                </fieldset>
                            </div>
                        <input type="button" name="btnCancel" class="submitButton" value="BACK" onClick="javascript: window.location= 'manage_content.php';">
					<?php
						} else
						if(isset($_REQUEST['action'])){
					?>

                <form name="form" id="validateFormData" method="post" action="<?php @print($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);?>" enctype="multipart/form-data">
							<div class="formEl_a">
								<fieldset class="sepH_b">
									<legend><?php print($FormHead);?></legend>
									<div class="sepH_b">
										<label for="a_text" class="lbl_a">Content Heading:</label>
										<input type="text" id="a_text" name="cnt_heading" value="<?php print($cnt_heading);?>" class="inpt_a required" />
									</div>
									<div class="sepH_b">
										<label for="a_textarea" class="lbl_a">Content Details:</label>
										<?php
											$sBasePath = "../fckeditor/";
                                            $oFCKeditor = new FCKeditor('cnt_details');
                                            $oFCKeditor->BasePath   = $sBasePath;
                                            $oFCKeditor->Value		= $cnt_details;
                                            $oFCKeditor->ToolbarSet	= 'Default';
                                            $oFCKeditor->Height		= 300;
                                            $oFCKeditor->Width		= 600;
                                            $oFCKeditor->Create();
											
                                        ?>
									</div>
									<div class="sepH_b">
										<label for="a_text" class="lbl_a">Page Title:</label>
										<input type="text" id="a_text" name="cnt_title" value="<?php print($cnt_title);?>" class="inpt_a" />
									</div>
									<div class="sepH_b">
										<label for="a_text" class="lbl_a">Meta Description:</label>
                                        <textarea id="a_textarea" name="cnt_description"  cols="30" rows="10" style="resize:none;"><?php print $cnt_description;?></textarea>
									</div>
									<div class="sepH_b">
										<label for="a_text" class="lbl_a">Meta Keywords:</label>
										<input type="text" id="a_text" name="cnt_keywords" value="<?php print($cnt_keywords);?>" class="inpt_a" />
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
                                    <input type="button" name="btnCancel" class="submitButton" value="BACK" onClick="javascript: window.location= 'manage_content.php';">
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
										<th><div class="th_wrapp">Serial</div></th>
                                        <th><div class="th_wrapp">Content Heading</div></th>
                                        <th><div class="th_wrapp">Page Title</div></th>
                                        <!--<th><div class="th_wrapp">Add Language</div></th>-->
                                        <th><div class="th_wrapp">Details</div></th>
                                        <th><div class="th_wrapp">Actions</div></th>
									</tr>
								</thead>
								<tbody>
								<?php
									$Query="SELECT c.*, cl.cnt_heading, cl.cnt_details, cl.cnt_title, cl.cnt_description, cl.cnt_keywords From contents AS c LEFT OUTER JOIN contents_ln AS cl ON cl.cnt_id=c.cnt_id AND cl.lang_id=".$_SESSION['lang_id']." ORDER BY c.cnt_id";
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
                                        <td class="chb_col" align="center"><input type="checkbox" name="chkstatus[]" value="<?php print($row->cnt_id);?>" class="inpt_c1" /></td>
                                        <td class="chb_col"><?php echo $row->cnt_id;?></td>
                                        <td><?php echo limit_text($row->cnt_heading,20);?></td>
                                        <td><?php echo limit_text($row->cnt_title,20);?></td>
                                        <!--<td align="center"><a href="manage_content.php?action=3&cnt_id=<?php echo $row->cnt_id;?>"> Add </a></td>-->
                                        <td align="center"><a href="manage_content.php?show&id=<?php echo $row->cnt_id;?>"> View </a></td>
                                        <td class="content_actions" width="70px">
                                            <a href="<?php print($_SERVER['PHP_SELF']."?action=2&cnt_id=".$row->cnt_id);?>" class="sepV_a" title="Edit">
                                                <img src="images/icons/pencil_gray.png" alt="" />
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
                                <!--<a href="#confModal" class="btn btn_c" rel="fancyConf">DELETE</a>-->
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