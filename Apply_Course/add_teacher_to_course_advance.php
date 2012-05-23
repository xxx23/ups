<?php
/***
FILE:   
DATE:   
AUTHOR: zqq
**/

$RELEATED_PATH = "../";
require_once($RELEATED_PATH . "config.php");
require_once($RELEATED_PATH . "session.php");
//update_status ( "確認開課中" );
$template = $_SESSION['template_path'] . $_SESSION['template'];
$tpl_path = "../themes/" . $_SESSION['template'];

	//new smarty	
	$tpl = new Smarty();
	//echo "<pre></pre>";
	//init
	if(isset($_GET[begin_course_cd])){
		$_SESSION[begin_course_cd]=$_GET[begin_course_cd];
	}
	//顯示剛輸入的課程資訊
	$sql = "SELECT * FROM begin_course WHERE begin_course_cd='".$_SESSION[begin_course_cd]."'";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$row = $res->fetchRow(DB_FETCHMODE_ASSOC);
	$tpl->assign("begin_course_name",	$row[begin_course_name] );
	$tpl->assign("begin_unit_cd",	getUnitNameByUnitCd($DB_CONN, $row[begin_unit_cd]) );
	$tpl->assign("inner_course_cd",	$row[inner_course_cd] );
	$tpl->assign("d_course_begin",	$row[d_course_begin] );
	$tpl->assign("d_course_end",	$row[d_course_end] );
	$tpl->assign("d_public_day",	$row[d_public_day] );
	$tpl->assign("d_select_begin",	$row[d_select_begin] );
	$tpl->assign("d_select_end",	$row[d_select_end] );
	$tpl->assign("course_year",		$row[course_year] );
	$tpl->assign("course_session",	$row[course_session] );
	
	$tpl->assign("coursekind",		getCourseKind($row[coursekind] ) );
	$tpl->assign("timeSet",			getTimeSet($row[timeSet] ) );
	$tpl->assign("charge_type",		getChargeType($row[charge_type] ) );			
	$tpl->assign("subsidizeid",		getSubsidizeid($row[subsidizeid] ) );
	
	$tpl->assign("certify_type", 	getCertifyType($row[certify_type]) );
	$tpl->assign("quantity", 		$row[quantity] );
	$tpl->assign("locally", 		$row[locally] );
	
	$tpl->assign("charge", 			$row[charge] );
	$tpl->assign("subsidize_money",	$row[subsidize_money] );
	
	$tpl->assign("course_cd",		$row[course_cd]);
	$tpl->assign("begin_course_cd",	$row[begin_course_cd]);		
	//判斷是否要新增 if action = addTeacher
	if($_GET[action] == 'addTeacher'){
		if(!addTeacher($DB_CONN, $_POST[begin_course_cd], $_POST[teacher_cd], $_POST[course_master])){
			$tpl->assign( "err_message","教師已經存在");
		}
		else{
			$tpl->assign( "err_message","新增成功");		
		}	
	}
	else if($_GET[action] == 'deleteTeacher'){
		$sql = "DELETE FROM teach_begin_course WHERE begin_course_cd='".$_GET[begin_course_cd]."' and teacher_cd='".$_GET[teacher_cd]."'";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
	}
	
	//顯示這門課的教師
	$sql = "SELECT p.personal_id, r.login_id, p.personal_name, t.course_master FROM teach_begin_course t, personal_basic p, register_basic r WHERE t.begin_course_cd='".$_SESSION[begin_course_cd]."'  and t.teacher_cd=p.personal_id and p.personal_id=r.personal_id";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$course_master = false;	
	while($row = $res->fetchRow(DB_FETCHMODE_ASSOC)){		
		if($row[course_master]){
			$row[course_master]='Yes';
			$course_master = true;
		}
		else
			$row[course_master]='No';	
		$tpl->append('teacher_data', $row);	
	}	
	
	//顯示新增教師的地方
	//查出所有的教師
	$sql = "SELECT p.personal_id, p.personal_name, r.login_id FROM personal_basic p, register_basic r WHERE p.personal_id=r.personal_id and r.role_cd='1'";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());	
	$teacher_num = $res->numRows();
	for($i=0; $i< $teacher_num; $i++){
		$teacher_data = $res->fetchRow(DB_FETCHMODE_ASSOC);
		$teacher_names[$i] = $teacher_data[personal_name]."\t(".$teacher_data[login_id].")";
		$teacher_ids[$i] = $teacher_data[personal_id];
	}	
	$tpl->assign("teacher_ids",	$teacher_ids );
	$tpl->assign("teacher_id",	$teacher_ids[0] );
	$tpl->assign("teacher_names", $teacher_names );	
	//是否為主要填寫者
	if(!$course_master){
		$tpl->assign("course_master_ids", array(0, 1));
		$tpl->assign("course_master_id",1);
		$tpl->assign("course_master_names", array('No', 'Yes'));	
	}
	else{
		$tpl->assign("course_master_ids", array(0));
		$tpl->assign("course_master_id",0);
		$tpl->assign("course_master_names", array('No'));
		$tpl->assign("message", "已經有主要填寫者");		
	}
	//輸出頁面
	$tpl->assign("tpl_path", "../themes/" . $_SESSION['template']);	
	//$tpl->display("add_teacher_to_course_advance.tpl");	
	$tpl->display($_SESSION['template_path'] . $_SESSION['template'] . "/course_admin/add_teacher_to_course_advance.tpl");		
