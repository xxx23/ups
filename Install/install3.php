<?php
	
	// setting include path 
    $root_dir = dirname(dirname($_SERVER['SCRIPT_FILENAME']) );
	$path = $root_dir ."/library/Smarty/";
	$path .= PATH_SEPARATOR . $root_dir . '/library/PearDB/';
	set_include_path(get_include_path() . PATH_SEPARATOR . $path);
	include('Smarty.class.php');
	include('DB.php');



	$SHELL_SCRIPT_FILE = "install.sh";
	$CONFIG_FILE = "../config.php";
	
	if( is_writable($CONFIG_FILE) ){
		file_put_contents($CONFIG_FILE, create_config() );
	}else{
	  	if( filesize($CONFIG_FILE) == 0){
			header("Location: install2.php?info=nowritable"); 
			return ;
		}
	}
    
    //測試root密碼是否ok
	$dsn = array(
    'phptype'  => "mysql",
    'username' => 'root',
    'password' => $_POST['db_rootpassword'],
    'hostspec' => $_POST['db_host'],
	);

	$options = array(
	    'debug'       => 2,
	    'portability' => DB_PORTABILITY_ALL,
	);
	
	$DB_CONN = DB::connect($dsn, $options);
    if (PEAR::isError($DB_CONN))
    { 
        header("Location: install2.php?info=dbconnectionfail");
        return ;
    }

   /* if( !is_dbConnection_valid('root', $_POST['db_rootpassword'], $_POST['db_host']) ) {
		header("Location: install2.php?info=dbconnectionfail");
		return ;
   }*/

    //新增資料庫
    $sql = 'CREATE DATABASE IF NOT EXISTS elearning;';
    $r = $DB_CONN->query($sql);
    if(PEAR::isError($r))
    {
        if($DB_DEBUG)
            die($_SERVER['PHP_SELF'] . ': '.$r->getDebugInfo());
        else
            header("Location:".$WEBROOT."error.html");
    }

    //給使用者這個資料庫的管理權限
    $userName = $_POST['db_username'];
    $password = $_POST['db_userpassword'];
    $sql = "GRANT ALL PRIVILEGES ON elearning.* TO $userName@localhost IDENTIFIED BY '$password'";
    $r = $DB_CONN->query($sql);
    if(PEAR::isError($r))
    {
        if($DB_DEBUG)
            die($_SERVER['PHP_SELF'] . ': '.$r->getDebugInfo());
        else
            header("Location:".$WEBROOT."error.html");
    }
    $DB_CONN->disconnect();

    //使用者連線測試
	if( !is_dbConnection_valid($_POST['db_username'], $_POST['db_userpassword'], $_POST['db_host'], $_POST['db_name']) ) {
		header("Location: install2.php?info=dbconnectionfail");
		return ;
    }



	
	$smtpl = new Smarty;
	
	if(is_writable($_POST['data_file_path']))
		$smtpl->assign("DATA_FILE_PATH_WRITE","<font color=\"green\">可寫入</font>");
	else
		$smtpl->assign("DATA_FILE_PATH_WRITE","<font color=\"red\">不可寫入</font>");
		
	if(is_writable($_POST['course_file_path']))
		$smtpl->assign("COURSE_FILE_PATH_WRITE","<font color=\"green\">可寫入</font>");
	else
		$smtpl->assign("COURSE_FILE_PATH_WRITE","<font color=\"red\">不可寫入</font>");
		
	if(is_writable($_POST['media_file_path']))
		$smtpl->assign("MEDIA_FILE_PATH_WRITE","<font color=\"green\">可寫入</font>");
	else
		$smtpl->assign("MEDIA_FILE_PATH_WRITE","<font color=\"red\">不可寫入</font>");
	
	if(is_writable($_POST['personal_path']))
		$smtpl->assign("PERSONAL_PATH_WRITE","<font color=\"green\">可寫入</font>");
	else
		$smtpl->assign("PERSONAL_PATH_WRITE","<font color=\"red\">不可寫入</font>");
	
    if(is_writable($_POST['scorm_path']))
		$smtpl->assign("SCORM_PATH_WRITE","<font color=\"green\">可寫入</font>");
	else
		$smtpl->assign("SCORM_PATH_WRITE","<font color=\"red\">不可寫入</font>");
    
    if(is_writable($_POST['share_path']))
		$smtpl->assign("SHARE_PATH_WRITE","<font color=\"green\">可寫入</font>");
	else
		$smtpl->assign("SHARE_PATH_WRITE","<font color=\"red\">不可寫入</font>");

	$script0 = "mkdir {$_POST['data_file_path']}\n"."mkdir {$_POST['media_file_path']}\n"
        ."mkdir {$_POST['course_file_path']}\n"."mkdir {$_POST['personal_path']}\n"
        ." mkdir {$_POST['share_path']}\n"
        ;

	$script1 = "find {$_POST['home_path']} -depth -name templates_c -exec chgrp {$_POST['www_gid']} {} \;\n" ;
	$script2 = "find {$_POST['home_path']} -depth -name templates_c -exec chmod g+w {} \;\n" ;
	$script3 = "chmod g+w {$_POST['data_file_path']};\n" ;
	$script4 = "chgrp {$_POST['www_gid']} {$_POST['data_file_path']};\n" ;
	$script5 = "chmod g+w {$_POST['media_file_path']};\n" ;
	$script6 = "chgrp {$_POST['www_gid']} {$_POST['media_file_path']};\n" ;
	$script7 = "chmod g+w {$_POST['course_file_path']};\n" ;
	$script8 = "chgrp {$_POST['www_gid']} {$_POST['course_file_path']};\n" ;
	$script9 = "chmod g+w {$_POST['personal_path']};\n" ;
	$script10 = "chgrp {$_POST['www_gid']} {$_POST['personal_path']};\n" ;
	$script14 = "chmod g+w {$_POST['scorm_path']};\n" ;
	$script15 = "chgrp {$_POST['www_gid']} {$_POST['scorm_path']};\n" ;
	$script11 = "chmod 750 {$_POST['home_path']}config.php;\n" ;
	$script12 = "chgrp {$_POST['www_gid']} {$_POST['home_path']}config.php;\n" ;
    
    $script16 = "chmod g+w {$_POST['share_path']};\n" ;
	$script17 = "chgrp {$_POST['www_gid']} {$_POST['share_path']};\n" ;

	$script13 = schedular_cmd($_POST['php_path'], $_POST['home_path']);
	
	$script_all = $script0 . $script1 . $script2. $script3 . $script4 . $script5 
				. $script6 . $script7 . $script8 . $script9 . $script10 . $script14 . $script15 . $script11 . $script12 . $script13 . $script16 . $script17;
	
	$shell_script = "#! /bin/sh \n#\n" .$script_all ;
	
	// would overwrite old file
    file_put_contents($SHELL_SCRIPT_FILE, $shell_script );
    // execute
    exec('sh ./install.sh');
    // sleep
    sleep(2);
	chmod( $SHELL_SCRIPT_FILE , 0754 );
	
	$smtpl->assign("script1",$script1);
	$smtpl->assign("script2",$script2);
	$smtpl->assign("script3",$script3);
	$smtpl->assign("script4",$script4);
	$smtpl->assign("script5",$script5);
	$smtpl->assign("script6",$script6);
	$smtpl->assign("script7",$script7);
	$smtpl->assign("script8",$script8);
	$smtpl->assign("script9",$script9);
	$smtpl->assign("script10",$script10);
	$smtpl->assign("script11",$script11);
	$smtpl->assign("script12",$script12);
	$smtpl->assign("script13",$script13);
	$smtpl->assign("script14",$script14);
	$smtpl->assign("script15",$script15);

	$string = "請至{$_POST['home_path']}/Install資料夾下，以root權限執行$>./install.sh";
	$smtpl->assign("command",$string);
	$smtpl->assign("HOME_PATH", $_POST['home_path']);
	$smtpl->assign("DATA_FILE_PATH", $_POST['data_file_path']);
	$smtpl->assign("MEDIA_FILE_PATH",$_POST['media_file_path']);
	$smtpl->assign("COURSE_FILE_PATH",$_POST['course_file_path'] );
	$smtpl->assign("PERSONAL_PATH",$_POST['personal_path']);
    $smtpl->assign("SCORM_PATH",$_POST['scorm_path']);
    $smtpl->assign("SHARE_PATH",$_POST['share_path']);
	$smtpl->assign("WWW_GID", $_POST['www_gid']);
	$smtpl->display("./install3.tpl");
	return ;
	
