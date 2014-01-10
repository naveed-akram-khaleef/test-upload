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

if(isset($_REQUEST['btnAdd'])){
	$link_id = getMaximum("social_links","link_id");
	$mfileName = "";
	$dirName = "../images/socials/";
	if (!empty($_FILES["mFile"]["name"])){
		$mfileName = $link_id."_".$_FILES["mFile"]["name"];
		if(move_uploaded_file($_FILES['mFile']['tmp_name'], $dirName."/".$mfileName)){
		}
	}
	mysql_query("INSERT INTO social_links (link_id, link_title, link_url, link_file) VALUES (".$link_id.",'".$_REQUEST['txtname']."','".$_REQUEST['txtdetails']."', '".$mfileName."')");
	header("Location: manage_social_networks.php?op=1");
}
elseif(isset($_REQUEST['btnEdit'])){
	$dirName = "../images/socials/";
	$mfileName = $_REQUEST['mfileName'];
	if (!empty($_FILES["mFile"]["name"])){
		@unlink("../images/socials/".$_REQUEST['mfileName']);
		$mfileName = $_REQUEST['link_id']."_".$_FILES["mFile"]["name"];
		if(move_uploaded_file($_FILES['mFile']['tmp_name'], $dirName."/".$mfileName)) {
		}
	}
mysql_query("UPDATE social_links SET link_title='".$_REQUEST['txtname']."', link_url ='".$_REQUEST['txtdetails']."' , link_file='".$mfileName."'  
WHERE link_id = ".$_REQUEST['link_id'] );
	header("Location: manage_social_networks.php?op=2");
}
elseif(isset($_REQUEST['action'])){
	if($_REQUEST['action'] == 2){
		$FormHead = "Edit Social Network's Information";
		$grs = mysql_query("SELECT * FROM social_links WHERE link_id = ".$_REQUEST['link_id']);
		if(mysql_num_rows($grs) > 0){
			$grow = mysql_fetch_object($grs);
			$txtname	= $grow->link_title;
			$txtdetails = $grow->link_url;
			$mfileName  = $grow->link_file;
		}
	}
	else{
		$FormHead = "Add New Social Link";
		if(!isset($_REQUEST['btnAdd'])){
			$txtname	= "";
			$txtdetails = "";
			$mfileName  = "";
		}
	}
}
if(isset($_REQUEST['btnActive'])){
	if(isset($_REQUEST['chkstatus'])){
		for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
			mysql_query("UPDATE social_links SET status_id=1 WHERE link_id = ".$_REQUEST['chkstatus'][$i]);
		}
		$msg_class='msg_box msg_ok';
		$strMSG = "Updated successfully";
	}
	else{
		$msg_class='msg_box msg_alert';
		$strMSG = "Please check atleast one checkbox";
	}
}
if(isset($_REQUEST['btnInActive'])){
	if(isset($_REQUEST['chkstatus'])){
		for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
			mysql_query("UPDATE social_links SET status_id=0 WHERE link_id = ".$_REQUEST['chkstatus'][$i]);
		}
		$msg_class='msg_box msg_ok';
		$strMSG = "Updated successfully";
	}
	else{
		$msg_class='msg_box msg_alert';
		$strMSG = "Please check atleast one checkbox";
	}
}
if(isset($_REQUEST['btnDelete'])){ 
	if(isset($_REQUEST['chkstatus'])){
		for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
			$getID = $_REQUEST['chkstatus'][$i];
			@unlink("../images/socials/".$_REQUEST['imgFile_'.$getID]);
			mysql_query("DELETE FROM social_links WHERE link_id = ".$_REQUEST['chkstatus'][$i]);
		}
		$msg_class='msg_box msg_ok';
		$strMSG = "Deleted successfully";
	}
	else{
		$msg_class='msg_box msg_alert';
		$strMSG = "Please check atleast one checkbox";
	}
}
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
                                <h1 class="sepH_c">Social Networks Management</h1>


            <?php
                if(isset($_REQUEST['action']) && $_REQUEST['action']==1){
            ?>
              <form name="form" id="validateFormData" method="post" action="<?php @print($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);?>" enctype="multipart/form-data">
                  <div class="formEl_a">
                      <fieldset class="sepH_b">
                          <legend><?php print($FormHead);?></legend>
                          <div class="sepH_b">
                              <label for="a_text" class="lbl_a">Name:</label>
                              <input type="text" id="a_text" name="txtname" value="<?php print($txtname);?>" class="inpt_a required" />
                          </div>
                          <div class="sepH_b">
                              <label for="a_textarea" class="lbl_a">Link to Website:</label>
                              <input type="text" id="a_text" name="txtdetails" value="<?php print($txtdetails);?>" class="inpt_a" />
                          </div>
                          <div class="sepH_b">
                              <label for="a_text" class="lbl_a">File:</label>
                              <input type="file"name="mFile" class="fileInputs" />
                          </div>                        
                      </fieldset>
  
                      <input type="hidden" name="action" value="<?php print($_REQUEST['action']);?>">
                      <?php
                          if($_REQUEST['action'] == 2){
                      ?>
                              <input type="hidden" name="mfileName" value="<?php print($mfileName);?>">
                              <input name="btnEdit" type="submit" class="submitButton" value="UPDATE">
                      <?php	
                          }
                          else{
                      ?>
                              <input name="btnAdd" type="submit" class="submitButton" value="ADD">
                      <?php
                          }
                      ?>
                      <input name="btnCancel" type="button" class="submitButton" value="BACK" onClick="javascript: window.location = 'manage_social_networks.php';">
              
                  </div>
              </form>
            <?php
                } else {
            ?>
              <div class="sepH_a" align="right">
                  <a href="<?php print($_SERVER['PHP_SELF']."?action=1");?>" title="Add New">Add New</a>
              </div>
              <form name="frm" id="frm" method="post" action="<?php @print($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);?>" enctype="multipart/form-data" onSubmit="return chkRequired(this);">
                  <table cellpadding="0" cellspacing="0" border="0" class="display" id="data_table">
                      <thead>
                          <tr>
                              <th class="chb_col"  align="center" width="30"><div class="th_wrapp"><input type="checkbox" name="chkAll" onClick="setAll();"></div></th>
                              <th><div class="th_wrapp">Name </div></th>
                              <th><div class="th_wrapp">Link to Website </div></th>
                              <th><div class="th_wrapp">Image </div></th>
                              <th><div class="th_wrapp">Status </div></th>
                              <th><div class="th_wrapp">Actions </div></th>
                          </tr>
                      </thead>
                      <tbody>
                      <?php
                $counter=0;
                          $Query = "SELECT * FROM social_links ORDER BY link_id";
                          $rs = mysql_query($Query);
                              while($row=mysql_fetch_object($rs)){	
                                  $counter++;
                      ?>
                          <tr>
                              <td class="chb_col" align="center"><input type="checkbox" name="chkstatus[]" value="<?php print($row->link_id);?>" class="inpt_c1" />
                              <input type="hidden" name="imgFile_<?php print($row->link_id);?>" value="<?php print($row->link_file);?>"></td>
                              <td><?php print($row->link_title);?> </td>
                              <td><?php print($row->link_url);?> </td>
                              <td><img src="../images/socials/<?php print($row->link_file);?>" width="30"> </td>
                              <td align="center"><?php echo (($row->status_id==1)?"<span class='notification info_bg'>Active</span>":"<span class='notification error_bg'>Not Active</span>");?></td>
                              <td class="content_actions" width="70px"><a href="<?php print($_SERVER['PHP_SELF']."?action=2&link_id=".$row->link_id);?>" class="sepV_a" title="Edit">
      <img src="images/icons/pencil_gray.png" alt="" />
      </a> </td>
                          </tr>
                      <?php
                              }
                      ?>
                      </tbody>
                  </table>
                  
            <?php if($counter > 0) {?>
                      <input type="submit" name="btnActive" value="ACTIVE" class="submitButton">
                      <input type="submit" name="btnInActive" value="INACTIVE" class="submitButton">
      
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