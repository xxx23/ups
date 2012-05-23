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

	// This is used for small popup windows to display specific help info
	if(!isset($_GET['help_file']) || !@is_file("./{$_GET['help_file']}") || eregi("[\\/]","{$_GET['help_file']}")){
		$_GET['help_file'] = "main";
	}
	
	// Load the help definitions
	include("./help/{$_GET['help_file']}");
	
	// Check for default values
	if(!isset($_GET['q']) || !isset($mini[$_GET['q']]))
		$_GET['q'] = "Main";
		
	$head = "X7 Chat 2 Quick Help";
	$body = $mini[$_GET['q']];
	
	// Link keywords
	foreach($word_reps as $key=>$val){
		$body = eregi_replace("$key","<a href=\"$val\">$key</a>",$body);
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
			
			INPUT {
				background: url(./help/help/images/input_bg.png);
				border: 1px solid #8F8F8F;
				font-family: arial, helvetica, sans-serif;
				font-size: 12px;
				height: 20px;
				vertical-align: center;
				padding-left: 2px;
			}
		</style>
	<head>
	<body>
		<table width="95%" height="95%" align="center" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="100%">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr valign="center">
							<td height="25" width="35" style="text-align: center;background: url(./help/images/body_tl.png);">&nbsp;</td>
							<td height="25" style="font-size: 16px;background: url(./help/images/body_tm.png);">&nbsp;&nbsp;<b><?PHP echo $head; ?></td>
							<td height="25" style="background: url(./help/images/body_tr.png);" width="25">&nbsp;</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr valign="top">
				<td width="100%" height="100%" style="padding: 1px;border: 1px solid black;border-bottom: none;background: #f1f2f6;"><?PHP echo $body; ?></td>
			</tr>
			<tr>
				<td width="100%">
					<table border="0" cellspacing="0" cellpadding="0" width="100%">
						<tr>
							<td width="75" height="25" style="background: url(./help/images/body_bl.png);">&nbsp;</td>
							<td height="25" style="background: url(./help/images/body_bm.png);">&nbsp;</td>
							<td height="25" width="75" style="background: url(./help/images/body_br.png);">&nbsp;</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	<Br><br>
	<?PHP
	print("<div align=\"center\">Powered By X7 Chat 2 &copy; 2004 By The X7 Group></div>");
	?>
	</body>
</html>
