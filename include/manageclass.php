<?php

require_once("smarty.php");
require_once("Db.php");
$DB= new DB_MYSQL();

session_start();
if(isset($_SESSION['userflag']) && $_SESSION['userflag'] == "admin")
{
	$smarty->assign("dir","manageclass");
	$smarty->assign("url","121.42.163.214/2645-6");
	$smarty->assign("primate","class");
	$th[]=array("field"=>"class","editor"=>"{type:'validatebox',options:{required:true,missingMessage:'此字段为必填项'}}","title"=>"班级ID");
	$th[]=array("field"=>"class_name","editor"=>"text","title"=>"班级名称");
	
	$major= json_encode($DB->get_all("select * from major"));
	$major= str_replace('"','\'',$major);
	$headteacher= json_encode($DB->get_all("select * from teacher"));
	$headteacher= str_replace('"','\'',$headteacher);
	
	$th[]=array("field"=>"major","editor"=>"{type:'combobox',options:{required:true,missingMessage:'此字段为必填项',data:$major,valueField:'major',textField:'major_name',editable:false}}","title"=>"专业ID");
	$th[]=array("field"=>"major_name","title"=>"专业");
	$th[]=array("field"=>"headteacher","editor"=>"{type:'combobox',options:{required:true,missingMessage:'此字段为必填项',data:$headteacher,valueField:'teacher',textField:'teacher_name',editable:false}}","title"=>"班主任ID");
	$th[]=array("field"=>"teacher_name","title"=>"班主任");	
    $smarty->assign("TableHeads",$th);

	$smarty->display("crud2.html");
}
else
{
	print("Access Denied");
    echo "<script language=\"JavaScript\">alert(\"你好，请先登录！\");window.location.replace('../../index.php');</script>";
}
?>