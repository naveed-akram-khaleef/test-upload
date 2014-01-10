<?php
ini_set('display_errors', 1); 
error_reporting(E_ALL);
header('P3P: CP="NOI ADM DEV PSAi NAV OUR STP IND DEM"');
$current_url  = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];

 $redirest_url = 'http://esol-tech.com/test/facebook-php-sdk-master/index.php'; //Local
//$redirest_url = 'http://hurmat.com/facebook/change_cover_image_api/facebook-php-sdk-master/index.php'; //Live

/**
 * Copyright 2011 Facebook, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may
 * not use this file except in compliance with the License. You may obtain
 * a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

require 'src/facebook.php';

// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
	'appId'  => '363366080411013',
	'secret' => '57ac59c176c4eb9560ade636bbd976ae',
	"cookie" => true,
	'fileUpload' => true
));

/*$facebook = new Facebook(array(
	'appId'  => '197649790422363',
	'secret' => '7fca30a43f88fb0fb2e8ba6eed931f58',
	"cookie" => true,
	'fileUpload' => true
));*/


/*
$facebook = new Facebook(array(
  'appId'  => '344617158898614',
  'secret' => '6dc8ac871858b34798bc2488200e503d',
));

*/
// Get User ID
$user = $facebook->getUser();
// We may or may not have this data based on whether the user is logged in.
//
// If we have a $user id here, it means we know the user is logged into
// Facebook, but we don't know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}

// Login or logout url will be needed depending on current user state.
if ($user) {
	if(isset($_REQUEST['logout'])){
		setcookie("363366080411013",'',time()-10);
		$facebook -> destroySession();
		header("Location: ".$current_url."");
	}
	$logoutUrl = $current_url.'?logout=1';
	//$logoutUrl = $facebook->getLogoutUrl();
} else {
	$loginUrl = $facebook->getLoginUrl();
}

// This call will always work since we are fetching public data.
// $naitik = $facebook->api('/naitik');

?>
<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <head></head>
  <body>
    <h1>php-sdk</h1>

    <?php if ($user): ?>
      <a href="<?php echo $logoutUrl; ?>">Logout</a>
    <?php else: ?>
      <div>
        Login using OAuth 2.0 handled by the PHP SDK:
        <?php
			$params = array(
			  'scope' => 'offline_access,read_friendlists,read_insights,read_mailbox,read_requests,read_stream,xmpp_login,user_online_presence,friends_online_presence,ads_management,create_event,manage_friendlists,manage_notifications,publish_actions,publish_stream,rsvp_event,user_photos,photo_upload,user_videos,manage_pages,user_status,friends_likes',
			  'redirect_uri' => $redirest_url
			);
			$loginUrl = $facebook->getLoginUrl($params);
		?>
        <a href="<?php echo $loginUrl; ?>">Login with Facebook</a>
      </div>
    <?php endif ?>

    <h3>PHP Session</h3>
    <pre><?php //print_r($_SESSION); ?></pre>

    <?php if ($user): ?>
      <h3>You</h3>
      <img src="https://graph.facebook.com/<?php echo $user; ?>/picture?type=large">

      <h3>Your User Object (/me)</h3>
      <pre><?php //print_r($user_profile); ?></pre>
    <?php else: ?>
      <strong><em>You are not Connected.</em></strong>
    <?php endif ?>
<?php
/*$facebook->api_client->fql_query("SELECT post_id, message, permalink
FROM stream 
WHERE  source_id = '100002321834754' and actor_id = '100002321834754'
LIMIT 2");*/

	//Get Facebook SDK Object
/*	$config = array(
	  'appId'  => APP_ID,
	  'secret' => API_SECRET,
	  'cookie' => true,
	);

	$facebook = new Facebook($config);*/

	//Create Query
	/*
	$params = array(
	    'method' => 'fql.query',
	    'query' => "SELECT post_id, message, permalink
FROM stream 
WHERE  source_id = '100002321834754' and actor_id = '100002321834754'
LIMIT 2",
	);
*/
	//Run Query
	//$result = $facebook->api($params);

