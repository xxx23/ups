<?
	$RELEATED_PATH = "../";

	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	checkAdmin();
	
	$IMAGE_PATH = $RELEATED_PATH . $IMAGE_PATH;
	$absoluteURL = $HOMEURL . "Learning_Tracking/";

	$system_id = $_GET['system_id'];

	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);

	//從Table tracking_system_menu 取出資料
	$sql = "SELECT * FROM tracking_system_menu WHERE system_id=$system_id";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());

	$resultNum = $res->numRows();

	if($resultNum > 0)
	{
		$res->fetchInto($row, DB_FETCHMODE_ASSOC);

		$system_name = $row['system_name'];
		$system_state = $row['system_state'];
	}


	$tpl->assign("system_id", $system_id);
	$tpl->assign("system_name", $system_name);
	$tpl->assign("system_state", $system_state);

	//目前的Action
	$tpl->assign("action", "modify");	//modify

	//目前的頁面
	$tpl->assign("currentPage", "modifySystem.php");

	assignTemplate($tpl, "/learning_tracking/systemInput.tpl");
?>
