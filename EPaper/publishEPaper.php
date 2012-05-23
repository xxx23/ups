<?
/*
DATE:   2007/04/27
AUTHOR: 14_不太想玩
*/
	$RELEATED_PATH = "../";
	
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	$IMAGE_PATH = $RELEATED_PATH . $IMAGE_PATH;
	$CSS_PATH = $RELEATED_PATH . $CSS_PATH;
	$absoluteURL = $HOMEURL . "EPaper/";
	
	$behavior = $_POST['behavior'];
	
	$incomingPage = $_POST['currentPage'];

	session_start();
	$personal_id = $_SESSION['personal_id'];			//取得個人編號
	$role_cd = $_SESSION['role_cd'];					//取得角色
	$begin_course_cd = $_SESSION['begin_course_cd'];	//取得課程代碼
	
	$epaper_cd = $_POST['epaper_cd'];				//取得電子報編號
	
	if($role_cd == 0)//系統管理者
	{
		$begin_course_cd = -1;
	}

	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("cssPath", $CSS_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);
	
	$tpl->assign("behavior", $behavior);
	$tpl->assign("incomingPage", $incomingPage);
	
	$tpl->assign("epaper_cd", $epaper_cd);
	
	//從Table e_paper取得這個電子報
	$sql = "SELECT * FROM e_paper 
					WHERE 
						epaper_cd=$epaper_cd 
					";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$res->fetchInto($row, DB_FETCHMODE_ASSOC);
	
	$if_auto = $row[if_auto];
	$tpl->assign("if_auto", $if_auto);
	
	$startYear = substr($row[d_public_day], 0, 4);
	$startMonth = substr($row[d_public_day], 5, 2);
	$startDay = substr($row[d_public_day], 8, 2);
	
	//年的範圍
	$yearScopeStart = TIME_year();
	$yearScopeEnd = TIME_year() + 5;
	
	$yearScopeCounter = 0;
	for($counter = $yearScopeStart; $counter <= $yearScopeEnd; $counter++)
	{
		$yearScope[$yearScopeCounter++] = $counter;
	}
	$tpl->assign("yearScope", $yearScope);

	//開始日期
	if($if_auto == 'Y')
	{
		$tpl->assign("startYear", $startYear);
		$tpl->assign("startMonth", $startMonth);
		$tpl->assign("startDay", $startDay);
	}
	else
	{
		$tpl->assign("startYear", TIME_year());
		$tpl->assign("startMonth", TIME_month());
		$tpl->assign("startDay", TIME_day());
	}
	
	assignTemplate($tpl, "/epaper/publishEPaper.tpl");
?>
