<div class="banner">
	<ul class="bjqs">
		<?php
            $nResult=mysql_query("SELECT h.* FROM header_slider AS h ORDER BY hs_id DESC");
            $hCount=mysql_num_rows($nResult);
            if($hCount>0){
                while($row=mysql_fetch_object($nResult)){
        ?>
                <li>
                    <div class="left">
                        <h1><?php print($row->hs_heading);?></h1>
                        <ul>
                            <?php print($row->hs_contents);?>
                        </ul>
                        <div class="full_width"><a href="index.php?id=7" title="<?php print($row->hs_button_text);?>" class="red_btn2_new"><?php print($row->hs_button_text);?></a></div>
                    </div>
                    <div class="right">
                        <img src="<?php print($siteRoot)?>images/banners/<?php print($row->hs_file);?>" />
                    </div>
                    <div class="clearfix"></div>
                </li>
        <?php
                }
            }
        ?>
	</ul>
</div>
<div class="full_width"><img src="<?php print($siteRoot)?>images/banners/shadow.png" /></div>