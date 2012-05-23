<?PHP
///////////////////////////////////////////////////////////////
//
//		X7 Chat Version 2.0.5
//		Released Jan 6, 2007
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
	// First we need to set up a nice environment
	error_reporting(E_ALL);
	set_magic_quotes_runtime(0);

	// Import the configuration file
	include("./config.php");

	// Import the database library
	include("./lib/db/".strtolower($X7CHAT_CONFIG['DB_TYPE']).".php");

	// Create a new database connection
	$db = new x7chat_db();

	// Check for GD
	if(function_exists("imagecreatefrompng")){
		// Defaults
		$size_x = "auto";
		$size_y = "auto";
		$font_size = "12";
		$number = 0;
		$red = $blue = $green = 0;
		$bg_red = $bg_blue = $bg_green = 255;
		$font = "./fonts/font";

		// Get the number of people online
		$exptime = time()-30;
		$query = $db->DoQuery("SELECT DISTINCT name FROM {$prefix}online WHERE invisible<>'1' AND time>'$exptime'");
		$number = mysql_num_rows($query);

		// Parse user input to see if they want anything different
		if(isset($_GET['size_x']))
			$size_x = $_GET['size_x'];
		if(isset($_GET['size_y']))
			$size_y = $_GET['size_y'];
		if(isset($_GET['font_size']))
			$font_size = $_GET['font_size'];
		if(isset($_GET['red']))
			$red = $_GET['red'];
		if(isset($_GET['blue']))
			$blue = $_GET['blue'];
		if(isset($_GET['green']))
			$green = $_GET['green'];
		if(isset($_GET['bg_red']))
			$bg_red = $_GET['bg_red'];
		if(isset($_GET['bg_blue']))
			$bg_blue = $_GET['bg_blue'];
		if(isset($_GET['bg_green']))
			$bg_green = $_GET['bg_green'];

		// Calculate image Size
		if($size_x == "auto"){
			$size_x = strlen($number)*intval($font_size);
		}
		if($size_y == "auto"){
			$size_y = intval($font_size)+2;
		}
		putenv('GDFONTPATH=' . realpath('.'));
		$counter = imagecreate($size_x,$size_y);
		$number = strval($number);

		$bg_color = imagecolorallocate($counter,$bg_red,$bg_green,$bg_blue);
		imagefill($counter,0,0,$bg_color);
		$color = imagecolorallocate($counter,$red,$green,$blue);
		imagettftext($counter,$font_size,0,0,($size_y-1),$color,$font,$number);
		header("Content-type: image/png");
		imagepng($counter);
	}else{
		echo "You do not have the GD Library Installed";
	}
?>
