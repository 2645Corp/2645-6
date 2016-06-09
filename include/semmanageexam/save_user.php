<?php

session_start();
$exam_name = htmlspecialchars($_REQUEST['exam_name']);
$begintime = htmlspecialchars($_REQUEST['begintime']);
$endtime = htmlspecialchars($_REQUEST['endtime']);
$subject_a = $_REQUEST['subject'];
$subject_a= str_replace('\\','',$subject_a);
$subjects= json_decode(    trim(

        $subject_a,

        chr(239).chr(187).chr(191)

    ),

    true);
$class_a= $_REQUEST['class'];
$classes= explode(",",$class_a);
$exam= $_SESSION['username']."_".date('U');
$sj_num= count($subjects);
$class_num= count($classes);
$term= $_GET['term'];

require_once("../Db.php");
$DB= new DB_MYSQL();
$result = true;
foreach($subjects as $subject)
{
	$sql = array(
		'exam' => $exam,
		'exam_name' => $exam_name,
		'sj_num' => $sj_num,
		'class_num' => $class_num,
		'classes' => $class_a,
		'publisher' => $_SESSION['username'],
		'maxgrade' => $subject['maxgrade'],
		'begintime' => $begintime,
		'endtime' => $endtime
		);
	$table_name= "sem".$term."_sj".$subject['subject']."_exam";

	$result &= $DB->insert($table_name,$sql);	
}

	$sql2 = array(
		'exam_name' => $exam_name,
		'sj_num' => $sj_num,
		'class_num' => $class_num,
		'classes' => $class_a,
		'publisher' => $_SESSION['username'],
		'begintime' => $begintime,
		'endtime' => $endtime
		);
if ($result){
	echo json_encode($sql2);
} else {
	echo json_encode(array('errorMsg'=>$DB->errormsg));
}
?>
