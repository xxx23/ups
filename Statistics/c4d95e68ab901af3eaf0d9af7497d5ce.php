<?php 
/*
資源組需求說明
1.年      -- 課
2.月份    -- 課
3.DOC名稱 -- 人
4.課程類別 -- 課             
5.課程名稱 -- 課

3.1 修課期間 -- 人 

> 以上撈出課程 或者一個課程範圍 
> 撈出課程範圍後針對課程狀況做課程培訓狀況作統計 

6.課程培訓(次數)
7.課程培訓(時數)
8.課程培訓人次(男)
9.課程培訓人次(女)
10.課程培訓人數(男)
11.課程培訓人數(女)

> 以下針對修習課程的一般民眾身份做統計 
> 先用用笨方法 各種身份下sql撈一次用
> 如果數量太大可能需要記得tune 一下maybe撈出來再用php分男女之類?
> 在php作整體人數加總 (記得先用sql驗證是否會對)

12.新住民教育訓練人(男)
13.新住民教育訓練人數(女)
    AND personal_basic.familysite = 3
	
14.婦女教育訓練人數(女) --- XDD 只有女 想說怎麼沒男
    personal_basic.sex = 0 AND personal_basic.d_birthday < DATE_SUB(NOW(), INTERVAL 40 YEAR)
	
15.銀髮族教育訓練人數(男)
16.銀髮族教育訓練人(女)
    AND personal_basic.d_birthday < DATE_SUB(NOW(), INTERVAL 50 YEAR)
	
17.勞工教育訓練人數(男)
18.勞工教育訓練人數(女)
    AND personal_basic.job = 0
    
呈現的部份 

1-5  分成一個table 
6-11 分成一個table  
12-18 分成一個table 


//debuging info 
注意表格資料的一致性，有時候會因為 take_course 裡有personal_id 
但是personal_basic 沒有(人被刪掉了)
所以這邊會用 left join , 以take_course的資料為主 

course_property 則用union 因為可能有某些課被設定在 
舊的已經刪掉的property 則不要算進去 

男女生的判斷，personal_basic.sex 未填則欄位為 NULL ，則先判斷為男 


==============================================================
*/

// input value 
// * class_kind 		課程性質
// * class_choose  		選擇的課程
// * date_course_begin 	課程開始時間
// * date_course_end  	課程結束時間
// * = 以上為課程搜尋條件 以下為人員搜尋條件 =
// * date_begin 		修課期間
// * date_end 			修課結束時間
// * type_location 		人員所處縣市別
// * type_doc 			人員所處DOC

//error_reporting(E_ALL); 
//ini_set('display_error', 1) ;

define('ROOT', '../');
require_once(ROOT.'config.php');
require_once(ROOT.'session.php');

//checkAdmin();
$tpl = new Smarty;
$TIMESTAMP_FORMAT = 'Y-m-d H:i:s' ; 
$DATE_FORMAT = 'Y/m/d' ; 
$has_data = false;
$deliver_passhour = 1 ; 

require_once('lib.php');

//$role_cd = $_SESSION['role_cd'];
$input_check = array( 
 	'class_kind'	=> 'int' , //課程分類
	'class_choose' 	=> 'int' , //課程id 
	'date_course_begin' => 'date', 
	'date_course_end' => 'date', 
	'deliver_passhour' => 'int' , 
	'date_begin' => 'date', 
	'date_end' => 'date', 
	'type_location' => 'int', 
	'type_doc' => 'int' 
);

//download_excel_flag 
if( isset($_GET['dl_excel']) && $_GET['dl_excel']==1 ) {
	$flag_download_excel = true ; 
}

//驗證處理選單的值，
validate_input($input_check) ;


$url_param = url_gen_param($input_check) ; 

//well_print($GLOBALS) ;

// 選單的值，選後還要show，所以傳回tpl 
foreach( $input_check as $key => $value ) {
	if( isset(${$key}) ){
		$tpl->assign($key, ${$key});
	}
}


$type_list = array(-1=>'不限','一般民眾','國民中小學教師','高中職教師','大專院校學生','大專院校教師');
$sort_list = array(-1=>'不限','依日期','依人數');
$tpl->assign('url_param', $url_param);
$tpl->assign('type_list', $type_list);

$tpl->assign('type_detail_list', $type_detail_list);
$tpl->assign('sort_list', $sort_list);



//fetch 課程類別 
$course_property = get_course_property();
$tpl->assign('course_property', $course_property);

//fetch 課程選單 
$class_list = get_course_list($class_kind ); 
$tpl->assign('class_list', $class_list);

//fetch 縣市別 
$location_list = get_location_list(); 
$tpl->assign('location_list', $location_list);

