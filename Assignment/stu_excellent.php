<?php
/*author: lunsrot
 * date: 2007/04/03
 */
require_once("../config.php");
require_once("../session.php");
require_once("ass_info.php");

$no = $_GET['homework_no'];
$option = $_GET['option'];

switch($option){
case "list_all": display_excellent($no); break;
case "list_single": answer_view($no); break;
default: break;
}

function display_excellent($no){
	$tpl = new Smarty;

	$result = db_query("select A.personal_id, B.personal_name from `handin_homework` A, `personal_basic` B where A.homework_no=$no and A.public=1 and B.personal_id=A.personal_id;");
	while(($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) != false){
		$row['homework_no'] = $no;
		$tpl->append("works", $row);
	}

	assignTemplate($tpl, "/assignment/stu_excell_view.tpl");
}

function answer_view($no){
	global $DB_CONN;
	$pid = $_GET['pid'];
	$tpl = new Smarty;

	$name = $DB_CONN->getOne("select homework_name from `homework` where homework_no=$no;");
	$tpl->assign('name', $name);

	$result = db_query("select work, type from `handin_homework` where homework_no=$no and personal_id=$pid order by personal_id;");
	$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
	$tpl->assign("isupload", $row['type']);
	$path = replyPath($_SESSION['begin_course_cd'], $no, $pid);
	$_SESSION['current_path'] = $path;

	if(!empty($row['type'])){
		$tpl->assign("isupload", 1);
		$tpl->assign("path",  $row['work']);
	}
	$tpl->assign("answer", $row['work']);
	if(empty($row['type'])){
		$login_id = $DB_CONN->getOne("select login_id from `register_basic` where personal_id=$pid;");
		$row['work'] = "$login_id.html";
	}
	downloadRelativeFile($tpl, $path, $row['work']);

	$name = $DB_CONN->getOne("select personal_name from `personal_basic` where personal_id=$pid;");
	$tpl->assign('title', $name);

	assignTemplate($tpl, "/assignment/student_answer.tpl");
}
?>
