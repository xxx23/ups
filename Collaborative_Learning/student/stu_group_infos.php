<?php
/******************************************************/
/* id: group_infos.php 2007/5/30 by hushpuppy Exp.    */
/* function: 合作學習 組員資料							  */
/******************************************************/

include "../../config.php";
require_once("../../session.php");

checkMenu("/Collaborative_Learning/student/stu_main_page.php");

$Begin_course_cd = $_SESSION['begin_course_cd'];
$Personal_id = $_SESSION['personal_id'];

$Homework_no = $_GET['homework_no'];

$template = $HOME_PATH."themes/".$_SESSION['template'];
$tpl_path = "/themes/".$_SESSION['template'];

$smtpl = new Smarty;

//取得group_no
$sql = "select group_no from groups_member where homework_no = '$Homework_no' and student_id='$Personal_id'";
$Group_no = $DB_CONN->getOne($sql);
if(PEAR::isError($Group_no))	die($Group_no->userinfo);
$smtpl->assign("group_no",$Group_no);

$sql = "select * from info_groups ig, projectwork pw
  where ig.homework_no = '$Homework_no'
 and pw.homework_no = '$Homework_no' 
	and ig.group_no = '$Group_no'
	and pw.project_no = ig.project_no";
$result = $DB_CONN->query($sql);
if(PEAR::isError($result))	die($result->userinfo);
$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
$smtpl->assign("project_content",$row['project_content']);

//取得本組學生名單
$sql_stu = "SELECT * FROM personal_basic pb, groups_member gm, register_basic rb
	WHERE gm.begin_course_cd = '$Begin_course_cd' 
	and gm.homework_no = '$Homework_no'
	and gm.group_no = '$Group_no'
	and rb.personal_id = gm.student_id
	and pb.personal_id = gm.student_id;
	";
//print $sql_stu;
$result = $DB_CONN->query($sql_stu);
if(PEAR::isError($result))	die($result->userinfo);
while( $stu_row = $result->fetchRow(DB_FETCHMODE_ASSOC) ){
	//print $stu_row['personal_name'];
	//print "test".$stu_row.personal_id;
	//print_r($stu_row);
	$smtpl->append("data_list",$stu_row);
}

$smtpl->assign("tpl_path",$tpl_path);
assignTemplate( $smtpl, "/collaborative_learning/student/stu_group_infos.tpl");

?>
