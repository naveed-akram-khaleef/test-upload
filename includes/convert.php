<h1><?php print($strHead);?></h1>
<?php
$strMSG='';

if(isset($_REQUEST['conversion_downloads'])){

	echo '<pre>';
	print_r( $_REQUEST );
	echo '</pre>';

	$Qry1 = mysql_query("SELECT mpl.* FROM mem_pak_limits AS mpl WHERE mpl.mem_id=".$_SESSION["memID"]." AND mpl.pak_id=".$_REQUEST['pak_id']." AND mpl.mpl_id=".$_REQUEST['mpl_id']." ");
	$total1 = mysql_num_rows($Qry1);
	$row1 = mysql_fetch_object($Qry1);
	$mpl_id = $row1->mpl_id;
	$downloads = $row1->mem_pak_downloads;
	$downloadsc = $row1->mem_pak_downloads_con;
	$streams = $row1->mem_pak_stream;
	$streamsc = $row1->mem_pak_stream_con;
	$gifts = $row1->mem_pak_gift;
	$giftsc = $row1->mem_pak_gift_con;
	$pkcredits = $row1->mem_pak_credits;

	echo $downloads.' &nbsp;&nbsp; '.$downloadsc.' &nbsp;&nbsp; '.($downloads-$downloadsc).'<br/>';
	echo $streams.' &nbsp;&nbsp; '.$streamsc.' &nbsp;&nbsp; '.($streams-$streamsc).'<br/>';
	echo $gifts.' &nbsp;&nbsp; '.$giftsc.' &nbsp;&nbsp; '.($gifts-$giftsc).'<br/>';
	echo $pkcredits;
	echo '<br/>';


/*
	$Qry1 = mysql_query("SELECT mpl.* FROM mem_pak_limits AS mpl WHERE mpl.mem_id=".$_SESSION["memID"]." AND mpl.pak_id=".$_REQUEST['pak_id']." AND mpl.mpl_id=".$_REQUEST['mpl_id']." ");
	$total1 = mysql_num_rows($Qry1);
	$row1 = mysql_fetch_object($Qry1);
	$mpl_id = $row1->mpl_id;
	$downloads = $row1->mem_pak_downloads;
	$downloadsc = $row1->mem_pak_downloads_con;
	$streams = $row1->mem_pak_stream;
	$streamsc = $row1->mem_pak_stream_con;
	$gifts = $row1->mem_pak_gift;
	$giftsc = $row1->mem_pak_gift_con;
	
	if(($downloads-$downloadsc)>=$_REQUEST['convert_number']){
		$new_downloadsc = ($downloadsc + $_REQUEST['convert_number']);
		$new_streams = ($streams + ($_REQUEST['convert_rate']*$_REQUEST['convert_number']));
		mysql_query("UPDATE mem_pak_limits SET mem_pak_downloads_con='".$new_downloadsc."', mem_pak_stream='".$new_streams."' WHERE mem_id=".$_SESSION["memID"]." AND mem_pak_isexpired=0 AND mpl_id=".$_REQUEST['mpl_id']." ");
		mysql_query("UPDATE my_package_history SET mem_pak_downloads_con='".$new_downloadsc."', mem_pak_stream='".$new_streams."' WHERE mem_id=".$_SESSION["memID"]." AND mpl_id=".$_REQUEST['mpl_id']." ");
		header("Location: index.php?id=22&op=4");
	} else {
		header("Location: index.php?id=".$_REQUEST['id']."&pak_id=".$_REQUEST['pak_id']."&mpl_id=".$_REQUEST['mpl_id']."&convert_rate=".$_REQUEST['convert_rate']."&op=5");
	}
*/
}

/*
if(isset($_REQUEST['conversion_streams'])){
	$Qry1 = mysql_query("SELECT mpl.* FROM mem_pak_limits AS mpl WHERE mpl.mem_id=".$_SESSION["memID"]." AND mpl.pak_id=".$_REQUEST['pak_id']." AND mpl.mpl_id=".$_REQUEST['mpl_id']." ");
	$total1 = mysql_num_rows($Qry1);
	$row1 = mysql_fetch_object($Qry1);
	$mpl_id = $row1->mpl_id;
	$downloads = $row1->mem_pak_downloads;
	$downloadsc = $row1->mem_pak_downloads_con;
	$streams = $row1->mem_pak_stream;
	$streamsc = $row1->mem_pak_stream_con;
	$gifts = $row1->mem_pak_gift;
	$giftsc = $row1->mem_pak_gift_con;

	if(($streams-$streamsc)>($_REQUEST['convert_rate']*$_REQUEST['convert_number'])){
		if($downloadsc>=$_REQUEST['convert_number']){
			$new_downloadsc = ($downloadsc - $_REQUEST['convert_number']);
			$new_streams = ($streams - ($_REQUEST['convert_rate']*$_REQUEST['convert_number']));
			mysql_query("UPDATE mem_pak_limits SET mem_pak_downloads_con='".$new_downloadsc."', mem_pak_stream='".$new_streams."' WHERE mem_id=".$_SESSION["memID"]." AND mem_pak_isexpired=0 AND mpl_id=".$_REQUEST['mpl_id']." ");
			mysql_query("UPDATE my_package_history SET mem_pak_downloads_con='".$new_downloadsc."', mem_pak_stream='".$new_streams."' WHERE mem_id=".$_SESSION["memID"]." AND mpl_id=".$_REQUEST['mpl_id']." ");
			header("Location: index.php?id=22&op=4");
		} else {
			header("Location: index.php?id=".$_REQUEST['id']."&pak_id=".$_REQUEST['pak_id']."&mpl_id=".$_REQUEST['mpl_id']."&convert_rate=".$_REQUEST['convert_rate']."&op=5");
		}
	} else {
		header("Location: index.php?id=".$_REQUEST['id']."&pak_id=".$_REQUEST['pak_id']."&mpl_id=".$_REQUEST['mpl_id']."&convert_rate=".$_REQUEST['convert_rate']."&op=5");
	}
}
*/
if(isset($_REQUEST["op"])){
	switch ($_REQUEST["op"]) {
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
<div id="loginFormDiv" class="contact login">
    <div class="form_area">
        <h4>Available Credits: <?php echo $_REQUEST['convert_rate'];?></h4><br />

        <form name="frm_download" method="post" id="" action="<?php $_SERVER['PHP_SELF'];?>">
            <ul>
                <li>
                    <div class="label"> Downloads:</div><div class="triangle"></div>
                    <input type="text" class="input" name="convert_number" />
                </li>
               <li class="button">
                    <input type="submit" class="btn" name="conversion_downloads" value="Convert to Streams" />
                </li>
            </ul>
        </form>

<!--
        <form name="frm_stream" method="post" id="" action="<?php $_SERVER['PHP_SELF'];?>">
            <ul>
                <li>
                    <div class="label"> Streams:</div><div class="triangle"></div>
                    <input type="text" class="input" name="convert_number" />
                </li>
               <li class="button">
                    <input type="submit" class="btn" name="conversion_streams" value="Convert to Downloads" />
                </li>
            </ul>
        </form>    
-->

    </div>
</div>