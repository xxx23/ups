<?
	$RELEATED_PATH = "../";

	require_once($RELEATED_PATH . "config.php");	
	require_once($RELEATED_PATH . "session.php");
	$IMAGE_PATH = $RELEATED_PATH . $IMAGE_PATH;
	$absoluteURL = $HOMEURL . "Learning_Tracking/";

	$system_id = $_GET["system_id"];
	$function_id = $_GET["function_id"];

	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);

	//從Table tracking_function_menu取出資料
	$sql = "SELECT * FROM tracking_function_menu 
				WHERE 
					system_id=$system_id AND 
					function_id=$function_id";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	
	$resultNum = $res->numRows();
	
	if($resultNum > 0)
	{
		$res->fetchInto($row, DB_FETCHMODE_ASSOC);

		$function_name = $row[function_name];
		$function_state = $row[function_state];
	}
	

	$tpl->assign("system_id", $system_id);
	$tpl->assign("function_id", $function_id);
	$tpl->assign("function_name", $function_name);
	$tpl->assign("function_state", $function_state);
	
	//目前的Action
	$tpl->assign("action", "modify");	//modify
	
	//目前的頁面
	$tpl->assign("currentPage", "modifyFunction.php");
	
	assignTemplate($tpl, "/learning_tracking/functionInput.tpl");
?>
