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
	$smarty->assign("dir","semchooseclass");
	$smarty->assign("url","121.42.163.214/2645-6");
	$smarty->assign("primate","subject");
	$smarty->assign("term",$term);
	
	$DB= new DB_MYSQL();
	
	$subjects= $DB->get_all("select * from subject");
	$sj[]=array("subject"=>'NULL',"subject_name"=>'请选择学科...');
	foreach($subjects as $subject)
		$sj[]=array("subject"=>$subject['subject'],"subject_name"=>$subject['subject_name']);
	$smarty->assign("Subjects",$sj);

	$smarty->display("semchooseclass.html");
}
else
{
	print("Access Denied");
    echo "<script language=\"JavaScript\">alert(\"你好，请先登录！\");window.location.replace('../../index.php');</script>";
}
?>
</body>
</html>