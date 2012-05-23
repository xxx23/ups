<?php
	/*author: lunsrot
	 * date: 2007/10/05
     */
	require_once("../config.php");
	require_once("../session.php");
	require_once("../library/content.php");
	
	$input = $_POST;
	if(empty($input['option'])){
		$input['option'] = "view";
		$input['content_cd'] = $_GET['content_cd'];
		$input['test_bank_id'] = $_GET['test_bank_id'];
	}

	call_user_func($input['option'], $input);
	
	//template
	//匯入介面
	function view($input){
        global $DB_CONN;
        global $HOME_PATH;
		require_once($HOME_PATH . 'library/smarty_init.php');

		$get_test_bank_name ="select test_bank_name from content_test_bank "
		." where content_cd={$input['content_cd']} "
		." and test_bank_id={$input['test_bank_id']}";
		
		$test_bank_name = db_getOne($get_test_bank_name);
		
		
		$tpl->assign("test_bank_name", $test_bank_name);
		$tpl->assign("content_cd", $input['content_cd']);
		$tpl->assign("test_bank_id", $input['test_bank_id']);
		assignTemplate($tpl, "/test_bank/import_test_bank.tpl");
	}

	//function
	//匯入題庫
	function import($input){
		global $DATA_FILE_PATH;
		
		$content_cd = get_Content_cd($_SESSION['begin_course_cd']);
		$Teacher_id = get_Teacher_id($content_cd);
	
		
		$Data_path = $DATA_FILE_PATH ."$Teacher_id/test_bank/";
		
		$upload_tmp_file = $_FILES['import']['tmp_name'];
		$tmp_dir = basename($upload_tmp_file);
		$direction_path = $Data_path."extract_tmp/";  // must have '/' , see rar readme
		
        extract_upload_file($Data_path,$direction_path);
        
        //尋找xls檔, glob用pattern match 目錄下的檔
        $xls_file = glob("$direction_path*.xlsx");
        $excel_type = 'Excel2007';

        if(empty($xls_file)){
            $xls_file = glob("$direction_path*.xls");
            $excel_type = 'Excel5';
        }
            
        //echo $direction_path;
		if(1 != count($xls_file)){
            echo "匯入檔有錯誤";
            $remove_all_cmd = "rm -rf $direction_path ";
            system_log($remove_all_cmd);
            system($remove_all_cmd); 
		
            exit(0);
        }
		require_once '../library/PHPExcel.php';
        require_once '../library/PHPExcel/IOFactory.php';
        
//import_excel($xls_file[0]);
        $objReader = PHPExcel_IOFactory::createReader($excel_type);
        $objReader->setReadDataOnly(true);
        $objPHPExcel = $objReader->load($xls_file[0]);
        foreach($objPHPExcel->getWorksheetIterator() as $worksheet)
        {
            $cnt = 0;
            foreach($worksheet->getRowIterator() as $row)
            {
                if($cnt != 0){
                    $time_random = date("mdHis");
                    $cellIterator = $row->getCellIterator();
                    $cellIterator->setIterateOnlyExistingCells(false);
                    foreach($cellIterator as $cell)
                    {   
                        if(!is_null($cell))
                        {
                            $line_element[] = $cell->getCalculatedValue();
                        }
                    }
			        $pic_file = glob($direction_path.$cnt."_pic.*");
			        //print_r($pic_file);
			        if( count( $pic_file ) == 1 ){
                        $line_element['pic'] = $content_cd."_".$input['test_bank_id'].'_'.$time_random.'_'.basename($pic_file[0]);
				        rename($pic_file[0], $Data_path.$line_element['pic']);
			        }
			
			        $av_file = glob($direction_path.$cnt."_av.*");
			        if( count( $av_file ) == 1 ){
				        $line_element['av'] = $content_cd."_".$input['test_bank_id'].'_'.$time_random.'_'.basename($av_file[0]);
                        rename($av_file[0], $Data_path.$line_element['av']);
			        }
                    _insert($line_element, $input['content_cd'], $input['test_bank_id']);
			
			        unset($line_element);

                }
                $cnt++;
            }
        }
        $remove_all_cmd = "rm -rf $direction_path ";
        system_log($remove_all_cmd);
        system($remove_all_cmd); 
		header("location:./test_bank.php?import_success=1");
    }
    function extract_upload_file($data_path,$direction_path)
    {
       global $RAR_PATH;
        if($_FILES['import']['error'] != 0)
            error_msg("匯入檔案失敗");

    
        if(!is_dir($direction_path))
            createPath($direction_path);
        
        
        $upload_tmp_file = $_FILES['import']['tmp_name'];
    	// x extract
		// -w(working directory)
		$rar_extract_cmd = "$RAR_PATH x -o+ -w$data_path $upload_tmp_file $direction_path";
		
		exec($rar_extract_cmd);

    }
    function display_excel($input){
        
        require_once '../library/PHPExcel.php';
        require_once '../library/PHPExcel/IOFactory.php';
        

        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        $objPHPExcel = $objReader->load($input);
        foreach($objPHPExcel->getWorksheetIterator() as $worksheet)
        {
            echo '[Worksheet:'.$worksheet->getTitle()."<br />\r\n";
            foreach($worksheet->getRowIterator() as $row)
            {
                echo "\t- Row number:".$row->getRowIndex()."<br />\r\n";

                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);
                foreach($cellIterator as $cell)
                {
                    if(!is_null($cell))
                    {
                        echo $cell->getCalculatedValue()."<br />\r\n";

                    }
                }


            }
        }
    }

	//library
	//將題目輸入題庫中
	function _insert($i, $cd, $test_bank_id){
		switch($i[0]){
			case "選擇題": $type=1; break;
			case "是非題": $type=2; break;
			case "填充題": $type=3; break;
			default: $type=4; break;
		}
		$m = 0;
		if($i[9] == "複選")
			$m = 1;
		switch($i[12]){
			case "易": $d = 0; break;
			case "中": $d = 1; break;
			default: $d = 2; break;
		}
		$seq = 0;
		if($i[13] == "依序")
			$seq = 1;


		foreach ($i as $key=>$value) {
			$i[$key] = addslashes($value);
		}

		$insert_test = "insert into `test_bank` (content_cd, test_bank_id, question, selection_no, selection1, " 
		." selection2, selection3, selection4, selection5, selection6, answer,"
		." answer_desc, test_type, is_multiple, difficulty, if_ans_seq, file_picture_name, file_av_name) "
		." values ($cd, $test_bank_id, '$i[1]', $i[2], '$i[3]', '$i[4]', '$i[5]',"
		." '$i[6]', '$i[7]', '$i[8]', '$i[10]', '$i[11]', $type, $m, $d, $seq,'{$i['pic']}', '{$i['av']}');";	
		db_query($insert_test);
	}

	//library
	function error_msg($str){
		echo "<script type=\"text/javascript\">alert('$str');history.back();</script>";
		exit(0);
	}
?>
