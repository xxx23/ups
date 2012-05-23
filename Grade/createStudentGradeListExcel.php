<?
/*
DATE:   2007/06/27
AUTHOR: 14_不太想玩
*/
	$RELEATED_PATH = "../";
	
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	$absoluteURL = $HOMEURL . "Grade/";

	session_start();
	$personal_id = $_SESSION['personal_id'];			//取得個人編號
	$role_cd = $_SESSION['role_cd'];					//取得角色
	$begin_course_cd = $_SESSION['begin_course_cd'];	//取得課程代
	
/**************************************************************************************/
//取得成績的種類

	//1.所有線上測驗成績
	//從Table course_percentage搜尋這堂課的所有線上測驗成績
	$percentage_type = 1;
	$sql = "SELECT
				A.number_id id, 
				A.percentage, 
				A.percentage_num no, 
				B.test_name name 
			FROM 
				course_percentage A, 
				test_course_setup B 
			WHERE 
				A.begin_course_cd = $begin_course_cd AND 
				A.percentage_type = '" . $percentage_type . "' AND 
				A.begin_course_cd = B.begin_course_cd AND 
				A.percentage_num = B.test_no 
			ORDER BY 
				A.percentage_num ASC
			";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$resultNum = $res->numRows();	
	if($resultNum > 0)
	{
		$rowCounter = 0;
		
		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
		{	
			$gradeList[$percentage_type][$rowCounter] = 
					array(
							"id" => $row[id], 
							"no" => $row[no], 
							"name" => $row[name], 
							"percentage" => $row[percentage]
							);
			
			$rowCounter++;
		}
		$onlineTestNum = $rowCounter;
	}


	//2.所有的作業成績
	//從Table course_percentage搜尋這堂課的所有作業成績
	$percentage_type = 2;
	$sql = "SELECT 
				A.number_id id, 
				A.percentage, 
				A.percentage_num no, 
				B.homework_name name 
			FROM 
				course_percentage A, 
				homework B 
			WHERE 
				A.begin_course_cd = $begin_course_cd AND 
				A.percentage_type = '" . $percentage_type . "' AND 
				A.begin_course_cd = B.begin_course_cd AND 
				A.percentage_num = B.homework_no 
			ORDER BY 
				A.percentage_num ASC
			";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$resultNum = $res->numRows();	
	
	if($resultNum > 0)
	{
		$rowCounter = 0;
		
		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
		{	
			$gradeList[$percentage_type][$rowCounter] = 
					array(
							"id" => $row[id], 
							"no" => $row[no], 
							"name" => $row[name], 
							"percentage" => $row[percentage]
							);
			
			$rowCounter++;
		}
		$homeworkNum = $rowCounter;
	}

	//3.所有點名成績
	//從Table course_percentage搜尋這堂課的所有點名成績
	$percentage_type = 3;
	$sql = "SELECT 
				A.number_id id, 
				A.percentage, 
				A.percentage_num no 
			FROM 
				course_percentage A 
			WHERE 
				A.begin_course_cd = $begin_course_cd AND 
				A.percentage_type = '" . $percentage_type . "' 
			ORDER BY 
				A.percentage_num ASC
			";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$resultNum = $res->numRows();	
	
	if($resultNum > 0)
	{
		$rowCounter = 0;
		
		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
		{	
			$gradeList[$percentage_type][$rowCounter] = 
					array(
							"id" => $row[id], 
							"no" => $row[no], 
							"name" => "點名". $row[no], 
							"percentage" => $row[percentage]
							);
			
			$rowCounter++;
		}
		$rollNum = $rowCounter;
	}

	//4.所有一般測驗成績
	//從Table course_percentage搜尋這堂課的所有一般測驗成績
	$percentage_type = 4;
	//從test_course_setup取得名稱
	$sql = "SELECT  *
	        FROM test_course_setup
	        WHERE begin_course_cd  = '$begin_course_cd' AND test_type = '$percentage_type' ORDER BY test_no ASC";

	        $res = $DB_CONN->query($sql);
	        if (PEAR::isError($res))        die($res->getMessage());
		        $resultNum = $res->numRows();
		$i= 0;
		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC)){
			$names[$i++]= $row[test_name];
			}
	
	
	$sql = "SELECT 
				A.number_id id, 
				A.percentage, 
				A.percentage_num no 
			FROM 
				course_percentage A 
			WHERE 
				A.begin_course_cd = $begin_course_cd AND 
				A.percentage_type = '" . $percentage_type . "' 
			ORDER BY 
				A.percentage_num ASC
			";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$resultNum = $res->numRows();	
	
	if($resultNum > 0)
	{
		$rowCounter = 0;
		
		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
		{	
			$gradeList[$percentage_type][$rowCounter] = 
					array(
							"id" => $row[id], 
							"no" => $row[no], 
							"name" => $names[$rowCounter], 
							"percentage" => $row[percentage]
							);
			
			$rowCounter++;
		}
		$commTestNum = $rowCounter;
	}

	//5.所有一般作業成績
	//從Table course_percentage搜尋這堂課的所一般作業成績
	$percentage_type = 5;

	//從test_course_setup取得名稱
	$sql = "SELECT  *
	        FROM test_course_setup
	        WHERE begin_course_cd  = '$begin_course_cd' AND test_type = '$percentage_type' ORDER BY test_no ASC";

	        $res = $DB_CONN->query($sql);
	        if (PEAR::isError($res))        die($res->getMessage());
		        $resultNum = $res->numRows();
		$i= 0;
		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC)){
			$names[$i++]= $row[test_name];
		}

	$sql = "SELECT 
				A.number_id id, 
				A.percentage, 
				A.percentage_num no 
			FROM 
				course_percentage A 
			WHERE 
				A.begin_course_cd = $begin_course_cd AND 
				A.percentage_type = '" . $percentage_type . "' 
			ORDER BY 
				A.percentage_num ASC
			";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$resultNum = $res->numRows();	
	
	if($resultNum > 0)
	{
		$rowCounter = 0;
		
		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
		{	
			$gradeList[$percentage_type][$rowCounter] = 
					array(
							"id" => $row[id], 
							"no" => $row[no], 
							"name" => $names[$rowCounter], 
							"percentage" => $row[percentage]
							);
			
			$rowCounter++;
		}
		$commHomeworkNum = $rowCounter;
	}

	//9.所有其他成績
	//從Table course_percentage搜尋這堂課的所有其他成績
	$percentage_type = 9;

	//從test_course_setup取得名稱
	$sql = "SELECT  *
	        FROM test_course_setup
	        WHERE begin_course_cd  = '$begin_course_cd' AND test_type = '$percentage_type' ORDER BY test_no ASC";

	        $res = $DB_CONN->query($sql);
	        if (PEAR::isError($res))        die($res->getMessage());
		        $resultNum = $res->numRows();
		$i= 0;
		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC)){
			$names[$i++]= $row[test_name];
		}

	$sql = "SELECT 
				A.number_id id, 
				A.percentage, 
				A.percentage_num no 
			FROM 
				course_percentage A 
			WHERE 
				A.begin_course_cd = $begin_course_cd AND 
				A.percentage_type = '" . $percentage_type . "' 
			ORDER BY 
				A.percentage_num ASC
			";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$resultNum = $res->numRows();	
	
	if($resultNum > 0)
	{
		$rowCounter = 0;
		
		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
		{	
			$gradeList[$percentage_type][$rowCounter] = 
					array(
							"id" => $row[id], 
							"no" => $row[no], 
							"name" => $names[$rowCounter], 
							"percentage" => $row[percentage]
							);
			
			$rowCounter++;
		}
		$otherNum = $rowCounter;
	}



	//計算總共有幾個成績
	$gradeNum = $onlineTestNum + $homeworkNum + $rollNum + $commTestNum + $commHomeworkNum + $otherNum;


