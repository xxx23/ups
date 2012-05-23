<?php 
require_once("../config.php");
require_once('session.php');
require_once('../library/filter.php');
require_once('lib.php') ; 

$begin_course_cd = required_param('begin_course_cd', PARAM_INT);

//new smarty	
$tpl = new Smarty();

//?d?Xbegin_course??????
$sql = "SELECT * FROM begin_course WHERE begin_course_cd='".$begin_course_cd."'";
$res = $DB_CONN->query($sql);
if (PEAR::isError($res))	die($res->getMessage());	
$advance_course = $res->fetchRow(DB_FETCHMODE_ASSOC);


$sql = "SELECT category , org_title, title 
        FROM register_applycourse 
        WHERE no = {$advance_course['applycourse_no']}";
$data = db_getAll($sql); 

global $accunt_categroy;
$undertaker_title = $account_categroy[$data[0]['category']].' '.$data[0]['org_title'].' '.$data[0]['title'];
$tpl->assign('undertaker_title' ,$undertaker_title);

//???X?{???\Ū?ɶ? ?ɤ��?
$criteria_content_hour = $advance_course['criteria_content_hour'];
	$content_time = explode(":",$criteria_content_hour);
if(isset($_POST['criteria_content_hour_1']))
	$tpl->assign('criteria_content_hour_1',$_POST['criteria_content_hour_1']);
else
	$tpl->assign('criteria_content_hour_1',preg_replace('/0(.+)/i','$1',$content_time[0]));
//edit by aeil
//$tpl->assign('criteria_content_hour_1',$content_time[0]);
//echo preg_replace('/0(.+)/i','$1',$content_time[0]);

if(isset($_POST['criteria_content_hour_2']))
	$tpl->assign('criteria_content_hour_2',$_POST['criteria_content_hour_2']);
else
	$tpl->assign('criteria_content_hour_2',$content_time[1]);	

$tpl->assign('begin_course_cd', $advance_course[begin_course_cd]);
$tpl->assign('course_cd', $advance_course[course_cd]);
//???ߦW??
if(isset($_POST['begin_course_name']))
	$tpl->assign('begin_course_name',$_POST['begin_course_name']);
else
	$tpl->assign('begin_course_name', $advance_course['begin_course_name']);

//?W?Ҥ???
$tpl->assign('d_course_begin'	, date("Y-n-j", strtotime($advance_course['d_course_begin'])));
//$tpl->assign('d_course_begin'	, $advance_course[d_course_begin]);
$tpl->assign('d_course_end'	, date("Y-n-j", strtotime($advance_course['d_course_end'])));
//???W????
$tpl->assign('d_select_begin'	, date("Y-n-j", strtotime($advance_course['d_select_begin'])));
$tpl->assign('d_select_end'	, date("Y-n-j", strtotime($advance_course['d_select_end'])));
//?ҵ{???}????
$tpl->assign('d_public_day'	, date("Y-n-j", strtotime($advance_course['d_public_day'])));
//?Ǵ?
$tpl->assign('course_year'	, $advance_course[course_year]);
//?Ǧ~
$tpl->assign('course_session'	, $advance_course[course_session]);

if(isset($_POST['take_hour']))
	$tpl->assign('take_hour',$_POST['take_hour']);
else
	$tpl->assign('take_hour',$advance_course['take_hour']);

if(isset($_POST['certify']))
	$tpl->assign('certify',$_POST['certify']);
else
	$tpl->assign('certify',$advance_course['certify']);

if(isset($_POST['is_preview']))
	$tpl->assign('is_preview',$_POST['is_preview']);
else
	$tpl->assign('is_preview',$advance_course['is_preview']);

if(isset($_POST['quantity']))
	$tpl->assign('quantity',$_POST['quantity']);
else
	$tpl->assign('quantity',$advance_course['quantity']);

if(isset($_POST['guest_allowed']))
	$tpl->assign("guest_allowed",$_POST['guest_allowed']);
else
	$tpl->assign("guest_allowed",$advance_course['guest_allowed']);    

