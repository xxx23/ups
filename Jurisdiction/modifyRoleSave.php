<?
	$RELEATED_PATH = "../";

	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");	


	$role_cd = $_POST["role_cd"];
	$role_name = $_POST["role_name"];

	//更新資料到Table lrtrole_
	$sth = $DB_CONN->prepare("UPDATE lrtrole_ SET role_name='$role_name' WHERE role_cd='$role_cd'");
	$res = $DB_CONN->execute($sth);
	if (PEAR::isError($res))	die($res->getMessage());

	//導向到finishPage
	header("location: roleManagement.php");
?>
