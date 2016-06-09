<?php
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'teacher';
	$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
	$itemid = isset($_POST['itemid']) ? $_POST['itemid'] : '%';
	$offset = ($page-1)*$rows;
	$result = array();

	require_once("../Db.php");
	$DB= new DB_MYSQL();

	$where = "teacher.teacher like '$itemid' or teacher.teacher_name like '$itemid' or teacher.subject like '$itemid' or subject.subject_name like '$itemid' or power like '$itemid'";
	$row= $DB->get_one("select count(*) from teacher, subject where teacher.subject = subject.subject and (".$where.")");
	$result["total"] = $row['count(*)'];
	$items= $DB->get_all("select teacher.*, subject.subject_name from teacher, subject where teacher.subject = subject.subject and (".$where.") order by $sort $order limit $offset,$rows");
	$result["rows"] = $items;
	
//	$rs = mysql_query("select count(*) from users");
//	$row = mysql_fetch_row($rs);
//	$result["total"] = $row[0];
//	$rs = mysql_query("select * from users limit $offset,$rows");
//	
//	$items = array();
//	while($row = mysql_fetch_object($rs)){
//		array_push($items, $row);
//	}
//	$result["rows"] = $items;

	echo json_encode($result);

?>