if(isset($_POST['charge']))
	$tpl->assign('charge',$_POST['charge']);
else
	$tpl->assign('charge',$advance_course['charge']);

if(isset($_POST['charge_discount']))
	$tpl->assign('charge_discount',$_POST['charge_discount']);
else
	$tpl->assign('charge_discount',$advance_course['charge_discount']);

if(isset($_POST['class_city']))
	$tpl->assign('class_city',$_POST['class_city']);
else
	$tpl->assign('class_city',$advance_course['class_city']);

if(isset($_POST['class_place']))
	$tpl->assign('class_place',$_POST['class_place']);
else
	$tpl->assign('class_place',$advance_course['class_place']);

if(isset($_POST['criteria_total']))
	$tpl->assign('criteria_total',$_POST['criteria_total']);
else
	$tpl->assign('criteria_total',$advance_course['criteria_total']);

if(isset($_POST['criteria_score']))
	$tpl->assign('criteria_score',$_POST['criteria_score']);
else
	$tpl->assign('criteria_score',$advance_course['criteria_score']);

if(isset($_POST['criteria_score_pstg']))
	$tpl->assign('criteria_score_pstg',$_POST['criteria_score_pstg']);
else
	$tpl->assign('criteria_score_pstg',$advance_course['criteria_score_pstg']);

if(isset($_POST['criteria_tea_score']))
	$tpl->assign('criteria_tea_score',$_POST['criteria_tea_score']);
else
	$tpl->assign('criteria_tea_score',$advance_course['criteria_tea_score']);

if(isset($_POST['criteria_tea_score_pstg']))
	$tpl->assign('criteria_tea_score_pstg',$_POST['criteria_tea_score_pstg']);
else
	$tpl->assign('criteria_tea_score_pstg',$advance_course['criteria_tea_score_pstg']);

//?ɶ??զX?_?? @ 2009/09/04

if(isset($_POST['criteria_content_hour']))
	$tpl->assign('criteria_content_hour',$_POST['criteria_content_hour']);
else
	$tpl->assign('criteria_content_hour',$advance_course['criteria_content_hour']);

if(isset($_POST['criteria_finish_survey']))
	$tpl->assign('criteria_finish_survey',$_POST['criteria_finish_survey']);
else
	$tpl->assign('criteria_finish_survey',$advance_course['criteria_finish_survey']);

if(isset($_POST['course_duration']))
	$tpl->assign('course_duration',$_POST['course_duration']);
else
	$tpl->assign('course_duration',$advance_course['course_duration']);

if(isset($_POST['director_name']))
	$tpl->assign('director_name',$_POST['director_name']);
else
	$tpl->assign('director_name',$advance_course['director_name']);

// ?]???q?ܳQ?��??T?ӳ????A?ҥH?n???s???ȥ??L?h 
// ?@?}?l???P?_?O?_???����??s?άO?Ѹ??Ʈw???X?Ӫ?
if(isset($_POST['director_tel_area']))
{
	$tpl->assign("director_tel_area",$_POST['director_tel_area']);
	$tpl->assign("director_tel_left",$_POST['director_tel_left']);
	$tpl->assign("director_tel_ext",$_POST['director_tel_ext']);
}
else // ???ɺ????٥????s?A?n???쥻?????Ƥ��?
{
	$director_tel = $advance_course['director_tel'];
	$director_result = split('[-,#]',$director_tel);
	//print_r($director_tel);
	if(count($director_result) == 2)
	{
	  if($director_result[1] == "-")
	  {  
		$director_result = str_split($director_result[0],3);
	  }
	  $tpl->assign("director_tel_left",$director_result[1]. 
	  $director_result[2]);
	}
	else
	{
	  $tpl->assign("director_tel_left",$director_result[1]);
	  $tpl->assign("director_tel_ext",$director_result[2]);
	}
	$tpl->assign("director_tel_area",$director_result[0]);
	//$tpl->assign("director_tel_left",$director_result[1]. 
	  //$director_result[2]);
	//$tpl->assign("director_tel_ext",$director_result[2]);
}
// end here

