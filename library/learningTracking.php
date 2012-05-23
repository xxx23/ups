<?

//進入或執行某個功能時呼叫
//ex1:登入系統 system_id = 1, function_id = 1, begin_course_cd = -1, 
//ex2:登入課程, 發表文章
//不是在課程中時,begin_course_cd填入-1
function LEARNING_TRACKING_start($system_id, $function_id, $begin_course_cd, $personal_id)
{
	global $DB_CONN;
	
	//取得目前時間
	$currentTime = TIME_date(1) . TIME_time(1);
	
	$function_occur_time = $currentTime;
	
	
	//更新統計資料到到Table event_statistics
	$sql = "SELECT 
				* 
			FROM 
				event_statistics A 
			WHERE 
				A.personal_id = $personal_id AND 
				A.begin_course_cd = $begin_course_cd AND 
				A.system_id = $system_id AND 
				A.function_id = $function_id
			";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$resultNum = $res->numRows();	
	
	if($resultNum == 0)
	{
		$function_hold_time = "00000000" . "000000";
		$function_occur_average_cycle = "00000000" . "000000";
		$function_occur_number = 1;
	
		//新增統計資料到Table event_statistics  
		$sql = "INSERT INTO event_statistics   
					(
						personal_id, 
						begin_course_cd, 
						system_id,
						function_id,
						function_hold_time, 
						function_occur_average_cycle, 
						function_occur_number
					) VALUES (
						$personal_id, 
						$begin_course_cd, 
						$system_id, 
						$function_id, 
						$function_hold_time, 
						$function_occur_average_cycle, 
						$function_occur_number
					)";
		$sth = $DB_CONN->prepare($sql);
		$res = $DB_CONN->execute($sth);
		if (PEAR::isError($res))	die($res->getMessage());
	}
	else
	{
		$res->fetchInto($row, DB_FETCHMODE_ASSOC);
		
		$function_occur_number = $row['function_occur_number'] + 1;

		//更新資料到Table event_statistics
		$sql = "UPDATE 
					event_statistics A 
				SET 
					A.function_occur_number = $function_occur_number 
				WHERE 
					A.personal_id = $personal_id AND 
					A.begin_course_cd = $begin_course_cd AND 
					A.system_id = $system_id AND 
					A.function_id = $function_id
				";
		$sth = $DB_CONN->prepare($sql);
		$res = $DB_CONN->execute($sth);
		if (PEAR::isError($res))	die($res->getMessage());	
		
		//計算功能持續的時間
		LEARNING_TRACKING_update_event_statistics($DB_CONN, 1, 1, -1, $personal_id);
		LEARNING_TRACKING_update_event_statistics($DB_CONN, 1, 2, $begin_course_cd, $personal_id);		
	}
	
	session_start();
	if($system_id == 1 && $function_id == 1 && isset($_SESSION['learningTracking_1_1_' . $personal_id]) == false)
	{
		$_SESSION['learningTracking_1_1_' . $personal_id] = 1;
	}
	
	if($system_id == 1 && $function_id == 2 && isset($_SESSION['learningTracking_1_2_' . $personal_id]) == false)
	{
		$_SESSION['learningTracking_1_2_' . $personal_id] = 1;
	}
	
	
	if($system_id == 4 && $function_id == 1 && isset($_SESSION['learningTracking_4_1_' . $personal_id]) == false)
	{
		$_SESSION['learningTracking_4_1_' . $personal_id] = 1;
	}
	if($system_id != 4 && $function_id != 1 && isset($_SESSION['learningTracking_4_1_' . $personal_id]) == true)
	{
		session_unregister('learningTracking_4_1_'  . $personal_id);
	}
	
	
    //新增事件到Table event 
    // Edit by carlcarl 先作select 如果總共一行以上的話
    // 就做update 如果0行的話表示沒有這個動作 所以就做insert
    // 本來想不用select 直接看update 不過就算沒有update到 他還是回傳1
    // 所以就先加了select判斷
    $sql = "select * from event where
        personal_id=$personal_id and
        begin_course_cd=$begin_course_cd and
        system_id=$system_id and
        function_id=$function_id
        limit 1
        ";
    $row = db_query($sql);
    if($row->numRows() == 1)
    {
        $sql = "update event set function_occur_time=$function_occur_time where
            personal_id=$personal_id and
            begin_course_cd=$begin_course_cd and
            system_id=$system_id and
            function_id=$function_id
            limit 1";

        $res = db_query($sql);
    }
    else if($row->numRows() == 0)
    {
        $sql = "INSERT INTO event  
            (
                personal_id, 
                begin_course_cd, 
                system_id,
                function_id,
                function_occur_time
            ) VALUES (
                $personal_id, 
                $begin_course_cd, 
                $system_id, 
                $function_id, 
                $function_occur_time
            )";
        $sth = $DB_CONN->prepare($sql);
        $res = $DB_CONN->execute($sth);
        if (PEAR::isError($res))	die($res->getMessage());
    }
}


