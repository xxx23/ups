<?php
include "../config.php";
require_once("../session.php");

checkMenu("/Teaching_Material/textbook_manage.php");
$Begin_course_cd = $_SESSION['begin_course_cd'];
$_SESSION['self_textbook'] = '0';

//$Teacher_cd = $_SESSION['personal_id'];
$Teacher_cd = getTeacherId();

$sql = "select content_cd from class_content_current where begin_course_cd = '$Begin_course_cd';";
$Content_cd = db_getOne($sql);

if(!isset($Content_cd) || $Content_cd == 0)
	die("您尚未選取本課程教材，請由\"授課教材管理\"選取。");

	
	
$tpl = new Smarty;
//require_once($HOME_PATH . 'library/smarty_init.php');

    $sql = "SELECT A1.id, A4.content_name AS name, A2.caption AS caption, A3.login_id AS checker, A1.page AS page , A1.content AS content, A1.reportdate AS reportdate
        FROM error_content_report A1, class_content A2, register_basic A3 , course_content A4
        WHERE A1.enable = 0
		AND A1.content_cd = $Content_cd
        AND A1.menu_id = A2.menu_id
        AND A1.personal_id = A3.personal_id
		AND A2.content_cd = A4.content_cd
        ORDER BY A1.reportdate ASC";


$result = db_query($sql);
$cnt = 0;


while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
{
		$tpl->append("content2",$row);
		$cnt++;

}

$tpl->assign("cnt",$cnt);

assignTemplate($tpl, '/teaching_material/tea_textbook_error_check.tpl');
?>
