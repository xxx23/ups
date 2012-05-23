<?php
global $DB_DEBUG ;
$DB_DEBUG=true;

require_once '../config.php' ;
require_once '../library/lib_course_pass.php';

$guest_pid = db_getOne("SELECT personal_id
                            FROM register_basic
                            WHERE role_cd = 4");


//取出所有自學期限已到的案例
$sql = "SELECT b.criteria_total, TIME_TO_SEC(b.criteria_content_hour) as take_hour,t.pass, t.begin_course_cd, t.personal_id, t.course_end,t.send2nknu_time 
        FROM begin_course b, take_course t
        WHERE b.begin_course_cd=t.begin_course_cd 
        AND t.allow_course=1 
        AND b.attribute='0' 
        AND t.personal_id != {$guest_pid}";

$result = db_query($sql);

$error_pass = 'error_pass.result';
$error_fail = 'error_fail.result';
$correct = 'correct.result';
$else_cond = 'else_cond.result';


if($result->numRows())
{
    while($dataRow = $result->fetchRow(DB_FETCHMODE_ASSOC))
    {
        $begin_course_cd = $dataRow['begin_course_cd'];
        $personal_id = $dataRow['personal_id'];
        //計算成績
        $grade = getScore($begin_course_cd,$personal_id,0);
        //計算閱讀時數
        $readSec = getReadSecond($begin_course_cd,$personal_id);
        //計算課程結束時間
        $course_end = strtotime($dataRow['course_end']);

        $dataRow['grade'] = $grade;
        $dataRow['redSec'] = $readSec;

        if($dataRow['pass']== 1 && ($readSec < $dataRow['take_hour'] &&$grade >= $dataRow['criteria_total']) )
        {
            $dataRow['test_msg'] = '條件不足但通過';
            $dump = print_r($dataRow, true);
            file_put_contents($error_pass, $dump, FILE_APPEND | LOCK_EX);
            if($dataRow['send2nknu_tim']!='0000-00-00')
                file_put_contents('error_send2nknu.result',$dump,FILE_APPEND |LOCK_EX);       
        }

    }

}



//end of check_pass.php

