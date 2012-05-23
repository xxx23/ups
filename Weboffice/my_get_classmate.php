<?php
/*
   author: rja
   這支程式是拿來給 mmc 查 某課程的全班同學的 姓名及email 用的，包括老師會放在第一個
   傳入參數是老師姓名及課程名稱
   先用老師姓名及課程名稱查 course_id
   有了 course_id 再查全班同學，這一步會較容易


 */
#error_reporting(256);

require_once("../config.php");
//require_once("../session.php");
require_once("../library/passwd.php");


$teacherName = $_REQUEST['teacherName'];
$courseName = $_REQUEST['courseName'];
$teacherName = (iconv(  "big5","utf-8",$teacherName));
$courseName = (iconv(  "big5","utf-8",$courseName));

//這個 sql 用來查 begin_course_cd, 傳入的參數是 teacher name 及 course name
$Q1 = "select bc.begin_course_cd begin_course_cd 
	from begin_course as bc , teach_begin_course as tbc, personal_basic as  pb
	where bc.begin_course_cd  = tbc.begin_course_cd and tbc.teacher_cd = pb.personal_id and 
	pb.personal_name = '$teacherName'  and bc.begin_course_name = '$courseName'";
//利用 getOne ，不知道會不會有沒想到的例外
$begin_course_cd = ( db_getOne($Q1));

//老師的資訊 (以後會有助教)
//可能會有很多老師及助教，我只取第一個老師的名字
$teaList = db_getTeacherAndTAList($begin_course_cd);
foreach($teaList as $value){
	if ($value['role_cd']==1)
		print urlencode($value['personal_name']) . '|' . ($value['email']) . "\n"; 
}

$studentInfo = db_getAllStudentInfo($coureId);
//學生的資訊 
if(!empty($studentInfo)){
	foreach ($studentInfo as $value){
		print urlencode($value['personal_name']) . '|' . ($value['email']) . "\n"; 
	}
}
//var_dump ( $teacherInfo);
?>
