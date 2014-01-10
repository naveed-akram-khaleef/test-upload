<?php
include("../lib/openCon.php");
include("../lib/functions.php");

require_once("../lib/class.pager1.php"); 
$p = new Pager1;

session_start();

if(!isset($_SESSION['UID'])) {
	header("location: login.php");
}

$strMSG = "";
$FormHead = "";
?>