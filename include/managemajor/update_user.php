<?php

$major = intval($_REQUEST['major']);
$major_name = $_REQUEST['major_name'];

require_once("../Db.php");
$DB= new DB_MYSQL();

$sql = array(
	'major_name' => $major_name,
);
$result= $DB->update("major",$sql,"major = '$major'");
if($result)
	echo json_encode($sql);
else echo json_encode(array("isError"=>"true","msg"=>$DB->errormsg));
?>