//fetch doc 
$type_docs = get_doc_type($type_location ) ;
$tpl->assign('type_docs', $type_docs); 

if ($has_data) {
	$tpl->assign("display_download_excel", true) ;

    $sql_table = '';
    $sql_takecourse_where = '';
    $sql_begin_course_where = '' ; 

	$sql_begin_course_where .= sql_course_where($class_choose, $class_kind ,-1,  $date_course_begin, $date_course_end, $deliver_passhour);
	$sql_takecourse_where .= sql_takecourse_where($date_begin, $date_end, -1) ;
	$sql_takecourse_where .= sql_persoanl_basic_where($type_location , $type_doc ) ; 
   
   
	//如果沒有設定 縣市別 或 doc ，則不交集
	if( $type_location != -1 || $type_doc != -1) { 
		$sql_table .= ',personal_basic';
		$sql_takecourse_where .= ' AND take_course.personal_id = personal_basic.personal_id';
	}
  
    $sql_sort  = " order by d_course_begin "; 

	
	
    //修課人數
    $sql_count_stu = 'SELECT COUNT(*) FROM take_course '
		.' LEFT JOIN personal_basic ON personal_basic.personal_id=take_course.personal_id '
		.' WHERE take_course.begin_course_cd = begin_course.begin_course_cd AND take_course.allow_course = 1 '. $sql_takecourse_where;
	//dump_sql($sql_count_stu, '查詢該課有多少人(C)',false); 	
	
	//通過時的人數
	$sql_pass_take_course = 'SELECT count(*) FROM take_course' . $sql_table . ' WHERE take_course.begin_course_cd = begin_course.begin_course_cd AND take_course.allow_course = 1 AND take_course.pass=1 ' . $sql_takecourse_where;
	//dump_sql($sql_pass_take_course, "通過時的人數", false) ; 
    
	//列出查詢範圍內的所有課程 且修課人數大於0的 
	$sql_takecourse_count = 'SELECT begin_course_cd,d_course_begin,property_name, certify, begin_course_name,(' . $sql_count_stu . ') AS C , (' .$sql_pass_take_course.') AS PASS'  
		.' FROM begin_course,course_property '
		.' WHERE course_property.property_cd = begin_course.course_property'. $sql_begin_course_where .' HAVING C > 0 '. $sql_sort ;

    //dump_sql($sql_takecourse_count, '列表course', false ) ;
	
	
    $result = db_query($sql_takecourse_count);

	
	$course_course_data_row = array(); 
	$total_course =0 ; 
	$total_take_course = 0; 
	$total_take_course_pass = 0;
	$total_take_course_pass_hour = 0 ;
	$course_data_row[0] = array(
		'index'=>'索引',
		'date_course_begin'=>'開課時間', 
		'begin_course_name'=>'課程名稱',
		'certify'=>'驗證時數',
		'take_course_count'=>'研習人數',
		'take_course_count_pass'=>'已通過研習人數' , 
		'course_pass_hour' => '課程通過認證時數'
	);
	
	$prepare_url = url_gen_param($input_check, 'class_choose' );

    while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) 
	{
		$total_course++;

		$course_pass_hour = ( intval($row['pass']) *  intval($row['certify']) ); 
		
		$course_data_row[] = array(
			'index' => $total_course ,
			'begin_course_cd' => $row['begin_course_cd'] ,
			'begin_course_name' => $row['begin_course_name'] ,
			'date_course_begin' => date_create($row['d_course_begin'])->format($DATE_FORMAT) ,
			'url_query_course' => url_append_param($prepare_url, 'class_choose', $row['begin_course_cd']), 
			'certify' =>  $row['certify'], 
			'take_course_count'	=>  $row['c'], 
			'take_course_count_pass'  =>  $row['pass'], 
			'course_pass_hour' => $course_pass_hour 
		);
		
		$total_take_course += $row['c'] ; 
		$total_take_course_pass += $row['pass'] ; 
		$total_take_course_pass_hour += $course_pass_hour ;
    }	
	//最下面統計值
	$course_data_row[] = array(
		'index'=>'加總','' ,'', 
		'take_course_count'=>$total_take_course, 
		'take_course_count_pass'=>$total_take_course_pass,
		'course_pass_hour' => $total_take_course_pass_hour
	); 
	$tpl->assign('data', $course_data_row);	
	
	
    //取出有哪些課程
    $sql_sub_begin_course_cd  = " SELECT begin_course_cd FROM begin_course,course_property where course_property.property_cd = begin_course.course_property $sql_begin_course_where "; 
    //dump_sql($sql_sub_begin_course_cd, '查詢有哪些課程符合', false); 

    $get_begin_course_cd_take_course = " SELECT DISTINCT begin_course_cd from take_course $sql_table where begin_course_cd in ( $sql_sub_begin_course_cd ) AND take_course.allow_course = 1 $sql_takecourse_where" ; 
    //dump_sql($get_begin_course_cd_take_course, '有哪些課符合有選課', false) ; 

	

	
