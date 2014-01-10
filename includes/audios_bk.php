<?php 
@$_SESSION['vot_cat']=1;
$cat_id = ((isset($_REQUEST['cid'])&&($_REQUEST['cid']!=''))?' AND c.cat_id='.$_REQUEST['cid']:'');
if(isset($_REQUEST['bit'])){ include('redirector.php'); }
?>
<div class="full_width video_page featured">
	<?php if(!isset($_REQUEST['pr'])){?>
        <div class="left">
            <div class="full_width" id="audio_section">
                <h1><?php print($strHead);?></h1>
                <?php echo (($strContents!='')?'<p>'.$strContents.'</p>':'');?>
                <?php include('title_bar.php');?>
                <div class="full_width slider" id="listing_response">
                	<?php include('product_listing.php');?>
                </div>
            </div>
        </div>
        <div class="right">
            <h2><?php echo Categories;?></h2>
            <?php echo bottom_categories();?>
            <div class="full_width add"><img src="images/add.jpg" /></div>
        </div>
	<?php } else { ?>
        <div class="left">
			<?php
                mysql_query("UPDATE products SET pr_hits = (pr_hits + 1) WHERE pr_id = '".$_REQUEST['pr']."'");
                $Query = "SELECT pr.pr_id, pr_added_date, pr_modified_date, pr.status_id, pr.cat_id, pr.pr_hits, pr.is_home, pr.is_featured, pr.mem_id, pr.ptype_id, pl.*, prf.prf_thumb, prf.prf_file, prf.prf_preview, m.mem_fname FROM products AS pr LEFT OUTER JOIN members AS m ON pr.mem_id=m.mem_id LEFT OUTER JOIN pr_files AS prf ON pr.pr_id=prf.pr_id AND prf.is_default=1 LEFT OUTER JOIN products_ln AS pl ON pr.pr_id=pl.pr_id WHERE pr.status_id=1 AND pr.pr_id=".$_REQUEST['pr']." AND pl.lang_id=".$_SESSION['lang_id']." ";
                $count = mysql_num_rows(mysql_query($Query)); 
                $rs = mysql_query($Query);
                if($count>0){
					while($row=mysql_fetch_object($rs)){
						$imgPath = chkFileExists4($row->prf_thumb);
						$prf_file = returnName("prf_file", "pr_files", "pr_id", $row->pr_id.' AND is_default=1 ');
						$s_file_name = @pathinfo($row->prf_preview,PATHINFO_FILENAME);
						$s_file_ext  = @pathinfo($row->prf_preview,PATHINFO_EXTENSION);
						echo "<div class='top_title'><h1>".$row->pr_title."</h1></div>";
              ?>
                        <div class="" style="padding-top:10px;">
                            <div class="image img_right_left"><a href="rtsp://178.79.149.95/vod/videos/preview/<?php echo $s_file_ext;?>:<?php echo $s_file_name;?>" target="_blank"><img src="<?php echo $imgPath;?>" /></a></div>
                            
                            <div class="details" style="width:60%; padding-left:10px;">
                                <p class="by"><?php echo $row->pr_long_details;?></p>
                                <p class="by"><strong><?php echo Views;?></strong> <?php echo $row->pr_hits;?></p>
                                <p><strong><?php echo User_Ratings;?></strong></p>
                                <link rel="stylesheet" href="<?php print($siteRoot)?>jquery/jRating.jquery.css" type="text/css" />
                                <script type="text/javascript" src="<?php print($siteRoot)?>jquery/jRating.jquery.js"></script>
                                <?php include('user_rating.php');?>
                            </div>
                        </div>
                        <div class="clearfix"></div>

<a href="rstp://www.google.com/" id="hititt" target="_parent" > Testing </a>
<script>
	//document.getElementById("hititt").click();

	/*$(document).ready(function(){
		$('#hititt').trigger('click');
		alert('1');
	});
	$(document).ready(function(){
	   $('#hititt').click();
		alert('2');
	});*/
</script>

<a href="rtsp://178.79.149.95/vod/videos/preview/mp3:1_6860" target="_blank">Testing</a>
<form action="rtsp://178.79.149.95/vod/videos/preview/mp3:1_6860" method="post" id="submitThisForm">
	<input type="submit" value="clickme" />
</form>

                        <div class="image img_right_left" style="width:100%; float:left; padding-top:6px;">
                            <div class="rating_buttons">
                                <ul>
                                	<!--rtsp://178.79.149.95/vod/videos/preview/<?php echo $s_file_ext;?>:<?php echo $s_file_name;?>-->
                                    <?php if(isset($_SESSION["memID"])){?>
                                    
                                    
                                        <a href="" id="someData" onclick="chkvalue();" data="http://localhost/esol/2013/wap_portal2/code/includes/details.php?pr_id=1&consume=1&cat_id=1&prf_id=1&mpl_id=2&pat_id=2" title="<?php echo Preview;?>">Try</a>
                                        
                                        
										<?php include('file_full_view.php');?>
                                        <?php include('file_download.php');?>
                                    <?php } else {?>
                                        <?php include('not_logged_in.php');?>
                                    <?php }
/*var urll = "includes/details.php?pr_id=<?php echo $_REQUEST['pr']?>&consume=1&cat_id=<?php echo $_SESSION['vot_cat'];?>&prf_id=<?php echo returnName("prf_id", "pr_files", "pr_id", $row->pr_id);?>&mpl_id=<?php echo $mpl_id;?>&pat_id=<?php echo $pat_id;?>";*/
?>
                                    <div class="clearfix"></div>
                                </ul>
                            </div>    
                            <div class="clearfix"></div>
                        </div>
						<script language="javascript">
						function chkvalue(){
							
							alert('h1');
							alert( $("#someData").attr('data') );
							
							//jQuery.noConflict();
							//jQuery(document).ready( function($){
								//$("#someData").click(function() {
									//var url = "http://localhost/esol/2013/wap_portal2/code/includes/details.php";

									/*dAtA__ = 'id=1';
									url = "http://localhost/esol/2013/wap_portal2/code/includes/details.php";
									$.ajax({
										type: "POST",		
										url: url,		
										data: dAtA__,		
										success: function(data){
											alert( data );
										},		
										error: function () {
											alert("There was an error!");
										}
									});*/
	/*
								$(document).ready(function(){
										$.get("http://localhost/esol/2013/wap_portal2/code/includes/details.php", 
										{ d1:'1' },    
										function(data) {
											alert(data);
										}
									);
								});*/
			
							
							
/*							var err=false;
							alert('s1');
								$.ajax({
									type: "POST",
									url: "http://localhost/esol/2013/wap_portal2/code/includes/details.php?pr_id=1&consume=1&cat_id=1&prf_id=1&mpl_id=2&pat_id=2",
									success: function(data){
										alert( 'Success: ');
									},
									complete: function(data){
										alert( 'Compelete: ');
									},
									error: function(){
										 alert("Error");
										 err=false;
									}
								})
								.done(function( msg ) {
									alert( "Data Saved: " + msg );
									err=true;
								});
								//alert(err);
								$(document).ajaxComplete(function() {
								  $("#test1").click();
								});
*/															
						}


						/*var err=false;
						if($("#clk").click()){}
							var sucess=0;
                            $(document).ready(function(e) {
								$('#clk').click(function(e) {
									
									
									$.ajax({
                                        type: "POST",
                                        url: "http://localhost/esol/2013/wap_portal2/code/includes/details.php?pr_id=1&consume=1&cat_id=1&prf_id=1&mpl_id=2&pat_id=2",
                                        success: function(data){
                                            alert( 'Success: ');
                                        },
                                        complete: function(data){
                                            alert( 'Compelete: ');
                                        },
                                        error: function(){
											 alert("Error");
                                        }
                                    })
                                    .done(function( msg ) {
										alert( "Data Saved: " + msg );
										
                                    });
									//alert( err );
								});
                            });*/
                        </script>

                        <div class="full_width">
                            <div id="msg_div" style="display:none;">
                                <div class="alert">
                                    <div class="close">x</div>
                                    <div class="alert_inner" align="center">
                                        <p id="msg"></p>
                                    </div>
                                </div>                        
                            </div>
                        </div>
                        <div class="clearfix"></div>

						<br />
                        <div class="rating_buttons">
                            <ul>
                                <?php if(isset($_SESSION["memID"])){?>
                                    <?php include('rating_buttons.php');?>
                                <?php } else {?>
                                    <?php include('not_logged_in.php');?>
                                <?php }?>
                                <div class="clearfix"></div>
                            </ul>
                        </div>    
                        <div class="clearfix"></div>

                        <div id="giftToFrndDiv" class="contact login">
                            <div class="form_area" style="width:100%;">
                                <?php include('gift_to_friend.php');?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <?php include('single_product.php');?>
			<?php
					}
				} else {
					echo No_Records;
				}
            ?>
        </div>
        <div class="right">
            <h2><?php echo Categories;?></h2>
            <?php echo bottom_categories();?>
            <div class="full_width add"><img src="images/add.jpg" /></div>
        </div>
	<?php } ?>
    <div class="clearfix"></div>
</div>
