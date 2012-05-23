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
	// This file handles bandwidht logging and stuff along that line
	
	// This function is called when a user registered to create a row for them 
	function bw_first_time($user){
		global $x7c,$db,$prefix;
		
		// See what the current day/month is and which to use (day or month)
		if($x7c->settings['default_bandwidth_type'] == 1)
			// use day
			$cur = mktime(0,0,0,date("m"),date("d"),date("Y"));
		else
			// use month
			$cur = mktime(0,0,0,date("m"),0,date("Y"));
		
		// Insert into DB
		$db->DoQuery("INSERT INTO {$prefix}bandwidth VALUES('0','$user','0','-1','$cur')");
	}
	
	// This function is used to update expired rows, they are not deleted simply reset to today
	function bw_cleanup(){
		global $x7c, $db, $prefix;
		
		// See what the expiration day/month is and which to use (day or month)
		if($x7c->settings['default_bandwidth_type'] == 1)
			// use day
			$exp = mktime(0,0,0,date("m"),date("d"),date("Y"));
		else
			// use month
			$exp = mktime(0,0,0,date("m"),0,date("Y"));
			
		$db->DoQuery("UPDATE {$prefix}bandwidth SET used='0',current='$exp' WHERE current<'$exp'");
	}
	
	// This function logs bandwidth
	function log_bw($used){
		global $db, $prefix, $x7s;
		$db->DoQuery("UPDATE {$prefix}bandwidth SET used=used+$used WHERE user='$x7s->username'");
	}
	
	// This function gets the current amount of bandwidth used by the user
	// it will return true if the user is over the limit, otherwise it will return false
	function check_bandwidth($user){
		global $x7s, $db, $prefix, $x7c;
		
		// First cleanup old stuff
		bw_cleanup();
		$query = $db->DoQuery("SELECT used,max FROM {$prefix}bandwidth WHERE user='$x7s->username'");
		$row = $db->Do_Fetch_Row($query);
		
		// See if the limit is set to default and if so correct that value
		if($row[1] == "-1")
			$row[1] = $x7c->settings['max_default_bandwidth'];
		
		// Test it and make sure it isn't 0 (unlimited) for the max
		if($row[0] > $row[1] && $row[1] != 0)
			return true;
		else
			return false;
	}
?>
