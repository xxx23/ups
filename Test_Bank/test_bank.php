<?php
	/**********************************************************************/
	/* Id:test_bank.php v1.0 2006/11/30 by hushpuppy Exp.  		      */
	/* function:由course_content_bank取出科目教材編號、名稱，並顯示頁面   */
	/**********************************************************************/
	include('../config.php');
	include('../session.php');
	checkMenu('/Test_Bank/test_bank.php');
	
	include('../library/content.php');
	
    //$Content_cd = $_SESSION['content_cd'];
	//清除content_cd session變數
	unset($_SESSION['content_cd']);
	unset($_SESSION['test_bank_id']);
	
	//刪除整份題庫的動作
	$Test_bank_id = $_GET['test_bank_id'];
	$Delete_flag  = $_GET['delete_flag'];
	
	if( isset($_GET['content_cd']) ) {
		$g_Content_cd	= $_GET['content_cd'];
		$Content_cd = $g_Content_cd ;
		
	}
	$Test_bank_name = $_POST['test_bank_name'];
	$p_Content_cd   = $_POST['content_cd'];	
	$Insert_flag  = $_POST['insert_flag'];
	
	//echo "<pre>";
	//echo (print_r($_POST,true));
	if( isset($Delete_flag) && isset($Test_bank_id) && isset($g_Content_cd)){
		$Content_cd = $g_Content_cd;
		$teacher_cd = get_Teacher_id($Content_cd);
		$Test_bank_file_path = $DATA_FILE_PATH . $teacher_cd . '/test_bank/';
		
		$delete_test_bank_id = "delete from content_test_bank where content_cd=$Content_cd and test_bank_id = $Test_bank_id;";
		$result = db_query($delete_test_bank_id);
		
		// delete from  test_bank (把題庫中的所有題目刪除)  要先把檔案刪除
		$get_all_filename = "select file_picture_name, file_av_name from test_bank where content_cd=$Content_cd and test_bank_id = $Test_bank_id;";
		$result = db_query($get_all_filename);
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC) ) {
			if(!empty($row['file_picture_name']) )
				FILE_del($Test_bank_file_path, $row['file_picture_name']);
			if(!empty($row['file_av_name']) )
				FILE_del($Test_bank_file_path, $row['file_av_name']);
		}
		
		$delete_test_bank_nrows = "delete from test_bank where content_cd=$g_Content_cd and test_bank_id = $Test_bank_id;";
		$result = db_query($delete_test_bank_nrows);
	
		header('Location: ./test_bank.php');
	}

	if( isset($Insert_flag) && isset($Test_bank_name) && isset($p_Content_cd) )
	{ // insert test_bank_name
		$Content_cd = $p_Content_cd;
		$check_duplicate_name = " SELECT * FROM content_test_bank where content_cd=$p_Content_cd and test_bank_name='$Test_bank_name' ";
		$result = db_query($check_duplicate_name);
		
		
		if($result->numRows() > 0 ) {//有重複的名字
			$duplicate_flag = 1;
			$duplicate_name = $Test_bank_name; 
		}else {

			$insert_content_test_bank_name = " INSERT INTO content_test_bank (content_cd, test_bank_name) "
			." VALUES ($p_Content_cd, '$Test_bank_name')";
		
			$result = db_query($insert_content_test_bank_name);
		}
	}
	$no_content_flag = false;
	
	if( isset($_GET['content_cd']) ) { // get from content_cd 
		$g_Content_cd	= $_GET['content_cd'];
		$Content_cd = $g_Content_cd ;

	}else {
		
		
		$Personal_id = $_SESSION['personal_id'];
		$Begin_course_cd = $_SESSION['begin_course_cd'];
		//echo "<pre>";
		//die(print_r($_SESSION,true));
		
		
		$get_content_cd = "select content_cd from class_content_current "
		." where begin_course_cd = $Begin_course_cd";
		$result = db_query($get_content_cd);
		
		if( $result->numRows() != 1 ) {
			$no_content_flag = true ;
		}
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$Content_cd = $row['content_cd'];
	}
	
	$smtpl = new Smarty;
	//$smtpl->assign("course_name","tmp"); 			//課程名稱

	$get_contents = " SELECT content_cd, content_name from course_content where teacher_cd={$_SESSION['personal_id']} ";
	$result = db_query($get_contents) ; 
	while($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) 
	{	
		
		if( $Content_cd == $row['content_cd'] ) {
			$smtpl->assign("current_content_name", $row['content_name']);
		}
		$smtpl->append("all_contents", $row);
	}
	
	
	// 沒有指定教材 請使用者先指定教材
	if( $no_content_flag || empty( $Content_cd ) ) {
		$smtpl->assign("hasTestBank", 0);
	}
	else 
	{	
		$smtpl->assign("hasTestBank", 1);
		
		$smtpl->assign("content_cd", $Content_cd);
		
		
		$get_test_bank_rows_with_content_cd = "select CTB.* from content_test_bank CTB "
		."where CTB.content_cd=$Content_cd order by test_bank_id";
		$result = db_query($get_test_bank_rows_with_content_cd);
		$banks_rows = $result->numRows();
		$smtpl->assign("bank_num", $banks_rows);
		
		
		if($duplicate_flag == 1) {
			$smtpl->assign("insert_name_duplicate", 1);
			$smtpl->assign("duplicate_name", $duplicate_name);
		}
		
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC)){
			
			$get_test_bank_nrows = "select count(test_bank_id) from test_bank "
			." where content_cd=$Content_cd and test_bank_id={$row['test_bank_id']}";
			$numRow = $DB_CONN->getOne($get_test_bank_nrows);
			
			$row['numRows'] = $numRow;
			//echo $get_test_bank_nrows;
			
			if($numRow == 0){
				$row['exist'] = '空題庫';
			}else{
				$row['exist'] = '已存在';
			}
			
			$smtpl->append("content",$row);
		}
		$smtpl->assign("import_success", $_GET['import_success']);
		//print $tpl_path;
		
	}
	assignTemplate($smtpl, "/test_bank/test_bank.tpl");
?>
