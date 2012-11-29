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
    .' ORDER BY A.d_news_begin DESC '. $sql_NumRows;

$result = db_query($get_admin_news);

while( $result->fetchInto($row, DB_FETCHMODE_ASSOC) )
{
    $date = $row['d_news_begin'];
    $subject = $row['subject'];
    $content= $row['content'];
    $tpl->append("news", array('date'=>$date, 'subject'=>$subject,'content'=>$content));
}

$tpl->display("index_news.tpl");

?>
