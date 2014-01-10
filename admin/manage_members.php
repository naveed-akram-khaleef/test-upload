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

//-----------session for confirm--------------
if(isset($_REQUEST['confirm'])){
	$_SESSION['confirm'] = $_REQUEST['confirm'];
}
else{
	if(!isset($_SESSION['confirm'])){
		$_SESSION['confirm'] = 1;
	}
}

$strMSG = "";
//--------------Button Active--------------------
if(isset($_REQUEST['btnActive'])){
	for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
		mysql_query("UPDATE members SET status_id = 1 WHERE mem_id = ".$_REQUEST['chkstatus'][$i]);
	}
	$msg_class='msg_box msg_ok';
	$strMSG = "Record(s) updated successfully";
}
//--------------Button InActive--------------------
if(isset($_REQUEST['btnInactive'])){
	for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
		mysql_query("UPDATE members SET status_id = 0 WHERE mem_id = ".$_REQUEST['chkstatus'][$i]);
	}
	$msg_class='msg_box msg_ok';
	$strMSG = "Record(s) updated successfully";
}
//--------------Button Confirm--------------------
if(isset($_REQUEST['btnConfirm'])){
	for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
		mysql_query("UPDATE members SET mem_confirm = 1 WHERE mem_id = ".$_REQUEST['chkstatus'][$i]);
	}
	$msg_class='msg_box msg_ok';
	$strMSG = "Record(s) updated successfully";
}
//--------------Button Not Confirm--------------------
if(isset($_REQUEST['btnNotConfirm'])){
	for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
		mysql_query("UPDATE members SET mem_confirm = 0 WHERE mem_id = ".$_REQUEST['chkstatus'][$i]);
	}
	$msg_class='msg_box msg_ok';
	$strMSG = "Record(s) updated successfully";
}
//--------------Button Delete--------------------
if(isset($_REQUEST['btnDelete'])){
	for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
		mysql_query("DELETE FROM members WHERE mem_id = ".$_REQUEST['chkstatus'][$i]);
	}
	$msg_class='msg_box msg_ok';
	$strMSG = "Record(s) updated successfully";
}

