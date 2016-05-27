<?php

$subject = intval($_REQUEST['subject']);
$subject_name = $_REQUEST['subject_name'];

require_once("../Db.php");
$DB= new DB_MYSQL();

$sql = array(
	'subject_name' => $subject_name,
);
$result= $DB->update("subject",$sql,"subject = '$subject'");
if($result)
	echo json_encode($sql);
else echo json_encode(array("isError"=>"true","msg"=>$DB->errormsg));
?>