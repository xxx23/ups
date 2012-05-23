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

	function microtime_float(){
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$usec + (float)$sec);
	}
	$debug_start = microtime_float();

	// First we need to set up a nice environment
	error_reporting(E_ALL);
	set_magic_quotes_runtime(0);

	// Import the configuration file
	include("./config.php");

	// Test to see if it is installed
	if(!isset($X7CHAT_CONFIG['INSTALLED'])){
		header("location: ./install.php");
		echo "<a href=\"./install.php\">Click Here to Install X7 Chat 2.0.0A3</a>";
		exit;
	}

	// Test to make sure the user didn't miss the last install step
	if(@$_GET['act'] != "frame"){
		if(file_exists("./install.php") || file_exists("./upgradev1.php")){
			print("<div align='center'><font color='red'>You must delete the files install.php and upgradev1.php before using the chatroom.</font></div>");
			exit;
		}
	}

	// Import the database library
	include("./lib/db/".strtolower($X7CHAT_CONFIG['DB_TYPE']).".php");

	// Create a new database connection
	$db = new x7chat_db();
	// Include the classes needed for loading

	// Include the security
	include("./lib/security.php");

	// Clean all incoming data
	parse_incoming();
	include("./lib/load.php");

	// Load the server variables
	$x7c = new settings();

	// Clean up the database a tad
	include("./lib/cleanup.php");
	cleanup_banned();

	// Include the authentication functions
	include("./lib/auth.php");

	// Include the AuthMod file
	include("./lib/auth/".strtolower($X7CHAT_CONFIG['AUTH_MODE']).".php");

	// Force Settings from AuthMod
	if($auth_disable_guest)
		$x7c->settings['allow_guests'] = 0;

	// Create a new session
	$x7s = new session();

	// Is the user trying to login?  If so give them a cookie
	if(isset($_POST['dologin']) && @$_POST['username'] != "")
		$x7s->dologin();

	// The alternate way to login is using GETs, check for that
	if(isset($_GET['dologin']) && @$_GET['username'] != ""){
		$_POST['username'] = $_GET['username'];
		$_POST['password'] = $_GET['password'];
		$x7s->dologin();
	}

	// If the user is logged in then load their settings and profile
	if($x7s->loggedin == 1){
		$x7p = new profile_info($x7s->username);
		$x7c->usersettings();
	}

	// Include the language file
	include("./lang/".$x7c->settings['default_lang'].".php");

	// Include the output library
	include("./lib/output.php");

	// Load the skin data
	$print = new load_skin($x7c->settings['default_skin']);

	// Run these cleanups only if you are not part of a frame
	if(@$_GET['act'] != "frame"){
		cleanup_messages();
		cleanup_guests();
	}

	// Now before all else we have to get them logged in if they are not already
	// We also have to check and make sure they are not trying to register or remember their password which they stupidly forgot or get help or anything like that

	// THis array contins the functions that you don't hvae to be logged in to do
	$no_login_req[] = "register";
	$no_login_req[] = "forgotmoipass";
	$no_login_req[] = "sm_window";
	$no_login_req[] = "help";

	if($x7s->loggedin == 0 && !in_array(@$_GET['act'],$no_login_req)){
		// They are not logged in
		// Include controls for login and logout
		include("./sources/loginout.php");
		page_login();
		$print->dump_buffer();
		exit;
	}elseif($x7s->loggedin == 2 && !in_array(@$_GET['act'],$no_login_req)){
		// They tried to login but with an incorrect pass or username
		include("./sources/loginout.php");
		//page_login("failed");
		page_login();
		$print->dump_buffer();
		exit;
	}elseif($x7s->loggedin == 3 && !in_array(@$_GET['act'],$no_login_req)){
		// They tried to login but their username was invalid
		include("./sources/loginout.php");
		page_login("invalid");
		$print->dump_buffer();
		exit;
	}elseif($x7s->loggedin == 4 && !in_array(@$_GET['act'],$no_login_req)){
		// They tried to login but their username was invalid
		include("./sources/loginout.php");
		page_login("activated");
		$print->dump_buffer();
		exit;
	}

	// Prevent their username and room from being deleted
	prevent_cleanup();

	// If the user has just entered as a guest then we need to remove old logs
	// This variable is set in lib/auth.php IF it is set at all
	if(isset($remove_old_guest_logs))
		cleanup_guest_logs($x7s->username);

	// Prevent errors
	if(!isset($_GET['act']))
		$_GET['act'] = "";

	// We cannot allow a user to start the frameset without choosing a room
	if($_GET['act'] == "frame" && $x7c->room_name == "")
		$_GET['act'] = "";

	// Test to see if server is running in single room mode
	if($x7c->settings['single_room_mode'] != ""){
		// Set the room name
		$_GET['room'] = $x7c->settings['single_room_mode'];
		// Fix problems with room passwords
		$x7c->room_info($_GET['room']);
		// Set action to frameset
		if($_GET['act'] == "")
			$_GET['act'] = "frame";
	}

	// See if the room is password protected
	if(isset($_GET['room'])){
		include("./sources/room_password.php");

		$cookie_name = "rpw_".$x7c->room_data['id'];

		// See if a cookie password is set
		if(!isset($_COOKIE[$cookie_name]))
			$_COOKIE[$cookie_name] = "";

		// See if the password form was filled out
		if(isset($_POST['room_pw']))
			$_COOKIE[$cookie_name] = $_POST['room_pw'];

		// Check the password returns 1 if correct, 2 if incorrect and 0 if there is no password
		$result = check_password($_GET['room'],$_COOKIE[$cookie_name]);
		if($result == 1){
				setcookie($cookie_name,$_COOKIE[$cookie_name],time()+$x7c->settings['cookie_time'],$X7CHAT_CONFIG['COOKIE_PATH']);
		}elseif($result == 2 && $x7c->permissions['access_pw_rooms'] != 1){
			roomlogin_screen($_GET['room']);
			$print->dump_buffer();
			exit;
		}

	}

	// See if a bandwidth error is occuring
	if($x7c->settings['log_bandwidth'] == 1){
		include("./lib/bandwidth.php");
		$BW_CHECK = check_bandwidth($x7s->username);
		if($BW_CHECK && ((@$_GET['frame'] != 'update' || $_GET['act'] != 'frame') && (@$_GET['pmf'] != "update" || $_GET['act'] != "pm")))
			$_GET['act'] = "bw_error";
	}


	// See if the admin has disabled the chat server
	if($x7c->settings['disable_chat'] == 1 && @$_GET['act'] != "logout"  && $x7c->permissions['access_disabled'] != 1)
		$_GET['act'] = "disabledchat";

	// Time to see what's happening!  The $act variable stored what the
	// user wants to see.  We need to determine that and bring up the
	// correct page

	// See if they are banned from this server
	include("./lib/ban.php");
	$x7p->bans_on_you = get_bans_onyou();
	$bans = $x7p->bans_on_you;

	foreach($bans as $key=>$row){
		if($row[1] == "*" && ((@$_GET['frame'] != 'update' || $_GET['act'] != 'frame') && (@$_GET['pmf'] != "update" || $_GET['act'] != "pm"))){	// The reason we see if they are getting the update frame is cuz if they are we need to let them so it'll remove them from the room they are in now
			$_GET['act'] = "sbanned";
			$ban_reason = $row[5];

			// Remove them from all online lists
			$db->DoQuery("DELETE FROM {$prefix}online WHERE name='$x7s->username'");
		}
	}

	// Ok let's see what's inside
	switch($_GET['act']){
		case "logout":
			// The user is leaving us :(
			setcookie($auth_ucookie,"",time()-$x7c->settings['cookie_time']-63000000,$X7CHAT_CONFIG['COOKIE_PATH']);
			setcookie($auth_pcookie,"",time()-$x7c->settings['cookie_time']-63000000,$X7CHAT_CONFIG['COOKIE_PATH']);

			// If the admin has choosen where to send the user to then send them there
			$to_send = $x7c->settings['logout_page'];
			if($to_send != ""){
				header("Location: $to_send");
			}else{
				$print->normal_window($txt[16],"$txt[17]<br><Br>&nbsp; <a href=\"index.php\">[$txt[0]]</a>");
				$print->dump_buffer();
				exit;
			}
		break;

		case "panic":
			// Core error (probably database)
			$print->normal_window($txt[14],"$txt[597]<Br><br><hr><b>Error Dump</b><br>$_GET[dump]<Br>$_GET[source]<Br>");
			$print->dump_buffer();
			exit;
		break;

		// Chat is disabled and user is not an admin
		case "disabledchat":
			$print->normal_window($txt[14],$txt[39]);
			$print->dump_buffer();
			exit;
		break;

		// Chat is disabled and user is not an admin
		case "support_sit":
			include("./sources/support.php");
			support_mainpage();
			$print->dump_buffer();
			exit;
		break;


		// They have exceeded the allowed bandwidth for this day/month
		case "bw_error":
			if($x7c->settings['default_bandwidth_type'] == 1)
				$body = $txt[480];
			else
				$body = $txt[481];
			$print->normal_window($txt[14],$body);
			$print->dump_buffer();
			exit;
		break;

		// They have been kicked from that room
		case "kicked":
			$print->normal_window($txt[14],$txt[118]);
			$print->dump_buffer();
			exit;
		break;

		// They have been banned from this server
		case "sbanned":
			$txt[117] = eregi_replace("_r",$ban_reason,$txt[117]);
			$print->normal_window($txt[14],$txt[117]);
			$print->dump_buffer();
			exit;
		break;

		// They want to read the user agreement
		case "user_agreement":
			$print->normal_window($txt[517],$x7c->settings['user_agreement']);
			$print->dump_buffer();
			exit;
		break;

		// They want to see who is registered
		case "memberlist":
			include("./sources/memberlist.php");
			memberlist();
			$print->dump_buffer();
			exit;
		break;

		// They want to see whats up
		case "calendar":
			include("./sources/calendar.php");
			calendar();
			$print->dump_buffer();
			exit;
		break;

		// See if they are trying to access the User CP
		case "user_cp": // Legacy support
		case "userpanel":
			// The user wants to access their Control Panel
			include("./sources/usercp.php");
			usercp_master();
			$print->dump_buffer();
			exit;
		break;

		// See if they are trying to access the Admin CP
		case "admincp":	// Legacy support
		case "adminpanel":
			// The user wants to access the Admin cp
			include("./sources/admin.php");
			admincp_master();
			$print->dump_buffer();
			exit;
		break;

		// See if they are trying to access the Room CP
		case "roomcp":
			// The user wants to access their Control Panel
			include("./sources/roomcp.php");
			roomcp_master();
			$print->dump_buffer();
			exit;
		break;

		// Handle the many frames
		case "frame":
			$before_frame = microtime_float()-$debug_start;

			// See if bandwidth logging is on
			if($x7c->settings['log_bandwidth'] == 1){
				ob_start();
				include("./sources/frame.php");
				$used = ob_get_length();
				log_bw($used);
				ob_end_flush();
			//}elseif(@$_GET['frame'] == "update"){
			//	include("./sources/update.php");
			}else{
				include("./sources/frame.php");
			}

			/*$debug_start = microtime_float()-$debug_start;
			if(!isset($data))
				$data = "";
			if(!isset($data2))
				$data2 = "";
			$fh = fopen("./temp.txt","a");
			fwrite($fh,"$debug_start [$before_frame] (other: $data :: $data2)\n");
			fclose($fh);
			*/
			exit;
		break;

		// In case they are registering
		case "register":
			// The user wants to join us :)
			// Check if the AuthMod wants us to redirect
			if($auth_register_link != ""){
				// Redirect
				header("location: $auth_register_link");
			}else{
				include("./sources/register.php");
				register_user();
				$print->dump_buffer();
			}
			exit;
		break;

		// awe, how sad, the user forgot their little password
		case "forgotmoipass":
			include("./sources/forgotpass.php");
			forgot_pass();
			$print->dump_buffer();
			exit;
		break;

		// They are doing some action associated with a private message
		case "pm":
			// See what they want to do and if we need to long bandwidth
			if($x7c->settings['log_bandwidth'] == 1){
				ob_start();
				include("./sources/privatemessage.php");
				pm_whatshouldicall();
				$used = ob_get_length();
				log_bw($used);
				ob_end_flush();
			}else{
				include("./sources/privatemessage.php");
				pm_whatshouldicall();
			}
			exit;
		break;

		// They want to see someone elses profile, or maybe their own?
		case "view_profile":
			include("./sources/profile.php");

			// If no user is specified we will show them their own profile
			if(!isset($_GET['user']))
				$_GET['user'] = $x7s->username;

			// Get the page source
			view_profile($_GET['user']);
			$print->dump_buffer();
			exit;
		break;

		// Dispay a small information popup window
		case "sm_window":
			include("./sources/info_box.php");
			mini_page();
			$print->dump_buffer();
			exit;
		break;

		// Dispay a small information popup window that contains help info
		case "help":
			$_GET['help_file'] = "./help/main";
			include("./help/mini.php");
			exit;
		break;

		// Perform a user action (ignore, ops, view ip, kick, mute)
		case "usr_action":
			include("./sources/usr_action_box.php");
			usr_action_window();
			$print->dump_buffer();
			exit;
		break;

		// Dispay the form for creating a new room
		case "newroom1":
			include("./sources/newroom.php");
			newroom_form();
			$print->dump_buffer();
			exit;
		break;

		// Create the new room
		case "newroom2":
			include("./lib/rooms.php");
			include("./sources/newroom.php");
			newroom_creation();
			$print->dump_buffer();
			exit;
		break;

		// Display room is full error message
		case "overload":
			$print->normal_window($txt[14],"$txt[80]<Br><Br><a href=\"index.php\">[$txt[77]]</a>");
			$print->dump_buffer();
			exit;
		break;

		// Allow the user to join a different room
		case "join_room":
			// Clean up old rooms
			cleanup_rooms();
			// First we include the rooms library
			include("./sources/roomlist.php");
			join_other_room();
			$print->dump_buffer();
			exit;
		break;
		default:
			// The default action is to show the room list
			// Clean up old rooms
			cleanup_rooms();
			// First we include the rooms library
			include("./sources/roomlist.php");
			room_list_page();
			$print->dump_buffer();
			exit;
		break;
	}

?>
