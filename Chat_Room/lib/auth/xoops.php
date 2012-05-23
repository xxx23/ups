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
	// Xoops

	// This file holds data on authentication
	$auth_ucookie = "X7C2U";
	$auth_pcookie = "X7C2P";
	$auth_register_link = "../register.php";
	$auth_disable_guest = true;
	
	// Get the Xoops config file
	$xoopsOption['nocommon'] = 1;
	require("../../mainfile.php");
	
	// Make a database connection to the PhpBB2 database
	$xoopsdb = new x7chat_db(XOOPS_DB_HOST,XOOPS_DB_USER,XOOPS_DB_PASS,XOOPS_DB_NAME);
	$table_prefix = XOOPS_DB_PREFIX."_";
	
	if(isset($_COOKIE["PHPSESSID"])){
		$cvalue = $_COOKIE["PHPSESSID"];
		$q = $xoopsdb->DoQuery("SELECT sess_data FROM {$table_prefix}session WHERE sess_id='$cvalue'");
		
		$cinfo = $xoopsdb->Do_Fetch_Row($q);
		if($cinfo[0] != ""){
			// Get user ID
			eregi("^xoopsUserId|[^;]*",$cinfo[0],$match);
			$match[0] = eregi_replace("xoopsUserID\|","",$match[0]);
			$suid = unserialize($match[0]);
			
			$q = $xoopsdb->DoQuery("SELECT uname,pass FROM {$table_prefix}users WHERE uid='$suid'");
			$xoopsname = $xoopsdb->Do_Fetch_Row($q);
			$_COOKIE['X7C2U'] = $xoopsname[0];
			$_COOKIE['X7C2P'] = $xoopsname[1];
		}
	}
	
	function auth_encrypt($data){
		return md5($data);
	}
	
	function auth_getpass($auth_ucookie){
		GLOBAL $xoopsdb,$table_prefix,$txt,$db,$g_default_settings,$prefix,$x7c;
		$query = $xoopsdb->DoQuery("SELECT pass FROM {$table_prefix}users WHERE uname='$_COOKIE[$auth_ucookie]'");
		$password = $xoopsdb->Do_Fetch_Row($query);
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
		GLOBAL $table_prefix,$xoopsdb;
		$newpass = auth_encrypt($newpass);
		$query = $xoopsdb->DoQuery("UPDATE {$table_prefix}users SET pass='$newpass' WHERE uname='$user'");
	}
	

?>
