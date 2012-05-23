<?php
/*author: lunsrot
 * date: 2007/03/12
 * modify: 2007/03/28
 */
require_once("../config.php");
require_once("../session.php");
require_once("course_info.php");

$tpl = new Smarty;

$pid = $_SESSION['personal_id'];
$role = $_SESSION['role_cd'];
$begin_course_cd = $_SESSION['begin_course_cd'];

$result = db_query("select personal_name from `personal_basic` where personal_id=$pid;");
$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
$tpl->assign("name", $row['personal_name']);

$fname = array("displayAdmin", "displayTeach", "displayAssis", "displayStudy", "displayOther");
call_user_func($fname[$role], $tpl, $pid);

$tmp = role_visibility($role, null, 0, 3);
$set = personal_visibility($tmp ,$pid);
//為了保證無論如何使用者都可以看到功能設定此一選項
setSystemTool("系統工具", "功能設定");
//濾掉使用者不想顯示的
$set = setUndisplay($set, 0, 3);
$tpl->assign("level_0", $set);

assignTemplate($tpl, "/course/index2.tpl");

function displayAdmin($tpl, $pid){
}

function displayTeach($tpl, $pid){
  $result = db_query("select B.begin_course_cd, B.begin_course_name from `teacher_course` A, `begin_course` B where A.teacher_cd=$pid and B.course_cd=A.course_cd;");
  while(($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) != false){
    $tpl->append("all_course", $row);
  }
}

function displayAssis($tpl, $pid){
}

function displayStudy($tpl, $pid){
  $result = db_query("select A.begin_course_cd, B.begin_course_name from `take_course` A, `begin_course` B where A.personal_id=$pid and B.begin_course_cd=A.begin_course_cd;");
  while(($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) != false){
    $tpl->append("all_course", $row);
  }
}

function displayOther($tpl, $pid){
}

function setUndisplay($input, $lvl, $stop){
  if($lvl >= $stop)
    return ;

  for($i = 0 ; $i < count($input) ; $i++){
    if($input[$i]['checked'] == 1){
      $set[$i] = $input[$i];
      $set[$i]['next'] = setUndisplay($input[$i]['next'], $lvl+1, $stop);
    }
  }
  return $set;
}
?>
