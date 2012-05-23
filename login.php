<?php
/***
FILE:   index.php
DATE:   2006/11/26
AUTHOR: zqq

首頁 左邊的login頁面
**/
	include("config.php");
	$show_news_numRows = 7;
	
	$tpl = new Smarty();	
	
	$get_admin_news = 'SELECT A.d_news_begin,A.subject FROM news A, news_target B '
	.' WHERE B.role_cd = 0 AND A.news_cd = B.news_cd '
	.' ORDER BY A.d_news_begin DESC, A.news_cd DESC limit 0,'. $show_news_numRows;

	$result = db_query($get_admin_news);
	
	while( $result->fetchInto($row, DB_FETCHMODE_ASSOC) ){
		$date = str_replace('-', '/', trim($row['d_news_begin'],"00:00:00") );
		$subject = $row['subject'];
		$tpl->append("news", array('date'=>$date, 'subject'=>$subject));
	}
	$tpl->display("login.tpl");
?>