<?php
session_start();
$dbServer 	= "localhost";
$dbUserName = "root";
$dbPassword = "";
$dbDatabase = "2013_wap_portal2";
$conn = mysql_connect("$dbServer","$dbUserName","$dbPassword") or die("Unable 2 Connect 2 Database Server"); 
$db = mysql_select_db("$dbDatabase")  or die("Unable 2 Connect 2 Database");

$aResponse['error'] = false;
$aResponse['message'] = '';

// ONLY FOR THE DEMO, YOU CAN REMOVE THIS VAR
	$aResponse['server'] = ''; 
// END ONLY FOR DEMO
	
if(isset($_POST['action']))
{
	if(htmlentities($_POST['action'], ENT_QUOTES, 'UTF-8') == 'rating')
	{
		/*
		* vars
		*/
		$id = intval($_POST['idBox']);
		$rate = floatval($_POST['rate']);
		//$section = floatval($_POST['section']);
		
		// YOUR MYSQL REQUEST HERE or other thing :)
		/*
		*
		*/
		
		// if request successful
		$success = true;
		// else $success = false;
		
		
		// json datas send to the js file
		if($success)
		{

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
			$MaxID = getMaximum("votes","vot_id");
			mysql_query("INSERT INTO votes (vot_id, user_id, pro_id, rate, section_id) VALUES (".$MaxID.", ".$_SESSION["memID"].", ".$id.", '".$rate."', ".$_SESSION['vot_cat'].")");
			
			$total_ratings = 0;
			$rate = 0.0;
			$Query = "SELECT SUM(rate) AS total_ratings, rate FROM votes WHERE pro_id = ".$id." ";
			$rs = mysql_query($Query);
			while($row=mysql_fetch_row($rs)){  $total_ratings = $row[0]; /*$rate = $row[1];*/ }

			$total_vots = 0;
			$Query = "SELECT pro_id FROM votes WHERE pro_id = ".$id." ";
			$rs = mysql_query($Query);
			$total_vots = mysql_num_rows($rs);
			
			$avg = 0;
			$avg = ( $total_ratings / $total_vots );
			$avg = round($avg, 1);
			
			$Query1 = "SELECT rate FROM votes WHERE pro_id = ".$id." AND user_id=".$_SESSION["memID"]." ORDER BY vot_id DESC LIMIT 1 ";
			$rs1 = mysql_query($Query1);
			$row1=mysql_fetch_object($rs1);
			$rate = $row1->rate;

			$aResponse['server'] .= '<p> '.$_SESSION['Average'].' '.$avg.' '.$_SESSION['Of'].' '.$total_vots.' '.$_SESSION['Rating'].' </p>'.'<span> '.$_SESSION['You_Rated'].': <b>'.$rate.'</b></span><br/><br/>';
			echo json_encode($aResponse);
		}
		else
		{
			$aResponse['error'] = true;
			$aResponse['message'] = 'An error occured during the request. Please retry';
			
			$aResponse['server'] = '<strong>ERROR :</strong> Your error if the request crash !';
			
			echo json_encode($aResponse);
		}
	}
	else
	{
		$aResponse['error'] = true;
		$aResponse['message'] = '"action" post data not equal to \'rating\'';
		
		// ONLY FOR THE DEMO, YOU CAN REMOVE THE CODE UNDER
			$aResponse['server'] = '<strong>ERROR :</strong> "action" post data not equal to \'rating\'';
		// END ONLY FOR DEMO
			
		
		echo json_encode($aResponse);
	}
}
else
{
	$aResponse['error'] = true;
	$aResponse['message'] = '$_POST[\'action\'] not found';
	
	// ONLY FOR THE DEMO, YOU CAN REMOVE THE CODE UNDER
		$aResponse['server'] = '<strong>ERROR :</strong> $_POST[\'action\'] not found';
	// END ONLY FOR DEMO
	
	echo json_encode($aResponse);
}
?>