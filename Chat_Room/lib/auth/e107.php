<?PHP
/////////////////////////////////////////////////////////////// 
//
//		X7 Chat Version 2.0.4
//		Released June 16, 2006
//		Copyright (c) 2004-2006 By the X7 Group
//		Website: http://www.x7chat.com
//
//		This program is free software.  You may
//		modify and/or redistribute it under the
//		terms of the included license as written  
//		and published by the X7 Group.
//  
//		By using this software you agree to the	     
//		terms and conditions set forth in the
//		enclosed file "license.txt".  If you did
//		not recieve the file "license.txt" please
//		visit our website and obtain an official
//		copy of X7 Chat.
//
//		Removing this copyright and/or any other
//		X7 Group or X7 Chat copyright from any
//		of the files included in this distribution
//		is forbidden and doing so will terminate
//		your right to use this software.
//	
////////////////////////////////////////////////////////////////EOH
?><?PHP

	// This file holds data on authentication
	$auth_ucookie = "X7C2U";
	$auth_pcookie = "X7C2P";
	$auth_register_link = "../signup.php";
	$auth_disable_guest = true;
	
	// Include the e107 cooookie
	include("../e107_config.php");
	// Init a new DB session to grab the cookie name
	$e107 = new x7chat_db($mySQLserver,$mySQLuser,$mySQLpassword,$mySQLdefaultdb);
	
	// Get name of cookie
	$query = $e107->doQuery("SELECT e107_value FROM {$mySQLprefix}core WHERE e107_name='pref'");
	$row = $e107->Do_Fetch_row($query);
	$pref = unserialize($row[0]);
	
	session_start();
	// This next line of code is straight from e107
	@list($uid, $upw) = (@$_COOKIE[$pref['cookie_name']] ? @explode(".", $_COOKIE[$pref['cookie_name']]) : @explode(".", $_SESSION[$pref['cookie_name']]));
	
	if($uid > 0){
		// They are logged into E107, do a pass comparison
		$query = $e107->DoQuery("SELECT user_name,user_password FROM {$mySQLprefix}user WHERE user_id='$uid'");
		$row = $e107->Do_Fetch_row($query);
		if($upw == md5($row[1])){
			$_COOKIE[$auth_ucookie] = $row[0];
			$_COOKIE[$auth_pcookie] = $row[1];
		}
	}
	
	function auth_encrypt($data){
		return md5($data);
	}
	
	function auth_getpass($auth_ucookie){
		GLOBAL $db,$prefix,$e107,$mySQLprefix,$g_default_settings,$txt,$x7c;
		$query = $e107->DoQuery("SELECT user_password FROM {$mySQLprefix}user WHERE user_name='$_COOKIE[$auth_ucookie]'");
		$password = $e107->Do_Fetch_Row($query);
		
		if($password[0] != ""){	
			$query = $db->DoQuery("SELECT * FROM {$prefix}users WHERE username='$_COOKIE[$auth_ucookie]'");
			$row = $db->Do_Fetch_Row($query);
			if($row[0] == ""){
				// Create an X7 Chat account for them.
				$time = time();
				$ip = $_SERVER['REMOTE_ADDR'];
				$db->DoQuery("INSERT INTO {$prefix}users (id,username,password,status,user_group,time,settings,hideemail,ip) VALUES('0','$_COOKIE[$auth_ucookie]','$password[0]','$txt[150]','{$x7c->settings['usergroup_default']}','$time','{$g_default_settings}','0','$ip')");
			}
		}
		
		return $password[0];
	}
	
	function change_pass($user,$newpass){
		GLOBAL $e107,$mySQLprefix;
		$newpass = auth_encrypt($newpass);
		$e107->DoQuery("UPDATE {$mySQLprefix}user SET user_password='$newpass' WHERE user_name='$user'");
	}
	

?>
