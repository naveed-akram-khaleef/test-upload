<li><a href="javascript:void(0);" title="<?php echo Add_To_Wishlist;?>" onclick="addToMyCollection();"><img src="images/icons/wish_icon.png" /></a></li>

<?php if($gf_limit==0){?>
    <li class="disable"><a href="javascript:void(0);" title="<?php echo Purchase_Package;?>"><img src="images/icons/friend_icon.png" /></a></li>
<?php
    } else {
?>
    <li><a href="javascript:void(0);" title="<?php echo Gift_To_Friend;?>" onclick="giftToFriend(); triangle_position();"><img src="images/icons/friend_icon.png" /></a></li>
<?php }?>
