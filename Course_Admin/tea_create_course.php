<?php
/***
FILE:   
DATE:   2006/12/11
AUTHOR: zqq


**/
	require_once("../config.php");
	session_start();

	if(!isset($_SESSION['values']['course_name']) ){
		$_SESSION['values']['course_name']				= getBeginCourseNameByBeginCourseCd($DB_CONN, $_SESSION[cur_begin_course_cd]);
		//$_SESSION['values']['course_classify_cd']		= '';
		//$_SESSION['values']['course_classify_parent']	= '';
		$_SESSION['values']['charge']					= '';
		$_SESSION['values']['need_validate_select']		= 0;
		$_SESSION['values']['is_public']				= 0;
		$_SESSION['values']['schedule_unit']			= '';
		$_SESSION['values']['introduction']				= '';
		$_SESSION['values']['future']					= '';
		$_SESSION['values']['goal']						= '';
		$_SESSION['values']['reguisition']				= '';
		$_SESSION['values']['audience']					= '';
		$_SESSION['values']['learning_test']			= '';
		$_SESSION['values']['prepare_course']			= '';
		$_SESSION['values']['mster_book']				= '';
		$_SESSION['values']['ref_book']					= '';
		$_SESSION['values']['ref_url']					= '';
		$_SESSION['values']['directory']				= '';
		$_SESSION['values']['index_file']				= '';
		$_SESSION['values']['content_maker']			= '';
		$_SESSION['values']['note']						= '';						
	}
	
	if(!isset($_SESSION['errors']['course_name'])){	
		$_SESSION['errors']['course_name']				= 'hidden';
		//$_SESSION['errors']['course_classify_cd']		= 'hidden';
		//$_SESSION['errors']['course_classify_parent']	= 'hidden';
		$_SESSION['errors']['charge']					= 'hidden';
		$_SESSION['errors']['need_validate_select']		= 'hidden';
		$_SESSION['errors']['is_public']				= 'hidden';
		$_SESSION['errors']['schedule_unit']			= 'hidden';
		$_SESSION['errors']['introduction']				= 'hidden';
		$_SESSION['errors']['future']					= 'hidden';
		$_SESSION['errors']['goal']						= 'hidden';
		$_SESSION['errors']['reguisition']				= 'hidden';
		$_SESSION['errors']['audience']					= 'hidden';
		$_SESSION['errors']['learning_test']			= 'hidden';
		$_SESSION['errors']['prepare_course']			= 'hidden';
		$_SESSION['errors']['mster_book']				= 'hidden';
		$_SESSION['errors']['ref_book']					= 'hidden';
		$_SESSION['errors']['ref_url']					= 'hidden';
		$_SESSION['errors']['directory']				= 'hidden';
		$_SESSION['errors']['index_file']				= 'hidden';
		$_SESSION['errors']['content_maker']			= 'hidden';
		$_SESSION['errors']['note']						= 'hidden';				
	}
	//new smarty
	$tpl = new Smarty();
	//echo $_SESSION['values']['course_name']."__";
	//-----------------------------
	$tpl->assign("valueOfCourse_name",$_SESSION['values']['course_name']);
	$tpl->assign("course_nameFailed",$_SESSION['errors']['course_name']);	

	//-----------------------------
	//$tpl->assign("valueOfCourse_classify_cd",$_SESSION['values']['course_classify_cd']);
	//$tpl->assign("course_classify_cdFailed",$_SESSION['errors']['course_classify_cd']);	

	//------------------------------
	//$tpl->assign("valueOfCourse_classify_parent",$_SESSION['values']['course_classify_parent']);
	//$tpl->assign("course_classify_parentFailed", $_SESSION['errors']['course_classify_parent']);	
	
	//-----------------------------
	$tpl->assign("valueOfCharge",$_SESSION['values']['charge']);
	$tpl->assign("chargeFailed",$_SESSION['errors']['charge']);	
	
	//----------------------------
	$tpl->assign("valueOfNeed_validate_select",$_SESSION['values']['need_validate_select']);
	$tpl->assign("need_validate_selectFailed",$_SESSION['errors']['need_validate_select']);	
	
	//-----------------------------
	$tpl->assign("valueOfIs_public",$_SESSION['values']['is_public']);
	$tpl->assign("is_publicFailed",$_SESSION['errors']['is_public']);	
	
	//------------------------------
	$tpl->assign("valueOfSchedule_unit",$_SESSION['values']['schedule_unit']);
	$tpl->assign("schedule_unitFailed",$_SESSION['errors']['schedule_unit']);	
	
	//-----------------------------
	$tpl->assign("valueOfIntroduction",$_SESSION['values']['introduction']);
	$tpl->assign("introductionFailed",$_SESSION['errors']['introduction']);		
	
	//-----------------------------
	$tpl->assign("valueOfFuture",$_SESSION['values']['future']);
	$tpl->assign("futureFailed",$_SESSION['errors']['future']);		
	
	//-----------------------------
	$tpl->assign("valueOfGoal",$_SESSION['values']['goal']);
	$tpl->assign("goalFailed",$_SESSION['errors']['goal']);		
	
	//----------------------------
	$tpl->assign("valueOfReguisition",$_SESSION['values']['reguisition']);
	$tpl->assign("reguisitionFailed",$_SESSION['errors']['reguisition']);		
	
	//------------------------------
	$tpl->assign("valueOfAudience",$_SESSION['values']['audience']);
	$tpl->assign("audienceFailed",$_SESSION['errors']['audience']);			
	
	//---------------------
	$tpl->assign("valueOfLearning_test",$_SESSION['values']['learning_test']);
	$tpl->assign("learning_testFailed",$_SESSION['errors']['learning_test']);			
	
	//---------------------------
	$tpl->assign("valueOfPrepare_course",$_SESSION['values']['prepare_course']);
	$tpl->assign("prepare_courseFailed",$_SESSION['errors']['prepare_course']);			
	
	//------------------------
	$tpl->assign("valueOfMster_book",$_SESSION['values']['mster_book']);
	$tpl->assign("mster_bookFailed",$_SESSION['errors']['mster_book']);		
	
	//-----------------------
	$tpl->assign("valueOfRef_book",$_SESSION['values']['ref_book']);
	$tpl->assign("ref_bookFailed",$_SESSION['errors']['ref_book']);		
	
	//-------------------------
	$tpl->assign("valueOfRef_url",$_SESSION['values']['ref_url']);
	$tpl->assign("ref_urlFailed",$_SESSION['errors']['ref_url']);		
	
	//---------------------------
	$tpl->assign("valueOfDirectory",$_SESSION['values']['directory']);
	$tpl->assign("directoryFailed",$_SESSION['errors']['directory']);	
	
	//---------------------------
	$tpl->assign("valueOfIndex_file",$_SESSION['values']['index_file']);
	$tpl->assign("index_fileFailed",$_SESSION['errors']['index_file']);	
	
	//-------------------------
	$tpl->assign("valueOfContent_maker",$_SESSION['values']['content_maker']);
	$tpl->assign("content_makerFailed",$_SESSION['errors']['content_maker']);		
	
	//---------------------------
	$tpl->assign("valueOfNote",$_SESSION['values']['note']);
	$tpl->assign("noteFailed",$_SESSION['errors']['note']);		
