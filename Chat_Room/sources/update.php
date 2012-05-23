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

		// This is the update frame, handle with care ;)
		// Output ONLY necessary stuff so we can conserve bandwidth
				
		// Add-Delay, why do I have the feeling this is going to become a major pain in the ass
		if(!isset($_GET['delay_added'])){
			$db->DoQuery("DELETE FROM {$prefix}online WHERE name='$x7s->username' AND room='$_GET[room]'");
			echo "<html>
			<head>
			</head>
			<!--<body onLoad=\"document.location='./index.php?act=frame&frame=update&room=$_GET[room]&delay_added=1';\">
			&nbsp;-->
			<body>
			</body>
			</html>";
			exit;
		}
				
		// Start with getting new messages from server
		include("./lib/online.php");
		include("./lib/message.php");
		
		// Get the last update time
		// Returns 2 if room is full
		$lasttime = return_last_time($_GET['room']);
				
		//Check for room limit error
		if($lasttime == 2)
			$script = "window.parent.location='index.php?act=overload'\n";
		else
			$script = "";
		
		// Supress javascript errors
		if(!isset($DEBUG_JAVASCRIPT))
			$script .= "function supresserrors(){\n\r
							return true;\n\r
						}\n\r
						window.onerror=supresserrors;\n\r";
		
		// Load some colors
		$sysmsg_color = $x7c->settings['system_message_color'];
		$default_size = $x7c->settings['sys_default_size'];
		$default_font = $x7c->settings['sys_default_font'];
			
		$change_users = $lasttime[0];
		$users2 = $lasttime[2];
		$users3 = $lasttime[3];
		$lasttime = $lasttime[1];
		$sound_play = 0;
		
		if($lasttime == "")
			$lasttime = 1;
		$time = time();
		$messages = 0;	/* Setting this to 0 means that the scrolling code isn't sent to save bandwidth	*/
		
		// Handle the user list
		if(count($change_users) > 0){
			$users = "";
			foreach($change_users as $key=>$val){
				$users .= "<a href=\"#\" style=\"cursor: pointer;cursor: hand;\" onClick=\"javascript: window.parent.frames[\'profile\'].document.location=\'./index.php?act=frame&frame=profile&room=$_GET[room]&user=$val\';window.parent.frames[\'bottom_right\'].document.getElementById(\'profilename\').innerHTML = \'$txt[90]\';window.parent.frames[\'bottom_right\'].document.getElementById(\'profilestatus\').innerHTML = \'\';window.parent.frames[\'bottom_right\'].document.getElementById(\'profileusergroup\').innerHTML = \'\';\">$val</a><br>";
			}
			foreach($users2 as $key=>$val){
				if($val != "" && $lasttime != time())
					$script .= "window.parent.frames['middle_left'].document.write('<span style=\"color: $sysmsg_color;font-size: $default_size; font-family: $default_font;\"><b>$val $txt[43]</b></span><Br>');\r\n";
				$messages = 1;
			}
			foreach($users3 as $key=>$val){
				if($val != "" && $lasttime != time())
					$script .= "window.parent.frames['middle_left'].document.write('<span style=\"color: $sysmsg_color;font-size: $default_size; font-family: $default_font;\"><b>$val $txt[44]</b></span><Br>');\r\n";
				$messages = 1;
			}
			
			$script .= "window.parent.frames['middle_right'].document.getElementById(\"onlinelist\").innerHTML='$users'\r\n";
			
			if($x7c->settings['disable_sounds'] != 1 && $sound_play != 1){
				if(eregi("MSIE","$_SERVER[HTTP_USER_AGENT]")){
					// wow, the browser you are using is a piece of shit
					// ok then, we'll send you nice code
					$script .= "window.parent.frames['bottom_left'].document.enter_snd.Play();\n";
				}else{
					// At lesat test code actually works here
					$script .= "if(window.parent.frames['bottom_left'].document.enter_snd.Play)\nwindow.parent.frames['bottom_left'].document.enter_snd.Play();\n";
				}
				// Yes, you did seem me just run a fucking browser test and I am not happy about it
				$sound_play = 1;
			}
			
		}
		
		
		if($lasttime == 1){
			// We need to put the background image if there is one there
			$image = $x7c->settings['background_image'];
			if($image != ""){
				$background = " style=\"background-attachment: fixed;background-image: url($image);\"";
			}else{
				$background = "";
			}
			$script .= "window.parent.frames['middle_left'].document.write('<html>$print->ss_mini<body$background>')\n";
			
			
			// We need to send the greeting, if there is one
			if($x7c->room_data['greeting'] != ""){
				$x7c->room_data['greeting'] = eregi_replace("'","\\'",$x7c->room_data['greeting']);
				$script .= "window.parent.frames['middle_left'].document.write('<b><font color=\"$sysmsg_color\">{$x7c->room_data['greeting']}</font></b><br>')\n";
			}
		
		}
		
		// Get messages to display
		if($lasttime > 1){
			// This is a very long query
			// It gets the new messages that are (in order):
			//		* Regular messages from users to the chat room
			//		* Messages from the System only to you
			//		* Messages from the Administrator to all chat rooms
			//		* Messages from the room operator/administrator to only this room
			//		* Offline messages that have not been read
			//		* Private messages
			$PM_COUNT = 0;
			$lt1 = $lasttime-1;
			$time1 = time()-1;
			
			// Private message Stuff
			$pm_time = time()-2*($x7c->settings['refresh_rate']/1000);
			$pms_found = 0;
			
			// Run the query
			$query = $db->DoQuery("SELECT user,type,body,time FROM {$prefix}messages WHERE 
									room='$_GET[room]' AND time>=$lt1 AND time<$time1 AND user<>'$x7s->username' AND type='1' OR 
									room='$x7s->username' AND time>$lt1 AND time<=$time1 AND type='3' OR
									type='2' AND time>=$lt1 AND time<$time1 OR
									type='4' AND time>=$lt1 AND time<$time1 AND room='$_GET[room]' OR 
									type='6' AND room='$x7s->username' AND time='0' OR 
									type='5' AND room='$x7s->username:0' AND time<'$pm_time' 
									ORDER BY time ASC");
			
			// Check for any database errors
			if($db->error == 4){
				$query = eregi_replace("'","\\'",$query);
				$query = eregi_replace("\n","",$query);
				$query = eregi_replace("\r","",$query);
				$script .= "\n\nwindow.parent.location='./index.php?act=panic&dump=$query&source=/sources/frame.php:144';\n\n";
			}
			
			while($row = $db->Do_Fetch_Row($query)){
				if(!in_array($row[0],$x7c->profile['ignored'])){
					$row[2] = eregi_replace("'","\\'",$row[2]);
					
					if($row[1] == 1){
						$row[2] = parse_message($row[2]);
						
						// See if they want a timestamp
						if($x7c->settings['disble_timestamp'] != 1)
							$timestamp = format_timestamp($row[3]);
						else
							$timestamp = "";
						
						$script .= "window.parent.frames['middle_left'].document.write('<span class=\"other_persons\"><a class=\"other_persons\" onClick=\"javascript: window.open(\'index.php?act=pm&send_to=$row[0]\',\'Pm$row[0]\',\'location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width={$x7c->settings['tweak_window_large_width']},height={$x7c->settings['tweak_window_large_height']}\');\">$row[0]</a>$timestamp:</span> $row[2]<br>');\r\n";
					}elseif($row[1] == 2 || $row[1] == 3 || $row[1] == 4){
						$row[2] = parse_message($row[2],1);
						//$script .= "alert('$row[1] is what got u and $row[0] is who duunit');\r\n";
						$script .= "window.parent.frames['middle_left'].document.write('$row[2]<br>');\r\n";
					}elseif($row[1] == 6){
						$PM_COUNT++;
					}elseif($row[1] == 5){
						$script .= "window.open('index.php?act=pm&send_to=$row[0]','Pm$row[0]','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width={$x7c->settings['tweak_window_large_width']},height={$x7c->settings['tweak_window_large_height']}');\r\n";
						$txt[511] = eregi_replace("<a>","<a style=\"cursor: hand;cursor: pointer;\" onClick=\"window.open(\\'index.php?act=pm&send_to=$row[0]\\',\\'Pm$row[0]\\',\\'location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width={$x7c->settings['tweak_window_large_width']},height={$x7c->settings['tweak_window_large_height']}\\');\">",$txt[511]);	
						$script .= "window.parent.frames['middle_left'].document.write('<span style=\"color: $sysmsg_color;font-size: $default_size; font-family: $default_font;\"><b>$txt[511]</b></span><Br>')\r\n";
					}
					
					$messages++;
				}
			}
		}

		
		if($messages != 0){
			/*$script .= '
			if(typeof(scrollBy) != "undefined"){
				window.parent.frames[\'middle_left\'].window.scrollBy(0, 65000);
			}else{
				window.parent.frames[\'middle_left\'].window.scroll(0, 65000);
			}'."\r\n";
			*/
			
			// Smooth Scrolling
			$rate = ($x7c->settings['refresh_rate']*3)-1;
			$script .= "
			current = 0;\r\n
			function scroll_screen(){\r\n
				window.parent.frames['middle_left'].window.scrollBy(0, 25);\r\n
				if(current < $rate){\r\n
					this_timeout = setTimeout('scroll_screen()','250');
					current++;
				}else{
					window.parent.frames['middle_left'].window.scrollBy(0, 65000);\r\n
				}\r\n
			}\r\n
			scroll_screen();\r\n";
		
			if($x7c->settings['disable_sounds'] != 1 && $sound_play != 1)
				if(eregi("MSIE","$_SERVER[HTTP_USER_AGENT]")){
					// wow, the browser you are using is a piece of shit
					// ok then, we'll send you nice code
					$script .= "window.parent.frames['bottom_left'].document.msg_snd.Play();\n";
				}else{
					// At lesat test code actually works here
					$script .= "if(window.parent.frames['bottom_left'].document.msg_snd.Play)\nwindow.parent.frames['bottom_left'].document.msg_snd.Play();\n";
				}
				// Yes, you did seem me just run a fucking browser test and I am not happy about it
		}
					
		// See if they are banned
		$bans = $x7p->bans_on_you;

		foreach($bans as $key=>$row){
		
			// If a row returned and they don't have immunity then thrown them out the door and lock up
			if($row != "" && $x7c->permissions['ban_kick_imm'] != 1){
				if($row[1] == "*"){
					// They are banned from the server
					$txt[117] = eregi_replace("_r",$row[5],$txt[117]);
					$script = "alert('$txt[117]')\n
								window.parent.location='./index.php'\r\n";
				}elseif($row[1] == $x7c->room_data['id'] && $row[4] == 60){
					// They are kicked from this room
					$txt[115] = eregi_replace("_r",$row[5],$txt[115]);
					$script = "alert('$txt[115]')\n
								window.parent.location='./index.php?act=kicked'\r\n";
					$db->DoQuery("DELETE FROM {$prefix}online WHERE name='$x7s->username' AND room='$_GET[room]'");
				}elseif($row[1] == $x7c->room_data['id']){
					// They are banned from this room
					$txt[116] = eregi_replace("_r",$row[5],$txt[116]);
					$script = "alert('$txt[116]')\n
								window.parent.location='./index.php?act=kicked'\r\n";
					$db->DoQuery("DELETE FROM {$prefix}online WHERE name='$x7s->username' AND room='$_GET[room]'");
				}
			}
		}
				
		// See if they have used up all their allowed bandwidth
		if($x7c->settings['log_bandwidth'] == 1){
			if($BW_CHECK){
				$script .= "window.parent.location='./index.php'\r\n";
			}
		}
		
		// Tell them about any new PMs that they have
		if(!isset($PM_COUNT))
			$PM_COUNT = "-";
		//$script .= "window.parent.frames['topf'].document.pm_form.numpms.value = '$PM_COUNT';\r\n";
		$script .= "window.parent.frames['topf'].document.getElementById('numpms').innerHTML = '$PM_COUNT';\r\n";
		
		// Debug
		//$script .= "window.parent.frames['middle_left'].document.write('$temp44<Br>');";
		
		// Output as little as possible here to save monthly bandwidth total
		$refreshplus5 = ($x7c->settings['refresh_rate']/1000)+5;
		echo "<html><head><meta http-equiv=\"refresh\" content=\"{$refreshplus5}\"><script language=\"javascript\" type=\"text/javascript\">$script\r\n</script></head><body onLoad=\"javascript: setTimeout('location.reload()','{$x7c->settings['refresh_rate']}');\">&nbsp;</body>";
?>