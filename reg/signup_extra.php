<?php
require_once("./../include/config.php");
session_start();
if(isset($_SESSION['username'])&&isset($_SESSION['userflag']))
{
	require_once("showmsg.php");
	//初始化数据库连接
	require_once("../include/Db.php");
	require_once("include/Db_bbs.php");
	$Db = new DB_MYSQL;
	$Db_bbs = new DB_BBS_MYSQL;
	//获取学号
	$student = $_SESSION['username'];
	//插入记录到课程管理系统数据库student_extra表
	$astu_extra = array(
	  "student"=>$student,
	  "gender"=>$_POST['gender'],
	  "id"=>$_POST['id'],
	  "address"=>$_POST['Address'],
	  "tel"=>$_POST['Tel'],
	  "qq"=>$_POST['QQ'],
	  "dadname"=>$_POST['DadName'],
	  "dadtel"=>$_POST['DadTel'],
	  "dadcompany"=>$_POST['DadCompany'],
	  "dadjob"=>$_POST['DadJob'],
	  "momname"=>$_POST['MomName'],
	  "momtel"=>$_POST['MomTel'],
	  "momcompany"=>$_POST['MomCompany'],
	  "momjob"=>$_POST['MomJob'],
	  "height"=>$_POST['Height'],
	  "birthday"=>$_POST['birthday'],
	  "input_province"=>$_POST['input_province'],
	  "input_city"=>$_POST['input_city'],
	  "input_area"=>$_POST['input_area'],
	  "juniorhigh"=>$_POST['JuniorHigh'],
	  "jobinjuniorhigh"=>$_POST['JobInJuniorHigh'],
	  "hobbie"=>$_POST['Hobbie'],
	  "goodat"=>$_POST['GoodAt'],
	  "likesport"=>$_POST['likesport'],
	  "favoritesport"=>$_POST['FavoriteSport'],
	  "health"=>$_POST['health'],
	  "sleeptime"=>$_POST['SleepTime'],
	  "tiaoshi"=>$_POST['tiaoshi'],
	  "personality"=>$_POST['Personality'],
	  "motto"=>$_POST['motto'],
	  "selfevaluation"=>$_POST['SelfEvaluation'],
	  "dandufuyang"=>$_POST['dandufuyang'],
	  "educationmethod"=>$_POST['EducationMethod'],
	  "aboutparent"=>$_POST['AboutParent'],
	  "yourtrouble"=>$_POST['YourTrouble']
	  );
	if($Db->insert("student_extra",$astu_extra) == false)
	{
		msg02("注册失败","与数据库通信错误，请重试。");
	}
	//更新论坛motto
	$aupdate = array(
		"sightml" => $_POST['motto']
	);
	$result = $Db->get_one("select `uid` from `student` where `student`=$student");
	if(!empty($result))
		$Db_bbs->update(BBS_DB_PREFIX."memberfields",$aupdate,"`uid`=".$result['uid']);
	msg05("基本信息调查表","提交成功！");
}
else
{
	header("Location:taunt.html");
	die();
}

 ?>