/*    
if(isset($_POST['director_tel']))
	$tpl->assign('director_tel',$_POST['director_tel']);
else
	$tpl->assign('director_tel',$advance_course['director_tel']);
 */

if(isset($_POST['director_email']))
	$tpl->assign('director_email',$_POST['director_email']);
else
	$tpl->assign('director_email',$advance_course['director_email']);

if(isset($_POST['director_fax']))
	$tpl->assign('director_fax',$_POST['director_fax']);
else
	$tpl->assign('director_fax',$advance_course['director_fax']);

if(isset($_POST['attribute']))
	$tpl->assign('attribute',$_POST['attribute']);
else
	$tpl->assign('attribute',$advance_course['attribute']);

if(isset($_POST['auto_admission']))
	$tpl->assign('auto_admission',$_POST['auto_admission']);
else
	$tpl->assign('auto_admission',$advance_course['auto_admission']);

if(isset($_POST['note']))
	$tpl->assign('note',$_POST['note']);
else
	$tpl->assign('note',$advance_course['note']);

// modify by Samuel @ 2009/09/02
// ?o?Ӥ????S?O?A?n?]?????P?????ҽҵ{???O?Ӳ??ͤ??P???ҵ{???X
// ???O?p?G???ܹL?᪺coure_property???쥻?ҵ{???O?@?˪??? ?n???쥻?????Ƭ????U?ӶǹL?h
if(isset($_POST['course_property']))
{
	if($_POST['course_property'] == $advance_course['course_property'])
	{
		$tpl->assign("course_property",$_POST['course_property']);
		$tpl->assign("inner_course_cd",$advance_course['inner_course_cd']);
	}
	else
	{
		$tpl->assign('course_property',$_POST['course_property']);
		$tpl->assign("inner_course_cd",get_inner_course($_POST['course_property'],0));
	}
}
else
{
	$tpl->assign('course_property',$advance_course['course_property']);
	$tpl->assign("inner_course_cd",$advance_course['inner_course_cd']);
}

if(isset($_POST['attribute']))
	$tpl->assign('attribute',$_POST['attribute']);
else
	$tpl->assign('attribute',$advance_course['attribute']);

if(isset($_POST['course_unit']))
	$tpl->assign('upper_course_type',$course_unit);

if(isset($_POST['article_number']))
	$tpl->assign('article_number',$_POST['article_number']);
else
	$tpl->assign('article_number', $advance_course['article_number']);

// course_stage ?ק? @ 2009/10/30
// ???ƿ諸?C?@??stage ?��}

if(!isset($_POST['post_state']))
{
	$check_stage1 = $advance_course['course_stage'][0];
	$check_stage2 = $advance_course['course_stage'][1];
	$check_stage3 = $advance_course['course_stage'][2];
	$check_stage4 = $advance_course['course_stage'][3];
}
else
{
	if(isset($_POST['course_stage_option1']))
		$check_stage1 = 1;
	else
		$check_stage1 = 0;

	if(isset($_POST['course_stage_option2']))
		$check_stage2 = 1;
	else    
		$check_stage2 = 0;

	if(isset($_POST['course_stage_option3']))
		$check_stage3 = 1;
	else
		$check_stage3 = 0;

	if(isset($_POST['course_stage_option4']))
		$check_stage4 = 1;
	else
		$check_stage4 = 0;
}

$tpl->assign("check_stage1",$check_stage1);
$tpl->assign("check_stage2",$check_stage2);
$tpl->assign("check_stage3",$check_stage3);
$tpl->assign("check_stage4",$check_stage4);

// end modification here @ 2009/10/30

if(isset($_POST['career_stage']))
	$tpl->assign('career_stage',$_POST['career_stage']);
else
	$tpl->assign('career_stage',$advance_course['career_stage']);

if(isset($_POST['deliver']))
  $tpl->assign('deliver',$_POST['deliver']);
else
  $tpl->assign('deliver',$advance_course['deliver']);

