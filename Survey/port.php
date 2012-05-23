<?php
	/*author: lunsrot
	 * date: 2007/09/21
	 */
	require_once("../config.php");
	require_once("../session.php");
	include "library.php";
	checkMenu("/Survey/port.php");

	$input = $_GET;
	if(empty($input['option']))	$input['option'] = "view";
	call_user_func($input['option'], $input);

	//template
	//用來讓使用者選擇匯入/匯出的頁面
	function view($input){

        global $PERSONAL_PATH;
		$tpl = new Smarty;
		$no = get_survey_bankno();
		if(empty($no)){
			$tpl->assign("exist", 0);
		}else{
			$tpl->assign("exist", 1);
			$tpl->assign("bankno", $no);
		}
		$tpl->assign("pid", $_SESSION['personal_id']);
		$tpl->assign("file_name", urlencode("問卷題庫.xls"));
        $tpl->assign("example_file",urlencode("example.xls"));
        $tpl->assign("done", $input['done']);
        $_SESSION['current_path'] = $PERSONAL_PATH . $_SESSION['personal_id'] . "/";            
        assignTemplate($tpl, "/survey/tea_port.tpl");
	}

	//function
	//匯出
	function export($input){
		global $PERSONAL_PATH;

        require_once('../library/PHPExcel.php');
        require_once('../library/PHPExcel/IOFactory.php');

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("MOE UPS")
                                 ->setLastModifiedBy("MOE UPS")
                                 ->setTitle("Survey export")
                                 ->setSubject("office 2003 document")
                                 ->setDescription("This document is Survey data")
                                 ->setKeywords("office 2003")
                                 ->setCategory("Survey");
        $row_index = 1;
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValueByColumnAndRow(0, 1, '題型')
                    ->setCellValueByColumnAndRow(1, 1, '是否為複選')
                    ->setCellValueByColumnAndRow(2, 1, '題目')
                    ->setCellValueByColumnAndRow(3, 1, '選項數')
                    ->setCellValueByColumnAndRow(4, 1, '第一選項')
                    ->setCellValueByColumnAndRow(5, 1, '第二選項')
                    ->setCellValueByColumnAndRow(6, 1, '第三選項')
                    ->setCellValueByColumnAndRow(7, 1, '第四選項')
                    ->setCellValueByColumnAndRow(8, 1, '第五選項')
                    ->setCellValueByColumnAndRow(9, 1, '第六選項');
        
        $row_index++;
        
		$quest = get_list_by_blockid($input['bankno'], 0);
		for($i = 0; $i < count($quest) ; $i++){
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValueByColumnAndRow(0, $row_index, $quest[$i]['survey_type'])
                    ->setCellValueByColumnAndRow(1, $row_index, $quest[$i]['is_multiple'])
                    ->setCellValueByColumnAndRow(2, $row_index, $quest[$i]['question'])
                    ->setCellValueByColumnAndRow(3, $row_index, $quest[$i]['selection_no'])
                    ->setCellValueByColumnAndRow(4, $row_index, $quest[$i]['selection1'])
                    ->setCellValueByColumnAndRow(5, $row_index, $quest[$i]['selection2'])
                    ->setCellValueByColumnAndRow(6, $row_index, $quest[$i]['selection3'])
                    ->setCellValueByColumnAndRow(7, $row_index, $quest[$i]['selection4'])
                    ->setCellValueByColumnAndRow(8, $row_index, $quest[$i]['selection5'])
                    ->setCellValueByColumnAndRow(9, $row_index, $quest[$i]['selection6']);
            $row_index++;

			$quest2 = get_list_by_blockid($input['bankno'], $quest[$i]['survey_cd']);
            for($j = 0 ; $j < count($quest2) ; $j++)
            {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValueByColumnAndRow(0, $row_index, $quest2[$j]['survey_type'])
                    ->setCellValueByColumnAndRow(1, $row_index, $quest2[$j]['is_multiple'])
                    ->setCellValueByColumnAndRow(2, $row_index, $quest2[$j]['question'])
                    ->setCellValueByColumnAndRow(3, $row_index, $quest2[$j]['selection_no'])
                    ->setCellValueByColumnAndRow(4, $row_index, $quest2[$j]['selection1'])
                    ->setCellValueByColumnAndRow(5, $row_index, $quest2[$j]['selection2'])
                    ->setCellValueByColumnAndRow(6, $row_index, $quest2[$j]['selection3'])
                    ->setCellValueByColumnAndRow(7, $row_index, $quest2[$j]['selection4'])
                    ->setCellValueByColumnAndRow(8, $row_index, $quest2[$j]['selection5'])
                    ->setCellValueByColumnAndRow(9, $row_index, $quest2[$j]['selection6']);
                $row_index++;
            }
            //空白行
            $row_index++;
		}
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save($PERSONAL_PATH.$_SESSION['personal_id'].'/問卷題庫.xls');
	}

	//library
	//寫入一行(標題或一道問題)
	function _write($f, $input){
		fwrite($f,	iconv("UTF-8", "Big-5", 
				$input['survey_type'] . "\t" . 
				$input['is_multiple'] . "\t" . 
				$input['question'] . "\t" .
				$input['selection_no'] . "\t" .
				$input['selection1'] . "\t" . $input['selection2'] . "\t" . $input['selection3'] . "\t" . $input['selection4'] . "\t" . $input['selection5'] . "\t" . $input['selection6'] . "\n"));
	}

	//library
	//取出指定block_id的題目
	function get_list_by_blockid($no, $id){
		$output = array();
		$tmp = db_query("select * from `survey_bank_question` where survey_bankno=$no and block_id=$id;");
		while($r = $tmp->fetchRow(DB_FETCHMODE_ASSOC))
			array_push($output, $r);
		return $output;
	}
?>
