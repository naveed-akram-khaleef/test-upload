<?php
function showStars($secID, $objID){
	$retValue = "";
	$avgRate = 0;
	$qry = mysql_query("SELECT COUNT( 1 ) AS total_records, SUM( rate ) AS total FROM votes WHERE section_id=".$secID." AND pro_id=".$objID);
	if(mysql_num_rows($qry) > 0){
		$row = mysql_fetch_object($qry);
		if($row->total_records > 0){
			$avgRate = round($row->total / $row->total_records, 1);
		}
	}
	for($i=0; $i<5; $i++){
		if($i < $avgRate){
			$retValue .= '<a href="#" title="'.$avgRate.'"><img src="images/star.png" alt="'.$avgRate.'" /></a> ';
		}
		else{
			$retValue .= '<a href="#" title="'.$avgRate.'"><img src="images/star_rol.png" alt="'.$avgRate.'" /></a> ';
		}
	}
	return $retValue;
}

function avgRating($secID, $objID){
	$retValue = "";
	$qry = mysql_query("SELECT COUNT( 1 ) AS total_records, SUM( rate ) AS total FROM votes WHERE section_id=".$secID." AND pro_id=".$objID);
	if(mysql_num_rows($qry) > 0){
		$row = mysql_fetch_object($qry);
		if($row->total_records == 0){
			$retValue = '<span id="serverResponse3">Average: 0 of </span><span id="serverResponse4">0 vote(s)</span>';
		}
		else{
			$avgRate = $row->total / $row->total_records;
			$retValue = '<span id="serverResponse3">Average: '.$avgRate.' of </span><span id="serverResponse4">'.$row->total_records.' vote(s)</span>';
		}
	}
	else{
		$retValue = '<span id="serverResponse3">Average: 0 of </span><span id="serverResponse4">0 vote(s)</span>';
	}
	return $retValue;
}

function avgRatingDet($secID, $objID){
	$retValue = "";
	$qry = mysql_query("SELECT COUNT( 1 ) AS total_records, SUM( rate ) AS total FROM votes WHERE section_id=".$secID." AND pro_id=".$objID);
	if(mysql_num_rows($qry) > 0){
		$row = mysql_fetch_object($qry);
		if($row->total_records == 0){
			$retValue = '<a href="#" class="Votes"><span id="serverResponse1">0 Vote(s) </span></a><span id="serverResponse2">Average: 0</span>';
		}
		else{
			$avgRate = $row->total / $row->total_records;
			$retValue = '<a href="#" class="Votes"><span id="serverResponse1">'.$row->total_records.' Vote(s) </span></a><span id="serverResponse2">Average: '.$avgRate.'</span>';
		}
	}
	else{
		$retValue = '<span id="serverResponse3">Average: 0 of </span><span id="serverResponse4">0 vote(s)</span>';
	}
	return $retValue;
}

function fillTimeCombo($val){
	$strMin = 0;
	$strHr = 0;
	for($i=0; $i<48; $i++){
		$strTime = date("H:i", mktime($strHr, $strMin, 0, 1, 1, 2012));
		$strTimeComp = $strTime.":00";
		if($val == $strTimeComp){
			print('<option value="'.$strTime.'" selected="selected">'.$strTime.'</option>');
		}
		else{
			print('<option value="'.$strTime.'">'.$strTime.'</option>');
		}
		if($strMin == 0){
			$strMin = 30;
		}
		else{
			$strMin = 0;
			$strHr++;
		}
	}
}

function rename_image($source){
	$ext = pathinfo($source);
	$image = substr(md5(rand(8, 999999999999999)),0,12)."_repair.".$ext['extension'];
	return $image;
}

function returnAuthor($ID){
	$retRes = "";
	if($ID == 0){
		$retRes = "Site Admin";
	}
	else{
		$strQry="SELECT mem_fname, mem_lname FROM members WHERE mem_id=".$ID;
		$nResult =mysql_query($strQry) or die("Unable 2 Work");
		if (mysql_num_rows($nResult)>=1){		
			$row=mysql_fetch_row($nResult);
			$retRes=$row[0] . " " . $row[1];
		}
	}
	return $retRes;	
}

function blogTags($ID){
	$cnt = 0;
	$strReturn = "";
	$strQuery="SELECT t.tag_name FROM bl_post_tags AS p, bl_tags AS t WHERE t.tag_id=p.tag_id AND p.post_id=".$ID;
	$nResult =mysql_query($strQuery);
	if (mysql_num_rows($nResult)>=1){
		while ($row=mysql_fetch_object($nResult)){
			if($cnt>0){
				$strReturn .= ", ";
			}
			$strReturn .= $row->tag_name;
			$cnt++;
		}
	}
	return $strReturn;
}

function getMaxTags(){
	$retResult = 0;
	$rsTag = mysql_query("SELECT MAX(tag_total) AS MaxTag FROM bl_tags");
	if (mysql_num_rows($rsTag)>=1){
		$rowTag=mysql_fetch_object($rsTag);
		$retResult = $rowTag->MaxTag;
	}
	return $retResult;
}

function getMinTags(){
	$retResult = 0;
	$rsTag = mysql_query("SELECT MIN(tag_total) AS MinTag FROM bl_tags");
	if (mysql_num_rows($rsTag)>=1){
		$rowTag=mysql_fetch_object($rsTag);
		$retResult = $rowTag->MinTag;
	}
	return $retResult;
}

function limit_text( $text, $limit )
{
  // figure out the total length of the string
  if( strlen($text)>$limit )
  {
	# cut the text
	$text = substr( $text,0,$limit );
	# lose any incomplete word at the end
	$text = substr( $text,0,-(strlen(strrchr($text,' '))) );
  }
  // return the processed string
  return $text."...";
}

