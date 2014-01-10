<?php
	$pageName = basename($_SERVER["PHP_SELF"]);
	$posName = strpos($pageName, '.php');
	$pageName = (substr($pageName, 0, $posName));
	$p = $pageName;
	$c = 'active';
?>
<div id="sidebar">
    <div class="micro">
        <form id="language" method="post">
            <div class="wrapper cf">
                Language: 
                <select name="lang_id" onchange="javascript: document.getElementById('language').submit();">
                    <?php echo FillSelected("language", "lang_id", "lang_name", @$_SESSION['lang_id']); ?>
                </select>
            </div>
        </form>
    </div><br />
  <div class="micro">
    <h4><span>HOME</span></h4>
    <ul class="sub_section cf" style="display:none">
      <li class="<?php echo ($p=='manage_content')?$c:'';?>"><a href="manage_content.php" title="Manage Contents">Contents</a></li>
      <li class="<?php echo ($p=='manage_banners')?$c:'';?>"><a href="manage_banners.php" title="Manage Contents">Banners</a></li>
      <li class="<?php echo ($p=='manage_menu')?$c:'';?>"><a href="manage_menu.php" title="Manage Menu">Menu</a></li>
      <li class="<?php echo ($p=='manage_subscribers')?$c:'';?>"><a href="manage_subscribers.php" title="Manage Subscribers">Subscribers</a></li>
      <li class="<?php echo ($p=='manage_contacts')?$c:'';?>"><a href="manage_contacts.php" title="Manage Feedback">Feedback</a></li>
      <li class="<?php echo ($p=='manage_news')?$c:'';?>"><a href="manage_news.php" title="Manage News">News</a></li>
      <li class="<?php echo ($p=='manage_newsletters')?$c:'';?>"><a href="manage_newsletters.php" title="Manage Newsletters">Newsletters</a></li>
      <li class="<?php echo ($p=='manage_social_networks')?$c:'';?>"><a href="manage_social_networks.php" title="Manage Social Networks">Social Networks</a></li>
      <li class="<?php echo ($p=='manage_faq')?$c:'';?>"><a href="manage_faq.php" title="Manage FAQ">FAQs</a></li>
    </ul>
  </div>
  <div class="micro">
    <h4><span>MODULES</span></h4>
    <ul class="sub_section cf" style="display:none">
      <li class="<?php echo ($p=='manage_categories')?$c:'';?>"><a href="manage_categories.php" title="Manage Categories">Categories</a></li>
      <li class="<?php echo ($p=='manage_product_types')?$c:'';?>"><a href="manage_product_types.php" title="Manage Product Types">Formats</a></li>
      <li class="<?php echo ($p=='manage_audio_tracks')?$c:'';?>"><a href="manage_audio_tracks.php" title="Manage Audio Tracks">Audio Tracks</a></li>
      <li class="<?php echo ($p=='manage_movies')?$c:'';?>"><a href="manage_movies.php" title="Manage Movies">Movies</a></li>
      <li class="<?php echo ($p=='manage_ringtones')?$c:'';?>"><a href="manage_ringtones.php" title="Manage Ringtones">Ringtones</a></li>
      <li class="<?php echo ($p=='manage_wallpapers')?$c:'';?>"><a href="manage_wallpapers.php" title="Manage Wallpapers">Wallpapers</a></li>
    </ul>
  </div>
  <div class="micro">
    <h4><span>MEMBERS</span></h4>
    <ul class="sub_section cf" style="display:none">
        <li class="<?php echo ($p=='manage_members' || $p=='manage_user_profile')?$c:'';?>"><a href="manage_members.php" title="Manage Members">Members</a></li>
    </ul>
  </div>
  <div class="micro">
    <h4><span>PACKAGES</span></h4>
    <ul class="sub_section cf" style="display:none">
      <li class="<?php echo ($p=='manage_shortcodes')?$c:'';?>"><a href="manage_shortcodes.php" title="Manage Short Codes">Short Codes</a></li>
      <!--<li class="<?php //echo ($p=='manage_pack_limits')?$c:'';?>"><a href="manage_pack_limits.php" title="Manage Package Limits">Package Limits</a></li>-->
      <!--<li class="<?php //echo ($p=='manage_topups')?$c:'';?>"><a href="manage_topups.php" title="Manage Top UPs">Top UPs</a></li>-->
      <li class="<?php echo ($p=='manage_packages')?$c:'';?>"><a href="manage_packages.php" title="Manage Packages">Packages</a></li>
    </ul>
  </div>
  <div class="micro">
    <h4><span>REPORTS</span></h4>
    <ul class="sub_section cf" style="display:none">
      <li class="<?php echo ($p=='manage_subscriptions')?$c:'';?>"><a href="manage_subscriptions.php" title="Subscription Reports">Subscriptions</a></li>
      <li class="<?php echo ($p=='manage_downloads')?$c:'';?>"><a href="manage_downloads.php" title="Download Reports">Downloads</a></li>
      <li class="<?php echo ($p=='manage_streams')?$c:'';?>"><a href="manage_streams.php" title="Stream Reports">Streams</a></li>
    </ul>
  </div>
  <div class="micro">
    <h4><span>IMPORT</span></h4>
    <ul class="sub_section cf" style="display:none">
        <li class="<?php echo ($p=='data_importer')?$c:'';?>"><a href="data_importer.php" title="Import Data">Import Data</a></li>
    </ul>
  </div>
  <div class="micro">
    <h4><span>SETTINGS</span></h4>
    <ul class="sub_section cf" style="display:none">
        <li class="<?php echo $p=='site_config'?$c:'';?>"><a href="site_config.php" title="Website Configuration">Site Configuration</a></li>
<!--        <li class="<?php echo $p=='manage_site_variables'?$c:'';?>"><a href="manage_site_variables.php" title="Website Variables">Site Variables</a></li>
-->        <li class="<?php echo $p=='logout'?$c:'';?>"><a href="logout.php" title="Logout">Logout</a></li>
    </ul>
  </div>
</div>