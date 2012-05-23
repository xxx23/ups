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

	function calendar(){
		global $x7c,$print,$txt;	
	
		include("./lib/events.php");
			
		$body = cal_threedays()."<Br><br>";
		
		$body .= cal_minimonth();
	
		$body .= "<Br><Br><div align=\"center\"><a href=\"index.php\">[$txt[77]]</div>";
		
		$print->normal_window($txt[315],$body);
	}

?> 
