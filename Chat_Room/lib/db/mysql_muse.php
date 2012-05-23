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

	// This class handles database communication
	class x7chat_db {
		var $con;	// MySql resource
		var $database;	// MySql database resource
		var $error;	// Stores error message (used for install file and debugging)
		
		// This function handles running a query
		function DoQuery($query){
			global $_COOKIE, $MUSE_DB;
			
			$q = mysql_query($query,$this->con);	// Run the query
			if(mysql_error() == ""){	// If MySql doesn't sends back an error then
				return $q;		// return resource ID
			}else{
				if(eregi("max_questions",mysql_error())){			
					// Switch users, this ones done with for an hour
					$MUSE_DB['current']++;
					if(!isset($MUSE_DB["user_{$MUSE_DB['current']}"])){
						// O damn we're out of users, error out
						echo "MUSE Error - Out of Users!";
						exit;
					}
					$this->x7chat_db();
					return $this->DoQuery($query);
				}else{
					return mysql_error();	// otherwise return the error
				}
			}	
		}

		// Get a row from the database
		function Do_Fetch_Row($q){
			$row = mysql_fetch_row($q);	// Get the row
			return $row;				// Return it
		}
		
		// Make the database connection and select the correct database
		function x7chat_db($host="",$uname="",$pword="",$db="",$die=1){
			global $X7CHAT_CONFIG, $MUSE_DB;		// Get the values from the config file
			if($host == ""){
				$host = $X7CHAT_CONFIG['DB_HOST'];
				$uname = $MUSE_DB["user_{$MUSE_DB['current']}"];
				$pword = $MUSE_DB["pass_{$MUSE_DB['current']}"];
				$db = $X7CHAT_CONFIG['DB_NAME'];
			}
			
			$this->error = 0;
			
			if($X7CHAT_CONFIG['USE_PCONNECT'] == 1){
				$this->con = @mysql_pconnect($host,$uname,$pword);
			}else{
				$this->con = @mysql_connect($host,$uname,$pword);
			}
			
			
			$this->database = @mysql_select_db($db,$this->con);		// Select the database
			if(!$this->con){
				if($die){
				die("Error connecting to database");		// If it fails print an error and exit
				}else{
					$this->error = 2;
					return;
				}
			}
			if(!$this->database){
				if($die){
					die("Error selecting database");		// If it fails print an error and exit
				}else{
					$this->error = 3;
					return;
				}
			}
		}
		
	}
?>
