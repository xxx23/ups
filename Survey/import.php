<?php
	/*author: lunsrot
	 * date: 2007/09/22
	 */
	require_once("../config.php");
	require_once("../session.php");
	include "library.php";
    require_once '../library/PHPExcel.php';
    require_once '../library/PHPExcel/IOFactory.php';

	checkMenu("/Survey/port.php");

	$input = $_POST;

	//開檔
	if($_FILES['bank']['error'] != 0)
		error_msg("上傳檔案失敗!!");
    $f = fopen($_FILES['bank']['tmp_name'], "r");

    $objReader = PHPExcel_IOFactory::createReader('Excel5');
    $objReader->setReadDataOnly(true);
    $objPHPExcel = $objReader->load($_FILES['bank']['tmp_name']);

	//確定使用者一定有survey_bankno，若沒有則為他新增
	$no = get_survey_bankno();
	$cd = getTeacherId();
	if(empty($no))
		db_query("insert into `survey_bank` (personal_id) values ($cd);");

    foreach($objPHPExcel->getWorksheetIterator() as $worksheet)
    {
        $cnt = 0;
        $tmp=array();
        foreach($worksheet->getRowIterator() as $row)
        {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);
        
            $line_element = array();
            if($cnt == 0)
                foreach($cellIterator as $cell)
                {   
                    if(!is_null($cell))
                    {
                        $example[] = $cell->getCalculatedValue();
                    }
                    else $example[] = '';
                }
            else
            {
                foreach($cellIterator as $cell)
                {   
                    if(!is_null($cell))
                    {
                       $line_element[] = $cell->getCalculatedValue();
                    }
                }
                if($line_element[0]=='')//empty line
                {
                    insert_set_questions($tmp,$example);
                    $tmp = array();
                    continue;
                }
                array_push($tmp,$line_element);
            }
            $cnt++;
        }
        if(!empty($tmp))
            insert_set_questions($tmp,$example);

    }
	header("location:./port.php?done=1");
	
	//library
	//將一組問題寫入資料庫
	function insert_set_questions($input, $example){
		global $DB_CONN;
		$quest = array_shift($input);
		if(is_exist($quest, $example))
			return ;
		$no = get_survey_bankno();
		insert_question($quest, $no, 0, $example);
		$cd = get_cd_by_quest($quest, $no, get_index_by_question($example));
		while($quest = array_shift($input))
			insert_question($quest, $no, $cd, $example);
	}

	//library
	//將一題問題寫入資料庫
    function insert_question($quest, $no, $block, $ei){
        foreach($ei as $field)
        {
            switch($field)
            {
            case '題型':$e[] = 'survey_type';break;
            case '是否為複選':$e[] = 'is_multiple';break;
            case '題目':$e[] = 'question';break;
            case '選項數':$e[] = 'selection_no';break;
            case '第一選項':$e[] = 'selection1';break;
            case '第二選項':$e[] = 'selection2';break;
            case '第三選項':$e[] = 'selection3';break;
            case '第四選項':$e[] = 'selection4';break;
            case '第五選項':$e[] = 'selection5';break;
            case '第六選項':$e[] = 'selection6';break;
            }
        }
		db_query("insert into `survey_bank_question` ($e[0], $e[1], $e[2], $e[3], $e[4], $e[5], $e[6], $e[7], $e[8], $e[9], block_id, survey_bankno) values ($quest[0], '$quest[1]', '$quest[2]', $quest[3], '$quest[4]', '$quest[5]', '$quest[6]', '$quest[7]', '$quest[8]', '$quest[9]', $block, $no);");
	}

	//library
	//檢查此問題的名稱是否已存在，若已存在則回傳1
	function is_exist($quest, $e){
		global $DB_CONN;
		$t = get_index_by_question($e);

		$no = get_survey_bankno();
		if(db_getOne("select count(*) from `survey_bank_question` where survey_bankno=$no and question='$quest[$t]';") != 0)
			return 1;
		return 0;
	}

	//library
	//取得question在array中的index
	function get_index_by_question($e){
		for($i = 0 ; $i < count($e) ; $i++)
			if($e[$i] == "題目")
				return $i;
	}

	//library
	//取得survey_cd
	function get_cd_by_quest($quest, $no, $i){
		global $DB_CONN;
		return db_getOne("select survey_cd from `survey_bank_question` where survey_bankno=$no and question='$quest[$i]';");
	}
?>
