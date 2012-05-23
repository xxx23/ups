<?
/*
DATE:   2007/06/29
AUTHOR: 14_不太想玩
*/
	$RELEATED_PATH = "../";
	
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	$IMAGE_PATH = $IMAGE_PATH;
	$CSS_PATH = $RELEATED_PATH . $CSS_PATH;
	$absoluteURL = $HOMEURL . "Roll_Call/";

	session_start();
	$personal_id = $_SESSION['personal_id'];			//取得個人編號
	$role_cd = $_SESSION['role_cd'];					//取得角色
	$begin_course_cd = $_SESSION['begin_course_cd'];	//取得課程代碼

	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("cssPath", $CSS_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);
	
	//3.所有的點名
	//從Table roll_book搜尋這堂課的所有點名
	$percentage_type = 3;
	$sql = "SELECT 
				A.roll_id, 
				A.roll_date, 
				B.percentage 
			FROM 
				roll_book A, 
				course_percentage B 
			WHERE 
				A.begin_course_cd = $begin_course_cd AND 
				A.begin_course_cd = B.begin_course_cd AND 
				B.percentage_type = '" . $percentage_type . "' AND 
				A.roll_id = B.percentage_num 
			GROUP BY 
				A.roll_id 
			ORDER BY 
				A.roll_id ASC
			";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$resultNum = $res->numRows();	
	
	if($resultNum > 0)
	{
		$rowCounter = 0;
		
		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
		{	
			$rollCallList[$rowCounter] = 
					array(
							"roll_id" => $row[roll_id], 
							"name" => "第" . $row[roll_id] . "次點名", 
							"percentage" => $row[percentage], 
							"roll_date" => substr($row[roll_date],0, 10) 
							);
			
			$rowCounter++;
		}
		
		$rollCallNum = $rowCounter;
		$tpl->assign("rollCallNum", $rollCallNum);
		$tpl->assign("rollCallList", $rollCallList);
	}

	
	
	//從Table take_course取得課程學生總數, 學生列表
	$sql = "SELECT 
				B.personal_id, 
				B.personal_name 
			FROM 
				take_course A, 
				personal_basic B 
			WHERE 
				A.begin_course_cd = $begin_course_cd AND 
				A.personal_id = B.personal_id 
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
			$studentList[$rowCounter][name] = $row[personal_name];
			$studentList[$rowCounter][student_id] = $row[personal_id];
			
			$rowCounter++;
		}
		$studentNum = $rowCounter;
		$tpl->assign("studentNum", $studentNum);
	}
	
	
	//取得所有學生每次點名的情況	
	if($rollCallNum > 0)
	{
		$sql = "SELECT 
					* 
				FROM 
					roll_book A 
				WHERE 
					A.begin_course_cd = $begin_course_cd 
				ORDER BY 
					A.roll_id ASC, 
					A.personal_id ASC
				";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		$resultNum = $res->numRows();	
		
		if($resultNum > 0)
		{
			$rollCallListCounter = 0;
			$studentListCounter = 0;
			$isError = 0;
			
			while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
			{	
				
				$new_roll_id = $row[roll_id];
				$new_state = $row[state];
				$new_student_id = $row[personal_id];
				
				//for test
				//echo "new_state:" . $new_state . "<br>";
				//echo "new_student_id:" . $new_student_id . "<br>";
				//echo "<br>";
	
	
				//判斷是哪一個成績
				while($rollCallList[$rollCallListCounter][roll_id] != $new_roll_id)
				{
					$studentListCounter = 0;
					
					$rollCallListCounter++;
					
					if($rollCallListCounter > $rollCallNum)
					{
						$isError = 1;
						break;
					}
				}
				if($isError == 1)	break;			
			
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
				if($isError == 1)	break;
				
				//將資料放入輸出
				$studentRollCallList[$studentListCounter][$rollCallListCounter] = $new_state;
			}
		}		
	}
	
	//將資料庫沒有的資料填上-1
	for($studentListCounter=0; $studentListCounter<$studentNum; $studentListCounter++)
	{
		for($rollCallListCounter=0; $rollCallListCounter<$rollCallNum; $rollCallListCounter++)
		{			
			if( $studentRollCallList[$studentListCounter][$rollCallListCounter] == NULL)
			{
				$studentRollCallList[$studentListCounter][$rollCallListCounter] = -1;
			}
		}
	}
	
	//輸出
	$tpl->assign("studentList", $studentList);
	$tpl->assign("studentRollCallList", $studentRollCallList);
	
	assignTemplate($tpl, "/roll_call/studentRollCallList.tpl");	
?>