//6. course_res.data1 . 課程培訓次數  (理解成這個範圍有多少課程)
    $course_res['data1'] = $total_course  ;
    //dump_sql($get_data6, '課程培訓次數  (理解成這個範圍有多少課程)'); 

//7. course_res.data2 . 課程培訓時數
    $course_res['data2'] = $total_take_course_pass_hour ;
    
	//dump_sql($get_data7) ; 

	
	//報表頁面 sql表  index => array('count欄位', '性別', '一般民眾分類') ; 
$sql_subquery_table = array (
	 'course_num_poeple_male' => array('no_distinct', 'male', 'none') , 
	 'course_num_poeple_female' => array('no_distinct', 'female', 'none'), 
	 'course_num_diff_poeple_male' => array('distinct', 'male', 'none'), 
	 'course_num_diff_poeple_female' => array('distinct', 'female', 'none'), 
	 'new_resident_male' => array('distinct', 'male', 'new_resident') ,
	 'new_resident_female' => array('distinct', 'female', 'new_resident') , 
	 'women' =>  array('distinct', 'female', 'women'), 
	 'elder_male' => array('distinct', 'male', 'elder'),
	 'elder_female' => array('distinct', 'female', 'elder'),
	 'laborer_male' => array('distinct', 'male', 'laborer') , 
	 'laborer_female' => array('distinct', 'female', 'laborer') 
);
	
//================================ 課程相關 ==================================
	
//8. course_res.data3 . 課程培訓人次 男 
    $get_data8 =  sql_gen_diff_type_num_count($sql_sub_begin_course_cd, $sql_takecourse_where, 
				$sql_subquery_table['course_num_poeple_male']) ;
    $course_res['data3'] = db_getOne($get_data8)  ;
    //dump_sql($get_data8,'研習人次 男', false); 

//9. course_res.data4 . 課程培訓人次 女
    $get_data9 = sql_gen_diff_type_num_count($sql_sub_begin_course_cd, $sql_takecourse_where, 
				$sql_subquery_table['course_num_poeple_female']) ;
    $course_res['data4'] = db_getOne($get_data9)  ;
    //dump_sql($get_data9,'課程培訓人次 女', false)  ;
	
//10. course_res.data5 . 課程培訓人數 男
    $get_data10 = sql_gen_diff_type_num_count($sql_sub_begin_course_cd, $sql_takecourse_where,
					$sql_subquery_table['course_num_diff_poeple_male']) ;
    
    $course_res['data5'] = db_getOne($get_data10);
    //dump_sql($get_data10, ' 課程培訓人數 男', false) ; 


//11. course_res.data6 . 課程培訓人數 女
    $get_data11 = sql_gen_diff_type_num_count($sql_sub_begin_course_cd, $sql_takecourse_where,
					$sql_subquery_table['course_num_diff_poeple_female']) ;
    $course_res['data6'] = db_getOne($get_data11)  ;
    //dump_sql($get_data11, '課程培訓人數 女', false) ; 

	$tpl->assign("course_res", $course_res);
	
	
//========================== 根據人員分類 =======================================	

//12. people_res.data1 .  新住民教育訓練人(男)
    $get_data12 = sql_gen_diff_type_num_count($sql_sub_begin_course_cd, $sql_takecourse_where,
					$sql_subquery_table['new_resident_male']) ; 
    $people_res['data1'] = db_getOne($get_data12) ;
    //dump_sql($get_data12, '新住民男', false) ; 

//13. people_res.data2 . 新住民教育訓練人數(女)
    $get_data13 = sql_gen_diff_type_num_count($sql_sub_begin_course_cd, $sql_takecourse_where,
					$sql_subquery_table['new_resident_female']) ; 

    $people_res['data2'] = db_getOne($get_data13) ;
    //dump_sql($get_data13, '新住民女', false) ; 


//14. people_res.data3 . 婦女教育訓練人數(女)
    $get_data14 = sql_gen_diff_type_num_count($sql_sub_begin_course_cd, $sql_takecourse_where,
					$sql_subquery_table['women']); 

    $people_res['data3'] = db_getOne($get_data14) ;
    //dump_sql($get_data14,'婦女', false);

