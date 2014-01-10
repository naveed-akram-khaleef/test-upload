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
	if(isset($_REQUEST['yes_no'])){
		$price = $_REQUEST['cs_price'];
		$is_price = 1;
	} else {
		$price = 0;
		$is_price = 0;
	}
	$MaxID = getMaximum("shortcodes","sc_id");
	$strQry="SELECT sc_id FROM shortcodes WHERE sc_code = '".$_REQUEST['sc_code']."'";
	$nResult =mysql_query($strQry) or die("Unable 2 Work");
	if (mysql_num_rows($nResult)>=1){ header("Location: manage_shortcodes.php?op=3"); die(); }	
	$strQRY="INSERT INTO shortcodes (sc_id, sc_code, sctype_id, cs_isprice, cs_price) VALUES (".$MaxID.", '".str_replace("'", "''", $_REQUEST['sc_code'])."', '".str_replace("'", "''", $_REQUEST['sctype_id'])."', '".$is_price."', '".$price."')";
	$nRst=mysql_query($strQRY) or die(mysql_error());
	header("Location: manage_shortcodes.php?op=1");
}
elseif(isset($_REQUEST['btnEdit'])){

	if(isset($_REQUEST['yes_no'])){
		$price = $_REQUEST['cs_price'];
		$is_price = 1;
	} else {
		if($_REQUEST['cs_price']!=''){
			$price = $_REQUEST['cs_price'];
			$is_price = 1;
		} else {
			$price = 0;
			$is_price = 0;
		}
	}

	mysql_query("UPDATE shortcodes SET sc_code ='".str_replace("'", "''", $_REQUEST['sc_code'])."', sctype_id ='".str_replace("'", "''", $_REQUEST['sctype_id'])."', cs_isprice ='".$is_price."', cs_price ='".$price."' WHERE sc_id=".$_REQUEST['sc_id']);
	header("Location: manage_shortcodes.php?op=2");
}
elseif((isset($_REQUEST['action'])) && ($_REQUEST['action']==2)){
	$FormHead = "Edit Details";
	$rs = mysql_query("SELECT * FROM shortcodes WHERE sc_id=".$_REQUEST['sc_id']);
	if(mysql_num_rows($rs) > 0){
		$row = mysql_fetch_object($rs);
		$sc_code = $row->sc_code;
		$sctype_id = $row->sctype_id;
		$cs_isprice = $row->cs_isprice;
		$cs_price = $row->cs_price;
	}
}
else{
	$FormHead = "Add New Details";
	if(!isset($_REQUEST['btnAdd'])){
		$sc_code = "";
		$sctype_id = "";
		$cs_isprice = "";
		$cs_price = "";
	}
}

