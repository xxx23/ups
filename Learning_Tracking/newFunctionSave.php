<?
	$RELEATED_PATH = "../";

	require_once($RELEATED_PATH . "config.php");	
	require_once($RELEATED_PATH . "session.php");

	$system_id = $_POST["system_id"];
	$function_name = $_POST["function_name"];
	$function_state = $_POST["function_state"];
	
	//取得一個新的功能編號
	$sql = "SELECT * FROM tracking_function_menu 
				WHERE 
					system_id=$system_id 
				ORDER BY function_id DESC";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	
	$resultNum = $res->numRows();
	if($resultNum < 1)
	{
		$function_id = 1;
	}
	else
	{
		$res->fetchInto($row, DB_FETCHMODE_ASSOC);
		$function_id = $row[function_id] + 1;
	}
	
	//新增資料到Table tracking_function_menu  
	$sql = "INSERT INTO tracking_function_menu  (
						system_id, 
						function_id, 
						function_name, 
						function_state 
					) VALUES ( 
						$system_id, 
						$function_id, 
						'$function_name', 
						'$function_state' 
					)";
	$sth = $DB_CONN->prepare($sql);
	$res = $DB_CONN->execute($sth);
	if (PEAR::isError($res))	die($res->getMessage());
	
	//導向到finishPage
	header("location: learningTrackingManagement.php");
	
?>