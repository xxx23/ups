<?php
require_once('../config.php');
require_once('../session.php');
require_once($HOME_PATH.'Course_Admin/MSSQLWrapper.class.php');
$NKNU_DB_HOST = "NKNU_DB";
$NKNU_DB_USER = "Hsngccu";
$NKNU_DB_PASSWD = "Cyber3elearning";
$NKNU_DATABASE ="course_Hsngccu";

//Get All Course
putenv('FREETDSCONF=/usr/local/etc/freetds.conf');
$nknudb = new MSSQLWrapper(
        $NKNU_DB_HOST,
        $NKNU_DB_USER,
        $NKNU_DB_PASSWD,
        $NKNU_DATABASE    
    );


//fetch student list
$allCourse = $nknudb->getAll("
        SELECT CourseID,Import_ID,CourseName,TeacherList
        FROM Course
        ");

$proccessedCourses = array();
$teacherList = array();
// find repeat
foreach($allCourse as $course){
    $proccessedCourse =array(
        'begin_course_cd' => fetchCourseCd($course['Import_ID']),
        'Import_ID' => $course['Import_ID'],
        'CourseID' => $course['CourseID'],
        'CourseName' => $course['CourseName'],
        'TeacherList'=> fetchTeacherList($course['TeacherList'])
    );
    
    foreach($proccessedCourse['TeacherList'] as $teacher){
        $teacherList[$proccessedCourse['begin_course_cd']][$teacher]++;
    }
}



function fetchTeacherList($list)
{
    $dataList = explode(',',$list);
    $teacherList = array();
    foreach($dataList as $data)
    {
        $temp = explode('-',$data);
        $teacherList[] = $temp[0];
    }
    return $teacherList;
}
function fetchCourseCd($id)
{
    $datas = explode('-',$id);
    if(count($datas) !=3)
        return $id;

    return $datas[1];
}
?>
<html>
    <head>
        <title>Find Reapeat</title>
    </head>
    <body>
        <table>
            <thead>
                <th>course id</th>
                <th>student list (repeat num)</th>
            </thead>
            <tbody>
                <?php foreach($teacherList as $begin_course_cd => $data):?>
                <tr>
                    <td><?=$begin_course_cd?></td>
                    <td>
                        <?php foreach($data as $key => $value):?>
                            <?php if($value>1):?>
                                <?="$key($value),"?>
                            <?php endif;?>    
                        <?php endforeach;?>
                    </td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </body>
</html>

