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
	// Invision 1.3.1 Final

	// This file holds data on authentication
	$auth_ucookie = "X7C2U";
	$auth_pcookie = "X7C2P";
	$auth_register_link = "../index.php?act=Reg&code=00";
	$auth_disable_guest = true;
	
	// Get the IB configuration file
	include("../conf_global.php");
	
	// Create IB database connection
	$ibdb = new x7chat_db($INFO['sql_host'],$INFO['sql_user'],$INFO['sql_pass'],$INFO['sql_database']);
	
	// Handle Invision login data conversion
	if(@$_COOKIE['member_id'] != "" && @$_COOKIE['member_id'] != 0){
		$q = $ibdb->DoQuery("SELECT name FROM {$INFO['sql_tbl_prefix']}members WHERE id='$_COOKIE[member_id]'");
		$row = $ibdb->Do_Fetch_Row($q);
		$_COOKIE[$auth_ucookie] = $row[0];
		$_COOKIE[$auth_pcookie] = @$_COOKIE['pass_hash'];
	}
	
	function auth_encrypt($data){
		return md5($data);
	}
	
	function auth_getpass($auth_ucookie){
		GLOBAL $ibdb,$INFO,$db,$prefix,$g_default_settings,$x7c,$txt;
		$query = $ibdb->DoQuery("SELECT password FROM {$INFO['sql_tbl_prefix']}members WHERE name='$_COOKIE[$auth_ucookie]'");
		$password = $ibdb->Do_Fetch_Row($query);
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
		GLOBAL $ibdb,$INFO;
		$newpass = auth_encrypt($newpass);
		$query = $ibdb->DoQuery("UPDATE {$INFO['sql_tbl_prefix']}members SET password='$newpass' WHERE name='$user'");
	}
	

?>
