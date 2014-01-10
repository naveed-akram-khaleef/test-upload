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
	$MaxID = getMaximum("site_variables","sv_id");
	$strQRY="INSERT INTO site_variables (sv_id, lang_id, sv_login, sv_logout, sv_register) VALUES (".$MaxID.", ".$_SESSION['lang_id'].", '".str_replace("'", "''", $_REQUEST['sv_login'])."', '".str_replace("'", "''", $_REQUEST['sv_logout'])."', '".str_replace("'", "''", $_REQUEST['sv_register'])."')";
	$nRst=mysql_query($strQRY) or die(mysql_error());
	header("Location: manage_site_variables.php?op=1");
}
elseif(isset($_REQUEST['btnEdit'])){
	$strUdtQry = "";
	mysql_query("UPDATE site_variables SET sv_login='".str_replace("'", "''", $_REQUEST['sv_login'])."', sv_logout='".str_replace("'", "''", $_REQUEST['sv_logout'])."', sv_register='".str_replace("'", "''", $_REQUEST['sv_register'])."', sv_search='".str_replace("'", "''", $_REQUEST['sv_search'])."', sv_audios='".str_replace("'", "''", $_REQUEST['sv_audios'])."', sv_ringtones='".str_replace("'", "''", $_REQUEST['sv_ringtones'])."', sv_movies='".str_replace("'", "''", $_REQUEST['sv_movies'])."', sv_wallpapers='".str_replace("'", "''", $_REQUEST['sv_wallpapers'])."', sv_new='".str_replace("'", "''", $_REQUEST['sv_new'])."', sv_top_rated='".str_replace("'", "''", $_REQUEST['sv_top_rated'])."', sv_most_viewed='".str_replace("'", "''", $_REQUEST['sv_most_viewed'])."', sv_featured='".str_replace("'", "''", $_REQUEST['sv_featured'])."', sv_enter_email='".str_replace("'", "''", $_REQUEST['sv_enter_email'])."', sv_newsletter='".str_replace("'", "''", $_REQUEST['sv_newsletter'])."', sv_copyright='".str_replace("'", "''", $_REQUEST['sv_copyright'])."', sv_allrights='".str_replace("'", "''", $_REQUEST['sv_allrights'])."', sv_related_items='".str_replace("'", "''", $_REQUEST['sv_related_items'])."', sv_views='".str_replace("'", "''", $_REQUEST['sv_views'])."', sv_view_file='".str_replace("'", "''", $_REQUEST['sv_view_file'])."', sv_listen='".str_replace("'", "''", $_REQUEST['sv_listen'])."', sv_rating='".str_replace("'", "''", $_REQUEST['sv_rating'])."', sv_gift='".str_replace("'", "''", $_REQUEST['sv_gift'])."', sv_wishlist='".str_replace("'", "''", $_REQUEST['sv_wishlist'])."', sv_add_to_wishlist='".str_replace("'", "''", $_REQUEST['sv_add_to_wishlist'])."', sv_download='".str_replace("'", "''", $_REQUEST['sv_download'])."', sv_news='".str_replace("'", "''", $_REQUEST['sv_news'])."', sv_faqs='".str_replace("'", "''", $_REQUEST['sv_faqs'])."', sv_advance_search='".str_replace("'", "''", $_REQUEST['sv_advance_search'])."', sv_about='".str_replace("'", "''", $_REQUEST['sv_about'])."', sv_contact='".str_replace("'", "''", $_REQUEST['sv_contact'])."', sv_name='".str_replace("'", "''", $_REQUEST['sv_name'])."', sv_email='".str_replace("'", "''", $_REQUEST['sv_email'])."', sv_phone='".str_replace("'", "''", $_REQUEST['sv_phone'])."', sv_message='".str_replace("'", "''", $_REQUEST['sv_message'])."', sv_categories='".str_replace("'", "''", $_REQUEST['sv_categories'])."', sv_submit='".str_replace("'", "''", $_REQUEST['sv_submit'])."', sv_my_account='".str_replace("'", "''", $_REQUEST['sv_my_account'])."' WHERE sv_id=".$_REQUEST['sv_id']);
	header("Location: manage_site_variables.php?op=2");
}
elseif((isset($_REQUEST['action'])) && ($_REQUEST['action']==2)){
	$FormHead = "Edit Details";
	$query = "SELECT * FROM site_variables WHERE sv_id=".$_REQUEST['sv_id']." ";
	$res = mysql_query($query);
	$row = mysql_fetch_assoc($res);
	foreach ($row as $sKey => $vValue) {
		$$sKey = $vValue;
	}
}
else{
	$FormHead = "Add New Details";
	if(!isset($_REQUEST['btnAdd'])){
		$title = "";
		$details = "";
		$date = "";
	}
}
if(isset($_REQUEST['btnDelete'])){
	if(isset($_REQUEST['chkstatus'])){
		for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
			DeleteFileWithThumb("site_variables_file", "site_variables", "sv_id", $_REQUEST['chkstatus'][$i], "", "");
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
                                <h1 class="sepH_c">Website Variables Management</h1>

						<?php
                            if(isset($_REQUEST['show'])){
                        ?>		
                            <div class="formEl_a">
                                <fieldset class="sepH_b">
                                    <legend>Details</legend>
                                    <table cellpadding="0" cellspacing="0" border="0" class="table_a smpl_tbl">
                                        <tr>
                                            <td>Login:</td>
                                            <td><?php echo $sv_login;?></td>
                                        </tr>
                                        <tr>
                                            <td>Logout:</td>
                                            <td><?php echo $sv_logout;?></td>
                                        </tr>
                                        <tr>
                                            <td>Register:</td>
                                            <td><?php echo $sv_register;?></td>
                                        </tr>
                                        <tr>
                                            <td>Search:</td>
                                            <td><?php echo $sv_search;?></td>
                                        </tr>
                                        <tr>
                                            <td>Audios:</td>
                                            <td><?php echo $sv_audios;?></td>
                                        </tr>
                                        <tr>
                                            <td>Ringtones:</td>
                                            <td><?php echo $sv_ringtones;?></td>
                                        </tr>
                                        <tr>
                                            <td>Movies:</td>
                                            <td><?php echo $sv_movies;?></td>
                                        </tr>
                                        <tr>
                                            <td>Wallpapers:</td>
                                            <td><?php echo $sv_wallpapers;?></td>
                                        </tr>
                                        <tr>
                                            <td>New:</td>
                                            <td><?php echo $sv_new;?></td>
                                        </tr>
                                        <tr>
                                            <td>Top Rated:</td>
                                            <td><?php echo $sv_top_rated;?></td>
                                        </tr>
                                        <tr>
                                            <td>Most Viewed:</td>
                                            <td><?php echo $sv_most_viewed;?></td>
                                        </tr>
                                        <tr>
                                            <td>Featured:</td>
                                            <td><?php echo $sv_featured;?></td>
                                        </tr>
                                        <tr>
                                            <td>Enter Email:</td>
                                            <td><?php echo $sv_enter_email;?></td>
                                        </tr>
                                        <tr>
                                            <td>Newsletter:</td>
                                            <td><?php echo $sv_newsletter;?></td>
                                        </tr>
                                        <tr>
                                            <td>Copyright:</td>
                                            <td><?php echo $sv_copyright;?></td>
                                        </tr>
                                        <tr>
                                            <td>All Rights Reserved:</td>
                                            <td><?php echo $sv_allrights;?></td>
                                        </tr>
                                        <tr>
                                            <td>Related Items:</td>
                                            <td><?php echo $sv_related_items;?></td>
                                        </tr>
                                        <tr>
                                            <td>Total Views:</td>
                                            <td><?php echo $sv_views;?></td>
                                        </tr>
                                        <tr>
                                            <td>View File:</td>
                                            <td><?php echo $sv_view_file;?></td>
                                        </tr>
                                        <tr>
                                            <td>Listen:</td>
                                            <td><?php echo $sv_listen;?></td>
                                        </tr>
                                        <tr>
                                            <td>User Rating:</td>
                                            <td><?php echo $sv_rating;?></td>
                                        </tr>
                                        <tr>
                                            <td>Gift to Friend:</td>
                                            <td><?php echo $sv_gift;?></td>
                                        </tr>
                                        <tr>
                                            <td>My Wishlist:</td>
                                            <td><?php echo $sv_wishlist;?></td>
                                        </tr>
                                        <tr>
                                            <td>Add to Wishlist:</td>
                                            <td><?php echo $sv_add_to_wishlist;?></td>
                                        </tr>
                                        <tr>
                                            <td>Download:</td>
                                            <td><?php echo $sv_download;?></td>
                                        </tr>
                                        <tr>
                                            <td>News:</td>
                                            <td><?php echo $sv_news;?></td>
                                        </tr>
                                        <tr>
                                            <td>FAQs:</td>
                                            <td><?php echo $sv_faqs;?></td>
                                        </tr>
                                        <tr>
                                            <td>Advance Search:</td>
                                            <td><?php echo $sv_advance_search;?></td>
                                        </tr>
                                        <tr>
                                            <td>About:</td>
                                            <td><?php echo $sv_about;?></td>
                                        </tr>
                                        <tr>
                                            <td>Contact Us:</td>
                                            <td><?php echo $sv_contact;?></td>
                                        </tr>
                                        <tr>
                                            <td>Name:</td>
                                            <td><?php echo $sv_name;?></td>
                                        </tr>
                                        <tr>
                                            <td>Email:</td>
                                            <td><?php echo $sv_email;?></td>
                                        </tr>
                                        <tr>
                                            <td>Phone:</td>
                                            <td><?php echo $sv_phone;?></td>
                                        </tr>
                                        <tr>
                                            <td>Message:</td>
                                            <td><?php echo $sv_message;?></td>
                                        </tr>
                                        <tr>
                                            <td>Categories:</td>
                                            <td><?php echo $sv_categories;?></td>
                                        </tr>
                                        <tr>
                                            <td>Submit:</td>
                                            <td><?php echo $sv_submit;?></td>
                                        </tr>
                                        <tr>
                                            <td>My Account:</td>
                                            <td><?php echo $sv_my_account;?></td>
                                        </tr>
                                    </table>
                                </fieldset>
                            </div>
                           <input type="button" name="btnCancel" class="submitButton" value="BACK" onClick="javascript: window.location= 'manage_site_variables.php';">  
						<?php	
                            } else  if(isset($_REQUEST['action']) == 1){
						?>
                            <form name="form" id="validateFormData" method="post" action="<?php @print($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);?>" enctype="multipart/form-data">
                                <div class="formEl_a">
                                    <fieldset class="sepH_b">
                                        <legend><?php print($FormHead);?></legend>
                                        <div class="sepH_b">
                                            <label for="a_text" class="lbl_a">Login:</label>
                                            <input type="text" id="a_text" name="sv_login" value="<?php print($sv_login);?>" class="inpt_a" />
                                        </div>
                                        <div class="sepH_b">
                                            <label for="a_text" class="lbl_a">Logout:</label>
                                            <input type="text" id="a_text" name="sv_logout" value="<?php print($sv_logout);?>" class="inpt_a" />
                                        </div>
                                        <div class="sepH_b">
                                            <label for="a_text" class="lbl_a">Register:</label>
                                            <input type="text" id="a_text" name="sv_register" value="<?php print($sv_register);?>" class="inpt_a" />
                                        </div>
                                        <div class="sepH_b">
                                            <label for="a_text" class="lbl_a">Search:</label>
                                            <input type="text" id="a_text" name="sv_search" value="<?php print($sv_search);?>" class="inpt_a" />
                                        </div>
                                        <div class="sepH_b">
                                            <label for="a_text" class="lbl_a">Audios:</label>
                                            <input type="text" id="a_text" name="sv_audios" value="<?php print($sv_audios);?>" class="inpt_a" />
                                        </div>
                                        <div class="sepH_b">
                                            <label for="a_text" class="lbl_a">Ringtones:</label>
                                            <input type="text" id="a_text" name="sv_ringtones" value="<?php print($sv_ringtones);?>" class="inpt_a" />
                                        </div>
                                        <div class="sepH_b">
                                            <label for="a_text" class="lbl_a">Movies:</label>
                                            <input type="text" id="a_text" name="sv_movies" value="<?php print($sv_movies);?>" class="inpt_a" />
                                        </div>
                                        <div class="sepH_b">
                                            <label for="a_text" class="lbl_a">Wallpapers:</label>
                                            <input type="text" id="a_text" name="sv_wallpapers" value="<?php print($sv_wallpapers);?>" class="inpt_a" />
                                        </div>
                                        <div class="sepH_b">
                                            <label for="a_text" class="lbl_a">New:</label>
                                            <input type="text" id="a_text" name="sv_new" value="<?php print($sv_new);?>" class="inpt_a" />
                                        </div>
                                        <div class="sepH_b">
                                            <label for="a_text" class="lbl_a">Top Rated:</label>
                                            <input type="text" id="a_text" name="sv_top_rated" value="<?php print($sv_top_rated);?>" class="inpt_a" />
                                        </div>
                                        <div class="sepH_b">
                                            <label for="a_text" class="lbl_a">Most Viewed:</label>
                                            <input type="text" id="a_text" name="sv_most_viewed" value="<?php print($sv_most_viewed);?>" class="inpt_a" />
                                        </div>
                                        <div class="sepH_b">
                                            <label for="a_text" class="lbl_a">Featured:</label>
                                            <input type="text" id="a_text" name="sv_featured" value="<?php print($sv_featured);?>" class="inpt_a" />
                                        </div>
                                        <div class="sepH_b">
                                            <label for="a_text" class="lbl_a">Enter Email:</label>
                                            <input type="text" id="a_text" name="sv_enter_email" value="<?php print($sv_enter_email);?>" class="inpt_a" />
                                        </div>
                                        <div class="sepH_b">
                                            <label for="a_text" class="lbl_a">Newsletter:</label>
                                            <input type="text" id="a_text" name="sv_newsletter" value="<?php print($sv_newsletter);?>" class="inpt_a" />
                                        </div>
                                        <div class="sepH_b">
                                            <label for="a_text" class="lbl_a">Copyright:</label>
                                            <input type="text" id="a_text" name="sv_copyright" value="<?php print($sv_copyright);?>" class="inpt_a" />
                                        </div>
                                        <div class="sepH_b">
                                            <label for="a_text" class="lbl_a">All Rights Reserved:</label>
                                            <input type="text" id="a_text" name="sv_allrights" value="<?php print($sv_allrights);?>" class="inpt_a" />
                                        </div>
                                        <div class="sepH_b">
                                            <label for="a_text" class="lbl_a">Related Items:</label>
                                            <input type="text" id="a_text" name="sv_related_items" value="<?php print($sv_related_items);?>" class="inpt_a" />
                                        </div>
                                        <div class="sepH_b">
                                            <label for="a_text" class="lbl_a">Total Views:</label>
                                            <input type="text" id="a_text" name="sv_views" value="<?php print($sv_views);?>" class="inpt_a" />
                                        </div>
                                        <div class="sepH_b">
                                            <label for="a_text" class="lbl_a">View File:</label>
                                            <input type="text" id="a_text" name="sv_view_file" value="<?php print($sv_view_file);?>" class="inpt_a" />
                                        </div>
                                        <div class="sepH_b">
                                            <label for="a_text" class="lbl_a">Listen:</label>
                                            <input type="text" id="a_text" name="sv_listen" value="<?php print($sv_listen);?>" class="inpt_a" />
                                        </div>
                                        <div class="sepH_b">
                                            <label for="a_text" class="lbl_a">Rating:</label>
                                            <input type="text" id="a_text" name="sv_rating" value="<?php print($sv_rating);?>" class="inpt_a" />
                                        </div>
                                        <div class="sepH_b">
                                            <label for="a_text" class="lbl_a">Gift to Friend:</label>
                                            <input type="text" id="a_text" name="sv_gift" value="<?php print($sv_gift);?>" class="inpt_a" />
                                        </div>
                                        <div class="sepH_b">
                                            <label for="a_text" class="lbl_a">My Wishlist:</label>
                                            <input type="text" id="a_text" name="sv_wishlist" value="<?php print($sv_wishlist);?>" class="inpt_a" />
                                        </div>
                                        <div class="sepH_b">
                                            <label for="a_text" class="lbl_a">Add to Wishlist:</label>
                                            <input type="text" id="a_text" name="sv_add_to_wishlist" value="<?php print($sv_add_to_wishlist);?>" class="inpt_a" />
                                        </div>
                                        <div class="sepH_b">
                                            <label for="a_text" class="lbl_a">Download:</label>
                                            <input type="text" id="a_text" name="sv_download" value="<?php print($sv_download);?>" class="inpt_a" />
                                        </div>
                                        <div class="sepH_b">
                                            <label for="a_text" class="lbl_a">News:</label>
                                            <input type="text" id="a_text" name="sv_news" value="<?php print($sv_news);?>" class="inpt_a" />
                                        </div>
                                        <div class="sepH_b">
                                            <label for="a_text" class="lbl_a">FAQs:</label>
                                            <input type="text" id="a_text" name="sv_faqs" value="<?php print($sv_faqs);?>" class="inpt_a" />
                                        </div>
                                        <div class="sepH_b">
                                            <label for="a_text" class="lbl_a">Advance Search:</label>
                                            <input type="text" id="a_text" name="sv_advance_search" value="<?php print($sv_advance_search);?>" class="inpt_a" />
                                        </div>
                                        <div class="sepH_b">
                                            <label for="a_text" class="lbl_a">About:</label>
                                            <input type="text" id="a_text" name="sv_about" value="<?php print($sv_about);?>" class="inpt_a" />
                                        </div>
                                        <div class="sepH_b">
                                            <label for="a_text" class="lbl_a">Contact Us:</label>
                                            <input type="text" id="a_text" name="sv_contact" value="<?php print($sv_contact);?>" class="inpt_a" />
                                        </div>
                                        <div class="sepH_b">
                                            <label for="a_text" class="lbl_a">Name:</label>
                                            <input type="text" id="a_text" name="sv_name" value="<?php print($sv_name);?>" class="inpt_a" />
                                        </div>
                                        <div class="sepH_b">
                                            <label for="a_text" class="lbl_a">Email:</label>
                                            <input type="text" id="a_text" name="sv_email" value="<?php print($sv_email);?>" class="inpt_a" />
                                        </div>
                                        <div class="sepH_b">
                                            <label for="a_text" class="lbl_a">Phone:</label>
                                            <input type="text" id="a_text" name="sv_phone" value="<?php print($sv_phone);?>" class="inpt_a" />
                                        </div>
                                        <div class="sepH_b">
                                            <label for="a_text" class="lbl_a">Message:</label>
                                            <input type="text" id="a_text" name="sv_message" value="<?php print($sv_message);?>" class="inpt_a" />
                                        </div>
                                        <div class="sepH_b">
                                            <label for="a_text" class="lbl_a">Categories:</label>
                                            <input type="text" id="a_text" name="sv_categories" value="<?php print($sv_categories);?>" class="inpt_a" />
                                        </div>
                                        <div class="sepH_b">
                                            <label for="a_text" class="lbl_a">Submit:</label>
                                            <input type="text" id="a_text" name="sv_submit" value="<?php print($sv_submit);?>" class="inpt_a" />
                                        </div>
                                        <div class="sepH_b">
                                            <label for="a_text" class="lbl_a">My Account:</label>
                                            <input type="text" id="a_text" name="sv_my_account" value="<?php print($sv_my_account);?>" class="inpt_a" />
                                        </div>
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
                                            <input name="btnCancel" type="button" class="submitButton" value="BACK" onClick="javascript: window.location = 'manage_site_variables.php';">
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
                                            <th><div class="th_wrapp">Login</div></th>
                                            <th><div class="th_wrapp">Logout</div></th>
                                            <th><div class="th_wrapp">Register</div></th>
                                            <th><div class="th_wrapp">Details</div></th>
                                            <th><div class="th_wrapp">Actions </div></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
										$Query = "SELECT * FROM site_variables";
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
                                            <td class="chb_col" align="center"><input type="checkbox" name="chkstatus[]" value="<?php print($row->sv_id);?>" class="inpt_c1" /></td>
                                            <td><?php echo $row->sv_login;?> </td>
                                            <td><?php echo $row->sv_logout;?> </td>
                                            <td><?php echo $row->sv_register;?> </td>
                                            <td><a href="<?php echo $_SERVER['PHP_SELF']."?action=2&show=1&sv_id=".$row->sv_id;?>"> View </a></td>
                                            <td class="content_actions" width="70px"><a href="<?php print($_SERVER['PHP_SELF']."?action=2&sv_id=".$row->sv_id);?>" class="sepV_a" title="Edit">
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
                                    <input type="submit" name="btnActive" value="ACTIVE" class="submitButton">
                                    <input type="submit" name="btnInactive" value="INACTIVE" class="submitButton">
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