//echo'<pre>';	
	//print_r( $result );
//echo'</pre>';	
	

/*class Client extends \Facebook
{
    private $config;
    private $reqPerms;
    public function fql($query)
    {
        $params = array(
            'method' => 'fql.query',
            'query' =>$query,
        );

        return $this->api($params);
    }

}
$config = array();

//Using client
$fb = new App\Facebook\Client($config);

$query = "SELECT uid, pic, pic_square, name FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = 111111111)";
$result = $fb->fql($query);
*/






?>
<!--
    <h3>Public profile of Naitik</h3>
    <img src="https://graph.facebook.com/naitik/picture">
    <?php //echo $naitik['name']; ?>
-->

  </body>
</html>


<?php

/*
$accounts = $facebook->api("/me/accounts", "GET", array("access_token"=>$facebook->getAccessToken()));
$data = $accounts["data"];
try {
	$facebook->api($pageId."/feed", "POST", array("name"=>"My Name", "caption"=>"My Caption"));
} catch (FacebookApiException $e) {
	error_log($e . " for: " .$pageId);
}*/


/*$accounts = $facebook->api('/me/accounts');
$page_id = '196271630507204';
foreach($accounts['data'] as $account)
{
   if($account['id'] == $page_id)
   {
      $token = $account['access_token'];
   }
}
$attachment = array(
        'access_token' => $token,
        'message' => 'Hy',
        'name' => 'Google',
        'link' => 'http://www.google.com',
        'description' => 'Search Engine',
        'picture'=> '',
);
try{
$res = $facebook->api('/'.$page_id.'/feed','POST',$attachment);

} catch (Exception $e){

    echo $e->getMessage();
}
*/




/*$pageID = '196271630507204';
$message = 'Hy there.';
$facebook = new Facebook(array('appId'  => '363366080411013', 'secret' => '57ac59c176c4eb9560ade636bbd976ae'));
$user = $facebook->getUser();
try 
{
    $pageInfo = $facebook->api("/{$pageID}?fields=access_token");
    if(!empty($pageInfo['access_token'])) 
    {
        $args = array(
            'access_token'  => $pageInfo['access_token'],
            'message'       => $message
        );
        $postID = $facebook->api("/{$pageID}/feed", 'post', $args);
    }
} 
catch (FacebookApiException $e) 
{
    echo '<pre>'; var_dump($e); echo '</pre>';
    $user = null;
}*/


/*$user = $facebook->getUser();
if ($user) {
	try {
		$message = $facebook->api('/196271630507204/feed', 'POST', array(
													 'message'=> '<Message>', 
													 'picture' => '<Picture URL>', 
													 'link'=> '<URL>',
													 'description'=>'Description', 
													 'name'=> '<Name of Post>', 
													 'privacy'=> '<ALL_FRIENDS (Default)>',
													 'caption'=> '<Caption>',                                                           
													 )
								);
		} catch (FacebookApiException $e) {
			error_log($e);
		}
} else {
	echo 'no';	
}
*/





//echo 'Proceeding this APP <br/>';
/*
$facebook = new Facebook(array(
  'appId'  => FACEBOOK_APP_ID,
  'secret' => FACEBOOK_SECRET_KEY,
  'cookie' => false,
));
*/ 
/*$user = $facebook->getUser();
$loginUrl   = $facebook->getLoginUrl(
	array(
		'scope'         => 'user_photos,photo_upload,manage_pages'
	)
);
     
if ($user) 
{
    try 
    {
        // Proceed knowing you have a logged in user 
		// who's authenticated.
        $user_profile = $facebook->api('/me');
        $permissions = $facebook->api('/me/permissions');
    } 
    catch (FacebookApiException $e) {
        $user = null;
    }
}   
 
if (!$user) {
    echo "<script type='text/javascript'>top.location.href = '$loginUrl';</script>";
}
*/

