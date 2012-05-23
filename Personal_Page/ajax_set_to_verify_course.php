<?php 
include('../config.php'); 
include('../session.php');
include('../library/filter.php');
require_once('../Apply_Course/lib.php') ; 
require_once('../library/mail.php') ;

$begin_course_cd = required_param('begin_course_cd', PARAM_INT);

$sql_check_exist = " SELECT count(*) FROM begin_course WHERE begin_course_cd=".$begin_course_cd; 
$num_rows = db_getOne($sql_check_exist); 


if( $num_rows != 0 ){
	//設定此課程狀態到為 p , (proccessing)
	$sql_content_cd = "UPDATE begin_course SET begin_coursestate='p' WHERE begin_course_cd=$begin_course_cd ";
	$result = db_query($sql_content_cd);
	echo 'ok';
	
	send_notify_mail($begin_course_cd);
	
}else  {
	echo 'fail';
}

return ;


function send_notify_mail($begin_course_cd) {
	global $MAIL_ADMIN_EMAIL;
	global $category4grouping ; 
	global $apply_org_table ; 
	global $HOMEURL, $WEBROOT;
//原本定義在 Apply_Course/lib.php 
	

	$get_category = " SELECT A.category, begin_course_name FROM register_applycourse A, begin_course B "
				 . " WHERE A.no=B.applycourse_no AND B.begin_course_cd=$begin_course_cd";
	$row = db_getRow($get_category) ; 
	
$notification_msg = "	
承辦人您好：
		課程 {$row['begin_course_name']} 已申請審核。
		請進入<a href=\"{$HOMEURL}{$WEBROOT}Apply_Course/\">課程管理系統</a>進行審核 。
";

	$to = $apply_org_table[ $category4grouping[$row['category'] ] ]['email'];
    
    if(is_array($to)){
        $mails = array();
        foreach($to as $email)
            if(!empty($email) && emailValidate($email))
                $mails[] = $email;

        $from =  $MAIL_ADMIN_EMAIL;  
        $fromName = "系統管理者"; 
        $subject = "課程申請審核通知";
        mailto( $from,  $fromName, $mails, $subject, $notification_msg ) ;    
    }
    else if( !empty($to) &&  emailValidate($to) ) {
		$from =  $MAIL_ADMIN_EMAIL;  
		$fromName = "系統管理者"; 
		$subject = "課程申請審核通知";
		mailto( $from,  $fromName, $to, $subject, $notification_msg ) ;
	}
}

?>
