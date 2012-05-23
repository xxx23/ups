<?php
/***
include news頁面與pop course 頁面  for index display 
by arnan 
***/

require("config.php");
require($HOME_PATH .'System_News/library.php') ;



$tpl = new Smarty();

/* ============= system News ============= */

$default_news_type = 'course-all' ;
$show_news_numRows = 10;
$sql_NumRows = ' limit 0, '.$show_news_numRows;

$sql_get_news_type_where = get_news_type_where_sql($default_news_type) ;

$get_admin_news = 'SELECT A.d_news_begin, A.subject, A.content, B.course_type FROM news A, news_target B '
    .' WHERE B.role_cd=0 AND A.news_cd=B.news_cd '.$sql_get_news_type_where
    .' ORDER BY A.d_news_begin DESC, A.news_cd DESC '. $sql_NumRows;

$result = db_query($get_admin_news);

while( $result->fetchInto($row, DB_FETCHMODE_ASSOC) ){
    $date = str_replace('-', '/', trim($row['d_news_begin'],"00:00:00") );
    $subject = $row['subject'];
    $content= $row['content'];
    $tpl->append("news", array('date'=>$date, 'subject'=>$subject,'content'=>$content));
}

$tpl->display("index_news.tpl");


/* ============ popular Course ===================== */ 
/*
    echo "<br />" ;
    include_once("library/common.php");
    include_once("session.php");	

    // 要show出幾門熱門的課程
    $role_cd = $_SESSION['role_cd'];	
    $show_course = 10 ;
    $sql = "SELECT t.begin_course_cd, count(*) as people_number, bc.begin_course_name, bc.course_cd
        FROM take_course t , begin_course bc
        WHERE t.begin_course_cd = bc.begin_course_cd
        GROUP BY begin_course_cd
        ORDER BY count(*) DESC limit 0,{$show_course}";

    $normal_course = get_popular_course(0,$show_course);
    $elementary_course = get_popular_course(1,$show_course);
    $high_course = get_popular_course(2,$show_course);
    $college_course = get_popular_course(3,$show_course);

    $tpl->assign("normal_course",$normal_course);
    $tpl->assign("elementary_course",$elementary_course);
    $tpl->assign("high_course",$high_course);
    $tpl->assign("college_course",$college_course);

    $tpl->assign("role_cd",$role_cd);
    $hot_course = db_getAll($sql);
    $tpl->assign("popular_course",$hot_course);
    $tpl->display("popular_course.tpl");

    function get_popular_course($type,$limit)
    {
        $sql = "select count(*) as people_number , BC.begin_course_cd, BC.begin_unit_cd , BC.begin_course_name, BC.course_cd
            from begin_course BC, take_course TC
            where BC.begin_course_cd in (
                select begin_course_cd
                from begin_course
                where begin_unit_cd in (
                    select unit_cd
                    from lrtunit_basic_ where department={$type}))
                    and BC.begin_course_cd = TC.begin_course_cd
                    Group BY BC.begin_course_cd
                    ORDER BY people_number DESC LIMIT 0,{$limit}";
        return db_getAll($sql);
    }
 */
?>
