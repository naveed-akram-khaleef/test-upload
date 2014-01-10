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


if(isset($_REQUEST['btnEdit'])){
	mysql_query("UPDATE site_config set site_name='".mysql_real_escape_string(str_replace("'", "''", $_POST['txt_name']))."', site_title='".mysql_real_escape_string(str_replace("'", "''", $_POST['txt_title']))."', site_keywords='".mysql_real_escape_string(str_replace("'", "''", $_POST['txt_keywords']))."', site_description='".mysql_real_escape_string(str_replace("'", "''", $_POST['txt_description']))."',site_status=1 WHERE site_id=".$_REQUEST['id']) or die(mysql_error());

	header("Location: manage_site_config.php?op=1");
}

if(isset($_GET['chk'])){
	if($_GET['chk']==1){
		if($_REQUEST["sid"] == 1){ 
			$status = 0;
		} else {
			$status = 1;
		}
		mysql_query("update site_config set site_status=".$status." where site_id=".$_GET['id']) or die(mysql_error());
		header("Location: manage_site_config.php?op=2");
	}
}	 

if(isset($_REQUEST['op'])){
	switch ($_REQUEST['op']) {
		case 1:
			$msg_class='msg_box msg_ok';
			$strMSG = "Site Configuration Updated Successfully";
			break;
		case 2:
			$msg_class='msg_box msg_ok';
			$strMSG = "Status Updated Successfully";
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
                                <h1 class="sepH_c">Site Configuration</h1>

			<?php
				if(isset($_GET['chk'])){
					if($_GET['chk']==2){
						$rss=mysql_query("select * from site_config where site_id=1") or die(mysql_error());
						$rows=mysql_fetch_array($rss);
			?>
            
       	<form name="form" method="post" action="<?php @print($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);?>" enctype="multipart/form-data">
            <div class="formEl_a">
                <fieldset class="sepH_b">
                    <legend>Update</legend>
                    <div class="sepH_b">
                        <label for="a_text" class="lbl_a">Name:</label>
                        <input type="text" id="a_text" name="txt_name" value="<?php print $rows['site_name']?>" class="inpt_a" />
                    </div>
                    <div class="sepH_b">
                        <label for="a_text" class="lbl_a">Title:</label>
                        <input type="text" id="a_text" name="txt_title" value="<?php print $rows['site_title']?>" class="inpt_a" />
                    </div>
                    <div class="sepH_b">
                        <label for="a_textarea" class="lbl_a">Keywords:</label>
                        <textarea id="a_textarea" name="txt_keywords"  cols="30" rows="10"><?php print $rows['site_keywords']?></textarea>
                    </div>
                    <div class="sepH_b">
                        <label for="a_textarea" class="lbl_a">Description:</label>
                        <textarea id="a_textarea" name="txt_description" cols="30" rows="10"><?php print $rows['site_description']?></textarea>
                    </div>
                </fieldset>
                <input name="btnEdit" type="submit" class="submitButton" value="UPDATE">
                <input type="button" class="submitButton" value="BACK" onClick="javascript: window.location = 'manage_site_config.php';">
            </div>
        </form>                  
			<?php
					}
				}
				else{
			?>
            
        <form name="frm" id="frm" method="post" action="<?php @print($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);?>" enctype="multipart/form-data" onSubmit="return chkRequired(this);">
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="data_table">
                <thead>
                    <tr>
                        <th width="30"><div class="th_wrapp">Serial </div></th>
                        <th><div class="th_wrapp">Name </div></th>
                        <th><div class="th_wrapp">Title </div></th>
                        <th><div class="th_wrapp">Keywords </div></th>
                        <th><div class="th_wrapp">Description </div></th>
                        <th><div class="th_wrapp">Status </div></th>
                        <th><div class="th_wrapp">Actions </div></th>
                    </tr>
                </thead>
                <tbody>
                <?php
					$counter=0;
					$rs=mysql_query("SELECT s.site_id, s.site_name, s.site_title, s.site_keywords, s.site_description, s.site_status FROM site_config AS s") or die(mysql_error());
					while($row=mysql_fetch_array($rs))
					{	
						$counter++;
                ?>
                    <tr>
                        <td align="center"><?php echo $counter;?></td>
                        <td><?php print $row['site_name']?> </td>
                        <td><?php print $row['site_title']?> </td>
                        <td><?php print $row['site_keywords']?> </td>
                        <td><?php print $row['site_description']?> </td>
                        <td><a href="manage_site_config.php?chk=1&id=<?php print $row['site_id'] ?>&sid=<?php print $row['site_status']?>"><?php echo (($row['site_status']==0)?'Inactive':'Active');?></a> </td>
                        <td class="content_actions" width="70px">
                        	<a href="manage_site_config.php?chk=2&id=<?php print $row['site_id']?>" class="sepV_a" title="Edit"><img src="images/icons/pencil_gray.png" alt="" /></a></td>
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