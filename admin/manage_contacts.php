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
$msg_class="";
$strMSG = "";
$FormHead = "";
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
                                <h1 class="sepH_c"> Feedback Management</h1>

					<?php
						if(isset($_REQUEST['show'])){
					?>	
            <div class="formEl_a">
                <fieldset class="sepH_b">
                    <legend>Details</legend>
                    	<table cellpadding="0" cellspacing="0" border="0" class="table_a smpl_tbl">
                    <?php    
							$Query = "SELECT * FROM contact_us_request WHERE cu_id=".$_REQUEST["id"]." LIMIT 1";
							$rs = mysql_query($Query);
							if(mysql_num_rows($rs)>0){
								while($row=mysql_fetch_object($rs)){
									$Query1 = "UPDATE contact_us_request SET is_viewed=1 WHERE cu_id=".$_REQUEST["id"]."";
									mysql_query($Query1);	
					?>
							<tr>
								<td>Name:</td>
								<td><?php print($row->cu_name);?></td>
							</tr>
							<tr>
								<td>Email:</td>
								<td><?php print($row->cu_email);?></td>
							</tr>
							<tr>
								<td>Phone:</td>
								<td><?php print($row->cu_phone);?></td>
							</tr>
							<tr>
								<td>Comment:</td>
								<td><?php print($row->cu_comment);?></td>
							</tr>
							<tr>
								<td>Date:</td>
								<td><?php print($row->date);?></td>
							</tr>
<!--							<tr>
								<td>Product Details:</td>
								<td><a href="manage_products.php?show=1&pro_id=<?php print($row->pro_id);?>"> See Product Details </a></td>
							</tr>-->
							<?php
                                    }
                                }
                                else{	
                            ?>
                                    <tr><td colspan="20" align="center" class="ListRow1">No Record Found</td></tr>
                            <?php
                                }
                            ?>
                        </table>
                    </fieldset>
                </div>
                <input type="button" name="btnCancel" class="submitButton" value="BACK" onClick="javascript: window.location= 'manage_contacts.php';">            


					<?php
						} else {
					?>


                
                <form name="frm" method="post" action="<?php @print($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);?>" enctype="multipart/form-data" onSubmit="return chkRequired(this);">
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="">
                        <thead>
                            <tr>
                                <th><div class="th_wrapp">Name</div></th>
                                <th><div class="th_wrapp">Email</div></th>
                                <th><div class="th_wrapp">Status</div></th>
                                <th><div class="th_wrapp">Details </div></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
							$Query = "SELECT * FROM contact_us_request ORDER BY cu_id DESC";
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
                                <td><?php print($row->cu_name);?> </td>
                                <td><?php print($row->cu_email);?> </td>
                                <td><?php echo (($row->is_viewed==1)?"<span class='notification ok_bg'>Viewed</span>":"<span class='notification alert_bg'>Pending</span>");?> </td>
                                <td><a href="manage_contacts.php?show=1&id=<?php print($row->cu_id);?>">View</a></td>
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