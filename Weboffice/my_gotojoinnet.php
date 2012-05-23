<?php
/*
 * author: rja
 * access mmc service
 */

require_once("../config.php");
require_once("../session.php");
require_once("../library/passwd.php");

#require_once 'my_rja_db_lib.php';


ini_set('display_errors', 'on'); error_reporting(E_ALL);          

$begin_course_cd = $_SESSION['begin_course_cd'];
$personal_id = $_SESSION['personal_id'];
#global $DB_SERVER, $DB_LOGIN, $DB, $DB_PASSWORD;

$action = $_GET['action'];

if ($action =='stuCheckMeeting'){
	stuCheckMeeting();
}else if ($action =='meeting'){
	meeting();
}else if ($action =='reservation'){
	reservation();

}else if ($action =='recordingManagement'){
	recordingManagement();
}else if ($action =='gotoPrepareModeMeeting'){
	$meetingId = $_REQUEST['meetingId'];
	$courseName = urlencode($_REQUEST['courseName']);
	gotoPrepareModeMeeting($meetingId, $courseName);
}else if ($action =='gotoInstantMeeting'){
	$courseName = urlencode($_REQUEST['courseName']);
	gotoInstantMeeting( $courseName);
}else if ($action =='delReservation'){
	$meetingId = urlencode($_REQUEST['meetingId']);
	delReservation( $courseName);
}

?>

<?PHP

function recordingManagement(){
	global $begin_course_cd;
	global $personal_id;
	list($teacher_email, $teacher_pass)=getMailAndPasswd($personal_id);

	$course_name = db_getCourseName($begin_course_cd);
	$course_name = urlencode($course_name);
	$reservationUrl= "Location: http://ups.moe.edu.tw/mmc/t_get_joinnet.php?action=recordingManagement&email=$teacher_email&password=$teacher_pass&course_name=$course_name";
	//die($reservationUrl);

	header($reservationUrl);

}
function reservation(){
	global $begin_course_cd;
	global $personal_id;

	list($teacher_email, $teacher_pass)=getMailAndPasswd($personal_id);

	$course_name = db_getCourseName($begin_course_cd);
	$course_name = urlencode($course_name);
	$reservationUrl= "Location: http://ups.moe.edu.tw/mmc/t_get_joinnet.php?action=reservation&email=$teacher_email&password=$teacher_pass&course_name=$course_name";

	header($reservationUrl);

}

function meeting(){
	/*
	   先看一下老師這門課有沒有預約會議

	   if( !今天有會議)
	   開即時會議
	   else if 時間還沒到開始時間五分鐘內
	   print page : 選擇要進準備模式，還有參加會議，並印出提醒訊息，準備模式要重開
	   else 直接進入這門預約的會議

	 */
	global $begin_course_cd;
	global $personal_id;
	global $action;


	/*
	 * include 完這隻 my_reservation_list_proc.php ，應該就會拿到一個 $reservation_meeting 變數
	 * $reservation_meeting  這個變數記著一些 mmc 上的會議資訊
	 * (預設是從今天開始到半年內的會議，與教師所開的課名稱相同的預約會議)
	 * 
	 * */
	include("./my_reservation_list_proc.php");
	//var_dump( $reservation_meeting);

	$course_name = db_getCourseName($begin_course_cd);
	$nextMeetingOfToday = getNextMeetingOfToday($reservation_meeting, $course_name);

	if(empty($nextMeetingOfToday)){ 
		//今天沒會議，所以開即時會議
		gotoInstantMeeting($course_name);
	} else if( ( $nextMeetingOfToday['startTime'] - time() ) > 900 ){
		//時間還沒到開始時間 15 分鐘內
		$meetingOfToday = getAllMeetingOfToday($reservation_meeting, $course_name);
		printPreparePage($meetingOfToday);
		exit;
	} else {
		//今天有會議，而且時間已經到了，離開始時間五分鐘內也算時間到 ( 時間超過三小時內也 ok )
		$meetingId = $nextMeetingOfToday['meetingId'];
		gotoReservedMeeting($meetingId, $course_name);

	}



}

