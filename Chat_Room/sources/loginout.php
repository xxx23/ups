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
	
	// This file's job is to handle all login and logout
	// This file controls pages for the following actions:
	//		act = login
	//		act = login2
	//		act = logout
	
	function page_login($failed=""){
		global $print,$txt,$db,$prefix,$x7c;		
		// Check to see if $failed contains a value, if it does then print
		// a message telling them they failed to authenticate
		if($failed == ""){
			$title = $txt[0];
			$failmsg = $txt[1];
		}elseif($failed == "invalid"){
			$title = $txt[14];
			$txt[23] = eregi_replace("_n","{$x7c->settings['maxchars_username']}",$txt[23]);
			$failmsg = $txt[23];
		}elseif($failed == "activated"){
			$title = $txt[14];
			$failmsg = $txt[613];
		}else{
			$failmsg = $txt[13];
			$title = $txt[14];
		}
//here to enter student's username and password 				
        require_once('../config.php');
        require_once('../library/filter.php');
		global $dsn,$options;
		$DB_CONN = DB::connect($dsn, $options);
		if (!empty($_GET['pid'])) {
		$pid=optional_param('pid', -1, PARAM_INT);
		$mysql = "SELECT * FROM register_basic WHERE personal_id = $pid";
		$res = $DB_CONN->query($mysql);
		if(PEAR::isError($res)) die($res->userinfo);
		$row = $res->fetchRow(DB_FETCHMODE_ASSOC);
		$loginid = $row['login_id']; 
		$loginpass = $row['pass'];  
		}else{
		  $loginid="";
		  $loginpass="";
		}
		// Print the login form that the user must enter username and password
		$body = "	<form action=\"index.php\" method=\"post\" name=\"loginform\">
					<input type=\"hidden\" name=\"dologin\" value=\"dologin\">
					<table align=\"center\" border=\"0\" width=\"225\" cellspacing=\"0\" cellpadding=\"4\">
						<tr valign=\"top\">
							<td width=\"225\" style=\"text-align: center\" colspan=\"2\">$failmsg<Br><Br></td>
						</tr>
						<tr valign=\"top\">
							<td width=\"80\">$txt[2]: </td>
							<td width=\"175\"><input type=\"text\" class=\"text_input\" name=\"username\" value=\"$loginid\"></td>
						</tr>
						<tr valign=\"top\">
							<td width=\"80\">$txt[3]: </td>
							<td width=\"175\"><input type=\"password\" class=\"text_input\" name=\"password\" value=\"$loginpass\"></td>
						</tr>
						<tr valign=\"top\">
							<td width=\"225\" style=\"text-align: center\" colspan=\"2\">
								<input type=\"submit\" value=\"$txt[4]\" class=\"button\">
								<Br>
								<Br>
								<a href=\"./index.php?act=register\">[$txt[6]]</a> &nbsp;";
								 
		if($x7c->settings['enable_passreminder'] == 1)
			$body .= 			"<a href=\"./index.php?act=forgotmoipass\">[$txt[5]]</a>
								</td>";
		
		$body .= 	"</tr>
					</table>
					</form>
				";
		
		// Output login window
		$print->normal_window($title,$body);
		
		// See if there is any news to show
		if($x7c->settings['news'] != "")
			$print->normal_window($txt[262],$x7c->settings['news']);
			
		// See if the stats window should be displayed
		if($x7c->settings['show_stats'] == 1){
			// Get the information for the online table
			include("./lib/online.php");
			clean_old_data();
			$people_online = get_online();
			$number_online = count($people_online);
			$people_online = implode(", ",$people_online);

			// Calculate total rooms
			$rooms = 0;
			$query = $db->DoQuery("SELECT id FROM {$prefix}rooms WHERE type='1'");
			while($row = $db->Do_Fetch_Row($query))
				$rooms++;

			// Calculate total registered users
			$accounts = 0;
			$query = $db->DoQuery("SELECT id FROM {$prefix}users WHERE  user_group<>'{$x7c->settings['usergroup_guest']}'");
			while($row = $db->Do_Fetch_Row($query))
				$accounts++;


			// Now body will hold the stats table
			$body = "	
						<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
							<tr valign=\"top\">
								<td width=\"175\">
									<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
										<tr valign=\"top\">
											<td width=\"125\"><b>$txt[8]:</b> </td>
											<td width=\"50\">$number_online</td>
										</tr>
										<tr valign=\"top\">
											<td width=\"125\"><b>$txt[9]:</b> </td>
											<td width=\"50\">$rooms</td>
										</tr>
										<tr valign=\"top\">
											<td width=\"125\"><b>$txt[10]:</b> </td>
											<td width=\"50\">$accounts</td>
										</tr>
									</table>
								</td>
								<td width=\"225\"><b>$txt[11]</b><Br>
									<i>$people_online</i>
								</td>
							</tr>
						</table>
					";

			// Output Stats Window
			$print->normal_window($txt[7],$body);
		}
		
		// See if the admin wants the upcoming events to show
		if($x7c->settings['show_events'] == 1){
			$body = "";
			include("./lib/events.php");
			
			if($x7c->settings['events_show3day'] == 1){
				$body .= cal_threedays()."<Br><br>";
			}
			
			if($x7c->settings['events_showmonth'] == 1){
				$body .= cal_minimonth();
			}
		
			// Output the Calander window
			$print->normal_window($txt[12],$body);
		}
		
	}

?> 
