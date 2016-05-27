<?php
require_once("config.php");
session_start();
if(isset($_SESSION['username'])&&isset($_SESSION['userflag']))
{
	$student = $_SESSION['username'];
	$oldpass = $_REQUEST['oldpass'];
	$Email = $_REQUEST['Email'];
	require_once("Db.php");
	require_once("./../reg/showmsg.php");
	$Db = new DB_MYSQL();
	$result = $Db->get_one("select * from `student` where `student`=$student");
	if(!empty($result))
	{
		if($result['pwd'] == md5(sha1(sha1($oldpass))))
		{
			$oldEmail = $result['email'];
			$stuname = $result['student_name'];
			$flag = true;
			$aupdate = array(
				'email' => $Email,
				'isActivate' => 0
			);
			$flag &= $Db->update("student",$aupdate,"student=$student");
			if($flag)
			{
				//发送邮件
				require_once("class.smtp.php");
				$x = new SMTP(MAIL_SERVER,MAIL_PORT,true,ASSIST_EMAIL,ASSIST_PASS,true);
				$key = urlencode(base64_encode($student."\t".$Email."\t".sha1(time())));
				$content1 = "<p>亲爱的".$stuname."同学：</p>
				<p>你的邮箱修改成功。</p>
				<p>请点击链接激活您的帐号：<br/> 
			  <a href='".SITE_URL."reg/active.php?key=".$key."' target= 
		  '_blank'>".SITE_URL."reg/active.php?key=".$key."</a></p> 
			  <p>如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问。</p>
			  <p>".SITE_NAME." ".RELEASE_YEAR."</p>"; 
			  	$success = true;
				$success &= $x->send($Email,ASSIST_EMAIL,SHORT_SITE_NAME."的激活邮件",$content1,ASSISTANT);
				$content2 = "<p>亲爱的".$stuname."同学：</p>
				<p>你的邮箱已经被修改。</p>
				<p>如果此操作不是你本人所进行的，请立即登录".SHORT_SITE_NAME."修改你的密码<br/> 
			  <a href='".SITE_URL."' target= 
		  '_blank'>点击此处登录".SHORT_SITE_NAME."</a></p>
			  <p>".SITE_NAME." ".RELEASE_YEAR."</p>"; 
				$success &= $x->send($oldEmail,ASSIST_EMAIL,SHORT_SITE_NAME."的安全提醒邮件",$content2,ASSISTANT);
				if($success)  //发送成功
				{
					$ajax= array(
						'result' => 'success',
					);
					echo json_encode($ajax);
				}
				else
				{
					$ajax= array(
						'result' => 'denied',
						'msg' => "验证邮件发送失败，请重试！"
					);
					echo json_encode($ajax);
				}
			}
			else
			{
				$ajax= array(
					'result' => 'denied',
					'msg' => "与数据库通信失败！"
				);
				echo json_encode($ajax);
			}
		}
		else
		{
			$ajax= array(
				'result' => 'denied',
				'msg' => "密码错误！"
			);
			echo json_encode($ajax);
		}
	}
	else
	{
		$ajax= array(
			'result' => 'denied',
			'msg' => "与数据库通信失败！"
		);
		echo json_encode($ajax);
	}
}
else
{
	header("Location:taunt.html");
	die();
}

?>