<?php
/****************************************************************/
/* id: learning_record.php v1.0 2007/08/31 by hushpuppy			*/
/* function: 教材學習追蹤功能function								*/
/****************************************************************/


//按下教材節點時執行檢察student_learning是否存在此menu_id
//若不存在，則insert此筆資料
//若存在，則update此menu_id的時間(event_last_time)
function learning_status($Content_cd, $Menu_id, $Personal_id)
{
	global $DB_CONN;
	$Begin_course_cd = $_SESSION['begin_course_cd'];
	$sql = "select * from student_learning 
		where begin_course_cd = '$Begin_course_cd' and content_cd = '$Content_cd' and menu_id = '$Menu_id'
		and personal_id = '$Personal_id'";
	$result = $DB_CONN->query($sql);
	//print $sql;
	if($result->numRows() == 0){
		$Event_occur_time = TIME_date(2) . " " . TIME_time(2);
		$sql = "insert into student_learning 
			(begin_course_cd, content_cd, personal_id, menu_id, event_happen_number, event_hold_time,
			event_occur_time, event_last_time) 
			values 
			('$Begin_course_cd', '$Content_cd', '$Personal_id', '$Menu_id', '1', '0', '$Event_occur_time', '$Event_occur_time')";
		//print $sql;
	}
	else{
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$count = $row['event_happen_number'] + 1;
		$Event_last_time = TIME_date(2) . " " . TIME_time(2);
		$sql = "update student_learning set event_last_time = '$Event_last_time', event_happen_number = '$count'
			where begin_course_cd = '$Begin_course_cd' and content_cd = '$Content_cd' 
			and personal_id = '$Personal_id' and menu_id = '$Menu_id'";
	}
	$result = $DB_CONN->query($sql);
	if(PEAR::isError($result))	die($result->userinfo);

}

//按下某menu_id時執行，為了紀錄上ㄧ次按下的menu_id到這次之間經過的時間
//離開某一頁面時會執行
function record_hold_time($Menu_id,$Personal_id,$Begin_course_cd)
{
	global $DB_CONN;
	//$Begin_course_cd = $_SESSION['begin_course_cd'];
	//$Personal_id = $_SESSION['personal_id'];
	//$Menu_id = $_SESSION['menu_id'];
	
	$current_time = TIME_date(2) . " " . TIME_time(2);; //取出現在時間
	
	//取出此menu_id的event_last_time, event_hold_time, event_happen_number
	$sql = "select * from student_learning where 
		begin_course_cd = '$Begin_course_cd' and menu_id = '$Menu_id' and personal_id = '$Personal_id'";

    $test_sql = $sql;

    $result = $DB_CONN->query($sql);
	$row = $result->fetchRow(DB_FETCHMODE_ASSOC);

	$Event_last_time = $row['event_last_time'];
	//$Count = $row['event_happen_number'] + 1;
	$Event_hold_time = $row['event_hold_time'];
	//print $Event_hold_time;
	
	//算出這次在這次menu的停留時間
	//$total_hold_time = hold_time($Event_hold_time, $current_time, $Event_last_time);
	//return_hold_time($Event_hold_time, $current_time, $Event_last_time);
	$sql = "update student_learning 
		set event_hold_time=ADDTIME(event_hold_time,TIMEDIFF(NOW(),'$Event_last_time'))
		where begin_course_cd = '$Begin_course_cd' and personal_id = '$Personal_id' and menu_id = '$Menu_id'";
	$result = $DB_CONN->query($sql);
	file_put_contents("test.txt","123", FILE_APPEND);
    if(PEAR::isError($result))	die($result->userinfo);


	return $test_sql;
}


function hold_time($function_hold_time, $currentTime, $event_last_time)
{
	
	$passedSecond = substr($function_hold_time,6,2) + substr($currentTime,17,2) -  substr($event_last_time,17,2);

	$carryNum = 0;//round($passedSecond / 60);
	$passedSecond = $passedSecond % 60;
	if($passedSecond < 0){	$carryNum--;	$passedSecond += 60;}
	if($passedSecond < 10)	$passedSecond = "0" . $passedSecond;
	
	$passedMinute = substr($function_hold_time,3,2) + substr($currentTime,14,2) -  substr($event_last_time,14,2) + $carryNum;
	$carryNum = 0;//round($passedMinute / 60);
	$passedMinute = $passedMinute % 60;
	if($passedMinute < 0){	$carryNum--;	$passedMinute += 60;}	
	if($passedMinute < 10)	$passedMinute = "0" . $passedMinute;
				
	$passedHour = substr($function_hold_time,0,2) + substr($currentTime,11,2) -  substr($event_last_time,11,2) + $carryNum;
	/*$carryNum = 0;//round($passedHour / 24);
	$passedHour = $passedHour % 24;
	if($passedHour < 0){	$carryNum--;	$passedHour += 24;}	
	if($passedHour < 10)	$passedHour = "0" . $passedHour;*/
	
	$function_hold_time = $passedHour . ":" . $passedMinute  . ":" . $passedSecond;
	
	return $function_hold_time;
}

?>