//------function area---------

function getCertifyType($type){

	$tmp = array('','學分','等級','時','過or不過');
	return $tmp[$type];
}

function getUnitNameByUnitCd($DB, $unit_cd){

	$sql = "SELECT unit_name FROM lrtunit_basic_ WHERE unit_cd='$unit_cd'";
	return $DB->getOne($sql);
}

function getCourseKind($coursekind){
	$tmp = array('非學分班','學士學分班','碩士學分班','學士學位班','碩士學位班','非學分班 (校內研習)');
	return $tmp[$coursekind];
}

function getTimeSet($timeSet){
	//echo $timeSet;
	$tmp = array('0'=>'尚無資料','1'=>'週一至週五白天','2'=>'週一至週五晚上','3'=>'週末','4'=>'暑假','5'=>'寒假');
	$set = explode(",", $timeSet);
	//echo "<pre>".print_r($set, true)."</pre>";
	$time ='';
	for($i=0; $i < count($set); $i++){
		$time .= $tmp[$set[$i]] . "/";
	}
	return $time;
}

function getChargeType($charge_type){
	$tmp = array('1'=>'全額負擔','2'=>'學校部分補助','3'=>'無');
	return $tmp[$charge_type];
}

function getSubsidizeid($subsidizeid){
	$tmp = array('10'=>'教育部國教司','11'=>'教育部中教司','12'=>'教育部高教司','13'=>'教育部社教司','14'=>'教育部電算中心','15'=>'教育部訓育委員會','16'=>'教育部中部辦公室','17'=>'教育部其他單位','18'=>'縣市政府','19'=>'其他單位','20'=>'無接受補助');
	return $tmp[$subsidizeid];
}
/*
function getCourseClassify($DB, $course_cd ){
	$sql = "SELECT course_classify_cd, course_classify_parent FROM course_basic WHERE course_cd='$course_cd'";
	$res = $DB->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$row = $res->fetchRow(DB_FETCHMODE_ASSOC);	
	//用$row[course_classify_cd], $row[course_classify_parent] 查出所有性質
	$count = 0;
	$sql = "SELECT course_classify_cd, course_classify_name, course_classify_parent FROM lrtcourse_classify_ WHERE course_classify_cd='".$row[course_classify_cd]."'";
	//echo $sql;
	$res = $DB->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());		
	$classify = $res->fetchRow(DB_FETCHMODE_ASSOC);		
	$course_classify[$count++] =  $classify[course_classify_name];
	$course_classify_parent = $classify[course_classify_parent];	
	while(true){
		$sql = "SELECT course_classify_cd, course_classify_name, course_classify_parent FROM lrtcourse_classify_ WHERE course_classify_cd='$course_classify_parent'";
		//echo $sql;
		$res = $DB->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());		
		$classify = $res->fetchRow(DB_FETCHMODE_ASSOC);
		$course_classify[$count++] = $classify[course_classify_name];
		$course_classify_parent = $classify[course_classify_parent];
		if($classify[course_classify_parent] == 0)
			break;
	}	
	//將array組合成一個string return 
	for($i=count($course_classify)-1; $i >= 0; $i--){
		$string .= $course_classify[$i] ."/";
	}	
	return $string;
}
 */
function addTeacher($DB, $begin_course_cd, $teacher_cd, $course_master){
	//先查詢是否存在
	$sql = "SELECT count(*) FROM teach_begin_course WHERE begin_course_cd='$begin_course_cd' and teacher_cd='$teacher_cd'";
	$count = $DB->getOne($sql);
	if($count != 0)
		return false;
	else{
		$sql = "INSERT INTO teach_begin_course (begin_course_cd, teacher_cd, course_master) VALUES ( '$begin_course_cd', '$teacher_cd', '$course_master')";
		$res = $DB->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		//新增相關資料夾
				
	}
	return true;
}
?>