function is_dbConnection_valid($name, $passwd, $host, $dbname){
		//connect to database
	$dsn = array(
    'phptype'  => "mysql",
    'username' => $name,
    'password' => $passwd,
    'hostspec' => $host,
    'database' => $dbname
	);

	$options = array(
	    'debug'       => 2,
	    'portability' => DB_PORTABILITY_ALL,
	);
	
	$DB_CONN = DB::connect($dsn, $options);
	if (PEAR::isError($DB_CONN)) return false;
	else return true;
}


function create_config() 
{ 
	global $_POST;
	
	$TAB = "\t";
ob_start();
	echo "<?php \n";
	echo '//System Begin Time' . "\n";
	echo $TAB.'$SYSTEM_BEGIN_YEAR = "' . date("Y") . '";' ."\n";
	echo $TAB.'$SYSTEM_BEGIN_MONTH = "' . date("m"). '";' ."\n";
	echo $TAB.'$SYSTEM_BEGIN_DAY = "' . date("d") .  '";' ."\n";
	echo "\n";
	echo '//Web Server Setting' ."\n";
	echo $TAB.'$HOST = "' . $_POST['host'] .'";' ."\n";
	echo $TAB.'$HOMEURL = "' .$_POST['homeurl'] . '";' . "\n";
	echo $TAB.'$WEBROOT = "' .$_POST['webroot'] . '";' . "\n";
	echo $TAB.'$HOME_PATH = "' . $_POST['home_path'] . '";' ."\n";
	echo "\n";
	echo '//database setting' . "\n";
	echo $TAB.'$DB_TYPE = "mysql";' . "\n";
	echo $TAB.'$DB_HOST = "' .$_POST['db_host'] . '";' . "\n";
	echo $TAB.'$DB_NAME = "' .$_POST['db_name'] . '";' . "\n";
	echo $TAB.'$DB_USERNAME = "' . $_POST['db_username'] . '";' . "\n";
	echo $TAB.'$DB_USERPASSWORD = "'. $_POST['db_userpassword'] . '";' . "\n";
	echo "\n";
	echo '//CSS' ."\n";
	echo $TAB.'$CSS_PATH = "' .$_POST['css_path']. '";' . "\n";
	echo '//JavaScript' . "\n";
	echo $TAB.'$JAVASCRIPT_PATH = "' .$_POST['javascript_path']. '";' . "\n";	
	echo '//Image' . "\n";
	echo $TAB.'$IMAGE_PATH = "' . $_POST['image_path'] . '";' . "\n";
	echo '//File' . "\n";
	echo $TAB.'$FILE_PATH = "file/";' . "\n";
	echo '//Theme' . "\n";
	echo $TAB.'$THEME_PATH = "'. $_POST['theme_path'] . '";' . "\n";
	echo '//Library' . "\n" ; 
	echo "\n";
	echo $TAB.'$LIBRARY_PATH = "' .$_POST['library_path'] . '";' .  "\n";	
	echo '//Teaching materials' . "\n";
	echo $TAB.'$DATA_FILE_PATH = "' . $_POST['data_file_path'] . '";' . "\n";
	echo '//Media for streaming' . "\n";
	echo $TAB.'$MEDIA_FILE_PATH = "' . $_POST['media_file_path'] . '";' . "\n";
	echo '//Course file' . "\n" ;
	echo $TAB.'$COURSE_FILE_PATH = "' .$_POST['course_file_path'] . '";' . "\n";
	echo '//Personal Directory' ."\n" ;
	echo $TAB.'$PERSONAL_PATH = "' .$_POST['personal_path'] . '";' . "\n";
	echo $TAB.'$WWW_GID = "' . $_POST['www_gid'] . '";' . "\n" ;
	echo "\n";
	echo '//FTP setting' . "\n";
	echo $TAB.'$FTP_IP = "' . $_SERVER['SERVER_ADDR'] . '";' . "\n";
	echo $TAB.'$FTP_PORT = "21";' . "\n";
	echo $TAB.'$MAX_UPLOAD_SIZE = "128";' . "\n";       
	echo "\n";
	echo '//utility settings' . "\n";
	echo $TAB.'$RAR_PATH = "' . $_POST['rar_path'] . '";' . "\n";
	echo $TAB.'$PHP_PATH = "' . $_POST['php_path'] . '";' . "\n";
	echo "\n";
	echo '//MAIL settings' . "\n";
	echo $TAB.'$MAIL_SMTP_HOST = "' . $_POST['mail_smtp_host'] . '";' . "\n";
	echo $TAB.'$MAIL_SMTP_HOST_PORT = "' . $_POST['mail_smtp_host_port'] . '";' . "\n";
	echo $TAB.'$MAIL_ADMIN_USER = "' . $_POST['mail_admin_user'] . '";' . "\n";
	echo $TAB.'$MAIL_ADMIN_PASSWROD = "' . $_POST['mail_admin_passwrod'] . '";' . "\n";
	echo $TAB.'$MAIL_ADMIN_EMAIL = "' . $_POST['mail_admin_email'] . '";' . "\n";
	echo $TAB.'$MAIL_ADMIN_EMAIL_NICK = "' . $_POST['mail_admin_email_nick'] . '";' . "\n";
	echo "\n";
	//Smarty , PearDB library , use as include_path 
	echo $TAB.'set_include_path( get_include_path() . PATH_SEPARATOR . $HOME_PATH.$LIBRARY_PATH."Smarty". PATH_SEPARATOR . $HOME_PATH.$LIBRARY_PATH."PearDB");' . "\n";
?>
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
?><?php	
$Buffer = ob_get_contents();	
ob_end_clean();
	return $Buffer;
}// end create_config


