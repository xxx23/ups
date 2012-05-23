<?
/*
DATE:   2007/05/15
AUTHOR: 14_不太想玩
*/
	$RELEATED_PATH = "../";
	
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	$IMAGE_PATH = $IMAGE_PATH;
	$CSS_PATH = $RELEATED_PATH . $CSS_PATH;
	$absoluteURL = $HOMEURL . "Grade/";

	session_start();
	$personal_id = $_SESSION['personal_id'];			//取得個人編號
	$role_cd = $_SESSION['role_cd'];					//取得角色
	$begin_course_cd = $_SESSION['begin_course_cd'];	//取得課程代碼

	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("cssPath", $CSS_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);

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
	$tpl->assign("studentName", $studentName);

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
	$tpl->assign("studentNum", $studentNum);

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
//取得各項成績
	//1.所有線上測驗成績
	//從Table test_course_setup搜尋這個學生這堂課的所有線上測驗成績
	$sql = "SELECT 
				A.test_no, 
				A.test_name, 
				A.percentage, 
				SUM(B.grade) grade 
			FROM 
				test_course_setup A, 
				test_course_ans B
			WHERE 
				A.begin_course_cd = $begin_course_cd AND 
				A.begin_course_cd = B.begin_course_cd AND 
				A.test_no = B.test_no AND 
				B.personal_id = $personal_id AND 
				A.test_type = '2' 
			GROUP BY A.test_no 
			ORDER BY A.test_no ASC";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$resultNum = $res->numRows();	
	if($resultNum > 0)
	{
		$rowCounter = 0;
		
		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
		{	
			$onlineTestList[$rowCounter] = 
					array(
							"test_no" => $row[test_no], 
							"test_name" => $row[test_name], 
							"percentage" => $row[percentage], 
							"grade" => $row[grade], 
							"rank" => ""
							);
							
			//計算總成績
			$totalGrade += $row[percentage] * $row[grade] / 100;
			
			$rowCounter++;
		}
		$onlineTestNum = $rowCounter;
		$tpl->assign("onlineTestNum", $onlineTestNum);
		
		//計算學生每個線上測驗的排名
		for($onlineTestCounter=0; $onlineTestCounter<$onlineTestNum; $onlineTestCounter++)
		{
			$test_no = $onlineTestList[$onlineTestCounter][test_no];
			
			//從Table handin_homework搜尋作業的所有成績
			$sql = "SELECT 
						SUM(grade) grade 
					FROM 
						test_course_ans 
					WHERE 
						begin_course_cd = $begin_course_cd AND 
						test_no = $test_no 
					GROUP BY test_no 
					ORDER BY grade DESC";
			$res = $DB_CONN->query($sql);
			if (PEAR::isError($res))	die($res->getMessage());
			$resultNum = $res->numRows();	
			
			if($resultNum = 0)
			{
				$onlineTestList[$onlineTestCounter][rank] = 0;
			}
			else 
			{
				$isRankSeted = 0;
				$rank = 1;
				while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
				{	
					if($onlineTestList[$onlineTestCounter][grade] == $row[grade])
					{
						$isRankSeted =1;
						$onlineTestList[$onlineTestCounter][rank] = $rank;
						break;
					}
					
					$rank++;
				}
				if($$isRankSeted == 0)	$onlineTestList[$onlineTestCounter][rank] = $rank;
			}
		}
		
		
		$tpl->assign("onlineTestList", $onlineTestList);
	}



	//2.所有的作業成績
	//從Table homework搜尋這個學生這堂課的所有作業成績
	$sql = "SELECT 
				A.homework_no, 
				A.homework_name, 
				A.percentage, 
				B.grade
			FROM 
				homework A, 
				handin_homework B
			WHERE 
				A.begin_course_cd = $begin_course_cd AND 
				A.begin_course_cd = B.begin_course_cd AND 
				A.homework_no = B.homework_no AND 
				B.personal_id = $personal_id AND 
				B.public = '1' 
			ORDER BY A.homework_no ASC";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$resultNum = $res->numRows();	
	
	if($resultNum > 0)
	{
		$rowCounter = 0;
		
		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
		{	
			$homeworkList[$rowCounter] = 
					array(
							"homework_no" => $row[homework_no], 
							"homework_name" => $row[homework_name], 
							"percentage" => $row[percentage], 
							"grade" => $row[grade], 
							"rank" => ""
							);
			
			//計算總成績
			$totalGrade += $row[percentage] * $row[grade] / 100;
			
			$rowCounter++;
		}
		$homeworkNum = $rowCounter;
		$tpl->assign("homeworkNum", $homeworkNum);
		
		
		//計算學生每個作業的排名
		for($homeworkCounter=0; $homeworkCounter<$homeworkNum; $homeworkCounter++)
		{
			$homework_no = $homeworkList[$homeworkCounter][homework_no];
			
			//從Table handin_homework搜尋作業的所有成績
			$sql = "SELECT 
						grade 
					FROM 
						handin_homework 
					WHERE 
						begin_course_cd = $begin_course_cd AND 
						homework_no = $homework_no
					ORDER BY grade DESC";
			$res = $DB_CONN->query($sql);
			if (PEAR::isError($res))	die($res->getMessage());
			$resultNum = $res->numRows();	
			
			if($resultNum = 0)
			{
				$homeworkList[$homeworkCounter][rank] = 0;
			}
			else 
			{
				$isRankSeted = 0;
				$rank = 1;
				while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
				{	
					if($homeworkList[$homeworkCounter][grade] == $row[grade])
					{
						$isRankSeted =1;
						$homeworkList[$homeworkCounter][rank] = $rank;
						break;
					}
					
					$rank++;
				}
				if($$isRankSeted == 0)	$homeworkList[$homeworkCounter][rank] = $rank;
			}
		}
				
		$tpl->assign("homeworkList", $homeworkList);
	}
	
	//3.所有的點名成績
	//檢查是否有點名成績所佔百分比的資料
	$sql = "SELECT 
				* 
			FROM 
				course_grade B
			WHERE 
				B.begin_course_cd = $begin_course_cd AND 
				B.type = 1";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$resultNum = $res->numRows();
	if($resultNum == 0)
	{
		//新增資料到Table course_epaper
		$sql = "INSERT INTO course_grade 
							(
								begin_course_cd, 
								type, 
								percentage 
							) VALUES (
								$begin_course_cd, 
								1, 
								0 
							)";
		$sth = $DB_CONN->prepare($sql);
		$res = $DB_CONN->execute($sth);
		if (PEAR::isError($res))	die($res->getMessage());
	}
	
	//從Table roll_book搜尋這個學生這堂課的所有點名成績
	$sql = "SELECT 
				A.roll_id, 
				A.grade, 
				B.percentage 
			FROM 
				roll_book A, 
				course_grade B
			WHERE 
				A.begin_course_cd = $begin_course_cd AND 
				A.begin_course_cd = B.begin_course_cd AND 
				A.personal_id = $personal_id AND 
				B.type = 1 
			ORDER BY A.roll_id ASC";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$resultNum = $res->numRows();	
	
	if($resultNum > 0)
	{
		$rowCounter = 0;
		
		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
		{	
			$rollList[$rowCounter] = 
					array(
							"roll_id" => $row[roll_id],  
							"roll_name" => "第" . ($rowCounter+1) . "次點名", 
							"percentage" => $row[percentage], 
							"grade" => $row[grade], 
							"rank" => ""
							);
			
			//計算總成績
			$totalGrade += $row[percentage] * $row[grade] / 100;
			
			$rowCounter++;
		}
		$rollNum = $rowCounter;
		$tpl->assign("rollNum", $rollNum);
	
		//計算學生每個點名的排名
		for($rollCounter=0; $rollCounter<$rollNum; $rollCounter++)
		{
			$roll_id = $rollList[$rollCounter][roll_id];
			
			//從Table roll_book搜尋點名的所有成績
			$sql = "SELECT 
						grade 
					FROM 
						roll_book 
					WHERE 
						begin_course_cd = $begin_course_cd AND 
						roll_id = $roll_id 
					ORDER BY grade DESC";
			$res = $DB_CONN->query($sql);
			if (PEAR::isError($res))	die($res->getMessage());
			$resultNum = $res->numRows();	
			
			if($resultNum = 0)
			{
				$rollList[$rollCounter][rank] = 1;
			}
			else 
			{
				$isRankSeted = 0;
				$rank = 1;
				while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
				{	
					if($rollList[$rollCounter][grade] == $row[grade])
					{
						$isRankSeted = 1;
						$rollList[$rollCounter][rank] = $rank;
						break;
					}
					
					$rank++;
				}
				if($$isRankSeted == 0)	$rollList[$rollCounter][rank] = $rank;
			}
		}
				
		$tpl->assign("rollList", $rollList);
	}
	
	
	//4.所有的合作學習成績
	//檢查是否有合作學習成績所佔百分比的資料
	$sql = "SELECT 
				* 
			FROM 
				course_grade B
			WHERE 
				B.begin_course_cd = $begin_course_cd AND 
				B.type = 2";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$resultNum = $res->numRows();
	if($resultNum == 0)
	{
		//新增資料到Table course_epaper
		$sql = "INSERT INTO course_grade 
							(
								begin_course_cd, 
								type, 
								percentage 
							) VALUES (
								$begin_course_cd, 
								2, 
								0 
							)";
		$sth = $DB_CONN->prepare($sql);
		$res = $DB_CONN->execute($sth);
		if (PEAR::isError($res))	die($res->getMessage());
	}
	
	//從Table course_grade搜尋這個學生這堂課的所有合作學習成績
	$sql = "SELECT 
				A.grade, 
				B.percentage 
			FROM 
				groups_staff A, 
				course_grade B
			WHERE 
				A.begin_course_cd = $begin_course_cd AND 
				A.begin_course_cd = B.begin_course_cd AND 
				A.personal_id = $personal_id AND 
				B.type = 2";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$resultNum = $res->numRows();
	
	if($resultNum > 0)
	{
		$rowCounter = 0;
		
		$res->fetchInto($row, DB_FETCHMODE_ASSOC);
		
		$groupsStaffList[$rowCounter] = 
					array(
							"groupsStaff_Name" => "合作學習", 
							"percentage" => $row[percentage], 
							"grade" => $row[grade], 
							"rank" => ""
							);
			
		//計算總成績
		$totalGrade += $row[percentage] * $row[grade] / 100;
			
		$rowCounter++;

		$groupsStaffNum = $rowCounter;
		$tpl->assign("groupsStaffNum", $groupsStaffNum);
		
		
		$groupsStaffCounter = 0;
		//計算學生合作學習的排名			
		//從Table groups_staff搜尋合作學習的所有成績
			$sql = "SELECT 
						grade 
					FROM 
						groups_staff 
					WHERE 
						begin_course_cd = $begin_course_cd 
					ORDER BY grade DESC";
			$res = $DB_CONN->query($sql);
			if (PEAR::isError($res))	die($res->getMessage());
			$resultNum = $res->numRows();	
			
			if($resultNum = 0)
			{
				$groupsStaffList[$groupsStaffCounter][rank] = 1;
			}
			else 
			{
				$isRankSeted = 0;
				$rank = 1;
				while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
				{	
					if($groupsStaffList[$groupsStaffCounter][grade] == $row[grade])
					{
						$isRankSeted = 1;
						$groupsStaffList[$groupsStaffCounter][rank] = $rank;
						break;
					}
					
					$rank++;
				}
				if($$isRankSeted == 0)	$groupsStaffList[$groupsStaffCounter][rank] = $rank;
			}
				
		$tpl->assign("groupsStaffList", $groupsStaffList);
	}
	
