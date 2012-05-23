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
	// Invision 2

	// This file holds data on authentication
	$auth_ucookie = "X7C2U";
	$auth_pcookie = "X7C2P";
	$auth_register_link = "../index.php?act=Reg&CODE=00";
	$auth_disable_guest = true;
	
	// Get the IB configuration file
	include("../conf_global.php");
	
	// Create IB database connection
	$ibdb = new x7chat_db($INFO['sql_host'],$INFO['sql_user'],$INFO['sql_pass'],$INFO['sql_database']);
	
	// Handle Invision login data conversion
	if(isset($_COOKIE['member_id']) && @$_COOKIE['member_id'] != 0){
		// Yes they are logged in, do a cookie transfer
		$uid = intval($_COOKIE['member_id']);
		$_COOKIE['X7C2P'] = $_COOKIE['pass_hash'];
		$q = $ibdb->DoQuery("SELECT name,member_login_key FROM {$INFO['sql_tbl_prefix']}members WHERE id='$uid'");
		$row = $ibdb->Do_Fetch_Row($q);
		$_COOKIE['X7C2U'] = $row[0];
		$ib2_member_login_key = $row[1];
	
		// Grab password information
		$query = $ibdb->DoQuery("SELECT converge_pass_salt,converge_pass_hash FROM {$INFO['sql_tbl_prefix']}members_converge WHERE converge_id='$uid'");
		$row = $ibdb->Do_Fetch_Row($query);
		$ib2_salt = $row[0];
		$ib2_pash_hash = $row[1];
		
		if($ib2_member_login_key == $_COOKIE['X7C2P']){
			$_COOKIE['X7C2P'] = $ib2_pash_hash;
		}else{
			$_COOKIE['X7C2U'] = "";
			$_COOKIE['X7C2P'] = "";
		}
		
	}
	
	function auth_encrypt($data){
		global $ib2_salt,$auth_ucookie;
		if($ib2_salt == ""){
			@init_by_username($_COOKIE[$auth_ucookie]);
		}
		$password = md5(md5($ib2_salt).md5($data));
		return $password;
	}
	
	function init_by_username($username){
		global $ibdb,$ib2_salt,$ib2_pash_hash, $INFO, $DATABASE;
		$q = $ibdb->DoQuery("SELECT id FROM {$INFO['sql_tbl_prefix']}members WHERE name='$username'");
		$row = $ibdb->Do_Fetch_Row($q);
		$uid = $row[0];
		$query = $ibdb->DoQuery("SELECT converge_pass_salt,converge_pass_hash FROM {$INFO['sql_tbl_prefix']}members_converge WHERE converge_id='$uid'");
		$row = $ibdb->Do_Fetch_Row($query);
		$ib2_salt = $row[0];
		$ib2_pash_hash = $row[1];
	}
	
	function auth_getpass($auth_ucookie){
		GLOBAL $ibdb,$INFO,$db,$prefix,$g_default_settings,$x7c,$txt,$ib2_pash_hash,$ib2_salt;
		if(@$ib2_pash_hash == ""){
			init_by_username($_COOKIE[$auth_ucookie]);
		}
		// Make sure they have an X7 Chat account
		if($ib2_pash_hash != ""){
			$query = $db->DoQuery("SELECT * FROM {$prefix}users WHERE username='$_COOKIE[$auth_ucookie]'");
			$row = $db->Do_Fetch_Row($query);
			if($row[0] == ""){
				// Create an X7 Chat account for them.
				$time = time();
				$ip = $_SERVER['REMOTE_ADDR'];
				$db->DoQuery("INSERT INTO {$prefix}users (id,username,password,status,user_group,time,settings,hideemail,ip) VALUES('0','$_COOKIE[$auth_ucookie]','','$txt[150]','{$x7c->settings['usergroup_default']}','$time','{$g_default_settings}','0','$ip')");
			}
		}
		return $ib2_pash_hash;
	}
	
	function change_pass($user,$newpass){
		GLOBAL $ibdb,$INFO,$uid;
		$newpass = auth_encrypt($newpass);
		$query = $ibdb->DoQuery("UPDATE {$INFO['sql_tbl_prefix']}members_converge SET converge_pass_hash='$newpass' WHERE converge_id='$uid'");
	}
	

?>
