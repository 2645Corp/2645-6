<?php

require_once("../Db.php");

$term= $_REQUEST['term'];
$subject= $_REQUEST['subject'];

$DB= new DB_MYSQL();
//$where = "subject like '$subject'";
//$result = array();
//$row= $DB->get_one("select count(*) from teacher where ".$where);
//$result["total"] = $row['count(*)'];
//$subjects[] = array("subject"=>"default","subject_name"=>"请选择科目...");
$subjects = $DB->get_all("select * from subject");
$sj = array();
$i=0;
$sj[$i]['subject'] = "default";
$sj[$i]['subject_name'] = "请选择科目...";
foreach($subjects as $subject)
{
	$i++;
	$sj[$i]['subject'] = $subject['subject'];
	$sj[$i]['subject_name'] = $subject['subject_name'];
}
//$result["teachers"] = $items;
//while($row = mysql_fetch_object($rs)){
//	array_push($result, $row);
//}
echo json_encode($sj);

?>