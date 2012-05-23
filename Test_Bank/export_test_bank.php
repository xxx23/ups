<?php
ini_set('display_errors',1);
	error_reporting(E_ALL);
	require_once("../config.php");
	require_once("../session.php");
	checkMenu("/Test_Bank/test_bank.php");
	
	include("../library/content.php");
	//include("../library/file.php");
	
	$Content_cd = $_GET['content_cd'];
	$Teacher_cd = $_SESSION['personal_id'];
	$Teacher_cd_with_content = get_Teacher_id($Content_cd);
	$Test_bank_id = $_GET['test_bank_id'];
	
	//make sure input ok 
	if($Content_cd == 0 or $Test_bank_id==0) {
		return ;
	}
	
	
	$file_path_arr = array();
	
	$path = $DATA_FILE_PATH.$Teacher_cd_with_content."/export_data/";
	$test_bank_path = $DATA_FILE_PATH.$Teacher_cd_with_content . '/test_bank/';
	
	if( !file_exists($path) ) {
		createPath($path);
	}

	$sql = "select test_bank_name from content_test_bank where content_cd=$Content_cd and test_bank_id=$Test_bank_id";
    $Test_bank_name = db_getOne($sql);
    //匯出壓縮檔內編碼有問題所以先定為固定的英文名稱
    //$file_name = $Test_bank_name.".xls";
     $file_name = "test_bank_info.xls";
	//匯出檔案
	$file_fd = export_testbank_excel($Content_cd, $Test_bank_id, $path, $file_name);
	
    	
	//如果檔案存在先移除
	if( file_exists($path.$Test_bank_name.".rar") ){
		unlink($path.$Test_bank_name.".rar");
	}
	
	//指定.xls檔
	$rar_cmd_files = ' "' . $path.$file_name . '"';
	
	//改名
	$rename_list = "$RAR_PATH rn -w$path ".$path.$Test_bank_name.".rar ";
	
	if( !empty($file_path_arr) ) {
		foreach($file_path_arr as $index => $files){
			if( isset($files['pic']) ) {
				$rar_cmd_files .= ' "'.$test_bank_path.$files['pic'].'" ';
				$rename_list .= " '{$files['pic']}'  '{$files['rn_pic']}' ";
			}			
			if( isset($files['av']) ) {
				$rar_cmd_files .= ' "'.$test_bank_path.$files['av'].'" ';
				$rename_list .= " '{$files['av']}' '{$files['rn_av']}' ";
			}
			
		}
	}
	//壓縮
	$rar_cmd = "$RAR_PATH a -ep '$path$Test_bank_name".".rar' " . $rar_cmd_files ;
	//well_print($rar_cmd);
	exec($rar_cmd);
	exec($rename_list);
	
	//well_print($rename_list);	die($path.$Test_bank_name.".rar");
	
	//回傳給 browser 
	return_file($file_fd, $path, $Test_bank_name.".rar");
	
	function export_testbank_excel($Content_cd, $Test_bank_id, $path, $file_name)
	{
	  global $DB_CONN, $file_path_arr;
	  
	  $path .= $file_name;

      require_once('../library/PHPExcel.php');
      require_once('../library/PHPExcel/IOFactory.php');
      $objPHPExcel = new PHPExcel();
      // Set properties
      $objPHPExcel->getProperties()->setCreator("MOE UPS")
                                 ->setLastModifiedBy("MOE UPS")
                                 ->setTitle("test_bank export")
                                 ->setSubject("office 2003 document")
                                 ->setDescription("This document is test data")
                                 ->setKeywords("office 2003")
                                 ->setCategory("test bank file");

        // Add some data
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValueByColumnAndRow(0, 1, '題型')
                    ->setCellValueByColumnAndRow(1, 1, '題目內容')
                    ->setCellValueByColumnAndRow(2, 1, '選項數')
                    ->setCellValueByColumnAndRow(3, 1, '第一選項')
                    ->setCellValueByColumnAndRow(4, 1, '第二選項')
                    ->setCellValueByColumnAndRow(5, 1, '第三選項')
                    ->setCellValueByColumnAndRow(6, 1, '第四選項')
                    ->setCellValueByColumnAndRow(7, 1, '第五選項')
                    ->setCellValueByColumnAndRow(8, 1, '第六選項')
                    ->setCellValueByColumnAndRow(9, 1, '單複選')
                    ->setCellValueByColumnAndRow(10, 1, '答案')
                    ->setCellValueByColumnAndRow(11, 1, '詳解')
                    ->setCellValueByColumnAndRow(12, 1, '題目難易度')
                    ->setCellValueByColumnAndRow(13, 1, '順序性')
                    ->setCellValueByColumnAndRow(14, 1, '圖片檔名')
                    ->setCellValueByColumnAndRow(15, 1, '影音檔名');

	  $sql = "select * from test_bank where content_cd=$Content_cd and test_bank_id=$Test_bank_id";
	  $result = db_query($sql);
	  
	  //count 
	  $index = 1;
	  while(($row = $result->fetchRow(DB_FETCHMODE_ASSOC)))
	  {
	    if($row['test_type'] == 1)
	      $type = "選擇題";
	    else if($row['test_type'] == 2)
	      $type = "是非題";
	    else if($row['test_type'] == 3)
	      $type = "填充題";
	    else
	      $type = "簡答題";

	    if($row['difficulty'] == 0)
	      $degree = "易";
	    else if($row['difficulty'] == 1)
	      $degree = "中";
	    else
	      $degree = "難";

	    if($row['is_multiple'] == 0)
	      $mult = "單選";
	    else
	      $mult = "複選";

	    if($row['if_ans_seq'] == 0)
	      $seq = "不依序";
	    else
	      $seq = "依序";

		
		if( !empty($row['file_picture_name']) ) {
			$file_path_arr[$index]['pic']= $row['file_picture_name'] ;
			$file_path_arr[$index]['rn_pic'] = $index.'_pic.'.File_subtype($row['file_picture_name']);
			$row['file_picture_name'] = $file_path_arr[$index]['rn_pic'];
		}
			
		if( !empty($row['file_av_name']) ) {
			$file_path_arr[$index]['av'] = $row['file_av_name'];
			$file_path_arr[$index]['rn_av'] = $index.'_av.'.File_subtype($row['file_av_name']);
			$row['file_av_name'] = $file_path_arr[$index]['rn_av'];			
		}
		
	    $num = $row['selection_no'] ;
        // Add some data
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValueByColumnAndRow(0, $index+1, $type)
                    ->setCellValueByColumnAndRow(1, $index+1,  $row['question'])
                    ->setCellValueByColumnAndRow(2, $index+1,  $num)
                    ->setCellValueByColumnAndRow(3, $index+1,  $row['selection1'])
                    ->setCellValueByColumnAndRow(4, $index+1,  $row['selection2'])
                    ->setCellValueByColumnAndRow(5, $index+1,  $row['selection3'])
                    ->setCellValueByColumnAndRow(6, $index+1,  $row['selection4'])
                    ->setCellValueByColumnAndRow(7, $index+1,  $row['selection5'])
                    ->setCellValueByColumnAndRow(8, $index+1,  $row['selection6'])
                    ->setCellValueByColumnAndRow(9, $index+1,  $mult)
                    ->setCellValueByColumnAndRow(10, $index+1,  $row['answer'])
                    ->setCellValueByColumnAndRow(11, $index+1,  $row['answer_desc'])
                    ->setCellValueByColumnAndRow(12, $index+1,  $degree)
                    ->setCellValueByColumnAndRow(13, $index+1,  $seq)
                    ->setCellValueByColumnAndRow(14, $index+1,  $row['file_picture_name'])
                    ->setCellValueByColumnAndRow(15, $index+1,  $row['file_av_name']);
		$index++;
	  }
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save($path); 
	}
	
	
function return_file($file, $file_path, $file_name)
{
	if(!is_readable($file_path.$file_name)){
		die("Cannot Open File?!");
	}
	else{
		header("Cache-Control:");// leave blank to avoid IE errors
		header("Pragma:");// leave blank to avoid IE errors
		header("Content-type: application/octet-stream; charset=utf-8");
		
		header("Content-Disposition: attachment; filename=\"".iconv("UTF-8", "big5", $file_name)."\"");
		header("Content-length:".(string)(filesize($file_path.$file_name))."\"");
		readfile($file_path.$file_name);
	}
}
?>
