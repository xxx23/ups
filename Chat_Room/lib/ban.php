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
	// Its raining really hard right now.  This file controls banning,
	// which is probably a hell of a lot more obvious than the rain.
	
	// Gets all bans that are placed on you personally
	function get_bans_onyou(){
		global $x7p,$x7s,$db,$prefix;
		$xu = ""; $xp = "";
		if($x7s->username != "")
			$xu = " OR user_ip_email='$x7s->username'";
		if($x7p)
			if($x7p->profile['email'] != "")
				$xp = " OR user_ip_email='{$x7p->profile['email']}'";
		
		/* Divide the IP address up so we can test it seperatly for sections */
		$ip_addr = explode(".",$_SERVER['REMOTE_ADDR']);
		$ip[0] = $ip_addr[0].".".$ip_addr[1].".".$ip_addr[2].".".$ip_addr[3];
		$ip[1] = $ip_addr[0].".".$ip_addr[1].".".$ip_addr[2].".*";
		$ip[2] = $ip_addr[0].".".$ip_addr[1].".*.*";
		$ip[3] = $ip_addr[0].".*.*.*";
		
		$query = $db->DoQuery("SELECT * FROM {$prefix}banned WHERE user_ip_email='$ip[0]' OR user_ip_email='$ip[1]' OR user_ip_email='$ip[2]' OR user_ip_email='$ip[3]'{$xu}{$xp}");	
		
		$return = array();
		while($row = $db->Do_Fetch_row($query)){
			$return[] = $row;
		}
		return $return;
	}
	
	function new_ban($user,$length,$reason,$room){
		global $db,$prefix, $txt;
		$time = time();
		$db->DoQuery("INSERT INTO {$prefix}banned VALUES('0','$room','$user','$time','$length','$reason')");
	
		// Alert the room if this isn't a server ban and if the user isn't an IP or E-Mail
		if($room != "*" && !eregi("\.",$user)){
			$txt[512] = eregi_replace("_u","$user",$txt[512]);
			$txt[512] = eregi_replace("_r","$reason",$txt[512]);
			include_once("./lib/message.php");
			alert_room(@$_GET['room'],$txt[512]);
		}
	}
	
	function remove_ban($id,$room){
		global $db,$prefix,$txt;
		
		// Alert the room that this user has been unbanned if it isn't a server ban and isn't an IP or email
		if($room != "*"){
			$query = $db->DoQuery("SELECT user_ip_email FROM {$prefix}banned WHERE id='$id'");
			$row = $db->Do_Fetch_Row($query);
			if(!eregi("\.",$row[0])){
				$txt[513] = eregi_replace("_u","$row[0]",$txt[513]);
				include_once("./lib/message.php");
				alert_room(@$_GET['room'],$txt[513]);
			}
		}
		$db->DoQuery("DELETE FROM {$prefix}banned WHERE id='$id' AND room='$room'");
	}

?>