function insKeyGeneral($mmod_id){
	//$mk_general = chkExist("mk_api", "module_key", "WHERE mk_id=".$mk_id." AND mmod_id=".$mmod_id." AND mk_isext=0");
	$mk_general = chkExist("mk_api", "module_key", "WHERE mmod_id=".$mmod_id." AND mk_isext=0");
	if($mk_general == '0'){
		$mk_id = getMaximum("module_key", "mk_id");
		$modName = returnName("mmod_name", "mem_modules", "mmod_id", $mmod_id);
		$str_gen = $mk_id."_".$mmod_id."_".$modName;
		$mk_general = base64_encode($str_gen);
		$mk_api = $mk_general;
		//$mk_api = $mk_general ."_". $mk_extension;
		$strQry = "INSERT INTO module_key (mk_id, mmod_id, mk_general, mk_extension, mk_api) VALUES(".$mk_id.", ".$mmod_id.", '".$mk_general."', '".$mk_extension."', '".$mk_api."')";
		$nResult = mysql_query($strQry) or die(mysql_error());
	}
	return $mk_general;
}

/*function insKeyExtension($mk_id, $mmod_id, $mk_extension){
	$mk_id = getMaximum("module_key", "mk_id");
	$modName = returnName("mmod_name", "mem_modules", "mmod_id", $mmod_id);
	$str_gen = $mk_id."_".$mmod_id."_".$modName;
	$mk_general = base64_encode($str_gen);
	$mk_api = $mk_general ."_". $mk_extension;
	$strQry = "INSERT INTO module_key (mk_id, mmod_id, mk_general, mk_extension, mk_api) VALUES(".$mk_id.", ".$mmod_id.", '".$mk_general."', '".$mk_extension."', '".$mk_api."')";
	$nResult = mysql_query($strQry) or die(mysql_error());
}*/

function returnSubsAmount($dur, $discount, $amount){
	$retAmount = round($amount, 2);
	if($dur == 'y'){
		$savings = ($amount*$discount)/100;
		$retAmount = round($amount - $savings, 2) * 12;
	}
	return $retAmount;
}

function dateDif($date1, $date2, $op){
	$retValue = "";
	$dt1 = explode("-", $date1);
	$dt2 = explode("-", $date2);
	$d1=mktime(0,0,0,$dt1[1],$dt1[2],$dt1[0]);
	$d2=mktime(0,0,0,$dt2[1],$dt2[2],$dt2[0]);
	switch ($op) {
		case 'hr':
			$retValue = floor(($d2-$d1)/3600);
			break;
		case 'min':
			$retValue = floor(($d2-$d1)/60);
			break;
		case 'sec':
			$retValue = ($d2-$d1);
			break;
		case 'year':
			$retValue = floor(($d2-$d1)/31536000);
			break;
		case 'mon':
			$retValue = floor(($d2-$d1)/2628000);
			break;
		case 'day':
			$retValue = floor(($d2-$d1)/86400);
			break;
	}
	return $retValue;
}

function getEmbedCode($swfURL, $feedURL){
	$strEmbed = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="1000" height="600">
				<param name="movie" value="'.$swfURL.'" />
				<param name="quality" value="high" />
				<param name="menu" value="false" />
				<param name="bgcolor" value="#869ca7" />
				<param name="allowFullScreen" value="true" />
				<param name="allowscriptaccess" value="always" />
				<param name="flashvars" value="feedURL='.$feedURL.'" />
				<embed src="'.$swfURL.'" menu="false" bgcolor="#869ca7" allowscriptaccess="always" allowFullScreen="true" flashvars="feedURL='.$feedURL.'" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="1000" height="600"></embed>
			</object>';
	return $strEmbed;
}

function getProEmbedCode($swfURL, $feedURL, $proVars){
	$strEmbed = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="1000" height="600">
				<param name="movie" value="'.$swfURL.'" />
				<param name="quality" value="high" />
				<param name="menu" value="false" />
				<param name="bgcolor" value="#869ca7" />
				<param name="allowFullScreen" value="true" />
				<param name="allowscriptaccess" value="always" />
				<param name="flashvars" value="feedURL='.$feedURL.$proVars.'" />
				<embed src="'.$swfURL.'" menu="false" bgcolor="#869ca7" allowscriptaccess="always" allowFullScreen="true" flashvars="feedURL='.$feedURL.$proVars.'" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="1000" height="600"></embed>
			</object>';
	return $strEmbed;
}

function chk_in_string($string, $find){
	$pos = strpos($string, $find);
	if($pos === false){
		$retVal = 0;
	}
	else{
		$retVal = 1;
	}
	return $retVal;
}

function fileRead($myFile){
	$fh = fopen($myFile, 'r');
	$fileData = fread($fh, filesize($myFile));
	fclose($fh);
	return $fileData;
}

function fileWrite($myFile, $strData){
	$fh = fopen($myFile, 'w');
	fwrite($fh, $strData);
	fclose($fh);
}

