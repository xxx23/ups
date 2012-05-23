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
if (!defined('CPG_NUKE')) { exit; }   

global $userinfo;
 setcookie("X7C2U", $userinfo['username']);
 setcookie("X7C2P", $userinfo['user_password']);  
    include("header.php");
    
    OpenTable();
    	echo 'Rooms will load in a new window...... <br><center><IFRAME SRC="x7chat/index.php" TITLE="Visioneer Chat" WIDTH="460" HEIGHT="600" (frame height)></IFRAME></center>';
     CloseTable();
    include("footer.php");

?>