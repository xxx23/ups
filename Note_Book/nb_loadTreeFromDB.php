<?php
/**************************************************************/
/* id: nb_loadTreeFromDB.php v1.0 2007/9/29 by hushpuppy Exp. */
/* function: 由資料庫中取出資料建筆記本樹狀結構,				 	  */
/**************************************************************/

//error_reporting(E_ALL);
include('../config.php');
include('../session.php');
include('./lib/notebook_func.inc');


global $Begin_course_cd ;	//開課編號


$Notebook_cd = $_GET['notebook_cd'];
$sql = "select * from notebook_content where notebook_cd = '$Notebook_cd' order by seq asc;";

$AddNode = buildTreeStructure($sql, $Notebook_cd);

$smtpl = new Smarty;


$smtpl->assign("addNode",$AddNode); //build tree
$smtpl->assign("Notebook_cd",$Notebook_cd);	//assign "課程科目教材編號" for inserting node
$smtpl->assign("WEBROOT",$WEBROOT);

assignTemplate($smtpl, "/note_book/notebook.tpl");
?>