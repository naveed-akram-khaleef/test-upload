<?php 
@$_SESSION['vot_cat']=4;
$cat_id = ((isset($_REQUEST['cid'])&&($_REQUEST['cid']!=''))?' AND c.cat_id='.$_REQUEST['cid']:'');
if(isset($_REQUEST['bit'])){ include('redirector.php'); }
?>
<div class="full_width featured">
	<?php if(isset($_REQUEST['pr'])){?>
        <div class="left prod_left">
			<?php
				mysql_query("UPDATE products SET pr_hits = (pr_hits + 1) WHERE pr_id = '".$_REQUEST['pr']."'");
                $Query = "SELECT pr.pr_id, pr_added_date, pr_modified_date, pr.status_id, pr.cat_id, pr.pr_hits, pr.is_home, pr.is_featured, pr.mem_id, pr.ptype_id, pl.*, prf.prf_thumb, prf.prf_file, prf.prf_preview FROM products AS pr LEFT OUTER JOIN pr_files AS prf ON pr.pr_id=prf.pr_id LEFT OUTER JOIN products_ln AS pl ON pr.pr_id=pl.pr_id WHERE pr.status_id=1 AND pr.pr_id=".$_REQUEST['pr']." AND pl.lang_id=".$_SESSION['lang_id']." ";
				$count = mysql_num_rows(mysql_query($Query));
				$rs = mysql_query($Query);
				if($count>0){
					while($row=mysql_fetch_object($rs)){
                        $imgPath = chkFileExists5($row->prf_thumb);
                        $prf_file = $row->prf_file;
            ?>
            			<img src="<?php echo $imgPath;?>" style="visibility:hidden; display:none;" />
                        <div class="detail_image" style="background-image:url('<?php echo $imgPath;?>');">
                            <div class="float_right">
								<?php if($gf_limit==0){?>
                                    <img title="<?php echo Purchase_Package;?>" src="images/icons/gift_icon_gray.png" />
                                <?php
                                    } else {
                                ?>
                                    <a href="javascript:void(0);" title="<?php echo Gift_To_Friend;?>" onclick="giftToFriend(); triangle_position();"><img src="images/icons/gift_icon.png" /></a>
                                <?php }?>
                            </div>
                        	<div class="float_right">
                            	<?php if(isset($_SESSION["memID"])){?>
                                    <a href="javascript:void(0);" title="<?php echo Add_To_Wishlist;?>" onclick="addToMyCollection();"><img src="images/icons/like_icon.png" /></a>
                                <?php } else { ?>
                                    <img title="<?php echo Login_To_Use_This_Service;?>" src="images/icons/like_icon_gray.png" />
                                <?php } ?>    
                            </div>
                            <div class="opcasy">
                                <div class="float_left" >
									<?php if($st_limit==0){?>
                                    	<img title="<?php echo Purchase_Package;?>" src="images/icons/full_view_icon_gray.png"/>
                                    <?php
                                        } else {
                                    ?>
                                            <?php if(($prf_file!='')&&(file_exists('files/products/file/'.$prf_file)==1)){?>
                                                <a title="<?php echo Full_View;?>" href="<?php echo $siteRoot;?>index.php?id=28&pr_id=<?php echo $_REQUEST['pr']?>&consume=1&cat_id=<?php echo $_SESSION['vot_cat'];?>&prf_id=<?php echo returnName("prf_id", "pr_files", "pr_id", $row->pr_id);?>&mpl_id=<?php echo $mpl_id;?>&pat_id=<?php echo $pat_id;?>"><img src="images/icons/full_view_icon.png" /></a>
                                            <?php } else {?>
                                                <img title="<?php echo File_Not_Exists;?>" src="images/icons/full_view_icon_gray.png"/>
                                            <?php }?>
                                    <?php }?>
                                </div>
								<?php if(isset($_SESSION["memID"])){?>
                                    <?php
                                        header('P3P: CP="NOI ADM DEV PSAi NAV OUR STP IND DEM"');
                                        $current_url  = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'].'?'.$_SERVER['QUERY_STRING'];
                                        $redirest_url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'].'?'.$_SERVER['QUERY_STRING'];
                                        require 'facebook_set_as_wallpaper/src/facebook.php';
                                        $facebook = new Facebook(array(
                                            'appId'  => '363366080411013',
                                            'secret' => '57ac59c176c4eb9560ade636bbd976ae',
                                            "cookie" => true,
                                            'fileUpload' => true
                                        ));
                                        $user = $facebook->getUser();
                                        if ($user) {
                                            if(isset($_REQUEST['logout'])){
                                                setcookie("363366080411013",'',time()-10);
                                                $facebook -> destroySession();
                                                header("Location: ".'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'].'?id='.$_REQUEST['id'].'&pr='.$_REQUEST['pr']);
                                            }
                                            $logoutUrl = $current_url.'&logout=1';
                                        } else {
                                            $loginUrl = $facebook->getLoginUrl();
                                        }
                                    ?>
                                    <?php if ($user): ?>
                                        <!--<div class="float_left"><a href="<?php echo $logoutUrl;?>" title="<?php echo Logout_From_Facebook;?>"><img src="images/icons/login_icon.png" /></a></div>-->
                                        <?php if($st_limit==0){?>
                                            <img title="<?php echo Purchase_Package;?>" src="images/icons/set_as_wallpaper_gray.png.png" />
                                            <?php
                                                } else {
                                                    if(($prf_file!='')&&(file_exists('files/products/file/'.$prf_file)==1)){
                                            ?>
                                                        <?php
                                                            $Query1 = "SELECT pt.*, prf.* FROM pr_types AS pt LEFT OUTER JOIN pr_files AS prf ON pt.ptype_id=prf.ptype_id WHERE pt.cat_id=".$_SESSION['vot_cat']." AND prf.pr_id=".$row->pr_id." LIMIT 1 ";
                                                            $count1 = mysql_num_rows(mysql_query($Query1)); 
                                                            $rs1 = mysql_query($Query1);
                                                            while($row1=mysql_fetch_object($rs1)){
                                                        ?>
                                                                <div class="float_left"><a title="<?php echo Set_As_Facebook_Wallpaper;?>" href="<?php echo $siteRoot;?>index.php?id=26&pr_id=<?php echo $_REQUEST['pr']?>&consume=2&cat_id=<?php echo $_SESSION['vot_cat'];?>&prf_id=<?php echo $row1->prf_id;?>&mpl_id=<?php echo $mpl_id;?>&pat_id=<?php echo $pat_id;?>"><img src="images/icons/set_as_wallpaper.png" /></a></div>
                                                        <?php
                                                            }
                                                        ?>
                                                    <?php } else {?>
                                                        <div class="float_left"><img title="<?php echo File_Not_Exists;?>" src="images/icons/set_as_wallpaper_gray.png" /></div>
                                                    <?php }?>
                                        <?php } ?>
                                    <?php else: ?>
                                        <?php
                                            $params = array(
                                                'scope' => 'offline_access,read_friendlists,read_insights,read_mailbox,read_requests,read_stream,xmpp_login,user_online_presence,friends_online_presence,ads_management,create_event,manage_friendlists,manage_notifications,publish_actions,publish_stream,rsvp_event,user_photos,photo_upload,user_videos,manage_pages,user_status,friends_likes',
                                                'redirect_uri' => $redirest_url
                                            );
                                            $loginUrl = $facebook->getLoginUrl($params);
                                        ?>
                                        <div class="float_left"><a href="<?php echo $loginUrl;?>" title="<?php echo Login_With_Facebook;?>"><img src="images/icons/set_as_wallpaper_gray.png" /></a></div>
                                    <?php endif ?>
                                <?php } else {?>
                                    <div class="float_left"><img title="<?php echo Login_To_Use_This_Service;?>" src="images/icons/set_as_wallpaper_gray.png" /></div>
                                <?php }?>
                                <div class="float_left">
                                    <?php if(($row->prf_thumb!='')&&(file_exists('files/products/img/'.$row->prf_thumb)==1)){?>
                                        <!--<a href="includes/share_on_facebook.php?pr=<?php echo $_REQUEST['pr'];?>" target="_blank" title="share on facebook">
                                            <img src="images/icons/share.png" alt='share on facebook' />
                                        </a>-->
                                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $_SESSION['site_root']."index.php?id=".$_REQUEST['id']."&pr=".$_REQUEST['pr'];?>" target="_blank" title="share on facebook">
                                            <img src="images/icons/share.png" alt='share on facebook' />
                                        </a>
                                    <?php } else { ?>
                                            <img src="images/icons/share_gray.png" title="<?php echo File_Not_Exists;?>" alt='<?php echo File_Not_Exists;?>' />
                                    <?php }?>
                                </div>
                                <div class="float_bottom_right">
									<?php if($dw_limit==0){?>
                                        <img title="<?php echo Purchase_Package;?>" src="images/icons/download_icon_gray.png" />
                                    <?php
                                        } else {
                                            if(($prf_file!='')&&(file_exists('files/products/file/'.$prf_file)==1)){
                                    ?>
                                               <a href="<?php echo $siteRoot;?>includes/downloads.php?pr_id=<?php echo $_REQUEST['pr']?>&consume=2&cat_id=<?php echo $_SESSION['vot_cat'];?>&prf_id=<?php echo returnName("prf_id", "pr_files", "pr_id", $row->pr_id);?>&mpl_id=<?php echo $mpl_id;?>&pat_id=<?php echo $pat_id;?>"><img src="images/icons/download_icon.png" /></a>
                                    <?php
                                            }
                                            else {
                                    ?>
                                                <img title="<?php echo File_Not_Exists;?>" src="images/icons/download_icon_gray.png" />
                                    <?php
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class='top_title'><h1><?php echo $row->pr_title;?></h1></div>
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


        <div class="right prod_right">
            <h2><?php echo Categories;?></h2>
            <?php echo bottom_categories();?>
        </div>
	<?php } elseif(isset($_REQUEST['cid'])){?>
        <div class="left" style="width:100%;">
            <div class="full_width" id="audio_section">
                <h1><?php print($strHead);?></h1>
                <?php echo (($strContents!='')?'<p>'.$strContents.'</p>':'');?>
                <?php include('title_bar.php');?>
                <div class="full_width slider" id="listing_response">
                	<?php include('product_listing.php');?>
                </div>
            </div>
        </div>
	<?php } else if(!isset($_REQUEST['pr'])){?>
        <div class="left" style="width:100%;">
            <div class="full_width" id="audio_section">
                <h1><?php print($strHead);?></h1>
                <?php echo (($strContents!='')?'<p>'.$strContents.'</p>':'');?>
                <div class="full_width">
                	<?php
						$Query =mysql_query("SELECT c.cat_id, cl.cat_name FROM categories AS c LEFT OUTER JOIN categories_ln AS cl ON c.cat_id=cl.cat_id WHERE c.status_id=1  AND c.cat_parentid=".$_SESSION['vot_cat']." AND cl.lang_id=".$_SESSION['lang_id']." ORDER BY cl.cat_name ASC");
						$count = mysql_num_rows($Query);
						if($count>0){
							while($row=mysql_fetch_object($Query)){
					?>
                            <div class="full_width" id="audio_section_<?php echo $row->cat_id;?>">
                                <div class="title_bar">
                                    <div class="left"><a href="index.php?id=<?php echo $page_id;?>&cid=<?php echo $row->cat_id;?>"><?php echo $row->cat_name;?></a></div>
                                    <div class="right">
                                        <ul>
                                            <li class="selected" data-contents=".new_arrivals"><?php echo New_Items;?></li>
                                            <li data-contents=".top_rated"><?php echo Top_Rated;?></li>
                                            <li data-contents=".top_viewed"><?php echo Most_Viewed;?></li>
                                            <li data-contents=".featured"><?php echo Featured;?></li>
											<?php if(isset($_SESSION["memID"])){?><li><a href="index.php?id=15"><?php echo My_Wishlist;?></a></li><?php }?>
                                        </ul>
                                    </div>
                                </div>
                                <div class="full_width slider">
                                    <?php echo home_products2($row->cat_id, $_SESSION['vot_cat'], 4, '', $page_id, $_SESSION['lang_id']);?>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="full_width data" style="display:none;">
                                    <div class="full_width new_arrivals">
                                        <?php echo home_products2($row->cat_id, $_SESSION['vot_cat'], 4, 'na', $page_id, $_SESSION['lang_id']);?>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="full_width top_rated">
                                        <?php echo home_products2($row->cat_id, $_SESSION['vot_cat'], 4, 'tr', $page_id, $_SESSION['lang_id']);?>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="full_width top_viewed">
                                        <?php echo home_products2($row->cat_id, $_SESSION['vot_cat'], 4, 'mv', $page_id, $_SESSION['lang_id']);?>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="full_width featured">
                                        <?php echo home_products2($row->cat_id, $_SESSION['vot_cat'], 4, 'fr', $page_id, $_SESSION['lang_id']);?>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                    <?php
							}
						}
					?>
                </div>
            </div>
        </div>
	<?php }?>
    <div class="clearfix"></div>
</div>
