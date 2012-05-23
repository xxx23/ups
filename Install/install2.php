<?php
	$root_dir = dirname(dirname($_SERVER['SCRIPT_FILENAME']) );

	$path = $root_dir."/library/Smarty/";
	$path2 = $root_dir."/library/PearDB/";
	set_include_path(get_include_path() . PATH_SEPARATOR . $path. PATH_SEPARATOR. $path2);
	
	include("Smarty.class.php");
	include('libs.php');
	

	
	// initial default settings 
	$SYSTEM_BEGIN_YEAR		= date("Y");
	$SYSTEM_BEGIN_MONTH		= date("m");
	$SYSTEM_BEGIN_DAY		= date("d");
	
	if( !empty($_SERVER['SERVER_NAME']) ){
		$HOST = $_SERVER["SERVER_NAME"];
	}else{
		$HOST = $_SERVER['SERVER_ADDR'];
	}
	
	if( dirname(dirname($_SERVER['REQUEST_URI'])) == "/")
		$url_path = "/";
	else 
		$url_path = dirname(dirname($_SERVER['REQUEST_URI']))."/";	
	
	if( !file_exists('../config.php') ) {
		die("please touch config.php at directory: ". $root_dir.'/');
	}
	
	// using as default value if config.php is empty 
		$HOMEURL			= "http://$HOST$url_path";
		$HOME_PATH         		= $root_dir."/";
		$WEBROOT			= $url_path;
		$CSS_PATH			= "css/";
		$JAVASCRIPT_PATH		= "script/";
		$IMAGE_PATH			= "images/"; 
		$THEME_PATH			= "themes/";
		$LIBRARY_PATH			= "library/";
		
		$DATA_FILE_PATH			= $HOME_PATH."Data_File/"; 
		$MEDIA_FILE_PATH		= $HOME_PATH."Streaming_File/";
		$COURSE_FILE_PATH		= $HOME_PATH."Course_File/";
        $PERSONAL_PATH 			= $HOME_PATH."Personal_File/";
        $SCORM_PATH             = $HOME_PATH."Teaching_Material/scorm/nccudata/";
        $SHARE_PATH             = $HOME_PATH."Share_File/";
		$WWW_GID			= posix_getgid();
		
		// RAR path 
		$RAR_PATH			= get_utility_path("rar", $PATHS);
		
		//php path 
		$PHP_PATH			= get_utility_path("php", $PATHS);
		
		//Mail 
		$MAIL_SMTP_HOST			= "localhost";
		$MAIL_SMTP_HOST_PORT		= "25";
		$MAIL_ADMIN_USER		= ""; // default empty  , mean no need authorized 
		$MAIL_ADMIN_PASSWROD		= "";
		$MAIL_ADMIN_EMAIL		= "";
		//$MAIL_ADMIN_EMAIL_NICK  = 'E-learning Administrator';
		$MAIL_ADMIN_EMAIL_NICK  = '[教育部-教學平台管理者]';
		
		//FTP 
		$FTP_IP				= $_SERVER['SERVER_ADDR'];
		$FTP_PORT			= 21;
		$MAX_UPLOAD_SIZE		= "128MB";
		
		//DB
		$DB_TYPE			= "MYSQL";
		$DB_HOST			= "localhost"; 
		$DB_USERNAME			= "username";
		$DB_USERPASSWORD		= "password";
		$DB_NAME			= "elearning";
		$MAX_LOGIN_LOG_LENGTH 		= 1000;

	$smtpl = new Smarty;
	
	$smtpl->assign("SYSTEM_BEGIN_YEAR",$SYSTEM_BEGIN_YEAR);
	$smtpl->assign("SYSTEM_BEGIN_MONTH",$SYSTEM_BEGIN_MONTH);
	$smtpl->assign("SYSTEM_BEGIN_DAY",$SYSTEM_BEGIN_DAY);
	$smtpl->assign("HOST",$HOST);
	$smtpl->assign("HOMEURL",$HOMEURL);
	$smtpl->assign("WEBROOT",$WEBROOT);
	$smtpl->assign("HOME_PATH",$HOME_PATH);
	$smtpl->assign("CSS_PATH",$CSS_PATH);
	$smtpl->assign("JAVASCRIPT_PATH",$JAVASCRIPT_PATH);
	$smtpl->assign("IMAGE_PATH",$IMAGE_PATH);
	$smtpl->assign("DATA_FILE_PATH",$DATA_FILE_PATH);
	$smtpl->assign("MEDIA_FILE_PATH",$MEDIA_FILE_PATH);
	$smtpl->assign("COURSE_FILE_PATH",$COURSE_FILE_PATH);
	$smtpl->assign("LIBRARY_PATH",$LIBRARY_PATH);
	$smtpl->assign("PERSONAL_PATH",$PERSONAL_PATH);
    $smtpl->assign("SCORM_PATH",$SCORM_PATH);
    $smtpl->assign("SHARE_PATH",$SHARE_PATH);
	$smtpl->assign("THEME_PATH",$THEME_PATH);
	$smtpl->assign("WWW_GID",$WWW_GID);
	//RAR 
	$smtpl->assign("RAR_PATH",$RAR_PATH);
	//PHP_PATH
	$smtpl->assign("PHP_PATH",$PHP_PATH);
	//Mail 
	$smtpl->assign("MAIL_SMTP_HOST",$MAIL_SMTP_HOST);
	$smtpl->assign("MAIL_SMTP_HOST_PORT",$MAIL_SMTP_HOST_PORT);
	$smtpl->assign("MAIL_ADMIN_USER", $MAIL_ADMIN_USER);
	$smtpl->assign("MAIL_ADMIN_PASSWROD", $MAIL_ADMIN_PASSWROD);
	$smtpl->assign("MAIL_ADMIN_EMAIL", $MAIL_ADMIN_EMAIL);
	$smtpl->assign("MAIL_ADMIN_EMAIL_NICK", $MAIL_ADMIN_EMAIL_NICK);
	//FTP
	$smtpl->assign("FTP_IP",$FTP_IP);
	$smtpl->assign("FTP_PORT",$FTP_PORT);
	$smtpl->assign("MAX_UPLOAD_SIZE",$MAX_UPLOAD_SIZE);
	//DB
	$smtpl->assign("DB_TYPE",$DB_TYPE);
	$smtpl->assign("DB_HOST",$DB_HOST);
	$smtpl->assign("DB_USERNAME",$DB_USERNAME);
	$smtpl->assign("DB_USERPASSWORD",$DB_USERPASSWORD);
	$smtpl->assign("DB_NAME",$DB_NAME);


	// do error display 
	if( $_GET['info'] == "nowritable") {
		$smtpl->assign("nowritable", 1);
	}else if($_GET['info'] == "dbconnectionfail"){
		$smtpl->assign("dbconnectionfail", 1);
	}
	
	$smtpl->display("./install2.tpl");	
?>
