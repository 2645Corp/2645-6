<?php

require_once("smarty.php");
require_once("Db.php");

$DB= new DB_MYSQL();

$term= @$_GET['term'];

session_start();
if(isset($_SESSION['username']))
{
	$smarty->assign('term',$term);	
	$smarty->display('semester.html');
}
else
{
	print("Access Denied");
    echo "<script language=\"JavaScript\">alert(\"你好，请先登录！\");window.location.replace('../index.php');</script>";
}

?>