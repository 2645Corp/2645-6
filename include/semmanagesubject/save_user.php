<?php

$subject = intval($_REQUEST['subject']);
$period = intval($_REQUEST['period']);
$score = intval($_REQUEST['score']);
$maxgrade = intval($_REQUEST['maxgrade']);

$term= @$_GET['term'];
$major= @$_GET['major'];
$table_name="sem".$term."_maj".$major;

require_once("../Db.php");
$DB= new DB_MYSQL();

$subject_a= $DB->get_one("select * from subject where subject = '$subject'");
$subject_name= $subject_a['subject_name'];

$sql = array(
	'subject' => $subject,
	'period' => $period,
	'score' => $score,
	'maxgrade' => $maxgrade,
);
$sql2 = array(
	'subject' => $subject,
	'subject_name' => $subject_name,
	'period' => $period,
	'score' => $score,
	'maxgrade' => $maxgrade,
);
$result= $DB->insert($table_name,$sql);
if($result)
	echo json_encode($sql2);
else echo json_encode(array("isError"=>"true","msg"=>$DB->errormsg));

?>