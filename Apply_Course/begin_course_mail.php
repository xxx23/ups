<?php
/***
FILE:   
DATE:   
AUTHOR: zqq
**/

$RELEATED_PATH = "../";
require_once($RELEATED_PATH . "config.php");
require_once("session.php");
//update_status ( "確認開課中" );
$template = $_SESSION['template_path'] . $_SESSION['template'];
$tpl_path = "../themes/" . $_SESSION['template'];
	
//echo "<pre>". print_r($_GET, true)."</pre>";

//系統設定檔名稱
$CONFIG_FILE = "../config.xml";


if( file_exists($CONFIG_FILE) == true)
{
	$dom = new DOMDocument();
	$dom->load($CONFIG_FILE);	
	//Web Server Setting

	$old_WEB_HOME_URL = $dom->getElementsByTagName("WEB_HOME_URL")->item(0)->nodeValue;	
}

//查出admin的 mail 
$sql = "SELECT p.email FROM register_basic r, personal_basic p 
		WHERE r.personal_id=p.personal_id and r.login_id='admin'";
$adm_email = $DB_CONN->getOne($sql);

$data = $_GET;

$sql = "SELECT * FROM begin_course WHERE begin_course_cd='".$data[begin_course_cd]."'";
$res = $DB_CONN->query($sql);
if (PEAR::isError($res))	die($res->getMessage());	
$course = $res->fetchRow(DB_FETCHMODE_ASSOC);	

for($i=0; $i<sizeof($data[personal_id]);$i++){
	$sql = "SELECT * FROM personal_basic WHERE personal_id='".$data[personal_id][$i]."'";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());	
	$personal = $res->fetchRow(DB_FETCHMODE_ASSOC);		
	// subject
	$subject = "[重要]". $course[begin_course_name] ."開課確認信";
	
	// message
	$message = "
	<html>
	<head>
	  <title>[重要]". $course[begin_course_name] ."開課確認信</title>
	</head>
	<body>
	  <p>".$personal[personal_name]."老師你好。</p>
	  <p>系統已經為你開設了".$course[begin_course_name]."這門課，請到 <a href=140.123.105.16>系統</a>確認。</p>
	  <p align='left'>謝謝。</p>
	  <p>系統開課管理者敬上 ".date("Y-m-d H:i")."</p>
	</body>
	</html>
	";
	$to = $personal[email];
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=big5' . "\r\n";
	
	// Additional headers
	$headers .= "To: ".$personal[personal_name]." <".$personal[email].">" . "\r\n";
	
		
	$headers .= "From: 系統開課管理者  <". $adm_email .">\r\n";
	//$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
	//$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";	
	// Mail it
	//mail($to,$subject, $message, $headers);
	//echo $message;
	mail(iconv("UTF-8","big5",$to), iconv("UTF-8","big5",$subject), iconv("UTF-8","big5",$message), iconv("UTF-8","big5",$headers));
	echo "信件已寄出";
}			
//------function area---------

?>
