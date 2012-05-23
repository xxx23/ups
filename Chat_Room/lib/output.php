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

	// This class handles the loading and output of skins and data
	class load_skin {
		var $buffer;		// Holds the data we are going to print
		var $templates;		// An array, holds the page templates
		var $image_path;	// Holds the path to images
		var $style_sheet;	// Holds the CSS style sheet for this template
		var $this_skin;		// The skin that the $print object is currently using
		var $inv_buffer;	// If you need to add something to the end of the page you can use this buffer
		var $direction;		// rtl or ltr
		
		function load_skin($skin){
			global $x7c, $_GET, $language_iso, $language_dir;
			
			$this->this_skin = $skin;
		
			$this->inv_buffer = "";
			$this->buffer = "";
			if(isset($language_dir))
				$this->direction = $language_dir;
			else
				$this->direction = "ltr";
			
			// Load the theme information
			include("./themes/$skin/theme.info");
			
			// This variable helps images find their way
			$this->image_path = "./themes/$skin/";
			
			// Advanced theme (it has all its style sheets)
			if($theme_type == 2){

				// Load the Global Style Sheets
				$theme_ss = file("./themes/$skin/$style_sheet");
				$theme_ss = implode("",$theme_ss);
				$theme_ss = eregi_replace("url\(","url(./themes/$skin/",$theme_ss);
				$this->style_sheet = $theme_ss;

				// This one require special parsing so it will work with a javascript write() command
				$theme_ss_mini = file("./themes/$skin/$style_sheet_mini");
				$theme_ss_mini = implode("",$theme_ss_mini);
				$theme_ss_mini = eregi_replace("url\(","url(./themes/$skin/",$theme_ss_mini);
				$theme_ss_mini = eregi_replace("\r","",$theme_ss_mini);
				$theme_ss_mini = eregi_replace("\n","",$theme_ss_mini);
				$theme_ss_mini = eregi_replace("'","\'",$theme_ss_mini);
				$this->ss_mini = $theme_ss_mini;

				// Load the Profile Page Style Sheets
				$theme_ss_profile = file("./themes/$skin/$style_sheet_profile");
				$theme_ss_profile = implode("",$theme_ss_profile);
				$theme_ss_profile = eregi_replace("url\(","url(./themes/$skin/",$theme_ss_profile);
				$this->ss_profile = $theme_ss_profile;

				// Load the Private Message Page Style Sheets
				$theme_ss_pm = file("./themes/$skin/$style_sheet_pm");
				$theme_ss_pm = implode("",$theme_ss_pm);
				$theme_ss_pm = eregi_replace("url\(","url(./themes/$skin/",$theme_ss_pm);
				$this->ss_pm = $theme_ss_pm;

				// Load the Chat input box style sheet
				$theme_ss_chatinput = file("./themes/$skin/$style_sheet_chatinput");
				$theme_ss_chatinput = implode("",$theme_ss_chatinput);
				$theme_ss_chatinput = eregi_replace("url\(","url(./themes/$skin/",$theme_ss_chatinput);
				$this->ss_chatinput = $theme_ss_chatinput;

				// Load the User Control style sheet
				$theme_ss_uc = file("./themes/$skin/$style_sheet_uc");
				$theme_ss_uc = implode("",$theme_ss_uc);
				$theme_ss_uc = eregi_replace("url\(","url(./themes/$skin/",$theme_ss_uc);
				$this->ss_uc = $theme_ss_uc;

				// Load the Events Calender Style Sheet
				$theme_ss_events = file("./themes/$skin/$style_sheet_events");
				$theme_ss_events = implode("",$theme_ss_events);
				$theme_ss_events = eregi_replace("url\(","url(./themes/$skin/",$theme_ss_events);
				$this->ss_events = $theme_ss_events;

				// Load the Private Message Page Style Sheets
				$theme_ss_ucp = file("./themes/$skin/$style_sheet_ucp");
				$theme_ss_ucp = implode("",$theme_ss_ucp);
				$theme_ss_ucp = eregi_replace("url\(","url(./themes/$skin/",$theme_ss_ucp);
				$this->ss_ucp = $theme_ss_ucp;
				
			}else{
				// This is a simple theme
				include_once("./lib/ssgen.php");
				
				// Get the theme data and split by ; marks rather then new lines
				$theme_data_file = file("./themes/$skin/theme.data");
				$theme_data_file = explode(";",eregi_replace("\r","",implode("",$theme_data_file)));
				
				$data = get_data($theme_data_file,$skin);
				
				// Generate all the style sheets
				$this->style_sheet = gen_css($data,$skin);
				$this->ss_mini = gen_mini($data,$skin);
				$this->ss_profile = gen_profile($data,$skin);
				$this->ss_pm = gen_pm($data,$skin);
				$this->ss_chatinput = gen_chatinput($data,$skin);
				$this->ss_uc = gen_uc($data,$skin);
				$this->ss_events = gen_events($data,$skin);
				$this->ss_ucp = gen_ucp($data,$skin);
				
			}
			
			
			// Compile page header
			$site_name = $x7c->settings['site_name'];
			$this->add("
<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">
<html dir=\"$this->direction\">
<head>
	<title>$site_name</title>
	<META NAME=\"COPYRIGHT\" CONTENT=\"Copyright 2004 By The X7 Group\">
	<META HTTP-EQUIV=\"Content-Type\" content=\"text/html; charset=$language_iso\">
	<META HTTP-EQUIV=\"CACHE-CONTROL\" CONTENT=\"NO-CACHE\">
	<META HTTP-EQUIV=\"PRAGMA\" CONTENT=\"NO-CACHE\">
	<LINK REL=\"SHORTCUT ICON\" HREF=\"./favicon.ico\">
	{$this->style_sheet}
</head>");
			
			// If this is a frameset page we can't add <body> to it
			if(@$_GET['frame'] != "main")
				$this->add("<body>");
				
		}
		
		function theme_info($skin){
		
			// Load the theme information
			include("./themes/$skin/theme.info");
			
			$return['author'] = $author;
			$return['date'] = $date;
			$return['name'] = $name;
			$return['description'] = $description;
			$return['version'] = $version;
			$return['copyright'] = $copyright;
			$return['website'] = $website;
			return $return;
		}
		
		function add($text){
			$this->buffer .= "$text\r\n";
			return 1;
		}
		
		// Print to the screen, set $pretend to true if you don't actually
		// want to print, this is useful for debugging
		function dump_buffer($pretend=false){
			global $_GET, $X7CHATVERSION;
			
			// Theme copyright if written by someone other then ourselfs
			$theme_info = $this->theme_info($this->this_skin);
			if($theme_info['author'] == "X7 Group")
				$theme_c = "";
			else
				$theme_c = "<Br>Theme by $theme_info[author], ".$theme_info['copyright'];
			
			//**************************************************************//
			//	This is my copyright.  I ask you very kindly not to			//
			//	remove it.  I spent 106 Hours and 45 Minutes of my own		//
			//	free time to make this software.  I am not getting school	//
			//	or work credit, nor am I going to get much money, if any,	//
			//	from it.  So if you don't want to pay for it the least you 	//
			//	can do is give me one line of credit.						//
			//**************************************************************//
			$this->add("<!----><div align=\"center\" style=\"visibility: visible;\">Powered By X7 Chat $X7CHATVERSION &copy; 2004 By The X7 Group$theme_c</div>");
			//**************************************************************//
			//	Should you decide that you want to steal my work anyway, I 	//
			//	must inform you that removal of this copyright without 		//
			//	permission voids your right to use this software and you	// 
			//	be required to cease all use of it immediatly.				//
			//**************************************************************//
			
			$this->add($this->inv_buffer);
			
			// If this is a frameset page we can't add </body> to it
			if(@$_GET['frame'] != "main")
				$this->add("</body>");
			
			$this->add("</html>");
			if($pretend)
				return $this->buffer;
			echo $this->buffer;
			return 1;
		}
		
		function normal_window($head,$body){
			global $x7c;
			// Load the Window Template
			$skin = $x7c->settings['default_skin'];
			$theme_wt = file("./themes/$skin/window.tpl");
			$theme_wt = implode("",$theme_wt);
			$theme_wt = eregi_replace("<x7chat_header>",$head,$theme_wt);
			$theme_wt = eregi_replace("<x7chat_body>",$body,$theme_wt);
			
			// Output this data
			$this->add($theme_wt);
		}
		
		// A small popup information window
		function info_window($body){
			global $x7c, $txt;
			// Load the Window Template
			$skin = $x7c->settings['default_skin'];
			$theme_wt = file("./themes/$skin/info_box.tpl");
			$theme_wt = implode("",$theme_wt);
			$theme_wt = eregi_replace("<x7chat_body>",$body,$theme_wt);
			$theme_wt = eregi_replace("<X>",$txt[133],$theme_wt);
			
			// Output this data
			$this->add($theme_wt);
		}
		
		// This will return the code for a help button.
		function help_button($subject){
			global $x7c;
			return "<img style=\"cursor: pointer;cursor: hand;\" onClick=\"javascript: window.open('./index.php?act=help&q=$subject','','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width={$x7c->settings['tweak_window_small_width']},height={$x7c->settings['tweak_window_small_height']}');\" src=\"{$this->image_path}/help.gif\">";
		}
		
	
	}

?>
