<?PHP
	// The original SMF AuthMod for version 1 was programmed by Carl C
	// Parts of the original AuthMod were used when converting this to Version 2
	// Borrowed Work: Cookie Handling, Encryption Function
	

	// This file holds data on authentication
	$auth_ucookie = "X7C2U";
	$auth_pcookie = "X7C2P";
	$auth_register_link = "../index.php?action=register";
	$auth_disable_guest = true;
	
	// Get the SMF Configuration File
	include("../Settings.php");
	
	// Make a database connection to the SMF database
	$smfdb = new x7chat_db($db_server,$db_user,$db_passwd,$db_name);
	
	$data = @stripslashes(stripslashes(eregi_replace("&quot;","\"",$_COOKIE[$cookiename])));
	$cookie = unserialize("$data");
	$HTTP_COOKIE_VARS['smf_uc'] = $cookie[0];
	$HTTP_COOKIE_VARS['smf_up'] = $cookie[1];
		
	if($HTTP_COOKIE_VARS['smf_uc'] != ""){
		$password = $smfdb->DoQuery("SELECT memberName,passwd,passwordSalt from {$db_prefix}members WHERE ID_MEMBER='$HTTP_COOKIE_VARS[smf_uc]'");
		$password = $smfdb->Do_Fetch_Row($password);
		$HTTP_COOKIE_VARS['smf_uc'] = $password[0];
		$_COOKIE['X7C2U'] = $HTTP_COOKIE_VARS['smf_uc'];
		$_COOKIE['X7C2P'] = $HTTP_COOKIE_VARS['smf_up'];
		$password_salt = $password[2];
	}
	
	function auth_encrypt($data){
		$enc = sha1(strtolower($_COOKIE['X7C2U']).$data);
				
		if(isset($_POST['dologin']))
			$enc = auth_cookie_encrypt($enc);
		
		return $enc;
	}
	
	function auth_cookie_encrypt($data){
		global $smfdb,$password_salt,$auth_ucookie,$db_prefix;
		if(!isset($password_salt)){
			$password = $smfdb->DoQuery("SELECT passwordSalt from {$db_prefix}members WHERE memberName='$_COOKIE[$auth_ucookie]'");
			$password_salt = $smfdb->Do_Fetch_Row($password);
			$password_salt = $password_salt[0];
		}
		
		return sha1($data . $password_salt);
	}
	
	function auth_getpass($auth_ucookie){
		GLOBAL $smfdb,$db_prefix,$txt,$db,$g_default_settings,$prefix,$x7c,$password_salt;
		$query = $smfdb->DoQuery("SELECT passwd,passwordSalt FROM {$db_prefix}members WHERE memberName='$_COOKIE[$auth_ucookie]'");
		$password = $smfdb->Do_Fetch_Row($query);
		$password_salt = $password[1];
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
		return auth_cookie_encrypt($password[0]);
	}
	
	function change_pass($user,$newpass){
		GLOBAL $db_prefix,$smfdb;
		$newpass = auth_encrypt($newpass,strtolower($user));
		$query = $smfdb->DoQuery("UPDATE {$db_prefix}members SET passwd='$newpass' WHERE memberName='$user'");
	}
	
?>
