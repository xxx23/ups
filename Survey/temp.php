<?php
/*author: lunsrot
 * date: 2007/04/07
 */
require_once("../config.php");
require_once("../session.php");
require_once("OnlineSurvey.class.php");

$course_cd = $_SESSION['begin_course_cd'];
$tpl = new Smarty;
$survey = new OnlineSurvey();

//瀏覽問卷
$tpl->assign("surveys",  $survey->list_all());
$tpl->assign("editable", 1);

//新增問卷
$tpl->assign("register", array("不記名", "記名"));
$tpl->assign("reg_select", 0);

//統計資料
$date = getCurTime();
$result = db_query("select * from `online_survey_setup` where survey_target=$course_cd and d_survey_end < '$date' order by d_survey_end;");
while(($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) != false){
	$tpl->append("survey2s", $row);
}

assignTemplate($tpl, "/survey/temp.tpl");
?>
