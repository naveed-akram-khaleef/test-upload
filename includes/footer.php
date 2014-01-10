<script language="javascript">
	function show_records(sorting_val){
		if(sorting_val=='na'){
			$("#na").addClass('selected');
			$("#tr").removeClass('selected');
			$("#mv").removeClass('selected');
			$("#fr").removeClass('selected');
		}else if(sorting_val=='tr'){
			$("#tr").addClass('selected');
			$("#na").removeClass('selected');
			$("#mv").removeClass('selected');
			$("#fr").removeClass('selected');
		}else if(sorting_val=='mv'){
			$("#mv").addClass('selected');
			$("#na").removeClass('selected');
			$("#tr").removeClass('selected');
			$("#fr").removeClass('selected');
		}else if(sorting_val=='fr'){
			$("#fr").addClass('selected');
			$("#na").removeClass('selected');
			$("#mv").removeClass('selected');
			$("#tr").removeClass('selected');
		}
		var url = "site_services.php?listing_response_div=1&sorting="+sorting_val+"&id="+'<?php echo $_REQUEST['id']?>'+"&cid="+'<?php echo ((isset($_REQUEST['cid'])?$_REQUEST['cid']:''));?>';
		$.ajax({
			type: "POST",
			url: url,
			beforeSend: function(){
				$('#listing_response').html('<img src="images/loading.gif" style="max-width:150px; max-height:150px;" />');
			},
			success: function(data){
				$('#listing_response').html('<img src="images/loading.gif" style="max-width:150px; max-height:150px;" />');
				$('#listing_response').html( data );
			},
			error: function () {
				$('#listing_response').html('');
				alert("There was an error!");
			}
		});
	}
	var rating=0;
	function getVal(val){
		rating = val;
	}
	function starVote(val){
		rating = val;
		saveVoting();
	}
	function saveVoting() {
		$(document).ready(function(){
			var pid='<?php echo ((isset($_REQUEST['pr'])?$_REQUEST["pr"]:''));?>';
			var sid='<?php echo $_SESSION['vot_cat'];?>';
			if(rating != 0){
				$.get("site_services.php?vote=1", 
				{ rate:rating, pid:pid, sid:sid },    
				function(data) {
					var receivedData = data.split(',');
					if($.trim(receivedData[0].toString()) == "error"){
						alert(receivedData[1]);
					}
					else {
						$("#serverResponse1").html(receivedData[0]+' vote(s) ');
						$("#serverResponse2").html('Average: '+receivedData[1]);
						$("#serverResponse3").html('Average: '+receivedData[1]+' of ');
						$("#serverResponse4").html(receivedData[0]+' rate ');
						$("#already_voted").html('<span>You rated: <b>'+receivedData[2]+'</b><span>');
					}
				}
				);
			}
		});
	}
	function addToMyCollection() {
		$(document).ready(function(){
			var pid='<?php echo ((isset($_REQUEST['pr'])?$_REQUEST["pr"]:''));?>';
			$.get("site_services.php?add_to_collection=1",
			{ pid:pid, cid:'<?php echo $_SESSION['vot_cat'];?>' },
			function(data) {
				var receivedData = data.split(',');
					if(receivedData[0]==1){
						$("#msg").html(receivedData[1]);
						$("#msg_div").attr('style','display:block; visibility:visible;');
						$("#msg_div").show();
					} else {
						$("#msg").html(receivedData[1]);
						$("#msg_div").attr('style','display:block; visibility:visible;');
						$("#msg_div").show();
					}
				}
			);
		});
	}
	<?php if(isset($_REQUEST['pr'])){?>
	document.getElementById('giftToFrndDiv').style.display='none';
	function giftToFriend(){
		$("#giftToFrndDiv").slideToggle();
	}
	<?php }?>
	$(document).ready(function(){
		$("#giftToFrnd").validate({
			submitHandler: function(form) {
			var url = "<?php print($siteRoot)?>site_services.php?pid="+'<?php echo ((isset($_REQUEST['pr'])?$_REQUEST["pr"]:''));?>';
			$.ajax({
				type: "POST",
				url: url,
				data: $("#giftToFrnd").serialize(),
				success: function(data){
					var receivedData = data.split(',');
					if(receivedData[0]==1){
						$("#msg").html(receivedData[1]);
						$("#msg_div").attr('style','display:block; visibility:visible;');
						$("#msg_div").show();
						$("#giftToFrndDiv").hide();
					} 
					else {
						$("#msg").html(receivedData[1]);
						$("#msg_div").attr('style','display:block; visibility:visible;');
						$("#msg_div").show();
					}
				}
			});
			return false;
			}
		});
	});
	function chkSubscriber(){
		$("#newsletterForm").validate({
			submitHandler: function(form) {
				var url = "<?php print($siteRoot)?>site_services.php";
				$.ajax({
					 type: "POST",
					 url: url,
					 data: $("#newsletterForm").serialize(),
					 success: function(data){
						var receivedData = data.split(',');
						if(receivedData[0]==1){
							$("#msg").html(receivedData[1]);
							$("#msg_div").attr('style','display:block; visibility:visible;');
							$("#msg_div").show();
							$("#newsletterFormDiv").hide();
							setTimeout(function() {
								window.location.href = "index.php?id=1";
							}, 2000);
						} else {
							$("#msg").html(receivedData[1]);
							$("#msg_div").attr('style','display:block; visibility:visible;');
							$("#msg_div").show();
						}
					 }
				});
			return false;
			}
		});
	}
