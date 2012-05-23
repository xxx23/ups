<?php
/****************************************************************/
/* id: inter_group_score.php v1.0 2007/6/5 by hushpuppy Exp.    */
/* function: 合作學習 教師檢視 組間互評結果 介面	    		        */
/****************************************************************/

include "../../config.php";
require_once("../../session.php");

checkMenu("/Collaborative_Learning/teacher/tea_main_page.php");

$Begin_course_cd = $_SESSION['begin_course_cd'];
$Personal_id = $_SESSION['personal_id'];
$Group_no = $_GET['group_no'];
$Homework_no = $_GET['homework_no'];

$smtpl = new Smarty;
$smtpl->assign("Group_no",$Group_no);

//查詢組別
$sql = "select * from info_groups where 
	begin_course_cd = '$Begin_course_cd' and homework_no = '$Homework_no' order by group_no";
$res = $DB_CONN->query($sql);
if(PEAR::isError($res))	die($res->getMessage());
$total_sum = 0;
$group_num = 0; //紀錄有評分的組別數
while( $row = $res->fetchRow(DB_FETCHMODE_ASSOC) ){
	$assess_group_no = $row['group_no'];
	$score_sql = "select * from take_groups_score where homework_no = '$Homework_no'
		and take_group_no = '$Group_no' and group_no = '$assess_group_no' and assess_type = '0'";
	$score = $DB_CONN->query($score_sql);
	if(PEAR::isError($score))	die($score->getMessage());
	$num = $score->numRows();
	$person_array = array();
	$sum = 0;
	while( $score_row = $score->fetchRow(DB_FETCHMODE_ASSOC) ){
		$tmp = array();
		$personal_id = $score_row['assess_personal_id'];
		$name = return_name($personal_id);
		$tmp['name'] = $name;
		$tmp['score'] = $score_row['take_group_score'];
		
		array_push($person_array, $tmp);
		$sum += $tmp['score'];
	}
	//平均值
	$avg = 0;
	if($num != 0){
		$group_num++;
		$avg = $sum/$num;
	}
	$row['average'] = $avg;
	$total_sum += $avg;
	$row['group_score'] = $person_array;
	$smtpl->append("group_list",$row);
	//print_r($row);
}
if($group_num != 0)
	$ans = $total_sum / $group_num;
$smtpl->assign("total_avg", $ans);
$smtpl->assign("tpl_path",$tpl_path);
assignTemplate( $smtpl, "/collaborative_learning/teacher/inter_group_score.tpl");

//由personal_id取得personal_name
function return_name($id)
{
	global $DB_CONN;
	$sql = "select personal_name from personal_basic where personal_id = '$id'";
	$name = $DB_CONN->getOne($sql);
	if(PEAR::isError($name))	die($name->getMessage());
	return $name;
}
?>
