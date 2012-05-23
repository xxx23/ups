<?php
/*
DATE:   2009/08/02
AUTHOR: tkraha
*/

	require_once("config.php");	
	
	$login_id = 'guest'; 
	
	global $DB_CONN, $HOME_PATH;
	$isExist = $DB_CONN->getOne("select count(*) from `register_basic` where login_id='$login_id' and login_state='1';");
	
	if($isExist != 1)
		loginFail(0);
	$sql = "SELECT personal_id, role_cd FROM register_basic WHERE login_id = '$login_id' AND validated='1'";
	$res = db_query($sql);
	if( ($res->numRows()) == 0)//帳號不核准使用
	{
		//導向回首頁
		loginFail(2);
	}
	else{
	
		$res->fetchInto($row, DB_FETCHMODE_ASSOC);
		$personal_id = $row[personal_id];
		$role_cd = $row[role_cd];
	
	}	
		
	//註冊session
	session_start();
	$_SESSION['personal_id'] = $personal_id;
	$_SESSION['role_cd'] = $role_cd;
	$_SESSION['template_path'] = $HOME_PATH . "themes/";
	$_SESSION['template'] = "IE2";

	setMenu($personal, $role_cd);
	
	//查出IP
	$ip = getenv ( "REMOTE_ADDR" );
	if ( $ip == "" )
		$ip = $HTTP_X_FORWARDED_FOR;
	if ( $ip == "" )
		$ip = $REMOTE_ADDR;		
	//-------------------------------------------------------
	/** 登入後會將這個user 記在 online_number **/
	if( isset($_SESSION['online_cd ']) ){ //同一個來源
		$sql = "UPDATE online_number SET status='重新登入中', idle='".date('U')."' WHERE online_cd='".$_SESSION['online_cd ']."'";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());			
	}
	else{ 
		$sql = "INSERT INTO online_number (personal_id, host, time, idle, status) VALUES ('".$personal_id."','".$ip."','".date("U")."','".date("U")."','登入系統中')";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		$sql = "SELECT online_cd FROM online_number WHERE personal_id='".$personal_id."' and host='".$ip."'";
		$online_cd = $DB_CONN->getOne($sql);
		$_SESSION['online_cd'] = $online_cd;						
	}
	//echo $sql;	
	//--------------------------------------------------------
	$_SESSION['personal_ip'] = $ip;	
	
	
	//學習追蹤-登入系統
	LEARNING_TRACKING_start(1, 1, -1, $_SESSION['personal_id']);
	
	//導向到個人首頁
	$redirectPage = "Personal_Page/index.php";
	
	header("location:" . $redirectPage);

	function setMenu($pid, $role){
		global $DB_CONN;
		$_SESSION['menu'] = array();
        $sql = "SELECT menu_link from `lrtmenu_` a, `menu_role` b 
            WHERE a.menu_id = b.menu_id
            AND a.menu_level > 0
            AND a.menu_link LIKE '%php%'
            AND b.role_cd = $role
            AND b.is_used = 'y';";

        $result = db_query($sql);
		while($row = $result->fetchRow())
			array_push($_SESSION['menu'], $row[0]);
	}

	function loginFail($type){
		$remind = array(
			"登入失敗，您的帳號不存在，請重新確認",
			"登入失敗，您的帳號密碼不符合，請重新確認",
			"登入失敗，您的帳號尚未被核准使用，請洽管理員");

		echo "<script type=\"text/javascript\">alert('$remind[$type]')</script>";
		if($type == 0)
			echo "<meta http-equiv=\"refresh\" content=\"0; url=index.php\"/>";
		else
			echo "<script type=\"text/javascript\">history.back()</script>";
		exit(0);
	}
?>
