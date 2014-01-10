<div id="slide_wrapper">
    <div id="slide_panel" class="wrapper">
        <div id="slide_content">
            <span id="slide_close"><img src="images/blank.gif" alt="" class="round_x16_b" /></span>

            <div class="cf">
                <div class="dp100 sortable"><p class="s_color tac sepH_a">You can drag widgets from dashboard and drop it here.</p></div>
            </div>

            <div class="row cf">
                <div class="dp75 taj">
                </div>
                <div class="dp25">
                    <div id="chart_k"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="top_bar">
    <div class="wrapper cf">
        <ul class="fl">
            <li class="sep">Welcome <span style="font-size:18px; font-weight:bold"><?php echo @$_SESSION["UserName"];?>!</span></li>
            <li class="sep"><a href="logout.php">Logout</a></li>
            <li><a href="../index.php" target="_blank">Visit Website</a></li>
        </ul>
    </div>
    </form>
</div>
<div id="header">
    <div class="wrapper cf">
        <div class="logo fl">
            <a href="index.php"><img src="images/logo.png" alt="" height="80" /></a>
        </div>
        <ul class="fr cf" id="main_nav">
            
            <li class="nav_item <?php echo (($pageName=='index')?'active':'');?>" title="Home">
            	<a href="index.php" class="main_link">
                	<img class="img_holder" style="background-image: url(images/icons/computer_imac.png)" alt="" src="images/blank.gif"/>
                    <span>Dashboard</span>
                </a>
                <?php echo $show_image;?>
            </li>
            <!--<li class="nav_item <?php echo (($pageName=='manage_members')?'active':'');?>" title="Manage Users">
            	<a href="manage_members.php" class="main_link">
                	<img class="img_holder" style="background-image: url(images/icons/users2.png)" alt="" src="images/blank.gif"/>
                    <span>Users</span>
                </a>
                <?php echo $show_image;?>
            </li>-->
            <li class="nav_item <?php echo (($pageName=='manage_admin_profile')?'active':'');?>" title="Admin Profile">
            	<a href="manage_admin_profile.php" class="main_link">
                	<img class="img_holder" style="background-image: url(images/icons/users2.png)" alt="" src="images/blank.gif"/>
                    <span>Profile</span>
                </a>
                <?php echo $show_image;?>
            </li>

        </ul>
    </div>
</div>