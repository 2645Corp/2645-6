<?php
require_once("config.php");
session_start();
if(isset($_SESSION['username'])&&isset($_SESSION['userflag']))
{
	//发送验证邮件
	require_once("class.smtp.php");
	$student = $_POST['student'];
	$x = new SMTP(MAIL_SERVER,MAIL_PORT,true,ASSIST_EMAIL,ASSIST_PASS,true);
	$key = urlencode(base64_encode($student."\t".$_POST['Email']."\t".sha1(time())));
	$content = "<p>亲爱的".$_POST['stuname']."同学：</p>
	<p>你的学号是：".$student."，请牢记。</p>
	<p>请点击链接激活您的帐号：<br/> 
	<a href='".SITE_URL."reg/active.php?key=".$key."' target= 
	'_blank'>".SITE_URL."reg/active.php?key=".$key."</a></p> 
	<p>如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问。</p>
	<p>".SITE_NAME." ".RELEASE_YEAR."</p>"; 
	$success = $x->send($_POST['Email'],ASSIST_EMAIL,SHORT_SITE_NAME."的激活邮件",$content,ASSISTANT);
	if($success)  //注册成功
	{
		$result= array('result' => 'success');
			echo json_encode($result);
	}
	else
	{
		$result= array('result' => 'failed');
			echo json_encode($result);
	}
}
else
{
	header("Location:taunt.html");
	die();
}

?>