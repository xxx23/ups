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
	// The massive help files, english only unless someone else translates it :)
	// This file mixes HTML and PHP a lot, its not structured like any of the other files because of its size and purpose
	
	if(!isset($_GET['help_file']) || !@is_file("./{$_GET['help_file']}") || eregi("[\\/]","{$_GET['help_file']}")){
		$_GET['help_file'] = "main";
	}
	
	// Load the help definitions
	include("./{$_GET['help_file']}");

	// Check for default values
	if(!isset($_GET['s']) || !isset($help[$_GET['s']]))
		$_GET['s'] = "Main";
	
	if(!isset($_GET['t']) || !isset($help[$_GET['s']][$_GET['t']]))
		$_GET['t'] = "Main";
	
	$head = eregi_replace("_"," ",$_GET['s'])." - ".eregi_replace("_"," ",$_GET['t']);
	$body = $help[$_GET['s']][$_GET['t']];
	
	// Link keywords
	foreach($word_reps as $key=>$val){
		$body = eregi_replace("$key","<a href=\"$val\">$key</a>",$body);
	}
	
	// See if they want to search
	if(isset($_POST['q']) && @$_POST['q'] != ""){
		$head = "Search";
		
		// Add a menu item for search
		$_GET['t'] = "Search";
		$help['Main']['Search'] = "";
		
		// Look for results
		$sr = array();
		$i = 0;
		$q = $_POST['q'];
		$highlight = explode(" ",$q);
		
		foreach($help as $key=>$val){
			foreach($val as $title=>$body){
				
				$i++;
				$sr[$i] = array(
							"Rel"=>"0",
							"Subject"=>"$key",
							"Topic"=>"$title",
							"Minitext"=>"",
						);
						
				// Check title for word +.75 is equal
				if($title == $q){
					$sr[$i]["Rel"] += 0.75;
					$sr[$i]["Minitext"] = substr($body,0,150);
				}
				
				// Check for equalling subject
				if($key == $q){
					$sr[$i]["Rel"] += 0.5;
					$sr[$i]["Minitext"] = substr($body,0,150);
				}
				
				foreach($highlight as $hkey=>$hval){
					
					// Check title for word, +.25 if in it
					if(eregi(preg_quote("$hval"),"$title")){
						$sr[$i]["Rel"] += 0.25;
						$sr[$i]["Minitext"] = substr($body,0,150);
					}
					
					// Check subject for word, +.20 if in it
					if(eregi(preg_quote("$hval"),"$key")){
						$sr[$i]["Rel"] += 0.20;
						$sr[$i]["Minitext"] = substr($body,0,150);
					}
					
					while(eregi(preg_quote("$hval"),$body)){
						$sr[$i]["Rel"] += 0.10;
						$sr[$i]["Minitext"] = substr($body,0,150);
						
						$body = eregi_replace(preg_quote("$hval"),"",$body);
					}
					
				}
				
				
			}
		}
		
		
		$body = "";
		array_multisort($sr,SORT_ASC);
		$sr = array_reverse($sr);
		// Display the results
		foreach($sr as $key=>$val){
			if($val["Rel"] != 0){
				
				$val["Minitext"] = eregi_replace("<b>","",$val["Minitext"]);
				$val["Minitext"] = eregi_replace("</b>","",$val["Minitext"]);
				$val["Minitext"] = eregi_replace("<br>.*","",$val["Minitext"]);
				foreach($highlight as $hkey=>$hval){
					$val["Minitext"] = eregi_replace(preg_quote("$hval"),"<b>$hval</b>",$val["Minitext"]);
				}
				
				$body .= "<a href=\"index.php?s={$val["Subject"]}&t={$val["Topic"]}&help_file=$_GET[help_file]\">{$val["Subject"]} -> {$val["Topic"]}</a></b><Br>{$val["Minitext"]} ...<Br><br>";
			}
		}
		
		if($body == "")
			$body = "Your search did not return any results.";
	}
	
	// Load the menu
	$menu = "";
	foreach($help as $key=>$val){
	
		if($key == $_GET['s']){
			// Load topics for this one also
			$menu .= "<div align=\"center\" onMouseOut=\"javascript: this.style.background='url(./images/menu_bg.gif)'\" onMouseOver=\"javascript: this.style.background='url(./images/menu_bg.gif)'\" style=\"text-align: left;font-weight: bold;cursor: hand;cursor: pointer;height: 16px;background: url(./images/menu_bg.gif);\" onClick=\"javascript: document.location='./index.php?s=$key&help_file=$_GET[help_file]';\"> &nbsp; $key</div>";
			
			foreach($val as $key2=>$val2){
				
				if($_GET['t'] == $key2)
					$menu .= "<div align=\"center\" onMouseOut=\"javascript: this.style.background='url(./images/menu_bg3.gif)'\" onMouseOver=\"javascript: this.style.background='url(./images/menu_bg3.gif)'\" style=\"text-align: left;cursor: hand;cursor: pointer;height: 16px;background: url(./images/menu_bg3.gif);\" onClick=\"javascript: document.location='./index.php?s=$key&t=$key2&help_file=$_GET[help_file]';\"> &nbsp; &nbsp; &nbsp; $key2</div>";
				else
					$menu .= "<div align=\"center\" onMouseOut=\"javascript: this.style.background='#f1f2f6'\" onMouseOver=\"javascript: this.style.background='url(./images/menu_bg3.gif)'\" style=\"text-align: left;cursor: hand;cursor: pointer;height: 16px\" onClick=\"javascript: document.location='./index.php?s=$key&t=$key2&help_file=$_GET[help_file]';\"> &nbsp; &nbsp; &nbsp; $key2</div>";
				
			}
		}else{
			// Just link it
			$menu .= "<div align=\"center\" onMouseOut=\"javascript: this.style.background='#f1f2f6'\" onMouseOver=\"javascript: this.style.background='url(./images/menu_bg.gif)'\" style=\"text-align: left;font-weight: bold;cursor: hand;cursor: pointer;height: 16px\" onClick=\"javascript: document.location='./index.php?s=$key&help_file=$_GET[help_file]';\"> &nbsp; $key</div>";
		}
		
	}
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/transitional.dtd">
<html>
	<head>
		<title>X7 Chat Help Center</title>
		<META NAME="COPYRIGHT" CONTENT="Copyright 2004 By The X7 Group">
		<META HTTP-EQUIV="Content-Type" content="text/html; charset=iso-8859-1">
		<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
		<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
		<LINK REL="SHORTCUT ICON" HREF="../favicon.ico">
		<style type="text/css">
			TD {
				font-family: arial, helvetica, sans-serif;
				font-size: 12px;
			}
			
			BODY {
				font-family: arial, helvetica, sans-serif;
				font-size: 12px;
			}
			
			A {
				font-family: arial, helvetica, sans-serif;
				font-size: 12px;
				color: #334570;
				text-decoration: none;
			}

			A:hover {
				color: #264eab;
				text-decoration: underline;
			}

			A:active {
				color: #ff0000;
				text-decoration: underline;
			}
			
			.serch_box {
				background: url(./images/input_bg.png);
				border: 1px solid #8F8F8F;
				font-family: arial, helvetica, sans-serif;
				font-size: 12px;
				height: 20px;
				vertical-align: center;
				padding: 0px;
				padding-left: 2px;
				margin: 0px;
			}
			
			.serch_button {
				background: #bbbbbb;
				background-image: url(./images/input_bg.png);
				border: 1px solid #8F8F8F;
				margin: 0px;
				font-family: arial, helvetica, sans-serif;
				font-size: 12px;
				padding: 0px;
				height: 20px;
				width: 45px;
			}
		</style>
	<head>
	<body topmargin="0" marginheight="0" leftmargin="0" marginwidth="0">
		<table	width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr valign="top">
				<td height="125" width="500" style="border-bottom: 1px solid black;background: url(./images/logo.png);cursor: pointer;cursor: hand;" onClick="javascript: document.location = 'index.php';">&nbsp;</td>
				<td height="125" style="border-bottom: 1px solid black;background: url(./images/header.png)">&nbsp;</td>
				<td height="125" width="250" style="border-bottom: 1px solid black;background: url(./images/steps.png)">
					<br>
					<div width="100%" style="text-align: center;font-weight: bold;font-size: 16px;">Search</div>
					<div align="center"><Br><Br>
						<form action="index.php?act=search&help_file=<?PHP echo $_GET['help_file']; ?>" method="post">
							<table border="0" cellspacing="0" cellpadding="0">
								<tr valign="center">
									<td>
										<input type="text" class="serch_box" name="q" value="<?PHP @print($_POST['q']);?>">
									</td>
									<td width="5">&nbsp;</td>
									<td>
										<input type="submit" value="Go" class="serch_button">
									</td>
								</tr>
							</table>
						</form>
					</div>
				</td>
			</tr>
		</table>
		<br><Br>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
			<tr valign="top">
				<td width="200">
					<table width="95%" align="center" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="100%">
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr valign="center">
										<td height="25" width="35" style="text-align: center;background: url(./images/body_tl2.png);">&nbsp;</td>
										<td height="25" style="font-size: 16px;background: url(./images/body_tm.png);">&nbsp;&nbsp;<b>Main Menu</td>
										<td height="25" style="background: url(./images/body_tr.png);" width="25">&nbsp;</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td width="100%" style="padding: 1px;border: 1px solid black;border-bottom: none;background: #f1f2f6;"><?PHP echo $menu; ?></td>
						</tr>
						<tr>
							<td width="100%">
								<table border="0" cellspacing="0" cellpadding="0" width="100%">
									<tr>
										<td width="75" height="25" style="background: url(./images/body_bl.png);">&nbsp;</td>
										<td height="25" style="background: url(./images/body_bm.png);">&nbsp;</td>
										<td height="25" width="75" style="background: url(./images/body_br.png);">&nbsp;</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
				<td>
					<table width="95%" align="center" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="100%">
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr valign="center">
										<td height="25" width="35" style="text-align: center;background: url(./images/body_tl.png);">&nbsp;</td>
										<td height="25" style="font-size: 16px;background: url(./images/body_tm.png);">&nbsp;&nbsp;<b><?PHP echo $head; ?></b></td>
										<td height="25" style="background: url(./images/body_tr.png);" width="25">&nbsp;</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td width="100%" style="padding: 10px;border: 1px solid black;border-bottom: none;background: #f1f2f6;"><?PHP echo $body; ?></td>
						</tr>
						<tr>
							<td width="100%">
								<table border="0" cellspacing="0" cellpadding="0" width="100%">
									<tr>
										<td width="75" height="25" style="background: url(./images/body_bl.png);">&nbsp;</td>
										<td height="25" style="background: url(./images/body_bm.png);">&nbsp;</td>
										<td height="25" width="75" style="background: url(./images/body_br.png);">&nbsp;</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><Br><br>
	<?PHP
	print("<div align=\"center\">Powered By <a href=\"http://www.x7chat.com/\" target=\"_blank\">X7 Chat</a> 2 &copy; 2004 By The <a href=\"http://www.x7chat.com/\" target=\"_blank\">X7 Group</a>$theme_c</div>");
	?>
	</body>
</html>