//$full_path_to_the_image = "http://localhost/facebook/change_cover_image_api/facebook-php-sdk-master/facebook_cover_image_test.jpg";
//$full_path_to_the_image = "https://lh5.googleusercontent.com/-f1AIsRyzEjg/AAAAAAAAAAI/AAAAAAAABUE/ys44m9QypVI/s300-c/photo.jpg";
/*
$facebook->setFileUploadSupport(true);
$args = array('message' => stripslashes('photo of user'));
$args['image'] = '@'.realpath($full_path_to_the_image);               
try {
     $photo_details = $facebook->api("/".$user."/photos", 'post', $args);
} catch(Exception $e){echo $e->getMessage();
}

header("Location: https://www.facebook.com/".$user."?preview_cover=".$photo_details['id']."");
exit;
*/


/*require 'facebook.php';
 
$facebook = new Facebook(array(
  'appId'  => FACEBOOK_APP_ID,
  'secret' => FACEBOOK_SECRET_KEY,
  'cookie' => false,
));*/
/* 
$user = $facebook->getUser();
 
$loginUrl = $facebook->getLoginUrl(array(
    'scope' => 'user_photos,manage_pages'
));
 
if ($user) 
{
    try 
    {
        // Proceed knowing you have a logged in user 
		// who's authenticated.
        $user_profile = $facebook->api('/me');
        $permissions = $facebook->api('/me/permissions');
    } 
    catch (FacebookApiException $e) {
        $user = null;
    }
}   
 
 
if (!isset($permissions['data'][0]['user_photos']) 
or !isset($permissions['data'][0]['manage_pages']) ) 
{
  $user = null;
}
 
if (!$user) 
{
  echo "<script type='text/javascript'>top.location.href = '$loginUrl';
  </script>";
  exit;
}


$facebook->setFileUploadSupport(true);
$accounts = $facebook->api('/me/accounts');
for($i=0;$accounts['data'][$i];$i++){
    $page_access_token=$accounts['data'][$i]['access_token'];
    $page_id = $accounts['data'][$i]['id'];
 
    $facebook->setAccessToken($page_access_token);
    $args = array('name' => 'awesome album name', 'message' => 'awesome album message');
    try {
        $album_id =$facebook->api("/$page_id/albums", 'post', $args);
    }catch(Exception $e){
        echo $e->getMessage();
    }
 
    $args = array('image' =>'@'.realpath($full_path_to_the_image));
    try{
        $uploaded_photo_details = $facebook->api("/{$album_id['id']}/photos", 'post', $args);
    }catch(Exception $e){
        echo $e->getMessage();
    }
 
    if(isset($uploaded_photo_details['id'])){
        $args = array('cover' => $uploaded_photo_details['id'], 'offset_y' =>0);
         try {
             $cover_details = $facebook->api("/{$page_id}", 'post', $args);
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }
}*/

//http://www.covershub.net/uploads/covmg/sleep-late-misc.jpg

/*$args = array('name' => 'awesome album name', 'message' => 'awesome album message');
try {
    $album_id =$facebook->api("/".$page_id."/albums", 'post', $args);
} catch(Exception $e){
    echo '<br/>Here1 '.$e->getMessage();
}

 $args = array('image' =>'@'.('"'.$full_path_to_the_image.'"'));
 print_r($args);
try{
    $uploaded_photo_details = $facebook->api("/{".$album_id['id']."}/photos", 'post', $args);
} catch(Exception $e){
    echo '<br/>Here2 '.$e->getMessage();
}

if(isset($uploaded_photo_details['id'])){
	$args = array('cover' => $uploaded_photo_details['id'], 'offset_y' =>0);
	try {
		$cover_details = $facebook->api("/{".$page_id."}", 'post', $args);
	} catch(Exception $e){
		echo '<br/>Here3 '.$e->getMessage();
	}
}

*/


