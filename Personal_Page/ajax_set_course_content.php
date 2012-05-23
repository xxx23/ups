<?php 
include('../config.php'); 
include('../session.php');
include('../library/filter.php');

$content_cd			= required_param('content_cd', PARAM_INT);
$begin_course_cd 	= required_param('begin_course_cd', PARAM_INT);



$sql_check_exist = " SELECT count(*) FROM class_content_current WHERE begin_course_cd=".$begin_course_cd; 
$num_rows = db_getOne($sql_check_exist); 

if( $num_rows != 0 ) 
	$sql_content_cd = "UPDATE class_content_current SET content_cd=$content_cd WHERE begin_course_cd=$begin_course_cd "; 
else 
	$sql_content_cd = " INSERT INTO class_content_current (begin_course_cd, content_cd ) VALUES ($begin_course_cd, $content_cd) ; ";


$result = db_query($sql_content_cd);

if( !PEAR::isError($result) )
	echo 'ok';
else 
	echo 'fail';
?>