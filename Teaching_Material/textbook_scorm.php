<?php
include('../config.php');
include('../session.php');
global $Teacher_cd;
global $smtpl;// for test
$smtpl=new Smarty();
$begin_course_cd=$_GET['begin_course_cd'];
$sql="select teacher_cd from teach_begin_course where begin_course_cd='$begin_course_cd'";
$teacher_cd=db_getOne($sql);
$smtpl->assign("begin_course_cd",$begin_course_cd);
$smtpl->assign("teacher_cd",$teacher_cd);

assignTemplate($smtpl, "/teaching_material/textbook_scorm.tpl");

?>
