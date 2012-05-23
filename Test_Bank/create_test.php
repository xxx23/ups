<?php
/**********************************************************/
/* $Id:create_test.php v1.0 2006/11/25 by hushpuppy Exp.$ */
/* v2.0 2007/7/2	越改越亂...orz						  */
/* $function:驗證表單並存入資料庫 							$ */
/**********************************************************/
	require_once('../config.php');
	require_once('../session.php');
	//checkmenu('')
    include('../library/content.php');
    require_once($HOME_PATH . 'library/filter.php') ; 
    

	global $Content_cd, $Test_bank_id;
	global $Test_type, $Question, $Selection_no, $Is_multiple, $Difficulty, $Sequence;
	global $Answer, $Answer_desc, $File_picture_name, $File_av_name;
	global $Selection1, $Selection2, $Selection3, $Selection4, $Selection5, $Selection6;  //僅選擇、填充有值
	global $Modify;
	global $DATA_FILE_PATH, $MAX_UPLOAD_SIZE, $DB_CONN;


	$Content_cd = $_SESSION['content_cd'];
	$Test_bank_id = $_SESSION['test_bank_id'];
	

	
	$Modify =$_POST['modify']; //modify的值為test_bankno
	//判斷是否為刪除上傳檔案
	$del = $_POST['del_img'];
	if(!empty($del)){
		delete_file($Modify, "img");
		return ;
	}
	$del = $_POST['del_av'];
	if(!empty($del)){
		delete_file($Modify, "av");
		return ;
	}
	
	$meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />"; //echo前加上，否則javascript msg會是亂碼
				
	$Test_type = $_POST['test_type'];
	if($Test_type == '')
		$Test_type = 'choosing';			//區別題型：1選擇(choosing)，2是非(YorN)，3填充(cram)，4簡答(QA)
	$Question = $_POST['test_title']; 		//題目
	//$Question = htmlspecialchars_decode($Question,ENT_QUOTES);
	//print $Question;
	//exit(1);
	if(empty($Question)){
		echo $meta."<script type=\"text/javascript\"> alert(\"錯誤! 您沒有輸入題目，請返回輸入!\"); history.back();</script>";
		return 0;
	}
	//$Question = htmlspecialchars($Question, ENT_QUOTES);
	
	//判斷是否上傳檔案
	$file_array = $_FILES['pic_file'];
	if(!empty($file_array['name'])){
		$new_name = upload_file($file_array);
		$File_picture_name = $new_name;
	}
	else{
		if(isset($Modify)){ //若為修改介面，要先拿到原本的值
			$sql = "select file_picture_name from test_bank where test_bankno = '$Modify';";
			$File_picture_name = db_getOne($sql);
		}
	}
	$file_array = $_FILES['av_file'];
	if(!empty($file_array['name'])){
		$new_name = upload_file($file_array);
		$File_av_name = $new_name;
	}
	else{
		if(isset($Modify)){ //若為修改介面，要先拿到原本的值
			$sql = "select file_av_name from test_bank where test_bankno = '$Modify';";
			$File_av_name = db_getOne($sql);
		}
	}
	$Selection_no = $_POST['test_count'];	//答案個數(只有選擇，填充此變數有值)
											//選擇題(0: 3個選項,1: 4個選項,2: 5個選項,3: 6個選項) 
											//填充題(0: 1個空格,1: 2個空格,2: 3個空格,3: 4個空格,4: 5個空格,5: 6個空格)
	$Is_multiple = $_POST['is_multiple'];	//單選(0)或複選(1)
	if(empty($Is_multiple))
		$Is_multiple = 0;
		
	$Difficulty = $_POST['degree'];			//難(2)中(1)易(0)
	if(empty($Difficulty))
		$Difficulty = 0;
		
	$Answer = $_POST['ans'];
	$Answer_desc = $_POST['answer_desc'];
	
	$Sequence = $_POST['sequence'];
	if(empty($Sequence))
		$Sequence = 0;
	
	//print "modify:".$Modify;
		
	if($Test_type == "choosing"){	//抓取選擇題題目內容
        $Selection1 = optional_param("select_1", 0, PARAM_TEXT);//$_POST['select_1'];
	  $Selection2 = optional_param("select_2", 0, PARAM_TEXT);//$_POST['select_2'];
	  $Selection3 = optional_param("select_3", 0, PARAM_TEXT);//$_POST['select_3'];
	  $Selection4 = optional_param("select_4", 0, PARAM_TEXT);//$_POST['select_4'];
	  $Selection5 = optional_param("select_5", 0, PARAM_TEXT);//$_POST['select_5'];
	  $Selection6 = optional_param("select_6", 0, PARAM_TEXT);//$_POST['select_6'];

	  //後來才改的，寫的有點亂...orz 
	  $array = $_POST['check_array'];
	  $size = sizeof($array);
		for($i = 0 ; $i < $size ; $i++){
		  $tmp = $array[$i];
		  if($i == $size - 1)
		    $Answer.= $tmp;
		  else
		    $Answer.= $tmp.";";
		}
		//print $size;
		if(sizeof($array) == 0 ){
		  echo $meta."<script type=\"text/javascript\"> alert(\"錯誤! 您沒有選擇任何答案，請返回輸入!\"); history.back();</script>";
		  return 0;
		}
		if(!$Is_multiple && sizeof($array) > 1){
		  echo $meta."<script type=\"text/javascript\"> alert(\"'$count'錯誤! 單選題您輸入了多個答案，請重新輸入!\"); history.back();</script>";
		  return 0;
		}
		if(!isset($Modify))
		  $Selection_no = $Selection_no + 3;
	}
	else if($Test_type == "cram"){	//抓取填充題空格答案內容
		if(empty($Selection_no))
			$Selection_no = $Selection_no + 1; //填充空格為 1~6
		$Selection1 = $_POST['cram_1'];
		$Selection2 = $_POST['cram_2'];
		$Selection3 = $_POST['cram_3'];
		$Selection4 = $_POST['cram_4'];
		$Selection5 = $_POST['cram_5'];
		$Selection6 = $_POST['cram_6'];
	}
	
	//依題型執行對應的動作
	switch($Test_type){
	case 'choosing':
		$ch = check_choosing($array,$Modify);
		if($ch == 0)
			break;
		else
			choosing2DB();
		if(isset($_POST['submit_over']))
			header("location:./test_bank_content.php");
		else if(isset($_POST['submit_next']))
			header("location:./question.php?type=choosing");
		break;
	case 'YorN':
		$ch = check_YorN();
		if($ch == 0)
			break;
		else
			YorN2DB();
		if(isset($_POST['submit_over']))
			header("location:./test_bank_content.php");
		else if(isset($_POST['submit_next']))
			header("location:./question.php?type=YorN");
		break;
	case 'cram':
		$ch = check_cram();
		if($ch == 0)
			break;
		else
			cram2DB();
		if(isset($_POST['submit_over']))
			header("location:./test_bank_content.php");
		else if(isset($_POST['submit_next']))
			header("location:./question.php?type=cram");
		break;
	case 'QA':
		QA2DB();
		if(isset($_POST['submit_over']))
			header("location:./test_bank_content.php");
		else if(isset($_POST['submit_next']))
			header("location:./question.php?type=QA");
		break;
}
    function updateAfterModifyGrade($test_bankno)
    {
        require_once('../Examine/TestCorrector.class.php');
        $objTestCorrector = new TestCorrector();
        $objTestCorrector->correctTestBankGrade($test_bankno);
    }
	//上傳檔案
	function upload_file($file_array){
		global $MAX_UPLOAD_SIZE, $DATA_FILE_PATH, $Content_cd;
		global $File_picture_name, $File_av_name;
		$Teacher_cd = $_SESSION['personal_id'];
		
		$tmp_name = $file_array['tmp_name'];
		$file_name = $file_array['name'];
		$file_type = $file_array['type'];
		$file_size = $file_array['size'];
		if($file_type == 'js' || $file_type == 'php')
			header("Location: ./lib/alert.html");
		$MAX = $MAX_UPLOAD_SIZE*1000000;
		if($file_size >= $MAX)
			echo $meta."<script type=\"text/javascript\"> alert(\"'警告! 您上傳的檔案已超過最大限制! '$file_size' max: '$MAX'\"); history.back();</script>";
		$time = date("mdHis");
		$new_name = $Content_cd."_".$time."_".$file_name;
	
		//上傳檔案
		
		$path = $DATA_FILE_PATH.$Teacher_cd."/test_bank/";
		
		if( !file_exists($path) ){
			mkdir($path);
		}
		
		
		//print "new_name:".$new_name;
		FILE_upload($tmp_name, $path, $new_name);
		return $new_name;
	}
	
	//刪除老師上傳的檔案
	function delete_file($test_bankno, $option){
		global $DB_CONN, $DATA_FILE_PATH;
		
		$content_cd = get_Content_cd($_SESSION['begin_course_cd']);
		$Teacher_cd = get_Teacher_id($content_cd);
		//取得目前的檔名
		if($option == "img")
			$sql = "select file_picture_name from test_bank where test_bankno = '$test_bankno';";
		else
			$sql = "select file_av_name from test_bank where test_bankno = '$test_bankno';";
		$filename = db_getOne($sql);

		
		//更新資料庫
		if($option == "img")
			$sql = "update test_bank set file_picture_name = '' where test_bankno = '$test_bankno';";
		else
			$sql = "update test_bank set file_av_name = '' where test_bankno = '$test_bankno';";

		db_query($sql);
		
		//刪除檔案
		$path = $DATA_FILE_PATH.$Teacher_cd."/test_bank/";
		unlink($path.$filename);
		//print $cmd;
		
		//導回原頁面
		header("Location: ./modify_test.php?test_bankno=$test_bankno");
	}
	
	//選擇題驗證與取値部份
	function check_choosing($array,$Modify){
		global $Selection_no, $Is_multiple;
		global $Selection1, $Selection2, $Selection3, $Selection4, $Selection5, $Selection6, $meta;
		$count = 0;	
		
		//if(!empty($Modify)){
		if(sizeof($array) == 0){
		  echo $meta."<script type=\"text/javascript\"> alert(\"錯誤! 您沒有選擇任何答案，請返回輸入!\"); history.back();</script>";
		  return 0;
		}
		//print $Is_multiple;
		if(!$Is_multiple && sizeof($array) > 1){
		  echo $meta."<script type=\"text/javascript\"> alert(\"錯誤! 單選題您輸入了多個答案，請重新輸入!\"); history.back();</script>";
		  return 0;
		}

		if($Selection_no == 4 && ($Selection1 == '' ||$Selection2 =='' || $Selection3 == '' || $Selection4 == '')){
			echo $meta."<script type=\"text/javascript\"> alert(\"錯誤! 您有選擇題選項沒有輸入內容1!\"); history.back();</script>";
			return 0;
		}
		if($Selection_no == 5 && ($Selection1 == '' ||$Selection2 =='' || $Selection3 == '' || $Selection4 == '' ||$Selection5 == '')){
			echo $meta."<script type=\"text/javascript\"> alert(\"錯誤! 您有選擇題選項沒有輸入內容2!\"); history.back();</script>";
			return 0;
		}
		if($Selection_no == 6 && ($Selection1 == '' ||$Selection2 =='' || $Selection3 == '' || $Selection4 == '' ||$Selection5 == ''|| $Selection6 == '')){
			echo $meta."<script type=\"text/javascript\"> alert(\"錯誤! 您有選擇題選項沒有輸入內容3!\"); history.back();</script>";
			return 0;
		}
		return 1;
}

	//是非題驗證
	function check_YorN(){	
		global $Answer, $meta;
			
		if($Answer != 1 && $Answer != 0){
			echo $meta."<script type=\"text/javascript\"> alert(\"'$Answer'錯誤! 您沒有選擇任何答案，請返回輸入!\"); history.back();</script>";
			return 0;
		}
		return 1;
	}

	//填充題驗證
	function check_cram(){
		global $Selection_no, $meta;
		global $Selection1, $Selection2, $Selection3, $Selection4, $Selection5, $Selection6;
		//print $Selection_no;
		if($Selection_no == 1 && $Selection1 == ''){
			echo $meta."<script type=\"text/javascript\"> alert(\"錯誤! 您有填充題答案項目沒有輸入內容1!\"); history.back();</script>";
			return 0;
		}
		if($Selection_no == 2 && ($Selection1 == '' || $Selection2 == '')){
			echo $meta."<script type=\"text/javascript\"> alert(\"錯誤! 您有填充題答案項目沒有輸入內容2!\"); history.back();</script>";
			return 0;
		}
		if($Selection_no == 3 && ($Selection1 == '' || $Selection2 == '' || $Selection3 == '')){
			echo $meta."<script type=\"text/javascript\"> alert(\"錯誤! 您有填充題答案項目沒有輸入內容3!\"); history.back();</script>";
			return 0;
		}
		if($Selection_no == 4 && ($Selection1 == '' || $Selection2 == '' || $Selection3 == '' || $Selection4 == '')){
			echo $meta."<script type=\"text/javascript\"> alert(\"錯誤! 您有填充題答案項目沒有輸入內容4!\"); history.back();</script>";
			return 0;
		}
		if($Selection_no == 5 && ($Selection1 == '' || $Selection2 == '' || $Selection3 == '' || $Selection4 == '' ||$Selection5 == '')){
			echo $meta."<script type=\"text/javascript\"> alert(\"錯誤! 您有填充題答案項目沒有輸入內容5!\"); history.back();</script>";
			return 0;
		}
		if($Selection_no == 6 && ($Selection1 == '' || $Selection2 == '' || $Selection3 == '' || $Selection4 == '' ||$Selection5 == '' || $Selection6 == '')){
			echo $meta."<script type=\"text/javascript\"> alert(\"錯誤! 您有填充題答案項目沒有輸入內容6!\"); history.back();</script>";
			return 0;
		}
		return 1;
}
	//將編輯的選擇題插入資料庫
	function choosing2DB(){
		global  $Content_cd, $Test_bank_id;
		global $Question, $Selection_no, $Is_multiple, $Difficulty,$DB_CONN;
		global $Selection1, $Selection2, $Selection3, $Selection4, $Selection5, $Selection6;
		global $Answer, $Answer_desc, $File_picture_name, $File_av_name;
		global $Modify;
		
		$Test_type = 1;
		if(empty($Modify)){
			$sql = "insert into test_bank (content_cd, test_bank_id, test_type, question, selection_no,
			selection1, selection2, selection3, selection4, selection5, selection6, is_multiple, answer, answer_desc,
			file_picture_name, file_av_name, difficulty) 
			values('$Content_cd', $Test_bank_id, '$Test_type', '$Question', '$Selection_no', 
			   '$Selection1', '$Selection2', '$Selection3', '$Selection4', '$Selection5', '$Selection6',
			   '$Is_multiple', '$Answer', '$Answer_desc', '$File_picture_name', '$File_av_name', '$Difficulty');";
			//print $sql;
		}
        else{
            db_query("update test_course set 
				question = '$Question', selection_no = '$Selection_no', selection1 = '$Selection1', selection2 = '$Selection2',
				selection3 = '$Selection3', selection4 = '$Selection4', selection5 = '$Selection5', selection6 = '$Selection6',
				is_multiple = '$Is_multiple', answer = '$Answer', answer_desc = '$Answer_desc', file_picture_name =
				'$File_picture_name', file_av_name = '$File_av_name', difficulty = '$Difficulty' 
				where 
                test_bankno = '$Modify' ;");
			$sql = "update test_bank set 
				question = '$Question', selection_no = '$Selection_no', selection1 = '$Selection1', selection2 = '$Selection2',
				selection3 = '$Selection3', selection4 = '$Selection4', selection5 = '$Selection5', selection6 = '$Selection6',
				is_multiple = '$Is_multiple', answer = '$Answer', answer_desc = '$Answer_desc', file_picture_name =
				'$File_picture_name', file_av_name = '$File_av_name', difficulty = '$Difficulty' 
				where 
                test_bankno = '$Modify' ;";
            
			//well_print($sql);
			//exit;
		}
		//print $sql;
        db_query($sql);
        if(!empty($Modify)) 
            updateAfterModifyGrade($Modify);
	}	
	
	//將編輯的是非題插入資料庫
	function YorN2DB(){
		global $Content_cd, $Test_bank_id;
		global $Question, $Selection_no, $Is_multiple, $Difficulty,$DB_CONN;
		global $Selection1, $Selection2, $Selection3, $Selection4, $Selection5, $Selection6;
		global $Answer, $Answer_desc, $File_picture_name, $File_av_name;
		global $Modify;
		
		$Test_type = 2;
		if(empty($Modify)){
			$sql = "insert into test_bank (content_cd, test_bank_id, test_type, question,
			answer, answer_desc, file_picture_name, file_av_name, difficulty) 
			values('$Content_cd', '$Test_bank_id',  '$Test_type','$Question', 
			   '$Answer', '$Answer_desc', '$File_picture_name', '$File_av_name', '$Difficulty');";
		}
        else
        {
            db_query("update test_course set 
				test_type = '$Test_type',
				question = '$Question', answer = '$Answer', answer_desc = '$Answer_desc',
				file_picture_name = '$File_picture_name', file_av_name = '$File_av_name' 
				where test_bankno = '$Modify';");
			$sql = "update test_bank set 
				test_type = '$Test_type',
				question = '$Question', answer = '$Answer', answer_desc = '$Answer_desc',
				file_picture_name = '$File_picture_name', file_av_name = '$File_av_name' 
				where test_bankno = '$Modify';";
		}
		//print $sql;
		
        db_query($sql);
        if(!empty($Modify)) 
            updateAfterModifyGrade($Modify);
	}	
	
	//將編輯的填充題插入資料庫
	function cram2DB(){
		global $Content_cd,$Test_bank_id;
		global $Question, $Selection_no, $Difficulty, $Sequence, $DB_CONN;
		global $Selection1, $Selection2, $Selection3, $Selection4, $Selection5, $Selection6;
		global $Answer, $Answer_desc, $File_picture_name, $File_av_name;
		global $Modify;
		
		if(empty($Sequence))
			$Sequence = 0;
		else
			$Sequence = 1;
		
		$Test_type = 3;
		if(empty($Modify)){
			$sql = "insert into test_bank (content_cd, test_bank_id,  test_type, question, selection_no,
			selection1, selection2, selection3, selection4, selection5, selection6, answer_desc,
			file_picture_name, file_av_name, difficulty, if_ans_seq) 
			values('$Content_cd', $Test_bank_id, '$Test_type','$Question', '$Selection_no', 
			   '$Selection1', '$Selection2', '$Selection3', '$Selection4', '$Selection5', '$Selection6',
			   '$Answer_desc', '$File_picture_name', '$File_av_name', '$Difficulty', '$Sequence');";
		}
        else{
            db_query("update test_course set
				test_type = '$Test_type',
				selection_no = '$Selection_no', selection1 = '$Selection1', selection2 = '$Selection2',
				selection3 = '$Selection3', selection4 = '$Selection4', selection5 = '$Selection5',
				selection6 = '$Selection6', answer_desc = '$Answer_desc',
				file_picture_name = '$File_picture_name', file_av_name = '$File_av_name'
				where test_bankno = '$Modify'");
			$sql = "update test_bank set
				test_type = '$Test_type',
				selection_no = '$Selection_no', selection1 = '$Selection1', selection2 = '$Selection2',
				selection3 = '$Selection3', selection4 = '$Selection4', selection5 = '$Selection5',
				selection6 = '$Selection6', answer_desc = '$Answer_desc',
				file_picture_name = '$File_picture_name', file_av_name = '$File_av_name'
				where test_bankno = '$Modify'";
		}
		//print $sql;
        db_query($sql);
        if(!empty($Modify)) 
            updateAfterModifyGrade($Modify);
	}	
	
	//將編輯的簡答題插入資料庫
	function QA2DB(){
		global $Content_cd, $Test_bank_id;
		global $Question, $Selection_no, $Is_multiple, $Difficulty,$DB_CONN;
		global $Selection1, $Selection2, $Selection3, $Selection4, $Selection5, $Selection6;
		global $Answer, $Answer_desc, $File_picture_name, $File_av_name;
		global $Modify;
		
		$Test_type = 4;
		if(empty($Modify)){
			$sql = "insert into test_bank (content_cd, test_bank_id,  test_type, question,
			answer_desc, file_picture_name, file_av_name, difficulty) 
			values('$Content_cd', $Test_bank_id, '$Test_type','$Question', 
			   '$Answer_desc', '$File_picture_name', '$File_av_name', '$Difficulty');";
		}
        else{
            db_query( "update test_course set
			test_type = '$Test_type', question = '$Question', answer_desc = '$Answer_desc', 
			file_picture_name = '$File_picture_name', file_av_name = '$File_av_name'
			where test_bankno = '$Modify'");
			$sql = "update test_bank set
			test_type = '$Test_type', question = '$Question', answer_desc = '$Answer_desc', 
			file_picture_name = '$File_picture_name', file_av_name = '$File_av_name'
			where test_bankno = '$Modify'";
		}
		//print $sql;
		db_query($sql);
	}	
?>
