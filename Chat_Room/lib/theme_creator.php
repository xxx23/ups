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

	// Load defaults for a theme, returns as array indexed by tag (see tag.txt in the 'template' theme)
	function load_styles($theme){
		// These are all the tags we need :)
		$return = array("background_color_1" => "",
		"background_color_2" => "",
		"background_color_3" => "",
		"background_color_4" => "",
		"font_color_0" => "",
		"font_color_1" => "",
		"font_color_2" => "",
		"font_color_3" => "",
		"fonts" => "",
		"font_size_0" => "",
		"font_size_1" => "",
		"font_size_2" => "",
		"font_size_3" => "",
		"border_color" => "",
		"border_color_light" => "",
		"border_size" => "",
		"border_style" => "",
		"link_color" => "",
		"link_hover" => "",
		"link_active" => "",
		"form_bg" => "",
		"form_border" => "",
		"form_size" => "",
		"form_color" => "",
		"form_border_size" => "",
		"form_border_style" => "",
		"other_person" => "",
		"you" => "",
		"chat_bg" => "",
		"chat_border" => "",
		"header_bg_image" => "",
		"col_bg_image" => "",
		"theme_author" => "",
		"theme_name" => "",
		"theme_description" => "",
		"theme_version" => "");
		
		// If the theme if a new one ("") then return blank defaults
		if($theme == "")
			return $return;
		
		// Grab the variables
		$theme_data = file("./themes/$theme/theme.data");
		$theme_data = explode(";",implode("",$theme_data));
		foreach($theme_data as $key=>$val){
			eregi("([A-z0-9_]*)\[(.*)\]","$val",$match);
			$data[$match[1]] = $match[2];
		}
		
		$return = array("background_color_1" => "$data[BGColor1]",
		"background_color_2" => "$data[BGColor2]",
		"background_color_3" => "$data[BGColor3]",
		"background_color_4" => "$data[BGColor4]",
		"font_color_0" => "$data[FontColor0]",
		"font_color_1" => "$data[FontColor1]",
		"font_color_2" => "$data[FontColor2]",
		"font_color_3" => "$data[FontColor3]",
		"fonts" => "$data[FontFamily]",
		"font_size_0" => "$data[FontSize0]",
		"font_size_1" => "$data[FontSize1]",
		"font_size_2" => "$data[FontSize2]",
		"font_size_3" => "$data[FontSize3]",
		"border_color" => "$data[BorderColor]",
		"border_color_light" => "$data[BorderColorLight]",
		"border_size" => "$data[BorderSize]",
		"border_style" => "$data[BorderStyle]",
		"link_color" => "$data[LinkColor]",
		"link_hover" => "$data[HoverColor]",
		"link_active" => "$data[ActiveColor]",
		"form_bg" => "$data[FormBG]",
		"form_border" => "$data[FormBorderColor]",
		"form_size" => "$data[FormFontSize]",
		"form_color" => "$data[FormFontColor]",
		"form_border_size" => "$data[FormBorderSize]",
		"form_border_style" => "$data[FormBorderStyle]",
		"other_person" => "$data[OtherPerson]",
		"you" => "$data[You]",
		"chat_bg" => "$data[ChatBG]",
		"chat_border" => "$data[ChatBorder]",
		"header_bg_image" => "$data[HeaderBG]",
		"col_bg_image" => "$data[ColumnBG]");
		
		include("./themes/$theme/theme.info");
		
		$return["theme_author"] = $author;
		$return["theme_name"] = $name;
		$return["theme_description"] = $description;
		$return["theme_version"] = $version;
		
		return $return;
	}
	
	function edit_file($theme){
		// Get prior data
		
		$return = array("background_color_1" => "BGColor1",
		"background_color_2" => "BGColor2",
		"background_color_3" => "BGColor3",
		"background_color_4" => "BGColor4",
		"font_color_0" => "FontColor0",
		"font_color_1" => "FontColor1",
		"font_color_2" => "FontColor2",
		"font_color_3" => "FontColor3",
		"fonts" => "FontFamily",
		"font_size_0" => "FontSize0",
		"font_size_1" => "FontSize1",
		"font_size_2" => "FontSize2",
		"font_size_3" => "FontSize3",
		"border_color" => "BorderColor",
		"border_color_light" => "BorderColorLight",
		"border_size" => "BorderSize",
		"border_style" => "BorderStyle",
		"link_color" => "LinkColor",
		"link_hover" => "HoverColor",
		"link_active" => "ActiveColor",
		"form_bg" => "FormBG",
		"form_border" => "FormBorderColor",
		"form_size" => "FormFontSize",
		"form_color" => "FormFontColor",
		"form_border_size" => "FormBorderSize",
		"form_border_style" => "FormBorderStyle",
		"other_person" => "OtherPerson",
		"you" => "You",
		"chat_bg" => "ChatBG",
		"chat_border" => "ChatBorder",
		"header_bg_image" => "HeaderBG",
		"col_bg_image" => "ColumnBG");
		
		$data = "";
		foreach($return as $key=>$val){
			$data .= "{$val}[$_POST[$key]];\n";
		}
		
		$fh = fopen("./themes/$theme/theme.data","w");
		fwrite($fh,$data);
		fclose($fh);
	}
?> 
