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
	// Handle password protected rooms

	// checks the room for a password and checks password correctness
	// 0 = no password
	// 1 = correct password
	// 2 = incorrect password
	//
	function check_password($room,$password){
		global $prefix, $db, $x7c;
		$row[0] = $x7c->room_data['password'];
		
		// See is there is a password
		if($row[0] == "")
			return 0;
			
		// Check user's password
		if($row[0] == $password){
			// Correct
			return 1;
		}else{
			// Incorrect
			return 2;
		}
	}
	
	// Print the login screen to enter the password for a room
	function roomlogin_screen($room){
		global $db, $prefix, $txt, $print;
		
		$body = "<div align=\"center\">
					<form action=\"index.php?act=frame&room=$room\" method=\"post\" name=\"roomloginform\">
					$txt[3]: <input type=\"password\" class=\"text_input\" name=\"room_pw\"> 
					<input type=\"submit\" class=\"button\" value=\"$txt[4]\"><Br><Br>
					<a href=\"./index.php\">[$txt[77]]</a>
					</form></div>
				";
		
		$print->normal_window($txt[78],"<div align=\"center\">$txt[79]</div><Br>$body");
	}

?>