//15. people_res.data4 . 銀髮族教育訓練人數(男)
    $get_data15 = sql_gen_diff_type_num_count($sql_sub_begin_course_cd, $sql_takecourse_where,
					$sql_subquery_table['elder_male']); 

    $people_res['data4'] =  db_getOne($get_data15) ;
    //dump_sql($get_data15, '銀髮族男');

//16. people_res.data5 . 銀髮族教育訓練人數(女)
    $get_data16 = sql_gen_diff_type_num_count($sql_sub_begin_course_cd, $sql_takecourse_where,
					$sql_subquery_table['elder_female']); 

    $people_res['data5'] = db_getOne($get_data16) ;
    //dump_sql($get_data16, '銀髮族女'); 


//17. people_res.data6   勞工教育訓練人數(男)
    $get_data17 =  sql_gen_diff_type_num_count($sql_sub_begin_course_cd, $sql_takecourse_where,
					$sql_subquery_table['laborer_male']) ; 

    $people_res['data6'] =  db_getOne($get_data17) ;
    //dump_sql($get_data17, '勞工男', false) ; 


//18. people_res.data7   勞工教育訓練人數(女)
    $get_data18 =  sql_gen_diff_type_num_count($sql_sub_begin_course_cd, $sql_takecourse_where,
					$sql_subquery_table['laborer_female']); 

    $people_res['data7'] = db_getOne($get_data18) ;
    //dump_sql($get_data18, '勞工女', false) ; 

    
    $tpl->assign("people_res", $people_res);

	
	if( isset($class_choose) && $class_choose != -1 ) {
		$sql_list_stu = 'SELECT personal_basic.personal_id, personal_name, course_begin, pass FROM take_course '
			.' LEFT JOIN personal_basic ON personal_basic.personal_id=take_course.personal_id '
			.' WHERE  take_course.begin_course_cd='.$class_choose .' ' . $sql_takecourse_where .'order by take_course.pass desc';
		
		$stu_list[0] = array('index'=>'索引', 'stu_name'=>'修課學員名字', 'pass'=>'審核是否通過', 'course_begin'=>'選課時間');
		
		$result = db_query($sql_list_stu) ;
		$index = 0 ; 
		while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
			$index ++ ; 

			$stu_list[] = array(
				'index' => $index , 
				'stu_name' => $row['personal_name'] , 
				'course_begin' => $row['course_begin'] , 
				'pass' =>  ($row['pass']==1?'通過':'未通過')
			);
		}
		$tpl->assign('stu_list', $stu_list) ; 
	}
	
} // end has data 
 
if( $flag_download_excel != true ) {
	assignTemplate($tpl, '/statistics/request1.tpl');
} else {
	$search_cond = gen_search_cond_value($input_check) ; 
	
	$objExcel = gen_excel_with_search($search_cond) ; 
	$objExcel = append_request1_data($objExcel, gen_summary($course_res, $people_res), $course_data_row) ;
	

// redirect output to client browser
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.urlencode("資源組-統計報表.xls").'"');
header('Cache-Control: max-age=0');
	
$objWriter = PHPExcel_IOFactory::createWriter($objExcel, 'Excel5'); 
$objWriter->save('php://output');
}
 
function gen_summary($course_res, $people_res)
{
	//
	$summary[] = array('title'=>'課程培訓次數',  'value'=>$course_res['data1']);
	$summary[] = array('title'=>'課程培訓時數' , 'value'=>$course_res['data2']);
	$summary[] = array('title'=>'課程培訓人次(男)' , 'value'=>$course_res['data3']);
	$summary[] = array('title'=>'課程培訓人次(女)' , 'value'=>$course_res['data4']);
	$summary[] = array('title'=>'課程培訓人數(男)' , 'value'=>$course_res['data5']);
	$summary[] = array('title'=>'課程培訓人數(女)' , 'value'=>$course_res['data6']);

	$summary[] = array('title'=>'新住民教育訓練人(男)', 	 'value'=>$people_res['data1']);
	$summary[] = array('title'=>'新住民教育訓練人(女)' , 'value'=>$people_res['data2']);
	$summary[] = array('title'=>'婦女教育訓練人數(女)' , 'value'=>$people_res['data3']);
	$summary[] = array('title'=>'銀髮族教育訓練人數(男)' , 'value'=>$people_res['data4']);
	$summary[] = array('title'=>'銀髮族教育訓練人(女)' , 'value'=>$people_res['data5']);
	$summary[] = array('title'=>'勞工教育訓練人數(男)' , 'value'=>$people_res['data6']);
	$summary[] = array('title'=>'勞工教育訓練人數(女)' , 'value'=>$people_res['data7']);
	
	return $summary ; 
}

?>
