<?php 
include('../config.php'); 
include('../session.php');
include('../library/filter.php');

$begin_course_cd 	= required_param('begin_course_cd', PARAM_INT);

$sql_check_exist = " SELECT state_note FROM begin_course WHERE begin_course_cd=".$begin_course_cd; 
$state_reason = db_getOne($sql_check_exist); 

echo $state_reason ; 
?>