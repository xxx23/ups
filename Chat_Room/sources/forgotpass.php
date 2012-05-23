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
	// Houstan we have a problem!  Some user has had a memory lapse
	// and forgot their own password!!!!!!  We had better assist them.
	
	function forgot_pass(){
		global $print, $txt, $db, $prefix, $x7c;
		
		if($x7c->settings['enable_passreminder'] == 0){
		
			$body = $txt[261]."<Br><Br><a href=\"index.php\">$txt[77]</a>";
		
		}elseif(isset($_POST['look4']) && isset($_POST['look4type']) && @$_POST['look4'] != ""){
		
			if($_POST['look4type'] == 1){
				// Search by E-mail
			
				$query = $db->DoQuery("SELECT username,email FROM {$prefix}users WHERE email='$_POST[look4]'");
				$row = $db->Do_Fetch_Row($query);
				if($row[0] == ""){
					// They entered an invalid email address
					$body = $txt[259]."<Br><Br><a href=\"index.php\">$txt[77]</a>";
				}else{
					// Send their password
					$body = $txt[258]."<Br><Br><a href=\"index.php\">$txt[77]</a>";
					snd_reminder($row[0],$row[1]);
				}
			
			}else{
				// Search by Username
			
				$query = $db->DoQuery("SELECT username,email FROM {$prefix}users WHERE username='$_POST[look4]'");
				$row = $db->Do_Fetch_Row($query);
				if($row[0] == ""){
					// They entered an invalid username
					$body = $txt[259]."<Br><Br><a href=\"index.php\">$txt[77]</a>";
				}else{
				
					// Check to see if email is empty
					if($row[1] == ""){
						$body = $txt[260]."<Br><Br><a href=\"index.php\">$txt[77]</a>";
					}else{
						// Send their password
						$body = $txt[258]."<Br><Br><a href=\"index.php\">$txt[77]</a>";
						snd_reminder($row[0],$row[1]);
					}
				
				}
			
			}
		
		}else{
			$body = $txt[257]."<Br><Br><div align=\"center\">
			<form action=\"./index.php?act=forgotmoipass\" method=\"post\">
				<select name=\"look4type\" class=\"text_input\">
					<option value=\"1\">$txt[20]</option>
					<option value=\"2\">$txt[2]</option>
				</select>
				<input type=\"text\" name=\"look4\" class=\"text_input\">
				<input type=\"submit\" value=\"$txt[5]\" class=\"button\">
			</form></div>
			";
		
		}
	
		$print->normal_window($txt[5],$body);
	}
	
	function snd_reminder($user,$email){
		global $x7c, $txt;
		
		// Generate a new password
		$values = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
		$length = rand(5,8);
		$new_password = "";
		while($length > 0){
			$rand = rand(0,61);
			$new_password .= $values[$rand];
			$length--;
		}
		
		// Change the pass in the DB
		change_pass($user,$new_password);
		
		// Send the reminder
		$txt[256] = eregi_replace("_i",getenv("REMOTE_ADDR"),$txt[256]);
		$txt[256] = eregi_replace("_u",$user,$txt[256]);
		$txt[256] = eregi_replace("_s",$x7c->settings['site_name'],$txt[256]);
		$txt[256] = eregi_replace("_p",$new_password,$txt[256]);
		mail($email,$txt[255],$txt[256],"From: {$x7c->settings['site_name']} <{$x7c->settings['admin_email']}>\r\n" ."Reply-To: {$x7c->settings['admin_email']}\r\n" ."X-Mailer: PHP/" . phpversion());
	}

?> 
