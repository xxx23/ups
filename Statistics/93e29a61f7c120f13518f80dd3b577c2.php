<?php
/*
統計報表-資教組 需求說明 
1.課程名稱
2.身份別(校長 / 教師)
3.期間
4.研習時數

也希望報表產出能提供各欄位彈性組合需求,再依所勾選欄位產出報表預覽功能(也能同時轉出excel檔)           

需求說明：   [○○縣市]在[○○]年度下，[○○○課程名稱]或[○○○身份別]的研習清單 清單

就是說，他們希望你們可以做出的複合式查詢是 
「在某段時間內(可設定)，哪些縣市(可選取)，
哪些人(校長或老師，可選取)或哪些課程(可選取)，
共有多少人取得多少研習時數(上述欄位的所有清單，
其中人的部分也要有"姓名顯示")」

*/
//error_reporting(E_ALL); 
//ini_set('display_error', 1) ;


define('ROOT', '../');
require_once(ROOT.'config.php');
require_once(ROOT.'session.php');
//checkAdmin();

require_once('lib.php');

global $url_parma ;
$tpl = new Smarty;

//url 搜尋的參數
$url_parma = array(); 
$has_data = false;

//default value 
$type_personal = -1 ; 
$class_kind = -1 ;
$deliver_passhour = 1; 
//print_r($_GET) ;


//$role_cd = $_SESSION['role_cd'];
$input_check = array( 
	'class_target_member'  => 'int' , //開課對象 
	'class_kind'	=> 'int' , 
	'class_choose' 	=> 'int' , 
	'date_course_begin' => 'date', 
    'date_course_end' => 'date', 
    'deliver_passhour' => 'int' ,
	'date_begin' => 'date', 
	'date_end' => 'date', 
	'type_location' => 'int', 
    'type_personal' => 'int'
);

if( isset($_GET['dl_excel']) && $_GET['dl_excel']==1 ) {
	$flag_download_excel = true ; 
}

//如果有找到任何需要的input 就設定成 has_data
validate_input($input_check) ;

// 選單的值，選後還要show，所以傳回tpl 
foreach( $input_check as $key => $value ) {
	if( isset(${$key}) ){
		$tpl->assign($key, ${$key});
	}
}

$url_param = url_gen_param($input_check) ; 

$tpl->assign('url_param', $url_param);
$tpl->assign('type_list', $type_list);


//fetch 課程類別 
$course_property = get_course_property();
$tpl->assign('course_property', $course_property);

$course_target_memeber_list = get_course_target_memeber_list(); 
$tpl->assign('course_target_memeber_list', $course_target_memeber_list) ; 

//fetch 課程選單 
$class_list = get_course_list($class_kind ); 
$tpl->assign('class_choose', $class_choose); //選取的課程
$tpl->assign('class_list', $class_list);

//fetch 縣市別 
$location_list = get_location_list(); 
$tpl->assign('location_list', $location_list);

//人員分類
$type_personal_list = get_type_personal_list(); 
$tpl->assign('type_personal_list', $type_personal_list);

