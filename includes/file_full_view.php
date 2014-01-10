<?php if($st_limit==0){?>
        <li class="disable"><a href="javascript:void(0);" title="<?php echo Purchase_Package;?>"><img src="images/icons/full_icon.png" /></a></li>
<?php
    } else {
		$s_file_name = @pathinfo($row->prf_file,PATHINFO_FILENAME);
		$s_file_ext  = @pathinfo($row->prf_file,PATHINFO_EXTENSION);
?>
        <li><a href="rtsp://178.79.149.95/vod/videos/file/<?php echo $s_file_ext;?>:<?php echo $s_file_name;?>" title="<?php echo Full_View;?>" target="_blank"><img src="images/icons/full_icon.png" /></a></li>
<?php }?>