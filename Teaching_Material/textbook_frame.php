<?php
/*******************************************************/
/* id: textbook_frame.php 2007/11/12 by hushpuppy Exp. */
/* function: 教材另開新分頁		               */
/*******************************************************/

include "../config.php";
require_once("../session.php");
require_once("./lib/textbook_func.inc");

$Content_cd = $_GET['content_cd'];

if($_SESSION['role_cd'] != 4){
  checkMenu("/Teaching_Material/textbook_preview.php");
}
LEARNING_TRACKING_start(4, 1, $_SESSION['begin_course_cd'], $_SESSION['personal_id']); 

$sql = "select * from class_content where content_cd = '$Content_cd' order by cast(menu_parentid as unsigned) asc, seq asc;";
$AddNode = buildTreeStructure($sql, $Content_cd);
//更變為瀏覽而不是編輯
$AddNode = str_replace("tea_","stu_",$AddNode);

$smtpl = new Smarty;
$smtpl->assign("Content_cd",$Content_cd);

$Script_path = $WEBROOT . $JAVASCRIPT_PATH ;
$smtpl->assign("script_path", $Script_path);

$smtpl->assign("WEBROOT", $WEBROOT);
//print $AddNode;
//build tree
$smtpl->assign("addNode", $AddNode); 
//assign "課程科目教材編號" for inserting node
$smtpl->assign("Content_cd", $Content_cd);  

assignTemplate($smtpl, "/teaching_material/textbook_frame.tpl");
