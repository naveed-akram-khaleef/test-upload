<?php
	//Source http://phpseclib.sourceforge.net/

	$strServer			= "178.79.149.95";
	$strServerPort		= "22222";
	$strServerUsername	= "worker";
	$strServerPassword	= "pebbles#006";

	$sftp = new Net_SFTP('178.79.149.95', 22222);
	if(!$sftp->login('worker', 'pebbles#006')) {
		//Failed
		$hddn = 0;
	}
	else{
		//Successfull
		$hddn = 1;
		$sftp->put($remote_file, $local_file_contents);
		$sftp->delete("/home/worker/videos/preview/".$pfileName);
	}
?>