<?php

$id = $_REQUEST['id'];

$ids = explode(',',$id);

require_once("../Db.php");
$DB= new DB_MYSQL();

foreach($ids as $iid)
{
	$result= true;
	$result= $result && $DB->delete("term","term='$iid'");
	$majors= $DB->get_all("select * from major");
	$subjects= $DB->get_all("select subject from subject");

	foreach($majors as $major)
	{
		$DB->query("drop table sem".$iid."_maj".$major['major']);
	}
	$DB->query("drop table sem".$iid."_xk");
	foreach($subjects as $subject)
	{
		$DB->query("drop table sem".$iid."_sj".$subject['subject']."_exam");
		$DB->query("alter table sem".$iid."_sj".$subject['subject']."_grade rename to recycle_sem".$iid."_sj".$subject['subject']."_grade");
	}
}

if ($result){
	echo json_encode(array('success'=>true));
} else {
	echo json_encode(array("isError"=>"true","msg"=>$DB->errormsg));
}
//"create table sem".$id."_maj".$major['major']
?>