/*	
	//-----課程性質1
	$sql = "SELECT * FROM lrtcourse_classify_ WHERE course_classify_level='1' ORDER BY course_classify_cd ASC";
	$res = $DB_CONN->query($sql);
	$i=0;
	while($row_1 = $res->fetchRow(DB_FETCHMODE_ASSOC) ){
		$course_classify_1_ids[$i]	= $row_1['course_classify_cd'];
		$course_classify_1_names[$i]= $row_1['course_classify_name'];
		$i++;
	}
	$tpl->assign("course_classify_1_ids"	,$course_classify_1_ids);
	$tpl->assign("course_classify_1_names"	,$course_classify_1_names);
	$tpl->assign("course_classify_1_id"		,$course_classify_1_ids[0]);
	//-----課程性質2
	$sql = "SELECT * FROM lrtcourse_classify_ WHERE course_classify_level='2' and course_classify_parent='".$course_classify_1_ids[0]."' ORDER BY course_classify_cd ASC";
	$res = $DB_CONN->query($sql);
	$i=0;
	while($row_2 = $res->fetchRow(DB_FETCHMODE_ASSOC) ){
		$course_classify_2_ids[$i]	= $row_2['course_classify_cd'];
		$course_classify_2_names[$i]= $row_2['course_classify_name'];
		$i++;
	}	
	$tpl->assign("course_classify_2_ids"	,$course_classify_2_ids);
	$tpl->assign("course_classify_2_names"	,$course_classify_2_names);
	$tpl->assign("course_classify_2_id"		,$course_classify_2_ids[0]);	
	//-----課程性質3
	$sql = "SELECT * FROM lrtcourse_classify_ WHERE course_classify_level='3' and course_classify_parent='".$course_classify_2_ids[0]."' ORDER BY course_classify_cd ASC";
	$res = $DB_CONN->query($sql);
	$i=0;
	while($row_3 = $res->fetchRow(DB_FETCHMODE_ASSOC) ){
		$course_classify_3_ids[$i]	= $row_3['course_classify_cd'];
		$course_classify_3_names[$i]= $row_3['course_classify_name'];
		$i++;
	}	
	$tpl->assign("course_classify_3_ids"	,$course_classify_3_ids);
	$tpl->assign("course_classify_3_names"	,$course_classify_3_names);
	$tpl->assign("course_classify_3_id"		,$course_classify_3_ids[0]);	
	//-----課程性質4
	$sql = "SELECT * FROM lrtcourse_classify_ WHERE course_classify_level='4' and course_classify_parent='".$course_classify_3_ids[0]."' ORDER BY course_classify_cd ASC";
	$res = $DB_CONN->query($sql);
	$i=0;
	while($row_4 = $res->fetchRow(DB_FETCHMODE_ASSOC) ){
		$course_classify_4_ids[$i]	= $row_4['course_classify_cd'];
		$course_classify_4_names[$i]= $row_4['course_classify_name'];
		$i++;
	}	
	$tpl->assign("course_classify_4_ids"	,$course_classify_4_ids);
	$tpl->assign("course_classify_4_names"	,$course_classify_4_names);
	$tpl->assign("course_classify_4_id"		,$course_classify_4_ids[0]);	*/
	
	//課程單位
	$tpl->assign("schedule_unit_ids", array('月', '週', '天', '次', '時'));
	$tpl->assign("schedule_unit_names",array('月', '週', '天', '次', '時'));
	$tpl->assign("schedule_unit_id", $schedule_unit);
	//是否可選課
	$tpl->assign('need_validate_select_ids'		, array(0,1));
	$tpl->assign('need_validate_select_names'	, array('No','Yes'));
	$tpl->assign('need_validate_select_id'		, $_SESSION['values']['need_validate_select']);	
	//是否開放教材
	$tpl->assign('is_public_ids'	, array(0,1));
	$tpl->assign('is_public_names'	, array('No','Yes'));
	$tpl->assign('is_public_id'		, $_SESSION['values']['is_public']);	
	//
	$tpl->assign("actionPage","./validate_tea_create_course.php?validationType=php");	
	//
	$tpl->display("tea_create_course.tpl");	
	
//--------function area ---------------

function getBeginCourseNameByBeginCourseCd($DB, $begin_course_cd){
	$sql = "SELECT begin_course_name FROM begin_course WHERE begin_course_cd='".$begin_course_cd."'";
	//echo $sql."...";
	return $DB->getOne($sql);	 
}	
?>