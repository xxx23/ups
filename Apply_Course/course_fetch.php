<?php
define('ROOT', '../');
require_once(ROOT.'config.php');
require_once(ROOT.'session.php');

global $DB_CONN;
if(isset($_GET['class_kind']))
    $class_kind = (int) $_GET['class_kind'];
else
    $class_kind = -1;

if(isset($_GET['class_for']))
    $class_for = (int) $_GET['class_for'];
else
    $class_for = -1;

if(isset($_GET['date_course_begin']) && !empty($_GET['date_course_begin']) ) {
    $date_course_begin = $_GET['date_course_begin'] ; 
}else {
    $date_course_begin = -1 ; 
}

if(isset($_GET['date_course_end']) && !empty($_GET['date_course_end']) ) {
    $date_course_end = $_GET['date_course_end'] ; 
}else {
    $date_course_end = -1 ; 
}





$sql = "SELECT begin_course_cd,begin_course_name FROM begin_course";
if($class_kind != -1 || $class_for != -1)
{
    $sql .= " WHERE 1=1 ";
    if($class_kind != -1) {
        $sql .= " AND course_property=$class_kind";
    }
    if($class_for != -1) {
        $sql .= " AND memberkind=$class_for";
    }
    if( $date_course_begin != -1 ) {
        $date_begin  = date_create( $date_course_begin) ; 
        $date_cb = $date_begin->format('\'Y-m-d H:i:s\'');
        $sql .= " AND begin_course.d_course_begin > $date_cb "; 
    }
    if( $date_course_end != -1 ) {
        $date_end = date_create( $date_course_end ) ; 
        $date_ce = $date_end->format('\'Y-m-d H:i:s\'') ; 
        $sql .= " AND begin_course.d_course_begin < $date_ce " ; 
    }
}

//echo $sql ; 
$result = db_query($sql);


$ret = Array();
while ($row =& $result->fetchRow(DB_FETCHMODE_ASSOC)) {
    $ret[ $row['begin_course_cd'] ] = $row['begin_course_name'] ;
}

echo json_encode($ret);
?>
