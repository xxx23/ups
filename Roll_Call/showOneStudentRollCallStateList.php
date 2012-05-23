<?
/*
DATE:   2007/07/12
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
			$studentRollCallList[$rowCounter] = 
					array(
							"roll_id" => $row[roll_id], 
							"name" => "第" . $row[roll_id] . "次點名", 
							"percentage" => $row[percentage], 
							"roll_date" => substr($row[roll_date],0, 10),
							"state"  => -1
							);
			
			$rowCounter++;
		}
		
		$rollCallNum = $rowCounter;
		$tpl->assign("rollCallNum", $rollCallNum);
		
		
		//取得學生各次點名的狀況
		for($rollCallCounter=0; $rollCallCounter<$rollCallNum; $rollCallCounter++)
		{
			$sql = "SELECT 
						A.state 
					FROM 
						roll_book A 
					WHERE 
						A.begin_course_cd = $begin_course_cd AND 
						A.roll_id = " . $studentRollCallList[$rollCallCounter][roll_id] . " AND 
						A.personal_id = $personal_id
					";
			$res = $DB_CONN->query($sql);
			if (PEAR::isError($res))	die($res->getMessage());
			$resultNum = $res->numRows();	
			
			if($resultNum > 0)
			{
				$res->fetchInto($row, DB_FETCHMODE_ASSOC);
				
				$studentRollCallList[$rollCallCounter][state] = $row[state];
			}
		}
	}

	//輸出所有點名狀況
	$tpl->assign("studentRollCallList", $studentRollCallList);

	//目前的頁面
	$tpl->assign("currentPage", "showOneStudentRollCallStateList.php");
	
	assignTemplate($tpl, "/roll_call/oneStudentRollCallList.tpl");	
?>
