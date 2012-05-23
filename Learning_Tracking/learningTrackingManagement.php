<?
require_once("../config.php");
require_once("../session.php");
checkAdmin();
	$RELEATED_PATH = "../";

	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	$IMAGE_PATH = $RELEATED_PATH . $IMAGE_PATH;
	$absoluteURL = $HOMEURL . "Learning_Tracking/";

	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);

	$menuCounter = 0;

	//從Table tracking_system_menu搜尋所有的系統
	$sql = "SELECT * FROM tracking_system_menu ORDER BY system_id ASC";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());

	$resultNum = $res->numRows();
	if($resultNum > 0)
	{
		$rowCounter = 0;

		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
		{
			$systemList[$rowCounter] =
					array(	"system_id" => $row['system_id'],
							"system_name" => $row['system_name'],
							"system_state" => $row['system_state']
						);

			$rowCounter++;
		}
		$systemNum = $rowCounter;

		//從Table tracking_function_menu搜尋所有的功能
		for($systemCounter=0; $systemCounter<$systemNum; $systemCounter++)
		{
			$menuList[$menuCounter++] =
					array(	"system_id" => $systemList[$systemCounter]['system_id'],
							"function_id" => "&nbsp",
							"name" => $systemList[$systemCounter]['system_name'],
							"state" => $systemList[$systemCounter]['system_state'],
							"menu_type" => "system"
						);

			$sql = "SELECT * FROM tracking_function_menu
							WHERE
								system_id = " . $systemList[$systemCounter]['system_id'] . "
							ORDER BY function_id ASC";
			$res = $DB_CONN->query($sql);
			if (PEAR::isError($res))	die($res->getMessage());

			$resultNum = $res->numRows();
			if($resultNum > 0)
			{
				while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
				{
					$menuList[$menuCounter++] =
						array(	"system_id" => $row['system_id'],
								"function_id" => $row['function_id'],
								"name" => $row['function_name'],
								"state" => $row['function_state'],
								"menu_type" => "function"
							);
				}
			}

		}
	}
	$menuNum = $menuCounter;
	$tpl->assign("menuNum", $menuNum);
	$tpl->assign("menuList", $menuList);

	//目前的頁面
	$tpl->assign("currentPage", "learningTrackingManagement.php");

	assignTemplate($tpl, "/learning_tracking/learningTrackingManagement.tpl");
?>
