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
	// This class handles the Action tab, and certain user control functions
	// like kicking, ignoring and banning.
	
	class user_control{
		var $user;	// Stores the username of the person this class will operate on
		var $user_info;	// Stores profile information
		var $permissions;	// Stores user permissions
		
		function user_control($user){
			global $x7c;
		
			$this->user_info = new profile_info($user);
			$this->permissions = $x7c->permissions($user);
			$this->user = $user;
		}
		
		// This generates the values for the action tag
		function generate_action_tab(){
			global $x7c, $db, $prefix, $x7s, $txt;
			
			// See if you have ignored this user or if this user is ignored
			$query = $db->DoQuery("SELECT * FROM {$prefix}muted WHERE ignored_user='$this->user' AND user='$x7s->username'");
			$row = $db->Do_Fetch_Row($query);
			if($row[0] != ""){
				// This user is currently ignored
				$return[0] = $txt[92];
				$return[1] = 'unignore';
			}else{
				// This user is not currently ignored
				$return[0] = $txt[91];
				$return[1] = 'ignore';
			}
				
			
			// See if YOU are an operator
			if($x7c->permissions['room_operator'] == 1){
				// You are an operator, so....
				
				// you are able to make other ops
				
				// See if they have AOP-staths
				if($this->permissions['AOP_all'] == 0){
					// see if they are already an op
					if($this->permissions['room_operator'] == 1){
						// They are already an op
						$return[2] = $txt[95];
						$return[3] = "top";
					}else{
						// They are not already an op
						$return[2] = $txt[94];
						$return[3] = 'gop';
					}
				}
				
				// See if you are allowed to view IP addresses
				if($x7c->permissions['viewip'] == 1){
					$return[] = $txt[98];
					$return[] = 'vip';
				}
				
				// See if you are allowed to kick people and if that person can be kicked
				if($x7c->permissions['kick'] == 1 && $this->permissions['ban_kick_imm'] != 1){
					$return[] = $txt[97];
					$return[] = 'kick';
				}
				
				// Check to see if they have a voice or not
				// First see if they have Auto-Voice-all, if so we can't do anything to them
				if($this->permissions['AV_all'] == 0){
				
					// Now, we run conditionals to figure out whether
					// the to user mute/unmute or give/take voice
					if($x7c->room_data['moderated'] == 1){
					
						// The room IS moderated, use give/take voice
						if($this->permissions['room_voice'] == 1){
							// They have a voice
							$return[] = $txt[100];
							$return[] = "tv";
						}else{
							// They do not have a voice, allow you to give them one
							$return[] = $txt[99];
							$return[] = "gv";
						}
					
					}else{
					
						// The room is NOT moderated, use mute/unmute
						if($this->permissions['room_voice'] == 1){
							// They have are not muted
							$return[] = $txt[93];
							$return[] = "mute";
						}else{
							// They are muted
							$return[] = $txt[96];
							$return[] = "unmute";
						}
					
					}
					
				}				
			}
			
			return $return;
			
		}
		
		// This generates the values for the Profile tab
		function generate_profile_tab(){
			global $txt;
		
			$return['status'] = $this->user_info->profile['status'];
			$return['group'] = $this->user_info->profile['user_group'];
			
			if($return['status'] == "")
				$return['status'] = $txt[150];
			
			return $return;
		}
		
		// Take a hint from the name if you want to know what this does
		function ignore($ban_length=0){
			global $x7s, $db, $prefix;
			$time = time();
			$db->DoQuery("INSERT INTO {$prefix}muted VALUES('0','$x7s->username','$this->user')");
		}
		
		// *yawn* hopefully I don't need to tell you what this does
		function unignore(){
			global $x7s, $db, $prefix;
			$db->DoQuery("DELETE FROM {$prefix}muted WHERE user='$x7s->username' AND ignored_user='$this->user'");
		}
		
		// Give someone operator status in a room
		function give_ops(){
			global $x7c, $db, $prefix, $txt;
			$their_id = $this->user_info->profile['id'];
			$new_ops = $x7c->room_data['ops'].";$their_id";
			$room_id = $x7c->room_data['id'];
			$db->DoQuery("UPDATE {$prefix}rooms SET ops='$new_ops' WHERE id='$room_id'");
		
			// Alert the room that they have a new operator, and alert the user that they have
			// access to the room cp.  In addition, reload their top frame so that they can see the Room CP button
			include_once("./lib/message.php");
			alert_room($x7c->room_name,$txt[126],$this->user);
			alert_user($this->user,$txt[407]);
		}
		
		// Take away someone's operator status in a room
		function take_ops(){
			global $x7c, $db, $prefix, $txt;
			$ops = explode(";",$x7c->room_data['ops']);
			$their_id = $this->user_info->profile['id'];
			$room_id = $x7c->room_data['id'];
			$key = array_search("$their_id",$ops);
			unset($ops[$key]);
			$ops = implode(";",$ops);
			$db->DoQuery("UPDATE {$prefix}rooms SET ops='$ops' WHERE id='$room_id'");
		
			// Alert the room that they have a new operator no longer
			include_once("./lib/message.php");
			alert_room($x7c->room_name,$txt[127],$this->user);
		}
		
		// View the user's IP address
		function view_ip(){
			global $db, $prefix;
			$query = $db->DoQuery("SELECT ip FROM {$prefix}online WHERE name='$this->user' AND room='$_GET[room]'");
			$row = $db->Do_Fetch_Row($query);
			return $row[0];
		}
		
		// Kick a user
		function kick($reason){
			global $db, $prefix, $x7c, $txt;
			$room_id = $x7c->room_data['id'];
			$time = time();
			$db->DoQuery("INSERT INTO {$prefix}banned VALUES('0','$room_id','$this->user','$time','60','$reason')");
			// Send a message to the room
			include_once("./lib/message.php");
			$txt[110] = eregi_replace("_r","$reason",$txt[110]);
			alert_room($_GET['room'],"$txt[110]",$this->user);
		}
		
		// Adds user's id and a negative sign to the voice column so they are muted
		function mute(){
			global $db, $prefix, $x7c, $txt;
			$voiced = $x7c->room_data['voiced'];
			$their_id = $this->user_info->profile['id'];
			$room_id = $x7c->room_data['id'];
			$voiced .= ";-$their_id";
			$db->DoQuery("UPDATE {$prefix}rooms SET voiced='$voiced' WHERE id='$room_id'");
			// Alert the room that they have a new operator
			include_once("./lib/message.php");
			alert_room($x7c->room_name,$txt[131],$this->user);
		
		}
		
		// Removes the user's id and negative sign from the voice column so they are unmuted
		function unmute(){
			global $db, $prefix, $x7c, $txt;
			$voiced = $x7c->room_data['voiced'];
			$their_id = $this->user_info->profile['id'];
			$room_id = $x7c->room_data['id'];
			$voiced = explode(";",$voiced);
			$key = array_search("-$their_id",$voiced);
			unset($voiced[$key]);
			$voiced = implode(";",$voiced);
			$db->DoQuery("UPDATE {$prefix}rooms SET voiced='$voiced' WHERE id='$room_id'");
			// Alert the room that they have a new operator
			include_once("./lib/message.php");
			alert_room($x7c->room_name,$txt[132],$this->user);
		}
		
		// Adds a user's id to the voice column
		function voice(){
			global $db, $prefix, $x7c, $txt;
			$voiced = $x7c->room_data['voiced'];
			$their_id = $this->user_info->profile['id'];
			$room_id = $x7c->room_data['id'];
			$voiced .= ";$their_id";
			$db->DoQuery("UPDATE {$prefix}rooms SET voiced='$voiced' WHERE id='$room_id'");
			// Alert the room that they have a new voiced user
			include_once("./lib/message.php");
			alert_room($x7c->room_name,$txt[129],$this->user);
		}
		
		// Removes a user's id from the voice column
		function unvoice(){
			global $db, $prefix, $x7c, $txt;
			$voiced = $x7c->room_data['voiced'];
			$their_id = $this->user_info->profile['id'];
			$room_id = $x7c->room_data['id'];
			$voiced = explode(";",$voiced);
			$key = array_search("$their_id",$voiced);
			unset($voiced[$key]);
			$voiced = implode(";",$voiced);
			$db->DoQuery("UPDATE {$prefix}rooms SET voiced='$voiced' WHERE id='$room_id'");
			// Alert the room that they have a new voiced user
			include_once("./lib/message.php");
			alert_room($x7c->room_name,$txt[130],$this->user);
		}

	}
	
	// This function gets a username by its ID
	function get_user_by_id($id){
		global $db, $prefix, $querydb;
		
		if(!isset($querydb['get_user_by_id_1'])){
			$query = $db->DoQuery("SELECT id,username FROM {$prefix}users");
			while($row = $db->Do_Fetch_Row($query)){
				$querydb['get_user_by_id_1'][$row[0]] = $row[1];
			}
		}
		
		return @$querydb['get_user_by_id_1'][$id];
	}
	
	/*// This function gets a username by its ID
	function get_user_by_id($id){
		global $db, $prefix, $querydb;
		$query = $db->DoQuery("SELECT username FROM {$prefix}users WHERE id='$id'");
		$row = $db->Do_Fetch_Row($query);
		return $row[0];
	}*/

?> 
