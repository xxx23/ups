<?
	$RELEATED_PATH = "../";

	require_once($RELEATED_PATH . "config.php");	
	require_once($RELEATED_PATH . "session.php");
	$IMAGE_PATH = $RELEATED_PATH . $IMAGE_PATH;
	$absoluteURL = $HOMEURL . "Jurisdiction/";

	$menu_id = $_GET["menu_id"];
	$menu_level = $_GET["menu_level"];

	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);

	//取出權限
	$sql_menu_id = "#" . $menu_id;
	$res = $DB_CONN->query("SELECT * FROM lrtmenu_ WHERE menu_id='$sql_menu_id'");
	if (PEAR::isError($res))	die($res->getMessage());
	
	$jurisdictionNum = $res->numRows();
	$tpl->assign("jurisdictionNum", $jurisdictionNum);
	
	if($jurisdictionNum > 0)
	{
		$res->fetchInto($row, DB_FETCHMODE_ASSOC);

		$menu_id = substr($row[menu_id], 1);	//去掉"#"
		$menu_name = $row[menu_name];
		$menu_link = $row[menu_link];
		$menu_state = $row[menu_state];
	}
	
	
	
	$tpl->assign("show_menu_id", 1);
	$tpl->assign("menu_id", $menu_id);
	$tpl->assign("menu_level", $menu_level);
	$tpl->assign("menu_name", $menu_name);
	$tpl->assign("menu_link", $menu_link);
	$tpl->assign("menu_state", $menu_state);
	
	//目前的Action
	$tpl->assign("action", "modify");	//modify
	
	//目前的頁面
	$tpl->assign("currentPage", "modifyJurisdiction.php");
	
	assignTemplate($tpl, "/jurisdiction/jurisdictionInput.tpl");
?>
