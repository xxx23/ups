<?PHP
///////////////////////////////////////////////////////////////
//
//		X7 Chat Version 2.0.4.3
//		Released August 28, 2006
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
	// This is to simplify index.php
	// instead of having index.php decide which of the following three functions
	// to call this first function determines that
	function pm_whatshouldicall(){
		global $x7c;

		if(!isset($_GET['pmf'])){
			pm_base_frame();
		}elseif($_GET['pmf'] == "snd_msg"){


		}elseif($_GET['pmf'] == "send"){
			pm_send_frame();
		}elseif($_GET['pmf'] == "null"){
			pm_null_frame();
		}else{
			pm_update_frame();
		}

	}

	// The update frame, duh
	function pm_update_frame(){
		global $db, $prefix, $x7s, $print, $x7c, $BW_CHECK, $x7p, $txt;

		// Include the message library
		include("./lib/message.php");

		$script = "";

		// See if this is a support room call
		if(isset($_GET['support']))
			$extra = $txt[596]."<Br>";
		else
			$extra = "";

		if(!isset($_GET['firsttime'])){
			// This is loaded for the first time
			$script .= "window.parent.window.frames['main_window'].document.write('<html><head>$print->ss_mini</head><body>$extra');";
		}

		// Get messages
		$messages = 0;
		$query = $db->DoQuery("SELECT user,body,time,type FROM {$prefix}messages WHERE room='$x7s->username:0' AND user='$_GET[send_to]' AND (type='5' OR type='7') ORDER BY time ASC");
		$query2 = $db->DoQuery("UPDATE {$prefix}messages SET room='$x7s->username:1' WHERE room='$x7s->username:0' AND user='$_GET[send_to]' AND (type='5' OR type='7')");
		while($row = $db->Do_Fetch_Row($query)){
			if($row[3] == 5){
				$row[1] = eregi_replace("'","\\'",$row[1]);

				// Do logging if required
				if($x7c->settings['log_pms'] == 1 && $_GET['send_to'] != ""){
					include_once("./lib/logs.php");
					$log = new logs(2,$_GET['send_to']);
					$log->add($_GET['send_to'],$row[1]);
				}

				$row[1] = parse_message($row[1]);

			}else{
				$row[1] = parse_message($row[1],1);
			}

			// See if they want a timestamp
			if($x7c->settings['disble_timestamp'] != 1)
				$timestamp = format_timestamp($row[2]);
			else
				$timestamp = "";

			if($row[3] == 5){
				$script .= "window.parent.window.frames['main_window'].document.write('<span class=\"other_persons\">$row[0]$timestamp:</span> $row[1]<Br>');\n";
			}else{
				$script .= "window.parent.window.frames['main_window'].document.write('$row[1]<Br>');\n";
			}
			$messages = 1;
		}

		// If there are new messages then scroll the screen
		if($messages == 1){
			$script .= "if(typeof(scrollBy) != \"undefined\"){\n
							window.parent.window.frames['main_window'].window.scrollBy(0, 65000);\n
						}else{\n
							window.parent.window.frames['main_window'].window.scroll(0, 65000);\n
						}\n";

			if($x7c->settings['disable_sounds'] != 1){
				if(eregi("MSIE","$_SERVER[HTTP_USER_AGENT]")){
					// wow, the browser you are using is a piece of shit
					// ok then, we'll send you nice code
					$script .= "window.parent.document.msg_snd.Play();\n";
				}else{
					// At lesat test code actually works here
					$script .= "if(window.parent.document.msg_snd.Play)\nwindow.parent.document.msg_snd.Play();\n";
				}
				// Yes, you did seem me just run a fucking browser test and I am not happy about it
				$sound_play = 1;
			}
		}

		// See if they have used up all their allowed bandwidth
		if($x7c->settings['log_bandwidth'] == 1){
			if($BW_CHECK){
				$script .= "window.parent.location='./index.php'\r\n";
			}
		}

		// See if they are banned
		$bans = $x7p->bans_on_you;

		foreach($bans as $key=>$row){

			// If a row returned and they don't have immunity then thrown them out the door and lock up
			if($row != "" && $x7c->permissions['ban_kick_imm'] != 1){
				if($row[1] == "*"){
					// They are banned from the server
					$txt[117] = eregi_replace("_r",$row[5],$txt[117]);
					$script = "alert('$txt[117]')\n
								window.parent.location='./index.php'\r\n";
				}
			}
		}

		// We need to output as little as possible here, again
		if(isset($_GET['firsttime']))
			echo "<html><head><script language=\"javascript\" type=\"text/javascript\">$script</script></head><body onLoad=\"javascript: setTimeout('location.reload()','{$x7c->settings['refresh_rate']}');\">&nbsp;</body>";
		else
			echo "<html><head><script language=\"javascript\" type=\"text/javascript\">$script</script></head><body onLoad=\"javascript: document.location='./index.php?act=pm&pmf=update&send_to=$_GET[send_to]&firsttime=1'\">&nbsp;</body>";
	}

	// A blank frame
	function pm_null_frame(){
		echo "&nbsp;";
	}

	// the sending frame, duh, both of these are invisible
	function pm_send_frame(){
		global $x7c, $prefix, $db;

		// Include the message library
		include("./lib/message.php");

		// Make sure the message isn't null
		if(@$_GET['msg'] != "" && !eregi("^/",@$_GET['msg'])){

			// Save the style settings they used for next time
			$x7c->edit_user_settings("default_font",$_GET['curfont']);
			$x7c->edit_user_settings("default_size",$_GET['cursize']);
			$x7c->edit_user_settings("default_color",$_GET['curcolor']);

			// Get the styles
			$starttags = "";
			$endtags = "";
			$color = $_GET['curcolor'];
			$size = eregi_replace(" Pt","pt",$_GET['cursize']);
			$font = $_GET['curfont'];

			// Make sure incoming values are safe
			$_GET['msg'] = eregi_replace("<","&lt;",$_GET['msg']);
			$color = eregi_replace("<","&lt;",$color);
			$size = eregi_replace("<","&lt;",$size);
			$font = eregi_replace("<","&lt;",$font);

			// Add the styles
			$starttags .= "[color=$color][size=$size][font=$font]";

			if($_GET['bold'] == 1){
				$starttags .= "[b]";
				$endtags .= "[/b]";
			}
			if($_GET['italic'] == 1){
				$starttags .= "[i]";
				$endtags .= "[/i]";
			}
			if($_GET['under'] == 1){
				$starttags .= "[u]";
				$endtags .= "[/u]";
			}

			$endtags .= "[/color][/size][/font]";

			$parsed_msg = $starttags.$_GET['msg'].$endtags;
			send_pm($parsed_msg,$_GET['send_to']);

		}elseif(eregi("^/",@$_GET['msg'])){
			// User has done a command
			include("./lib/irc.php");
			parse_irc_command(@$_GET['msg'],1);
		}

	}

	// The actual window which hardly does anything besides print the template
	function pm_base_frame(){
		global $x7s, $x7c, $print, $txt;

		include("./lib/message.php");

		// IE is retarded so we have to do this
		$_GET['send_to'] = eregi_replace("__ATSIGN__","@",$_GET['send_to']);

		echo $print->style_sheet;
		?>
		<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
		<html>
		<head>
		<title><?PHP echo $x7c->settings['site_name']; ?></title>
			<?PHP
				// Echo the styles
				echo $print->ss_chatinput;

				// Handle the $extra variable, used when the private message
				// is a support one
				if(isset($_GET['support']))
					$extra = "&support=1";
				else
					$extra = "";
			?>
			<script langauge="javascript" type="text/javascript">
				SelectorMenu = new Array();
				SelectorMenu['fontselector'] = 0;
				SelectorMenu['sizeselector'] = 0;
				fontTimeout = "";
				sizeTimeout = "";

				function doSelect(object){
					object.className = 'selected';
				}
				function doDeSelect(object){
					object.className = '';
				}

				function ClickedSelector(menu){
					popUpAddr = document.getElementById(menu).style
					if(SelectorMenu[menu] == 0){
						popUpAddr.visibility='visible';
						SelectorMenu[menu] = 1;
					}else{
						popUpAddr.visibility='hidden';
						SelectorMenu[menu] = 0;
					}
				}

				function closeMenu(menu){
					popUpAddr = document.getElementById(menu).style
					popUpAddr.visibility='hidden';
					SelectorMenu[menu] = 0;
				}

				function doClickFont(font){
					ClickedSelector('fontselector');
					document.chatIn.curfont.value=font;
				}

				function DoClickSize(in_font){
					ClickedSelector('sizeselector');

					in_font = in_font.replace(/[a-z]*$/i,"");

					if(in_font < <?PHP echo $x7c->settings['style_min_size']; ?>){
						in_font = "<?PHP echo $x7c->settings['style_min_size']; ?>";
					}

					<?PHP
					$max_size = $x7c->settings['style_max_size'];
					if($max_size != 0){
						echo "if(in_font > $max_size){\n
							in_font = \"$max_size\";\n
						}\n";
					}
					?>

					document.chatIn.cursize.value=in_font+" Pt";
				}

				function styleOut(object,name){
					ref = "itemh = document.chatIn."+name;
					eval(ref);
					if(itemh.value == 0){
						object.className='boldtxt';
					}
				}

				function styleClicked(object,name){
					ref = "itemh = document.chatIn."+name;
					eval(ref);
					if(itemh.value == 0){
						object.className='boldtxtdown';
						itemh.value = 1;
					}else{
						object.className='boldtxt';
						itemh.value = 0;
					}
				}

				function styleOver(object,name){
					ref = "itemh = document.chatIn."+name;
					eval(ref);
					if(itemh.value == 0){
						object.className='boldtxtover';
					}
				}

				function msgSent(){
					message = document.chatIn.msgi.value;
					document.chatIn.msg.value=message;
					if(message != ""){
						document.chatIn.msgi.value=''
						document.chatIn.msgi.focus();


						// Parse/Add styles
						color = document.chatIn.curcolor.value;
						size = document.chatIn.cursize.value;
						size = size.replace(" Pt","pt");
						font = document.chatIn.curfont.value;
						starttags = "<span style=\"font-family:"+font+"; color:"+color+"; font-size:"+size+"\">";
						endtags = "</span>";

						if(document.chatIn.bold.value == 1){
							starttags = starttags+"<b>";
							endtags = endtags+"</b>";
						}

						if(document.chatIn.italic.value == 1){
							starttags = starttags+"<i>";
							endtags = endtags+"</i>";
						}

						if(document.chatIn.under.value == 1){
							starttags = starttags+"<u>";
							endtags = endtags+"</u>";
						}

						// Inline styles
						// replace < tags
						message = message.replace(/</gi,"&lt;");

						// Match Size Tags
						while(message.match(/\[size=[^\]]*\][^\]]*\[\/size\]/i)){
							temp = message.match(/\[size=[^\]]*\]/i);
							temps = ""+temp;	// Convert to string
							temps = temps.replace(/\[size=/i,"");
							temps = temps.replace("]","");
							message = message.replace(/\[size=[^\]]*\]/i,"<span style=\"font-size: "+temps+"\">");
							message = message.replace(/\[\/size\]/i,"</span>");
						}

						// Match Color Tags
						while(message.match(/\[color=[^\]]*\][^\]]*\[\/color\]/i)){
							temp = message.match(/\[color=[^\]]*\]/i);
							temps = ""+temp;	// Convert to string
							temps = temps.replace(/\[color=/i,"");
							temps = temps.replace("]","");
							message = message.replace(/\[color=[^\]]*\]/i,"<span style=\"color: "+temps+"\">");
							message = message.replace(/\[\/color\]/i,"</span>");
						}

						// Match font Tags
						while(message.match(/\[font=[^\]]*\][^\]]*\[\/font\]/i)){
							temp = message.match(/\[font=[^\]]*\]/i);
							temps = ""+temp;	// Convert to string
							temps = temps.replace(/\[font=/i,"");
							temps = temps.replace("]","");
							message = message.replace(/\[font=[^\]]*\]/i,"<span style=\"font-family: "+temps+"\">");
							message = message.replace(/\[\/font\]/i,"</span>");
						}

						// Bold Italic and Unerline
						while(message.match(/\[b\][^\]]*\[\/b\]/i)){
							message = message.replace(/\[b\]/i,"<b>");
							message = message.replace(/\[\/b\]/i,"</b>");
						}

						while(message.match(/\[i\][^\]]*\[\/i\]/i)){
							message = message.replace(/\[i\]/i,"<i>");
							message = message.replace(/\[\/i\]/i,"</i>");
						}

						while(message.match(/\[u\][^\]]*\[\/u\]/i)){
							message = message.replace(/\[u\]/i,"<u>");
							message = message.replace(/\[\/u\]/i,"</u>");
						}

						//test = message.match(/\[size=(.+?)?\]/ig);
						//test = message.match(/\[size=[^\]]*\]/);

						<?PHP
						// Do Keyword parsing, Smilie parsing and filter parsing
						include("./lib/filter.php");
						$msg_filter = new filters();
						echo $msg_filter->filter_javascript();
						?>

						// Add styles to message
						message = starttags+message+endtags;

						timestamp = '';
						// Do timestamp
						<?PHP
							if($x7c->settings['disble_timestamp'] != 1){
								?>
										d = new Date();

										hours = ""+d.getHours();
										mins = ""+d.getMinutes();
										secs = ""+d.getSeconds();

										<?PHP
										// The following is a bunch of javascript that emulates the PHP's date() function to a small extent
										//  PHP date |	JAVASCRIPT variable
											$dc['a'] = "if(hours > 12)\njva = 'pm';\nelse\njva = 'am';\n\n";
											$dc['A'] = "if(hours > 12)\njvA = 'PM';\nelse\njvA = 'AM';\n\n";
											$dc['g'] = "if(hours > 12)\njvg = hours-12;\nelse\njvg = hours;\n\n";
											$dc['G'] = "jvG = hours;";
											$dc['h'] = "if(hours > 12)\njvh = ''+(hours-12);\nelse\njvh = ''+hours;\nif(jvh.length == 1)\njvh = '0'+jvh;\n\n";
											$dc['H'] = "jvH = hours;\nif(jvH.length == 1)\njvH = '0'+jvH;\n\n";
											$dc['i'] = "jvi = ''+mins;\nif(jvi.length == 1)\njvi = '0'+jvi;\n\n";
											$dc['s'] = "jvs = ''+secs;\nif(jvs.length == 1)\njvs = '0'+jvs;\n\n";
											$dc['U'] = "jvU = d.getTime()/1000;\n\n";

											// The dateformat (Using PHP syntax only a,A,g,G,h,H,i,s and U are supported)
											$df = $x7c->settings['date_format'];

											// THis will be printed, only the needed javascript from above will be added
											$script = "";

											// replace the PHP symbols in $df with the javascript counterpart
											foreach($dc as $phps=>$js){
												$olddf = $df;

												// Preserve any special characters that are back slashed
												$df = ereg_replace("\\\\$phps","o_2R\n08_f",$df);

												// DO the switch
												$df = ereg_replace("$phps","\"+jv{$phps}+\"",$df);

												// Restore those characters who were preserved
												$df = ereg_replace("o_2R\n08_f","$phps",$df);

												// If there was a change then we need this javascript printed
												if($olddf != $df)
													$script .= $js;
											}
										?>
										<?PHP echo $script; ?>
										timestamp = "[<?PHP echo $df; ?>]";
								<?PHP
							}
						?>

						// Put it into screen
						window.frames['main_window'].document.write('<span class="you"><?PHP echo $x7s->username; ?>'+timestamp+':</span> '+message+'<Br>');

						// Scroll the screen
						if(typeof(scrollBy) != "undefined"){
							window.frames['main_window'].window.scrollBy(0, 65000);
						}else{
							window.frames['main_window'].window.scroll(0, 65000);
						}
					}
				}

			</script>
			<?PHP echo $print->ss_pm; ?>
			<div align="center">

			<table border="0" width="428" cellspacing="1" cellpadding="1" class="pm_infobar">
				<tr>
					<td width="128" class="pm_ib_fc"><?PHP echo $_GET['send_to']; ?></td>
					<td width="75" class="pm_ib_r" onMouseOut="javascript: this.className='pm_ib_r';" onMouseOver="javascript: this.className='pm_ib_r_alt';" onClick="javascript: window.open('./index.php?act=view_profile&user=<?PHP echo $_GET['send_to']; ?>','','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width=<?PHP echo $x7c->settings['tweak_window_large_width']; ?>,height=<?PHP echo $x7c->settings['tweak_window_large_height']; ?>');"><?PHP echo $txt[87]; ?></td>
					<td width="75" class="pm_ib_r" onMouseOut="javascript: this.className='pm_ib_r';" onMouseOver="javascript: this.className='pm_ib_r_alt';" onClick="javascript: window.open('./index.php?act=userpanel&cp_page=msgcenter&to=<?PHP echo $_GET['send_to']; ?>','','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width=<?PHP echo $x7c->settings['tweak_window_large_width']; ?>,height=<?PHP echo $x7c->settings['tweak_window_large_height']; ?>');"><?PHP echo $txt[89]; ?></td>
					<td width="75" class="pm_ib_r" onMouseOut="javascript: this.className='pm_ib_r';" onMouseOver="javascript: this.className='pm_ib_r_alt';" onClick="javascript: window.open('./index.php?act=usr_action&action=ignore&user=<?PHP echo $_GET['send_to']; ?>&room=','','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width=<?PHP echo $x7c->settings['tweak_window_small_width']; ?>,height=<?PHP echo $x7c->settings['tweak_window_small_height']; ?>');window.close();"><?PHP echo $txt[91]; ?></td>
					<td width="75" class="pm_ib_r" onMouseOut="javascript: this.className='pm_ib_r';" onMouseOver="javascript: this.className='pm_ib_r_alt';" onClick="javascript: window.close();"><?PHP echo $txt[133]; ?></td>
				</tr>
			</table>

			<Br>
			<iframe name="send" style="visibility: hidden;" width="0" height="0" src="./index.php?act=pm&pmf=send&send_to=<?PHP echo $_GET['send_to']; ?>"></iframe>
			<iframe name="update" style="visibility: hidden;" width="0" height="0" src="./index.php?act=pm&pmf=update&send_to=<?PHP echo $_GET['send_to']; ?><?PHP echo $extra; ?>"></iframe>
			<iframe class="main_iframe" frameborder="0" name="main_window" width="428" height="150" src="./index.php?act=pm&pmf=null"></iframe>

			<form name="chatIn" method="get" action="index.php" target="send">
			<input type="hidden" name="act" value="pm">
			<input type="hidden" name="pmf" value="send">
			<input type="hidden" name="send_to" value="<?PHP echo $_GET['send_to']; ?>">
			<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height="10" colspan="11" width="10"><img src="<?PHP echo $print->image_path; ?>spacer.gif"></td>
				</tr>
				<tr valign="top">
					<td width="10">&nbsp;</td>
					<td width="95">
						<!-- Begin Select Area for Font -->
							<table border="0" cellspacing="0" cellpadding="0" class="nonSelected" onMouseOver="javascript: clearTimeout(fontTimeout);" onMouseOut="javascript: fontTimeout = setTimeout('closeMenu(\'fontselector\');',750);">
								<tr valign="middle">
									<td height="17" class="selectbar" onClick="javascript: ClickedSelector('fontselector');" onMouseOver="javascript: document.font_selector.src='<?PHP echo $print->image_path; ?>selectarrow_over.gif'" onMouseOut="javascript: document.font_selector.src='<?PHP echo $print->image_path; ?>selectarrow.gif'">&nbsp;<input type="text" readonly="true" name="curfont" value="<?PHP echo $x7c->settings['default_font']; ?>" class="curfont"></td>
									<td height="17" class="arrow_box" onClick="javascript: ClickedSelector('fontselector');" width="17"><img name="font_selector" src="<?PHP echo $print->image_path; ?>selectarrow.gif" onMouseOver="javascript: this.src='<?PHP echo $print->image_path; ?>selectarrow_over.gif'" onMouseOut="javascript: this.src='<?PHP echo $print->image_path; ?>selectarrow.gif'"></td>
								</tr>
							</table>
								<div id="fontselector" style="visibility: hidden;z-Index: 3;position: relative;top: 0px;left:0px;">
								<table border="0" cellspacing="0" cellpadding="0" class="nonSelected" onMouseOver="javascript: clearTimeout(fontTimeout);" onMouseOut="javascript: fontTimeout = setTimeout('closeMenu(\'fontselector\');',750);">
									<tr>
										<td height="15" width="81" onClick="javascript: doClickFont('<?PHP echo $txt[55]; ?>');" onMouseOver="javascript: doSelect(this);" onMouseOut="javascript: doDeSelect(this);">&nbsp;<?PHP echo $txt[55]; ?> &nbsp;</td>
									</tr>
									<tr>
										<td height="15" width="81" onClick="javascript: doClickFont('<?PHP echo $x7c->settings['default_font']; ?>');" onMouseOver="javascript: doSelect(this);" onMouseOut="javascript: doDeSelect(this)">&nbsp;<?PHP echo $x7c->settings['default_font']; ?></td>
									</tr>
									<tr>
										<td height="15" width="81" onClick="javascript: window.open('./index.php?act=sm_window&page=fonts','','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width=<?PHP echo $x7c->settings['tweak_window_small_width']; ?>,height=<?PHP echo $x7c->settings['tweak_window_small_height']; ?>');" onMouseOver="javascript: doSelect(this);" onMouseOut="javascript: doDeSelect(this)">&nbsp;<?PHP echo $txt[56]; ?></td>
									</tr>
								</table>
							</div>
						<!-- End Select Area for Font -->
					</td>

					<td width="75">
						<!-- Begin Select Area for Size -->
							<table border="0" cellspacing="0" cellpadding="0" class="nonSelected"   onMouseOver="javascript: clearTimeout(sizeTimeout);" onMouseOut="javascript: sizeTimeout = setTimeout('closeMenu(\'sizeselector\');',750);">
								<tr valign="middle">
									<td height="17" class="selectbar" onClick="javascript: ClickedSelector('sizeselector');" onMouseOver="javascript: document.size_selector.src='<?PHP echo $print->image_path; ?>selectarrow_over.gif'" onMouseOut="javascript: document.size_selector.src='<?PHP echo $print->image_path; ?>selectarrow.gif'">&nbsp;<input type="text" readonly="true" name="cursize" value="<?PHP echo $x7c->settings['default_size']; ?>" class="cursize"></td>
									<td height="17" class="arrow_box" onClick="javascript: ClickedSelector('sizeselector');" width="17"><img name="size_selector" src="<?PHP echo $print->image_path; ?>selectarrow.gif" onMouseOver="javascript: this.src='<?PHP echo $print->image_path; ?>selectarrow_over.gif'" onMouseOut="javascript: this.src='<?PHP echo $print->image_path; ?>selectarrow.gif'"></td>
								</tr>
							</table>

							<div id="sizeselector" style="visibility: hidden;z-Index: 3;position: relative;top: 0px;left:0px;">
								<table border="0" cellspacing="0" cellpadding="0" class="nonSelected"   onMouseOver="javascript: clearTimeout(sizeTimeout);" onMouseOut="javascript: sizeTimeout = setTimeout('closeMenu(\'sizeselector\');',750);">
									<tr>
										<td height="15" width="61" onClick="javascript: DoClickSize('10 Pt');" onMouseOver="javascript: doSelect(this)" onMouseOut="javascript: doDeSelect(this);">&nbsp;10 Pt</td>
									</tr>
									<tr>
										<td height="15" width="61" onClick="javascript: DoClickSize('12 Pt');" onMouseOver="javascript: doSelect(this)" onMouseOut="javascript: doDeSelect(this);">&nbsp;12 Pt</td>
									</tr>
									<tr>
										<td height="15" width="61" onClick="javascript: DoClickSize('14 Pt');" onMouseOver="javascript: doSelect(this)" onMouseOut="javascript: doDeSelect(this)">&nbsp;14 Pt</td>
									</tr>
									<tr>
										<td height="15" width="61" onClick="javascript: fontsize = prompt('<?PHP echo $txt[58]; ?>','');DoClickSize(fontsize);closeMenu('sizeselector');" onMouseOver="javascript: doSelect(this)" onMouseOut="javascript: doDeSelect(this)">&nbsp;<?PHP echo $txt[56]; ?></td>
									</tr>
								</table>
							</div>
						<!-- End Select Area for Size -->
					</td>

					<td width="92">
						<!-- Begin Select Area for Color -->
							<table border="0" cellspacing="0" cellpadding="0" class="nonSelected">
								<tr valign="middle">
									<td height="17" class="selectbar" onClick="javascript: window.open('./index.php?act=sm_window&page=colors','','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width=<?PHP echo $x7c->settings['tweak_window_small_width']; ?>,height=<?PHP echo $x7c->settings['tweak_window_small_height']; ?>');" onMouseOver="javascript: document.color_selector.src='<?PHP echo $print->image_path; ?>selectarrow_over.gif'" onMouseOut="javascript: document.color_selector.src='<?PHP echo $print->image_path; ?>selectarrow.gif'">&nbsp;<input type="text" readonly="true" name="curcolor" style="color: <?PHP echo $x7c->settings['default_color']; ?>;" value="<?PHP echo $x7c->settings['default_color']; ?>" class="curcolor"></td>
									<td height="17" class="arrow_box" onClick="javascript: window.open('./index.php?act=sm_window&page=colors','','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width=<?PHP echo $x7c->settings['tweak_window_small_width']; ?>,height=<?PHP echo $x7c->settings['tweak_window_small_height']; ?>');" width="17"><img name="color_selector" src="<?PHP echo $print->image_path; ?>selectarrow.gif" onMouseOver="javascript: this.src='<?PHP echo $print->image_path; ?>selectarrow_over.gif'" onMouseOut="javascript: this.src='<?PHP echo $print->image_path; ?>selectarrow.gif'"></td>
								</tr>
							</table>

						<!-- End Select Area for Color -->
					</td>

					<td width="20">
						<table border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="20" class="boldtxt" height="19" onClick="javascript: styleClicked(this,'bold')" onMouseOver="javascript: styleOver(this,'bold');" onMouseOut="javascript: styleOut(this,'bold');">
									<input type="hidden" name="bold" value="0"><b>B</b>
								</td>
							</tr>
						</table>
					</td>

					<td width="8">&nbsp;</td>

					<td width="20">
						<table border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="20" class="boldtxt" height="19" onClick="javascript: styleClicked(this,'italic')" onMouseOver="javascript: styleOver(this,'italic');" onMouseOut="javascript: styleOut(this,'italic');">
									<input type="hidden" name="italic" value="0"><i>I</i>
								</td>
							</tr>
						</table>
					</td>

					<td width="8">&nbsp;</td>

					<td width="20">
						<table border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="20" class="boldtxt" height="19" onClick="javascript: styleClicked(this,'under')" onMouseOver="javascript: styleOver(this,'under');" onMouseOut="javascript: styleOut(this,'under');">
									<input type="hidden" name="under" value="0"><u>U</u>
								</td>
							</tr>
						</table>
					</td>

					<td width="10">&nbsp;</td>

					<td width="21" height="17"><img src="<?PHP echo $print->image_path; ?>blanksmile.gif" class="smileybutton" onClick="javascript: window.open('./index.php?act=sm_window&page=smile','','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width=<?PHP echo $x7c->settings['tweak_window_small_width']; ?>,height=<?PHP echo $x7c->settings['tweak_window_small_height']; ?>');" onMouseOver="javascript: this.className='smileybuttonOver'" onMouseOut="javascript: this.className='smileybutton'"></td>

				</tr>
				<tr>
					<td width="10">&nbsp;</td>
					<td colspan="10">
						<div style="position: relative; top: -50px;z-index: 2;">
							<table border="0" cellspacing="0" cellpadding="0">
								<tr valign="middle">
									<td width="315" height="25" class="msginput_bg">
										<div align="center">
											<input type="text" name="msgi" class="msginput">
											<input type="hidden" name="msg" value="">
										</div>
									</td>
									<td width="5">&nbsp;</td>
									<!--<td><input type="image" src="<?PHP echo $print->image_path; ?>send.gif" onClick="javascript: msgSent();" style="cursor: pointer; cursor: hand;" onMouseOut="this.src='<?PHP echo $print->image_path; ?>send.gif'" onMouseOver="this.src='<?PHP echo $print->image_path; ?>send_over.gif'"></td>-->
									<td><input type="submit"  onClick="javascript: msgSent();" style="cursor: pointer; cursor: hand;background: url(<?PHP echo $print->image_path; ?>send.gif);border: none;height: 25px;width: 55px;text-align: center;font-weight: bold;" onMouseOut="this.style.background='url(<?PHP echo $print->image_path; ?>send.gif)'" onMouseOver="this.style.background='url(<?PHP echo $print->image_path; ?>send_over.gif)'" value="<?PHP echo $txt[181]; ?>"></td>
								</tr>
							</table>
						</div>
					</td>
				</tr>
			</table>
			</form>
			<Br><Br>
			<script language="javascript" type="text/javascript">
				<!-- Why do I do this?  Because IE is a piece of shit -->
				//document.write('');
				function execi(){
					document.getElementById("sounds").innerHTML = '<EMBED SRC="./sounds/enter.mid" AUTOSTART="FALSE" LOOP="FALSE" NAME="enter_snd" HIDDEN="true"></EMBED><EMBED SRC="./sounds/msg.mid" AUTOSTART="FALSE" LOOP="FALSE" NAME="msg_snd" HIDDEN="true"></EMBED>';
				}
				setTimeout('execi()','7500');
			</script>
			<div name="sounds" id="sounds"></div>
			</div>
			</body>
			</html>
		<?PHP
	}
?>
