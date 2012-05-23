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
	// The original PostNuke AuthMod file was developed by Richard Virtue
	// Parts of the original file were used in the programming of this file.
	// PostNuke 0.750

	// This file holds data on authentication
	$auth_ucookie = "X7C2U";
	$auth_pcookie = "X7C2P";
	$auth_register_link = "../user.php?op=check_age&module=NS-NewUser";
	$auth_disable_guest = true;
	
	// Get the PostNuke Configuration File
	// For some reason PostNuke still uses a damned deprecated extract statement which fucks up our prefix variable
	$save_the_prefixs = $prefix;
	include("../config.php");
	$pn_prefix = $pnconfig['prefix']."_";
	$prefix = $save_the_prefixs;
	
	// Test for encoded values
	if($pnconfig['encoded'] == 1){
		$pnconfig['dbuname'] = base64_decode($pnconfig['dbuname']);
		$pnconfig['dbpass'] = base64_decode($pnconfig['dbpass']);
	}
	// Make a database connection to the PhpBB2 database
	$nukedb = new x7chat_db($pnconfig['dbhost'],$pnconfig['dbuname'],$pnconfig['dbpass'],$pnconfig['dbname']);
	
	if(isset($_COOKIE["POSTNUKESID"])){
		$cvalue = $_COOKIE["POSTNUKESID"];
		$q = $nukedb->DoQuery("SELECT pn_uid FROM {$pn_prefix}session_info WHERE pn_sessid='$cvalue'");
		$suid = $nukedb->Do_Fetch_Row($q);
		$q = $nukedb->DoQuery("SELECT pn_uname,pn_pass FROM {$pn_prefix}users WHERE pn_uid='$suid[0]'");
		$pnukename = $nukedb->Do_Fetch_Row($q);
		if($pnukename[0] != ""){
			$_COOKIE['X7C2U'] = $pnukename[0];
			$_COOKIE['X7C2P'] = $pnukename[1];
		}
	}
		
	function auth_encrypt($data){
		return md5($data);
	}
	
	function auth_getpass($auth_ucookie){
		GLOBAL $nukedb,$pn_prefix,$txt,$db,$g_default_settings,$prefix,$x7c;
		$query = $nukedb->DoQuery("SELECT pn_pass FROM {$pn_prefix}users WHERE pn_uname='$_COOKIE[$auth_ucookie]'");
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
		GLOBAL $nukedb,$pn_prefix;
		$newpass = auth_encrypt($newpass);
		$query = $nukedb->DoQuery("UPDATE {$pn_prefix}users SET pn_pass='$newpass' WHERE pn_uname='$user'");
	}
	

?>
