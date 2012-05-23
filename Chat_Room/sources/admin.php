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
?> <?PHP
 	// This is by far the largest file in the entire distrobution.  It clocks in at almost 3000 lines
	function admincp_master(){
		global $X7CHATVERSION, $x7p, $x7s, $print, $db, $txt, $x7c, $prefix, $X7CHAT_CONFIG, $g_default_settings;

		$head = $txt[37];
		$body = $txt[306]."<Br><Br><div align=\"center\"><a href=\"http://x7chat.com/download.php\"><img border=\"0\" src=\"http://x7chat.com/rss/updates.php?version=$X7CHATVERSION\"></a></div>";

		// Set these so it doesn't complain, all admins have access to these pages
		$x7c->permissions["admin_main"] = 1;
		$x7c->permissions["admin_news"] = 1;
		$x7c->permissions["admin_help"] = 1;

		// Look for the CP page we are on, if not set then make it main
		if(!isset($_GET['cp_page']))
			$_GET['cp_page'] = "main";

		// Check permissions
		$check_page = $_GET['cp_page'];
		if($check_page == "groupmanager")
			$check_page = "groups";
		if($x7c->permissions["admin_{$check_page}"] != 1)
			$_GET['cp_page'] = "ad2";
		if($x7c->permissions['admin_access'] != 1)
			$_GET['cp_page'] = "ad";
		
		// Figure out which page this is
		if($_GET['cp_page'] == "news"){

			$head = $txt[307];
			
			// See if news from us is enabled
			if($X7CHAT_CONFIG['DISABLE_XUPDATER'] == 1){
				$body = $txt[319];
			}else{
				include("./lib/xupdater.php");
				$news = get_news();
				if($news == "nonews"){
					$body = $txt[320];
				}else{
				
					// Display this news article
					foreach($news as $key=>$val){
						$body = "<Br>
								<table align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
							<tr>
								<td width=\"50\" height=\"50\" rowspan=\"2\"><img src=\"$val[icon]\" width=\"50\" height=\"50\"></td>
								<td width=\"200\"><font size=\"3\"><b>$val[title]</b></font></td>
							</tr>
							<Tr>
								<td width=\"200\">By $val[author] on $val[date]</td>
							</tr>
							<tr>
								<td width=\"250\" colspan=\"2\">$val[body]</td>
							</tr>
						</table>
						<Br>";
					}
				
				}
			}
		
		}elseif($_GET['cp_page'] == "settings"){

			$head = $txt[139];
			
			if(isset($_GET['update_settings'])){
				// Update the settings for some section
					$txt[343] = eregi_replace("<a>","<a href=\"./index.php?act=adminpanel&cp_page=settings\">",$txt[343]);
				
				if($_GET['settings_page'] == "general"){
					// Update the settings page for the general settings
					// Check for unset values (this is a bug in some browers)
					if(!isset($_POST['disable_chat']))
						$_POST['disable_chat'] = 0;
					if(!isset($_POST['allow_reg']))
						$_POST['allow_reg'] = 0;
					if(!isset($_POST['allow_guests']))
						$_POST['allow_guests'] = 0;
					if(!isset($_POST['disable_sounds']))
						$_POST['disable_sounds'] = 0;
					if(!isset($_POST['log_bandwidth']))
						$_POST['log_bandwidth'] = 0;
					if(!isset($_POST['req_activation']))
						$_POST['req_activation'] = 0;
					
					// Preparse these to cuz we need to convert seconds to miliseconds
					$_POST['min_refresh'] = $_POST['min_refresh']*1000;
					$_POST['max_refresh'] = $_POST['max_refresh']*1000;
					
					// Check for problems with the submitted data
					if($_POST['min_refresh'] > $_POST['max_refresh'])
						$error = $txt[344];
					
					if(!isset($error)){
						// Do the actual updates right now, when I say now I mean NOW
						// Yes this section wrecks hell on your MySql server but hopefully you don't need to update your settings to often
						update_setting("disable_chat",$_POST['disable_chat']);
						update_setting("allow_reg",$_POST['allow_reg']);
						update_setting("allow_guests",$_POST['allow_guests']);
						update_setting("disable_sounds",$_POST['disable_sounds']);
						update_setting("site_name",$_POST['site_name']);
						update_setting("admin_email",$_POST['admin_email']);
						update_setting("logout_page",$_POST['logout_page']);
						update_setting("default_lang",$_POST['default_lang']);
						update_setting("default_skin",$_POST['default_skin']);
						update_setting("maxchars_status",$_POST['maxchars_status']);
						update_setting("maxchars_msg",$_POST['maxchars_msg']);
						update_setting("max_offline_msgs",$_POST['max_offline_msgs']);
						update_setting("min_refresh",$_POST['min_refresh']);
						update_setting("max_refresh",$_POST['max_refresh']);
						update_setting("cookie_time",$_POST['cookie_time']);
						update_setting("log_bandwidth",$_POST['log_bandwidth']);
						update_setting("maxchars_username",$_POST['maxchars_username']);
						update_setting("banner_link",$_POST['banner_link']);
						update_setting("single_room_mode",$_POST['single_room_mode']);
						update_setting("req_activation",$_POST['req_activation']);
						
						// Check activation stuff
						if($_POST['req_activation'] == 0){
							// Update existing accounts so they do not require activation
							$db->doQuery("UPDATE {$prefix}users SET activated='1'");
						}
						
						$body = $txt[343];
					}else{
						$body = $error."<Br><Br><div align=\"center\"><a href=\"javascript: history.back()\">$txt[77]</a></div>";
					}
				}elseif($_GET['settings_page'] == "logs"){
					// Convert these values from Kilobytes to bytes
					$_POST['max_log_user'] *= 1024;
					$_POST['max_log_room'] *= 1024;
					
					if(!isset($_POST['enable_logging']))
						$_POST['enable_logging'] = 0;
					
					// Update the settings
					update_setting("max_log_user",$_POST['max_log_user']);
					update_setting("max_log_room",$_POST['max_log_room']);
					update_setting("logs_path",$_POST['logs_path']);
					update_setting("enable_logging",$_POST['enable_logging']);
					
					$body = $txt[343];
					
				}elseif($_GET['settings_page'] == "user_agreement"){
				
					// Update the user agreement
					$_POST['user_agreement'] = eregi_replace("\n","<Br>",$_POST['user_agreement']);
					$_POST['user_agreement'] = eregi_replace("&lt;","<",$_POST['user_agreement']);
					$_POST['user_agreement'] = eregi_replace("&gt;",">",$_POST['user_agreement']);
					$_POST['user_agreement'] = eregi_replace("&quot;","\"",$_POST['user_agreement']);
					update_setting("user_agreement",$_POST['user_agreement']);
					$body = $txt[343];
					
				}elseif($_GET['settings_page'] == "timedate"){
				
					// Update the settings
					update_setting("date_format",$_POST['date_format']);
					update_setting("date_format_full",$_POST['date_format_full']);
					update_setting("date_format_date",$_POST['date_format_date']);
					update_setting("time_offset_hours",$_POST['time_offset_hours']);
					update_setting("time_offset_mins",$_POST['time_offset_mins']);

					$body = $txt[343];
				
				}elseif($_GET['settings_page'] == "exptime"){
				
					// Pre-parse, convert these times from hours to seconds
					$_POST['expire_messages'] = round($_POST['expire_messages']*60,0);
					$_POST['expire_rooms'] = round($_POST['expire_rooms']*60,0);
					$_POST['expire_guests'] = round($_POST['expire_guests']*60,0);
					
					if($_POST['online_time'] <= 0){
						$_POST['online_time'] = 30;
					}
					
					update_setting("online_time",$_POST['online_time']);
					update_setting("expire_messages",$_POST['expire_messages']);
					update_setting("expire_rooms",$_POST['expire_rooms']);
					update_setting("expire_guests",$_POST['expire_guests']);
				
					$body = $txt[343];
				
				}elseif($_GET['settings_page'] == "styles"){
				
					// uncheck these checkboxs if not checked
					if(!isset($_POST['enable_roombgs']))
						$_POST['enable_roombgs'] = 0;
					if(!isset($_POST['enable_roomlogo']))
						$_POST['enable_roomlogo'] = 0;
					if(!isset($_POST['disable_smiles']))
						$_POST['disable_smiles'] = 0;
					if(!isset($_POST['disable_styles']))
						$_POST['disable_styles'] = 0;
					if(!isset($_POST['disable_autolinking']))
						$_POST['disable_autolinking'] = 0;
					
					// parse comma spaces
					$_POST['style_allowed_fonts'] = eregi_replace(" ,",",",$_POST['style_allowed_fonts']);
					$_POST['style_allowed_fonts'] = eregi_replace(", ",",",$_POST['style_allowed_fonts']);
					
					// Update the styles section
					update_setting("banner_url",$_POST['banner_url']);
					update_setting("background_image",$_POST['background_image']);
					update_setting("enable_roombgs",$_POST['enable_roombgs']);
					update_setting("enable_roomlogo",$_POST['enable_roomlogo']);
					update_setting("default_font",$_POST['default_font']);
					update_setting("default_color",$_POST['default_color']);
					update_setting("default_size",$_POST['default_size']);
					update_setting("style_min_size",$_POST['style_min_size']);
					update_setting("style_max_size",$_POST['style_max_size']);
					update_setting("disable_smiles",$_POST['disable_smiles']);
					update_setting("disable_styles",$_POST['disable_styles']);
					update_setting("disable_autolinking",$_POST['disable_autolinking']);
					update_setting("system_message_color",$_POST['system_message_color']);
					update_setting("style_allowed_fonts",$_POST['style_allowed_fonts']);	
					
					$body = $txt[343];
				
				}elseif($_GET['settings_page'] == "avatars"){
				
					// Convert from kilobytes to bytes
					$_POST['avatar_max_size'] *= 1024;
					
					// Check for unchecked checkboxes
					if(!isset($_POST['enable_avatar_uploads']))
						$_POST['enable_avatar_uploads'] = 0;
					if(!isset($_POST['resize_smaller_avatars']))
						$_POST['resize_smaller_avatars'] = 0;
					
					update_setting("enable_avatar_uploads",$_POST['enable_avatar_uploads']);
					update_setting("resize_smaller_avatars",$_POST['resize_smaller_avatars']);
					update_setting("avatar_max_size",$_POST['avatar_max_size']);
					update_setting("avatar_size_px",$_POST['avatar_size_px']);
					update_setting("uploads_path",$_POST['uploads_path']);
					update_setting("uploads_url",$_POST['uploads_url']);
				
					$body = $txt[343];
					
				}elseif($_GET['settings_page'] == "loginpage"){
				
					// Check Check boxes
					if(!isset($_POST['show_events']))
						$_POST['show_events'] = 0;
					if(!isset($_POST['show_stats']))
						$_POST['show_stats'] = 0;
					if(!isset($_POST['enable_passreminder']))
						$_POST['enable_passreminder'] = 0;
					
					// Adjust this wierd little setting again
					$_POST['events_3day_number']--;
					if($_POST['events_3day_number'] > 2 || $_POST['events_3day_number'] < 0)
						$_POST['events_3day_number'] = 0;
					
					// Figure out whether they want to show the daily or monthly calendar.
					// Actually, chat will show both correctly if both values are set to 1
					// in the database, but the admin doesn't need to know that :)
					if($_POST['event_show'] == "events_showmonth"){
						$_POST['events_showmonth'] = 1;
						$_POST['events_show3day'] = 0;
					}else{
						$_POST['events_showmonth'] = 0;
						$_POST['events_show3day'] = 1;
					}
						
					// Update settings
					update_setting("news",$_POST['news']);
					update_setting("show_events",$_POST['show_events']);
					update_setting("events_showmonth",$_POST['events_showmonth']);
					update_setting("events_show3day",$_POST['events_show3day']);
					update_setting("show_stats",$_POST['show_stats']);
					update_setting("enable_passreminder",$_POST['enable_passreminder']);
					update_setting("events_3day_number",$_POST['events_3day_number']);
				
					$body = $txt[343];
				
				}elseif($_GET['settings_page'] == "advanced"){
				
					if(!isset($_POST['disable_gd']))
						$_POST['disable_gd'] = 0;
				
					update_setting("disable_gd",$_POST['disable_gd']);
				
					$body = $txt[343];
				
				}elseif($_GET['settings_page'] == "support"){
				
					// Clean up the values a little
					$_POST['support_personel'] = eregi_replace("; ",";",$_POST['support_personel']);
					$_POST['support_personel'] = eregi_replace(" ;",";",$_POST['support_personel']);
					
					update_setting("support_personel",$_POST['support_personel']);
					update_setting("support_image_online",$_POST['support_image_online']);
					update_setting("support_image_offline",$_POST['support_image_offline']);
					update_setting("support_message",$_POST['support_message']);
					
					$body = $txt[343];
				
				}
			
			}elseif(isset($_GET['settings_page'])){
				// Display the settings form
				
				// Get default values for settings
				// The reason we have to do this here is because values for this admin and the system default may be different
				$query = $db->DoQuery("SELECT * FROM {$prefix}settings");
				while($row = $db->Do_Fetch_Row($query)){
					$def_settings[$row[1]] = $row[2];
				}
				
				if($_GET['settings_page'] == "general"){
				
					// Get the default values for check boxes
					$checkboxs[] = "disable_chat";
					$checkboxs[] = "allow_reg";
					$checkboxs[] = "allow_guests";
					$checkboxs[] = "disable_sounds";
					$checkboxs[] = "log_bandwidth";
					foreach($checkboxs as $key=>$val){
						if($def_settings[$val] == 1)
							$def[$val] = " CHECKED=\"true\"";
						else
							$def[$val] = "";
					}
					
					// Get defaults for lang and skin
					$lng_dir = dir("./lang");
					$skin_dir = dir("./themes");

					$def['default_lang'] = "";
					$def['default_skin'] = "";

					while($option = $lng_dir->read()){
						if($option != "." && $option != ".." && $option != "index.html"){
							$option = eregi_replace("\.php","",$option);
							if($option == $def_settings['default_lang'])
								$slcted = " SELECTED=\"true\"";
							else
								$slcted = "";
							$def['default_lang'] .= "<option value=\"$option\"$slcted>$option</option>";
						}
					}

					while($option = $skin_dir->read()){
						if($option != "." && $option != ".." && @is_file("./themes/$option/theme.info")){
							if($option == $def_settings['default_skin'])
								$slcted = " SELECTED=\"true\"";
							else
								$slcted = "";
							include("./themes/$option/theme.info");
							$def['default_skin'] .= "<option value=\"$option\"$slcted>$name</option>";
						}
					}
					
					if($def_settings['single_room_mode'] == "")
						$def['single_room_mode'] = "<option value=\"\" SELECTED>$txt[591]</option>";
					else
						$def['single_room_mode'] = "<option value=\"\">$txt[591]</option>";
						
					$query = $db->DoQuery("SELECT * FROM {$prefix}rooms");
					while($row = $db->Do_Fetch_Row($query)){
						if($def_settings['single_room_mode'] == $row[1])
							$def['single_room_mode'] .= "<option value=\"$row[1]\" SELECTED>$row[1]</option>";
						else
							$def['single_room_mode'] .= "<option value=\"$row[1]\">$row[1]</option>";
					}
						
					// Default values for these two fields since we need to convert milisconds to seconds
					$def['min_refresh'] = $def_settings['min_refresh']/1000;
					$def['max_refresh'] = $def_settings['max_refresh']/1000;
					
					if($def_settings['req_activation'] == 1)
						$def['req_activation'] = " checked=\"true\"";
					else
						$def['req_activation'] = "";
					
					$body = "<Br>
						<form action=\"./index.php?act=adminpanel&cp_page=settings&settings_page=general&update_settings=1\" method=\"POST\">
						<table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
							<tr>
								<td width=\"100\">$txt[329]: </td>
								<td width=\"100\"><input type=\"checkbox\" name=\"disable_chat\"{$def['disable_chat']} value=\"1\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[330]: </td>
								<td width=\"100\"><input type=\"checkbox\" name=\"allow_reg\"{$def['allow_reg']} value=\"1\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[331]: </td>
								<td width=\"100\"><input type=\"checkbox\" name=\"allow_guests\"{$def['allow_guests']} value=\"1\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[468]: </td>
								<td width=\"100\"><input type=\"checkbox\" name=\"log_bandwidth\"{$def['log_bandwidth']} value=\"1\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[207]: </td>
								<td width=\"100\"><input type=\"checkbox\" name=\"disable_sounds\"{$def['disable_sounds']} value=\"1\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[332]: </td>
								<td width=\"100\"><input type=\"text\" class=\"text_input\" name=\"site_name\" value=\"{$def_settings['site_name']}\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[333]: </td>
								<td width=\"100\"><input type=\"text\" class=\"text_input\" name=\"admin_email\" value=\"{$def_settings['admin_email']}\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[334]: </td>
								<td width=\"100\"><input type=\"text\" class=\"text_input\" name=\"logout_page\" value=\"{$def_settings['logout_page']}\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[335]: </td>
								<td width=\"100\"><input type=\"text\" class=\"text_input\" name=\"maxchars_status\" value=\"{$def_settings['maxchars_status']}\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[551]: </td>
								<td width=\"100\"><input type=\"text\" class=\"text_input\" name=\"banner_link\" value=\"{$def_settings['banner_link']}\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[515]*: </td>
								<td width=\"100\"><input type=\"text\" class=\"text_input\" name=\"maxchars_username\" value=\"{$def_settings['maxchars_username']}\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[336]*: </td>
								<td width=\"100\"><input type=\"text\" class=\"text_input\" name=\"maxchars_msg\" value=\"{$def_settings['maxchars_msg']}\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[337]*: </td>
								<td width=\"100\"><input type=\"text\" class=\"text_input\" name=\"max_offline_msgs\" value=\"{$def_settings['max_offline_msgs']}\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[338]* ($txt[351]): </td>
								<td width=\"100\"><input type=\"text\" class=\"text_input\" name=\"min_refresh\" value=\"{$def['min_refresh']}\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[339]* ($txt[351]): </td>
								<td width=\"100\"><input type=\"text\" class=\"text_input\" name=\"max_refresh\" value=\"{$def['max_refresh']}\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[341]: </td>
								<td width=\"100\">
									<select name=\"default_lang\" class=\"text_input\">
										{$def['default_lang']}
									</select>
								</td>
							</tr>
							<tr>
								<td width=\"100\">$txt[342]: </td>
								<td width=\"100\">
									<select name=\"default_skin\" class=\"text_input\">
										{$def['default_skin']}
									</select>
								</td>
							</tr>
							<tr>
								<td width=\"100\">$txt[357] ($txt[351]): </td>
								<td width=\"100\"><input type=\"text\" class=\"text_input\" name=\"cookie_time\" value=\"{$def_settings['cookie_time']}\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[590]<b>**</b>: </td>
								<td width=\"100\"><select class=\"text_input\" name=\"single_room_mode\">{$def['single_room_mode']}</select></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[616]: </td>
								<td width=\"100\"><input type=\"checkbox\" class=\"text_input\" value=\"1\" name=\"req_activation\"{$def['req_activation']}></td>
							</tr>
							<tr>
								<td width=\"200\" colspan=\"2\"><div align=\"center\"><input type=\"submit\" class=\"button\" value=\"$txt[187]\"></div></td>
							</tr>
							<tr>
								<td width=\"200\" colspan=\"2\"><b>* $txt[340]</b><Br><Br><b>** $txt[593]</b></td>
							</tr>
						</table>
						</form>";
						
				}elseif($_GET['settings_page'] == "user_agreement"){
					// The user agreement page
					$agreement = eregi_replace("<br>","\n",$x7c->settings['user_agreement']);
					$body = "<Br><div align=\"center\">$txt[518]<Br><Br>
						<form action=\"./index.php?act=adminpanel&cp_page=settings&settings_page=user_agreement&update_settings=1\" method=\"POST\">
							<textarea cols=\"35\" rows=\"15\" name=\"user_agreement\" class=\"text_input\">{$agreement}</textarea>
							<br>
							<input type=\"submit\" value=\"$txt[187]\" class=\"button\">
						</form></div>";
						
				}elseif($_GET['settings_page'] == "support"){
					// The chat support page
					$file = eregi_replace("/index\.php","",$_SERVER['PHP_SELF']);
					$html = "<a target=\"_blank\" href=\"http://$_SERVER[SERVER_NAME]$file/support.php\"><img src=\"http://$_SERVER[SERVER_NAME]$file/support.php?img=1\" border=\"0\"></a>";
					
					$body = "<Br><div align=\"center\">$txt[604]<Br><Br>
						<form action=\"./index.php?act=adminpanel&cp_page=settings&settings_page=support&update_settings=1\" method=\"POST\">
						<table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
							<tr>
								<td width=\"100\">$txt[605]*: </td>
								<td width=\"100\"><input type=\"text\" name=\"support_personel\" value=\"{$def_settings['support_personel']}\" class=\"text_input\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[606]: </td>
								<td width=\"100\"><input type=\"text\" name=\"support_message\" value=\"{$def_settings['support_message']}\" class=\"text_input\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[607]: </td>
								<td width=\"100\"><input type=\"text\" name=\"support_image_online\" value=\"{$def_settings['support_image_online']}\" class=\"text_input\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[608]: </td>
								<td width=\"100\"><input type=\"text\" name=\"support_image_offline\" value=\"{$def_settings['support_image_offline']}\" class=\"text_input\"></td>
							</tr>
							</table>
							<input type=\"submit\" value=\"$txt[187]\" class=\"button\"><Br><Br>
							<b>*: $txt[609]</b><br><Br>
							<b>Copy this HTML code anywhere onto your website to display the live help image.</b><Br>
							<textarea cols=\"30\" rows=\"5\">{$html}</textarea><Br><Br>
							Preview: <br>
							{$html}
							<Br><Br>
						</form></div>";
				
				}elseif($_GET['settings_page'] == "logs"){
				
					// Get defaults
					if($def_settings['enable_logging'] == 1)
						$def['enable_logging'] = "checked=\"true\"";
					else
						$def['enable_logging'] = "";
						
					// Convert these from bytes to kilobytes
					$def['max_log_user'] = $def_settings['max_log_user']/1024;
					$def['max_log_room'] = $def_settings['max_log_room']/1024;
					
					$body = "<Br>
						<form action=\"./index.php?act=adminpanel&cp_page=settings&settings_page=logs&update_settings=1\" method=\"POST\">
						<table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
							<tr>
								<td width=\"100\">$txt[244]: </td>
								<td width=\"100\"><input type=\"checkbox\" name=\"enable_logging\"{$def['enable_logging']} value=\"1\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[345]**: </td>
								<td width=\"100\"><input type=\"text\" class=\"text_input\" name=\"logs_path\" value=\"{$def_settings['logs_path']}\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[346]*: </td>
								<td width=\"100\"><input type=\"text\" class=\"text_input\" name=\"max_log_room\" value=\"{$def['max_log_room']}\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[347]*: </td>
								<td width=\"100\"><input type=\"text\" class=\"text_input\" name=\"max_log_user\" value=\"{$def['max_log_user']}\"></td>
							</tr>
							<tr>
								<td width=\"200\" colspan=\"2\"><div align=\"center\"><input type=\"submit\" class=\"button\" value=\"$txt[187]\"></div></td>
							</tr>
							<tr>
								<td width=\"200\" colspan=\"2\"><b>* $txt[340]</b><Br><b>** $txt[522]</b></td>
							</tr>
						</table>
						</form>";
				
				}elseif($_GET['settings_page'] == "timedate"){
				
					$thelp = $print->help_button("time_date");
					$body = "<Br>
						<form action=\"./index.php?act=adminpanel&cp_page=settings&settings_page=timedate&update_settings=1\" method=\"POST\">
						<table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
							<tr>
								<td width=\"100\">$txt[348]: $thelp</td>
								<td width=\"100\"><input type=\"text\" class=\"text_input\" name=\"date_format\" value=\"{$def_settings['date_format']}\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[349]: $thelp</td>
								<td width=\"100\"><input type=\"text\" class=\"text_input\" name=\"date_format_date\" value=\"{$def_settings['date_format_date']}\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[350]: </td>
								<td width=\"100\"><input type=\"text\" class=\"text_input\" name=\"date_format_full\" value=\"{$def_settings['date_format_full']}\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[201]: </td>
								<td width=\"100\"><input type=\"text\" class=\"text_input\" name=\"time_offset_hours\" value=\"{$def_settings['time_offset_hours']}\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[202]: </td>
								<td width=\"100\"><input type=\"text\" class=\"text_input\" name=\"time_offset_mins\" value=\"{$def_settings['time_offset_mins']}\"></td>
							</tr>
							<tr>
								<td width=\"200\" colspan=\"2\"><div align=\"center\"><input type=\"submit\" class=\"button\" value=\"$txt[187]\"></div></td>
							</tr>
						</table>
						</form>";
				
				}elseif($_GET['settings_page'] == "exptime"){
				
					// Convert default values from miliseconds to second
					$def['expire_messages'] = $def_settings['expire_messages']/60;
					$def['expire_rooms'] = $def_settings['expire_rooms']/60;
					$def['expire_guests'] = $def_settings['expire_guests']/60;
				
					$body = "<Br>
						<form action=\"./index.php?act=adminpanel&cp_page=settings&settings_page=exptime&update_settings=1\" method=\"POST\">
						<table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
							<tr>
								<td width=\"100\">$txt[352] ($txt[351]): </td>
								<td width=\"100\"><input type=\"text\" class=\"text_input\" name=\"online_time\" value=\"{$def_settings['online_time']}\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[353]* ($txt[356]): </td>
								<td width=\"100\"><input type=\"text\" class=\"text_input\" name=\"expire_messages\" value=\"{$def['expire_messages']}\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[354]* ($txt[356]): </td>
								<td width=\"100\"><input type=\"text\" class=\"text_input\" name=\"expire_rooms\" value=\"{$def['expire_rooms']}\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[355]* ($txt[356]): </td>
								<td width=\"100\"><input type=\"text\" class=\"text_input\" name=\"expire_guests\" value=\"{$def['expire_guests']}\"></td>
							</tr>
							<tr>
								<td width=\"200\" colspan=\"2\"><div align=\"center\"><input type=\"submit\" class=\"button\" value=\"$txt[187]\"></div></td>
							</tr>
							<tr>
								<td width=\"200\" colspan=\"2\"><b>* $txt[340]</b></td>
							</tr>
						</table>
						</form>";
				
				}elseif($_GET['settings_page'] == "styles"){
				
					// Calculate default check box values
					$checkboxs[] = "enable_roombgs";
					$checkboxs[] = "enable_roomlogo";
					$checkboxs[] = "disable_smiles";
					$checkboxs[] = "disable_styles";
					$checkboxs[] = "disable_autolinking";
					foreach($checkboxs as $key=>$val){
						if($def_settings[$val] == 1)
							$def[$val] = " CHECKED=\"true\"";
						else
							$def[$val] = "";
					}
				
					$body = "<Br>
						<form action=\"./index.php?act=adminpanel&cp_page=settings&settings_page=styles&update_settings=1\" name=\"settings_form\" method=\"POST\">
						<table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
							<tr>
								<td width=\"100\">$txt[324]: </td>
								<td width=\"100\"><input type=\"text\" class=\"text_input\" name=\"banner_url\" value=\"{$def_settings['banner_url']}\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[358]: </td>
								<td width=\"100\"><input type=\"text\" class=\"text_input\" name=\"background_image\" value=\"{$def_settings['background_image']}\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[359]: </td>
								<td width=\"100\"><input type=\"checkbox\" name=\"enable_roombgs\"{$def['enable_roombgs']} value=\"1\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[360]: </td>
								<td width=\"100\"><input type=\"checkbox\" name=\"enable_roomlogo\"{$def['enable_roomlogo']} value=\"1\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[361]: </td>
								<td width=\"100\"><input type=\"text\" class=\"text_input\" name=\"default_font\" style=\"font-family: {$def_settings['default_font']};\" value=\"{$def_settings['default_font']}\" onChange=\"this.style.fontFamily=this.value\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[362]: </td>
								<td width=\"100\"><input type=\"text\" class=\"text_input\" name=\"default_size\" value=\"{$def_settings['default_size']}\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[363]: &nbsp;&nbsp;<img src=\"./colors.png\" width=\"15\" height=\"15\" onClick=\"javascript: window.open('./index.php?act=sm_window&page=colors&toform=settings_form&tofield=default_color','','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width={$x7c->settings['tweak_window_small_width']},height={$x7c->settings['tweak_window_small_height']}');\"></td>
								<td width=\"100\"><input type=\"text\" class=\"text_input\" name=\"default_color\" value=\"{$def_settings['default_color']}\" style=\"color: {$def_settings['default_color']};\" onChange=\"this.style.color=this.value\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[364]: </td>
								<td width=\"100\"><input type=\"text\" class=\"text_input\" name=\"style_min_size\" value=\"{$def_settings['style_min_size']}\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[365]: </td>
								<td width=\"100\"><input type=\"text\" class=\"text_input\" name=\"style_max_size\" value=\"{$def_settings['style_max_size']}\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[366]: </td>
								<td width=\"100\"><input type=\"checkbox\" name=\"disable_smiles\"{$def['disable_smiles']} value=\"1\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[367]: </td>
								<td width=\"100\"><input type=\"checkbox\" name=\"disable_styles\"{$def['disable_styles']} value=\"1\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[368]: </td>
								<td width=\"100\"><input type=\"checkbox\" name=\"disable_autolinking\"{$def['disable_autolinking']} value=\"1\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[369]: &nbsp;&nbsp;<img src=\"./colors.png\" width=\"15\" height=\"15\" onClick=\"javascript: window.open('./index.php?act=sm_window&page=colors&toform=settings_form&tofield=system_message_color','','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width={$x7c->settings['tweak_window_small_width']},height={$x7c->settings['tweak_window_small_height']}');\"></td>
								<td width=\"100\"><input type=\"text\" class=\"text_input\" name=\"system_message_color\" value=\"{$def_settings['system_message_color']}\" style=\"color: {$def_settings['system_message_color']};\" onChange=\"this.style.color=this.value\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[370]: </td>
								<td width=\"100\"><input type=\"text\" class=\"text_input\" name=\"style_allowed_fonts\" value=\"{$def_settings['style_allowed_fonts']}\"></td>
							</tr>
							<tr>
								<td width=\"200\" colspan=\"2\"><div align=\"center\"><input type=\"submit\" class=\"button\" value=\"$txt[187]\"></div></td>
							</tr>
							<tr>
								<td width=\"200\" colspan=\"2\"><b>* $txt[371]</b></td>
							</tr>
						</table>
						</form>";
				
				}elseif($_GET['settings_page'] == "avatars"){
				
					// Get Default checkbox values
					if($def_settings['enable_avatar_uploads'] == 1)
						$def['enable_avatar_uploads'] = " checked=\"true\"";
					else
						$def['enable_avatar_uploads'] = "";
					if($def_settings['resize_smaller_avatars'] == 1)
						$def['resize_smaller_avatars'] = " checked=\"true\"";
					else
						$def['resize_smaller_avatars'] = "";
						
					// Convert from bytes to kilobytes
					$def['avatar_max_size'] = $def_settings['avatar_max_size']/1024;
				
					$body = "<Br>
						<form action=\"./index.php?act=adminpanel&cp_page=settings&settings_page=avatars&update_settings=1\" method=\"POST\">
						<table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
							<tr>
								<td width=\"100\">$txt[372]: </td>
								<td width=\"100\"><input type=\"checkbox\" name=\"enable_avatar_uploads\"{$def['enable_avatar_uploads']} value=\"1\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[373]: </td>
								<td width=\"100\"><input type=\"checkbox\" name=\"resize_smaller_avatars\"{$def['resize_smaller_avatars']} value=\"1\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[374]: </td>
								<td width=\"100\"><input type=\"text\" class=\"text_input\" name=\"avatar_max_size\" value=\"{$def['avatar_max_size']}\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[375]: </td>
								<td width=\"100\"><input type=\"text\" class=\"text_input\" name=\"avatar_size_px\" value=\"{$def_settings['avatar_size_px']}\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[376]: </td>
								<td width=\"100\"><input type=\"text\" class=\"text_input\" name=\"uploads_path\" value=\"{$def_settings['uploads_path']}\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[377]: </td>
								<td width=\"100\"><input type=\"text\" class=\"text_input\" name=\"uploads_url\" value=\"{$def_settings['uploads_url']}\"></td>
							</tr>
							<tr>
								<td width=\"200\" colspan=\"2\"><div align=\"center\"><input type=\"submit\" class=\"button\" value=\"$txt[187]\"></div></td>
							</tr>
						</table>
						</form>";
				
				}elseif($_GET['settings_page'] == "loginpage"){
				
					// Calculate default check box values
					$checkboxs[] = "show_stats";
					$checkboxs[] = "enable_passreminder";
					$checkboxs[] = "show_events";
					foreach($checkboxs as $key=>$val){
						if($def_settings[$val] == 1)
							$def[$val] = " checked=\"true\"";
						else
							$def[$val] = "";
					}
					
					// Default radio button properties
					if($def_settings['events_show3day'] == 1){
						$def['events_show3day'] = " checked=\"true\"";
						$def['events_showmonth'] = "";
					}else{
						$def['events_show3day'] = "";
						$def['events_showmonth'] = " checked=\"true\"";
					}
					
					// Adjust this wierd little property
					$def['events_3day_number'] = $def_settings['events_3day_number']+1;
				
					$body = "<Br>
						<form action=\"./index.php?act=adminpanel&cp_page=settings&settings_page=loginpage&update_settings=1\" method=\"POST\">
						<table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
							<tr>
								<td width=\"100\">$txt[262]: </td>
								<td width=\"100\"><input type=\"text\" class=\"text_input\" name=\"news\" value=\"{$def_settings['news']}\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[379]: </td>
								<td width=\"100\"><input type=\"checkbox\" name=\"show_stats\"{$def['show_stats']} value=\"1\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[380]: </td>
								<td width=\"100\"><input type=\"checkbox\" name=\"enable_passreminder\"{$def['enable_passreminder']} value=\"1\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[378]: </td>
								<td width=\"100\"><input type=\"checkbox\" name=\"show_events\"{$def['show_events']} value=\"1\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[378]: </td>
								<td width=\"100\">
									<input type=\"radio\" name=\"event_show\" value=\"events_showmonth\"{$def['events_showmonth']}> $txt[382]<Br>
									<input type=\"radio\" name=\"event_show\" value=\"events_show3day\"{$def['events_show3day']}> $txt[383]
								</td>
							</tr>
							<tr>
								<td width=\"100\">$txt[381]: </td>
								<td width=\"100\"><input type=\"text\" class=\"text_input\" name=\"events_3day_number\" value=\"{$def['events_3day_number']}\"></td>
							</tr>
							<tr>
								<td width=\"200\" colspan=\"2\"><div align=\"center\"><input type=\"submit\" class=\"button\" value=\"$txt[187]\"></div></td>
							</tr>
						</table>
						</form>";
				
				}elseif($_GET['settings_page'] == "advanced"){
				
					// Default values
					if($def_settings['disable_gd'] == 1)
						$def['disable_gd'] = " checked=\"true\"";
					else
						$def['disable_gd'] = "";
				
					$body = "<Br>$txt[385]<Br><Br>
						<form action=\"./index.php?act=adminpanel&cp_page=settings&settings_page=advanced&update_settings=1\" method=\"POST\">
						<table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
							<tr>
								<td width=\"100\">$txt[384]: </td>
								<td width=\"100\"><input type=\"checkbox\" name=\"disable_gd\"{$def['disable_gd']} value=\"1\"></td>
							</tr>
							<tr>
								<td width=\"200\" colspan=\"2\"><div align=\"center\"><input type=\"submit\" class=\"button\" value=\"$txt[187]\"></div></td>
							</tr>
						</table>
						</form>";
				
				}
				
				
			}else{
				// Display the many catagories of settings
				$body = "
					<div align=\"center\">$txt[321]
						<br><Br>
						<a href=\"./index.php?act=adminpanel&cp_page=settings&settings_page=general\">[$txt[218]]</a><br><br>
						<a href=\"./index.php?act=adminpanel&cp_page=settings&settings_page=logs\">[$txt[240]]</a><br><br>
						<a href=\"./index.php?act=adminpanel&cp_page=settings&settings_page=timedate\">[$txt[322]]</a><br><br>
						<a href=\"./index.php?act=adminpanel&cp_page=settings&settings_page=exptime\">[$txt[323]]</a><br><br>
						<a href=\"./index.php?act=adminpanel&cp_page=settings&settings_page=styles\">[$txt[325]]</a><br><br>
						<a href=\"./index.php?act=adminpanel&cp_page=settings&settings_page=avatars\">[$txt[326]]</a><br><br>
						<a href=\"./index.php?act=adminpanel&cp_page=settings&settings_page=loginpage\">[$txt[327]]</a><br><br>
						<a href=\"./index.php?act=adminpanel&cp_page=settings&settings_page=user_agreement\">[$txt[517]]</a><br><br>
						<a href=\"./index.php?act=adminpanel&cp_page=settings&settings_page=support\">[$txt[599]]</a><br><br>
						<a href=\"./index.php?act=adminpanel&cp_page=settings&settings_page=advanced\">[$txt[328]]</a><br><br>
					</div>";
			}
		
		}elseif($_GET['cp_page'] == "themes"){
		
			$head = $txt[308];
		
			// Make sure the subpage is set, or else set it to main
			if(!isset($_GET['theme_page']))
				$theme_page = "main";
			else
				$theme_page = $_GET['theme_page'];
		
			// Show them the page they want
			if($theme_page == "main"){
			
				$body = "<Br><div align=\"center\"><b>$txt[36]</b><Br>
					<table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"col_header\">
						<tr>
							<td width=\"150\" height=\"25\">&nbsp;$txt[390]</td>
							<td width=\"100\" height=\"25\">$txt[86]</td>
						</tr>
					</table>
					<table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"inside_table\">";
						
				$skin_dir = dir("./themes");
				$installed_themes = array();
				while($option = $skin_dir->read()){
					if($option != "." && $option != ".."){
						if(@include("./themes/$option/theme.info")){
							$installed_themes[] = $name;
							// See if this theme is editable
							if($theme_type == 1)
								$edit = "<a href=\"./index.php?act=adminpanel&cp_page=themes&theme_page=creator&edit=$option\">[$txt[459]]</a>";
							else
								$edit = "";
							
							$body .= "<tr>
										<td width=\"150\" class=\"dark_row\">&nbsp;<a href=\"./index.php?act=adminpanel&cp_page=themes&theme_page=info&theme=$option\">$name</a></td>
										<td width=\"100\" class=\"dark_row\"><a href=\"./index.php?act=adminpanel&cp_page=themes&theme_page=delete&theme=$option\">[$txt[175]]</a> {$edit}</td>
									</tr>";
						}
					}
				}
				
				$body .= "</table><Br><Br>";
				
				// This section shows themes that are available to be installed
				
				// Get the uploaded themes
				include("./lib/xupdater.php");
				$uploaded_themes = get_uploaded_themes();
				if(is_array($uploaded_themes)){
					$body .= "$txt[399]<Br>
						<table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"col_header\">
							<tr>
								<td width=\"150\" height=\"25\">&nbsp;$txt[390]</td>
								<td width=\"100\" height=\"25\">$txt[86]</td>
							</tr>
						</table>
						<table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"inside_table\">";

						foreach($uploaded_themes as $key=>$val){
							// Make sure this theme isn't installed already
							if(!in_array($val['name'],$installed_themes)){

								$body .= "<tr>
											<td width=\"150\" class=\"dark_row\">&nbsp;<a href=\"./index.php?act=adminpanel&cp_page=themes&theme_page=info&packed=1&theme=$val[name]\">$val[name]</a></td>
											<td width=\"100\" class=\"dark_row\"><a href=\"./index.php?act=adminpanel&cp_page=themes&theme_page=install&theme=$val[file]\">[$txt[400]]</a></td>
										</tr>";

							}
						}
						
						$body .= "</table><Br><br>";
						
					}elseif($uploaded_themes == 2){
						// The themes directory can't be written to
						$body .= "$txt[401]<br><Br>";
					}
					
					// Give them a link to download new themes
					$body .= "<a href=\"http://themes.x7chat.com\" target=\"_blank\">$txt[406]</a><Br><Br>";
					// GIve them a link to create their own theme
					$body .= "<a href=\"index.php?act=adminpanel&cp_page=themes&theme_page=creator\">$txt[526]</a><Br><br></div>";
				
			
			}elseif($theme_page == "delete"){
				
				// The user has said they want to delete a theme
				// Confirm this choice, we don't want them to accidentally delete a theme
				if(!isset($_GET['confirmed'])){
					$body = "<div align=\"center\">$txt[391]<Br>
					<a href=\"./index.php?act=adminpanel&cp_page=themes\">$txt[393]</a> | <a href=\"./index.php?act=adminpanel&cp_page=themes&theme_page=delete&theme=$_GET[theme]&confirmed=1\">$txt[392]</a></div>";
				}else{
					// Make sure we are not trying to delete the default theme
					if($_GET['theme'] == $x7c->settings['default_skin']){
						$body = "<div align=\"center\">$txt[612]<Br><Br><a href=\"./index.php?act=adminpanel&cp_page=themes\">$txt[77]</a></div>";
					}else{
					
						// Make sure the themes directory is 777\
						if(is_writeable("./themes")){
	
							// Delete the theme files
							$skin_dir = dir("./themes/$_GET[theme]");
							while($option = $skin_dir->read()){
								if($option != "." && $option != ".."){
									@unlink("./themes/$_GET[theme]/$option");
								}
							}
							// Delete the directory
							if(!@rmdir("./themes/$_GET[theme]")){
								$txt[395] = eregi_replace("_d","$_GET[theme]",$txt[395]);
								$body = "<div align=\"center\">$txt[395]<Br><Br><a href=\"./index.php?act=adminpanel&cp_page=themes\">$txt[77]</a></div>";
							}else{
								$body = "<div align=\"center\">$txt[394]<Br><Br>$txt[396]<Br><Br><a href=\"./index.php?act=adminpanel&cp_page=themes\">$txt[77]</a></div>";
							}
						}else{
							// Make them CHMOD the themes directory
							$body = "<div align=\"center\">$txt[397]<Br><Br><a href=\"./index.php?act=adminpanel&cp_page=themes&theme_page=delete&theme=$_GET[theme]&confirmed=1\">$txt[398]</a><Br><a href=\"./index.php?act=adminpanel&cp_page=themes\">$txt[77]</a></div>";
						}
					}
				}
			
			}elseif($theme_page == "install"){
				// Time to install a theme, how exciting!
				include("./lib/xupdater.php");
				if(install_theme($_GET['theme']) == 1){
					$body = "<div align=\"center\">$txt[402]<Br><Br>$txt[396]<Br><br><a href=\"./index.php?act=adminpanel&cp_page=themes\">$txt[77]</a></div>";
				}else{
					// They need to CHMOD 777 the themes directory
					$body = "<div align=\"center\">$txt[397]<Br><Br><a href=\"./index.php?act=adminpanel&cp_page=themes&theme_page=install&theme=$_GET[theme]\">$txt[398]</a><br><a href=\"./index.php?act=adminpanel&cp_page=themes\">$txt[77]</a></div>";
				}
			
			}elseif($theme_page == "info"){
				// View information on a particular theme
				// Get the info
				if(!isset($_GET['packed'])){
				
					include("./themes/$_GET[theme]/theme.info");
				
				}else{
				
					include("./lib/xupdater.php");
					$uploaded_themes = get_uploaded_themes();
					foreach($uploaded_themes as $key=>$val){
						if($val['name'] == $_GET['theme']){
							$name = $val['name'];
							$website = $val['website'];
							$version = $val['version'];
							$date = $val['date'];
							$author = $val['author'];
							$description = $val['desc'];
							$copyright = $val['copyright'];
							break;
						}
					}
					
				}
				
				// Send output
				$body = "<div align=\"center\"><Br><Br>
						<table border=\"0\" cellspacing=\"0\" cellpadding=\"5\">
							<tr>
								<td width=\"100\"><b>$txt[31]</b>:</td>
								<td width=\"150\"><a href=\"$website\" target=\"_blank\">$name</a> (v$version)</td>
							</tr>
							<tr>
								<td width=\"100\"><b>$txt[403]</b>:</td>
								<td width=\"150\">$date</td>
							</tr>
							<tr>
								<td width=\"100\"><b>$txt[404]</b>:</td>
								<td width=\"150\">$author</td>
							</tr>
							<tr>
								<td width=\"100\"><b>$txt[405]</b>:</td>
								<td width=\"150\">$description</td>
							</tr>
							<tr>
								<td width=\"250\" colspan=\"2\" style=\"text-align: center\"><b>$copyright</b></td>
							</tr>
						</table>
						<a href=\"javascript: history.back()\">$txt[77]</a></div>";
			}elseif($theme_page == "creator"){
			
				$body = "";
			
				// Include the theme creator librarys
				include("./lib/theme_creator.php");
				
				
				// Check file permissions
				if(is_writeable("./themes") && (!isset($_GET['edit']) || @is_writeable("./themes/$_GET[edit]"))){
				
					if(isset($_GET['do_create'])){
						// They are ready to create the new theme	
						if(!is_dir("./themes/template")){
							$body = $txt[557]."<Br><Br><a href=\"index.php?act=adminpanel&cp_page=themes\">$txt[77]</a>";
						}else{
							// Check for proper name
							if(@$_POST['theme_name'] == "" || !isset($_POST['theme_name'])){
								$body = "$txt[559]<Br><Br><a href=\"javascript: history.back();\">$txt[77]</a>";
							}else{
								//Create the THEME!
								$_GET['do_edit'] = eregi_replace("[^0-9_A-z]","",$_POST['theme_name']);
								mkdir("./themes/$_GET[do_edit]");
								copy("./themes/template/blanksmile.gif","./themes/$_GET[do_edit]/blanksmile.gif");
								copy("./themes/template/button.gif","./themes/$_GET[do_edit]/button.gif");
								copy("./themes/template/button_over.gif","./themes/$_GET[do_edit]/button_over.gif");
								copy("./themes/template/colheader.gif","./themes/$_GET[do_edit]/colheader.gif");
								copy("./themes/template/headerbg.png","./themes/$_GET[do_edit]/headerbg.png");
								copy("./themes/template/help.gif","./themes/$_GET[do_edit]/help.gif");
								//copy("./themes/template/inputbox.gif","./themes/$_GET[do_edit]/inputbox.gif");
								copy("./themes/template/key.gif","./themes/$_GET[do_edit]/key.gif");
								copy("./themes/template/logo.gif","./themes/$_GET[do_edit]/logo.gif");
								copy("./themes/template/new_mail.gif","./themes/$_GET[do_edit]/new_mail.gif");
								copy("./themes/template/old_mail.gif","./themes/$_GET[do_edit]/old_mail.gif");
								copy("./themes/template/selectarrow.gif","./themes/$_GET[do_edit]/selectarrow.gif");
								copy("./themes/template/selectarrow_over.gif","./themes/$_GET[do_edit]/selectarrow_over.gif");
								copy("./themes/template/selectbar.gif","./themes/$_GET[do_edit]/selectbar.gif");
								copy("./themes/template/selectbar_inv.gif","./themes/$_GET[do_edit]/selectbar_inv.gif");
								copy("./themes/template/send.gif","./themes/$_GET[do_edit]/send.gif");
								copy("./themes/template/send_over.gif","./themes/$_GET[do_edit]/send_over.gif");
								copy("./themes/template/spacer.gif","./themes/$_GET[do_edit]/spacer.gif");
								copy("./themes/template/star.gif","./themes/$_GET[do_edit]/star.gif");
								copy("./themes/template/user_control_bg2.gif","./themes/$_GET[do_edit]/user_control_bg2.gif");
								copy("./themes/template/user_control_bg.gif","./themes/$_GET[do_edit]/user_control_bg.gif");
								
								//copy("./themes/template/css.css","./themes/$_GET[do_edit]/css.css");
								copy("./themes/template/info_box.tpl","./themes/$_GET[do_edit]/info_box.tpl");
								//copy("./themes/template/ss_chatinput.css","./themes/$_GET[do_edit]/ss_chatinput.css");
								//copy("./themes/template/ss_events.css","./themes/$_GET[do_edit]/ss_events.css");
								//copy("./themes/template/ss_mini.css","./themes/$_GET[do_edit]/ss_mini.css");
								//copy("./themes/template/ss_pm.css","./themes/$_GET[do_edit]/ss_pm.css");
								//copy("./themes/template/ss_profile.css","./themes/$_GET[do_edit]/ss_profile.css");
								//copy("./themes/template/ss_uc.css","./themes/$_GET[do_edit]/ss_uc.css");
								//copy("./themes/template/ss_ucp.css","./themes/$_GET[do_edit]/ss_ucp.css");
								copy("./themes/template/window.tpl","./themes/$_GET[do_edit]/window.tpl");
								copy("./themes/template/theme.data","./themes/$_GET[do_edit]/theme.data");
							}
						}
					}
					
					if(isset($_GET['do_edit'])){
						// They want to edit an existing theme
						
						edit_file($_GET['do_edit']);
						
						$date = date("m/d/Y");
						$date_y = date("Y");
						$fh = fopen("./themes/$_GET[do_edit]/theme.info","w");
						fwrite($fh,"<?PHP
	// Theme Info File
	// Created By X7 Chat Theme Creator

	// ------------------ Theme Info ------------------ 
	\$author = \"$_POST[theme_author]\";
	\$date = \"$date\";
	\$name = \"$_POST[theme_name]\";
	\$description = \"$_POST[theme_description]\";
	\$version = \"$_POST[theme_version]\";
	\$copyright = \"Copyright $date_y by $_POST[theme_author]\";
	\$website = \"\";

	// 1 For simple, 2 for advanced
	\$theme_type = 1;
?>");
						fclose($fh);
						
						$body = "$txt[558]<br><Br><a href=\"index.php?act=adminpanel&cp_page=themes\">$txt[77]</a>";
						
					}elseif($body == ""){
						// Display the form to create a brand new theme or if $_GET['edit'] is set then edit that existing theme
						
						// See if they want to edit an existing one, if so, damn we have to go through a ton of work to load it
						if(isset($_GET['edit'])){
							// ok fine, make us go through tons of work since the user couldn't get it right the first time
							$def = load_styles($_GET['edit']);
							$mode = "&do_edit=$_GET[edit]";
						}else{
							// Ok, defaults can be blank
							$def = load_styles("");
							$mode = "&do_create=1";
						}
						
						// Print the form
						$body = "
						<form name=\"themes_form\" align=\"center\" action=\"index.php?act=adminpanel&cp_page=themes&theme_page=creator{$mode}\" method=\"post\">
							<table border=\"0\" cellspacing=\"5\" cellpadding=\"0\">
								<tr>
									<td colspan=\"2\"><B>$txt[578]</b><Br><Br></td>
								</tr>
								<tr>
									<td width=\"150\" height=\"25\">$txt[552]</td>
									<td width=\"150\" height=\"25\"><input type=\"text\" name=\"theme_name\" value=\"{$def['theme_name']}\" class=\"text_input\"></td>
								</tr>
								<tr>
									<td width=\"150\" height=\"25\">$txt[554]</td>
									<td width=\"150\" height=\"25\"><input type=\"text\" name=\"theme_author\" value=\"{$def['theme_author']}\" class=\"text_input\"></td>
								</tr>
								<tr>
									<td width=\"150\" height=\"25\">$txt[555]</td>
									<td width=\"150\" height=\"25\"><input type=\"text\" name=\"theme_description\" value=\"{$def['theme_description']}\" class=\"text_input\"></td>
								</tr>
								<tr>
									<td width=\"150\" height=\"25\">$txt[556]</td>
									<td width=\"150\" height=\"25\"><input type=\"text\" name=\"theme_version\" value=\"{$def['theme_version']}\" class=\"text_input\"></td>
								</tr>
								<tr>
									<td colspan=\"2\"><br><hr><b>$txt[579]</b><Br><br></td>
								</tr>
								<tr>
									<td width=\"150\" height=\"25\">$txt[530]: &nbsp;&nbsp;<img src=\"./colors.png\" style=\"cursor: pointer;cursor: hand;\" width=\"15\" height=\"15\" onClick=\"javascript: window.open('./index.php?act=sm_window&page=colors&toform=themes_form&tofield=font_color_1','','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width={$x7c->settings['tweak_window_small_width']},height={$x7c->settings['tweak_window_small_height']}');\"></td>
									<td width=\"150\" height=\"25\"><input type=\"text\" name=\"font_color_1\" value=\"{$def['font_color_1']}\" class=\"text_input\"></td>
								</tr>
								<tr>
									<td width=\"150\" height=\"25\">$txt[531]: &nbsp;&nbsp;<img src=\"./colors.png\" style=\"cursor: pointer;cursor: hand;\" width=\"15\" height=\"15\" onClick=\"javascript: window.open('./index.php?act=sm_window&page=colors&toform=themes_form&tofield=font_color_2','','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width={$x7c->settings['tweak_window_small_width']},height={$x7c->settings['tweak_window_small_height']}');\"></td>
									<td width=\"150\" height=\"25\"><input type=\"text\" name=\"font_color_2\" value=\"{$def['font_color_2']}\" class=\"text_input\"></td>
								</tr>
								<tr>
									<td width=\"150\" height=\"25\">$txt[532]: &nbsp;&nbsp;<img src=\"./colors.png\" style=\"cursor: pointer;cursor: hand;\" width=\"15\" height=\"15\" onClick=\"javascript: window.open('./index.php?act=sm_window&page=colors&toform=themes_form&tofield=font_color_3','','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width={$x7c->settings['tweak_window_small_width']},height={$x7c->settings['tweak_window_small_height']}');\"></td>
									<td width=\"150\" height=\"25\"><input type=\"text\" name=\"font_color_3\" value=\"{$def['font_color_3']}\" class=\"text_input\"></td>
								</tr>
								<tr>
									<td width=\"150\" height=\"25\">$txt[563]: &nbsp;&nbsp;<img src=\"./colors.png\" style=\"cursor: pointer;cursor: hand;\" width=\"15\" height=\"15\" onClick=\"javascript: window.open('./index.php?act=sm_window&page=colors&toform=themes_form&tofield=font_color_0','','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width={$x7c->settings['tweak_window_small_width']},height={$x7c->settings['tweak_window_small_height']}');\"></td>
									<td width=\"150\" height=\"25\"><input type=\"text\" name=\"font_color_0\" value=\"{$def['font_color_0']}\" class=\"text_input\"></td>
								</tr>
								<tr>
									<td width=\"150\" height=\"25\">$txt[533]</td>
									<td width=\"150\" height=\"25\"><input type=\"text\" name=\"fonts\" value=\"{$def['fonts']}\" class=\"text_input\"></td>
								</tr>
								<tr>
									<td width=\"150\" height=\"25\">$txt[534]</td>
									<td width=\"150\" height=\"25\"><input type=\"text\" name=\"font_size_0\" value=\"{$def['font_size_0']}\" class=\"text_input\"></td>
								</tr>
								<tr>
									<td width=\"150\" height=\"25\">$txt[535]</td>
									<td width=\"150\" height=\"25\"><input type=\"text\" name=\"font_size_1\" value=\"{$def['font_size_1']}\" class=\"text_input\"></td>
								</tr>
								<tr>
									<td width=\"150\" height=\"25\">$txt[536]</td>
									<td width=\"150\" height=\"25\"><input type=\"text\" name=\"font_size_2\" value=\"{$def['font_size_2']}\" class=\"text_input\"></td>
								</tr>
								<tr>
									<td width=\"150\" height=\"25\">$txt[537]</td>
									<td width=\"150\" height=\"25\"><input type=\"text\" name=\"font_size_3\" value=\"{$def['font_size_3']}\" class=\"text_input\"></td>
								</tr>
								<tr>
									<td colspan=\"2\"><br><hr><b>$txt[580]</b><Br><br></td>
								</tr>
								<tr>
									<td width=\"150\" height=\"25\">$txt[527]: &nbsp;&nbsp;<img src=\"./colors.png\" style=\"cursor: pointer;cursor: hand;\" width=\"15\" height=\"15\" onClick=\"javascript: window.open('./index.php?act=sm_window&page=colors&toform=themes_form&tofield=background_color_1','','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width={$x7c->settings['tweak_window_small_width']},height={$x7c->settings['tweak_window_small_height']}');\"></td>
									<td width=\"150\" height=\"25\"><input type=\"text\" name=\"background_color_1\" value=\"{$def['background_color_1']}\" class=\"text_input\"></td>
								</tr>
								<tr>
									<td width=\"150\" height=\"25\">$txt[528]: &nbsp;&nbsp;<img src=\"./colors.png\" style=\"cursor: pointer;cursor: hand;\" width=\"15\" height=\"15\" onClick=\"javascript: window.open('./index.php?act=sm_window&page=colors&toform=themes_form&tofield=background_color_2','','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width={$x7c->settings['tweak_window_small_width']},height={$x7c->settings['tweak_window_small_height']}');\"></td>
									<td width=\"150\" height=\"25\"><input type=\"text\" name=\"background_color_2\" value=\"{$def['background_color_2']}\" class=\"text_input\"></td>
								</tr>
								<tr>
									<td width=\"150\" height=\"25\">$txt[529]: &nbsp;&nbsp;<img src=\"./colors.png\" style=\"cursor: pointer;cursor: hand;\" width=\"15\" height=\"15\" onClick=\"javascript: window.open('./index.php?act=sm_window&page=colors&toform=themes_form&tofield=background_color_3','','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width={$x7c->settings['tweak_window_small_width']},height={$x7c->settings['tweak_window_small_height']}');\"></td>
									<td width=\"150\" height=\"25\"><input type=\"text\" name=\"background_color_3\" value=\"{$def['background_color_3']}\" class=\"text_input\"></td>
								</tr>
								<tr>
									<td width=\"150\" height=\"25\">$txt[585]: &nbsp;&nbsp;<img src=\"./colors.png\" style=\"cursor: pointer;cursor: hand;\" width=\"15\" height=\"15\" onClick=\"javascript: window.open('./index.php?act=sm_window&page=colors&toform=themes_form&tofield=background_color_4','','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width={$x7c->settings['tweak_window_small_width']},height={$x7c->settings['tweak_window_small_height']}');\"></td>
									<td width=\"150\" height=\"25\"><input type=\"text\" name=\"background_color_4\" value=\"{$def['background_color_4']}\" class=\"text_input\"></td>
								</tr>
								<tr>
									<td width=\"150\" height=\"25\">$txt[549]: &nbsp;&nbsp;<img src=\"./colors.png\" style=\"cursor: pointer;cursor: hand;\" width=\"15\" height=\"15\" onClick=\"javascript: window.open('./index.php?act=sm_window&page=colors&toform=themes_form&tofield=chat_bg','','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width={$x7c->settings['tweak_window_small_width']},height={$x7c->settings['tweak_window_small_height']}');\"></td>
									<td width=\"150\" height=\"25\"><input type=\"text\" name=\"chat_bg\" value=\"{$def['chat_bg']}\" class=\"text_input\"></td>
								</tr>
								<tr>
									<td width=\"150\" height=\"25\">$txt[553]: &nbsp;&nbsp;<img src=\"./colors.png\" style=\"cursor: pointer;cursor: hand;\" width=\"15\" height=\"15\" onClick=\"javascript: window.open('./index.php?act=sm_window&page=colors&toform=themes_form&tofield=col_bg_image','','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width={$x7c->settings['tweak_window_small_width']},height={$x7c->settings['tweak_window_small_height']}');\"></td>
									<td width=\"150\" height=\"25\"><input type=\"text\" name=\"col_bg_image\" value=\"{$def['col_bg_image']}\" class=\"text_input\"></td>
								</tr>
								<tr>
									<td width=\"150\" height=\"25\">$txt[562]: &nbsp;&nbsp;<img src=\"./colors.png\" style=\"cursor: pointer;cursor: hand;\" width=\"15\" height=\"15\" onClick=\"javascript: window.open('./index.php?act=sm_window&page=colors&toform=themes_form&tofield=header_bg_image','','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width={$x7c->settings['tweak_window_small_width']},height={$x7c->settings['tweak_window_small_height']}');\"></td>
									<td width=\"150\" height=\"25\"><input type=\"text\" name=\"header_bg_image\" value=\"{$def['header_bg_image']}\" class=\"text_input\"></td>
								</tr>
								<tr>
									<td colspan=\"2\"><br><hr><b>$txt[581]</b><Br><br></td>
								</tr>
								<tr>
									<td width=\"150\" height=\"25\">$txt[538]: &nbsp;&nbsp;<img src=\"./colors.png\" style=\"cursor: pointer;cursor: hand;\" width=\"15\" height=\"15\" onClick=\"javascript: window.open('./index.php?act=sm_window&page=colors&toform=themes_form&tofield=border_color','','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width={$x7c->settings['tweak_window_small_width']},height={$x7c->settings['tweak_window_small_height']}');\"></td>
									<td width=\"150\" height=\"25\"><input type=\"text\" name=\"border_color\" value=\"{$def['border_color']}\" class=\"text_input\"></td>
								</tr>
								<tr>
									<td width=\"150\" height=\"25\">$txt[586]: </td>
									<td width=\"150\" height=\"25\"><input type=\"text\" name=\"border_style\" value=\"{$def['border_style']}\" class=\"text_input\"></td>
								</tr>
								<tr>
									<td width=\"150\" height=\"25\">$txt[587]: </td>
									<td width=\"150\" height=\"25\"><input type=\"text\" name=\"border_size\" value=\"{$def['border_size']}\" class=\"text_input\"></td>
								</tr>
								<tr>
									<td width=\"150\" height=\"25\">$txt[539]: &nbsp;&nbsp;<img src=\"./colors.png\" style=\"cursor: pointer;cursor: hand;\" width=\"15\" height=\"15\" onClick=\"javascript: window.open('./index.php?act=sm_window&page=colors&toform=themes_form&tofield=border_color_light','','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width={$x7c->settings['tweak_window_small_width']},height={$x7c->settings['tweak_window_small_height']}');\"></td>
									<td width=\"150\" height=\"25\"><input type=\"text\" name=\"border_color_light\" value=\"{$def['border_color_light']}\" class=\"text_input\"></td>
								</tr>
								<tr>
									<td width=\"150\" height=\"25\">$txt[550]: &nbsp;&nbsp;<img src=\"./colors.png\" style=\"cursor: pointer;cursor: hand;\" width=\"15\" height=\"15\" onClick=\"javascript: window.open('./index.php?act=sm_window&page=colors&toform=themes_form&tofield=chat_border','','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width={$x7c->settings['tweak_window_small_width']},height={$x7c->settings['tweak_window_small_height']}');\"></td>
									<td width=\"150\" height=\"25\"><input type=\"text\" name=\"chat_border\" value=\"{$def['chat_border']}\" class=\"text_input\"></td>
								</tr>
								<tr>
									<td colspan=\"2\"><br><hr><b>$txt[582]</b><Br><br></td>
								</tr>
								<tr>
									<td width=\"150\" height=\"25\">$txt[540]: &nbsp;&nbsp;<img src=\"./colors.png\" style=\"cursor: pointer;cursor: hand;\" width=\"15\" height=\"15\" onClick=\"javascript: window.open('./index.php?act=sm_window&page=colors&toform=themes_form&tofield=link_color','','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width={$x7c->settings['tweak_window_small_width']},height={$x7c->settings['tweak_window_small_height']}');\"></td>
									<td width=\"150\" height=\"25\"><input type=\"text\" name=\"link_color\" value=\"{$def['link_color']}\" class=\"text_input\"></td>
								</tr>
								<tr>
									<td width=\"150\" height=\"25\">$txt[541]: &nbsp;&nbsp;<img src=\"./colors.png\" style=\"cursor: pointer;cursor: hand;\" width=\"15\" height=\"15\" onClick=\"javascript: window.open('./index.php?act=sm_window&page=colors&toform=themes_form&tofield=link_hover','','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width={$x7c->settings['tweak_window_small_width']},height={$x7c->settings['tweak_window_small_height']}');\"></td>
									<td width=\"150\" height=\"25\"><input type=\"text\" name=\"link_hover\" value=\"{$def['link_hover']}\" class=\"text_input\"></td>
								</tr>
								<tr>
									<td width=\"150\" height=\"25\">$txt[542]: &nbsp;&nbsp;<img src=\"./colors.png\" style=\"cursor: pointer;cursor: hand;\" width=\"15\" height=\"15\" onClick=\"javascript: window.open('./index.php?act=sm_window&page=colors&toform=themes_form&tofield=link_active','','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width={$x7c->settings['tweak_window_small_width']},height={$x7c->settings['tweak_window_small_height']}');\"></td>
									<td width=\"150\" height=\"25\"><input type=\"text\" name=\"link_active\" value=\"{$def['link_active']}\" class=\"text_input\"></td>
								</tr>
								<tr>
									<td colspan=\"2\"><br><hr><b>$txt[583]</b><Br><br></td>
								</tr>
								<tr>
									<td width=\"150\" height=\"25\">$txt[543]: &nbsp;&nbsp;<img src=\"./colors.png\" style=\"cursor: pointer;cursor: hand;\" width=\"15\" height=\"15\" onClick=\"javascript: window.open('./index.php?act=sm_window&page=colors&toform=themes_form&tofield=form_bg','','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width={$x7c->settings['tweak_window_small_width']},height={$x7c->settings['tweak_window_small_height']}');\"></td>
									<td width=\"150\" height=\"25\"><input type=\"text\" name=\"form_bg\" value=\"{$def['form_bg']}\" class=\"text_input\"></td>
								</tr>
								<tr>
									<td width=\"150\" height=\"25\">$txt[544]: &nbsp;&nbsp;<img src=\"./colors.png\" style=\"cursor: pointer;cursor: hand;\" width=\"15\" height=\"15\" onClick=\"javascript: window.open('./index.php?act=sm_window&page=colors&toform=themes_form&tofield=form_border','','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width={$x7c->settings['tweak_window_small_width']},height={$x7c->settings['tweak_window_small_height']}');\"></td>
									<td width=\"150\" height=\"25\"><input type=\"text\" name=\"form_border\" value=\"{$def['form_border']}\" class=\"text_input\"></td>
								</tr>
								<tr>
									<td width=\"150\" height=\"25\">$txt[588]: </td>
									<td width=\"150\" height=\"25\"><input type=\"text\" name=\"form_border_style\" value=\"{$def['form_border_style']}\" class=\"text_input\"></td>
								</tr>
								<tr>
									<td width=\"150\" height=\"25\">$txt[589]: </td>
									<td width=\"150\" height=\"25\"><input type=\"text\" name=\"form_border_size\" value=\"{$def['form_border_size']}\" class=\"text_input\"></td>
								</tr>
								<tr>
									<td width=\"150\" height=\"25\">$txt[545]</td>
									<td width=\"150\" height=\"25\"><input type=\"text\" name=\"form_size\" value=\"{$def['form_size']}\" class=\"text_input\"></td>
								</tr>
								<tr>
									<td width=\"150\" height=\"25\">$txt[546]: &nbsp;&nbsp;<img src=\"./colors.png\" style=\"cursor: pointer;cursor: hand;\" width=\"15\" height=\"15\" onClick=\"javascript: window.open('./index.php?act=sm_window&page=colors&toform=themes_form&tofield=form_color','','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width={$x7c->settings['tweak_window_small_width']},height={$x7c->settings['tweak_window_small_height']}');\"></td>
									<td width=\"150\" height=\"25\"><input type=\"text\" name=\"form_color\" value=\"{$def['form_color']}\" class=\"text_input\"></td>
								</tr>
								<tr>
									<td colspan=\"2\"><br><hr><b>$txt[584]</b><Br><br></td>
								</tr>
								<tr>
									<td width=\"150\" height=\"25\">$txt[547]: &nbsp;&nbsp;<img src=\"./colors.png\" style=\"cursor: pointer;cursor: hand;\" width=\"15\" height=\"15\" onClick=\"javascript: window.open('./index.php?act=sm_window&page=colors&toform=themes_form&tofield=other_person','','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width={$x7c->settings['tweak_window_small_width']},height={$x7c->settings['tweak_window_small_height']}');\"></td>
									<td width=\"150\" height=\"25\"><input type=\"text\" name=\"other_person\" value=\"{$def['other_person']}\" class=\"text_input\"></td>
								</tr>
								<tr>
									<td width=\"150\" height=\"25\">$txt[548]: &nbsp;&nbsp;<img src=\"./colors.png\" style=\"cursor: pointer;cursor: hand;\" width=\"15\" height=\"15\" onClick=\"javascript: window.open('./index.php?act=sm_window&page=colors&toform=themes_form&tofield=you','','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width={$x7c->settings['tweak_window_small_width']},height={$x7c->settings['tweak_window_small_height']}');\"></td>
									<td width=\"150\" height=\"25\"><input type=\"text\" name=\"you\" value=\"{$def['you']}\" class=\"text_input\"></td>
								</tr>
								<tr>
									<td width=\"300\" colspan=\"2\" height=\"25\"><div align=\"center\"><input type=\"submit\" value=\"$txt[63]\" class=\"button\"></div></td>
								</tr>
							</table>
						</form>";
					
					}
					
				}else{
					// Unable to write, give them a message saying that ./themes needs to be CHMOD 777
					if(isset($_GET['edit']))
						$edit = "&edit=$_GET[edit]";
					else
						$edit = "";
					$body = "$txt[525]<Br><br>[<a href=\"index.php?act=adminpanel&cp_page=themes&theme_page=creator{$edit}\">$txt[398]</a>] [<a href=\"index.php?act=adminpanel&cp_page=themes\">$txt[77]</a>]";
				}
			
			}
		
		}elseif($_GET['cp_page'] == "filter"){
			// Do the swear word filter, this is an easy section thankfully :)
			
			$head = $txt[143];
			
			include("./lib/filter.php");
			$filters = new filters();
			
			if(isset($_GET['add']) && isset($_GET['add2'])){
				$txt[162] = eregi_replace("_w",$_GET['add'],$txt[162]);
				$body = "$txt[162]<Br><Br>";
				$filters->add_filter(1,$_GET['add'],$_GET['add2']);
				$filters->reload();
			}elseif(isset($_GET['upload_and_add'])){
				include("./lib/upload.php");
				upload_file("filter_list","filter_list.txt");
				$data = implode("",file("{$x7c->settings['uploads_path']}/filter_list.txt"));
				$data = eregi_replace("[\r|\n|']","",$data);
				$data = explode(",",$data);
				foreach($data as $key=>$val){
					$temp = explode(":",$val);
					$filters->add_filter(1,$temp[0],$temp[1]);
				}
				unlink("{$x7c->settings['uploads_path']}/filter_list.txt");
				$filters->reload();
				$body = "";
			}elseif(isset($_GET['remove'])){
				$txt[163] = eregi_replace("_w",$_GET['remove'],$txt[163]);
				$body = "$txt[163]<Br><Br>";
				$filters->remove_server_filter($_GET['remove']);
				$filters->reload();
			}else{
				$body = "";
			}
			
			$body .= "$txt[145]<Br>";
			$type4s = $filters->get_filter_by_type(1);
			foreach($type4s as $key=>$val){
				if(!eregi("<a href=",$val[1])){
					$body .= "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"./index.php?act=adminpanel&cp_page=filter&remove=$val[0]\">$val[0] ($val[1])</a><Br>";
				}
			}
			
			$body .= "<Br><Br>
			<form action=\"./index.php\" method=\"get\">
				<input type=\"hidden\" name=\"act\" value=\"adminpanel\">
				<input type=\"hidden\" name=\"cp_page\" value=\"filter\">
				<b>$txt[164]</b><Br>
				&nbsp;&nbsp;&nbsp;&nbsp;$txt[165] <input type=\"text\" name=\"add\" class=\"text_input\"><Br>
				&nbsp;&nbsp;&nbsp;&nbsp;$txt[166] <input type=\"text\" name=\"add2\" class=\"text_input\"><Br>
				&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"submit\" class=\"button\" value=\"$txt[160]\">
			
			</form><hr>
			<form action=\"index.php?act=adminpanel&cp_page=filter&upload_and_add=1\" method=\"post\" enctype=\"multipart/form-data\">
			$txt[192]: <input type=\"file\" name=\"filter_list\"> <input type=\"submit\" value=\"$txt[192]\" class=\"button\">
			</form>";
		
		
		}elseif($_GET['cp_page'] == "groupmanager"){
			// This is the user group control page
			
			$head = $txt[309];
			
			$body = "";
			
			if(isset($_POST['create'])){
				// Create a group
				$db->DoQuery("INSERT INTO {$prefix}permissions (id,usergroup) VALUES('0','{$_POST['create']}')");
				// Edit the settings for this group
				$_GET['edit'] = $_POST['create'];
			}
			
			if(isset($_GET['edit'])){
				// Edit a groups permissions
				// Get defaults
				$query = $db->DoQuery("SELECT * FROM {$prefix}permissions WHERE usergroup='$_GET[edit]'");
				$row = $db->Do_Fetch_Row($query);
				($row[2] == 1) ? $def['make_rooms'] = " checked=\"true\"" : $def['make_rooms'] = "";
				($row[3] == 1) ? $def['make_proom'] = " checked=\"true\"" : $def['make_proom'] = "";
				($row[4] == 1) ? $def['make_nexp'] = " checked=\"true\"" : $def['make_nexp'] = "";
				($row[5] == 1) ? $def['make_mod'] = " checked=\"true\"" : $def['make_mod'] = "";
				($row[6] == 1) ? $def['viewip'] = " checked=\"true\"" : $def['viewip'] = "";
				($row[7] == 1) ? $def['kick'] = " checked=\"true\"" : $def['kick'] = "";
				($row[8] == 1) ? $def['ban_kick_imm'] = " checked=\"true\"" : $def['ban_kick_imm'] = "";
				($row[9] == 1) ? $def['AOP_all'] = " checked=\"true\"" : $def['AOP_all'] = "";
				($row[10] == 1) ? $def['AV_all'] = " checked=\"true\"" : $def['AV_all'] = "";
				($row[11] == 1) ? $def['view_hidden_emails'] = " checked=\"true\"" : $def['view_hidden_emails'] = "";
				($row[12] == 1) ? $def['use_keywords'] = " checked=\"true\"" : $def['use_keywords'] = "";
				($row[13] == 1) ? $def['access_room_logs'] = " checked=\"true\"" : $def['access_room_logs'] = "";
				($row[14] == 1) ? $def['log_pms'] = " checked=\"true\"" : $def['log_pms'] = "";
				($row[15] == 1) ? $def['set_background'] = " checked=\"true\"" : $def['set_background'] = "";
				($row[16] == 1) ? $def['set_logo'] = " checked=\"true\"" : $def['set_logo'] = "";
				($row[17] == 1) ? $def['make_admins'] = " checked=\"true\"" : $def['make_admins'] = "";
				($row[18] == 1) ? $def['server_msg'] = " checked=\"true\"" : $def['server_msg'] = "";
				($row[19] == 1) ? $def['can_mdeop'] = " checked=\"true\"" : $def['can_mdeop'] = "";
				($row[20] == 1) ? $def['can_mkick'] = " checked=\"true\"" : $def['can_mkick'] = "";
				($row[21] == 1) ? $def['admin_settings'] = " checked=\"true\"" : $def['admin_settings'] = "";
				($row[22] == 1) ? $def['admin_themes'] = " checked=\"true\"" : $def['admin_themes'] = "";
				($row[23] == 1) ? $def['admin_filter'] = " checked=\"true\"" : $def['admin_filter'] = "";
				($row[24] == 1) ? $def['admin_groups'] = " checked=\"true\"" : $def['admin_groups'] = "";
				($row[25] == 1) ? $def['admin_users'] = " checked=\"true\"" : $def['admin_users'] = "";
				($row[26] == 1) ? $def['admin_ban'] = " checked=\"true\"" : $def['admin_ban'] = "";
				($row[27] == 1) ? $def['admin_bandwidth'] = " checked=\"true\"" : $def['admin_bandwidth'] = "";
				($row[28] == 1) ? $def['admin_logs'] = " checked=\"true\"" : $def['admin_logs'] = "";
				($row[29] == 1) ? $def['admin_events'] = " checked=\"true\"" : $def['admin_events'] = "";
				($row[30] == 1) ? $def['admin_mail'] = " checked=\"true\"" : $def['admin_mail'] = "";
				($row[31] == 1) ? $def['admin_mods'] = " checked=\"true\"" : $def['admin_mods'] = "";
				($row[32] == 1) ? $def['admin_smilies'] = " checked=\"true\"" : $def['admin_smilies'] = "";
				($row[33] == 1) ? $def['admin_rooms'] = " checked=\"true\"" : $def['admin_rooms'] = "";
				($row[34] == 1) ? $def['access_disabled'] = " checked=\"true\"" : $def['access_disabled'] = "";
				($row[35] == 1) ? $def['b_invisible'] = " checked=\"true\"" : $def['b_invisible'] = "";
				($row[36] == 1) ? $def['c_invisible'] = " checked=\"true\"" : $def['c_invisible'] = "";
				($row[37] == 1) ? $def['admin_keywords'] = " checked=\"true\"" : $def['admin_keywords'] = "";
				($row[38] == 1) ? $def['access_pw_rooms'] = " checked=\"true\"" : $def['access_pw_rooms'] = "";
				
				$body = "$txt[424]<Br><Br><table border=\"0\" cellspacing=\"0\" cellpadding=\"4\" align=\"center\">
					<form action=\"index.php?act=adminpanel&cp_page=groupmanager&update=$_GET[edit]\" method=\"post\">
					<tr>
						<td width=\"120\">$txt[422]</td>
						<td width=\"50\"><input type=\"checkbox\" name=\"make_rooms\" value=\"1\"{$def['make_rooms']}></td>
					</tr>
					<tr>
						<td width=\"120\">$txt[423]</td>
						<td width=\"50\"><input type=\"checkbox\" name=\"make_proom\" value=\"1\"{$def['make_proom']}></td>
					</tr>
					<tr>
						<td width=\"120\">$txt[425]*</td>
						<td width=\"50\"><input type=\"checkbox\" name=\"make_nexp\" value=\"1\"{$def['make_nexp']}></td>
					</tr>
					<tr>
						<td width=\"120\">$txt[426]*</td>
						<td width=\"50\"><input type=\"checkbox\" name=\"make_mod\" value=\"1\"{$def['make_mod']}></td>
					</tr>
					<tr>
						<td width=\"120\">$txt[427]*</td>
						<td width=\"50\"><input type=\"checkbox\" name=\"viewip\" value=\"1\"{$def['viewip']}></td>
					</tr>
					<tr>
						<td width=\"120\">$txt[428]*</td>
						<td width=\"50\"><input type=\"checkbox\" name=\"kick\" value=\"1\"{$def['kick']}></td>
					</tr>
					<tr>
						<td width=\"120\">$txt[429]</td>
						<td width=\"50\"><input type=\"checkbox\" name=\"ban_kick_imm\" value=\"1\"{$def['ban_kick_imm']}></td>
					</tr>
					<tr>
						<td width=\"120\">$txt[430]</td>
						<td width=\"50\"><input type=\"checkbox\" name=\"AOP_all\" value=\"1\"{$def['AOP_all']}></td>
					</tr>
					<tr>
						<td width=\"120\">$txt[431]</td>
						<td width=\"50\"><input type=\"checkbox\" name=\"AV_all\" value=\"1\"{$def['AV_all']}></td>
					</tr>
					<tr>
						<td width=\"120\">$txt[432]</td>
						<td width=\"50\"><input type=\"checkbox\" name=\"view_hidden_emails\" value=\"1\"{$def['view_hidden_emails']}></td>
					</tr>
					<tr>
						<td width=\"120\">$txt[433]*</td>
						<td width=\"50\"><input type=\"checkbox\" name=\"use_keywords\" value=\"1\"{$def['use_keywords']}></td>
					</tr>
					<tr>
						<td width=\"120\">$txt[434]*</td>
						<td width=\"50\"><input type=\"checkbox\" name=\"access_room_logs\" value=\"1\"{$def['access_room_logs']}></td>
					</tr>
					<tr>
						<td width=\"120\">$txt[435]</td>
						<td width=\"50\"><input type=\"checkbox\" name=\"log_pms\" value=\"1\"{$def['log_pms']}></td>
					</tr>
					<tr>
						<td width=\"120\">$txt[436]**</td>
						<td width=\"50\"><input type=\"checkbox\" name=\"set_background\" value=\"1\"{$def['set_background']}></td>
					</tr>
					<tr>
						<td width=\"120\">$txt[437]**</td>
						<td width=\"50\"><input type=\"checkbox\" name=\"set_logo\" value=\"1\"{$def['set_logo']}></td>
					</tr>
					<tr>
						<td width=\"120\">$txt[438]</td>
						<td width=\"50\"><input type=\"checkbox\" name=\"make_admins\" value=\"1\"{$def['make_admins']}></td>
					</tr>
					<tr>
						<td width=\"120\">$txt[439]</td>
						<td width=\"50\"><input type=\"checkbox\" name=\"server_msg\" value=\"1\"{$def['server_msg']}></td>
					</tr>
					<tr>
						<td width=\"120\">$txt[440]*</td>
						<td width=\"50\"><input type=\"checkbox\" name=\"can_mdeop\" value=\"1\"{$def['can_mdeop']}></td>
					</tr>
					<tr>
						<td width=\"120\">$txt[441]*</td>
						<td width=\"50\"><input type=\"checkbox\" name=\"can_mkick\" value=\"1\"{$def['can_mkick']}></td>
					</tr>
					<tr>
						<td width=\"120\">$txt[442]</td>
						<td width=\"50\"><input type=\"checkbox\" name=\"admin_settings\" value=\"1\"{$def['admin_settings']}></td>
					</tr>
					<tr>
						<td width=\"120\">$txt[443]</td>
						<td width=\"50\"><input type=\"checkbox\" name=\"admin_themes\" value=\"1\"{$def['admin_themes']}></td>
					</tr>
					<tr>
						<td width=\"120\">$txt[444]</td>
						<td width=\"50\"><input type=\"checkbox\" name=\"admin_filter\" value=\"1\"{$def['admin_filter']}></td>
					</tr>
					<tr>
						<td width=\"120\">$txt[445]</td>
						<td width=\"50\"><input type=\"checkbox\" name=\"admin_groups\" value=\"1\"{$def['admin_groups']}></td>
					</tr>
					<tr>
						<td width=\"120\">$txt[446]</td>
						<td width=\"50\"><input type=\"checkbox\" name=\"admin_users\" value=\"1\"{$def['admin_users']}></td>
					</tr>
					<tr>
						<td width=\"120\">$txt[447]</td>
						<td width=\"50\"><input type=\"checkbox\" name=\"admin_ban\" value=\"1\"{$def['admin_ban']}></td>
					</tr>
					<tr>
						<td width=\"120\">$txt[448]</td>
						<td width=\"50\"><input type=\"checkbox\" name=\"admin_bandwidth\" value=\"1\"{$def['admin_bandwidth']}></td>
					</tr>
					<tr>
						<td width=\"120\">$txt[449]</td>
						<td width=\"50\"><input type=\"checkbox\" name=\"admin_logs\" value=\"1\"{$def['admin_logs']}></td>
					</tr>
					<tr>
						<td width=\"120\">$txt[457]</td>
						<td width=\"50\"><input type=\"checkbox\" name=\"admin_events\" value=\"1\"{$def['admin_events']}></td>
					</tr>
					<tr>
						<td width=\"120\">$txt[450]</td>
						<td width=\"50\"><input type=\"checkbox\" name=\"admin_mail\" value=\"1\"{$def['admin_mail']}></td>
					</tr>
					<tr>
						<td width=\"120\">$txt[451]</td>
						<td width=\"50\"><input type=\"checkbox\" name=\"admin_mods\" value=\"1\"{$def['admin_mods']}></td>
					</tr>
					<tr>
						<td width=\"120\">$txt[452]</td>
						<td width=\"50\"><input type=\"checkbox\" name=\"admin_smilies\" value=\"1\"{$def['admin_smilies']}></td>
					</tr>
					<tr>
						<td width=\"120\">$txt[453]</td>
						<td width=\"50\"><input type=\"checkbox\" name=\"admin_rooms\" value=\"1\"{$def['admin_rooms']}></td>
					</tr>
					<tr>
						<td width=\"120\">$txt[577]</td>
						<td width=\"50\"><input type=\"checkbox\" name=\"admin_keywords\" value=\"1\"{$def['admin_keywords']}></td>
					</tr>
					<tr>
						<td width=\"120\">$txt[454]</td>
						<td width=\"50\"><input type=\"checkbox\" name=\"access_disabled\" value=\"1\"{$def['access_disabled']}></td>
					</tr>
					<tr>
						<td width=\"120\">$txt[505]</td>
						<td width=\"50\"><input type=\"checkbox\" name=\"b_invisible\" value=\"1\"{$def['b_invisible']}></td>
					</tr>
					<tr>
						<td width=\"120\">$txt[506]</td>
						<td width=\"50\"><input type=\"checkbox\" name=\"c_invisible\" value=\"1\"{$def['c_invisible']}></td>
					</tr>
					<tr>
						<td width=\"120\">$txt[602]</td>
						<td width=\"50\"><input type=\"checkbox\" name=\"access_pw_rooms\" value=\"1\"{$def['access_pw_rooms']}></td>
					</tr>
					<tr>
						<td width=\"170\" colspan=\"2\"><div align=\"center\"><input type=\"submit\" class=\"button\" value=\"$txt[187]\"></div></td>
					</tr>
				</table><Br><Br>
				<b>*</b>: $txt[455]<br><Br>
				<b>**</b>: $txt[456]<br><Br>";
				
			}elseif(isset($_GET['view'])){
					// View members in a group
					// Get defaults for changing it
					$query = $db->DoQuery("SELECT usergroup FROM {$prefix}permissions");
					$change_ops = "";
					while($row = $db->Do_Fetch_Row($query)){
						$change_ops .= "<option value=\"$row[0]\">$row[0]</option>";
					}
					
					$query = $db->DoQuery("SELECT username FROM {$prefix}users WHERE user_group='$_GET[view]'");
					// This is the javascript for the check all uncheck all boxes
					$body .= "
					<script langauge=\"javascript\" type=\"text/javascript\">
						function chkAll(){
							dgform = document.gform;
							for(i=0;i < dgform.elements.length;i++){
								this1 = dgform.elements[i];
								if(this1.name != 'checkall' && this1.type == 'checkbox'){
									if(this1.checked)
										this1.checked = false;
									else
										this1.checked = true;
								}
							}
						}
						
					</script>";
					
					$body .= "$txt[418]<Br><form action=\"index.php?act=adminpanel&cp_page=groupmanager\" method=\"post\" name=\"gform\"><Br>
					&nbsp;&nbsp; <input type=\"checkbox\" name=\"checkall\" onClick=\"javascript: chkAll();\"><b>$txt[419]</b><Br>";
					while($row = $db->Do_Fetch_Row($query)){
						$body .= "&nbsp;&nbsp; <input type=\"checkbox\" name=\"ug_$row[0]\" value=\"1\"> $row[0]<Br>";
					}
					
					$body .= "<Br><div align=\"center\">$txt[417]: <select class=\"text_input\" name=\"new_g\">{$change_ops}</select><input type=\"submit\" class=\"button\" value=\"$txt[416]\"></form><Br><Br><a href=\"index.php?act=adminpanel&cp_page=groupmanager\">$txt[77]</a></div>";
					
			}else{
			
				if(isset($_GET['update'])){
					// Update a group
					// Check for checkboxs
					!isset($_POST['make_rooms']) ? $_POST['make_rooms'] = 0 : "";
					!isset($_POST['make_proom']) ? $_POST['make_proom'] = 0 : "";
					!isset($_POST['make_nexp']) ? $_POST['make_nexp'] = 0 : "";
					!isset($_POST['make_mod']) ? $_POST['make_mod'] = 0 : "";
					!isset($_POST['viewip']) ? $_POST['viewip'] = 0 : "";
					!isset($_POST['kick']) ? $_POST['kick'] = 0 : "";
					!isset($_POST['ban_kick_imm']) ? $_POST['ban_kick_imm'] = 0 : "";
					!isset($_POST['AOP_all']) ? $_POST['AOP_all'] = 0 : "";
					!isset($_POST['AV_all']) ? $_POST['AV_all'] = 0 : "";
					!isset($_POST['view_hidden_emails']) ? $_POST['view_hidden_emails'] = 0 : "";
					!isset($_POST['use_keywords']) ? $_POST['use_keywords'] = 0 : "";
					!isset($_POST['access_room_logs']) ? $_POST['access_room_logs'] = 0 : "";
					!isset($_POST['log_pms']) ? $_POST['log_pms'] = 0 : "";
					!isset($_POST['set_background']) ? $_POST['set_background'] = 0 : "";
					!isset($_POST['set_logo']) ? $_POST['set_logo'] = 0 : "";
					!isset($_POST['make_admins']) ? $_POST['make_admins'] = 0 : "";
					!isset($_POST['server_msg']) ? $_POST['server_msg'] = 0 : "";
					!isset($_POST['can_mdeop']) ? $_POST['can_mdeop'] = 0 : "";
					!isset($_POST['can_mkick']) ? $_POST['can_mkick'] = 0 : "";
					!isset($_POST['admin_settings']) ? $_POST['admin_settings'] = 0 : "";
					!isset($_POST['admin_themes']) ? $_POST['admin_themes'] = 0 : "";
					!isset($_POST['admin_filter']) ? $_POST['admin_filter'] = 0 : "";
					!isset($_POST['admin_groups']) ? $_POST['admin_groups'] = 0 : "";
					!isset($_POST['admin_users']) ? $_POST['admin_users'] = 0 : "";
					!isset($_POST['admin_ban']) ? $_POST['admin_ban'] = 0 : "";
					!isset($_POST['admin_bandwidth']) ? $_POST['admin_bandwidth'] = 0 : "";
					!isset($_POST['admin_logs']) ? $_POST['admin_logs'] = 0 : "";
					!isset($_POST['admin_events']) ? $_POST['admin_events'] = 0 : "";
					!isset($_POST['admin_mail']) ? $_POST['admin_mail'] = 0 : "";
					!isset($_POST['admin_mods']) ? $_POST['admin_mods'] = 0 : "";
					!isset($_POST['admin_smilies']) ? $_POST['admin_smilies'] = 0 : "";
					!isset($_POST['admin_rooms']) ? $_POST['admin_rooms'] = 0 : "";
					!isset($_POST['access_disabled']) ? $_POST['access_disabled'] = 0 : "";
					!isset($_POST['b_invisible']) ? $_POST['b_invisible'] = 0 : "";
					!isset($_POST['c_invisible']) ? $_POST['c_invisible'] = 0 : "";
					!isset($_POST['admin_keywords']) ? $_POST['admin_keywords'] = 0 : "";
					!isset($_POST['access_pw_rooms']) ? $_POST['access_pw_rooms'] = 0 : "";
					
					// Save the settings
					$db->DoQuery("UPDATE {$prefix}permissions SET make_rooms='$_POST[make_rooms]',make_proom='$_POST[make_proom]',make_nexp='$_POST[make_nexp]',make_mod='$_POST[make_mod]',viewip='$_POST[viewip]',kick='$_POST[kick]',ban_kick_imm='$_POST[ban_kick_imm]',AOP_all='$_POST[AOP_all]',AV_all='$_POST[AV_all]',view_hidden_emails='$_POST[view_hidden_emails]',use_keywords='$_POST[use_keywords]',access_room_logs='$_POST[access_room_logs]',log_pms='$_POST[log_pms]',set_background='$_POST[set_background]',set_logo='$_POST[set_logo]',make_admins='$_POST[make_admins]',server_msg='$_POST[server_msg]',can_mdeop='$_POST[can_mdeop]',can_mkick='$_POST[can_mkick]',admin_settings='$_POST[admin_settings]',admin_themes='$_POST[admin_themes]',admin_filter='$_POST[admin_filter]',admin_groups='$_POST[admin_groups]',admin_users='$_POST[admin_users]',admin_ban='$_POST[admin_ban]',admin_bandwidth='$_POST[admin_bandwidth]',admin_logs='$_POST[admin_logs]',admin_events='$_POST[admin_events]',admin_mail='$_POST[admin_mail]',admin_mods='$_POST[admin_mods]',admin_smilies='$_POST[admin_smilies]',admin_rooms='$_POST[admin_rooms]',access_disabled='$_POST[access_disabled]',b_invisible='$_POST[b_invisible]',c_invisible=$_POST[c_invisible],admin_keywords='$_POST[admin_keywords]',access_pw_rooms='$_POST[access_pw_rooms]' WHERE usergroup='$_GET[update]'");
					// Tell user they have been updated
					$body .= "$txt[458]<Br><br>";
					
				}elseif(isset($_GET['delete'])){
					// Delete a group
					// Make sure the group is empty
					$query = $db->DoQuery("SELECT * FROM {$prefix}users WHERE user_group='$_GET[delete]'");
					$row = $db->Do_Fetch_Row($query);
					if($row[0] != ""){
						$body .= "$txt[420]<Br><Br>";
					}else{
						$db->DoQuery("DELETE FROM {$prefix}permissions WHERE usergroup='$_GET[delete]'");
						$body .= "$txt[421]<Br><Br>";
					}
					
					
				}elseif(isset($_POST['new_g'])){
					// Change user's groups
					$body .= "$txt[415]<Br><Br>";
					foreach($_POST as $key=>$val){
						if(eregi("^ug_",$key) && $val == 1){
							$key = eregi_replace("^ug_","",$key);
							$db->DoQuery("UPDATE {$prefix}users SET user_group='$_POST[new_g]' WHERE username='$key'");
						}
					}
					
				}elseif(isset($_GET['defaults'])){
					// Edit the default groups
					// Update the database
					update_setting("usergroup_admin",$_POST['admin']);
					update_setting("usergroup_guest",$_POST['guest']);
					update_setting("usergroup_default",$_POST['member']);
					$body .= "$txt[412]<Br><Br>";
					// Update member accounts so their user groups are correct
					//$db->DoQuery("UPDATE {$prefix}users SET user_group='_1' WHERE user_group='{$x7c->settings['usergroup_admin']}' WHERE username<>'$x7s->username'");
					//$db->DoQuery("UPDATE {$prefix}users SET user_group='_2' WHERE user_group='{$x7c->settings['usergroup_guest']}' WHERE username<>'$x7s->username'");
					//$db->DoQuery("UPDATE {$prefix}users SET user_group='_3' WHERE user_group='{$x7c->settings['usergroup_default']}' WHERE username<>'$x7s->username'");
					//$db->DoQuery("UPDATE {$prefix}users SET user_group='{$_POST['admin']}' WHERE user_group='_1' WHERE username<>'$x7s->username'");
					//$db->DoQuery("UPDATE {$prefix}users SET user_group='{$_POST['guest']}' WHERE user_group='_2' WHERE username<>'$x7s->username'");
					//$db->DoQuery("UPDATE {$prefix}users SET user_group='{$_POST['member']}' WHERE user_group='_3' WHERE username<>'$x7s->username'");

					// Update these values quickly so that the change is shown
					$x7c->settings['usergroup_admin'] = $_POST['admin'];
					$x7c->settings['usergroup_guest'] = $_POST['guest'];
					$x7c->settings['usergroup_default'] = $_POST['member'];

				}
				
					// Get default group values
					$query = $db->DoQuery("SELECT usergroup FROM {$prefix}permissions");
					$group_options['admin'] = "";
					$group_options['member'] = "";
					$group_options['guest'] = "";
					while($row = $db->Do_Fetch_Row($query)){
						if($x7c->settings['usergroup_admin'] == $row[0])
							$group_options['admin'] .= "<option value=\"$row[0]\" selected=\"true\">$row[0]</option>";
						else
							$group_options['admin'] .= "<option value=\"$row[0]\">$row[0]</option>";
						
						if($x7c->settings['usergroup_guest'] == $row[0])
							$group_options['guest'] .= "<option value=\"$row[0]\" selected=\"true\">$row[0]</option>";
						else
							$group_options['guest'] .= "<option value=\"$row[0]\">$row[0]</option>";
							
						if($x7c->settings['usergroup_default'] == $row[0])
							$group_options['member'] .= "<option value=\"$row[0]\" selected=\"true\">$row[0]</option>";
						else
							$group_options['member'] .= "<option value=\"$row[0]\">$row[0]</option>";
						
						$groups[] = $row[0];
					}
				
					// Display groups and settings edit form
					$body .= "<div align=\"center\">
						<b>$txt[408]</b><br>
						<form action=\"index.php?act=adminpanel&cp_page=groupmanager&defaults=1\" method=\"post\">
							<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
								<tr>
									<td width=\"100\">$txt[409]: </td>
									<td width=\"100\"><select name=\"member\" class=\"text_input\">{$group_options['member']}</select></td>
								</tr>
								<tr>
									<td width=\"100\">$txt[410]: </td>
									<td width=\"100\"><select name=\"guest\" class=\"text_input\">{$group_options['guest']}</select></td>
								</tr>
								<tr>
									<td width=\"100\">$txt[411]: </td>
									<td width=\"100\"><select name=\"admin\" class=\"text_input\">{$group_options['admin']}</select></td>
								</tr>
								<tr>
									<td width=\"200\" colspan=\"2\"><div align=\"center\"><input type=\"submit\" class=\"button\" value=\"$txt[187]\"></div></td>
								</tr>
							</table>
						</form><Br><Br>
						<table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"col_header\">
							<tr>
								<td width=\"100\" height=\"25\">&nbsp;$txt[123]</td>
								<td width=\"160\" height=\"25\">$txt[86]</td>
							</tr>
						</table>
						<table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"inside_table\">";
						
					// Display a table of groups with actions
					foreach($groups as $key=>$group){
						$body .= "<Tr>
									<td width=\"100\" class=\"dark_row\">&nbsp;$group</td>
									<td width=\"160\" class=\"dark_row\">
									<a href=\"index.php?act=adminpanel&cp_page=groupmanager&view=$group\">[$txt[413]]</a>
									<a href=\"index.php?act=adminpanel&cp_page=groupmanager&delete=$group\">[$txt[175]]</a>
									<a href=\"index.php?act=adminpanel&cp_page=groupmanager&edit=$group\">[$txt[139]]</a>
									</td>
								</tr>";
					}
						
					$body .= "</table><Br><br>
					<form action=\"index.php?act=adminpanel&cp_page=groupmanager\" method=\"post\">
						$txt[414]: <input type=\"text\" class=\"text_input\" name=\"create\">
						<input type=\"submit\" class=\"button\" value=\"$txt[63]\">
					</form></div>";
				}
		
		
		}elseif($_GET['cp_page'] == "users"){
		
			$head = $txt[310];
		
			// This is the manage users screen.  Show the admin all the users
			// and allow him/her to delete or edit the user
			
			// See if quick edit was used
			if(isset($_POST['user']) && isset($_POST['action'])){
				if($_POST['action'] == "delete")
					$_GET['delete'] = $_POST['user'];
				else
					$_GET['edit'] = $_POST['user'];
			}
			
			if(isset($_GET['delete'])){
			
				// Check for confirmation
				if(!isset($_GET['confirm'])){
					// Request confirmation
					$body = "<div align=\"center\">$txt[461]<Br>
					<a href=\"index.php?act=adminpanel&cp_page=users&delete=$_GET[delete]&confirm=yes\">$txt[392]</a> | 
					<a href=\"index.php?act=adminpanel&cp_page=users\">$txt[393]</a>
					</div>";
					
				}else{
					// Do the delete
					$db->DoQuery("DELETE FROM {$prefix}users WHERE username='$_GET[delete]'");
					// Delete bandwidth info
					$db->DoQuery("DELETE FROM {$prefix}bandwidth WHERE user='$_GET[delete]'");
					// Clean up logs
					cleanup_guest_logs($_GET['delete']);
					$body = "<div align=\"center\">$txt[462]<Br><a href=\"index.php?act=adminpanel&cp_page=users\">$txt[77]</a></div>";
				}
			
			}elseif(isset($_GET['edit'])){
				// Display the form for editing the user
				// Get defaults
				$def = new profile_info($_GET['edit']);
				if($def->profile['id'] == ""){
					// Nonexistant user
					$body = "<div align=\"center\">$txt[463]<Br><a href=\"index.php?act=adminpanel&cp_page=users\">$txt[77]</a></div>";
				}else{
					// Get the default user group
					$query = $db->DoQuery("SELECT usergroup FROM {$prefix}permissions");
					$group_options = "";
					while($row = $db->Do_Fetch_Row($query)){
						if($def->profile['user_group'] == $row[0])
							$group_options .= "<option value=\"$row[0]\" selected=\"true\">$row[0]</option>";
						else
							$group_options .= "<option value=\"$row[0]\">$row[0]</option>";
					}
				
					$body = "<Br>
						<form action=\"index.php?act=adminpanel&cp_page=users&update=$_GET[edit]\" method=\"post\" name=\"profileform\">
						<table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">
							<tr>
								<td width=\"60\">$txt[2]:</td>
								<td width=\"100\"><input type=\"text\" name=\"username\" class=\"text_input\" value=\"{$def->profile['username']}\"></td>
							</tr>
							
							<tr>
								<td width=\"60\">$txt[3]:</td>
								<td width=\"100\"><input type=\"password\" name=\"pass1\" class=\"text_input\"></td>
							</tr>
							
							<tr>
								<td width=\"60\">$txt[21]:</td>
								<td width=\"100\"><input type=\"password\" name=\"pass2\" class=\"text_input\"></td>
							</tr>
							
							<tr>
								<td width=\"60\">$txt[20]:</td>
								<td width=\"100\"><input type=\"text\" name=\"email\" class=\"text_input\" value=\"{$def->profile['email']}\"></td>
							</tr>
							
							<tr>
								<td width=\"60\">$txt[31]:</td>
								<td width=\"100\"><input type=\"text\" name=\"rname\" class=\"text_input\" value=\"{$def->profile['name']}\"></td>
							</tr>
							
							<tr>
								<td width=\"60\">$txt[121]:</td>
								<td width=\"100\"><input type=\"text\" name=\"location\" class=\"text_input\" value=\"{$def->profile['location']}\"></td>
							</tr>
							
							<tr>
								<td width=\"60\">$txt[122]:</td>
								<td width=\"100\"><input type=\"text\" name=\"hobbies\" class=\"text_input\" value=\"{$def->profile['hobbies']}\"></td>
							</tr>
							
							<tr>
								<td width=\"60\">$txt[124]:</td>
								<td width=\"100\"><textarea class=\"text_input\" name=\"bio\" cols=\"18\">{$def->profile['bio']}</textarea></td>
							</tr>
							
							<tr>
								<td width=\"60\">$txt[186]:</td>
								<td width=\"100\">
									<select name=\"gender\" class=\"text_input\">
										<option value=\"0\" ";$body .= ($def->profile['gender'] == 0) ? "selected=true":"";$body .= ">$txt[191]</option>
										<option value=\"1\" ";$body .= ($def->profile['gender'] == 1) ? "selected=true":"";$body .= ">$txt[189]</option>
										<option value=\"2\" ";$body .= ($def->profile['gender'] == 2) ? "selected=true":"";$body .= ">$txt[190]</option>
								
									</select>
								</td>
							</tr>
							
							<tr>
								<td width=\"60\">$txt[125]: </td>
								<td width=\"100\"><input type=\"text\" name=\"avatar\" class=\"text_input\" value=\"{$def->profile['avatar']}\"></td>
							</tr>
							
							<tr>
								<td width=\"60\">$txt[309]: </td>
								<td width=\"100\"><select name=\"usergroup\" class=\"text_input\">{$group_options}</select></td>
							</tr>
							
							<tr>
								<td width=\"160\" colspan=\"2\"><div align=\"center\"><input type=\"submit\" value=\"$txt[187]\" class=\"button\"></div></td>
							</tr>
						</table><Br>";
				}
				
			}elseif(isset($_GET['update'])){
				// Update the user

				// Check passwords first
				if($_POST['pass1'] != $_POST['pass2']){
					$body = "<div align=\"center\">$txt[26]<Br><a href=\"javascript: history.back();\">$txt[77]</a></div>";
				}else{
					// Update is 100% ok to do, passwords match and user exists

					// Check to see if pass was blank, if so then don't change it
					if($_POST['pass1'] != "")
						// Change their password
						change_pass($_GET['update'],$_POST['pass1']);
						
					// Update the profile info
					$db->DoQuery("UPDATE {$prefix}users SET username='$_POST[username]',email='$_POST[email]',avatar='$_POST[avatar]',name='$_POST[rname]',location='$_POST[location]',hobbies='$_POST[hobbies]',bio='$_POST[bio]',gender='$_POST[gender]',user_group='$_POST[usergroup]' WHERE username='$_GET[update]'");
					
					$body = "<div align=\"center\">$txt[464]<Br><a href=\"index.php?act=adminpanel&cp_page=users\">$txt[77]</a></div>";
				}
			}elseif(isset($_GET['create'])){
				// Register a new user account
				// Clean up incoming data
				$_POST['pass1'] = auth_encrypt($_POST['pass1']);
				$_POST['pass2'] = auth_encrypt($_POST['pass2']);
				if($_POST['pass1'] == "")
					$error = $txt[25];
				if($_POST['pass1'] != $_POST['pass2'])
					$error = $txt[26];
				// Check username
				if($_POST['username'] == "" || eregi("\.|'|,|;| |\"",$_POST['username']) || (strlen($_POST['username']) > $x7c->settings['maxchars_username'] && $x7c->settings['maxchars_username'] != 0)){
					$txt[23] = eregi_replace("_n","{$x7c->settings['maxchars_username']}",$txt[23]);
					$error = $txt[23];
				}
				// Check for unique username
				$query = $db->DoQuery("SELECT * FROM {$prefix}users WHERE username='$_POST[username]'");
				$row = $db->Do_Fetch_Row($query);
				if($row[0] != "")
					$error = $txt[27];
				// Did any errors occur?
				if(isset($error)){
				// An error has occured!
				$body = $error."<Br><Br><div align=\"center\"><a style=\"cursor: pointer;cursor:hand;\" onClick=\"javascript: history.back();\">[$txt[77]]</a></div>";
				}else{
					$time = time();
					$ip = "";
					$settings = $g_default_settings; // This is defined in lib/auth.php
					$db->DoQuery("INSERT INTO {$prefix}users (id,username,password,status,user_group,time,settings,hideemail,ip) VALUES('0','$_POST[username]','$_POST[pass1]','$txt[150]','{$x7c->settings['usergroup_default']}','$time','$settings','0','$ip')");
					
					// Create the bandwidth row for them
					include_once("./lib/bandwidth.php");
					bw_first_time($_POST['username']);
					
					$body = $txt[600]."<Br><br><a style=\"cursor: pointer;cursor:hand;\" onClick=\"javascript: history.back();\">[$txt[77]]</a>";
				}
			}else{
				// Display all users
				$body = "<Br><div align=\"center\"><b>$txt[460]</b></div><Br>
						<form action=\"index.php?act=adminpanel&cp_page=users\" method=\"post\" name=\"quicke\">
						<table width=\"200\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
							<tr>
								<td>$txt[2]: </td>
								<td><input type=\"text\" name=\"user\" class=\"text_input\"></td>
							</tr>
							<Tr>
								<td>$txt[459]</td>
								<td> <input type=\"radio\" name=\"actionr\" value=\"edit\" checked=\"true\" style=\"position: relative;z-index: 2;\"> </td>
							</tr>
							<Tr>
								<td>$txt[175]</td>
								<td> <input type=\"radio\" name=\"actionr\" value=\"delete\" style=\"position: relative;z-index: 2;\"> </td>
							</tr>
							<Tr>
								<td colspan=\"2\"><div align=\"center\" style=\"position: relative; top: -24px;left: 30px;z-index: 1;\"><input type=\"submit\" value=\"$txt[187]\" class=\"button\"></div></td>
							</tr>
						</table>
						</form>
						<Br>
						___page_counter___<Br>
						<table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"col_header\">
							<tr>
								<td width=\"100\" height=\"25\">&nbsp;$txt[2]</td>
								<td width=\"100\" height=\"25\">$txt[123]</td>
								<td width=\"100\" height=\"25\">$txt[86]</td>
							</tr>
						</table>
						<table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"inside_table\">";
				// Pages
				
				
				$query = $db->DoQuery("SELECT * FROM {$prefix}users ORDER BY username ASC");
				$i = 0;
				
				if(!isset($_GET['start']))
					$_GET['start'] = 0;
				$end = $_GET['start']+25;
				
				while(($row = $db->Do_Fetch_Row($query))){
					if($i >= $_GET['start'] && $i < $end)
						$body .= "<tr>
								<td width=\"100\" class=\"dark_row\">&nbsp; $row[1]</td>
								<td width=\"100\" class=\"dark_row\">$row[10]</td>
								<td width=\"100\" class=\"dark_row\"><a href=\"index.php?act=adminpanel&cp_page=users&edit=$row[1]\">[$txt[459]]</a> <a href=\"index.php?act=adminpanel&cp_page=users&delete=$row[1]\">[$txt[175]]</a></td>
							</tr>";
					$i++;
				}
				
				// The actual page counter
				$page_count = ceil($i/25);
				$pages = "";
				while($page_count > 0){
					$start = $page_count*25-25;
					$pages = "<a href=\"./index.php?act=adminpanel&cp_page=users&start=$start\">[$page_count]</a>".$pages;
					$page_count--;	
				}
								
				$body .= "</table>___page_counter___<Br><Br>";
				
				$body = eregi_replace("___page_counter___","$pages",$body);
				
				// Create new user
				$body .= "<div align=\"center\"><b>$txt[601]</b><Br><Br>
				<form action=\"./index.php?act=adminpanel&cp_page=users&create=1\" method=\"post\">
				$txt[2] <input type=\"text\" name=\"username\" class=\"text_input\"><Br>
				$txt[3] <input type=\"password\" name=\"pass1\" class=\"text_input\"><br>
				$txt[21] <input type=\"password\" name=\"pass2\" class=\"text_input\"><br><Br>
				<input type=\"submit\" value=\"$txt[63]\" class=\"text_input\"></div></form>";
			
			}
			
		
		}elseif($_GET['cp_page'] == "rooms"){
			// Manage rooms, allow for editing, deleteing, but not renaming
			
			$head = $txt[311];
			
			if(isset($_GET['delete'])){
				// They want to delete a room, make sure that is ok
				if(!isset($_GET['confirm'])){
					// Make it so admins can't delete a room being used by single-room mode
					if($x7c->settings['single_room_mode'] != $_GET['delete']){
						$body = "<div align=\"center\">$txt[465]<Br>
						<a href=\"index.php?act=adminpanel&cp_page=rooms&delete=$_GET[delete]&confirm=yes\">$txt[392]</a> | 
						<a href=\"index.php?act=adminpanel&cp_page=rooms\">$txt[393]</a>
						</div>";
					}else{
						$body = "$txt[594]<Br><Br><a href=\"index.php?act=adminpanel&cp_page=rooms\">$txt[77]</a>";
					}
				}else{
					// Ok, delete the room
					$body = "<div align=\"center\">$txt[466]<Br><a href=\"index.php?act=adminpanel&cp_page=rooms\">$txt[77]</a></div>";
					
					// Get the room id
					$query = $db->DoQuery("SELECT id FROM {$prefix}rooms WHERE name='$_GET[delete]'");
					$row = $db->Do_Fetch_Row($query);
					$id = $row[0];
					
					// Delete the room
					$db->DoQuery("DELETE FROM {$prefix}rooms WHERE name='$_GET[delete]'");
					
					// Delete room bans
					$db->DoQuery("DELETE FROM {$prefix}banned WHERE room='$id'");
					
					// Delete room filters
					$db->DoQuery("DELETE FROM {$prefix}filter WHERE type='4' AND room='$_GET[delete]'");
					
					// Delete room logs
					@unlink("{$x7c->settings['logs_path']}/$_GET[delete].log");
					
				}
			}else{
				// Display a list of all rooms and give a link to edit them
				// Remove old records
				include_once("./lib/online.php");
				clean_old_data();
			
				// Prepare header
				$rooms = array();
				$query = $db->DoQuery("SELECT name,topic,password,maxusers,logged FROM {$prefix}rooms");
				while($row = $db->Do_Fetch_Row($query)){
					$rooms[] = $row;
				}
				$body = "<Br>
							<table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"col_header\">
								<tr>
									<td width=\"160\" height=\"25\">&nbsp;$txt[31]</td>
									<td width=\"100\" height=\"25\">&nbsp;$txt[86]</td>
								</tr>
							</table>
							<table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"inside_table\">
				";
				
				// LIST!
				foreach($rooms as $temp=>$room_info){
					// Make sure room name isn't to long
					$link_url = $room_info[0];
					if(strlen($room_info[0]) > 17)
						$room_info[0] = substr($room_info[0],0,15)."...";

					// Print lock picture if this room is password protected
					if($room_info[2] != "")
						$lock = "&nbsp;<img src=\"$print->image_path/key.gif\">";
					else
						$lock = "";
					// Put it into the $body variable
					$body .= "
							<tr>
								<td width=\"160\" class=\"dark_row\">&nbsp;<a href=\"index.php?act=frame&room=$link_url\">$room_info[0]</a>$lock</td>
								<td width=\"100\" class=\"dark_row\"><a href=\"index.php?act=roomcp&room=$link_url\">[$txt[459]]</a> <a href=\"index.php?act=adminpanel&cp_page=rooms&delete=$link_url\">[$txt[175]]</a></td>
							</tr>
					";
				}
				
				$body .= "</table>";
				
				// Give them a link to add a room
				$body .= "<Br><div align=\"center\"><a href=\"index.php?act=newroom1\">[$txt[59]]</a></div>";
			}
			
			
			
		}elseif($_GET['cp_page'] == "ban"){
			// Show them a table of banned users and allow them to delete and ban people
			
			$head = $txt[312];
			
			if(@$_GET['subact'] == "ban" && isset($_POST['toban'])){
			
				if(@$_POST['len_unlimited'] == 1){
					$length = 0;
				}else{
					$length = $_POST['len_limited']*$_POST['len_period'];
				}
				
				new_ban($_POST['toban'],$length,$_POST['reason'],"*");
				$body = "$txt[234]<br><Br>";
			
			}elseif(@$_GET['subact'] == "unban"){
			
				remove_ban($_GET['banid'],"*");
				$body = "$txt[235]<Br><Br>";
				
			}elseif(@$_GET['subact'] == "iplookup"){
				// Look up a users IP address
				$query = $db->DoQuery("SELECT ip FROM {$prefix}users WHERE username='$_POST[user]'");
				$row = $db->Do_Fetch_Row($query);
				if($row[0] == "")
					$body = "$txt[239]<Br><Br>";
				else
					$body = "$txt[107] <b>$row[0]</b><Br><Br>";
					
			}else{
				$body = "";
			}
				
			
				$body .= "$txt[233]<Br><Br><table border=\"0\" align=\"center\" cellspacing=\"0\" cellpadding=\"2\" class=\"col_header\">
						<tr>
							<td width=\"100\">$txt[224]</td>
							<td width=\"110\">$txt[223]</td>
							<td width=\"50\">$txt[225]</td>
						</tr>
						</table>
						<table border=\"0\" align=\"center\" cellspacing=\"0\" cellpadding=\"2\" class=\"inside_table\">";
				
				// Get the ban records
				$query = $db->DoQuery("SELECT * FROM {$prefix}banned WHERE room='*'");
				while($row = $db->Do_Fetch_Row($query)){
				
					if($row[4] == 0)
						$length = $txt[226];
					else
						$length = date("{$x7c->settings['date_format_full']}",$row[3]+$row[4]);
					
				
					$body .= "<tr>
								<td width=\"100\" class=\"dark_row\"><a href=\"index.php?act=adminpanel&cp_page=ban&subact=unban&banid=$row[0]\">$row[2]</a></td>
								<td width=\"110\" class=\"dark_row\">$row[5]</td>
								<td width=\"50\" class=\"dark_row\" style=\"text-align: center\">$length</td>
							</tr>";
				}
							
				$body .= "</table><Br><br>
					<form action=\"index.php?act=adminpanel&cp_page=ban&subact=ban\" method=\"post\">
						<table align=\"center\" border=\"0\" cellspacing=\"5\" cellpadding=\"0\">
							<tr>
								<td width=\"200\" colspan=\"2\"><div align=\"center\"><b>$txt[222]</b></div></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[224]: </td>
								<td width=\"100\"><input type=\"text\" name=\"toban\" class=\"text_input\"></td>
							</tr>
							<tr>
								<td width=\"100\">$txt[223]: </td>
								<td width=\"100\"><input type=\"text\" name=\"reason\" class=\"text_input\"></td>
							</tr>
							<tr valign=\"top\">
								<td width=\"100\">$txt[225]: </td>
								<td width=\"100\" style=\"text-align: center\">$txt[226] <input type=\"checkbox\" value=\"1\" name=\"len_unlimited\" CHECKED>
									<Br>$txt[227]
									<Br>
									<input type=\"text\" class=\"text_input\" style=\"width: 45px;text-align: center;\" name=\"len_limited\" value=\"0\">
									<select name=\"len_period\" class=\"text_input\">
										<option value=\"60\">$txt[228]</option>
										<option value=\"3600\">$txt[229]</option>
										<option value=\"86400\">$txt[230]</option>
										<option value=\"604800\">$txt[231]</option>
										<option value=\"2419200\">$txt[232]</option>
									</select>
								</td>
							</tr>
							<tr>
								<td width=\"200\" colspan=\"2\"><div align=\"center\"><input type=\"submit\" value=\"$txt[222]\" class=\"button\"></div></td>
							</tr>
						</table>
					</form><Br><Br><div align=\"center\">
					<form action=\"index.php?act=adminpanel&cp_page=ban&subact=iplookup\" method=\"post\">
						<b>$txt[519]</b><Br>
						$txt[2]: <input type=\"text\" class=\"text_input\" name=\"user\"> <input type=\"submit\" value=\"$txt[520]\" class=\"button\">
					</form><Br><Br></div>";
		
		}elseif($_GET['cp_page'] == "bandwidth"){
			// This panel allows admins to see the bandwidth usage of their users
			
			$head = $txt[313];
			
			// See if they are enabling/disabling bandwidth logging
			if(isset($_GET['able'])){
				if($x7c->settings['log_bandwidth'] == 0){
					// It is already disabled, enable it
					$x7c->settings['log_bandwidth'] = 1;
					update_setting("log_bandwidth","1");
				}else{
					// It is already enabled, disable it
					$x7c->settings['log_bandwidth'] = 0;
					update_setting("log_bandwidth","0");
				}
			}
			
			if(isset($_GET['cleanup'])){
				// This is used to remove guest rows from the bandwidth table
				$query = $db->DoQuery("SELECT username FROM {$prefix}users");
				$query2 = $db->DoQuery("SELECT user FROM {$prefix}bandwidth");
				$delete = array();
				while($row = $db->Do_Fetch_Row($query)){
					$users[] = $row[0];
				}
				while($row2 = $db->Do_Fetch_Row($query2)){
					if(!in_array($row2[0],$users))
						$delete[] = $row2[0];
				}
				foreach($delete as $key=>$val){
					$db->DoQuery("DELETE FROM {$prefix}bandwidth WHERE user='$val'");
				}
				
			}
			
			// Make sure bandwidth logging is enabled
			if($x7c->settings['log_bandwidth'] == 0){
				$txt[469] = eregi_replace("<a>","<a href=\"index.php?act=adminpanel&cp_page=bandwidth&able=1\">",$txt[469]);
				$body = $txt[469];
			}else{
			
				// If they changed the max_default_bandwidth variable then update it
				if(isset($_POST['max_default_bandwidth'])){
					$_POST['max_default_bandwidth'] *= 1048576;
					update_setting("max_default_bandwidth",$_POST['max_default_bandwidth']);
					$x7c->settings['max_default_bandwidth'] = $_POST['max_default_bandwidth'];
				
					// Update the time period to log during
					$x7c->settings['default_bandwidth_type'] = $_POST['type'];
					if($_POST['type'] == 1)
						update_setting("default_bandwidth_type","1");
					else
						update_setting("default_bandwidth_type",$_POST['type'],"0");
					
				}
				
				// They want to update some poor users bandwidth limit :) or maybe, that user is actually lucky
				if(isset($_GET['update'])){
				
					// Get current values first so we know which ones to change and which to leave alone
					// this saves querys
					$query = $db->DoQuery("SELECT id,max FROM {$prefix}bandwidth");
					while($row = $db->Do_Fetch_Row($query)){
						$current[$row[0]] = $row[1];
					}
					
					// Scan through posted values
					foreach($_POST as $key=>$val){
						// See if its the right kind
						if(eregi("^bwu_([0-9])*$",$key,$match)){
							
							// Make sure the value is numeric, otherwise set to default
							if(!is_numeric($val))
								$val = "-1";
								
							if($val != "-1")
								$val *= 1048576;
								
							// See if it was changed, if so then update the DB
							if($val != $current[$match[1]])
								$db->DoQuery("UPDATE {$prefix}bandwidth SET max='$val' WHERE id='$match[1]'");
							
						}
					}
				
				}
			
				// Print a thingy that allows them to disable bandwidth logging
				$txt[470] = eregi_replace("<a>","<a href=\"index.php?act=adminpanel&cp_page=bandwidth&able=1\">",$txt[470]);
				$body = $txt[470];
				
				// Defaults
				$def['max_default_bandwidth'] = $x7c->settings['max_default_bandwidth']/1048576;
				
				if($x7c->settings['default_bandwidth_type'] == 1){
					$def['option_1'] = " selected=\"true\"";
					$def['option_2'] = "";
				}else{
					$def['option_1'] = "";
					$def['option_2'] = " selected=\"true\"";
				}
				
				
				// Print the form that allows them to change the default limit
				$txt[472] = eregi_replace("_t","<select name=\"type\" class=\"text_input\"><option value=\"1\"{$def['option_1']}>$txt[474]</option><option value=\"2\"{$def['option_2']}>$txt[473]</option></select>",$txt[472]);
				$body .= "<Br><Br><div align=\"center\"><form action=\"index.php?act=adminpanel&cp_page=bandwidth\" method=\"post\">
							$txt[471]*: <input value=\"$def[max_default_bandwidth]\" type=\"text\" name=\"max_default_bandwidth\" class=\"text_input\" size=\"3\"><Br>
							$txt[472]<Br>
							<input type=\"submit\" class=\"button\" value=\"$txt[187]\">
							<Br><b>* $txt[340]</b></form></div><br><Br>";
				
				// Get the rows and rows of data from the DB
				$body .= "
					<form action=\"index.php?act=adminpanel&cp_page=bandwidth&update=1\" method=\"post\">
					&nbsp;&nbsp;&nbsp;___page_counter___
					<table border=\"0\" align=\"center\" cellspacing=\"0\" cellpadding=\"2\" class=\"col_header\">
						<tr>
							<td width=\"100\" height=\"25\">$txt[2]</td>
							<td width=\"60\" height=\"25\">$txt[475]**</td>
							<td width=\"90\" height=\"25\">$txt[476]*</td>
						</tr>
						</table>
						<table border=\"0\" align=\"center\" cellspacing=\"0\" cellpadding=\"2\" class=\"inside_table\">";
				
				// Get the rows
				$total = 0;
				$query = $db->DoQuery("SELECT user,used,max,id FROM {$prefix}bandwidth ORDER BY user ASC");
				
				if(!isset($_GET['start']))
					$_GET['start'] = 0;
				$end = $_GET['start'] + 25;
				$i = 0;
				
				while($row = $db->Do_Fetch_Row($query)){
					
						// Convert used bandwidth from bytes to megabytes
						$used = round(($row[1]/1048576),1);
						$total += $used;
						
					if($i >= $_GET['start'] && $i < $end){
						// CHeck and convert the max bandwidth
						if($row[2] == "-1"){
							$max = " ($txt[55])";
						}elseif($row[2] == "0"){
							$max = " ($txt[248])";
						}else{
							$max = "";
							$row[2] /= 1048576;
						}
												
						$body .= "<tr>
										<td class=\"dark_row\" width=\"100\">$row[0]</td>
										<td class=\"dark_row\" width=\"60\">$used MB</td>
										<td class=\"dark_row\" width=\"90\"><input type=\"text\" name=\"bwu_$row[3]\" class=\"text_input\" size=\"3\" value=\"$row[2]\">$max</td>
									</tr>";
					}
					$i++;
				}
				
				$page_count = ceil($i/25);
				$pages = "";
				while($page_count > 0){
					$start = $page_count*25-25;
					$pages = "<a href=\"./index.php?act=adminpanel&cp_page=bandwidth&start=$start\">[$page_count]</a>".$pages;
					$page_count--;	
				}
					
				// Cleanup text
				$txt[521] = eregi_replace("<a>","<a href=\"index.php?act=adminpanel&cp_page=bandwidth&cleanup=1\">",$txt[521]);
						
				$body .= "<tr>
								<td class=\"dark_row\" width=\"100\"><b>$txt[479]</b></td>
								<td class=\"dark_row\" width=\"60\"><b>$total MB</b></td>
								<td class=\"dark_row\" width=\"90\"><input type=\"submit\" class=\"button\" value=\"$txt[187]\"></td>
							</tr>
						</table>&nbsp;&nbsp;&nbsp;___page_counter___<Br><Br><b>* $txt[478]</b><Br><b>** $txt[477]</b></form><Br><div align=\"center\">$txt[521]</div><Br><Br>";
			
				$body = eregi_replace("___page_counter___","$pages",$body);
			}
		
		}elseif($_GET['cp_page'] == "logs"){
			// Allow the admin to manage logs
			
			$head = $txt[314];
			
			// See if they want to enable/disable logging
			if(isset($_GET['able'])){
				if($x7c->settings['enable_logging'] == 1){
					// Disable
					update_setting("enable_logging","0");
					$x7c->settings['enable_logging'] = 0;
				}else{
					// Enable
					update_setting("enable_logging","1");
					$x7c->settings['enable_logging'] = 1;
				}
			}
			
			// See if logging is enabled or disabled
			if($x7c->settings['enable_logging'] == 1){
				// Logging is enabled, tell them so
				$txt[485] = eregi_replace("<a>","<a href=\"index.php?act=adminpanel&cp_page=logs&able=1\">",$txt[485]);
				$body = $txt[485]."<Br><br>";
				
				// Give them a link to edit log settings
				$body .= "<div align=\"center\"><a href=\"index.php?act=adminpanel&cp_page=settings&settings_page=logs\">$txt[486]</a><Br><Br></div>";
			
			
				// Display a table of all rooms showing if logging is enabled giving a Manage/View link
				include("./lib/rooms.php");
				$rooms = list_rooms();
				$body .= "<Br>
							<table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"col_header\">
								<tr>
									<td width=\"120\" height=\"25\">&nbsp;$txt[31]</td>
									<td width=\"70\" height=\"25\">$txt[482]</td>
									<td width=\"80\" height=\"25\">$txt[86]</td>
								</tr>
							</table>
							<table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"inside_table\">
				";

				// LIST!
				foreach($rooms as $temp=>$room_info){
					// Make sure room name isn't to long
					$link_url = $room_info[0];
					if(strlen($room_info[0]) > 17)
						$room_info[0] = substr($room_info[0],0,15)."...";

					// See if the room is logged
					if($room_info[4] == 1)
						$log = $txt[392];
					else
						$log = $txt[393];

					// Put it into the $body variable
					$body .= "
							<tr>
								<td width=\"120\" class=\"dark_row\">&nbsp;<a href=\"index.php?act=frame&room=$link_url\">$room_info[0]</a></td>
								<td width=\"70\" class=\"dark_row\">$log</td>
								<td width=\"80\" class=\"dark_row\"><a href=\"index.php?act=roomcp&cp_page=logs&room=$link_url\">$txt[483]</a></td>
							</tr>
					";
				}

				$body .= "</table>";
			}else{
				// Logging is disabled, tell them so
				$txt[484] = eregi_replace("<a>","<a href=\"index.php?act=adminpanel&cp_page=logs&able=1\">",$txt[484]);
				$body = $txt[484];
			}
		
		}elseif($_GET['cp_page'] == "events"){
			// Ah yes, the calendar
			
			$head = $txt[315];
		
			// Show the current one month calendar and allow admin to add, edit and delete events.
			include("./lib/events.php");
			cleanup_events();
			
			$body = "";
			
			// This mini function is in charge of printing a form that allows you to add a new event or edit an old one
			function event_form($action,$default=""){
				global $db, $prefix, $txt;
			
				// Get defaults first
				if($default != ""){
					$query = $db->DoQuery("SELECT * FROM {$prefix}events WHERE id='$_GET[edit]'");
					$row = $db->Do_Fetch_Row($query);
					$hour = date("H",$row[1]);
					$min = date("i",$row[1]);
					$day = date("d",$row[1]);
					$month = date("m",$row[1]);
					$year = date("Y",$row[1]);
				}else{
					$hour = date("H");
					$min = date("i");
					$day = date("d");
					$month = date("m");
					$year = date("Y");
					$row[0] = 0;
					$row[2] = "";
				}
				
				return "<form action=\"index.php\" method=\"get\">
							<input type=\"hidden\" name=\"act\" value=\"adminpanel\">
							<input type=\"hidden\" name=\"cp_page\" value=\"events\">
							<input type=\"hidden\" name=\"$action\" value=\"$row[0]\">
							$txt[488]: <input type=\"text\" value=\"$row[2]\" class=\"text_input\" size=\"30\" name=\"event\"><Br>
							$txt[492]: <input type=\"text\" value=\"$month\" class=\"text_input\" size=\"2\" name=\"month\"> / <input type=\"text\" value=\"$day\" class=\"text_input\" size=\"2\" name=\"day\"> / <input type=\"text\" value=\"$year\" class=\"text_input\" size=\"4\" name=\"year\"><Br>
							$txt[490]*: <input type=\"text\" size=\"2\" name=\"hour\" value=\"$hour\" class=\"text_input\"> <b>:</b> <input type=\"text\" size=\"2\" name=\"min\" value=\"$min\" class=\"text_input\"><br>
							<input type=\"submit\" value=\"$txt[187]\" class=\"button\">
							<br><b>* $txt[491]</b>
						</form>";
			}
			
			if(isset($_GET['delete'])){
				// Delete an event
				$db->DoQuery("DELETE FROM {$prefix}events WHERE id='$_GET[delete]'");
			}elseif(isset($_GET['add'])){
				// Add an event
				$time = mktime($_GET['hour'],$_GET['min'],0,$_GET['month'],$_GET['day'],$_GET['year']);
				add_event($time,$_GET['event']);
			}elseif(isset($_GET['edit'])){
				// Display the event edit form
				
				$body = "<div align=\"center\">
						<b>$txt[487]</b><Br>";
				$body .= event_form("update",$_GET['edit']);
				$body .= "</div><Br><hr><Br>";
			}elseif(isset($_GET['update'])){
				// Change an event
				$time = mktime($_GET['hour'],$_GET['min'],0,$_GET['month'],$_GET['day'],$_GET['year']);
				$db->DoQuery("UPDATE {$prefix}events SET event='$_GET[event]',timestamp='$time' WHERE id='$_GET[update]'");
			}
			
			// Show all events
			$query = $db->DoQuery("SELECT * FROM {$prefix}events");
			$body .= "<Br>
					<table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\" class=\"col_header\">
						<tr>
							<td width=\"135\" height=\"25\">&nbsp;$txt[488]</td>
							<td width=\"70\" height=\"25\">$txt[180]</td>
							<td width=\"70\" height=\"25\">$txt[86]</td>
						</tr>
					</table>
					<table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\" class=\"inside_table\">";
			while($row = $db->Do_Fetch_Row($query)){
			
				// Only display a preview of the actual event
				if(strlen($row[2]) > 40)
					$row[2] = substr($row[2],0,36)."...";
				
				// Get the day this is occuring on
				$time = mktime(0,0,0,date("m",$row[1]),date("d",$row[1]),date("Y",$row[1]));
					
				$body .= "<tr>
							<td class=\"dark_row\" width=\"135\"><a href=\"#\" onClick=\"javascript: window.open('./index.php?act=sm_window&page=event&day=$time','','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width={$x7c->settings['tweak_window_small_width']},height={$x7c->settings['tweak_window_small_height']}');\">$row[2]</a></td>
							<td class=\"dark_row\" width=\"70\">".date($x7c->settings['date_format_full'],$row[1])."</td>
							<td class=\"dark_row\" width=\"70\"><a href=\"index.php?act=adminpanel&cp_page=events&delete=$row[0]\">[$txt[175]]</a><Br><a href=\"index.php?act=adminpanel&cp_page=events&edit=$row[0]\">[$txt[459]]</a></td>
						</tr>";
			
			}
			
			$body .= "</table><br><br>";
			
			// Allow them to add a new event
			$body .= "<div align=\"center\"><b>$txt[489]</b><Br>".event_form("add")."<Br><Br>";
			
			// Show them the month calendar
			$body .=  "<div align=\"center\"><b>$txt[315]</b><Br>".cal_minimonth()."<Br>";

		
		}elseif($_GET['cp_page'] == "mail"){
			// MASSIVE MAIL SECTION!!!!!!!!!1111one11one111one
			
			$head = $txt[316];
			
			if(isset($_POST['message'])){
				// SEND THE MESSAGE!
				$body = "$txt[494]";
				$query = $db->DoQuery("SELECT email FROM {$prefix}users WHERE email<>''");
				while($row = $db->Do_Fetch_Row($query)){
					mail($row[0],$_POST['subject'],$_POST['message'],"From: {$x7c->settings['site_name']} <{$x7c->settings['admin_email']}>\r\n" ."Reply-To: {$x7c->settings['admin_email']}\r\n" ."X-Mailer: PHP/" . phpversion());
				}
			}else{				// Give them a form to enter a nice long message

				
				$body = "<div align=\"center\"><Br>$txt[493]<Br><Br>
						<form action=\"index.php?act=adminpanel&cp_page=mail\" method=\"post\">
							$txt[178]: <input type=\"text\" name=\"subject\" class=\"text_input\"><br>
							<textarea cols=\"35\" rows=\"15\" class=\"text_input\" name=\"message\"></textarea><br>
							<input type=\"submit\" value=\"$txt[181]\" class=\"button\">
						</form>
						</div>";
				
			}
		
		}elseif($_GET['cp_page'] == "smilies"){
		
			$head = $txt[317];
			
			include("./lib/filter.php");
			$filters = new filters();
			
			if(isset($_GET['add']) && isset($_GET['add2'])){
				$_GET['add2'] = "<img src=\"$_GET[add2]\">";
				$filters->add_filter(2,$_GET['add'],$_GET['add2']);
				$filters->reload();
			}elseif(isset($_GET['remove'])){
				$filters->remove_smiley($_GET['remove']);
				$filters->reload();
			}elseif(isset($_GET['upload_and_add'])){
				include("./lib/upload.php");
				upload_file("smile_list","smile_list.txt");
				$data = implode("",file("{$x7c->settings['uploads_path']}/smile_list.txt"));
				$data = eregi_replace("[\r|\n|']","",$data);
				$data = explode(",",$data);
				foreach($data as $key=>$val){
					$temp = explode(":",$val);
					$filters->add_filter(2,$temp[0],"<img src=\"$temp[1]\">");
				}
				unlink("{$x7c->settings['uploads_path']}/smile_list.txt");
				$filters->reload();
				$body = "";
			}elseif(isset($_GET['massadd'])){
				// Mass add smilies
				foreach($_POST as $key=>$val){
					if(eregi("^sm_([0-9]*)",$key,$match) && $val != ""){
						$_POST["smurl_$match[1]"] = "<img src=\"./smilies/{$_POST["smurl_$match[1]"]}\">";
						$filters->add_filter(2,$_POST["sm_$match[1]"],$_POST["smurl_$match[1]"]);
					}
				}
				$filters->reload();
			}
			
			$body = "$txt[498]<Br><Br>
					<table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\" class=\"col_header\">
						<tr>
							<td width=\"75\" height=\"25\">&nbsp;$txt[496]</td>
							<td width=\"75\" height=\"25\">$txt[501]</td>
							<td width=\"75\" height=\"25\">$txt[86]</td>
						</tr>
					</table>
					<table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\" class=\"inside_table\">";
			$type4s = $filters->get_filter_by_type(2);
			foreach($type4s as $key=>$val){
				if(!eregi("<a href=",$val[1])){
					$val[0] = stripslashes($val[0]);
					$body .= "<Tr>
								<td class=\"dark_row\" width=\"75\">$val[0]</td>
								<td class=\"dark_row\" width=\"75\">$val[1]</td>
								<td class=\"dark_row\" width=\"75\"><a href=\"./index.php?act=adminpanel&cp_page=smilies&remove=$val[3]\">[$txt[175]]</a></td>
							</tr>";
				}
			}
			
			$body .= "</table><Br><Br>
			<form action=\"./index.php\" method=\"get\">
				<input type=\"hidden\" name=\"act\" value=\"adminpanel\">
				<input type=\"hidden\" name=\"cp_page\" value=\"smilies\">
				<b>$txt[495]</b><Br>
				&nbsp;&nbsp;&nbsp;&nbsp;$txt[496] <input type=\"text\" name=\"add\" class=\"text_input\"><Br>
				&nbsp;&nbsp;&nbsp;&nbsp;$txt[497] <input type=\"text\" name=\"add2\" class=\"text_input\"><Br>
				&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"submit\" class=\"button\" value=\"$txt[160]\">
			
			</form><Br><Br>";
			
			// Smiley Mass-Add
			$loaded = array();
			foreach($type4s as $key=>$val){
				if(eregi("<img src=\"\./smilies/([^\"]*)\">",$val[1],$match)){
					$loaded[] = $match[1];
				}
			}
			
			$not_loaded = array();
			$smilies_dir = dir("./smilies");
			while($file = $smilies_dir->read()){
				if($file != "." && $file != ".." && $file != "index.html"){
					if(!in_array($file,$loaded))
						$not_loaded[] = $file;
				}
			}
			
			if(count($not_loaded) != 0){
				$body .= "$txt[499]<Br>
						<form action=\"index.php?act=adminpanel&cp_page=smilies&massadd=1\" method=\"post\">";
						
				$i = 0;
				foreach($not_loaded as $key=>$val){
					$i++;
					$body .= "&nbsp;&nbsp;&nbsp;$txt[496]: <input size=\"4\" type=\"text\" class=\"text_input\" name=\"sm_$i\"> <input type=\"hidden\" name=\"smurl_$i\" value=\"$val\"><img src=\"./smilies/$val\"><Br>";
				}
							
				$body .= "&nbsp;&nbsp;&nbsp;<input type=\"submit\" value=\"$txt[160]\" class=\"button\">
						<Br><Br></form>";
			}else{
				$body .= "$txt[500]";
			}
			
			// Upload a CSV List for smilies
			$body .= "<hr>
			<form action=\"index.php?act=adminpanel&cp_page=smilies&upload_and_add=1\" method=\"post\" enctype=\"multipart/form-data\">
			$txt[192]: <input type=\"file\" name=\"smile_list\"> <input type=\"submit\" value=\"$txt[192]\" class=\"button\">
			</form><br><Br>";
		
		}elseif($_GET['cp_page'] == "mods"){
			// Do the mods page
			
			$head = $txt[318];
			
			// Check mods directory permissions
			if(!is_writeable("./mods")){
				$body = "$txt[565]<br><br><A href=\"index.php?act=adminpanel&cp_page=mods\">$txt[398]</a>";
			}elseif(isset($_GET['install'])){
			
				// Check for steps
				if(!isset($_GET['step']))
					$_GET['step'] = 1;
					
				include("./lib/xupdater.php");
				open_package($_GET['install']);
				include("./mods/temp/mod.info");
				
				// Check CHMOD if they are trying to move on
				if($_GET['step'] > 1){
					foreach($CHMOD as $key=>$val){
						if(!is_writeable($val)){
							$_GET['step'] = 1;
						}
					}
				}
				
				if($_GET['step'] == 1){
					// Overview & CHMOD instructions
					$body = "$txt[571]<Br><br>";
					
					// load chmodders
					foreach($CHMOD as $key=>$val){
						$body .= "&nbsp;&nbsp;&nbsp;<b>$val</b><Br>";
					}
					
					$body .= "<Br><Br><a href=\"index.php?act=adminpanel&cp_page=mods&install=$_GET[install]&step=3\">$txt[572]</a> &nbsp; &nbsp; | &nbsp; &nbsp; 
					<a href=\"index.php?act=adminpanel&cp_page=mods&install=$_GET[install]&step=2\">$txt[573]</a> &nbsp; &nbsp; | &nbsp; &nbsp; 
					<a href=\"index.php?act=adminpanel&cp_page=mods\">$txt[77]</a>";
					
				}
				
				if($_GET['step'] == 2){
					// Create a backup if desired
					if(!is_dir("./mods/backup"))
						mkdir("./mods/backup");
						
					@mkdir("./mods/backup/$_GET[install]");
					
					foreach($CHMOD as $key=>$val){
						if(!is_dir($val)){
							eregi("/[^/]*$",$val,$valn);
							copy($val,"./mods/backup/$_GET[install]/$valn[0]");
						}
					}
					
					$_GET['step'] = 3;
				}
				
				if($_GET['step'] == 3){
					// Do run first DB, File edit and File system instructions, run last
					
					run_first();
					
					// Run DB Querys
					foreach($DATABASE as $key=>$val){
						$val = eregi_replace("\{prefix\}",$prefix,$val);
						$db->DoQuery($val);
					}
					
					// Run file edit instructions
					foreach($FIND_REPLACE as $key=>$val){
						mod_replace($val['file'],$val['find'],$val['replace']);
					}
					
					// Run filesystem functions
					foreach($FILE_SYSTEM as $key=>$val){
						if($val['action'] == "copy"){
							copy($val['source'],$val['dest']);
						}elseif($val['action'] == "delete"){
							if(is_dir($val['file']))
								rmdir($val['file']);
							else
								unlink($val['file']);
						}elseif($val['action'] == "mkdir"){
							mkdir($val['directory']);
						}elseif($val['action'] == "make"){
							$fh = fopen($val['file'],"w");
							fwrite($fh,$val['contents']);
							fclose($fh);
						}
						
					}
					
					$body = "$txt[574]<Br><br><div align=\"center\"><a href=\"index.php?act=adminpanel&cp_page=mods\">$txt[77]</div>";
					
					run_last();
					
					// Update the mod_data file
					include("./mods/mod_data");
					$fh = fopen("./mods/mod_data","w");
					fwrite($fh,"<?PHP\n\$mods_installed=array();\n");
					foreach($mods_installed as $key=>$val){
						fwrite($fh,"\$mods_installed['$key'] = \"$val\";\n");
					}
					fwrite($fh,"\$mods_installed[] = \"$_GET[install]\";\n");
					fwrite($fh,"?>");
					fclose($fh);
				}
				
				close_package("./mods/temp");
				
			// THE UNINSTALL PROCESS	
			}elseif(isset($_GET['uninstall'])){
			
				// Check for steps
				if(!isset($_GET['step']))
					$_GET['step'] = 1;
					
				include("./lib/xupdater.php");
				open_package($_GET['uninstall']);
				include("./mods/temp/uninstall.info");
				
				// Check CHMOD if they are trying to move on
				if($_GET['step'] > 1){
					foreach($CHMOD as $key=>$val){
						if(!is_writeable($val)){
							$_GET['step'] = 1;
						}
					}
				}
				
				if($_GET['step'] == 1){
					// Overview & CHMOD instructions
					$body = "$txt[571]<Br><br>";
					
					// load chmodders
					foreach($CHMOD as $key=>$val){
						$body .= "&nbsp;&nbsp;&nbsp;<b>$val</b><Br>";
					}
					
					$body .= "<Br><Br><a href=\"index.php?act=adminpanel&cp_page=mods&uninstall=$_GET[uninstall]&step=3\">$txt[575]</a> &nbsp; &nbsp; | &nbsp; &nbsp; 
					<a href=\"index.php?act=adminpanel&cp_page=mods\">$txt[77]</a>";
					
				}
				
				if($_GET['step'] == 3){
					// Do run first DB, File edit and File system instructions, run last
					
					run_first();
					
					// Run DB Querys
					foreach($DATABASE as $key=>$val){
						$val = eregi_replace("\{prefix\}",$prefix,$val);
						$db->DoQuery($val);
					}
					
					// Run file edit instructions
					foreach($FIND_REPLACE as $key=>$val){
						mod_replace($val['file'],$val['find'],$val['replace']);
					}
					
					// Run filesystem functions
					foreach($FILE_SYSTEM as $key=>$val){
						if($val['action'] == "copy"){
							copy($val['source'],$val['dest']);
						}elseif($val['action'] == "delete"){
							if(is_dir($val['file']))
								rmdir($val['file']);
							else
								unlink($val['file']);
						}elseif($val['action'] == "mkdir"){
							mkdir($val['directory']);
						}elseif($val['action'] == "make"){
							$fh = fopen($val['file'],"w");
							fwrite($fh,$val['contents']);
							fclose($fh);
						}
						
					}
					
					run_last();
					
					$body = "$txt[576]<Br><br><div align=\"center\"><a href=\"index.php?act=adminpanel&cp_page=mods\">$txt[77]</div>";
					
				}
				
				close_package("./mods/temp");
			
				// Update the mod_data file
				include("./mods/mod_data");
				$fh = fopen("./mods/mod_data","w");
				fwrite($fh,"<?PHP\n\$mods_installed=array();\n");
				$ky = array_search($_GET['uninstall'],$mods_installed);
				unset($mods_installed[$ky]);
				foreach($mods_installed as $key=>$val){
					fwrite($fh,"\$mods_installed['$key'] = \"$val\";\n");
				}
				fwrite($fh,"?>");
				fclose($fh);
				
			
			}else{
				// Ok, mods are [OK]
				
				// If installed mod data isn't set up yet then do it
				if(!is_file("./mods/mod_data")){
					$fh = fopen("./mods/mod_data","w");
					fwrite($fh,"<?PHP\n\$mods_installed=array();\n?>\n");
					fclose($fh);
				}
				
				// Include the mod file and library file
				include("./mods/mod_data");
				include("./lib/xupdater.php");
				
				// Auto-Detect any new mods
				$mods = get_uploaded_mods();
				$installed = array();
				
				// See if they are already installed, or not
				foreach($mods as $key=>$val){
					if(in_array($val['file'],$mods_installed)){
						$installed[] = $val;
						unset($mods[$key]);
					}
				}
				
				// Ok, we now have info on the mods not installed and the
				// mods that are installed.  Lets show em
				
				$body = "<Br><div align=\"center\"><b>$txt[567]</b><Br>
						<table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"col_header\">
							<tr>
								<td width=\"150\" height=\"25\">&nbsp;$txt[570]</td>
								<td width=\"100\" height=\"25\">$txt[86]</td>
							</tr>
						</table>
						<table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"inside_table\">";
					
				foreach($installed as $key=>$val){
				
					$body .= "<tr>
								<Td width=\"150\" class=\"dark_row\"><a href=\"index.php?act=adminpanel&cp_page=mods&show_info=$val[file]\">$val[name]</a></td>
								<td width=\"100\" class=\"dark_row\"><a href=\"index.php?act=adminpanel&cp_page=mods&uninstall=$val[file]\">$txt[568]</a></td>
							</tr>";
				
				}
						
				$body .= "</table><Br>";
				
				// Do not installed mods
				$body .= "<Br><div align=\"center\"><b>$txt[569]</b><Br>
						<table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"col_header\">
							<tr>
								<td width=\"150\" height=\"25\">&nbsp;$txt[570]</td>
								<td width=\"100\" height=\"25\">$txt[86]</td>
							</tr>
						</table>
						<table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"inside_table\">";
					
				foreach($mods as $key=>$val){
				
					$body .= "<tr>
								<Td width=\"150\" class=\"dark_row\"><a href=\"index.php?act=adminpanel&cp_page=mods&show_info=$val[file]\">$val[name]</a></td>
								<td width=\"100\" class=\"dark_row\"><a href=\"index.php?act=adminpanel&cp_page=mods&install=$val[file]\">$txt[400]</a></td>
							</tr>";
				
				}
						
				$body .= "</table><Br><Br><div align=\"center\"><a href=\"http://mods.x7chat.com/\" target=\"_blank\">$txt[566]</a></div>";
					
			}
			
		
		
		}elseif($_GET['cp_page'] == "help"){
			$head = $txt[34];
			$body = $txt[502];
			
		}elseif($_GET['cp_page'] == "keywords"){
			$head = $txt[144];
			
			include("./lib/filter.php");
			$filters = new filters();

			if(isset($_GET['add']) && isset($_GET['add2'])){
				$body = "$txt[167]<Br><Br>";

				// Pre-process this stuff to make sure they are not hackin
				$_GET['add2'] = eregi_replace("\"","%34",$_GET['add2']);
				$_GET['add2'] = eregi_replace("'","%39",$_GET['add2']);

				if(!eregi("^http://","$_GET[add2]"))
					$_GET['add2'] = "http://$_GET[add2]";
				$_GET['add2'] = "<a href=\"$_GET[add2]\" target=\"_blank\">$_GET[add]</a>";

				$filters->add_filter(3,$_GET['add'],$_GET['add2']);
				$filters->reload();
			}elseif(isset($_GET['remove'])){
				$body = "$txt[167]<Br><Br>";
				$filters->remove_server_keyword($_GET['remove']);
				$filters->reload();
			}else{
				$body = "";
			}

			$body .= "$txt[168]<Br>";
			$type4s = $filters->get_filter_by_type(3);
			foreach($type4s as $key=>$val){
				// See if this is a keyword or a filter
				if(eregi("<a href=",$val[1])){
					$val[1] = preg_match("/\"(.+?)\"/i",$val[1],$match);
					$val[1] = $match[1];

					$body .= "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"./index.php?act=adminpanel&cp_page=keywords&remove=$val[0]\">$val[0]</a> ($val[1])<Br>";
				}
			}

			$body .= "<Br><Br>
			<form action=\"./index.php\" method=\"get\">
				<input type=\"hidden\" name=\"act\" value=\"adminpanel\">
				<input type=\"hidden\" name=\"cp_page\" value=\"keywords\">
				<b>$txt[169]</b><Br>
				&nbsp;&nbsp;&nbsp;&nbsp;$txt[165] <input type=\"text\" name=\"add\" class=\"text_input\"><Br>
				&nbsp;&nbsp;&nbsp;&nbsp;$txt[170] <input type=\"text\" name=\"add2\" class=\"text_input\"><Br>
				&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"submit\" class=\"button\" value=\"$txt[169]\">

			</form>";
			
		}elseif($_GET['cp_page'] == "ad"){
			// A permission denied error occured, Don't show admin menu, only the error
			$head = $txt[14];
			$cbody = $txt[216];
			$perm_error = 1;
		}elseif($_GET['cp_page'] == "ad2"){
			// A permission denied error occured, but this user is an admin so show them the menu anyway
			$head = $txt[14];
			$body = $txt[216];
		}

		if(@$perm_error != 1){

			// THis mini-function helps by checking permissions and printing links
			function printlink($id,$txt){
				global $x7c;

				// See if they have access to this section
				$check_page = $id;
				if($check_page == "groupmanager")
					$check_page = "groups";
				if($x7c->permissions["admin_{$check_page}"] != 1){

					return "";

				}else{

					if($_GET['cp_page'] == $id)
						return "<tr>
									<td width=\"100%\" class=\"ucp_sell\">$txt</td>
								</tr>";
					else
						return  "<tr>
									<td width=\"100%\" class=\"ucp_cell\" onMouseOver=\"javascript: this.className='ucp_sell'\" onMouseOut=\"javascript: this.className='ucp_cell'\"  onClick=\"javascript: window.location='./index.php?act=adminpanel&cp_page=$id'\">$txt</td>
								</tr>";
				}

			}

			// Add the menu to the body
			$cbody = "<div align=\"center\">
				<table border=\"0\" width=\"95%\" class=\"ucp_table\" cellspacing=\"0\" cellpadding=\"0\">
					<tr valign=\"top\">
						<td width=\"25%\" height=\"100%\">
							<table class=\"ucp_table2\" height=\"100%\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">
								".printlink("main",$txt[137])."
								".printlink("news",$txt[307])."
								".printlink("settings",$txt[139])."
								".printlink("themes",$txt[308])."
								".printlink("filter",$txt[143])."
								".printlink("keywords",$txt[144])."
								".printlink("groupmanager",$txt[309])."
								".printlink("users",$txt[310])."
								".printlink("rooms",$txt[311])."
								".printlink("ban",$txt[312])."
								".printlink("bandwidth",$txt[313])."
								".printlink("logs",$txt[314])."
								".printlink("events",$txt[315])."
								".printlink("mail",$txt[316])."
								".printlink("smilies",$txt[317])."
								".printlink("mods",$txt[318])."
								".printlink("help",$txt[34])."
								<tr valign=\"top\">
									<td width=\"100%\" class=\"ucp_cell\" style=\"cursor: default;\" height=\"100%\"><Br><a href=\"./index.php\">[$txt[29]]</a><Br><a href=\"#\" onClick=\"javascript: window.close();\">[$txt[133]]</a><Br><Br></td>
								</tr>
							</table>
						</td>
						<Td width=\"5\" class=\"ucp_divider\">&nbsp;</td>
						<td width=\"75%\" class=\"ucp_bodycell\">$body</td>
					</tr>
				</table>
				</div>";
		}

		$print->normal_window($head,$print->ss_ucp.$cbody);
		
	}
	
	// I almost called this function wreck_hell() because its used so much
	function update_setting($setting,$newval){
		global $prefix, $db;
		$db->DoQuery("UPDATE {$prefix}settings SET setting='$newval' WHERE variable='$setting'");
	}
 
 ?>