function returnFeatureVal($pfsID, $pfsName, $fnpQty, $fPrice, $fnpTenure, $fDir, $pakID, $pkfID, $pkfName, $dur, $discount){
	//$fVal = "";
	$fVal = '<input type="hidden" name="pfsID_'.$pkfID.'_'.$pakID.'" id="pfsID_'.$pkfID.'_'.$pakID.'" value="'.$pfsID.'" />';
	switch ($pfsID) {
		case 0:
			$fVal .= '<img src="'.$fDir.'images/cross.png" width="24" height="24" alt="'.$pfsName.'" style="margin-top:8px;">';
			$fVal .= '<input type="hidden" name="qty_'.$pkfID.'_'.$pakID.'" id="qty_'.$pkfID.'_'.$pakID.'" value="0" />';
			break;
		case 1:
			$fVal .= '<img src="'.$fDir.'images/tick.png" width="24" height="24" alt="'.$pfsName.'" style="margin-top:8px;">';
			$fVal .= '<input type="hidden" name="qty_'.$pkfID.'_'.$pakID.'" id="qty_'.$pkfID.'_'.$pakID.'" value="0" />';
			break;
		case 2:
			$fVal .= '<span style="line-height:38px;">Limited to <b>' . $fnpQty . '</b></span>';
			$fVal .= '<input type="hidden" name="qty_'.$pkfID.'_'.$pakID.'" id="qty_'.$pkfID.'_'.$pakID.'" value="' . $fnpQty . '" />';
			$fVal .= '<input type="hidden" name="proLimit" id="proLimit" value="' . $fnpQty . '" />';
			break;
		case 3:
			$fVal .= '<span style="line-height:38px;"><b>'.$pfsName.'</b></span>';
			$fVal .= '<input type="hidden" name="qty_'.$pkfID.'_'.$pakID.'" id="qty_'.$pkfID.'_'.$pakID.'" value="0" />';
			break;
		case 4:
			if($fnpQty>0){
				$fVal .= '<input type="checkbox" name="chk_'.$pakID.'[]" id="chk_'.$pakID.'[]" value="'.$pkfID.'" /> Add USD ' . returnSubsAmount($dur, $discount, $fPrice) . '/' . $dur;
				$fVal .= '<br />Quantity: <input type="textbox" name="qty_'.$pkfID.'_'.$pakID.'" id="qty_'.$pkfID.'_'.$pakID.'" value="1" style="width:30px; text-align:right;" class="inputsmallBorder" onFocus="this.className=\'inputsmallBorder2\';" onBlur="this.className=\'inputsmallBorder\';" />';
			}
			else{
				$fVal .= '<span style="line-height:38px;"><input type="checkbox" name="chk_'.$pakID.'[]" id="chk_'.$pakID.'[]" value="'.$pkfID.'" /> Add USD ' . returnSubsAmount($dur, $discount, $fPrice) . '/' . $dur . '</span> <input type="hidden" name="qty_'.$pkfID.'_'.$pakID.'" id="qty_'.$pkfID.'_'.$pakID.'" value="0" />';
			}
				$fVal .= '<input type="hidden" name="price_'.$pkfID.'_'.$pakID.'" id="price_'.$pkfID.'_'.$pakID.'" value="'.returnSubsAmount($dur, $discount, $fPrice).'" /><input type="hidden" name="pfName_'.$pkfID.'_'.$pakID.'" id="pfName_'.$pkfID.'_'.$pakID.'" value="'.$pkfName.'" />';
			break;
		case 5:
			$fVal = '<span style="line-height:34px;"><b><a href="#" title="Contact Us">Contact Us</a></b></span>';
			break;
	}
	return $fVal;
}

function showStatus($val){
	switch ($val) {
		case 0:
			$varStatus = "Pending";
			break;
		case 1:
			$varStatus = "Completed";
			break;
		case 2:
			$varStatus = "Failed";
			break;
		case 3:
			$varStatus = "Denied";
			break;
		case 4:
			$varStatus = "INVALID";
			break;
		case 5:
			$varStatus = "Cancelled";
			break;
		case 6:
			$varStatus = "Rejected";
			break;
	}
	return $varStatus;
}

function copyDir($dir, $dest){
	if ($handle = opendir($dir)) {
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != "..") {
				$pos = strpos($file, ".");
				if($pos > 0){
					$strSource = $dir . "/" . $file;
					$strDest = $dest . "/" . $file;
					copy($strSource, $strDest);
				}
			}
		}
		closedir($handle);
	}
}

function showCardname($ID){
	$retRes = "";
	$strQry="SELECT mcard_name FROM mem_cards WHERE mcard_id=$ID";
	$nResult =mysql_query($strQry) or die("Unable 2 Work");
	if (mysql_num_rows($nResult)>=1){		
		$row=mysql_fetch_row($nResult);
		$retRes=$row[0];
	}
	else{
		$retRes = "Card Removed";
	}
	return $retRes;	
}

function FillSelected($Table, $IDField, $TextField, $ID){   
	$strQuery="SELECT $IDField, $TextField FROM $Table ORDER BY $IDField";
	$nResult =mysql_query($strQuery);
	if (mysql_num_rows($nResult)>=1){
		while ($row=mysql_fetch_row($nResult)){
			if($row[0] == $ID){
				print("<option value=\"$row[0]\" selected>$row[1]</option>");
			}
			else{
				print("<option value=\"$row[0]\">$row[1]</option>");
			}
		}
	}
}

// Display Just Parent Categories
function FillSelected2($Table, $IDField, $TextField, $ID, $WHERE){
	$strQuery="SELECT $IDField, $TextField FROM $Table WHERE $WHERE ORDER BY $IDField ASC";
	$nResult =mysql_query($strQuery);
	if (mysql_num_rows($nResult)>=1){
		while ($row=mysql_fetch_row($nResult)){
			if($row[0] == $ID){
				print("<option value=\"$row[0]\" selected>$row[1]</option>");
			}
			else{
				print("<option value=\"$row[0]\">$row[1]</option>");
			}
		}
	}
}

function FillSelectedValue($Table, $IDField, $TextField, $ID){   
	$strQuery="SELECT $IDField, $TextField FROM $Table ORDER BY $IDField";
	$nResult =mysql_query($strQuery);
	if (mysql_num_rows($nResult)>=1){
		while ($row=mysql_fetch_row($nResult)){
			if($row[0] == $ID){
				print("<option value=\"$row[1]\" selected>$row[1]</option>");
			}
			else{
				print("<option value=\"$row[1]\">$row[1]</option>");
			}
		}
	}
}

