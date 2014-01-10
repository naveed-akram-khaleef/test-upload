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
	$MaxID = getMaximum("subscribers","sub_id");
	$strQry="SELECT sub_id FROM subscribers WHERE sub_email = '".$_REQUEST['name']."'";
	$nResult =mysql_query($strQry) or die("Unable 2 Work");
	if (mysql_num_rows($nResult)>=1){ header("Location: manage_subscribers.php?op=3"); die(); }	
	$strQRY="INSERT INTO subscribers(sub_id, sub_email, sub_date) VALUES(".$MaxID.", '".str_replace("'", "''", $_REQUEST['email'])."', now())";
	$nRst=mysql_query($strQRY) or die(mysql_error());
	header("Location: manage_subscribers.php?op=1");
}
elseif(isset($_REQUEST['btnEdit'])){
	mysql_query("UPDATE subscribers SET sub_email='".str_replace("'", "''", $_REQUEST['email'])."' WHERE sub_id=".$_REQUEST['sub_id']);
	header("Location: manage_subscribers.php?op=2");
}
elseif((isset($_REQUEST['action'])) && ($_REQUEST['action']==2)){
	$FormHead = "Edit Details";
	$rs = mysql_query("SELECT * FROM subscribers WHERE sub_id=".$_REQUEST['sub_id']);
	if(mysql_num_rows($rs) > 0){
		$row = mysql_fetch_object($rs);
		$name = $row->sub_name; 
		$email = $row->sub_email; 
	}
}
else{
	$FormHead = "Add New";
	if(!isset($_REQUEST['btnAdd'])){
		$name = "";
		$email = "";
	}
}
if(isset($_REQUEST['btnDelete'])){
	if(isset($_REQUEST['chkstatus'])){
		for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
			mysql_query("DELETE FROM subscribers WHERE sub_id = ".$_REQUEST['chkstatus'][$i]);
		}
		header("Location: manage_subscribers.php?op=5");
	}
	else{
		header("Location: manage_subscribers.php?op=4");
	}
}
if(isset($_REQUEST['op'])){
	switch ($_REQUEST['op']) {
		case 1:
			$msg_class='msg_box msg_ok';
			$strMSG = "Record Added Successfully";
			break;
		case 2:
			$msg_class='msg_box msg_info';
			$strMSG = "Record Updated Successfully";
			break;
		case 3:
			$msg_class='msg_box msg_error';
			$strMSG = "Record Already Exists";
			break;
		case 4:
			$msg_class='msg_box msg_alert';
			$strMSG = "Please check atleast one checkbox";
			break;
		case 5:
			$msg_class='msg_box msg_error';
			$strMSG = "Record Deleted Successfully";
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
                                <h1 class="sepH_c"> Subscribers Management</h1>
								<?php	
                                    if(isset($_REQUEST['action']) == 1){
                                ?>
                                <form name="form" id="validateFormData" method="post" action="<?php @print($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);?>" enctype="multipart/form-data">
                                    <div class="formEl_a">
                                        <fieldset class="sepH_b">
                                            <legend><?php print($FormHead);?></legend>
                                            <div class="sepH_b">
                                                <label for="a_text" class="lbl_a">Email:</label>
                                                <input type="text" id="a_text" name="email" value="<?php print($email);?>" class="inpt_a required email" />
                                            </div>
                                        </fieldset>
                                        <?php
                                            if(isset($_REQUEST['action']) && $_REQUEST['action']==2){
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
                                                <input name="btnCancel" type="button" class="submitButton" value="BACK" onClick="javascript: window.location = 'manage_subscribers.php';">
                                    </div>
                                </form>
                                <?php
                                    } else {
                                ?>         
                                    <div class="sepH_a" align="right">
                                        <a href="<?php print($_SERVER['PHP_SELF']."?action=1");?>" title="Add New">Add New</a>
                                    </div>
                                    <form name="frm" id="frm" method="post" action="<?php @print($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);?>" enctype="multipart/form-data" onSubmit="return chkRequired(this);">
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="">
                        <thead>
                            <tr>
                                <th class="chb_col"  align="center" width="30"><div class="th_wrapp"><input type="checkbox" name="chkAll" onClick="setAll();"></div></th>
                                <!--<th><div class="th_wrapp">Name </div></th>-->
                                <th><div class="th_wrapp">Email </div></th>
                                <th><div class="th_wrapp">Date </div></th>
                                <th><div class="th_wrapp">Actions </div></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
							$Query = "SELECT * FROM subscribers ORDER BY sub_id ASC";
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
                                <td class="chb_col" align="center"><input type="checkbox" name="chkstatus[]" value="<?php print($row->sub_id);?>" class="inpt_c1" /></td>
                                <!--<td><?php //print($row->sub_name);?> </td>-->
                                <td><?php print($row->sub_email);?> </td>
                                <td><?php print($row->sub_date);?> </td>
                                <td class="content_actions" width="70px"><a href="<?php print($_SERVER['PHP_SELF']."?action=2&sub_id=".$row->sub_id);?>" class="sepV_a" title="Edit">
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