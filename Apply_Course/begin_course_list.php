<?php
/**
 * 列出開課帳號已開課之列表
 *
**/

$RELEATED_PATH = "../";
require_once($RELEATED_PATH . "config.php");
require_once('session.php');

check_access("begin_course_list");	

$tpl = new Smarty ; 

$no = $_SESSION['no'] ; 
//$no = 0; 
if(!isset($_SESSION['no']) ) {
	die("連線逾時，請重新登入");
}


//列出所有還沒真正開好的課
$list_begincourse = " SELECT * FROM begin_course WHERE begin_coursestate!=1 AND applycourse_no=".$no. " order by begin_course_cd desc ";
$courses = db_getAll($list_begincourse) ; 



//系所 (課程性質) 產生unit_cd => unit_name  對應
$maping_unit_cd_2_name = " SELECT unit_cd , unit_name FROM lrtunit_basic_ " ; 
$result = db_query($maping_unit_cd_2_name);
while($row = $result->fetchRow(DB_FETCHMODE_ASSOC) ) {
	$unit_cd_mapping[$row['unit_cd']] = $row['unit_name'] ;
}


foreach($courses as $k => $v )   {

	if( !empty($v['begin_unit_cd']) )
		$unit_name = $unit_cd_mapping [ $v['begin_unit_cd'] ] ; 
	else 
		$unit_name ='無' ;
		
	$courses[$k]['unit_name'] = $unit_name;
	
	
	//找出修課教師
	$get_tea_name = " SELECT personal_name FROM teach_begin_course tbc, personal_basic pb WHERE tbc.teacher_cd=pb.personal_id AND begin_course_cd = " . $v['begin_course_cd'] ; 
	$names_res = db_query($get_tea_name);
	
	unset($names_line);
	while($row = $names_res->fetchRow(DB_FETCHMODE_ASSOC) ) {
		$names_line .= $row['personal_name'] . ',<br/>';
	}
	$courses[$k]['personal_name'] = $names_line ;
	$courses[$k]['course_state'] = $begin_course_state[ $v['begin_coursestate'] ];
}

$tpl->assign('course_data', $courses);
//輸出頁面                                      
assignTemplate($tpl, "/apply_course/begin_course_list.tpl");

?>