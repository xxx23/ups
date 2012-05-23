<?php
/*
更新schedule page的內容
*/
	$RELEATED_PATH = "../";
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	
	$target = $_POST['target'];
	//更新新增的位置
	if($target == "updatePosition"){
		//查出這門課所有的schedule並且回傳position
		$sql = "SELECT schedule_index FROM course_schedule WHERE begin_course_cd='".$_SESSION[begin_course_cd]."'";
		$res = $DB_CONN->query($sql);
		if(PEAR::isError($res))	die($res->getMessage());
		$positionSelect = createPositionSelect($res);
		$doc = new DOMDocument('1.0', 'UTF-8');
		$doc->formatOutput = true;
		$response = $doc->createElement('response');
		for($i=0; $i < count($positionSelect);$i++){
			$option = $doc->createElement('option');
			$option->appendChild($doc->createTextNode($positionSelect[$i]));
			$response->appendChild($option);
		}
		$doc->appendChild($response);		
		$XML_Document =  $doc->saveXML();
		header('Content-Type: text/xml');  //這行一定要加 orz
		echo $XML_Document;
	}
	//更新course unit
	else if($target == "updateCourseUnit"){
		//更新
		$sql = "UPDATE course_basic SET schedule_unit='".$_POST['unit']."' WHERE course_cd='".$_SESSION[course_cd]."'";
		$res = $DB_CONN->query($sql);
		if(PEAR::isError($res))	die($res->getMessage());
	} 
	//更新course schedule
	else if($target == "insertSchedule"){
		//insert schedule
		//查出目前有幾筆記錄
		$sql = "SELECT COUNT(schedule_index) FROM course_schedule WHERE begin_course_cd='".$_SESSION[begin_course_cd]."'";
		$count = $DB_CONN->getOne($sql);
		if($count != 0){
			$sql = "INSERT INTO course_schedule (begin_course_cd, course_schedule_day, schedule_index, subject, course_type, teacher_cd, course_activity)
			 		VALUES ('".$_SESSION[begin_course_cd]."', '".$_POST[course_schedule_day]."', '".sortScheduleIndex($_POST[position], $count, $DB_CONN)."', '".$_POST[subject]."', '".$_POST[course_type]."', '".$_POST[teach_teacher]."', '".$_POST[course_activity]."')";
			$res = $DB_CONN->query($sql);
			if(PEAR::isError($res))	die($res->getMessage());				
		}
		//如果為 0 直接 insert
		else{
		//schedule_index = 1
			$sql = "INSERT INTO course_schedule (begin_course_cd, course_schedule_day, schedule_index, subject, course_type, teacher_cd, course_activity)
			 		VALUES ('".$_SESSION[begin_course_cd]."', '".$_POST[course_schedule_day]."', '1', '".$_POST[subject]."', '".$_POST[course_type]."', '".$_POST[teach_teacher]."', '".$_POST[course_activity]."')";
			$res = $DB_CONN->query($sql);
			if(PEAR::isError($res))	die($res->getMessage());					
		}
	}
	else if($target == "delectSchedule"){
		//delete a schedule
		$sql = "DELETE FROM course_schedule WHERE  begin_course_cd='".$_SESSION[begin_course_cd]."' AND schedule_index='".$_POST[position]."'";
		$res = $DB_CONN->query($sql);
		if(PEAR::isError($res))	die($res->getMessage());
		sortScheduleIndexAfterDelete($_POST[position], $DB_CONN);
		//查出目前有幾筆記錄
	}
	else if($target == "modifySchedule"){
		//modify
		$sql = "UPDATE course_schedule SET course_schedule_day='".$_POST[course_schedule_day]."' , subject='".$_POST[subject]."' , course_type='".$_POST[course_type]."' , course_activity='".$_POST[course_activity]."' WHERE begin_course_cd='".$_SESSION[begin_course_cd]."' AND schedule_index='".$_POST[position]."'";
		$res = $DB_CONN->query($sql);
		if(PEAR::isError($res))	die($res->getMessage());	
	}

//--------function area-------------
function createPositionSelect($sqlResult){

	$positionSelect[0] = "請選擇插入點";
	if($sqlResult->numRows()!=0){	
		$count = 0;
		while(true){
			$count++;	
			if($row = $sqlResult->fetchRow(DB_FETCHMODE_ASSOC)){		
				$positionSelect[$count] = "在".$row[schedule_index]."之前";
				$tmp = $row[schedule_index];
			}
			else
				break;			
		}
		$positionSelect[$count] = "在".$tmp."之後";
	}
	//如果為空特別處理	
	else{
		$positionSelect[1] = "第一筆資料";
	}
	return $positionSelect;			
}	

function sortScheduleIndex($position, $count, $DB){
	//如果 $position <= $count 新增在中間 並且剩下的shift 1個位置
	if($position <= $count){
		for($i = $count; $i >= $position; $i--){
			$sql = "UPDATE course_schedule SET schedule_index='" . ($i+1) . "' WHERE begin_course_cd='".$_SESSION[begin_course_cd]."' AND schedule_index='". $i ."'";
			$res = $DB->query($sql);
			if(PEAR::isError($res))	die($res->getMessage());		
		}
	}
	//如果 $position > $count 在最下方新增一筆 
	else{	
		//do nothing
	}
	return $position;
}

function sortScheduleIndexAfterDelete($position, $DB){
	//查出目前有幾筆記錄
	$sql = "SELECT COUNT(schedule_index) FROM course_schedule WHERE begin_course_cd='".$_SESSION[begin_course_cd]."'";
	$count = $DB->getOne($sql);
	//如果 count不為零
	if($count != 0){
		if($position < $count+1){
			for($i = $position+1 ; $i <= $count+1; $i++){
				$sql = "UPDATE course_schedule SET schedule_index='" . ($i-1) . "' WHERE begin_course_cd='".$_SESSION[begin_course_cd]."' AND schedule_index='". $i ."'";
				$res = $DB->query($sql);
				if(PEAR::isError($res))	die($res->getMessage());						
			}	
		}
	}
}

?>
