<?php 
//System Begin Time
	$SYSTEM_BEGIN_YEAR = "2008";
	$SYSTEM_BEGIN_MONTH = "04";
	$SYSTEM_BEGIN_DAY = "16";

//Web Server Setting
	$HOST = "140.123.105.16";
	$HOMEURL = "http://140.123.105.16/";
	$WEBROOT = "/~tkraha/";
	$HOME_PATH = "/home/tkraha/WWW/";

//database setting
	$DB_TYPE = "mysql";
	$DB_HOST = "localhost";
	$DB_NAME = "elearning2009";
	$DB_USERNAME = "elearning2009";
	$DB_USERPASSWORD = "elearning2009";

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
	$DATA_FILE_PATH = $HOME_PATH."Data_File/";
//Media for streaming
	$MEDIA_FILE_PATH = $HOME_PATH."Streaming_File/";
//Course file
	$COURSE_FILE_PATH = $HOME_PATH."Course_File/";
//Personal Directory
	$PERSONAL_PATH = $HOME_PATH."Personal_File/";
	$WWW_GID = "80";

//FTP setting
	$FTP_IP = "140.123.105.16";
	$FTP_PORT = "21";
	$MAX_UPLOAD_SIZE = "128";

//utility settings
	$RAR_PATH = "/usr/local/bin/rar";
	$PHP_PATH = "/usr/local/bin/php";

//MAIL settings
	$MAIL_SMTP_HOST = "localhost";
	$MAIL_SMTP_HOST_PORT = "25";
	$MAIL_ADMIN_USER = "";
	$MAIL_ADMIN_PASSWROD = "";
	$MAIL_ADMIN_EMAIL = "";
	$MAIL_ADMIN_EMAIL_NICK = "[中正大學-教學平台管理者]";
    
//NKNU SQL server MSSQL connect setting
    $NKNU_DB_HOST = 'NKNUDB';
    $NKNU_DB_USER = 'Hsngccu';
    $NKNU_DB_PASSWD = 'Cyber3elearning';
    $NKNU_DATABASE = 'course_Hsngccu';
    $NKNU_TABLE = 'course';



    set_include_path( get_include_path() . PATH_SEPARATOR . $HOME_PATH.$LIBRARY_PATH."Smarty". PATH_SEPARATOR . $HOME_PATH.$LIBRARY_PATH."PearDB");
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
