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
if(isset($_REQUEST["cid"])){
	$cid = $_REQUEST["cid"];
}
if(isset($_REQUEST['udt'])){
	if(isset($_REQUEST['btnEdit'])){
		$chk = chkExist("cat_id", "categories_ln", "WHERE cat_id=".$_REQUEST['id']." AND lang_id=".$_SESSION["lang_id"]);
		if($chk > 0){
			mysql_query("UPDATE categories_ln SET cat_name='".$_REQUEST['cat_name']."', cat_details='".$_REQUEST['cat_details']."' WHERE cat_id=".$_REQUEST['id']." AND lang_id=".$_SESSION["lang_id"]);
		}
		else{
			mysql_query("INSERT INTO categories_ln(cat_id, lang_id, cat_name, cat_details) VALUES(".$_REQUEST['id'].", ".$_SESSION["lang_id"].", '".$_REQUEST['cat_name']."', '".$_REQUEST['cat_details']."')");
		}
		if(isset($_REQUEST['cid'])){
			header("Location: manage_categories.php?op=2&cid=".$_REQUEST['cid']);
		}
		else{
			header("Location: manage_categories.php?op=2");
		}
	}
	else{
		if(isset($_REQUEST['udt']) == 1){
			$strQry = "SELECT * FROM categories WHERE cat_id =".$_REQUEST['id'];
			$nResult = mysql_query($strQry);
			$rs = mysql_fetch_object($nResult);
			$rsl = mysql_query("SELECT * FROM categories_ln WHERE cat_id=".$_REQUEST['id']." AND lang_id=".$_SESSION['lang_id']);
			if(mysql_num_rows($rsl)>0){
				$rowl=mysql_fetch_object($rsl);
				$cat_name = $rowl->cat_name;
				$cat_details = $rowl->cat_details;
			}
			else{
				$cat_name = "";
				$cat_details = "";
			}
		}
	}
}
elseif(isset($_REQUEST['del'])){
	if(isset($_REQUEST["cid"])){
		$nResult=mysql_query("DELETE FROM categories WHERE cat_id = ".$_REQUEST['id']) or die(mysql_error());
		$nResult=mysql_query("DELETE FROM categories_ln WHERE cat_id = ".$_REQUEST['id']) or die(mysql_error());
		header("Location: manage_categories.php?op=3&cid=".$_REQUEST['cid']);
	}
}
elseif(isset($_REQUEST['btnAdd'])){
	$chk = chkExist("cat_id", "categories", " WHERE cat_name='".$_REQUEST['cat_name']."' AND cat_parentid=".$_REQUEST['cid']." ");
	if ($chk>0){
		$strMSG="Already exist";
		$class = "msg_box msg_alert";
		header("Location: manage_categories.php?op=5");
	} else {
		$MaxID = getMaximum("categories","cat_id");
		if(isset($_REQUEST['cid'])){
			$parentID = $_REQUEST['cid'];
			$redURL = "&cid=".$_REQUEST['cid'];
		} else {
			$parentID = 0;
			$redURL = "";
		}
		$strQRY="INSERT INTO categories(cat_id, cat_name, cat_details, cat_parentid) VALUES('".$MaxID."', '".$_REQUEST['cat_name']."', '".$_REQUEST['cat_details']."', ".$parentID.")";
		$nRst=mysql_query($strQRY) or die(mysql_error()."Unable 2 Add New Record");
		mysql_query("INSERT INTO categories_ln(cat_id, lang_id, cat_name, cat_details) VALUES(".$MaxID.", ".$_SESSION["lang_id"].", '".$_REQUEST['cat_name']."', '".$_REQUEST['cat_details']."')");
		header("Location: manage_categories.php?op=1".$redURL);
	}
}
else{
	$cat_name = "";
	$cat_details = "";
}
if(isset($_REQUEST['Featured'])){
	if(isset($_REQUEST['chkstatus'])){
		for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
			mysql_query("UPDATE categories SET is_featured=1 WHERE cat_id = ".$_REQUEST['chkstatus'][$i]);
		}
		$msg_class='msg_box msg_ok';
		$strMSG = "Record(s) updated successfully";
	}
	else{
		$strMSG = "Please check atleast one checkbox";
	}
}
if(isset($_REQUEST['UnsetFeatured'])){
	if(isset($_REQUEST['chkstatus'])){
		for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
			mysql_query("UPDATE categories SET is_featured=0 WHERE cat_id = ".$_REQUEST['chkstatus'][$i]);
		}
		$msg_class='msg_box msg_ok';
		$strMSG = "Record(s) updated successfully";
	}
	else{
		$strMSG = "Please check atleast one checkbox";
	}
}
if(isset($_REQUEST['Active'])){
	if(isset($_REQUEST['chkstatus'])){
		for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
			mysql_query("UPDATE categories SET status_id=1 WHERE cat_id = ".$_REQUEST['chkstatus'][$i]);
		}
		$msg_class='msg_box msg_ok';
		$strMSG = "Record(s) updated successfully";
	}
	else{
		$strMSG = "Please check atleast one checkbox";
	}
}
if(isset($_REQUEST['InActive'])){
	if(isset($_REQUEST['chkstatus'])){
		for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
			mysql_query("UPDATE categories SET status_id=0 WHERE cat_id = ".$_REQUEST['chkstatus'][$i]);
		}
		$msg_class='msg_box msg_ok';
		$strMSG = "Record(s) updated successfully";
	}
	else{
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
		case 3:
			$msg_class='msg_box msg_ok';
			$strMSG = "Record Deleted Successfully";
			break;
		case 4:
			$msg_class='msg_box msg_alert';
			$strMSG = "Please remove sub categories first";
			break;
		case 5:
			$msg_class='msg_box msg_alert';
			$strMSG = "Record already exists";
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
                                <h1 class="sepH_c">Categories Management</h1>
								<?php
                                    if(isset($_REQUEST['show'])){
                                ?>
                                    <div class="formEl_a">
                                        <fieldset class="sepH_b">
                                            <legend>Details</legend>
                                            <table cellpadding="0" cellspacing="0" border="0" class="table_a smpl_tbl">
                                            
                                            <?php
                                                $Query="SELECT c.cat_id, c.status_id, c.cat_parentid, cl.* From categories AS c LEFT OUTER JOIN categories_ln AS cl ON c.cat_id=cl.cat_id WHERE c.cat_id=".$_REQUEST['cid']." AND cl.lang_id=".$_SESSION['lang_id']." LIMIT 1";
                                                $rs = mysql_query($Query);
                                                    if(mysql_num_rows($rs)>0){
                                                        $row=mysql_fetch_object($rs);
                                            ?>
                                                    <tr>
                                                        <td>ID:</td>
                                                        <td><?php print($row->cat_id);?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Name:</td>
                                                        <td><?php print($row->cat_name);?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Details:</td>
                                                        <td><?php print($row->cat_details);?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Status:</td>
                                                        <td><?php echo (($row->status_id==1)?"<span class='notification ok_bg'>Active</span>":"<span class='notification alert_bg'>Not Active</span>");?> </td>
                                                    </tr>
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
                                    <input type="button" name="btnCancel" value="BACK" class="submitButton" onClick="javascript: window.location= '<?php echo ((isset($_REQUEST["pid"]) ? 'manage_categories.php?cid='.$_REQUEST["pid"] : 'manage_categories.php'));?>';">
                                <?php	
                                    }
                                    elseif(isset($_REQUEST['action'])){ 
                                ?>
                                    <form name="form" method="post" action="<?php @print($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);?>" enctype="multipart/form-data">
                                        <div class="formEl_a">
                                            <fieldset class="sepH_b">
                                                <legend><?php
                                                        if(isset($_REQUEST['udt'])){
                                                            print("Edit Category");
                                                        }
                                                        else{
                                                            print("Add Category");
                                                        }
                                                    ?>
                                                </legend>
                                                <div class="sepH_b">
                                                    <label for="a_text" class="lbl_a">Category:</label>
                                                    <input type="text" id="a_text" name="cat_name" value="<?php @print($cat_name);?>" class="inpt_a" />
													<?php
                                                        if( !empty($_GET['cid']) ){
                                                    ?>
                                                          <input  type="hidden" name="hiddenCatId" value="<?php echo @$_GET['cid']; ?>">
                                                    <?php
                                                        } else {
                                                    ?>
                                                          <input  type="hidden" name="hiddenCatId" value="0">
                                                    <?php
                                                        }
                                                    ?>                        
                                                </div>
                                                <div class="sepH_b">
                                                    <label for="a_textarea" class="lbl_a">Details:</label>
                                                    <textarea id="a_textarea" name="cat_details" cols="30" rows="10"><?php @print($cat_details);?></textarea>
                                                </div>
                                            </fieldset>
                                            <?php
                                                if(isset($_REQUEST['udt'])){
                                            ?>
                                                  <input type="submit" name="btnEdit" value="UPDATE" class="submitButton">
                                                  <input type="hidden" name="uiFile" value="<?php echo @$cat_file?>">
                                            <?php
                                                }
                                                else{
                                            ?>
                                                  <input type="submit" name="btnAdd" value="ADD" class="submitButton">
                                            <?php
                                                }
                                            ?>
                                            <input type="button" name="btnCancel" value="BACK" class="submitButton" onClick="javascript: window.location= '<?php echo ((isset($_REQUEST["cid"]) ? 'manage_categories.php?cid='.$_REQUEST["cid"] : 'manage_categories.php'));?>';">
                                
                                        </div>
                                    </form>             
                                <?php } else{ ?>

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
                                                    <?php if(isset($_REQUEST['cid'])){?><th class="chb_col"  align="center" width="30"><div class="th_wrapp"><input type="checkbox" name="chkAll" onClick="setAll();"></div></th><?php }?>
                                                    <th><div class="th_wrapp">Category </div></th>
                                                    <th><div class="th_wrapp">Status </div></th>
                                                    <th><div class="th_wrapp">Details </div></th>
                                                    <!--<th><div class="th_wrapp">Add Language</div></th>-->
                                                    <th><div class="th_wrapp">Actions </div></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                if(isset($_REQUEST['cid'])){
													$Query="SELECT c.*, cl.cat_name, cl.cat_details From categories AS c LEFT OUTER JOIN categories_ln AS cl ON cl.cat_id=c.cat_id AND cl.lang_id=".$_SESSION['lang_id']." WHERE c.cat_parentid ='".$_REQUEST['cid']."' ORDER BY c.cat_id";
                                                }
                                                else{
													$Query="SELECT c.*, cl.cat_name, cl.cat_details From categories AS c LEFT OUTER JOIN categories_ln AS cl ON cl.cat_id=c.cat_id AND cl.lang_id=".$_SESSION['lang_id']." WHERE c.cat_parentid =0 ORDER BY c.cat_id";
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
                                                    <?php if(isset($_REQUEST['cid'])){?><td class="chb_col" align="center"><input type="checkbox" name="chkstatus[]" value="<?php print($row->cat_id);?>" class="inpt_c1" /></td><?php }?>
                                                    <?php
                                                    if(isset($_REQUEST['cid'])){
                                                    ?>
                                                        <td align="left"><?php print($row->cat_name);?></td>
                                                    <?php	} else { ?>
                                                        <td align="left" style="padding-left:4px;padding-right:4px;"><a href="<?php print($_SERVER['PHP_SELF']."?cid=".$row->cat_id);?>" title="<?php print($row->cat_name);?>"><?php print($row->cat_name);?></a> - Total <?php print(TotalRecords("categories", "WHERE cat_parentid=".$row->cat_id));?></td>
                                                        <td><?php echo (($row->status_id==1)?"<span class='notification ok_bg'>Active</span>":"<span class='notification alert_bg'>Not Active</span>");?> </td>
                                                        <td align="left"><a href="<?php print($_SERVER['PHP_SELF']."?show=1&cid=".$row->cat_id);?>">Details</a></td>                  
                                                       <!-- <td align="center"><a href="manage_categories.php?action=3&cat_id=<?php //echo $row->cat_id;?>"> Add </a></td>-->
                                                    <?php	
                                                    }
                                                    ?>
                                                    <?php
                                                    if(isset($_REQUEST['cid'])){
                                                    ?>
                                                        <td><?php echo (($row->status_id==1)?"<span class='notification ok_bg'>Active</span>":"<span class='notification alert_bg'>Not Active</span>");?> </td>
                                                        <td align="left"><a href="<?php print($_SERVER['PHP_SELF']."?show=1&cid=".$row->cat_id.'&pid='.$_REQUEST['cid']);?>">Details</a></td>  
                                                        <!--<td align="center"><a href="manage_categories.php?action=3&cid=<?php //echo $_REQUEST['cid'];?>&cat_id=<?php //echo $row->cat_id;?>"> Add </a></td>-->
                                                        <td class="content_actions" width="70px">                           
                                                            <a href="<?php print($_SERVER['PHP_SELF']."?id=".$row->cat_id."&udt=1&action=1&cid=".$_REQUEST['cid']);?>" class="sepV_a" title="Edit">
                                                                <img src="images/icons/pencil_gray.png" alt="" />
                                                            </a>
                                                        
                                                            <a href="<?php print($_SERVER['PHP_SELF']."?id=".$row->cat_id."&del=1&cid=".$_REQUEST['cid']);?>" title="Delete" onClick="javascript: return confirm('Are you sure you want to delete this record');">
                                                                <img src="images/icons/trashcan_gray.png" alt="" />
                                                            </a>
                                                        </td>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <td class="content_actions" width="70px">                           
                                                            <a href="<?php print($_SERVER['PHP_SELF']."?id=".$row->cat_id."&action=1&udt=1");?>" class="sepV_a" title="Edit">
                                                                <img src="images/icons/pencil_gray.png" alt="" />
                                                            </a>
                                                        
                                                            <!--<a href="<?php //print($_SERVER['PHP_SELF']."?id=".$row->cat_id."&del=1");?>" title="Delete" onClick=" javascript: return confirm('Are you sure you want to delete this record');">
                                                                <img src="images/icons/trashcan_gray.png" alt="" />
                                                            </a>-->
                                                        </td>
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

                                            <?php
                                                if(isset($_REQUEST['cid'])){
                                            ?>
                                                <input type="hidden" name="cid" value="<?php print($cid);?>">
                                            <?php
                                                }
                                            ?>
                                            <?php if(isset($_REQUEST['cid'])){?>
                                              <input type="submit" name="Active" value="ACTIVE" class="submitButton">
                                              <input type="submit" name="InActive" value="INACTIVE" class="submitButton">
                                            <?php }?>
<!--
                                            <input type="submit" name="Featured" value="FEATURED" class="submitButton">
                                            <input type="submit" name="UnsetFeatured" value="UNSET FEATURES" class="submitButton">
-->                                        <?php }?>
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