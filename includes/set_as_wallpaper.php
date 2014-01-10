<div class="full_width">
	<?php
        echo $Query = "SELECT prf.*, pl.pr_title, pt.ptype_value, pt.cat_id FROM pr_files AS prf LEFT OUTER JOIN products_ln AS pl ON prf.pr_id=pl.pr_id AND pl.lang_id=".$_SESSION['lang_id']." LEFT OUTER JOIN pr_types AS pt ON prf.ptype_id=pt.ptype_id WHERE prf.prf_id=".$_REQUEST['prf_id']." AND prf.pr_id=".$_REQUEST['pr_id']." LIMIT 1";
        $rs = mysql_query($Query);
        $count = mysql_num_rows(mysql_query($Query)); 
		if($count>0){
            while($row=mysql_fetch_object($rs)){
    ?>
            <p><h1> <?php echo $row->pr_title.' ';?> </h1> <?php echo $row->ptype_value; ?></p>
            <div style="overflow-x:scroll; overflow-y:scroll; height:auto; width:954px;">
                <?php 
                    $cat = $row->cat_id;
                    if($cat==1){
                ?>
                    <div class="clearfix"></div>
                    <br clear="all" />
                    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
                    <script type="text/javascript" src="<?php echo $siteRoot;?>js/player/js/demo.js"></script>
                    <script type="text/javascript" src="<?php echo $siteRoot;?>js/player/js/jquery.jplayer.min.js"></script>
                    <script type="text/javascript" src="<?php echo $siteRoot;?>js/player/js/jplayer.playlist.min.js"></script>
                    <script type="text/javascript">
                    //<![CDATA[
                    $(document).ready(function(){
                        new jPlayerPlaylist({
                            jPlayer: "#jquery_jplayer_1",
                            cssSelectorAncestor: "#jp_container_1"
                        }, [
                            {
                                mp3:"<?php echo $siteRoot;?>files/products/file/<?php echo $row->prf_file;?>",
                                m4a:"<?php echo $siteRoot;?>files/products/file/<?php echo $row->prf_file;?>",
                                ogg:"<?php echo $siteRoot;?>files/products/file/<?php echo $row->prf_file;?>",
                                oga:"<?php echo $siteRoot;?>files/products/file/<?php echo $row->prf_file;?>",
                                webma:"<?php echo $siteRoot;?>files/products/file/<?php echo $row->prf_file;?>",
                                wav:"<?php echo $siteRoot;?>files/products/file/<?php echo $row->prf_file;?>"
                            }
                        ], {
                            swfPath: "js",
                            supplied: "mp3, m4a, ogg, oga, webma, wav",
                            wmode: "window"
                        });
                    });
                    //]]>
                    </script>
                    <div id="skin-loader"></div>
                    <div id="skin-wrapper" data-skin-name="premium-pixels">
                        <div id="jquery_jplayer_1" class="jp-jplayer"></div>
                        <div id="jp_container_1" class="jp-audio">
                            <div class="jp-type-playlist">
                                <div class="jp-gui jp-interface">
                                    <ul class="jp-controls">
                                        <li><a href="javascript:;" class="jp-previous" tabindex="1">previous</a></li>
                                        <li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
                                        <li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
                                        <li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
                                        <li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
                                        <li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>
                                    </ul>
                                    <div class="jp-progress">
                                        <div class="jp-seek-bar">
                                            <div class="jp-play-bar"></div>
                                        </div>
                                    </div>
                                    <div class="jp-volume-bar">
                                        <div class="jp-volume-bar-value"></div>
                                    </div>
                                    <div class="jp-progress">
                                        <div class="jp-seek-bar">
                                            <div class="jp-play-bar"></div>
                                        </div>
                                    </div>
                                    <ul class="jp-toggles">
                                        <li><a href="javascript:;" class="jp-shuffle" tabindex="1" title="shuffle">shuffle</a></li>
                                        <li><a href="javascript:;" class="jp-shuffle-off" tabindex="1" title="shuffle off">shuffle off</a></li>
                                        <li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat">repeat</a></li>
                                        <li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off">repeat off</a></li>
                                    </ul>
                                </div>
                                <div class="jp-current-time"></div>
                                <div class="jp-duration"></div>
                                <div class="jp-playlist" style="display:none;">
                                    <ul>
                                        <li></li>
                                    </ul>
                                </div>
                                <div class="jp-no-solution">
                                    <span>Update Required</span>
                                    To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
                                </div>
                            </div>
                        </div>
                    </div>
                    <br clear="all" />
                    <div class="clearfix"></div>
                <?php		
                    } elseif($cat==2){
                ?>
                    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
                    <link href="<?php echo $siteRoot;?>js/skin/blue.monday/jplayer.blue.monday.css" rel="stylesheet" type="text/css" />
                    <script type="text/javascript" src="<?php print($siteRoot)?>js/js/jquery.jplayer.min.js"></script>
                    <script type="text/javascript">
                        //<![CDATA[
                        $(document).ready(function () {
                            $("#jquery_jplayer_1").jPlayer({
                                ready: function(event) {
                                    $(this).jPlayer("setMedia", {
                                        flv: "<?php echo $siteRoot;?>files/products/file/<?php echo @$row->prf_file;?>",
                                        mp4: "<?php echo $siteRoot;?>files/products/file/<?php echo @$row->prf_file;?>",
                                        m4v: "<?php echo $siteRoot;?>files/products/file/<?php echo @$row->prf_file;?>",
                                        ogv: "<?php echo $siteRoot;?>files/products/file/<?php echo @$row->prf_file;?>",
                                        webm: "<?php echo $siteRoot;?>files/products/file/<?php echo @$row->prf_file;?>",
                                        webmv: "<?php echo $siteRoot;?>files/products/file/<?php echo @$row->prf_file;?>",
                                        poster: "<?php echo $siteRoot;?>files/products/file/<?php echo @$row->prf_thumb;?>"
                                    });
                                },
                                swfPath: "<?php echo $siteRoot;?>js/js/Jplayer.swf",
                                supplied: "flv, mp4, m4v, ogv, webm, webmv",
                                size: {
                                    width: "100%",
                                    height: "50%"
                                }
                            });
                        });
                        //]]>
                    </script>
                    <div id="jp_container_1" class="jp-video">
                        <div class="jp-type-single">
                            <div id="jquery_jplayer_1" class="jp-jplayer"></div>
                            <div class="jp-gui">
                                <div class="jp-interface">
                                    <div class="jp-progress">
                                        <div class="jp-seek-bar">
                                            <div class="jp-play-bar"></div>
                                        </div>
                                    </div>
                                    <div class="jp-current-time"></div>
                                    <div class="jp-duration"></div>
                                    <div class="jp-controls-holder">
                                        <ul class="jp-controls">
                                            <li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
                                            <li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
                                            <li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>
                                        </ul>
                                        <div class="jp-volume-bar">
                                            <div class="jp-volume-bar-value"></div>
                                        </div>
                                    </div>
                                    <div class="jp-title">
                                    </div>
                                </div>
                            </div>
                            <div class="jp-no-solution">
                                <span>Update Required</span>
                                To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <br clear="all" />
                <?php		
                    } elseif($cat==3){
                ?>
                    <div class="clearfix"></div>
                    <br clear="all" />
                    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
                    <script type="text/javascript" src="<?php echo $siteRoot;?>js/player/js/demo.js"></script>
                    <script type="text/javascript" src="<?php echo $siteRoot;?>js/player/js/jquery.jplayer.min.js"></script>
                    <script type="text/javascript" src="<?php echo $siteRoot;?>js/player/js/jplayer.playlist.min.js"></script>
                    <script type="text/javascript">
                    //<![CDATA[
                    $(document).ready(function(){
                        new jPlayerPlaylist({
                            jPlayer: "#jquery_jplayer_1",
                            cssSelectorAncestor: "#jp_container_1"
                        }, [
                            {
                                mp3:"<?php echo $siteRoot;?>files/products/file/<?php echo $row->prf_file;?>",
                                m4a:"<?php echo $siteRoot;?>files/products/file/<?php echo $row->prf_file;?>",
                                ogg:"<?php echo $siteRoot;?>files/products/file/<?php echo $row->prf_file;?>",
                                oga:"<?php echo $siteRoot;?>files/products/file/<?php echo $row->prf_file;?>",
                                webma:"<?php echo $siteRoot;?>files/products/file/<?php echo $row->prf_file;?>",
                                wav:"<?php echo $siteRoot;?>files/products/file/<?php echo $row->prf_file;?>"
                            }
                        ], {
                            swfPath: "js",
                            supplied: "mp3, m4a, ogg, oga, webma, wav",
                            wmode: "window"
                        });
                    });
                    //]]>
                    </script>
                    <div id="skin-loader"></div>
                    <div id="skin-wrapper" data-skin-name="premium-pixels">
                        <div id="jquery_jplayer_1" class="jp-jplayer"></div>
                        <div id="jp_container_1" class="jp-audio">
                            <div class="jp-type-playlist">
                                <div class="jp-gui jp-interface">
                                    <ul class="jp-controls">
                                        <li><a href="javascript:;" class="jp-previous" tabindex="1">previous</a></li>
                                        <li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
                                        <li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
                                        <li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
                                        <li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
                                        <li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>
                                    </ul>
                                    <div class="jp-progress">
                                        <div class="jp-seek-bar">
                                            <div class="jp-play-bar"></div>
                                        </div>
                                    </div>
                                    <div class="jp-volume-bar">
                                        <div class="jp-volume-bar-value"></div>
                                    </div>
                                    <div class="jp-progress">
                                        <div class="jp-seek-bar">
                                            <div class="jp-play-bar"></div>
                                        </div>
                                    </div>
                                    <ul class="jp-toggles">
                                        <li><a href="javascript:;" class="jp-shuffle" tabindex="1" title="shuffle">shuffle</a></li>
                                        <li><a href="javascript:;" class="jp-shuffle-off" tabindex="1" title="shuffle off">shuffle off</a></li>
                                        <li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat">repeat</a></li>
                                        <li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off">repeat off</a></li>
                                    </ul>
                                </div>
                                <div class="jp-current-time"></div>
                                <div class="jp-duration"></div>
                                <div class="jp-playlist" style="display:none;">
                                    <ul>
                                        <li></li>
                                    </ul>
                                </div>
                                <div class="jp-no-solution">
                                    <span>Update Required</span>
                                    To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
                                </div>
                            </div>
                        </div>
                    </div>
                    <br clear="all" />
                    <div class="clearfix"></div>
                <?php		
                    } elseif($cat==4){
                ?>
                    <img src="files/products/file/<?php print($row->prf_file);?>" alt="" style="max-width:none;"  />
                    <?php
                        header('P3P: CP="NOI ADM DEV PSAi NAV OUR STP IND DEM"');
                        require 'includes/facebook_set_as_wallpaper/src/facebook.php';
                        $facebook = new Facebook(array(
                            'appId'  => '363366080411013',
                            'secret' => '57ac59c176c4eb9560ade636bbd976ae',
                            "cookie" => true,
                            'fileUpload' => true
                        ));
                        $user = $facebook->getUser();
                    ?>
                    <?php
                        $facebook->setFileUploadSupport(true);
                        if ($user){
                            $facebook->setFileUploadSupport(true);
                            $user_id = $facebook->getUser();
                            
                            $albums = $facebook->api("/me/albums"); 
                            $album_id = ""; 
                            foreach($albums["data"] as $item)
                            { 
                                if($item["type"] == "profile")
                                { 
                                    echo $album_id = $item["id"]; 
                                    break; 
                                }
                            }
                            $full_image_path = realpath("files/products/file/".$row->prf_file);
                            $random_number = substr(number_format(time() * rand(),0,'',''),0,8);
                            $args = array('message' => 'Uploaded by Umar Ayaz, with some random number to make this post unique '.$random_number); 
                            $args['image'] = '@' . $full_image_path;   
                            $data = $facebook->api("/{$album_id}/photos", 'post', $args); 
                            $pictue = $facebook->api('/'.$data['id']);   
                            $fb_image_link = $pictue['link']."&makeprofile=1";
                            echo "<script type='text/javascript'>top.location.href = '$fb_image_link';</script>";
                        }
                    ?>
                <?php		
                    }
                ?>
            </div>
            <?php
                $MaxID = getMaximum("my_consumption","myc_id");
                mysql_query("INSERT INTO my_consumption (myc_id, pr_id, mem_id, myc_added_date, cat_id, consume_type) VALUES (".$MaxID.", ".$_REQUEST['pr_id'].", ".$_SESSION["memID"].", NOW(), ".$_REQUEST['cat_id'].", '1')");
        
				if($_REQUEST['pat_id']==1){
					mysql_query("UPDATE mem_pak_limits SET mem_pak_downloads_con = (mem_pak_downloads_con + 1) WHERE mem_id = ".$_SESSION["memID"]." AND mpl_id=".$_REQUEST['mpl_id']." AND mem_pak_isexpired=0 ");
					mysql_query("UPDATE my_package_history SET mem_pak_downloads_con = (mem_pak_downloads_con + 1) WHERE mem_id = ".$_SESSION["memID"]." AND mpl_id=".$_REQUEST['mpl_id']." AND mem_pak_isexpired=0 ");
				}
				elseif($_REQUEST['pat_id']==2){
					mysql_query("UPDATE mem_pak_limits SET mem_pak_credits = (mem_pak_credits - 2) WHERE mem_id = ".$_SESSION["memID"]." AND mpl_id=".$_REQUEST['mpl_id']." AND mem_pak_isexpired=0 ");
					mysql_query("UPDATE my_package_history SET mem_pak_credits = (mem_pak_credits - 2) WHERE mem_id = ".$_SESSION["memID"]." AND mpl_id=".$_REQUEST['mpl_id']." AND mem_pak_isexpired=0 ");
				}
            ?>
	<?php
			}
		}
    ?>
  <div class="clearfix"></div>
</div>