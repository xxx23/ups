<?php
/* id: loadTreeFromDB.php 2007/2/8 by hushpuppy Exp. */
/* function: 由資料庫中取出資料建課程樹狀結構 */

include "../config.php";
require_once("../session.php");
require_once("./lib/textbook_func.inc");

if($_SESSION['role_cd'] != 4)
  checkMenu("/Teaching_Material/textbook_preview.php");

LEARNING_TRACKING_start(4, 1, $_SESSION['begin_course_cd'], $_SESSION['personal_id']); 
//$Begin_course_cd = $_SESSION['begin_course_cd'];
$Content_cd = $_GET['content_cd'];

$sql = "select * from class_content where content_cd = '{$Content_cd}' order by cast(menu_parentid as unsigned) asc, seq asc;";

  //joyce----------0312
  //add the third variable in func:buildTreeStructure to know whether the tree bulid in frame or not

  $AddNode = buildTreeStructure($sql,$Content_cd,1);

  //因為存進DB中的各個node，其url都為呼叫tea_textbook_content.php，但student進入時必須處理stu_textbook_content.php
  //故將"tea_"替換為"stu_"
  $AddNode = str_replace("tea_","stu_",$AddNode);



$smtpl = new Smarty;
$Script_path = $WEBROOT.$JAVASCRIPT_PATH ;
$smtpl->assign("script_path",$Script_path);
$smtpl->assign("WEBROOT",$WEBROOT);

$smtpl->assign("addNode",$AddNode); //build tree
$smtpl->assign("Content_cd",$Content_cd);	//assign "課程科目教材編號" for inserting node

assignTemplate( $smtpl,"/teaching_material/tree_frame.tpl");
?>
