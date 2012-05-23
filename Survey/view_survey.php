<?php
/*author: lunsrot
 * date: 2007/05/04
 */
require_once("../config.php");
require_once("../session.php");
require_once("sur_info.php");

$survey_no = $_GET['survey_no'];
$tpl = new Smarty;

$tpl->assign("survey_name", $DB_CONN->getOne("select survey_name from `online_survey_setup` where survey_no=$survey_no;"));
$groups = all_questions($survey_no);
$tpl->assign("groups", $groups);
$tpl->assign("survey_no", $survey_no);
$tpl->assign("fillout", 0);
$tpl->assign("editable", 1);

assignTemplate($tpl, "/survey/fillout_survey.tpl");
?>
