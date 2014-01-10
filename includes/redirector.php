<?php
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
	$Query ="SELECT pr.pr_id, pl.pr_title, pr.pr_hits, prf.prf_thumb, prf.prf_file, m.mem_fname, prf.prf_preview, c.cat_id ".$condition." FROM products AS pr LEFT OUTER JOIN members AS m ON pr.mem_id=m.mem_id LEFT OUTER JOIN categories AS c ON pr.cat_id=c.cat_id LEFT OUTER JOIN pr_files AS prf ON pr.pr_id=prf.pr_id AND prf.is_default=1 LEFT OUTER JOIN products_ln AS pl ON pr.pr_id=pl.pr_id WHERE pr.status_id=1 AND c.status_id=1 AND c.cat_parentid=".$_SESSION['vot_cat']." ".$cat_id." AND pl.lang_id=".$_SESSION['lang_id']." ".$where." ";
	$limit = 1;
	$start = $p->findStart($limit); 
	$count = mysql_num_rows(mysql_query($Query));
	$pages = $p->findPages($count, $limit); 
	$rs = mysql_query($Query." LIMIT ".$start.", ".$limit);
	if($count>0){
		while($row=mysql_fetch_object($rs)){
		  $pr_id = $row->pr_id;
		}
	}
	$redirect_url = $_SESSION['site_root'].'index.php?page='.$_REQUEST['page']."&id=".$_REQUEST['id'].$url.((isset($_REQUEST['cid']))?'&cid='.$_REQUEST['cid']:'').'&pr='.$pr_id;
	$res = "";
	$res.='<script type="text/javascript">';
		$res.='window.location.href="'.$redirect_url.'";';
	$res.='</script>';
	echo $res;
?>