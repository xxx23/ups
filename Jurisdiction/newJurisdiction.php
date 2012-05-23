<?
	$RELEATED_PATH = "../";

	require_once($RELEATED_PATH . "config.php");	
	require_once($RELEATED_PATH . "session.php");
	checkAdmin();
/*modify by lunsrot at 2007/08/07*/
	$IMAGE_PATH = $RELEATED_PATH . $IMAGE_PATH;
	$absoluteURL = $HOMEURL . "Jurisdiction/";

	$parent_menu_id = $_GET["parent_menu_id"];
	$menu_level = $_GET["menu_level"];

	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);
	

	$tpl->assign("menu_level", $menu_level);
	$tpl->assign("parent_menu_id", $parent_menu_id);
	
	//目前的Action
	$tpl->assign("action", "new");	//new
	
	//目前的頁面
	$tpl->assign("currentPage", "newJurisdiction.php");
	
	assignTemplate($tpl, "/jurisdiction/jurisdictionInput.tpl");
?>