function printPreparePage($meetingOfToday){
	/*
	   預約會議: 若今天有預約會議，但老師點下"進入網路辦公室"時，時間在前15分鐘以前，則出現二個選項:
	   (接下來這是這支 function 要做的事)
	   1. 進入準備模式
	   (印出今日所有的會議是什麼時候，還有會議資訊 ，可能會進另一個會議的準備模式)
	   (紅字印出提醒文)

	   2. 開即時會議
	 */

	include_once("./my_reservation_list_print_table_lib.php");

	//var_dump( $reservation_meeting);

	echo "本門課程今日預約會議清單：";
	$listTable = editTableContent($meetingOfToday);
	printTable($listTable);

	echo '今日的會議預約時間還沒有到，您也可以選擇先進入"準備課程模式"，';
	echo '在"準備課程模式"中，您可以先上傳一些教材做會議前的準備，其它人不會進來打擾您。';
	echo '等會議時間一到，關掉"準備課程模式"再重新進入網路辦公室，會議的其它參與者就可以進來了。';
	echo '<p><font color="red">需要注意的是，在"準備課程模式"中，若到了會議預約時間，一定要記得重新進入網路辦公室';

	echo '，否則其他會議參與者無法進入你的預約會議。</font>';

	echo '<p>若您只是想開一個即時會議，可以';
	global $begin_course_cd;
	$Q1="select begin_course_name from begin_course where begin_course_cd = $begin_course_cd";
	$courseName = db_getOne($Q1);
	$courseName = urlencode($courseName);

	$instantMeetingUrl="<a href='./my_gotojoinnet.php?action=gotoInstantMeeting&courseName=$courseName'>
		按這裡就馬上開一個即時會議</a></p>";
	echo  $instantMeetingUrl;


}
function delReservation($course_name){
	global $begin_course_cd;
	global $personal_id;
	global $action;
	global $meetingId;

	list($teacher_email, $teacher_pass)=getMailAndPasswd($personal_id);

	//$find_course_name_sql = "select name from course where a_id = $begin_course_cd; ";
	//$course_name = db_getOne($find_course_name_sql);
	//$course_name = urlencode($course_name);

	header("Location: http://ups.moe.edu.tw/mmc/t_get_joinnet.php?action=delReservation&email=$teacher_email&password=$teacher_pass&myMeetingId=$meetingId");

}
function gotoInstantMeeting($course_name){
	global $begin_course_cd;
	global $personal_id;
	global $action;

	list($teacher_email, $teacher_pass)=getMailAndPasswd($personal_id);

	$course_name = db_getCourseName();

	$course_name = urlencode($course_name);
	$nextUrl = "Location: http://ups.moe.edu.tw/mmc/t_get_joinnet.php?action=instantMeeting&email=$teacher_email&password=$teacher_pass&course_name=$course_name";

	header($nextUrl);

}
function gotoReservedMeeting($meetingId, $course_name){
	global $begin_course_cd;
	global $personal_id;

	list($teacher_email, $teacher_pass)=getMailAndPasswd($personal_id);

	$course_name = db_getCourseName();
	$course_name = urlencode($course_name);

	header("Location: http://ups.moe.edu.tw/mmc/t_get_joinnet.php?action=gotoReservedMeeting&email=$teacher_email&password=$teacher_pass&course_name=$course_name&myMeetingId=$meetingId");

}
function gotoPrepareModeMeeting($meetingId, $course_name){
	//$course_name 可能沒用到
	global $begin_course_cd;
	global $personal_id;

	list($teacher_email, $teacher_pass)=getMailAndPasswd($personal_id);

	#$find_course_name_sql = "select name from course where a_id = $begin_course_cd; ";
	$course_name = db_getCourseName();
	$course_name = urlencode($course_name);

	header("Location: http://ups.moe.edu.tw/mmc/t_get_joinnet.php?action=gotoPrepareModeMeeting&email=$teacher_email&password=$teacher_pass&course_name=$course_name&myMeetingId=$meetingId");

}
function getMailAndPasswd($personal_id){
	$Q1 = "select email from personal_basic where personal_id= '$personal_id' ";
	$teacher_email=db_getOne($Q1);
	$Q2 = "select pass from register_basic where personal_id= '$personal_id' ";
	$encrypted_passwd=db_getOne($Q2);
	//cyber是明碼，不用 decrypt，ecourse則需要
	$teacher_pass=passwd_decrypt($encrypted_passwd);
	//$teacher_pass=($encrypted_passwd);


	return array($teacher_email, $teacher_pass);
}

