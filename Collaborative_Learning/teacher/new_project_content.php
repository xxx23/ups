<?php
/******************************************************************/
/* id: new_project_content.php v1.0 2007/6/4 by hushpuppy Exp.    */
/* function: 合作學習 教師新增合作學習內容(題目)介面				      */
/******************************************************************/

include "../../config.php";
require_once("../../session.php");
require_once("../lib/co_learn_lib.php");

checkMenu("/Collaborative_Learning/teacher/tea_main_page.php");

$Homework_no_post = $_POST['homework_no'];
if(!isset($Homework_no_post)){
	$Homework_no = $_GET['homework_no'];
	$key = $_GET['key'];
	check_get_reverse_key($Homework_no, $key, "tea");
}
$Begin_course_cd = $_SESSION['begin_course_cd'];

$new_flag_g = $_GET['n']; //當進入專案內容，老師要新增題目 按完才不會跳出兩顆tree
$new_flag_p = $_POST['new_flag'];
$Project_content = $_POST['project_content'];
$Finish_option = $_POST['finish_option'];
//若為free, 即表示不限制選此專案的組數
$Free = $_POST['group_num_free'];
if(!isset($Free))
	$Similar_project_number = $_POST['group_num'];

if(isset($Project_content)){
	if(isset($Homework_no)){
		$sql = "insert into projectwork 
			(begin_course_cd, homework_no, project_no, groupno_topic, project_content, similar_project_number)
			values
			('$Begin_course_cd', '$Homework_no', '', '0', '$Project_content', '$Similar_project_number');";
		$no = $Homework_no;
		$key = check_get_produce_key($Homework_no, "tea");
	}
	else if(isset($Homework_no_post)){
		$sql = "insert into projectwork 
			(begin_course_cd, homework_no, project_no, groupno_topic, project_content, similar_project_number)
			values
			('$Begin_course_cd', '$Homework_no_post', '', '0', '$Project_content', '$Similar_project_number');";
		$no = $Homework_no_post;
		$key = check_get_produce_key($Homework_no_post, "tea");
	}
	$result = $DB_CONN->query($sql);
	if(PEAR::isError($result))	die($result->userinfo);
	//print $option;
	if($Finish_option == 'finish' && $new_flag_p == 0)
	  header("Location: ./tea_co_learn.php?homework_no=$no&key=$key");
	else if($Finish_option == 'finish' && $new_flag_p == 1)
	  header("Location: ./modify_project.php?homework_no=$no&key=$key");
	/*else if($Finish_option == 'finish' && $option == 1)
	  header("Location: ./tea_usage.php?homework_no=$no");*/
	else if($Finish_option == 'continue')
		header("Location: ./new_project_content.php?homework_no=$no&key=$key");
}

$template = $HOME_PATH."themes/".$_SESSION['template'];
$tpl_path = "/themes/".$_SESSION['template'];

$smtpl = new Smarty;
if(isset($Homework_no)){
	$sql = "select homework_name from homework where homework_no = '$Homework_no';";
	$smtpl->assign("homework_no",$Homework_no);
}
else{
	$sql = "select homework_name from homework where homework_no = '$Homework_no_post';";
	$smtpl->assign("homework_no",$Homework_no_post);
}
$Homework_name = $DB_CONN->getOne($sql);
if(PEAR::isError($Homework_name))	die($Homework_name);

$smtpl->assign("homework_name",$Homework_name);
$smtpl->assign("new_flag",$new_flag_g);

$smtpl->assign("tpl_path",$tpl_path);
assignTemplate( $smtpl, "/collaborative_learning/teacher/new_project_content.tpl");

?>
