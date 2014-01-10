<?php
include("includes/php_includes_top.php");
if(isset($_REQUEST['loginForm'])){
	$Qry = "SELECT * FROM members WHERE mem_login='".$_REQUEST['mem_login']."' AND mem_confirm=1 AND status_id=1";
	$nResult = mysql_query($Qry);
	if(mysql_num_rows($nResult)>0){
		while ($row=mysql_fetch_object($nResult)){
			mysql_query("UPDATE members SET mem_last_login='".date("Y-m-d")."' WHERE mem_id=".$row->mem_id." ");
			$_SESSION["memID"] = $row->mem_id;
			$_SESSION["memLogin"] = $row->mem_login;
			$_SESSION["memEmail"] = $row->mem_email;
			echo "1,".Logged_In_Successfully."";
		}
	} else {
		echo "2,".Wrong_Phone_Number."";
	}
}
elseif(isset($_REQUEST['signupForm'])){
	$exist = IsExist("mem_id", "members", "mem_login", $_REQUEST['mem_login']);
	if($exist==0){
		$MaxID = getMaximum("members","mem_id");
		mysql_query("INSERT INTO members (mem_id, mem_login, mem_datecreated) VALUES(".$MaxID.", '".$_REQUEST['mem_login']."', NOW())");
		echo "1,".Account_Created."";
	} else {
		echo "2,".Phone_Number_Exists."";
	}
}
elseif(isset($_REQUEST['newsletterForm'])){
	$Qry = "SELECT sub_email FROM subscribers WHERE sub_email ='".$_REQUEST['sub_email']."'";
	$nResult = mysql_query($Qry);
	if(mysql_num_rows($nResult)>0){
		while ($row=mysql_fetch_object($nResult)){
			echo "2,".Already_Subscribed."";
		}
	} else {
		$MaxID = getMaximum("subscribers","sub_id");
		mysql_query("INSERT INTO subscribers (sub_id, sub_email, sub_date) VALUES(".$MaxID.", '".$_REQUEST['sub_email']."', NOW())");
		echo "1,".Subscribed_Successfully."";
	}
}
elseif(isset($_REQUEST['forgotForm'])){
	$Qry = "SELECT mem_id FROM members WHERE mem_email='".$_REQUEST['mem_login']."' LIMIT 1";
	$nResult = mysql_query($Qry);
	if(mysql_num_rows($nResult)>0){
		while ($row=mysql_fetch_object($nResult)){

			$random_number = substr(number_format(time() * rand(),0,'',''),0,8);
			mysql_query("UPDATE members SET mem_password = '".(md5($random_number))."' WHERE mem_email='".$_REQUEST['mem_login']."' LIMIT 1");

			$mTo      = $_REQUEST['mem_login'];
			$fromMail = "info@domain.com";
			$subject  = "Details about your IBF account";
			$welcome  = "Hi \n\n
			Following are the details of the change password request:\n
			Email: ".$_REQUEST['mem_login']."\n
			Password: ".$random_number."\n
			\nThis is an automatic generated message. Do not reply to this message. In case you’ll like to contact us, please use the contact form on our website.";
			$message = $welcome;
			$headers = "<" . $fromMail . ">";
			@mail($mTo, $subject, $message, $headers);
			echo "1,".Check_Your_Inbox."";
		}
	} else {
		echo "2,".Info_Doesnt_Match."";
	}
}
elseif(isset($_REQUEST['contactForm'])){
	$mTo = SITE_EMAIL; //admin email
	$fromMail = "Wap Portal Contact Us <noreply@limelyteapp.com>";
	$subject = "Contact Request";
	
	$welcome = "Hi \n\n
	Following are the details regarding Feedback request:\n
	Name: ".$_REQUEST['cu_name']."\n
	Email: ".$_REQUEST['cu_email']."\n
	Phone: ".$_REQUEST['cu_phone']."\n
	Comment: ".$_REQUEST['cu_comment']."\n
	\nThis is an automatic generated message. Do not reply to this message.";
		
	$message = $welcome;
	$headers = "<" . $fromMail . ">";
	@mail($mTo, $subject, $message, $headers);
	
	$MaxID = getMaximum("contact_us_request","cu_id");
	mysql_query("INSERT INTO contact_us_request (cu_id, cu_name, cu_email, cu_phone, cu_comment, date) VALUES (".$MaxID.", '".sql_str($_REQUEST['cu_name'])."', '".sql_str($_REQUEST['cu_email'])."', '".sql_str($_REQUEST['cu_phone'])."', '".sql_str($_REQUEST['cu_comment'])."', NOW())") or die(mysql_error());
	echo "1,".Thanks_For_Contact."";
}
elseif(isset($_REQUEST['changepassForm'])){
	$Qry = "SELECT mem_password FROM members WHERE mem_id=".$_SESSION["memID"]." AND mem_password='".md5($_REQUEST['mem_password_o'])."' LIMIT 1 ";
	$nResult = mysql_query($Qry);
	if(mysql_num_rows($nResult)>0){
		while ($row=mysql_fetch_object($nResult)){
			mysql_query("UPDATE members SET mem_password='".md5($_REQUEST['mem_password_n'])."' WHERE mem_id=".$_SESSION["memID"]." ");
			echo '1,Updated successfully!';
		}
	} else {
		echo '2,Your provided information does not match with our system!';
	}
}
elseif(isset($_REQUEST['vote'])){
	$rate = floatval($_REQUEST['rate']);
	$pid = floatval($_REQUEST['pid']);
	$sid = floatval($_REQUEST['sid']);
	mysql_query("INSERT INTO votes (user_id, pro_id, rate, section_id) VALUES ('".$_SESSION["memID"]."', '".$pid."', '".$rate."', '".$sid."')");
	$total_ratings = 0;
	$total_vots = 0;
	$qry = mysql_query("SELECT COUNT( 1 ) AS total_records, SUM( rate ) AS total FROM votes WHERE section_id=".$sid." AND pro_id=".$pid);
	if(mysql_num_rows($qry) > 0){
		$row = mysql_fetch_object($qry);
		$total_ratings = $row->total;
		$total_vots = $row->total_records;
	}
	$avg = 0.0;
	$avg = ( $total_ratings / $total_vots );
	$avg = round($avg, 1);
	echo $total_vots.','.$avg.','.$rate;
}
elseif(isset($_REQUEST['add_to_collection'])){
	//$exist = IsExist("mc_id", "my_collection", "mem_id", $_SESSION["memID"]." AND pr_id=".$_REQUEST['pid']." " );
	$exist = chkExist("mc_id", "my_collection", " WHERE mem_id=".$_SESSION["memID"]." AND pr_id=".$_REQUEST['pid']." ");
	if(!$exist>0){
		$MaxID = getMaximum("my_collection","mc_id");
		mysql_query("INSERT INTO my_collection (mc_id, pr_id, mem_id, cat_id, mc_added_date) VALUES(".$MaxID.", ".$_REQUEST['pid'].", ".$_SESSION["memID"].", ".$_REQUEST['cid'].", NOW())");
		echo "1,".Added_To_Wishlist."";
	} else {
		echo "2,".Already_Exists."";
	}
}
elseif(isset($_REQUEST['gift_to_friend'])){
	$exist = chkExist("mg_id", "my_gifted_items", " WHERE mem_id=".$_SESSION["memID"]." AND pr_id=".$_REQUEST['pid']." AND mg_to=".$_REQUEST['mg_to']." ");
	if(!$exist>0){
		$Qry = mysql_query(" SELECT mpl.* FROM mem_pak_limits AS mpl WHERE mpl.mem_id=".$_SESSION["memID"]." LIMIT 1 ");
		if(mysql_num_rows($Qry)>0){
			$row=mysql_fetch_object($Qry);
			$gifts = $row->mem_pak_gift;
			$giftsc = $row->mem_pak_gift_con;
			if($gifts==$giftsc){
				echo "2,".Purchase_Package."";
			} else {
				$MaxID = getMaximum("my_gifted_items","mg_id");
				mysql_query("INSERT INTO my_gifted_items (mg_id, mg_from, mg_to, mg_details, mem_id, pr_id, cat_id, mg_added_date) VALUES (".$MaxID.", ".$_SESSION["memLogin"].", '".$_REQUEST['mg_to']."', '".$_REQUEST['mg_details']."', ".$_SESSION["memID"].", ".$_REQUEST['pid'].", ".$_REQUEST['cid'].", NOW())");

				mysql_query("UPDATE mem_pak_limits SET mem_pak_gift_con = (mem_pak_gift_con + 1) WHERE mem_id = ".$_SESSION["memID"]." AND mem_pak_isexpired=0 AND mpl_id=".$_REQUEST['mpl_id']." ");
				mysql_query("UPDATE my_package_history SET mem_pak_gift_con = (mem_pak_gift_con + 1) WHERE mem_id = ".$_SESSION["memID"]." AND mpl_id=".$_REQUEST['mpl_id']." ");
				echo "1,".Seccessfully_Send."";
			}
		}
	} else {
		echo "2,".Already_Send."";
	}
}
elseif(isset($_REQUEST['decrease_limits'])){
	$Query = mysql_query("SELECT pak_expiry FROM members WHERE mem_id=".$_SESSION["memID"]." LIMIT 1");
	$row = $row=mysql_fetch_object($Query);
	$exp_date = $row->pak_expiry;
	$MaxID = getMaximum("my_consumption","myc_id");
	mysql_query("INSERT INTO my_consumption (myc_id, pr_id, mem_id, myc_added_date, cat_id) VALUES (".$MaxID.", ".$_REQUEST['pr_id'].", ".$_SESSION["memID"].", NOW(), ".$_REQUEST['cid'].")");
	if($_REQUEST['cat_id']==1){
		mysql_query("UPDATE mem_pak_limits SET mem_pak_stream_con = (mem_pak_stream_con + 1) WHERE mem_id = ".$_SESSION["memID"]." ");
		mysql_query("UPDATE my_package_history SET mem_pak_stream_con = (mem_pak_stream_con + 1) WHERE mem_id = ".$_SESSION["memID"]." AND mph_expiry='".$exp_date."' ");
	}elseif($_REQUEST['cat_id']==2){
		mysql_query("UPDATE mem_pak_limits SET mem_pak_downloads_con = (mem_pak_downloads_con + 1) WHERE mem_id = ".$_SESSION["memID"]." ");
		mysql_query("UPDATE my_package_history SET mem_pak_downloads_con = (mem_pak_downloads_con + 1) WHERE mem_id = ".$_SESSION["memID"]." AND mph_expiry='".$exp_date."' ");
	}
}
elseif(isset($_REQUEST['listing_response_div'])){
$cat_id = ((isset($_REQUEST['cid'])&&($_REQUEST['cid']!='')&&(!empty($_REQUEST['cid'])))?' AND c.cat_id='.$_REQUEST['cid']:'');
$res='';
	$res.='<div class="full_width slider" id="listing_response">';
			$counter=0;
			$url = "";
			$condition='';
			if($_REQUEST['sorting']=='na'){
				$where = " ORDER BY pr.pr_id DESC ";
				$url = "&na=1";
			} elseif($_REQUEST['sorting']=='tr'){
				$condition = " ,( SELECT SUM( v.rate ) FROM votes AS v WHERE v.section_id=".$_SESSION['vot_cat']." AND v.pro_id=pr.pr_id LIMIT 1 ) as res ";
				$where = " ORDER BY res DESC ";
				$url = "&tr=1";
			} elseif($_REQUEST['sorting']=='mv'){
				$where = " ORDER BY pr.pr_hits DESC ";
				$url = "&mv=1";
			} elseif($_REQUEST['sorting']=='fr'){
				$where = " AND pr.is_featured=1 ORDER BY pr.pr_id ";
				$url = "&fr=1";
			} else {
				$where = " ORDER BY pr.pr_id ASC ";
			}
			$Query =" SELECT pr.pr_id, pl.pr_title, pr.pr_hits, prf.prf_thumb, prf.prf_file, m.mem_fname, c.cat_id ".$condition." FROM products AS pr LEFT OUTER JOIN members AS m ON pr.mem_id=m.mem_id LEFT OUTER JOIN categories AS c ON pr.cat_id=c.cat_id LEFT OUTER JOIN pr_files AS prf ON pr.pr_id=prf.pr_id AND prf.is_default=1 LEFT OUTER JOIN products_ln AS pl ON pr.pr_id=pl.pr_id WHERE pr.status_id=1 AND c.status_id=1 AND c.cat_parentid=".$_SESSION['vot_cat']." ".$cat_id." AND pl.lang_id=".$_SESSION['lang_id']." ".$where." ";
			$limit = 12;
			$start = $p->findStart($limit); 
			$count = mysql_num_rows(mysql_query($Query));
			$pages = $p->findPages($count, $limit); 
			$rs = mysql_query($Query." LIMIT ".$start.", ".$limit);
			if($count>0){
				while($row=mysql_fetch_object($rs)){
				  $counter++;
				  $imgPath = chkFileExists4($row->prf_thumb);
				  $res.="
					<div class='col'>
						<div class='thumbs'>
							<div class='image'>
								<a href='index.php?page=".($start+$counter)."&id=".$_REQUEST['id'].$url.((isset($_REQUEST['cid'])&&($_REQUEST['cid']!=''))?'&cid='.$_REQUEST['cid']:'')."&pr=".$row->pr_id."'><img src='".$imgPath."' /></a>
							</div>
							<div class='caption'>
								<a href='index.php?page=".($start+$counter)."&id=".$_REQUEST['id'].$url.((isset($_REQUEST['cid'])&&($_REQUEST['cid']!=''))?'&cid='.$_REQUEST['cid']:'')."&pr=".$row->pr_id."'>".limit_text($row->pr_title,15)."</a>
							</div>
						</div>
					</div>";
					if($counter%4==0){$res.'<div class="clearfix"></div>';}
				}
		  } else{
			  $res .= No_Records;
		  }
		$res.='<div class="clearfix"></div>';
		if($counter > 0) {
			$res.='
			<div class="full_width pagination">
				<ul style="border-bottom: solid 0px;">';
					$res.="<li><span>".Page." <b>".$_GET['page']."</b> ".Of.' '.$pages.' '."</span></li>";
					$next_prev = $p->nextPrev($_GET['page'], $pages, "&id=".$_REQUEST['id'].((isset($_REQUEST['cid'])&&($_REQUEST['cid']!=''))?'&cid='.$_REQUEST['cid']:''));
					$next_prev = str_replace('site_services.php','index.php',$next_prev);
					$res.= $next_prev;
				$res.='
				</ul>
				<div class="clearfix"></div>
			</div><br /><br />';
			$res.="
			<div class='pagination_total'>&nbsp; ".Total.' '.$count.' '.Records."</div>";
		}
	$res.="</div>";
	echo $res;
}
?>