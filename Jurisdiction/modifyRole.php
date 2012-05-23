<?
	$RELEATED_PATH = "../";

	require_once($RELEATED_PATH . "config.php");	
	/*modify by lunsrot at 2007/03/22*/
	require_once($RELEATED_PATH . "session.php");
	checkAdmin();
	/*modify end*/
	$IMAGE_PATH = $RELEATED_PATH . $IMAGE_PATH;
	$absoluteURL = $HOMEURL . "Jurisdiction/";

	$role_cd = $_GET["role_cd"];

	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);
	

	//取出角色資料
	$res = $DB_CONN->query("SELECT * FROM lrtrole_ WHERE role_cd='$role_cd'");
	if (PEAR::isError($res))	die($res->getMessage());
	
	$roleNum = $res->numRows();
	$tpl->assign("roleNum", $roleNum);
	
	if($roleNum > 0)
	{
		$res->fetchInto($row, DB_FETCHMODE_ASSOC);

		$role_name = $row[role_name];
	}
	
	$tpl->assign("show_role_cd", 1);
	$tpl->assign("role_cd", $role_cd);
	$tpl->assign("role_name", $role_name);
	
	//目前的Action
	$tpl->assign("action", "modify");	//modify
	
	//目前的頁面
	$tpl->assign("currentPage", "modifyRole.php");
	
/*modify by lunsrot at 2007/03/22*/
	assignTemplate($tpl, "/jurisdiction/roleInput.tpl");
/*modify end*/
?>