if(!empty($_POST['btnChangePassword'])){
	mysql_query("UPDATE members SET mem_password='".md5($_POST['newPassword'])."' WHERE mem_id=".$_GET['memid']);
	header("Location: manage_members.php?op=1");
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
		case 2:
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
                                <h1 class="sepH_c">Members Management</h1>

								<?php if(isset($_REQUEST['reset'])){ ?>
                                    <form name="form" method="post" action="<?php @print($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);?>" enctype="multipart/form-data" onSubmit="return chkRequired(this);">
                                        <div class="formEl_a">
                                            <fieldset class="sepH_b">
                                                <legend>Reset Member Password</legend>
                                    
                                                <div class="sepH_b">
                                                    <label for="a_text" class="lbl_a">New Password:</label>
                                                    <input type="text" id="a_text"name="newPassword" class="inpt_a" />
                                                </div>
                                
                                            </fieldset>
                                            
                                            <input type="submit" name="btnChangePassword" class="submitButton" value="UPDATE" />
                                            <input type="button" name="btnCancel" class="submitButton" value="BACK" onClick="javascript: window.location= 'manage_members.php';">
                                
                                        </div>
                                    </form>             
                                <?php }else if(isset($_REQUEST['show'])){ ?>
                                    <div class="formEl_a">
                                    <fieldset class="sepH_b">
                                    <legend>Details</legend>
                                        <table cellpadding="0" cellspacing="0" border="0" class="table_a smpl_tbl">
                                        <?php
                                            $strQry = "SELECT m.*, s.status_name, mpl.* FROM members AS m, status AS s, mem_pak_limits AS mpl WHERE m.status_id=s.status_id AND m.mem_id='".$_REQUEST["memid"]."' AND m.mem_id=mpl.mem_id ORDER BY m.mem_id";
                                            $rs = mysql_query($strQry);
                                            if(mysql_num_rows($rs)>0){
                                                $row=mysql_fetch_object($rs);
                                
                                                $Date_memcreated = "";
                                                if($row->mem_datecreated!=""){
                                                    $arrdate = explode("-", $row->mem_datecreated);
                                                    $Date_memcreated = date("M j, Y", mktime (0, 0, 0, $arrdate[1], $arrdate[2], $arrdate[0]));
                                                }
                                                $date_mem_lastupdate = "";
                                                if($row->mem_lastupdated!=""){
                                                    $arrdate = explode("-", $row->mem_lastupdated);
                                                    $date_mem_lastupdate = date("M j, Y", mktime (0, 0, 0, $arrdate[1], $arrdate[2], $arrdate[0]));
                                                }
                                                $date_memlastlogin = "";
                                                if($row->mem_last_login!=""){
                                                    $arrdate = explode("-", $row->mem_last_login);
                                                    $date_memlastlogin = date("M j, Y", mktime (0, 0, 0, $arrdate[1], $arrdate[2], $arrdate[0]));
                                                }
                                                $date_dob = "";
                                        ?>
                                            <tr>
                                                <td width="150" align="right">Login:</td>
                                                <td width="400" align="left" style="padding-left:4px;padding-right:4px;"><?php print($row->mem_login);?></td>
                                            </tr>
                                            <tr>
                                                <td align="right">Active:</td>
                                                <td align="left"><?php echo (($row->status_id==1)?"<span class='notification info_bg'>Yes</span>":"<span class='notification error_bg'>No</span>");?></td>
                                            </tr>
                                            <tr>
                                                <td align="right">Video Downloads:</td>
                                                <td align="left" style="padding-left:4px;padding-right:4px;"><?php print($row->pak_videos_downloads);?></td>
                                            </tr>
                                            <tr>
                                                <td align="right">Video Stream:</td>
                                                <td align="left" style="padding-left:4px;padding-right:4px;"><?php print($row->pak_videos_streams);?></td>
                                            </tr>
                                            <tr>
                                                <td align="right">Audio Download:</td>
                                                <td align="left" style="padding-left:4px;padding-right:4px;"><?php print($row->pak_audios_downloads);?></td>
                                            </tr>
                                            <tr>
                                                <td align="right">Audio Stream:</td>
                                                <td align="left" style="padding-left:4px;padding-right:4px;"><?php print($row->pak_audios_streams);?></td>
                                            </tr>
                                            <tr>
                                                <td align="right">Wallpaper Download:</td>
                                                <td align="left" style="padding-left:4px;padding-right:4px;"><?php print($row->pak_wallpapers_downloads);?></td>
                                            </tr>
                                            <tr>
                                                <td align="right">Ringtones Download:</td>
                                                <td align="left" style="padding-left:4px;padding-right:4px;"><?php print($row->pak_ringtones_downlaods);?></td>
                                            </tr>
                                            <tr>
                                                <td align="right">Gifts:</td>
                                                <td align="left" style="padding-left:4px;padding-right:4px;"><?php print($row->pak_gifts);?></td>
                                            </tr>





                                            <!--<tr>
                                                <td align="right">First Name:</td>
                                                <td align="left" style="padding-left:4px;padding-right:4px;"><?php print($row->mem_fname);?></td>
                                            </tr>
                                            <tr>
                                                <td align="right">Last Name:</td>
                                                <td align="left" style="padding-left:4px;padding-right:4px;"><?php print($row->mem_lname);?></td>
                                            </tr>
                                            <tr>
                                                <td align="right">Login:</td>
                                                <td align="left" style="padding-left:4px;padding-right:4px;"><?php echo $row->mem_login;?></td>
                                            </tr>
                                            <tr>
                                                <td align="right">Phone:</td>
                                                <td align="left" style="padding-left:4px;padding-right:4px;"><?php print($row->mem_phone);?></td>
                                            </tr>
                                            <tr>
                                                <td align="right">Adress:</td>
                                                <td align="left" style="padding-left:4px;padding-right:4px;"><?php print($row->mem_address);?></td>
                                            </tr>
                                            <tr>
                                                <td align="right">City:</td>
                                                <td align="left" style="padding-left:4px;padding-right:4px;"><?php print($row->mem_city);?></td>
                                            </tr>
                                            <tr>
                                                <td align="right">State:</td>
                                                <td align="left" style="padding-left:4px;padding-right:4px;"><?php print($row->mem_state);?></td>
                                            </tr>
                                            <tr>
                                                <td align="right">Zip Code:</td>
                                                <td align="left" style="padding-left:4px;padding-right:4px;"><?php print($row->mem_zcode);?></td>
                                            </tr>
                                            <tr>
                                                <td align="right">Date Created:</td>
                                                <td align="left" style="padding-left:4px;padding-right:4px;"><?php print($Date_memcreated);?></td>
                                            </tr>
                                            <tr>
                                                <td align="right">Last Updated:</td>
                                                <td align="left" style="padding-left:4px;padding-right:4px;"><?php print($date_mem_lastupdate);?></td>
                                            </tr>
                                            <tr>
                                                <td align="right">Last Login:</td>
                                                <td align="left" style="padding-left:4px;padding-right:4px;"><?php print($date_memlastlogin);?></td>
                                            </tr>
                                            <tr>
                                                <td align="right">Status:</td>
                                                <td align="left" style="padding-left:4px;padding-right:4px;"><?php print($row->status_name);?></td>
                                            </tr>
                                            <tr>
                                                <td align="right">Confirm:</td>
                                                <td align="left" style="padding-left:4px;padding-right:4px;"><?php echo (($row->mem_confirm==1)?'Confirmed':'Not Confirmed');?></td>
                                            </tr>-->
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
                                        <input type="button" name="btnCancel" class="submitButton" value="BACK" onClick="javascipt:window.location='manage_members.php';">
                                    <?php } ?>
                                <?php } else if(isset($_REQUEST['action'])) {?>
                                    <form id="dataForm" class="table-form" method="post" action="<?php echo $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'];?>">
                                        <fieldset>
                                            <legend><?php echo $form_head; ?></legend>
                                            <dl>
                                                <dt><label>Type</label></dt>
                                                <dd>
                                                    <select name="mtype_id">
                                                        <?php FillSelected("lov_member_type", "mtype_id", "mtype_name", @$mtype_id); ?>
                                                    </select>
                                                </dd>
                                                <dt><label>Package</label></dt>
                                                <dd>
                                                    <select name="pak_id">
                                                        <?php FillSelected("packages", "pak_id", "pak_name", @$pak_id); ?>
                                                    </select>
                                                </dd>
                                                <dt><label>Login/Email</label></dt>
                                                <dd>
                                                    <input id="checkingText" onBlur="chkTextExist('members','mem_login','mem_id','<?php echo @$mem_id;?>');" type="text" class="medium required email" name="mem_login" value="<?php @print($mem_login);?>" <?php echo ((isset($_REQUEST['action'])&& $_REQUEST['action']==2)?'disabled':'');?>>
                                                    <span id="res_of_chk"></span>
                                                </dd>
                                                <dt><label>Password</label></dt>
                                                <dd>
                                                    <input type="password" class="medium required" name="mem_password" value="<?php @print($mem_password);?>"  <?php echo ((isset($_REQUEST['action'])&& $_REQUEST['action']==2)?'disabled':'');?>>
                                                </dd>
                                                <dt><label>First Name</label></dt>
                                                <dd>
                                                    <input type="text" class="medium" name="mem_fname" value="<?php @print($mem_fname);?>">
                                                </dd>
                                                <dt><label>Last Name</label></dt>
                                                <dd>
                                                    <input type="text" class="medium" name="mem_lname" value="<?php @print($mem_lname);?>">
                                                </dd>
                                                <dt><label>Title</label></dt>
                                                <dd>
                                                    <select name="title_id">
                                                        <?php FillSelected("lov_titles", "title_id", "title_name", @$title_id); ?>
                                                    </select>
                                                </dd>
                                                <dt><label>Gender</label></dt>
                                                <dd>
                                                    <select name="gen_id">
                                                        <?php FillSelected("lov_gender", "gen_id", "gen_name", @$gen_id); ?>
                                                    </select>
                                                </dd>
                                                <dt><label>Date of Birth</label></dt>
                                                <dd>
                                                    <input type="text" class="datepicker small" name="mem_dob" value="<?php @print($mem_dob);?>">
                                                </dd>
                                                <dt><label>CNIC</label></dt>
                                                <dd>
                                                    <input type="text" class="medium" name="mem_cnic" value="<?php @print($mem_cnic);?>">
                                                </dd>
                                                <dt><label>Phone</label></dt>
                                                <dd>
                                                    <input type="text" class="medium" name="mem_phone" value="<?php @print($mem_phone);?>">
                                                </dd>
                                                <dt><label>Mobile</label></dt>
                                                <dd>
                                                    <input type="text" class="medium" name="mem_mobile" value="<?php @print($mem_mobile);?>">
                                                </dd>
                                                <dt><label>Address</label></dt>
                                                <dd>
                                                    <textarea rows="5" cols="40" class="wysiwyg large" name="mem_address"><?php echo @$mem_address;?></textarea>
                                                </dd>
                                                <dt><label>City</label></dt>
                                                <dd>
                                                    <input type="text" class="medium" name="mem_city" value="<?php @print($mem_city);?>">
                                                </dd>
                                                <dt><label>State</label></dt>
                                                <dd>
                                                    <input type="text" class="medium" name="mem_state" value="<?php @print($mem_state);?>">
                                                </dd>
                                                <dt><label>Postal Code</label></dt>
                                                <dd>
                                                    <input type="text" class="medium" name="mem_pcode" value="<?php @print($mem_pcode);?>">
                                                </dd>
                                                <dt><label>Country</label></dt>
                                                <dd>
                                                    <select name="countries_id">
                                                        <?php FillSelected("countries", "countries_id", "countries_name", @$countries_id); ?>
                                                    </select>
                                                </dd>
                                                <dt><label>Expiry</label></dt>
                                                <dd>
                                                    <input type="text" class="datepicker small" name="mem_expiry" value="<?php @print($mem_expiry);?>">
                                                </dd>
                                                <dt><label>Category</label></dt>
                                                <dd>
                                                    <select name="cat_id">
                                                        <?php FillSelected("category", "cat_id", "cat_title", @$cat_id); ?>
                                                    </select>
                                                </dd>
                                                <dt><label>Functional Area</label></dt>
                                                <dd>
                                                    <select name="farea_id">
                                                        <?php FillSelected("lov_functional_area", "farea_id", "farea_name", @$farea_id); ?>
                                                    </select>
                                                </dd>
                                                <dt><label>Career Level</label></dt>
                                                <dd>
                                                    <select name="crl_id">
                                                        <?php FillSelected("lov_career_level", "crl_id", "crl_name", @$crl_id); ?>
                                                    </select>
                                                </dd>
                                                <?php if($_REQUEST['action'] == 2) {?>
                                                    <dt><label>Current File</label></dt>
                                                    <dd>
                                                        <?php echo @chkFileExists($fileOrgPath,$mem_file);?>
                                                    </dd>
                                                <?php }?>
                                                <?php include("progress_bar_file.php"); ?>
                                            </dl>
                                        </fieldset>
                                        <?php if($_REQUEST['action'] == 2) {?>
                                            <input type="hidden" name="mfileName" value="<?php echo @$mem_file; ?>">
                                            <input type="hidden" name="mem_cv" value="<?php echo @$mem_cv; ?>">
                                            <input type="submit" name="btnEdit" value="Update" class="button">
                                        <?php } else { ?>
                                            <input type="submit" name="btnAdd" value="Add" class="button">
                                        <?php } ?>
                                        <input type="reset" value="Clear Fields" class="button gray">
                                        <input type="button" value="Cancel" class="button gray" onClick="javascript: window.location= '<?php echo @$_SERVER['HTTP_REFERER'];?>';">
                                    </form>
                                <?php } else {?>
                                    <a href="manage_user_profile.php?action=1" rel="tooltip" title="Add New Record">Add New</a>
                                    <?php
                                        switch ($_SESSION['confirm']) {
                                            case 0:
                                    ?>
                                        | <a href="<?php print($_SERVER['PHP_SELF']."?confirm=1");?>" title="View Confirmed">Confirmed</a> | <b>Not Confirmed</b>
                                    <?php
                                            break;
                                            case 1:
                                    ?>
                                        <!--| <b>Confirmed</b> | <a href="<?php print($_SERVER['PHP_SELF']."?confirm=0");?>" title="View Not Confirmed">Not Confirmed</a>-->
                                    <?php
                                            break;
                                        }
                                    ?>
                                    <form name="frm" id="frm" method="post" action="<?php @print($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);?>" enctype="multipart/form-data" onSubmit="return chkRequired(this);">
                                        <table cellpadding="0" cellspacing="0" border="0" class="display" id="">
                                            <thead>
                                                <tr>
                                                    <th class="chb_col"  align="center" width="30"><div class="th_wrapp"><input type="checkbox" name="chkAll" onClick="setAll();"></div></th>
                                                    <th><div class="th_wrapp">Login</div></th>
                                                    <th><div class="th_wrapp">ACTIVE</div></th>
                                                    <th><div class="th_wrapp">Package</div></th>
                                                    <th><div class="th_wrapp">PACKAGE EXPIRY</div></th>
                                                    <th><div class="th_wrapp">PACKAGE EXPIRED</div></th>
                                                    <th><div class="th_wrapp">Actions</div></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                $Query = "SELECT m.*, pk.pak_name FROM members AS m LEFT OUTER JOIN packages AS pk ON m.pak_id=pk.pak_id WHERE m.mem_confirm='".$_SESSION['confirm']."' ORDER BY m.mem_id";
												$counter=0;
												$limit = 25;
												$start = $p->findStart($limit); 
												$count = mysql_num_rows(mysql_query($Query)); 
												$pages = $p->findPages($count, $limit); 
												$rs = mysql_query($Query." LIMIT ".$start.", ".$limit);
												if(mysql_num_rows($rs)>0){
													while($row=mysql_fetch_object($rs)){	
														$counter++;
																												/*
                                                        $showDate = "";
                                                        if($row->mem_datecreated!=""){
                                                            $memDate = @explode("-", $row->mem_datecreated);
                                                            $showDate = @date("m.j.Y", mktime (0, 0, 0, $memDate[1],$memDate[2],$memDate[0]));
                                                        }
                                                        if(($row->mem_last_login == "0000-00-00") || ($row->mem_last_login == "")){
                                                            $lastLogin = "";
                                                        }
                                                        else{
                                                            $shDate = @explode("-", $row->mem_last_login);
                                                            $lastLogin = @date("m.j.Y", mktime (0, 0, 0, $shDate[1],$shDate[2],$shDate[0]));
                                                        }*/
                                            ?>
                                            
                                                <tr>
                                                    <td class="chb_col" align="center"><input type="checkbox" name="chkstatus[]" value="<?php print($row->mem_id);?>" class="inpt_c1" /></td>
                                                    <td  style="padding-left:4px;padding-right:4px;"><a href="<?php print($_SERVER['PHP_SELF']);?>?show=1&memid=<?php print($row->mem_id);?>" title="View Details"><?php echo $row->mem_login;?></a></td>
                                                    <td align="center"><?php echo (($row->status_id==1)?"<span class='notification info_bg'>Yes</span>":"<span class='notification error_bg'>No</span>");?></td>
                                                    <td align="center"><?php echo $row->pak_name;?></td>
                                                    <td align="center"><?php echo $row->pak_expiry;?></td>
                                                    <td align="center"><?php echo (($row->pak_isexpired==1)?"<span class='notification info_bg'>Yes</span>":"<span class='notification error_bg'>No</span>");?></td>
<br />
                                                    <td class="content_actions" width="10px"><a href="manage_user_profile.php?id=<?php print($row->mem_id); ?>" class="sepV_a" title="Edit">
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
                                        
                                        <?php if($counter != 0){?>
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
                                            <input type="submit" name="btnActive" class="submitButton" value="ACTIVE" />
                                            <input type="submit" name="btnInactive" class="submitButton" value="INACTIVE" />
                                            <?php
                                                switch ($_SESSION['confirm']) {
                                                    case 0:
                                            ?>
                                                <!--<input type="submit" name="btnConfirm" class="submitButton" value="CONFIRMED" />-->
                                
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
                                
                                                <?php
                                                    break;
                                                    case 1:
                                                ?>
                                                    <!--<input type="submit" name="btnNotConfirm" class="submitButton" value="NOT CONFIRMED" />-->
                                                <?php	
                                                    break;
                                                }
                                                ?>
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