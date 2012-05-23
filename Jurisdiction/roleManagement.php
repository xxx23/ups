<?
	$RELEATED_PATH = "../";

	require_once($RELEATED_PATH . "config.php");
/*modify by lunsrot at 2007/03/22*/
	require_once($RELEATED_PATH . "session.php");
/*modify end*/
	checkAdmin();
	$IMAGE_PATH = $RELEATED_PATH . $IMAGE_PATH;
	$absoluteURL = $HOMEURL . "Jurisdiction/";

	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);

	//搜尋所有系統的角色
	$res = $DB_CONN->query("SELECT * FROM lrtrole_ ORDER BY role_cd");
	if (PEAR::isError($res))	die($res->getMessage());

	$roleNum = $res->numRows();
	$tpl->assign("roleNum", $roleNum-1);

	if($roleNum > 0)
	{
		$rowCounter = 0;

		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
		{
 			//管理者與教務管理者的權限不能更改

			$role_cd = $row['role_cd'];
			$role_name = $row['role_name'];
			$roleList[$rowCounter] =
					array(	"role_cd" => $role_cd,
							"role_name" => $role_name
						);
			$rowCounter++;
		}

		$tpl->assign("roleList", $roleList);
	}

	//目前的頁面
	$tpl->assign("currentPage", "roleManagement.php");

/*modify by lunsrot at 2007/03/22*/
	assignTemplate($tpl, "/jurisdiction/roleManagement.tpl");
/*modify end*/
?>
