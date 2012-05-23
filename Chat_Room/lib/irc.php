<?PHP
/////////////////////////////////////////////////////////////// 
//
//		X7 Chat Version 2.0.4.3
//		Released August 28, 2006
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
	// This file controls all of the IRC commands
	// creating a new command is very simple, just add a new functions named
	// irc_yourcommandname and have the code inside.  Each function takes one argument
	// that contains everything after the /cmd that the user says.
	
	// This function determines what function to call
	function parse_irc_command($command,$pm=0){
		global $x7s, $txt;
		
		preg_match("/^\/(.+?) (.+?)$/i",$command,$run);
		// $run[1] is now the command name
		// $run[2] is now the command arguments
		
		// This is a fall-back in case no arguments are given, then we still need to figure out $run[1]
		if($run[1] == ""){
			preg_match("/^\/(.+?)$/i",$command,$run);
			$run[2] = "";
		}
		
		if($pm == 0){
			// This command is NOT being run from a pm window
			if(function_exists("irc_$run[1]")){
				// The function exists, run it now
				call_user_func("irc_$run[1]",$run[2]);
			}else{
				// Error, that function does not exist!
				alert_user($x7s->username,$txt[211]);
			}
		
		}else{
			// This command IS being run from a pm window
			if(function_exists("irc_pm_$run[1]")){
				// The function exists, run it now
				call_user_func("irc_pm_$run[1]",$run[2]);
			}else{
				// Error, that function does not exist!
				alert_private_chat_you($_GET['send_to'],$txt[211]);
			}
			
		}
	
	}
	
	
	
	//////////////////////////////////////
	//			START ACTUAL CMDS		//
	//////////////////////////////////////
	
	//////////////
	////////////// The following commands are for chat rooms
	//////////////
	
	// Roll The Dice
	//	Syntax: /roll <number of dice> <number of sides> <additional math (+.-)>
	function irc_roll($params,$pm=0){
		global $x7s, $txt;
		
		// Split params into values
		$params = explode(" ",$params);
		
		// Get number of dice
		if($params[0] != "" && is_numeric($params[0]))
			$dice_to_roll = $params[0];
		else
			$dice_to_roll = 1;
			
		// Get number of sides
		if($params[1] != "" && is_numeric($params[1])){
			$params[1] = eregi_replace("d","",$params[1]);
			$dice_sides = $params[1];
		}else{
			$dice_sides = 6;
		}
		
		// Get additional Math
		if($params[2] != "" && is_numeric($params[2])){
			if(preg_match("/^\-([0-9]*)/",$params[2],$math)){
				$additional_m = $math[1]*-1;
			}else{
				$additional_m = $params[2];
			}
		}else{
			if($params[3] != "")
				$additional_m = $params[3];
			else
				$additional_m = 0;
		}
		
		// Do the dice rolls
		srand(time()+microtime()/date("s"));
		for($left_to_roll = $dice_to_roll;$left_to_roll > 0;$left_to_roll--){
			$this_rand = rand(1,$dice_sides);
			$results[] = $this_rand+$additional_m;
		}
		
		$txt[212] = eregi_replace("_u",$x7s->username,$txt[212]);
		$txt[212] = eregi_replace("_d","$dice_to_roll",$txt[212]);
		$txt[212] = eregi_replace("_s","$dice_sides",$txt[212]);
		$output = "$txt[212]  ";
		if($additional_m != 0){
			$txt[214] = eregi_replace("_a","$additional_m",$txt[214]);
			$output .= "$txt[214]  ";
		}
		$output .= $txt[213];
		foreach($results as $key=>$val){
			$output .= " $val ";
		}
		
		// Send to user
		if($pm == 0){
			alert_room($_GET['room'],$output);
		}else{
			alert_private_chat($_GET['send_to'],$output);
		}
	}
	
	// Kicks a user, removes the user from chat
	function irc_kick($params){
		global $x7c, $txt, $x7s;
	
		// Get the parameter values
		$user = irc_param_parsefw($params);
		
		// Check syntax
		if(@$user[0] == "" || @$user[1] == ""){
			alert_user($x7s->username,$txt[269]);
			return 0;
		}
		
		// Check permissions
		if($x7c->permissions['room_operator'] == 1){
			// Take appropriate action
			include_once("./lib/usercontrol.php");
			$uc = new user_control($user[0]);
			if($uc->permissions['ban_kick_imm'] != 1 && $x7c->permissions['kick'] == 1)
				$uc->kick($user[1]);
			else
				alert_user($x7s->username,$txt[268]);
		}else{
			// Permission denied
			alert_user($x7s->username,$txt[267]);
		}
	
	}
	
	// Ban Function, bans a user
	function irc_ban($params){
		global $txt, $x7c, $x7s;
		
		// Get the parameter values
		$params = irc_param_parsefw($params);
		
		// Check syntax
		if(@$params[0] == "" || @$params[1] == ""){
			alert_user($x7s->username,$txt[270]);
			return 0;
		}
		
		// Check permissions
		if($x7c->permissions['room_operator'] == 1){
			// Take appropriate action
			include_once("./lib/usercontrol.php");
			$uc = new user_control($params[0]);
			if($uc->permissions['ban_kick_imm'] != 1)
				new_ban($params[0],0,$params[1],$x7c->room_data['id']);
			else
				alert_user($x7s->username,$txt[268]);
		}else{
			// Permission denied
			alert_user($x7s->username,$txt[267]);
		}
	}
	
	// The unban command, removes a ban from a username
	function irc_unban($params){
		global $txt, $x7c, $x7s, $db, $prefix;
		
		// Get the ban ID
		$query = $db->DoQuery("SELECT id FROM {$prefix}banned WHERE room='{$x7c->room_data['id']}' AND user_ip_email='$params'");	
		$banid = $db->Do_Fetch_Row($query); 
		$banid = $banid[0];
		
		// Check syntax
		if($banid == ""){
			alert_user($x7s->username,$txt[271]);
			return 0;
		}
		
		// Check permissions
		if($x7c->permissions['room_operator'] == 1){
			remove_ban($banid,$x7c->room_data['id']);
		}else{
			// Permission denied
			alert_user($x7s->username,$txt[267]);
		}
	}
	
	// The op command gives operator access to a user
	function irc_op($params){
		global $txt, $x7c, $x7s;
		
		// Check syntax
		if($params == ""){
			alert_user($x7s->username,$txt[272]);
			return 0;
		}
		
		// Check permissions
		if($x7c->permissions['room_operator'] == 1){
			include_once("./lib/usercontrol.php");
			$uc = new user_control($params);
			if($uc->permissions['room_operator'] != 1)
				$uc->give_ops();
		}else{
			// Permission denied
			alert_user($x7s->username,$txt[267]);
		}
	}
	
	// The deop command gives operator access to a user
	function irc_deop($params){
		global $txt, $x7c, $x7s;
		
		// Check syntax
		if($params == ""){
			alert_user($x7s->username,$txt[273]);
			return 0;
		}
		
		// Check permissions
		if($x7c->permissions['room_operator'] == 1){
			include_once("./lib/usercontrol.php");
			$uc = new user_control($params);
			if($uc->permissions['AOP_all'] != 1)
				$uc->take_ops();
			else
				alert_user($x7s->username,$txt[268]);
		}else{
			// Permission denied
			alert_user($x7s->username,$txt[267]);
		}
	}
	
	// The mkick function kicks everyone in the room, except u
	function irc_mkick($params){
		global $txt, $x7c, $db, $prefix, $x7s;
		
		// Check parameters
		if($params == ""){
			alert_user($x7s->username,$txt[564]);
			return 0;
		}
		
		if($x7c->permissions['can_mkick'] == 1){
		
			$query = $db->DoQuery("SELECT name FROM {$prefix}online WHERE room='$_GET[room]'");
			while($row = $db->Do_Fetch_Row($query)){
				if($row[0] != $x7s->username)
					irc_kick("$row[0] $params");
			}
		
		}else{
			// Permission Denied
			alert_user($x7s->username,$txt[267]);
		}
	}
	
	// The ignore command blocks all messages from a user
	function irc_ignore($params,$pm=0){
		global $txt, $x7s;
		
		// Check syntax
		if($params == ""){
			if($pm == 0)
				alert_user($x7s->username,$txt[274]);
			else
				alert_private_chat_you($_GET['send_to'],$txt[274]);
			return 0;
		}
		
		include_once("./lib/usercontrol.php");
		$uc = new user_control($params);
		$uc->ignore();
	}
	
	// The unignore command will unblock a blocked user
	function irc_unignore($params,$pm=0){
		global $txt, $x7s;
		
		// Check syntax
		if($params == ""){
			if($pm == 0)
				alert_user($x7s->username,$txt[275]);
			else
				alert_private_chat_you($_GET['send_to'],$txt[275]);
			return 0;
		}
		
		include_once("./lib/usercontrol.php");
		$uc = new user_control($params);
		$uc->unignore();
	}
	
	// Sets a user's status to away
	function irc_away($params){
		global $txt;
		// Accepts no arguments so syntax is always correct :)
		include("./lib/status.php");
		set_status($txt[149]);
	}
	
	// Sets a user's status to available
	function irc_back($params){
		global $txt;
		// Accepts no arguments so syntax is always correct :)
		include("./lib/status.php");
		set_status($txt[150]);
	}
	
	// this command prints the usernames of all the people in the chat room
	function irc_names($params){
		global $txt, $global_u_online, $x7s;
		include_once("./lib/online.php");
		$u_online = implode(", ",get_online($_GET['room']));
		alert_user($x7s->username,$txt[276].$u_online);
	}
	
	// This command makes the user 'do' an action
	function irc_me($params,$pm=0){
		global $x7s, $txt;
		// Make sure they have specified an action to do
		if($params == ""){
			if($pm == 0)
				alert_user($x7s->username,$txt[277]);
			else
				alert_private_chat_you($_GET['send_to'],$txt[277]);
			return 0;
		}
		
		// Send them the output
		if($pm == 0){
			alert_room($_GET['room'],$x7s->username." ".$params);
		}else{
			alert_private_chat($_GET['send_to'],$x7s->username." ".$params);
		}
	}
	
	// Gives administrator access to a person
	function irc_admin($params){
		global $x7c, $x7s, $txt, $db, $prefix;
		
		// Make sure they gave us enough info
		if($params == ""){
			alert_user($x7s->username,$txt[278]);
			return 0;
		}
		
		// Make sure they have correct permissoins
		if($x7c->permissions['make_admins'] == 1){
			// Ok, make this user an admin
			$db->DoQuery("UPDATE {$prefix}users SET user_group='{$x7c->settings['usergroup_admin']}' WHERE username='$params'");
			$txt[279] = eregi_replace("_u",$params,$txt[279]);
			alert_room($_GET['room'],$txt[279]);
		}else{
			// Permission Denied
			alert_user($x7s->username,$txt[267]);
		}
	}
	
	// Takes administrator access from a person
	function irc_deadmin($params){
		global $x7c, $x7s, $txt, $db, $prefix;
		
		// Make sure they gave us enough info
		if($params == ""){
			alert_user($x7s->username,$txt[278]);
			return 0;
		}
		
		// See if they are unadmining themselfs
		if($params == $x7s->username){
			alert_user($x7s->username,$txt[281]);
			return 0;
		}elseif($params == "$x7s->username 1"){
			$params = $x7s->username;
		}
		
		// Make sure they have correct permissoins
		if($x7c->permissions['make_admins'] == 1){
			// Ok, make this user an admin
			$db->DoQuery("UPDATE {$prefix}users SET user_group='{$x7c->settings['usergroup_default']}' WHERE username='$params'");
			$txt[280] = eregi_replace("_u",$params,$txt[280]);
			alert_room($_GET['room'],$txt[280]);
		}else{
			// Permission Denied
			alert_user($x7s->username,$txt[267]);
		}
	}
	
	// Gives someone a voice in a moderated room
	function irc_voice($params){
		global $x7c, $txt, $x7s;
		
		// Check syntax
		if($params == ""){
			alert_user($x7s->username,$txt[282]);
			return 0;
		}
		
		// Check permissions
		if($x7c->permissions['room_operator'] == 1){
			include_once("./lib/usercontrol.php");
			$uc = new user_control($params);
			if($uc->permissions['AV_all'] != 1)
				$uc->voice();
			else
				alert_user($x7s->username,$txt[268]);
		}else{
			// Permission denied
			alert_user($x7s->username,$txt[267]);
		}
	}
	
	// Take someones voice so they can no longer speak in moderated rooms
	function irc_devoice($params){
		global $x7c, $txt, $x7s;
		
		// Check syntax
		if($params == ""){
			alert_user($x7s->username,$txt[283]);
			return 0;
		}
		
		// Check permissions
		if($x7c->permissions['room_operator'] == 1){
			include_once("./lib/usercontrol.php");
			$uc = new user_control($params);
			if($uc->permissions['AV_all'] != 1)
				$uc->unvoice();
			else
				alert_user($x7s->username,$txt[268]);
		}else{
			// Permission denied
			alert_user($x7s->username,$txt[267]);
		}
	}
	
	// Make someone shut the hell up in a non-moderated room
	function irc_mute($params){
		global $x7c, $txt, $x7s;
		
		// Check syntax
		if($params == ""){
			alert_user($x7s->username,$txt[284]);
			return 0;
		}
		
		// Check permissions
		if($x7c->permissions['room_operator'] == 1){
			include_once("./lib/usercontrol.php");
			$uc = new user_control($params);
			if($uc->permissions['AV_all'] != 1)
				$uc->mute();
			else
				alert_user($x7s->username,$txt[268]);
		}else{
			// Permission denied
			alert_user($x7s->username,$txt[267]);
		}
	}
	
	// Allow the user to speak again
	function irc_unmute($params){
		global $x7c, $txt, $x7s;
		
		// Check syntax
		if($params == ""){
			alert_user($x7s->username,$txt[285]);
			return 0;
		}
		
		// Check permissions
		if($x7c->permissions['room_operator'] == 1){
			include_once("./lib/usercontrol.php");
			$uc = new user_control($params);
			$uc->unmute();
		}else{
			// Permission denied
			alert_user($x7s->username,$txt[267]);
		}
	}
	
	// Send a message to all rooms
	function irc_wallchan($params){
		global $x7c, $x7s, $txt;
	
		// Check syntax
		if($params == ""){
			alert_user($x7s->username,$txt[286]);
			return 0;
		}
		
		// Check permissions
		if($x7c->permissions['server_msg'] == 1){
			// Send the message
			send_global_message($params);
		}else{
			// Permision denied
			alert_user($x7s->username,$txt[267]);
		}
	
	}
	
	// This commands job is to open the room control panel
	function irc_roomcp($params){
		global $x7c, $txt, $x7s;
		
		if($x7c->permissions['room_operator'] == 1){
			$txt[287] = eregi_replace("<a>","<a style=\"cursor: hand;cursor: pointer;\" onClick=\"javascript: window.open('index.php?act=roomcp&room=$_GET[room]','','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width={$x7c->settings['tweak_window_large_width']},height={$x7c->settings['tweak_window_large_height']}');\">",$txt[287]);
			alert_user($x7s->username,$txt[287]);
		}else{
			// Permision denied
			alert_user($x7s->username,$txt[267]);
		}
	}
	
	// This commands job is to open the room control panel
	function irc_admincp($params){
		global $x7c, $txt, $x7s;
		
		if($x7c->permissions['admin_access'] == 1){
			$txt[504] = eregi_replace("<a>","<a style=\"cursor: hand;cursor: pointer;\" onClick=\"javascript: window.open('index.php?act=adminpanel','','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width={$x7c->settings['tweak_window_large_width']},height={$x7c->settings['tweak_window_large_height']}');\">",$txt[504]);
			alert_user($x7s->username,$txt[504]);
		}else{
			// Permision denied
			alert_user($x7s->username,$txt[267]);
		}
	}
	
	function irc_help($params,$pm=0){
		global $x7c, $txt, $x7s;
		
		if($pm == 0){
			$txt[503] = eregi_replace("<a>","<a href=\"./help/\" target=\"_blank\">",$txt[503]);
			alert_user($x7s->username,$txt[503]);
		}else{
			$txt[503] = eregi_replace("<a>","<a href=\"./help/\" target=\"_blank\">",$txt[503]);
			alert_private_chat_you($_GET['send_to'],$txt[503]);
		}
	}
	
	function irc_invisible($params){
		global $x7c, $txt, $x7s;
		
		// Check Permissions
		if($x7c->permissions['b_invisible'] != 1){
			alert_user($x7s->username,$txt[507]);
		}else{
			include_once("./lib/online.php");
			invisy_switch($x7c->room_name);
			if($x7c->settings['invisible'] == 1)
				alert_user($x7s->username,$txt[509]);
			else
				alert_user($x7s->username,$txt[508]);
		}
	}
	
	
	// This function allows an op to start, stop or clear the logs
	function irc_log($params){
		global $x7s, $x7c, $txt;
		
		// Check syntax
		$params = strtolower($params);
		if($params == "" || ($params != "start" && $params != "stop" && $params != "clear" && $params != "size")){
			alert_user($x7s->username,$txt[288]);
			return 0;
		}
		
		// Check permissions
		if($x7c->permissions['room_operator'] == 0 || $x7c->permissions['access_room_logs'] == 0){
			// Permission Denied
			alert_user($x7s->username,$txt[267]);
		}else{
			// Do the specified action
			if($params == "stop"){
				include_once("./lib/rooms.php");
				change_roomsetting($_GET['room'],"logged",0);
			}elseif($params == "start"){
				include_once("./lib/rooms.php");
				change_roomsetting($_GET['room'],"logged",1);
			}elseif($params == "clear"){
				include_once("./lib/logs.php");
				$log = new logs(1,$_GET['room']);
				$log->clear();
			}elseif($params == "size"){
				include_once("./lib/logs.php");
				$log = new logs(1,$_GET['room']);
				// Get the size of the log
				$fs1 = round($log->log_size/1024,2);
				// Get the max allowed size
				if($x7c->settings['max_log_room'] == 0)
					$maxlog = $txt[248];
				else
					$maxlog = round($x7c->settings['max_log_room']/1024,2);
				// Tell the user
				$txt[289] = eregi_replace("_s","$fs1",$txt[289]);
				$txt[289] = eregi_replace("_m","$maxlog",$txt[289]);
				alert_user($x7s->username,$txt[289]);
			
			}
		}
	}
	
	// This is the all powerful mode function.  Its used for a billion different thing so this is going to be a long one
	function irc_mode($params){
		global $x7c, $x7s, $txt;
		
		$params = explode(" ",$params);
		$params[0] = strtolower($params[0]);
		
		// Primary syntax check, make sure they have something on the end
		if($params[0] == "" || $params[1] == ""){
			$txt[290] = eregi_replace("<a>","<a style=\"cursor: hand;cursor: pointer;\" onClick=\"javascript: window.open('index.php?act=help&q=irc_mode','','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width={$x7c->settings['tweak_window_small_width']},height={$x7c->settings['tweak_window_small_height']}');\">",$txt[290]);
			alert_user($x7s->username,$txt[290]);
			return 0;
		}
		
		// See which command they want run
		switch($params[0]){
			case "+b":
				parse_irc_command("/ban $params[1] $txt[292]");
			break;
			case "-b":
				parse_irc_command("/unban $params[1]");
			break;
			case "+o":
				parse_irc_command("/op $params[1]");
			break;
			case "-o":
				parse_irc_command("/deop $params[1]");
			break;
			case "+v":
				parse_irc_command("/voice $params[1]");
			break;
			case "-v":
				parse_irc_command("/devoice $params[1]");
			break;
			case "+i":
				parse_irc_command("/ignore $params[1]");
			break;
			case "-i":
				parse_irc_command("/unignore $params[1]");
			break;
			case "+a":
				parse_irc_command("/admin $params[1]");
			break;
			case "-a":
				parse_irc_command("/deadmin $params[1]");
			break;
			case "+m":
				parse_irc_command("/mute $params[1]");
			break;
			case "-m":
				parse_irc_command("/unmute $params[1]");
			break;
			default: 
				$txt[290] = eregi_replace("<a>","<a style=\"cursor: hand;cursor: pointer;\" onClick=\"javascript: window.open('index.php?act=help&q=irc_mode','','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width={$x7c->settings['tweak_window_small_width']},height={$x7c->settings['tweak_window_small_height']}');\">",$txt[290]);
				alert_user($x7s->username,$txt[290]);
				return 0;
			break;
		}
	}
	
	// Takes operator access away from everyone except you
	function irc_mdeop($params){
		global $x7p, $x7c, $x7s, $txt, $db, $prefix;
		
		// Check permissions
		if($x7c->permissions['room_operator'] == 1 && $x7c->permissions['can_mdeop'] == 1){
			$db->DoQuery("UPDATE {$prefix}rooms SET ops='{$x7p->profile['id']}' WHERE name='$_GET[room]'");
			$txt[293] = eregi_replace("_u",$x7s->username,$txt[293]);
			alert_room($_GET['room'],$txt[293]);
		}else{
			// Permision denied
			alert_user($x7s->username,$txt[267]);
		}
	}
	
	// Very simple, print the version
	function irc_version($params){
		global $X7CHATVERSION, $x7s;
		alert_user($x7s->username,"<a href=\"http://www.x7chat.com/\" target=\"_blank\">X7Chat</a> $X7CHATVERSION");
	}
	
	// Very simple, print the news
	function irc_motd($params){
		global $x7c, $x7s, $txt;
		if($x7c->settings['news'] != "")
			$news = $x7c->settings['news'];
		else
			$news = $txt[294];
		alert_user($x7s->username,"$news");
	}
	
	// Get the users IP
	function irc_userip($params){
		global $x7s, $x7c, $txt;
		
		// Check syntax
		if($params == ""){
			alert_user($x7s->username,$txt[295]);
			return 0;
		}
		
		// Check permissions
		if($x7c->permissions['viewip'] == 1 && $x7c->permissions['room_operator'] == 1){
			// Show them the IP
			include_once("./lib/usercontrol.php");
			$uc = new user_control($params);
			alert_user($x7s->username,$uc->view_ip());
		}else{
			// Permision denied
			alert_user($x7s->username,$txt[267]);
		}
	}
	
	// This IRC command will invite a user to join the current room
	function irc_invite($params){
		global $x7s, $x7c, $txt;
		
		// Check syntax
		if($params == ""){
			alert_user($x7s->username,$txt[297]);
			return 0;
		}
		
		$txt[296] = eregi_replace("_u",$x7s->username,$txt[296]);
		$txt[296] = eregi_replace("_r","<a style=\"cursor: hand;cursor: pointer;\" onClick=\"javascript: window.open('index.php?act=frame&room=$_GET[room]','','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width={$x7c->settings['tweak_window_large_width']},height={$x7c->settings['tweak_window_large_height']}');\">[$_GET[room]]</a>",$txt[296]);
		alert_user($params,$txt[296]);
	}
	
	// This IRC command prints out a printlist, why the user would ever need this is beyond me
	function irc_list($params){
		global $x7s, $x7c;
		include_once("./lib/rooms.php");
		$rooms = list_rooms();
		$roomlist = "";
		foreach($rooms as $key=>$val){
			$roomlist .= "<a style=\"cursor: hand;cursor: pointer;\" onClick=\"javascript: window.open('index.php?act=frame&room=$val[0]','','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width={$x7c->settings['tweak_window_large_width']},height={$x7c->settings['tweak_window_large_height']}');\">[$val[0]]</a><Br>";
		}
		alert_user($x7s->username,$roomlist);
	}
	
	// This IRC command prints a link that allows you to join a new room
	function irc_join($params){
		global $x7s, $txt, $db, $prefix, $x7c;
		
		// Check syntax
		if($params == ""){
			alert_user($x7s->username,$txt[298]);
			return 0;
		}
		
		// Give them a link if the room exists
		$query = $db->DoQuery("SELECT * FROM {$prefix}rooms WHERE name='$params'");
		$row = $db->Do_Fetch_Row($query);
		if($row[0] == "" && $x7c->permissions['make_room'] == 1){
			// The room doesn't exist, allow them to create it
			$txt[301] = eregi_replace("<a>","<a style=\"cursor: hand;cursor: pointer;\" onClick=\"javascript: window.open('index.php?act=newroom1','','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width={$x7c->settings['tweak_window_large_width']},height={$x7c->settings['tweak_window_large_height']}');\">",$txt[301]);
			alert_user($x7s->username,"$txt[300]  $txt[301]");
		}elseif($row[0] != ""){
			// The room does exist, allow them to join it
			$txt[299] = eregi_replace("_r",$params,$txt[299]);
			$txt[299] = eregi_replace("<a>","<a style=\"cursor: hand;cursor: pointer;\" onClick=\"javascript: window.open('index.php?act=frame&room=$params','','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width={$x7c->settings['tweak_window_large_width']},height={$x7c->settings['tweak_window_large_height']}');\">",$txt[299]);
			alert_user($x7s->username,$txt[299]);
		}else{
			alert_user($x7s->username,$txt[300]);
		}
		
	}
	
	// This function gives them a link to send someone a Private Message
	function irc_msg($params){
		global $txt, $x7c, $x7s;
		
		// Check syntax
		if($params == ""){
			alert_user($x7s->username,$txt[302]);
			return 0;
		}
		
		$txt[303] = eregi_replace("_u",$params,$txt[303]);
		$txt[303] = eregi_replace("<a>","<a style=\"cursor: hand;cursor: pointer;\" onClick=\"javascript: window.open('index.php?act=pm&send_to=$params','','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width={$x7c->settings['tweak_window_large_width']},height={$x7c->settings['tweak_window_large_height']}');\">",$txt[303]);
		alert_user($x7s->username,$txt[303]);

	}
	
	// This IRC function sends a message to all room operators
	function irc_wallchop($params){
		global $x7c, $x7s, $txt;
		
		// Check syntax
		if($params == ""){
			alert_user($x7s->username,$txt[304]);
			return 0;
		}
		
		// Send the message
		$ops = explode(";",$x7c->room_data['ops']);
		include_once("./lib/usercontrol.php");
		$txt[305] = eregi_replace("_u",$x7s->username,$txt[305]);
		$txt[305] = eregi_replace("_r",$_GET['room'],$txt[305]);
		foreach($ops as $Key=>$val){
			$user = get_user_by_id($val);
			alert_user($user,"$txt[305]: $params");
		}
	
	}
	
	
	//////////////
	////////////// The following commands are for private chats
	//////////////
	
	// links to the roll command
	function irc_pm_roll($params){
		irc_roll($params,1);
	}
	
	// links to the ignore command
	function irc_pm_ignore($params){
		irc_ignore($params,1);
	}
	
	// links to the roll command
	function irc_pm_unignore($params){
		irc_unignore($params,1);
	}
	
	// links to the back command
	function irc_pm_back($params){
		irc_back($params);
	}
	
	// links to the away command
	function irc_pm_away($params){
		irc_away($params);
	}
	
	// links to the me command
	function irc_pm_me($params){
		irc_me($params,1);
	}
	
	// links to the me command
	function irc_pm_help($params){
		irc_help($params,1);
	}
	
	//////////////
	////////////// The following commands are for undocumented and are primarily for debugging
	////////////// They may or may not exist in future versions, depending on what bugs are fixed.
	//////////////
	
	// reset your session (used to refresh the user list)
	function irc_lsync($params){
		global $x7c, $txt, $x7s, $prefix, $db;
		$db->DoQuery("UPDATE {$prefix}online SET usersonline='' WHERE name='$x7s->username' AND room='$_GET[room]'");
	}
		
	//////////////////////////////////////
	//	END ACTUAL CMDS		    //
	//////////////////////////////////////
	
	
	
	// This function help with parameter parsing
	// This function returns a two element array.  The first element is 
	// the first word in the provided argument, the second element is the
	// rest of the words.
	function irc_param_parsefw($string){
		$string = explode(" ",$string);
		$return[0] = $string[0]; unset($string[0]);
		$return[1] = implode(" ",$string);
		return $return;
	}

?>
