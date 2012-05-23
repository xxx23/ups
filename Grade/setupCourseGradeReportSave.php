<?
/*
DATE:   2007/07/14
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
	
	
	$grade_type_cd = $_POST["grade_type_cd"];			//取得成績類型
	
	$levelNum = $_POST["levelNum"];						//取得成績階級數
	
	//從Table course_grade_report先刪除掉原本的設定
	$sql = "DELETE 
			FROM 
				course_grade_report 
			WHERE 
				begin_course_cd=$begin_course_cd
			";
	$sth = $DB_CONN->prepare($sql);	
	$res = $DB_CONN->execute($sth);
	if (PEAR::isError($res))	die($res->getMessage());
	
	$number_id = 1;
	
	
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
							"percentage" => $row[percentage]
							);
			
			$rowCounter++;
		}
		$onlineTestNum = $rowCounter;

		for($onlineTestCounter=0; $onlineTestCounter<$onlineTestNum; $onlineTestCounter++)
		{
			$nameTmp = "isPrint_" . $gradeList[$percentage_type][$onlineTestCounter][id];
			$isPrint = $_POST[$nameTmp];
			
			if($isPrint == true)	$print = '1';
			else					$print = '0';
			
			$sql = "INSERT INTO course_grade_report 
							( 
								begin_course_cd, 
								number_id, 
								percentage_type, 
								precentage_num, 
								print 
							) VALUES ( 
								$begin_course_cd, 
								$number_id, 
								'$percentage_type', 
								" . $gradeList[$percentage_type][$onlineTestCounter][no] . ", 
								'$print'
							)";
			$sth = $DB_CONN->prepare($sql);
			$res = $DB_CONN->execute($sth);
			if (PEAR::isError($res))	die($res->getMessage());			
			
			$number_id++;
		}
		
		
		$nameTmp = "isPrintTotoal_" . $percentage_type;
		$isPrint = $_POST[$nameTmp];
		
		if($isPrint == true)	$print = '1';
		else					$print = '0';
		
		$sql = "INSERT INTO course_grade_report 
						( 
							begin_course_cd, 
							number_id, 
							percentage_type, 
							precentage_num, 
							print 
						) VALUES ( 
							$begin_course_cd, 
							$number_id, 
							'$percentage_type', 
							0, 
							'$print'
						)";
		$sth = $DB_CONN->prepare($sql);
		$res = $DB_CONN->execute($sth);
		if (PEAR::isError($res))	die($res->getMessage());
		
		$number_id++;
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
							"percentage" => $row[percentage]
							);
			
			$rowCounter++;
		}
		$homeworkNum = $rowCounter;

		for($homeworkCounter=0; $homeworkCounter<$homeworkNum; $homeworkCounter++)
		{
			$nameTmp = "isPrint_" . $gradeList[$percentage_type][$homeworkCounter][id];
			$isPrint = $_POST[$nameTmp];
			
			if($isPrint == true)	$print = '1';
			else					$print = '0';
			
			$sql = "INSERT INTO course_grade_report 
							( 
								begin_course_cd, 
								number_id, 
								percentage_type, 
								precentage_num, 
								print 
							) VALUES ( 
								$begin_course_cd, 
								$number_id, 
								'$percentage_type', 
								" . $gradeList[$percentage_type][$homeworkCounter][no] . ", 
								'$print'
							)";
			$sth = $DB_CONN->prepare($sql);
			$res = $DB_CONN->execute($sth);
			if (PEAR::isError($res))	die($res->getMessage());			
			
			$number_id++;
		}
		
		
		$nameTmp = "isPrintTotoal_" . $percentage_type;
		$isPrint = $_POST[$nameTmp];
		
		if($isPrint == true)	$print = '1';
		else					$print = '0';
		
		$sql = "INSERT INTO course_grade_report 
						( 
							begin_course_cd, 
							number_id, 
							percentage_type, 
							precentage_num, 
							print 
						) VALUES ( 
							$begin_course_cd, 
							$number_id, 
							'$percentage_type', 
							0, 
							'$print'
						)";
		$sth = $DB_CONN->prepare($sql);
		$res = $DB_CONN->execute($sth);
		if (PEAR::isError($res))	die($res->getMessage());
		
		$number_id++;
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
							"percentage" => $row[percentage]
							);
			
			$rowCounter++;
		}
		$rollNum = $rowCounter;

		for($rollCounter=0; $rollCounter<$rollNum; $rollCounter++)
		{
			$nameTmp = "isPrint_" . $gradeList[$percentage_type][$rollCounter][id];
			$isPrint = $_POST[$nameTmp];
			
			if($isPrint == true)	$print = '1';
			else					$print = '0';
			
			$sql = "INSERT INTO course_grade_report 
							( 
								begin_course_cd, 
								number_id, 
								percentage_type, 
								precentage_num, 
								print 
							) VALUES ( 
								$begin_course_cd, 
								$number_id, 
								'$percentage_type', 
								" . $gradeList[$percentage_type][$rollCounter][no] . ", 
								'$print'
							)";
			$sth = $DB_CONN->prepare($sql);
			$res = $DB_CONN->execute($sth);
			if (PEAR::isError($res))	die($res->getMessage());			
			
			$number_id++;
		}
		
		
		$nameTmp = "isPrintTotoal_" . $percentage_type;
		$isPrint = $_POST[$nameTmp];
		
		if($isPrint == true)	$print = '1';
		else					$print = '0';
		
		$sql = "INSERT INTO course_grade_report 
						( 
							begin_course_cd, 
							number_id, 
							percentage_type, 
							precentage_num, 
							print 
						) VALUES ( 
							$begin_course_cd, 
							$number_id, 
							'$percentage_type', 
							0, 
							'$print'
						)";
		$sth = $DB_CONN->prepare($sql);
		$res = $DB_CONN->execute($sth);
		if (PEAR::isError($res))	die($res->getMessage());
		
		$number_id++;
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
							"percentage" => $row[percentage]
							);
			
			$rowCounter++;
		}
		$commTestNum = $rowCounter;

		for($commTestCounter=0; $commTestCounter<$commTestNum; $commTestCounter++)
		{
			$nameTmp = "isPrint_" . $gradeList[$percentage_type][$commTestCounter][id];
			$isPrint = $_POST[$nameTmp];
			
			if($isPrint == true)	$print = '1';
			else					$print = '0';
			
			$sql = "INSERT INTO course_grade_report 
							( 
								begin_course_cd, 
								number_id, 
								percentage_type, 
								precentage_num, 
								print 
							) VALUES ( 
								$begin_course_cd, 
								$number_id, 
								'$percentage_type', 
								" . $gradeList[$percentage_type][$commTestCounter][no] . ", 
								'$print'
							)";
			$sth = $DB_CONN->prepare($sql);
			$res = $DB_CONN->execute($sth);
			if (PEAR::isError($res))	die($res->getMessage());			
			
			$number_id++;
		}
		
		
		$nameTmp = "isPrintTotoal_" . $percentage_type;
		$isPrint = $_POST[$nameTmp];
		
		if($isPrint == true)	$print = '1';
		else					$print = '0';
		
		$sql = "INSERT INTO course_grade_report 
						( 
							begin_course_cd, 
							number_id, 
							percentage_type, 
							precentage_num, 
							print 
						) VALUES ( 
							$begin_course_cd, 
							$number_id, 
							'$percentage_type', 
							0, 
							'$print'
						)";
		$sth = $DB_CONN->prepare($sql);
		$res = $DB_CONN->execute($sth);
		if (PEAR::isError($res))	die($res->getMessage());
		
		$number_id++;
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
							"percentage" => $row[percentage]
							);
			
			$rowCounter++;
		}
		$commHomeworkNum = $rowCounter;

		for($commHomeworkCounter=0; $commHomeworkCounter<$commHomeworkNum; $commHomeworkCounter++)
		{
			$nameTmp = "isPrint_" . $gradeList[$percentage_type][$commHomeworkCounter][id];
			$isPrint = $_POST[$nameTmp];
			
			if($isPrint == true)	$print = '1';
			else					$print = '0';
			
			$sql = "INSERT INTO course_grade_report 
							( 
								begin_course_cd, 
								number_id, 
								percentage_type, 
								precentage_num, 
								print 
							) VALUES ( 
								$begin_course_cd, 
								$number_id, 
								'$percentage_type', 
								" . $gradeList[$percentage_type][$commHomeworkCounter][no] . ", 
								'$print'
							)";
			$sth = $DB_CONN->prepare($sql);
			$res = $DB_CONN->execute($sth);
			if (PEAR::isError($res))	die($res->getMessage());			
			
			$number_id++;
		}
		
		
		$nameTmp = "isPrintTotoal_" . $percentage_type;
		$isPrint = $_POST[$nameTmp];
		
		if($isPrint == true)	$print = '1';
		else					$print = '0';
		
		$sql = "INSERT INTO course_grade_report 
						( 
							begin_course_cd, 
							number_id, 
							percentage_type, 
							precentage_num, 
							print 
						) VALUES ( 
							$begin_course_cd, 
							$number_id, 
							'$percentage_type', 
							0, 
							'$print'
						)";
		$sth = $DB_CONN->prepare($sql);
		$res = $DB_CONN->execute($sth);
		if (PEAR::isError($res))	die($res->getMessage());
		
		$number_id++;
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
							"percentage" => $row[percentage]
							);
			
			$rowCounter++;
		}
		$otherNum = $rowCounter;

		for($otherCounter=0; $otherCounter<$otherNum; $otherCounter++)
		{
			$nameTmp = "isPrint_" . $gradeList[$percentage_type][$otherCounter][id];
			$isPrint = $_POST[$nameTmp];
			
			if($isPrint == true)	$print = '1';
			else					$print = '0';
			
			$sql = "INSERT INTO course_grade_report 
							( 
								begin_course_cd, 
								number_id, 
								percentage_type, 
								precentage_num, 
								print 
							) VALUES ( 
								$begin_course_cd, 
								$number_id, 
								'$percentage_type', 
								" . $gradeList[$percentage_type][$otherCounter][no] . ", 
								'$print'
							)";
			$sth = $DB_CONN->prepare($sql);
			$res = $DB_CONN->execute($sth);
			if (PEAR::isError($res))	die($res->getMessage());			
			
			$number_id++;
		}
		
		
		$nameTmp = "isPrintTotoal_" . $percentage_type;
		$isPrint = $_POST[$nameTmp];
		
		if($isPrint == true)	$print = '1';
		else					$print = '0';
		
		$sql = "INSERT INTO course_grade_report 
						( 
							begin_course_cd, 
							number_id, 
							percentage_type, 
							precentage_num, 
							print 
						) VALUES ( 
							$begin_course_cd, 
							$number_id, 
							'$percentage_type', 
							0, 
							'$print'
						)";
		$sth = $DB_CONN->prepare($sql);
		$res = $DB_CONN->execute($sth);
		if (PEAR::isError($res))	die($res->getMessage());
		
		$number_id++;
	}

	//全部總成績
	$percentage_type = 99;
	$nameTmp = "isPrintTotoal_" . $percentage_type;
	$isPrint = $_POST[$nameTmp];
	
	if($isPrint == true)	$print = '1';
	else					$print = '0';
	
	$sql = "INSERT INTO course_grade_report 
					( 
						begin_course_cd, 
						number_id, 
						percentage_type, 
						precentage_num, 
						print 
					) VALUES ( 
						$begin_course_cd, 
						$number_id, 
						'$percentage_type', 
						0, 
						'$print'
					)";
	$sth = $DB_CONN->prepare($sql);
	$res = $DB_CONN->execute($sth);
	if (PEAR::isError($res))	die($res->getMessage());
	
	$number_id++;
	
	
	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("cssPath", $CSS_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);


	$title = "成績單設定";
	$content = "設定成功";	
	$content = $content . "<br><a href='setupCourseGradeReport.php'>返回 成績單設定</a>";

	$tpl->assign("title", $title);
	$tpl->assign("content", $content);
	
	assignTemplate($tpl, "/grade/message.tpl");
?>
