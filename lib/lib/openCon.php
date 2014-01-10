<?php
	$dbDatabase = "ado1302506170130";
	$dbServer 	= "ado1302506170130.db.10177187.hostedresource.com";
	$dbUserName = "ado1302506170130";
	$dbPassword = "Lgw!ac554411";
	$conn = mysql_connect("$dbServer","$dbUserName","$dbPassword") or die("Unable 2 Connect 2 Database Server"); 
	$db = mysql_select_db("$dbDatabase")  or die("Unable 2 Connect 2 Database");
?>