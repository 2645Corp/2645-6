<?php
$teacher = htmlspecialchars($_REQUEST['teacher']);
$teacher_name = htmlspecialchars($_REQUEST['teacher_name']);
$subject = htmlspecialchars($_REQUEST['subject']);
$power = htmlspecialchars($_REQUEST['power']);
$resetpass = isset($_REQUEST['resetpass']);
$passcode= md5(sha1(sha1($teacher)));

require_once("../Db.php");
$DB= new DB_MYSQL();
if($resetpass)
	$sql = array(
		'teacher_name' => $teacher_name,
		'subject' => $subject,
		'power' => $power,
		'pwd' => $passcode);
else
	$sql = array(
		'teacher_name' => $teacher_name,
		'subject' => $subject,
		'power' => $power);

$result = $DB->update("teacher",$sql,"teacher = '$teacher'");
if ($result){
	echo json_encode(array(
		'teacher_name' => $teacher_name,
		'subject' => $subject,
		'power' => $power,
	));
} else {
	echo json_encode(array('errorMsg'=>$DB->errormsg));
}

?>