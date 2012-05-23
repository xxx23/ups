<?
/*modify by lunsrot at 2007/03/22 almost all file content*/
	$RELEATED_PATH = '../';
	require_once($RELEATED_PATH . 'config.php');
	require_once($RELEATED_PATH . 'session.php');
	checkAdmin();
	$IMAGE_PATH = $RELEATED_PATH . $IMAGE_PATH;
	$absoluteURL = $HOMEURL . "Jurisdiction/";

	global $DB_CONN;
	$role_cd = $_GET["role_cd"];

	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);

	$tpl->assign("role_cd", $role_cd);
	$tpl->assign("role_name", $DB_CONN->getOne("select role_name from `lrtrole_` where role_cd=$role_cd;"));
//	$result = db_query("select A.menu_id, A.is_used, B.menu_name, B.menu_link, B.menu_level from `menu_role` A, `lrtmenu_` B where A.role_cd=$role_cd and B.menu_id=A.menu_id and B.menu_state='y' order by B.menu_id;");
	//先取出該角色能使用何種功能
	$menu_id = array();
	$is_used = array();
	$result = db_query("select menu_id, is_used from `menu_role` where role_cd=$role_cd order by menu_id;");
	while(($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) != false){
		array_push($menu_id, $row['menu_id']);
		array_push($is_used, $row['is_used']);
	}
	//取出所有功能
	$result = db_query("select menu_id, menu_name, menu_link, menu_level from `lrtmenu_` where menu_state='y' order by menu_id;");
	$tpl->assign("jurisdictionNum", $result->numRows());
	$i = 0;
	while(($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) != false){
		$row['is_used'] = 'n';
		//為所有的功能判斷是否使用
		if(in_array($row['menu_id'], $menu_id)){
			$j = array_search($row['menu_id'], $menu_id);
			$row['is_used'] = $is_used[$j];
		}
		$row['number'] = $i++;
		$row['menu_id'] = substr($row['menu_id'], 1);
		$tpl->append("jurisdictionList", $row);
	}

	assignTemplate($tpl, "/jurisdiction/roleJurisdictionInput.tpl");
?>