function FillMultiple($Table, $IDField, $TextField, $SelTbl, $Field1, $Field2, $SelID){
	$strQuery="SELECT $IDField, $TextField FROM $Table";
	$nResult =mysql_query($strQuery);
	if (mysql_num_rows($nResult)>=1){
		while ($row=mysql_fetch_row($nResult)){
			$strQuery1="SELECT * FROM $SelTbl WHERE $Field1=$row[0] AND $Field2=$SelID";
			$nResult1 =mysql_query($strQuery1);
			if (mysql_num_rows($nResult1)>=1){
				print("<option value=\"$row[0]\" selected>$row[1]</option>");
			}
			else{
				print("<option value=\"$row[0]\">$row[1]</option>");
			}
		}
	}
}
function FillSelected_Parent($Table, $IDField, $TextField, $ID, $parentField){   
	$strQuery="SELECT $IDField, $TextField FROM $Table WHERE $parentField = 0";
	$nResult =mysql_query($strQuery);
	if (mysql_num_rows($nResult)>=1){
		while ($row=mysql_fetch_row($nResult)){
			$strQry="SELECT $IDField, $TextField FROM $Table WHERE $parentField = $row[0]";
			$nRs = mysql_query($strQry);
			if (mysql_num_rows($nRs)>=1){
				print("<optgroup label=\"$row[1]\">");
				while ($row1=mysql_fetch_row($nRs)){
					if($row1[0] == $ID){
						print("<option value=\"$row1[0]\" selected>$row1[1]</option>");
					}
					else{
						print("<option value=\"$row1[0]\">$row1[1]</option>");
					}
				}
				print("</optgroup>");
			}
			else{
				if($row[0] == $ID){
					print("<option value=\"$row[0]\" selected>$row[1]</option>");
				}
				else{
					print("<option value=\"$row[0]\">$row[1]</option>");
				}
			}
		}
	}
}
function FillSelected_ParentLang($Table, $IDField, $TextField, $ID, $parentField, $langID){   
	$strQuery="SELECT a.".$IDField.", l.".$TextField.", a.".$parentField." FROM ".$Table." AS a LEFT OUTER JOIN ".$Table."_ln AS l ON l.".$IDField."=a.".$IDField." AND lang_id=".$langID." WHERE a.".$parentField." = 0";
	$nResult =mysql_query($strQuery);
	if (mysql_num_rows($nResult)>=1){
		while ($row=mysql_fetch_row($nResult)){
			//$strQry="SELECT $IDField, $TextField, $parentField FROM $Table WHERE $parentField = $row[0]";
			$strQry = "SELECT a.".$IDField.", l.".$TextField.", a.".$parentField." FROM ".$Table." AS a LEFT OUTER JOIN ".$Table."_ln AS l ON l.".$IDField."=a.".$IDField." AND lang_id=".$langID." WHERE a.$parentField = $row[0]";
			$nRs = mysql_query($strQry);
			if (mysql_num_rows($nRs)>=1){
				print("<optgroup label=\"$row[1]\">");
				while ($row1=mysql_fetch_row($nRs)){
					if($row1[0] == $ID){
						print("<option value=\"$row1[0]\" selected>$row1[1]</option>");
					}
					else{
						print("<option value=\"$row1[0]\">$row1[1]</option>");
					}
				}
				print("</optgroup>");
			}
			else{
				if($row[0] == $ID){
					print("<option value=\"$row[0]\" selected>$row[1]</option>");
				}
				else{
					print("<option value=\"$row[0]\">$row[1]</option>");
				}
			}
		}
	}
}

function TotalRecords($Table, $condition){
	$strQuery = "SELECT * FROM $Table $condition";
	$nResult = mysql_query($strQuery);
	return mysql_num_rows($nResult);
}

function TotalRecords1($condition){
	$strQuery = $condition;
	$nResult = mysql_query($strQuery);
	return mysql_num_rows($nResult);
}

function checkAdminOldPass($UserID,$Pass){
	$retRes=0;
		$strQry="SELECT admin_user, admin_pass FROM admin WHERE admin_id=$UserID AND admin_pass='$Pass'";
		$nResult =mysql_query($strQry);
		if (mysql_num_rows($nResult)>=1){
			$retRes=1;
		}
	return $retRes;		
}

function checkAdminLogin($Login,$Pass){
	$retRes=0;
	$strQry="SELECT user_id FROM user WHERE user_name='$Login' AND user_password='$Pass'";
	$nResult=mysql_query($strQry);
	if (mysql_num_rows($nResult)>=1){
		$retRes=1;
	}	
	return $retRes;		
}

function checkSAdminLogin($Login,$Pass){
	$retRes=0;
	$strQry="SELECT sadmin_user FROM sec_admin WHERE sadmin_user='$Login' AND sadmin_pass='$Pass'";
	$nResult =mysql_query($strQry);
	if (mysql_num_rows($nResult)>=1){
		while ($row=mysql_fetch_object($nResult)){
			if(@$row->sadmin_user) 
				$retRes=1;
		}
	}	
	return $retRes;		
}

function checkLogin($Login,$Pass){
	$retRes=0;
	$strQry="SELECT mem_login FROM members WHERE mem_login='$Login' AND mem_password='$Pass'";
	$nResult = mysql_query($strQry);
	if (mysql_num_rows($nResult)>=1){
		while ($row=mysql_fetch_object($nResult)){
			if(@$row->mem_login)
				$retRes=1;
		}
	}	
	return $retRes;		
}

function checkLogin2($Login,$Pass){
	$retRes=0;
	$strQry="SELECT mem_login FROM members WHERE mem_login='$Login' AND mem_password='$Pass' AND mem_deleted = 1";
	$nResult = mysql_query($strQry);
	if (mysql_num_rows($nResult)>=1){
		while ($row=mysql_fetch_object($nResult)){
			if(@$row->mem_login)
				$retRes=1;
		}
	}	
	return $retRes;		
}

