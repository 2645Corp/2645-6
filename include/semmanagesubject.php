<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>2645-6</title>
</head>

<body>
<?php
require_once("smarty.php");
require_once("Db.php");

$term= @$_GET['term'];

session_start();
if(isset($_SESSION['userflag']) && $_SESSION['userflag'] == "admin")
{
	$smarty->assign("dir","semmanagesubject");
	$smarty->assign("url","121.42.163.214/2645-6");
	$smarty->assign("primate","subject");
	$smarty->assign("term",$term);
	
	$DB= new DB_MYSQL();
	
	$majors= $DB->get_all("select * from major");
	$mj[]=array("major"=>'NULL',"major_name"=>'请选择专业...');
	foreach($majors as $major)
		$mj[]=array("major"=>$major['major'],"major_name"=>$major['major_name']);
	$smarty->assign("Majors",$mj);
	
	$subject= json_encode($DB->get_all("select * from subject"));
	$subject= str_replace('"','\'',$subject);
	
	$th[]=array("field"=>"subject","editor"=>"{type:'combobox',options:{required:true,missingMessage:'此字段为必填项',data:$subject,valueField:'subject',textField:'subject_name',editable:false}}","title"=>"学科ID");
	$th[]=array("field"=>"subject_name","title"=>"学科名称");
	$th[]=array("field"=>"period","editor"=>"{type:'validatebox',options:{required:true,missingMessage:'此字段为必填项'}}","title"=>"学时");
	$th[]=array("field"=>"score","editor"=>"{type:'validatebox',options:{required:true,missingMessage:'此字段为必填项'}}","title"=>"学分");
	$th[]=array("field"=>"maxgrade","editor"=>"{type:'validatebox',options:{required:true,missingMessage:'此字段为必填项'}}","title"=>"学科满分");

    $smarty->assign("TableHeads",$th);

	$smarty->display("semmanagesubject.html");
}
else
{
	print("Access Denied");
    echo "<script language=\"JavaScript\">alert(\"你好，请先登录！\");window.location.replace('../../index.php');</script>";
}
?>
</body>
</html>