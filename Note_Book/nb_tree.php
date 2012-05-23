<?php
/**************************************************************/
/* id: nb_Tree.php v1.0 2007/10/5 by hushpuppy Exp. 		  */
/* function: 由資料庫中取出資料建筆記本樹狀結構,				 	  */
/**************************************************************/

include "../config.php";
require_once("../session.php");
require_once("./lib/notebook_func.inc");

//checkMenu("/Teaching_Material/textbook_manage.php");

global $Begin_course_cd ;	//開課編號
global $DB_CONN;

$Notebook_cd = $_GET['notebook_cd'];
$Personal_id = $_SESSION['personal_id'];
$sql = "select * from notebook_content where notebook_cd = '$Notebook_cd' order by seq asc;";

$AddNode = buildTreeStructure($sql, $Notebook_cd);

$smtpl = new Smarty;

//print $AddNode;
$smtpl->assign("addNode",$AddNode); //build tree
$smtpl->assign("Notebook_cd",$Notebook_cd);	//assign "課程科目教材編號" for inserting node

//找出這位人員的所有筆記本
$sql = "select * from personal_notebook where personal_id = '$Personal_id;'";
$result = $DB_CONN->query($sql);
if(PEAR::isError($result))      die($result->getMessage());
$array = array('0' => '-選擇筆記本-');
while($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
    $i = $row['notebook_cd'];
    $array[$i] = $row['notebook_name'];
}
$smtpl->assign("tbArray",$array);

assignTemplate($smtpl, "/note_book/nb_tree.tpl");

?>