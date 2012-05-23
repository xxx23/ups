<?

	function setupGradeDefaultPrint($DB_CONN, $begin_course_cd)
	{	
	
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
								"percentage_type" => $percentage_type, 
								"id" => $row[id], 
								"no" => $row[no], 
								"name" => $row[name], 
								"percentage" => $row[percentage],
								"isPrint" => 1
								);
				
				$rowCounter++;
			}
			$onlineTestNum = $rowCounter;			
						
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
							A.print = '0'
						";
				$res = $DB_CONN->query($sql);
				if (PEAR::isError($res))	die($res->getMessage());
				$resultNum = $res->numRows();	
				
				if($resultNum > 0)
				{
					$gradeList[$percentage_type][$onlineTestCounter][isPrint] = 0;
				}
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
								"percentage_type" => $percentage_type, 
								"id" => $row[id], 
								"no" => $row[no], 
								"name" => $row[name], 
								"percentage" => $row[percentage],
								"isPrint" => 1
								);
				
				$rowCounter++;
			}
			$homeworkNum = $rowCounter;			
			
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
							A.print = '0'
						";
				$res = $DB_CONN->query($sql);
				if (PEAR::isError($res))	die($res->getMessage());
				$resultNum = $res->numRows();	
				
				if($resultNum > 0)
				{
					$gradeList[$percentage_type][$homeworkCounter][isPrint] = 0;
				}
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
								"percentage_type" => $percentage_type, 
								"id" => $row[id], 
								"no" => $row[no], 
								"name" => "點名". $row[no], 
								"percentage" => $row[percentage],
								"isPrint" => 1
								);
				
				$rowCounter++;
			}
			$rollNum = $rowCounter;
			
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
							A.print = '0'
						";
				$res = $DB_CONN->query($sql);
				if (PEAR::isError($res))	die($res->getMessage());
				$resultNum = $res->numRows();	
				
				if($resultNum > 0)
				{
					$gradeList[$percentage_type][$rollCounter][isPrint] = 0;
				}
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
								"percentage_type" => $percentage_type, 
								"id" => $row[id], 
								"no" => $row[no], 
								"name" => "測驗". $row[no], 
								"percentage" => $row[percentage],
								"isPrint" => 1
								);
				
				$rowCounter++;
			}
			$commTestNum = $rowCounter;
			
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
							A.print = '0'
						";
				$res = $DB_CONN->query($sql);
				if (PEAR::isError($res))	die($res->getMessage());
				$resultNum = $res->numRows();	
				
				if($resultNum > 0)
				{
					$gradeList[$percentage_type][$commTestCounter][isPrint] = 0;
				}
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
								"percentage_type" => $percentage_type, 
								"id" => $row[id], 
								"no" => $row[no], 
								"name" => "作業". $row[no], 
								"percentage" => $row[percentage],
								"isPrint" => 1
								);
				
				$rowCounter++;
			}
			$commHomeworkNum = $rowCounter;
			
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
							A.print = '0'
						";
				$res = $DB_CONN->query($sql);
				if (PEAR::isError($res))	die($res->getMessage());
				$resultNum = $res->numRows();	
				
				if($resultNum > 0)
				{
					$gradeList[$percentage_type][$commHomeworkCounter][isPrint] = 0;
				}
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
								"percentage_type" => $percentage_type, 
								"id" => $row[id], 
								"no" => $row[no], 
								"name" => "其他" . $row[no], 
								"percentage" => $row[percentage],
								"isPrint" => 1
								);
				
				$rowCounter++;
			}
			$otherNum = $rowCounter;
			
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
							A.print = '0'
						";
				$res = $DB_CONN->query($sql);
				if (PEAR::isError($res))	die($res->getMessage());
				$resultNum = $res->numRows();	
				
				if($resultNum > 0)
				{
					$gradeList[$percentage_type][$otherCounter][isPrint] = 0;
				}
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
					A.print = '0'
				";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		$resultNum = $res->numRows();	
		
		if($resultNum == 0)
		{
			$gradeList[$percentage_type][0][percentage_type] = $percentage_type;
			$gradeList[$percentage_type][0][no] = 0;
			$gradeList[$percentage_type][0][isPrint] = 1;	
		}
		elseif($resultNum > 0)
		{
			$gradeList[$percentage_type][0][percentage_type] = $percentage_type;
			$gradeList[$percentage_type][0][no] = 0;
			$gradeList[$percentage_type][0][isPrint] = 0;
		}
		
		
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
		
		

		//將設存回資料庫
		$number_id = 1;
		foreach($gradeList as $gradeType)
		{
			foreach($gradeType as $grade)
			{
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
									'$grade[percentage_type]', 
									$grade[no], 
									'$grade[isPrint]'
								)";
				$sth = $DB_CONN->prepare($sql);
				$res = $DB_CONN->execute($sth);
				if (PEAR::isError($res))	die($res->getMessage());			
				
				$number_id++;
			
			}
		}
	}

?>