//http://www.firstcovers.com/covers/5332/its+easy+if+you+try.html
//http://www.f-covers.com/facebook-cover/destructive-cars
//http://99covers.com/Winter-snow-Collage-facebook-covers/32624/1
//http://www.covershub.net/covers/cover/6693/it-039-s-a-new-day-quotes

//http://www.firstcovers.com/covers/5332/its+easy+if+you+try.html
//http://www.firstcovers.com/covers/5332/its+easy+if+you+try.html
/*
https://www.facebook.com/
dialog/
oauth?
client_id=344101682307459&
scope=publish_stream%2C
user_photos%2C
read_stream%2C
email&
redirect_uri=http%3A%2F%2Fwww.firstcovers.com%2F
pass_code.php%3Fid%3D5332
*/


//http://www.f-covers.com/facebook-cover/destructive-cars
/*
https://www.facebook.com/
dialog/
oauth?
client_id=514111085298025&
redirect_uri=http%3A%2F%2Fwww.f-covers.com%2Ffacebook-cover%2Fupload.php%3Fbanner%3Ddestructive-cars.jpg&
state=bbb66fb325bdd6a5facd8f757c7506d5&
scope=photo_upload%2C
publish_stream
*/


//http://99covers.com/Winter-snow-Collage-facebook-covers/32624/1
/*https://www.facebook.com/dialog/oauth?client_id=235083829881503&redirect_uri=http://99covers.com/index.php?action=callback&scope=email,publish_stream,user_photos,user_likes,user_about_me,user_photo_video_tags
*/

//http://www.covershub.net/covers/cover/6693/it-039-s-a-new-day-quotes
/*https://www.facebook.com/dialog/oauth?client_id=120571018150830&redirect_uri=http%3A%2F%2Fwww.covershub.net%2Fcovers%2Factivate%2F6693&state=f47dc682c2ca82723ff7e0b9a22f7c3c&scope=read_stream%2Cpublish_stream%2Cpublish_actions
*/

//$full_path_to_the_image = "http://m.c.lnkd.licdn.com/mpr/mpr/shrink_80_80/p/2/000/127/0a1/299d4fc.jpg";
?>

<form method="post" actioin="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
	Select Cover File: 
    <input type="file" name="cover_file"><br>
    <input type="submit" name="cover_file_submit" value="Submit">
</form>
<?php
$facebook->setFileUploadSupport(true);
if(isset($_REQUEST['cover_file_submit'])){
	
	print_r( $_POST );
	print_r( $_FILES );
	
	$mfileName = '';
	if(!empty($_FILES["cover_file"]["name"])){
		$dirName = "uploadings/";
		$randNum0 = rand(00000,99999);
		$randNum1 = rand(00000,99999);
		$ext = @pathinfo($_FILES['cover_file']['name'],PATHINFO_EXTENSION);
		$mfileName = $randNum0.'_'.$randNum1.".".$ext;
		if(move_uploaded_file($_FILES['cover_file']['tmp_name'], $dirName.$mfileName)){
		}
	}

	//echo $mfileName;
	//die();

	
	$facebook->setFileUploadSupport(true);
	$user_id = $facebook->getUser();
	
	// Get Profile Album 
	$albums = $facebook->api("/me/albums"); 
	$album_id = ""; 
	foreach($albums["data"] as $item)
	{ 
		if($item["type"] == "profile")
		{ 
			echo $album_id = $item["id"]; 
			break; 
		} 
	}
	
	// Set Photo Atributes 
	$full_image_path = realpath("uploadings/".$mfileName);
	$args = array('message' => 'Successfully Uploaded...'); 
	$args['image'] = '@' . $full_image_path;   
	
	// Upload Photo To Facebook 
	$data = $facebook->api("/{$album_id}/photos", 'post', $args); 
	$pictue = $facebook->api('/'.$data['id']);   
	$fb_image_link = $pictue['link']."&makeprofile=1";
	
	// Redirect To Uploaded Photo URL And Change Profile Picture 
	echo "<script type='text/javascript'>top.location.href = '$fb_image_link';</script>";
}

?>