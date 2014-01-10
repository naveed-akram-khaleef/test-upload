<?php
	$dbDatabase = "2013_wap_portal2";
	$dbServer = "localhost";
	$dbUserName = "root";
	$dbPassword = "";
	$conn = mysql_connect("$dbServer","$dbUserName","$dbPassword") or die("Unable 2 Connect 2 Database Server"); 
	$db = mysql_select_db("$dbDatabase")  or die("Unable 2 Connect 2 Database"); 
?>