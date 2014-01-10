<?php
	$counter=0;
	$url = "";
	$condition='';
	if(isset($_REQUEST['na'])){
		$where = " ORDER BY pr.pr_id DESC ";
		$url = "&na=1";
	} elseif(isset($_REQUEST['tr'])){
		$condition = " ,( SELECT SUM( v.rate ) FROM votes AS v WHERE v.section_id=".$_SESSION['vot_cat']." AND v.pro_id=pr.pr_id LIMIT 1 ) as res ";
		$where = " ORDER BY res DESC ";
		$url = "&tr=1";
	} elseif(isset($_REQUEST['mv'])){
		$where = " ORDER BY pr.pr_hits DESC ";
		$url = "&mv=1";
	} elseif(isset($_REQUEST['fr'])){
		$where = " AND pr.is_featured=1 ORDER BY pr.pr_id ";
		$url = "&fr=1";
	} else {
		$where = " ORDER BY pr.pr_id ASC ";
	}
	$Query ="SELECT pr.pr_id, pl.pr_title, pr.pr_hits, prf.prf_thumb, prf.prf_file, prf.prf_preview, c.cat_id ".$condition." FROM products AS pr LEFT OUTER JOIN categories AS c ON pr.cat_id=c.cat_id LEFT OUTER JOIN pr_files AS prf ON pr.pr_id=prf.pr_id LEFT OUTER JOIN products_ln AS pl ON pr.pr_id=pl.pr_id WHERE pr.status_id=1 AND c.status_id=1 AND c.cat_parentid=".$_SESSION['vot_cat']." ".$cat_id." AND pl.lang_id=".$_SESSION['lang_id']." ".$where." ";
	$limit = 12;
	$start = $p->findStart($limit);
	$count = mysql_num_rows(mysql_query($Query));
	$pages = $p->findPages($count, $limit); 
	$rs = mysql_query($Query." LIMIT ".$start.", ".$limit);
	if($count>0){
		while($row=mysql_fetch_object($rs)){
		  $counter++;
		  $imgPath = chkFileExists4($row->prf_thumb);
		  echo "
			<div class='col'>
				<div class='thumbs'>
					<div class='image'>
						<a href='index.php?page=".($start+$counter)."&id=".$_REQUEST['id'].$url.((isset($_REQUEST['cid']))?'&cid='.$_REQUEST['cid']:'')."&pr=".$row->pr_id."'><img src='".$imgPath."' /></a>
					</div>
					<div class='caption'>
						<a href='index.php?page=".($start+$counter)."&id=".$_REQUEST['id'].$url.((isset($_REQUEST['cid']))?'&cid='.$_REQUEST['cid']:'')."&pr=".$row->pr_id."'>".limit_text($row->pr_title,15)."</a>
					</div>
				</div>
			</div>";
			if($counter%4==0){echo '<div class="clearfix"></div>';}
		}
  } else{
	  echo No_Records;
  }
?>
<div class="clearfix"></div>
<?php if($counter > 0) {?>
	<div class="full_width pagination">
		<ul style="border-bottom: solid 0px;">
			<li><span><?php print(Page." <b>".$_GET['page']."</b> ".Of.' '.$pages.' ');?></span></li>
			<?php	
				$next_prev = $p->nextPrev($_GET['page'], $pages, "&id=".$_REQUEST['id'].$url.((isset($_REQUEST['cid']))?'&cid='.$_REQUEST['cid']:''));
				print($next_prev);
			?>
		</ul>
		<div class="clearfix"></div>
	</div><br />
	<div class="pagination_total">&nbsp; <?php echo Total.' '.$count.' '.Records;?></div>
<?php } ?>