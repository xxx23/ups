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
	// PHPBB 2.0.11

	// This file holds data on authentication
	$auth_ucookie = "X7C2U";
	$auth_pcookie = "X7C2P";
	$auth_register_link = "../profile.php?mode=register";
	$auth_disable_guest = true;
	
	// Get the PhpBB2 Configuration File
	include("../config.php");
	
	// Make a database connection to the PhpBB2 database
	$phpbbdb = new x7chat_db($dbhost,$dbuser,$dbpasswd,$dbname);
	
	// Check for existing functions
	$query = $phpbbdb->DoQuery("SELECT config_value FROM {$table_prefix}config WHERE config_name='cookie_name'");
	$cname = $phpbbdb->Do_Fetch_Row($query);
	if(isset($_COOKIE["$cname[0]_sid"])){
		$cvalue = $_COOKIE["$cname[0]_sid"];
		$query = $phpbbdb->DoQuery("SELECT session_user_id,session_logged_in FROM {$table_prefix}sessions WHERE session_id='$cvalue'");
		$cinfo = $phpbbdb->Do_Fetch_Row($query);
		// Check if user exists on PhpBB Board
		if($cinfo[0] != ""){
			$suid = $cinfo[0];
			// Check if they are logged in
			if($cinfo[1] == 1){
				$query = $phpbbdb->DoQuery("SELECT username,user_password FROM {$table_prefix}users WHERE user_id='$suid'");
				$phpbbname = $phpbbdb->Do_Fetch_Row($query);
				@setcookie($auth_ucookie,$phpbbname[0],time()+$x7c->settings['cookie_time'],$X7CHAT_CONFIG['COOKIE_PATH']);
				@setcookie($auth_pcookie,$phpbbname[1],time()+$x7c->settings['cookie_time'],$X7CHAT_CONFIG['COOKIE_PATH']);
				$_COOKIE[$auth_ucookie] = $phpbbname[0];
				$_COOKIE[$auth_pcookie] = $phpbbname[1];
			}
		}
	}
	
	function auth_encrypt($data){
		return md5($data);
	}
	
	function auth_getpass($auth_ucookie){
		GLOBAL $phpbbdb,$table_prefix,$prefix,$txt,$db,$g_default_settings,$prefix,$x7c;
		$query = $phpbbdb->DoQuery("SELECT user_password FROM {$table_prefix}users WHERE username='$_COOKIE[$auth_ucookie]'");
		$password = $phpbbdb->Do_Fetch_Row($query);
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
		GLOBAL $table_prefix,$phpbbdb;
		$newpass = auth_encrypt($newpass);
		$query = $phpbbdb->DoQuery("UPDATE {$table_prefix}users SET user_password='$newpass' WHERE username='$user'");
	}
	

?>
