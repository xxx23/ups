<?php
/***
FILE:   
DATE:   2006/12/11
AUTHOR: zqq
**/

	
	$RELEATED_PATH = "../";
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	//update_status ( "確認開課中" );
	$template = $_SESSION['template_path'] . $_SESSION['template'];
	$tpl_path = "../themes/" . $_SESSION['template'];	
	
	//session變數
	if(!isset($_SESSION['values']['begin_course_name']) ){
		$_SESSION['values']['begin_course_name']= '';
		//$_SESSION['values']['course_cd']		= '';
		$_SESSION['values']['begin_unit_cd']	= '';
		$_SESSION['values']['inner_course_cd']	= '';
		$_SESSION['values']['d_course_begin']	= '';
		$_SESSION['values']['d_course_end']		= '';
		$_SESSION['values']['d_public_day']		= '';
		$_SESSION['values']['d_select_begin']	= '';
		$_SESSION['values']['d_select_end']		= '';
		$_SESSION['values']['course_year']		= this_semester('y');
		$_SESSION['values']['course_session']	= this_semester('s');
	}
	
	if(!isset($_SESSION['errors']['begin_course_name'])){	
		$_SESSION['errors']['begin_course_name']= 'hidden';
		//$_SESSION['errors']['course_cd']		= 'hidden';
		$_SESSION['errors']['begin_unit_cd']	= 'hidden';
		$_SESSION['errors']['inner_course_cd']	= 'hidden';		
		$_SESSION['errors']['d_course_begin']	= 'hidden';
		$_SESSION['errors']['d_course_end']		= 'hidden';
		$_SESSION['errors']['d_public_day']		= 'hidden';
		$_SESSION['errors']['d_select_begin']	= 'hidden';
		$_SESSION['errors']['d_select_end']		= 'hidden';
		$_SESSION['errors']['course_year']		= 'hidden';
		$_SESSION['errors']['course_session']	= 'hidden';	
	}
	//new smarty
	$tpl = new Smarty();
	//echo "<pre></pre>";
	
	//-------------開課名稱--------------------
	$tpl->assign("valueOfBegin_course_name",$_SESSION['values']['begin_course_name']);
	$tpl->assign("begin_course_nameFailed",$_SESSION['errors']['begin_course_name']);	

	//-------------課程科目編號--------------------
	//$tpl->assign("valueOfCourse_cd",$_SESSION['values']['course_cd']);
	//$tpl->assign("course_cdFailed",$_SESSION['errors']['course_cd']);	

	//-------------對應內部課程號--------------------
	$tpl->assign("valueOfInner_course_cd",$_SESSION['values']['inner_course_cd']);
	$tpl->assign("inner_course_cdFailed",$_SESSION['errors']['inner_course_cd']);	

	//-------------開課單位--------------------
	$tpl->assign("valueOfBegin_unit_cd",$_SESSION['values']['begin_unit_cd']);
	$tpl->assign("begin_unit_cdFailed", $_SESSION['errors']['begin_unit_cd']);	
	
	//-------------開課開始日期--------------------
	$tpl->assign("valueOfD_course_begin",$_SESSION['values']['d_course_begin']);
	$tpl->assign("d_course_beginFailed",$_SESSION['errors']['d_course_begin']);	
	
	//-------------開課結束日期--------------------
	$tpl->assign("valueOfD_course_end",$_SESSION['values']['d_course_end']);
	$tpl->assign("d_course_endFailed",$_SESSION['errors']['d_course_end']);	
	
	//-------------開課公開日期--------------------
	$tpl->assign("valueOfD_public_day",$_SESSION['values']['d_public_day']);
	$tpl->assign("d_public_dayFailed",$_SESSION['errors']['d_public_day']);	
	
	//-------------選課開始日期--------------------
	$tpl->assign("valueOfD_select_begin",$_SESSION['values']['d_select_begin']);
	$tpl->assign("d_select_beginFailed",$_SESSION['errors']['d_select_begin']);	
	
	//-------------選課結束日期--------------------
	$tpl->assign("valueOfD_select_end",$_SESSION['values']['d_select_end']);
	$tpl->assign("d_select_endFailed",$_SESSION['errors']['d_select_end']);		
	
	//-------------開課所屬的學年--------------------
	$tpl->assign("valueOfCourse_year",$_SESSION['values']['course_year']);
	$tpl->assign("course_yearFailed",$_SESSION['errors']['course_year']);		
	
	//-------------開課所屬的學期--------------------
	$tpl->assign("valueOfCourse_session",$_SESSION['values']['course_session']);
	$tpl->assign("course_sessionFailed",$_SESSION['errors']['course_session']);		
		
	//-------------課程名稱--------------------
	
	//-------------開課單位--------------------
	$sql = "SELECT unit_cd, unit_name FROM lrtunit_basic_ ORDER BY unit_cd ASC";
	$res = $DB_CONN->query($sql);
	$i=0;
	while( $row = $res->fetchRow(DB_FETCHMODE_ASSOC)){
		$begin_unit_cd_ids[$i]	= $row['unit_cd'];
		$begin_unit_cd_names[$i]= $row['unit_name'];
		$i++;
	}
	$tpl->assign("begin_unit_cd_ids", $begin_unit_cd_ids);
	$tpl->assign("begin_unit_cd_id",$begin_unit_cd_ids[0]);
	$tpl->assign("begin_unit_cd_names", $begin_unit_cd_names);

	//-------------日--------------------

	/*$d_course_begin_Y_names = setNames(10,100);
	$d_course_begin_M_names = setNames(1, 12);
	$d_course_begin_D_names = setNames(1, 31);
	$tpl->assign("d_course_begin_Y_names", $d_course_begin_Y_names);
	$tpl->assign("d_course_begin_M_names", $d_course_begin_M_names);
	$tpl->assign("d_course_begin_D_names", $d_course_begin_D_names);*/
					
	//以下教師在職進修需要的欄位
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
	$tpl->assign("course_classify_4_id"		,$course_classify_4_ids[0]);		
	
	//班別性質
	$sql = "SELECT * FROM lrtstorecd_basic_ WHERE type_name = '班別性質_代碼'";
	$res = $DB_CONN->query($sql);
	while($row = $res->fetchRow(DB_FETCHMODE_ASSOC))
	{
		$tpl->append('coursekind_ids',$row['type_id']);
		$tpl->append('coursekind_names',$row['type_id_name']);
	}
	$tpl->assign('coursekind_id',0);
	//課程時段
	$tpl->assign('timeSet_ids'		, array(1,2,3,4,5,0));
	$tpl->assign('timeSet_names'	, array('週一至週五白天','週一至週五晚上','週末','暑假','寒假','尚無資料'));
	$tpl->assign('timeSet_id'		, '');		
	//學員繳費方式
	$sql = "SELECT * FROM lrtstorecd_basic_ WHERE type_name = '繳費方式_代碼'";
	$res = $DB_CONN->query($sql);
	while($row = $res->fetchRow(DB_FETCHMODE_ASSOC))
	{
		$tpl->append('charge_type_ids'	, $row['type_id']);
		$tpl->append('charge_type_names', $row['type_id_name']);
	}
	$tpl->assign('charge_type_id'	, 1);		
	//補助單位
	$sql = "SELECT * FROM lrtstorecd_basic_ WHERE type_name = '補助單位_代碼'";
	$res = $DB_CONN->query($sql);
	while($row = $res->fetchRow(DB_FETCHMODE_ASSOC))
	{
		$tpl->append('subsidizeid_ids'	, $row['type_id']);
		$tpl->append('subsidizeid_names', $row['type_id_name']);
	}
	$tpl->assign('subsidizeid_id'	, 1);		
	
	//驗證表單
	$tpl->assign("actionPage","./validate_begin_course_advance.php?validationType=php");	
	//輸出頁面
	$tpl->assign("tpl_path", "../themes/" . $_SESSION['template']);	
	$tpl->display($_SESSION['template_path'] . $_SESSION['template'] . "/course_admin/begin_course_advance.tpl");	
	


	function setNames($begin, $end){
		$array[0] = "請選擇";
		for($i = 1; $i <= $end-$begin+1 ; $i++){
			$array[$i] = ''.$begin + $i -1;
		}
		return $array;
	}



function this_semester($str){
	
	$year = date('Y')-1911;
	$month = date('n');
	$day = date('j');
	
	if( $month >= 2  && $month <= 7 ){
		$session = 2;
		$y = $year - 1;
	}
	else{
		$session = 1;
		$y = $year ;		
	}
	if($str === "y")
		return $y;
	else
		return $session;	
}	
?>
