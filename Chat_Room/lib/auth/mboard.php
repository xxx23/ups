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
	// MercuryBoard 1.1.2

	// This file holds data on authentication
	$auth_ucookie = "X7C2U";
	$auth_pcookie = "X7C2P";
	$auth_register_link = "../index.php?a=register";
	$auth_disable_guest = true;
	
	// Get the MB configuration file
	include("../settings.php");
	
	// Create MB database connection
	$mbdb = new x7chat_db($set['db_host'],$set['db_user'],$set['db_pass'],$set['db_name']);
	$tablepre = $set['prefix'];
	
	// Get cookie name
	$query = $mbdb->DoQuery("SELECT * FROM {$tablepre}settings");
	$row = mysql_fetch_row($query);
	$mcboard_settings = unserialize($row[1]);
	
	// See if they are logged in already
	if(isset($_COOKIE[$mcboard_settings['cookie_prefix']."user"])){
		$query = $mbdb->DoQuery("SELECT user_name FROM {$tablepre}users WHERE user_id='".$_COOKIE[$mcboard_settings['cookie_prefix']."user"]."'");
		$row = $mbdb->Do_Fetch_Row($query);
		if($row[0] != ""){
			$_COOKIE[$auth_ucookie] = $row[0];
			$_COOKIE[$auth_pcookie] = $_COOKIE[$mcboard_settings['cookie_prefix']."pass"];
		}
	}
	
	function auth_encrypt($data){
		$data = str_replace('$', '', $data);
		return md5($data);
	}
	
	function auth_getpass($auth_ucookie){
		GLOBAL $mbdb,$tablepre,$db,$prefix,$g_default_settings,$x7c,$txt;
		$user = eregi_replace(" ","",$_COOKIE[$auth_ucookie]);
		$query = $mbdb->DoQuery("SELECT user_password FROM {$tablepre}users WHERE user_name='$user'");
		$password = $mbdb->Do_Fetch_Row($query);
		// Make sure they have an X7 Chat account
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
		GLOBAL $mbdb,$tablepre;
		$newpass = auth_encrypt($newpass);
		$user = eregi_replace(" ","",$user);
		$query = $mbdb->DoQuery("UPDATE {$tablepre}users SET user_password='$newpass' WHERE user_name='$user'");
		echo mysql_error();
	}
	

?>
