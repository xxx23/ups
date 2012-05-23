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
	// This file handles uploads of avatars
	//		* Returns 1 if avatar uploads are disabled
	//		* Returns 2 if avatar is to large
	//		* Returns 3 if the avatar is not an image type
	//		* Returns 4 if the avatar upload directory is not writeable
	//		* Returns URL to avatar is everythign went ok
	function handle_uploaded_avatar(){
		global $x7c, $x7s;
		
		// See if avatar uploads are enabled
		if($x7c->settings['enable_avatar_uploads'] == 1){
			
			// Make sure the directory is writeable
			if(!is_writable($x7c->settings['uploads_path']))
				return 4;
		
			// See if the file is within the correct size limitations
			if($_FILES['avatar']['size'] > $x7c->settings['avatar_max_size']){
				// To large return 2
				return 2;
			}else{
			
				// See if the file is a correct image type, either gif, png or jpg
				if($_FILES['avatar']['type'] == "image/gif"){
					remove_other_avatars();
					move_uploaded_file($_FILES['avatar']['tmp_name'],"{$x7c->settings['uploads_path']}/avatar_{$x7s->username}.gif");
					return "{$x7c->settings['uploads_url']}/avatar_{$x7s->username}.gif";
				}elseif($_FILES['avatar']['type'] == "image/png"){
					remove_other_avatars();
					move_uploaded_file($_FILES['avatar']['tmp_name'],"{$x7c->settings['uploads_path']}/avatar_{$x7s->username}.png");
					return "{$x7c->settings['uploads_url']}/avatar_{$x7s->username}.png";
				}elseif($_FILES['avatar']['type'] == "image/jpeg" || $_FILES['avatar']['type'] == "image/pjpeg"){
					remove_other_avatars();
					move_uploaded_file($_FILES['avatar']['tmp_name'],"{$x7c->settings['uploads_path']}/avatar_{$x7s->username}.jpeg");
					return "{$x7c->settings['uploads_url']}/avatar_{$x7s->username}.jpeg";
				}else{
					// Incorrect type, return 3
					return 3;
				}
			
			}
			
		}else{
			// They are not so return 1
			return 1;
		}
	
	}
	
	// This function removes a users other avatars
	function remove_other_avatars(){
		global $x7s, $x7c;
		
		// Gif ones
		if(file_exists("{$x7c->settings['uploads_path']}/avatar_{$x7s->username}.gif"))
			unlink("{$x7c->settings['uploads_path']}/avatar_{$x7s->username}.gif");
		
		// PNG ones
		if(file_exists("{$x7c->settings['uploads_path']}/avatar_{$x7s->username}.png"))
			unlink("{$x7c->settings['uploads_path']}/avatar_{$x7s->username}.png");
		
		// JPG ones
		if(file_exists("{$x7c->settings['uploads_path']}/avatar_{$x7s->username}.jpeg"))
			unlink("{$x7c->settings['uploads_path']}/avatar_{$x7s->username}.jpeg");
		
	}
	
?>
