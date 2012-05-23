<?php
/*****************************************************************/
/* id: result_show.php v1.0 2007/6/20 by hushpuppy Exp.          */
/* function: 合作學習學生成果發表介面							     */
/*****************************************************************/
/* author: lunsrot
 * date: 2007/07/18
 */
require_once("../config.php");
require_once("../session.php");
//require_once("../library/redirect_file.php");
require_once("lib/co_learn_lib.php");

//checkMenu("/Collaborative_Learning/teacher/tea_main_page.php");

global $DB_CONN, $COURSE_FILE_PATH;
$course_cd = $_SESSION['begin_course_cd'];

$tpl = new Smarty;
$input = $_GET;

check_get_reverse_key($input['homework_no'], $input['key'], "stu");
$result = db_query("select * from `info_groups` where begin_course_cd=$course_cd and homework_no=$input[homework_no];");
while($row = $result->fetchRow(DB_FETCHMODE_ASSOC)){
	if($row['upload'] == 1){
		//$path = "$COURSE_FILE_PATH$course_cd/homework/$input[homework_no]/student/$row[group_no]/$row[result_work]";
		$path = "$COURSE_FILE_PATH$course_cd/homework/$input[homework_no]/student/$row[group_no]/";
		//$_SESSION['current_path'] = $path;
		$time = fileatime($path);
		$date = getdate($time);
		$row['upload_time'] = "$date[year]-$date[mon]-$date[mday] $date[hours]:$date[minutes]:$date[seconds]";
		$row['encode_result_work'] = urlencode($row['result_work']);
		//$row['file_path'] = $path;
	}else
		$row['upload_time'] = "未上傳";
	$tpl->append("project_list", $row);
}

assignTemplate($tpl, "/collaborative_learning/result_show.tpl");
?>

