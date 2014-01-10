<?php
ob_start();
session_start();
include("../lib/openCon.php");
include("../lib/functions.php");
if(!isset($_SESSION['UID'])){
	header("location: login.php");
}
include("includes/php_includes_top.php");
$msg_class = "";
$strMSG = "";
$FormHead = "";

if(isset($_REQUEST['btnAdd'])){
	$MaxID_mem = getMaximum("members","mem_id");

	$rs = mysql_query("SELECT * FROM packages WHERE pak_id=".$_REQUEST['pak_id']);
	$row = mysql_fetch_object($rs);
	$vdownload = $row->pak_videos_downloads;
	$vstream = $row->pak_videos_streams;
	$adownload = $row->pak_audios_downloads;
	$astream = $row->pak_audios_streams;
	$wdownload = $row->pak_wallpapers_downloads;
	$rdownload = $row->pak_ringtones_downlaods;
	$pgifts = $row->pak_gifts;

	$MaxID_pak = getMaximum("mem_pak_limits","mpl_id");
	mysql_query("INSERT INTO mem_pak_limits (mpl_id, mem_id, pak_videos_downloads, pak_videos_streams, pak_audios_downloads, pak_audios_streams, pak_ringtones_downlaods, pak_wallpapers_downloads, pak_gifts) VALUES('".$MaxID_pak."', '".$MaxID_mem."', '".$vdownload."', '".$vstream."', '".$adownload."', '".$astream."', '".$rdownload."', '".$wdownload."', '".$pgifts."')") or die(mysql_error());

	mysql_query("INSERT INTO members (mem_id, mem_fname, mem_lname, mem_email, mem_login, mem_password, mem_phone, mem_address, mem_city, mem_state, mem_zcode, mem_datecreated, pak_id) VALUES(".$MaxID_mem.", '".$_REQUEST['mem_fname']."', '".$_REQUEST['mem_lname']."', '".$_REQUEST['mem_email']."', '".$_REQUEST['mem_login']."', '".(md5($_REQUEST['mem_password']))."', '".$_REQUEST['mem_phone']."', '".$_REQUEST['mem_address']."', '".$_REQUEST['mem_city']."', '".$_REQUEST['mem_state']."', '".$_REQUEST['mem_zcode']."', NOW(), '".$_REQUEST['pak_id']."') ") or die(mysql_error());
	header("Location: manage_members.php?op=2");
}
if(isset($_REQUEST['btnEdit'])){
	mysql_query("UPDATE members SET mem_fname='".mysql_real_escape_string(str_replace("'", "''", $_REQUEST['mem_fname']))."', mem_lname='".mysql_real_escape_string(str_replace("'", "''", $_REQUEST['mem_lname']))."', mem_login='".$_REQUEST['mem_login']."', mem_phone='".mysql_real_escape_string(str_replace("'", "''", $_REQUEST['mem_phone']))."', mem_address='".mysql_real_escape_string(str_replace("'", "''", $_REQUEST['mem_address']))."', mem_city='".mysql_real_escape_string(str_replace("'", "''", $_REQUEST['mem_city']))."', mem_state='".mysql_real_escape_string(str_replace("'", "''", $_REQUEST['mem_state']))."', mem_zcode='".mysql_real_escape_string(str_replace("'", "''", $_REQUEST['mem_zcode']))."', mem_lastupdated=NOW(), pak_id='".$_REQUEST['pak_id']."' WHERE mem_id='".$_REQUEST['id']."' ") or die(mysql_error());
	header("Location: manage_members.php?op=3");
}
if(isset($_REQUEST['id'])){
	$rs = mysql_query("SELECT * FROM members WHERE mem_id=".$_REQUEST['id']);
	if(mysql_num_rows($rs) > 0){
		$row = mysql_fetch_object($rs);
		$pak_id = $row->pak_id;
		$mem_fname = $row->mem_fname;
		$mem_lname = $row->mem_lname;
		$mem_login = $row->mem_login;
		$mem_email = $row->mem_email;
		$mem_password = $row->mem_password;
		$mem_phone = $row->mem_phone;
		$mem_address = $row->mem_address;
		$mem_city = $row->mem_city;
		$mem_state = $row->mem_state;
		$mem_zcode = $row->mem_zcode;
	} else {
		$pak_id = "";
		$mem_fname = "";
		$mem_lname = "";
		$mem_login = "";
		$mem_email = "";
		$mem_password = "";
		$mem_phone = "";
		$mem_address = "";
		$mem_city = "";
		$mem_state = "";
		$mem_zcode = "";
	}
} else {
	$pak_id = "";
	$mem_fname = "";
	$mem_lname = "";
	$mem_login = "";
	$mem_email = "";
	$mem_password = "";
	$mem_phone = "";
	$mem_address = "";
	$mem_city = "";
	$mem_state = "";
	$mem_zcode = "";
}
if(isset($_REQUEST['op'])){
	switch ($_REQUEST['op']) {
		case 1:
			$msg_class='msg_box msg_ok';
			$strMSG = "Updated Successfully";
			break;
		case 2:
			$msg_class='msg_box msg_ok';
			$strMSG = "Added Successfully";
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
                                <h1 class="sepH_c"> Member Profile </h1>
                           
                                <form name="form" method="post" action="<?php @print($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);?>" enctype="multipart/form-data" class="formEl_a">
                                    <div class="cf formEl sepH_b">
                                        <div class="dp25 tac">
                                            <img alt="" src="images/user_noPhoto100.gif" />
                                        </div>
                                        <div class="dp75">
                                            <dt><label>Package</label></dt>
                                            <dd>
                                                <select name="pak_id">
                                                    <?php FillSelected("packages", "pak_id", "pak_name", @$pak_id); ?>
                                                </select>
                                            </dd>
                                            <div class="sepH_b">
                                                <label for="username" class="lbl_a">First Name</label>
                                                <input type="text" class="inpt_a" name="mem_fname" value="<?php echo $mem_fname;?>"/>
                                            </div>
                                            <div class="sepH_b">
                                                <label for="username" class="lbl_a">Last Name</label>
                                                <input type="text" class="inpt_a" name="mem_lname" value="<?php echo $mem_lname;?>"/>
                                            </div>
                                            <?php if(isset($_REQUEST['id'])){?>
                                                <div class="sepH_b">
                                                    <label for="fname" class="lbl_a">Login/ Username</label>
                                                    <input type="text" class="inpt_a" id="fname" name="mem_login" value="<?php echo $mem_login;?>" />
                                                </div>
                                                <div class="sepH_b">
                                                    <label for="fname" class="lbl_a">Email</label>
                                                    <input type="text" class="inpt_a" id="fname" name="mem_email" value="<?php echo $mem_email;?>" disabled="disabled" readonly="readonly" />
                                                </div>
                                                <div class="sepH_b">
                                                    <label for="fname" class="lbl_a">Password</label>
                                                    <input type="password" class="inpt_a" id="fname" name="mem_password" value="<?php echo $mem_password;?>" disabled="disabled" readonly="readonly" />
                                                </div>
                                            <?php } else {?>
                                                <div class="sepH_b">
                                                    <label for="fname" class="lbl_a">Login/ Username</label>
                                                    <input type="text" class="inpt_a" id="fname" name="mem_login" value="<?php echo $mem_login;?>" />
                                                </div>
                                                <div class="sepH_b">
                                                    <label for="fname" class="lbl_a">Email</label>
                                                    <input type="text" class="inpt_a" id="fname" name="mem_email" value="<?php echo $mem_email;?>" />
                                                </div>
                                                <div class="sepH_b">
                                                    <label for="fname" class="lbl_a">Password</label>
                                                    <input type="password" class="inpt_a" id="fname" name="mem_password" value="<?php echo $mem_password;?>" />
                                                </div>
                                            <?php }?>
                                            <div class="sepH_b">
                                                <label for="fname" class="lbl_a">Phone</label>
                                                <input type="text" class="inpt_a" id="fname" name="mem_phone" value="<?php echo $mem_phone;?>"/>
                                            </div>
                                            <div class="sepH_b">
                                                <label for="a_textarea" class="lbl_a">Address</label>
                                                <textarea id="a_textarea" name="mem_address" cols="30" rows="10"><?php print($mem_address);?></textarea>
                                            </div>
                                            <div class="sepH_b">
                                                <label for="fname" class="lbl_a">City</label>
                                                <input type="text" class="inpt_a" id="fname" name="mem_city" value="<?php echo $mem_city;?>"/>
                                            </div>
                                            <div class="sepH_b">
                                                <label for="fname" class="lbl_a">State</label>
                                                <input type="text" class="inpt_a" id="fname" name="mem_state" value="<?php echo $mem_state;?>"/>
                                            </div>
                                            <div class="sepH_b">
                                                <label for="fname" class="lbl_a">Zip Code</label>
                                                <input type="text" class="inpt_a" id="fname" name="mem_zcode" value="<?php echo $mem_zcode;?>"/>
                                            </div>
											<?php if(isset($_REQUEST['id'])){?>
                                                <input name="btnEdit" type="submit" class="submitButton" value="UPDATE">
                                            <?php } else {?>
                                                <input name="btnAdd" type="submit" class="submitButton" value="ADD">
                                            <?php }?>
                                            <input name="btnCancel" type="button" class="submitButton" value="BACK" onClick="javascript: window.location = 'manage_members.php';" />
                                        </div>
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