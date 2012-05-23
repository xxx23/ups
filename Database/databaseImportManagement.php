<?
	$RELEATED_PATH = "../";

	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	$IMAGE_PATH = $RELEATED_PATH . $IMAGE_PATH;
	$absoluteURL = $HOMEURL . "Database/";


	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);
	
	//目前的頁面
	$tpl->assign("currentPage", "databaseImportManagement.php");
	
	assignTemplate($tpl, "/database/databaseImportManagement.tpl");
?>