function checkSubscription($mID){
	$retRes=0;
	$strQry="SELECT sinfo_enddate, paystatus_id FROM subscription_info WHERE mem_id=$mID";
	$nResult = mysql_query($strQry);
	if (mysql_num_rows($nResult)>=1){
		$row=mysql_fetch_object($nResult);
		if($row->paystatus_id > 1){
			$retRes=2;
		}
		elseif($row->paystatus_id < 1){
			$retRes=3;
		}
		elseif($row->sinfo_enddate < date("Y-m-d")){
			$retRes=1;
		}
		else{
			$retRes=4;
		}
	}
	return $retRes;		
}

function UpdateSignIn($MemberID, $MemberEmail){
	$MaxID = getMaximum("signin_counter", "signin_id");
	
	$strQry1="UPDATE members SET mem_last_login = NOW() WHERE mem_id=$MemberID";
	$nResult1 = mysql_query($strQry1);
	
	$strQry2="INSERT INTO signin_counter(signin_id, mem_id, mem_email, signin_date) VALUES ($MaxID, $MemberID, '$MemberEmail', NOW())";
	$nResult2 = mysql_query($strQry2);
}

function updateViews($cardID, $numViews){
	$totalViews = $numViews + 1;
	mysql_query("UPDATE cards SET card_views=".$totalViews." WHERE card_id = ".$cardID) or die("Unable 2 Update Views");
}

function getRating($PhotoID){
	$Rating = 0;
	$strQry="SELECT photo_totalrating, photo_rating FROM photos WHERE photo_id = $PhotoID";
	$nResult =mysql_query($strQry);
	if (mysql_num_rows($nResult)>=1){
		while ($row=mysql_fetch_object($nResult)){
			if($row->photo_totalrating > 0 && $row->photo_rating > 0) 
				$Rating = $row->photo_totalrating / $row->photo_rating;
			else
				$Rating=0;
		}
	}	
	return $Rating;	
}

function getMaximumWhere($Table,$Field, $Where){
	$maxID = 0;
	$strQry="SELECT MAX(" . $Field . ")+1 as CID FROM " . $Table . " ".$Where;
	$nResult =mysql_query($strQry);
	if (mysql_num_rows($nResult)>=1){
		while ($row=mysql_fetch_object($nResult)){
			if(@$row->CID) 
				$maxID=$row->CID;
			else
				$maxID=1;
		}
	}	
	return $maxID;	
}

function getMaximum($Table,$Field){
	$maxID = 0;
	$strQry="SELECT MAX(" . $Field . ")+1 as CID FROM " . $Table . " ";
	$nResult =mysql_query($strQry);
	if (mysql_num_rows($nResult)>=1){
		while ($row=mysql_fetch_object($nResult)){
			if(@$row->CID) 
				$maxID=$row->CID;
			else
				$maxID=1;
		}
	}	
	return $maxID;	
}

function getMaximumCatID($Table,$Field){
	$maxID = 0;
	$strQry="SELECT MAX(" . $Field . ")+1 as CID FROM " . $Table . " ";
	$nResult =mysql_query($strQry);
	if (mysql_num_rows($nResult)>=1){
		while ($row=mysql_fetch_object($nResult)){
			if(@$row->CID) 
				$maxID=$row->CID;
			else
				$maxID=2;
		}
	}	
	return $maxID;	
}

function IsExist($Field, $Table, $TblField, $Value){
	$retRes=0;
	$strQry="SELECT $Field FROM $Table WHERE $TblField='$Value'";
	$nResult =mysql_query($strQry) or die(mysql_error());
	if (mysql_num_rows($nResult)>=1){		
		$retRes=1;
	}	
	return $retRes;		
}

function chkExist($Field, $Table, $WHERE){
	$retRes=0;
	$strQry="SELECT $Field FROM $Table $WHERE";
	$nResult=mysql_query($strQry) or die("Unable 2 Work");
	if (mysql_num_rows($nResult)>=1){
		$row=mysql_fetch_row($nResult);
		$retRes = $row[0];
		//$retRes=1;
	}	
	return $retRes;		
}

function returnMulCat($ID){
	$retRes = "";
	$numCnt = 0;
	$strQry="SELECT c.cat_name FROM categories AS c, card_categories AS cc WHERE c.cat_id = cc.cat_id AND cc.card_id = $ID";
	$nResult =mysql_query($strQry) or die("Unable 2 Work");
	if (mysql_num_rows($nResult)>=1){	
		while($row=mysql_fetch_row($nResult)){
			if($numCnt == 0){
				$retRes.=$row[0];
			}
			else{
				$retRes.=", ".$row[0];
			}
			$numCnt++;
		}
	}	
	return $retRes;
}

function returnName($Field, $Table, $IDField, $ID){
	$retRes = "";
	$strQry="SELECT $Field FROM $Table WHERE $IDField=$ID";
	$nResult =mysql_query($strQry) or die("Unable 2 Work");
	if (mysql_num_rows($nResult)>=1){		
		$row=mysql_fetch_row($nResult);
		$retRes=$row[0];
	}	
	return $retRes;	
}

function returnID($Field, $Table, $NameField, $Name){
	$strQry="SELECT $Field FROM $Table WHERE $NameField='$Name'";
	$nResult =mysql_query($strQry) or die("Unable 2 Work");
	if (mysql_num_rows($nResult)>=1){		
		$row=mysql_fetch_row($nResult);
		$retRes=$row[0];
	}	
	return $retRes;		
}

function countCategories($Field, $qryText){
	$strQry="SELECT CatID, CatName FROM Categories WHERE ParentID = $Field $qryText";
	$nResult =mysql_query($strQry);
	if (mysql_num_rows($nResult)>=1){
		$count = mysql_num_rows($nResult);
	}
	else{
		$count = 0;
	}	
	return $count;	
}

function countSubCategories($Field){
	$strQry="SELECT CatID, CatName FROM Categories WHERE ParentID = $Field";
	$nResult =mysql_query($strQry);
	if (mysql_num_rows($nResult)>=1){
		$count = mysql_num_rows($nResult);
	}
	else{
		$count = 0;
	}	
	return $count;	
}

