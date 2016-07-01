<?php

$id = intval($_REQUEST['id']);
$student_name = $_REQUEST['student_name'];
$class = $_REQUEST['class'];
$isReg = isset($_REQUEST['isReg']) ? $_REQUEST['isReg'] : 0;

require_once("../Db.php");
$DB= new DB_MYSQL();

$sql = array(
	'student_name' => $student_name,
	'class' => $class,
	'isReg' => $isReg
);
$result= $DB->update("prereg",$sql,"id = '$id'");
if($result)
	echo json_encode($sql);
else echo json_encode(array("isError"=>"true","msg"=>$DB->errormsg));
?>