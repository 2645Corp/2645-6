<?php
require_once("Db.php");
$DB= new DB_MYSQL();

$username = $_POST['username'];
$passcode = md5(sha1(sha1($_POST['pass'])));

//获取session的值
$query = $DB->query("select * from teacher where teacher = '$username' and pwd = '$passcode'");
//判断用户以及密码
if($row = mysql_fetch_array($query))
{
    session_start();
    //判断权限
    $_SESSION['username'] = $row['teacher'];
    $_SESSION['userflag'] = $row['power'];
    header("Location: admin.php");
}
else {
	$query = $DB->query("select * from student where student = '$username' and pwd = '$passcode'");
	if($row = mysql_fetch_array($query))
	{
		session_start();
		//判断权限
		$_SESSION['username'] = $row['student'];
		$_SESSION['userflag'] = "student";
		header("Location: stumain.php");
	}
	else {
	    echo "<script language=\"JavaScript\">alert(\"用户名或密码错误\");window.location.replace('../index.php');</script>";
	}
}
?>