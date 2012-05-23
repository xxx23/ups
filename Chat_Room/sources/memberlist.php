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

	// This function displays a list of all members
	function memberlist(){
		global $db, $prefix, $txt, $print, $x7c;
		
		// See if the user wants the data sorted in anyway
		$order = "";
		$sort_order_1 = 1;
		$sort_order_2 = 3;
		if(isset($_GET['sort'])){
			if($_GET['sort'] == "1"){
				$order = " ORDER BY username ASC";
				$sort_order_1 = 2;
			}elseif($_GET['sort'] == "2"){
				$order = " ORDER BY username DESC";
			}elseif($_GET['sort'] == "3"){
				$order = " ORDER BY user_group ASC";
				$sort_order_2 = 4;
			}elseif($_GET['sort'] == "4"){
				$order = " ORDER BY user_group DESC";
			}
		}
		
		// Get the userlist and online data
		$query = $db->DoQuery("SELECT username,user_group FROM {$prefix}users{$order}");
		$query2 = $db->DoQuery("SELECT name,room,invisible FROM {$prefix}online");
		
		$online = array();
		while($row = $db->Do_Fetch_Row($query2)){
			if($row[2] != 1)
				$online[$row[0]][] = $row[1];
		}
		
		$body = "<div align=\"center\">
		<a href=\"index.php\">[$txt[77]]</div><Br>
		<table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\" class=\"col_header\">
			<tr>
				<td width=\"100\" height=\"25\">&nbsp;<a href=\"index.php?act=memberlist&sort={$sort_order_1}\">$txt[2]</a></td>
				<td width=\"100\" height=\"25\"><a href=\"index.php?act=memberlist&sort={$sort_order_2}\">$txt[123]</a></td>
				<td width=\"100\" height=\"25\">$txt[560]</td>
			</tr>
		</table>
		<table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\" class=\"inside_table\">";
		
		while($row = $db->Do_Fetch_Row($query)){
			
			// Link up the rooms they are currently in
			$rooms = "";
			if(isset($online[$row[0]])){
				foreach($online[$row[0]] as $key=>$val){
					$rooms .= "<a href=\"#\" onClick=\"window.open('index.php?act=frame&room=$val','','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width={$x7c->settings['tweak_window_large_width']},height={$x7c->settings['tweak_window_large_height']}');\">$val</a>, ";
				}
				$rooms = substr($rooms,0,strlen($rooms)-2);
			}
		
			// Output this entry
			$body .= "<tr>
						<td width=\"100\" class=\"dark_row\"><a href=\"index.php?act=view_profile&user=$row[0]\">$row[0]</a></td>
						<td width=\"100\" class=\"dark_row\">$row[1]</td>
						<td width=\"100\" class=\"dark_row\">{$rooms}</td>
					<tr>";
			
		}
		
		$body .= "</table></div>";

		$print->normal_window($txt[561],$body);
	}

?> 
