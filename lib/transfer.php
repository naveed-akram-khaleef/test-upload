<?php
	//Source http://phpseclib.sourceforge.net/

	$strServer			= "178.79.149.95";
	$strServerPort		= "22222";
	$strServerUsername	= "worker";
	$strServerPassword	= "pebbles#006";

	if($mfileName!=''){
		$remote_file = "/home/worker/videos/file/".$mfileName;
		$local_file_contents = file_get_contents('../files/products/file/'.$mfileName);
	}
	if($pfileName!=''){
		$remote_file = "/home/worker/videos/preview/".$pfileName;
		$local_file_contents = file_get_contents('../files/products/preview/'.$pfileName);
	}

	$sftp = new Net_SFTP('178.79.149.95', 22222);
    if(!$sftp->login('worker', 'pebbles#006')) {
		//Failed
		$hddn = 0;
	}
	else{
		//Successfull
		$hddn = 1;

        $sftp->BufferSize = (1024 * 32) - 50;
        $sftp->OperationTimeout = TimeSpan.FromMinutes(15);
    
        $sftp->put($remote_file, $local_file_contents);
		if($mfileName!=''){
			@unlink('../files/products/file/'.$mfileName);
		}
		if($pfileName!=''){
			@unlink('../files/products/preview/'.$pfileName);
		}
	}
?>