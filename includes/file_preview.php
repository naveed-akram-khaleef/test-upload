<?php if($st_limit==0){?>
    <li class="disable"><a href="javascript:void(0);" title="<?php echo Purchase_Package;?>"><img src="images/icons/preview_icon.png" /></a></li>
<?php
    } else {
        if($prf_file!=''){
?>
        <li class="disable"><a href="javascript:void(0);" title="<?php echo File_Not_Exists;?>"><img src="images/icons/preview_icon.png" /></a></li>

        <li><a href="javascript:void(0);" title="<?php echo Preview;?>"><img src="images/icons/view_icon.png" /></a>
            <ul>
                <?php
                    $Query1 = "SELECT pt.*, prf.* FROM pr_types AS pt LEFT OUTER JOIN pr_files AS prf ON pt.ptype_id=prf.ptype_id WHERE pt.cat_id=".$_SESSION['vot_cat']." AND prf.pr_id=".$row->pr_id." ";
                    $count1 = mysql_num_rows(mysql_query($Query1)); 
                    $rs1 = mysql_query($Query1);
                    while($row1=mysql_fetch_object($rs1)){
                ?>
                        <li><a href="<?php echo $siteRoot;?>index.php?id=20&pr_id=<?php echo $_REQUEST['pr']?>&consume=1&cat_id=<?php echo $_SESSION['vot_cat'];?>&prf_id=<?php echo $row1->prf_id;?>&mpl_id=<?php echo $mpl_id;?>&pat_id=<?php echo $pat_id;?>&preview=1" target="_blank"><?php print($row1->ptype_value);?></a></li>
                <?php
                    }
                ?>
            </ul>
        </li>
        <?php } else { ?>
            <li class="disable"><a href="javascript:void(0);" title="<?php echo File_Not_Exists;?>"><img src="images/icons/preview_icon.png" /></a></li>
        <?php }?>
<?php }?>