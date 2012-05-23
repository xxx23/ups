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
	$absoluteURL = $HOMEURL . "Grade/";

	session_start();
	$personal_id = $_SESSION['personal_id'];			//取得個人編號
	$role_cd = $_SESSION['role_cd'];					//取得角色
	$begin_course_cd = $_SESSION['begin_course_cd'];	//取得課程代碼

	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("cssPath", $CSS_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);
	
	$tpl->assign("isBackOn", 1);						//是否允許回上一頁

	$incomingPage = $_POST["currentPage"];				//
	$tpl->assign("incomingPage", $incomingPage);	
	
	$grade_type_cd = $_POST["grade_type_cd"];			//成績類型
	$tpl->assign("grade_type_cd", $grade_type_cd);
	
	
	$tpl->assign("title", "成績轉換設定");


	//從Table grade_convert搜尋成績轉換設定
	$sql = "SELECT 
				 * 
			FROM 
				grade_convert A 
			WHERE 
				A.begin_course_cd = $begin_course_cd AND 
				A.grade_type_cd = '" . $grade_type_cd . "' 
			ORDER BY 
				A.number_id ASC
			";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$resultNum = $res->numRows();	
	
	if($resultNum == 0)
	{
		$levelNum = 0;
	}
	else if($resultNum > 0)
	{
		$levelNum = $resultNum;
		
		$rowCounter = 0;
		
		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
		{
			//設定分數下限
			$tpl->assign("lv" . ($rowCounter+1). "_bottom", $row[grade]);
			
			//設定分數上限
			if($rowCounter+2 <= $levelNum)
			{
				$tpl->assign("lv" . ($rowCounter+2). "_top", $row[grade]-1);
			}

			//設定轉換結果
			$tpl->assign("lv" . ($rowCounter+1). "_value", $row[grade_convert]);
			
			$rowCounter++;	
		}
		
		
	}	
	$tpl->assign("levelNum", $levelNum);
	
	switch($levelNum)
	{
	case 10:	$tpl->assign("isShowLv10", 1);
	case 9:		$tpl->assign("isShowLv9", 1);
	case 8:		$tpl->assign("isShowLv8", 1);
	case 7:		$tpl->assign("isShowLv7", 1);
	case 6:		$tpl->assign("isShowLv6", 1);
	case 5:		$tpl->assign("isShowLv5", 1);
	case 4:		$tpl->assign("isShowLv4", 1);
	case 3:		$tpl->assign("isShowLv3", 1);
	case 2:		$tpl->assign("isShowLv2", 1);
	case 1:		$tpl->assign("isShowLv1", 1);
	default:	break;	
	}
	

	//目前的頁面
	$tpl->assign("currentPage", "setupGradeConvert.php");
	
	assignTemplate($tpl, "/grade/gradeConvertInput.tpl");
?>
