<?php
/* id: textbook_manage.php 2007/3/12 v1.0 by hushpuppy Exp. */
/* function: 教師教材管理頁面 */

include "../config.php";
require_once("../session.php");

//checkMenu("/Teaching_Material/course_manage_personal.php");

global $DATA_FILE_PATH, $MEDIA_FILE_PATH, $COURSE_FILE_PATH;

$tpl_path = "/themes/".$_SESSION['template'];
$template = $HOME_PATH."themes/".$_SESSION['template'];


$tpl = new Smarty;

//課程新增
if(isset($_POST['submit_create'])){
  $tmp = strpos($course_name, "/");
  if(is_numeric(strpos($course_name, "/")) || is_numeric(strpos($course_name, "\\")) ){
      echo "<script>alert(\"警告!你所輸入課程名稱包含不合法字元!\");</script>";
  }
  else{
	$teacher_cd = getTeacherId();
	$course_name = $_POST['course_name'];
	$need_validate_select = $_POST['need_validate_select'];
	$schedule_unit = $_POST['schedule_unit'];
	$is_public = "0";
	$t = create_course($teacher_cd , $course_name , $need_validate_select , $is_public , $schedule_unit);
	if($t)
		$tpl->assign("create_status" , "課程建立成功");
	else
	  	$tpl->assign("create_status","課程建立失敗");
  }
}

//開放旁聽
$tpl->assign("need_validate_select_options_values" , array("0" , "1"));
$tpl->assign("need_validate_select_options_selected" , "0");
$tpl->assign("need_validate_select_options_output" , array("不開放旁聽" , "開放旁聽"));

//課程科目時程單位
$tpl->assign("schedule_unit_options_values" , array("月份" , "週" , "天" , "次" , "時"));
$tpl->assign("schedule_unit_options_selected" , "週");
$tpl->assign("schedule_unit_options_output" , array("月份" , "週" , "天" , "次" , "時"));

//讀取現有課程
$sql = "SELECT * FROM course_basic WHERE teacher_cd=".getTeacherId();
$res = db_query($sql);

while(($row = $res->fetchRow(DB_FETCHMODE_ASSOC)) != false)
{
	$tpl->append("course_list_options_values",$row['course_cd']);
	$tpl->append("course_list_options_output",$row['course_name']);
}

assignTemplate($tpl,"/course/course_manage_personal.tpl");


//建立新課程
function create_course($teacher_cd , $course_name , $need_validate_select , $is_public , $schedule_unit)
{
  	global $DB_CONN;

	$sql = "INSERT INTO course_basic
			( teacher_cd , course_name , need_validate_select , is_public , schedule_unit ) 
			VALUES
			( $teacher_cd , '$course_name' , '$need_validate_select' , '$is_public' , '$schedule_unit')";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))
	{
		die($res->getMessage());
		return false;
	}

	return true;
}

?>
