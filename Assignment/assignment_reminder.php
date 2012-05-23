<?php
require_once("../config.php");
require_once("../session.php");

require_once(  '../library/mail.php');

#Global $DB_CONN;
$homework_no = $_REQUEST['homework_no'];
$begin_course_cd = $_SESSION['begin_course_cd'];
//var_dump($begin_course_cd);
//var_dump($homework_no);

$sql = "select begin_course_name from begin_course where begin_course_cd = $begin_course_cd";
$begin_course_name = db_getOne($sql);
//var_dump($course_name);


$sql = "SELECT rb.login_id as login_id, email, personal_name,homework_name, d_dueday  
FROM homework hk,handin_homework hh, personal_basic pb ,register_basic rb
where hk.homework_no = hh.homework_no and hh.handin_time is NULL  and hh.homework_no = $homework_no 
and hh.personal_id = pb.personal_id and hh.personal_id = rb.personal_id ";
$mail_entry = db_getAll($sql);
//print_r($mail_entry);
//print_r($_SESSION);
//die;



$from= 'elearning@hsng.cs.ccu.edu.tw';
$fromName= '學習平台';

$subject = "您在 $begin_course_name 這門課程有作業尚未繳交";
$message = "
同學您好,
\n\n
您在 $begin_course_name 這門課程有作業尚未繳交。
作業名稱： {$mail_entry[0]['homework_name']}
作業繳交期限： {$mail_entry[0]['d_dueday']}

請盡速繳交，謝謝。

這是系統自動發出的信件，請勿回覆。

";
$message = nl2br($message);

$output=Array();
//print $message;
foreach($mail_entry as $value){
$output[] = $v;
	if (!empty($value['email']))
		$to[]=$value['email'];
}

//var_dump($to);
mailto($from , $fromName, $to, $subject, $message );



$tpl = new Smarty;
$tpl->assign('ass_data', $mail_entry);
assignTemplate($tpl, "/assignment/homework_reminder.tpl");

?>

