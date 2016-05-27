<?php

$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'subject';
$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
$itemid = isset($_POST['itemid']) ? $_POST['itemid'] : '%';
$offset = ($page-1)*$rows;

require_once("../Db.php");

$term= @$_GET['term'];
$major= @$_GET['major'];
$table_name="sem".$term."_maj".$major;

$DB= new DB_MYSQL();
$where = "subject.subject_name like '$itemid' or ".$table_name.".period like '$itemid' or ".$table_name.".score like '$itemid' or ".$table_name.".maxgrade like '$itemid'";
$result = array();
$row= $DB->get_one("select count(*) from ".$table_name.", subject where ".$table_name.".subject = subject.subject and (".$where.")");
$result["total"] = $row['count(*)'];
$items= $DB->get_all("select ".$table_name.".*, subject.subject_name from ".$table_name.", subject where ".$table_name.".subject = subject.subject and (".$where.") order by $sort $order limit $offset,$rows");
$result["rows"] = $items;
//while($row = mysql_fetch_object($rs)){
//	array_push($result, $row);
//}
	echo json_encode($result);

?>