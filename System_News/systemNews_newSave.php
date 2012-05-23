<?php
/*
DATE:   2006/12/13
AUTHOR: 14_不太想玩
*/
//error_reporting(E_All);
$RELEATED_PATH = "../";
set_time_limit(0);
require_once($RELEATED_PATH . 'config.php');
require_once($RELEATED_PATH . 'session.php');
require_once($RELEATED_PATH . 'library/mail.php');	
require_once('library.php');	
//add for pure html
require_once $RELEATED_PATH.'library/purifier/HTMLPurifier.auto.php';
$purifier = new HTMLPurifier();
//end

//人員編號	
$personal_id = $_SESSION["personal_id"];

//課程編號
$begin_course_cd = $_SESSION["begin_course_cd"];

//finishPage
$finishPage = $_POST["finishPage"];

//取得角色類型
$role_cd = db_getOne("SELECT role_cd FROM register_basic where personal_id="."$personal_id");

if($role_cd == 0) { // admin //系統公告
	//
	$FILE_PATH = gen_system_news_path($personal_id) ; 
}
elseif($role_cd == 1 || $role_cd == 2) { // 老師 助教 
	//課程公告
	//設定檔案儲存路徑
	$FILE_PATH = gen_course_news_path($begin_course_cd) ; 
}
else{
	echo "Error !!!";
	exit(0);
}

//判斷公告的類型(1.ㄧ般性 2.時限性 3.週期性)
$formType = $_POST["formType"];

//重要等級 //拿掉，所以改用default = 1 
//$important = $_POST["important"];	
$important = "1";	


//起始日期
$startYear 		= $_POST["startYear"];
$startMonth 	= $_POST["startMonth"];
$startDay 		= $_POST["startDay"];
$d_news_begin 	= $startYear . $startMonth . $startDay . "000000";

//結束日期
$endYear 		= $_POST["endYear"];
$endMonth 		= $_POST["endMonth"];
$endDay 		= $_POST["endDay"];
$d_news_end 	= $endYear . $endMonth . $endDay . "000000";

//週期設定
$cycleYear 		= $_POST["cycleYear"];
$cycleMonth 	= $_POST["cycleMonth"];
$cycleDay 		= $_POST["cycleDay"];
$d_cycle 		= $cycleYear . $cycleMonth . $cycleDay;

$cycleWeek 		= $_POST["cycleWeek"];

//過期處理方式
$handle = $_POST["handle"];
if(isset($handle) == false)	$handle = 1;

$news_type = $_POST['news_type'] ;

//公告標題
$subject = $_POST["subject"];
//你就會發現，MySQL除了字元長度以外，也算字數，而 varchar , char 算的是字數，不是佔用的byte數
//varchar(100)in mysql
//$subject = substr($subject,0,50);
$subject = mb_substr($subject,0,50,'utf-8');
$subject = stripslashes($subject);

//公告內容
$content = $_POST["content"];
$content = stripslashes($content);
$content = $purifier->purify($content);

//網址
$url = $_POST["url"];
$url = stripslashes($url);
if (substr($url,0,7) != "http://"){
    $url = "http://".$url;
}



//先預先取得一個news_cd
$randomNum = mt_rand(0, 10000000);
/*$sth = $DB_CONN->prepare('INSERT INTO news (subject) VALUES (?)');
$data = array($randomNum);
$res = $DB_CONN->execute($sth, $data);
if (PEAR::isError($res))	die($res->getMessage());
 */
 
$sth = db_query("INSERT INTO news (subject) VALUES ($randomNum)");

//從Table news取得新的news_cd
$res = db_query("SELECT news_cd FROM news WHERE subject=$randomNum");
/*if (PEAR::isError($res))	die($res->getMessage());*/
$res->fetchInto($row, DB_FETCHMODE_ASSOC);
$news_cd = $row[news_cd];

//上傳資料到Table news
$sth = db_query("UPDATE news SET if_news = '$formType', subject = '$subject', personal_id = '$personal_id', d_news_begin = '$d_news_begin', d_news_end = '$d_news_end', content = '$content', important = '$important', frequency = 0, d_cycle = '$d_cycle', week_cycle = '$cycleWeek', handle = '$handle' WHERE subject = '$randomNum'");

//VALUES ('$formType', '$subject', '$personal_id', '$d_news_begin', '$d_news_end', '$content', '$important', '0', '$d_cycle', '$cycleWeek', '$handle', '$randomNumi')');
//$res = $DB_CONN->execute($sth, $data);
//if (PEAR::isError($res))	die($res->getMessage());

//取得role_cd
session_start();
$role_cd = $_SESSION['role_cd'];
/*
//從Table register_basic取得role_cd
$res = $DB_CONN->query("SELECT role_cd FROM register_basic WHERE personal_id = $personal_id");
if (PEAR::isError($res))	die($res->getMessage());
$res->fetchInto($row, DB_FETCHMODE_ASSOC);
$role_cd = $row[role_cd];
*/

