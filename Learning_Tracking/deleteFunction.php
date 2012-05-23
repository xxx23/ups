<?
	$RELEATED_PATH = "../";

	require_once($RELEATED_PATH . "config.php");	
	require_once($RELEATED_PATH . "session.php");

	$system_id = $_GET["system_id"];
	$function_id = $_GET["function_id"];

	//刪除事件的資料
	//從Table event_statistics中刪除資料
	$sql = "DELETE FROM event_statistics WHERE system_id=$system_id AND function_id=$function_id";
	$sth = $DB_CONN->prepare($sql);	
	$res = $DB_CONN->execute($sth);
	if (PEAR::isError($res))	die($res->getMessage());

	//從Table event中刪除資料
	$sql = "DELETE FROM event WHERE system_id=$system_id AND function_id=$function_id";
	$sth = $DB_CONN->prepare($sql);	
	$res = $DB_CONN->execute($sth);
	if (PEAR::isError($res))	die($res->getMessage());


	//從Table tracking_function_menu中刪除資料
	$sql = "DELETE FROM tracking_function_menu WHERE system_id=$system_id AND function_id=$function_id";
	$sth = $DB_CONN->prepare($sql);	
	$res = $DB_CONN->execute($sth);
	if (PEAR::isError($res))	die($res->getMessage());
	
	header("location: learningTrackingManagement.php");
?>
