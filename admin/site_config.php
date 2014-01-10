<?php
ob_start();
include("../lib/openCon.php");
include("../lib/functions.php");
session_start();
if(!isset($_SESSION['UID'])){
	header("location: login.php");
}
include("includes/php_includes_top.php");
$msg_class='';
$strMSG = "";
$FormHead = "";

if(isset($_GET['chk'])){
	if($_GET['chk']==1){
		mysql_query("UPDATE site_config set config_sitename='".$_POST['txt_name']."',config_sitetitle='".$_POST['txt_title']."',config_site_email='".$_POST['config_site_email']."',config_metakey='".$_POST['txt_keyword']."',config_metades='".$_POST['txt_details']."',config_upload_limit=".$_POST['txt_upload']." where config_id=".$_POST['txt_id']) or die(mysql_error());
		$msg_class='msg_box msg_ok';
		$strMSG = "Site Configuration Updated Successfully";
	}
	elseif($_GET['chk']==2){
		if($_GET['sid']==1){
			$st=0;
		}
		else{
			$st=1;
		}
		mysql_query("update site_config set status_id=".$st." where config_id=".$_GET['cid']) or die(mysql_error());
		$msg_class='msg_box msg_ok';
		$strMSG = "Status Updated Successfully";
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
						<?php if($strMSG != ''){?>
                            <div class="<?php echo $msg_class;?>"><?php echo $strMSG;?><img src="images/blank.gif" class="msg_close" alt="" /></div>
                        <?php }?>
                            <div class="sepH_c">
                                <h1 class="sepH_c">Site Configuration</h1>

								<?php
									if(isset($_GET['op'])){
										if($_GET['op']==1){
											$rss=mysql_query("select * from site_config where config_id=1") or die(mysql_error());
											$rows=mysql_fetch_array($rss);
                                ?>
                                            <form name="form" method="post" action="<?php ?>site_config.php?chk=1" enctype="multipart/form-data">
                                                <div class="formEl_a">
                                                    <fieldset class="sepH_b">
                                                        <legend>Update</legend>
                                                        <div class="sepH_b">
                                                            <label for="a_text" class="lbl_a">Site Name:</label>
                                                            <input type="text" id="a_text" name="txt_name" value="<?php print $rows['config_sitename']?>" class="inpt_a" />
                                                        </div>
                                                        <div class="sepH_b">
                                                            <label for="a_text" class="lbl_a">Title:</label>
                                                            <input type="text" id="a_text" name="txt_title" value="<?php print $rows['config_sitetitle']?>" class="inpt_a" />
                                                        </div>
                                                        <div class="sepH_b">
                                                            <label for="a_text" class="lbl_a">Site Email:</label>
                                                            <input type="text" id="a_text" name="config_site_email" value="<?php print $rows['config_site_email']?>" class="inpt_a" />
                                                        </div>
                                                        <div class="sepH_b">
                                                            <label for="a_textarea" class="lbl_a">Meta Keyword:</label>
                                                            <textarea id="a_textarea" name="txt_keyword"  cols="30" rows="10" style="resize:none;"><?php print $rows['config_metakey']?></textarea>
                                                        </div>
                                                        <div class="sepH_b">
                                                            <label for="a_textarea" class="lbl_a">Meta Description:</label>
                                                            <textarea id="a_textarea" name="txt_details" cols="30" rows="10"><?php print $rows['config_metades']?></textarea>
                                                        </div>
                                                    </fieldset>
                                                    <input type="hidden" name="txt_id" value="<?php print @$rows['config_id']?>" >
                                                    <input type="hidden" name="txt_upload" value="<?php print @$rows['config_upload_limit']?>" >
                                                    <input type="submit" name="Submit" class="submitButton" value="SAVE">
                                                    <input type="button" class="submitButton" value="BACK" onClick="javascript: window.location = '<?php @print($_SERVER['HTTP_REFERER']);?>';">
                                                </div>
                                            </form>                  
                                <?php
                                        }
                                    } else {
                                ?>
                                        <form name="frm" id="frm" method="post" action="<?php @print($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);?>" enctype="multipart/form-data" onSubmit="return chkRequired(this);">
                                            <table cellpadding="0" cellspacing="0" border="0" class="display" id="data_table">
                                                <thead>
                                                    <tr>
                                                        <th width="30"><div class="th_wrapp">Serial </div></th>
                                                        <th><div class="th_wrapp">Site Name </div></th>
                                                        <th><div class="th_wrapp">Title </div></th>
                                                        <th><div class="th_wrapp">Status </div></th>
                                                        <th><div class="th_wrapp">Actions </div></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    $counter=0;
                                                    $rs=mysql_query("select  site_config.config_sitename,site_config.config_sitetitle,site_config.config_id,status.status_id,status.status_name from site_config,status where site_config.status_id=status.status_id") or die(mysql_error());
                                                    while($row=mysql_fetch_array($rs))
                                                    {	
                                                        $counter++;
                                                ?>
                                                    <tr>
                                                        <td align="center"><?php echo $counter;?></td>
                                                        <td><?php print $row['config_sitename']?> </td>
                                                        <td><?php print $row['config_sitetitle']?> </td>
                                                        
                                                        <td><a href="site_config.php?chk=2&cid=<?php print $row['config_id'] ?>&sid=<?php print $row['status_id']?>"><?php print $row['status_name']?></a> - <?php echo (($row['status_id']==1)?"<span class='notification info_bg'>Currently Active</span>":"<span class='notification error_bg'>Currently Not Active</span>");?></td>
                                                        
                                                        <td class="content_actions" width="70px"><a href="site_config.php?op=1&sid=<?php print $row['config_id']?>" class="sepV_a" title="Edit">
                                <img src="images/icons/pencil_gray.png" alt="" />
                                </a> </td>
                                                    </tr>
                                                <?php
                                                        }
                                                ?>
                                                </tbody>
                                            </table>
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