<h1><?php print($strHead);?></h1>
<?php $cat_id = ((isset($_REQUEST['cid'])&&($_REQUEST['cid']!=''))?' AND myc.cat_id='.$_REQUEST['cid']:' AND myc.cat_id=1 '); ?>
<div class="full_width video_page featured">
    <div class="left">
      <div class="full_width" id="audio_section">
        <div class="">
          <div class="clearfix" style="height:0px;"></div>
          <div class="title_bar">
            <ul>
				<?php
					$Query = "SELECT c.cat_id, c.status_id, c.cat_parentid, cl.* From categories AS c LEFT OUTER JOIN categories_ln AS cl ON c.cat_id=cl.cat_id WHERE c.cat_parentid=0 AND cl.lang_id=".$_SESSION['lang_id']." ORDER BY c.cat_id ASC ";
                    $count = mysql_num_rows(mysql_query($Query)); 
                    $rs = mysql_query($Query);
                    if($count>0){
                        while($row=mysql_fetch_object($rs)){
                          echo '<li><a href="index.php?id='.$_REQUEST['id'].'&cid='.$row->cat_id.'">'.$row->cat_name.'</a></li>';
                        }
                    }
                ?>            
            </ul>
          </div>
      </div>
      <div class="full_width slider">
		<?php
			$counter=0;
			$Query = "SELECT myc.*, pr.pr_hits, m.mem_fname, prf.prf_thumb, prf.prf_file, pl.pr_title, pl.lang_id FROM my_collection AS myc LEFT OUTER JOIN products AS pr ON myc.pr_id=pr.pr_id LEFT OUTER JOIN members AS m ON myc.mem_id=m.mem_id LEFT OUTER JOIN pr_files AS prf ON myc.pr_id=prf.pr_id LEFT OUTER JOIN products_ln AS pl ON myc.pr_id=pl.pr_id WHERE myc.mem_id=".$_SESSION["memID"]." ".$cat_id." AND pl.lang_id=".$_SESSION['lang_id']." ORDER BY myc.mc_id DESC";
          $limit = 12;
          $start = $p->findStart($limit); 
          $count = mysql_num_rows(mysql_query($Query));
          $pages = $p->findPages($count, $limit); 
          $rs = mysql_query($Query." LIMIT ".$start.", ".$limit);
          if($count>0){
            while($row=mysql_fetch_object($rs)){
              $counter++;
              if($counter%2==0){
                $class = "item1 last";
              } else {
                $class = "item1";
              }
			$pid=1;
			if($row->cat_id==1){
				$pid = 5;
			} elseif($row->cat_id==2){
				$pid = 6;
			} elseif($row->cat_id==2){
				$pid = 7;
			} elseif($row->cat_id==4){
				$pid = 8;
			}
			$imgPath = chkFileExists4($row->prf_thumb);
			$atr = imagePropotionate($imgPath, 98, 80);
			  echo "
				<div class='col'>
					<div class='thumbs'>
						<div class='image'>
							<a href='index.php?id=".$page_id."&pr=".$row->pr_id."'>
								<img src='".$imgPath."' />
							</a>
						</div>
						<div class='caption'>
							<a href='index.php?id=".$page_id."&pr=".$row->pr_id."'>".limit_text($row->pr_title,20)."</a>
						</div>
					</div>
				</div>";
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
                        $next_prev = $p->nextPrev($_GET['page'], $pages, '&id='.$_REQUEST['id'].((isset($_REQUEST['cid']))?'&cid='.$_REQUEST['cid']:''));
                        print($next_prev);
                    ?>
                </ul>
                <div class="clearfix"></div>
            </div><br />
            <div class="pagination_total">&nbsp; <?php echo Total.' '.$count.' '.Records;?></div>
        <?php } ?>
      </div>
    </div>
    </div>
    <div class="right">
      <div class="full_width add"><img src="images/add.jpg" /></div>
    </div>
  <div class="clearfix"></div>
</div>