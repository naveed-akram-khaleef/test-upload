<div class="full_width news_contents">
    <h1><?php print($strHead);?></h1>
	<?php
    $counter=0;
    $Query = "SELECT * FROM news WHERE status_id=1 ORDER BY news_created DESC";
    $limit = 15;
    $start = $p->findStart($limit); 
    $count = mysql_num_rows(mysql_query($Query)); 
    $pages = $p->findPages($count, $limit); 
    $rs = mysql_query($Query." LIMIT ".$start.", ".$limit);
    if($count>0){
        while($row=mysql_fetch_object($rs)){
            $counter++;
			$date = "";
			if($row->news_created!=""){
				$arrdate  = explode("-", $row->news_created);
				$arrdate2 = explode(" ", $arrdate[2]);
				$date = date("j M Y", mktime (0, 0, 0, $arrdate[1], $arrdate2[0], $arrdate[0]));
			}
			if($row->news_created=="0000-00-00"){
				$date = "";
			}
    ?>
            <div class="news_item">
                <p class="title"><?php echo $row->news_title?></p>
                <p class="date"> Posted on  <?=$date?></p>
                <p><?php echo $row->news_details?></p>
            </div>
    <?php
            }
		  } else{
			  echo '<p>'.No_Records.'</p>';
		  }
	?>
	<div class="clearfix"></div><br />
	<?php if($counter > 0) {?>
		<div class="full_width pagination">
			<ul style="border-bottom: solid 0px;">
				<li><span><?php print(Page." <b>".$_GET['page']."</b> ".Of." ".$pages.' ');?></span></li>
				<?php	
					$next_prev = $p->nextPrev($_GET['page'], $pages, '&id='.$_REQUEST['id']);
					print($next_prev);
				?>
			</ul>
			<div class="clearfix"></div>
		</div><br />
		<div class="pagination_total">&nbsp; <?php echo Total.' '.$count.' '.Records;?></div>
	<?php } ?>
</div>