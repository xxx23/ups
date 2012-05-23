<?php
	require_once("../config.php");
	
	require_once("../library/passwd.php");
	require_once("../library/account.php");
	
	$smtpl = new Smarty;
	
	if(isset($_POST['admin_init'])){
		$admin_account = $_POST['admin_account'];
		$admin_pass = $_POST['admin_pass'];
		//print $admin_account.$admin_pass;
		create_account_($admin_account,$admin_pass,"0");
	}
	
	$sql = "select personal_id from register_basic where login_id='admin'";
	$result = $DB_CONN->getOne($sql);
	if(PEAR::isError($result))	die($result->userinfo);
	if(isset($result)){
	  $smtpl->assign("created","1");
	  $smtpl->assign("create_status","<font color=\"red\">管理者帳號已新增!</font>");
	}
	else
	  $smtpl->assign("created","0");
 

	$smtpl->display("./install5.tpl");

	function create_account_($id, $pass, $cd){
	  global $PERSONAL_PATH;
	  $pass = passwd_encrypt($pass);
	  if(!validate_login_id($id) || check_login_id_($id) != 0)
	    return -1;
	  db_query("insert into `register_basic` (login_id, pass, role_cd, login_state, validated) values ('$id', '$pass', $cd, '1', '1');");
	  $pid = db_getOne("select personal_id from `register_basic` where login_id='$id';");
	  db_query("insert into `personal_basic` (personal_id) values ($pid);");
	  createPath($PERSONAL_PATH . $pid);
	  return $pid;
	}

	//檢查該帳號是否已存在，若已存在回傳1
	function check_login_id_($id){
	  $tmp = db_getOne("select count(*) from `register_basic` where login_id='$id';");
	  return ($tmp > 1)? 1 : 0;
	}
?>
