<?php 
/*
 *report1.php scorm教材使用記錄
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
         
//從student_learning中query出該門課的content_cd的記錄
$sql = "select distinct(menu_id)  from  student_learning  where content_cd = $content_cd;";
$menu=db_getAll($sql);
$menu_count=sizeof($menu);
for ($a = 0; $a<$menu_count; $a+=1) 
{
$menu_id=$menu[$a]["menu_id"];
$sql = "select SUM(event_happen_number) AS event_happen_number_sum,
               SUM(TIME_TO_SEC(event_hold_time)) AS event_hold_time_sum
        from student_learning where content_cd = $content_cd and menu_id = $menu_id";
$tracking=db_getRow($sql);
/*根據menu_id找出title*/
$sql = "select title  from  mdl_scorm_scoes  where id = $menu_id;";
$title=db_getOne($sql);
$row=array();
$row[]=$title;
$row[]=$tracking["event_happen_number_sum"];
$row[]=$tracking["event_hold_time_sum"];
$table->data[]=$row;    
}
print_table($table);

?>
