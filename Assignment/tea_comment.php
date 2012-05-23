<?php
/*author: lunsrot
 * date: 2007/04/03
 */
require_once("../config.php");
require_once("../session.php");


$option = $_GET['option'];
if(!isset($option))
 $option = $_POST['option'];

checkMenu("/Assignment/tea_assignment.php");

switch($option){
case "view": display_comment(); break;
case "update": update_comment(); break;
default: break;
}

function display_comment(){
	$pid = $_GET['pid'];
	$tpl = new Smarty;

	$result = db_query("select homework_name from `homework` where homework_no=".$_SESSION['homework_no'].";");
	$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
	$tpl->assign("name", $row['homework_name']);
	$result = db_query("select comment from `handin_homework` where homework_no=".$_SESSION['homework_no']." and personal_id=$pid;");
	$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
	$tpl->assign("comment", $row['comment']);
	$tpl->assign("pid", $pid);

	assignTemplate($tpl, "/assignment/edit_comment.tpl");
}

function update_comment(){
  $pid = $_POST['pid'];
  $comment = $_POST['comment'];

  db_query("update `handin_homework` set comment='$comment' where personal_id=$pid and homework_no=".$_SESSION['homework_no'].";");
  header("location: tea_correct.php?homework_no=" . $_SESSION['homework_no'] . "&y_submitted.tplview=true&option=list_all");
}
?>
