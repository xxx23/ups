<?php
/*author: lunsrot
 * date:2007/04/07
 */
require_once("../config.php");
require_once("../session.php");
require_once("sur_info.php");

$target = $_SESSION['begin_course_cd'];
$option = $_GET['option'];

checkMenu("/Survey/tea_view.php");

switch($option){
	case "create": create($target); break;
	case "modify_view": modify_view(); break;
	case "modify": modify($target); break;
	default: header("location: tea_view.php"); break;
}

function display_create(){
	$tpl = new Smarty;
	assignTemplate($tpl, "/survey/create_survey.tpl");
}

function create($target){
	global $DB_CONN;
	$name = $_GET['survey_name'];
	$is_register = $_GET['is_register'];
	$tmp = gettimeofday();
	$time = getdate($tmp['sec']);
	$date = $time['year']."-".$time['mon']."-".$time['mday']." ".$time['hours'].":".$time['minutes'].":".$time['seconds'];

	checkSurveyName($name, $target, 0);
	checkBank(getTeacherId());

	db_query("insert into `online_survey_setup` (survey_target, survey_name, is_register, mtime) values ($target, '$name', $is_register, '$date');"); 
	$result = $DB_CONN->getOne("select survey_no from `online_survey_setup` where survey_target=$target and survey_name='$name';");
	updateSurveyStudent($target, $result);

	header("location: edit_survey.php?survey_no=" . $result);
}

function updateSurveyStudent($target, $survey_no){
	$date = getCurTime();
	$result = db_query("select personal_id from `take_course` where begin_course_cd=$target;");
	while(($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) != false)
		db_query("insert into `survey_student` (survey_no, personal_id, mtime) values ($survey_no, $row[personal_id], '$date');");
}

function modify_view(){
	$survey_no = $_GET['survey_no'];
	$tpl = new Smarty;

	$result = db_query("select survey_name, is_register, d_survey_beg, d_survey_end from `online_survey_setup` where survey_no=$survey_no;");
	$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
	$tpl->assign("survey_no", $survey_no);
	$tpl->assign("survey_name", $row['survey_name']);
	//$tpl->assign("register", array("不記名", "記名"));
	$tpl->assign("is_register", $row['is_register']);
	if(empty($row['d_survey_beg']))
		$beg = getdate(strtotime(getCurTime()));
	else
		$beg = getdate(strtotime($row['d_survey_beg']));
	$tpl->assign("beg", "$beg[year]-$beg[mon]-$beg[mday]");
	if(empty($row['d_survey_end']))
		$end = getdate(strtotime(getCurTime()));
	else
		$end = getdate(strtotime($row['d_survey_end']));
	$tpl->assign("end", "$end[year]-$end[mon]-$end[mday]");

	assignTemplate($tpl, "/survey/modify_view.tpl");
}

function modify($target){
	$survey_name = $_GET['survey_name'];
	//$is_register = $_GET['is_register'];
	$survey_no = $_GET['survey_no'];
	$begin = $_GET['beg'] . " 00:00:00";
	$end = $_GET['end'] . " 23:59:59";

	checkSurveyName($survey_name, $target, $survey_no);

	//db_query("update `online_survey_setup` set survey_name='$survey_name', is_register=$is_register, d_survey_beg='$begin', d_survey_end='$end' where survey_no=$survey_no;");
	db_query("update `online_survey_setup` set survey_name='$survey_name', d_survey_beg='$begin', d_survey_end='$end' where survey_no=$survey_no;");
	header("location:./tea_view.php");
}

/* 參數依序表示問卷名稱、問卷對象、允許名稱重複出現的次數
 * 第三個參數為0或1，0表示第一次新增，絕不允許重複名稱，1表示修改，剛好和原來的問卷名稱相同
 */
function checkSurveyName($name, $target, $type){
	if($name == ""){
		echo "請輸入問卷名稱<br/><a href=\"tea_view.php\">回瀏覽問卷</a>";
		exit(0);
	}
	$tmp = isExist($name, $target);
	if($tmp != 0 && $tmp != $type){
		echo "問卷名稱重複，請重新輸入<br/><a href=\"tea_view.php\">回瀏覽問卷</a>";
		exit(0);
	}
}

function isExist($name, $target){
	$result = db_query("select survey_no from `online_survey_setup` where survey_target=$target and survey_name='$name';");
	if($result->numRows() != 0){
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		return $row['survey_no'];
	}
	return 0;
}

function checkBank($pid){
	global $DB_CONN;
	$num = $DB_CONN->getOne("select count(*) from `survey_bank_question` where survey_bankno in (select survey_bankno from `survey_bank` where personal_id=$pid);");
	if($num > 0)
		return ;
	echo "<script type=\"text/javascript\">alert('目前沒有任何問卷題目，請先新增題目！');history.back();</script>";
	exit(0);
}
?>