function LEARNING_TRACKING_update_event_statistics($DB_CONN, $system_id, $function_id, $begin_course_cd, $personal_id)
{

	//計算功能持續的時間
	session_start();		
	if(isset($_SESSION['learningTracking_' . $system_id . '_' . $function_id . '_' . $personal_id]) == true)
	{
		//取得目前時間
		$currentTime = TIME_date(2) . " " . TIME_time(2);
		
		
		//先取得原本已經經過的時間
		$sql = "SELECT 
					* 
				FROM 
					event_statistics A 
				WHERE 
					A.personal_id = $personal_id AND 
					A.begin_course_cd = $begin_course_cd AND 
					A.system_id = $system_id AND 
					A.function_id = $function_id
				";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		$resultNum = $res->numRows();	
		
		if($resultNum > 0)
		{
			$res->fetchInto($row, DB_FETCHMODE_ASSOC);
			$function_hold_time = $row['function_hold_time'];		
		

		
			//計算功能持續總時間			
            /*
             * $sql = "SELECT 
						* 
					FROM 
						event A 
					WHERE 
						A.personal_id = $personal_id AND 
						A.begin_course_cd = $begin_course_cd 
					ORDER BY 
						A.function_occur_time DESC
                        ";
             */
            //Edit by carlcar 這個SQL的語法比較快
            $sql = "SELECT 
						MAX(function_occur_time) as function_occur_time
					FROM 
						event A 
					WHERE 
						A.personal_id = $personal_id AND 
						A.begin_course_cd = $begin_course_cd 
                        ";

			$res = $DB_CONN->query($sql);
			if (PEAR::isError($res))	die($res->getMessage());
			//$resultNum = $res->numRows();
			$res->fetchInto($row, DB_FETCHMODE_ASSOC);

			if($row['function_occur_time'] != NULL)
			{
				//for test
				//echo "function_hold_time:" . $function_hold_time . "<br>";
				//echo "currentTime:" . $currentTime . "<br>";
				//echo "function_occur_time:" . $row[function_occur_time] . "<br>";
							
				$passedSecond = substr($function_hold_time,17,2) + substr($currentTime,17,2) -  substr($row['function_occur_time'],17,2);
				$carryNum = floor($passedSecond / 60);
				$passedSecond = $passedSecond % 60;
				if($passedSecond < 0){	$carryNum--;	$passedSecond += 60;}	
				if($passedSecond < 10)	$passedSecond = "0" . $passedSecond;
				
				$passedMinute = substr($function_hold_time,14,2) + substr($currentTime,14,2) -  substr($row['function_occur_time'],14,2) + $carryNum;
				$carryNum = floor($passedMinute / 60);
				$passedMinute = $passedMinute % 60;
				if($passedMinute < 0){	$carryNum--;	$passedMinute += 60;}	
				if($passedMinute < 10)	$passedMinute = "0" . $passedMinute;
				
				$passedHour = substr($function_hold_time,11,2) + substr($currentTime,11,2) -  substr($row['function_occur_time'],11,2) + $carryNum;
				$carryNum = floor($passedHour / 24);
				$passedHour = $passedHour % 24;
				if($passedHour < 0){	$carryNum--;	$passedHour += 24;}	
				if($passedHour < 10)	$passedHour = "0" . $passedHour;
	
				$passedDay = substr($function_hold_time,8,2) + substr($currentTime,8,2) -  substr($row['function_occur_time'],8,2) + $carryNum;
				$carryNum = floor($passedDay / 31);
				$passedDay = $passedDay % 31;
				if($passedDay < 0){	$carryNum--;	$passedDay += 31;}	
				if($passedDay < 10)	$passedDay = "0" . $passedDay;
	
				$passedMonth = substr($function_hold_time,5,2) + substr($currentTime,5,2) -  substr($row['function_occur_time'],5,2) + $carryNum;
				$carryNum = floor($passedMonth / 12);
				$passedMonth = $passedMonth % 12;
				if($passedMonth < 0){	$carryNum--;	$passedMonth += 12;}	
				if($passedMonth < 10)	$passedMonth = "0" . $passedMonth;
				
				
				$passedYear = substr($function_hold_time,0,4) + substr($currentTime,0,4) -  substr($row['function_occur_time'],0,4) + $carryNum;
				$passedYear = floor($passedYear);
				if($passedYear < 10)	$passedYear = "000" . $passedYear;
				else if($passedYear < 100)	$passedYear = "00" . $passedYear;
				else if($passedYear < 1000)	$passedYear = "0" . $passedYear;
				
				$function_hold_time = $passedYear . "-" . $passedMonth . "-" . $passedDay . " " . $passedHour . ":" . $passedMinute  . ":" . $passedSecond;
			}
			
			
			//更新成績資料到Table event_statistics
			$sql = "UPDATE 
						event_statistics A 
					SET 
						A.function_hold_time = '$function_hold_time' 
					WHERE 
						A.personal_id = $personal_id AND 
						A.begin_course_cd = $begin_course_cd AND 
						A.system_id = $system_id AND 
						A.function_id = $function_id
					";
			$sth = $DB_CONN->prepare($sql);
			$res = $DB_CONN->execute($sth);
			if (PEAR::isError($res))	die($res->getMessage());	
		}
	}
}


//結束時呼叫
//ex1:登出系統 system_id = 1, function_id = 1, begin_course_cd = -1, 
//ex2:登出課程, 發表文章完成 
//不是在課程中時,begin_course_cd填入-1
function LEARNING_TRACKING_stop($system_id, $function_id, $begin_course_cd, $personal_id)
{
	session_start();
	session_unregister('learningTracking_' . $system_id . '_' . $function_id . '_' . $personal_id);
}

?>