if(isset($_REQUEST['btnDelete'])){
	if(isset($_REQUEST['chkstatus'])){
		for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
			mysql_query("DELETE FROM shortcodes WHERE sc_id = ".$_REQUEST['chkstatus'][$i]);
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
                                <h1 class="sepH_c">Short Codes Management</h1>

						<?php
                            if(isset($_REQUEST['show'])){
                        ?>		
                            <div class="formEl_a">
                                <fieldset class="sepH_b">
                                    <legend>Details</legend>
                                    <table cellpadding="0" cellspacing="0" border="0" class="table_a smpl_tbl">
                                    <?php
                                        $Query="SELECT sc.*, sct.sctype_name FROM shortcodes AS sc LEFT OUTER JOIN shortcode_type AS sct ON sc.sctype_id=sct.sctype_id WHERE sc.sc_id='".$_REQUEST["sc_id"]."' ";
                                        $rs = mysql_query($Query);
                                        if(mysql_num_rows($rs)>0){
                                            $row=mysql_fetch_object($rs);	
                                    ?>
                                        <tr>
                                            <td>Short Code:</td>
                                            <td><?php print($row->sc_code);?></td>
                                        </tr>
                                        <tr>
                                            <td>Type:</td>
                                            <td><?php print($row->sctype_name);?></td>
                                        </tr>
                                        <tr>
                                            <td>Price:</td>
                                            <td><?php if($row->cs_isprice==1){ echo $row->cs_price; }else {?>
                                            	<span class='notification alert_bg'>Not Set</span>
                                            <?php }?> </td>
                                        </tr>
                                    <?php
                                        }
                                    ?>
                                    </table>
                                </fieldset>
                            </div>
                           <input type="button" name="btnCancel" class="submitButton" value="BACK" onClick="javascript: window.location= 'manage_shortcodes.php';">  
						<?php	
                            } else  if(isset($_REQUEST['action']) == 1){
						?>
                            <form name="form" id="validateFormData" method="post" action="<?php @print($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);?>" enctype="multipart/form-data">
                                <div class="formEl_a">
                                    <fieldset class="sepH_b">
                                        <legend><?php print($FormHead);?></legend>
                                        <div class="sepH_b">
                                            <label for="a_text" class="lbl_a">Short Code:</label>
                                            <input type="text" id="a_text" name="sc_code" value="<?php print($sc_code);?>" class="inpt_a required" />
                                        </div>
                                        <div class="sepH_b">
                                            <label for="a_textarea" class="lbl_a">Type:</label>
                                            <select name="sctype_id">
                                                <?php FillSelected("shortcode_type", "sctype_id", "sctype_name", $sctype_id); ?>
                                            </select>
                                        </div>
																				<?php if($cs_isprice!=1){?>
                                          <div class="sepH_c cf" onclick="show_hide();">
                                            <label class="lbl_a">Do you want to enter price:</label>
                                            <div class="lblSpace">
                                              <div>
                                                <input type="checkbox" id="agree_disagree" name="yes_no" class="agree_disagree_checkbox" <?php echo (($cs_isprice==1)?'checked="checked"':'');?>/>
                                                <span class="f_help">Default: NO</span>
                                              </div>
                                            </div>
                                          </div>
                                      <?php }?>
																				<?php if($cs_isprice==1){?>
                                          <div id="">
                                            <div class="sepH_b">
                                                <label for="a_textarea" class="lbl_a">Fee:</label>
                                                <input type="text" id="a_text" name="cs_price" value="<?php print(@$cs_price);?>" class="inpt_a required" />
                                            </div>
                                          </div>
                                        <?php } else {?>
                                          <div id="response">
                                            <div class="sepH_b">
                                                <label for="a_textarea" class="lbl_a">Fee:</label>
                                                <input type="text" id="a_text" name="cs_price" value="<?php print(@$cs_price);?>" class="inpt_a required" />
                                            </div>
                                          </div>
                                        <?php }?>
                                        <script language="javascript">
																					var counter=0;
																					document.getElementById('response').style.display='none';
																					document.getElementById('response').style.visibility='hidden';
																					function show_hide(){
																						counter++;
																						if(counter%2==1){
																							document.getElementById('response').style.display='block';
																							document.getElementById('response').style.visibility='visible';
																						} else {
																							document.getElementById('response').style.display='none';
																							document.getElementById('response').style.visibility='hidden';
																						}
																					}
																				</script>
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
                                            <input name="btnCancel" type="button" class="submitButton" value="BACK" onClick="javascript: window.location = 'manage_shortcodes.php';">
                                </div>
                            </form>   
						<?php
							} else {
						?>         
                            <div class="sepH_a" align="right">
                                <a href="<?php print($_SERVER['PHP_SELF']."?action=1");?>" sc_code="Add New">Add New</a>
                            </div>
                            <form name="frm" id="frm" method="post" action="<?php @print($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);?>" enctype="multipart/form-data" onSubmit="return chkRequired(this);">
                                <table cellpadding="0" cellspacing="0" border="0" class="display" id="">
                                    <thead>
                                        <tr>
                                            <th class="chb_col"  align="center" width="30"><div class="th_wrapp"><input type="checkbox" name="chkAll" onClick="setAll();"></div></th>
                                            <th><div class="th_wrapp">Short Code</div></th>
                                            <th><div class="th_wrapp">Type</div></th>
                                            <th><div class="th_wrapp">Price</div></th>
                                            <th><div class="th_wrapp">Details</div></th>
                                            <th><div class="th_wrapp">Actions </div></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
																		
										$Query="SELECT sc.*, sct.sctype_name FROM shortcodes AS sc LEFT OUTER JOIN shortcode_type AS sct ON sc.sctype_id=sct.sctype_id ";
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
                                            <td class="chb_col" align="center"><input type="checkbox" name="chkstatus[]" value="<?php print($row->sc_id);?>" class="inpt_c1" /></td>
                                            <td><?php echo limit_text($row->sc_code,20);?> </td>
                                            <td><?php echo limit_text($row->sctype_name,20);?> </td>
                                            <td><?php if($row->cs_isprice==1){ echo $row->cs_price; }else {?>
                                            	<span class='notification alert_bg'>Not Set</span>
                                            <?php }?> </td>
                                            <td><a href="<?php echo $_SERVER['PHP_SELF']."?show=1&sc_id=".$row->sc_id;?>"> View </a></td>
                                            <td class="content_actions" width="70px"><a href="<?php print($_SERVER['PHP_SELF']."?action=2&sc_id=".$row->sc_id);?>" class="sepV_a" sc_code="Edit">
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