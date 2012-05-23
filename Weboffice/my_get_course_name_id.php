<?php

require_once("../config.php");
//require_once("../session.php");
require_once("../library/passwd.php");
require_once("../library/common.php");


//$name= iconv( "utf-8", "big5",$_GET['name']);
$name= $_GET['name'];


// $name = iconv("utf-8","big5",  $name);

//var_dump($name);

//$name='黃仁竑';

 $Q1 = "select personal_id from personal_basic where personal_name = '$name'; ";
        $personalId = db_getOne($Q1);

if (empty($personalId)) die;

//$Q1 = "select  distinct course.name as name,  course.a_id as id  from user,teach_course as tc,course, this_semester as s where user.name ='$name' and user.a_id= tc.teacher_id and tc.course_id= course.a_id and tc.year = s.year and tc.term = s.term ";

$find_course_name_sql = "select distinct bc.begin_course_name as name , bc.begin_course_cd as id  
	from teach_begin_course tbc, begin_course as bc  
	where tbc.teacher_cd = $personalId and 
	tbc.course_master = 1 and
	tbc.begin_course_cd = bc.begin_course_cd ";
//print $find_course_name_sql;


$courseNameAndId=db_getAll($find_course_name_sql);
//var_dump($courseNameAndId);



foreach ($courseNameAndId as $value){
	$ret .= $value['name'] .'|@a';
}
$ret = ereg_replace('\|@a$', '', $ret);
$ret .= "\n";

foreach ($courseNameAndId as $value){
	$ret .= $value['id'] .'|@a';
}

echo (ereg_replace('\|@a$', '', $ret));





?>
