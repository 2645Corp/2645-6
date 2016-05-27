<?php

$class = intval($_REQUEST['class']);
$class_name = $_REQUEST['class_name'];
$major = intval($_REQUEST['major']);
$headteacher = intval($_REQUEST['headteacher']);

require_once("../Db.php");
$DB= new DB_MYSQL();

$major_a= $DB->get_one("select * from major where major = '$major'");
$major_name= $major_a['major_name'];
$teacher_a= $DB->get_one("select * from teacher where teacher = '$headteacher'");
$teacher_name= $teacher_a['teacher_name'];

$sql = array(
	'class' => $class,
	'class_name' => $class_name,
	'major' => $major,
	'headteacher' => $headteacher
);
$sql2 = array(
	'class' => $class,
	'class_name' => $class_name,
	'major' => $major,
	'major_name' => $major_name,
	'headteacher' => $headteacher,
	'teacher_name' => $teacher_name
);
$result= $DB->update("class",$sql,"class = '$class'");
if($result)
	echo json_encode($sql2);
else echo json_encode(array("isError"=>"true","msg"=>$DB->errormsg));
?>