<?
/*
DATE:   2007/07/08
AUTHOR: 14_不太想玩
*/

//*****************************************************************************
//*****************************************************************************
//*****************************************************************************
//*****************************************************************************
//*****************************************************************************
//*****************************************************************************
//以下程式跟showOneStudentGradeList.php相同

	$RELEATED_PATH = "../";
	
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	require_once("library.php");
	$IMAGE_PATH = $IMAGE_PATH;
	$CSS_PATH = $RELEATED_PATH . $CSS_PATH;
	$absoluteURL = $HOMEURL . "Grade/";

	session_start();
	$personal_id = $_SESSION['personal_id'];			//取得個人編號
	$role_cd = $_SESSION['role_cd'];					//取得角色
	$begin_course_cd = $_SESSION['begin_course_cd'];	//取得課程代碼

	//從Table personal_basic取得學生資料
	$sql = "SELECT * 
			FROM 
				personal_basic
			WHERE 
				personal_id = $personal_id";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$res->fetchInto($row, DB_FETCHMODE_ASSOC);
	$studentName = $row[personal_name];

	//從Table take_course取得課程學生總數, 學生列表
	$sql = "SELECT * 
			FROM 
				take_course 
			WHERE 
				begin_course_cd = $begin_course_cd
			ORDER BY personal_id ASC";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$resultNum = $res->numRows();
	
	$studentNum = $resultNum;

	if($resultNum > 0)
	{
		$rowCounter = 0;
		
		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
		{	
			$studentList[$rowCounter] = 
					array(
							"personal_id" => $row[personal_id], 
							"totalGrade" => 0
							);
			$rowCounter++;
		}
	}

	//總成績
	$totalGrade = 0;
	
