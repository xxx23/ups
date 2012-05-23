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
/////////////////////////////////////////////////////////////// 
//
//		X7 Chat Version 2.0.0
//		Released July 27, 2005
//		Copyright (c) 2004-2005 By the X7 Group
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
	// The original vB authmod was made by Johannes Biermann johannes.biermann@teccentral.de
	// This copy was modified to work with X7 Chat Version 2

	// This file holds data on authentication
	$auth_ucookie = "X7C2U";
	$auth_pcookie = "X7C2P";
	$auth_register_link = "../register.php";
	$auth_disable_guest = false;
	
	require_once("../includes/config.php");
	// found vBulletin 3.5
	if (!empty($config))
	{
		$servername =& $config['MasterServer']['servername'];
		$dbusername =& $config['MasterServer']['username'];
		$dbpassword =& $config['MasterServer']['password'];
		$dbname =& $config['Database']['dbname'];
		$tableprefix =& $config['Database']['tableprefix'];
		$cookieprefix =& $config['Misc']['cookieprefix'];
	}
	// This is the license number for you vB. You can find it in your docmunents
	// or in every vB file at the top or bottom
	// It works still if it is empty but the password in the cookie is NOT checked
	// if it is valid!
	$license_nr = '';
	
	$vbc = new x7chat_db($servername,$dbusername,$dbpassword,$dbname);
	
	if (isset ($_COOKIE[$cookieprefix.'userid']) && isset($_COOKIE[$cookieprefix.'password'])) {
		
		$result = $vbc->DoQuery("SELECT userid, username, usergroupid, password, salt FROM {$tableprefix}user WHERE userid='".intval($_COOKIE[$cookieprefix.'userid'])."'");
		$member = $vbc->Do_Fetch_Row($result);

		// Check to make a better check ...
		if ($license_nr != '') {
			// Check if the pass from the cookie is valid
		if (md5($member[5] . $license_nr) == $_COOKIE[$cookieprefix.'password']) {
			# OK Pass/Userid exists
				@setcookie("$auth_ucookie",$member[1],time()+140000,"/");
				@setcookie("$auth_pcookie",$member[3],time()+140000,"/");
				$_COOKIE[$auth_ucookie] = $member[1];
				$_COOKIE[$auth_pcookie] = $member[3];
				$vb_salt = $member[4];
		}
	// Simple check ..
		}else{
			# OK Userid exists
				@setcookie("$auth_ucookie",$member[1],time()+140000,"/");
				@setcookie("$auth_pcookie",$member[3],time()+140000,"/");
				$_COOKIE[$auth_ucookie] = $member[1];
				$_COOKIE[$auth_pcookie] = $member[3];
				$vb_salt = $member[4];
		}
	
	}
	
	function vb_init($username){
		global $vbc, $tableprefix;
		$result = $vbc->DoQuery("SELECT salt FROM {$tableprefix}user WHERE username='".addslashes(htmlspecialchars($username))."'");
		$member = $vbc->Do_Fetch_Row($result);
		return $member[0];
	}
	
	function auth_encrypt($data){
		global $vb_salt,$auth_ucookie;
		if ($vb_salt == "")
			$vb_salt = vb_init($_COOKIE[$auth_ucookie]);
		$password_md5 = md5 (md5($data) . $vb_salt);
		return $password_md5;
	}
	
	function auth_getpass($auth_ucookie){
		GLOBAL $prefix,$db,$vbc,$tableprefix,$txt,$x7c,$g_default_settings;
		$q = $vbc->DoQuery("SELECT password, usergroupid FROM {$tableprefix}user WHERE username='".addslashes($_COOKIE[$auth_ucookie])."'");
		$password = $vbc->Do_Fetch_Row($q);
		if($password[0] != ""){
			$query = $db->DoQuery("SELECT * FROM {$prefix}users WHERE username='".addslashes($_COOKIE[$auth_ucookie])."'");
			$row = $db->Do_Fetch_Row($query);
			if($row[0] == ""){
				// Create an X7 Chat account for them.
				$time = time();
				$ip = $_SERVER['REMOTE_ADDR'];
				$db->DoQuery("INSERT INTO {$prefix}users (id,username,password,status,user_group,time,settings,hideemail,ip) VALUES('0','".addslashes($_COOKIE[$auth_ucookie])."','$password[0]','$txt[150]','{$x7c->settings['usergroup_default']}','$time','{$g_default_settings}','0','$ip')");
			}
		}
		return $password[0];
	}
	
	function change_pass($user,$newpass){
		GLOBAL $vbc,$tableprefix;
		$newpass = auth_encrypt($newpass);
		$vbc->DoQuery("UPDATE {$tableprefix}user SET password='$newpass' WHERE username='$user'");
	}
?>