// Return Number of products in Category
function countProducts($CatID){
	$strQry="SELECT C.CatID, C.ParentID, P.ProID, P.ItemNumber, P.ProName, P.Size, P.Price, P.ProPicture FROM Categories AS C, Products AS P, Products_Categories AS PC WHERE C.CatID = PC.CatID AND P.ProID = PC.ProID AND PC.CatID = $CatID";
	$nResult =mysql_query($strQry);
	if (mysql_num_rows($nResult)>=1){
		$count = mysql_num_rows($nResult);
	}
	else{
		$count = 0;
	}	
	return $count;	
}

// Return Number of products in Category and its Sub Category
function countProducts1($CatID){
	//$strQry="SELECT C.CatID, C.ParentID, P.ProID, P.ItemNumber, P.ProName, P.Size, P.Price, P.ProPicture FROM Categories AS C, Products AS P, Products_Categories AS PC WHERE C.CatID = PC.CatID AND P.ProID = PC.ProID AND PC.CatID = $CatID AND C.ParentID = $CatID";
	$strQry="SELECT C.CatID, C.ParentID, P.ProID, P.ItemNumber, P.ProName, P.Size, P.Price, P.ProPicture FROM Categories AS C, Products AS P, Products_Categories AS PC WHERE C.CatID = $CatID AND PC.CatID = C.CatID AND P.ProID = PC.ProID OR C.ParentID = $CatID AND PC.CatID = C.CatID AND P.ProID = PC.ProID";
	//print($strQry);
	$nResult =mysql_query($strQry);
	if (mysql_num_rows($nResult)>=1){
		$count = mysql_num_rows($nResult);
	}
	else{
		$count = 0;
	}	
	return $count;	
}
// function for file deletion
function DeleteFile($Field,$Table,$IDField,$ID){
	$strQuery="SELECT $Field FROM $Table WHERE $IDField=$ID";
	//	print($strQuery);
	$nResult =mysql_query($strQuery);
	if (mysql_num_rows($nResult)>=1){
		$row=mysql_fetch_object($nResult);
		//print($row->$Field);
		$fPath = "../".$row->$Field;
		@unlink($fPath);
	}
}
// function for file deletion
function DeleteFileWithThumb($Field, $Table, $IDField, $ID, $iPath, $tPath){
	$strQuery="SELECT $Field FROM $Table WHERE $IDField=$ID";
	//	print($strQuery);
	$nResult = mysql_query($strQuery);
	if (mysql_num_rows($nResult)>=1){
		$row = mysql_fetch_object($nResult);
		$fPath = $iPath.$row->$Field;
		@unlink($fPath);
		if($tPath != "EMPTY"){
			$fPath = $tPath.$row->$Field;
			@unlink($fPath);	
		}
	}
}
// function for file deletion
function DeleteFile2($Field, $Table, $IDField, $ID, $path){
	$strQuery="SELECT $Field FROM $Table WHERE $IDField=$ID";
	$nResult =mysql_query($strQuery);
	if (mysql_num_rows($nResult)>=1){
		$row=mysql_fetch_object($nResult);
		$iPath = $path.$row->$Field;
		@unlink($iPath);
		$tPath = $path."th/".$row->$Field;
		@unlink($tPath);
	}
}
function Fill($Table, $IDField, $TextField, $chkSelected){
	$strQuery="SELECT $IDField, $TextField FROM $Table ORDER BY $IDField";
	$nResult =mysql_query($strQuery);
	if (mysql_num_rows($nResult)>=1){
		while ($row=mysql_fetch_row($nResult)){
			if ($chkSelected == $row[0]){
				print("<option value=\"$row[0]\" selected>$row[1]</option>");
			}
			else{
				print("<option value=\"$row[0]\">$row[1]</option>");
			}
		}
	}
}

function ImageSize($imagesource, $DisplayH, $DisplayW){
	list($width, $height, $type, $attr) = getimagesize($imagesource);
	$wid = $width;
	$hig = $height;
	
	if($wid > $DisplayW || $hig > $DisplayH){
		if($wid <= $hig){
			$img_ratio = $wid / $hig;
			$newHeight = $DisplayH;
			$temp = $newHeight * $img_ratio;
			$newWidth = round($temp);
		}
		else{
			$img_ratio = $hig / $wid;
			$newWidth = $DisplayW;
			$temp = $newWidth * $img_ratio;
			$newHeight = round($temp);
		}
	}
	else{
		$newHeight = $hig;
		$newWidth = $wid;
	}
	
	$showimage = "<img src=\"".$imagesource."\" height=\"".$newHeight."\" width=\"".$newWidth."\" class=\"img\">";
	return $showimage;
}

function IncreaseViews($Table, $CounterFeild, $IDField, $ID){
	$Query = "UPDATE $Table SET $CounterFeild = $CounterFeild+1 WHERE $IDField = $ID";
	$nRst=mysql_query($Query) or die("Unable 2 Edit Record");
}

function GetViews($Field, $Table, $IDField, $ID){
	$strQry="SELECT $Field FROM $Table WHERE $IDField=$ID";
	$nResult =mysql_query($strQry) or die("Unable 2 Work");
	if (mysql_num_rows($nResult)>=1){		
		$rs=mysql_fetch_object($nResult);
		print($rs->$Field);
	}	
}

function SelectDate($emonth, $eday){
	print("<select name=\"month1\" class=\"inputsmallBorder\">");
	for($i=1; $i<=12; $i++) {
		if($emonth == $i){
			print("<option value=\"$i\" selected>$i</option>");
		}
		else{
			print("<option value=\"$i\">$i</option>");
		}
	}
	print("</select>&nbsp;");
	
	print("<select name=\"day1\" class=\"inputsmallBorder\">");
	for($i=1; $i<=31; $i++) {
		if ($eday == $i){
			print("<option value=\"$i\" selected>$i</option>");
		}
		else{
			print("<option value=\"$i\">$i</option>");
		}
	}
	print("</select>");
}

