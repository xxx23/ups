<?
	$RELEATED_PATH = "../";

	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	$IMAGE_PATH = $RELEATED_PATH . $IMAGE_PATH;
	$absoluteURL = $HOMEURL . "Database/";


	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);
	

	//取得menu
	$menu = $_GET['menu'];	
	if( isset($menu) == false)	$menu = 0;
	
	switch($menu)
	{
	
	case 1:	$tpl->assign("content", "http://" . $DB_HOST . "/phpMyAdmin/");	break;
	case 2:	$tpl->assign("content", "databaseExportManagement.php");	break;
	case 3:	$tpl->assign("content", "databaseImportManagement.php");	break;
	default:$tpl->assign("content", "");	break;
	}


	//目前的頁面
	$tpl->assign("currentPage", "databaseManagement.php");
	
	assignTemplate($tpl, "/database/databaseManagement.tpl");
?>
