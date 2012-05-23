<?php 
//此頁設定審核結果

require_once("../config.php");
require_once("session.php");
require_once('../library/filter.php');
require_once('lib.php');
require_once('../library/mail.php');

check_access("verify_course_list");

$begin_course_cd 	= required_param('begin_course_cd', PARAM_INT);
$pass 				= required_param('pass', PARAM_TEXT); 
$state_note 		= optional_param('state_note', '', PARAM_TEXT) ; 

//列出待審核之課程
//看begin_coursestate , char(1), 'p': 正在審核中 , 'n': 審核不通過, '1': 審核通過, '0': 還沒審核
if( $pass=='true') {
	$sql = "UPDATE begin_course SET begin_coursestate= '1'  WHERE begin_course_cd=$begin_course_cd";
	send_notify_mail($begin_course_cd);
}else {
	$sql = "UPDATE begin_course SET begin_coursestate='n', state_note='$state_note' WHERE begin_course_cd= $begin_course_cd"; 
}
	db_query($sql);

redirect('verify_course_list.php');  


//準備
function send_notify_mail($begin_course_cd) {

//通知開課 開課帳號 課程已經開好
	$sql_begincourse_email = "SELECT B.undertaker , B.email FROM begin_course A , register_applycourse B
		WHERE A.begin_course_cd = $begin_course_cd AND A.applycourse_no = B.no 
	"; 

	$begincourse_row = db_getRow($sql_begincourse_email);
$notification_msg = "	
開課帳號 {$begincourse_row['undertaker']} 您好：
		您開設的課程 {$row['begin_course_name']} , 已經通過審核了。
";
	
	$to = $begincourse_row['email'];
	
	if( !empty($to) &&  emailValidate($to) ) {
		$from =  $apply_org_table[ $_SESSION['category'] ]['email'] ;  
		$fromName = $apply_org_table[ $_SESSION['category'] ]['org_title']; 
		$subject = "課程審核通過通知";
		mailto( $from,  $fromName, $to, $subject, $notification_msg );
	}
	

//送給開課教師	
	$get_teacher = " SELECT personal_name , email, B.begin_course_name FROM teach_begin_course A, begin_course B, personal_basic C "
				 . " WHERE A.begin_course_cd=B.begin_course_cd AND A.teacher_cd=C.personal_id "
				 . " AND A.course_master=1";
	
	$row = db_getRow($get_teacher) ; 
	
$notification_msg = "	
老師您好：
		您的課程 {$row['begin_course_name']} , 已經通過審核了。
		您可以進入該課程，安排您的教學活動囉～
";
	
	$to = $row['email'];
	
	if( !empty($to) &&  emailValidate($to) ) {
		$from =  $apply_org_table[ $_SESSION['category'] ]['email'] ;  
		$fromName = $apply_org_table[ $_SESSION['category'] ]['org_title']; 
		$subject = "課程審核通過通知";
		mailto( $from,  $fromName, $to, $subject, $notification_msg );
	}
	
}
?>