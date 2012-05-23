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
	// For now this simply contains some duplicates of functions found in 
	// xupdater.php and uploads.php, my hope is that in the future it will
	// be consolidated into this file only to help clean out the other two
	
	// Upload a new file
	function upload_file($incoming,$filename=""){
		global $x7c;
		
		// Moves uploaded file into the uploads directory
		move_uploaded_file($_FILES[$incoming]['tmp_name'],"{$x7c->settings['uploads_path']}/$filename");
		
	}
	
	// Unzip a file / directory
	function unzip_file($file_name){
		if(!mkdir("./uploads/temp"))
			return 0;

		$shell = exec("unzip ./uploads/$file_name -d ./uploads/temp");
		if(!eregi("inflating",$shell)){
			// Unzipping the file failed
			return 0;
		}else{
			// Ok to continue
			return 1;
		}
	}
	
	// Remove a directory
	function remove_file($dirx){
		// This code seems pretty damn ineffective to me, maybe there is a better way..
		$dir = dir($dirx);
		while($file = $dir->read()){
			if($file != "." && $file != ".."){
				if(is_dir("$dirx/$file"))
					remove_file("$dirx/$file");
				else
					unlink("$dirx/$file");
			}
		}
		
		rmdir($dirx);
	}
?>
