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
	// These functions handle help popups and the smilie box and other similar popup dialog boxes
	function usr_action_window(){
		global $print, $txt, $x7c;
		
		// Include the user control library
		include("./lib/usercontrol.php");
		
		// Create a user info object for this user
		$user_info = new user_control($_GET['user']);
		
		if($_GET['action'] == "ignore"){
			$user_info->ignore();
			$body = $txt[101];
		}elseif($_GET['action'] == "unignore"){
			$user_info->unignore();
			$body = $txt[102];
		}elseif($_GET['action'] == "gop" && $x7c->permissions['room_operator'] == 1){
			$user_info->give_ops();
			$body = $txt[105];
		}elseif($_GET['action'] == "top" && $x7c->permissions['room_operator'] == 1){
			$user_info->take_ops();
			$body = $txt[106];
		}elseif($_GET['action'] == "vip" && $x7c->permissions['room_operator'] == 1 && $x7c->permissions['viewip'] == 1){
			$ip = $user_info->view_ip();
			$body = $txt[107].$ip;
		}elseif($_GET['action'] == "kick" && $x7c->permissions['room_operator'] == 1 && $x7c->permissions['kick'] == 1){
			if(!isset($_POST['reason'])){
				$body = $txt[108]."
				<form action=\"index.php?act=usr_action&action=kick&user=$user_info->user&room=$_GET[room]\" method=\"post\">
				<input type=\"text\" size=\"25\" name=\"reason\" class=\"text_input\">
				<input type=\"submit\" value=\"$txt[97]\" class=\"button\">
				</form>";
			}else{
				$user_info->kick($_POST['reason']);
				$body = $txt[109];
			}
		}elseif($_GET['action'] == "mute" && $x7c->permissions['room_operator'] == 1){
			$user_info->mute();
			$body = $txt[111];
		}elseif($_GET['action'] == "unmute" && $x7c->permissions['room_operator'] == 1){
			$user_info->unmute();
			$body = $txt[112];
		}elseif($_GET['action'] == "gv" && $x7c->permissions['room_operator'] == 1){
			$user_info->voice();
			$body = $txt[113];
		}elseif($_GET['action'] == "tv" && $x7c->permissions['room_operator'] == 1){
			$user_info->unvoice();
			$body = $txt[114];
		}else{
			// They sent an incorrect page so we give them an error
			$body = $txt[104];
		}
		
		// This script will update the user action/profile tab so it is accurate
		$script = "
		<script language=\"javascript\" type=\"text/javascript\">\n
		opener.window.clearTheWay();
		opener.window.parent.frames['profile'].document.location='./index.php?act=frame&frame=profile&room=$_GET[room]&user=$_GET[user]&tto=1';\n
		</script>\n
		";
		
		// Output this to the print buffer
		$print->info_window($body.$script);
	}
?> 
