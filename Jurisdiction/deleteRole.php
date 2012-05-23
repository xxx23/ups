<?
	$RELEATED_PATH = "../";

	require_once($RELEATED_PATH . "config.php");	
	require_once($RELEATED_PATH . "session.php");

	$role_cd = $_GET["role_cd"];

	//刪除角色的權限資料
	//從Table menu_role中刪除資料
	$sql = "DELETE FROM menu_role WHERE role_cd=$role_cd";
	$sth = $DB_CONN->prepare($sql);	
	$res = $DB_CONN->execute($sth);
	if (PEAR::isError($res))	die($res->getMessage());

	//刪除角色的資料
	//從Table lrtrole_中刪除資料
	$sql = "DELETE FROM lrtrole_ WHERE role_cd=$role_cd";
	$sth = $DB_CONN->prepare($sql);	
	$res = $DB_CONN->execute($sth);
	if (PEAR::isError($res))	die($res->getMessage());
	
	header("location: roleManagement.php");
?>
