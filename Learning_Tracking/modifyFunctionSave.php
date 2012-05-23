<?
	$RELEATED_PATH = "../";

	require_once($RELEATED_PATH . "config.php");	
	require_once($RELEATED_PATH . "session.php");

	$system_id = $_POST["system_id"];
	$function_id = $_POST["function_id"];
	$function_name = $_POST["function_name"];
	$function_state = $_POST["function_state"];
	
	//更新資料到Table tracking_function_menu 
	$sql = "UPDATE tracking_function_menu 
					SET 
						function_name='$function_name', 
						function_state='$function_state' 
					WHERE 
						system_id=$system_id AND 
						function_id=$function_id 
					";
	$sth = $DB_CONN->prepare($sql);
	$res = $DB_CONN->execute($sth);
	if (PEAR::isError($res))	die($res->getMessage());
	
	//導向到finishPage
	header("location: learningTrackingManagement.php");
?>
