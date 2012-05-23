<?
/*
DATE:   2007/04/06
AUTHOR: 14_不太想玩
*/
	$RELEATED_PATH = "../";
	
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	$IMAGE_PATH = $RELEATED_PATH . $IMAGE_PATH;
	$CSS_PATH = $RELEATED_PATH . $CSS_PATH;
	$absoluteURL = $HOMEURL . "EPaper/";

	session_start();
	$personal_id = $_SESSION['personal_id'];			//取得個人編號
	$role_cd = $_SESSION['role_cd'];					//取得角色
	

	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("cssPath", $CSS_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);
	
	$tpl->assign("behavior", $behavior);
	
	$tpl->assign("isDeleteOn", 1);	//是否允許刪除訂閱電子報
	
	//從Table e_paper, person_epaper, begin_course搜尋個人訂閱的課程電子報
	$sql = "SELECT A.begin_course_cd, C.begin_course_name 
					FROM 
						person_epaper A, 
						begin_course C 
					WHERE 
						A.personal_id = $personal_id AND 
						A.begin_course_cd = C.begin_course_cd 
					ORDER BY A.begin_course_cd DESC";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$resultNum = $res->numRows();
	
	if($resultNum > 0)
	{
		$rowCounter = 0;
		
		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
		{			
			$epaperList[$rowCounter] = 
					array(
							"counter" => $rowCounter, 
							"begin_course_cd" => $row[begin_course_cd], 
							"begin_course_name" => $row[begin_course_name]
							);
			
			$rowCounter++;
		}
		$epaperNum = $rowCounter;
		
		$tpl->assign("epaperNum", $epaperNum);
		$tpl->assign("epaperList", $epaperList);
	}

	assignTemplate($tpl, "/epaper/subscribeEPaperList.tpl");
?>
