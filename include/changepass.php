<?php

require_once("Db.php");
require_once("../reg/include/Db_bbs.php");
require_once("config.php");
session_start();

$DB= new DB_MYSQL();
$Db_bbs = new DB_BBS_MYSQL();

$username= $_SESSION['username'];
$userflag= $_SESSION['userflag'];
if($userflag != "student")
{
	$teacher= $DB->get_one("select * from teacher where teacher = '$username'");
}
else
{
	$student = $DB->get_one("select * from student where student = '$username'");
}

$oldpass = htmlspecialchars($_REQUEST['oldpass']);
$newpass = htmlspecialchars($_REQUEST['newpass']);
$confirmpass = htmlspecialchars($_REQUEST['confirmpass']);

if($userflag != "student")
{
	if(md5(sha1(sha1($oldpass)))==$teacher['pwd'])
	{
		$passcode= md5(sha1(sha1($confirmpass)));
		$teacher['pwd']= $passcode;
		$DB->update('teacher',$teacher,"teacher = '$username'");
		$result= array('result' => 'success');
		echo json_encode($result);
	}
	else
	{
		$result= array('result' => 'denied');
		echo json_encode($result);
	}
}
else
{
	if(md5(sha1(sha1($oldpass)))==$student['pwd'])
	{
		$bbsresult = $Db_bbs->get_one("select `salt` from `".BBS_DB_PREFIX."uc_members` where `username`=".$student['student']);
		$salt = $bbsresult['salt'];
		$newbbspwd = md5(md5($confirmpass).$salt);
		$abbsupdate = array(
			"password" => $newbbspwd
		);
		
		$passcode= md5(sha1(sha1($confirmpass)));
		$student['pwd']= $passcode;
		$DB->update('student',$student,"student = '$username'");
		$Db_bbs->update(BBS_DB_PREFIX."uc_members",$abbsupdate,"username='".$student['student']."'");
		$result= array('result' => 'success');
		echo json_encode($result);
	}
	else
	{
		$result= array('result' => 'denied');
		echo json_encode($result);
	}
}
?>