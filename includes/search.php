<div class="full_width video_page featured">
    <div class="left">
      <div class="full_width" id="audio_section">
        <div class="">
          <h1>
            <?php 
                if(isset($_REQUEST['searchTerm'])){
                    @$_SESSION['searchTerm'] = @$_REQUEST['searchTerm'];
                }
                echo Search_Results_For.' '.$_SESSION['searchTerm'];
            ?>
          </h1>
          <div class="clearfix" style="height:0px;"></div>
      </div>
      <div class="full_width slider">
        <?php
            $counter=0;
            $url = "";

        if(isset($_SESSION['searchTerm']) && trim($_SESSION['searchTerm'])!=''){
          if(isset($_REQUEST['cid'])){
            $condition = " AND ( p.cat_id=".$_REQUEST['cid']." ) ";
          } else {
            $condition = "";
          }
          $Query = " SELECT p.pr_id, pl.pr_title, p.pr_file, p.pr_thumb, p.pr_hits, p.cat_id, m.mem_fname FROM products AS p LEFT OUTER JOIN members AS m ON p.mem_id=m.mem_id LEFT OUTER JOIN products_ln AS pl ON p.pr_id=pl.pr_id WHERE ( pl.pr_title LIKE '%".$_SESSION['searchTerm']."%' OR pl.pr_short_details LIKE '%".$_SESSION['searchTerm']."%' OR pl.pr_long_details LIKE '%".$_SESSION['searchTerm']."%' OR pl.pr_meta_keyword LIKE '%".$_SESSION['searchTerm']."%' OR pl.pr_meta_description LIKE '%".$_SESSION['searchTerm']."%' ) AND ( p.status_id=1 ) ".$condition." AND pl.lang_id=".$_SESSION['lang_id']." ORDER BY p.pr_id DESC ";
          $limit = 12;
          $start = $p->findStart($limit); 
          $count = mysql_num_rows(mysql_query($Query));
          $pages = $p->findPages($count, $limit); 
          $rs = mysql_query($Query." LIMIT ".$start.", ".$limit);
          if($count>0){
            while($row=mysql_fetch_object($rs)){
              $Qry1=mysql_query("SELECT cat_parentid FROM categories WHERE cat_id=".$row->cat_id);
              $row1=mysql_fetch_object($Qry1);
              $cat_id = $row1->cat_parentid;
              $counter++;
             
			  /*if($counter%4==0){
                $class = "item1 last";
              } else {
                $class = "item1";
              }
              if($counter==1 || $counter%2==1){
                echo '<div class="listing">';
              }*/
			  
              if($cat_id==1){
                 $cat_id = 5; 
              } elseif($cat_id==2){
                 $cat_id = 6; 
              } elseif($cat_id==3){
                 $cat_id = 7; 
              } elseif($cat_id==4){
                 $cat_id = 8; 
              }
			  $prf_thumb = returnName("prf_thumb", "pr_files", "pr_id", $row->pr_id);
              $imgPath = chkFileExists4($prf_thumb);
			  echo "
				<div class='col'>
					<div class='thumbs'>
						<div class='image'>
							<a href='index.php?id=".$cat_id."&pr=".$row->pr_id."'>
								<img src='".$imgPath."' />
							</a>
						</div>
						<div class='caption'>
							<a href='index.php?id=".$cat_id."&pr=".$row->pr_id."'>".limit_text($row->pr_title,20)."</a>
						</div>
					</div>
				</div>";
        ?>
            <?php //$prf_thumb = returnName("prf_thumb", "pr_files", "pr_id", $row->pr_id.' AND is_default=1 '); ?>
            <?php //$prf_file = returnName("prf_file", "pr_files", "pr_id", $row->pr_id.' AND is_default=1 '); ?>
           <!-- <div class="<?php echo $class;?>">
            <div class="image"><a href="index.php?id=<?php echo $cat_id.'&pr='.$row->pr_id;?>"><img <?php echo $atr;?> src="<?php echo chkFileExists4($prf_thumb);?>" /></a></div>
            <div class="details">
                <p class="title"><a style="text-decoration:none;" href="index.php?id=<?php echo $cat_id.'&pr='.$row->pr_id;?>"><?php echo $row->pr_title;?></a></p>
                <p class="by"><?php echo '<b>'.By.'</b> '.$row->mem_fname;?></p>
                <p class="views"><?php echo '<b>'.Views.'</b> '.$row->pr_hits;?></p>
            </div>
            </div>-->
            <?php
            /*if($counter%2==0){
              echo '<div class="clearfix"></div></div>';
            } else if($counter==$limit || $count==$counter){
              echo '<div class="clearfix"></div></div>';
            }*/
            ?>
        <?php
            }
          } else{
			  echo No_Records;
          }
        ?>
        <?php
          } else{
			  echo No_Records;
          }
        ?>
        <div class="clearfix"></div><br />
        <?php if($counter > 0) {?>
            <div class="full_width pagination">
                <ul style="border-bottom: solid 0px;">
                    <li><span><?php print(Page." <b>".$_GET['page']."</b> ".Of." ".$pages.' ');?></span></li>
                    <?php	
                        $next_prev = $p->nextPrev($_GET['page'], $pages, '&id='.$_REQUEST['id'].((isset($_REQUEST['cid'])?'&cid='.$_REQUEST['cid']:'')));
                        print($next_prev);
                    ?>
                </ul>
                <div class="clearfix"></div>
            </div><br />
            <div>&nbsp; <?php echo Total.' '.$count.' '.Records;?></div>
        <?php } ?>
      </div>
    </div>
    </div>
    <div class="right">
      <h2><?php echo Categories;?></h2>
      <div class="full_width category">
        <ul>
          <?php
            $Query = "SELECT c.cat_id, c.status_id, c.cat_parentid, cl.* FROM categories AS c LEFT OUTER JOIN categories_ln AS cl ON c.cat_id=cl.cat_id WHERE c.status_id=1  AND cl.lang_id=".$_SESSION['lang_id']." ORDER BY RAND() LIMIT 5";
            $count = mysql_num_rows(mysql_query($Query)); 
            $rs = mysql_query($Query);
            if($count>0){
                while($row=mysql_fetch_object($rs)){
          ?>
                  <li><a href="index.php?id=<?php echo $_REQUEST['id'];?>&cid=<?php echo $row->cat_id;?>"><?php echo $row->cat_name;?></a></li>
          <?php
                }
            }
          ?>
        </ul>
      </div>
      <div class="full_width add"><img src="images/add.jpg" /></div>
    </div>
    <div class="clearfix"></div>
    <h1><?php echo Aadvance_Search;?></h1>
    <div class="form_area">
      <form action="index.php?id=<?php echo $_REQUEST['id']?>" method="post" id="searchForm">
        <ul>
          <li>
            <div class="label"><?php echo Enter_Keywords;?>:</div><div class="triangle"></div>
            <input type="text" placeholder="Enter keywords..." name="searchTerm" class="input" value="<?php echo ((isset($_REQUEST['searchTerm']))&&($_REQUEST['searchTerm']!='')?$_REQUEST['searchTerm']:'');?>" />
          </li>
          <li>
            <select name="cid" class="input2">
				<?php
					echo FillSelected3("categories AS c LEFT OUTER JOIN categories_ln AS cl ON c.cat_id=cl.cat_id AND cl.lang_id=".$_SESSION['lang_id']." ", "c.cat_id", "cl.cat_name", @$_REQUEST['cid'], "c.cat_parentid");
				?>
            </select>
          </li>
          <li class="button"><input value="<?php echo Submit;?>" type="submit" class="btn" /></li>
        </ul>
      </form>    
    </div>
    <div class="clearfix"></div>
</div>