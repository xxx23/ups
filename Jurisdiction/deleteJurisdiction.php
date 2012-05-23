<?
	$RELEATED_PATH = "../";

	require_once($RELEATED_PATH . "config.php");	
	require_once($RELEATED_PATH . "session.php");

	$menu_id = $_GET["menu_id"];
	$sql_menu_id = "#" . $menu_id;

	//刪除角色所擁有的這些權限以及它的所有子權限
	//從Table menu_role中刪除資料
	$sql = "DELETE FROM menu_role WHERE menu_id LIKE '$sql_menu_id%'";
	$sth = $DB_CONN->prepare($sql);	
	$res = $DB_CONN->execute($sth);
	if (PEAR::isError($res))	die($res->getMessage());

	$sort_id = db_getOne("select sort_id from `lrtmenu_` where menu_id='$sql_menu_id';");
	$menu_level = (strlen($menu_id)/2) - 1;
	$tmp = "";
	if($menu_level != 0)
		$tmp = " AND menu_id LIKE '#" . substr($menu_id, 0, -2) . "'";
	db_query("UPDATE `lrtmenu_` SET sort_id=sort_id-1 WHERE sort_id>$sort_id AND menu_level='$menu_level'$tmp;");

	//刪除這個權限以及它的所有子權限
	//從Table lrtmenu_中刪除資料
	$sql = "DELETE FROM lrtmenu_ WHERE menu_id LIKE '$sql_menu_id%'";
	$sth = $DB_CONN->prepare($sql);	
	$res = $DB_CONN->execute($sth);
	if (PEAR::isError($res))	die($res->getMessage());

	header("location: jurisdictionManagement.php");
?>
