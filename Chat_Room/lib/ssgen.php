<?PHP
/////////////////////////////////////////////////////////////// 
//
//		X7 Chat Version 2.0.4.2
//		Released July 29, 2006
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
	// This file generates style sheets for simple themes
	// Recieves the theme data file as an array
	
	// Grab the variables
	function get_data($theme_data,$skin){
		foreach($theme_data as $key=>$val){
			if($val != "\n"){
				eregi("([A-z0-9_]*)\[(.*)\]","$val",$match);
				$match[2] = eregi_replace("url\(","url(./themes/$skin/",$match[2]);
				$data[$match[1]] = $match[2];
			}
		}
		return $data;
	}
	
	function gen_css($data,$skin){	
		// Generate the Style information
		$css = "<style type=\"text/css\">
			BODY {
				color: $data[FontColor1];
				font-family: $data[FontFamily];
				font-size: $data[FontSize1];
				background: $data[BGColor1];
			}
			TD {
				color: $data[FontColor1];
				font-family: $data[FontFamily];
				font-size: $data[FontSize1];
			}
			.online_list {
				color: $data[FontColor1];
				border: $data[BorderSize] $data[BorderStyle] $data[BorderColor];
				font-family: $data[FontFamily];
				font-size: $data[FontSize1];
				width: 96%;
				background: $data[BGColor2];
				height: 98%;
				margin-left: 1%;
			}
			.menubar {
				color: $data[FontColor2];
				background: url(./themes/$skin/button.gif);
				text-align: center;
				font-size: $data[FontSize1];
				font-family: $data[FontFamily];
				cursor: pointer;
			}
			.menubar_hover {
				color: $data[FontColor2];
				background: url(./themes/$skin/button_over.gif);
				text-align: center;
				font-size: $data[FontSize1];
				font-family: $data[FontFamily];
				cursor: pointer;
			}
			.infobar {
				color: $data[FontColor1];
				font-size: $data[FontSize1];
				font-family: $data[FontFamily];
			}
			.box_header {
				color: $data[FontColor3];
				font-family: $data[FontFamily];
				font-size: $data[FontSize2];
				background: $data[HeaderBG];
				border: $data[BorderSize] $data[BorderStyle] $data[BorderColor];
				text-align: center;
				font-weight: bold;
			}
			.box_body {
				color: $data[FontColor1];
				font-family: $data[FontFamily];
				font-size: $data[FontSize1];
				background: $data[BGColor2];
				border: $data[BorderSize] $data[BorderStyle] $data[BorderColor];
				border-top: none;
				text-align: left;
			}
			.info_box_body {
				color: $data[FontColor1];
				font-family: $data[FontFamily];
				font-size: $data[FontSize1];
				background: $data[BGColor2];
				border: $data[BorderSize] $data[BorderStyle] $data[BorderColor];
				text-align: left;
			}
			.col_header {
				color: $data[FontColor3];
				font-family: $data[FontFamily];
				font-size: $data[FontSize3];
				font-weight: bold;
				background: $data[ColumnBG];
				text-align: left;
				border: $data[BorderSize] $data[BorderStyle] $data[BorderColor];
			}
			.dark_row {
				color: $data[FontColor1];
				font-family: $data[FontFamily];
				font-size: $data[FontSize1];
				background: $data[BGColor3];
				text-align: left;
			}
			.inside_table {
				border: $data[BorderSize] $data[BorderStyle] $data[BorderColor];
				border-top: none;
			}
			A {
				color: $data[LinkColor];
				text-decoration: none;
			}
			A:HOVER {
				color: $data[HoverColor];
				text-decoration: underline;
			}
			A:ACTIVE {
				color: $data[ActiveColor];
			}
			.text_input{
				background: $data[FormBG];
				border: $data[FormBorderSize] $data[FormBorderStyle] $data[FormBorderColor];
				font-size: $data[FormFontSize];
				font-family: $data[FontFamily];
				color: $data[FormFontColor];
			}
			.button{
				background: $data[FormBG];
				border: $data[FormBorderSize] $data[FormBorderStyle] $data[FormBorderColor];
				font-size: $data[FormFontSize];
				font-family: $data[FontFamily];
				color: $data[FormFontColor];
			}
		</style>";
		
		return $css;
	}
	
	function gen_chatinput($data,$skin){
		
		$css = " <style type=\"text/css\">
			.arrow_box {
				border-left: $data[BorderSize] $data[BorderStyle] $data[BorderColor];
				background: $data[BGColor3];
				color: $data[FontColor1];
			}
			.selectbar {
				border: none;
				background: url(./themes/$skin/selectbar.gif);
				height: 15px;
				color: $data[FontColor1];
			}
			.msginput_bg {
			}
			.msginput {
				border: $data[FormBorderSize] $data[FormBorderStyle] $data[FormBorderColor];
				background: $data[FormBG];
				font-family: $data[FontFamily];
				font-size: $data[FormFontSize];
				width: 298px;
				color: $data[FormFontColor];
			}
			.smileybuttonOver {
				border: $data[BorderSize] $data[BorderStyle] $data[BorderColor];
				background: $data[BGColor4];
				cursor: pointer;
				color: $data[FontColor1];
			}
			.smileybutton {
				border: $data[BorderSize] $data[BorderStyle] $data[BorderColor];
				background: url(./themes/$skin/selectbar.gif);
				cursor: pointer;
				color: $data[FontColor1];
			}
			.boldtxt {
				background: url(./themes/$skin/selectbar.gif);
				font-family: $data[FontFamily];
				font-size: $data[FontSize1];
				cursor: pointer;
				border: $data[BorderSize] $data[BorderStyle] $data[BorderColor];
				text-align: center;
				color: $data[FontColor1];
			}
			.boldtxtover {
				background: $data[BGColor2];
				font-family: $data[FontFamily];
				font-size: $data[FontSize1];
				cursor: pointer;
				border-left: $data[BorderSize] $data[BorderStyle] $data[BorderColor];
				border-top: $data[BorderSize] $data[BorderStyle] $data[BorderColor];
				border-right: $data[BorderSize] $data[BorderStyle] $data[BorderColor];
				border-bottom: $data[BorderSize] $data[BorderStyle] $data[BorderColor];
				text-align: center;
				color: $data[FontColor1];
			}
			.boldtxtdown {
				background: url(./themes/$skin/selectbar_inv.gif);
				font-family: $data[FontFamily];
				font-size: $data[FontSize1];
				cursor: pointer;
				border-right: $data[BorderSize] $data[BorderStyle] $data[BorderColorLight];
				border-bottom: $data[BorderSize] $data[BorderStyle] $data[BorderColorLight];
				border-left: $data[BorderSize] $data[BorderStyle] $data[BorderColor];
				border-top: $data[BorderSize] $data[BorderStyle] $data[BorderColor];
				text-align: center;
				color: $data[FontColor1];
			}
			.curfont {
				width: 61px;
				height: 15px;
				background: transparent;
				border: 0px solid $data[BorderColor];
				font-family: $data[FontFamily];
				font-size: $data[FontSize1];
				cursor: pointer;
				color: $data[FontColor1];
			}
			.cursize {
				width: 41px;
				height: 15px;
				background: transparent;
				border: 0px solid $data[BorderColor];
				font-family: $data[FontFamily];
				font-size: $data[FontSize1];
				cursor: pointer;
				color: $data[FontColor1];
			}
			.curcolor {
				width: 61px;
				height: 15px;
				background: transparent;
				border: 0px solid $data[BorderColor];
				font-family: $data[FontFamily];
				font-size: $data[FontSize1];
				cursor: pointer;
				color: $data[FontColor1];
			}
			.selected {
				background: $data[BGColor3];
				font-family: $data[FontFamily];
				font-size: $data[FontSize1];
				cursor: pointer;
				color: $data[FontColor1];
			}
			.nonSelected {
				background: $data[BGColor2];
				border: $data[BorderSize] $data[BorderStyle] $data[BorderColor];
				font-family: $data[FontFamily];
				font-size: $data[FontSize1];
				cursor: pointer;
				color: $data[FontColor1];
			}
			.send_button {
				color: $data[FontColor1];
			}
		</style>";
		
		return $css;
	}
	
	function gen_events($data,$skin){
		
		$css = "<style type=\"text/css\">
			.event_top {
				font-family: $data[FontFamily];
				font-size: $data[FontSize2];
				font-weight: bold;
				border: $data[BorderSize] $data[BorderStyle] $data[BorderColor];
				border-right: 0px $data[BorderStyle] $data[BorderColor];
				background: $data[BGColor2];
				color: $data[FontColor0];
			}
			.event_table {
				border-right: $data[BorderSize] $data[BorderStyle] $data[BorderColor];
			}
			.event_day {
				font-family: $data[FontFamily];
				font-size: $data[FontSize1];
				border: $data[BorderSize] $data[BorderStyle] $data[BorderColor];
				border-right: 0px $data[BorderStyle] $data[BorderColor];
				color: $data[FontColor0];
			}
			.event_day_name {
				font-family: $data[FontFamily];
				font-size: $data[FontSize1];
				border-bottom: $data[BorderSize] $data[BorderStyle] $data[BorderColor];
				text-align: center;
				font-weight: bold;
				color: $data[FontColor0];
			}
			.event_day_no {
				font-family: $data[FontFamily];
				font-size: $data[FontSize1];
				border: $data[BorderSize] $data[BorderStyle] $data[BorderColor];
				border-right: 0px $data[BorderStyle] $data[BorderColor];
				text-align: center;
				color: $data[FontColor0];
			}
			.event_day_yes {
				font-family: $data[FontFamily];
				font-size: $data[FontSize1];
				text-align: center;
				border: $data[BorderSize] $data[BorderStyle] $data[BorderColor];
				border-right: 0px $data[BorderStyle] $data[BorderColor];
				background: url(./themes/$skin/./star.gif);
				cursor: pointer;
				color: $data[FontColor0];
			}
			.event_day_abr {
				font-family: $data[FontFamily];
				font-size: $data[FontSize1];
				border: $data[BorderSize] $data[BorderStyle] $data[BorderColor];
				text-align: center;
				font-weight: bold;
				color: $data[FontColor0];
			}
		</style>";
		
		return $css;
	}
	
	function gen_mini($data,$skin){
		
		$css = "<style type=\"text/css\">
			.other_persons {
				color: $data[OtherPerson];
				font-weight: bold;
			}
			.you {
				color: $data[You];
				font-weight: bold;
			} 
			#message_window {
				background: $data[ChatBG];
				margin-left: 5px;
				height: 98%;
				padding-left: 5px;
				padding-right: 5px;
				border: 1px solid $data[ChatBorder];
				overflow: scroll;
				margin-right: 5px;
			}
		</style>";
		
		$css = eregi_replace("\r","",$css);
		$css = eregi_replace("\n","",$css);
		$css = eregi_replace("'","\'",$css);
	
		return $css;	
	}
	
	function gen_pm($data,$skin){
		
		$css = "<style type=\"text/css\">
			.pm_infobar {
				background: black;
			}
			.pm_ib_fc {
				text-align: center;
				background: $data[BGColor3];
				font-size: $data[FontSize0];
				font-family: $data[FontFamily];
				font-weight: bold;
				color: $data[FontColor0];
			}
			.pm_ib_r {
				text-align: center;
				background: $data[BGColor2];
				font-size: $data[FontSize0];
				font-family: $data[FontFamily];
				cursor: pointer;
				color: $data[FontColor0];
			}
			.pm_ib_r_alt {
				text-align: center;
				background: $data[BGColor3];
				font-size: $data[FontSize0];
				font-family: $data[FontFamily];
				cursor: pointer;
				color: $data[FontColor0];
			}
			.main_iframe {
				border: 1px solid $data[ChatBorder];
			}
		</style>";
	
		return $css;	
	}
	
	function gen_profile($data,$skin){
		
		$css = "<style type=\"text/css\">
			.profile_username {
				font-size: $data[FontSize2];
				font-weight: bold;
				text-align: center;
			}
			.profile_header_text {
				font-weight: bold;
			}
			.profile_table {
			}
			.profile_cell {
			}
		</style>";
	
		return $css;	
	}
	
	function gen_uc($data,$skin){
		
		$css = " <style type=\"text/css\">
			.uc_item_box{
				font-family: $data[FontFamily];
				font-size: $data[FontSize1];
				vertical-align: middle;
				border: $data[FormBorderSize] $data[FormBorderStyle] $data[FormBorderColor];
				background: $data[BGColor2];
				text-align: center;
				color: $data[FontColor1];
			}
			.uc_item {
				font-family: $data[FontFamily];
				font-size: $data[FontSize0];
				vertical-align: middle;
				border: $data[FormBorderSize] $data[FormBorderStyle] $data[BGColor2];
				background: $data[BGColor2];
				text-align: center;
				width: 100px;
				color: $data[FontColor1];
				height: 18px;
				cursor: default;
			}
			.uc_header{
				font-family: $data[FontFamily];
				font-size: $data[FontSize0];
				vertical-align: middle;
				cursor: pointer;
				text-align: center;
				background: url(./themes/$skin/user_control_bg.gif);
				color: $data[FontColor1];
			}
			.uc_header_text{
				font-family: $data[FontFamily];
				font-size: $data[FontSize1];
				vertical-align: middle;
				cursor: pointer;
				text-align: center;
				color: $data[FontColor1];
				cursor: pointer;
			}
			.uc_header_selected{
				font-family: $data[FontFamily];
				font-size: $data[FontSize1];
				vertical-align: middle;
				cursor: pointer;
				text-align: center;
				font-weight: bold;
				background: url(./themes/$skin/user_control_bg2.gif);
				color: $data[FontColor1];
				cursor: pointer;
			}
			.uc_item_over{
				font-family: $data[FontFamily];
				font-size: $data[FontSize0];
				vertical-align: middle;
				cursor: pointer;
				background: $data[BGColor3];
				border: $data[FormBorderSize] $data[FormBorderStyle] $data[FormBorderColor];
				text-align: center;
				width: 100px;
				color: $data[FontColor1];
				height: 18px;
				cursor: pointer;
			}
			.uc_item_blank{
				font-family: $data[FontFamily];
				font-size: $data[FontSize0];
				vertical-align: middle;
				background: $data[BGColor2];
				border: 1px solid $data[BGColor2];
				text-align: center;
				width: 100px;
				color: $data[FontColor1];
				height: 18px;
				cursor: default;
			}
			.infobox {
				font-size: $data[FontSize1];
				font-family: $data[FontFamily];
				border: none;
				cursor: pointer;
				background: transparent;
				color: $data[FontColor1];
			}

		</style>";
	
		return $css;	
	}
	
	function gen_ucp($data,$skin){
		
		$css = "<style type=\"text/css\">
			.ucp_cell {
				text-align: center;
				background: $data[BGColor4];
				font-size: $data[FontSize0];
				font-family: $data[FontFamily];
				cursor: pointer;
				border-bottom: $data[BorderSize] $data[BorderStyle] $data[BorderColor];
				color: $data[FontColor1];
			}
			.ucp_sell {
				text-align: center;
				background: $data[BGColor3];
				font-size: $data[FontSize0];
				font-family: $data[FontFamily];
				cursor: pointer;
				border-bottom: $data[BorderSize] $data[BorderStyle] $data[BorderColor];
				color: $data[FontColor1];
			}
			.ucp_bodycell {
				border-bottom: $data[BorderSize] $data[BorderStyle] $data[BorderColor];
				border-right: $data[BorderSize] $data[BorderStyle] $data[BorderColor];
				font-size: $data[FontSize0];
				font-family: $data[FontFamily];
				color: $data[FontColor1];
			}
			.ucp_table {
				border-top: $data[BorderSize] $data[BorderStyle] $data[BorderColor];
				color: $data[FontColor1];
			}
			.ucp_table2 {
				border-left: $data[BorderSize] $data[BorderStyle] $data[BorderColor];
				color: $data[FontColor1];
			}
			.ucp_divider{
				border-left: $data[BorderSize] $data[BorderStyle] $data[BorderColor];
				border-bottom: $data[BorderSize] $data[BorderStyle] $data[BorderColor];
				color: $data[FontColor1];
			}
		</style>";
	
		return $css;	
	}
?>
