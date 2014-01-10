<?php
$rsHW = mysql_query("SELECT * FROM widgets ORDER BY wid_id LIMIT 0,2");
if(mysql_num_rows($rsHW)>0){
?>
<div class="full_width">
<?php
	$cnt = 0;
	while($rHW=mysql_fetch_object($rsHW)){
		$cnt++;
		$clsName = "left";
		if($cnt%2==0){
			$clsName = "right";
		}
?>
	<div class="<?php print($clsName);?> texture_box avoid_increase">
		<div class="heading">
			<div class="bullet"></div>
			<?php print($rHW->wid_heading);?>
		</div>
		<div class="ctn"><?php print($rHW->wid_details);?></div>
	</div>
<?php
		}
?>
	<div class="clearfix"></div>
</div>
<?php
	}
?>
