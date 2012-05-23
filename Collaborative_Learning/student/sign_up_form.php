<?php
/***********************************************************/
/* id: sign_up_form.php v2.0 2007/6/20 by hushpuppy Exp.   */
/* function: 報名表單							   		   */
/***********************************************************/
require_once("../../session.php");
include "../../config.php";
require_once("../lib/co_learn_lib.php");
require_once("../lib/grouping_lib.php");

checkMenu("/Collaborative_Learning/student/stu_main_page.php");

$Homework_no = $_POST['homework_no'];

if(empty($Homework_no)){
	$Homework_no = $_GET['homework_no'];
	$Key = $_GET['key'];
	check_get_reverse_key($Homework_no, $Key, "stu");
}

$Begin_course_cd = $_SESSION['begin_course_cd'];
$Personal_id = $_SESSION['personal_id'];
$Project_no = $_POST['project_name'];
$smtpl = new Smarty;
$smtpl->assign("homework_no",$Homework_no);

//取得分組人數
$sql = "select group_member from project_data where homework_no = '$Homework_no'";
$Group_member = $DB_CONN->getOne($sql);
if(PEAR::isError($Group_member))	die($Group_member->userinfo);
$smtpl->assign("group_member",$Group_member);

$Group_name = $_POST['group_name'];

//取得group_no
$sql = "select group_no from groups_member where homework_no = '$Homework_no' and student_id = '$Personal_id'";
$Group_no = $DB_CONN->getOne($sql);
if(PEAR::isError($Group_no))	die($Group_no->userinfo);

$Self_subject = $_POST['enable_self_subject'];
if(!isset($Self_subject))	$Self_subject = "false";
$New = $_POST['submit_form'];

//自定題目
if($Self_subject == 'true'){
  $Project_content = $_POST['self_subject_content'];
	//先檢查是否已存在題目
	$sql = "select project_no from info_groups where homework_no = '$Homework' and group_no = '$Group_no'";
	$Project_no = $DB_CONN->getOne($sql);
	if(PEAR::isError($Project_no))	die($Project_no->userinfo);
	if(empty($Project_no)){
		$sql = "insert into projectwork 
			(begin_course_cd, homework_no, project_no, groupno_topic, project_content, similar_project_number)
			values
			('$Begin_course_cd', '$Homework_no', '$Project_no', '$Group_no', '$Project_content', '')";
	}
	else{
		$sql = "update projectwork set project_content = '$Project_content' 
			where homework_no = '$Homework_no' and project_no = '$Project_no'";
	}
	//print $sql;
	$result = $DB_CONN->query($sql);
	if(PEAR::isError($result))	die($result->userinfo);
	
	//更改組名
	$sql = "update info_groups set group_name = '$Group_name' 
		where homework_no = '$Homework_no' and group_no = '$Group_no'";
	$result = $DB_CONN->query($sql);
	if(PEAR::isError($result))	die($result->userinfo);
}
else if($Self_subject == 'false' && $New == '1'){
	//更改題目
	//$Project_no = $_POST['project_name'];
	$sql = "update info_groups set project_no = '$Project_no' where homework_no = '$Homework_no' and group_no = '$Group_no'";
	//print $sql;
	$result = $DB_CONN->query($sql);
	if(PEAR::isError($result))	die($result->userinfo);
	echo "<center><span class=\"imp\">您已更改專案題目!</span></center>";
	
	//更改組名
	$sql = "update info_groups set group_name = '$Group_name' 
	  where homework_no = '$Homework_no' and group_no = '$Group_no'";
	//print $sql;
	$result = $DB_CONN->query($sql);
	if(PEAR::isError($result))	die($result->userinfo);
}
else if($Self_subject == 'false' && $New == '0'){
	//新增組別
	//$Project_no = $_POST['project_name'];
	$New_id = $_POST['stu_id'];
	$num = sizeof($New_id);
//轉換成以personal_id維編號
	$New_id = to_personal_id_array($New_id);
	$res = check_if_exists($New_id, $Begin_course_cd, $Homework_no);	//錯誤檢查
	//print_r($New_id);
	$New_array = array();
	array_push($New_array,$New_id);
	if($res == 1){
		insert2DB($New_array, $num, $Group_number, $Homework_no, $Project_no, $Group_name);
		echo "<center><span class=\"imp\">您已申請分組!</span></center>";
	}
}


//列出題目
$sql = "select * from projectwork where
	 begin_course_cd = '$Begin_course_cd' and homework_no = '$Homework_no'
	 and groupno_topic = '0' or groupno_topic = '$Group_no';";
$result = $DB_CONN->query($sql);
if(PEAR::isError($result))	die($result->userinfo);

while($row = $result->fetchRow(DB_FETCHMODE_ASSOC)){
	$Project_no = $row['project_no'];
	$sql = "select * from info_groups where project_no = '$Project_no';";
	$num = $DB_CONN->query($sql);
	$row['num'] = $num->numRows();
	$smtpl->append("projectwork_list", $row);
}

//取得組別編號
//檢查是否已完成分組
$sql = "select * from groups_member where student_id = '$Personal_id' and homework_no = '$Homework_no'";
$group_result = $DB_CONN->query($sql);
if(PEAR::isError($group_result))	die($group_result->userinfo);
$row = $group_result->fetchRow(DB_FETCHMODE_ASSOC);

//判斷是否已分組
if($group_result->numRows() == 1){
	$smtpl->append("text","您已經完成分組。");
	$smtpl->assign("Groupped",1);
}
else{
	$smtpl->assign("Groupped",0);
	for($i = 0 ; $i < $Group_member ; $i++){
		$smtpl->append("text","<input type=\"text\" name=\"stu_id[]\" size=\"10\" value=\"\">");
	}
}

$Group_no = $row['group_no'];

//插入組名
$sql = "select group_name from info_groups where homework_no = '$Homework_no' and group_no = '$Group_no'";
$Group_name = $DB_CONN->getOne($sql);
if(PEAR::isError($Group_name))	die($Group_name->userinfo);
$smtpl->assign("group_name",$Group_name);

//檢視是否可以自定題目
$sql = "select self_appointed from project_data where homework_no = '$Homework_no'";
$Self_subject = $DB_CONN->getOne($sql);
if(PEAR::isError($Self_subject))	die($Self_subject->userinfo);

$smtpl->assign("self_subject",$Self_subject);

assignTemplate($smtpl,"/collaborative_learning/student/sign_up_form.tpl");

?>
