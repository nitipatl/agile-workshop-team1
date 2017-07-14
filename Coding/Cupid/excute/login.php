<?php
session_start();
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Content-type: text/html; charset=tis-620");
header("Cache-Control: no-cache, must-revalidate");

include("../class/MSSQLOperation.class.php");
include("../class/QueryProfile.class.php");

$db = new QueryProfile();

//$_SESSION['USERNAME'] = 'ทดสอบ';
$_SESSION['login'] = false;

if(isset($_POST['Submit'])){
	$db -> getUser(preg_replace("/[^a-zA-Z\d]/i", '', $_POST['textUser']), preg_replace("/[^a-zA-Z\d]/i", '', $_POST['textPwd']));
	if($db -> numrows == 1){
		$_SESSION['name'] = in_array($db -> fields[0]["role"], array('poweruser', 'user'))?$db -> fields[0]["person_name"]:$_POST['textUser'];
		$_SESSION['agency'] = $db -> fields[0]["agency"];
		$_SESSION['status'] = $db -> fields[0]["status"];
		$_SESSION['role'] = $db -> fields[0]["role"];	
		$_SESSION['person_id'] = $db -> fields[0]["person_id"];
		$_SESSION['login'] = true;
		$_SESSION['position'] = $db -> fields[0]["position"];
		echo '1';	
	}else echo '0';
}
?>