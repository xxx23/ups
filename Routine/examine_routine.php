<?php

$env = php_sapi_name();
if($env == 'apache2handler' && $env != 'cli')
{
    die('Do not execute on browser!');
}

chdir(dirname($_SERVER['PHP_SELF']) );
require_once("../config.php");
require_once("../config.php");
require_once('../library/mail.php');

//query出還沒做測驗的
//需為線上測驗, 且有設定提醒, 帳號角色為學員, 現在日期需在測驗日期內
$sql = "create temporary table need_to_submit engine=memory
  	SELECT distinct bc.begin_course_name,bc.begin_course_cd ,pb.personal_id, pb.personal_name ,tcs.test_name ,tcs.test_no ,pb.email,tcs.d_test_end   
        FROM  test_course_setup tcs,begin_course bc,personal_basic pb,take_course tc,register_basic rg 
	WHERE tcs.begin_course_cd = bc.begin_course_cd AND tcs.begin_course_cd = tc.begin_course_cd AND pb.personal_id  = tc.personal_id AND
	      tcs.is_online = 1 AND tcs.remind = 1 AND pb.personal_id = rg.personal_id AND rg.role_cd = 3 AND 
	      NOW() BETWEEN tcs.d_test_beg AND tcs.d_test_end;";
db_query($sql);

$sql = "create temporary table submited engine=memory
        select distinct begin_course_cd,test_no,personal_id ,grade
	from test_course_ans";
db_query($sql);

$sql ="create temporary table resulted engine=memory
       select nts.begin_course_name,nts.personal_name,nts.d_test_end,nts.email ,nts.test_name , s.grade
       from need_to_submit nts left join submited s on nts.begin_course_cd = s.begin_course_cd and nts.test_no = s.test_no and 
       nts.personal_id = s.personal_id";
db_query($sql);


$sql = "select * from resulted where grade is null";
$mail_entry  = db_getAll($sql);
 
//print_r($mail_entry);
 

//exit;
//寄信給未做測驗的人
for($i = 0 ; $i < count($mail_entry) ; $i++){
	//set sender
	$from= 'elearning@hsng.cs.ccu.edu.tw';
	$fromName= '學習平台';

	//set message title and content
	$subject = "您在 {$mail_entry[$i]['begin_course_name']} 這門課程有測驗尚未繳交";
	$message = "
{$mail_entry[$i]['personal_name']}同學您好,
\n\n
您在 {$mail_entry[$i]['begin_course_name']} 這門課程有測驗尚未做完。
測驗名稱： {$mail_entry[$i]['test_name']}
測驗繳交期限： {$mail_entry[$i]['d_test_end']}

請盡速完成測驗，謝謝。

這是系統自動發出的信件，請勿回覆。

";

$message = nl2br($message);
$mailresult = mailto($from , $fromName, $mail_entry[$i]['email'], $subject, $message );

/*if($mailresult)
  echo "mail success.\n";
else
  echo "mail failed.\n";
 */
}

//echo 'done.';

?>

