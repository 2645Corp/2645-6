<?php

$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
$sort = isset($_REQUEST['sort']) ? strval($_REQUEST['sort']) : 'begintime';
$order = isset($_REQUEST['order']) ? strval($_REQUEST['order']) : 'asc';
$itemid = isset($_POST['itemid']) ? $_POST['itemid'] : '%';
$offset = ($page-1)*$rows;

require_once("../Db.php");

$term= @$_GET['term'];
$subject= $_GET['subject'];

$DB= new DB_MYSQL();

function sortbymaxgrade($a,$b)
{
	global $order;
	if($order=='asc')
	{
		if($a['maxgrade']==$b['maxgrade'])
			return 0;
		else return $a['maxgrade']>$b['maxgrade']?1:-1;
	}
	else
	{
		if($a['maxgrade']==$b['maxgrade'])
			return 0;
		else return $a['maxgrade']>$b['maxgrade']?-1:1;
	}

}

if($subject=='ALL')
{
	$items= array();
	$subjects= $DB->get_all("select subject from subject");

	//多表联合查询
	$tables="";
	$sql="";
	$sql2 = "";
	for($i=0;$i<count($subjects);$i++)
	{
		$table_name="sem".$term."_sj".$subjects[$i]['subject']."_exam";
		$where = "teacher.teacher_name like '$itemid' or ".$table_name.".exam_name like '$itemid' or ".$table_name.".sj_num like '$itemid' or ".$table_name.".class_num like '$itemid' or ".$table_name.".maxgrade like '$itemid'";
		$sql.= "select ".$table_name.".exam, ".$table_name.".exam_name, ".$table_name.".sj_num, ".$table_name.".class_num, ".$table_name.".classes, ".$table_name.".publisher, ".$table_name.".begintime, ".$table_name.".endtime, teacher.teacher_name from ".$table_name.", teacher where ".$table_name.".publisher = teacher.teacher and (".$where.") ";
		$sql2 .= "select count(*) from ".$table_name." ";
		$tables.=$table_name;
		if($i!=count($subjects)-1)
		{
			$sql.="union ";
			$sql2.="union ";
		}
	}
	if($sort != "maxgrade")
		$sql.="order by $sort $order limit $offset,$rows";
	else $sql.="limit $offset,$rows";
	$items= $DB->get_all($sql);

	$fucking= $DB->get_one("SELECT FOUND_ROWS() as fuck");
	//SQL_CALC_FOUND_ROWS 
	//echo $fucking['fuck'];
	$count = $DB->get_one($sql2);
	//算满分
	
	for($i=0;$i<count($items);$i++)
	{
		//$subjects= $DB->get_all("select subject from subject");
		$maxgrade_a = 0;
		$exam = $items[$i]['exam'];
		foreach($subjects as $subject)
		{
			$tb_name = "sem".$term."_sj".$subject['subject']."_exam";
			$cnt = $DB->get_one("select count(*) from ".$tb_name." where exam = '$exam'");
			if($cnt['count(*)'] > 0)
			{
				$tmp = $DB->get_one("select * from ".$tb_name." where exam = '$exam'");
				$maxgrade_a += $tmp['maxgrade'];
			}
		}
		$items[$i]['maxgrade'] = $maxgrade_a;
	}	
	$result=array();
	$result["total"] = $fucking['fuck'];// $count['count(*)'];
	if($sort=="maxgrade")
	{
		usort($items,'sortbymaxgrade');
	}
	$result["rows"] = $items;
}
//不是全部
else
{
	$table_name="sem".$term."_sj".$subject."_exam";
	
	$where = "teacher.teacher_name like '$itemid' or ".$table_name.".exam_name like '$itemid' or ".$table_name.".sj_num like '$itemid' or ".$table_name.".class_num like '$itemid' or ".$table_name.".maxgrade like '$itemid'";
	$result = array();
	$row= $DB->get_one("select count(*) from ".$table_name.", teacher where ".$table_name.".publisher = teacher.teacher and (".$where.")");
	$result["total"] = $row['count(*)'];
	$items= $DB->get_all("select ".$table_name.".*, teacher.teacher_name from ".$table_name.", teacher where ".$table_name.".publisher = teacher.teacher and (".$where.") order by $sort $order limit $offset,$rows");
	$result["rows"] = $items;
	//while($row = mysql_fetch_object($rs)){
	//	array_push($result, $row);
	//}
}
	echo json_encode($result);

?>