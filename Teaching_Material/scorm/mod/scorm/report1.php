<?php  // $Id: report1.php 
/*
 *report1.php scorm教材個人使用記錄
 */
//下面這行就可以使用 cyberccu2 原本的 session
//require('/home/zoe/WWW/session.php');
require('../../../../session.php');
$begin_course_cd_before = $_SESSION['begin_course_cd'];
$personal_id_before = $_SESSION['personal_id'];

//下面這行就會改採用 moodle 的 session
require_once("../../config.php");
require_once('locallib.php');

$_SESSION['begin_course_cd']= $begin_course_cd_before ; 
$_SESSION['personal_id']= $personal_id_before ;
$begin_course_cd=$_SESSION['begin_course_cd'];
$personal_id=$_SESSION['personal_id'];
//query content_cd
$sql = "select content_cd from class_content_current  where begin_course_cd='$begin_course_cd'";
$content_cd= db_getOne($sql);
            $table = new stdClass();
            $table->head = array();
            $table->width = '100%';

            $table->head[]= "教材標題";
            $table->align[] = 'left';
            $table->wrap[] = 'nowrap';
            $table->size[] = '*';
            
            $table->head[]= '點閱次數';
            $table->align[] = 'left';
            $table->wrap[] = 'nowrap';
            $table->size[] = '*';

            $table->head[]= '停留總時間(秒)';
            $table->align[] = 'left';
            $table->wrap[] = 'nowrap';
            $table->size[] = '*';

            $table->head[]= '首次登入時間';
            $table->align[] = 'center';
            $table->wrap[] = 'nowrap';
            $table->size[] = '*';

            $table->head[]= '最後登入時間';
            $table->align[] = 'center';
            $table->wrap[] = 'nowrap';
            $table->size[] = '*';
//從student_learning中query出personal_id和該門課的content_cd的記錄
$sql = "select * from student_learning where personal_id = $personal_id and content_cd = $content_cd";
$tracking=db_getAll($sql);
$tracking_count=sizeof($tracking);
for ($a = 0; $a<$tracking_count; $a+=1) 
{
$row=array();
    $scoid=$tracking[$a]["menu_id"];
    $sql = "select title  from  mdl_scorm_scoes  where id = $scoid;";
    $title=db_getOne($sql);
    $row[]=$title;
    $row[]=$tracking[$a]["event_happen_number"];
    $row[]=$tracking[$a]["event_hold_time"];
    $row[]=$tracking[$a]["event_occur_time"];
    $row[]=$tracking[$a]["event_last_time"];
$table->data[]=$row;    
}
print_table($table);
?>
