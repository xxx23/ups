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
	// If you are looking for help you've come to the wrong place.  This isn't a help file.
	
	// First we need to set up a nice environment
	error_reporting(E_ALL);
	set_magic_quotes_runtime(0);

	// Import the configuration file
	include("./config.php");
	
	// Import the database library
	include("./lib/db/".strtolower($X7CHAT_CONFIG['DB_TYPE']).".php");
	
	// Create a new database connection
	$db = new x7chat_db();
	
	// Check if a support person is online or not
	$query = $db->DoQuery("SELECT variable,setting FROM {$prefix}settings WHERE variable='support_personel' OR variable='support_image_online' OR variable='support_image_offline' OR variable='support_message' OR variable='default_lang'");
	while($row = $db->Do_Fetch_Row($query)){
		$settings[$row[0]] = $row[1];
	}
	$personel = explode(";",$settings['support_personel']);
	
	$queryx = "name=''";
	foreach($personel as $key=>$val){
		$queryx .= " OR name='$val'";
	}
	
		
	// Include the language file
	include("./lang/$settings[default_lang].php");
	
	$exp_time = time()-30;
	$query = $db->DoQuery("SELECT name FROM {$prefix}online WHERE room='support;' AND ($queryx) AND time>'$exp_time'");
	$supporters = array();
	$temp = "";
	while($row = mysql_fetch_row($query)){
		$temp = $row[0];
		$supporters[] = $row[0];
	}
	$row[0] = $temp;
	if($row[0] != ""){
		// Someone Online
		$img = $settings['support_image_online'];
		$online = 1;
	}else{
		// Noone Online
		$img = $settings['support_image_offline'];
		$online = 0;
	}
	
	if(@$_GET['img'] == "1"){
		header("Content-type: image/png");
		include("$img");
	}else{
		if($online){
			// Give them a support window
			$name = "User".rand(0,9).rand(100,999);
			$time = time();
			// Pick who to send it to
			$queryx = "user=''";
			foreach($supporters as $key=>$val){
				$queryx .= " OR user='$val'";
				$sessions[$val] = 0;
			}
			$query = $db->DoQuery("SELECT user FROM {$prefix}messages WHERE $queryx");
			while($row = $db->Do_Fetch_Row($query)){
				if($row[0] != "")
					$sessions[$row[0]]++;
			}
			// Interpret the results
			$sessions = array_flip($sessions);
			sort($sessions);
			$temp = array_keys($sessions);
			$to = $sessions[$temp[0]];
			
			$db->DoQuery("INSERT INTO {$prefix}messages VALUES('0','$name','5','$txt[595]','parsed_body','$to:0','$time')");
			header("Location: ./index.php?act=pm&send_to=$to&username=$name&password=&dologin=1&support=1");
		}else{
			// Tell them support is offline
			echo $settings['support_message'];
		}
	}
?> 
