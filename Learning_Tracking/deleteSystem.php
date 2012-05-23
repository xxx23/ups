<?
	$RELEATED_PATH = "../";

	require_once($RELEATED_PATH . "config.php");	
	require_once($RELEATED_PATH . "session.php");

	checkAdmin();
	$system_id = $_GET["system_id"];

	//刪除事件的資料
	//從Table event_statistics中刪除資料
	$sql = "DELETE FROM event_statistics WHERE system_id=$system_id";
	$sth = $DB_CONN->prepare($sql);	
	$res = $DB_CONN->execute($sth);
	if (PEAR::isError($res))	die($res->getMessage());

	//從Table event 中刪除資料
	$sql = "DELETE FROM event WHERE system_id=$system_id";
	$sth = $DB_CONN->prepare($sql);	
	$res = $DB_CONN->execute($sth);
	if (PEAR::isError($res))	die($res->getMessage());


	//從Table tracking_function_menu中刪除所有的功能
	$sql = "DELETE FROM tracking_function_menu WHERE system_id=$system_id";
	$sth = $DB_CONN->prepare($sql);	
	$res = $DB_CONN->execute($sth);
	if (PEAR::isError($res))	die($res->getMessage());
	
	//從Table tracking_system_menu中刪除資料
	$sql = "DELETE FROM tracking_system_menu WHERE system_id=$system_id";
	$sth = $DB_CONN->prepare($sql);	
	$res = $DB_CONN->execute($sth);
	if (PEAR::isError($res))	die($res->getMessage());
	
	header("location: learningTrackingManagement.php");
?>
