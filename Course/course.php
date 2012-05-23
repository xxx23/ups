<?php
/*author: lunsrot
 * date: 2007/03/12
 * modify: 2007/03/28
 */
require_once("../config.php");
require_once("../session.php");
require_once("course_info.php");
require_once($HOME_PATH.'library/smarty_init.php') ; 


global $DB_CONN, $HOME_PATH, $SMARTY, $tpl;


$pid = $_SESSION['personal_id'];
$role = $_SESSION['role_cd'];
$begin_course_cd = $_SESSION['begin_course_cd'];
$tpl->assign("begin_course_cd", $begin_course_cd);

//$result = db_query("select personal_name, photo from `personal_basic` where personal_id=$pid;");
//add by aeil
$sql = "select personal_name, photo from `personal_basic` where     personal_id=$pid;";
	$result = $DB_CONN->query($sql);
$res = $result;
	if (PEAR::isError($res))	die($res->getMessage());
	
	if( ($res->numRows()) == 0)//帳號密碼錯誤
	{
		//導向回首頁
		loginFail(1);
	}
      //end
$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
$tpl->assign("name", $row['personal_name']);
$tpl->assign("photo", $row['photo']);

$fname = array("displayAdmin", "displayTeach", "displayAssis", "displayStudy", "displayOther");
call_user_func($fname[$role], $tpl, $pid);
$course_name = $DB_CONN->getOne("select begin_course_name from `begin_course` where begin_course_cd=$begin_course_cd;");
$tpl->assign("course_name", $course_name);

//如果是自學式課程再過濾一次
$attribute = $DB_CONN->getOne("select attribute from `begin_course` where begin_course_cd=$begin_course_cd;");
$tmp = role_visibility($role, null, 0, 3, $begin_course_cd,$attribute);
//echo "<pre>$$$";print_r($set);echo "</pre>";
$set = personal_visibility($tmp ,$pid,$begin_course_cd);
setSystemTool("系統工具", "功能設定");
//濾掉使用者不想顯示的
$set = setUndisplay($set, 0, 3);


//為了保證無論如何使用者都可以看到功能設定此一選項
$tpl->assign("level_0", $set);

//div的順序
$seq = $DB_CONN->getOne("select course_div from `personal_basic` where personal_id=$pid;");
$seq = setSequence($seq);
$tpl->assign("role",$role);
$tpl->assign("seq", $seq);
$tpl->assign("lang", $_SESSION['lang']) ;
assignNotebook($tpl);


assign_sudo_admin_url($tpl);
assignTemplate($tpl, "/course/index.tpl");

function displayAdmin($SMARTY, $pid){
}

function displayTeach($SMARTY, $pid){
	$result = db_query("select B.begin_course_cd, B.begin_course_name from `teach_begin_course` A, `begin_course` B where A.teacher_cd=$pid and B.begin_course_cd=A.begin_course_cd;");
	while(($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) != false){
		$SMARTY->append("all_course", $row);
	}
}

function displayAssis($SMARTY, $pid){
}

function displayStudy($SMARTY, $pid){
    $result = db_query("select A.begin_course_cd, B.begin_course_name from `take_course` A, `begin_course` B 
                        where A.personal_id=$pid 
                        and B.begin_course_cd=A.begin_course_cd 
                        and A.allow_course=1
                        and (A.course_end > NOW() or A.course_end is NULL) 
                        and B.note IS NOT NULL 
                        order by B.attribute;");
	while(($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) != false){
		$SMARTY->append("all_course", $row);
	}
}

function displayOther($SMARTY, $pid){
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
function assignNotebook($SMARTY){
  $Personal_id = $_SESSION['personal_id'];
  $sql = "select * from personal_notebook where personal_id = '$Personal_id'";
  $result = db_query($sql);
  $row = $result->fetchRow(DB_FETCHMODE_ASSOC);
  $SMARTY->assign("Notebook_cd",$row['notebook_cd']);
}
?>
