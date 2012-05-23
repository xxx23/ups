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

	// This file handles private chat stuff

	// Send a private message
	function send_pm($msg,$to){
		global $x7s, $db, $prefix, $x7c, $txt;
		$time = time();
		
		// Check message size limit
		if($x7c->settings['maxchars_msg'] != 0 && strlen($msg) > $x7c->settings['maxchars_msg']){
			alert_private_chat_you($x7s->username,$txt[252]);
			return 0;
		}
		
		$db->DoQuery("INSERT INTO {$prefix}messages VALUES('0','$x7s->username','5','$msg','parsed_body','$to:0','$time')");
		
		// Do logging if required
		if($x7c->settings['log_pms'] == 1 && $to != ""){
			include("./lib/logs.php");
			$log = new logs(2,$to);
			$log->add($x7s->username,$msg);
		}
	}
?> 
