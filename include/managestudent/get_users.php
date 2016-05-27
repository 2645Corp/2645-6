<?php
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'student';
	$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
	$itemid = isset($_POST['itemid']) ? $_POST['itemid'] : '%';
	$offset = ($page-1)*$rows;
	$result = array();

	require_once("../Db.php");
	$DB= new DB_MYSQL();

	$where = "student.student like '$itemid' or student.student_name like '$itemid' or student.class like '$itemid' or class.class_name like '$itemid' or student.gender like '$itemid' or student.id like '$itemid'";
	$row= $DB->get_one("select count(*) from student, class where student.class = class.class and (".$where.")");
	$result["total"] = $row['count(*)'];
	$items= $DB->get_all("select student.*, class.class_name from student, class where student.class = class.class and (".$where.") order by $sort $order limit $offset,$rows");
	$i=0;
	foreach($items as $k=>$v)
	{
		if($v['gender']=='M')
			$items[$i]['gender_name']='男';
		else
			$items[$i]['gender_name']='女';
		$i++;
	}
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