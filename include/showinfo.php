<?php
session_start();
if(isset($_SESSION['username'])&&isset($_SESSION['userflag']))
{
	require_once("smarty.php");
	require_once("Db.php");
	$DB= new DB_MYSQL();
	$student = $_SESSION['username'];
	$result = $DB->get_one("select * from student where student = '$student'");
	$class = $DB->get_one("select * from `class` where `class`=".$result['class']);
	$major = $DB->get_one("select `major_name` from `major` where `major`=".$class['major']);
	$smarty->assign('stuname',$result['student_name']);
	$smarty->assign('major',$major['major_name']);
	$smarty->assign('class',$class['class_name']);
	$smarty->assign('Email',$result['email']);
	$smarty->assign('student',$student);
	$smarty->display('showinfo.html');
}
else
{
	header("Location:taunt.html");
	die();
}
?>