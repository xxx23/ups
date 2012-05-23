<?php
/******************************************************************/
/* id: tea_un_grouped_list.php v1.0 2007/7/7 by hushpuppy Exp.    */
/* function: 教師合作學習 檢視未分組名單				      		  */
/******************************************************************/

include "../../config.php";
require_once("../../session.php");

$Homework_no = $_GET['homework_no'];
$Begin_course_cd = $_SESSION['begin_course_cd'];
checkMenu("/Collaborative_Learning/teacher/tea_main_page.php");

$template = $HOME_PATH."themes/".$_SESSION['template'];
$tpl_path = "/themes/".$_SESSION['template'];

$smtpl = new Smarty;

//assign homewrok name
$sql = "select homework_name from homework where homework_no = '$Homework_no';";
$Homework_name = $DB_CONN->getOne($sql);
if(PEAR::isError($Homework_name))	die($Homework_name);
$smtpl->assign("homework_name",$Homework_name);

$sql = "SELECT * FROM register_basic rb, personal_basic pb, take_course tc
		WHERE tc.begin_course_cd = '$Begin_course_cd' 
		and tc.personal_id = rb.personal_id 
		and rb.personal_id = pb.personal_id
		and rb.role_cd = '3'";
    $res = $DB_CONN->query($sql);
    if(PEAR::isError($res))	die($res->getMessage());
	
	while( $row = $res->fetchRow(DB_FETCHMODE_ASSOC) ){
		//核准與身份確認
		if($row['allow_course'] )
		    $row['allow'] = "核准";
	    else
			continue;
    	    //$row['allow'] = "不核准";

	    if($row['status_student'] == 0)
        	$row['status'] = "旁聽生";
    	else
	        $row['status'] = "正修生";
			
		//驗證是否已報名	
		$id = $row['personal_id'];
		$sql = "select * from groups_member where homework_no = '$Homework_no' and begin_course_cd = '$Begin_course_cd'
		and student_id = '$id';";
		$result = $DB_CONN->query($sql);
	    if(PEAR::isError($result))	die($result->userinfo);
		if($result->numRows() == 1)
			continue;
		else
			$smtpl->append("name_list",$row);
	}
$smtpl->assign("tpl_path",$tpl_path);
assignTemplate( $smtpl, "/collaborative_learning/teacher/tea_un_grouped_list.tpl");

?>
