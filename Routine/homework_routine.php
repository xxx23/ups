<?php

$env = php_sapi_name();
if($env == 'apache2handler' && $env != 'cli')
{
    die('Do not execute on browser!');
}

chdir(dirname($_SERVER['PHP_SELF']) );
require_once("../config.php");
require_once('../library/mail.php');


//select出各個作業在deadline前還沒繳交作業人的名單
$sql = "SELECT hw.begin_course_cd,bc.begin_course_name,personal_name,homework_name,hw.d_dueday,remind,email
  	FROM homework hw , handin_homework hh , personal_basic pb , begin_course bc
	WHERE hh.personal_id = pb.personal_id AND hw.homework_no = hh.homework_no AND 
	hw.begin_course_cd = bc.begin_course_cd AND remind = 1 AND hw.d_dueday > NOW() AND
       	hh.handin_time is NULL 	
	";

$mail_entry = db_getAll($sql);
print_r($mail_entry);
die;


//寄信給在deadline前還沒繳交作業的人
for($i = 0; $i < count($mail_entry); $i++){
  
$from= 'elearning@hsng.cs.ccu.edu.tw';
$fromName= '學習平台';
$subject = "您在 {$mail_entry[$i]['begin_course_name']} 這門課程有作業尚未繳交";
$message = "
        {$mail_entry[$i]['personal_name']}同學您好,
	\n\n
	您在 {$mail_entry[$i]['begin_course_name']} 這門課程有作業尚未繳交。
	作業名稱： {$mail_entry[$i]['homework_name']}
作業繳交期限： {$mail_entry[$i]['d_dueday']}

請盡速繳交，謝謝。

這是系統自動發出的信件，請勿回覆。

";

$message = nl2br($message);
$mailresult = mailto($from , $fromName, $mail_entry[$i]['email'], $subject, $message );

/*if ($mailresult) 
  echo "mail success.\n";
else 
  echo "mail failed.\n";
 */
}
?>

