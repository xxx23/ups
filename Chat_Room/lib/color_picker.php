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
	// This library handles the color picker functions.  There are basically
	// two ways to do this.  The first one is the GD way, GD is an external library set
	// that MOST servers have installed. However, since a few server don't and/or don't
	// allow users to use them I have included an alternate method also.  The alternate
	// method doesn't allow changing of shade, only of color.  GD allows for shade and color
	// to be chosen.
	
	// You can disable the GD method in your X7 Chat control panel if you do not want to use it,
	// otherwise X7 Chat will detect whether you have it installed and if you do then
	// it will use it automatically.

	function color_form(){
		global $txt, $x7c;
		
		// See what form they want it routed to
		if(!isset($_GET['toform']))
			$form = 'chatIn';
		else
			$form = $_GET['toform'];
			
		if(!isset($_GET['tofield']))
			$field = "curcolor";
		else
			$field = $_GET['tofield'];
		
		if(isset($_GET['extra'])){
			$_GET['extra'] = "&extra=1";
			$extra = "opener.document.getElementById('{$field}d').innerHTML = color;\n
			opener.document.getElementById('{$field}d').style.color = color;";
		}else{
			$_GET['extra'] = "";
			$extra = "";
		}
		
			
		
		if(function_exists("imagecreatefrompng") && file_exists("./colors.png") && $x7c->settings['disable_gd'] != 1){
			$image = @imagecreatefrompng("./colors.png");
			
			// Use GD method
			return "<div align=\"center\">
					$txt[128]<Br><a href=\"./index.php?act=sm_window&page=colors2&toform=$form&tofield=$field{$_GET['extra']}&coords=\"><img src=\"colors.png\" ismap=\"true\" style=\"border: 1px solid black;\"></a>
					<br><br>
					<form action=\"?act=sm_window&page=colors2&toform=$form&tofield=$field{$_GET['extra']}\" method=\"post\">
						$txt[611]: (#XXXXXX)<input type=\"text\" class=\"text_input\" name=\"custom_color\"> <input type=\"submit\" class=\"text_input\" value=\"$txt[187]\">
					</form>
					</div>";
		}else{
			// Use old fashioned way
			return "
			<script langauge=\"javascript\" type=\"text/javascript\">
				function update_color(color){
					opener.document.$form.$field.value = color;
					opener.document.$form.$field.style.background = color;
					$extra
				}
			</script>
			<div align=\"center\">
					$txt[128]<Br>
					<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
						<Tr>
							<td width=\"20\" bgcolor=\"#ff0000\" onClick=\"javasript: update_color('#ff0000');\">&nbsp;</td>
							<td width=\"20\" bgcolor=\"#a80000\" onClick=\"javasript: update_color('#a80000');\">&nbsp;</td>
							<td width=\"20\" bgcolor=\"#370000\" onClick=\"javasript: update_color('#370000');\">&nbsp;</td>
							<td width=\"20\" bgcolor=\"#ff8484\" onClick=\"javasript: update_color('#ff8484');\">&nbsp;</td>
						</tr>
						<Tr>
							<td width=\"20\" bgcolor=\"#ffff02\" onClick=\"javasript: update_color('#ffff02');\">&nbsp;</td>
							<td width=\"20\" bgcolor=\"#909001\" onClick=\"javasript: update_color('#909001');\">&nbsp;</td>
							<td width=\"20\" bgcolor=\"#353500\" onClick=\"javasript: update_color('#353500');\">&nbsp;</td>
							<td width=\"20\" bgcolor=\"#fffc67\" onClick=\"javasript: update_color('#fffc67');\">&nbsp;</td>
						</tr>
						<Tr>
							<td width=\"20\" bgcolor=\"#40ff00\" onClick=\"javasript: update_color('#40ff00');\">&nbsp;</td>
							<td width=\"20\" bgcolor=\"#2eb700\" onClick=\"javasript: update_color('#2eb700');\">&nbsp;</td>
							<td width=\"20\" bgcolor=\"#144f00\" onClick=\"javasript: update_color('#144f00');\">&nbsp;</td>
							<td width=\"20\" bgcolor=\"#a2ff86\" onClick=\"javasript: update_color('#a2ff86');\">&nbsp;</td>
						</tr>
						<Tr>
							<td width=\"20\" bgcolor=\"#00fbff\" onClick=\"javasript: update_color('#00fbff');\">&nbsp;</td>
							<td width=\"20\" bgcolor=\"#009da0\" onClick=\"javasript: update_color('#009da0');\">&nbsp;</td>
							<td width=\"20\" bgcolor=\"#004849\" onClick=\"javasript: update_color('#004849');\">&nbsp;</td>
							<td width=\"20\" bgcolor=\"#bcffff\" onClick=\"javasript: update_color('#bcffff');\">&nbsp;</td>
						</tr>
						<Tr>
							<td width=\"20\" bgcolor=\"#0900ff\" onClick=\"javasript: update_color('#0900ff');\">&nbsp;</td>
							<td width=\"20\" bgcolor=\"#0500a4\" onClick=\"javasript: update_color('#0500a4');\">&nbsp;</td>
							<td width=\"20\" bgcolor=\"#020049\" onClick=\"javasript: update_color('#020049');\">&nbsp;</td>
							<td width=\"20\" bgcolor=\"#8277ff\" onClick=\"javasript: update_color('#8277ff');\">&nbsp;</td>
						</tr>
						<Tr>
							<td width=\"20\" bgcolor=\"#ff00ff\" onClick=\"javasript: update_color('#ff00ff');\">&nbsp;</td>
							<td width=\"20\" bgcolor=\"#a800a8\" onClick=\"javasript: update_color('#a800a8');\">&nbsp;</td>
							<td width=\"20\" bgcolor=\"#410041\" onClick=\"javasript: update_color('#410041');\">&nbsp;</td>
							<td width=\"20\" bgcolor=\"#ffa8fb\" onClick=\"javasript: update_color('#ffa8fb');\">&nbsp;</td>
						</tr>
						<Tr>
							<td width=\"20\" bgcolor=\"#ffffff\" onClick=\"javasript: update_color('#ffffff');\">&nbsp;</td>
							<td width=\"20\" bgcolor=\"#c7c7c7\" onClick=\"javasript: update_color('#c7c7c7');\">&nbsp;</td>
							<td width=\"20\" bgcolor=\"#6a6a6a\" onClick=\"javasript: update_color('#6a6a6a');\">&nbsp;</td>
							<td width=\"20\" bgcolor=\"#000000\" onClick=\"javasript: update_color('#000000');\">&nbsp;</td>
						</tr>
					</table>
					<br><br>
					<form action=\"?act=sm_window&page=colors2&toform=$form&tofield=$field{$_GET['extra']}\" method=\"post\">
						$txt[611]: (#XXXXXX)<input type=\"text\" class=\"text_input\" name=\"custom_color\"> <input type=\"submit\" class=\"text_input\" value=\"$txt[187]\">
					</form>
					</div>";
		}
	}
	
	function color_update(){
		global $x7c, $txt;
		// This extra page function is needed if you use GD to update the
		// actual color since the old method is client-side and GD is
		// server-side we have to send the data to the server before
		// upating the input form.
		
		// See if the user submitted a custom RGB value or if they clicked it
		if(isset($_POST['custom_color'])){
			if(strlen($_POST['custom_color']) == 6){
				$color = "#".$_POST['custom_color'];
			}elseif(strlen($_POST['custom_color']) == 7){
				$color = $_POST['custom_color'];
			}else{
				$color = "#00000";
			}
			
			// See what form they want it routed to
			if(!isset($_GET['toform']))
				$form = 'chatIn';
			else
				$form = $_GET['toform'];
				
			if(!isset($_GET['tofield']))
				$field = "curcolor";
			else
				$field = $_GET['tofield'];
			
			if(isset($_GET['extra'])){
				$extra = "opener.document.getElementById('{$field}d').innerHTML = '$color';\n
				opener.document.getElementById('{$field}d').style.color = '$color';";
			}else{
				$extra = "";
			}
				
			return "<script language=\"javascript\" type=\"text/javascript\">\n
			opener.document.$form.$field.value = '$color';\n
			opener.document.$form.$field.style.background = '$color';\n
			$extra
			</script>$txt[134]";
		}
		
		// Get the coordinates from the image map
		$coords = eregi_replace("^\?","",$_GET['coords']);
		$coords = explode(",",$coords);
		
		// Test once more for GD support
		if(function_exists("imagecreatefrompng") && file_exists("./colors.png") && $x7c->settings['disable_gd'] != 1){
		
			$image = @imagecreatefrompng("./colors.png");
		
			// Get the location of the color they picked
			$rgb = imagecolorat($image,$coords[0],$coords[1]);
			$rgb = imagecolorsforindex($image,$rgb); 
			
			// Convert from decimal to hexidecimal
			$r = dechex($rgb['red']);
			$b = dechex($rgb['blue']);
			$g = dechex($rgb['green']);
			
			// Since PHP will automatically chop the leading zero off a 
			// single digit number we need to add it back on
			if(strlen($r) == 1)
				$r = "0".$r;
			if(strlen($g) == 1)
				$g = "0".$g;
			if(strlen($b) == 1)
				$b = "0".$b;
				
			// See what form they want it routed to
			if(!isset($_GET['toform']))
				$form = 'chatIn';
			else
				$form = $_GET['toform'];
				
			if(!isset($_GET['tofield']))
				$field = "curcolor";
			else
				$field = $_GET['tofield'];
				
			if(isset($_GET['extra'])){
				$extra = "opener.document.getElementById('{$field}d').innerHTML = '#$r$g$b';\n
				opener.document.getElementById('{$field}d').style.color = '#$r$g$b';";
			}else{
				$extra = "";
			}
				
			// Output the changer
			return "<script language=\"javascript\" type=\"text/javascript\">\n
			opener.document.$form.$field.value = '#$r$g$b';\n
			opener.document.$form.$field.style.background = '#$r$g$b';\n
			$extra
			</script>$txt[134]";
			
		}else{
			// Somehow they made it to this page and GD isn't working, tell them an error occured.
			// This is not translated because they should never be able to get here in the first place.
			
			return "<b>* Critcal Library Error * The GD Library required for this color picker is missing.  Please contact the administrator of this chat room.</b>";
		}
	}

?>
