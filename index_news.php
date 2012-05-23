<?php
/***
FILE:   index_news.php
DATE:   2009/07/30
AUTHOR: w60292

首頁的公告頁面
**/
require("config.php");
require($HOME_PATH .'System_news/library.php') ;

$default_news_type = 'course-all' ;
$show_news_numRows = 5;
	
	$tpl = new Smarty();	
	

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
?>
