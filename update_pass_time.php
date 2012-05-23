<?php
    require_once 'config.php';

    $data = db_getAll("
        SELECT begin_course_cd,personal_id ,FROM_UNIXTIME( MAX( UNIX_TIMESTAMP( event_last_time ) ) ,  '%Y-%m-%d' ) AS max_time
        FROM `student_learning` 
        WHERE 1 GROUP BY begin_course_cd,personal_id

    ");

    $MaxTimeTable = array();
    foreach($data as $row)
    {
        $MaxTimeTable[$row['begin_course_cd']][$row['personal_id']] = $row['max_time'];
    }
    unset($data);

    $data = db_getAll("
        SELECT begin_course_cd, personal_id
        FROM take_course

        WHERE `pass` =1
        AND `pass_time` IS NULL
        AND personal_id != 2
        ");
    $count=0;
    $updateQuery = '';
    foreach($data as $row)
    {
        $maxTime = $MaxTimeTable[$row['begin_course_cd']][$row['personal_id']];
        $updateQuery.= "UPDATE take_course SET pass_time = '{$maxTime}' WHERE begin_course_cd={$row['begin_course_cd']} AND personal_id={$row['personal_id']};\n";
        $course++;
    }
    echo $course;
    echo $updateQuery;
    
