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

	// Controls logging of chat rooms and private messages
	class logs {
		var $do_logging;	// If this is set to 1 then logging is done, otherwise it is not.
		var $log_file;		// This is the file to write to
		var $error;			// This holds the last occuring error
		var $log_size;		// The current size in bytes of hte log
		var $number_of_pages;	// The number of pages in the log viewer
		
		function logs($logtype,$roomuser){
			global $x7c,$x7s;
			
			$this->do_logging = 1;
			
			// See if logs directory is writeable
			if(!is_writable($x7c->settings['logs_path'])){
				$this->error = 2;
				$this->do_logging = 0;
				return 0;
			}
			
			// See whether its a room log or a PM log
			if($logtype == 1){
				// Room log
				$this->log_file = "{$x7c->settings['logs_path']}/$roomuser.log";
				
				// Make sure this file exists, if not create it
				if(!file_exists($this->log_file))
					$this->create();
					
				// Check log size to make sure it isn't over
				$this->log_size = filesize($this->log_file);
				if($this->log_size > $x7c->settings['max_log_room'] && $x7c->settings['max_log_room'] != 0){
					$this->error = 4;
					$this->do_logging = 0;
					return 0;
				}
				
			}else{
				// PM log
				$this->log_file = "{$x7c->settings['logs_path']}/$x7s->username/$roomuser.log";
				
				// If the user directory doesn't exist then create it
				if(!is_dir("{$x7c->settings['logs_path']}/$x7s->username/")){
					if(!mkdir("{$x7c->settings['logs_path']}/$x7s->username/")){
						$this->error = 3;
						$this->do_logging = 0;
						return 0;
					}
				}
				
				// Check logs size to make sure it isn't over
				$this->log_size = 0;
				$dir = dir("{$x7c->settings['logs_path']}/$x7s->username");
				while($file = $dir->read()){
					if($file != "." && $file != "..")
						$this->log_size += filesize("{$x7c->settings['logs_path']}/$x7s->username/$file");
				}
	
				if($this->log_size > $x7c->settings['max_log_user'] && $x7c->settings['max_log_user'] != 0){
					$this->error = 4;
					$this->do_logging = 0;
					return 0;
				}
				
			}
			
		
			return 1;
		}
		
		// Obviously, add to a log
		function add($user,$text){
			
			if($this->do_logging == 1){
				// Prepare the message (remove \')
				$text = eregi_replace("\\\\'","'",$text);
				$time = time();
				$fh = fopen($this->log_file,"a");
				flock($fh,2);
				fwrite($fh,"$time;[$user]$text\n");
				flock($fh,3);
				fclose($fh);
			}
			
		}
		
		// Creates a log file
		function create(){
			$fh = fopen($this->log_file,"a");
			fclose($fh);
		}
		
		// Clears a log
		function clear($logfile=""){
			// See if they want to use default log file to clear
			if($logfile == "")
				$logfile = $this->log_file;
				
			unlink($logfile);
			
			if($this->log_file == $logfile){
				$this->create();
			}
			
		}
		
		// Returns the raw contents of a log file, an array with each line in it's own element
		function get_log_contents($logfile=""){
			if($logfile == "")
				$logfile = $this->log_file;
			
			// See if a start page is set
			if(!isset($_GET['start_page']))
				$_GET['start_page'] = 1;
			if(!isset($_GET['number_of_entries']))
				$_GET['number_of_entries'] = 5;
		
			if(!isset($_GET['view_all']))
				$data = array_chunk(file($logfile),$_GET['number_of_entries']);
			else
				$data = file($logfile);
			
			$this->number_of_pages = count($data);
				
			if(count($data) > 0)
				return $data[$_GET['start_page']-1];
			else
				return array();
		}
		
		// Returns an array containing a list of logs that a user has
		function get_pm_loglist(){
			global $x7c,$x7s;
			
			$return = array();
			
			$dir = dir("{$x7c->settings['logs_path']}/$x7s->username");
			while($file = $dir->read()){
				if($file != "." && $file != ".."){
					$return[] = eregi_replace("\.log$","",$file);
				}
			}
			
			return $return;
		}
	
	}
	
?> 
