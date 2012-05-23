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

	// Handle the user Control panel
	function usercp_master(){
		global $x7p, $x7s, $print, $db, $txt, $x7c, $prefix, $auth_pcookie, $X7CHAT_CONFIG;

		$head = $txt[135];
		$body = $txt[136];

		if(!isset($_GET['cp_page']))
			$_GET['cp_page'] = "main";

		if(@$_GET['cp_page'] == "main"){
			// The main CP -- hmm, duh
			$head = $txt[135];
			$body = $txt[136];

		}elseif($_GET['cp_page'] == "status"){
			// Do the status page
			include("./lib/status.php");
			$head = $txt[140];
			if(isset($_GET['new_status'])){
				set_status($_GET['new_status']);
				$body = "$txt[148]: <i>";
			}else{
				$body = "$txt[146]: <i>";
			}

			$maxchars = $x7c->settings['maxchars_status'];
			$body .= "{$x7p->profile['status']}</i><br><Br>
					$txt[147]:<Br>
					&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"./index.php?act=userpanel&cp_page=status&new_status=$txt[149]\">$txt[149]</a><Br>
					&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"./index.php?act=userpanel&cp_page=status&new_status=$txt[150]\">$txt[150]</a><Br>
					&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"./index.php?act=userpanel&cp_page=status&new_status=$txt[151]\">$txt[151]</a><Br>
					&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"./index.php?act=userpanel&cp_page=status&new_status=$txt[152]\">$txt[152]</a><Br>
					<Br>
					<form action=\"index.php\" method=\"get\">
						&nbsp;&nbsp;&nbsp;&nbsp;$txt[153]:
						<input type=\"hidden\" name=\"act\" value=\"userpanel\">
						<input type=\"hidden\" name=\"cp_page\" value=\"status\">
						<input type=\"text\" class=\"text_input\" name=\"new_status\" size=\"20\">
						<input type=\"submit\" class=\"button\" value=\"$txt[154]\"><Br>
						&nbsp;&nbsp;&nbsp;&nbsp;$txt[155] ($maxchars)
					</form>
					";

		}elseif($_GET['cp_page'] == "blocklist"){
			$head = $txt[141];

			if(isset($_GET['remove'])){

				include("./lib/usercontrol.php");
				$userinfo = new user_control($_GET['remove']);
				$userinfo->unignore();
				$txt[158] = eregi_replace("_u",$_GET['remove'],$txt[158]);
				$body = $txt[158]."<Br><Br>";

			}elseif(isset($_GET['add'])){

				include("./lib/usercontrol.php");
				$userinfo = new user_control($_GET['add']);
				$userinfo->ignore();
				$txt[161] = eregi_replace("_u",$_GET['add'],$txt[161]);
				$body = $txt[161]."<Br><Br>";

			}else{
				$body = "";
			}

			$body .= "$txt[156]<Br>";

			// Get the blocked users
			$query = $db->DoQuery("SELECT ignored_user FROM {$prefix}muted WHERE user='$x7s->username'");
			while($row = $db->Do_Fetch_Row($query)){
				$body .= "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"./index.php?act=userpanel&cp_page=blocklist&remove=$row[0]\">[$row[0]]</a><Br>";
			}

			$body .= "<Br><div align=\"center\">
			<form action=\"./index.php\" method=\"get\">
				$txt[159]
				<input type=\"hidden\" name=\"act\" value=\"userpanel\">
				<input type=\"hidden\" name=\"cp_page\" value=\"blocklist\">
				<input type=\"text\" class=\"text_input\" name=\"add\">
				<input type=\"submit\" class=\"button\" value=\"$txt[160]\">
			</form></div>";

		}elseif($_GET['cp_page'] == "wfilter"){

			$head = $txt[143];
			include("./lib/filter.php");
			$filters = new filters();

			if(isset($_GET['add']) && isset($_GET['add2'])){
				$txt[162] = eregi_replace("_w",$_GET['add'],$txt[162]);
				$body = "$txt[162]<Br><Br>";
				$filters->add_filter(5,$_GET['add'],$_GET['add2']);
				$filters->reload();
			}elseif(isset($_GET['remove'])){
				$txt[163] = eregi_replace("_w",$_GET['remove'],$txt[163]);
				$body = "$txt[163]<Br><Br>";
				$filters->remove_user_filter($_GET['remove']);
				$filters->reload();
			}else{
				$body = "";
			}

			$body .= "$txt[145]<Br>";
			$type5s = $filters->get_filter_by_type(5);
			foreach($type5s as $key=>$val){
				if(!eregi("<a href=",$val[1])){
					$body .= "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"./index.php?act=userpanel&cp_page=wfilter&remove=$val[0]\">$val[0] ($val[1])</a><Br>";
				}
			}

			$body .= "<Br><Br>
			<form action=\"./index.php\" method=\"get\">
				<input type=\"hidden\" name=\"act\" value=\"userpanel\">
				<input type=\"hidden\" name=\"cp_page\" value=\"wfilter\">
				<b>$txt[164]</b><Br>
				&nbsp;&nbsp;&nbsp;&nbsp;$txt[165] <input type=\"text\" name=\"add\" class=\"text_input\"><Br>
				&nbsp;&nbsp;&nbsp;&nbsp;$txt[166] <input type=\"text\" name=\"add2\" class=\"text_input\"><Br>
				&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"submit\" class=\"button\" value=\"$txt[160]\">

			</form>";

		}elseif($_GET['cp_page'] == "msgcenter"){

			$head = $txt[142];

			include("./lib/message.php");

			if(isset($_GET['to']) && isset($_GET['subject']) && isset($_GET['body'])){
				$body = "$txt[171]<Br><Br>";

				// Make sure the subject isn't null
				if($_GET['subject'] == "")
					$_GET['subject'] = $txt[173];

				// Send the msg
				$_GET['body'] = eregi_replace("\n","<Br>",$_GET['body']);

				$query = $db->DoQuery("SELECT * FROM {$prefix}users WHERE username='$_GET[to]'");
				$row = $db->Do_Fetch_Row($query);
				if($row[0] == "")
					$person_error = true;
				else
					$person_error = false;

				if(count_offline($_GET['to']) >= $x7c->settings['max_offline_msgs'] && $x7c->settings['max_offline_msgs'] != 0){
					$body = $txt[184]."<Br><Br>";
					$_GET['msg'] = $_GET['body'];
				}elseif($person_error){
					// Person doesn't exist
					$body = $txt[610]."<Br><Br>";
					$_GET['msg'] = $_GET['body'];
				}else{
					send_offline_msg($_GET['to'],$_GET['subject'],$_GET['body']);
					// Reset values
					$_GET['subject'] = "";
					$_GET['to'] = "";
				}

				if(isset($_GET['msg']))
					$_GET['msg'] = eregi_replace("<Br>","\n",$_GET['msg']);

			}elseif(isset($_GET['delete'])){
				$body = "$txt[177]<Br><br>";
				offline_delete($_GET['delete']);
			}else{
				$body = "";
			}

			$msgs = get_offline_msgs();

			if(isset($_GET['read'])){
				// Print an individual message

				offline_markasread($_GET['read']);

				$mid = $_GET['read'];
				$author = $msgs[$mid][1];

				$nb = offline_msg_split($msgs[$mid][2]);
				$msgbody = $nb[0];
				$subject = $nb[1];

				// Set default values for reply form
				$_GET['to'] = $author;

				if(!eregi("^$txt[176]",$subject))
					$_GET['subject'] = "$txt[176]$subject";
				else
					$_GET['subject'] = $subject;

				$replybody = remove_chattags($msgbody);
				$replybody = eregi_replace("<br>","\n",$replybody);
				$_GET['msg'] = "\n\n$txt[174]\n".$replybody;

				$msgbody = parse_message($msgbody);

				$body .= "<Br><Br><table width=\"98%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
						<Tr>
							<td class=\"col_header\">&nbsp;$subject</td>
						</tr>
						</table>
						<table class=\"inside_table\" width=\"98%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">
						<Tr>
							<td class=\"dark_row\"><B>$txt[179]: $author</b><hr><br></td>
						</tr>
						<Tr>
							<td class=\"dark_row\">$msgbody</td>
						</tr>
						<Tr>
							<td class=\"dark_row\"><br><hr><a href=\"./index.php?act=userpanel&cp_page=msgcenter&delete=$mid\">[$txt[175]]</a></td>
						</tr>
					</table><Br><Br><div align=\"center\"><a href=\"index.php?act=userpanel&cp_page=msgcenter\">[$txt[77]]</a></div>";

			}else{
				// Display a table of all messages

				$body .= "$txt[172]<Br><Br><table width=\"98%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"col_header\">
						<tr>
							<td width=\"30\"></td>
							<td width=\"100\">$txt[178]</td>
							<td width=\"100\">$txt[179]</td>
							<td>&nbsp;</td>
						</tr>
						</table>
						<table width=\"98%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"inside_table\">
						";

				foreach($msgs as $id=>$val){
					$mid = $id;
					$author = $val[1];

					$nb = offline_msg_split($val[2]);
					$msgbody = $nb[0];
					$subject = $nb[1];

					if($val[3] == 0)
						$img = "<img src=\"{$print->image_path}new_mail.gif\">";
					else
						$img = "<img src=\"{$print->image_path}old_mail.gif\">";

					$body .= "<tr>
								<td width=\"30\" class=\"dark_row\">$img</td>
								<td width=\"100\" class=\"dark_row\"><a href=\"./index.php?act=userpanel&cp_page=msgcenter&read=$mid\">$subject</a></td>
								<td width=\"100\" class=\"dark_row\">$author</td>
								<td class=\"dark_row\"><a href=\"./index.php?act=userpanel&cp_page=msgcenter&delete=$mid\">[$txt[175]]</a></td>
							</tr>";
				}

				$body .= "</table>";

				// Display Inbox totals
				if($x7c->settings['max_offline_msgs'] != 0){
					$number = count_offline($x7s->username);
					$percentage = ($number/$x7c->settings['max_offline_msgs'])*100;
					$percentage .= "%";

					$number = $x7c->settings['max_offline_msgs']-$number;

					$txt[185] = eregi_replace("_p",$percentage,$txt[185]);
					$txt[185] = eregi_replace("_n","$number",$txt[185]);

					$body .= "<Br><br>$txt[185]";

				}

			}

			// DO send form

			// These three isset() things are checking for default field values
			if(!isset($_GET['subject']))
				$_GET['subject'] = "";

			if(!isset($_GET['to']))
				$_GET['to'] = "";

			if(!isset($_GET['msg']))
				$_GET['msg'] = "";

			$body .= "<br><br><div align=\"center\">
				<form action=\"./index.php\" method=\"get\">
				<b>$txt[181]</b><Br>
				<input type=\"hidden\" name=\"act\" value=\"userpanel\">
				<input type=\"hidden\" name=\"cp_page\" value=\"msgcenter\">
				$txt[182]: <input class=\"text_input\" type=\"text\" name=\"to\" value=\"$_GET[to]\"><Br>
				$txt[183]: <input class=\"text_input\" type=\"text\" name=\"subject\" value=\"$_GET[subject]\"><br>
				<textarea name=\"body\" class=\"text_input\" cols=\"25\" rows=\"7\">$_GET[msg]</textarea><Br>
				<input type=\"submit\" value=\"$txt[181]\" class=\"button\">
				</form></div>";


		}elseif($_GET['cp_page'] == "profile"){

			$head = $txt[85];

			if(isset($_POST['email'])){
				$error = "";

				$email = $_POST['email'];

				// Parse incoming Data
				if(!eregi("^[^@]*@[^.]*\..*$",$_POST['email']))
					$error = $txt[24]."<Br>";

				if($_POST['pass1'] != $_POST['pass2'])
					$error .= $txt[26]."<Br>";

				if($_POST['pass1'] == ""){
					$update_pass = "";
				}else{
					// Update their cookie so they stay logged in
					setcookie($auth_pcookie,auth_encrypt($_POST['pass1']),time()+$x7c->settings['cookie_time'],$X7CHAT_CONFIG['COOKIE_PATH']);
					change_pass($x7s->username,$_POST['pass1']);
				}

				// Make sure this looks at least a little like a URL
				if(!preg_match("#^http://#",$_POST['avatar']))
					$_POST['avatar'] = "http://".$_POST['avatar'];

				if($error == ""){
					$body = $txt[188];
					$db->DoQuery("UPDATE {$prefix}users SET email='$email',avatar='$_POST[avatar]',name='$_POST[rname]',location='$_POST[location]',hobbies='$_POST[hobbies]',bio='$_POST[bio]',gender='$_POST[gender]' WHERE username='$x7s->username'");
				}else{
					$body = "<div align=\"center\">".$error."<Br><Br><a href=\"./index.php?act=userpanel&cp_page=profile\">$txt[77]</a></div>";
				}

			}else{

				$body = "<Br>
						<form action=\"index.php?act=userpanel&cp_page=profile\" method=\"post\" name=\"profileform\">
						<table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">
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
								<td width=\"100\"><input type=\"text\" name=\"email\" class=\"text_input\" value=\"{$x7p->profile['email']}\"></td>
							</tr>

							<tr>
								<td width=\"60\">$txt[31]:</td>
								<td width=\"100\"><input type=\"text\" name=\"rname\" class=\"text_input\" value=\"{$x7p->profile['name']}\"></td>
							</tr>

							<tr>
								<td width=\"60\">$txt[121]:</td>
								<td width=\"100\"><input type=\"text\" name=\"location\" class=\"text_input\" value=\"{$x7p->profile['location']}\"></td>
							</tr>

							<tr>
								<td width=\"60\">$txt[122]:</td>
								<td width=\"100\"><input type=\"text\" name=\"hobbies\" class=\"text_input\" value=\"{$x7p->profile['hobbies']}\"></td>
							</tr>

							<tr>
								<td width=\"60\">$txt[124]:</td>
								<td width=\"100\"><textarea class=\"text_input\" name=\"bio\" cols=\"18\">{$x7p->profile['bio']}</textarea></td>
							</tr>

							<tr>
								<td width=\"60\">$txt[186]:</td>
								<td width=\"100\">
									<select name=\"gender\" class=\"text_input\">
										<option value=\"0\" ";$body .= ($x7p->profile['gender'] == 0) ? "selected=true":"";$body .= ">$txt[191]</option>
										<option value=\"1\" ";$body .= ($x7p->profile['gender'] == 1) ? "selected=true":"";$body .= ">$txt[189]</option>
										<option value=\"2\" ";$body .= ($x7p->profile['gender'] == 2) ? "selected=true":"";$body .= ">$txt[190]</option>

									</select>
								</td>
							</tr>

							<tr>
								<td width=\"60\">$txt[125]:";$body .= ($x7c->settings['enable_avatar_uploads'] == 1) ? "<Br><a href=\"#\" onClick=\"javascript: window.open('index.php?act=userpanel&cp_page=upload','','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width={$x7c->settings['tweak_window_large_width']},height={$x7c->settings['tweak_window_large_height']}');\">[$txt[192]]</a>":"";$body.="</td>
								<td width=\"100\"><input type=\"text\" name=\"avatar\" class=\"text_input\" value=\"{$x7p->profile['avatar']}\"></td>
							</tr>

							<tr>
								<td width=\"160\" colspan=\"2\"><div align=\"center\"><input type=\"submit\" value=\"$txt[187]\" class=\"button\"></div></td>
							</tr>
						</table><Br>";

			}

		}elseif($_GET['cp_page'] == "upload"){

			$head = $txt[192];

			if(isset($_GET['uploaded'])){
				// Do the upload
				include("./lib/uploads.php");
				$returned = handle_uploaded_avatar();

				if($returned == 1){
					$body = $txt[195];
				}elseif($returned == 2){
					$body = $txt[196];
				}elseif($returned == 3){
					$body = $txt[197];
				}elseif($returned == 4){
					$body = $txt[198];
				}else{
					$db->DoQuery("UPDATE {$prefix}users SET avatar='$returned' WHERE username='$x7s->username'");
					$body = $txt[194];
					$body .= "\n\n
						<script langauge=\"javascript\" type=\"text/javascript\">
							if(opener.document.profileform.avatar.value){
								opener.document.profileform.avatar.value = '$returned';
							}
						</script>";
				}


			}else{
				// Print the upload form
				$txt[193] = eregi_replace("_b",$x7c->settings['avatar_max_size'],$txt[193]);
				$txt[193] = eregi_replace("_d",$x7c->settings['avatar_size_px'],$txt[193]);

				$body = "<br>$txt[193]<br><Br><div align=\"center\"><form action=\"index.php?act=userpanel&cp_page=upload&uploaded=1\" method=\"post\" enctype=\"multipart/form-data\">
 					<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"{$x7c->settings['avatar_max_size']}\" />
					<input type=\"file\" name=\"avatar\"><Br>
					<input type=\"submit\" value=\"$txt[192]\" class=\"button\">
				</form></div>";

			}

		}elseif($_GET['cp_page'] == "settings"){

			$head = $txt[139];

			if(isset($_GET['settings_change'])){

				// Pre-parse certain values
				$_POST['cookie_time'] = $_POST['cookie_time']*3600;
				$_POST['refresh_rate'] = $_POST['refresh_rate']*1000;
				($_POST['time_offset_hours'] == "" || $_POST['time_offset_hours'] == $x7c->settings['sys_time_offset_hours']) ? $_POST['time_offset_hours'] = "default" : "" ;
				($_POST['time_offset_mins'] == "" || $_POST['time_offset_mins'] == $x7c->settings['sys_time_offset_mins']) ? $_POST['time_offset_mins'] = "default" : "" ;

				(@$_POST['disable_styles'] == "") ? $_POST['disable_styles'] = 0 : "" ;
				(@$_POST['disable_smiles'] == "") ? $_POST['disable_smiles'] = 0 : "" ;
				(@$_POST['disable_sounds'] == "") ? $_POST['disable_sounds'] = 0 : "" ;
				(@$_POST['disble_timestamp'] == "") ? $_POST['disble_timestamp'] = 0 : "" ;
				(@$_POST['hideemail'] == "") ? $_POST['hideemail'] = 0 : "" ;
				(@$_POST['log_pms'] == "" || $x7c->permissions['log_pms'] == 0) ? $_POST['log_pms'] = 0 : "";
				(@$_POST['b_invisible'] == "" || $x7c->permissions['b_invisible'] == 0) ? $_POST['b_invisible'] = 0 : "";

				$new_settings = "$_POST[language];$_POST[skin];$_POST[cookie_time];{$x7c->rawsettings[3]};{$x7c->rawsettings[4]};{$x7c->rawsettings[5]};$_POST[disable_styles];$_POST[disable_smiles];$_POST[disable_sounds];$_POST[disble_timestamp];$_POST[refresh_rate];$_POST[time_offset_hours];$_POST[time_offset_mins];$_POST[log_pms];$_POST[b_invisible]";
				$x7c->edit_user_setting_field($new_settings,$_POST['hideemail']);
				$body = $txt[210];

			}else{

				// Adjust defaults so they match what user is expecting (ie: hours to seconds)
				$def['cookie_time'] = round($x7c->settings['cookie_time']/3600,2);
				$def['refresh_rate'] = round($x7c->settings['refresh_rate']/1000,2);

				// Get language and skin options
				$lng_dir = dir("./lang");
				$skin_dir = dir("./themes");

				$def['languages'] = "<option value=\"default\">$txt[55]</option>";
				$def['skins'] = "<option value=\"default\">$txt[55]</option>";

				while($option = $lng_dir->read()){
					if($option != "." && $option != ".." && $option != "index.html"){
						$option = eregi_replace("\.php","",$option);
						if($option == $x7c->settings['default_lang'] && $x7c->rawsettings[0] != "default")
							$slcted = " SELECTED";
						else
							$slcted = "";
						$def['languages'] .= "<option value=\"$option\"$slcted>$option</option>";
					}
				}

				while($option = $skin_dir->read()){
					if($option != "." && $option != ".." && @is_file("./themes/$option/theme.info")){
						if($option == $x7c->settings['default_skin'] && $x7c->rawsettings[1] != "default")
							$slcted = " SELECTED";
						else
							$slcted = "";
						include("./themes/$option/theme.info");
						$def['skins'] .= "<option value=\"$option\"$slcted>$name</option>";
					}
				}

				// This checks to see whether a check box is checked or not
				($x7c->settings['disable_styles'] == 0) ? $def['disable_styles'] = "" : $def['disable_styles'] = " CHECKED";
				($x7c->settings['disable_smiles'] == 0) ? $def['disable_smiles'] = "" : $def['disable_smiles'] = " CHECKED";
				($x7c->settings['disable_sounds'] == 0) ? $def['disable_sounds'] = "" : $def['disable_sounds'] = " CHECKED";
				($x7c->settings['disble_timestamp'] == 0) ? $def['disble_timestamp'] = "" : $def['disble_timestamp'] = " CHECKED";
				($x7p->profile['hideemail'] == 0) ? $def['hideemail'] = "" : $def['hideemail'] = " CHECKED";
				($x7c->settings['log_pms'] == 0) ? $def['log_pms'] = "" : $def['log_pms'] = " CHECKED";
				($x7c->settings['invisible'] == 0) ? $def['b_invisible'] = "" : $def['b_invisible'] = " CHECKED";

				// Output body
				$body = "<Br>
						<form action=\"index.php?act=userpanel&cp_page=settings&settings_change=1\" method=\"post\">
						<table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">
							<tr>
								<td width=\"90\">$txt[199]:</td>
								<td width=\"100\"><input type=\"text\" name=\"cookie_time\" class=\"text_input\" value=\"$def[cookie_time]\"></td>
							</tr>
							<tr>
								<td width=\"90\">$txt[200]:</td>
								<td width=\"100\"><input type=\"text\" name=\"refresh_rate\" class=\"text_input\" value=\"$def[refresh_rate]\"></td>
							</tr>
							<tr>
								<td width=\"90\">$txt[201]:</td>
								<td width=\"100\"><input type=\"text\" name=\"time_offset_hours\" class=\"text_input\" value=\"{$x7c->settings['time_offset_hours']}\"></td>
							</tr>
							<tr>
								<td width=\"90\">$txt[202]:</td>
								<td width=\"100\"><input type=\"text\" name=\"time_offset_mins\" class=\"text_input\" value=\"{$x7c->settings['time_offset_mins']}\"></td>
							</tr>

							<tr>
								<td width=\"90\">$txt[203]:</td>
								<td width=\"100\">
									<select name=\"skin\" class=\"text_input\">
										$def[skins]
									</select>
								</td>
							</tr>

							<tr>
								<td width=\"90\">$txt[205]:</td>
								<td width=\"100\"><input type=\"checkbox\" name=\"disable_styles\" value=\"1\"$def[disable_styles]></td>
							</tr>
							<tr>
								<td width=\"90\">$txt[206]:</td>
								<td width=\"100\"><input type=\"checkbox\" name=\"disable_smiles\" value=\"1\"$def[disable_smiles]></td>
							</tr>
							<tr>
								<td width=\"90\">$txt[207]:</td>
								<td width=\"100\"><input type=\"checkbox\" name=\"disable_sounds\" value=\"1\"$def[disable_sounds]></td>
							</tr>
							<tr>
								<td width=\"90\">$txt[208]:</td>
								<td width=\"100\"><input type=\"checkbox\" name=\"disble_timestamp\" value=\"1\"$def[disble_timestamp]></td>
							</tr>
							<tr>
								<td width=\"90\">$txt[209]:</td>
								<td width=\"100\"><input type=\"checkbox\" name=\"hideemail\" value=\"1\"$def[hideemail]></td>
							</tr>";

				if($x7c->permissions['log_pms'] == 1)
					$body .= "<tr>
									<td width=\"90\">$txt[241]:</td>
									<td width=\"100\"><input type=\"checkbox\" name=\"log_pms\" value=\"1\"$def[log_pms]></td>
								</tr>";

				if($x7c->permissions['b_invisible'] == 1)
					$body .= "<tr>
									<td width=\"90\">$txt[510]:</td>
									<td width=\"100\"><input type=\"checkbox\" name=\"b_invisible\" value=\"1\"$def[b_invisible]></td>
								</tr>";

				$body .= 	"<tr>
								<td width=\"190\" style=\"text-align: center;\" colspan=\"2\"><input type=\"submit\" class=\"button\" value=\"$txt[154]\"></td>
							</tr>
						</table>
						";

			}

		}elseif($_GET['cp_page'] == "logs"){

			$head = $txt[240];

			if($x7c->permissions['log_pms'] == 0){

				$body = $txt[216];

			}else{

				include("./lib/logs.php");
				$log = new logs(2,"");

				if(isset($_GET['subact'])){
					if($_GET['subact'] == 'enable'){
						// Enable logging
						$x7c->edit_user_settings("log_pms",1);
						$x7c->settings['log_pms'] = 1;

					}elseif($_GET['subact'] == 'disable'){
						// Disable logging
						$x7c->edit_user_settings("log_pms",0);
						$x7c->settings['log_pms'] = 0;

					}elseif(isset($_GET['clear'])){
						// Clear the log
						$_GET['clear'] = eregi_replace("\.","",$_GET['clear']);
						$log->clear("{$x7c->settings['logs_path']}/$x7s->username/$_GET[clear].log");

					}
				}

				if($x7c->settings['log_pms'] == 1)
					$body = "$txt[242].  <a href=\"index.php?act=userpanel&cp_page=logs&subact=disable\">[$txt[245]]</a><Br><Br>";
				else
					$body = "$txt[243].  <a href=\"index.php?act=userpanel&cp_page=logs&subact=enable\">[$txt[244]]</a><Br><Br>";

				// Display file size information
				if($x7c->settings['max_log_user'] != 0){
					$percent1 = round($log->log_size/$x7c->settings['max_log_user'],2)*100;
					$percent1 .= "%";
					$percent2 = 100-$percent1."%";
					$fs1 = round($log->log_size/1024,2);
					$fs2 = round(($x7c->settings['max_log_user']-$log->log_size)/1024,2);
				}else{
					$percent1 = $txt[248];
					$percent2 = $txt[248];
					$fs1 = round($log->log_size/1024,2);
					$fs2 = "($txt[248])";
				}

				$txt[246] = eregi_replace("_p","$percent1",$txt[246]);
				$txt[247] = eregi_replace("_p","$percent2",$txt[247]);
				$txt[246] = eregi_replace("_s","$fs1",$txt[246]);
				$txt[247] = eregi_replace("_s","$fs2",$txt[247]);
				$body .= "$txt[246]<Br>$txt[247]<Br><Br>";

				// If logging is enabled and a log is selected then show the log
				if($x7c->settings['log_pms'] == 1 && isset($_GET['selected_log'])){

					// Get the log contents
				$_GET['selected_log'] = eregi_replace("\.","",$_GET['selected_log']);
					$contents = $log->get_log_contents("{$x7c->settings['logs_path']}/$x7s->username/$_GET[selected_log].log");
					// Calculate the pages display
					$pages = "";
					for($i = 1;$i <= $log->number_of_pages;$i++){
						$pages .= "<a href=\"./index.php?act=userpanel&cp_page=logs&start_page=$i&selected_log=$_GET[selected_log]\">[$i]</a> ";
					}

					$body .= "$txt[249]<Br>$pages<hr>";

					include("./lib/message.php");
					foreach($contents as $linenum=>$entry){
						// Get date and sender
						preg_match("/^(.+?);\[(.+?)\]/",$entry,$match);
						$entry = preg_replace("/^(.+?);\[(.+?)\]/","",$entry);
						$date = date($x7c->settings['date_format_full'],$match[1]);
						$sender = $match[2];
						// Get message
						$message = $entry;

						// Parse and display
						$message = parse_message($message);
						$body .= "<b>$sender</b>[$date]: $message<br>";

					}

					$body .= "<hr>$pages<Br><div align=\"center\"><Br><a href=\"index.php?act=userpanel&cp_page=logs\">[$txt[77]]</a></div><Br><Br>";
				}elseif($x7c->settings['log_pms'] == 1){
					$body .= "$txt[251]<br><Br>";

					$logs = $log->get_pm_loglist();
					foreach($logs as $key=>$user){
						$body .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"index.php?act=userpanel&cp_page=logs&selected_log=$user\">$user</a> <a href=\"index.php?act=userpanel&cp_page=logs&subact=&clear=$user\">[$txt[250]]</a><Br>";
					}
				}

			}

		}

		// THis mini-function determines what the active section link is
		function whatsmyclass($id){
			$x = $_GET['cp_page'];

			if($x == $id)
				return " class=\"ucp_sell\"";
			else
				return " class=\"ucp_cell\" onMouseOver=\"javascript: this.className='ucp_sell'\" onMouseOut=\"javascript: this.className='ucp_cell'\"  onClick=\"javascript: window.location='./index.php?act=userpanel&cp_page=$id'\"";
		}

		// Add the menu to the body
		$cbody = "<div align=\"center\">
			<table border=\"0\" width=\"95%\" class=\"ucp_table\" cellspacing=\"0\" cellpadding=\"0\">
				<tr valign=\"top\">
					<td width=\"25%\" height=\"100%\">
						<table class=\"ucp_table2\" height=\"100%\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">
							<tr>
								<td width=\"100%\"".whatsmyclass("main").">$txt[137]</td>
							</tr>
							<tr>
								<td width=\"100%\"".whatsmyclass("profile").">$txt[138]</td>
							</tr>
							<tr>
								<td width=\"100%\"".whatsmyclass("settings").">$txt[139]</td>
							</tr>
							<tr>
								<td width=\"100%\"".whatsmyclass("status").">$txt[140]</td>
							</tr>
							<tr>
								<td width=\"100%\"".whatsmyclass("blocklist").">$txt[141]</td>
							</tr>
							<tr>
								<td width=\"100%\"".whatsmyclass("msgcenter").">$txt[142]</td>
							</tr>
							<tr>
								<td width=\"100%\"".whatsmyclass("wfilter").">$txt[143]</td>
							</tr>";

		if($x7c->permissions['log_pms'] == 1)
			$cbody .= 		"<tr>
								<td width=\"100%\"".whatsmyclass("logs").">$txt[240]</td>
							</tr>";

		$cbody .= 				"<tr valign=\"top\">
								<td width=\"100%\" class=\"ucp_cell\" style=\"cursor: default;\" height=\"100%\"><Br>";

		if($x7c->settings['single_room_mode'] == "")
			$cbody .= 					"<a href=\"./index.php\">[$txt[29]]</a><Br>";

		$cbody .= 						"<a href=\"#\" onClick=\"javascript: window.close();\">[$txt[133]]</a><Br><Br>
								</td>
							</tr>";

		$cbody .=
						"</table>
					</td>
					<Td width=\"5\" class=\"ucp_divider\">&nbsp;</td>
					<td width=\"75%\" class=\"ucp_bodycell\">$body</td>
				</tr>
			</table>
			</div>";

		$print->normal_window($head,$print->ss_ucp.$cbody);
	}

?>
