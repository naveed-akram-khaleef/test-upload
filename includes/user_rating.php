<?php 
	if(isset($_SESSION["memID"])){
?>
	<?php
		$Query = "SELECT * FROM votes WHERE pro_id = '".$_REQUEST["pr"]."' AND section_id=".$_SESSION['vot_cat']." AND user_id='".$_SESSION["memID"]."' ";
		$rs = mysql_query($Query);
		$vote_given = mysql_num_rows($rs);
		if(mysql_num_rows($rs) > 0){
			$rowVote = mysql_fetch_object($rs);
			$total_ratings = 0;
			$total_vots = 0;
			$avg = 0.0;
			$qry1 = mysql_query("SELECT COUNT( 1 ) AS total_records, SUM( rate ) AS total FROM votes WHERE section_id=".$_SESSION['vot_cat']." AND pro_id=".$row->pr_id);
			if( mysql_num_rows($qry1)>0 ){
				$row1 = mysql_fetch_object($qry1);
				$total_ratings = $row1->total;
				$total_vots = $row1->total_records;
			}
			if($total_ratings!=0 && $total_vots!=0) {
				$avg = ( $total_ratings / $total_vots );
				$avg = round($avg, 1);
			}
			?>
            <div class="serverResponse">
                <div class="exemple">
                    <div class="exemple4 pagination_total float_right" id="<?php echo $avg;?>_10"></div>
                </div>
                <div class="clearfix"></div>
                <p><?php print(avgRating($_SESSION['vot_cat'], $_REQUEST["pr"]));?></p>
                <p><?php echo You_Rated;?> <b><?php echo $rowVote->rate;?></b></p>
            </div>
	<?php
        } else {
    ?>
        <div class="exemple pagination_total float_right">
            <div class="exemple5" id="10_<?php echo $_REQUEST['pr']?>"></div>
        </div>
        <div class="clearfix"></div>
        <div class="serverResponse pagination_total">
            <p><?php print(avgRating($_SESSION['vot_cat'], $_REQUEST["pr"]));?></p>
        </div>
	<?php
    }
    ?>
<?php } else { ?>
<?php
	$total_ratings = 0;
	$total_vots = 0;
	$avg = 0.0;
	$qry1 = mysql_query("SELECT COUNT( 1 ) AS total_records, SUM( rate ) AS total FROM votes WHERE section_id=".$_SESSION['vot_cat']." AND pro_id=".$_REQUEST["pr"]);
	if( mysql_num_rows($qry1)>0 ){
		$row1 = mysql_fetch_object($qry1);
		$total_ratings = $row1->total;
		$total_vots = $row1->total_records;
	}
	if($total_ratings!=0 && $total_vots!=0) {
		$avg = ( $total_ratings / $total_vots );
		$avg = round($avg, 1);
	}
?>
    <div class="serverResponse">
        <div class="exemple">
            <div class="exemple4 pagination_total float_right" id="<?php echo $avg;?>_10"></div>
        </div>
        <div class="clearfix"></div>
        <p><?php print(avgRating($_SESSION['vot_cat'], $_REQUEST["pr"]));?></p>
    </div>
<?php }?>
<script type="text/javascript">
	$(document).ready(function(){
		$('.exemple5').jRating({
			step:true,
			decimalLength:1,
			onSuccess : function(){
				//alert('Success : your rate has been saved :)');
			},
			onError : function(){
				//alert('Error : please retry');
			}
		});
		$('.exemple4').jRating({
			isDisabled : true
		});
	});
</script>