function Display_Alphabets($char, $QryString){
	$count = 0;
	$linksHTML = "";
	$char_array = array();
		$char_array[0]	=	"A";
		$char_array[1]	=	"B";
		$char_array[2]	=	"C";
		$char_array[3]	=	"D";
		$char_array[4]	=	"E";
		$char_array[5]	=	"F";
		$char_array[6]	=	"G";
		$char_array[7]	=	"H";
		$char_array[8]	=	"I";
		$char_array[9]	=	"J";
		$char_array[10]	=	"K";
		$char_array[11]	=	"L";
		$char_array[12]	=	"M";
		$char_array[13]	=	"N";
		$char_array[14]	=	"O";
		$char_array[15]	=	"P";
		$char_array[16]	=	"Q";
		$char_array[17]	=	"R";
		$char_array[18]	=	"S";
		$char_array[19]	=	"T";
		$char_array[20]	=	"U";
		$char_array[21]	=	"V";
		$char_array[22]	=	"W";
		$char_array[23]	=	"X";
		$char_array[24]	=	"Y";
		$char_array[25]	=	"Z";

	$linksHTML = "<table width=\"98%\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\"><tr>";
	while ($count < count($char_array)) {
		if($char == $char_array[$count]) {
			$linksHTML .= "<td align=\"center\" class=\"charSelected\">".$char_array[$count]."</td>";
		}
		else{
			if($QryString != ""){
				$linksHTML .= "<td align=\"center\" class=\"char\"><a href=\"".$_SERVER['PHP_SELF']."?char=".$char_array[$count]."&".$QryString."\" title=\"".$char_array[$count]."\">".$char_array[$count]."</a></td>";
			}
			else{
				$linksHTML .= "<td align=\"center\" class=\"char\"><a href=\"".$_SERVER['PHP_SELF']."?char=".$char_array[$count]."\" title=\"".$char_array[$count]."\">".$char_array[$count]."</a></td>";
			}
		}
		$count++;
	}

	
	$linksHTML .= "</tr></table>";
	print($linksHTML);
}

