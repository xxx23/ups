<?php 
//ini_set('display_errors', '1');
//error_reporting(E_ALL);
//System Begin Time
	$SYSTEM_BEGIN_YEAR = "2012";
	$SYSTEM_BEGIN_MONTH = "08";
	$SYSTEM_BEGIN_DAY = "03";

//Web Server Setting
	$HOST = "10.1.1.76";
	$HOMEURL = "http://10.1.1.76/";
	$WEBROOT = "/";
	$HOME_PATH = "/var/www/";

//database setting
	$DB_TYPE = "mysql";
	$DB_HOST = "localhost";
	$DB_NAME = "elearning";
	$DB_USERNAME = "hsng";
	$DB_USERPASSWORD = "ringline";

//CSS
	$CSS_PATH = "css/";
//JavaScript
	$JAVASCRIPT_PATH = "script/";
//Image
	$IMAGE_PATH = "images/";
//File
	$FILE_PATH = "file/";
//Theme
	$THEME_PATH = "themes/";
//Library

	$LIBRARY_PATH = "library/";
//Teaching materials
	$DATA_FILE_PATH = "/var/www/Data_File/";
//Media for streaming
	$MEDIA_FILE_PATH = "/var/www/Streaming_File/";
//Course file
	$COURSE_FILE_PATH = "/var/www/Course_File/";
//Personal Directory
	$PERSONAL_PATH = "/var/www/Personal_File/";
	$WWW_GID = "33";

//FTP setting
	$FTP_IP = "10.1.1.76";
	$FTP_PORT = "21";
	$MAX_UPLOAD_SIZE = "128";

//utility settings
	$RAR_PATH = "/usr/bin/rar";
	$PHP_PATH = "/usr/bin/php";

//MAIL settings
	$MAIL_SMTP_HOST = "localhost";
	$MAIL_SMTP_HOST_PORT = "25";
	$MAIL_ADMIN_USER = "";
	$MAIL_ADMIN_PASSWROD = "";
	$MAIL_ADMIN_EMAIL = "";
	$MAIL_ADMIN_EMAIL_NICK = "[教育部-教學平台管理者]";

	$UPS_ONLY = true;

	$USE_MYSQL = false;
	$USE_MONGODB = !$USE_MYSQL;

	set_include_path( get_include_path() . PATH_SEPARATOR . $HOME_PATH.$LIBRARY_PATH."Smarty". PATH_SEPARATOR . $HOME_PATH.$LIBRARY_PATH."PearDB");

	if($USE_MYSQL)
	{
		//Pear DB library
		require_once("DB.php");
		
		//connect to database
		$dsn = array(
		    'phptype'  => $DB_TYPE,
		    'username' => $DB_USERNAME,
		    'password' => $DB_USERPASSWORD,
		    'hostspec' => $DB_HOST,
		    'database' => $DB_NAME
		);

		$options = array(
		    'debug'       => 2,
		    'portability' => DB_PORTABILITY_ALL,
		);
		
		$DB_CONN = DB::connect($dsn, $options);
		if (PEAR::isError($DB_CONN))	die($DB_CONN->getMessage());

		//appended by puppy for avoiding encoding problem
		if ($DB_TYPE == "mysql")
		      $DB_CONN->query("SET NAMES 'utf8'");
	}
	else if($USE_MONGODB)
	{

		//Pear DB library
		require_once("DB.php");
		
		//connect to database
		$dsn = array(
		    'phptype'  => $DB_TYPE,
		    'username' => $DB_USERNAME,
		    'password' => $DB_USERPASSWORD,
		    'hostspec' => $DB_HOST,
		    'database' => $DB_NAME
		);

		$options = array(
		    'debug'       => 2,
		    'portability' => DB_PORTABILITY_ALL,
		);
		
		$DB_CONN = DB::connect($dsn, $options);
		if (PEAR::isError($DB_CONN))	die($DB_CONN->getMessage());

		//appended by puppy for avoiding encoding problem
		if ($DB_TYPE == "mysql")
		      $DB_CONN->query("SET NAMES 'utf8'");

		////////////////////////////////////////////////

		$m = new Mongo("mongodb://${DB_USERNAME}:${DB_USERPASSWORD}@localhost/elearning");

		// $m = new Mongo("mongodb://localhost:27017");
		$db = $m->elearning;
		// $db->authenticate($DB_USERNAME, $DB_USERPASSWORD);
	}
		    
	//Smarty library
	require_once("Smarty.class.php");
	
	//Zip library
	require_once($LIBRARY_PATH . "ziparchive.php");
	
	//MySqlDump library
	require_once($LIBRARY_PATH . "MySqlDump.php");
	
	//RSS library
	require_once($LIBRARY_PATH . "rss_generator.php");
	
	//common library
	require_once($LIBRARY_PATH . "common.php");
	
	//time library
	require_once($LIBRARY_PATH . "time.php");

	//file library
	require_once($LIBRARY_PATH . "file.php");
	
	//system library
	require_once($LIBRARY_PATH . "system.php");
	
	//pdf library
	require_once($LIBRARY_PATH . "fpdf/chinese.php");
	
	//big5 library
	require_once($LIBRARY_PATH . "big5_func/big5_func.inc");
	
	
	//Learning Tracking library
	require_once($LIBRARY_PATH . "learningTracking.php");
    
	//Learning Tracking Setting
	$NOISE_TIME = 5;	//seconds
?>
