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
	
	$tpl->assign("isModifyOn", 1);	//是否允許修改
	$tpl->assign("isDeleteOn", 1);	//是否允許刪除
	

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
		$tpl->assign("onlineTestNum", $onlineTestNum);
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
		$tpl->assign("homeworkNum", $homeworkNum);
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
		$tpl->assign("rollNum", $rollNum);
	}

	//4.所有一般測驗成績
	//從Table course_percentage搜尋這堂課的所有一般測驗成績
	$percentage_type = 4;

	//從test_course_setup取得名稱
	$sql = "SELECT 
	  		* 
		FROM 
			test_course_setup 
		WHERE 
			begin_course_cd  = '$begin_course_cd' AND
			test_type = '$percentage_type' 
		ORDER BY test_no ASC";
        
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
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
							"name" => $names[$rowCounter] , 
							"percentage" => $row[percentage]
							);
			
			$rowCounter++;
		}
		$commTestNum = $rowCounter;
		$tpl->assign("commTestNum", $commTestNum);
	}

	//5.所有一般作業成績
	//從Table course_percentage搜尋這堂課的所一般作業成績
	$percentage_type = 5;


	//從test_course_setup取得名稱
	$sql = "SELECT 
	  		* 
		FROM 
			test_course_setup 
		WHERE 
			begin_course_cd  = '$begin_course_cd' AND
			test_type = '$percentage_type' 
		ORDER BY test_no ASC";
        
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
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
							"name" => $names[$rowCounter], 
							"percentage" => $row[percentage]
							);
			
			$rowCounter++;
		}
		$commHomeworkNum = $rowCounter;
		$tpl->assign("commHomeworkNum", $commHomeworkNum);
	}

	//9.所有其他成績
	//從Table course_percentage搜尋這堂課的所有其他成績
	$percentage_type = 9;


	//從test_course_setup取得名稱
	$sql = "SELECT 
	  		* 
		FROM 
			test_course_setup 
		WHERE 
			begin_course_cd  = '$begin_course_cd' AND
			test_type = '$percentage_type' 
		ORDER BY test_no ASC";
        
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
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
							"name" => $names[$rowCounter], 
							"percentage" => $row[percentage]
							);
			
			$rowCounter++;
		}
		$otherNum = $rowCounter;
		$tpl->assign("otherNum", $otherNum);
	}

	//輸出所有成績
	$tpl->assign("gradeList", $gradeList);

	//計算總共有幾個成績
	$totalGradeNum = $onlineTestNum + $homeworkNum + $rollNum + $commTestNum + $commHomeworkNum + $otherNum;
	$tpl->assign("totalGradeNum", $totalGradeNum);

	//目前的頁面
	$tpl->assign("currentPage", "showGradeList.php");
	
	assignTemplate($tpl, "/grade/gradeList.tpl");
?>
