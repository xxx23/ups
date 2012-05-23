<?php
/***********************************************************/
/* id: submit_list.php v1.0 2007/6/20 by hushpuppy Exp.    */
/* function: 合作學習 老師檢視學生作業繳交狀況				   */
/***********************************************************/
include "../../config.php";
require_once("../../session.php");

checkMenu("/Collaborative_Learning/teacher/tea_main_page.php");

$Begin_course_cd = $_SESSION['begin_course_cd'];

$Homework_no = $_POST['homework_no'];

$template = $HOME_PATH."themes/".$_SESSION['template'];
$tpl_path = "/themes/".$_SESSION['template'];

$smtpl = new Smarty;

$smtpl->assign("tpl_path",$tpl_path);
assignTemplate( $smtpl, tpl");

?>