</script>
<div id="footer">
    <div id="msg_div" style="display:none;">
        <div class="alert">
            <div class="close">x</div>
            <div class="alert_inner" align="center">
                <p id="msg"></p>
            </div>
        </div>                        
    </div>
    <div id="newsletterFormDiv" class="register">
        <form method="post" id="newsletterForm">
            <div class="left">
                <p>
					<?php
						$footer_cnt=0;
                        $nResult1=mysql_query("SELECT m.menu_id, m.cnt_id, m.mtype_id, m.menu_parent_id, m.menu_bg, m.status_id, m.menu_link, m.menu_show, m.menu_order, ml.* FROM menu AS m LEFT OUTER JOIN menu_ln AS ml ON m.menu_id=ml.menu_id WHERE m.menu_parent_id=0 AND m.status_id=1 AND m.menu_link=1 AND m.mtype_id IN (0,5) AND ml.lang_id=".$_SESSION['lang_id']." ORDER BY m.menu_order ASC");
						$footer_total = mysql_num_rows($nResult1);
                        while($row=mysql_fetch_object($nResult1)){
							$footer_cnt++;
                    ?>
                          <a href="<?php print("index.php?id=".$row->menu_id);?>"><?php print($row->menu_title);?></a>
                          <?php if($footer_cnt!=$footer_total){echo '&nbsp;|&nbsp;';}?>
                          
                    <?php
                        }
                    ?>
                </p>
                <ul>
                    <li><?php echo Newsletter_Signup;?></li>
                    <li class="search_area">
                      <input type="text" placeholder="<?php echo Enter_Email;?>" class="input required email search_bar" name="sub_email" />
                      <input class="go_btn" type="submit" name="newsletterForm" value="" onclick="javascript: chkSubscriber();" />
                    </li>
                </ul>
            </div>
        </form>
    </div>        
    <div class="right">
        <ul>
          <li>
            <?php
              $Qry = mysql_query("SELECT * FROM social_links WHERE status_id=1");
              if(mysql_num_rows($Qry)>0){
                while ($row=mysql_fetch_object($Qry)){
            ?>
                  <a href="<?php echo $row->link_url;?>"><img src="images/socials/<?php echo $row->link_file;?>" title="<?php echo $row->link_title;?>" /></a>
            <?php			
                }
              }
            ?>	
          </li> 
          <li><?php echo Copyright;?> ©  Wap Portal <?php echo date("Y");?> | <?php echo All_Rights;?></li> 
        </ul>
    </div>
    <div class="clearfix"></div>
</div>
