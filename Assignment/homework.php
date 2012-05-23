<?php
/*author: lunsrot
 * date: 2007/04/03
 */
require_once("../config.php");
require_once("../session.php");

/*
 * comment by rja on 2008/10/22
 * 這真是一個糟透了的作法。
 * 作業評分時，顯示名單的順序一定要跟批改作業時的名單順序相同，否則可能會別的模組
 * 產生非預期的 bug 而改錯人
 * 為了修正這個問題，改成顯示名單時順便顯示 input type hidden 的 personal_id ，
 * 批改分數時就會送出 personal_id ，則 update_grade 時就可依 personal_id 修改
 * */

function update_grade($grade,$personal_id){
	global $DB_CONN;
	$no = $_SESSION['homework_no'];
	$course_cd = $_SESSION['begin_course_cd'];

	$gradeSize= count($grade);
	for( $i=0 ; $i<$gradeSize ; $i++){

		if(is_numeric($grade[$i])){
		$thissql="update `course_concent_grade` set concent_grade=" . $grade[$i] . " 
			where begin_course_cd=$course_cd and percentage_num=$no and percentage_type=2 and student_id={$personal_id[$i]};";
		print $thissql;
		db_query($thissql);

		}
	}
}
?>
