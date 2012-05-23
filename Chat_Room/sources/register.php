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

	// Read file name, guess what is handles, you are right
	function register_user(){
		global $x7c, $print, $txt, $db, $prefix, $g_default_settings;
		
		// If admin doesn't want new members then tell them to go away
		if($x7c->settings['allow_reg'] == 0){
			$print->normal_window($txt[14],"$txt[15]");	
			return 0;
		}
		
		// Let's see if they have already filled out the form
		if(isset($_GET['step']) && @$_GET['step'] != "act"){
			// They have already filled out the register form and sent it
			
			// Clean up incoming data
			$_POST['pass1'] = auth_encrypt($_POST['pass1']);
			$_POST['pass2'] = auth_encrypt($_POST['pass2']);
			
			// Check the data they submitted
			if(!eregi("^[^@]*@[^.]*\..*$",$_POST['email']))
				$error = $txt[24];
			if($_POST['pass1'] == "")
				$error = $txt[25];
			if($_POST['pass1'] != $_POST['pass2'])
				$error = $txt[26];
			if($_POST['username'] == "" || eregi("\.|'|,|;| |\"",$_POST['username']) || (strlen($_POST['username']) > $x7c->settings['maxchars_username'] && $x7c->settings['maxchars_username'] != 0)){
				$txt[23] = eregi_replace("_n","{$x7c->settings['maxchars_username']}",$txt[23]);
				$error = $txt[23];
			}
			$query = $db->DoQuery("SELECT * FROM {$prefix}users WHERE username='$_POST[username]'");
			$row = $db->Do_Fetch_Row($query);
			if($row[0] != "")
				$error = $txt[27];
			
			// Did any errors occur?
			if(isset($error)){
				// An error has occured!
				$body = $error."<Br><Br><div align=\"center\"><a style=\"cursor: pointer;cursor:hand;\" onClick=\"javascript: history.back();\">[$txt[77]]</a></div>";
			
			}else{
				// No Problems!  Create their account
				
				// Generate Activation code
				if($x7c->settings['req_activation'] == 1){
					$seed = "abcdefghijklmnoparstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ";
					$act_code = $seed[rand(0,strlen($seed)-1)];
					for($x = 0;$x < 5;$x++){
						$act_code .= $seed[rand(0,strlen($seed)-1)];
					}
				}else{
					$act_code = 1;
				}
				
				$time = time();
				$ip = $_SERVER['REMOTE_ADDR'];
				$settings = $g_default_settings; // This is defined in lib/auth.php
				$db->DoQuery("INSERT INTO {$prefix}users (id,username,password,email,status,user_group,time,settings,hideemail,ip,activated) VALUES('0','$_POST[username]','$_POST[pass1]','$_POST[email]','$txt[150]','{$x7c->settings['usergroup_default']}','$time','$settings','0','$ip','$act_code')");
				
				$URL = eregi_replace("step=1","step=act&act_code=$act_code","http://{$_SERVER["HTTP_HOST"]}{$_SERVER["REQUEST_URI"]}");
				mail($_POST['email'],$txt[618],"$txt[617]\r\n\r\n$URL\r\n","From: {$x7c->settings['site_name']} <{$x7c->settings['admin_email']}>\r\n" ."Reply-To: {$x7c->settings['admin_email']}\r\n" ."X-Mailer: PHP/" . phpversion());

				// Create the bandwidth row for them
				include_once("./lib/bandwidth.php");
				bw_first_time($_POST['username']);
				
				$body = $txt[28];
				
				if($act_code != 1)
					$body .= "<br><br>".$txt[613];
			}
			
		}elseif(@$_GET['step'] == "act"){
		
			$body = activate_account();
				
		}else{
		
			// No, they still need to fill out this form:
			// If we make it here then the admin wants all the user's they can get!
			$body = "	<form action=\"index.php?act=register&step=1\" method=\"post\" name=\"registerform\">
						<table border=\"0\" width=\"400\" cellspacing=\"0\" cellpadding=\"0\">
							<tr valign=\"top\">
								<td width=\"400\" style=\"text-align: center\" colspan=\"4\">$txt[19]<Br><Br></td>
							</tr>
							<tr valign=\"top\">
								<td width=\"50\">&nbsp;</td>
								<td width=\"120\" style=\"vertical-align: middle;\">$txt[2]: </td>
								<td width=\"175\" height=\"25\"><input type=\"text\" class=\"text_input\" name=\"username\"></td>
								<td width=\"50\">&nbsp;</td>
							</tr>
							<tr valign=\"top\">
								<td width=\"50\">&nbsp;</td>
								<td width=\"120\" style=\"vertical-align: middle;\">$txt[3]: </td>
								<td width=\"175\" height=\"25\"><input type=\"password\" class=\"text_input\" name=\"pass1\"></td>
								<td width=\"50\">&nbsp;</td>
							</tr>
							<tr valign=\"top\">
								<td width=\"50\">&nbsp;</td>
								<td width=\"120\" style=\"vertical-align: middle;\">$txt[21]: </td>
								<td width=\"175\" height=\"25\"><input type=\"password\" class=\"text_input\" name=\"pass2\"></td>
								<td width=\"50\">&nbsp;</td>
							</tr>
							<tr valign=\"top\">
								<td width=\"50\">&nbsp;</td>
								<td width=\"120\" style=\"vertical-align: middle;\">$txt[20]: </td>
								<td width=\"175\" height=\"25\"><input type=\"text\" class=\"text_input\" name=\"email\"></td>
								<td width=\"50\">&nbsp;</td>
							</tr>
							<tr valign=\"top\">
								<td width=\"400\" style=\"text-align: center\" colspan=\"4\"><input type=\"submit\" value=\"$txt[18]\" class=\"button\"></td>
							</tr>
						</table>
						</form>
						<div align=\"center\">$txt[22]<Br><Br><a href=\"./index.php\">[$txt[77]]</a></div>
					";
		}
		
		// Save the body to the print buffer
		$print->normal_window($txt[18],$body);	
		return 1;
	}
	
	function activate_account(){
		global $x7c, $print, $txt, $db, $prefix;
		
		// Make sure the activation code exists
		$query = $db->DoQuery("SELECT * FROM {$prefix}users WHERE activated='$_GET[act_code]'");
		$row = $db->Do_Fetch_row($query);
		if($row[0] != ""){
			$db->DoQuery("UPDATE {$prefix}users SET activated='1' WHERE activated='$_GET[act_code]'");
			$body = $txt[614];
		}else{
			$body = $txt[615];
		}
		
		return $body;
	}
?> 
