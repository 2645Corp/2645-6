<?php

require_once("../include/smarty.php");

function msg01()
{
	global $smarty;
	$smarty->display('regstatus01.html');
}

function msg02($title,$msg)
{
	global $smarty;
	$smarty->assign('title',$title);
	$smarty->assign('message',$msg);
	$smarty->display('regstatus02.html');
}

function msg04($email,$student)
{
	global $smarty;
	$smarty->assign('student',$student);
	$urls = explode("@",$email);
	$smarty->assign('mailurl',"http://mail.".$urls[1]);
	$smarty->display('regstatus04.html');
}

function msg05($title,$msg)
{
	global $smarty;
	$smarty->assign('title',$title);
	$smarty->assign('message',$msg);
	$smarty->display('regstatus05.html');
}

function msg06()
{
	global $smarty;
	$smarty->display('regstatus06.html');
}

function msg08($username,$Email)
{
	global $smarty;
	$smarty->assign('username',$username);
	$smarty->assign('Email',$Email);
	$smarty->display('regstatus08.html');
}

function msg09($email)
{
	global $smarty;
	$urls = explode("@",$email);
	$smarty->assign('mailurl',"http://mail.".$urls[1]);
	$smarty->display('regstatus09.html');
}

?>