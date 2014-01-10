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
                            <div class="sepH_c">
                                <h1 class="sepH_c"> Subscriptions Report</h1>

                    <form name="form" id="validateFormData" method="post" action="manage_subscriptions.php" enctype="multipart/form-data">
                        <div class="formEl_a">
                            <fieldset class="sepH_b">
                                <legend> Search Subscriptions </legend>
                                <div class="sepH_b" id="extension">
									From: &nbsp;
                                    <input type="text" id="a_text" name="from" value="<?php echo @$_REQUEST['from']?>" class="inpt_b required datepicker" />&nbsp;

                                    To: &nbsp;
                                    <input type="text" id="b_text" name="to" value="<?php echo @$_REQUEST['to']?>" class="inpt_b required datepicker" />
                                    
                                    <br /><br />Package: &nbsp;
                                    <select name="pak_id">
                                        <option value="0"> Select Package</option>
                                        <?php FillSelected(" packages WHERE status_id=1 ", "pak_id", "pak_name", @$_REQUEST['pak_id']); ?>
                                    </select>&nbsp;&nbsp;
                                    <input name="btnSearch" type="submit" class="submitButton" value="Search">
                                </div>
                            </fieldset>
                        </div>
                    </form>

                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="">
                        <thead>
                            <tr>
                                <th><div class="th_wrapp">Pak Name </div></th>
                                <th><div class="th_wrapp">Member </div></th>
                                <th><div class="th_wrapp">Added On </div></th>
                                <th><div class="th_wrapp">Expired On </div></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
							$counter=0;
							$url='';
							$pak_id='';
							if(isset($_REQUEST['pak_id'])){
								$url = "&from=".$_REQUEST['from']."&to=".$_REQUEST['to']."&pak_id=".$_REQUEST['pak_id'];
								if($_REQUEST['pak_id']==0){
									$Query = "SELECT mph.*, m.mem_login, p.pak_name FROM my_package_history AS mph LEFT OUTER JOIN members AS m ON mph.mem_id=m.mem_id  LEFT OUTER JOIN packages AS p ON mph.pak_id=p.pak_id WHERE ( mph.mph_added_date >= '".$_REQUEST['from']."' AND  mph.mph_added_date <= '".$_REQUEST['to']."' ) ORDER BY mph.mph_id DESC"; 
								} else {
									$Query = "SELECT mph.*, m.mem_login, p.pak_name FROM my_package_history AS mph LEFT OUTER JOIN members AS m ON mph.mem_id=m.mem_id  LEFT OUTER JOIN packages AS p ON mph.pak_id=p.pak_id WHERE ( mph.mph_added_date >= '".$_REQUEST['from']."' AND  mph.mph_added_date <= '".$_REQUEST['to']."' ) AND mph.pak_id=".$_REQUEST['pak_id']." ORDER BY mph.mph_id DESC"; 
								}
							} else {
								$Query = "SELECT mph.*, m.mem_login, p.pak_name FROM my_package_history AS mph LEFT OUTER JOIN members AS m ON mph.mem_id=m.mem_id LEFT OUTER JOIN packages AS p ON mph.pak_id=p.pak_id ORDER BY mph.mph_id DESC"; 
							}
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
                                <td><?php print($row->pak_name);?> </td>
                                <td><?php print($row->mem_login);?> </td>
                                <td><?php print($row->mph_added_date);?> </td>
                                <td><?php print($row->mph_expiry);?> </td>
                            </tr>
						<?php
                                }
                            } else{
                        ?>
                                <tr><td colspan="100%" align="center"> No records found. </td></tr>
                        <?php
                            }
							//}
                        ?>
                        </tbody>
                    </table>
					<?php if($counter > 0) {?>
                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td><?php print("Page <b>".$_GET['page']."</b> of ".$pages);?>  - Total <?php echo $count; ?> Record(s) </td>
                                <td align="right">
                                <?php	
                                    $next_prev = $p->nextPrev($_GET['page'], $pages, $url);
                                    print($next_prev);
                                ?>
                                </td>
                            </tr>
                        </table>
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