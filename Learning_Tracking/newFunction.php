<?
	$RELEATED_PATH = "../";

	require_once($RELEATED_PATH . "config.php");	
	require_once($RELEATED_PATH . "session.php");
	checkAdmin();
	$IMAGE_PATH = $RELEATED_PATH . $IMAGE_PATH;
	$absoluteURL = $HOMEURL . "Learning_Tracking/";

	$system_id = $_GET["system_id"];

	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);
	
	$tpl->assign("system_id", $system_id);
	
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
		$new_function_id = 1;
	}
	else
	{
		$res->fetchInto($row, DB_FETCHMODE_ASSOC);
		$new_function_id = $row[function_id] + 1;
	}
	$tpl->assign("function_id", $new_function_id);
	
	//目前的Action
	$tpl->assign("action", "new");	//new
	
	//目前的頁面
	$tpl->assign("currentPage", "newFunction.php");
	
	assignTemplate($tpl, "/learning_tracking/functionInput.tpl");
?>
