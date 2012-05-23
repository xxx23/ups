<?php
	/************************************************************************/
	/*id: learning_tracking.php v1.0 2007/9/4 by hushpuppy Exp.				*/
	/*function: 教材學習追蹤，當點擊教材node時，送出ajax由本程式接收request		*/
	/************************************************************************/
	
	include "../../config.php";
	include "../../session.php";
	include "../lib/learning_record.php";
	//include "../../lib/date.php";
	//checkMenu("/Teaching_Material/stu_textbook_content.php");
	
	$Menu_id = $_GET['Menu_id'];
	
	$total = record_hold_time($Menu_id);
	//print $total;
	//print $Content_cd."-".$Menu_id."-".$Personal_id;
?>