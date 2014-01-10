<?php
function thanksMail($mName, $mTo, $officeName, $phone){
	$rm = mysql_query("SELECT * FROM auto_email WHERE ae_id=4");
	if(mysql_num_rows($rm)){
		$row=mysql_fetch_object($rm);
		$fromMail = $row->ae_from;
		$subject = $row->ae_subject;
		$message = str_replace("[NAME]", $mName, str_replace("[OFFICE_NAME]", $officeName, str_replace("[PHONE]", $phone, $row->ae_contents)));
		$headers = "From: IncomeBasedFunding <" . strip_tags($fromMail) . ">\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		@mail($mTo, $subject, $message, $headers);
	}
}
function appOffice($mName, $mTo){
	$rm = mysql_query("SELECT * FROM auto_email WHERE ae_id=3");
	if(mysql_num_rows($rm)){
		$row=mysql_fetch_object($rm);
		$fromMail = $row->ae_from;
		$subject = $row->ae_subject;
		$message = str_replace("[NAME]", $mName, $row->ae_contents);
		$headers = "From: IncomeBasedFunding <" . strip_tags($fromMail) . ">\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		@mail($mTo, $subject, $message, $headers);
	}
}
function appAdmin($mTo){
	$rm = mysql_query("SELECT * FROM auto_email WHERE ae_id=2");
	if(mysql_num_rows($rm)){
		$row=mysql_fetch_object($rm);
		$fromMail = $row->ae_from;
		$subject = $row->ae_subject;
		//$message = str_replace("[NAME]", $mName, $row->ae_contents);
		$message = $row->ae_contents;
		$headers = "From: IncomeBasedFunding <" . strip_tags($fromMail) . ">\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		@mail($mTo, $subject, $message, $headers);
	}
}
function appNoShow($mName, $mTo, $officeName, $phone){
	$rm = mysql_query("SELECT * FROM auto_email WHERE ae_id=1");
	if(mysql_num_rows($rm)){
		$row=mysql_fetch_object($rm);
		$fromMail = $row->ae_from;
		$subject = $row->ae_subject;
		$message = str_replace("[NAME]", $mName, str_replace("[OFFICE_NAME]", $officeName, str_replace("[PHONE]", $phone, $row->ae_contents)));
		$headers = "From: IncomeBasedFunding <" . strip_tags($fromMail) . ">\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		@mail($mTo, $subject, $message, $headers);
	}
}
function appNotSold($mName, $mTo, $officeName, $phone){
	$rm = mysql_query("SELECT * FROM auto_email WHERE ae_id=6");
	if(mysql_num_rows($rm)){
		$row=mysql_fetch_object($rm);
		$fromMail = $row->ae_from;
		$subject = $row->ae_subject;
		$message = str_replace("[NAME]", $mName, str_replace("[OFFICE_NAME]", $officeName, str_replace("[PHONE]", $phone, $row->ae_contents)));
		$headers = "From: IncomeBasedFunding <" . strip_tags($fromMail) . ">\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		@mail($mTo, $subject, $message, $headers);
	}
}



function cancelMembership($mName, $mTo){
	$fromMail = "noreply@autoauctionpass.com";
	$subject = "Membership Cacelled :: Auto Auction Pass";
	
	$welcome = "Hi ".$mName."
	\n\nYour membership has been cancelled.
	\n\nThis is an automatically generated message. Pleae do not reply to this message.If you would like to contact us, please use the contact form on our website.";
	
	$message = $welcome;
				
	$headers = "From: Auto Auction Pass <" . $fromMail . ">"; 	

	@mail($mTo, $subject, $message, $headers);
}

function SendConfirmation($mName, $mTo, $mID){
	//sending email for Registration confirmation...
	$fromMail = "noreply@strictlypro.com";
	$subject = "Strictly Pro";
	
	$welcome = "Hi ".$mName."
	\n\nWelcome and thanks for joining strictlypro!

	\n\nTo activate your account and begin using strictlypro just click the link below to confirm that your email is working:
	\nhttp://www.strictlypro.com/activate.php?memid=".$mID."
	\n\nIf clicking the link does not work, type or copy and paste the link into your web browser. 
	\nMake sure to copy the address exactly and do not add extra spaces.
	
	\nhttp://www.strictlypro.com
	
	\n\nThis is an automatic generated message. Do not reply to this message. In case you’ll like to contact us, please use the contact form on our website.";
	
	$message = $welcome;
				
	$headers = "From: strictlypro <" . $fromMail . ">"; 	

	@mail($mTo, $subject, $message, $headers);
}

