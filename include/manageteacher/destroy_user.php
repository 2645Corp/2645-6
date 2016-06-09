<?php

$id = $_REQUEST['id'];

$ids = explode(',',$id);


require_once("../Db.php");
$DB= new DB_MYSQL();

foreach($ids as &$iid)
{
	$result= true;
	$result= $result && $DB->delete("teacher","teacher='$iid'");
}

if ($result){
	echo json_encode(array('success'=>true));
} else {
	echo json_encode(array('errorMsg'=>$DB->errormsg));
}
?>