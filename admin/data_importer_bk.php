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
if(isset($_REQUEST['btnImport'])){
	if (!empty($_FILES["mFile"]["name"])){
		$mfileName = $_FILES["mFile"]["name"];
		if(move_uploaded_file($_FILES['mFile']['tmp_name'], "progress_bar_temp/".$mfileName)){

			error_reporting(E_ALL);
			ini_set('display_errors', TRUE);
			ini_set('display_startup_errors', TRUE);
			date_default_timezone_set('Europe/London');
			define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
			date_default_timezone_set('Europe/London');
			require_once 'php_excel/Classes/PHPExcel/IOFactory.php';
			include('php_excel/Classes/PHPExcel/Reader/Excel2007.php');
			$objPHPExcel = PHPExcel_IOFactory::load("progress_bar_temp/".$mfileName);
			
			foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
				$worksheetTitle     = $worksheet->getTitle();
				$highestRow         = $worksheet->getHighestRow(); // e.g. 10
				$highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
				$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
				$nrColumns = ord($highestColumn) - 64;
				//echo '<table border="5">';
				for ($row = 1; $row <= $highestRow; ++ $row) {
					$lang_id="";
					$pr_title="";
					$pr_short_details="";
					$pr_long_details="";
					$pr_meta_keyword="";
					$pr_meta_description="";
					$cat_id="";
					$prf_thumb="";
					$prf_file="";
					$prf_preview="";
					$ptype_id="";
					$is_featured=0;
					//echo '<tr>';
					for ($col = 0; $col < $highestColumnIndex; ++ $col) {
						$cell = $worksheet->getCellByColumnAndRow($col, $row);
						$val = $cell->getValue();
						$dataType = PHPExcel_Cell_DataType::dataTypeForValue($val);
						if($val!=''){
							echo '<td>' . $col.' '.$row.' '.$val. '<br></td>';
							if($row>1){
								if($val!=''){
									if($col==0){
										$lang_id = $val;
									}
									if($col==1){
										$pr_title = $val;
									}
									if($col==2){
										$pr_short_details = $val;
									}
									if($col==3){
										$pr_long_details = $val;
									}
									if($col==4){
										$pr_meta_keyword = $val;
									}
									if($col==5){
										$pr_meta_description = $val;
									}
									if($col==6){
										$cat_id = $val;
									}
									if($col==7){
										$is_featured = $val;
									}
									if($col==8){
										$prf_thumb = $val;
									}
									if($col==9){
										$prf_file = $val;
									}
									if($col==10){
										$prf_preview = $val;
									}
									if($col==11){
										$ptype_id = $val;
									}
								}
							}
						}
					}
					//echo '</tr>';
					if($row>1){
						//if($val!=''){
							//echo  " '".$lang_id."', '".$pr_title."', '".$pr_short_details."', '".$pr_long_details."', '".$pr_meta_keyword."', '".$pr_meta_description."', '".$cat_id."', '".$prf_thumb."', '".$prf_file."', '".$prf_preview."', '".$ptype_id."' , '".$is_featured."' <br/><br/>";

							$MaxID_pro = getMaximum("products","pr_id");
							mysql_query("INSERT INTO products (pr_id, pr_title, pr_short_details, pr_long_details, pr_meta_keyword, pr_meta_description, pr_added_date, cat_id, is_featured, mem_id) VALUES (".$MaxID_pro.", '".sql_str($pr_title)."', '".sql_str($pr_short_details)."', '".sql_str($pr_long_details)."', '".sql_str($pr_meta_keyword)."', '".sql_str($pr_meta_description)."', NOW(), '".sql_str($cat_id)."', '".sql_str($is_featured)."', '".sql_str($_SESSION['UID'])."')") or die(mysql_error());
	
							mysql_query("INSERT INTO products_ln (pr_id, lang_id, pr_title, pr_short_details, pr_long_details, pr_meta_keyword, pr_meta_description) VALUES (".$MaxID_pro.", '".sql_str($lang_id)."', '".sql_str($pr_title)."', '".sql_str($pr_short_details)."', '".sql_str($pr_long_details)."', '".sql_str($pr_meta_keyword)."', '".sql_str($pr_meta_description)."')") or die(mysql_error());
	
							$MaxID_file = getMaximum("pr_files","prf_id");
							mysql_query("INSERT INTO pr_files (prf_id, prf_thumb, prf_file, prf_preview, ptype_id, pr_id, mem_id, prf_added_date) VALUES (".$MaxID_file.", '".sql_str($prf_thumb)."', '".sql_str($prf_file)."', '".sql_str($prf_preview)."', '".sql_str($ptype_id)."', '".sql_str($MaxID_pro)."', '".sql_str($_SESSION['UID'])."', NOW())") or die(mysql_error());
						//}
					}
					//echo '</tr>';
					echo '</br></br>';
				}
				//echo '</table>';
				// $_SESSION['status_message'] = added_message();
				header("Location: data_importer.php?op=1");
			}
		}
	}
}
if(isset($_REQUEST['op'])){
	switch ($_REQUEST['op']) {
		case 1:
			$msg_class='msg_box msg_ok';
			$strMSG = "Record Added Successfully";
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
                            <h1 class="sepH_c">Import Data</h1>
                            <form name="form" id="validateFormData" method="post" action="<?php @print($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);?>" enctype="multipart/form-data">
                                <div class="formEl_a">
                                    <fieldset class="sepH_b">
                                        <legend> Excel Data Importer </legend>
                                        <div class="sepH_b">
                                            <label for="a_textarea" class="lbl_a">XLS/XLSX File</label>
                                            <input type="file" name="mFile" class="fileInputs medium required">
                                        </div>
                                        <input name="btnImport" type="submit" class="submitButton" value="Submit">
                                    </fieldset>
                                </div>
                            </form>   
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
