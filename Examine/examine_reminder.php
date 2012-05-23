<?php
require_once("../config.php");
require_once("../session.php");

require_once(  '../library/mail.php');

#Global $DB_CONN;
$test_no = $_REQUEST['test_no'];
$begin_course_cd = $_SESSION['begin_course_cd'];
//var_dump($begin_course_cd);
//var_dump($test_no);

$sql = "select begin_course_name from begin_course where begin_course_cd = $begin_course_cd";
$begin_course_name = db_getOne($sql);
//var_dump($course_name);


$sql = " SELECT rb.login_id login_id, pb.email email, pb.personal_name personal_name
FROM  take_course tc, personal_basic pb, register_basic rb
where tc.begin_course_cd = $begin_course_cd and tc.personal_id = pb.personal_id  and pb.personal_id = rb.personal_id
and tc.personal_id not in 
(select tc.personal_id 
from test_course_setup tcs, test_course_ans tca
where tcs.begin_course_cd = $begin_course_cd and tcs.test_no = $test_no 
and tcs.begin_course_cd = tca.begin_course_cd and tcs.test_no = tca.test_no)

 ";
//print $sql. '<br />';
$mail_list = db_getAll($sql);
//print_r($mail_list);

$get_test_info_sql = " 
select tcs.test_name test_name, tcs.d_test_end d_test_end
from test_course_setup tcs
where tcs.begin_course_cd = $begin_course_cd and tcs.test_no = $test_no 
";

$mail_entry = db_getAll($get_test_info_sql);
//print 'mail_entry here:';
//print_r($mail_entry);


$from= 'elearning@hsng.cs.ccu.edu.tw';
$fromName= '學習平台';

$subject = "您在 $begin_course_name 這門課程有測驗尚未繳交";
$message = "
同學您好,
\n\n
您在 $begin_course_name 這門課程有測驗尚未做完。
測驗名稱： {$mail_entry[0]['test_name']}
測驗繳交期限： {$mail_entry[0]['d_test_end']}

請盡速完成測驗，謝謝。

這是系統自動發出的信件，請勿回覆。

";
$message = nl2br($message);

$output=Array();
//print $message;
foreach($mail_list as $value){
$output[] = $v;
	if (!empty($value['email']))
		$to[]=$value['email'];
}

//var_dump($to);
//var_dump($subject);
//var_dump($message);
mailto($from , $fromName, $to, $subject, $message );



$tpl = new Smarty;
$tpl->assign('mail_list', $mail_list);
assignTemplate($tpl, "/examine/examine_reminder.tpl");

print 'ok';
?>

