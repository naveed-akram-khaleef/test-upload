<form method="post" id="giftToFrnd">
    <ul>
        <li style="position:relative;">
            <div class="label"><?php echo Phone;?>:</div><div class="triangle"></div>
            <input type="text" class=" input required number " name="mg_to" />
        </li>
        <li>
            <div class="label"><?php echo Message;?>:</div><div class="triangle"></div>
            <input type="text" class=" input required " name="mg_details" />
        </li>
        <li class="button">
            <input type="hidden" name="cid" value="<?php echo $_SESSION['vot_cat'];?>" />
            <input type="hidden" name="mpl_id" value="<?php echo $mpl_id;?>" />
            <input type="submit" id="giftToFrnd" class="btn" name="gift_to_friend" value="<?php echo Submit;?>" />
        </li>
    </ul>
</form>