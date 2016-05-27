<?php
require_once("./../include/config.php");
require_once("../include/Db.php");
require_once("include/Db_bbs.php");
require_once("showmsg.php");
$Db = new DB_MYSQL();
$Db_bbs = new DB_BBS_MYSQL();
$action = $_REQUEST['action'];
if($action == "send")  //发送密码找回邮件
{
	if(geetest())  //极验
	{
		//发送密码找回邮件
		  require_once("../include/class.smtp.php");
		  $username = $_POST['username'];
		  $postemail = $_POST['Email'];
		  $result = $Db->get_one("select * from `student` where `student`=$username");
		  if(!empty($result))
		  {
			  if($postemail == $result['email'] && $result['isActivate'] == 1)
			  {
				  $pass = $result['pwd'];
				  $x = new SMTP(MAIL_SERVER,MAIL_PORT,true,ASSIST_EMAIL,ASSIST_PASS,true);
				  $nowtime = time();
				  $mykey = urlencode(base64_encode(md5($pass.$nowtime)."\t".$username."\t".$pass."\t".$nowtime));
				  $content = "<p>亲爱的用户：</p>
				  <p>请点击链接重置您的密码：<br/> 
				<a href='".SITE_URL."reg/resetpass.php?action=show&key=".$mykey."' target= 
			'_blank'>".SITE_URL."reg/resetpass.php?action=show&key=".$mykey."</a></p> 
				<p>如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问。此链接24小时之内有效，请尽快使用并妥善保管。</p>
				<p>".SITE_NAME." ".RELEASE_YEAR."</p>"; 
				  $success = $x->send($result['email'],ASSIST_EMAIL,SHORT_SITE_NAME."的密码找回邮件",$content,ASSISTANT);
				  if($success)
					msg09($result['email']);
				  else
					msg08($username,$postemail);
			  }
			  else
			  {
				  if($postemail != $result['email'])
					msg02("找回密码","邮箱不正确，请检查。");
				  else
					msg02("找回密码","邮箱尚未激活。");
			  }
		  }
		  else
		  {
			  msg02("找回密码","用户名不存在，请检查。");
		  }
	}
	else
	{
		msg01();
	}
	
	  
}
else if($action == "reset")  //修改密码
{
	if(validate())  //检验
	{
		$key = $_REQUEST['key'];
		$key = base64_decode($key);
		$keys = explode("\t",$key);
		$student = $keys[1];
		$bbsresult = $Db_bbs->get_one("select `salt` from `".BBS_DB_PREFIX."uc_members` where `username`=$student");
		$salt = $bbsresult['salt'];
		$newbbspwd = md5(md5($_POST['Password']).$salt);
		$abbsupdate = array(
			"password" => $newbbspwd
		);
		$aupdate = array(
			"pwd" => md5(sha1(sha1($_POST['Password'])))
		);
		if($Db->update("student",$aupdate,"student=$student") && $Db_bbs->update(BBS_DB_PREFIX."uc_members",$abbsupdate,"username='$student'"))
		{
			msg05("修改密码","密码修改成功，请牢记。");
		}
		else
		{
			msg05("修改密码","与数据库通信错误，密码修改失败。");
		}
	}
	else
	{
		die();
	}
}
else if($action == "show")  //显示找回密码页面
{
	require_once("../include/smarty.php");
	if(validate())
	{
		$smarty->assign('key',$_REQUEST['key']);
		$smarty->display('resetpass.html');
	}
	else
	{
		die();
	}
}
else
{
	msg01();
}

function timediff( $begin_time, $end_time )  //计算时间差
{
  if ( $begin_time < $end_time ) {
    $starttime = $begin_time;
    $endtime = $end_time;
  } else {
    $starttime = $end_time;
    $endtime = $begin_time;
  }
  $timediff = $endtime - $starttime;
  $days = intval( $timediff / 86400 );
  $remain = $timediff % 86400;
  $hours = intval( $remain / 3600 );
  $remain = $remain % 3600;
  $mins = intval( $remain / 60 );
  $secs = $remain % 60;
  $res = array( "day" => $days, "hour" => $hours, "min" => $mins, "sec" => $secs );
  return $res;
}

function validate()  //检验合法性
{
	global $Db;
	$key = $_REQUEST['key'];
	$key = base64_decode($key);
	$keys = explode("\t",$key);
	$visa = $keys[0];
	$student = $keys[1];
	$oldpass = $keys[2];
	$visatime = $keys[3];
	if(md5($oldpass.$visatime) == $visa)  //校验key是否合法
	{
		$duration = timediff($visatime,time());
		if(($duration['day'] <= 0 && $duration['hour'] < 24) || ($duration['day'] == 1 && $duration['hour'] <= 0 && $duration['min'] <= 0 && $duration['sec'] <= 0))  //检验是否超过24小时
		{
			$result = $Db->get_one("select `pwd` from `student` where `student`=$student");
			if(!empty($result) && $result['pwd'] == $oldpass)  //检验旧密码是否正确
			{
				return true;  //合法
			}
			else
			{
				msg05("找回密码","链接可能已经失效。");
			}
		}
		else
		{
			msg05("找回密码","链接可能已经失效。");
		}
	}
	else
	{
		msg01();
	}
}

function geetest()
{
	require_once 'geetest/lib/class.geetestlib.php';
	require_once 'geetest/config/config.php';
	session_start();
	$validate = false;
	$GtSdk = new GeetestLib(CAPTCHA_ID, PRIVATE_KEY);
	$user_id = $_SESSION['user_id'];
	if ($_SESSION['gtserver'] == 1) {
		$result = $GtSdk->success_validate($_POST['geetest_challenge'], $_POST['geetest_validate'], $_POST['geetest_seccode'], $user_id);
		if ($result) {
			$validate = true;
		} else{
			$validate = false;
		}
	}else{
		if ($GtSdk->fail_validate($_POST['geetest_challenge'],$_POST['geetest_validate'],$_POST['geetest_seccode'])) {
			$validate = true;
		}else{
			$validate = false;
		}
	}
	return $validate;
}

?>