//?d?߶}?ҳ??? modify by Samuel 09/06/05
// modify by Samuel again => ????course_unit?????ܤ覡
$sql = "SELECT * from lrtunit_basic_ WHERE department = -1 ORDER BY unit_cd";
$total_course_unit = db_getAll($sql);
$sql = "SELECT * from lrtunit_basic_ WHERE unit_cd = {$advance_course['begin_unit_cd']}";
$subunit = db_getRow($sql);
$upper_course_type = $subunit['department'];

if(isset($_POST['course_unit'])) 
{
	// ?p?G?ثe?? ?ҵ{???O ?P ???Ʈw?O?ۦP????
	$sql = "SELECT * FROM lrtunit_basic_ WHERE department = {$_POST['course_unit']} ORDER BY unit_cd";
	$total_course_subunit = db_getAll($sql);
	$upper_course_type = $_POST['course_unit'];
}
else
{	
	// ?ثe???ҵ{???O ?P???Ʈw???ҵ{???O???P ?ҥH?n???䥦???O???l???O???X??
	$sql = "SELECT * FROM lrtunit_basic_ WHERE department = {$subunit['department']} ORDER BY unit_cd";
	$total_course_subunit = db_getAll($sql);
	$begin_unit_cd = $advance_course['begin_unit_cd'];
}

$tpl->assign("upper_course_type",$upper_course_type);
$tpl->assign("begin_unit_cd",$begin_unit_cd);
$tpl->assign('total_course_unit',$total_course_unit);
$tpl->assign('total_course_subunit',$total_course_subunit);
// end @ 2009/10/07

//?d?ߩҦ????}?????O modify by Samuel @ 2009/09/02
$sql = "SELECT * FROM course_property";
$total_course_property = db_getAll($sql);
$tpl->assign("total_course_property",$total_course_property);
//???X????
assignTemplate($tpl, "/apply_course/verify_course_detail.tpl");	


//-----function area-------
function get_inner_course($property_number,$sql_type)
{
	//???X?????O?U?ثe?ҵ{???̤j??
	$sql = "select max(course_number) as course_maxi
		FROM generate_inner_course_cd
		WHERE property_type = {$property_number}";

	 
	if( db_getOne($sql) == NULL) //???ܸ??ݩ??٨S???}?L?ҵ{
		$max_course_number = 1 ;
	else{
		$max_course_number = db_getOne($sql); // ?U?@?????ƪ??ҵ{???X
		$max_course_number ++ ;
	}
	
	//?P?_?}?]?ҵ{???᪺?ҵ{?s???O?h
	$property=$property_number + 1 ;
	if($max_course_number < 10)
		$inner_course_cd_1 = "010".$property."000".$max_course_number;
	elseif($max_course_number >= 10 && $max_course_number < 100) // 10~99
		$inner_course_cd_1 = "010".$property."00".$max_course_number;
	elseif($max_course_number >= 100 && $max_course_number < 1000) // 100~999
		$inner_course_cd_1 = "010".$property."0".$max_course_number;
	else // ?j??1000 ???|?ӼƦr
		$inner_course_cd_1 = "010".$property."".$max_course_number;

	if($sql_type == 0)
		return $inner_course_cd_1;
	elseif($sql_type == 1)
	{
		if($max_course_number == 1) //???ܳ??٨S???}?L?ҵ{?A???o???s?????? ?A?g?^?o?Ӹ??ƪ?
		{
				$sql = "INSERT INTO generate_inner_course_cd
						  (
						  course_type,
						  property_type,
						  course_number
						   ) VALUES
						   (
						   '1',
						   '{$property_number}',
						   '{$max_course_number}'
						   )";
				db_query($sql);
		}
		else // ?Y???ܨ????ݩ? ?쥻?w?g?N???ҵ{?F ???????s???̤j?ȴN?n?F
		{
				$sql = "UPDATE generate_inner_course_cd
						SET course_number ='{$max_course_number}'
						WHERE property_type = {$property_number}";
				db_query($sql);
		}
	}
}
	

?>
