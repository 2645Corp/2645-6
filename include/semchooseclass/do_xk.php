<?php

require_once("../Db.php");

$term = $_REQUEST['term'];
$subject = $_REQUEST['subject'];
$class = $_REQUEST['class'];
$teacher = $_REQUEST['teacher'];

$DB= new DB_MYSQL();
$where = "class like '$class'";
$result = true;
$errormsg_plus = "";
//$class_tmp = array();

$students = $DB->get_all("select * from student where ".$where);
foreach($students as $student)
{
	if($teacher == "null")
	{
		$result_a = $DB->query("update sem".$term."_xk set sj".$subject."=null where student=".$student['student']);
		if(!$result_a)
			$errormsg_plus = $errormsg_plus.$DB->errormsg.",";
		$result &= $result_a;
		//删除成绩表记录
		$student_a = $student['student'];
		$result_a = $DB->delete("sem".$term."_sj".$subject."_grade","student='$student_a'");	
		if(!$result_a)
			$errormsg_plus = $errormsg_plus.$DB->errormsg.",";
		$result &= $result_a;
	}
	else
	{
		$sql = array(
			'sj'.$subject => $teacher
		);
		$student_a = $student['student'];
		$result_a = $DB->update("sem".$term."_xk",$sql,"student = '$student_a'");
		if(!$result_a)
			$errormsg_plus = $errormsg_plus.$DB->errormsg.",";
		$result &= $result_a;
		//添加成绩表记录
		$result_a = $DB->insert("sem".$term."_sj".$subject."_grade",array('student'=>$student_a));	
		if(!$result_a)
			$errormsg_plus = $errormsg_plus.$DB->errormsg.",";
		$result &= $result_a;
	}
		
}

if($result)
	echo json_encode(array("isError"=>"false"));
else echo json_encode(array("isError"=>"true","msg"=>$errormsg_plus));

?>