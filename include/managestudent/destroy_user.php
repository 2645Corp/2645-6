<?php

$id = $_REQUEST['id'];

$ids = explode(',',$id);


require_once("../Db.php");
$DB= new DB_MYSQL();
$terms= $DB->get_all("select term from term");
$subjects= $DB->get_all("select subject from subject");
foreach($ids as &$iid)
{
	$result= true;
	$result= $result && $DB->delete("student","student='$iid'");
	foreach($terms as $term)
	{
		$result &= $DB->delete("sem".$term['term']."_xk","student='$iid'");
		foreach($subjects as $subject)
			$result &= $DB->delete("sem".$term['term']."_sj".$subject['subject']."_grade","student='$iid'");
	}
}

if ($result){
	echo json_encode(array('success'=>true));
} else {
	echo json_encode(array('errorMsg'=>$DB->errormsg));
}
?>