<?php
/*
	author: rja
	這支程式是拿來給 mmc 查 courseid 用的


*/
require_once 'common.php';
require_once 'fadmin.php';
#require_once 'passwd_encryption.php';
require_once 'my_rja_db_lib.php';

#error_reporting(256);
$query_this_semeter = "SELECT * FROM this_semester";
$this_semeter = flatArray(query_db_to_array($query_this_semeter));
$this_year = $this_semeter[0];
$this_term = $this_semeter[1];

$teacherName = $_REQUEST['teacherName'];
$courseName = $_REQUEST['courseName'];
$Q1 = "select course.a_id from course, teach_course, user 
where course.a_id = teach_course.course_id and user.a_id = teach_course.teacher_id and 
course.name = '$courseName'  and user.name = '$teacherName'and teach_course.year = $this_year and teach_course.term = $this_term ";

//print $Q1;

$courseId = query_db_to_value($Q1);
print ( $courseId);

?>
