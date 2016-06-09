<?php

$term = intval($_REQUEST['term']);
$term_name = $_REQUEST['term_name'];
$startdate = $_REQUEST['startdate'];
$enddate = $_REQUEST['enddate'];

require_once("../Db.php");
$DB= new DB_MYSQL();

$sql = array(
	'term_name' => $term_name,
	'startdate' => $startdate,
	'enddate' => $enddate
);
$result= $DB->update("term",$sql,"term = '$term'");
if($result)
	echo json_encode($sql);
else echo json_encode(array("isError"=>"true","msg"=>$DB->errormsg));
?>