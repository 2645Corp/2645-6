<?php

$term_name = $_REQUEST['term_name'];
$startdate = $_REQUEST['startdate'];
$enddate = $_REQUEST['enddate'];

require_once("../Db.php");
$DB= new DB_MYSQL();

$sql = array(
	'term_name' => $term_name,
	'startdate' => $startdate,
	'enddate' => $enddate
);

$result= $DB->insert("term",$sql);
$id= $DB->insert_id();
$majors= $DB->get_all("select * from major");
$subjects= $DB->get_all("select * from subject");
$students= $DB->get_all("select student from student");

foreach($majors as $major)
{
	$DB->query("create table sem".$id."_maj".$major['major']." ( subject smallint NOT NULL, period smallint, score tinyint NOT NULL, maxgrade smallint NOT NULL, PRIMARY KEY (subject) );");
}
$xk_query="create table sem".$id."_xk ( student int NOT NULL, ";
foreach($subjects as $subject)
{
	$xk_query.="sj";
	$xk_query.=$subject['subject'];
	$xk_query.=" smallint, ";
	$DB->query("create table sem".$id."_sj".$subject['subject']."_exam ( exam char(20) NOT NULL, exam_name char(40), sj_num smallint NOT NULL, class_num smallint NOT NULL, classes varchar(1024) NOT NULL, publisher int NOT NULL, maxgrade smallint NOT NULL, begintime timestamp NOT NULL, endtime timestamp NOT NULL, PRIMARY KEY(exam));");
	$DB->query("create table sem".$id."_sj".$subject['subject']."_grade ( student int, PRIMARY KEY(student));");
}
$xk_query.="PRIMARY KEY(student));";
$DB->query($xk_query);
foreach($students as $student)
	$result &= $DB->insert("sem".$id."_xk",$student);
//echo json_encode(array("isError"=>"true","msg"=>$xk_query));

if($result)
	echo json_encode($sql);
else echo json_encode(array("isError"=>"true","msg"=>$DB->errormsg));
