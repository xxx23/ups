<?php
/*****************************************************************/
/* id: modify_project.php v1.0 2007/6/18 by hushpuppy Exp.       */
/* function: 合作學習 教師檢視與修改專案題目、內容介面				 */
/******************************************************************/

include "../../config.php";
require_once("../../session.php");
require_once("../lib/co_learn_lib.php");

checkMenu("/Collaborative_Learning/teacher/tea_main_page.php");

$Begin_course_cd = $_SESSION['begin_course_cd'];
$Homework_no = $_GET['homework_no'];
if(isset($Homework_no)){
	$key = $_GET['key'];
	check_get_reverse_key($Homework_no,$key,"tea");
}
else
	$Homework_no = $_POST['homework_no'];

$Project_no = $_POST['project_no'];
$del_str = "delete_".$Project_no;
$group_num_str = "group_num".$Project_no;
$var = "group_num_".$Project_no;
$Group_num = $_POST[$var];	//允許的組數

$checked = $_POST['group_num_name_'];
$var = 'project_content_'.$Project_no;
$Project_content = $_POST[$var];
$Delete = $_POST[$del_str];
if(isset($Project_no) && $Delete != 'true'){ //表示修改資料
	$sql = "update projectwork set 
			project_content = '$Project_content', 
			similar_project_number = '$Group_num'
			where project_no = '$Project_no';";
	$result = $DB_CONN->query($sql);
	if(PEAR::isError($result))	die($result->userinfo);
}
if(isset($Project_no) && $Delete =='true'){ //表示刪除資料
	$sql = "delete from projectwork where project_no = '$Project_no';";
	$result = $DB_CONN->query($sql);
	if(PEAR::isError($result))	die($result->userinfo);
}

$template = $HOME_PATH."themes/".$_SESSION['template'];
$tpl_path = "/themes/".$_SESSION['template'];

$smtpl = new Smarty;
//指定homework name
$sql = "select homework_name from homework where homework_no = '$Homework_no';";
$Homework_name = $DB_CONN->getOne($sql);
if(PEAR::isError($Homework_name))	die($Homework_name);

$smtpl->assign("homework_name",$Homework_name);

//query動作
$sql = "select * from projectwork where begin_course_cd = '$Begin_course_cd' and homework_no = '$Homework_no' order by project_no;";
$result = $DB_CONN->query($sql);
if(PEAR::isError($result))	die($result->userinfo);
while($row = $result->fetchRow(DB_FETCHMODE_ASSOC)){
	//if($row['groupno_topic'] != 0)
	$smtpl->append("project_list", $row);
}

$smtpl->assign("tpl_path",$tpl_path);
assignTemplate( $smtpl, "/collaborative_learning/teacher/modify_project.tpl");

?>
