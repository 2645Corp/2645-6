<?php
require_once("../include/Db.php");
require_once("showmsg.php");
$key = $_REQUEST['key'];
$key = base64_decode($key);
$keys = explode("\t",$key);
$Db = new DB_MYSQL();
$result = $Db->get_one("select `email` from `student` where `student`=".$keys[0]);
if(!empty($result) && $keys[1] == $result['email'])
{
	$aupdate = array(
		"isActivate"=>1
	);
	if($Db->update("student",$aupdate,"student=".$keys[0]))
	{
		msg06();
	}
	else
	{
		msg05("激活失败","与数据库通信失败。");
	}
}
else
{
	msg05("激活失败","此链接可能已经失效。");
}
?>