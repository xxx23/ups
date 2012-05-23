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

	// This file handles all, I mean most, things room related
	
	// This function returns a list of all rooms
	function list_rooms(){
		global $db,$prefix;
		
		// Get the rooms from the database
		$return = array();
		$query = $db->DoQuery("SELECT name,topic,password,maxusers,logged FROM {$prefix}rooms WHERE type='1'");
		while($row = $db->Do_Fetch_Row($query)){
			$return[] = $row;
		}
		return $return;
	}
	
	// This function creates a new room
	function create_room($uid,$name,$type,$moded,$topic,$greet,$pass,$max,$exp){
		global $prefix, $db;
		if($exp != 1)
			$time = time();
		else
			$time = 0;
		$ops = "$uid";
		$voice = "$uid";
		$db->DoQuery("INSERT INTO {$prefix}rooms VALUES('0','$name','$type','$moded','$topic','$greet','$pass','$max','$time','$ops','$voice','0','','')");
		return 1;
	}
	
	// Takes an array with the following values in this order:
	// type, moderated, topic, greeting, password, max users, background image, logo image
	function mass_change_roomsettings($room,$new_settings){
		global $prefix, $db;
		$db->DoQuery("UPDATE {$prefix}rooms SET type='$new_settings[0]',moderated='$new_settings[1]',topic='$new_settings[2]',greeting='$new_settings[3]',password='$new_settings[4]',maxusers='$new_settings[5]',background='$new_settings[6]',logo='$new_settings[7]' WHERE name='$room'");
	}
	
	// Changes a single setting (used mostly for IRC cmds I think)
	function change_roomsetting($room,$setting,$new_setting){
		global $prefix, $db;
		$db->DoQuery("UPDATE {$prefix}rooms SET $setting='$new_setting' WHERE name='$room'");
	}

?> 