// get next one meeting of today  in this courseName
function getNextMeetingOfToday($reservation_meeting, $courseName){
	//var_dump($reservation_meeting);


	foreach($reservation_meeting as $value){
		if( $value['courseName'] == $courseName)   {
			//startTime 離三小時內的會議就是下一個，如果已經過三小時的會議就不要了
			if (( date('Ymd',$value['startTime']) == date('Ymd'))&&(($value['startTime']) > (time()-10800))  ){
				//已經結束的會議也不要
				if( ! $value['finished'] and  ($value['endTime'] > time())  ){
					return $value;
				}
			}
		}

	}
}

// get all meeting of today  in this courseName
function getAllMeetingOfToday($reservation_meeting, $courseName){
	//var_dump($reservation_meeting);
	$allTodayMeeting = Array();


	foreach($reservation_meeting as $value){
		if( $value['courseName'] == $courseName)   {
			//startTime 離三小時內的會議就是下一個，如果已經過三小時的會議就不要了
			if ( date('Ymd',$value['startTime']) == date('Ymd') ){
				//已經結束的會議也不要
				if( ! $value['finished'] and  ($value['endTime'] > time())  ){
					$allTodayMeeting[]=$value;
				}
			}
		}

	}
	return $allTodayMeeting;
}

function stuCheckMeeting(){
	global $begin_course_cd;
	$course_name = db_getCourseName();
	$course_name = urlencode($course_name);


	$query_teacherid_from_coursename = "http://ups.moe.edu.tw/mmc/my_get_mmc_info.php?action=getOnlineTeacherByCourseName&course_name=$course_name";
	//print $query_teacherid_from_coursename;
	$onlineTeacherId = file_get_contents($query_teacherid_from_coursename);
	$onlineTeacherId = explode(',',$onlineTeacherId);
	$onlineTeacherId = (int)$onlineTeacherId[0];
	#var_dump($onlineTeacherId);

	//find user name from user id
	//讓進入會議時，自動輸入名單

	$my_user_name = db_getPersonalName();

	if(empty($my_user_name)){
		$my_user_name = $personal_id;
	}


	#	$my_query_teacher_name = "select  name from teach_course,user where teacher_id = user.a_id and  begin_course_cd = '{$begin_course_cd}' ";
	#	$my_teacher_name = db_getOne($my_query_teacher_name);
	//var_dump($my_teacher_name);

	//目前不考慮一個課程有二個以上的老師的情況，如果日後要考慮這種情況，就是把不同老師的姓名列出來，傳給 mmc，mmc 上另一支程式再 判斷哪個老師有開即時會議中
	//note: order by name desc 是一個暫用的 trick, cyber上的java5 有很多老師，我只想要先選非英文姓名的，暫時用一下
	//$Q1_ecourse_bak = "select name from teach_course as t1, user as t2 where begin_course_cd= '$begin_course_cd' and  t1.teacher_id = t2.a_id and authorization = 1 and t2.name !='name'  order by name desc ;  ";

	/* 
	 * 好像可以把下面這二個 block 放到後面的 if 去
	 * */

	//可能會有很多老師及助教，我只取第一個老師的名字
	$teaList = db_getTeacherAndTAList();
	foreach($teaList as $value){
		if ($value['role_cd']==1){
			$teacher_name = $value['personal_name'];
			break;
		}
	}


	//$teacher_name_encode = ($teacher_name);
	$teacher_name_encode = urlencode($teacher_name);
	//find meetingId from remote mmc
	$remoteUrl = "http://ups.moe.edu.tw/mmc/get_joinnet.php?teacher_name=$teacher_name_encode";
	$teacher_id=file_get_contents($remoteUrl);
	//var_dump( $teacher_id );


	if (!is_numeric($teacher_id) ) {
		echo("some thing wrong: return value is not numeric. <b>Debug code: $teacher_id, $teacher_name</b>");
	}                                             

	//error check
	if(is_numeric($onlineTeacherId) && $onlineTeacherId!=0){

		//老師在線上
		/* 
		 * 目前 cyber2 沒有 implement 下面這個 chat log 
		 */
		//先在 table log 中記下這次的聊天記錄
		//addLogChat();

		//把使用者導向 mmc 
		$my_joinmeeting_url = "http://ups.moe.edu.tw/mmc/gotomeeting.php?u=$onlineTeacherId&c=visit&name=$my_user_name";
		header("Location: $my_joinmeeting_url");

	}else{
		//老師不在線上
		$my_joinmeeting_url = "http://ups.moe.edu.tw/mmc/gotomeeting.php?u=$teacher_id&c=visit&name=$my_user_name";
		print "老師目前不在線上，也可以利用 joinnet <a href=\"{$my_joinmeeting_url}\">留言給老師</a>。";
		printHelpInfo();


	}



}

