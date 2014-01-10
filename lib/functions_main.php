<?php

function forgotPass($mName, $mTo, $mPass){
	//sending email to say thanks for registration...
	$fromMail = "noreply@dtt.ae";
	$subject = "Your Password!";
	
	$welcome = "Hi ".$mName."
	\n\nPlease seeyour password below:\n\n
	Password: ".$mPass."\n\n
	If you still find any prblem in login, please let us know. Thanks
	\n\nThis is an automatic generated message. Do not reply to this message. In case you’ll like to contact us, please use the contact form on our website.";
	
	$message = $welcome;
				
	$headers = "From: Dynamic Technical Training <" . $fromMail . ">"; 	

	@mail($mTo, $subject, $message, $headers);
}

function CVAdmin($mName, $mTo){
	//sending email to say thanks for registration...
	$fromMail = "noreply@dtt.ae";
	$subject = "New CV Received - Dynamic Technical Training";
	
	$welcome = "Hi ".$mName."
	\n\nNew CV has been received!\n\n
	Please login to admin panel and view the CVs. Thanks
	\n\nThis is an automatic generated message. Do not reply to this message. In case you’ll like to contact us, please use the contact form on our website.";
	
	$message = $welcome;
				
	$headers = "From: Dynamic Technical Training <" . $fromMail . ">"; 	

	@mail($mTo, $subject, $message, $headers);
}

function CVConfirmation($mName, $mTo){
	//sending email for Registration confirmation...
	$fromMail = "noreply@dtt.ae";
	$subject = "Your CV has been received - Dynamic Technical Training";
	
	$welcome = "Hi ".$mName."
	\n\nWelcome and thanks for submitting your CV!\n\n
	Your CV has been received, our HR Admin will contact you soon.
	\n\nThis is an automatic generated message. Do not reply to this message. In case you’ll like to contact us, please use the contact form on our website.";
	
	$message = $welcome;
				
	$headers = "From: Dynamic Technical Training <" . $fromMail . ">"; 	

	@mail($mTo, $subject, $message, $headers);
}

function changePassword($mName, $mTo, $mPassword){
	$fromMail = "noreply@autoauctionpass.com";
	$subject = "Password Changed :: Auto Auction Pass";
	
	$welcome = "Hi ".$mName."
	\n\nYour password has been changed.Your new password is as follow.
	\n\nPassword: ".$mPassword."
	\n\nThis is an automatically generated message. Pleae do not reply to this message.If you would like to contact us, please use the contact form on our website.";
	
	$message = $welcome;
				
	$headers = "From: Auto Auction Pass <" . $fromMail . ">"; 	

	@mail($mTo, $subject, $message, $headers);
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

function sendPassword($mName, $mTo, $mPassword){
	$fromMail = "noreply@autoauctionpass.com";
	$subject = "Your Password :: Auto Auction Pass";
	
	$welcome = "Hi ".$mName."
	\n\nLost your password? Not to worry we retrieved it for you :)
	\n\nPassword: ".$mPassword."
	\n\nThis is an automatically generated message. Pleae do not reply to this message.If you would like to contact us, please use the contact form on our website.";
	
	$message = $welcome;
				
	$headers = "From: Auto Auction Pass <" . $fromMail . ">"; 	

	@mail($mTo, $subject, $message, $headers);
}

function sendUName($mName, $mTo, $mUName){
	$fromMail = "noreply@autoauctionpass.com";
	$subject = "Your Username :: Auto Auction Pass";
	
	$welcome = "Hi ".$mName."
	\n\nLost your username? Not to worry we retrieved it for you :)
	\n\nUsername: ".$mUName."
	\n\nThis is an automatically generated message. Please do not reply to this message.If you would like to contact us, please use the contact form on our website.";
	
	$message = $welcome;
				
	$headers = "From: Auto Auction Pass <" . $fromMail . ">"; 	

	@mail($mTo, $subject, $message, $headers);
}