/**************************************************************************************/
/**************************************************************************************/
/**************************************************************************************/
/**************************************************************************************/
/**************************************************************************************/	
/**************************************************************************************/
/**************************************************************************************/
/**************************************************************************************/
/**************************************************************************************/
/**************************************************************************************/		
/**************************************************************************************/
/**************************************************************************************/
/**************************************************************************************/
/**************************************************************************************/
/**************************************************************************************/	
/**************************************************************************************/
//取得所有學生的成績

	

	//從Table take_course取得課程學生名單	
	$sql = "SELECT 
				A.personal_id 
			FROM 
				take_course A 
			WHERE 
            A.begin_course_cd = $begin_course_cd 
            AND A.status_student =1
			ORDER BY 
				A.personal_id ASC
			";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$resultNum = $res->numRows();

	if($resultNum > 0)
	{
		$rowCounter = 0;
		
		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
		{	
			$studentList[$rowCounter][rank] = 0;
			$studentList[$rowCounter][name] = "";
			$studentList[$rowCounter][student_id] = $row[personal_id];
			$studentList[$rowCounter][totalGrade] = 0;
			
			$rowCounter++;
		}
		$studentNum = $rowCounter;
		
		//從Table personal_basic取得學生名稱
		for($studentListCounter=0; $studentListCounter<$studentNum; $studentListCounter++)
		{
			$sql = "SELECT 
						A.personal_name 
					FROM 
						personal_basic A 
					WHERE 
						A.personal_id = " . $studentList[$studentListCounter][student_id] . "
					";
			$res = $DB_CONN->query($sql);
			if (PEAR::isError($res))	die($res->getMessage());
			$resultNum = $res->numRows();
			if($resultNum > 0)
			{
				$res->fetchInto($row, DB_FETCHMODE_ASSOC);
				$studentList[$studentListCounter][name] = $row[personal_name];
			}
		}
	}
	
	
	$gradeCounter = 0;
	
	
	//1.所有線上測驗成績
	//從Table course_concent_grade搜尋所有學生這堂課的所有線上測驗成績
	if($onlineTestNum > 0)
	{
		$percentage_type = 1;
		$sql = "SELECT 
					A.number_id id, 
					A.percentage_num no, 
					A.student_id, 
					A.concent_grade grade 
				FROM 
					course_concent_grade A, 
					course_percentage B 
				WHERE 
					A.begin_course_cd = $begin_course_cd AND 
					A.percentage_type = '" . $percentage_type . "' AND 
					A.begin_course_cd = B.begin_course_cd AND 
					A.number_id = B.number_id 
				ORDER BY 
					A.percentage_num ASC, 
					A.student_id ASC
				";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		$resultNum = $res->numRows();	
		
		if($resultNum > 0)
		{
			$studentListCounter = 0;			
			
			$onlineTestGradeBeginNum = $gradeCounter;
			$onlineTestListCounter = 0;
			
			while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
			{	
				$isError = 0;
				
				$new_id = $row[id];
				$new_no = $row[no];
				$new_student_id = $row[student_id];
				$new_grade = $row[grade];
				
				//for test
				//echo "number_id:" . $new_id . "<br>";
				//echo "percentage_num:" . $new_no . "<br>";
				//echo "gradeList:" . $gradeList[$percentage_type][$onlineTestListCounter][no] . "<br>";
				//echo "student_id:" . $new_student_id . "<br>";
				//echo "concent_grade:" . $new_grade . "<br>";
				//echo "<br>";
	
	
				//判斷是哪一個成績
				
				while($gradeList[$percentage_type][$onlineTestListCounter][no] != $new_no)
				{
					//for test
					//echo "in:" . $gradeList[$percentage_type][$onlineTestListCounter][no] . "<br><br>";
					
					$studentListCounter = 0;
					
					$onlineTestListCounter++;
					
					if($onlineTestListCounter >= $onlineTestNum)
					{
						$isError = 1;
						//echo "<font color='red'>error1</font><br>";
						break;
					}
				}
				if($isError == 1)	continue;	
						
				$gradeCounter = $onlineTestGradeBeginNum + $onlineTestListCounter;
			
				//判斷是哪個學生的成績
				while($studentList[$studentListCounter][student_id] != $new_student_id)
				{
					$studentListCounter++;
					
					if($studentListCounter >= $studentNum)
					{	
						$isError = 1;
						//echo "<font color='red'>error2</font><br>";
						break;
					}
				}
				if($isError == 1)
				{	
					$studentListCounter = 0;
					continue;
				}
				
				//將資料放入輸出
				$studentList[$studentListCounter][totalGrade] += $new_grade * $gradeList[$percentage_type][$onlineTestListCounter][percentage] / 100;
				$studentGradeList[$studentListCounter][$gradeCounter] = $new_grade;
				//echo "student_id:" . $studentList[$studentListCounter][student_id] . "<br>";
				//echo "grade:" . $studentGradeList[$studentListCounter][$gradeCounter] . "<br>";
				//echo "<br>";
			}
		}	
	}
	
	$gradeCounter = $onlineTestNum;


	//2.所有的線上作業成績
	//從Table homework搜尋這個學生這堂課的所有線上作業成績
	if($homeworkNum > 0)
	{
		$percentage_type = 2;
		$sql = "SELECT 
					A.number_id id, 
					A.percentage_num no, 
					A.student_id, 
					A.concent_grade grade 
				FROM 
					course_concent_grade A, 
					course_percentage B 
				WHERE 
					A.begin_course_cd = $begin_course_cd AND 
					A.percentage_type = '" . $percentage_type . "' AND 
					A.begin_course_cd = B.begin_course_cd AND 
					A.number_id = B.number_id 
				ORDER BY 
					A.percentage_num ASC, 
					A.student_id ASC
				";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		$resultNum = $res->numRows();	
		
		if($resultNum > 0)
		{
			$studentListCounter = 0;
			
			
			$homeworkGradeBeginNum = $gradeCounter;
			$homeworkListCounter = 0;
			
			while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
			{	
				$isError = 0;
				
				$new_id = $row[id];
				$new_no = $row[no];
				$new_student_id = $row[student_id];
				$new_grade = $row[grade];
				
				//for test
				//echo "number_id:" . $new_id . "<br>";
				//echo "percentage_num:" . $new_no . "<br>";
				//echo "student_id:" . $new_student_id . "<br>";
				//echo "concent_grade:" . $new_grade . "<br>";
				//echo "<br>";
	
	
				//判斷是哪一個成績
				while($gradeList[$percentage_type][$homeworkListCounter][no] != $new_no)
				{
					//for test
					//echo "in:" . $gradeList[$percentage_type][$homeworkListCounter][no] . "<br><br>";
					
					
					$studentListCounter = 0;
					
					$homeworkListCounter++;
					
					if($homeworkListCounter >= $homeworkNum)
					{
						$isError = 1;
						//echo "<font color='red'>error1</font><br>";
						break;
					}
				}
				if($isError == 1)	break;
				
				$gradeCounter = $homeworkGradeBeginNum + $homeworkListCounter;
			
				//判斷是哪個學生的成績
				while($studentList[$studentListCounter][student_id] != $new_student_id)
				{
					$studentListCounter++;
					
					if($studentListCounter >= $studentNum)
					{	
						$isError = 1;
						//echo "<font color='red'>error2</font><br>";
						break;
					}
				}
				if($isError == 1)
				{	
					$studentListCounter = 0;
					continue;
				}
				
				//將資料放入輸出
				$studentList[$studentListCounter][totalGrade] += $new_grade * $gradeList[$percentage_type][$homeworkListCounter][percentage] / 100;
				$studentGradeList[$studentListCounter][$gradeCounter] = $new_grade;
				//echo "<br>";
			}
		}
	}

	$gradeCounter = $onlineTestNum + $homeworkNum;
	


	//3.所有的點名成績
	//從Table roll_book搜尋這個學生這堂課的所有點名成績
	if($rollNum > 0)
	{
		$percentage_type = 3;
		$sql = "SELECT 
					A.number_id id, 
					A.percentage_num no, 
					A.student_id, 
					A.concent_grade grade 
				FROM 
					course_concent_grade A, 
					course_percentage B 
				WHERE 
					A.begin_course_cd = $begin_course_cd AND 
					A.percentage_type = '" . $percentage_type . "' AND 
					A.begin_course_cd = B.begin_course_cd AND 
					A.number_id = B.number_id 
				ORDER BY 
					A.percentage_num ASC, 
					A.student_id ASC
				";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		$resultNum = $res->numRows();	
		
		if($resultNum > 0)
		{
			$studentListCounter = 0;
						
			$rollGradeBeginNum = $gradeCounter;
			$rollListCounter = 0;
			
			while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
			{	
				$isError = 0;
				
				$new_id = $row[id];
				$new_no = $row[no];
				$new_student_id = $row[student_id];
				$new_grade = $row[grade];
				
				//for test
				//echo "number_id:" . $new_id . "<br>";
				//echo "percentage_num:" . $new_no . "<br>";
				//echo "student_id:" . $new_student_id . "<br>";
				//echo "concent_grade:" . $new_grade . "<br>";
				//echo "<br>";
	
	
				//判斷是哪一個成績
				while($gradeList[$percentage_type][$rollListCounter][no] != $new_no)
				{
					$studentListCounter = 0;
					
					$rollListCounter++;
					
					if($rollListCounter >= $rollNum)
					{
						$isError = 1;
						break;
					}
				}
				if($isError == 1)	break;			
				
				$gradeCounter = $rollGradeBeginNum + $rollListCounter;
			
				//判斷是哪個學生的成績
				while($studentList[$studentListCounter][student_id] != $new_student_id)
				{
					$studentListCounter++;
					
					if($studentListCounter >= $studentNum)
					{	
						$isError = 1;
						break;
					}
				}
				if($isError == 1)
				{	
					$studentListCounter = 0;
					continue;
				}
				
				//將資料放入輸出
				$studentList[$studentListCounter][totalGrade] += $new_grade * $gradeList[$percentage_type][$rollListCounter][percentage] / 100;
				$studentGradeList[$studentListCounter][$gradeCounter] = $new_grade;
			}
		}
	}
	
	$gradeCounter = $onlineTestNum + $homeworkNum + $rollNum;
	


	//4.所有一般測驗成績
	//從Table course_percentage搜尋這堂課的所有一般測驗成績
	if($commTestNum > 0)
	{
		$percentage_type = 4;
		$sql = "SELECT 
					A.number_id id, 
					A.percentage_num no, 
					A.student_id, 
					A.concent_grade grade 
				FROM 
					course_concent_grade A, 
					course_percentage B 
				WHERE 
					A.begin_course_cd = $begin_course_cd AND 
					A.percentage_type = '" . $percentage_type . "' AND 
					A.begin_course_cd = B.begin_course_cd AND 
					A.number_id = B.number_id 
				ORDER BY 
					A.percentage_num ASC, 
					A.student_id ASC
				";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		$resultNum = $res->numRows();	
		
		if($resultNum > 0)
		{
			$studentListCounter = 0;
			
			
			$commTestGradeBeginNum = $gradeCounter;
			$commTestListCounter = 0;
			
			while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
			{	
				$isError = 0;
				
				$new_id = $row[id];
				$new_no = $row[no];
				$new_student_id = $row[student_id];
				$new_grade = $row[grade];
				
				//for test
				//echo "number_id:" . $new_id . "<br>";
				//echo "percentage_num:" . $new_no . "<br>";
				//echo "student_id:" . $new_student_id . "<br>";
				//echo "concent_grade:" . $new_grade . "<br>";
				//echo "<br>";
	
	
				//判斷是哪一個成績
				while($gradeList[$percentage_type][$commTestListCounter][no] != $new_no)
				{
					$studentListCounter = 0;
					
					$commTestListCounter++;
					
					if($commTestListCounter >= $commTestNum)
					{
						$isError = 1;
						break;
					}
				}
				if($isError == 1)	break;	
						
				$gradeCounter = $commTestGradeBeginNum + $commTestListCounter;
			
				//判斷是哪個學生的成績
				while($studentList[$studentListCounter][student_id] != $new_student_id)
				{
					$studentListCounter++;
					
					if($studentListCounter >= $studentNum)
					{	
						$isError = 1;
						break;
					}
				}
				if($isError == 1)
				{	
					$studentListCounter = 0;
					continue;
				}
				
				//將資料放入輸出
				$studentList[$studentListCounter][totalGrade] += $new_grade * $gradeList[$percentage_type][$commTestListCounter][percentage] / 100;
				$studentGradeList[$studentListCounter][$gradeCounter] = $new_grade;
			}
		}
	}
	$gradeCounter = $onlineTestNum + $homeworkNum + $rollNum + $commTestNum;
	


	//5.所有一般作業成績
	//從Table course_concent_grade搜尋這堂課的所有一般作業成績
	if($commHomeworkNum > 0)
	{
		$percentage_type = 5;
		$sql = "SELECT 
					A.number_id id, 
					A.percentage_num no, 
					A.student_id, 
					A.concent_grade grade 
				FROM 
					course_concent_grade A, 
					course_percentage B 
				WHERE 
					A.begin_course_cd = $begin_course_cd AND 
					A.percentage_type = '" . $percentage_type . "' AND 
					A.begin_course_cd = B.begin_course_cd AND 
					A.number_id = B.number_id 
				ORDER BY 
					A.percentage_num ASC, 
					A.student_id ASC
				";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		$resultNum = $res->numRows();	
		
		if($resultNum > 0)
		{
			$studentListCounter = 0;
						
			$commHomeworkGradeBeginNum = $gradeCounter;
			$commHomeworkListCounter = 0;
			
			while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
			{	
				$isError = 0;
				
				$new_id = $row[id];
				$new_no = $row[no];
				$new_student_id = $row[student_id];
				$new_grade = $row[grade];
				
				//for test
				//echo "number_id:" . $new_id . "<br>";
				//echo "percentage_num:" . $new_no . "<br>";
				//echo "student_id:" . $new_student_id . "<br>";
				//echo "concent_grade:" . $new_grade . "<br>";
				//echo "<br>";
	
	
				//判斷是哪一個成績
				while($gradeList[$percentage_type][$commHomeworkListCounter][no] != $new_no)
				{
					$studentListCounter = 0;
					
					$commHomeworkListCounter++;
					
					if($commHomeworkListCounter >= $commHomeworkNum)
					{
						$isError = 1;
						break;
					}
				}
				if($isError == 1)	break;	
						
				$gradeCounter = $commHomeworkGradeBeginNum + $commHomeworkListCounter;
			
				//判斷是哪個學生的成績
				while($studentList[$studentListCounter][student_id] != $new_student_id)
				{
					$studentListCounter++;
					
					if($studentListCounter >= $studentNum)
					{	
						$isError = 1;
						break;
					}
				}
				if($isError == 1)
				{	
					$studentListCounter = 0;
					continue;
				}
				
				//將資料放入輸出
				$studentList[$studentListCounter][totalGrade] += $new_grade * $gradeList[$percentage_type][$commHomeworkListCounter][percentage] / 100;
				$studentGradeList[$studentListCounter][$gradeCounter] = $new_grade;
			}
		}
	}
	$gradeCounter = $onlineTestNum + $homeworkNum + $rollNum + $commTestNum + $commHomeworkNum;

	//9.所有其他成績
	//從Table course_concent_grade搜尋這堂課的所有其他成績
	if($commTestNum > 0)
	{
		$percentage_type = 9;
		$sql = "SELECT 
					A.number_id id, 
					A.percentage_num no, 
					A.student_id, 
					A.concent_grade grade 
				FROM 
					course_concent_grade A, 
					course_percentage B 
				WHERE 
					A.begin_course_cd = $begin_course_cd AND 
					A.percentage_type = '" . $percentage_type . "' AND 
					A.begin_course_cd = B.begin_course_cd AND 
					A.number_id = B.number_id 
				ORDER BY 
					A.percentage_num ASC, 
					A.student_id ASC
				";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		$resultNum = $res->numRows();	
		
		if($resultNum > 0)
		{
			$studentListCounter = 0;
						
			$otherGradeBeginNum = $gradeCounter;
			$otherListCounter = 0;
			
			while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
			{	
				$isError = 0;
				
				$new_id = $row[id];
				$new_no = $row[no];
				$new_student_id = $row[student_id];
				$new_grade = $row[grade];
				
				//for test
				//echo "number_id:" . $new_id . "<br>";
				//echo "percentage_num:" . $new_no . "<br>";
				//echo "student_id:" . $new_student_id . "<br>";
				//echo "concent_grade:" . $new_grade . "<br>";
				//echo "<br>";
	
	
				//判斷是哪一個成績
				while($gradeList[$percentage_type][$otherListCounter][no] != $new_no)
				{
					$studentListCounter = 0;
					
					$otherListCounter++;
					
					if($otherListCounter >= $otherNum)
					{
						$isError = 1;
						break;
					}
				}
				if($isError == 1)	break;		
					
				$gradeCounter = $otherGradeBeginNum + $otherListCounter;
			
				//判斷是哪個學生的成績
				while($studentList[$studentListCounter][student_id] != $new_student_id)
				{
					$studentListCounter++;
					
					if($studentListCounter >= $studentNum)
					{	
						$isError = 1;
						break;
					}
				}
				if($isError == 1)
				{	
					$studentListCounter = 0;
					continue;
				}
				
				//將資料放入輸出
				$studentList[$studentListCounter][totalGrade] += $new_grade * $gradeList[$percentage_type][$otherListCounter][percentage] / 100;
				$studentGradeList[$studentListCounter][$gradeCounter] = $new_grade;
			}
		}
	}
	$gradeCounter = $onlineTestNum + $homeworkNum + $rollNum + $commTestNum + $homeworkNum + $otherNum;


	//將資料庫沒有的資料填上0
	for($studentListCounter=0; $studentListCounter<$studentNum; $studentListCounter++)
	{
		for($gradeCounter=0; $gradeCounter<$gradeNum; $gradeCounter++)
		{
			//for test
			/*
			echo "";
			echo $studentListCounter;
			echo " ";
			echo "";
			echo $gradeCounter;
			echo "<br>";
			*/
			
			if( $studentGradeList[$studentListCounter][$gradeCounter] == NULL)
			{
				$studentGradeList[$studentListCounter][$gradeCounter] = 0;
			}
		}
	}	
	
	//依照總分作排序	
	for($studentListCounter=0; $studentListCounter<$studentNum-1; $studentListCounter++)
	{
		$maxNum = $studentListCounter;
		$maxGrade = $studentList[$maxNum][totalGrade];
		
		for($studentListCounter2=$studentListCounter+1; $studentListCounter2<$studentNum; $studentListCounter2++)
		{
			if($studentList[$studentListCounter2][totalGrade] > $maxGrade)
			{
				$maxNum = $studentListCounter2;
				$maxGrade = $studentList[$maxNum][totalGrade];
			}
		}
		
		//將資料做交換
		$studentList[$studentListCounter][rank] = $studentListCounter+1;
		swap($studentList[$studentListCounter][name], $studentList[$maxNum][name]);
		swap($studentList[$studentListCounter][personal_id], $studentList[$maxNum][personal_id]);
		swap($studentList[$studentListCounter][totalGrade], $studentList[$maxNum][totalGrade]);
		for($gradeCounter=0; $gradeCounter<$gradeNum; $gradeCounter++)
		{
			swap($studentGradeList[$studentListCounter][$gradeCounter], $studentGradeList[$maxNum][$gradeCounter]);
		}
	}
	$studentList[$studentListCounter][rank] = $studentListCounter+1;

	

	//計算各項成績的最高分, 最低分, 平均	
	for($gradeCounter=0; $gradeCounter<$gradeNum; $gradeCounter++)
	{	
		$max = $studentGradeList[0][$gradeCounter];
		$min = $studentGradeList[0][$gradeCounter];
		$sum = 0;
		
		for($studentListCounter=0; $studentListCounter<$studentNum; $studentListCounter++)
		{
			if($gradeList[$studentListCounter][$gradeCounter] > $max)
				$max = $studentGradeList[$studentListCounter][$gradeCounter];
				
			if($gradeList[$studentListCounter][$gradeCounter] < $min)
				$min = $studentGradeList[$studentListCounter][$gradeCounter];
				
			$sum += $studentGradeList[$studentListCounter][$gradeCounter];
		}
		
		$maxGradeList[$gradeCounter] = $max;
		$minGradeList[$gradeCounter] = $min;
		$avgGradeList[$gradeCounter] = number_format($sum/$studentNum, 2, '.', '');//只顯示到小數點兩位
	}
	
	//計算總成績的最高分, 最低分, 平均	
	$max = $studentList[0][totalGrade];
	$min = $studentList[0][totalGrade];
	$sum = 0;
	for($studentListCounter=0; $studentListCounter<$studentNum; $studentListCounter++)
	{
		if($studentList[$studentListCounter][totalGrade] > $max)
			$max = $studentList[$studentListCounter][totalGrade];
			
		if($studentList[$studentListCounter][totalGrade] < $min)
			$min = $studentList[$studentListCounter][totalGrade];
			
		$sum += $studentList[$studentListCounter][totalGrade];
	}
	$maxGradeList[$gradeNum] = $max;
	$minGradeList[$gradeNum] = $min;
	$avgGradeList[$gradeNum] = number_format($sum/$studentNum, 2, '.', '');

	

