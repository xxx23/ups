<?php
/***
FILE:
DATE:
AUTHOR: zqq
**/
	//require_once("../config.php");
	//require_once("../session.php");

	$RELEATED_PATH = "../";
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	//update_status ( "確認開課中" );
	checkAdminAcademic();
	//開啟session
	//session_start();

	if(!array_key_exists('values', $_SESSION) ){
		$_SESSION['values'] = Array();
		$_SESSION['errors'] = Array();
	}

	if(!array_key_exists('unit_cd', $_SESSION['values']) ){
		$_SESSION['values']['unit_cd']		= '';
		$_SESSION['values']['unit_name']	= '';
		$_SESSION['values']['unit_abbrev']	= '';
		$_SESSION['values']['unit_e_name']	= '';
		$_SESSION['values']['unit_e_abbrev']	= '';
		$_SESSION['values']['department']	= '';
	}

	if(!array_key_exists('unit_cd', $_SESSION['errors']) ){
		$_SESSION['errors']['unit_cd']		= 'hidden';
		$_SESSION['errors']['unit_name']	= 'hidden';
		$_SESSION['errors']['unit_abbrev']	= 'hidden';
		$_SESSION['errors']['unit_e_name']	= 'hidden';
		$_SESSION['errors']['unit_e_abbrev']	= 'hidden';
		$_SESSION['errors']['department']	= 'hidden';
	}
	//new smarty
	$tpl = new Smarty();
	echo "<pre></pre>";

	//-------------系所編號--------------------
	if (array_key_exists('unit_cd', $_SESSION['values']))
		$tpl->assign("valueOfUnit_cd",$_SESSION['values']['unit_cd']);
	if (array_key_exists('unit_cd', $_SESSION['errors']))
		$tpl->assign("unit_cdFailed",$_SESSION['errors']['unit_cd']);

	//-------------系所名稱--------------------
	if (array_key_exists('unit_name', $_SESSION['values']))
		$tpl->assign("valueOfUnit_name",$_SESSION['values']['unit_name']);
	if (array_key_exists('unit_name', $_SESSION['errors']))
		$tpl->assign("unit_nameFailed",$_SESSION['errors']['unit_name']);

	//-------------系所英文名稱--------------------
	if (array_key_exists('unit_abbrev', $_SESSION['values']))
		$tpl->assign("valueOfUnit_abbrev",$_SESSION['values']['unit_abbrev']);
	if (array_key_exists('unit_abbrev', $_SESSION['errors']))
		$tpl->assign("unit_abbrevFailed",$_SESSION['errors']['unit_abbrev']);

	//-------------系所簡稱--------------------
	if (array_key_exists('unit_e_name', $_SESSION['values']))
		$tpl->assign("valueOfUnit_e_name",$_SESSION['values']['unit_e_name']);
	if (array_key_exists('unit_e_name', $_SESSION['errors']))
		$tpl->assign("unit_e_nameFailed", $_SESSION['errors']['unit_e_name']);

	//-------------系所英文簡稱--------------------
	if (array_key_exists('unit_e_abbrev', $_SESSION['values']))
		$tpl->assign("valueOfUnit_e_abbrev",$_SESSION['values']['unit_e_abbrev']);
	if (array_key_exists('unit_e_abbrev', $_SESSION['errors']))
		$tpl->assign("unit_e_abbrevFailed",$_SESSION['errors']['unit_e_abbrev']);

	//-------------所屬部門或機關--------------------
	/*$sql = "SELECT * FROM lrtunit_basic_  ORDER BY unit_cd ASC";
	$res = $DB_CONN->query($sql);
	$i=0;
	$department['ids'][$i]		= -1;
	$department['names'][$i]	= "最上層";
	$i++;
	while($row = $res->fetchRow(DB_FETCHMODE_ASSOC)){
		$department['ids'][$i]		= $row['unit_cd'];
		$department['names'][$i]	= $row['unit_name'];
		$i++;
	}

	$tpl->assign("department_ids"	,$department['ids'] );
	$tpl->assign("department_names"	,$department['names']);
*/
	if (array_key_exists('department', $_SESSION['values']))
		$tpl->assign("department_id",$_SESSION['values']['department']);
	if (array_key_exists('department', $_SESSION['errors']))
		$tpl->assign("departmentFailed",$_SESSION['errors']['department']);
	$tpl->assign("ValueOfBegin_unit_cd","最上層");
	//驗證表單
	$tpl->assign("actionPage","./validate_unit_basic.php?validationType=php");
	//輸出頁面
	assignTemplate($tpl, "/course_admin/unit_basic.tpl");
?>
