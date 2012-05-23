<?PHP
///////////////////////////////////////////////////////////////
//
//		X7 Chat Version 2.0.5
//		Released Jan 6, 2007
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
	// Handles sessions in a way
	function return_last_time($room){
		global $db, $prefix, $x7s, $x7c;

		$query = $db->DoQuery("SELECT * FROM {$prefix}online WHERE name='$x7s->username' AND room='$room'");
		$row = $db->Do_Fetch_Row($query);
		$time = time();

		$user_online = get_online($room);
		$return[0] = array();

		$total_us = count($user_online);
		$row[4] = explode(",",$row[4]);
		$back_2_db = implode(",",$user_online);
		$return[2] = array_diff($user_online,$row[4]);
		$return[3] = array_diff($row[4],$user_online);
		$compared = $return[2]+$return[3];


		if(count($compared) > 0){
			// Update the online list
			$return[0] = $user_online;
		}

		if(@$row[0] == ""){
			// See if the room is full
			if($total_us >= $x7c->room_data['maxusers'])
				return 2;

			$ip = $_SERVER['REMOTE_ADDR'];
			$db->DoQuery("INSERT INTO {$prefix}online VALUES('0','$x7s->username','$ip','$room','','$time','{$x7c->settings['auto_inv']}')");
			return 1;
		}

		$db->DoQuery("UPDATE {$prefix}online SET time='$time',usersonline='$back_2_db' WHERE name='$x7s->username' AND room='$room'");

		// This gets set to the timestamp when the user last got messages
		$return[1] = $row[5];

		// Add the

		return $return;
	}

	function clean_old_data(){
		global $x7c, $db, $prefix, $x7s;
		// Delete old data from the online table
		$exp_time = time() - $x7c->settings['online_time'];
		$query = $db->DoQuery("DELETE FROM {$prefix}online WHERE time<'$exp_time'");
	}

	// Returns an array containing the name's of users online
	function get_online($room="*"){
		global $db, $prefix, $querydb, $x7c;
		$return = array();

		// Ah HA, invisible users
		if(@$x7c->permissions['c_invisible'] == 1)
			$invis = "";
		else
			$invis = " AND invisible<>'1' ";

		// $querydb caches queries so we don't have to run them more than once
		if(!isset($querydb['get_online_1'])){
			$querydb['get_online_1'] = array();
			$exp_time = time() - $x7c->settings['online_time'];
			$query = $db->DoQuery("SELECT DISTINCT name,room FROM {$prefix}online WHERE time>'$exp_time'{$invis}ORDER by name ASC");
			while($row = $db->Do_Fetch_Row($query)){
				$querydb['get_online_1'][$row[1]][] = $row[0];
			}
		}

		if($room == "*"){
			foreach($querydb['get_online_1'] as $roomname=>$names){
				foreach($names as $null=>$name)
					$return[] = $name;
			}
		}else{
			@$return = $querydb['get_online_1'][$room];
		}

		if(!is_array($return))
			$return = array();

		return $return;
	}

	// Magically makes you invisible/visible (inverts whatever you currently are)
	function invisy_switch($room){
		global $db, $prefix, $x7s, $x7c;

		if($x7c->settings['invisible'] == 1)
			$db->DoQuery("UPDATE {$prefix}online SET invisible='0' WHERE room='$room' AND name='$x7s->username'");
		else
			$db->DoQuery("UPDATE {$prefix}online SET invisible='1' WHERE room='$room' AND name='$x7s->username'");
	}
?>
