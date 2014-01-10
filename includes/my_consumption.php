<h1><?php print($strHead);?></h1>
<div class="full_width news_contents">
    <div class="table">
        <div class="head">
            <div class="col col1">ID</div>
            <div class="col col2" style="width:120px;"><?php echo Categories;?></div>
            <div class="col col2" style="width:300px;"><?php echo Product;?></div>
            <div class="col col3"><?php echo Details;?></div>
            <div class="col col4"><?php echo Consumed_On;?></div>
            <div class="clearfix"></div>
        </div>
        <?php
			$Query = "SELECT myc.*, pl.pr_title, pl.lang_id, m.mem_fname, cl.cat_name FROM my_consumption AS myc LEFT OUTER JOIN products AS pr ON myc.pr_id=pr.pr_id LEFT OUTER JOIN members AS m ON myc.mem_id=m.mem_id LEFT OUTER JOIN categories_ln AS cl ON myc.cat_id=cl.cat_id AND cl.lang_id=".$_SESSION['lang_id']." LEFT OUTER JOIN products_ln AS pl ON myc.pr_id=pl.pr_id WHERE myc.mem_id=".$_SESSION["memID"]." AND pl.lang_id=".$_SESSION['lang_id']." ORDER BY myc.myc_id DESC";
            $counter=0;
            $limit = 12;
            $start = $p->findStart($limit);
            $count = mysql_num_rows(mysql_query($Query)); 
            $pages = $p->findPages($count, $limit); 
            $rs = mysql_query($Query." LIMIT ".$start.", ".$limit);
            if(mysql_num_rows($rs)>0){
                while($row=mysql_fetch_object($rs)){	
                    $counter++;
                    if($counter%2==0){
                        $class = "row color";
                    } else {
                        $class = "row";
                    }
					$pid=1;
					if($row->cat_id==1){
						$pid = 5;
					} elseif($row->cat_id==2){
						$pid = 6;
					} elseif($row->cat_id==3){
						$pid = 7;
					} elseif($row->cat_id==4){
						$pid = 8;
					}
        ?>
            <div class="<?php echo $class;?>">
                <div class="col col1">&nbsp;<?php echo $row->myc_id;?></div>
                <div class="col col2" style="width:120px;">&nbsp;<?php print($row->cat_name);?></div>
                <div class="col col2" style="width:300px;">&nbsp;<?php print($row->pr_title);?></div>
                <div class="col col3">&nbsp;<a href="index.php?id=<?php echo $pid?>&pr=<?php print($row->pr_id);?>">View</a></div>
                <div class="col col4">&nbsp;<?php print($row->myc_added_date);?></div>
                <div class="clearfix"></div>
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
                        $next_prev = $p->nextPrev($_GET['page'], $pages, '&id='.$_REQUEST['id'].((isset($_REQUEST['cid']))?'&cid='.$_REQUEST['cid']:''));
                        print($next_prev);
                    ?>
                </ul>
                <div class="clearfix"></div>
            </div><br />
            <div class="pagination_total">&nbsp; <?php echo Total.' '.$count.' '.Records;?></div>
        <?php } ?>
    </div>
    <div class="list_view">
		<?php
			$Query = "SELECT myc.*, pl.pr_title, pl.lang_id, m.mem_fname, cl.cat_name FROM my_consumption AS myc LEFT OUTER JOIN products AS pr ON myc.pr_id=pr.pr_id LEFT OUTER JOIN members AS m ON myc.mem_id=m.mem_id LEFT OUTER JOIN categories_ln AS cl ON myc.cat_id=cl.cat_id AND cl.lang_id=".$_SESSION['lang_id']." LEFT OUTER JOIN products_ln AS pl ON myc.pr_id=pl.pr_id WHERE myc.mem_id=".$_SESSION["memID"]." AND pl.lang_id=".$_SESSION['lang_id']." ORDER BY myc.myc_id DESC";
            $counter=0;
            $limit = 12;
            $start = $p->findStart($limit);
            $count = mysql_num_rows(mysql_query($Query)); 
            $pages = $p->findPages($count, $limit); 
            $rs = mysql_query($Query." LIMIT ".$start.", ".$limit);
            if(mysql_num_rows($rs)>0){
                while($row=mysql_fetch_object($rs)){	
                    $counter++;
                    if($counter%2==0){
                        $class = "row color";
                    } else {
                        $class = "row";
                    }
					$pid=1;
					if($row->cat_id==1){
						$pid = 5;
					} elseif($row->cat_id==2){
						$pid = 6;
					} elseif($row->cat_id==3){
						$pid = 7;
					} elseif($row->cat_id==4){
						$pid = 8;
					}
        ?>
            <div class="row">
                <ul>
                    <li class="left">ID</li>
                    <li class="right"><?php echo $row->myc_id;?></li>
                    <div class="clearfix"></div>
                </ul>
                <ul>
                    <li class="left"><?php echo Categories;?></li>
                    <li class="right"><?php print($row->cat_name);?></li>
                    <div class="clearfix"></div>
                </ul>
                <ul>
                    <li class="left"><?php echo Product;?></li>
                    <li class="right"><?php print($row->pr_title);?></li>
                    <div class="clearfix"></div>
                </ul>
                <ul>
                    <li class="left"><?php echo Details;?></li>
                    <li class="right"><a href="index.php?id=<?php echo $pid?>&pr=<?php print($row->pr_id);?>">View</a></li>
                    <div class="clearfix"></div>
                </ul>
                <ul>
                    <li class="left"><?php echo Consumed_On;?></li>
                    <li class="right"><?php print($row->myc_added_date);?></li>
                    <div class="clearfix"></div>
                </ul>
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