//產生Excel
//********************************************************************************
//********************************************************************************
//********************************************************************************
//********************************************************************************	
//********************************************************************************

	
	$fileContent = "";


	//產生標題列	
	$word = "排名\t姓名\t";
	$fileContent = $fileContent . iconv("UTF-8","big5", $word);

	foreach($gradeList as $gradeTypeItem) 
	{
		foreach($gradeTypeItem as $gradeItem) 
		{
			$word = $gradeItem[name] . "\t";
			$fileContent = $fileContent . iconv("UTF-8","big5", $word);
		}
	}
	
	$word = "總成績\t";
	$fileContent = $fileContent . iconv("UTF-8","big5", $word);
	
	$word = "\n";
	$fileContent = $fileContent . iconv("UTF-8","big5", $word);
	
	
	//產生學生成績的部份
	for($studentListCounter=0; $studentListCounter<$studentNum; $studentListCounter++)
	{
		$word = $studentList[$studentListCounter][rank] . "\t";
		$fileContent = $fileContent . iconv("UTF-8","big5", $word);
		
		$word = $studentList[$studentListCounter][name] . "\t";
		$fileContent = $fileContent . iconv("UTF-8","big5", $word);
		
		
		for($gradeCounter=0; $gradeCounter<$gradeNum; $gradeCounter++)
		{
			$word = $studentGradeList[$studentListCounter][$gradeCounter] . "\t";
			$fileContent = $fileContent . iconv("UTF-8","big5", $word);
		}
		
		
		$word = $studentList[$studentListCounter][totalGrade] . "\t";
		$fileContent = $fileContent . iconv("UTF-8","big5", $word);
		
		$word = "\n";
		$fileContent = $fileContent . iconv("UTF-8","big5", $word);
	}
	
	
	//最高分
	$word = "最高分\t\t";
	$fileContent = $fileContent . iconv("UTF-8","big5", $word);
	for($gradeCounter=0; $gradeCounter<$gradeNum+1; $gradeCounter++)
	{	
		$word = $maxGradeList[$gradeCounter] . "\t";;
		$fileContent = $fileContent . iconv("UTF-8","big5", $word);
	}
	$word = "\n";
	$fileContent = $fileContent . iconv("UTF-8","big5", $word);
	
	//最低分
	$word = "最低分\t\t";
	$fileContent = $fileContent . iconv("UTF-8","big5", $word);
	for($gradeCounter=0; $gradeCounter<$gradeNum+1; $gradeCounter++)
	{	
		$word = $minGradeList[$gradeCounter] . "\t";;
		$fileContent = $fileContent . iconv("UTF-8","big5", $word);
	}
	$word = "\n";
	$fileContent = $fileContent . iconv("UTF-8","big5", $word);
	
	//平均
	$word = "平均\t\t";
	$fileContent = $fileContent . iconv("UTF-8","big5", $word);
	for($gradeCounter=0; $gradeCounter<$gradeNum+1; $gradeCounter++)
	{	
		$word = $avgGradeList[$gradeCounter] . "\t";;
		$fileContent = $fileContent . iconv("UTF-8","big5", $word);
	}
	$word = "\n";
	$fileContent = $fileContent . iconv("UTF-8","big5", $word);
	
	
	
	//將傳送Excel檔案讓使用者下載
	$fileName = "StudentGradeList.xls";
	header("Content-type:application/vnd.ms-excel");
	header("Content-Disposition:filename=" . $fileName);
	echo $fileContent;


//**************************************************************************
	
	function swap(&$a, &$b)
	{
		$tmp = $a;
		$a = $b;
		$b = $tmp;
	}	
?>
