<div class="full_width">
	<?php
        $Query = "SELECT prf.*, pl.pr_title, pt.ptype_value, pt.cat_id FROM pr_files AS prf LEFT OUTER JOIN products_ln AS pl ON prf.pr_id=pl.pr_id AND pl.lang_id=".$_SESSION['lang_id']." LEFT OUTER JOIN pr_types AS pt ON prf.ptype_id=pt.ptype_id WHERE prf.prf_id=".$_REQUEST['prf_id']." AND prf.pr_id=".$_REQUEST['pr_id']." LIMIT 1";
        $rs = mysql_query($Query);
        $count = mysql_num_rows(mysql_query($Query)); 
		if($count>0){
			while($row=mysql_fetch_object($rs)){
    ?>
            <p>
                <h1> <?php echo $row->pr_title;?> </h1> 
                <?php echo $row->ptype_value; ?>
            </p>
            <div style="overflow-x:scroll; overflow-y:scroll; height:auto; width:954px;">
                <?php 
                    $cat = $row->cat_id;
                    //if($cat==4){
						$file_name = chkFileExists6($row->prf_file);
						
                ?>
                        <img src="<?php echo $file_name;?>" alt="<?php echo $row->pr_title;?> - file not found" style="max-width:none;"  />
                <?php		
                   // }
                ?>
            </div>
			<?php
				$Query = mysql_query("SELECT * FROM mem_logs WHERE mem_id=".$_SESSION["memID"]." AND cat_id=".$_REQUEST["cat_id"]." AND ustype_id=".$_REQUEST['consume']." AND pr_id=".$_REQUEST['pr_id']." AND counter<5");
				$total = mysql_num_rows($Query);
				$row = $row=mysql_fetch_object($Query);
				if($total>0){
					mysql_query("UPDATE mem_logs SET counter = (counter + 1) WHERE mem_id=".$_SESSION["memID"]." AND cat_id=".$_REQUEST["cat_id"]." AND ustype_id=".$_REQUEST['consume']." AND pr_id=".$_REQUEST['pr_id']." AND counter<5");
				}
				else {
					$MaxID = getMaximum("mem_logs","mlog_id");
					mysql_query("INSERT INTO mem_logs (mlog_id, mem_id, cat_id, ustype_id, pr_id, mlog_date, mlog_time, counter) VALUES (".$MaxID.", ".$_SESSION["memID"].", ".$_REQUEST['cat_id'].", ".$_REQUEST['consume'].", ".$_REQUEST['pr_id'].", NOW(), NOW(), 1)");
				
					$MaxID = getMaximum("my_consumption","myc_id");
					mysql_query("INSERT INTO my_consumption (myc_id, pr_id, mem_id, myc_added_date, cat_id, consume_type) VALUES (".$MaxID.", ".$_REQUEST['pr_id'].", ".$_SESSION["memID"].", NOW(), ".$_REQUEST['cat_id'].", '1')");
					
					if($_REQUEST['pat_id']==1){
						mysql_query("UPDATE mem_pak_limits SET mem_pak_stream_con = (mem_pak_stream_con + 1) WHERE mem_id = ".$_SESSION["memID"]." AND mpl_id=".$_REQUEST['mpl_id']." AND mem_pak_isexpired=0 ");
						mysql_query("UPDATE my_package_history SET mem_pak_stream_con = (mem_pak_stream_con + 1) WHERE mem_id = ".$_SESSION["memID"]." AND mpl_id=".$_REQUEST['mpl_id']." AND mem_pak_isexpired=0 ");
					}
					elseif($_REQUEST['pat_id']==2){
						mysql_query("UPDATE mem_pak_limits SET mem_pak_credits = (mem_pak_credits - 1) WHERE mem_id = ".$_SESSION["memID"]." AND mpl_id=".$_REQUEST['mpl_id']." AND mem_pak_isexpired=0 ");
						mysql_query("UPDATE my_package_history SET mem_pak_credits = (mem_pak_credits - 1) WHERE mem_id = ".$_SESSION["memID"]." AND mpl_id=".$_REQUEST['mpl_id']." AND mem_pak_isexpired=0 ");
					}
				
				}
			?>
	<?php
			}
		}
	?>
    <div class="clearfix"></div>
</div>