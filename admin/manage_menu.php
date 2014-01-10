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
if(isset($_REQUEST["menu_id"])){
	$menu_id = $_REQUEST["menu_id"];
}
if(isset($_REQUEST['btnAdd'])){
	$chk = IsExist("menu_id", "menu", "menu_title", $_REQUEST['menu_title']);
	if ($chk == 1){
		header("Location: manage_menu.php?op=3");
	} else {
		$MaxID = getMaximum("menu","menu_id");
		$strQRY1 = "INSERT INTO menu (menu_id, menu_title, menu_order) VALUES (".$MaxID.", '".str_replace("'", "''", $_REQUEST['menu_title'])."', ".$MaxID.")";
		$nRst=mysql_query($strQRY1);
		$strQRY2 = "INSERT INTO menu_ln (menu_id, lang_id, menu_title) VALUES (".$MaxID.", ".$_SESSION['lang_id'].", '".str_replace("'", "''", $_REQUEST['menu_title'])."')";
		$nRst=mysql_query($strQRY2);
		header("Location: manage_content.php?op=1");
	}
	if(isset($_REQUEST['level'])){
		header("Location: manage_menu.php?op=1&menu_id=".$_REQUEST['parent_id']."&level=".$_REQUEST['level']);
	}
	else {
		header("Location: manage_menu.php?op=1");
	}
}
elseif(isset($_REQUEST['btnEdit'])){
	$chk = chkExist("menu_id", "menu_ln", "WHERE menu_id=".$_REQUEST['menu_id']." AND lang_id=".$_SESSION["lang_id"]);
	if($chk > 0){
		$strQRY2="UPDATE menu_ln SET menu_title='".str_replace("'", "''", $_REQUEST['menu_title'])."' WHERE menu_id = ".$_REQUEST['menu_id']." AND lang_id=".$_SESSION['lang_id']." ";
		$nRst=mysql_query($strQRY2) or die(mysql_error());
	}
	else{
		$strQRY2 = "INSERT INTO menu_ln (menu_id, lang_id, menu_title) VALUES (".$_REQUEST['menu_id'].", ".$_SESSION['lang_id'].", '".str_replace("'", "''", $_REQUEST['menu_title'])."')";
		$nRst=mysql_query($strQRY2);
	}
	if(isset($_REQUEST['level'])){
		header("Location: manage_menu.php?op=2&menu_id=".$_REQUEST['parent_id']."&level=".$_REQUEST['level']);
	}
	else { 
		header("Location: manage_menu.php?op=2");
	}
}
elseif(isset($_REQUEST['action'])){
	if($_REQUEST['action'] == 2) {
		$strQry = "";
		$strQry="SELECT m.*, ml.menu_title From menu AS m LEFT OUTER JOIN menu_ln AS ml ON ml.menu_id=m.menu_id AND ml.lang_id=".$_SESSION['lang_id']." WHERE m.menu_id =".$_REQUEST['menu_id']." ORDER BY m.menu_id";
		$nResult = mysql_query($strQry) or die(mysql_error());
		$rs = mysql_fetch_object($nResult);
		$cnt_id = $rs->cnt_id;
		$menu_title = $rs->menu_title;
		$menu_parent_id = $rs->menu_parent_id;
		//$menu_bg = $rs->menu_bg;
		$mtype_id = $rs->mtype_id;
		$menu_url = $rs->menu_url;
	}
	else{
		$cnt_id = 0;
		$menu_title = '';
		$menu_parent_id = 0;
		//$menu_bg = '';
		$mtype_id = 1;
		$menu_url = "page.php";
	}
}
elseif(isset($_REQUEST['btnActive'])){
	if(isset($_REQUEST['chkstatus'])){
		for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
			mysql_query("UPDATE menu SET status_id=1 WHERE menu_id = ".$_REQUEST['chkstatus'][$i]);
		}
		$msg_class='msg_box msg_ok';
		$strMSG = "Record(s) updated successfully";
	}
	else{
		$strMSG = "Please check atleast one checkbox";
	}
}
elseif(isset($_REQUEST['btnInactive'])){
	if(isset($_REQUEST['chkstatus'])){
		for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
			mysql_query("UPDATE menu SET status_id=0 WHERE menu_id = ".$_REQUEST['chkstatus'][$i]);
		}
		$msg_class='msg_box msg_ok';
		$strMSG = "Record(s) updated successfully";
	}
	else{
		$strMSG = "Please check atleast one checkbox";
	}
}
elseif(isset($_REQUEST['btnOrder'])){
	for($i=0; $i<count($_REQUEST['menuID']); $i++){
		mysql_query("UPDATE menu SET menu_order=".$_REQUEST['menu_ord'][$i]." WHERE menu_id=".$_REQUEST['menuID'][$i]);
	}
	$msg_class='msg_box msg_ok';
	$strMSG = "Record(s) updated successfully";
}
elseif(isset($_REQUEST['btnDelete'])){
	if(isset($_REQUEST['chkstatus'])){
		for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
			DeleteFileWithThumb("menu_bg", "menu", "menu_id", $_REQUEST['chkstatus'][$i], "../images/menu/", "../images/menu/th/");
			mysql_query("DELETE FROM menu WHERE menu_id = ".$_REQUEST['chkstatus'][$i]);
			mysql_query("DELETE FROM menu WHERE menu_parent_id = ".$_REQUEST['chkstatus'][$i]);
		}
		if(isset($_REQUEST['level'])){
			header("Location: manage_menu.php?menu_id=".$_REQUEST['menu_id']."&op=3&level=".$_REQUEST['level']);
		}
		else { 
			header("Location: manage_menu.php?op=2");
		}
	}
	else{
		if(isset($_REQUEST['level'])){
			header("Location: manage_menu.php?menu_id=".$_REQUEST['menu_id']."&op=4&level=".$_REQUEST['level']);
		}
		else { 
			header("Location: manage_menu.php?op=2");
		}
	}
}
//--------------------------------------------------------------------------------------
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
			$msg_class='msg_box msg_alert';
			$strMSG = "Already exists";
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
						<?php
                        if($msg_class != ''){
							?>
                            <div class="<?php echo $msg_class;?>"><?php echo $strMSG;?><img src="images/blank.gif" class="msg_close" alt="" /></div>
                        <?php
                        }
						?>
                        <div class="sepH_c">
                            <h1 class="sepH_c">Menu Management</h1>
                            <?php
                            if(isset($_REQUEST['action'])){ 
                            ?>
                            <form name="form" id="validateFormData" method="post" action="<?php @print($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);?>" enctype="multipart/form-data">
                            <div class="formEl_a">
                                <fieldset class="sepH_b">
                                    <legend>
	                                    <?php
                                        print("Edit Menu");
    	                                ?>
                                    </legend>
                                    <div class="sepH_b">
                                        <label for="a_text" class="lbl_a">Menu Title</label>
                                        <input type="text" id="a_text" name="menu_title" value="<?php @print($menu_title);?>" class="inpt_a required" />
                                    </div>
                                    <!--<div class="sepH_b">
                                        <label for="a_text" class="lbl_a">Menu URL Name</label>
                                        <input type="text" id="a_text" name="menu_url" value="<?php //@print($menu_url);?>" class="inpt_a" />
                                    </div>-->
                                    <!--<div class="sepH_b">
                                        <label for="iFile" class="lbl_a">Background</label>
                                        <input type="file" name="iFile" class="fileInputs" />
                                        <p>&nbsp;  </p>
                                    </div>-->
                                    <?php if($_REQUEST['action']!=3){?>
                                    <div class="sepH_b">
                                        <label for="a_text" class="lbl_a">Content:</label>
                                        <select name="cnt_id" id="a_select">
                                            <?php FillSelected("contents", "cnt_id", "cnt_heading", $cnt_id); ?>
                                        </select>
                                    </div>
                                    <?php }?>
                                    <!--<div class="sepH_b">
                                        <label for="a_text" class="lbl_a">Type:</label>
                                        <select name="mtype_id" id="a_select">
                                            <?php //FillSelected2("menu_type", "mtype_id", "mtype_name", $mtype_id, "mtype_id>0"); ?>
                                        </select>
                                    </div>-->
                                </fieldset>
                                <?php
								if($_REQUEST['action'] == 2) {
								?>
                                    <input type="submit" name="btnEdit" value="UPDATE" class="submitButton">
								<?php
                                }
								else {
								?>
									<input type="submit" name="btnAdd" value="ADD" class="submitButton">
								<?php
                                }
                                ?>
								<input type="hidden" name="menu_url" id="menu_url" value="<?php print($menu_url);?>" />
                                <input type="button" name="btnCancel" class="submitButton" value="BACK" onClick="javascript: window.location= '<?php echo $_SERVER['HTTP_REFERER'];?>';">  
                            </div>
                            </form>             
                            <?php
                            }
                            else{
                                ?>
                                <div class="sepH_a" align="right">
								<a href="<?php print("manage_menu.php?action=1".(isset($_REQUEST['level'])?'&level='.$_REQUEST['level']:'').(isset($_REQUEST['menu_id'])?'&parent_id='.$_REQUEST['menu_id']:''));?>">Add New</a>
                                <?php if(isset($_REQUEST['menu_id'])){ ?>
                                    | <a href="manage_menu.php" title="Back">Back to Parent Menu</a>
                                <?php }?>
                                </div>
                                <form name="frm" id="frm" method="post" action="<?php @print($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);?>" enctype="multipart/form-data">
                                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="">
                                        <thead>
                                            <tr>
                                                <th class="chb_col"  align="center" width="30"><div class="th_wrapp"><input type="checkbox" name="chkAll" onClick="setAll();"></div></th>
                                                <th><div class="th_wrapp">ID</div></th>
                                                <th><div class="th_wrapp">Title</div></th>
                                                <th><div class="th_wrapp">Order</div></th>
                                                <th><div class="th_wrapp">Status</div></th>
                                                <!--<th><div class="th_wrapp">Add Language</div></th>-->
                                                <th><div class="th_wrapp">Actions</div></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $counter=0;
											$Query="SELECT m.*, ml.menu_title From menu AS m LEFT OUTER JOIN menu_ln AS ml ON ml.menu_id=m.menu_id AND ml.lang_id=".$_SESSION['lang_id']." ORDER BY m.menu_id";
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
                                                    <td class="chb_col" align="center"><input type="checkbox" name="chkstatus[]" value="<?php print($row->menu_id);?>" class="inpt_c1" /></td>
                                                    <td width="20"><?php echo $row->menu_id;?></td>
                                                    <td align="left">
                                                    <?php if(!isset($_REQUEST['level'])){
														if($row->mtype_id == 0 || $row->mtype_id == 1 || $row->mtype_id == 2 || $row->mtype_id == 4){
															print($row->menu_title);
														}
														else{
															print($row->menu_title);
													?>
                                                    
                                                        <!--<a href="<?php print($_SERVER['PHP_SELF']."?menu_id=".$row->menu_id."&level=".(@$_REQUEST['level']+1));?>" title="<?php print($row->menu_title);?>"><?php print($row->menu_title);?></a> (<?php print(TotalRecords("menu", "WHERE menu_parent_id=".$row->menu_id));?>)-->                                                    
													<?php }
													} elseif($_REQUEST['level']<=1){
                                                        print($row->menu_title);
													}?>
                                                    </td>
													<td>
														<input type="text" id="a_text" name="menu_ord[]" value="<?php @print($row->menu_order);?>" class="inpt_b_small" />
														<input type="hidden" name="menuID[]" value="<?php @print($row->menu_id);?>" />
													</td>
                                                    <td><?php echo (($row->status_id==1)?"<span class='notification ok_bg'>Active</span>":"<span class='notification alert_bg'>Inactive</span>");?> </td>
                                                    <!--<td align="center"><a href="manage_menu.php?action=3&menu_id=<?php echo $row->menu_id;?>"> Add </a></td>-->
                                                    <td class="content_actions" width="70px">                           
                                                        <a href="<?php print($_SERVER['PHP_SELF']."?action=2&menu_id=".$row->menu_id.(isset($_REQUEST['level'])?'&level='.$_REQUEST['level']:'').(isset($_REQUEST['menu_id'])?'&parent_id='.$_REQUEST['menu_id']:''));?>" class="sepV_a" title="Edit"><img src="images/icons/pencil_gray.png" alt="" /></a>
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
                                    <?php
                                    if($counter > 0) {
									?>

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

                                        <input type="submit" name="btnActive" value="ACTIVE" class="submitButton" onclick="return chkRequired(this);">
                                        <input type="submit" name="btnInactive" value="INACTIVE" class="submitButton" onclick="return chkRequired(this);">
                                        <input type="submit" id="btnOrder" name="btnOrder" value="UPDATE ORDER" class="submitButton">
                                        <!--<a href="#confModal" class="btn btn_c" rel="fancyConf">DELETE</a>
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
                                        <span style="visibility:hidden;"><input type="submit" name="btnDelete" id="btnDelete"></span>-->
                                    <?php
                                    }
                                        ?>
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
					"aaSorting": [[ 0, "asc" ]],
					"aoColumns": [
						null,
						null,
						null,
						null,
						null,
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