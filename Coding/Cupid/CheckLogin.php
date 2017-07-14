<?php 
 session_start();
$host = "localhost";
$username = "team1";
$password = "QIw0VaXCAlBGdex5";
$dbname = "team1";
$mysqli = new MySQLI($host,$username,$password,$dbname);
$result = $mysqli->query(" select  * from user  WHERE  user='$_POST[user]' AND password='$_POST[password]' ") or die(mysqli_error());;   

if($result[id]!=''){
	$_SESSION['id'] = $result['id'];
	include('main.php');
};
?>