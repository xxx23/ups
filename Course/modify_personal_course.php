<?php
/* id: textbook_manage.php 2007/3/12 v1.0 by hushpuppy Exp. */
/* function: 教師教材管理頁面 */

include "../config.php";
require_once("../session.php");

//checkMenu("/Teaching_Material/course_manage_personal.php");

global $DATA_FILE_PATH, $MEDIA_FILE_PATH, $COURSE_FILE_PATH;

$tpl_path = "/themes/".$_SESSION['template'];
$template = $HOME_PATH."themes/".$_SESSION['template'];

//ini_set('display_errors',1);
//error_reporting(E_ALL);
$tpl = new Smarty();
$course_cd = "";

//進入編輯
if(isset($_POST['submit_modify2'])){
  	$course_cd = $_POST['course_cd'];
	$teacher_cd = getTeacherId();
  	$course_name = $_POST['course_name'];
  	$need_validate_select = $_POST['need_validate_select'];
  	$schedule_unit = $_POST['schedule_unit'];
  	$is_public = "0";
  	$t = modify_course($course_cd , $teacher_cd , $course_name , $need_validate_select , $is_public , $schedule_unit);
  	if($t)
  	  	$tpl->assign("modify_status" , "課程更新成功");
  	else
  	  	$tpl->assign("midify_status","課程更新失敗");
}
//echo $_POST['course_list']."<br/>";
//讀取課程資料
if(isset($_POST['course_list']))
	$course_cd = $_POST['course_list'];
else
    $course_cd = $_POST['course_cd'];

//echo "test course_cd".$course_cd;
$tpl->assign("course_cd",$course_cd);
$sql = "SELECT * FROM course_basic WHERE teacher_cd=".getTeacherId()." and course_cd=$course_cd";
$row = db_getRow($sql);
$tpl->assign("course_name",$row['course_name']);
$tpl->assign("need_validate_select_options_selected",$row['need_validate_select']);
$tpl->assign("schedule_unit_options_selected",$row['schedule_unit']);

//開放旁聽
$tpl->assign("need_validate_select_options_values" , array("0" , "1"));
$tpl->assign("need_validate_select_options_output" , array("不開放旁聽" , "開放旁聽"));

//課程科目時程單位
$tpl->assign("schedule_unit_options_values" , array("月份" , "週" , "天" , "次" , "時"));
$tpl->assign("schedule_unit_options_output" , array("月份" , "週" , "天" , "次" , "時"));

$tpl->assign("op_course_cd","?course_cd=".$course_cd);
assignTemplate($tpl,"/course/modify_personal_course.tpl");


//編輯課程
function modify_course($course_cd , $teacher_cd , $course_name , $need_validate_select , $is_public , $schedule_unit)
{
  	global $DB_CONN;

	$sql = "UPDATE course_basic SET course_name = '$course_name' , need_validate_select = '$need_validate_select' , is_public = '$is_public' , schedule_unit = '$schedule_unit'
	  		WHERE teacher_cd=$teacher_cd and course_cd=$course_cd";

	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))
	{
		die($res->getMessage());
		return false;
	}

	return true;
}

?>