//上傳資料到news_target
$sth = db_query("INSERT INTO news_target (news_cd, role_cd, begin_course_cd, course_type) VALUES ('$news_cd', '$role_cd', '$begin_course_cd', '$news_type')");
/*$res = $DB_CONN->execute($sth, $data);
if (PEAR::isError($res))	die($res->getMessage());
 */

/*
echo "暫存檔：" . $_FILES['file']['tmp_name'] . "<br>";
echo "檔案名稱：" . $_FILES['file']['name'] . "<br>";  //上傳檔案名稱
echo "檔案大小：" . $_FILES['file']['size'] . "<br>";   //上傳檔案大小(Bytes)
echo "檔案類型：" . $_FILES['file']['type'] . "<br>";   //上傳檔案MIME類型
*/




//有檔案要上傳
if(!empty($_FILES['file']['tmp_name']) )
{	
				
	foreach($_FILES['file']['name'] as $file_index => $value) { // inspect looping 
		if($_FILES['file']['tmp_name'][$file_index] == '') 
			continue;
			
		//設定要上傳的資料
		$fileName = $_FILES['file']['name'][$file_index];		//檔案名稱
		$ext = strrchr( $fileName, '.' );			//副檔名
		$file_type = FILE_fileType($ext);			//檔案類型
		//$newFileName = $news_cd . "_" . $file_cd . $ext;	//新檔案名稱: 公告編號+ 檔案編號
		$newFileName = $news_cd .'_'.md5($_FILES['file']['name'][$file_index].time().$file_index) .$ext;				//新檔案名稱: 公告編號
		$fileUrl = $FILE_PATH . $newFileName;	//檔案的連結
		
		
		//上傳檔案到Server
		if( FILE_upload($_FILES['file']['tmp_name'][$file_index], $HOME_PATH.$FILE_PATH, $newFileName) == false) {	
			echo "FILE_upload fail";
			die();
		}
		
		//上傳資料到Table news_upload
		$sth = db_query("INSERT INTO news_upload (news_cd, file_name, file_type, news_file, file_url, if_url) VALUES ('$news_cd',' $fileName', '$file_type', '$newFileName', '$fileUrl', 0)");
	/*	$data = array($news_cd, $fileName, $file_type, $newFileName, $fileUrl, 0);
		$DB_CONN->execute($sth, $data);
     */	}
}

//有網址要上傳
if($url != "")
{
	//上傳資料到Table news_upload
	$sql = "INSERT INTO news_upload (
			news_cd, file_url, if_url
			) VALUES (
			$news_cd, '$url', '1' )";
	db_query($sql);
}

//notify user by mail 

if($role_cd == 0)
{
    $datas = db_getAll("SELECT email FROM personal_basic WHERE recnews='1'");
    $mails = array();
    foreach($datas as $data)
        $mails[$data['email']] = 1;

    //避免重複
    $mails = array_keys($mails);
   
    $subject_title = "[系統公告]";
    $auto_msg = "<br> <br> 這是系統自動發出的信件，請勿回覆。";        
    if(!empty($mails))
        foreach($mails as $userMail)
        {
            mailto(
                $MAIL_ADMIN_EMAIL,
                $MAIL_ADMIN_EMAIL_NICK,
                $userMail,
                $subject_title.$subject,
                $content.$auto_msg
            );
        }


}
elseif($role_cd == 1 || $role_cd==2)
{
    $courseData = db_getRow("SELECT * FROM begin_course WHERE begin_course_cd = '$begin_course_cd'");
    if($courseData['attribute']==0)//自學
    {
        $courseStus = db_getAll("
            SELECT personal_basic.email 
            FROM (SELECT * FROM take_course WHERE begin_course_cd = '$begin_course_cd') AS T
            LEFT JOIN personal_basic ON T.personal_id = personal_basic.personal_id
            WHERE personal_basic.recnews ='1' 
            AND NOW() BETWEEN T.course_begin AND T.course_end;");
        
    }
    else//教導
    {
        $courseStus = db_getAll("
            SELECT personal_basic.email 
            FROM (SELECT * FROM take_course WHERE begin_course_cd = '$begin_course_cd') AS T
            LEFT JOIN personal_basic ON T.personal_id = personal_basic.personal_id
            WHERE personal_basic.recnews ='1' 
            AND NOW() BETWEEN '{$courseData['d_course_begin']}' AND '{$courseData['d_course_end']}';");
    }

    $mails = array();
    foreach($courseStus as $stu)
    {
        $mails[$stu['email']] = 1;
    }
    $mails = array_keys($mails);

    $subject_title = "[課程公告:{$courseData['begin_course_name']}]";
    $auto_msg = "<br> <br> 這是系統自動發出的信件，請勿回覆。";        
    if(!empty($mails))
        foreach($mails as $userMail)
        {
             mailto(
                $MAIL_ADMIN_EMAIL,
                $MAIL_ADMIN_EMAIL_NICK,
                $userMail,
                $subject_title.$subject,
                $content.$auto_msg
            );
        }
}
else
{
    if($lang == 'zh_tw')
         die("權限錯誤");
    else
        die("Permissions Error");
}


//導向到finishPage
header("location: " . $finishPage);
?>
