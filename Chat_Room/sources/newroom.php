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
	// This file controls creation of new rooms
	
	// Print for the form that needs filled out to create a room
	function newroom_form(){
		global $txt, $print, $x7c;
		
		// Make sure they have permission to make a new room
		if($x7c->permissions['make_room'] != 1){
			$print->normal_window($txt[14],$txt[60]);
			return 0;
		}
		
		// Print the form
				$body = "	<form action=\"index.php?act=newroom2\" method=\"post\" name=\"newroomform\">
							<table border=\"0\" width=\"400\" cellspacing=\"5\" cellpadding=\"0\">
								<tr valign=\"top\">
									<td width=\"400\" style=\"text-align: center\" colspan=\"4\">$txt[62]<Br><Br></td>
								</tr>
						";
						
				// The Room Name Field
				$body .= "		<tr valign=\"top\">
									<td width=\"70\">&nbsp;</td>
									<td width=\"80\" style=\"vertical-align: middle;\">$txt[61]: </td>
									<td width=\"175\" ><input type=\"text\" class=\"text_input\" name=\"roomname\"></td>
									<td width=\"70\">&nbsp;</td>
								</tr>
						";
						
				// The Room Topic Field
				$body .= "		<tr valign=\"top\">
									<td width=\"70\">&nbsp;</td>
									<td width=\"80\" style=\"vertical-align: middle;\">$txt[65]: </td>
									<td width=\"175\" ><input type=\"text\" class=\"text_input\" name=\"roomtopic\"></td>
									<td width=\"70\">&nbsp;</td>
								</tr>
						";
						
				// The Room Greeting Field
				$body .= "		<tr valign=\"top\">
									<td width=\"70\">&nbsp;</td>
									<td width=\"80\" style=\"vertical-align: middle;\">$txt[66]: "; $body .= $print->help_button("room_greeting"); $body .= "</td>
									<td width=\"175\" ><input type=\"text\" class=\"text_input\" name=\"roomgreeting\"></td>
									<td width=\"70\">&nbsp;</td>
								</tr>
						";
						
				// The Room Password Field
				$body .= "		<tr valign=\"top\">
									<td width=\"70\">&nbsp;</td>
									<td width=\"80\" style=\"vertical-align: middle;\">$txt[3]: </td>
									<td width=\"175\" ><input type=\"text\" class=\"text_input\" name=\"roompass\"></td>
									<td width=\"70\">&nbsp;</td>
								</tr>
						";
						
				// The Room Max users Field
				$body .= "		<tr valign=\"top\">
									<td width=\"70\">&nbsp;</td>
									<td width=\"80\" style=\"vertical-align: middle;\">$txt[67]: </td>
									<td width=\"175\" ><input type=\"text\" class=\"text_input\" name=\"roommax\"></td>
									<td width=\"70\">&nbsp;</td>
								</tr>
						";
							
				// The room type selector
				$type_options = "<option value=\"1\">$txt[68]</option>";
				if($x7c->permissions['make_proom'] == 1)
					$type_options .= "<option value=\"2\">$txt[69]</option>";
				
				$body .= "		<tr valign=\"top\">
									<td width=\"70\">&nbsp;</td>
									<td width=\"80\" style=\"vertical-align: middle;\">$txt[64]: </td>
									<td width=\"175\" ><select class=\"text_input\" name=\"roomtype\" style=\"width:100px;\">$type_options</select></td>
									<td width=\"70\">&nbsp;</td>
								</tr>
						";
						
				// Permission check and if enabled print moderated toggle
				if($x7c->permissions['make_mod'] == 1)
					$body .= "		<tr valign=\"top\">
										<td width=\"70\">&nbsp;</td>
										<td width=\"80\" style=\"vertical-align: middle;\">$txt[70]: </td>
										<td width=\"175\" ><input type=\"checkbox\" name=\"roommod\" value=\"1\"></td>
										<td width=\"70\">&nbsp;</td>
									</tr>
							";
							
				// Permission check and if enabled print never expire toggle
				if($x7c->permissions['make_nexp'] == 1)
					$body .= "		<tr valign=\"top\">
										<td width=\"70\">&nbsp;</td>
										<td width=\"80\" style=\"vertical-align: middle;\">$txt[71]: </td>
										<td width=\"175\" ><input type=\"checkbox\" name=\"roomnexp\" value=\"1\"></td>
										<td width=\"70\">&nbsp;</td>
									</tr>
							";
						
				// The submit button and form close
				$body .= "		<tr valign=\"top\">
									<td width=\"400\" style=\"text-align: center\" colspan=\"4\">&nbsp;</td>
								</tr>
								<tr valign=\"top\">
									<td width=\"400\" style=\"text-align: center\" colspan=\"4\"><input type=\"submit\" value=\"$txt[63]\" class=\"button\"></td>
								</tr>
							</table>
							</form>
							<div align=\"center\"><a href=\"./index.php\">[$txt[29]]</a></div>
						";
		
		$print->normal_window($txt[59],$body);
	
	}
	
	// This comment was made at 1:52 PM on July 4th 2004.  United States of America RULEZ!
	
	function newroom_creation(){
		global $txt, $print, $x7c, $db, $prefix, $x7p;
		
		$error = "";
		
		// Make sure all values were filled out and check for errors in it
		if($_POST['roomname'] == "" || eregi("\.|'|,|;|\*",$_POST['roomname']))
			$error = $txt[72];
			
		$query = $db->DoQuery("SELECT name FROM {$prefix}rooms WHERE name='$_POST[roomname]'");
		$row = $db->Do_Fetch_Row($query);
		if($row[0] != "")
			$error = $txt[76];
			
		if($_POST['roommax'] == "" || $_POST['roommax'] < 3)
			$_POST['roommax'] = "3";
		
		if($_POST['roomtype'] != "1" && $_POST['roomtype'] != "2")
			$error = $txt[73];
			
		if($_POST['roomtype'] == "2" && $x7c->permissions['make_proom'] != 1)
			$error = $txt[74];
		
		if($x7c->permissions['make_mod'] != 1 || !isset($_POST['roommod']))
			$_POST['roommod'] = 0;
			
		if($x7c->permissions['make_nexp'] != 1 || !isset($_POST['roomnexp']))
			$_POST['roomnexp'] = 0;
			
		if($error == ""){
			$body = $txt[75]."<Br><Br><a href=\"./index.php\">[$txt[29]]</a>";
			// Crate the room
			create_room($x7p->profile['id'],$_POST['roomname'],$_POST['roomtype'],$_POST['roommod'],$_POST['roomtopic'],$_POST['roomgreeting'],$_POST['roompass'],$_POST['roommax'],$_POST['roomnexp']);
		}else{
			$body = $error."<Br><Br><a href=\"index.php?act=newroom1\">[$txt[77]]</a>";
		}
		
		$print->normal_window($txt[59],$body);
	}
	
?> 
