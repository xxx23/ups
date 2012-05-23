<?php
/*
   author: rja
   這支程式是拿來跟 mmc 同步同一門課程的隨選視訊用的
   其實就是在按下"隨選視訊"時，去 mmc 同步錄影檔(隨選視訊)
 */

require_once("../config.php");
require_once("../session.php");
require_once("../library/common.php");

//error_reporting(256);


$Content_cd = get_Content_cd($_SESSION['begin_course_cd']);
$begin_course_cd = $_SESSION['begin_course_cd'];

global $user_id;

$Q1= "select begin_course_name from begin_course  where begin_course_cd  = $begin_course_cd"; 
$courseName  = db_getOne($Q1);
$courseName  = urlencode($courseName);
 
$synUrl = "http://ups.moe.edu.tw/mmc/my_get_on_line_video_syn.php?courseId=$begin_course_cd&courseName=$courseName";
$page = file_get_contents($synUrl);
//print $synUrl;
if (!empty($page)){

	$Q2 = "delete from on_line where rfile like 'http://ups.moe.edu.tw/mmc%' ";
	db_query($Q2);
}

if(preg_match('/^\d+\|@a/', $page) ){

	$allVodeoLink = explode("\n", $page);

    
    
    foreach ($allVodeoLink as $key => $value ){
		if (empty($value)) break;

		list($pubRecordingId, $teacherName, $courseName, $courseId, $subject, $date ) = explode('|@a' , $value);
		$subject = urldecode($subject);
		if (iconv('utf-8', 'utf-8', $subject) != $subject) {
			$subject = iconv("big5", "utf-8", $subject);
		}


		//這裡的 courseName 好像用不到
		//$courseName = urldecode($courseName);

		$pubUrl = "http://ups.moe.edu.tw/mmc/pub_recording_view.php?id=$pubRecordingId";
		$query = "INSERT INTO on_line ( content_cd , seq, d_course , subject , rfile )
			VALUES ( $Content_cd,NULL, '$date', '$subject', '$pubUrl'); ";

		db_query($query);
	}


}

?>

