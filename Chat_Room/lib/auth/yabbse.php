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
	// YabbSE 1.5.5
	

	// This file holds data on authentication
	$auth_ucookie = "X7C2U";
	$auth_pcookie = "X7C2P";
	$auth_register_link = "../index.php?board=;action=register";
	$auth_disable_guest = true;
	
	// Get the yabbse Configuration File
	include("../Settings.php");
	
	// Make a database connection to the yabbse database
	$yabbsedb = new x7chat_db($db_server,$db_user,$db_passwd,$db_name);
	
	$cookie = @unserialize(stripslashes(eregi_replace("&quot;","\"",$_COOKIE[$cookiename])));
	$yabbse_uc = $cookie[0];
	$yabbse_up = $cookie[1];
	if($yabbse_uc != ""){
		$username = $yabbsedb->DoQuery("SELECT memberName,passwd from {$db_prefix}members WHERE ID_MEMBER='$yabbse_uc'");
		$username = $yabbsedb->Do_Fetch_Row($username);
		$yabbse_uc = $username[0];
		$_COOKIE[$auth_ucookie] = $yabbse_uc;
		$_COOKIE[$auth_pcookie] = $yabbse_up;
	}
	
	function yabben($data, $key){
		if (strlen($key) > 64)
			$key = pack('H*', md5($key));
		$key  = str_pad($key, 64, chr(0x00));
		$k_ipad = $key ^ str_repeat(chr(0x36), 64);
		$k_opad = $key ^ str_repeat(chr(0x5c), 64);
		return md5($k_opad . pack('H*', md5($k_ipad . $data)));
	}
	
	function auth_encrypt($data){
		global $auth_ucookie;
		
		$data = @yabben($data, strtolower($_COOKIE[$auth_ucookie]));
		
		if(isset($_POST['dologin']))
			$data = yabben($data, "ys");
		
		return $data;
	}
	
	function auth_getpass($auth_ucookie){
		GLOBAL $yabbsedb,$db_prefix,$txt,$db,$g_default_settings,$prefix,$x7c;
		$query = $yabbsedb->DoQuery("SELECT passwd FROM {$db_prefix}members WHERE memberName='$_COOKIE[$auth_ucookie]'");
		$password = $yabbsedb->Do_Fetch_Row($query);
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
		return yabben($password[0],"ys");
	}
	
	function change_pass($user,$newpass){
		GLOBAL $db_prefix,$yabbsedb;
		$newpass = auth_encrypt($newpass);
		$query = $yabbsedb->DoQuery("UPDATE {$db_prefix}members SET passwd='$newpass' WHERE memberName='$user'");
	}
	
?>
