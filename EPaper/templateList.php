<?
/*
DATE:   2007/03/31
AUTHOR: 14_不太想玩
*/
	$RELEATED_PATH = "../";
	
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	$IMAGE_PATH = $RELEATED_PATH . $IMAGE_PATH;
	$CSS_PATH = $RELEATED_PATH . $CSS_PATH . $CSS_VERSION_PATH;
	$absoluteURL = $HOMEURL . "EPaper/";
	
	
	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("cssPath", $CSS_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);

	assignTemplate($tpl, "/epaper/templateList.tpl");
?>
