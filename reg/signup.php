<?
require_once("./../include/config.php");
/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/
//print_r($_POST);
/*if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/png"))
&& ($_FILES["file"]["size"] <= 10485760))*/
require_once("showmsg.php");
if(geetest())  //如果极验通过
{
	$ftype = get_filetype($_FILES["file"]["tmp_name"]);
	if (
	(($ftype == "gif")|| ($ftype == "jpg")|| ($ftype == "png"))
	&& ($_FILES["file"]["size"] <= 10485760)
	)
	{
		  //初始化数据库连接
		  require_once("../include/Db.php");
		  require_once("include/Db_bbs.php");
		  $Db = new DB_MYSQL;
		  $Db_bbs = new DB_BBS_MYSQL;
		  //判断信息是否存在于prereg表里
		  $preresult = $Db->get_one("select * from `prereg` where `student_name`='".$_POST['stuname']."' and `class`=".$_POST['class']." and `isReg`=0");
		  if(empty($preresult))
		  {
			  msg02("注册失败","该班级中没有你的信息，请检查。");
			  die();
		  }
		  $regid = $preresult['id'];
		  //插入记录到课程管理系统数据库student表
		  $astu = array(
			"student_name"=>$_POST['stuname'],
			"pwd"=>md5(sha1(sha1($_POST['Password']))),
			"email"=>$_POST['Email'],
			"isActivate"=>0,
			"class"=>$_POST['class']
			);
		  if($Db->insert("student",$astu) == false)
		  {
			  msg02("注册失败","与数据库通信错误，请重试。");
		  }
		  //获取刚刚插入的学生的学号
		  $student = $Db->insert_id();
		  //保存照片文件	  
		  if ($_FILES["file"]["error"] > 0)
			{
				roll_back1($student);
				msg02("注册失败","图片上传失败，请重试。");
			}
		  else
			{
				move_uploaded_file($_FILES["file"]["tmp_name"],"upload/" . $student);
			}			
		   //插入记录到ucenter数据库cdb_uc_members表
		   $salt = getRandStr(6);
		   $aucmember = array(
			//"uid"=>$student,
			"username"=>$student,
			"password"=>md5(md5($_POST['Password']).$salt),
			"email"=>"",
			//"myid"=>$_POST['input_city'],
			//"myidkey"=>$_POST['input_area'],
			"regip"=>"127.0.0.1",
			"regdate"=>time(),
			"lastloginip"=>0,
			"lastlogintime"=>0,
			"salt"=>$salt
			//"secques"=>$_POST['FavoriteSport']
			);
		  if($Db_bbs->insert(BBS_DB_PREFIX."uc_members",$aucmember) == false)
		  {
			  roll_back1($student);
			  msg02("注册失败","与数据库通信错误，请重试。");
			  die();
		  }
		  $myuid = $Db_bbs->insert_id();
		  //更新student的uid
		  $uidupdate = array(
			"uid"=>$myuid
		  );
		  $Db->update('student',$uidupdate,"student=$student");
		  //插入记录到ucenter数据库cdb_uc_memberfields表
		   $aucmemberfield = array(
			"uid"=>$myuid,
			"blacklist"=>""
			);
		  if($Db_bbs->insert(BBS_DB_PREFIX."uc_memberfields",$aucmemberfield) == false)
		  {
			  roll_back1($student);
			  roll_back2($student,$myuid);
			  msg02("注册失败","与数据库通信错误，请重试。");
		  }
		  //插入记录到discuz数据库cdb_members表
		  /*$gender = 0;
		  if($_POST['gender'] == 'M')
			$gender = 1;
		  else
			$gender = 2;*/
			
		   $adzmember = array(
			"uid"=>$myuid,
			"username"=>$student,
			"password"=>md5(md5($_POST['Password']).getRandStr(6)),
			"secques"=>"",
			"gender"=>0,
			"adminid"=>0,
			"groupid"=>10,
			"groupexpiry"=>0,
			"extgroupids"=>"",
			"regip"=>"127.0.0.1",
			"regdate"=>time(),
			"lastip"=>"",
			"lastvisit"=>0,
			"lastactivity"=>0,
			"lastpost"=>0,
			"posts"=>0,
			"threads"=>0,
			"digestposts"=>0,
			"oltime"=>0,
			"pageviews"=>0,
			"credits"=>0,
			"extcredits1"=>0,
			"extcredits2"=>0,
			"extcredits3"=>0,
			"extcredits4"=>0,
			"extcredits5"=>0,
			"extcredits6"=>0,
			"extcredits7"=>0,
			"extcredits8"=>0,
			"email"=>"",
			"bday"=>"0000-00-00",
			"sigstatus"=>0,
			"tpp"=>0,
			"ppp"=>0,
			"styleid"=>0,
			"dateformat"=>0,
			"timeformat"=>0,
			"pmsound"=>1,
			"showemail"=>0,
			"newsletter"=>1,
			"invisible"=>0,
			"timeoffset"=>9999,
			"prompt"=>1,
			"accessmasks"=>0,
			"editormode"=>2,
			"customshow"=>26,
			"xspacestatus"=>0,
			"customaddfeed"=>0,
			"newbietaskid"=>0
			);
		  if($Db_bbs->insert(BBS_DB_PREFIX."members",$adzmember) == false)
		  {
			  roll_back1($student);
			  roll_back2($student,$myuid);
			  msg02("注册失败","与数据库通信错误，请重试。");
		  }
		  //插入记录到discuz数据库cdb_memberfields表
		   $adzmemberfield = array(
			"uid"=>$myuid,
			"nickname"=>"",
			"site"=>"",
			"alipay"=>"",
			"icq"=>"",
			"qq"=>"",
			"yahoo"=>"",
			"msn"=>"",
			"taobao"=>"",
			"location"=>"",
			"customstatus"=>"",
			"medals"=>"",
			"avatar"=>"",
			"avatarwidth"=>0,
			"avatarheight"=>0,
			"bio"=>"",
			"sightml"=>"",
			"ignorepm"=>"",
			"groupterms"=>"",
			"authstr"=>"",
			"spacename"=>"",
			"buyercredit"=>0,
			"sellercredit"=>0
			);
		  if($Db_bbs->insert(BBS_DB_PREFIX."memberfields",$adzmemberfield) == false)
		  {
			  roll_back1($student);
			  roll_back2($student,$myuid);
				msg02("注册失败","与数据库通信错误，请重试。");
		  }
		  //发送验证邮件
		  require_once("../include/class.smtp.php");
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
			  msg04($_POST['Email'],$student);
			  $aupdate = array(
			  	"isReg" => 1
			  );
			  $Db->update("prereg",$aupdate,"id=$regid");
		  }
		  else
		  {
			  msg04($_POST['Email'],$student);
			  $aupdate = array(
			  	"isReg" => 1
			  );
			  $Db->update("prereg",$aupdate,"id=$regid");
		  }
	  }
	else
	  {
		msg02("注册失败","图片格式不正确，请重新提交。");
	  }
}
else
{
	msg01();
}

 
function get_extension($file)  //获取文件扩展名
{
	$info = pathinfo($file);
	return $info['extension'];
}

