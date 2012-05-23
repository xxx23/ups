<?php
	/*author: zqq
	 * modify by lunsrot at 2007/07/08
	 */
	require_once("../config.php");
	require_once("../session.php");

	$input = $_POST;

	switch($input['option']){
	case "insert": insert($input); break;
	default: view(); break;
	}

	//----------------function area ------------------
	function view(){
		global $DB_CONN, $HOME_PATH;
		$tpl_path = "/themes/" . $_SESSION['template'];		
		$template = $HOME_PATH . $tpl_path;
		//new smarty
		$tpl = new Smarty();

		$sql = "SELECT *, r.validated FROM register_basic r, personal_basic p WHERE r.personal_id=p.personal_id and r.role_cd='3'";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());	
		while($row = $res->fetchRow(DB_FETCHMODE_ASSOC) ){
			$user[] = $row;
		}

		// 顯示 匯入的結果	
		$tpl->assign("user", $user);

		//輸出頁面
		$tpl->assign("tpl_path", $tpl_path);		
		$tpl->display($template ."/registration/adm_check_register.tpl");
	}

	function insert($input){
		global $DB_CONN;
		$choose = $input['choose'];
		for($i = 0 ; $i < count($choose) ; $i++)
			$DB_CONN->query("update `register_basic` set validated='1' where personal_id=$choose[$i];");
		header("location:./adm_check_register.php");
	}
?>
