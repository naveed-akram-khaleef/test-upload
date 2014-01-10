<?php if($dw_limit==0){?>
    <li class="disable"><a href="javascript:void(0);" title="<?php echo Purchase_Package;?>"><img src="images/icons/download_icon.png" /></a></li>
<?php
    } else {
?>
    <li><?php $file_link = @file_get_contents("http://178.79.149.95:82/prepare/?fname=file/".$row->prf_file);?><a href="http://178.79.149.95:82/downloads/<?php echo $file_link;?>" title="<?php echo Downloads;?>" target="_blank"><img src="images/icons/download_icon.png" /></a></li>
<?php }?>