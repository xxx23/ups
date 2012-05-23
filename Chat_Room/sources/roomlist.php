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

	// Handles the room list page
	function room_list_page(){
		global $print, $txt, $x7c, $x7s;

		// Include the needed library
		include("./lib/rooms.php");

		// Get the array we need that contains the rooms
		// Returns a multi-dimentional array.  Each room has it's
		// own element and each room element has index 0 which is name
		// and index 1 which is topic
		$rooms = list_rooms();
		$color = "dark";
		$body = "
				<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"col_header\">
					<tr>
						<td width=\"160\" height=\"25\">&nbsp;$txt[31]</td>
						<td width=\"190\" height=\"25\">&nbsp;$txt[32]</td>
						<td width=\"50\" height=\"25\">&nbsp;$txt[30]</td>
					</tr>
				</table>
				<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"inside_table\">

		";

		// Remove old records
		include_once("./lib/online.php");
		clean_old_data();

		foreach($rooms as $temp=>$room_info){

			// Make sure topic isn't to long
			if(strlen($room_info[1]) > 28)
				$room_info[1] = substr($room_info[1],0,26)."...";

			// Now do the same for the room name
			$link_url = $room_info[0];

			if(strlen($room_info[0]) > 17)
				$room_info[0] = substr($room_info[0],0,15)."...";

			// Get the online count
			$online_count = get_online(make_sql_safe($link_url));
			if(is_array($online_count))
				$online_count = count($online_count);
			else
				$online_count = 0;

			// Print lock picture if this room is locked
			if($room_info[2] != "")
				$lock = "&nbsp;<img src=\"$print->image_path/key.gif\">";
			else
				$lock = "";

			if($online_count != $room_info[3] || isset($_GET['showall']))
			// Put it into the $body variable
			  //changed
			  $encode_roomname = urlencode($link_url); 
			$body .= "
			  <tr>
			  <td width=\"160\" height=\"20\" class=\"dark_row\">&nbsp;<a title=\"$link_url\" href=\"index.php?act=frame&room=$encode_roomname\">$room_info[0]</a>$lock</td>
			  <td width=\"190\" height=\"20\" class=\"dark_row\">&nbsp;$room_info[1]</td>
			  <td width=\"50\" height=\"20\" class=\"dark_row\" style=\"text-align: center\">&nbsp;$online_count/$room_info[3]</td>
			  </tr>
			  ";
		}

		if(!isset($_GET['showall']))
		// If full rooms are not being show give them a link to show them
		$body .= "</table><div align=\"center\"><Br>$txt[81] -- <a href=\"index.php?showall=1\">$txt[82]</a><Br>";
		else
		// If full rooms are being show give them a link to hide them
		$body .= "</table><div align=\"center\"><Br>$txt[83] -- <a href=\"index.php\">$txt[84]</a><Br>";

		// Box to join a private room
		$body .= "<br>
			<form action=\"./index.php?act=join_room\" method=\"post\">
				$txt[388]: <input type=\"text\" class=\"text_input\" name=\"rname\">
				<input type=\"submit\" value=\"$txt[389]\" class=\"button\">
			</form>";

		// Tell them when rooms automatically expire
		$expire = ($x7c->settings['expire_rooms']/60)." ".$txt[228];
		if($expire == 0)
			$expire = $txt[265];
		$txt[264] = eregi_replace("_t",$expire,$txt[264]);
		$thelp = $print->help_button("room_expire");
		$body .= "<Br><div align=\"center\">$txt[264] $thelp</div><Br>";


		if($x7c->permissions['make_room'] == 1)
			$body .= "<a href=\"index.php?act=newroom1\">[$txt[59]]</a> &nbsp;";

		$body .= "<a href=\"./index.php?act=userpanel\">[$txt[35]]</a> &nbsp;";

		if($x7c->permissions['admin_access'] == 1)
			$body .= "<a href=\"./index.php?act=adminpanel\">[$txt[37]]</a> &nbsp;";

		$body .= "<a href=\"index.php?act=memberlist\">[$txt[561]]</a> &nbsp;";
		$body .= "<a href=\"index.php?act=calendar\">[$txt[315]]</a> &nbsp;";
		$body .= "<a href=\"index.php?act=logout\">[$txt[16]]</a> &nbsp;";
		$body .= "<a href=\"./help/\" target=\"_blank\">[$txt[34]]</a><Br>";

		$supporters= explode(";",$x7c->settings['support_personel']);
		if(in_array($x7s->username,$supporters))
			// Give them a support center link
			$body .= "<a href=\"index.php?act=support_sit\">[$txt[599]]</a> &nbsp;";

		$body .= "</div>";
		// User agreement
		if($x7c->settings['user_agreement'] != ""){
			$txt[516] = eregi_replace("<a>","<a href=\"#\" onClick=\"window.open('index.php?act=user_agreement','','location=no,menubar=no,resizable=yes,statusbar=no,toolbar=no,scrollbars=yes,width={$x7c->settings['tweak_window_large_width']},height={$x7c->settings['tweak_window_large_height']}');\">",$txt[516]);
			$body .= "<div align=\"center\"><Br><Br><font size=\"1\"><b>$txt[516]</b></font></div>";
		}
		// Output this into a nice window
		$print->normal_window($txt[29],$body);
	}

	// This function checks to see if a room with that name exists and if it does then it allows you to join it
	function join_other_room(){
		global $db, $prefix, $txt, $print;

		// See if hte room exists
		$query = $db->DoQuery("SELECT * FROM {$prefix}rooms WHERE name='$_POST[rname]'");
		$row = $db->Do_Fetch_Row($query);

		if($row == ""){
			// Tell them they are stupid and that room doesn't exist
			$body = "<div align=\"center\">$txt[386]<Br><Br><a href=\"./index.php\">$txt[77]</a></div>";
		}else{
			// Give them a link to join that room
			$txt[387] = eregi_replace("<a>","<a href=\"index.php?act=frame&room=$_POST[rname]\">",$txt[387]);
			$body = $txt[387];
		}


		$print->normal_window($txt[29],$body);
	}

?>