/*************************************************************************************/
	
	//設定預設預設會顯示成績
	setupGradeDefaultPrint($DB_CONN, $begin_course_cd);
	
	
	//1.所有線上測驗成績
	//從Table course_percentage搜尋這堂課的所有線上測驗成績
	$percentage_type = 1;
	$sql = "SELECT
				A.number_id, 
				A.percentage, 
				A.percentage_num, 
				B.test_name name 
			FROM 
				course_percentage A, 
				test_course_setup B, 
				course_grade_report C 
			WHERE 
				A.begin_course_cd = $begin_course_cd AND 
				A.percentage_type = '" . $percentage_type . "' AND 
				A.begin_course_cd = B.begin_course_cd AND 
				A.percentage_num = B.test_no AND 
				A.begin_course_cd = C.begin_course_cd AND 
				A.percentage_type = C.percentage_type AND 
				A.percentage_num = C.precentage_num AND 
				C.print = 1 
			ORDER BY 
				A.percentage_num
			";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$resultNum = $res->numRows();	
	if($resultNum > 0)
	{
		$rowCounter = 0;
		
		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
		{	
			$studentGradeList[$percentage_type][$rowCounter] = 
					array(
							"number_id" => $row[number_id], 
							"percentage_num" => $row[percentage_num], 
							"concent_grade" => "", 
							"percentage" => $row[percentage], 
							"name" => $row[name], 
							"rank" => ""
							);
			$rowCounter++;
		}
		$onlineTestNum = $rowCounter;
	}		
		
	//取得並計算學生每個成績排名
	for($onlineTestCounter=0; $onlineTestCounter<$onlineTestNum; $onlineTestCounter++)
	{
		$number_id = $studentGradeList[$percentage_type][$onlineTestCounter][number_id];
	
		$sql = "SELECT 
					* 
				FROM 
					course_concent_grade A 
				WHERE 
					A.begin_course_cd = $begin_course_cd AND 
					A.number_id = $number_id
				ORDER BY
					A.concent_grade DESC
				";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		$resultNum = $res->numRows();	
		if($resultNum > 0)
		{
			$rowCounter = 0;
			$rank = 1;
			
			while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
			{	
				if($row[student_id] == $personal_id)
				{
					$studentGradeList[$percentage_type][$onlineTestCounter][concent_grade] = $row[concent_grade];
					$studentGradeList[$percentage_type][$onlineTestCounter][rank] = $rank;
					
					//計算總成績
					$totalGrade += $studentGradeList[$percentage_type][$onlineTestCounter][percentage] * $row[concent_grade] / 100;
					
					break;
				}
								
				$rowCounter++;
				$rank++;
			}
		}	
		
		//將資料庫沒有的資料填上0
		if( $studentGradeList[$percentage_type][$onlineTestCounter][rank] == "")
		{
			$studentGradeList[$percentage_type][$onlineTestCounter][rank] = 0;
		}
		if( $studentGradeList[$percentage_type][$onlineTestCounter][concent_grade] == "")
		{
			$studentGradeList[$percentage_type][$onlineTestCounter][concent_grade] = 0;
		}
		
		//做分數的轉換
		$sql = "SELECT 
					* 
				FROM 
					grade_convert A 
				WHERE 
					A.begin_course_cd = $begin_course_cd AND 
					A.grade_type_cd = '$percentage_type' AND 
					A.grade <= " . $studentGradeList[$percentage_type][$onlineTestCounter][concent_grade] . " 
				ORDER BY 
					A.grade DESC
				";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		$resultNum = $res->numRows();	
		if($resultNum > 0)
		{
			$res->fetchInto($row, DB_FETCHMODE_ASSOC);
			
			$studentGradeList[$percentage_type][$onlineTestCounter][concent_grade] = $row[grade_convert];
		}
	}	



	//2.所有的作業成績
	//從Table homework搜尋這個學生這堂課的所有作業成績
	$percentage_type = 2;
	$sql = "SELECT
				A.number_id, 
				A.percentage, 
				A.percentage_num, 
				B.homework_name name 
			FROM 
				course_percentage A, 
				homework B, 
				course_grade_report C 
			WHERE 
				A.begin_course_cd = $begin_course_cd AND 
				A.percentage_type = '" . $percentage_type . "' AND 
				A.begin_course_cd = B.begin_course_cd AND 
				A.percentage_num = B.homework_no AND 
				A.begin_course_cd = C.begin_course_cd AND 
				A.percentage_type = C.percentage_type AND 
				A.percentage_num = C.precentage_num AND 
				C.print = 1 
			ORDER BY 
				A.percentage_num
			";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$resultNum = $res->numRows();	
	if($resultNum > 0)
	{
		$rowCounter = 0;
		
		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
		{	
			$studentGradeList[$percentage_type][$rowCounter] = 
					array(
							"number_id" => $row[number_id], 
							"percentage_num" => $row[percentage_num], 
							"concent_grade" => "", 
							"percentage" => $row[percentage], 
							"name" => $row[name], 
							"rank" => ""
							);
			$rowCounter++;
		}
		$homeworkNum = $rowCounter;
	}		
		
	//取得並計算學生每個成績排名
	for($homeworkCounter=0; $homeworkCounter<$homeworkNum; $homeworkCounter++)
	{
		$number_id = $studentGradeList[$percentage_type][$homeworkCounter][number_id];
	
		$sql = "SELECT 
					* 
				FROM 
					course_concent_grade A 
				WHERE 
					A.begin_course_cd = $begin_course_cd AND 
					A.number_id = $number_id 
				ORDER BY 
					A.concent_grade DESC
				";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		$resultNum = $res->numRows();	
		if($resultNum > 0)
		{
			$rowCounter = 0;
			$rank = 1;
			
			while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
			{	
				if($row[student_id] == $personal_id)
				{
					$studentGradeList[$percentage_type][$homeworkCounter][concent_grade] = $row[concent_grade];
					$studentGradeList[$percentage_type][$homeworkCounter][rank] = $rank;
					
					//計算總成績
					$totalGrade += $studentGradeList[$percentage_type][$homeworkCounter][percentage] * $row[concent_grade] / 100;
					
					break;
				}
								
				$rowCounter++;
				$rank++;
			}
		}	

		
		//將資料庫沒有的資料填上0
		if( $studentGradeList[$percentage_type][$homeworkCounter][rank] == "")
		{			
			$studentGradeList[$percentage_type][$homeworkCounter][rank] = 0;
		}	
		if( $studentGradeList[$percentage_type][$homeworkCounter][concent_grade] == "")
		{
			$studentGradeList[$percentage_type][$homeworkCounter][concent_grade] = 0;
		}
		
		//做分數的轉換
		$sql = "SELECT 
					* 
				FROM 
					grade_convert A 
				WHERE 
					A.begin_course_cd = $begin_course_cd AND 
					A.grade_type_cd = '$percentage_type' AND 
					A.grade <= " . $studentGradeList[$percentage_type][$homeworkCounter][concent_grade] . " 
				ORDER BY 
					A.grade DESC
				";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		$resultNum = $res->numRows();	
		if($resultNum > 0)
		{
			$res->fetchInto($row, DB_FETCHMODE_ASSOC);
			
			$studentGradeList[$percentage_type][$homeworkCounter][concent_grade] = $row[grade_convert];
		}
	}


	//3.所有的點名成績
	//從Table homework搜尋這個學生這堂課的所有點名成績
	$percentage_type = 3;
	$sql = "SELECT
				A.number_id, 
				A.percentage, 
				A.percentage_num 
			FROM 
				course_percentage A, 
				roll_book B, 
				course_grade_report C 
			WHERE 
				A.begin_course_cd = $begin_course_cd AND 
				A.percentage_type = '" . $percentage_type . "' AND 
				A.begin_course_cd = B.begin_course_cd AND 
				A.percentage_num = B.roll_id AND 
				A.begin_course_cd = C.begin_course_cd AND 
				A.percentage_type = C.percentage_type AND 
				A.percentage_num = C.precentage_num AND 
				C.print = '1' 
			GROUP BY
				A.percentage_num 
			ORDER BY 
				A.percentage_num
			";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$resultNum = $res->numRows();	
	if($resultNum > 0)
	{
		$rowCounter = 0;
		
		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
		{	
			$studentGradeList[$percentage_type][$rowCounter] = 
					array(
							"number_id" => $row[number_id], 
							"percentage_num" => $row[percentage_num], 
							"concent_grade" => "", 
							"percentage" => $row[percentage], 
							"name" => "點名". $row[percentage_num], 
							"rank" => ""
							);
			$rowCounter++;
		}
		$rollCallNum = $rowCounter;
	}		
		
	//取得並計算學生每個成績排名
	for($rollCallCounter=0; $rollCallCounter<$rollCallNum; $rollCallCounter++)
	{
		$number_id = $studentGradeList[$percentage_type][$rollCallCounter][number_id];
	
		$sql = "SELECT 
					* 
				FROM 
					course_concent_grade A 
				WHERE 
					A.begin_course_cd = $begin_course_cd AND 
					A.number_id = $number_id
				ORDER BY
					A.concent_grade DESC
				";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		$resultNum = $res->numRows();	
		if($resultNum > 0)
		{
			$rowCounter = 0;
			$rank = 1;
			
			while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
			{	
				if($row[student_id] == $personal_id)
				{
					$studentGradeList[$percentage_type][$rollCallCounter][concent_grade] = $row[concent_grade];
					$studentGradeList[$percentage_type][$rollCallCounter][rank] = $rank;
					
					//計算總成績
					$totalGrade += $studentGradeList[$percentage_type][$rollCallCounter][percentage] * $row[concent_grade] / 100;
					
					break;
				}
								
				$rowCounter++;
				$rank++;
			}
		}	
		
		//將資料庫沒有的資料填上0
		if( $studentGradeList[$percentage_type][$rollCallCounter][rank] == "")
		{
			$studentGradeList[$percentage_type][$rollCallCounter][rank] = 0;
		}	
		if( $studentGradeList[$percentage_type][$rollCallCounter][concent_grade] == "")
		{
			$studentGradeList[$percentage_type][$rollCallCounter][concent_grade] = 0;
		}
		
		
		//做分數的轉換
		$sql = "SELECT 
					* 
				FROM 
					grade_convert A 
				WHERE 
					A.begin_course_cd = $begin_course_cd AND 
					A.grade_type_cd = '$percentage_type' AND 
					A.grade <= " . $studentGradeList[$percentage_type][$rollCallCounter][concent_grade] . " 
				ORDER BY 
					A.grade DESC
				";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		$resultNum = $res->numRows();	
		if($resultNum > 0)
		{
			$res->fetchInto($row, DB_FETCHMODE_ASSOC);
			
			$studentGradeList[$percentage_type][$rollCallCounter][concent_grade] = $row[grade_convert];
		}
	}

	//4.所有一般測驗成績
	//從Table course_percentage搜尋這堂課的所有一般測驗成績
	$percentage_type = 4;
	$sql = "SELECT
				A.number_id, 
				A.percentage, 
				A.percentage_num 
			FROM 
				course_percentage A, 
				course_grade_report C 
			WHERE 
				A.begin_course_cd = $begin_course_cd AND 
				A.percentage_type = '" . $percentage_type . "' AND 
				A.begin_course_cd = C.begin_course_cd AND 
				A.percentage_type = C.percentage_type AND 
				A.percentage_num = C.precentage_num AND 
				C.print = '1' 
			ORDER BY 
				A.percentage_num
			";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$resultNum = $res->numRows();	
	if($resultNum > 0)
	{
		$rowCounter = 0;
		
		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
		{	
			$studentGradeList[$percentage_type][$rowCounter] = 
					array(
							"number_id" => $row[number_id], 
							"percentage_num" => $row[percentage_num], 
							"concent_grade" => "", 
							"percentage" => $row[percentage], 
							"name" => "測驗". $row[percentage_num], 
							"rank" => ""
							);
			$rowCounter++;
		}
		$commTestNum = $rowCounter;
	}		
		
	//取得並計算學生每個成績排名
	for($commTestCounter=0; $commTestCounter<$commTestNum; $commTestCounter++)
	{
		$number_id = $studentGradeList[$percentage_type][$commTestCounter][number_id];
	
		$sql = "SELECT 
					* 
				FROM 
					course_concent_grade A 
				WHERE 
					A.begin_course_cd = $begin_course_cd AND 
					A.number_id = $number_id
				ORDER BY
					A.concent_grade DESC
				";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		$resultNum = $res->numRows();	
		if($resultNum > 0)
		{
			$rowCounter = 0;
			$rank = 1;
			
			while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
			{	
				if($row[student_id] == $personal_id)
				{
					$studentGradeList[$percentage_type][$commTestCounter][concent_grade] = $row[concent_grade];
					$studentGradeList[$percentage_type][$commTestCounter][rank] = $rank;
					
					//計算總成績
					$totalGrade += $studentGradeList[$percentage_type][$commTestCounter][percentage] * $row[concent_grade] / 100;
					
					break;
				}
								
				$rowCounter++;
				$rank++;
			}
		}	
		
		//將資料庫沒有的資料填上0
		if( $studentGradeList[$percentage_type][$commTestCounter][rank] == "")
		{
			$studentGradeList[$percentage_type][$commTestCounter][rank] = 0;
		}	
		if( $studentGradeList[$percentage_type][$commTestCounter][concent_grade] == "")
		{
			$studentGradeList[$percentage_type][$commTestCounter][concent_grade] = 0;
		}
		
		//做分數的轉換
		$sql = "SELECT 
					* 
				FROM 
					grade_convert A 
				WHERE 
					A.begin_course_cd = $begin_course_cd AND 
					A.grade_type_cd = '$percentage_type' AND 
					A.grade <= " . $studentGradeList[$percentage_type][$commTestCounter][concent_grade] . " 
				ORDER BY 
					A.grade DESC
				";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		$resultNum = $res->numRows();	
		if($resultNum > 0)
		{
			$res->fetchInto($row, DB_FETCHMODE_ASSOC);
			
			$studentGradeList[$percentage_type][$commTestCounter][concent_grade] = $row[grade_convert];
		}
	}

	//5.所有一般作業成績
	//從Table course_percentage搜尋這堂課的所一般作業成績
	$percentage_type = 5;
	$sql = "SELECT
				A.number_id, 
				A.percentage, 
				A.percentage_num 
			FROM 
				course_percentage A, 
				course_grade_report C 
			WHERE 
				A.begin_course_cd = $begin_course_cd AND 
				A.percentage_type = '" . $percentage_type . "' AND 
				A.begin_course_cd = C.begin_course_cd AND 
				A.percentage_type = C.percentage_type AND 
				A.percentage_num = C.precentage_num AND 
				C.print = '1' 
			ORDER BY 
				A.percentage_num
			";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$resultNum = $res->numRows();	
	if($resultNum > 0)
	{
		$rowCounter = 0;
		
		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
		{	
			$studentGradeList[$percentage_type][$rowCounter] = 
					array(
							"number_id" => $row[number_id], 
							"percentage_num" => $row[percentage_num], 
							"concent_grade" => "", 
							"percentage" => $row[percentage], 
							"name" => "作業". $row[percentage_num], 
							"rank" => ""
							);
			$rowCounter++;
		}
		$commHomeworkNum = $rowCounter;
	}		
		
	//取得並計算學生每個成績排名
	for($commHomeworkCounter=0; $commHomeworkCounter<$commHomeworkNum; $commHomeworkCounter++)
	{
		$number_id = $studentGradeList[$percentage_type][$commHomeworkCounter][number_id];
	
		$sql = "SELECT 
					* 
				FROM 
					course_concent_grade A 
				WHERE 
					A.begin_course_cd = $begin_course_cd AND 
					A.number_id = $number_id
				ORDER BY
					A.concent_grade DESC
				";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		$resultNum = $res->numRows();	
		if($resultNum > 0)
		{
			$rowCounter = 0;
			$rank = 1;
			
			while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
			{	
				if($row[student_id] == $personal_id)
				{
					$studentGradeList[$percentage_type][$commHomeworkCounter][concent_grade] = $row[concent_grade];
					$studentGradeList[$percentage_type][$commHomeworkCounter][rank] = $rank;
					
					//計算總成績
					$totalGrade += $studentGradeList[$percentage_type][$commHomeworkCounter][percentage] * $row[concent_grade] / 100;
					
					break;
				}
								
				$rowCounter++;
				$rank++;
			}
		}	
		
		//將資料庫沒有的資料填上0
		if( $studentGradeList[$percentage_type][$commHomeworkCounter][rank] == "")
		{
			$studentGradeList[$percentage_type][$commHomeworkCounter][rank] = 0;
		}	
		if( $studentGradeList[$percentage_type][$commHomeworkCounter][concent_grade] == "")
		{
			$studentGradeList[$percentage_type][$commHomeworkCounter][concent_grade] = 0;
		}
		
		//做分數的轉換
		$sql = "SELECT 
					* 
				FROM 
					grade_convert A 
				WHERE 
					A.begin_course_cd = $begin_course_cd AND 
					A.grade_type_cd = '$percentage_type' AND 
					A.grade <= " . $studentGradeList[$percentage_type][$commHomeworkCounter][concent_grade] . " 
				ORDER BY 
					A.grade DESC
				";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		$resultNum = $res->numRows();	
		if($resultNum > 0)
		{
			$res->fetchInto($row, DB_FETCHMODE_ASSOC);
			
			$studentGradeList[$percentage_type][$commHomeworkCounter][concent_grade] = $row[grade_convert];
		}
	}


	//9.所有其他成績
	//從Table course_percentage搜尋這堂課的所有其他成績
	$percentage_type = 9;
	$sql = "SELECT
				A.number_id, 
				A.percentage, 
				A.percentage_num 
			FROM 
				course_percentage A, 
				course_grade_report C 
			WHERE 
				A.begin_course_cd = $begin_course_cd AND 
				A.percentage_type = '" . $percentage_type . "' AND 
				A.begin_course_cd = C.begin_course_cd AND 
				A.percentage_type = C.percentage_type AND 
				A.percentage_num = C.precentage_num AND 
				C.print = '1' 
			ORDER BY 
				A.percentage_num
			";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$resultNum = $res->numRows();	
	if($resultNum > 0)
	{
		$rowCounter = 0;
		
		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
		{	
			$studentGradeList[$percentage_type][$rowCounter] = 
					array(
							"number_id" => $row[number_id], 
							"percentage_num" => $row[percentage_num], 
							"concent_grade" => "", 
							"percentage" => $row[percentage], 
							"name" => "其他". $row[percentage_num], 
							"rank" => ""
							);
			$rowCounter++;
		}
		$otherNum = $rowCounter;
	}		
		
	//取得並計算學生每個成績排名
	for($otherCounter=0; $otherCounter<$otherNum; $otherCounter++)
	{
		$number_id = $studentGradeList[$percentage_type][$otherCounter][number_id];
	
		$sql = "SELECT 
					* 
				FROM 
					course_concent_grade A 
				WHERE 
					A.begin_course_cd = $begin_course_cd AND 
					A.number_id = $number_id
				ORDER BY
					A.concent_grade DESC
				";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		$resultNum = $res->numRows();	
		if($resultNum > 0)
		{
			$rowCounter = 0;
			$rank = 1;
			
			while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
			{	
				if($row[student_id] == $personal_id)
				{
					$studentGradeList[$percentage_type][$otherCounter][concent_grade] = $row[concent_grade];
					$studentGradeList[$percentage_type][$otherCounter][rank] = $rank;
					
					//計算總成績
					$totalGrade += $studentGradeList[$percentage_type][$otherCounter][percentage] * $row[concent_grade] / 100;
					
					break;
				}
								
				$rowCounter++;
				$rank++;
			}
		}	
		
		//將資料庫沒有的資料填上0
		if( $studentGradeList[$percentage_type][$otherCounter][rank] == "")
		{
			$studentGradeList[$percentage_type][$otherCounter][rank] = 0;
		}	
		if( $studentGradeList[$percentage_type][$otherCounter][concent_grade] == "")
		{
			$studentGradeList[$percentage_type][$otherCounter][concent_grade] = 0;
		}
		
		//做分數的轉換
		$sql = "SELECT 
					* 
				FROM 
					grade_convert A 
				WHERE 
					A.begin_course_cd = $begin_course_cd AND 
					A.grade_type_cd = '$percentage_type' AND 
					A.grade <= " . $studentGradeList[$percentage_type][$otherCounter][concent_grade] . " 
				ORDER BY 
					A.grade DESC
				";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		$resultNum = $res->numRows();	
		if($resultNum > 0)
		{
			$res->fetchInto($row, DB_FETCHMODE_ASSOC);
			
			$studentGradeList[$percentage_type][$otherCounter][concent_grade] = $row[grade_convert];
		}
	}
	
	//計算總排名
	$sql = "SELECT 
				SUM(A.percentage * B.concent_grade / 100) grade 
			FROM 
				course_percentage A, 
				course_concent_grade B, 
				take_course C 
			WHERE 
				A.begin_course_cd = $begin_course_cd AND 
				A.begin_course_cd = B.begin_course_cd AND 
				A.number_id = B.number_id AND 
				B.begin_course_cd = C.begin_course_cd AND 
				B.student_id = C.personal_id 
			GROUP BY 
				B.student_id
			";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$resultNum = $res->numRows();	
	if($resultNum > 0)
	{
		$rowCounter = 0;
		$totalRank = 1;
		
		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
		{	
			//echo $row[grade] . "<br>";	//for test
			if($row[grade] > $totalGrade)
			{
				$totalRank++;
			}
		}
	}	

	
	//輸出總成績
	$percentage_type = 99;
	$sql = "SELECT 
				* 
			FROM 
				course_grade_report C 
			WHERE 
				C.begin_course_cd = $begin_course_cd AND 
				C.percentage_type = '" . $percentage_type . "' AND 
				C.precentage_num = 0 AND 
				C.print = 1 
			";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$resultNum = $res->numRows();	
	if($resultNum > 0)
	{
		
		//做分數的轉換
		$sql = "SELECT 
					* 
				FROM 
					grade_convert A 
				WHERE 
					A.begin_course_cd = $begin_course_cd AND 
					A.grade_type_cd = '$percentage_type' AND 
					A.grade <= " . $totalGrade . " 
				ORDER BY 
					A.grade DESC
				";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		$resultNum = $res->numRows();	
		if($resultNum > 0)
		{
			$res->fetchInto($row, DB_FETCHMODE_ASSOC);
			
			$totalGrade = $row[grade_convert];
		}
	}	