/*************************************************************************************/
//計算總排名
	//1.所有線上測驗成績
	//從Table test_course_setup搜尋所有學生這堂課的所有線上測驗成績
	$sql = "SELECT 
				SUM(B.grade * A.percentage) grade, 
				B.personal_id 
			FROM 
				test_course_setup A, 
				test_course_ans B 
			WHERE 
				A.begin_course_cd = $begin_course_cd AND 
				A.begin_course_cd = B.begin_course_cd AND 
				A.test_no = B.test_no AND 
				A.test_type = '2' 
			GROUP BY B.personal_id 
			ORDER BY B.personal_id ASC";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$resultNum = $res->numRows();	
	
	if($resultNum > 0)
	{
		$studentListCounter = 0;
		$isError = 0;
		
		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
		{	
			$new_student_id = $row[personal_id];
			$new_grade = $row[grade]/100;
			
			while($studentList[$studentListCounter][personal_id] != $new_student_id)
			{
				$studentListCounter++;
				
				if($studentListCounter >= $studentNum)
				{	
					$isError = 1;
					break;
				}
			}
			if($isError == 1)	break;
			
			$studentList[$studentListCounter][totalGrade] += $new_grade;
		}
	}
	
	//2.所有的作業成績
	//從Table homework搜尋所有學生這堂課的所有作業成績
	$sql = "SELECT 
				SUM(B.grade * A.percentage) grade, 
				B.personal_id 
			FROM 
				homework A, 
				handin_homework B 
			WHERE 
				A.begin_course_cd = $begin_course_cd AND 
				A.begin_course_cd = B.begin_course_cd AND 
				A.homework_no = B.homework_no AND 
				B.public = '1' 
			GROUP BY B.personal_id 
			ORDER BY B.personal_id ASC";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$resultNum = $res->numRows();	
	if($resultNum > 0)
	{
		$studentListCounter = 0;
		$isError = 0;
		
		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
		{	
			$new_student_id = $row[personal_id];
			$new_grade = $row[grade]/100;
			
			while($studentList[$studentListCounter][personal_id] != $new_student_id)
			{
				$studentListCounter++;
				
				if($studentListCounter >= $studentNum)
				{	
					$isError = 1;
					break;
				}
			}
			if($isError == 1)	break;
			
			$studentList[$studentListCounter][totalGrade] += $new_grade;
		}
	}
	
	//3.所有的點名成績
	//從Table roll_book搜尋這個學生這堂課的所有點名成績
	$sql = "SELECT 
				SUM(A.grade * B.percentage) grade, 
				A.personal_id 
			FROM 
				roll_book A, 
				course_grade B
			WHERE 
				A.begin_course_cd = $begin_course_cd AND 
				A.begin_course_cd = B.begin_course_cd AND 
				B.type = 1 
			GROUP BY A.personal_id 
			ORDER BY A.personal_id ASC";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$resultNum = $res->numRows();	
	if($resultNum > 0)
	{
		$studentListCounter = 0;
		$isError = 0;
		
		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
		{	
			$new_student_id = $row[personal_id];
			$new_grade = $row[grade]/100;
			
			while($studentList[$studentListCounter][personal_id] != $new_student_id)
			{
				$studentListCounter++;
				
				if($studentListCounter >= $studentNum)
				{	
					$isError = 1;
					break;
				}
			}
			if($isError == 1)	break;
			
			$studentList[$studentListCounter][totalGrade] += $new_grade;
		}
	}
	
	//4.所有的合作學習成績
	$sql = "SELECT 
				SUM(A.grade * B.percentage) grade,  
				A.personal_id 
			FROM 
				groups_staff A, 
				course_grade B
			WHERE 
				A.begin_course_cd = $begin_course_cd AND 
				A.begin_course_cd = B.begin_course_cd AND 
				B.type = 2
			GROUP BY A.personal_id 
			ORDER BY A.personal_id ASC";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$resultNum = $res->numRows();
	if($resultNum > 0)
	{
		$studentListCounter = 0;
		$isError = 0;
		
		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
		{	
			$new_student_id = $row[personal_id];
			$new_grade = $row[grade]/100;
			
			while($studentList[$studentListCounter][personal_id] != $new_student_id)
			{
				$studentListCounter++;
				
				if($studentListCounter >= $studentNum)
				{	
					$isError = 1;
					break;
				}
			}
			if($isError == 1)	break;
			
			$studentList[$studentListCounter][totalGrade] += $new_grade;
		}
	}
	
	//計算學生的總分排名
	$totalRank = 1;
	for($studentListCounter=0; $studentListCounter<$studentNum; $studentListCounter++)
	{	
		//echo $studentList[$studentListCounter][totalGrade] . "<br>";	//for test
		
		if($totalGrade < $studentList[$studentListCounter][totalGrade])
		{
			$totalRank++;
		}
	}
	//輸出總排名
	$tpl->assign("totalRank", $totalRank);
	
	//輸出總成績
	$tpl->assign("totalGrade", $totalGrade);
	
	$tpl->display("studentGrade.tpl");
	

?>
