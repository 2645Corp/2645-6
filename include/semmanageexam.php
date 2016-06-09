<?php
require_once("smarty.php");

session_start();
$term= @$_GET['term'];
if(isset($_SESSION['userflag']) && $_SESSION['userflag'] == "admin")
{
	$smarty->assign("dir","semmanageexam");
	$smarty->assign("url","121.42.163.214/2645-6");
	$smarty->assign("primate","exam");
	$smarty->assign("term",$term);
	
	require_once("Db.php");
	$DB= new DB_MYSQL();
	
	$subjects= $DB->get_all("select * from subject");
	$sj[]=array("subject"=>'ALL',"subject_name"=>'全部');
	foreach($subjects as $subject)
		$sj[]=array("subject"=>$subject['subject'],"subject_name"=>$subject['subject_name']);
	$smarty->assign("Subjects",$sj);
	
	$th[]=array("field"=>"exam","title"=>"考试id","hidden"=>"true");
	$th[]=array("field"=>"exam_name","title"=>"考试");
	$th[]=array("field"=>"sj_num","title"=>"参加考试的科目数");
	$th[]=array("field"=>"class_num","title"=>"参加考试的班级数");
	$th[]=array("field"=>"classes","title"=>"参加考试的班级");
	$th[]=array("field"=>"publisher","title"=>"发布者id","hidden"=>"true");
	$th[]=array("field"=>"teacher_name","title"=>"发布者");
	$th[]=array("field"=>"maxgrade","title"=>"满分");
	$th[]=array("field"=>"begintime","title"=>"开始时间");
	$th[]=array("field"=>"endtime","title"=>"结束时间");
    $smarty->assign("TableHeads",$th);
	
	$title_new=array("发布考试","考试信息");
	$title_edit=array("修改考试","考试信息");
	$smarty->assign("FormNewTitle",$title_new);
	$smarty->assign("FormEditTitle",$title_edit);
	
	$fh_new[]=array("title"=>"考试名称","content"=>'<input class="easyui-textbox" name="exam_name" required="true" missingMessage="此字段为必填项"/>');
	$fh_new[]=array("title"=>"开始时间","content"=>'<input class="easyui-datetimebox" name="begintime" required="true"/>');
	$fh_new[]=array("title"=>"结束时间","content"=>'<input class="easyui-datetimebox" name="endtime" required="true"/>');
	
	$classes= $DB->get_all("select class, class_name from class");
	$classes= json_encode($classes);
	$classes= str_replace('"','\'',$classes);
	$subjects= $DB->get_all("select subject, subject_name from subject");
	$subjects= json_encode($subjects);
	$subjects= str_replace('"','\'',$subjects);
	$bj_editor= "<input id=\"cc2\" class=\"easyui-combobox\" required=\"true\" missingMessage=\"此字段为必填项\"
			name=\"class\"
			data-options=\"
					data:$classes,
					editable:false,
					valueField:'class',
					textField:'class_name',
					multiple:true,
					panelHeight:'200px'
			\">";
	$km_editor='<select id="cc" name="subject" multiple="true" style="width:200px" missingMessage="此字段为必填项"></select>
	<div id="sp">
		<div style="color:#99BBE8;background:#fafafa;padding:5px;">设置考试的科目和各科满分</div>
		<div style="padding:10px">';
	$subjects= $DB->get_all("select * from subject");
		foreach($subjects as $subject)
		{
			$km_editor.='<input type="checkbox" value="';
			$km_editor.=$subject['subject'];
			$km_editor.='"><span>';
			$km_editor.=$subject['subject_name'];
			$km_editor.='</span>&emsp;满分：<input class="easyui-textbox" style="width:40px" value="100" disabled="true" /><br/>';
		}
		$km_editor.='</div>
	</div>
	<script type="text/javascript">'.
		"$(function(){
			$('#cc').combo({
				required:true,
				editable:false
			});
			$('#sp').appendTo($('#cc').combo('panel'));
			$(\"#sp input[type='checkbox']\").click(function(){
				var v = $(this).val();
				var s = $(this).next('span').text();
				var valu = $('#cc').combo('getValue');
				if(typeof(valu)=='undefined')
					var json = new Array();
				else var json = eval('(' + valu + ')');
				if($(this).is(':checked')){
					var arr = { \"subject\":v, \"maxgrade\":$(this).next().next().next().children('input').val() };
					$(this).next().next().next().children('input').removeAttr('disabled');
					json.push(arr);
					valu = JSON.stringify(json);
					if($('#cc').combo('getText')=='')
						$('#cc').combo('setValue', valu).combo('setText', s);
					else
						$('#cc').combo('setValue', valu).combo('setText',$('#cc').combo('getText')+','+s);
				}
				else
				{
					$(this).next().next().next().children('input').attr('disabled','true');
					for (var i = 0; i < json.length; i++) {
           				var cur_person = json[i];
						if (cur_person.subject == v) {
							json.splice(i, 1);
						}
					}
					valu = JSON.stringify(json);
					$('#cc').combo('setValue', valu).combo('setText',$('#cc').combo('getText').replace(s+',',''));			
					$('#cc').combo('setValue', valu).combo('setText',$('#cc').combo('getText').replace(s,''));			
					$('#cc').combo('setValue', valu).combo('setText',$('#cc').combo('getText').replace(',,',','));			
				}
			});
			$(\"#sp input[type='text']\").change(function(){
				var v = $(this).parent().prev().prev().prev().val();
				var s = $(this).val();
				var valu = $('#cc').combo('getValue');
				if(typeof(valu)=='undefined')
					var json = new Array();
				else var json = eval('(' + valu + ')');
				for (var i = 0; i < json.length; i++) {
					var cur_person = json[i];
					if (cur_person.subject == v) {
						json[i].maxgrade = s;
					}
				}
				valu = JSON.stringify(json);
				$('#cc').combo('setValue', valu);
			});
		});
	</script>";
//	$km_editor= "<input id=\"cc\" class=\"easyui-combobox\" 
//			name=\"subject\"
//			data-options=\"
//					data:$subjects,
//					
//					valueField:'subject',
//					textField:'subject_name',
//					multiple:true,
//					panelHeight:'auto'
//			\">";

	$fh_new[]=array("title"=>"考试的科目","content"=>$km_editor);
	$fh_new[]=array("title"=>"考试的班级","content"=>$bj_editor);
	
	$smarty->assign("Form_new",$fh_new);

	$smarty->display("semmanageexam.html");
}
else
{
	print("Access Denied");
    echo "<script language=\"JavaScript\">alert(\"你好，请先登录！\");window.location.replace('../../index.php');</script>";
}
?>