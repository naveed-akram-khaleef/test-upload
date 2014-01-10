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
	$MaxID = getMaximum("pr_types","ptype_id");
	$strQry="SELECT ptype_id FROM pr_types WHERE ptype_value ='".$_REQUEST['ptype_value']."' AND cat_id='".$_REQUEST['cat_id']."' ";
	$nResult =mysql_query($strQry) or die("Unable 2 Work");
	if (mysql_num_rows($nResult)>=1){ header("Location: manage_product_types.php?op=3"); die(); }	
	if($_REQUEST['cat_id']==4){
		$value =  $_REQUEST['width'].'X'.$_REQUEST['height'];
	} else {
		$value =  $_REQUEST['ptype_value'];
	}
	$strQRY="INSERT INTO pr_types (ptype_id, ptype_value, cat_id) VALUES (".$MaxID.", '".str_replace("'", "''", $value)."', '".str_replace("'", "''", $_REQUEST['cat_id'])."')";
	$nRst=mysql_query($strQRY) or die(mysql_error());
	if(isset($_REQUEST['cid'])){
		header("Location: manage_product_types.php?op=1&cid=".$_REQUEST['cid']);
	} else {
		header("Location: manage_product_types.php?op=1");
	}
}
elseif(isset($_REQUEST['btnEdit'])){
	if($_REQUEST['cat_id']==4){
		$value =  $_REQUEST['width'].'X'.$_REQUEST['height'];
	} else {
		$value =  $_REQUEST['ptype_value'];
	}
	mysql_query("UPDATE pr_types SET ptype_value ='".str_replace("'", "''", $value)."', cat_id ='".str_replace("'", "''", $_REQUEST['cat_id'])."' WHERE ptype_id=".$_REQUEST['ptype_id']);
	if(isset($_REQUEST['cid'])){
		header("Location: manage_product_types.php?op=2&cid=".$_REQUEST['cid']);
	} else {
		header("Location: manage_product_types.php?op=2");
	}
}
elseif((isset($_REQUEST['action'])) && ($_REQUEST['action']==2)){
	$FormHead = "Edit Details";
	$rs = mysql_query("SELECT * FROM pr_types WHERE ptype_id=".$_REQUEST['ptype_id']);
	if(mysql_num_rows($rs) > 0){
		$row = mysql_fetch_object($rs);
		$ptype_value = $row->ptype_value;
		$cat_id = $row->cat_id;
	}
}
else{
	$FormHead = "Add New Details";
	if(!isset($_REQUEST['btnAdd'])){
		$ptype_value = '';
		$cat_id = 0;
	}
}
if(isset($_REQUEST['btnDelete'])){
	if(isset($_REQUEST['chkstatus'])){
		for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
			mysql_query("DELETE FROM pr_types WHERE ptype_id=".$_REQUEST['chkstatus'][$i]);
		}
		$msg_class='msg_box msg_ok';
		$strMSG = "Record(s) deleted successfully";
	}
	else{
		$msg_class='msg_box msg_alert';
		$strMSG = "Please check atleast one checkbox";
	}
}
if(isset($_REQUEST['op'])){
	switch ($_REQUEST['op']) {
		case 1:
			$msg_class='msg_box msg_ok';
			$strMSG = "Record Added Successfully";
			break;
		case 2:
			$msg_class='msg_box msg_ok';
			$strMSG = "Record Updated Successfully";
			break;
		case 3:
			$msg_class='msg_box msg_alert';
			$strMSG = "Already Exist";
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
						<?php if($msg_class != ''){?>
                            <div class="<?php echo $msg_class;?>"><?php echo $strMSG;?><img src="images/blank.gif" class="msg_close" alt="" /></div>
                        <?php }?>
                            <div class="sepH_c">
                                <h1 class="sepH_c">Product Types Management</h1>
                                <p><strong>Supported Audio/Ringtone Formats:</strong> mp3, m4a, ogg, oga, webma, wav</p>
                                <p><strong>Supported Video Formats:</strong> mp4, m4v, ogv, webm, webmv</p>

						<?php
                            if(isset($_REQUEST['show'])){
                        ?>		
                            <div class="formEl_a">
                                <fieldset class="sepH_b">
                                    <legend>Details</legend>
                                    <table cellpadding="0" cellspacing="0" border="0" class="table_a smpl_tbl">
                                    <?php
                                        $Query="SELECT n.*, s.status_name FROM pr_types AS n LEFT OUTER JOIN status AS s ON n.status_id=s.status_id WHERE n.ptype_id='".$_REQUEST["ptype_id"]."' ";
                                        $rs = mysql_query($Query);
                                        if(mysql_num_rows($rs)>0){
                                            $row=mysql_fetch_object($rs);	
                                    ?>
                                        <tr>
                                            <td>ptype_value:</td>
                                            <td><?php print($row->ptype_value);?></td>
                                        </tr>
                                        <tr>
                                            <td>Details:</td>
                                            <td><?php print($row->pr_types_details);?></td>
                                        </tr>
                                        <tr>
                                            <td>Added Date:</td>
                                            <td><?php print($row->pr_types_created);?></td>
                                        </tr>
                                        <tr>
                                            <td>Updated Date:</td>
                                            <td><?php print($row->pr_types_modified);?></td>
                                        </tr>
                                        <tr>
                                            <td>Status:</td>
                                            <td><?php echo (($row->status_id==1)?"<span class='notification info_bg'>Active</span>":"<span class='notification error_bg'>In Active</span>");?></td>
                                        </tr>
                                    <?php
                                        }
                                    ?>
                                    </table>
                                </fieldset>
                            </div>
                           <input type="button" name="btnCancel" class="submitButton" value="BACK" onClick="javascript: window.location= 'manage_product_types.php';">  
						<?php	
                            } else  if(isset($_REQUEST['action']) == 1){
						?>
                            <form name="form" id="validateFormData" method="post" action="<?php @print($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);?>" enctype="multipart/form-data">
                                <div class="formEl_a">
                                    <fieldset class="sepH_b">
                                        <legend><?php print($FormHead);?></legend>
                                        <div class="sepH_b">
                                            <label for="a_textarea" class="lbl_a">Category:</label>
                                            <select name="cat_id" onchange="javascript: displayWH(this.value,'<?php echo (($cat_id==4)?$ptype_value:0);?>');" class="required">
                                            		<option value=""> Select Category</option>
                                                <?php FillSelected("categories WHERE cat_parentid=0 ", "cat_id", "cat_name", $cat_id); ?>
                                            </select>
                                        </div>
                                        <div class="sepH_b" id="response">
                                        	<?php if($cat_id==4){ $arr = explode('X',$ptype_value);?>
                                            Width: <input style="width:50px;" type="text" id="a_text" name="width" value="<?=$arr[0]?>" class="inpt_a required" />px
                                            &nbsp; Height: <input style="width:50px;" type="text" id="a_text1" name="height" value="<?=$arr[1]?>" class="inpt_a required" />px
                                          <?php }?>
                                        </div>
                                        <script language="javascript">
                                        	function displayWH(someValue,someValue2){
																						if(someValue2!=0){
																							spliters = someValue2.split("X");
																							firstSplit = spliters[0];
																							secondSplit = spliters[1];
																						} else {
																							firstSplit = '';
																							secondSplit = '';
																						}
																						if(someValue==4){
																							str = 'Width: <input style="width:50px;" type="text" id="a_text" name="width" value="'+firstSplit+'" class="inpt_a required" />px &nbsp; Height: <input style="width:50px;" type="text" id="a_text1" name="height" value="'+secondSplit+'" class="inpt_a required" />px';
																							document.getElementById("response").innerHTML = str;
																							document.getElementById("extension").style.visibility='hidden';
																							document.getElementById("extension").style.display='none';
																						} else {
																							document.getElementById("response").innerHTML = '';
																							document.getElementById("extension").style.visibility='visible';
																							document.getElementById("extension").style.display='block';
																						}
																					}
                                        </script>
																				<?php //if($cat_id!=4){?>
                                          <div class="sepH_b" id="extension">
                                              <label for="a_text" class="lbl_a">Value/Extension:</label>
                                              <input type="text" id="a_text" name="ptype_value" value="<?php print($ptype_value);?>" class="inpt_a required" />
                                          </div>
                                        <?php //}?>
                                    </fieldset>
                                    <?php
                                        if(isset($_REQUEST['action']) && ($_REQUEST['action']==2)){
                                    ?>
                                            <input name="btnEdit" type="submit" class="submitButton" value="UPDATE">
                                    <?php	
                                        }
                                        else{
                                    ?>
                                            <input name="btnAdd" type="submit" class="submitButton" value="ADD">
                                    <?php
                                        }
                                    ?>
                                            <input name="btnCancel" type="button" class="submitButton" value="BACK" onClick="javascript: window.location = 'manage_product_types.php';">
                                </div>
                            </form>   
						<?php
							} else {
						?>         

							<?php if(isset($_REQUEST['cid'])){?>
                                <div class="sepH_a" align="right">
                                    <a href="<?php print($_SERVER['PHP_SELF']."?action=1&".$_SERVER['QUERY_STRING']);?>" title="Add New">Add New</a>
                                    <?php if(isset($_REQUEST['cid'])){ ?>
                                        | <a href="<?php print($_SERVER['PHP_SELF']);?>" title="Back">Go Back</a>
                                    <?php } ?>
                                </div>
                              <?php }?>  

                            <form name="frm" id="frm" method="post" action="<?php @print($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);?>" enctype="multipart/form-data" onSubmit="return chkRequired(this);">
                                <table cellpadding="0" cellspacing="0" border="0" class="display" id="">
                                    <thead>
                                        <tr>
                                            <?php if(isset($_REQUEST['cid'])){?>
                                            <th class="chb_col"  align="center" width="30"><div class="th_wrapp"><input type="checkbox" name="chkAll" onClick="setAll();"></div></th>
                                            <th><div class="th_wrapp">Categories</div></th>
                                            <th><div class="th_wrapp">Type ID</div></th>
                                            <th><div class="th_wrapp">Type Value/Extension</div></th>
                                            <th><div class="th_wrapp">Actions </div></th>
											<?php } else {?>
                                            <th><div class="th_wrapp">Categories</div></th>
											<?php }?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
										if(isset($_REQUEST['cid'])){
											$Query = " SELECT pt.*, c.cat_name FROM pr_types AS pt LEFT OUTER JOIN categories AS c ON pt.cat_id=c.cat_id WHERE pt.cat_id=".$_REQUEST['cid']." ORDER BY pt.ptype_id ";
										}
										else{
											$Query="SELECT * FROM categories WHERE cat_parentid=0 ORDER BY cat_id";
										}
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
											<?php
                                                if(isset($_REQUEST['cid'])){
                                            ?>
                                                <td class="chb_col" align="center"><input type="checkbox" name="chkstatus[]" value="<?php print($row->ptype_id);?>" class="inpt_c1" /></td>
                                                <td><?php echo $row->cat_name;?> </td>
                                                <td><?php echo $row->ptype_id;?> </td>
                                                <td><?php echo $row->ptype_value;?> </td>
                                                <td class="content_actions" width="70px"><a href="<?php print($_SERVER['PHP_SELF']."?action=2&ptype_id=".$row->ptype_id);?>&cid=<?php echo $_REQUEST['cid'];?>" class="sepV_a" ptype_value="Edit">
                <img src="images/icons/pencil_gray.png" alt="" />
                </a> </td>
											<?php
                                            } else {
                                            ?>
                                                <td><a href="manage_product_types.php?cid=<?php echo $row->cat_id;?>"><?php echo $row->cat_name;?></a>  (<?php print(TotalRecords("pr_types", "WHERE cat_id=".$row->cat_id));?>) </td>
                                            <?php	
                                            }
                                            ?>
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
                                <?php if($counter > 0) {?>
									<?php if(isset($_REQUEST['cid'])){?>
                                    <a href="#confModal" class="btn btn_c" rel="fancyConf">DELETE</a>
                                    <?php }?>
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
						<?php 
							}
						?>
                        
                        
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