function thanksMail($mName, $mTo, $mID){
	//sending email to say thanks for registration...
	$fromMail = "noreply@360Style.com";
	$subject = "360Style";
	
	$welcome = "Hi ".$mName."
	\n\nWelcome and thanks for joining 360Style.com!\n\n
	Your account has been created, you may login now
	\n\nThis is an automatic generated message. Do not reply to this message. In case you’ll like to contact us, please use the contact form on our website.";
	
	$message = $welcome;
				
	$headers = "From: 360Style <" . $fromMail . ">"; 	

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
function SendCard($mName, $mTo, $cardID, $senderID, $fromName){
	//sending email for Registration confirmation...
	$fromMail = "noreply@strictlypro.com";
	$subject = "Greetings - Strictly Pro";
	
	$welcome = "Hi ".$mName."
	\n\n".$fromName." send you an eCard. Please follow the link below to see your card.

	\n\nTo view your card strictlypro just click the link below:
	\nhttp://www.strictlypro.com/view_card.php?mcard_id=".$cardID."&sendid=".$senderID."
	\n\nIf clicking the link does not work, type or copy and paste the link into your web browser. 
	\nMake sure to copy the address exactly and do not add extra spaces.
	
	\nhttp://www.strictlypro.com
	
	\n\nThis is an automatic generated message. Do not reply to this message. In case you’ll like to contact us, please use the contact form on our website.";
	
	$message = $welcome;
				
	$headers = "From: strictlypro <" . $fromMail . ">"; 	

	@mail($mTo, $subject, $message, $headers);
}
function SendCommentUpdate($mName, $mTo){
	//sending email for Registration confirmation...
	$fromMail = "noreply@wondercard.net";
	$subject = "Comment has been added in your blog";
	
	$welcome = "Hi ".ucwords($mName).",
	\nA comment has been added against your Blog Post. Please have a look and approve.
	\n\n\nThis is an automatic generated message. Do not reply to this message. In case you’ would like to contact us, please use the contact form on our website: www.wondercard.net/support.php.
	\nEnjoy your wonder eCard!
	\n
	\nWonderCard.net
	\nSend eCardz that flip, for free!
	\nCreate cardz unique to you using photos, video, music and text of your own!";
	
	$message = $welcome;
				
	$headers = "From: WonderCard <" . $fromMail . ">";
	
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
	
	/*$welcome = '<style>
	a{text-decoration:none; color:#790000;}
	</style>
	<table align="center" width="750" border="0" cellpadding="0" cellspacing="0" style="background-image:url(http://www.wondercard.net/images/mail_images/email_bg.jpg); background-position:top; background-repeat:no-repeat;">
		<tr>
			<td align="center" height="20" style="font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#898989;">Add greeting@wondercard.net to your address book to ensure that youreceive Wonder Cardz email in your inbox.</td>
		</tr>
		<tr>
			<td height="570" valign="top">
				<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; color:#898989;">
					<tr><td colspan="3" height="110"></td></tr>
					<tr><td colspan="3" align="center" style="font-size:36px;">'.$mName.'</td></tr>
					<tr><td colspan="3" align="center" style="font-size:18px;">has sent you a wonder greeting card</td></tr>
					<tr><td colspan="3" height="40"></td></tr>
					<tr><td colspan="3" align="center" style="font-size:26px; text-decoration:underline;"><a href="'.$cardURL.'" title="Click Here to View Card">Click Here to View Card</a></td></tr>
					<tr><td colspan="3" height="54"></td></tr>
					<tr>
						<td width="166"></td>
						<td width="169" height="149" align="center"><img src="'.$cardImage.'" width="160" height="149" border="0" /></td>
						<td></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#898989;">
			Having trouble viewing the card? Copy and paste the following link into your web browser:<br />
			<a href="'.$cardURL.'" title="View Card">'.$cardURL.' </a>
			<br /><br />
			Wondercard.net repects your privacy, For more information, please review our <a href="http://www.wondercard.net/privacy.php" title="Privacy Statement">Privacy Statement</a>.<br />
			This is an automatic generated message. Do not reply to this message.<br />
			<a href="http://www.wondercard.net" title="WonderCard">wondercard.net </a>. Send eCardz that flips for FREE! Create cardz unique to you using photos, videos, music and text of your own! <br />
			</td>
		</tr>
	</table>';*/
	
	$message = $welcome;
				
	$headers = "From: WonderCard <" . $fromMail . ">"; 
	$headers = "From: WonderCard <" . strip_tags($fromMail) . ">\r\n";
	$headers .= "Reply-To: ". strip_tags($fromMail) . "\r\n";
	//$headers .= "CC: aqeelashraf@gmail.com\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";	

	@mail($mTo, $subject, $message, $headers);
}
function SendCardReply($mName, $mTo, $mReceiver, $msgReply){
	//sending email for Registration confirmation...
	$fromMail = "noreply@wondercard.net";
	$subject = "WonderCard - Reply from Card Receiver";
	
	$welcome = "Hi ".ucwords($mName).",
	\n\n".ucwords($msgReply)."
	\n\nWe will keep you posted on new wonder cardz. If you have any suggestions or ideas, please click here to send us your feedbacks: www.wondercard.net/support.php.
	\nThis is an automatic generated message. Do not reply to this message. In case you’ would like to contact us, please use the contact form on our website: www.wondercard.net/support.php.
	
	\n
	\nCustomer Service
	\nWonderCard.net
	\nSend eCardz that flip, for free!
	\nCreate cardz unique to you using photos, video, music and text of your own!";
	
	$message = $welcome;
				
	$headers = "From: WonderCard <" . $fromMail . ">"; 	

	@mail($mTo, $subject, $message, $headers);
}
function SendCardView($mName, $mTo, $mReceiver){
	//sending email for Registration confirmation...
	$fromMail = "noreply@strictlypro.com";
	$subject = "Strictly Pro Confirmation";
	
	$welcome = "Hi ".$mName."
	\n\nThanks for using strictlypro!
	\n\nYour card has been viewed by ".$mReceiver."
	
	\nhttp://www.strictlypro.com
	
	\n\nThis is an automatic generated message. Do not reply to this message. In case you’ll like to contact us, please use the contact form on our website.";
	
	$message = $welcome;
				
	$headers = "From: strictlypro <" . $fromMail . ">"; 	

	@mail($mTo, $subject, $message, $headers);
}

function mailSendNow($mName, $uName){
	//sending notification for send now pmail...
	$mTo = "urgent@HollandOffice.com";
	$fromMail = "noreply@hollandoffice.com";
	$subject = "Urgent Mail Send Request";

	$welcome = "Hi,
	\n\n!Mr. ".$mName." wants to send mail now
	\n\nThe username is ".$uName."
	\n\nPlease see further details in Admin Panel\n\n Thanks
	
	\n\nThis is an automatic generated message. Do not reply to this message. In case you’ll like to contact us, please use the contact form on our website.";
	
	$message = $welcome;
				
	$headers = "From: HollandOffice <" . $fromMail . ">"; 	

	@mail($mTo, $subject, $message, $headers);
}

function SendNLConfirmation($mTo, $mID){
	//sending email for Registration confirmation...
	$fromMail = "noreply@hollandoffice.com";
	$subject = "Newsletter Confirmation";
	
	$welcome = "Dear Holland Office visitor, \"Thank you for your interest in our company\". We received your request for our monthly newsletter and messages concerning your privacy.
	\n\nIn order to verify the validity of this request and to prevent the sending of unwanted e-mail, we ask our subscibers to confirm this request by clicking on the link below. http://www.hollandoffice.com/nl_activate.php?memid=".$mID." This is a so called ‘opt-in procedure’ which you can reverse (opting-out) by sending us a request by e-mail. If the above address does not appear as a clickable link, cut/copy and paste it into your browser's address bar

	\n\nNeedless to say... We don’t sell your e-mail address. As a matter of fact; your privacy is our very existance! WELCOME TO HOLLAND OFFICE!
	
	\n\nThis is an automatic generated message. Do not reply to this message. In case you’ll like to contact us, please use the contact form on our website.";
	
	$message = $welcome;
				
	$headers = "From: HollandOffice <" . $fromMail . ">"; 	

	@mail($mTo, $subject, $message, $headers);
}

function sendAddPMail($mTo, $mFName, $mUName){
	//sending email for Registration confirmation...
	$fromMail = "noreply@hollandoffice.com";
	$subject = "New P-Mail Notification";
	
	$welcome = "Dear ".$mFName.", you received new p-mail at your service address. Please login in at Holland Office with your username ".$mUName." and check for details. We send this message to you as a reminder to check your mail regularly.

	\n\nThis is an automatic generated message. Do not reply to this message. In case you’ll like to contact us, please use the contact form on our website.";
	
	$message = $welcome;
				
	$headers = "From: HollandOffice <" . $fromMail . ">"; 	

	@mail($mTo, $subject, $message, $headers);
}

function sendSubsPayment($mTo, $mUName, $subs, $duration, $psource){
	//sending email for Registration confirmation...
	$fromMail = "noreply@hollandoffice.com";
	$subject = "Payment Received";
	
	$welcome = "We successfully received your payment for your subscription to Holland Office.  \n\nYour details: [".$subs.", ".$duration.", through: ".$psource."].\n\nPlease login to your account with your username ".$mUName." and start using our services.

	\n\nThis is an automatic generated message. Do not reply to this message. In case you’ll like to contact us, please use the contact form on our website.";
	
	$message = $welcome;
				
	$headers = "From: HollandOffice <" . $fromMail . ">"; 	

	@mail($mTo, $subject, $message, $headers);
}

/*
function SendContact($mName, $mTo, $mID){
	//sending email for Registration confirmation...
	$fromMail = "admin@HollandOffice.com";
	$mTo = "info@hollandoffice.com";
	$subject = "Holland Office Account Confirmation";
	
	$welcome = "Hi ".$mName."
	\n\nWelcome and thanks for joining Holland Office!

	\n\nTo activate your account and begin using Holland Office just click the link below to confirm that your email is working:
	\nhttp://www.safysolutions.net/yourlocaloffice/activate.php?memid=".$mID."
	\n\nIf clicking the link does not work, type or copy and paste the link into your web browser. 
	\nMake sure to copy the address exactly and do not add extra spaces.
	
	\nhttp://www.HollandOffice.com";
	
	$message = $welcome;
				
	$headers = "From: HollandOffice <" . $fromMail . ">"; 	

	@mail($mTo, $subject, $message, $headers);
}
*/
?>
