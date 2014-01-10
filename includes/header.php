<div id="header">
    <div class="left"><img src="images/logo.png" alt="" /></div>
    <div class="right">
        <ul>
			<?php if(isset($_SESSION["memID"]) && ($_SESSION["memID"]!='')){?>
                <form action="<?php echo $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];?>" method="post" id="language" >
                <li><a href="includes/logout.php"><?php echo Logout;?></a> | 
                    <select name="lang_id" onchange="javascript: document.getElementById('language').submit();">
                        <?php echo FillSelected("language", "lang_id", "lang_name", @$_SESSION['lang_id']); ?>
                    </select>
                </li>
                </form>
            <?php } else {?>
                <form action="<?php echo $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];?>" method="post" id="language" >
                <li><a href="javascript: Void(0);" onclick="register();"><?php echo Register;?></a> | <a href="javascript: Void(0);" onclick="login();"><?php echo Login;?></a> | 
                    <select name="lang_id" onchange="javascript: document.getElementById('language').submit();">
                        <?php echo FillSelected("language", "lang_id", "lang_name", @$_SESSION['lang_id']); ?>
                    </select>
                </li>
                </form>
            <p class="phoneResponse"></p>
            <?php }?>
            <script>
				function login(){
					$(".phoneResponse").hide();
					$(document).ready(function(){
						$.get("includes/ph_login.php", 
							{ url:'<?php echo $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];?>' },
								function(data) {
									$(".phoneResponse").show();
									$(".phoneResponse").html(data);
								}
						);
					});
				}
				function register(){
					$(".phoneResponse").hide();
					$(document).ready(function(){
						$.get("includes/ph_register.php", 
							{ url:'<?php echo $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];?>' },
								function(data) {
									$(".phoneResponse").show();
									$(".phoneResponse").html(data);
								}
						);
					});
				}
			</script>
            <li class="search_area">
            	<form action="index.php?id=12" method="post" id="searchForm">
                    <input type="text" placeholder="<?php echo Enter_Keywords;?>" name="searchTerm" class="input search_bar" value="<?php echo ((isset($_REQUEST['searchTerm']))&&($_REQUEST['searchTerm']!='')?$_REQUEST['searchTerm']:'');?>" />
                    <input class="go_btn" type="submit" value="" onclick="javascript: document.getElementById('searchForm').submit();" />
                </form>
            </li>
        </ul>
    </div>
    <div class="clearfix"></div>
</div>
<?php
if(isset($_REQUEST['id'])){
	$page_id=$_REQUEST['id'];
} else {
	$page_id=0;
}
?>

<div class="mMenu2">
    <div style="margin-top:2px; width:100%; " align="right"> 
        <?php if(isset($_SESSION["memID"]) && ($_SESSION["memID"]!='')){?>
            <form action="<?php echo $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];?>" method="post" id="language2" >
                <a href="includes/logout.php"><?php echo Logout;?></a> | 
                <select name="lang_id" onchange="javascript: document.getElementById('language2').submit();">
                    <?php echo FillSelected("language", "lang_id", "lang_name", @$_SESSION['lang_id']); ?>
                </select>
            </form>
        <?php } else {?>
            <form action="<?php echo $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];?>" method="post" id="language2" >
            <a href="javascript: Void(0);" onclick="register2();"><?php echo Register;?></a> | <a href="javascript: Void(0);" onclick="login2();"><?php echo Login;?></a> | 
                <select name="lang_id" onchange="javascript: document.getElementById('language2').submit();">
                    <?php echo FillSelected("language", "lang_id", "lang_name", @$_SESSION['lang_id']); ?>
                </select>
            </form>
            <p class="phoneResponse2"></p>
        <?php }?>   
        <script>
            function login2(){
                $(".phoneResponse2").hide();
                $(document).ready(function(){
                    $.get("includes/ph_login.php", 
                        { url:'<?php echo $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];?>' },
                            function(data) {
                                $(".phoneResponse2").show();
                                $(".phoneResponse2").html(data);
                            }
                    );
                });
            }
            function register2(){
                $(".phoneResponse2").hide();
                $(document).ready(function(){
                    $.get("includes/ph_register.php", 
                        { url:'<?php echo $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];?>' },
                            function(data) {
                                $(".phoneResponse2").show();
                                $(".phoneResponse2").html(data);
                            }
                    );
                });
            }
        </script>
    </div>
</div>    
<div class="mMenu">
    <div class="left"><a href="<?php echo $siteRoot;?>"><img src="images/mLogo.png" alt="" /></a></div>
    <div class="right">
        <ul>
            <!--<li class="account">Category</li>-->
            <?php if(isset($_SESSION["memID"])){?><li class="mCat"><img src="images/user_icon.png" alt="" /></li><?php }?>
            <li class="mMenu_icon"><img src="images/menu_icon.png" alt="" /></li>
            <li class="mSearch_icon"><img src="images/mSearch_icon.png" alt="" /></li>
            <div class="clearfix"></div>
        </ul>
    </div>
    <div class="clearfix"></div>
</div>
<ul class="mSearch_field hide">
    <li class="search_area">
        <form action="index.php?id=12" method="post" id="searchForm">
            <input type="text" placeholder="<?php echo Enter_Keywords;?>" name="searchTerm" class="input" value="<?php echo ((isset($_REQUEST['searchTerm']))&&($_REQUEST['searchTerm']!='')?$_REQUEST['searchTerm']:'');?>" />
            <input class="go_btn" type="submit" value="" onclick="javascript: document.getElementById('searchForm').submit();" />
        </form>
    </li>
</ul>
<div class="mMenu_dropdown">
    <ul id="menu_dropdown">
		<?php echo top_menu('5', $page_id);?>
    </ul>
    <!--<ul id="menu_cat">
		<?php //echo top_menu('5', $page_id);?>
    </ul>-->
	<?php if(isset($_SESSION["memID"])){?>
        <ul id="menu_account">
        	<?php echo top_menu('1', $page_id);?>
        </ul>
	<?php }?>
</div>
<div id="menu">
    <ul class="menu">
		<?php echo top_menu('0,5', $page_id);?>
		<?php if(isset($_SESSION["memID"])){?>
            <li><a href="javascript:void(0);"><?php echo My_Account;?></a>
                <ul><?php echo top_menu('1', $page_id);?></ul>
            </li>
        <?php }?>
        <div class="clearfix"></div>
    </ul>
</div>