function addLogChat(){
	global $begin_course_cd;
	global $personal_id;
	$event = 4;
	$a_id = getAIDFromUserID($personal_id);
	#利用 ecourse 前人的 library function，我也不知道為什麼要用這麼麻煩的方法
	$now_time = get_now_time_str();
	if (! checkLogTimeValidation($a_id, $now_time))
		return ; 

	$sql = "INSERT INTO log (a_id, personal_id, event_id,  tag2, tag3, mtime ) values ('', $a_id, $event, '$begin_course_cd' , '1' , '$now_time')";
	#var_dump(($sql));
	$thisDB = 'study' . $begin_course_cd;
	query_db($sql, $thisDB);


}
function checkLogTimeValidation($a_id, $now_time){
	global $begin_course_cd;
	$sql = "select mtime from log where personal_id = '$a_id' and ( NOW() - mtime  < 10800)";
	//print $sql;
	//die;
	$result = (db_getOne($sql));
	if (!empty($result) )
		return false;
	else
		return true;

}



function printHelpInfo(){

?>
		<p>使用說明：我們的網路會議需要安裝 JoinNet 軟體來使用，JoinNet 為安裝於使用者端之免費軟體。
		在您安裝 JoinNet 軟體之後，您也可以利用執行測試精靈來確定您的電腦是否符合系統需求。</p>
		<table border="0" cellpadding="0" cellspacing="0">
		<tbody><tr>
		<td nowrap="true">
		<p>
		<a href="http://www.webmeeting.com.tw/download_joinnet.php" target="_blank"><img src="http://ups.moe.edu.tw/mmc/images/icon_download.gif" align="absmiddle" border="0" vspace="1" hspace="5">下載 JoinNet</a>

		</p>
		</td>
		</tr>
		<tr>
		<td nowrap="true">
		<p>
		<a href="http://ups.moe.edu.tw/mmc/joinnet_wizard.php"><img src="http://ups.moe.edu.tw/mmc/images/icon_test_wizard.gif" align="absmiddle" border="0" vspace="1" hspace="5">執行測試精靈						</a>
		</p>

		</td>
		</tr>
		</tbody></table>

<?php

}


?>
