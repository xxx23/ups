<?php
/* id: textbook_manage.php 2007/3/12 v1.0 by hushpuppy Exp. */
/* function: 教師教材管理頁面 */

include "../config.php";
require_once("../session.php");

//checkMenu("/Teaching_Material/course_manage_personal.php");

global $DATA_FILE_PATH, $MEDIA_FILE_PATH, $COURSE_FILE_PATH, $WEBROOT;

$tpl_path = $WEBROOT."themes/".$_SESSION['template'];
$template = $HOME_PATH."themes/".$_SESSION['template'];

$tpl = new Smarty;

$begin_course_cd = "";
if(isset($_GET['begin_course_cd']))
{
  	$begin_course_cd = $_GET['begin_course_cd'];
	$tpl->assign("op_begin_course_cd","?begin_course_cd=".$begin_course_cd);
	$res = db_query("UPDATE begin_course SET begin_coursestate='1' , note='".getCurTime()."' WHERE begin_course_cd=$begin_course_cd 
	  		AND exists(SELECT * FROM teach_begin_course WHERE begin_course_cd=$begin_course_cd AND teacher_cd=".getTeacherID().")");
}
else if(isset($_SESSION['begin_course_cd']))
{
	$begin_course_cd = $_SESSION['begin_course_cd'];
}

//判斷這個begin_course_cd是否是這位老師所有的exit(0);
$row = $DB_CONN->getRow("SELECT teacher_cd FROM teach_begin_course WHERE begin_course_cd = $begin_course_cd AND teacher_cd=".getTeacherID());
if($row == null)
{
	header("location:../identification_error.html");
	exit(0);
}
//course_cd更改
if(isset($_POST['submit_update'])){
	$course_cd = $_POST['course_cd'];
	$t = update_course_cd($begin_course_cd , $course_cd ,getTeacherId());
	if($t)
	{
		$tpl->assign("update_status" , "課程設定成功");
		//如果是在課程中修改的話要更改course_cd的Session值
		if(isset($_SESSION['begin_course_cd']))
		{
			$_SESSION['course_cd'] = $course_cd;
		}
	}
	else
	  	$tpl->assign("update_status","課程設定失敗");
}


//讀取目前的課程及教師ID
$sql = "SELECT course_name , login_id FROM begin_course INNER JOIN course_basic ON begin_course.course_cd=course_basic.course_cd INNER JOIN register_basic
  	ON course_basic.teacher_cd = register_basic.personal_id 
	WHERE begin_course_cd = $begin_course_cd";
$row = db_getRow($sql);
if($row != null)
{
  	$tpl->assign("course_name",$row['course_name']);
	$tpl->assign("teacher_name",$row['login_id']);
}
else
{
	$tpl->assign("course_name","尚未指定");
	$tpl->assign("teacher_name","尚未指定課程");
}


//讀取個人現有課程
$sql = "SELECT * FROM course_basic WHERE teacher_cd=".getTeacherId();
$res = db_query($sql);

while(($row = $res->fetchRow(DB_FETCHMODE_ASSOC)) != false)
{
	$tpl->append("course_list_options_values",$row['course_cd']);
	$tpl->append("course_list_options_output",$row['course_name']);
}

assignTemplate($tpl,"/course/course_manage.tpl");


//更新course_cd
function update_course_cd($begin_course_cd , $course_cd , $teacher_cd)
{
  	global $DB_CONN;

	$sql = "UPDATE begin_course
			SET course_cd = $course_cd
			WHERE begin_course_cd = $begin_course_cd and
				exists( SELECT * FROM teach_begin_course WHERE begin_course_cd=$begin_course_cd AND teacher_cd = $teacher_cd)";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))
	{
		die($res->getMessage());
		return false;
	}

	return true;
}

?>
