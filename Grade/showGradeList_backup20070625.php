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
	
	$tpl->assign("isModifyOn", 0);	//是否允許修改公告
	$tpl->assign("isCountOn", 0);	//是否允許調整 是否計分
	

	//1.所有線上測驗成績
	//從Table test_course_setup搜尋這堂課的所有線上測驗成績
	$sql = "SELECT 
				A.test_no, 
				A.test_name, 
				A.percentage
			FROM 
				test_course_setup A
			WHERE 
				A.begin_course_cd = $begin_course_cd AND 
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
							);
			
			$rowCounter++;
		}
		$onlineTestNum = $rowCounter;
		$tpl->assign("onlineTestNum", $onlineTestNum);
		$tpl->assign("onlineTestList", $onlineTestList);
	}


	//2.所有的作業成績
	//從Table homework搜尋這堂課的所有作業成績
	$sql = "SELECT 
				A.homework_no, 
				A.homework_name, 
				A.percentage
			FROM 
				homework A
			WHERE 
				A.begin_course_cd = $begin_course_cd
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
							"percentage" => $row[percentage]
							);
			
			$rowCounter++;
		}
		$homeworkNum = $rowCounter;
		$tpl->assign("homeworkNum", $homeworkNum);
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
	
	//從Table roll_book搜尋這堂課的所有點名成績
	$sql = "SELECT 
				A.roll_id, 
				B.percentage 
			FROM 
				roll_book A, 
				course_grade B
			WHERE 
				A.begin_course_cd = $begin_course_cd AND 
				A.begin_course_cd = B.begin_course_cd AND 
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
							"percentage" => $row[percentage]
							);
			
			$rowCounter++;
		}
		$rollNum = $rowCounter;
		$tpl->assign("rollNum", $rollNum);
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
				B.percentage 
			FROM 
				course_grade B
			WHERE 
				B.begin_course_cd = $begin_course_cd AND 
				B.type = 2";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$resultNum = $res->numRows();
	if($resultNum > 0)
	{
		$rowCounter = 0;
		
		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
		{	
			$groupsStaffList[$rowCounter] = 
					array(
							"groupsStaff_name" => "合作學習", 
							"percentage" => $row[percentage]
							);
			
			$rowCounter++;
		}
		$groupsStaffNum = $rowCounter;
		$tpl->assign("groupsStaffNum", $groupsStaffNum);
		$tpl->assign("groupsStaffList", $groupsStaffList);
	}
	
	//目前的頁面
	$tpl->assign("currentPage", "showGradeList.php");
	
	$tpl->display("gradeList.tpl");
?>
