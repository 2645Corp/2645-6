<?php

$id = $_REQUEST['id'];
$term = $_REQUEST['term'];
$major = $_REQUEST['major'];
$table_name="sem".$term."_maj".$major;

$ids = explode(',',$id);

require_once("../Db.php");
$DB= new DB_MYSQL();
foreach($ids as &$iid)
{
	$result= true;
	$result= $result && $DB->delete($table_name,"subject='$iid'");
}

if ($result){
	echo json_encode(array('success'=>true));
} else {
	echo json_encode(array("isError"=>"true","msg"=>$DB->errormsg));
}
?>