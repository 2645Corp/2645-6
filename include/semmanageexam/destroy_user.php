<?php

$id = $_REQUEST['id'];

$ids = explode(',',$id);

$term= @$_GET['term'];
require_once("../Db.php");
$DB= new DB_MYSQL();

$subjects= $DB->get_all("select subject from subject");
$errmsg= "";
foreach($ids as &$iid)
{
	$result= true;
	//$result= $result && $DB->delete("student","student='$iid'");
	foreach($subjects as $subject)
	{
		$table_name= "sem".$term."_sj".$subject['subject']."_exam";
		$flag= $DB->get_one("select count(*) from ".$table_name." where exam = '$iid'");
		if($flag['count(*)']>0)
		$row= $DB->get_one("select sj_num from ".$table_name." where exam = '$iid'");
		if($row['sj_num'] > 1)
		{
			$success = $DB->delete($table_name,"exam='$iid'");
			if(!$success)
				$errmsg.=$DB->errormsg;
		}
		else
		{
			$result=false;
			$errmsg.="你不能在这里删除涉及多科目的考试!权限错误，位于考试id为".$iid."处。";
		}
	}
}

if ($result){
	echo json_encode(array('success'=>true));
} else {
	echo json_encode(array('errorMsg'=>$errmsg));
}
?>