<?php
header("Content-Type:text/html;   charset='utf8'"); 
if($_POST['leadExcel'] == "true")
{
    $filename = $_FILES['inputExcel']['name'];
    $tmp_name = $_FILES['inputExcel']['tmp_name'];
    uploadFile($filename,$tmp_name);
}
//导入Excel文件
function uploadFile($file,$filetempname) 
{
    //自己设置的上传文件存放路径
    $filePath = '../../upload/';
    $str = "";   
    //下面的路径按照你PHPExcel的路径来修改
    require_once '../../PHPExcel/Classes/PHPExcel.php';
    require_once '../../PHPExcel/Classes/PHPExcel/IOFactory.php';
    require_once '../../PHPExcel/Classes/PHPExcel/Reader/Excel5.php';
	require_once("../Db.php");
    //注意设置时区
    $time=date("y-m-d-H-i-s");//去当前上传的时间 
    //获取上传文件的扩展名
    $extend=strrchr ($file,'.');
    //上传后的文件名
    $name=$time.$extend;
    $uploadfile=$filePath.$name;//上传后的文件名地址 
    //move_uploaded_file() 函数将上传的文件移动到新位置。若成功，则返回 true，否则返回 false。
    $result=move_uploaded_file($filetempname,$uploadfile);//假如上传到当前目录下
    //echo $result;
    if($result) //如果上传文件成功，就执行导入excel操作
    {
		if (strtolower ( $extend ) == ".xls")              
        	$objReader = PHPExcel_IOFactory::createReader('Excel5');//use excel5 for xls format 
		else if(strtolower ( $extend ) == ".xlsx")
			$objReader = PHPExcel_IOFactory::createReader('Excel2007');//use excel2007 for xlsx format 
        else
		{
			unlink($uploadfile); //删除上传文件
			echo json_encode(array('errorMsg'=>"文件格式错误！"));
			die();
		}
        $objPHPExcel = $objReader->load($uploadfile); 
        $sheet = $objPHPExcel->getSheet(0); 
        $highestRow = $sheet->getHighestRow();           //取得总行数 
        $highestColumn = $sheet->getHighestColumn(); //取得总列数
        
        /* 第二种方法*/
        $objWorksheet = $objPHPExcel->getActiveSheet();
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);//总列数
        $headtitle=array(); 
		$DB= new DB_MYSQL(); //连接数据库
		$success= true;
		$errorMsg_plus= "";
        for ($row = 2;$row <= $highestRow;$row++) 
        {
            $strs=array();
            //注意highestColumnIndex的列数索引从0开始
            for ($col = 0;$col < $highestColumnIndex;$col++)
            {
                $strs[$col] =$objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
            }
			if($strs[3]=='男')
				$strs[3]='M';
			else if($strs[3]=='女')
				$strs[3]='F';
			$class=$strs[2];
			$class_a=$DB->get_one("select * from class where class = '$class'");
			if(!empty($class_a))	
			{
				$sql = array(
					'student' => $strs[0],
					'student_name' => $strs[1],
					'class' => $strs[2],
					'gender' => $strs[3],
					'id' => $strs[4]);
				$result = $DB->insert('student',$sql);
				$success = $success && $result;
				$terms= $DB->get_all("select term from term");
				foreach($terms as $term)
				{
					$result &= $DB->insert("sem".$term['term']."_xk",array('student'=>$strs[0]));	
				}
				$success = $success && $result;
			}
			else
			{
				$errorMsg_plus = $errorMsg_plus."Query Error: insert into student(student,student_name,class,gender,id) values('".$strs[0]."','".$strs[1]."','".$strs[2]."','".$strs[3]."','".$strs[4]."') Invalid value for key 'class'.";
				$success=false;
				continue;
			}	
			if ($result){
				continue;
			} else {
				$errorMsg_plus = $errorMsg_plus.$DB->errormsg;
			}
        }
		unlink($uploadfile); //删除上传的excel文件
		if($success)
			echo json_encode(array('okMsg'=>"导入成功！"));
		else echo json_encode(array('errorMsg'=>$errorMsg_plus));		
    }
    else
    {
	   unlink($uploadfile);
	   echo json_encode(array('errorMsg'=>"文件上传失败！"));
    } 
    return;
}
?>