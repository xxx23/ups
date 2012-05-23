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

	// This file has functions that handle statuses
	
	// This functions returns the current status
	function get_status($user){
		global $db, $prefix;
		$query = $db->DoQuery("SELECT status FROM {$prefix}users WHERE username='$user'");
		$row = $db->Do_Fetch_Row($query);
		return $row[0];
	}
	
	// Sets a users status
	function set_status($new_status){
		global $db, $prefix, $x7s, $x7c;
		$new_status = substr($new_status,0,$x7c->settings['maxchars_status']);
		$db->DoQuery("UPDATE {$prefix}users SET status='$new_status' WHERE username='$x7s->username'");
	}

?> 
