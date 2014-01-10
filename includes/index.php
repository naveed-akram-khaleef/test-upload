<link href="css/flexslider.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.flexslider.js"></script>
<script type="text/javascript">
    $(window).load(function(){
      $('.flexslider').flexslider({animation: "fade", controlNav:false,});
    });
</script>
<?php
	$Query =mysql_query("SELECT * FROM  banners WHERE status_id=1 ORDER BY ban_id");
	$count = mysql_num_rows($Query);
	if($count>0){
?>
    <div class="full_width banner flexslider">
        <ul class="slides">
<?php		
		while($row=mysql_fetch_object($Query)){
?>
            <li><img src="files/banners/<?php echo $row->ban_file;?>" alt="<?php echo $row->ban_name;?>" /></li>
<?php
		}
?>
        </ul>
    </div>
<?php		
	}
?>

<div class="full_width slider_area" id="audio_section">
    <div class="title_bar">
        <div class="left"><a href="index.php?id=5"><?php echo Audio_Tracks;?></a></div>
        <div class="right">
            <ul>
                <li class="selected" data-contents=".new_arrivals"><?php echo New_Items;?></li>
                <li data-contents=".top_rated"><?php echo Top_Rated;?></li>
                <li data-contents=".top_viewed"><?php echo Most_Viewed;?></li>
                <li data-contents=".featured"><?php echo Featured;?></li>
                <?php if(isset($_SESSION["memID"])){?><li><a href="index.php?id=15"><?php echo My_Wishlist;?></a></li><?php }?>
            </ul>
        </div>
    </div>
    <div class="full_width slider">
		<?php echo home_products(1, 4, '', 5, $_SESSION['lang_id']);?>
        <div class="clearfix"></div>
    </div>
    <div class="full_width data" style="display:none;">
        <div class="full_width new_arrivals">
			<?php echo home_products(1, 4, 'na', 5, $_SESSION['lang_id']);?>
            <div class="clearfix"></div>
        </div>
        <div class="full_width top_rated">
            <?php echo home_products(1, 4, 'tr', 5, $_SESSION['lang_id']);?>
            <div class="clearfix"></div>
        </div>
        <div class="full_width top_viewed">
            <?php echo home_products(1, 4, 'mv', 5, $_SESSION['lang_id']);?>
            <div class="clearfix"></div>
        </div>
        <div class="full_width featured">
            <?php echo home_products(1, 4, 'fr', 5, $_SESSION['lang_id']);?>
            <div class="clearfix"></div>
        </div>
  </div>
</div>

<div class="full_width slider_area" id="video_section">
  <div class="title_bar">
      <div class="left"><a href="index.php?id=6"><?php echo Movies;?></a></div>
        <div class="right">
          <ul>
                <li class="selected" data-contents=".new_arrivals"><?php echo New_Items;?></li>
                <li data-contents=".top_rated"><?php echo Top_Rated;?></li>
                <li data-contents=".top_viewed"><?php echo Most_Viewed;?></li>
                <li data-contents=".featured"><?php echo Featured;?></li>
                <?php if(isset($_SESSION["memID"])){?><li><a href="index.php?id=15&cid=2"><?php echo My_Wishlist;?></a></li><?php }?>
            </ul>
        </div>
    </div>
    <div class="full_width slider">
		<?php echo home_products(2, 4, '', 6, $_SESSION['lang_id']);?>
        <div class="clearfix"></div>
    </div>
    <div class="full_width data" style="display:none;">
        <div class="full_width new_arrivals">
			<?php echo home_products(2, 4, 'na', 6, $_SESSION['lang_id']);?>
            <div class="clearfix"></div>
        </div>
        <div class="full_width top_rated">
            <?php echo home_products(2, 4, 'tr', 6, $_SESSION['lang_id']);?>
            <div class="clearfix"></div>
        </div>
        <div class="full_width top_viewed">
            <?php echo home_products(2, 4, 'mv', 6, $_SESSION['lang_id']);?>
            <div class="clearfix"></div>
        </div>
        <div class="full_width featured">
            <?php echo home_products(2, 4, 'fr', 6, $_SESSION['lang_id']);?>
            <div class="clearfix"></div>
        </div>
  </div>
</div>

<div class="full_width slider_area" id="wallpaper">
  <div class="title_bar">
      <div class="left"><a href="index.php?id=8"><?php echo Wallpapers;?></a></div>
        <div class="right">
          <ul>
                <li class="selected" data-contents=".new_arrivals"><?php echo New_Items;?></li>
                <li data-contents=".top_rated"><?php echo Top_Rated;?></li>
                <li data-contents=".top_viewed"><?php echo Most_Viewed;?></li>
                <li data-contents=".featured"><?php echo Featured;?></li>
                <?php if(isset($_SESSION["memID"])){?><li><a href="index.php?id=15&cid=4"><?php echo My_Wishlist;?></a></li><?php }?>
            </ul>
        </div>
    </div>
    <div class="full_width slider">
		<?php echo home_products(4, 4, '', 8, $_SESSION['lang_id']);?>
        <div class="clearfix"></div>
    </div>
    <div class="full_width data" style="display:none;">
        <div class="full_width new_arrivals">
			<?php echo home_products(4, 4, 'na', 8, $_SESSION['lang_id']);?>
            <div class="clearfix"></div>
        </div>
        <div class="full_width top_rated">
            <?php echo home_products(4, 4, 'tr', 8, $_SESSION['lang_id']);?>
            <div class="clearfix"></div>
        </div>
        <div class="full_width top_viewed">
            <?php echo home_products(4, 4, 'mv', 8, $_SESSION['lang_id']);?>
            <div class="clearfix"></div>
        </div>
        <div class="full_width featured">
            <?php echo home_products(4, 4, 'fr', 8, $_SESSION['lang_id']);?>
            <div class="clearfix"></div>
        </div>
  </div>
</div>