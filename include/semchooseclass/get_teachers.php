<?php

require_once("../Db.php");

$term= $_REQUEST['term'];
$subject= $_REQUEST['subject'];

$DB= new DB_MYSQL();
$where = "subject like '$subject'";
$result = array();
$row= $DB->get_one("select count(*) from teacher where ".$where);
$result["total"] = $row['count(*)'];
$items= $DB->get_all("select * from teacher where ".$where);
$result["teachers"] = $items;
//while($row = mysql_fetch_object($rs)){
//	array_push($result, $row);
//}
echo json_encode($result);

?>