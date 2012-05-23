<?php
/**********************************************************/
/* id: new_project.php v1.0 2007/6/4 by hushpuppy Exp.    */
/* function: 合作學習 教師新增合作學習介面				      */
/**********************************************************/

require_once("../../session.php");
include "../../config.php";
require_once("../lib/co_learn_lib.php");

//checkMenu("/Collaborative_Learning/student/stu_main_page.php");

$Homework_no = $_GET['homework_no'];
$key = $_GET['key'];

check_get_reverse_key($Homework_no, $key, "stu");

$Begin_course_cd = $_SESSION['begin_course_cd'];

$sql = "select * from homework where homework_no = '$Homework_no';";
$result = $DB_CONN->query($sql);
if(PEAR::isError($result))	die($result->userinfo);
$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
$question = $row['question'];
$d_dueday = $row['d_dueday'];

$sql = "select * from project_data where homework_no = '$Homework_no' and begin_course_cd = '$Begin_course_cd';";
$result = $DB_CONN->query($sql);
if(PEAR::isError($result))	die($result->userinfo);
$row = $result->fetchRow(DB_FETCHMODE_ASSOC);

$template = $HOME_PATH."themes/".$_SESSION['template'];
$tpl_path = "/themes/".$_SESSION['template'];

$smtpl = new Smarty;

$smtpl->assign("project_goal",$row['project_goal']);
$smtpl->assign("comment",$row['comment']);
$smtpl->assign("ref_doc",$row['ref_doc']);
$smtpl->assign("due_date",$row['due_date']);
$smtpl->assign("score_type",$row['score_type']);
$smtpl->assign("person_rate",$row['person_rate']);
$smtpl->assign("group_rate",100-$row['person_rate']);
$smtpl->assign("question",$question);
$smtpl->assign("d_dueday",$d_dueday);

$smtpl->assign("tpl_path",$tpl_path);
assignTemplate( $smtpl, "/collaborative_learning/student/question_view.tpl");

?>
