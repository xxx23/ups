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

	// For some odd reason I decided to define this here:
	$g_default_settings = "default;default;{$x7c->settings['cookie_time']};default;default;default;0;0;0;0;5000;default;default;0;0";

	// This class handles authentication
	class session {
		var $loggedin;		// 1 if logged in, 0 if not, 2 if incorrect password
		var $username;		// Holds the person's official username
		
		// Create a new session
		function session(){
			global $X7CHAT_CONFIG,$db,$auth_ucookie,$auth_pcookie,$ACTIVATION_ERROR;
			
			// Set username to null by default
			$this->username = "";
			
			if(@$_COOKIE[$auth_ucookie] != "" && @$_COOKIE[$auth_pcookie] != "" ){
			
				// The user has a cookie set for username
				if($_COOKIE[$auth_pcookie] == auth_getpass($auth_ucookie)){
					$this->loggedin = 1;
					$this->username = $_COOKIE[$auth_ucookie];
				}else{
					$this->loggedin = 2;
				}
				
				if(isset($ACTIVATION_ERROR))
					$this->loggedin = 4;
					
			}else{
				// This user is NOT logged in
				$this->loggedin = 0;
			}
		}
		
		function dologin(){
			global $X7CHAT_CONFIG,$db,$auth_ucookie,$auth_pcookie,$x7c,$x7s,$prefix,$g_default_settings,$remove_old_guest_logs,$txt,$ACTIVATION_ERROR;
			
			// The AuthMod file has already been included above
			
			// Put test values into the cookie
			$_COOKIE["$auth_ucookie"] = $_POST['username'];
			$_POST['password'] = auth_encrypt($_POST['password']);
			$_COOKIE["$auth_pcookie"] = $_POST['password'];
			
			// A temporary sessions to check password
			$temp = new session();
			
			if($temp->loggedin == 1){
				$un = parse_outgoing($_POST['username']);
				$pw = parse_outgoing($_POST['password']);
				setcookie($auth_ucookie,$un,time()+$x7c->settings['cookie_time'],$X7CHAT_CONFIG['COOKIE_PATH']);
				setcookie($auth_pcookie,$pw,time()+$x7c->settings['cookie_time'],$X7CHAT_CONFIG['COOKIE_PATH']);
				$x7s->loggedin = 1;
				$this->username = $_COOKIE[$auth_ucookie];
				return 1;
			}else{
			
				if($x7c->settings['allow_guests'] == 1){
					$query = $db->DoQuery("SELECT * FROM {$prefix}users WHERE username='$_POST[username]'");
					$row = $db->Do_Fetch_Row($query);
					if($row[0] == ""){
					
						// Make sure username is valid
						if(eregi("\.|'|,|;| ",$_POST['username']) || (strlen($_POST['username']) > $x7c->settings['maxchars_username'] && $x7c->settings['maxchars_username'] != 0)){
							$x7s->loggedin = 3;
							return 0;
						}
							
						// User may enter as a guest with this username
						$time = time();
						$ip = $_SERVER['REMOTE_ADDR'];
						$db->DoQuery("INSERT INTO {$prefix}users (id,username,password,status,user_group,time,settings,hideemail,ip,activated) VALUES('0','$_POST[username]','$_POST[password]','$txt[150]','{$x7c->settings['usergroup_guest']}','$time','{$g_default_settings}','0','$ip','1')");
						
						// Remove old logs
						$remove_old_guest_logs = 1;
						
						// Give them nice cookies with chocolate chips
						$un = parse_outgoing($_POST['username']);
						$pw = parse_outgoing($_POST['password']);
						setcookie($auth_ucookie,$un,time()+$x7c->settings['cookie_time'],$X7CHAT_CONFIG['COOKIE_PATH']);
						setcookie($auth_pcookie,$pw,time()+$x7c->settings['cookie_time'],$X7CHAT_CONFIG['COOKIE_PATH']);
						$x7s->loggedin = 1;
						$this->username = $_COOKIE[$auth_ucookie];
						return 1;
					}
				}
				
				if(!isset($ACTIVATION_ERROR)){
					$x7s->loggedin = 2;
					setcookie($auth_ucookie,"",time()-$x7c->settings['cookie_time']-63000000,$X7CHAT_CONFIG['COOKIE_PATH']);
					setcookie($auth_pcookie,"",time()-$x7c->settings['cookie_time']-63000000,$X7CHAT_CONFIG['COOKIE_PATH']);
					return 0;
				}else{
					$x7s->loggedin = 4;
					return 0;
				}
			
			
			}
			
		}
	
	}

?>
