<?php
/* id: loadTreeFromDB.php 2007/2/8 by hushpuppy Exp. */
/* function: �Ѹ�Ʈw�����X��ƫؽҵ{�𪬵��c */

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

  //�]���s�iDB�����U��node�A��url�����I�stea_textbook_content.php�A��student�i�J�ɥ����B�zstu_textbook_content.php
  //�G�N"tea_"������"stu_"
  $AddNode = str_replace("tea_","stu_",$AddNode);



$smtpl = new Smarty;
$Script_path = $WEBROOT.$JAVASCRIPT_PATH ;
$smtpl->assign("script_path",$Script_path);
$smtpl->assign("WEBROOT",$WEBROOT);

$smtpl->assign("addNode",$AddNode); //build tree
$smtpl->assign("Content_cd",$Content_cd);	//assign "�ҵ{��رЧ��s��" for inserting node

assignTemplate( $smtpl,"/teaching_material/tree_frame.tpl");
?>
