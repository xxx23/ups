<?php
/***********************************************************/
/* id: tea_co_learn.php v1.0 2007/7/1 by hushpuppy Exp.    */
/* function: 教師合作學習 進入後的主頁面(樹狀結構)	   */
/***********************************************************/

require_once("../../session.php");
include "../../config.php";
include "../lib/co_learn_lib.php";

checkMenu("/Collaborative_Learning/teacher/tea_main_page.php");

$tpl_path = "/themes/".$_SESSION['template'];
$template = $HOME_PATH."themes/".$_SESSION['template'];
$Homework_no = $_GET['homework_no'];
$key = $_GET['key'];

$smtpl = new Smarty;

$smtpl->assign("HW_NO",$Homework_no);
$smtpl->assign("Key",$key);
$smtpl->assign("pid", $_SESSION['personal_id']);
assignTemplate($smtpl, "/collaborative_learning/teacher/tea_co_learn.tpl");

?>
