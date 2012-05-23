<?php
/***
FILE:   config.php
DATE:   2006/12/13
AUTHOR: 14_不太想玩
CREATED BY: modifyConfigSave.php
CREATED DATE:{$createDate}
一些常用的宣告
***/

	//系統起始時間
	$SYSTEM_BEGIN_YEAR = "{$SYSTEM_BEGIN_YEAR}";
	$SYSTEM_BEGIN_MONTH = "{$SYSTEM_BEGIN_MONTH}";
	$SYSTEM_BEGIN_DAY = "{$SYSTEM_BEGIN_DAY}";

	//Web Server Setting
	$HOST = "{$WEB_SERVER_IP}";
	$HOMEURL = "{$WEB_HOME_URL}";
	$HOME_PATH = "{$WEB_HOME_PATH}";
	$ROOT = "{$ROOT}";
	
	//database setting
	$DB_TYPE = "{$DB_TYPE}";
	$DB_HOST = "{$DB_SERVER_IP}";
	$DB_USERNAME = "{$DB_USERNAME}";
	$DB_USERPASSWORD = "{$DB_USERPASSWORD}";
	$DB_NAME = "{$DB_NAME}";

	//CSS
	$CSS_VERSION = 2;
	$CSS_PATH = "{$CSS_PATH}";

{literal}
	switch($CSS_VERSION)
	{
	case 1:	$CSS_VERSION_PATH = "v1/";	break;
	case 2:	$CSS_VERSION_PATH = "v2/";	break;
	case 3:	$CSS_VERSION_PATH = "v3/";	break;
	default:	$CSS_VERSION_PATH = "v1/";	break;
	}
{/literal}

	//JavaScript
	$JAVASCRIPT_PATH = "{$JAVASCRIPT_PATH}";
	
	//Image
	$IMAGE_PATH = "{$IMAGE_PATH}";
	
	//File
	$FILE_PATH = "{$FILE_PATH}";
	
	//	
	$DATA_FILE_PATH = "/home/DataFile/";

	//Media for streaming
	$MEDIA_FILE_PATH = "/home/MediaFile/";

	//Course file
	$COURSE_FILE_PATH = "/home/CourseFile";

	//Library
	$LIBRARY_PATH = "{$LIBRARY_PATH}";


	//Smarty library
	require_once("Smarty.class.php");
	
	//Pear DB library
	require_once("DB.php");
	
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
	
	//big library
	require_once($LIBRARY_PATH . "big5_func/big5_func.inc");
	
	//Learning Tracking Setting
	$NOISE_TIME = 5;	//seconds
	
	
{literal}	
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


	/*author: lunsrot
	 * data: 2007/02/10
	 */
	function db_query($sql){
		global $DB_CONN;
		
		$r = $DB_CONN->query($sql);
		if(PEAR::isError($r))	die($r->getMessage());
		
		return $r;
	}
	
	/*author: lunsrot
	 *date: 2007/04/30
	 */
	function getCurTime(){
		$tmp = gettimeofday();
		$time = getdate($tmp['sec']);
		$date = $time['year']."-".$time['mon']."-".$time['mday']." ".$time['hours'].":".$time['minutes'].":".$time['seconds'];
		return $date;
	}

	/*author: sad man
	 * date: sad time
	 */	
	function update_status ( $status_now ) {
		global $DB_CONN;
		$status_now = addslashes( $status_now );
		//先判斷是否在某個課程中
		if(isset($_SESSION[begin_course_cd])){ //尚未點任何課程
			$sql = "UPDATE online_number SET status='" . $status_now . "', time='" . getCurTime() ."' WHERE personal_id='".$_SESSION[personal_id]."' AND host='".$_SESSION[personal_ip]."'";	
		}
		else{ //有點選課成
			$sql = "UPDATE online_number SET status='" . $status_now . "', time='" . getCurTime() ."' , begin_course_cd='".$_SESSION[begin_course_cd]."' WHERE personal_id='".$_SESSION[personal_id]."' AND host='".$_SESSION[personal_ip]."'";
		}
		$res = $DB_CONN->query($sql);
		if(PEAR::isError($res))	die($res->getMessage());					
	}

	/*author: lunsrot
	 * date: 2007/06/19
	 */
	function createPath($path){
		$old_mask = umask(0);
		if($path[ strlen($path) - 1 ] == '/')
			$path[ strlen($path) - 1 ] = "\0";
		$tmp = explode("/", $path);
		$target = "";
		for($i = 0 ; $i < count($tmp) ; $i++){
			$target .= $tmp[$i] . "/";
			if(!is_dir($target))
				mkdir($target, 0775);
		}
		umask($old_mask);
	}
{/literal}
?>
