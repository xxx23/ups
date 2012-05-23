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
	// These functions handle help popups and the smilie box and other similar popup dialog boxes
	function mini_page(){
		global $print, $txt, $x7c, $db, $prefix;
		if($_GET['page'] == "smile"){
			// Print the smilies
			include("./lib/filter.php");
			$body = "";
			$smile = new filters("");
			$smilies = $smile->get_filter_by_type("2");
			foreach($smilies as $noneed=>$filter){
				$filter[0] = stripslashes($filter[0]);
				$filter[0] = eregi_replace("\\\\","\\\\",$filter[0]);
				$body .= "<a onClick=\"javascript: opener.document.chatIn.msgi.value = opener.document.chatIn.msgi.value+'$filter[0]';\">$filter[1]</a> ";
			}
			
		}elseif($_GET['page'] == "fonts"){
		
			// Print the available fonts
			$body = "$txt[57]<Br><Br>";
			$allowed_fonts = explode(",",$x7c->settings['style_allowed_fonts']);
			foreach($allowed_fonts as $noneed=>$fontname){
				$fontname = trim($fontname);
				$body .= "<a href=\"#1\" onClick=\"javascript: opener.document.chatIn.curfont.value = '$fontname';opener.document.getElementById('curfontd').innerHTML = '$fontname';\">$fontname</a><Br>";
			}
			
		}elseif($_GET['page'] == "colors"){
			
			// Print the color table for users to pick from
			include("./lib/color_picker.php");
			$body = color_form();
			
		}elseif($_GET['page'] == "colors2"){
			
			// If the user is using the GD library for colors then
			// a second page (this one) is required to update the settings.
			include("./lib/color_picker.php");
			$body = color_update();
			
		}elseif($_GET['page'] == "event"){
		
			$body = "";
			$mini = $_GET['day'];
			$maxi = $_GET['day']+86400;
			$query = $db->DoQuery("SELECT * FROM {$prefix}events WHERE timestamp>'$mini' AND timestamp<'$maxi'");
			while($row = $db->Do_Fetch_Row($query)){
				$body .= "<B>".date($x7c->settings['date_format_full'],$row[1]).": </b>$row[2]<Br><Br>";
			}
			
		}elseif($_GET['page'] == "invis"){
			// If they are allowed to set themselfs to invisible them do it
			if($x7c->permissions['b_invisible'] == 1){
				include_once("./lib/online.php");
				invisy_switch($_GET['room']);
				if($x7c->settings['invisible'] == 1)
					$body = $txt[509];
				else
					$body = $txt[508];
			}else{
				$body = "$txt[507]";
			}
		
		}else{
			// They sent an incorrect page so we give them an error
			$body = $txt[45];
		}
		
		// Output this to the print buffer
		$print->info_window($body);
	}
?> 
