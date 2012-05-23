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
	// Show another User's profile
	function view_profile($user){
		global $print, $x7c, $txt;
		$profile = new profile_info($user);
		
		// See if the user has hidden their E-Mail address
		if($profile->profile['hideemail'] == 1 && $x7c->permissions['view_hidden_emails'] == 1)
			$profile->profile['email'] .= " ".$txt[120];
		if($profile->profile['hideemail'] == 1 && $x7c->permissions['view_hidden_emails'] != 1)
			$profile->profile['email'] = $txt[120];
			
		// Go around PHP4's object array string bug
		$profile = $profile->profile;
		
		// Parse gender:
		// 1 = male
		// 2 = female
		// 3 = other
		if($profile['gender'] == 1)
			$profile['gender'] = $txt[189];
		elseif($profile['gender'] == 2)
			$profile['gender'] = $txt[190];
		else
			$profile['gender'] = $txt[191];
			
		// Check size & stuffon their avatar
		$temp = explode("x",$x7c->settings['avatar_size_px']);
		$height = $temp[1];
		$width = $temp[0];
		
		$image_info = @getimagesize($profile['avatar']);
		if(!is_array($image_info)){
			$avatar_code = "<img alt=\"[** $txt[125] **]\" src=\"$profile[avatar]\" width=\"$width\" height=\"$height\">";
		}else{
		
			if($image_info[0] > $width || $image_info[1] > $height || $x7c->settings['resize_smaller_avatars'] == 1)
				$avatar_code = "<img alt=\"[** $txt[125] **]\" src=\"$profile[avatar]\" width=\"$width\" height=\"$height\">";
			else
				$avatar_code = "<img alt=\"[** $txt[125] **]\" src=\"$profile[avatar]\">";
				
		}
		

		
			
		// Output

		$body = "
		<table class=\"profile_table\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">
			<tr>
				<td width=\"400\" colspan=\"2\" class=\"profile_username\">$user<Br><Br></td>
			</tr>
			<tr valign=\"top\">
				<td width=\"150\" class=\"profile_cell\">$avatar_code<Br><span class=\"profile_header_text\">$txt[124]:</span> $profile[bio]</td>
				<td width=\"250\" class=\"profile_cell\">	&nbsp;&nbsp;<span class=\"profile_header_text\">$txt[123]:</span> $profile[user_group]<Br>
									&nbsp;&nbsp;<span class=\"profile_header_text\">$txt[20]:</span> $profile[email]<br>
								  	&nbsp;&nbsp;<span class=\"profile_header_text\">$txt[31]:</span> $profile[name]<Br>
									&nbsp;&nbsp;<span class=\"profile_header_text\">$txt[121]:</span> $profile[location]<Br>
									&nbsp;&nbsp;<span class=\"profile_header_text\">$txt[122]:</span> $profile[hobbies]<br>
									&nbsp;&nbsp;<span class=\"profile_header_text\">$txt[186]:</span> $profile[gender]</td>
			</tr>
		</table>
		";
		
		$print->normal_window($txt[119],$print->ss_profile.$body);
	}
?> 