function sendQuoteMail($mTo, $fromEmail, $quoteType, $quoteMessage){
	$subject = $quoteType;
	$welcome = $quoteMessage."
	\n\nThis is an automatic generated message. Do not reply to this message. In case you’ll like to contact us, please use the contact form on our website.";
	$message = $welcome;
	$headers = "From: Enzee Textile<" . $fromEmail . ">"; 	
	@mail($mTo, $subject, $message, $headers);
}
function SendCardHTML($mName, $mTo, $cardID, $senderID, $fromName, $thImage){
	//sending email for Registration confirmation...
	$fromMail = "noreply@wondercard.net";
	$subject = $fromName." has sent you a wonder eCard";
	$cardURL = "http://www.wondercard.net/view_card.php?mcard_id=".$cardID."&sendid=".$senderID;
	//$cardImage = "http://www.wondercard.net/images/mail_images/card_img.jpg";
	$cardImage = "http://www.wondercard.net/cards/th/".$thImage;
	
	$welcome = '<style>
	a{text-decoration:none; color:#790000;}
	table, td, p, div{padding:0px; border:0px;}
	</style>
	<table align="center" width="750" height="701" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="border-spacing:0px;">
		<tr><td colspan="5" align="center" height="20" style="font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#898989;">Add greeting@wondercard.net to your address book to ensure that youreceive Wonder Cardz email in your inbox.</td></tr>
		<tr><td colspan="5" width="750" height="74"><img src="http://www.wondercard.net/images/mail_images/email_img_1.jpg" width="750" height="74" alt=""></td></tr>
		<tr>
			<td colspan="2" width="165" height="147"><img src="http://www.wondercard.net/images/mail_images/email_img_2.jpg" width="165" height="147" alt=""></td>
			<td width="400" height="147" colspan="2" valign="bottom" background="http://www.wondercard.net/images/mail_images/email_img_bg.jpg" bgcolor="#DAECEE">
				<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; color:#898989; border-spacing:0px;">
					<tr><td height="20" align="center" style="font-size:14px; color:#000000;">Hi, '.$mName.'</td></tr>
					<tr><td align="center" style="font-size:32px;">'.$fromName.'</td></tr>
					<tr><td align="center" style="font-size:16px;">has sent you a wonder greeting card</td></tr>
					<tr><td height="25"></td></tr>
					<tr><td align="center" style="font-size:22px; text-decoration:underline;"><a href="'.$cardURL.'" title="Click Here to View Card">Click Here to View Card</a></td></tr>
				</table>
			</td>
			<td width="185" height="147"><img src="http://www.wondercard.net/images/mail_images/email_img_4.jpg" width="185" height="147" alt=""></td>
		</tr>
		<tr>
			<td colspan="5" width="750" height="72"><img src="http://www.wondercard.net/images/mail_images/email_img_5.jpg" width="750" height="72" alt=""></td>
		</tr>
		<tr>
			<td width="156" height="206"><img src="http://www.wondercard.net/images/mail_images/email_08.jpg" width="156" height="206" alt=""></td>
			<td width="160" height="206" colspan="2" align="center" bgcolor="#FFFFFF"><img src="'.$cardImage.'" width="160" height="149" border="0" /></td>
			<td width="406" height="206" colspan="2"><img src="http://www.wondercard.net/images/mail_images/email_img_7.jpg" width="406" height="206" alt=""></td>
		</tr>
		<tr><td width="750" height="48" colspan="5"><img src="http://www.wondercard.net/images/mail_images/email_img_8.jpg" width="750" height="48" alt=""></td></tr>
		<tr>
			<td width="750" colspan="5" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#898989;">
			Having trouble viewing the card? Copy and paste the following link into your web browser:<br />
			<a href="'.$cardURL.'" title="View Card">'.$cardURL.' </a>
			<br /><br />
			Wondercard.net repects your privacy, For more information, please review our <a href="http://www.wondercard.net/privacy.php" title="Privacy Statement">Privacy Statement</a>.<br />
			This is an automatic generated message. Do not reply to this message.<br />
			<a href="http://www.wondercard.net" title="WonderCard">wondercard.net </a>. Send eCardz that flips for FREE! Create cardz unique to you using photos, videos, music and text of your own! <br />
			</td>
		</tr>
		<tr>
			<td width="156" height="1"><img src="http://www.wondercard.net/images/mail_images/spacer.gif" width="156" height="1" alt=""></td>
			<td width="9" height="1"><img src="http://www.wondercard.net/images/mail_images/spacer.gif" width="9" height="1" alt=""></td>
			<td width="179" height="1"><img src="http://www.wondercard.net/images/mail_images/spacer.gif" width="179" height="1" alt=""></td>
			<td width="221" height="1"><img src="http://www.wondercard.net/images/mail_images/spacer.gif" width="221" height="1" alt=""></td>
			<td width="185" height="1"><img src="http://www.wondercard.net/images/mail_images/spacer.gif" width="185" height="1" alt=""></td>
		</tr>
	</table>';
	
	$message = $welcome;
				
	$headers = "From: WonderCard <" . $fromMail . ">"; 
	$headers = "From: WonderCard <" . strip_tags($fromMail) . ">\r\n";
	$headers .= "Reply-To: ". strip_tags($fromMail) . "\r\n";
	//$headers .= "CC: aqeelashraf@gmail.com\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";	

	@mail($mTo, $subject, $message, $headers);
}
?>