//以上程式跟showOneStudentGradeList.php相同
//*****************************************************************************
//*****************************************************************************
//*****************************************************************************
//*****************************************************************************
//*****************************************************************************
//*****************************************************************************

	
	
//產生PDF
//********************************************************************************
//********************************************************************************
//********************************************************************************
//********************************************************************************	
//********************************************************************************
	$pdf = new PDF_Chinese();
	$pdf->AddBig5Font();
	
	$tableWidthListCounter = 0;
	
	$oneStringWidth = 1.5;
	$cellHigh = 5;
	
	$pdf->AddPage();

	$pdf->SetFillColor(180, 180, 180); 
	$pdf->SetFont('Big5','',10);


	$word = "姓名:" . $studentName;
	$length = 120;
	$cellWidth = $oneStringWidth * $length;
	$pdf->Cell($cellWidth,$cellHigh,iconv("UTF-8","big5",$word),"TBLR",0,'C');	//TBL:Top, Buttom, Left
	
	$pdf->LN();	
	
	$word = "考試名稱";
	$length = 40;
	$cellWidth = $oneStringWidth * $length;
	$pdf->Cell($cellWidth,$cellHigh,iconv("UTF-8","big5",$word),"TBLR",0,'C');	//TBL:Top, Buttom, Left
	
	$word = "比例";
	$length = 26;
	$cellWidth = $oneStringWidth * $length;
	$pdf->Cell($cellWidth,$cellHigh,iconv("UTF-8","big5",$word),"TBLR",0,'C');	//TBL:Top, Buttom, Left
	
	$word = "分數";
	$length = 26;
	$cellWidth = $oneStringWidth * $length;
	$pdf->Cell($cellWidth,$cellHigh,iconv("UTF-8","big5",$word),"TBLR",0,'C');	//TBL:Top, Buttom, Left
	
	$word = "排名";
	$length = 28;
	$cellWidth = $oneStringWidth * $length;
	$pdf->Cell($cellWidth,$cellHigh,iconv("UTF-8","big5",$word),"TBLR",0,'C');	//TBL:Top, Buttom, Left		
	
	$pdf->LN();
	
	foreach($studentGradeList as $oneTypeOfGrade)
	{
		foreach($oneTypeOfGrade as $grade)
		{
			$word = $grade[name];
			$length = 40;
			$cellWidth = $oneStringWidth * $length;
			$pdf->Cell($cellWidth,$cellHigh,iconv("UTF-8","big5",$word),"TBLR",0,'C');	//TBL:Top, Buttom, Left
			
			$word = $grade[percentage] . "%";
			$length = 26;
			$cellWidth = $oneStringWidth * $length;
			$pdf->Cell($cellWidth,$cellHigh,iconv("UTF-8","big5",$word),"TBLR",0,'C');	//TBL:Top, Buttom, Left
			
			$word = $grade[concent_grade];
			$length = 26;
			$cellWidth = $oneStringWidth * $length;
			$pdf->Cell($cellWidth,$cellHigh,iconv("UTF-8","big5",$word),"TBLR",0,'C');	//TBL:Top, Buttom, Left
			
			$word = $grade[rank] . "/" . $studentNum;
			$length = 28;
			$cellWidth = $oneStringWidth * $length;
			$pdf->Cell($cellWidth,$cellHigh,iconv("UTF-8","big5",$word),"TBLR",0,'C');	//TBL:Top, Buttom, Left		
			
			$pdf->LN();	
		}
	}
	
	$word = "總成績";
	$length = 40;
	$cellWidth = $oneStringWidth * $length;
	$pdf->Cell($cellWidth,$cellHigh,iconv("UTF-8","big5",$word),"TBLR",0,'C');	//TBL:Top, Buttom, Left
	
	$word = $totalGrade;
	$length = 80;
	$cellWidth = $oneStringWidth * $length;
	$pdf->Cell($cellWidth,$cellHigh,iconv("UTF-8","big5",$word),"TBLR",0,'C');	//TBL:Top, Buttom, Left
	
	
	$pdf->LN();	
	
	$word = "總排名";
	$length = 40;
	$cellWidth = $oneStringWidth * $length;
	$pdf->Cell($cellWidth,$cellHigh,iconv("UTF-8","big5",$word),"TBLR",0,'C');	//TBL:Top, Buttom, Left
	
	$word = $totalRank . "/" . $studentNum;
	$length = 80;
	$cellWidth = $oneStringWidth * $length;
	$pdf->Cell($cellWidth,$cellHigh,iconv("UTF-8","big5",$word),"TBLR",0,'C');	//TBL:Top, Buttom, Left
	
	
	$pdf->Output();
?>
