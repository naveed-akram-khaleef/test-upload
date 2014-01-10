<h1><?php print($strHead);?></h1>
<?php $cat_id = ((isset($_REQUEST['cid'])&&($_REQUEST['cid']!=''))?' AND mg.cat_id='.$_REQUEST['cid']:' AND mg.cat_id=1 '); ?>
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
                $Query = "SELECT mg.*, prf.prf_thumb, prf.prf_file FROM my_gifted_items AS mg LEFT OUTER JOIN pr_files AS prf ON mg.pr_id=prf.pr_id WHERE mg.mem_id=".$_SESSION["memID"]." ".$cat_id." ORDER BY mg.mg_id DESC";
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
				if($counter==1 || $counter%2==1){
					//echo '<div class="listing">';
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
							<div class='caption'>".To."
								<a href='index.php?id=".$page_id."&pr=".$row->pr_id."'>".' '.limit_text($row->mg_to,20)."</a>
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