function schedular_cmd($php_path, $home_path)
{
	$sep = "\t";
	$schedular_crontab   =  "0".$sep."1".$sep."*".$sep."*".$sep."*".$sep."root".$sep." ".$php_path." -f ".$home_path."EPaper/schedule.php";
	$remind_HW_crontab   =  "0".$sep."0".$sep."*".$sep."*".$sep."*".$sep."root".$sep." ".$php_path." -f ".$home_path."Routine/homework_routine.php > /dev/null";
	$remind_TEST_crontab =  "0".$sep."0".$sep."*".$sep."*".$sep."*".$sep."root".$sep." ".$php_path." -f ".$home_path."Routine/examine_routine.php > /dev/null";
	$calculate_selfCourseEnd_crontab = "0".$sep."1".$sep."*".$sep."*".$sep."*".$sep."root".$sep." ".$php_path." -f ".$home_path."Grade/dailyUpdate.php >& /dev/null";
    $remind_COURSE_END_crontab = "0".$sep."1".$sep."*".$sep."*".$sep."*".$sep."root".$sep." ".$php_path." -f ".$home_path."Routine/course_end_alert_routine.php >& /dev/null";


    $cmd = "echo\t'$schedular_crontab' >> /etc/crontab;\n";	
	$cmd .= "echo\t'$remind_HW_crontab' >> /etc/crontab;\n";
	$cmd .= "echo\t'$remind_TEST_crontab' >> /etc/crontab;\n";
	$cmd .= "echo\t'$calculate_selfCourseEnd_crontab' >> /etc/crontab;\n";
    $cmd .= "echo\t'$remind_COURSE_END_crontab' >> /etc/crontab;\n"; 
    return $cmd;
}
?>
