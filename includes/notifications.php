<style>
	.regular-checkbox {
		display: none;
		width: 1em;
	}
	.regular-checkbox + label {
		background-color: #fafafa;
		border: 1px solid #cacece;
		box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px -15px 10px -12px rgba(0,0,0,0.05);
		padding: 9px;
		border-radius: 3px;
		display: inline-block;
		position: relative;
		width: 1em;
	}
	.regular-checkbox + label:active, .regular-checkbox:checked + label:active {
		box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px 1px 3px rgba(0,0,0,0.1);
		width: 1em;
	}
	.regular-checkbox:checked + label {
		background-color: #e9ecee;
		border: 1px solid #adb8c0;
		box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px -15px 10px -12px rgba(0,0,0,0.05), inset 15px 10px -12px rgba(255,255,255,0.1);
		color: #99a1a7;
		width: 1em;
	}
	.regular-checkbox:checked + label:after {
		content: '\2714';
		font-size: 14px;
		position: absolute;
		top: 0px;
		left: 10px;
		color: #99a1a7;
		width: 1em;
	}
</style>
<h1><?php print($strHead);?></h1>
<?php
$strMSG='';
if(isset($_REQUEST['notification_form'])){
	if(isset($_REQUEST['cat_id'])){
		mysql_query("DELETE FROM category_notifications WHERE mem_id=".$_SESSION["memID"]." ");
		for($i=0; $i<count($_REQUEST['cat_id']); $i++){
			mysql_query("INSERT INTO category_notifications (mem_id, cat_id) VALUES (".$_SESSION["memID"].", ".$_REQUEST['cat_id'][$i].")");
		}
	}
	else{
		mysql_query("DELETE FROM category_notifications WHERE mem_id=".$_SESSION["memID"]." ");
	}
	header("Location: ".$_SERVER['PHP_SELF']."?id=1");
}
if(isset($_REQUEST["op"])){
	switch ($_REQUEST["op"]) {
		case 1:
			$msg_class='msg_box msg_ok';
			$strMSG = "Notifications Updated Successfully!";
			break;
	}
}
?>
<div class="full_width news_contents">
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
	<form name="notification_form" method="post" action="<?php echo $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];?>">
        <fieldset style="border-radius:7px; border:solid 1px #ccc; box-shadow:0px 0px 6px rgba(0,0,0,0.10); ">
            <table width="100%" cellspacing="2" cellpadding="2">
                <tr> 
                <?php
                    $counter=0;
                    $Query1 = "SELECT c.*, ( SELECT cn.cat_id FROM category_notifications AS cn WHERE c.cat_id=cn.cat_id AND cn.mem_id=".$_SESSION["memID"]." ) AS selected_cat_id FROM categories AS c  WHERE c.status_id=1 AND cat_parentid=0  ORDER BY c.cat_name";
                    $total = mysql_num_rows(mysql_query($Query1)); 
                    $rs1 = mysql_query($Query1);
                    while($row1=mysql_fetch_object($rs1)){
                        $counter++;
                ?>
                        <td width="10%"><?php echo $row1->cat_name?></td> 
                        <td width="10%"><input type="checkbox" id="checkbox-2-1-<?php echo $row1->cat_id?>" class="regular-checkbox big-checkbox" name="cat_id[]" value="<?php echo $row1->cat_id?>" <?php echo (($row1->selected_cat_id!='')?"checked='checked'":'');?> /><label for="checkbox-2-1-<?php echo $row1->cat_id?>"></label></td>
                <?php
                        if($counter%2==0){echo '</tr>';}
                    }
                ?>
                </tr>
            </table>
        </fieldset>
        <div align="center" style="margin-top:10px;">
            <!--<?php //echo Dont_Want_Cat_Notify;?> <input type="checkbox" name="no_cat_id" value="1" /> &nbsp; &nbsp; -->
            <input type="submit" class="btn" name="notification_form" value="<?php echo Submit;?>" />
        </div>    
    </form>
</div>