<?php

$teacher = htmlspecialchars($_REQUEST['teacher']);
$teacher_name = htmlspecialchars($_REQUEST['teacher_name']);
$subject = htmlspecialchars($_REQUEST['subject']);
$power = htmlspecialchars($_REQUEST['power']);
$passcode= md5(sha1(sha1($teacher)));

require_once("../Db.php");
$DB= new DB_MYSQL();

$sql = array(
		'teacher' => $teacher,
		'teacher_name' => $teacher_name,
		'subject' => $subject,
		'power' => $power,
		'pwd' => $passcode);
$result = $DB->insert('teacher',$sql);
if ($result){
	echo json_encode($sql);
} else {
	echo json_encode(array('errorMsg'=>$DB->errormsg));
}
?>