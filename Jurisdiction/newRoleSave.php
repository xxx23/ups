<?
	$RELEATED_PATH = "../";

	require_once($RELEATED_PATH . "config.php");
/*modify by lunsrot at 2007/03/22*/
	require_once($RELEATED_PATH . "session.php");
/*modify end*/

	$role_name = $_POST["role_name"];
	$role_cd = $_POST['role_cd'];

	$result = db_query("insert into `lrtrole_` (role_name, role_cd) values ('$role_name', $role_cd);");
	//導向到finishPage
	header("location: roleManagement.php");
?>
