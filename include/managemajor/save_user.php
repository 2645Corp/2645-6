<?php

$major_name = $_REQUEST['major_name'];

require_once("../Db.php");
$DB= new DB_MYSQL();

$sql = array(
	'major_name' => $major_name,
);
$result= $DB->insert("major",$sql);
$id= $DB->insert_id();
$sql2 = array(
	'major' => $id,
	'major_name' => $major_name
);
$terms= $DB->get_all("select term from term");
foreach($terms as $term)
{
	$DB->query("create table sem".$term['term']."_maj".$id." ( subject smallint NOT NULL, period smallint, score tinyint NOT NULL, maxgrade smallint NOT NULL, PRIMARY KEY (subject) );");
}
if($result)
	echo json_encode($sql2);
else echo json_encode(array("isError"=>"true","msg"=>$DB->errormsg));

?>