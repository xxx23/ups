<?php
/*
DATE:   2006/12/26
AUTHOR: 14_不太想玩
*/

	require_once("config.php");	
	
	include "library/passwd.php";

	$login_id = $_POST['login_id'];
	$password = $_POST['password'];

    $login_id = trim($login_id);
    $password = trim($password);

	global $DB_CONN, $HOME_PATH;
	/*modify by lunsrot at 2007/08/08
	 *修改內容：讓使用者登入時若發生無法登入時應給予適當說明
     */

    $row = db_getRow("select pass, validated, personal_id, role_cd, login_state from `register_basic` where login_id='$login_id';");
    $isExist = $row['login_state'];
	
	$password = passwd_encrypt($password);
	if($isExist != '1')
		loginFail(0);
    if($row['validated'] != 1)//帳號不核准使用
    {
        //導向回首頁
        loginFail(2);
    }
    elseif($row['pass'] != $password)//帳號密碼錯誤
	{
		//導向回首頁
		loginFail(1);
	}
	else//帳號密碼正確
	{	
        $personal_id = $row['personal_id'];
        $role_cd = $row['role_cd'];		
		
		//註冊session
		session_start();
		$_SESSION['personal_id'] = $personal_id;
		$_SESSION['role_cd'] = $role_cd;
		$_SESSION['template_path'] = $HOME_PATH . "themes/";
		$_SESSION['template'] = db_getOne("SELECT personal_style FROM personal_basic WHERE personal_id=$personal_id;");
		if(empty($_SESSION['template']))
			$_SESSION['template'] = "IE";
		setMenu($personal_id, $role_cd);
		
		//查出IP
		$ip = getenv ( "REMOTE_ADDR" );
		if ( $ip == "" )
			$ip = $HTTP_X_FORWARDED_FOR;
		if ( $ip == "" )
			$ip = $REMOTE_ADDR;		
		//-------------------------------------------------------
		/**紀錄每個登入者的log**/
        loginLog($personal_id,$ip,$MAX_LOGIN_LOG_LENGTH);
		/** 登入後會將這個user 記在 online_number **/
		if( isset($_SESSION['online_cd ']) ){ //同一個來源
			$sql = "UPDATE online_number SET status='重新登入中', idle='".date('U')."' WHERE online_cd='".$_SESSION['online_cd ']."'";
			$res = db_query($sql);
		}
		else{ 
			$sql = "INSERT INTO online_number (personal_id, host, time, idle, status) VALUES ('".$personal_id."','".$ip."','".date("U")."','".date("U")."','登入系統中')";
			$res = db_query($sql);
			$sql = "SELECT online_cd FROM online_number WHERE personal_id='".$personal_id."' and host='".$ip."'";
			$online_cd = db_getOne($sql);
			$_SESSION['online_cd'] = $online_cd;						
		}

		//--------------------------------------------------------
		$_SESSION['personal_ip'] = $ip;	
		
		//學習追蹤-登入系統
		LEARNING_TRACKING_start(1, 1, -1, $_SESSION['personal_id']);
		
		//導向到個人首頁
		$redirectPage = "Personal_Page/index.php";
        /*Modified by Zoe
         *
         */
	    $_SESSION['isLoggedIn'] = true;	
        $logged = time();
        $_SESSION['loggedAt']= $logged; 

	}

	header("location:" . $redirectPage);

	function setMenu($pid, $role){
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
            "登入失敗，您的帳號尚未被核准使用，請至註冊時填寫的信箱收取帳號認證信，並點選連結啟用帳號",
            "教師帳號目前維護中"
        );

		echo "<script type=\"text/javascript\">alert('$remind[$type]')</script>";
		if($type == 0)
            echo "<meta http-equiv=\"refresh\" content=\"0; url=index.php\"/>";
        else if ($type == 2)
        {
            echo "<meta http-equiv=\"refresh\" content=\"0; url=Other/q_and_a.php?q=1\"/>";
        }
		else
			echo "<script type=\"text/javascript\">history.back()</script>";
		exit(0);
	}
	function loginLog($pid,$ip,$MAX_LOGIN_LOG_LENGTH)
	{
		global $DB_CONN,$MAX_LOGIN_LOG_LENGTH;
        /*$sql = "SELECT COUNT(*) as count FROM `login_log`";
        $count = db_getOne($sql);
		if($count > $MAX_LOGIN_LOG_LENGTH)
		{
			$sql = "DELETE FROM `login_log` WHERE `login_log`.`login_time`=(SELECT MIN(login_time) FROM (SELECT login_time FROM `login_log`) AS temp)";
			$res = $DB_CONN->query($sql);
			if (PEAR::isError($res))	die($res->getMessage());
        }*/
		$sql = "INSERT INTO `login_log` (`pid`, `login_time`, ` ip`) VALUES ('".$pid."', CURRENT_TIMESTAMP, '".$ip."');";
		$res = db_query($sql);
		$res = db_query("LOCK TABLES `login_statistic` WRITE");
		$date = getdate();
		$sql = "SELECT count FROM `login_statistic` WHERE `which_month`='$date[year]/$date[mon]/1 00:00:00'";
		$res = db_query($sql);
		if($res->numRows($res) > 0)
		{
			$data = $res->fetchRow();
			$sql = "UPDATE `login_statistic` SET `count` = ".($data[0]+1) ." WHERE `which_month` = '$date[year]/$date[mon]/1 00:00:00'";
		}
		else
		{
			$sql = "INSERT INTO `login_statistic` (`which_month`, `count`) VALUES ('$date[year]/$date[mon]/1', '1');";
		}
		$res = db_query($sql);
		$res = db_query("UNLOCK TABLES");
	}
?>
