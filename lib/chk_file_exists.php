<?php
$sftp = new Net_SFTP('178.79.149.95', 22222);
if($sftp->login('worker', 'pebbles#006')) {
	$preview_file = $sftp->size('/home/worker/videos/preview/'.$preview_file);
	$main_file = $sftp->size('/home/worker/videos/file/'.$main_file);
}
?>