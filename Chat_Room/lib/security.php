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
 	// This makes sure that users don't try to include naughty files via
	// the language pack selection or theme selector
 	function parse_includes($name){
		if(!eregi("^[A-z0-9]*$",$name))
			return 0;
		else
			return 1;
	}
	
	// This function converts outgoing data into something that is url safe
	function strip_outgoing($value){
		return urlencode($value);
	}
	
	function parse_incoming(){
		global $_POST, $_GET, $_COOKIE;
		// Make POST variables clean
		foreach($_POST as $name=>$value){
			$value = urldecode($value);
			if(get_magic_quotes_gpc() == 0)
				$value = addslashes($value);
				
			//$value = htmlspecialchars($value);
			$value = preg_replace("/</i","&lt;",$value);
			$value = preg_replace("/>/i","&gt;",$value);
			$value = preg_replace("/'/i","&#039;",$value);
			$value = preg_replace("/\"/i","&quot;",$value);
			
			$_POST[$name] = $value;
		}
		
		// Mke GET variables clean
		foreach($_GET as $name=>$value){
			$value = urldecode($value);
			if(get_magic_quotes_gpc() == 0)
				$value = addslashes($value);
			$value = preg_replace("/</i","&lt;",$value);
			$value = preg_replace("/>/i","&gt;",$value);
			$value = preg_replace("/'/i","&#039;",$value);
			$value = preg_replace("/\"/i","&quot;",$value);
			$_GET[$name] = $value;
		}
				
		// Make COOKIE's clean
		foreach($_COOKIE as $name=>$value){
			$value = @urldecode($value);
			if(get_magic_quotes_gpc() == 0)
				$value = addslashes($value);
			$value = preg_replace("/</i","&lt;",$value);
			$value = preg_replace("/>/i","&gt;",$value);
			$value = preg_replace("/'/i","&#039;",$value);
			$value = preg_replace("/\"/i","&quot;",$value);
			$_COOKIE[$name] = $value;
		}
	}
	
	function parse_outgoing($data){
		$data = stripslashes($data);
		return $data;
	}
	
	function make_sql_safe($data){
		$data = eregi_replace("'","\'",$data);
		return $data;
	}	
	
	// This function converts incoming variables data into something that is safe for printing
	/*function strip($value){
		$value = urldecode($value);
		return htmlspecialchars($value);
	}
	
	// This function converts incoming variables data into something that is safe for SQL queries
	function strip_sql($value){
		$value = urldecode($value);
		$value = eregi_replace("'","\'",$value);
		return htmlspecialchars($value);
	}
	*/
 ?>
