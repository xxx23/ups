<?
	$RELEATED_PATH = "../";

	require_once($RELEATED_PATH . "config.php");	
	require_once($RELEATED_PATH . "session.php");
	checkAdmin();
	$IMAGE_PATH = $RELEATED_PATH . $IMAGE_PATH;
	$absoluteURL = $HOMEURL . "Learning_Tracking/";

	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);
	
	//取得一個新的系統編號
	$sql = "SELECT * FROM tracking_system_menu ORDER BY system_id DESC";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	
	$resultNum = $res->numRows();
	if($resultNum < 1)
	{
		$new_system_id = 1;
	}
	else
	{
		$res->fetchInto($row, DB_FETCHMODE_ASSOC);
		$new_system_id = $row[system_id] + 1;
	}
	$tpl->assign("system_id", $new_system_id);
	
	//目前的Action
	$tpl->assign("action", "new");	//new
	
	//目前的頁面
	$tpl->assign("currentPage", "newSystem.php");
	
	assignTemplate($tpl, "/learning_tracking/systemInput.tpl");
?>
