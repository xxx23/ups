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

    if (!eregi("modules.php", $_SERVER['PHP_SELF'])) {
	die ("You can't access this file directly...");
    }

   $module_name = basename(dirname(__FILE__));

    include("header.php");
    OpenTable();
    	echo '	<script language="javascript" type="text/javascript">
			window.open("http://x7chat.com/Nuke/Chat/","Chat");
		</script>
		Chat will load in a new window......';
    CloseTable();
    include("footer.php");

?>