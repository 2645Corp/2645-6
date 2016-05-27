<?php

require_once("../Db.php");

$term= $_REQUEST['term'];
$subject= $_REQUEST['subject'];

$DB= new DB_MYSQL();
$where = "subject like '$subject'";
$result = array();
$class_tmp = array();

$majors = $DB->get_all("select * from major");
foreach($majors as $major)
{
	$tablename="sem".$term."_maj".$major['major'];
	$row= $DB->get_one("select count(*) from ".$tablename." where ".$where);
	
	if($row['count(*)']>0)
	{
		$classes= $DB->get_all("select * from class where major=".$major['major']);
		foreach($classes as $class)
		{
			$flag = true;
			foreach($class_tmp as $tmp)
			{
				if($tmp['class'] == $class['class'])
				{
					$flag = false;
					break;
				}
			}	
			if(flag)
			{
				//$students = $DB->get_all("select * from student where class=".$class['class']);
				$student = $DB->get_one("select * from student where class=".$class['class']);
				if(count($student > 0))
				{
					$student_a = $student;
					$teacher_name = array();
					$teacher = $DB->get_one("select * from sem".$term."_xk where student=".$student_a['student']);
					
					if($teacher['sj'.$subject]!=NULL)
					{
						$teacher_name = $DB->get_one("select * from teacher where teacher=".$teacher['sj'.$subject]);
					}
						
				}
				$class_tmp[] = array(
						"class"=>$class['class'],
						"class_name"=>$class['class_name'],
						"teacher"=>$teacher['sj'.$subject],
						"teacher_name"=>$teacher_name['teacher_name']
					);
			}
		}
		
	}
}

$count = count($class_tmp);
$result["total"] = "$count";
$result["classes"] = $class_tmp;

echo json_encode($result);

?>