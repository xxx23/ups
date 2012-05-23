<?php
/***
FILE:   
DATE:   
AUTHOR: zqq

驗證開課的物件
**/

require_once ('../config.php');
//session_start();
class ValidateBeginCourseAdvance
{
	//DataBase
	private $pearDB;
	private $errorMsg; //for AJAX
	function __construct($DB_CONN)
	{
		$this->pearDB = $DB_CONN;
		$this->errorMsg ='';
	}
	
	function __destruct()
	{
		//$this->pearDB->disconnect();
	}
	
	public function ValidateAJAX ( $inputValue, $fieldID )
	{	
		switch( $fieldID )
		{
			case	'begin_course_name':
				return $this->ValidateBeginCourseName($inputValue);
				break;																														
		}
	}	


	public function queryCourseClassify( $nodeValue, $level )
	{
		switch( $level)
		{
			case '1':  //需要query出  2, 3, 4
				//level 2			
				$sql = "SELECT course_classify_cd, course_classify_name FROM lrtcourse_classify_ WHERE course_classify_level=2 and course_classify_parent='".$nodeValue."'";
				//echo $sql;
				$res = $this->pearDB->query($sql);
				if (PEAR::isError($res))	die($res->getMessage());
				$i=0;
				while($row = $res->fetchRow(DB_FETCHMODE_ASSOC)){
					$response[0][$i]['course_classify_cd']	= $row['course_classify_cd'];
					$response[0][$i]['course_classify_name']= $row['course_classify_name'];
					$i++;
					//echo $row['course_classify_cd']."_<br>";
				}
				//level 3
				$sql = "SELECT course_classify_cd, course_classify_name FROM lrtcourse_classify_ WHERE course_classify_level=3 and course_classify_parent='".$response[0][0]['course_classify_cd']."'";
				$res = $this->pearDB->query($sql);
				if (PEAR::isError($res))	die($res->getMessage());
				$i=0;
				while($row = $res->fetchRow(DB_FETCHMODE_ASSOC)){
					$response[1][$i]['course_classify_cd']	= $row['course_classify_cd'];
					$response[1][$i]['course_classify_name']= $row['course_classify_name'];
					$i++;
				}
				//level 4
				$sql = "SELECT course_classify_cd, course_classify_name FROM lrtcourse_classify_ WHERE course_classify_level=4 and course_classify_parent='".$response[1][0]['course_classify_cd']."'";
				$res = $this->pearDB->query($sql);
				if (PEAR::isError($res))	die($res->getMessage());
				$i=0;
				while($row = $res->fetchRow(DB_FETCHMODE_ASSOC)){
					$response[2][$i]['course_classify_cd']	= $row['course_classify_cd'];
					$response[2][$i]['course_classify_name']= $row['course_classify_name'];
					$i++;
				}									
				break;
			case '2':  //需要query出 3, 4
				//level 3
				$sql = "SELECT course_classify_cd, course_classify_name FROM lrtcourse_classify_ WHERE course_classify_level=3 and course_classify_parent='".$nodeValue."'";
				$res = $this->pearDB->query($sql);
				if (PEAR::isError($res))	die($res->getMessage());
				$i=0;
				while($row = $res->fetchRow(DB_FETCHMODE_ASSOC)){
					$response[0][$i]['course_classify_cd']	= $row['course_classify_cd'];
					$response[0][$i]['course_classify_name']= $row['course_classify_name'];
					$i++;
				}
				//level 4
				$sql = "SELECT course_classify_cd, course_classify_name FROM lrtcourse_classify_ WHERE course_classify_level=4 and course_classify_parent='".$response[0][0]['course_classify_cd']."'";
				$res = $this->pearDB->query($sql);
				if (PEAR::isError($res))	die($res->getMessage());
				$i=0;
				while($row = $res->fetchRow(DB_FETCHMODE_ASSOC)){
					$response[1][$i]['course_classify_cd']	= $row['course_classify_cd'];
					$response[1][$i]['course_classify_name']= $row['course_classify_name'];
					$i++;
				}									
				break;			
			case '3':  //需要query出 4
				//level 4
				$sql = "SELECT course_classify_cd, course_classify_name FROM lrtcourse_classify_ WHERE course_classify_level=4 and course_classify_parent='".$nodeValue."'";
				$res = $this->pearDB->query($sql);
				if (PEAR::isError($res))	die($res->getMessage());
				$i=0;
				while($row = $res->fetchRow(DB_FETCHMODE_ASSOC)){
					$response[0][$i]['course_classify_cd']	= $row['course_classify_cd'];
					$response[0][$i]['course_classify_name']= $row['course_classify_name'];
					$i++;
				}
				break;			
		}
		return $response;
	}

		
	public function ValidatePHP()
	{
		global $COURSE_FILE_PATH,$MEDIA_FILE_PATH; //sad!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
		$errorsExist = 0;
				
		$_SESSION['errors']['begin_course_name'] = 'hidden';
		
		//驗證name
		if( !$this->ValidateBeginCourseName($_POST['begin_course_name']))
		{
			$_SESSION['errors']['begin_course_name'] = 'error';
			$errorsExist = 1;
		}
		
		//驗證通過
		if ( $errorsExist == 0){
			//先rand  出一筆亂數
			$validateKey = $this->randString(60);				
			//選出course_classify_cd 與 course_classify_parent
			if(isset($_POST[course_classify_4])){
				$course_classify_cd = $_POST[course_classify_4];
				$course_classify_parent = $_POST[course_classify_3];
			}
			else{
				if(isset($_POST[course_classify_3])){
					$course_classify_cd = $_POST[course_classify_3];
					$course_classify_parent = $_POST[course_classify_2];				
				}
				else{ 
					if(isset($_POST[course_classify_2])){
						$course_classify_cd = $_POST[course_classify_2];
						$course_classify_parent = $_POST[course_classify_1];							
					}
				}
			}									
			//寫入資料庫  並且在node 塞入 validateKey			
			$sql  = "INSERT INTO begin_course ( course_classify_cd, course_classify_parent, inner_course_cd, begin_unit_cd, begin_course_name, d_course_begin, d_course_end, d_public_day, d_select_begin, d_select_end, course_year, course_session, coursekind, timeSet, charge_type, subsidizeid, certify_type, quantity, certify, subsidize_money, charge, locally, note)";
			
			$sql .= "VALUES ( '$course_classify_cd', '$course_classify_parent', '".$_POST[inner_course_cd]."','".$_POST[begin_unit_cd]."','".$_POST[begin_course_name]."','".$_POST[d_course_begin]."','".$_POST[d_course_end]."','".$_POST[d_public_day]."','".$_POST[d_select_begin]."','".$_POST[d_select_end]."','".$_POST[course_year]."', '".$_POST[course_session]."', '".$_POST[coursekind]."', '". $this->convertTimeSet($_POST[timeSet]) ."', '".$_POST[charge_type]."', '".$_POST[subsidizeid]."' , '". $_POST[certify_type] ."','". $_POST[quantity] ."' , '".$_POST[certify]."', '".$_POST[subsidize_money]."', '".$_POST[charge]."' , '".$_POST[locally]."','$validateKey' )";
			
			$res = $this->pearDB->query($sql);
			if (PEAR::isError($res))	die($res->getMessage());	
			//查出剛剛insert的 begin_course_cd
			$sql = "SELECT begin_course_cd FROM begin_course WHERE begin_course_name='".$_POST[begin_course_name]."' and note='$validateKey' ORDER BY begin_course_cd DESC";
			$begin_course_cd = $this->pearDB->getOne($sql);			
			if (PEAR::isError($res))	die($res->getMessage());
			//清除剛剛塞入的validateKey
			$sql = "UPDATE begin_course SET note=NULL, begin_coursestate='0', course_type='1' WHERE begin_course_cd='$begin_course_cd'";
			$res = $this->pearDB->query($sql);
			if (PEAR::isError($res))	die($res->getMessage());

			//在 /home/CourseFile 與 /home/StreamingFile 裡面建立資料夾 0775
			$courseDir = $COURSE_FILE_PATH . $begin_course_cd;
			$streamingDir = $MEDIA_FILE_PATH . $begin_course_cd;			
			$this->createDIR($courseDir);
			$this->createDIR($streamingDir);										
			unset($_SESSION['values']);
			unset($_SESSION['errors']);													
			return "add_teacher_to_course_advance.php?begin_course_cd=" . $begin_course_cd;				
		}		
		//驗證有錯誤
		else{
			foreach( $_POST as $key => $value){
				$_SESSION['values'][$key] = $_POST[$key];
			}
			return 'add_teacher_to_course_advance.php';
		}		
	}
		
	
	private function ValidateBeginCourseName($value)
	{
		$value = trim($value);
		if($value){
			return 1; //valid
		}	
		else{
			$this->setErrorMsg("課程名稱尚未填入");
			return 0; //not valid	
		}	
	}
			
			
	private function setErrorMsg($msg)
	{
		$this->errorMsg = $msg;
	}
	
	public function getErrorMsg()
	{
		return $this->errorMsg;
	}

	private function randString($len, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789')
	{
    	$string = '';
    	for ($i = 0; $i < $len; $i++)
    	{
        	$pos = rand(0, strlen($chars)-1);
     		$string .= $chars{$pos};
    	}
    	return $string;
	}

	private function convertTimeSet($timeSet){
		//echo "<pre>". print_r($timeSet, true) ."</pre>";
		$time = '';
		for($i=0; $i<count($timeSet); $i++){
			$time .= $timeSet[$i] .","; 
		}
		return $time;
	}
	
	private function createDIR($path){

		if( $path[strlen($path)-1] == '/');
		else
			$path = $path.'/';
					
		$old_umask = umask(0);
		mkdir($path, 0775);
		umask($old_umask);
	}
}

?>
