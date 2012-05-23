<?php
	/*author: lunsrot
	 * date: 2007/09/05
	 */
	require_once("../config.php");
	require_once("../session.php");

	$tpl = new Smarty;

	$tmp = db_query("SELECT A.* FROM news A, news_target B WHERE B.begin_course_cd = $_SESSION[begin_course_cd] AND B.news_cd = A.news_cd ORDER BY A.d_news_begin DESC, A.news_cd DESC");
	$i = 0;
	while($r = $tmp->fetchRow(DB_FETCHMODE_ASSOC)){
		$tpl->append("data", $r);
		$i++;
		if($i > 3) break;
	}

	assignTemplate($tpl, "/system_news/little_window.tpl");
?>
