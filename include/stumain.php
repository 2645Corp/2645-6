<?php

require_once("smarty.php");
require_once("Db.php");
require_once("config.php");

$DB= new DB_MYSQL();

session_start();
if(isset($_SESSION['username'])&&isset($_SESSION['userflag']))
{
	if($_SESSION['userflag']=="student")
	{
		$userid= $_SESSION['username'];
		$user= $DB->get_one("select * from student where student = '$userid'");
		$smarty->assign('isActivate',$user['isActivate']);
		$smarty->assign('student',$user['student']);
		$smarty->assign('Email',$user['email']);
		$urls = explode("@",$user['email']);
		$smarty->assign('mailurl',"http://mail.".$urls[1]);
		$smarty->assign('username',$user['student_name']);
		$smarty->assign('userflag',$_SESSION['userflag']);
		$smarty->assign('sitename',SITE_NAME);
		$smarty->assign('uid',$userid);
		
		//获取所有问卷
		$grade = intval(substr($userid,0,2));
		$qs = $DB->get_all("select * from `questionnaire` where `department`=$grade");
		$qns = array();
		if(!empty($qs))
		{
			foreach($qs as $q)
			{
				if(time() >= strtotime($q['begintime']) && time() <= strtotime($q['endtime']))
				{
					$qns[] = $q;
				}
			}
		}
		$smarty->assign('qns',$qns);
		
		$smarty->display('stumain.html');
	}
	else
	{
		print("Access Denied");
		echo "<script language=\"JavaScript\">alert(\"你没有权限访问此页面\");window.location.replace('../index.php');</script>";
	}

}
else
{
	print("Access Denied");
    echo "<script language=\"JavaScript\">alert(\"你好，请先登录！\");window.location.replace('../index.php');</script>";
}

?>