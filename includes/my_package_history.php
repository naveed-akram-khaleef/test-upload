<h1><?php print($strHead);?></h1>
<div class="full_width news_contents">
    <div class="table">
        <div class="head">
            <div class="col col1" style="width:100px; overflow:hidden;" ><?php echo Package;?></div>
            <div class="col col2" style="width:170px; overflow:hidden;" ><?php echo Downloads_Consumed;?></div>
            <div class="col col3" style="width:170px; overflow:hidden;" ><?php echo Streams_Consumed;?></div>
            <div class="col col4" style="width:170px; overflow:hidden;" ><?php echo Gifts_Consumed;?></div>
            <div class="col col5" style="width:150px; overflow:hidden;" ><?php echo Purchased_On;?></div>
            <div class="col col6" style="width:120px; overflow:hidden;" ><?php echo Expired_On;?></div>
            <div class="clearfix"></div>
        </div>
        <?php
            $Query = "SELECT mph.*, pk.pak_name, pkt.pktype_name FROM my_package_history AS mph LEFT OUTER JOIN packages AS pk ON mph.pak_id=pk.pak_id LEFT OUTER JOIN pak_type AS pkt ON pk.pktype_id=pkt.pktype_id WHERE mph.mem_id=".$_SESSION["memID"]." ORDER BY mph.mph_id DESC ";
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
        ?>
            <div class="<?php echo $class;?>">
                <div class="col col1" style="width:100px; overflow:hidden;" >&nbsp;<?php echo $row->pktype_name;?></div>
                <div class="col col2" style="width:170px; overflow:hidden;" >&nbsp;<?php print($row->mem_pak_downloads_con);?>/<?php echo $row->mem_pak_downloads;?></div>
                <div class="col col3" style="width:170px; overflow:hidden;" >&nbsp;<?php print($row->mem_pak_stream_con);?>/<?php echo $row->mem_pak_stream;?></div>
                <div class="col col4" style="width:170px; overflow:hidden;" >&nbsp;<?php print($row->mem_pak_gift_con);?>/<?php echo $row->mem_pak_gift;?></div>
                <div class="col col5" style="width:150px; overflow:hidden;" >&nbsp;<?php echo $row->mph_added_date;?></div>
                <div class="col col6" style="width:120px; overflow:hidden;" >&nbsp;<?php echo $row->mph_expiry;?></div>
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
                        $next_prev = $p->nextPrev($_GET['page'], $pages, '&id='.$_REQUEST['id']);
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
            $Query = "SELECT mph.*, pk.pak_name, pkt.pktype_name FROM my_package_history AS mph LEFT OUTER JOIN packages AS pk ON mph.pak_id=pk.pak_id LEFT OUTER JOIN pak_type AS pkt ON pk.pktype_id=pkt.pktype_id WHERE mph.mem_id=".$_SESSION["memID"]." ORDER BY mph.mph_id DESC ";
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
        ?>
            <div class="row">
                <ul>
                    <li class="left"><?php echo Package;?></li>
                    <li class="right"><?php echo $row->pktype_name;?></li>
                    <div class="clearfix"></div>
                </ul>
                <ul>
                    <li class="left"><?php echo Downloads_Consumed;?></li>
                    <li class="right"><?php print($row->mem_pak_downloads_con);?>/<?php echo $row->mem_pak_downloads;?></li>
                    <div class="clearfix"></div>
                </ul>
                <ul>
                    <li class="left"><?php echo Streams_Consumed;?></li>
                    <li class="right"><?php print($row->mem_pak_stream_con);?>/<?php echo $row->mem_pak_stream;?></li>
                    <div class="clearfix"></div>
                </ul>
                <ul>
                    <li class="left"><?php echo Gifts_Consumed;?></li>
                    <li class="right"><?php print($row->mem_pak_gift_con);?>/<?php echo $row->mem_pak_gift;?></li>
                    <div class="clearfix"></div>
                </ul>
                <ul>
                    <li class="left"><?php echo Added_On;?></li>
                    <li class="right"><?php echo $row->mph_added_date;?></li>
                    <div class="clearfix"></div>
                </ul>
                <ul>
                    <li class="left"><?php echo Expired_On;?></li>
                    <li class="right"><?php echo $row->mph_expiry;?></li>
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
                        $next_prev = $p->nextPrev($_GET['page'], $pages, '&id='.$_REQUEST['id']);
                        print($next_prev);
                    ?>
                </ul>
                <div class="clearfix"></div>
            </div><br />
            <div class="pagination_total">&nbsp; <?php echo Total.' '.$count.' '.Records;?></div>
        <?php } ?>
    </div>
</div>