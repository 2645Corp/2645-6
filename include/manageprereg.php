<?php
require_once("smarty.php");
require_once("config.php");

session_start();
if(isset($_SESSION['userflag']) && $_SESSION['userflag'] == "admin")
{
	$smarty->assign("dir","manageprereg");
	$smarty->assign("url","www.whyzsyb.com");
	$smarty->assign("primate","id");
	$th[]=array("field"=>"id","editor"=>"text","title"=>"id");
	$th[]=array("field"=>"student_name","editor"=>"{type:'validatebox',options:{required:true,missingMessage:'此字段为必填项'}}","title"=>"姓名");
	$th[]=array("field"=>"class","editor"=>"{type:'validatebox',options:{required:true,missingMessage:'此字段为必填项'}}","title"=>"班级");
	$th[]=array("field"=>"isReg","editor"=>"text","title"=>"isReg");
	
    $smarty->assign("TableHeads",$th);

	$smarty->display("crud2.html");
}
else
{
	print("Access Denied");
    echo "<script language=\"JavaScript\">alert(\"你好，请先登录！\");window.location.replace('../../index.php');</script>";
}
?>