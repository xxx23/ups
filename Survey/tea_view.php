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

checkMenu("/Survey/tea_view.php");

//瀏覽問卷
$tpl->assign("surveys",  $survey->list_all());
$tpl->assign("editable", 1);

//新增問卷
$tpl->assign("register", array("不記名", "記名"));
$tpl->assign("reg_select", 0);

assignTemplate($tpl, "/survey/tea_view.tpl");
?>
