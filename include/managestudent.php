<?php
require_once("smarty.php");

session_start();
if(isset($_SESSION['userflag']) && $_SESSION['userflag'] == "admin")
{
	$smarty->assign("dir","managestudent");
	$smarty->assign("url","121.42.163.214/2645-6");
	$smarty->assign("primate","student");
	require_once("Db.php");
	$DB= new DB_MYSQL();
	
	$th[]=array("field"=>"student","title"=>"学号");
	$th[]=array("field"=>"student_name","title"=>"姓名");
	$th[]=array("field"=>"class","title"=>"班级id","hidden"=>"true");
	$th[]=array("field"=>"class_name","title"=>"班级");
	$th[]=array("field"=>"gender","title"=>"性别id","hidden"=>"true");
	$th[]=array("field"=>"gender_name","title"=>"性别");
	$th[]=array("field"=>"id","title"=>"身份证号码");
    $smarty->assign("TableHeads",$th);
	
	$title_new=array("添加学生","学生信息");
	$title_edit=array("修改学生","学生信息");
	$smarty->assign("FormNewTitle",$title_new);
	$smarty->assign("FormEditTitle",$title_edit);
	
	$fh_new[]=array("title"=>"学号","content"=>'<input class="easyui-textbox" name="student" required="true" missingMessage="此字段为必填项"/>');
	$fh_new[]=array("title"=>"姓名","content"=>'<input class="easyui-textbox" name="student_name" required="true" missingMessage="此字段为必填项"/>');
	$classes= $DB->get_all("select class, class_name from class");
	$bj_editor= '<select class="easyui-combobox" name="class" style="width:120px;" data-options="editable:false">';
	foreach($classes as $class)
	{
		$bj_editor.='<option value="';
		$bj_editor.=$class['class'];
		$bj_editor.='">';
		$bj_editor.=$class['class_name'];
		$bj_editor.='</option>';
	}
	$bj_editor.='</select>';
	$fh_new[]=array("title"=>"班级","content"=>$bj_editor);
	$fh_new[]=array("title"=>"性别","content"=>
	'
	<select class="easyui-combobox" name="gender" style="width:50px;" data-options="editable:false">
        <option value="M">男</option>
        <option value="F">女</option>
	</select>
	');
	$fh_new[]=array("title"=>"身份证号码","content"=>'<input class="easyui-textbox" name="id" required="true" missingMessage="此字段为必填项"/>');
	$smarty->assign("Form_new",$fh_new);

	$fh_edit[]=array("title"=>"学号","content"=>'<input class="easyui-textbox" name="student" required="true" readonly="true" missingMessage="此字段为必填项"/>');	
	$fh_edit[]=array("title"=>"姓名","content"=>'<input class="easyui-textbox" name="student_name" required="true" missingMessage="此字段为必填项"/>');	
	$fh_edit[]=array("title"=>"班级","content"=>$bj_editor);
	$fh_edit[]=array("title"=>"性别","content"=>
	'
	<select class="easyui-combobox" name="gender" style="width:50px;" data-options="editable:false">
        <option value="M">男</option>
        <option value="F">女</option>
	</select>
	');
	$fh_edit[]=array("title"=>"身份证号码","content"=>'<input class="easyui-textbox" name="id" required="true" missingMessage="此字段为必填项"/>');
	$smarty->assign("Form_edit",$fh_edit);
	$smarty->display("crud1.html");
}
else
{
	print("Access Denied");
    echo "<script language=\"JavaScript\">alert(\"你好，请先登录！\");window.location.replace('../../index.php');</script>";
}
?>