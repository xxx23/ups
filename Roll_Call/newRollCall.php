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

	//目前的Action
	$tpl->assign("action", "new");

	//網頁標題
	$tpl->assign("title", "新增點名");
	
	//所佔百分比
	$tpl->assign("percentage", 0);
	
	
	//年的範圍
	$yearScopeStart = $SYSTEM_BEGIN_YEAR;
	$yearScopeEnd = TIME_year() + 5;
	
	$yearScopeCounter = 0;
	for($counter = $yearScopeStart; $counter <= $yearScopeEnd; $counter++)
	{
		$yearScope[$yearScopeCounter++] = $counter;
	}
	$tpl->assign("yearScope", $yearScope);
	
	//點名日期
	$tpl->assign("year", TIME_year());
	$tpl->assign("month", TIME_month());
	$tpl->assign("day", TIME_day());
	
	
	//從Table take_course搜尋這堂課的所有學生
	$sql = "SELECT B.personal_id, B.personal_name  
					FROM 
						take_course A,
						personal_basic B 
					WHERE 
						A.begin_course_cd = $begin_course_cd AND 
						A.personal_id = B.personal_id 
					ORDER BY B.personal_id ASC";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$resultNum = $res->numRows();

	if($resultNum > 0)
	{
		$rowCounter = 0;
		
		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
		{	
			$studentList[$rowCounter] = 
					array(
							"counter" => $rowCounter+1, 
							"personal_id" => $row[personal_id], 
							"personal_name" => $row[personal_name], 
							"state" => 0
							);
			
			$rowCounter++;
		}
		$studentNum = $rowCounter;
		
		$tpl->assign("studentNum", $studentNum);
		$tpl->assign("studentList", $studentList);
	}
	
	assignTemplate($tpl, "/roll_call/rollCallInput.tpl");	
?>
