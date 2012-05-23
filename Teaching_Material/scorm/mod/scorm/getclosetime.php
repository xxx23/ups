<?php
//下面這行就可以使用 cyberccu2 原本的 session
require('../../../../session.php');
$begin_course_cd_before = $_SESSION['begin_course_cd'];
$personal_id_before = $_SESSION['personal_id'];
//print '<pre>';
//print_r($_SESSION);
if($personal_id_before == "")//登出了
{
       // $begin_course_cd_before = $_GET['Begin_course_cd'];
        $personal_id_before = $_GET['Personal_id'];
}
    $begin_course_cd_get = $_GET['Begin_course_cd'];


/* ============================================= */
/*if($begin_course_cd_get != $begin_course_cd_before)
{
        echo "0";//看到一半切到別的課程
}*/
/* =====================正常情況======================== */
//else
//{
//下面這行就會改採用 moodle 的 session
require_once("../../config.php");
require_once('locallib.php');

$_SESSION['begin_course_cd']= $begin_course_cd_before ; 
$_SESSION['personal_id']= $personal_id_before ;
$begin_course_cd=$_SESSION['begin_course_cd'];
$personal_id=$_SESSION['personal_id'];
//query content_cd

$sql="select content_cd   from class_content_current  where begin_course_cd = $begin_course_cd";
$content_cd= db_getOne($sql);
//查該user最新的紀錄=timemodified值最大且element='x.start.time'
$sql="select id, scormid , scoid, value from  mdl_scorm_scoes_track
WHERE timemodified = ( select max(timemodified)
                        from mdl_scorm_scoes_track
                        where userid = '$personal_id'and 
                              element='x.start.time') and element='x.start.time';";
$track= db_getRow($sql);
//查id的下一筆value是否為complete
$sql="select value  from mdl_scorm_scoes_track where id = ($track[id]+1)";
$value= db_getOne($sql);
$timemodified=time();
//假如value=complete
if($value=="completed")
{
    /*Update mdl_scorm_scoes_track*/
    $sql ="update mdl_scorm_scoes_track
    set timemodified=$timemodified
           where id= $track[id]+1 ";
    db_query($sql);
    //set  start_time
    $time_start= $track[value];
}
else
{
    /*Update mdl_scorm_scoes_track*/
    $sql ="update mdl_scorm_scoes_track
    set timemodified=$timemodified
           where id= $track[id]";
    db_query($sql);
    $time_start= $track[value];
}

//=====================joyce 0915=============結點防呆檢查
  //從content_cd查scorm_id
  $sql = "select id from mdl_scorm  where content_cd ='$content_cd'";
  $s_id = db_getOne($sql);
  $sql = "select scorm from  mdl_scorm_scoes  where id = $track[scoid];";
  $s_id2 = db_getOne($sql);

  if($track['scormid']!= $s_id || $s_id!= $s_id2)
  {echo $track['scormid'].','.$s_id;  return;}


//Update student_learning table
$time_start_strf=strftime("%Y-%m-%d %H:%M:%S", $time_start);
$time_end_strf=strftime("%Y-%m-%d %H:%M:%S",$timemodified);
    //query student_learning 
    $sql = "select * from student_learning where 
            begin_course_cd ='$begin_course_cd' and
            personal_id = '$personal_id' and
            menu_id='$track[scoid]'";
    $row=db_getRow($sql);
    if(is_null($row))
     {
      //student_learning中沒有紀錄 
      $sql ="insert into student_learning
          (begin_course_cd,content_cd,personal_id,menu_id,
           event_happen_number,event_hold_time,event_occur_time,
           event_last_time)
           values ($begin_course_cd,$content_cd,$personal_id,'{$track[scoid]}',
           1,TIMEDIFF('$time_end_strf','$time_start_strf'),'$time_start_strf','$time_end_strf');";
      db_query($sql);
     }
     else
     {
       //student_learning中已有紀錄      
         $event_happen_number=$row["event_happen_number"]+1;
         $event_hold_time=$row["event_hold_time"];
         $sql ="update student_learning
             set event_happen_number=$event_happen_number,
             event_hold_time=ADDTIME('$event_hold_time',
             TIMEDIFF('$time_end_strf','$time_start_strf')),
             event_last_time='$time_end_strf'
             where begin_course_cd = '$begin_course_cd' and personal_id = '$personal_id' and menu_id='{$track[scoid]}';";
        db_query($sql);
     }
    //echo "1";
//}//else
?>
