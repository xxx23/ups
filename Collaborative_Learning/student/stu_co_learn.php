<?php
/******************************************************/
/* id: stu_co_learn.php 2007/5/24 by hushpuppy Exp.   */
/* function: 學生合作學習的主頁面						  */
/******************************************************/

require_once("../../session.php");
include "../../config.php";
include "../lib/co_learn_lib.php";
include("../../Discuss_Area/library.php"); 

checkMenu("/Collaborative_Learning/student/stu_main_page.php");

$Homework_no = $_GET['homework_no'];
$key = $_GET['key'];
$Personal_id = $_SESSION['personal_id'];

$smtpl = new Smarty;

$link = discussLink($Homework_no);
if($link == '0')
  $smtpl->assign("discuss_link","./warning.html");
else
  $smtpl->assign("discuss_link",$link);

$smtpl->assign("HW_NO",$Homework_no);
$smtpl->assign("Key",$key);

$smtpl->assign("pid",$Personal_id);
assignTemplate( $smtpl, "/collaborative_learning/student/stu_co_learn.tpl");


function discussLink($Homework_no)
{
  global $DB_CONN;
  $Begin_course_cd = $_SESSION['begin_course_cd'];
  $Personal_id = $_SESSION['personal_id'];

  $sql = "select group_no from groups_member 
    where begin_course_cd = '$Begin_course_cd' and homework_no = '$Homework_no' and student_id = '$Personal_id'";
  $Group_no = $DB_CONN->getOne($sql);
  if(PEAR::isError($Group_no))	die($Group_no->userinfo);
  if(empty($Group_no))
    return 0;
  $link = DiscussArea_getLinkIntoArticleList($DB_CONN, $HOME_PATH, $Begin_course_cd, $Homework_no, $Group_no, "student");
  if(empty($link))
    return 0;
  else
    return "../../".$link;
}
?>