function get_filetype($file)  //通过读文件头获取文件类型
{
	$tempfile = @fopen($file, "rb");
    $bin = fread($tempfile, 2); //只读2字节 
	fclose($tempfile);
	$strInfo = @unpack("C2chars", $bin);
	$typeCode = intval($strInfo['chars1'] . $strInfo['chars2']);
	$fileType = '';
	switch ($typeCode){ // 6677:bmp 255216:jpg 7173:gif 13780:png 7790:exe 8297:rar 8075:zip tar:109121 7z:55122 gz 31139
		case '255216':
			$fileType = 'jpg';
			break;
		case '7173':
			$fileType = 'gif';
			break;
		case '13780':
			$fileType = 'png';
			break;
		default:
			$fileType = 'unknown';
			break;
	}
	return $fileType;
}

function getRandStr($length)  //生成随机字符串
{
   $str = null;
   $strPol = "0123456789abcdefghijklmnopqrstuvwxyz";
   $max = strlen($strPol)-1;

   for($i=0;$i<$length;$i++){
    $str.=$strPol[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
   }

   return $str;
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

function roll_back1($failstudent)
{
	global $Db,$Db_bbs;
	//回滚数据库1 student表
	$Db->delete("student","student=$failstudent");
	//回滚数据库1 student_extra表
	$Db->delete("student_extra","student=$failstudent");
}

function roll_back2($failstudent,$failuid)
{
	global $Db,$Db_bbs;
	//回滚数据库2 cdb_uc_members表
	$Db_bbs->delete(BBS_DB_PREFIX."uc_members","username='$failstudent'");
	//回滚数据库2 cdb_uc_memberfields表
	$Db_bbs->delete(BBS_DB_PREFIX."uc_memberfields","uid=$failuid");
	//回滚数据库2 cdb_members表
	$Db_bbs->delete(BBS_DB_PREFIX."members","username='$failstudent'");
	//回滚数据库2 cdb_memberfields表
	$Db_bbs->delete(BBS_DB_PREFIX."memberfields","uid=$failuid");
}

 ?>