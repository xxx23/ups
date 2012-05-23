<?php
	/*$Id:show_test.php v1.0 2006/12/12 by huhspuppy Exp.$*/
	/*$function: 檢視題目內容 $*/
	require_once "../config.php";
	require_once("../session.php");
	checkMenu("/Test_Bank/test_bank.php");
	
	$from = $_GET['from'];//記錄從哪邊來的
	$Test_bankno = $_GET['test_bankno'];
	$Teacher_cd = $_SESSION['personal_id'];
	
	$sql = "select * from test_bank where test_bankno = $Test_bankno;";
	$result = db_query($sql);
	$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
	if(PEAR::isError($row))	die($row->getMessage());
	
	$Test_type = $row['test_type'];	//區別題型：1選擇(choosing)，2是非(YorN)，3填充(cram)，4簡答(QA)
	

	$path = "../Data_File/$Teacher_cd/test_bank/";

	switch($Test_type){
	case '1': //choosing
		show_choosing($row,$path,$from);
		break;
	case '2': //YorN
		show_YorN($row,$path,$from);
		break;
	case '3': //cram
		show_cram($row,$path,$from);
		break;
	case '4': //QA
		show_QA($row,$path,$from);
		break;	
	}
	
	function show_choosing($row,$path,$from){
		
		$smtpl = new Smarty;
               
		$num = $row['selection_no'];
		if($row['difficulty'] == 0)
			$degree = '易';
		else if($row['difficulty'] == 1)
			$degree = '中';
		else
			$degree = '難';
			
		$smtpl->assign("degree",$degree);
		$smtpl->assign("row",$row);
		
		if($row['is_multiple'] == 0)
			$row['IsMultiple'] = '單選題';
		else
			$row['IsMultiple'] = '複選題';
		
		$smtpl->assign("IsMultiple",$row['IsMultiple']);
		//assign給smarty 答案選項
		for($i = 1 ; $i <= $num ; $i++)
			$smtpl->append("content",$row['selection'.$i]);
		//assign給smarty 答案checkbox
		for($i = 1 ; $i <= $num ; $i++)
		  $smtpl->append("answer",$i);
		//assign正確答案
		$ansArray = explode(";",$row['answer']);	
		foreach($ansArray as $value)
		  $ansValues[$value] = true;
		
		$smtpl->assign("ansValues",$ansValues);

		$file_path = $path;
		if(!empty($row['file_picture_name'])){
			$file_path.= $row['file_picture_name'];
			$smtpl->assign("IMG",1);
			$smtpl->assign("IMG_PATH",$file_path);
		}
		else{
			$smtpl->append("IMG",0);
		}
		$file_path = $path;
		if(!empty($row['file_av_name'])){
			$file_path.= $row['file_av_name'];
			$smtpl->assign("AV",1);
			$smtpl->assign("AV_PATH",$file_path);
		}
		else{
			$smtpl->append("AV",0);
		}
	       
		$smtpl->assign("from",$from);
		assignTemplate($smtpl,"/test_bank/show_choosing.tpl");
		
	}
	function show_YorN($row,$path,$from){

		$smtpl = new Smarty;
		
		if($row['difficulty'] == 0)
			$degree = '易';
		else if($row['difficulty'] == 1)
			$degree = '中';
		else
		  $degree = '難';
		
		$file_path = $path;
		if(!empty($row['file_picture_name'])){
		  $file_path.= $row['file_picture_name'];
		  $smtpl->assign("IMG",1);
		  $smtpl->assign("IMG_PATH",$file_path);
		}
		else{
		  $smtpl->append("IMG",0);
		}
		$file_path = $path;
		if(!empty($row['file_av_name'])){
		  $file_path.= $row['file_av_name'];
		  $smtpl->assign("AV",1);
		  $smtpl->assign("AV_PATH",$file_path);
		}
		else{
		  $smtpl->append("AV",0);
		}
		
		$smtpl->assign("degree",$degree);
		$smtpl->assign("row",$row);	
		$smtpl->assign("from",$from);
		assignTemplate($smtpl,"/test_bank/show_YorN.tpl");
	}
	
	function show_cram($row,$path,$from){
	  	$smtpl = new Smarty;
		
		$num = $row['selection_no'];
		if($row['difficulty'] == 0)
			$degree = '易';
		else if($row['difficulty'] == 1)
			$degree = '中';
		else
			$degree = '難';
		
		$smtpl->assign("degree",$degree);
		$smtpl->assign("row",$row);
		
		for($i = 1 ; $i <= $num ; $i++)
		  $smtpl->append("answer",$i);
		for($i = 1 ; $i <= $num ; $i++ )
		  $ansArray[$i] = $row['selection'.$i];
		$smtpl->assign('ansArray',$ansArray);
		$file_path = $path;
		if(!empty($row['file_picture_name'])){
		  $file_path.= $row['file_picture_name'];
		  $smtpl->assign("IMG",1);
		  $smtpl->assign("IMG_PATH",$file_path);
		}
		else{
		  $smtpl->append("IMG",0);
		}
		$file_path = $path;
		if(!empty($row['file_av_name'])){
		  $file_path.= $row['file_av_name'];
		  $smtpl->assign("AV",1);
		  $smtpl->assign("AV_PATH",$file_path);
		}
		else{
		  $smtpl->append("AV",0);
		}
			
		$smtpl->assign("from",$from);
		assignTemplate($smtpl,"/test_bank/show_cram.tpl");

	}
	function show_QA($row,$path,$from){
		
		$smtpl = new Smarty;
	
		if($row['difficulty'] == 0)
			$degree = '易';
		else if($row['difficulty'] == 1)
			$degree = '中';
		else
			$degree = '難';
		
		
		$file_path = $path;
		if(!empty($row['file_picture_name'])){
		  $file_path.= $row['file_picture_name'];
		  $smtpl->assign("IMG",1);
		  $smtpl->assign("IMG_PATH",$file_path);
		}
		else{
		  $smtpl->append("IMG",0);
		}
		$file_path = $path;
		if(!empty($row['file_av_name'])){
		  $file_path.= $row['file_av_name'];
		  $smtpl->assign("AV",1);
		  $smtpl->assign("AV_PATH",$file_path);
		}
		else{
		  $smtpl->append("AV",0);
		}

		$smtpl->assign("degree",$degree);
		$smtpl->assign("row",$row);
		$smtpl->assign("from",$from);
		assignTemplate($smtpl,"/test_bank/show_QA.tpl");
	}
?>
