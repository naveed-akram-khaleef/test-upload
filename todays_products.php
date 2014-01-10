<?php include("includes/php_includes_top.php"); ?>
<table width="30%">
    <?php
        $Query1 = "SELECT p.pr_added_date, p.cat_id, pl.pr_id, pl.pr_title, (SELECT c.cat_parentid FROM categories AS c WHERE p.cat_id=c.cat_id) AS cat_parent_id FROM products AS p LEFT OUTER JOIN products_ln AS pl ON p.pr_id=pl.pr_id AND pl.lang_id=1 LEFT OUTER JOIN categories AS c ON p.cat_id=c.cat_id LEFT OUTER JOIN category_notifications AS cn ON p.cat_id=cn.cat_id WHERE p.pr_added_date='".date('Y-m-d')."' AND p.cat_id=cn.cat_id AND cn.mem_id=".$_SESSION["memID"]." ";
        $total = mysql_num_rows(mysql_query($Query1)); 
        $rs1 = mysql_query($Query1);
		if($total>0){
	?>
            <tr> 
                <td width="15%">Total Notifications</td>
                <td width="15%"><?php echo $total;?></td>
            </tr> 
    
    <?php		
			while($row1=mysql_fetch_object($rs1)){
				$page_id=1;
				if($row1->cat_parent_id==1){
					$page_id = 5;
				} elseif($row1->cat_parent_id==2){
					$page_id = 6;
				} elseif($row1->cat_parent_id==3){
					$page_id = 7;
				} elseif($row1->cat_parent_id==4){
					$page_id = 8;
				}
    ?>
                <tr> 
                    <td width="15%"><?php echo $row1->pr_title;?></td>
                    <td width="15%"><a href="<?php echo $_SESSION['site_root'].'index.php?id='.$page_id.'&pr='. $row1->pr_id;?>"><?php echo $row1->pr_title;?></a></td>
                </tr> 
    <?php
			}
		} else {
			echo 'No Notifications.';
		}
    ?>
</table>