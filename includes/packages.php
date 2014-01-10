<h1><?php print($strHead);?></h1>
<?php
$strMSG='';
$op='';
if(isset($_REQUEST['buy'])){
	$Qry2 = mysql_query("SELECT pk.*, pkt.pktype_days FROM packages AS pk LEFT OUTER JOIN pak_type AS pkt ON pk.pktype_id=pkt.pktype_id WHERE pk.pak_id=".$_REQUEST['pid']." LIMIT 1");
	$row2=mysql_fetch_object($Qry2);
	$tdownloads = $row2->pak_downloads;
	$tstreams = $row2->pak_streams;
	$tgifts = $row2->pak_gifts;
	$pkdays = $row2->pktype_days;
	$pkcredits = $row2->pak_credits;
	$date = date("Y-m-d", strtotime("+".$pkdays." day"));

	$Qry1 = mysql_query("SELECT mpl_id FROM mem_pak_limits WHERE mem_id=".$_SESSION["memID"]." AND pak_id=".$_REQUEST['pid']." AND mem_pak_isexpired!=1 ");
	$total1 = mysql_num_rows($Qry1);
	$row1 = mysql_fetch_object($Qry1);
	if($total1>0){

		$Qry3 = mysql_query("SELECT mpl_id, mem_pak_expiry FROM mem_pak_limits WHERE mem_id=".$_SESSION["memID"]." AND pak_id=".$_REQUEST['pid']." AND mem_pak_isexpired!=1 ");
		$total3 = mysql_num_rows($Qry3);
		$row3 = mysql_fetch_object($Qry3);
		$row3->mem_pak_expiry;
		$mpl_id = $row3->mpl_id;
		$remaining_days = (strtotime($row3->mem_pak_expiry) - strtotime(date('Y-m-d'))) / (60 * 60 * 24);
		if($remaining_days<0){
			$remaining_days=0;
		}
		$pkdays = ($pkdays + $remaining_days);
		$extended_date = date("Y-m-d", strtotime("+".$pkdays." day"));
		$date = $extended_date;

		mysql_query("UPDATE mem_pak_limits SET mem_pak_downloads=(mem_pak_downloads + ".$tdownloads."), mem_pak_stream=(mem_pak_stream + ".$tstreams."), mem_pak_gift=(mem_pak_gift + ".$tgifts."), mem_pak_date=NOW(), mem_pak_expiry='".$extended_date."', mem_pak_credits=(mem_pak_credits + ".$pkcredits.") WHERE mem_id=".$_SESSION["memID"]." AND pak_id=".$_REQUEST['pid']." AND mem_pak_isexpired!=1 ");
		//mysql_query("UPDATE members SET pak_id=".$_REQUEST['pid'].", pak_expiry='".$extended_date."', pak_isexpired=0 WHERE mem_id=".$_SESSION["memID"]." ");

		mysql_query("UPDATE my_package_history SET mem_pak_downloads=(mem_pak_downloads + ".$tdownloads."), mem_pak_stream=(mem_pak_stream + ".$tstreams."), mem_pak_gift=(mem_pak_gift + ".$tgifts."), mph_expiry='".$extended_date."', mem_pak_credits=(mem_pak_credits + ".$pkcredits.") WHERE mem_id=".$_SESSION["memID"]." AND pak_id=".$_REQUEST['pid']." AND mpl_id=".$mpl_id." ");
		$op = 4;
	} else {
		$MaxID = getMaximum("mem_pak_limits","mpl_id");
		mysql_query("INSERT INTO mem_pak_limits (mpl_id, mem_id, mem_pak_downloads, mem_pak_downloads_con, mem_pak_stream, mem_pak_stream_con, mem_pak_gift, mem_pak_gift_con, mem_pak_date, mem_pak_expiry, pak_id, mem_pak_credits) VALUES(".$MaxID.", ".$_SESSION["memID"].", '".$tdownloads."', '0', '".$tstreams."', '0', '".$tgifts."', '0', NOW(), '".$date."', ".$_REQUEST['pid'].", ".$pkcredits.")");
		$mpl_id = $MaxID;
		//mysql_query("UPDATE members SET pak_id=".$_REQUEST['pid'].", pak_expiry='".$date."', pak_isexpired=0 WHERE mem_id=".$_SESSION["memID"]." ");
		$op = 1;

		$MaxID_mph = getMaximum("my_package_history","mph_id");
		mysql_query("INSERT INTO my_package_history (mph_id, mem_id, pak_id, mpl_id, mph_added_date, mem_pak_downloads, mem_pak_downloads_con, mem_pak_stream, mem_pak_stream_con, mem_pak_gift, mem_pak_gift_con, mph_expiry, mem_pak_credits) VALUES(".$MaxID_mph.", ".$_SESSION["memID"].", ".$_REQUEST['pid'].", ".$mpl_id.", NOW(), '".$tdownloads."', '0', '".$tstreams."', '0', '".$tgifts."', '0', '".$date."', '".$pkcredits."')");

	}
	header("Location: index.php?id=".$_REQUEST['id'].'&op='.$op);
}
if(isset($_REQUEST["op"])){
	switch ($_REQUEST["op"]) {
		case 1:
			$msg_class='msg_box msg_ok';
			$strMSG = "Package Added Successfully";
			break;
		case 2:
			$msg_class='msg_box msg_ok';
			$strMSG = "Package Alredy Exists";
			break;
		case 3:
			$msg_class='msg_box msg_ok';
			$strMSG = "Package Deleted Successfully";
			break;
		case 4:
			$msg_class='msg_box msg_ok';
			$strMSG = "Package Updated Successfully";
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
    <div class="table">
        <div class="head">
            <div class="col col1" style="width:100px; overflow:hidden;" ><?php echo Package;?></div>
            <div class="col col2" style="width:80px;  overflow:hidden;"  ><?php echo Fee;?></div>
            <div class="col col3" style="width:100px; overflow:hidden;" ><?php echo Short_Code;?></div>
            <div class="col col4" style="width:190px; overflow:hidden;" ><?php echo Number_Of_Downloads;?></div>
            <div class="col col5" style="width:190px; overflow:hidden;" ><?php echo Number_Of_Streams;?></div>
            <div class="col col6" style="width:190px; overflow:hidden;" ><?php echo Number_Of_Gifts;?></div>
            <div class="col col7" style="width:80px;  overflow:hidden;" ><?php echo Action;?></div>
            <div class="clearfix"></div>
        </div>
        <?php
            $Query = "SELECT pk.*, sc.sc_code, pkt.pktype_name FROM packages AS pk LEFT OUTER JOIN shortcodes AS sc ON pk.sc_id=sc.sc_id LEFT OUTER JOIN pak_type AS pkt ON pk.pktype_id=pkt.pktype_id WHERE pk.status_id=1 ";
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
                <div class="col col2" style="width:80px; overflow:hidden;" >&nbsp;<?php print($row->pak_fee);?></div>
                <div class="col col3" style="width:100px; overflow:hidden;" >&nbsp;<?php print($row->sc_code);?></div>
                <div class="col col4" style="width:190px; overflow:hidden;" >&nbsp;<?php echo $row->pak_downloads;?> (<?php print(getSelCat($row->pak_id, 1));?>)</div>
                <div class="col col5" style="width:190px; overflow:hidden;" >&nbsp;<?php echo $row->pak_streams;?> (<?php print(getSelCat($row->pak_id, 2));?>)</div>
                <div class="col col6" style="width:190px; overflow:hidden;" >&nbsp;<?php echo $row->pak_gifts;?> (<?php print(getSelCat($row->pak_id, 3));?>)</div>
                <div class="col col7" style="width:80px; overflow:hidden;" ><a href="<?php echo 'index.php?id='.$_REQUEST['id'].'&buy=1&pid='.$row->pak_id;?>">Purchase</a></div>
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
            $Query = "SELECT pk.*, sc.sc_code, pkt.pktype_name FROM packages AS pk LEFT OUTER JOIN shortcodes AS sc ON pk.sc_id=sc.sc_id LEFT OUTER JOIN pak_type AS pkt ON pk.pktype_id=pkt.pktype_id WHERE pk.status_id=1 ";
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
                    <li class="left"><?php echo Fee;?></li>
                    <li class="right"><?php print($row->pak_fee);?></li>
                    <div class="clearfix"></div>
                </ul>
                <ul>
                    <li class="left"><?php echo Short_Code;?></li>
                    <li class="right"><?php print($row->sc_code);?></li>
                    <div class="clearfix"></div>
                </ul>
                <ul>
                    <li class="left"><?php echo Number_Of_Downloads;?></li>
                    <li class="right"><?php echo $row->pak_downloads;?> (<?php print(getSelCat($row->pak_id, 1));?>)</li>
                    <div class="clearfix"></div>
                </ul>
                <ul>
                    <li class="left"><?php echo Number_Of_Streams;?></li>
                    <li class="right"><?php echo $row->pak_streams;?> (<?php print(getSelCat($row->pak_id, 2));?>)</li>
                    <div class="clearfix"></div>
                </ul>
                <ul>
                    <li class="left"><?php echo Number_Of_Gifts;?></li>
                    <li class="right"><?php echo $row->pak_gifts;?> (<?php print(getSelCat($row->pak_id, 3));?>)</li>
                    <div class="clearfix"></div>
                </ul>
                <ul>
                    <li class="left"><?php echo Action;?></li>
                    <li class="right"><a href="<?php echo 'index.php?id='.$_REQUEST['id'].'&buy=1&pid='.$row->pak_id;?>">Purchase</a></li>
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