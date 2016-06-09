<?php

$subject_name = $_REQUEST['subject_name'];

require_once("../Db.php");
$DB= new DB_MYSQL();

$sql = array(
	'subject_name' => $subject_name,
);
$result= $DB->insert("subject",$sql);
$id= $DB->insert_id();
$sql2 = array(
	'subject' => $id,
	'subject_name' => $subject_name
);
$terms= $DB->get_all("select term from term");
foreach($terms as $term)
{
	$DB->query("create table sem".$term['term']."_sj".$id."_exam ( exam char(20) NOT NULL, exam_name char(40), sj_num smallint NOT NULL, class_num smallint NOT NULL, classes varchar(1024) NOT NULL, publisher int NOT NULL, maxgrade smallint NOT NULL, begintime timestamp NOT NULL, endtime timestamp NOT NULL, PRIMARY KEY(exam));");
	$DB->query("create table sem".$term['term']."_sj".$id."_grade ( student int, PRIMARY KEY(student));");
}
$DB->query("alter table sem".$term['term']."_xk add sj".$id." int;");
if($result)
	echo json_encode($sql2);
else echo json_encode(array("isError"=>"true","msg"=>$DB->errormsg));

?>