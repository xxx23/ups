<?php
include "../config.php";
require_once("../session.php");
//require_once($HOME_PATH. 'library/smarty_init.php');

$Content_cd = $_GET['content_cd'];

$sql = "select content_name from course_content where content_cd = ".$Content_cd ;
$Caption = db_getOne($sql);

$tpl = new Smarty;
$tpl->assign("Content_cd",$Content_cd);	//assign "課程科目教材編號"
$tpl->assign("Caption",$Caption);	//assign "課程科目教材名稱"

    $sql = "SELECT A2.caption AS caption, A3.login_id AS login_id, A1.page AS page , A1.content AS content
        FROM error_content_report A1, class_content A2, register_basic A3 
        WHERE A1.content_cd = ".$Content_cd."
		AND A1.enable = 1
        AND A1.menu_id = A2.menu_id
        AND A1.personal_id = A3.personal_id
        ORDER BY A1.menu_id ASC";

$result = db_query($sql);
$cnt = 0;
while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
{
		$tpl->append("content2",$row);
		$cnt++;
}
$tpl->assign("cnt",$cnt);	//錯誤筆數
assignTemplate( $tpl,"/teaching_material/textbook_error_content.tpl");


?>
