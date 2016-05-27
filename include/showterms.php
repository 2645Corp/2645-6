<?php

require_once("smarty.php");
require_once("Db.php");

$DB= new DB_MYSQL();

session_start();
if(isset($_SESSION['userflag']) && $_SESSION['userflag'] == "admin")
{
	$terms = $DB->get_all("select * from term");
	$smarty->assign('Terms',$terms);
	$smarty->display('showterms.html');
}
else
{
	print("Access Denied");
    echo "<script language=\"JavaScript\">alert(\"你好，请先登录！\");window.location.replace('../index.php');</script>";
}

?>