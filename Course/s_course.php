<?php
//ini_set('display_errors',1);
//error_reporting(E_ALL);
include("../config.php");
include('../session.php');
require_once("course_info.php");

  if(!isset($_SESSION['personal_id']))
      identification_error();
  $tpl_path = "/themes/".$_SESSION['template'];


  global $DB_CONN, $HOME_PATH;
  $tpl = new Smarty;

  $pid = $_SESSION['personal_id'];
  $role = $_SESSION['role_cd'];
  $begin_course_cd = $_SESSION['begin_course_cd'];
  $tpl->assign("begin_course_cd", $begin_course_cd);

  $result = db_query("select personal_name, photo from `personal_basic` where personal_id=$pid;");
  $row = $result->fetchRow(DB_FETCHMODE_ASSOC);
  $tpl->assign("name", $row['personal_name']);
  $tpl->assign("photo", $row['photo']);
  $tpl->assign("role",$role);

  $fname = array("displayAdmin", "displayTeach", "displayAssis", "displayStudy", "displayOther");
  call_user_func($fname[$role], $tpl, $pid);
  $course_name = $DB_CONN->getOne("select begin_course_name from `begin_course` where begin_course_cd=$begin_course_cd;");
  $tpl->assign("course_name", $course_name);

  $tmp = role_visibility($role, null, 0, 3, $begin_course_cd);
  $set = personal_visibility($tmp ,$pid);
  //echo "<pre>";print_r($set);echo "</pre>";
  setSystemTool("系統工具", "功能設定");
  //濾掉使用者不想顯示的
  $set = setUndisplay($set, 0, 3);
  //為了保證無論如何使用者都可以看到功能設定此一選項
  $tpl->assign("level_0", $set);

  //div的順序
  $seq = $DB_CONN->getOne("select course_div from `personal_basic` where personal_id=$pid;");
  assignNotebook($tpl);
  assignTemplate($tpl, "/course/s_index.tpl");

function displayAdmin($tpl, $pid){
}

function displayTeach($tpl, $pid){
        //$result = db_query("select B.begin_course_cd, B.begin_course_name from `teach_begin_course` A, `begin_course` B where A.teacher_cd=$pid and B.begin_course_cd=A.begin_course_cd;"); 
        $result = db_query("select B.begin_course_cd, B.begin_course_name from `teach_begin_course` A, `begin_course` B, `lrtunit_basic_` C
	  where A.teacher_cd=$pid and B.begin_course_cd=A.begin_course_cd and C.unit_cd=B.begin_unit_cd and B.note IS NOT NULL");
	$n = $result->numRows();
	echo "flag_n=".$n;
	while(($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) != false){
                $tpl->append("all_course", $row);
        }
}

function displayAssis($tpl, $pid){
}

function displayStudy($tpl, $pid){
//$result = db_query("select A.begin_course_cd, B.begin_course_name from `take_course` A, `begin_course` B where A.personal_id=$pid and B.begin_course_cd=A.begin_course_cd and A.allow_course=1;");
  $result = db_query("select A.begin_course_cd, B.begin_course_name from `take_course` A, `begin_course` B, `lrtunit_basic_` C
          where
	                 A.personal_id=$pid and
		                        B.begin_course_cd=A.begin_course_cd and
			                        C.unit_cd=B.begin_unit_cd and
				                 A.allow_course=1 and
				                  (A.course_end > NOW() or A.course_end is NULL) and
				                  B.note IS NOT NULL order by B.attribute");

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
                if(!isset($input[$i]['checked']))
                        $input[$i]['checked'] = 1;
                if($input[$i]['checked'] == 1){
                        $set[$i] = $input[$i];
                        $set[$i]['next'] = setUndisplay($input[$i]['next'], $lvl+1, $stop);
                }
        }
        return $set;
}
function setSequence($input){
        if(strlen($input) != 12)
                return "1^2^3^4^5^6^";
        return $input;
}

//add by puppy
function assignNotebook($tpl){
  $Personal_id = $_SESSION['personal_id'];
  $sql = "select * from personal_notebook where personal_id = '$Personal_id'";
  $result = db_query($sql);
  $row = $result->fetchRow(DB_FETCHMODE_ASSOC);
  $tpl->assign("Notebook_cd",$row['notebook_cd']);
}


?>
