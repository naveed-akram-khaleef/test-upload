<h1><?php print($strHead);?></h1>
<?php
$strMSG='';
if(isset($_REQUEST['delete'])){
	mysql_query("UPDATE members SET pak_id='0', pak_expiry='', pak_isexpired='0' WHERE mem_id=".$_SESSION["memID"]." ");
	mysql_query("DELETE FROM mem_pak_limits WHERE mem_id = ".$_SESSION["memID"]." ");
	header("Location: index.php?id=".$_REQUEST['id'].'&op=3');
}
if(isset($_REQUEST["op"])){
	switch ($_REQUEST["op"]) {
		case 1:
			$msg_class='msg_box msg_ok';
			$strMSG = "Package Added Successfully";
			break;
		case 2:
			$msg_class='msg_box msg_ok';
			$strMSG = "Package Alredy Exists, Delete Old Package First";
			break;
		case 3:
			$msg_class='msg_box msg_ok';
			$strMSG = "Package Deleted Successfully";
			break;
		case 4:
			$msg_class='msg_box msg_ok';
			$strMSG = "Package Updated Successfully";
			break;
		case 5:
			$msg_class='msg_box msg_ok';
			$strMSG = "Conversion cannot be done due to insufficient downloads/streams";
			break;
	}
}
?>
<?php if($strMSG!=''){?> 
    <div id="msg_div">
      <div class="alert">
          <div class="close">x</div>
          <div class="alert_inner" align="center">
              <p id="msg"><?php echo $strMSG;?></p>
          </div>
      </div>                        
    </div>
<?php }?>
<div class="full_width news_contents">
    <h1><?php //echo My_Purchased_Package;?></h1>
    <div class="table">
        <div class="head">
            <div class="col col1" style="width:100px; overflow:hidden;" ><?php echo Package;?></div>
            <div class="col col2" style="width:170px; overflow:hidden;" ><?php echo Downloads;?></div>
            <div class="col col3" style="width:160px; overflow:hidden;" ><?php echo Streams;?></div>
            <div class="col col4" style="width:160px; overflow:hidden;" ><?php echo Gifts_Consumed;?></div>
            <div class="col col6" style="width:60px;  overflow:hidden;" ><?php echo Credits;?></div>
            <div class="col col5" style="width:140px; overflow:hidden;" ><?php echo Expired_On;?></div>
            <div class="col col6" style="width:60px;  overflow:hidden;" ><?php echo Expired;?></div>
            <div class="clearfix"></div>
        </div>
        <?php
            $Query = "SELECT mpl.*, pk.pak_name, pk.pak_id, pk.pat_id, pk.pak_credits FROM mem_pak_limits AS mpl LEFT OUTER JOIN packages AS pk ON mpl.pak_id=pk.pak_id WHERE pk.status_id=1 AND mpl.mem_id=".$_SESSION["memID"]." ORDER BY mpl.mpl_id DESC";
            $counter=0;
            $count = mysql_num_rows(mysql_query($Query)); 
            $rs = mysql_query($Query);
            if($count>0){
                while($row=mysql_fetch_object($rs)){	
                    $counter++;
                    if($counter%2==0){
                        $class = "row color";
                    } else {
                        $class = "row";
                    }
        ?>
            <div class="<?php echo $class;?>">
                <div class="col col1" style="width:100px; overflow:hidden;" >&nbsp;<?php echo $row->pak_name;?></div>
                <div class="col col2" style="width:170px; overflow:hidden;" >&nbsp;
					<?php
						if($row->pat_id==2){
							echo floor($row->mem_pak_credits/$row->mem_pak_downloads);
						}
						else {
							echo $row->mem_pak_downloads_con.'/'.$row->mem_pak_downloads;
						}
					?>
                </div>
                <div class="col col3" style="width:160px; overflow:hidden;" >&nbsp;
					<?php
						if($row->pat_id==2){
							echo floor($row->mem_pak_credits/$row->mem_pak_stream);
						}
						else {
							echo $row->mem_pak_stream_con.'/'.$row->mem_pak_stream;
						}
					?>
                </div>
                <div class="col col4" style="width:160px; overflow:hidden;" >&nbsp;<?php print($row->mem_pak_gift_con);?>/<?php echo $row->mem_pak_gift;?></div>
                <div class="col col6" style="width:60px; overflow:hidden;" >&nbsp;<?php echo $row->mem_pak_credits;?></div>
                <div class="col col5" style="width:140px; overflow:hidden;" >&nbsp;<?php 
                    echo $row->mem_pak_expiry.'<br/>';
					$days = floor((strtotime($row->mem_pak_expiry) - strtotime(date('Y-m-d'))) / (60 * 60 * 24));
					print '&nbsp;'.$days.' Day(s) remaining';
                ?></div>
                <div class="col col6" style="width:60px; overflow:hidden;" >&nbsp;<?php echo (($row->mem_pak_isexpired==1)?'Yes':'Not Yet');?></div>
                <div class="clearfix"></div>
            </div>
        <?php
                }
              } else{
				  echo '<p>'.No_Records.'</p>';
              }
        ?>
    </div>
    
    <div class="list_view">
		<?php
            $Query = "SELECT mpl.*, pk.pak_name, pk.pak_id, pk.pak_downloads, pk.pak_streams, pk.pat_id, pk.pak_credits FROM mem_pak_limits AS mpl LEFT OUTER JOIN packages AS pk ON mpl.pak_id=pk.pak_id WHERE pk.status_id=1 AND mpl.mem_id=".$_SESSION["memID"]." ORDER BY mpl.mpl_id DESC";
            $counter=0;
            $count = mysql_num_rows(mysql_query($Query)); 
            $rs = mysql_query($Query);
            if($count>0){
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
                    <li class="right"><?php echo $row->pak_name;?></li>
                    <div class="clearfix"></div>
                </ul>
                <ul>
                    <li class="left"><?php echo Downloads;?></li>
                    <li class="right">					
						<?php
                            if($row->pat_id==2){
                                echo floor($row->mem_pak_credits/$row->pak_downloads);
                            }
                            else {
                                print($row->mem_pak_stream_con);?>/<?php echo $row->mem_pak_stream;
                            }
                        ?>
                    </li>
                    <div class="clearfix"></div>
                </ul>
                <ul>
                    <li class="left"><?php echo Streams;?></li>
                    <li class="right">
						<?php
                            if($row->pat_id==2){
                                echo floor($row->mem_pak_credits/$row->pak_streams);
                            }
                            else {
                                print($row->mem_pak_stream_con);?>/<?php echo $row->mem_pak_stream;
                            }
                        ?>
                    </li>
                    <div class="clearfix"></div>
                </ul>
                <ul>
                    <li class="left"><?php echo Gifts_Consumed;?></li>
                    <li class="right"><?php print($row->mem_pak_gift_con);?>/<?php echo $row->mem_pak_gift;?></li>
                    <div class="clearfix"></div>
                </ul>
                <ul>
                    <li class="left"><?php echo Credits;?></li>
                    <li class="right"><?php echo $row->mem_pak_credits;?></li>
                    <div class="clearfix"></div>
                </ul>
                <ul>
                    <li class="left"><?php echo Expired_On;?></li>
                    <li class="right"><?php 
                    echo $row->mem_pak_expiry.'<br/>';
					$days = floor((strtotime($row->mem_pak_expiry) - strtotime(date('Y-m-d'))) / (60 * 60 * 24));
					print $days.' Day(s) remaining';
                ?></li>
                    <div class="clearfix"></div>
                </ul>
                <ul>
                    <li class="left"><?php echo Expired;?></li>
                    <li class="right"><?php echo (($row->mem_pak_isexpired==1)?'Yes':'Not Yet');?></li>
                    <div class="clearfix"></div>
                </ul>
            </div>    
        <?php
                }
              } else{
				  echo '<p>'.No_Records.'</p>';
              }
        ?>
    </div>
    
</div>