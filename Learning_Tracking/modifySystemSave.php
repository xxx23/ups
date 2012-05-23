<?
	$RELEATED_PATH = "../";

	require_once($RELEATED_PATH . "config.php");	
	require_once($RELEATED_PATH . "session.php");

	$system_id = $_POST["system_id"];
	$system_name = $_POST["system_name"];
	$system_state = $_POST["system_state"];
	
	//更新資料到Table tracking_system_menu 
	$sql = "UPDATE tracking_system_menu 
					SET 
						system_name='$system_name', 
						system_state='$system_state' 
					WHERE 
						system_id=$system_id
					";
	$sth = $DB_CONN->prepare($sql);
	$res = $DB_CONN->execute($sth);
	if (PEAR::isError($res))	die($res->getMessage());
	
	//導向到finishPage
	header("location: learningTrackingManagement.php");
?>
