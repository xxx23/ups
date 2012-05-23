<?
/*
DATE:   2007/07/19
AUTHOR: 14_不太想玩
*/
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

	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("cssPath", $CSS_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);

	//設定預設預設會顯示所有成績
	setupGradeDefaultPrint($DB_CONN, $begin_course_cd);
	

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
			$gradeList[$percentage_type][$rowCounter] = 
					array(
							"id" => $row[id], 
							"no" => $row[no], 
							"name" => $row[name], 
							"percentage" => $row[percentage],
							"isPrint" => 0
							);
			
			$rowCounter++;
		}
		$onlineTestNum = $rowCounter;
		$tpl->assign("onlineTestNum", $onlineTestNum);
		
		for($onlineTestCounter=0; $onlineTestCounter<$onlineTestNum; $onlineTestCounter++)
		{
			$sql = "SELECT 
						* 
					FROM 
						course_grade_report A 
					WHERE 
						A.begin_course_cd = $begin_course_cd AND 
						A.percentage_type = '" . $percentage_type . "' AND 
						A.precentage_num = " . $gradeList[$percentage_type][$onlineTestCounter][no] . " AND 
						A.print = '1'
					";
			$res = $DB_CONN->query($sql);
			if (PEAR::isError($res))	die($res->getMessage());
			$resultNum = $res->numRows();	
			
			if($resultNum > 0)
			{
				$gradeList[$percentage_type][$onlineTestCounter][isPrint] = 1;
			}
		}
		
		$sql = "SELECT 
					* 
				FROM 
					course_grade_report A 
				WHERE 
					A.begin_course_cd = $begin_course_cd AND 
					A.percentage_type = '" . $percentage_type . "' AND 
					A.precentage_num = 0 AND 
					A.print = '1'
				";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		$resultNum = $res->numRows();	
		
		if($resultNum > 0)
		{
			$tpl->assign("isPrintTotoal_" . $percentage_type, 1);
		}
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
			$gradeList[$percentage_type][$rowCounter] = 
					array(
							"id" => $row[id], 
							"no" => $row[no], 
							"name" => $row[name], 
							"percentage" => $row[percentage],
							"isPrint" => 0
							);
			
			$rowCounter++;
		}
		$homeworkNum = $rowCounter;
		$tpl->assign("homeworkNum", $homeworkNum);
		
		
		for($homeworkCounter=0; $homeworkCounter<$homeworkNum; $homeworkCounter++)
		{
			$sql = "SELECT 
						* 
					FROM 
						course_grade_report A 
					WHERE 
						A.begin_course_cd = $begin_course_cd AND 
						A.percentage_type = '" . $percentage_type . "' AND 
						A.precentage_num = " . $gradeList[$percentage_type][$homeworkCounter][no] . " AND 
						A.print = '1'
					";
			$res = $DB_CONN->query($sql);
			if (PEAR::isError($res))	die($res->getMessage());
			$resultNum = $res->numRows();	
			
			if($resultNum > 0)
			{
				$gradeList[$percentage_type][$homeworkCounter][isPrint] = 1;
			}
		}
		
		$sql = "SELECT 
					* 
				FROM 
					course_grade_report A 
				WHERE 
					A.begin_course_cd = $begin_course_cd AND 
					A.percentage_type = '" . $percentage_type . "' AND 
					A.precentage_num = 0 AND 
					A.print = '1'
				";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		$resultNum = $res->numRows();	
		
		if($resultNum > 0)
		{
			$tpl->assign("isPrintTotoal_" . $percentage_type, 1);
		}
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
			$gradeList[$percentage_type][$rowCounter] = 
					array(
							"id" => $row[id], 
							"no" => $row[no], 
							"name" => "點名". $row[no], 
							"percentage" => $row[percentage],
							"isPrint" => 0
							);
			
			$rowCounter++;
		}
		$rollNum = $rowCounter;
		$tpl->assign("rollNum", $rollNum);
		
		for($rollCounter=0; $rollCounter<$rollNum; $rollCounter++)
		{
			$sql = "SELECT 
						* 
					FROM 
						course_grade_report A 
					WHERE 
						A.begin_course_cd = $begin_course_cd AND 
						A.percentage_type = '" . $percentage_type . "' AND 
						A.precentage_num = " . $gradeList[$percentage_type][$rollCounter][no] . " AND 
						A.print = '1'
					";
			$res = $DB_CONN->query($sql);
			if (PEAR::isError($res))	die($res->getMessage());
			$resultNum = $res->numRows();	
			
			if($resultNum > 0)
			{
				$gradeList[$percentage_type][$rollCounter][isPrint] = 1;
			}
		}
		
		$sql = "SELECT 
					* 
				FROM 
					course_grade_report A 
				WHERE 
					A.begin_course_cd = $begin_course_cd AND 
					A.percentage_type = '" . $percentage_type . "' AND 
					A.precentage_num = 0 AND 
					A.print = '1'
				";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		$resultNum = $res->numRows();	
		
		if($resultNum > 0)
		{
			$tpl->assign("isPrintTotoal_" . $percentage_type, 1);
		}
	}

	//4.所有一般測驗成績
	//從Table course_percentage搜尋這堂課的所有一般測驗成績
	$percentage_type = 4;
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
			$gradeList[$percentage_type][$rowCounter] = 
					array(
							"id" => $row[id], 
							"no" => $row[no], 
							"name" => "測驗". $row[no], 
							"percentage" => $row[percentage],
							"isPrint" => 0
							);
			
			$rowCounter++;
		}
		$commTestNum = $rowCounter;
		$tpl->assign("commTestNum", $commTestNum);
		
		for($commTestCounter=0; $commTestCounter<$commTestNum; $commTestCounter++)
		{
			$sql = "SELECT 
						* 
					FROM 
						course_grade_report A 
					WHERE 
						A.begin_course_cd = $begin_course_cd AND 
						A.percentage_type = '" . $percentage_type . "' AND 
						A.precentage_num = " . $gradeList[$percentage_type][$commTestCounter][no] . " AND 
						A.print = '1'
					";
			$res = $DB_CONN->query($sql);
			if (PEAR::isError($res))	die($res->getMessage());
			$resultNum = $res->numRows();	
			
			if($resultNum > 0)
			{
				$gradeList[$percentage_type][$commTestCounter][isPrint] = 1;
			}
		}
		
		$sql = "SELECT 
					* 
				FROM 
					course_grade_report A 
				WHERE 
					A.begin_course_cd = $begin_course_cd AND 
					A.percentage_type = '" . $percentage_type . "' AND 
					A.precentage_num = 0 AND 
					A.print = '1'
				";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		$resultNum = $res->numRows();	
		
		if($resultNum > 0)
		{
			$tpl->assign("isPrintTotoal_" . $percentage_type, 1);
		}
	}

	//5.所有一般作業成績
	//從Table course_percentage搜尋這堂課的所一般作業成績
	$percentage_type = 5;
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
			$gradeList[$percentage_type][$rowCounter] = 
					array(
							"id" => $row[id], 
							"no" => $row[no], 
							"name" => "作業". $row[no], 
							"percentage" => $row[percentage],
							"isPrint" => 0
							);
			
			$rowCounter++;
		}
		$commHomeworkNum = $rowCounter;
		$tpl->assign("commHomeworkNum", $commHomeworkNum);
		
		for($commHomeworkCounter=0; $commHomeworkCounter<$commHomeworkNum; $commHomeworkCounter++)
		{
			$sql = "SELECT 
						* 
					FROM 
						course_grade_report A 
					WHERE 
						A.begin_course_cd = $begin_course_cd AND 
						A.percentage_type = '" . $percentage_type . "' AND 
						A.precentage_num = " . $gradeList[$percentage_type][$commHomeworkCounter][no] . " AND 
						A.print = '1'
					";
			$res = $DB_CONN->query($sql);
			if (PEAR::isError($res))	die($res->getMessage());
			$resultNum = $res->numRows();	
			
			if($resultNum > 0)
			{
				$gradeList[$percentage_type][$commHomeworkCounter][isPrint] = 1;
			}
		}
		
		$sql = "SELECT 
					* 
				FROM 
					course_grade_report A 
				WHERE 
					A.begin_course_cd = $begin_course_cd AND 
					A.percentage_type = '" . $percentage_type . "' AND 
					A.precentage_num = 0 AND 
					A.print = '1'
				";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		$resultNum = $res->numRows();	
		
		if($resultNum > 0)
		{
			$tpl->assign("isPrintTotoal_" . $percentage_type, 1);
		}
	}

	//9.所有其他成績
	//從Table course_percentage搜尋這堂課的所有其他成績
	$percentage_type = 9;
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
			$gradeList[$percentage_type][$rowCounter] = 
					array(
							"id" => $row[id], 
							"no" => $row[no], 
							"name" => "其他" . $row[no], 
							"percentage" => $row[percentage],
							"isPrint" => 0
							);
			
			$rowCounter++;
		}
		$otherNum = $rowCounter;
		$tpl->assign("otherNum", $otherNum);
		
		for($otherCounter=0; $otherCounter<$otherNum; $otherCounter++)
		{
			$sql = "SELECT 
						* 
					FROM 
						course_grade_report A 
					WHERE 
						A.begin_course_cd = $begin_course_cd AND 
						A.percentage_type = '" . $percentage_type . "' AND 
						A.precentage_num = " . $gradeList[$percentage_type][$otherCounter][no] . " AND 
						A.print = '1'
					";
			$res = $DB_CONN->query($sql);
			if (PEAR::isError($res))	die($res->getMessage());
			$resultNum = $res->numRows();	
			
			if($resultNum > 0)
			{
				$gradeList[$percentage_type][$otherCounter][isPrint] = 1;
			}
		}
		
		$sql = "SELECT 
					* 
				FROM 
					course_grade_report A 
				WHERE 
					A.begin_course_cd = $begin_course_cd AND 
					A.percentage_type = '" . $percentage_type . "' AND 
					A.precentage_num = 0 AND 
					A.print = '1'
				";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		$resultNum = $res->numRows();	
		
		if($resultNum > 0)
		{
			$tpl->assign("isPrintTotoal_" . $percentage_type, 1);
		}
	}


	//全部總成績
	$percentage_type = 99;
	$sql = "SELECT 
					* 
				FROM 
					course_grade_report A 
				WHERE 
					A.begin_course_cd = $begin_course_cd AND 
					A.percentage_type = '" . $percentage_type . "' AND 
					A.precentage_num = 0 AND 
					A.print = '1'
				";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		$resultNum = $res->numRows();	
		
		if($resultNum > 0)
		{
			$tpl->assign("isPrintTotoal_" . $percentage_type, 1);
		}


	//輸出所有成績
	$tpl->assign("gradeList", $gradeList);

	//計算總共有幾個成績
	$totalGradeNum = $onlineTestNum + $homeworkNum + $rollNum + $commTestNum + $commHomeworkNum + $otherNum;
	$tpl->assign("totalGradeNum", $totalGradeNum);

	//目前的頁面
	$tpl->assign("currentPage", "setupCourseGradeReport.php");
	
	assignTemplate($tpl, "/grade/courseGradeReportInput.tpl");
?>
