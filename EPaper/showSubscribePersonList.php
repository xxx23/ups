<?
/*
DATE:   2007/03/31
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
	$begin_course_cd = $_SESSION['begin_course_cd'];	//取得課程代碼
	
	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("cssPath", $CSS_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);
	
	//從Table e_paper, person_epaper, personal_basic搜尋這堂課的訂閱成員名單
	$sql = "SELECT C.* 
					FROM 
						person_epaper B, 
						personal_basic C
					WHERE 
						B.begin_course_cd = $begin_course_cd AND 
						B.personal_id = C.personal_id 
					ORDER BY C.personal_id ASC";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$personNum = $res->numRows();
	
	if($personNum > 0)
	{
		$rowCounter = 0;
		
		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
		{			
			$personList[$rowCounter] = 
					array(
							"personal_id" => $row[personal_id],
							"personal_name" => $row[personal_name],
							"personal_home" => $row[personal_home], 
							"email" => $row[email]
							);
			$rowCounter++;
		}
		$tpl->assign("personNum", $rowCounter);
		$tpl->assign("personList", $personList);
	}
	
	assignTemplate($tpl, "/epaper/subscribePersonList.tpl");
?>
