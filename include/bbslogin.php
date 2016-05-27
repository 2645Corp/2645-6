<?php

session_start();
if(isset($_SESSION['username'])&&isset($_SESSION['userflag']))
{
	$student=$_SESSION['username'];
	require_once("Db.php");
	require_once("bbsloginhelper.php");
	$Db = new DB_MYSQL();
	$uid = $Db->get_one("select `uid` from `student` where `student`=$student");
	_synlogin($uid['uid']);
	$url = SITE_URL."bbs";
	echo "<script language='javascript' type='text/javascript'>";
	echo "window.location.href='$url';";  
	echo "</script>";
}
else
{
	header("Location:taunt.html");
	die();
}

?>