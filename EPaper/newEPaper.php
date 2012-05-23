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

	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("cssPath", $CSS_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);
	
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
	$tpl->assign("startYear", TIME_year());
	$tpl->assign("startMonth", TIME_month());
	$tpl->assign("startDay", TIME_day());
	
	assignTemplate($tpl, "/epaper/newEPaper.tpl");
?>
