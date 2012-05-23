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
	// Returns an multi-dimentional Array.  It is indexed by article number
	// which doesn't matter, and then each element contains an array indexed
	// by strings which contain the actual information.
	function get_news(){
		$news = @file("http://x7chat.com/rss/x7cu.rss");
		$news = @implode("",$news);
		$news = preg_split("/<news>/",$news);
		@array_shift($news);
		$newsnum = 0;
		$return = array();
		$i = 0;
		foreach($news as $Key=>$val){
			$i++;
			$val = eregi_replace("_;","&#59",$val);
			$val = explode(";",$val);
			$return[$newsnum]['title'] = $val[0];
			$return[$newsnum]['author'] = $val[1];
			$return[$newsnum]['date'] = $val[2];
			$return[$newsnum]['icon'] = $val[3];
			$return[$newsnum]['body'] = $val[4];
			if($i > 2)
				break;
			$newsnum++;
		}
		if(count($return) == 0)
			$return = "nonews";
		
		return $return;
	}
	
	// The job of this function is to get information on the style mods current available
	// Will return:
	//	an array if sucessful
	//	2 is the mods directory is unwriteable
	function get_uploaded_themes(){
		
		if(!is_writable("./mods"))
			return 2;
		$mods_dir = dir("./mods");
		$return = array();
		$i = 0;
		
		// Pre-Cleanup and prep
		@unlink("./mods/temp/theme.info");
		@mkdir("./mods/temp");
		
		while($file = $mods_dir->read()){
			// Make sure this is an x7cs (x7 chat style) file
			if(eregi("^x7cs_([A-Za-z0-9_]*).zip",$file,$match)){
				$return[$i]['file'] = $match[0];
				
				$shell = exec("unzip ./mods/$match[0] theme.info -d ./mods/temp");
				if(!eregi("inflating",$shell)){
					// Unzipping the file failed or else it isn't a valid theme file
					unset($return[$i]);
				}else{
					// Ok to continue
					// Get the data from the unzipped info file
					include("./mods/temp/theme.info");
					
					$return[$i]['author'] = $author;
					$return[$i]['date'] = $date;
					$return[$i]['name'] = $name;
					$return[$i]['desc'] = $description;
					$return[$i]['version'] = $version;
					$return[$i]['copyright'] = $copyright;
					$return[$i]['website'] = $website;
					
					// Cleanup
					unlink("./mods/temp/theme.info");
				}
			}
		}
		
		// Post clenaup
		@rmdir("./mods/temp");
		
		// Return
		return $return;
	}
	
	// This function will install a theme
	//	Will return the following errors if something goes wrong, otherwise will return 1
	//		0: Themes directory needs CHMODed
	//
	function install_theme($theme){
	
		if(!is_writeable("./themes"))
			return 0;
			
		// If the theme already has the start and end on it then remove though
		$theme = eregi_replace("^x7cs_","",$theme);
		$theme = eregi_replace("\.zip$","",$theme);
			
		// Unzip the theme
		$shell = exec("unzip -o ./mods/x7cs_$theme.zip -d ./themes/$theme");
		
		return 1;
	}
	
	// Auto-Modder functions for modding
	function mod_replace($file,$original,$new){
		global $fail;
		
		// Make sure file is writeable
		if(!is_writeable($file)){
			// damn it, they didn't chmod the file like we told them to
			$fail = 1;
			return 0;
		}
		
		// Open the file for writing
		$data = file($file);
		$data = implode("",$data);
		$data = eregi_replace("\r\n","\n",$data);
		$original = preg_quote($original);
		if(!$data = eregi_replace("$original","$new",$data)){
			$fail = 2;
			return 0;
		}
		$fh = fopen($file,"w");
		fwrite($fh,$data);
		fclose($fh);
		return 1;
	}
	
	function mod_remove($file,$text){
		mod_replace($file,$text,"");
	}
	
	function mod_add_after($file,$text,$add){
		mod_replace($file,$text,"$text\n$add");
	}
	
	function mod_add_before($file,$text,$add){
		mod_replace($file,$text,"$add\n$text");
	}
	
	// This function checks for uploaded mods, it assumes that it has
	// write access to the mdos directoy
	function get_uploaded_mods(){
		
		// Setup
		@mkdir("./mods/temp");
		$mods_dir = dir("./mods");
		$i = 0;
		$return = array();
		
		// Check the files in the dir for x7 chat mod files
		while($file = $mods_dir->read()){
			// Make sure this is an x7cs (x7 chat style) file
			if(eregi("^x7cm_([A-Za-z0-9_]*).zip",$file,$match)){
				$return[$i]['file'] = $match[0];
				
				$shell = exec("unzip ./mods/$match[0] mod.info -d ./mods/temp");
				if(!eregi("inflating",$shell)){
					// Unzipping the file failed or else it isn't a valid theme file
					unset($return[$i]);
				}else{
					// Ok to continue
					// Get the data from the unzipped info file
					include("./mods/temp/mod.info");
					
					$return[$i]['author'] = $author;
					$return[$i]['date'] = $date;
					$return[$i]['name'] = $name;
					$return[$i]['desc'] = $description;
					$return[$i]['version'] = $version;
					$return[$i]['copyright'] = $copyright;
					$return[$i]['website'] = $website;
					
					$i++;
					
					// Cleanup
					@unlink("./mods/temp/mod.info");
				}
			}
		}
	
		// Cleanup
		@rmdir("./mods/temp");
		
		return $return;
	}
	
	// Opens up a package
	function open_package($package){
		@mkdir("./mods/temp");

		$shell = exec("unzip ./mods/$package -d ./mods/temp");
		if(!eregi("inflating",$shell)){
			// Unzipping the file failed or else it isn't a valid theme file
			return 0;
		}else{
			// Ok to continue
			return 1;
		}
		
	}
	
	// Closes a package
	function close_package($dirx){
		$dir = dir($dirx);
		while($file = $dir->read()){
			if($file != "." && $file != ".."){
				if(is_dir("$dirx/$file"))
					close_package("$dirx/$file");
				else
					unlink("$dirx/$file");
			}
		}
		
		rmdir($dirx);
	}
	
?> 
