<?php
/*******************************************************/
/* Id:modify_test.php v1.0 2006/12/1 by hushpuppy Exp. */
/* v2.0 2007/7/3									   */
/* function: 輸出四種題型頁面，並由DB取出資料填入顯示 $ 	   */
/*******************************************************/

	include "../config.php";
	require_once("../session.php");

	checkMenu("/Test_Bank/test_bank.php");	
	global $Test_bankno, $row;
	$Teacher_cd = $_SESSION['personal_id'];
	$Test_bankno = $_GET['test_bankno'];
	
	$sql = "select * from test_bank where test_bankno = '$Test_bankno';";
	
	$result = $DB_CONN->query($sql);
	if(PEAR::isError($result))	die($result->userinfo);
	
	$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
	if(PEAR::isError($row))	die($row->getMessage());
	
	if( $DATA_FILE_PATH[strlen($DATA_FILE_PATH)-1] == '/');
    	else
    	    $DATA_FILE_PATH = $DATA_FILE_PATH.'/';
	$path = $DATA_FILE_PATH.$Teacher_cd."/test_bank/";
	$_SESSION['current_path'] = $path;

	$smtpl = new Smarty;

	$Test_type = $row['test_type'];
	switch($Test_type){
		case "1":	//choosing
			show_choosing($row,$path);
			break;
		case "2":	//YorN
			show_YorN($row,$path);
			break;
		case "3":	//cram
			show_cram($row,$path);
			break;
		case "4":	//QA
			show_QA($row,$path);
			break;
	}
	function show_choosing($row, $path){
	  	global $smtpl, $template;
		$num = $row['selection_no'];
		//插入題型
		$smtpl->assign("test_type",array(0,1,2,3,4));
		$smtpl->assign("test_type_out",array('請選擇題型','選擇題','是非題','填充題','問答題'));
		$smtpl->assign("test_type_slt",$row['test_type']);
		//插入題目
		$smtpl->assign("question",$row['question']);
		//插入答案選項個數
		$smtpl->assign("ans_num",array(3,4,5,6));
		$smtpl->assign("ans_num_out",array('三個選項','四個選項','五個選項','六個選項'));
		$smtpl->assign("ans_num_slt",$row['selection_no']);
		//插入單複選
		$smtpl->assign("is_multiple",array(0,1));
		$smtpl->assign("is_multiple_out",array('單選','複選'));
		$smtpl->assign("is_multiple_slt",$row['is_multiple']);
		//插入難易度
		$smtpl->assign("degree",array(0,1,2));
		$smtpl->assign("degree_out",array('易','中','難'));  //0:易 1:中 2:難 
		$smtpl->assign("degree_slt",$row['difficulty']);
		//插入選項
		for($i = 1 ; $i <= $num  ; $i++){
			$smtpl->append("selection",$row['selection'.$i]);
			$check_array[$i] = "Check_".$i;
			$index[$i] = $i;
			//$check_array = array
		}
		$Answer = $row['answer'];
		//print "ans:".$Answer;
		$tok = strtok($Answer, ";");
		$i = 0;
		while($tok){
			$slt_array[$i] = $tok;
			//print $tok;
			$tok = strtok(";");
			$i++;
		}
		$smtpl->assign("checkbox",check_array);
		$smtpl->assign("box_name",$index);
		$smtpl->assign("slt_array",$slt_array);
		$smtpl->assign("test_bankno",$row['test_bankno']);
		
		//上傳的影音或圖片
		if(empty($row['file_picture_name'])){
			$smtpl->assign("img",0);
		}
		else{
			$smtpl->assign("img",1);
			$smtpl->assign("img_name",$row['file_picture_name']);
		}
		if(empty($row['file_av_name'])){
			$smtpl->assign("av",0);
		}
		else{
			$smtpl->assign("av",1);
			$smtpl->assign("av_name",$row['file_av_name']);
		}
		
		assignTemplate($smtpl, "/test_bank/modify_choosing.tpl");
		
	}
	function show_YorN($row,$path){
		global $smtpl, $template;
		//插入題型
		$smtpl->assign("test_type",array(0,1,2,3,4));
		$smtpl->assign("test_type_out",array('請選擇題型','選擇題','是非題','填充題','問答題'));
		$smtpl->assign("test_type_slt",$row['test_type']);
		//題目
		$smtpl->assign("question",$row['question']);
		//難易度
		$smtpl->assign("degree",array(0,1,2));
		$smtpl->assign("degree_out",array('易','中','難'));  //0:易 1:中 2:難 
		$smtpl->assign("degree_slt",$row['difficulty']);
		//答案
		$smtpl->assign("answer",$row['answer']);
		//詳解
		$smtpl->assign("answer_desc",$row['answer_desc']);
		//編號
		$smtpl->assign("test_bankno",$row['test_bankno']);
		
		//上傳的影音或圖片
		if(empty($row['file_picture_name'])){
			$smtpl->assign("img",0);
		}
		else{
			$smtpl->assign("img",1);
			$smtpl->assign("img_name",$row['file_picture_name']);
		}
		if(empty($row['file_av_name'])){
			$smtpl->assign("av",0);
		}
		else{
			$smtpl->assign("av",1);
			$smtpl->assign("av_name",$row['file_av_name']);
		}

		assignTemplate($smtpl, "/test_bank/modify_YorN.tpl");
	}
	//修改填充題
	function show_cram($row,$path){
	  	global $smtpl, $template;
		$num = $row['selection_no'];
		//插入題型
		$smtpl->assign("test_type",array(0,1,2,3,4));
		$smtpl->assign("test_type_out",array('請選擇題型','選擇題','是非題','填充題','問答題'));
		$smtpl->assign("test_type_slt",$row['test_type']);
		//插入題目
		$smtpl->assign("question",$row['question']);
		//插入難易度
		$smtpl->assign("degree",array(0,1,2));
		$smtpl->assign("degree_out",array('易','中','難'));  //0:易 1:中 2:難 
		$smtpl->assign("degree_slt",$row['difficulty']);
		//插入順序性
		$smtpl->assign("sequence",array(0,1));
		$smtpl->assign("sequence_out",array('否','是'));  
		$smtpl->assign("sequence_slt",$row['if_ans_seq']);
		//插入選項
		$smtpl->assign("blank_num",array(1,2,3,4,5,6));  
		$smtpl->assign("blank_num_out",array('ㄧ個空格','二個空格','三個空格','四個空格','五個空格','六個空格'));  
		$smtpl->assign("blank_num_slt",$row['selection_no']);
		for($i = 1 ; $i <= $num  ; $i++)
			$smtpl->append("selection",$row['selection'.$i]);
		//序號
		$smtpl->assign("test_bankno",$row['test_bankno']);
		//詳解
		$smtpl->assign("answer_desc",$row['answer_desc']);
		
		//上傳的影音或圖片
		if(empty($row['file_picture_name'])){
			$smtpl->assign("img",0);
		}
		else{
			$smtpl->assign("img",1);
			$smtpl->assign("img_name",$row['file_picture_name']);
		}
		if(empty($row['file_av_name'])){
			$smtpl->assign("av",0);
		}
		else{
			$smtpl->assign("av",1);
			$smtpl->assign("av_name",$row['file_av_name']);
		}
		assignTemplate($smtpl, "/test_bank/modify_cram.tpl");
	}
	function show_QA($row,$path){
	  	global $smtpl, $template;
		//插入題型
		$smtpl->assign("test_type",array(0,1,2,3,4));
		$smtpl->assign("test_type_out",array('請選擇題型','選擇題','是非題','填充題','問答題'));
		$smtpl->assign("test_type_slt",$row['test_type']);
		
		//題目
		$smtpl->assign("question",$row['question']);
		//難易度
		$smtpl->assign("degree",array(0,1,2));
		$smtpl->assign("degree_out",array('易','中','難'));  //0:易 1:中 2:難 
		$smtpl->assign("degree_slt",$row['difficulty']);
		//詳解
		$smtpl->assign("answer_desc",$row['answer_desc']);
		//編號
		$smtpl->assign("test_bankno",$row['test_bankno']);
		
		//上傳的影音或圖片
		if(empty($row['file_picture_name'])){
			$smtpl->assign("img",0);
		}
		else{
			$smtpl->assign("img",1);
			$smtpl->assign("img_name",$row['file_picture_name']);
		}
		if(empty($row['file_av_name'])){
			$smtpl->assign("av",0);
		}
		else{
			$smtpl->assign("av",1);
			$smtpl->assign("av_name",$row['file_av_name']);
		}
		assignTemplate($smtpl, "/test_bank/modify_QA.tpl");
		
	}
?>
