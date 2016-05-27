<?php
$student = htmlspecialchars($_REQUEST['student']);
$student_name = htmlspecialchars($_REQUEST['student_name']);
$class = htmlspecialchars($_REQUEST['class']);
$gender = htmlspecialchars($_REQUEST['gender']);
$id = htmlspecialchars($_REQUEST['id']);
require_once("../Db.php");
$DB= new DB_MYSQL();
$sql = array(
		'student' => $student,
		'student_name' => $student_name,
		'class' => $class,
		'gender' => $gender,
		'id' => $id);
$result = $DB->update("student",$sql,"student = '$student'");
if ($result){
	echo json_encode($sql);
} else {
	echo json_encode(array('errorMsg'=>$DB->errormsg));
}
?>