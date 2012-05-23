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
	// This file controls the event calender found on the login page.
	
	// Generate a three day calender (for the login screen)
	function cal_threedays(){
		global $txt, $x7c, $db, $prefix, $print;	
	
		// Cleanup old data
		cleanup_events();
		
		$today = date("m;d;Y");
		
		$this_month = date("F");
		if(isset($txt[$this_month]))
			$this_month = $txt[$this_month];
		
		$days_this_month = date("t");
		$today = explode(";",$today);
		//mktime(hour,minute,second,month,day,year);
		$days[0] = mktime(0,0,0,$today[0],$today[1],$today[2]);
		for($i = 1;$i <= $x7c->settings['events_3day_number'];$i++){
			$today[1]++;	
			if($today[1] > $days_this_month){
				if($today[0] == "12"){
					$today[0] = 1;
					$today[2]++;
				}else{
					$today[0]++;
				}
				$today[1] = 1;
			}
			
			$days[$i] = mktime(0,0,0,$today[0],$today[1],$today[2]);
		}
		
		// Get the events
		$maxi = max($days)+86400;
		$mini = min($days);
		
		if($maxi == $mini)
			$maxi = $mini+86400;
		$query = $db->DoQuery("SELECT * FROM {$prefix}events WHERE timestamp<'$maxi' AND timestamp>'$mini' ORDER BY timestamp ASC");
		while($row = $db->Do_Fetch_Row($query)){
			$event_day = date("d",$row[1]);
			$event_time = date($x7c->settings['date_format'],$row[1]);
			$events[$event_day][] = "<b>".$event_time."</b><Br>".$row[2];
		}
		
		// Calculate table width
		if($x7c->settings['events_3day_number'] == 0)
			$width = "245";
		elseif($x7c->settings['events_3day_number'] == 1)
			$width = "322";
		elseif($x7c->settings['events_3day_number'] == 2)
			$width = "400";
			
		$width_percent = round((1/($x7c->settings['events_3day_number']+1))*100)."%";
		
		$return = "$print->ss_events
			<table width=\"$width\" class=\"event_table\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\">
				<tr>
					<td colspan=\"7\" width=\"100%\" class=\"event_top\">&nbsp; $this_month</td>
				</tr>
				<tr valign=\"top\">";
		
		
		foreach($days as $key=>$val){
			$day = date("d",$val);
			
			// Do this in case the server they are on is not set to english, if the server is set to english then we want to translate from the language file
			if(isset($txt[date("l",$val)]))
				$day_name = $txt[date("l",$val)];
			else
				$day_name = date("l",$val);
				
			$return .= "<td width=\"$width_percent\" class=\"event_day\"><div class=\"event_day_name\">$day - $day_name</div>";
			
			if(isset($events[$day])){
				foreach($events[$day] as $key=>$val){
					$return .= "$val<Br><Br>";
				}
			}else{
				$return .= $txt[173];
			}
			
			$return .= "</td>";
			
		}
		
		$return .= "</tr></table>";
		
		return $return;
	}
	
	// Print a miniature full month calender
	function cal_minimonth(){
		global $db, $prefix, $x7c, $print, $txt;
		
		// Cleanup old data
		cleanup_events();
		
		// Get primary data for todays date
		$this_month_name = date("F");
		if(isset($txt[$this_month_name]))
			$this_month_name = $txt[$this_month_name];
		$days_this_month = date("t");
		$this_year = date("Y");
		$this_month = date("m");
		$current_day = 1;
		$first_day = date("w",mktime(0,0,0,$this_month,1,$this_year));
		
		$return = "$print->ss_events
		<table border=\"0\" class=\"event_table\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">
			<tr>
				<td width=\"245\" colspan=\"7\" class=\"event_top\">&nbsp; $this_month_name</td>
			</tr>
			<tr>
				<td width=\"35\" class=\"event_day_abr\">".substr($txt['Sunday'],0,1)."</td>
				<td width=\"35\" class=\"event_day_abr\">".substr($txt['Monday'],0,1)."</td>
				<td width=\"35\" class=\"event_day_abr\">".substr($txt['Tuesday'],0,1)."</td>
				<td width=\"35\" class=\"event_day_abr\">".substr($txt['Wednesday'],0,1)."</td>
				<td width=\"35\" class=\"event_day_abr\">".substr($txt['Thursday'],0,1)."</td>
				<td width=\"35\" class=\"event_day_abr\">".substr($txt['Friday'],0,1)."</td>
				<td width=\"35\" class=\"event_day_abr\">".substr($txt['Saturday'],0,1)."</td>
			</tr>
			<tr>
		";
		
		// Laod events for this month
		$mini = mktime(0,0,0,$this_month,1,$this_year);
		$maxi = mktime(24,60,60,$this_month,$days_this_month,$this_year);
		$query = $db->DoQuery("SELECT * FROM {$prefix}events WHERE timestamp<'$maxi' AND timestamp>'$mini' ORDER BY timestamp ASC");
		while($row = $db->Do_Fetch_Row($query)){
			$event_day = date("d",$row[1]);
			$event_time = date($x7c->settings['date_format'],$row[1]);
			$events[$event_day] = 1;
		}
		
		// $rc is the row counter, we can only have 7 cells in a row regardless of how many days are in the row
		$rc = 0;
		$first_set = 0;
		while($current_day <= $days_this_month){
			
			// See if the first row has been set
			if($first_set == 0){
				// See if today is the start of the week, otherwise print a blank cell
				if($rc == $first_day){
					// Today IS the first day, print the day
					$first_set = 1;
				}else{
					// Today is not the first day, print a blank row
					$return .= "<td width=\"35\" height=\"35\" class=\"event_day_no\">&nbsp;</td>";
				}
			}
			
			if($first_set == 1){
				// Ok, we are on a day :), lets see if there are any events planned for today
				$time = mktime(0,0,0,$this_month,$current_day,$this_year);
				if(isset($events[date("d",$time)])){
					// Yes!
					$return .= "<td width=\"35\" height=\"35\" class=\"event_day_yes\" onClick=\"javascript: window.open('./index.php?act=sm_window&page=event&day=$time','','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width={$x7c->settings['tweak_window_small_width']},height={$x7c->settings['tweak_window_small_height']}');\">$current_day</td>";
				}else{
					// Nope
					$return .= "<td width=\"35\" height=\"35\" class=\"event_day_no\">$current_day</td>";
				}
				$current_day++;
			}
			
			// See if we should start a new row
			$rc++;
			
			if($rc == 7){
				$return .= "</tr><tr>";
				$rc = 0;	
			}
			
		// End while loop
		}
		
		// Finish up the square with blank rows
		if($rc != 0){
			while($rc < 7){
				$return .= "<td width=\"35\" class=\"event_day_no\">&nbsp;</td>";
				$rc++;
			}
		}
		
		$return .= "</tr></table>";
		
		return $return;
	}
	
	// Add an event to the calender
	function add_event($time,$event){
		global $db, $prefix;
		$db->DoQuery("INSERT INTO {$prefix}events VALUES('0','$time','$event')");
	}
	
	// Deletes old events
	function cleanup_events(){
		global $db, $prefix, $cleanup_events_ran;
		// Delete events from the time that was last month if it hasn't been done already
		if(!isset($cleanup_events_ran)){
			$cleanup_events_ran = 1;
			$exptime = @mktime(0,0,0,date("m"),1,date("Y"))-1;
			$db->DoQuery("DELETE FROM {$prefix}events WHERE timestamp<$exptime");
		}
	}

?> 
