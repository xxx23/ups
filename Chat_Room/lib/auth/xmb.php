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
	// XMB 1.9

	// This file holds data on authentication
	$auth_ucookie = "xmbuser";
	$auth_pcookie = "xmbpw";
	$auth_register_link = "../member.php?action=reg";
	$auth_disable_guest = true;
	
	// Get the XMB configuration file
	include("../config.php");
	
	// Create XMB database connection
	$xmbdb = new x7chat_db($dbhost,$dbuser,$dbpw,$dbname);
	
	function auth_encrypt($data){
		return md5($data);
	}
	
	function auth_getpass($auth_ucookie){
		GLOBAL $xmbdb,$tablepre,$db,$prefix,$g_default_settings,$x7c,$txt;
		$query = $xmbdb->DoQuery("SELECT password FROM {$tablepre}members WHERE username='$_COOKIE[$auth_ucookie]'");
		$password = $xmbdb->Do_Fetch_Row($query);
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
		GLOBAL $xmbdb,$tablepre;
		$newpass = auth_encrypt($newpass);
		$query = $xmbdb->DoQuery("UPDATE {$tablepre}members SET password='$newpass' WHERE username='$user'");
	}
	

?>