function showBanner($location, $showOne){
	// show random banner where status is 1
	if($showOne == 0){
		$stringQry="SELECT * FROM banner WHERE status_id = 1 AND bloc_id = ".$location;
	}
	else{
		$stringQry="SELECT * FROM banner WHERE status_id = 1 AND bloc_id = ".$location." ORDER BY RAND()";
	}
	$nRst = mysql_query($stringQry);
	if(mysql_num_rows($nRst)>=1){
		print("<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">");
		while($rowb=mysql_fetch_object($nRst)){
			$totalView = $rowb->banner_display + 1;
			$banID = $rowb->banner_id;
			print("<tr>");
			print("<td>");
			if($rowb->bformat_id == 2){
				print("<a href=\"bannerclick.php?banid=".$banID."&url=".$rowb->banner_url."\" title=\"".$rowb->banner_alttext."\" target=\"_blank\">");
				print("<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0\" border=\"0\">");
				print("<param name=\"movie\" value=\"".$rowb->banner_source."\">");
				print("<param name=\"quality\" value=\"high\">");
				print("<embed src=\"".$rowb->banner_source."\" quality=\"high\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\"></embed></object>");
				print("</a>");
			}
			else{
				print("<a href=\"bannerclick.php?banid=".$banID."&url=".$rowb->banner_url."\" title=\"".$rowb->banner_alttext."\" target=\"_blank\"><img src=\"".$rowb->banner_source."\" alt=\"".$rowb->banner_alttext."\" border=\"0\" align=\"absbottom\" class=\"img\"></a>");
			}
		print("		</td>");
		print("	</tr>");
		print("<tr><td height=\"10\"></td></tr>");
		}
	print("</table>");
	mysql_query("UPDATE banner SET banner_display=".$totalView." WHERE banner_id = ".$banID);
	}
}

function showBanner2($btype){
	// show random banner where status is 1
	$stringQry="SELECT * FROM banners WHERE status_id = 1 AND ban_start_date <= '".date("Y-m-d")."' AND ban_end_date >= '".date("Y-m-d")."' AND btype_id = ".$btype." ORDER BY RAND()";
	$nRst = mysql_query($stringQry);
	if(mysql_num_rows($nRst)>=1){
		print("<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">");
		while($rowb=mysql_fetch_object($nRst)){
			$totalView = $rowb->ban_display + 1;
			$banid = $rowb->ban_id;
			print("<tr>");
			print("<td>");
		/*	
			if($rowb->bformat_id == 2){
				print("<a href=\"bannerclick.php?banid=".$banID."&url=".$rowb->banner_url."\" title=\"".$rowb->banner_alttext."\" target=\"_blank\">");
				print("<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0\" border=\"0\">");
				print("<param name=\"movie\" value=\"".$rowb->banner_source."\">");
				print("<param name=\"quality\" value=\"high\">");
				print("<embed src=\"".$rowb->banner_source."\" quality=\"high\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\"></embed></object>");
				print("</a>");
			}
			else{
		*/
				print("<a href=\"bannerclick.php?banid=".$banid."&url=".$rowb->ban_link."\" target=\"_blank\"><img src=\"banner_files/".$rowb->ban_image."\" alt=\"".$rowb->ban_alt_text."\" border=\"0\" align=\"absbottom\" class=\"img\"></a>");
		//	}
		print("		</td>");
		print("	</tr>");
		print("<tr><td height=\"10\"></td></tr>");
		}
	print("</table>");
	mysql_query("UPDATE banners SET ban_display=".$totalView." WHERE ban_id = ".$banid);
	}
}

function createThumbnail($imageDirectory, $imageName, $thumbDirectory, $thumbWidth){
$srcImg = imagecreatefromjpeg("$imageDirectory/$imageName");
$origWidth = imagesx($srcImg);
$origHeight = imagesy($srcImg);

$ratio = $origWidth / $thumbWidth;
$thumbHeight = $origHeight * $ratio;

$thumbImg = imagecreate($thumbWidth, $thumbHeight);
imagecopyresized($thumbImg, $srcImg, 0, 0, 0, 0, $thumbWidth, $thumbHeight, imagesx($thumbImg), imagesy($thumbImg));

imagejpeg($thumbImg, "$thumbDirectory/$imageName");
}

function createThumbnail2($imageDirectory, $imageName, $thumbDirectory, $thumbWidth, $thumbHeight){
	$srcImg = imagecreatefromjpeg("$imageDirectory/$imageName");
	$sourceWidth = imagesx($srcImg);
	$sourceHeight = imagesy($srcImg);
	
	if($sourceHeight > $sourceWidth){
		$ratio = $sourceHeight / $thumbHeight;
		$tmpWidth = $sourceWidth / $ratio;
		if($tmpWidth > $thumbWidth){
			$ratio = $sourceWidth / $thumbWidth;
			$thumbHeight = round($sourceHeight / $ratio);
		}
		else{
			$thumbWidth = $tmpWidth;
		}
	}
	else{
		$ratio = $sourceWidth / $thumbWidth;
		$tmpHeight = $sourceHeight / $ratio;
		if($tmpHeight > $thumbHeight){
			$ratio = $sourceHeight / $thumbHeight;
			$thumbWidth = round($sourceWidth / $ratio);
		}
		else{
			$thumbHeight = $tmpHeight;
		}
	}
	
	$thumbImg = imagecreatetruecolor($thumbWidth, $thumbHeight);
	imagecopyresized($thumbImg, $srcImg, 0, 0, 0, 0, $thumbWidth, $thumbHeight, imagesx($srcImg), imagesy($srcImg));
	
	imagejpeg($thumbImg, $thumbDirectory.$imageName);
}

function left_side_menu($Table, $IDField, $TextField, $ID, $parentField, $section, $table2, $page){   
	$strQuery="SELECT $IDField, $TextField FROM $Table WHERE $parentField = 0 AND section_id='".$section."' AND status_id=1 ";
	$nResult =mysql_query($strQuery);
	if (mysql_num_rows($nResult)>=1){
		while ($row=mysql_fetch_row($nResult)){
			$strQry="SELECT $IDField, $TextField FROM $Table WHERE $parentField = $row[0] AND status_id=1";
			$nRs = mysql_query($strQry);
			if (mysql_num_rows($nRs)>=1){
				echo "<a class='menuheader expandable'>$row[1]</a>";
					echo "<ul class='categoryitems'>";
						while ($row1=mysql_fetch_row($nRs)){
							if($row1[0] == $ID){
								echo ("$row1[1]");
							}
							else{
								$total_sub_products = TotalRecords($table2, " WHERE cat_id='".$row1[0]."' AND status_id=1 ");
								echo "<li><a href='".$page."$row1[0]'>$row1[1] ($total_sub_products) </a></li>";
							}
						}
					echo "</ul>";
			}
			else{
				if($row[0] == $ID){
					echo ("$row[1]");
				}
				else{
					echo ("<a class='menuheader expandable'>$row[1]</a>");
				}
			}
		}
	}
}

function left_side_menu2($Table, $IDField, $TextField, $ID, $parentField, $section){   
	$strQuery="SELECT $IDField, $TextField FROM $Table WHERE $parentField = 0 AND section_id='".$section."'";
	$nResult =mysql_query($strQuery);
	if (mysql_num_rows($nResult)>=1){
		while ($row=mysql_fetch_row($nResult)){
			$strQry="SELECT $IDField, $TextField FROM $Table WHERE $parentField = $row[0]";
			echo "<option disabled='disabled' style='font-weight:bold'>$row[1]</option>";
			$nRs = mysql_query($strQry);
			if (mysql_num_rows($nRs)>=1){
				while ($row1=mysql_fetch_row($nRs)){
					if($row1[0] == $ID){
						echo "<option value='$row1[0]' selected='selected'>$row1[1]</option>";
					}
					else{
						echo "<option value='$row1[0]'>$row1[1]</option>";
					}
				}
			}
		}
	}
}
			
function dateTime($date,$displayTime){
	if($date != ""){
		$arrtime = '';
		$time = '';
		$arrdate = explode("-", $date);
			$arrdate2 = explode(" ", $arrdate[2]);
			if(sizeof($arrdate2)>1){
				$arrtime = explode(":", $arrdate2[1]);
				$time = date("g:i:s a", mktime ($arrtime[0],$arrtime[1],$arrtime[2]));
			}
		$date = date("M j, Y", mktime (0, 0, 0, $arrdate[1], $arrdate2[0], $arrdate[0]));
		if($date == "0000-00-00" or $date == "0000-00-00 00:00:00") {
			$date = '';
		}
		if($displayTime == 1){
			return $date = $date.' '.$time;
		} else {
			return $date = $date;
		}
	}
}

function displayAllRecords($field, $from, $where){
	$counter = 0;
	$Query =  "SELECT $field FROM $from WHERE $where ";
	$pro = mysql_query($Query);
	$total_rec = mysql_num_rows($pro);
	while($row=mysql_fetch_assoc($pro)){
		$counter++;
		echo $row[$field];
		if($total_rec != $counter){ echo ' , ';}
	}
}

function redirect($url) {
	if (!headers_sent()) {
		//If headers not sent yet... then do php redirect
		header('Location: '.$url);
		exit;
	} else {
		//If headers are sent... do javascript redirect... if javascript disabled, do html redirect.
		echo '<script type="text/javascript">';
		echo 'window.location.href="'.$url.'";';
		echo '</script>';
		echo '<noscript>';
		echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
		echo '</noscript>';
		exit;
	}
}

?>