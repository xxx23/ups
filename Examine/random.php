<?php
	/*author: lunsrot
	 * date: 2007/07/07
	 */
	//error_reporting(E_ALL);
	
	require_once("../config.php");
	require_once("../session.php");
	require_once("exam_info.php");
	
	$input = $_POST;
	unset($_POST);

	switch($input['option']){
	case "select_bank": select_bank($input); return;
	case "select_question": select_question($input); return;
	default: view_bank();	return ;
	}

	/*	DB schema explain：
		test_bankno 為題目
	*/ 
	function view_bank(){
		$tpl = new Smarty;
		$pid = getTeacherId();
		$content_cd = get_current_content_cd(0);
		$get_all_banks ="select test_bank_id, test_bank_name from content_test_bank where content_cd=$content_cd order by test_bank_id;";
		$result = db_query($get_all_banks);

		//well_print($_SESSION);
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC)){
			// 算出 1:選擇題/2:是非題/3:填充題/4:問答題 各有多少題
			for($i = 1 ; $i <= 4 ; $i++){
				$get_count = "select count(*) from test_bank where content_cd=$content_cd and test_bank_id={$row['test_bank_id']} and test_type=$i "
				." and test_bankno not in (select test_bankno from test_course where begin_course_cd=$_SESSION[begin_course_cd] and test_no=$_SESSION[test_no])";
				$tmp = db_getOne($get_count);
				$row[$i] = $tmp;
			}
			$tpl->append("banks", $row);
		}
		assignTemplate($tpl, "/examine/select_bank.tpl");
	}

	function select_bank($input){
		$tpl = new Smarty;
		
		$content_cd = get_current_content_cd(0);
		$test_bank_id = $input['test_bank_id'];
		
		$output = array();
		$_SESSION['test_bank_id'] = $input['test_bank_id'];
		
		//well_print($_SESSION);
		if( !empty($test_bank_id) ) {
			
			$output = array();
			//列出 易 中 難 
			for($k = 0 ; $k < 3 ; $k++) {
				$output[$k] = array();
				//列出 1:選擇題/2:是非題/3:填充題/4:問答題 各有多少題
				for($j=1; $j<5; $j++) {
				// 從有選的test_bank_id 裡面拿出數總和
					$output[$k][$j] = 0;
					foreach($test_bank_id as $value) {
						$get_counts = "select count(*) from `test_bank` where content_cd=$content_cd and test_bank_id=$value "
						." and test_type=$j and difficulty='$k' and "
						." test_bankno not in (select test_bankno from `test_course` "
						."where begin_course_cd=$_SESSION[begin_course_cd] and test_no=$_SESSION[test_no] ) ";
						$num = db_getOne($get_counts);
						$output[$k][$j] += $num;
					}	
					
				}
			}
			$tpl->assign("group", $output);
		}else{
			$tpl->assign("select_no_bank", true);
		}
		$tpl->assign("test_no", $_SESSION['test_no']);
		assignTemplate($tpl, "/examine/select_question.tpl");
	}

		
	function select_question($input)
	{

		$content_cd = get_current_content_cd(0);
		$test_bank_id = $_SESSION['test_bank_id'];
		
		
		for($i=0; $i<3; $i++) {
			for($j=1; $j<5; $j++) {
				$sum[$i][$j] = $input['sum_'.$i.'_'.$j]; // 總共題數
				$num[$i][$j] = $input['num_'.$i.'_'.$j]; // 選取幾題
				$grade[$i][$j] = $input['grade_'.$i.'_'.$j]; // 總共幾分		
			}
		}
		
		//well_print($_SESSION);
		//well_print($sum);
		//well_print($num);
		//well_print($grade);
	
		
		for($diff = 0 ; $diff < 3 ; $diff++) {
			for($test_type = 1 ; $test_type < 5 ; $test_type++)	{
				
				$select_or_not = random_array($sum[$diff][$test_type], $num[$diff][$test_type]);//總題數 出題數
				
				$grade_for_test = averageGrade($grade[$diff][$test_type], $num[$diff][$test_type]);
				

				
				if( !is_array($grade_for_test) or empty($grade_for_test) or $grade_for_test == -1) {
					continue;
				}
				
				//well_print("select_or_not-". $diff . "-" . $test_type);
				//well_print($select_or_not);
				//well_print("grade_for_test");
				//well_print($grade_for_test);
				//well_print("<hr>");
				
				// 有選bank_id才insert 資料	
				if( isset($test_bank_id) && !empty($test_bank_id) ){
					foreach($test_bank_id as $bank_id)
					{	
						$select_out_test = "select * from `test_bank` where content_cd=$content_cd "
						." and test_bank_id=$bank_id and test_type=$test_type and difficulty=$diff "
						." and test_bankno not in (select test_bankno from test_course "
						."where begin_course_cd=$_SESSION[begin_course_cd] and test_no=$_SESSION[test_no] )";
						$result = db_query($select_out_test);
						
						$i=0;$j=0;// $i 跑 select or not   $j 跑 grade_for_test 
 
						echo $result->numRows();
						while($row = $result->fetchRow(DB_FETCHMODE_ASSOC)){
							if($select_or_not[$i++] != 1) {
								continue;
							}else{
							  foreach($row as $key => $value){
								$row[$key] = addslashes($value);
							  }							
							  insertQuestion($row, $grade_for_test[$j++]);
								
							}
						}
					}
				}else{
					die('沒有選擇題庫，請退回上一頁重新選擇<a href="random.php">亂數出題</a>');
				}
				
			}
		}
		
		unset($_SESSION['test_bank_id']);
		header("location:./connection_page.php");
		
	}
	
	
	//得到一個陣列，用來紀錄該出此題型群中的哪幾題
	//do $sum = 8 , $num = 4
	// 1 1 1 1 0 0 0 0 
	// after shuffle 
	// 0 1 0 1 1 1 0 0
	function random_array($sum, $num){
		$out = array();
		$out = array_pad($out, $num, 1);
		$out = array_pad($out, $sum, 0);
		shuffle($out);
		return $out;
	}

	function averageGrade($grade, $num){
		$out = array();
		if($num == 0)
			return -1;
		$rest = $grade % $num;
		$avg = $grade/$num;
		$floor_avg = floor($avg);
		
		//將餘數分散到各個avg去
		if($rest != 0){
			for($i = 0 ; $i < $num ; $i++){
				if($i < $rest){
					$out[] = $floor_avg + 1;
				}else{
					$out[] = $floor_avg;
				}
			}
		}else{
			for($i = 0 ; $i < $num ; $i++)
				$out[] = $avg;
		}
		return $out;
	}

	function insertQuestion($row, $grade){
		$pid = getTeacherId();
		$insert_Question = "insert into `test_course` (begin_course_cd, test_bankno, test_no, test_type, question, selection_no, selection1, selection2, selection3, selection4, selection5, selection6, is_multiple, answer, answer_desc, file_picture_name, file_av_name, difficulty, grade, if_ans_seq) values ($_SESSION[begin_course_cd], $row[test_bankno], $_SESSION[test_no], $row[test_type], '$row[question]', $row[selection_no], '$row[selection1]', '$row[selection2]', '$row[selection3]', '$row[selection4]', '$row[selection5]', '$row[selection6]', '$row[is_multiple]', '$row[answer]', '$row[answer_desc]', '$row[file_picture_name]', '$row[fiie_av_name]', '$row[difficulty]', $grade, '$row[if_ans_seq]');";
		db_query($insert_Question);
		//echo $insert_Question;
		copyFile($row['file_picture_name'], $pid, $_SESSION['begin_course_cd'], $_SESSION['test_no']);
		copyFile($row['file_av_name'], $pid, $_SESSION['begin_course_cd'], $_SESSION['test_no']);
	}
	

?>
