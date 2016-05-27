<?php

require_once("smarty.php");
require_once("Db.php");
$DB= new DB_MYSQL();

session_start();
if(isset($_SESSION['userflag']) && $_SESSION['userflag'] == "admin")
{
	$smarty->assign("dir","manageterm");
	$smarty->assign("url","121.42.163.214/2645-6");
	$smarty->assign("primate","term");
	$th[]=array("field"=>"term_name","editor"=>"{type:'text'}","title"=>"学期名称");
	$th[]=array("field"=>"startdate","editor"=>"{type:'datebox',options:{required:true,editable:false}}","title"=>"开始日期");
	$th[]=array("field"=>"enddate","editor"=>"{type:'datebox',options:{required:true,editable:false}}","title"=>"结束日期");
    $smarty->assign("TableHeads",$th);

	$smarty->display("crud3.html");
}
else
{
	print("Access Denied");
    echo "<script language=\"JavaScript\">alert(\"你好，请先登录！\");window.location.replace('../../index.php');</script>";
}
?>