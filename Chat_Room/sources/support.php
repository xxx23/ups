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
	// This provides a place for support people to wait while they wait for
	// support requests to arrive
	
	function support_mainpage(){
		global $txt, $db, $x7c, $x7s, $print, $prefix;
		
		// Make sure they are who they say they are
		$supporters= explode(";",$x7c->settings['support_personel']);
		if(!in_array($x7s->username,$supporters)){
			// Give them an access denied message
			$print->normal_window($txt[14],$txt[216]);
			return 0;
		}
		
		// See which page we want
		if(isset($_GET['update'])){
			// Conserve bandwidth like it means your life
			// Make us online
			$query = $db->DoQuery("SELECT * FROM {$prefix}online WHERE name='$x7s->username' AND room='support;'");
			$row = $db->Do_Fetch_Row($query);
			if($row[0] == ""){
				// We are new here
				$time = time();
				$ip = $_SERVER['REMOTE_ADDR'];
				$db->DoQuery("INSERT INTO {$prefix}online VALUES(0,'$x7s->username','$ip','support;','','$time','')");
			}else{
				// Run an update
				$time = time();
				$db->DoQuery("UPDATE {$prefix}online SET time='$time' WHERE name='$x7s->username' AND room='support;'");
			}
			
			// Continuez
			$pm_time = time()-2*($x7c->settings['refresh_rate']/1000);
			$query = $db->DoQuery("SELECT user FROM {$prefix}messages WHERE type='5' AND room='$x7s->username:0' AND time<'$pm_time' ORDER BY time ASC");
			echo mysql_error();
			$script = "";
			while($row = $db->Do_Fetch_Row($query)){
				if(!in_array($row[0],$x7c->profile['ignored'])){
					// Open a new support window
					$script = "window.open('index.php?act=pm&send_to=$row[0]','','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width={$x7c->settings['tweak_window_large_width']},height={$x7c->settings['tweak_window_large_height']}');\r\n";
				}
			}
			
			$body = "<html><head><script language=\"javascript\" type=\"text/javascript\">$script</script></head><body onLoad=\"javascript: setTimeout('location.reload()','{$x7c->settings['refresh_rate']}');\">&nbsp;</body>";
			$print->add($body);
		}else{
			
			// Give them a screen with an update frame and info about site
			$ranroom = "General Chat";
			$body = "<iframe src=\"./index.php?act=support_sit&update=1&room=$ranroom\" width=\"0\" height=\"0\" style=\"visibility: hidden;\"></iframe>";
			$body .= "$txt[603]";
			
			$print->normal_window($txt[599],$body);
		}
		
		return 1;
	}

?>