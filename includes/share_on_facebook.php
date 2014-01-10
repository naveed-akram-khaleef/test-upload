<?php
session_start();
include("../lib/openCon.php");
include("../lib/functions.php");
include("../lib/site_settings.php");
$pr_id = ((isset($_REQUEST['pr'])?$_REQUEST['pr']:0));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php
        $Query = "SELECT ca.cat_parentid AS cat_id, pl.*, prf.prf_thumb, prf.prf_file, prf.prf_preview FROM products AS pr LEFT OUTER JOIN pr_files AS prf ON pr.pr_id=prf.pr_id LEFT OUTER JOIN products_ln AS pl ON pr.pr_id=pl.pr_id LEFT OUTER JOIN categories AS ca ON pr.cat_id=ca.cat_id WHERE pr.pr_id=".$_REQUEST['pr']." LIMIT 1";
        $rs = mysql_query($Query);
        $row = mysql_fetch_object($rs);
        
        $cnt_url = $_SESSION['site_root'].'includes/share_on_facebook.php?pr='.$pr_id;
        $image   = $_SESSION['site_root'].'files/products/img/'.$row->prf_thumb;
        $title   = $row->pr_title;
        $summary = $row->pr_long_details;
        //$url	 = "http://facebook.com/sharer.php?s=100&p[url]=".$cnt_url."&p[images][0]=".$image."&p[title]=".$title."&p[summary]=".$summary."";
        $url	 = "https://www.facebook.com/sharer/sharer.php?u=".$cnt_url."";

        if(isset($_SERVER['HTTP_REFERER'])){
			$haystack = $_SERVER['HTTP_REFERER'];
			$needle   = 'facebook';
            if(strpos($haystack,$needle)!==false){
                $page_id=1;
                if($row->cat_id==1){
                    $page_id = 5;
                } elseif($row->cat_id==2){
                    $page_id = 6;
                } elseif($row->cat_id==3){
                    $page_id = 7;
                } elseif($row->cat_id==4){
                    $page_id = 8;
                }
                $url = $_SESSION['site_root'].'index.php?id='.$page_id.'&pr='.$pr_id;
            }
        }
    ?>
    <meta property="og:url" content="<?php echo $cnt_url;?>" />
    <meta property="og:title" content="<?php echo $title;?>" />
    <meta property="og:description" content="<?php echo $summary;?>"/>
    <meta property="og:image" content="<?php echo $image;?>"/>
    <meta http-equiv="refresh" content="0;url='<?php echo $url;?>'" />
</head>
<body></body>
</html>