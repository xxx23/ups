<?php
/* id: tea_loadTreeFromDB.php 2007/2/8 by hushpuppy Exp. */
/* function: 由資料庫中取出資料建課程樹狀結構,教師身分使用 */


include "../config.php";
require_once("../session.php");
include("./lib/textbook_func.inc");

checkMenu("/Teaching_Material/textbook_manage.php");

$Content_cd = $_GET['content_cd'];

$sql = "select * from class_content where content_cd = $Content_cd order by cast(menu_parentid as unsigned) asc, seq asc;";

$AddNode = buildTreeStructure($sql, $Content_cd);

$smtpl = new Smarty;
$Script_path = $WEBROOT . $JAVASCRIPT_PATH ;
$smtpl->assign("script_path", $Script_path);
$smtpl->assign("WEBROOT", $WEBROOT);
//print $AddNode;
$smtpl->assign("addNode", $AddNode); //build tree
$smtpl->assign("Content_cd", $Content_cd);	//assign "課程科目教材編號" for inserting node

assignTemplate($smtpl, "/teaching_material/tea_textbook.tpl");
?>
