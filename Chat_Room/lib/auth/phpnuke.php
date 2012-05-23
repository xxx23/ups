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
	// PhpNuke 7.5

	// This file holds data on authentication
	$auth_ucookie = "X7C2U";
	$auth_pcookie = "X7C2P";
	$auth_register_link = "../modules.php?name=Your_Account&op=new_user";
	$auth_disable_guest = true;
	
	// Get the PhpNuke Configuration File
	// Preserve X7 Chat $prefix variable
	$temp_prefix = $prefix;
	include("../config.php");
	$nuke_prefix = $prefix."_";
	$prefix = $temp_prefix;
	
	// Make a database connection to the PhpBB2 database
	$nukedb = new x7chat_db($dbhost,$dbuname,$dbpass,$dbname);
	
	if(isset($HTTP_COOKIE_VARS['user']) && @$HTTP_COOKIE_VARS['user'] != ""){
		$cookie = $HTTP_COOKIE_VARS['user'];
		$cookie = base64_decode($cookie);
		$cookie = explode(":", $cookie);
		$_COOKIE['X7C2U'] = @$cookie[1];
		$_COOKIE['X7C2P'] = @$cookie[2];
	}
	
	function auth_encrypt($data){
		return md5($data);
	}
	
	function auth_getpass($auth_ucookie){
		GLOBAL $nukedb,$nuke_prefix,$txt,$db,$g_default_settings,$prefix,$x7c;
		$query = $nukedb->DoQuery("SELECT user_password FROM {$nuke_prefix}users WHERE username='$_COOKIE[$auth_ucookie]'");
		$password = $nukedb->Do_Fetch_Row($query);
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
		GLOBAL $nukedb,$nuke_prefix;
		$newpass = auth_encrypt($newpass);
		$query = $nukedb->DoQuery("UPDATE {$nuke_prefix}users SET user_password='$newpass' WHERE username='$user'");
	}
	

?>
