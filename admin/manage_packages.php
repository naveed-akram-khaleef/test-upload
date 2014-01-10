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
	$MaxID = getMaximum("packages","pak_id");
	mysql_query("INSERT INTO packages (pak_id, pak_name, sc_id, pktype_id, pak_downloads, pak_streams, pak_gifts, pat_id, pak_credits) VALUES('".$MaxID."', '".$_REQUEST['pak_name']."', '".$_REQUEST['sc_id']."', '".$_REQUEST['pktype_id']."', '".$_REQUEST['pak_downloads']."', '".$_REQUEST['pak_streams']."', '".$_REQUEST['pak_gifts']."', '".$_REQUEST['pat_id']."', '".$_REQUEST['pak_credits']."')") or die(mysql_error());
	// Insert Download Categories
	for($d=0;$d<count($_REQUEST['dn_cats']);$d++){
		mysql_query("INSERT INTO package_cat_limits (pak_id, plt_id, cat_id) VALUES('".$MaxID."', '1', '".$_REQUEST['dn_cats'][$d]."')");
	}
	// Insert Download Streams
	for($s=0;$s<count($_REQUEST['st_cats']);$s++){
		mysql_query("INSERT INTO package_cat_limits (pak_id, plt_id, cat_id) VALUES('".$MaxID."', '2', '".$_REQUEST['st_cats'][$s]."')");
	}
	// Insert Download Gifts
	for($g=0;$g<count($_REQUEST['gf_cats']);$g++){
		mysql_query("INSERT INTO package_cat_limits (pak_id, plt_id, cat_id) VALUES('".$MaxID."', '3', '".$_REQUEST['gf_cats'][$g]."')");
	}
	header("Location: manage_packages.php?op=2");
}
elseif(isset($_REQUEST['btnEdit'])){
	mysql_query("UPDATE packages SET pak_name='".$_REQUEST['pak_name']."', sc_id='".$_REQUEST['sc_id']."', pktype_id='".$_REQUEST['pktype_id']."', pak_downloads='".$_REQUEST['pak_downloads']."', pak_streams='".$_REQUEST['pak_streams']."', pak_gifts='".$_REQUEST['pak_gifts']."', pat_id='".$_REQUEST['pat_id']."', pak_credits='".$_REQUEST['pak_credits']."' WHERE pak_id=".$_REQUEST['pak_id']." ") or die(mysql_error());
	// Insert Download Categories
	mysql_query("DELETE FROM package_cat_limits WHERE pak_id=".$_REQUEST['pak_id']);
	for($d=0;$d<count($_REQUEST['dn_cats']);$d++){
		mysql_query("INSERT INTO package_cat_limits (pak_id, plt_id, cat_id) VALUES('".$_REQUEST['pak_id']."', '1', '".$_REQUEST['dn_cats'][$d]."')");
	}
	// Insert Download Streams
	for($s=0;$s<count($_REQUEST['st_cats']);$s++){
		mysql_query("INSERT INTO package_cat_limits (pak_id, plt_id, cat_id) VALUES('".$_REQUEST['pak_id']."', '2', '".$_REQUEST['st_cats'][$s]."')");
	}
	// Insert Download Gifts
	for($g=0;$g<count($_REQUEST['gf_cats']);$g++){
		mysql_query("INSERT INTO package_cat_limits (pak_id, plt_id, cat_id) VALUES('".$_REQUEST['pak_id']."', '3', '".$_REQUEST['gf_cats'][$g]."')");
	}
	header("Location: manage_packages.php?op=3");
} 
elseif(isset($_REQUEST['action'])){
	$pak_id = '';
	$pak_name = '';
	$sc_id = '';
	$pktype_id = '';
	$pak_fee = '';
	$pak_downloads = '';
	$pak_streams = '';
	$pak_gifts = '';
	$pat_id = '';
	$pak_credits = '';
	$form_head = "Add New";
	if($_REQUEST['action'] == 2){
		$rs = mysql_query("SELECT * FROM packages WHERE pak_id=".$_REQUEST['pak_id']);
		if(mysql_num_rows($rs)>0){
			$row=mysql_fetch_object($rs);
			$pak_id = $row->pak_id;
			$pak_name = $row->pak_name;
			$sc_id = $row->sc_id;
			$pktype_id = $row->pktype_id;
			$pak_fee = $row->pak_fee;
			$pak_downloads = $row->pak_downloads;
			$pak_streams = $row->pak_streams;
			$pak_gifts = $row->pak_gifts;
			$pat_id = $row->pat_id;
			$pak_credits = $row->pak_credits;
			$form_head = "Edit Details";
		}
	}
}
if(isset($_REQUEST['btnActive'])){
	for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
		mysql_query("UPDATE packages SET status_id = 1 WHERE pak_id = ".$_REQUEST['chkstatus'][$i]);
	}
	$msg_class='msg_box msg_ok';
	$strMSG = "Record(s) updated successfully";
}
if(isset($_REQUEST['btnInactive'])){
	for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
		mysql_query("UPDATE packages SET status_id = 0 WHERE pak_id = ".$_REQUEST['chkstatus'][$i]);
	}
	$msg_class='msg_box msg_ok';
	$strMSG = "Record(s) updated successfully";
}
if(isset($_REQUEST['btnDelete'])){
	for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
		mysql_query("DELETE FROM packages WHERE pak_id = ".$_REQUEST['chkstatus'][$i]);
		mysql_query("DELETE FROM package_cat_limits WHERE pak_id = ".$_REQUEST['chkstatus'][$i]);
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
                                <h1 class="sepH_c">Packages Management</h1>

								<?php if(isset($_REQUEST['reset'])){ ?>
                                <?php }else if(isset($_REQUEST['show'])){ ?>
                                    <div class="formEl_a">
                                    <fieldset class="sepH_b">
                                    <legend>Details</legend>
                                        <table cellpadding="0" cellspacing="0" border="0" class="table_a smpl_tbl">
                                        <?php
                                            $strQry = "SELECT pk.*, sc.sc_code, pkt.pktype_name, pt.pat_name FROM packages AS pk LEFT OUTER JOIN shortcodes AS sc ON pk.sc_id=sc.sc_id LEFT OUTER JOIN pak_type AS pkt ON pk.pktype_id=pkt.pktype_id LEFT OUTER JOIN pak_andor_type AS pt ON pk.pat_id=pt.pat_id WHERE pk.pak_id=".$_REQUEST['pak_id']." ";
                                            $rs = mysql_query($strQry);
                                            if(mysql_num_rows($rs)>0){
                                                $row=mysql_fetch_object($rs);
                                        ?>
                                            <tr>
                                                <td width="150" align="right">Name:</td>
                                                <td width="400" align="left" style="padding-left:4px;padding-right:4px;"><?php print($row->pak_name);?></td>
                                            </tr>
                                            <tr>
                                                <td align="right">Short Code:</td>
                                                <td align="left" style="padding-left:4px;padding-right:4px;"><?php echo $row->sc_code;?></td>
                                            </tr>
                                            <tr>
                                                <td align="right">Package:</td>
                                                <td align="left" style="padding-left:4px;padding-right:4px;"><?php echo $row->pktype_name;?></td>
                                            </tr>
                                            <!--<tr>
                                                <td align="right">Fee:</td>
                                                <td align="left" style="padding-left:4px;padding-right:4px;"><?php //echo $row->pak_fee;?></td>
                                            </tr>-->
                                            <tr>
                                                <td align="right">Status:</td>
                                                <td><?php echo (($row->status_id==1)?"<span class='notification ok_bg'>Active</span>":"<span class='notification alert_bg'>Not Active</span>");?> </td>
                                            </tr>
                                            <tr>
                                                <td align="right">Number of Downloads:</td>
                                                <td align="left" style="padding-left:4px;padding-right:4px;"><?php echo $row->pak_downloads;?></td>
                                            </tr>
											<tr>
                                                <td align="right">Download Categories:</td>
                                                <td align="left" style="padding-left:4px;padding-right:4px;"><?php print(getSelCat($row->pak_id, 1));?></td>
                                            </tr>
                                            <tr>
                                                <td align="right">Number of Streams:</td>
                                                <td align="left" style="padding-left:4px;padding-right:4px;"><?php echo $row->pak_streams;?></td>
                                            </tr>
											<tr>
                                                <td align="right">Stream Categories:</td>
                                                <td align="left" style="padding-left:4px;padding-right:4px;"><?php print(getSelCat($row->pak_id, 2));?></td>
                                            </tr>
                                            <tr>
                                                <td align="right">Number of Gifts:</td>
                                                <td align="left" style="padding-left:4px;padding-right:4px;"><?php echo $row->pak_gifts;?></td>
                                            </tr>
											<tr>
                                                <td align="right">Gift Categories:</td>
                                                <td align="left" style="padding-left:4px;padding-right:4px;"><?php print(getSelCat($row->pak_id, 3));?></td>
                                            </tr>
											<tr>
                                                <td align="right">AND/OR:</td>
                                                <td align="left" style="padding-left:4px;padding-right:4px;"><?php echo $row->pat_name;?></td>
                                            </tr>
											<tr>
                                                <td align="right">Credits:</td>
                                                <td align="left" style="padding-left:4px;padding-right:4px;"><?php print($row->pak_credits);?></td>
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
                                        <input type="button" name="btnCancel" class="submitButton" value="BACK" onClick="javascipt:window.location='manage_packages.php';">
                                    <?php } ?>
                                <?php } else if(isset($_REQUEST['action'])) {?>

									<form id="validateFormData" class="table-form" method="post" action="<?php echo $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'];?>">
                                        <div class="formEl_a">
                                            <fieldset class="sepH_b">
                                                <legend><?php print($form_head);?></legend>
                                                <div class="sepH_b">
                                                    <label for="a_textarea" class="lbl_a">Short Code:</label>
                                                    <select name="sc_id">
                                                        <?php FillSelected("shortcodes", "sc_id", "sc_code", $sc_id); ?>
                                                    </select>
                                                </div>
                                                <div class="sepH_b">
                                                    <label for="a_textarea" class="lbl_a">Package Type:</label>
                                                    <select name="pktype_id">
                                                        <?php FillSelected("pak_type", "pktype_id", "pktype_name", $pktype_id); ?>
                                                    </select>
                                                </div>
                                                <div class="sepH_b">
                                                    <label for="a_textarea" class="lbl_a">Package AND/OR:</label>
                                                    <select name="pktype_id">
                                                        <?php FillSelected("pak_andor_type", "pat_id", "pat_name", $pat_id); ?>
                                                    </select>
                                                </div>
												<div class="sepH_b">
                                                    <label for="mem_login" class="lbl_a">Credits:</label>
                                                    <input type="text" class="inpt_a required" name="pak_credits" value="<?php echo $pak_credits;?>" />
                                                </div>
												<div class="sepH_b">
                                                    <label for="mem_login" class="lbl_a">Name:</label>
                                                    <input type="text" class="inpt_a required" id="pak_name" name="pak_name" value="<?php echo $pak_name;?>" />
                                                </div>
                                                <!--<div class="sepH_b">
                                                    <label for="mem_password" class="lbl_a">Fee</label>
                                                    <input type="text" class="inpt_a required" id="pak_fee" name="pak_fee" value="<?php //echo $pak_fee;?>" />
                                                </div>-->
                                                <div class="sepH_b">
                                                    <label for="pak_downloads" class="lbl_a">Number of Downloads:</label>
                                                    <input type="text" class="inpt_b" id="pak_downloads" name="pak_downloads" value="<?php echo $pak_downloads;?>" />
                                                </div>
												<div class="sepH_b">
                                                    <label for="a_textarea" class="lbl_a">Download Categories:</label>
                                                    <select name="dn_cats[]" class="inpt_b required" multiple="multiple" size="4">
                                                        <?php FillMultiple_ParentCats("categories", "cat_id", "cat_name", "cat_parentid", "package_cat_limits", "cat_id", "plt_id", "pak_id", $pak_id, 1); ?>
                                                    </select>
                                                </div>
                                                <div class="sepH_b">
                                                    <label for="pak_streams" class="lbl_a">Number of Streams:</label>
                                                    <input type="text" class="inpt_b required" id="pak_streams" name="pak_streams" value="<?php echo $pak_streams;?>" />
                                                </div>
												<div class="sepH_b">
                                                    <label for="a_textarea" class="lbl_a">Stream Categories:</label>
                                                    <select name="st_cats[]" class="inpt_b" multiple="multiple" size="4">
                                                        <?php FillMultiple_ParentCats("categories", "cat_id", "cat_name", "cat_parentid", "package_cat_limits", "cat_id", "plt_id", "pak_id", $pak_id, 2); ?>
                                                    </select>
                                                </div>
                                                <div class="sepH_b">
                                                    <label for="pak_gifts" class="lbl_a">Number of Gifts:</label>
                                                    <input type="text" class="inpt_b required" id="pak_gifts" name="pak_gifts" value="<?php echo $pak_gifts;?>" />
                                                </div>
												<div class="sepH_b">
                                                    <label for="a_textarea" class="lbl_a">Gift Categories:</label>
                                                    <select name="gf_cats[]" class="inpt_b" multiple="multiple" size="4">
                                                        <?php FillMultiple_ParentCats("categories", "cat_id", "cat_name", "cat_parentid", "package_cat_limits", "cat_id", "plt_id", "pak_id", $pak_id, 3); ?>
                                                    </select>
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
													<th><div class="th_wrapp">Status</div></th>
													<th><div class="th_wrapp">Short Code</div></th>
													<th><div class="th_wrapp">Tenure</div></th>
													<th><div class="th_wrapp">Actions</div></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
																								$Query = "SELECT pk.*, sc.sc_code, pkt.pktype_name FROM packages AS pk LEFT OUTER JOIN shortcodes AS sc ON pk.sc_id=sc.sc_id LEFT OUTER JOIN pak_type AS pkt ON pk.pktype_id=pkt.pktype_id ";
                                                //$Query = "SELECT * FROM packages";
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
                                              <td class="chb_col" align="center"><input type="checkbox" name="chkstatus[]" value="<?php print($row->pak_id);?>" class="inpt_c1" /></td>
                                              <td  style="padding-left:4px;padding-right:4px;"><a href="<?php print($_SERVER['PHP_SELF']);?>?show=1&pak_id=<?php print($row->pak_id);?>" title="View Details"><?php print($row->pak_name);?></a></td>
                                              <td><?php echo (($row->status_id==1)?"<span class='notification ok_bg'>Active</span>":"<span class='notification alert_bg'>Not Active</span>");?> </td>
                                              <td><?php echo $row->sc_code;?></td>
                                              <td><?php echo $row->pktype_name;?></td>
                                              <td class="content_actions" width="10px">
                                                <a href="<?php print($_SERVER['PHP_SELF']."?action=2&pak_id=".$row->pak_id);?>" class="sepV_a" title="EDIT"><img src="images/icons/pencil_gray.png" alt="EDIT" /></a>
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
                                            <input type="submit" name="btnActive" class="submitButton" value="ACTIVE" />
                                            <input type="submit" name="btnInactive" class="submitButton" value="INACTIVE" />
                                        
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