if ($has_data) {
	
	$tpl->assign("display_download_excel", true) ;

//開始準備 查詢的sql 
    $sql_takecourse_where = '';
    $sql_begin_course_where = '' ; //撈出 哪些是需要的課
    $sql_table = '';
    $sql_takecourse_where = '';

	 

	//收尋關於課程的條件
	$sql_begin_course_where .= sql_course_where($class_choose, $class_kind, $class_target_member , $date_course_begin, $date_course_end, $deliver_passhour);
	
	//搜尋修課 及人員條件
	$sql_takecourse_where .= sql_takecourse_where($date_begin, $date_end, -1) ;
	$sql_takecourse_where .= sql_persoanl_basic_where($type_location , -1 , $type_personal) ; 	
		

    //符合課程選取的 set (取出 begin_course_cd 的 set )
    $sql_sub_begin_course_cd  = " SELECT begin_course_cd, begin_course_name, certify FROM begin_course where 1=1 $sql_begin_course_where" ;
    
	
	$all_course = db_getAll( $sql_sub_begin_course_cd ); 
	//well_print($all_course) ;
	//dump_sql($sql_sub_begin_course_cd, '搜尋符合的課程'); 

	$sql_sub_begin_course_cd  = " SELECT begin_course_cd FROM begin_course where 1=1 $sql_begin_course_where" ;
	
	
	$total_stu = 0; 
	$total_stu_pass = 0; 
	$total_stu_pass_certify_hour = 0 ;
	

	
 
	$list_course = array() ;
	
	//loop 搜尋的課 找出修課學生 及通過認證情況
	foreach( $all_course as $course) {

		$sql_take_course_stus = " select personal_basic.personal_id, personal_name, pass FROM take_course "
			." LEFT JOIN personal_basic ON take_course.personal_id=personal_basic.personal_id "
			." WHERE begin_course_cd={$course['begin_course_cd']} $sql_takecourse_where " ;

		$takecourse_stus = db_getAll($sql_take_course_stus);
		
		//如果沒有修課學生 則不表列	
		if( empty($takecourse_stus) )
			continue ; 
		
		unset($passed_stus) ; 
		unset($yet_passed_stus); 
		$course_total_stu = 0; 
		$course_total_pass_stu = 0  ; 
		$p_tr_i = $p_td_i = 0 ; 
		$yp_tr_i = $yp_td_i = 0 ; 
		foreach($takecourse_stus as $stu) {
			$course_total_stu ++ ;
			if( $stu['pass'] == 1 ) { //通過的學生
				$course_total_pass_stu ++ ;
				$passed_stus[$p_tr_i][$p_td_i] = $stu['personal_name'] ; 
				$p_td_i ++ ;
				if( $p_td_i == 4 ) { // 每列 4個 
					$p_tr_i++;
					$p_td_i = 0 ;
				}
			}else { //尚未通過的學生
				
				$yet_passed_stus[$yp_tr_i][$yp_td_i] = $stu['personal_name'] ; 
				$yp_td_i ++ ;
				if( $yp_td_i == 4 ) { // 每列 4個 
					$yp_tr_i++;
					$yp_td_i = 0 ;
				}			
			}
		}
		
		$print_course = array(
			'course_name'		=> $course['begin_course_name'], 
			'certify' 			=> $course['certify'] , 
			'course_total_stu' 	=> $course_total_stu, 
			'passed_stus' 		=> $passed_stus , 
			'yet_passed_stus' 	=> $yet_passed_stus,
			'course_total_pass_stu' 	=> $course_total_pass_stu  , 
			'course_total_yet_pass_stu' => ($course_total_stu - $course_total_pass_stu)
		);
		
		//well_print($print_course);
		$list_course[]  = $print_course ;
		$total_stu += $course_total_stu;
		$total_stu_pass += $course_total_pass_stu ;
		$total_stu_pass_certify_hour += $course['certify'] * $course_total_pass_stu ;
		
	}	
	
	$tpl->assign('total_stu', $total_stu);
	$tpl->assign('total_stu_pass', $total_stu_pass);
	$tpl->assign('total_stu_pass_certify_hour', $total_stu_pass_certify_hour);
	

	$tpl->assign('list_course',$list_course );    
//*/
} // end has data 




if( $flag_download_excel != true ) {
	assignTemplate($tpl, '/statistics/request2.tpl');
} else {
	$search_cond = gen_search_cond_value($input_check) ; 
	
	$objExcel = gen_excel_with_search($search_cond) ; 
	$objExcel = append_request2_data($objExcel, 
		gen_summary($total_stu, $total_stu_pass, $total_stu_pass_certify_hour), 
		$list_course
	) ;
	
// redirect output to client browser
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.urlencode("資教組-統計報表.xls").'"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objExcel, 'Excel5'); 
$objWriter->save('php://output');
}

function gen_summary($total_stu, $total_stu_pass, $total_stu_pass_certify_hour) 
{
	$summary[] = array('title'=> '總通過人數', 'value'=> $total_stu); 
	$summary[] = array('title'=> '總修課人數', 'value'=> $total_stu_pass); 
	$summary[] = array('title'=> '總通過時數', 'value'=> $total_stu_pass_certify_hour); 
	return $summary ; 
}
?>
