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
	// Mambo 4.5.2

	// This file holds data on authentication
	$auth_ucookie = "X7C2U";
	$auth_pcookie = "X7C2P";
	$auth_register_link = "../index.php?option=com_registration&task=register";
	$auth_disable_guest = true;
	
	// Get the mambo Configuration File
	include("../configuration.php");
	
	// Make a database connection to the PhpBB2 database
	$mamdb = new x7chat_db($mosConfig_host,$mosConfig_user,$mosConfig_password,$mosConfig_db);
	
	// Introduced in Version 2.0.1 for Joomla Support
	//$session_cookie_name = "sessioncookie";
	$session_cookie_name = md5("site".$mosConfig_live_site);
	
	// Check for existing sessions
	if(isset($_COOKIE[$session_cookie_name])){
		$_COOKIE[$session_cookie_name] = md5($_COOKIE[$session_cookie_name].$_SERVER['REMOTE_ADDR']);
		$query = $mamdb->DoQuery("SELECT userid FROM {$mosConfig_dbprefix}session WHERE session_id='{$_COOKIE[$session_cookie_name]}'");
		$row = $mamdb->Do_Fetch_Row($query);
		if($row[0] != 0){
			$query = $mamdb->DoQuery("SELECT username,password FROM {$mosConfig_dbprefix}users WHERE id='$row[0]'");
			$row = $mamdb->Do_Fetch_Row($query);
			$_COOKIE[$auth_ucookie] = $row[0];
			$_COOKIE[$auth_pcookie] = $row[1];
		}
	}
	
	function auth_encrypt($data){
		return md5($data);
	}
	
	function auth_getpass($auth_ucookie){
		GLOBAL $mamdb,$mosConfig_dbprefix,$txt,$db,$g_default_settings,$prefix,$x7c;
		$query = $mamdb->DoQuery("SELECT password FROM {$mosConfig_dbprefix}users WHERE username='$_COOKIE[$auth_ucookie]'");
		$password = $mamdb->Do_Fetch_Row($query);
		// Check if they have an X7 Chat account
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
		GLOBAL $mosConfig_dbprefix,$mamdb;
		$newpass = auth_encrypt($newpass);
		$query = $mamdb->DoQuery("UPDATE {$mosConfig_dbprefix}users SET password='$newpass' WHERE username='$user'");
	}
	

?>
