<?php
include("includes/php_includes_top.php"); 
$strHead = "";
$strContents = "";
$strSMG = "";
$show = 0;
$inc = 0;
$incPage = "";
$isHome = 0;
$clsInnerPage = "inner_page";
if(isset($_REQUEST['id'])){
	if($_REQUEST['id'] == 1){
		$isHome = 1;
		$clsInnerPage = "";
	}
	$rsCnt = mysql_query("SELECT m.*, c.cnt_heading, c.cnt_details, c.cnt_keywords FROM menu AS m LEFT OUTER JOIN contents_ln AS c ON c.cnt_id=m.cnt_id WHERE m.status_id=1 AND m.menu_id=".$_REQUEST['id']." AND c.lang_id=".$_SESSION['lang_id']." ");
	if(mysql_num_rows($rsCnt)){
		$cRow=mysql_fetch_object($rsCnt);
		$strHead = $cRow->cnt_heading;
		$strContents = $cRow->cnt_details;
		if(!empty($cRow->menu_url)){
			if($cRow->menu_url != 'page.php'){
				$inc = 1;
				$incPage = "includes/".$cRow->menu_url;
			}
		}
	}
	else{
		$strHead = "Not Found";
		$strContents = "The page is not avaiable or removed!";
	}
}
else{
	if(isset($_REQUEST['cid'])){
		$rsCnt = mysql_query("SELECT cnt_heading, cnt_details, cnt_keywords FROM contents WHERE cnt_id=".$_REQUEST['cid']." AND lang_id=".$_SESSION['lang_id']." ");
		if(mysql_num_rows($rsCnt)){
			$cRow=mysql_fetch_object($rsCnt);
			$strHead = $cRow->cnt_heading;
			$strContents = $cRow->cnt_details;
		}
		else{
			$strHead = "Not Found";
			$strContents = "The page is not avaiable or removed!";
		}
	}
	else{
		$isHome = 1;
		$clsInnerPage = "";
		$rsCnt = mysql_query("SELECT m.*, cl.cnt_heading, cl.cnt_details, cl.cnt_keywords FROM menu AS m LEFT OUTER JOIN contents_ln AS cl ON cl.cnt_id=m.cnt_id WHERE m.menu_id=1 AND m.status_id=1 AND cl.lang_id=".$_SESSION['lang_id']." ");
		if(mysql_num_rows($rsCnt)){
			$cRow=mysql_fetch_object($rsCnt);
			$strHead = $cRow->cnt_heading;
			$strContents = $cRow->cnt_details;
			if(!empty($cRow->menu_url)){
				if($cRow->menu_url != 'page.php'){
					$inc = 1;
					$incPage = "includes/".$cRow->menu_url;
				}
			}
		}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php include("includes/html_header.php"); ?>
</head>
<body>
    <div id="container" align="center">
        <div class="page_width">
			<?php include("includes/header.php");?>
            <div class="full_width content">
				<?php if($isHome==1){?>
					<?php 
                        if($inc==1){
                            include($incPage);
                        }
                    ?>
				<?php } else{ ?>
					<?php
                        if(isset($_REQUEST['id'])){
                            $page_id=$_REQUEST['id'];
                        } else {
                            $page_id=0;
                        }
                        if($inc==0){
                    ?>
                    <h1><?php print($strHead);?></h1>
					<?php
                        }
                    ?>
                    <?php if($page_id!=5&&$page_id!=6&&$page_id!=7&&$page_id!=8&&$page_id!=12&&$page_id!=20){?>
                        <?php echo (($strContents!='')?'<p>'.$strContents.'</p>':'');?>
                        <div class="clearfix" style="height:0px;"></div>
                    <?php } ?>
					<?php 
                        if($inc==1){
                            include($incPage);
                        }
                    ?>
				<?php } ?>
            </div>
            <?php include("includes/footer.php"); ?>
        </div>
    </div>
</body>
</html>
<?php include("includes/php_includes_bottom.php");?>