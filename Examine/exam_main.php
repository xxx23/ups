<?php
	/*	author: arnan
		modify date: 2008/02/20
	*/
	//error_reporting(E_ALL);
	require_once("../config.php");
	require_once("../session.php");
/*modify end*/
	include "exam_info.php";

	checkMenu("/Examine/create_exam.php");

	global $DB_CONN;
	global $test_no;
	
	$begin_course_cd = $_SESSION['begin_course_cd'];
	$personal_id = getTeacherId();
	$content_cd = get_current_content_cd($begin_course_cd);
	$test_bank_id = 0;
	
	if( isset($_GET['test_no']) ) {
		$_SESSION['test_no'] = $_GET['test_no'];
	}
		
	$test_no = $_SESSION['test_no'] ;
	$checkScore = $_GET['checkScore'];
	$test_type = $_GET['test_type'];
	if( empty($test_type) )
		$test_type = 1;


/*  display the template
 */
	if( $checkScore != 1){
		$tpl = new Smarty;

		global $content_cd, $content_name;
		//display information in table, example: question, is_check?, percentage
			
		$get_content_info = "select content_name from course_content where content_cd=$content_cd";
		$result = db_query($get_content_info);
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$content_name = $row['content_name'];
		$tpl->assign('content_cd', $content_cd);
		$tpl->assign('content_name', $content_name);
		
		
		
		if(!empty($content_cd)){

			if( isset($_GET['test_bank_id']) ){
				$test_bank_id = intval($_GET['test_bank_id']);
				$tpl->assign("current_bank_id", $test_bank_id);
			}
				
			if( isset($_GET['level']) ) {
				$difficulty = intval($_GET['level']);
				$sql_difficulty = " and difficulty=$difficulty ";
			}			
			
			$get_all_test_banks ="select test_bank_id, test_bank_name from content_test_bank where content_cd=$content_cd";
			$test_bank_result = db_query($get_all_test_banks);
			$bank_nrows = $test_bank_result->numRows();
			
			if($bank_nrows == 0) {
				$tpl->assign("no_banks", 1);
			}else{
				$default = true; // 給未指定題庫一個初始
				
				if( isset($_GET['test_bank_id']) ){ // 如果有指定題庫
					$test_bank_id = $_GET['test_bank_id'];
				}
				
				while( $row = $test_bank_result->fetchRow(DB_FETCHMODE_ASSOC) ) {
					if( $default && empty($test_bank_id)) {
						$test_bank_id = $row['test_bank_id'];
						$default = false;
					}
					
					if( $test_bank_id == $row['test_bank_id']) {
						$_SESSION['test_bank_id'] = $test_bank_id;// 給編輯題庫紀錄用
						$tpl->assign("current_bank_name", $row['test_bank_name']);
						$tpl->assign("current_bank_id", $test_bank_id);
					}
					
					$test_bank['bank_id'] = $row['test_bank_id'];
					$test_bank['bank_name'] = $row['test_bank_name'];
					$tpl->append("banks", $test_bank);// 列出 banks_info 建Tree 用
				}
			}

			$sql_test_bank_id = "";
			if( !empty($test_bank_id) && $test_bank_id !=0 ){
				$sql_test_bank_id = " and test_bank_id=$test_bank_id " ;
			}
			$show_selected_test = "SELECT * FROM test_bank "
			." where content_cd=$content_cd $sql_test_bank_id and test_type=$test_type  $sql_difficulty order by test_bankno;";
			
			
			//echo $show_selected_test;
			$result = db_query($show_selected_test);
			$i = 1;
			$checked = 0;
			$total = 0;
			while( $row = $result->fetchRow(DB_FETCHMODE_ASSOC) ){
				$row['question'] = strip_tags($row['question']);
				if( is_inTest_course($row, $test_no) == 1 ){
					$row['percentage'] = assignScore($row, $test_no);
					$row['disable'] = "disabled";
					$checked += assignScore($row, $test_no);
					$total += 1;	
				}else{
					$row['ind'] = $i;
				}
				$row['num'] = $i++;
				$tpl->append('content', $row);
			}

			$sql = "select SUM(grade), COUNT(*) from `test_course` where begin_course_cd=$begin_course_cd and test_no=$test_no;";
			$result = db_query($sql);
			$row = $result->fetchRow();
			$tpl->assign('test_type', $test_type);
			if(empty($row[0]))
				$row[0] = 0;
		}else{
			$tpl->assign('no_content', "本課程目前無任何題庫");
		}
		
		$tab = $_GET['tab'];
		if(empty($tab)) {
			$tab = "tabA";
		}
		
		$tpl->assign("test_type_char", test_type_toChar($test_type));
		$tpl->assign("difficulty",difficulty_toChar($difficulty));
		$tpl->assign("tab", $tab);
		$tpl->assign('test_no', $test_no);
		$tpl->assign('exam_total', $row[0]);
		$tpl->assign('exam_checked', $row[1]);
		$tpl->assign('total', $total);
		$tpl->assign('checked', $checked);
		$tpl->assign('content_cd', $content_cd);
	
		assignTemplate($tpl, "/examine/exam_main.tpl");
	}else{
		$checked = $_GET['quest'];
		$per = $_GET['percentage'];
		$content_cd = $_GET['content_cd'];

		$j = -1;
		for( $i = 0 ; $i < sizeof($checked) ; $i++){
			for( $j++ ; $j < sizeof($per) ; $j++)
				if( !empty($per[$j]) )
					break;
			$sql = "select * from test_bank where test_bankno=$checked[$i] and test_type=$test_type;";
			$result = db_query($sql);
			$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
/*			$row['question'] = addslashes($row['question']);
			$row['answer'] = addslashes($row['answer']);
			$row['answer_desc'] = addslashes($row['answer_desc']);
			for($k = 1 ; $k < 7 ; $k++)
				$row['selection'.$k] = addslashes($row['selection'.$k]);*/
			foreach($row as $key => $value)
				$row[$key] = ereg_replace("\'", "\\'", $value);


			//若勾選了題目，但沒有填配分，預設配分為 0 , modifyed by rja
			if (empty($per[$j])) 
				$per[$j] = 0;
			$sql = "INSERT INTO test_course (begin_course_cd, test_no, test_bankno, test_type, "
			." question, selection_no, selection1, selection2, selection3, selection4, "
			." selection5, selection6, is_multiple, answer, answer_desc, file_picture_name, "
			." file_av_name, grade, difficulty, if_ans_seq) "
			." VALUES ($begin_course_cd, $test_no, $checked[$i], '$row[test_type]', '$row[question]', '$row[selection_no]', '$row[selection1]', '$row[selection2]', '$row[selection3]', '$row[selection4]', '$row[selection5]', '$row[selection6]', '$row[is_multiple]', '$row[answer]', '$row[answer_desc]', '$row[file_picture_name]', '$row[file_av_name]', $per[$j], '$row[difficulty]', '$row[if_ans_seq]');";
			//echo  $sql;
			
			db_query($sql);
			copyFile($row['file_picture_name'], $personal_id, $begin_course_cd, $test_no);
			copyFile($row['file_av_name'], $personal_id, $begin_course_cd, $test_no);
		}
		session_unregister(checkbox);
		
		header("location:./connection_page.php");
	}

	/* function list */
	function is_inTest_course($row, $test_no){
		
		$sql = "select * from `test_course` where begin_course_cd=$_SESSION[begin_course_cd] and test_bankno=$row[test_bankno] and test_no=$test_no;";
		$result = db_query($sql);
		if( $result->numRows() > 0 )
			return 1;
		else
			return 0;
	}
	function assignScore($row, $test_no){	
	
		$sql = "select * from test_course where test_bankno=$row[test_bankno] and test_no=$test_no;";
		$result = db_query($sql);
		$tmp = $result->fetchRow(DB_FETCHMODE_ASSOC);
		return $tmp['grade'];
	}
	
	function test_type_toChar($test_type) {
		switch($test_type) {
			case 1: return "選擇題";
			case 2: return "是非題";
			case 3: return "填充題";
			case 4: return "簡答題";
			default : return "選擇題";
		}
	}
	
	function difficulty_toChar($level) {
		if( !isset($_GET['level']) ) {
			return "所有難度";
		}
		switch($level) {
			case 0: return "簡易";
			case 1: return "中等";
			case 2: return "困難";
		}
	}

?>
