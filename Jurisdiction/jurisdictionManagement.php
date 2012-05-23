<?
	$RELEATED_PATH = "../";

	require_once($RELEATED_PATH . "config.php");
/*modify by lunsrot at 2007/03/22*/
	require_once($RELEATED_PATH . "session.php");
/*modify end*/
	checkAdmin();
	echo str_pad('', 1024);
	$IMAGE_PATH = $RELEATED_PATH . $IMAGE_PATH;
	$absoluteURL = $HOMEURL . "Jurisdiction/";

	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);

	$input = $_GET;
	if (!array_key_exists('menu_id', $input))
		$input['menu_id'] = '';
	if(!array_key_exists('menu_level', $input) || !is_numeric($input['menu_level']))
		$input['menu_level'] = 0;

	//搜尋所有系統的權限
	if(empty($input['menu_id']))
		$res = $DB_CONN->query("SELECT * FROM lrtmenu_ where menu_level='$input[menu_level]' ORDER BY sort_id");
	else
		$res = $DB_CONN->query("SELECT * FROM lrtmenu_ where menu_level='$input[menu_level]' and menu_id like '#$input[menu_id]%' ORDER BY sort_id");
	if (PEAR::isError($res))	die($res->getMessage());

	$tpl->assign("menu_level", $input['menu_level']);
	$tpl->assign("menu_id", $input['menu_id']);
	$tpl->assign("parent_menu_id", substr($input['menu_id'], 0, strlen($input['menu_id']) - 2));
	$jurisdictionNum = $res->numRows();
	$tpl->assign("jurisdictionNum", $jurisdictionNum);

	if($jurisdictionNum > 0)
	{
		$rowCounter = 0;

		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
		{
			$menu_id = substr($row['menu_id'], 1);	//去掉"#"

			$menu_level = $row['menu_level'];

			$menu_name = $row['menu_name'];

			$menu_link = $row['menu_link'];

			$menu_state = $row['menu_state'];

			$sort_id = $row['sort_id'];

			$jurisdictionList[$rowCounter] =
					array(	"menu_id" => $menu_id,
							"menu_level" => $menu_level,
							"menu_name" => $menu_name,
							"menu_link" => $menu_link,
							"menu_state" => $menu_state,
							"sort_id" => $sort_id
						);

			$rowCounter++;
		}

		$tpl->assign("jurisdictionList", $jurisdictionList);
	}

	//目前的頁面
	$tpl->assign("currentPage", "jurisdictionManagement.php");

/*modify by lunsrot at 2007/03/22*/
	assignTemplate($tpl, "/jurisdiction/jurisdictionManagement.tpl");
	ob_flush();
	flush(); //both needed to flush the buffer
	sleep(1);
/*modify end*/
?>
