<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title> <?php echo ((SITE_TITLE!='Wap Portal')?SITE_TITLE.' - Wap Portal':SITE_TITLE); ?> </title>
<meta name="keywords" content="<?php echo SITE_META_KEYWORDS; ?>"/>
<meta name="description" content="<?php echo SITE_META_DESCRIPTION; ?>" />
<?php if($_SESSION['lang_id']==1){?>
    <link href="<?php print($siteRoot)?>css/styles.css" rel="stylesheet" type="text/css" />
    <link href="<?php print($siteRoot)?>css/responsive.css" rel="stylesheet" type="text/css" />
<?php } else {?>
    <link href="<?php print($siteRoot)?>css/styles_ur.css" rel="stylesheet" type="text/css" />
    <link href="<?php print($siteRoot)?>css/responsive_ur.css" rel="stylesheet" type="text/css" />
<?php }?>

<?php
	$pr_id = ((isset($_REQUEST['pr'])?$_REQUEST['pr']:0));
	$Query = "SELECT ca.cat_parentid AS cat_id, pl.*, prf.prf_thumb, prf.prf_file, prf.prf_preview FROM products AS pr LEFT OUTER JOIN pr_files AS prf ON pr.pr_id=prf.pr_id LEFT OUTER JOIN products_ln AS pl ON pr.pr_id=pl.pr_id LEFT OUTER JOIN categories AS ca ON pr.cat_id=ca.cat_id WHERE pr.pr_id=".$_REQUEST['pr']." LIMIT 1";
	$rs = mysql_query($Query);
	$row = mysql_fetch_object($rs);
	
	$cnt_url = $_SESSION['site_root']."index.php?pr=".$_REQUEST['pr'];
	//$cnt_url = $_SESSION['site_root'].'includes/share_on_facebook.php?pr='.$pr_id;
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
			echo "<meta http-equiv='refresh' content='0;url=".$url."'/>";
		}
	}
?>
<meta property="og:url" content="<?php echo $cnt_url;?>" />
<meta property="og:title" content="<?php echo $title;?>" />
<meta property="og:description" content="<?php echo $summary;?>"/>
<meta property="og:image" content="<?php echo $image;?>"/>
<!--<meta http-equiv="refresh" content="0;url='<?php echo $url;?>'" />-->

<script src="js/jquery-1.10.2.min.js" language="javascript"></script>
<script type="text/javascript" src="<?php print($siteRoot)?>js/jquery.carouFredSel-6.2.1.js"></script>
<script type="text/javascript" src="<?php print($siteRoot)?>js/custom.js"></script>
<script type="text/javascript">
	$(function() {
		$('.carousel').carouFredSel({
			responsive: true,
			circular: true,
			width: '100%',
			scroll: 1,
			items: {
				height: "variable",
				visible: {
					min: 1,
					max: 4,
				}
			}
		});
	});
</script>
<script type="text/javascript" src="<?php print($siteRoot)?>js/form_validation.js"></script>
<script>
	$(document).ready(function() {
		$('.close').click(function() {
			$("#msg_div").attr('style',' display:none; visibility:hidden; ');
		});
	});
</script>
<script type="text/javascript">
	$(document).ready(function(e) {
		$(".mMenu ul li.mMenu_icon").click(function(e) {
			$(".mMenu_dropdown #menu_dropdown").slideToggle();
			$(".mSearch_field").slideUp();
			$(".mMenu_dropdown #menu_cat").slideUp();
			$(".mMenu_dropdown #menu_account").slideUp();
		});
		$(".mMenu ul li.mSearch_icon").click(function(e) {
			$(".mSearch_field").slideToggle();
			$(".mMenu_dropdown #menu_dropdown").slideUp();
			$(".mMenu_dropdown #menu_cat").slideUp();
			$(".mMenu_dropdown #menu_account").slideUp();
		});
		$(".mMenu ul li.account").click(function(e) {
			$(".mMenu_dropdown #menu_cat").slideToggle();
			$(".mMenu_dropdown #menu_dropdown").slideUp();
			$(".mSearch_field").slideUp();
			$(".mMenu_dropdown #menu_account").slideUp();
		});
		$(".mMenu ul li.mCat").click(function(e) {
			$(".mMenu_dropdown #menu_account").slideToggle();
			$(".mMenu_dropdown #menu_cat").slideUp();
			$(".mMenu_dropdown #menu_dropdown").slideUp();
			$(".mSearch_field").slideUp();
		});
		slider();
	});
	function slider(){
		$(".title_bar ul li").click(function(e) {
			var section = $(this).parent().parent().parent().parent().attr("id");
			$("#"+section).find("li").removeClass("selected");
			$(this).addClass("selected");
			var curr = $(this).attr("data-contents");
			var data = $("#"+section+" "+curr).html();
			$("#"+section+" .slider").html(data);
		});
	}
</script>