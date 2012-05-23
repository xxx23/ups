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
	// This class handles filters
	class filters {
		var $filter_array;	// each element holds an array, index 0 is text and index 1 is replacement

		// This reloads the loaded filters
		function reload(){
			$this->filter_array = array();
			$this->filters();
		}

		function filters($room=""){
			// Load the filters for the room, the server, and the user
			global $x7s, $x7c, $db, $prefix;

			$this->filter_array = array();

			// If a room name is passed then save it
			if($room != "")
				$this->room_name = $room;

			// If a room was originally passed then laod it
			if(isset($this->room_name))
				$room = $this->room_name;

			// Load the user's bad word filter
			$query = $db->DoQuery("SELECT text,replacement,type,id FROM {$prefix}filter WHERE room='$x7s->username' AND type='5'");
			while($row = $db->Do_Fetch_Row($query)){
				$row[0] = preg_quote($row[0],"/");
				$this->filter_array[] = array("0"=>$row[0],"1"=>$row[1],"2"=>$row[2],"3"=>$row[3]);
			}

			if(!empty($room)){
				// Load the room's bad word filter
				$query = $db->DoQuery("SELECT text,replacement,type,id FROM {$prefix}filter WHERE room='$room' AND type='4'");
				while($row = $db->Do_Fetch_Row($query)){
					$row[0] = preg_quote($row[0],"/");
					$this->filter_array[] = array("0"=>$row[0],"1"=>$row[1],"2"=>$row[2],"3"=>$row[3]);
				}
			}

			// Load the server's bad word filter
			$query = $db->DoQuery("SELECT text,replacement,type,id FROM {$prefix}filter WHERE type='1'");
			while($row = $db->Do_Fetch_Row($query)){
				$row[0] = preg_quote($row[0],"/");
				$this->filter_array[] = array("0"=>$row[0],"1"=>$row[1],"2"=>$row[2],"3"=>$row[3]);
			}

			// Load the smilie filter if the admin has enabled it
			if($x7c->settings['disable_smiles'] != 1){
				$query = $db->DoQuery("SELECT text,replacement,type,id FROM {$prefix}filter WHERE type='2' ORDER BY text DESC");
				while($row = $db->Do_Fetch_Row($query)){
					$row[0] = preg_quote($row[0],"/");
					$this->filter_array[] = array("0"=>$row[0],"1"=>$row[1],"2"=>$row[2],"3"=>$row[3]);
				}
			}

			// Load the keyword filter
				$query = $db->DoQuery("SELECT text,replacement,type,id FROM {$prefix}filter WHERE type='3'");
				while($row = $db->Do_Fetch_Row($query)){
					$row[0] = preg_quote($row[0],"/");
					$this->filter_array[] = array("0"=>$row[0],"1"=>$row[1],"2"=>$row[2],"3"=>$row[3]);
				}

			// Ok, all filters have been loaded
		}

		function filter_text($text){
			foreach($this->filter_array as $noneed=>$filter){
				// Do the replacement
				$text = preg_replace("/$filter[0]/i","$filter[1]",$text);
			}

			return $text;
		}

		// This returns the javascript necessary for filtering messages on the client side
		function filter_javascript(){
			global $x7c;

			$script = "";

			if($x7c->settings['disable_autolinking'] != 1){
				// Replace web addresses and EMail addresses with links
				$script .= "message = message.replace(/www\./gi,\"http://www.\");\r\n";
				$script .= "message = message.replace(/http:\/\/http:\/\//gi,\"http://\");\r\n";
				$script .= "message = message.replace(/http:\/\/([^ ]*)([ ]*)/gi,\"<a href=\\\"http://$1\\\" target=\\\"_blank\\\">http://$1</a>$2\");\r\n";
				$script .= "message = message.replace(/https:\/\/([^ ]*)([ ]*)/gi,\"<a href=\\\"https://$1\\\" target=\\\"_blank\\\">https://$1</a>$2\");\r\n";
				$script .= "message = message.replace(/(\w*@.+\.[^ ]+)/gi,\"<a href=\\\"mailto: $1\\\">$1</a>\");\r\n";
			}

			$script .= "message = message.replace(/\\\\n/gi,\"<br>\");\r\n";

			foreach($this->filter_array as $noneed=>$filter){
				// Add it to the output
				$filter[1] = preg_replace("/\"/i","\\\"",$filter[1]);
				$script .= "message = message.replace(/$filter[0]/gi,\"$filter[1]\");\r\n";
			}

			return $script;
		}

		// This returns all of a certain type of filter
		function get_filter_by_type($type){
			$return = array();
			foreach($this->filter_array as $noneed=>$filter){
				// Add it to the output if it's the correct type
				if($filter[2] == $type){
					$filter[1] = eregi_replace("\\\\\"","",$filter[1]);
					$return[] = $filter;
				}
			}
			return $return;
		}

		// Creates a new filter
		function add_filter($type,$org,$rep){
			global $prefix, $db, $x7s;

			if(empty($org) || empty($rep)) return;

			// This handles user-set bad word filters
			if($type == 5){
				$db->DoQuery("INSERT INTO {$prefix}filter VALUES('0','$x7s->username','5','$org','$rep')");
			// This type is a room set bad word filter
			}elseif($type == 4){
				$db->DoQuery("INSERT INTO {$prefix}filter VALUES('0','$_GET[room]','4','$org','$rep')");
			// This handles server filtered words, smilies and server keywords
			}else{
				$db->DoQuery("INSERT INTO {$prefix}filter VALUES('0','','$type','$org','$rep')");
			}

		}

		// Removes a user filter
		function remove_user_filter($fid){
			global $db, $prefix, $x7s;
			$db->DoQuery("DELETE FROM {$prefix}filter WHERE type='5' AND text='$fid' AND room='$x7s->username'");
		}

		// Removes a room filter
		function remove_room_filter($fid){
			global $db, $prefix, $x7s;
			$db->DoQuery("DELETE FROM {$prefix}filter WHERE type='4' AND text='$fid' AND room='$_GET[room]'");
		}

		// Removes a server filter
		function remove_server_filter($fid){
			global $db, $prefix, $x7s;
			$db->DoQuery("DELETE FROM {$prefix}filter WHERE type='1' AND text='$fid'");
		}

		// Removes a smiley
		function remove_smiley($fid){
			global $db, $prefix, $x7s;
			$db->DoQuery("DELETE FROM {$prefix}filter WHERE type='2' AND id='$fid'");
		}

		// Removes a server keyword
		function remove_server_keyword($fid){
			global $db, $prefix, $x7s;
			$db->DoQuery("DELETE FROM {$prefix}filter WHERE type='3' AND text='$fid'");
		}

	}
?>
