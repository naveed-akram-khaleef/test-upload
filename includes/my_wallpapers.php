<?php
$strMSG='';
if(isset($_REQUEST['btnDelete'])){ 
	mysql_query("DELETE FROM my_collection WHERE mc_id = ".$_REQUEST['mc_id']." AND mem_id=".$_SESSION["memID"]." ");
	header("Location: index.php?id=".$_REQUEST['id'].'&op=3');
}
if(isset($_REQUEST["op"])){
	switch ($_REQUEST["op"]) {
		case 3:
			$msg_class='msg_box msg_ok';
			$strMSG = "Record Deleted Successfully";
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
<div class="table">
  <div class="head">
    <div class="col">ID</div>
    <div class="col">Added Date</div>
    <div class="col">Product Name</div>
    <div class="col">Product Details</div>
    <div class="col">Action</div>
    <div class="clearfix"></div>
  </div>
	<?php
    $Query = " SELECT mc.*, pr.* FROM my_collection AS mc LEFT OUTER JOIN products AS pr ON mc.pr_id=pr.pr_id WHERE mc.mem_id=".$_SESSION["memID"]." AND mc.cat_id=4 ORDER BY mc.mc_id DESC";
    $counter=0;
    $limit = 25;
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
      <div class="col">&nbsp;<?php echo $row->mc_id;?></div>
      <div class="col">&nbsp;<?php echo $row->mc_added_date;?></div>
      <div class="col">&nbsp;<?php echo $row->pr_title;?></div>
      <div class="col"><a href="index.php?id=8&pr=<?php echo $row->pr_id;?>">View</a></div>
      <div class="col"><a href="<?php print($_SERVER['PHP_SELF']."?id=".$_REQUEST['id']."&btnDelete=1&mc_id=".$row->mc_id);?>" title="Delete" onClick="javascript: return confirm('Are you sure you want to delete this record');"><img src="images/icons/trashcan_gray.png" alt="" /></a></div>
      <div class="clearfix"></div>
    </div>
	<?php
      }
    } else{
  ?>
      <div align="center" style="padding-top:20px;">No Records found.</div>
  <?php
    }
  ?>
</div>