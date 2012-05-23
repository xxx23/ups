<?php
	/* $Id:test_bank_content.php v1.0 2006/11/30 by hushpuppy Exp.$*/
	/* $function:由test_bank中取出題目資訊並顯示。			  	  $*/
	
	
	require_once("../config.php");
	require_once("../session.php");
	checkMenu("/Test_Bank/test_bank.php");
	require_once("../library/content.php");
	 
	

	$Delete_test_bankno = $_GET['delete_test_bankno'];
	
	
	if( isset($_GET['content_cd']))
		$_SESSION['content_cd'] = $_GET['content_cd'] ;
	$Content_cd = $_SESSION['content_cd'];

	//由test_bank.php取得現在所選擇的題庫 pk by content_cd , test_bank_id
	
	$content_teacher_cd = get_Teacher_id($Content_cd);

	$Test_bank_id = $_GET['test_bank_id']; 

	$Test_bank_file_path = $DATA_FILE_PATH . $content_teacher_cd .'/test_bank/';

	// get ids from session 
	if( !isset($_SESSION['content_cd']) ){
		$_SESSION['content_cd'] = $Content_cd;
	}
	$Content_cd = $_SESSION['content_cd'];
	
	
	if( !isset($_SESSION['test_bank_id'] ) ) {
		$_SESSION['test_bank_id'] = $Test_bank_id;
	}
	$Test_bank_id = $_SESSION['test_bank_id'];
	
	
	if(isset($Delete_test_bankno))
	{
	
		//get files to delete 
		$get_file_name = "SELECT file_picture_name,file_av_name from test_bank where test_bankno=$Delete_test_bankno";
		$result = db_query($get_file_name) ;
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		
		if( !empty($row['file_picture_name']) )
			FILE_del($Test_bank_file_path, $row['file_picture_name']);
		
		if( !empty($row['file_av_name']) )
			FILE_del($Test_bank_file_path, $row['file_av_name']);
		
		$delete_one_test = "delete from test_bank where test_bankno=$Delete_test_bankno;";
		$result = db_query($delete_one_test);		
	}
	

	// get bank name
	$get_bank_title = "select test_bank_name from content_test_bank where content_cd=$Content_cd and test_bank_id=$Test_bank_id";
	$title = db_getOne( $get_bank_title );
	
	//get banks info 
	$get_bank_with_test = "select * from test_bank where content_cd=$Content_cd and test_bank_id=$Test_bank_id order by test_type asc;";
	//echo $get_bank_with_test;
	$result = db_query($get_bank_with_test);
	$numRow = $result->numRows();
	
	$smtpl = new Smarty;
	$smtpl->assign("title", $title);
	$smtpl->assign("test_num",$numRow);
	
	while($row = $result->fetchRow(DB_FETCHMODE_ASSOC)){
		if($row[test_type] == 1)
			$row['test_type_name'] = '選擇題';
		else if($row[test_type] == 2)
			$row['test_type_name'] = '是非題';
		else if($row['test_type'] == 3)
			$row['test_type_name'] = '填充題';
		else if($row['test_type'] == 4)
			$row['test_type_name'] = '簡答題';
		$smtpl->append("content",$row);
	}
	
	assignTemplate( $smtpl,"/test_bank/test_bank_content.tpl")
?>
