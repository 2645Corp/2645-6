<?php
require_once("smarty.php");
require_once("Db.php");
$DB= new DB_MYSQL();

session_start();
if(isset($_SESSION['userflag']) && $_SESSION['userflag'] == "admin")
{
	$smarty->assign("dir","manageteacher");
	$smarty->assign("url","121.42.163.214/2645-6");
	$smarty->assign("primate","teacher");
	$th[]=array("field"=>"teacher","title"=>"教师ID");
	$th[]=array("field"=>"teacher_name","title"=>"姓名");
	$th[]=array("field"=>"subject_name","title"=>"科目");
	$th[]=array("field"=>"power","title"=>"权限");
	$th[]=array("field"=>"pwd","title"=>"密码");
    $smarty->assign("TableHeads",$th);
	$title_new=array("添加教师","教师信息");
	$title_edit=array("修改教师","教师信息");
	$smarty->assign("FormNewTitle",$title_new);
	$smarty->assign("FormEditTitle",$title_edit);
	$fh_new[]=array("content"=>'<input class="easyui-textbox" name="teacher"  required="true"  missingMessage="此字段为必填项"/>',"title"=>"教师ID");
	$fh_new[]=array("content"=>'<input class="easyui-textbox" name="teacher_name"  missingMessage="此字段为必填项"/>',"title"=>"姓名");
	$select_data= $DB->get_all("select * from subject");
	$options= "";
	foreach($select_data as $data_loop)
	{
		$options= $options."<option value=\"".$data_loop['subject']."\" editable=\"false\">".$data_loop['subject_name']."</option>";
	}
	$fh_new[]=array("content"=>'<select id="cc" class="easyui-combobox" data-options="editable:false" name="subject" style="width:150px;" required="true"  missingMessage="此字段为必填项"/>'.$options."</select>","title"=>"科目");
	$fh_new[]=array("content"=>'<input class="easyui-textbox" name="power"  required="true"  missingMessage="此字段为必填项"/>',"title"=>"<abbr title='包括admin,headteacher,leader,teacher,用逗号隔开'>权限</abbr>");
	$smarty->assign("Form_new",$fh_new);
	$fh_edit[]=array("content"=>'<input class="easyui-textbox" name="teacher"  required="true"  missingMessage="此字段为必填项" readonly="true"/>',"title"=>"教师ID");
	$fh_edit[]=array("content"=>'<input class="easyui-textbox" name="teacher_name"  missingMessage="此字段为必填项"/>',"title"=>"姓名");
	$fh_edit[]=array("content"=>'<select class="easyui-combobox" data-options="editable:false" name="subject" style="width:150px;" required="true"  missingMessage="此字段为必填项"/>'.$options."</select>","title"=>"科目");
	$fh_edit[]=array("content"=>'<input class="easyui-textbox" name="power"  required="true"  missingMessage="此字段为必填项"/>',"title"=>"<abbr title='包括admin,headteacher,leader,teacher,用逗号隔开'>权限</abbr>");
	$fh_edit[]=array("content"=>'<input class="easyui-switchbutton" name="resetpass"  missingMessage="此字段为必填项" />',"title"=>"重置密码");	
	$smarty->assign("Form_edit",$fh_edit);
	$smarty->display("crud1.html");
}
else
{
	print("Access Denied");
    echo "<script language=\"JavaScript\">alert(\"你好，请先登录！\");window.location.replace('../../index.php');</script>";
}
?>