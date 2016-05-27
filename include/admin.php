<?php

require_once("smarty.php");
require_once("Db.php");

$DB= new DB_MYSQL();

session_start();
if(isset($_SESSION['username'])&&isset($_SESSION['userflag']))
{
	if($_SESSION['userflag']!="student")
	{
		$userid= $_SESSION['username'];
		$user= $DB->get_one("select * from teacher where teacher = '$userid'");
		$smarty->assign('username',$user['teacher_name']);
		$smarty->assign('userflag',$_SESSION['userflag']);
		
		$terms = $DB->get_all("select * from term");
		$smarty->assign('Terms',$terms);
		
		$smarty->display('admin.html');
	}
	else
	{
		print("Access Denied");
		echo "<script language=\"JavaScript\">alert(\"你没有权限访问此页面！\");window.location.replace('../index.php');</script>";
	}
}
else
{
	print("Access Denied");
    echo "<script language=\"JavaScript\">alert(\"你好，请先登录！\");window.location.replace('../index.php');</script>";
}

?>