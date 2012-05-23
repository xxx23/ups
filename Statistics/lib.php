<?php

$SEARCH_COND_TITLE =  array(
	'class_target'  => '開課對象' , 
	'class_kind'	=> '課程性質', 
	'class_choose' 	=> '符合條件課程' , 
	'date_course_begin' => '開設課程開始時間範圍-開始範圍', 
	'date_course_end' => '開設課程開始時間範圍-結束範圍', 
	'date_begin' => '依修課人員修課期間範圍-開始範圍', 
	'date_end' => '依修課人員修課期間範圍-結束範圍', 
	'type_location' => '依修課人員所處縣市別', 
	'type_doc' => '人員所處DOC' ,
	'type_personal' => '依修課人員身分別'
);



function dump_sql($sql, $alert='', $print='false') {
    if( $print ) {
        echo $alert ."<br/>\n" ; 
        echo $sql.'&nbsp;&nbsp;'; 
        echo "<hr/>" ; 
    }
}

function get_course_property() {

	$course_property = array();
	$course_property['-1'] = "不限";
	$sql = 'SELECT property_cd,property_name FROM course_property ORDER BY property_cd ASC';
	$result = db_query($sql);
	while ($row =& $result->fetchRow(DB_FETCHMODE_ASSOC)) {
		$course_property[$row['property_cd']] = $row['property_name'];
	}
	return $course_property ; 
}

function get_course_list($class_kind=-1) {

	$class_list = array();
	$class_list['-1'] = "不限";
	$sql = "SELECT begin_course_cd,begin_course_name FROM begin_course";
	if(isset($class_kind) && $class_kind != -1) {
		$sql .= " where course_property=$class_kind";
	}

	$result = db_query($sql);
	while ($row =& $result->fetchRow(DB_FETCHMODE_ASSOC)) {
		$class_list[$row['begin_course_cd']] = $row['begin_course_name'];
	}
	
	return $class_list ; 	
}

function get_location_list() 
{
	$location_list = array();
	$sql = 'SELECT city_cd,city FROM location GROUP BY city_cd';
	$result = db_query($sql);
	$location_list[ -1 ] = '不限';
	while ($row =& $result->fetchRow(DB_FETCHMODE_ASSOC)) {
		$location_list[ $row['city_cd'] ] = $row['city'];
	}
	return $location_list ; 
}


function get_doc_type($type_location ) 
{
	$type_docs = Array();
	$type_docs[-1] = '不限';
	$type_docs[-2] = '全部';
	if( !empty($type_location)  ) {
		$sql = "SELECT doc_cd,doc FROM docs WHERE city_cd = $type_location";
		$result = db_query($sql);
		
		while ($row =& $result->fetchRow(DB_FETCHMODE_ASSOC)) {
				$type_docs[$row['doc_cd']] =  $row['doc'];
		}
	}
	return $type_docs ; 
}

function get_course_target_memeber_list() 
{
	return array(
		-1 => '不限', 
		1  => '一般民眾', 
		2  => '中小學教師' , 
		3  => '高中職教師' ,
		4  => '大專院校師生' 
	);
}

function get_type_personal_list() 
{
	return array(
		-1 => '不限', 
		0  => '一般教師', 
		1  => '主任' , 
		2  => '校長' ,
        3  => '中小學教師(含以上三種身份)'
	);
}

// 驗證 input , 使變數變成 global 變數 可以直接用GLOBALS
function validate_input($in) 
{
	$TIMESTAMP_FORMAT = 'Y-m-d' ;
	
	foreach($in as $key => $value) {
	
		if($value == 'int' && array_key_exists($key, $_GET) ) { 
				$GLOBALS['has_data'] = true ;          // 有input 表示有查詢
				$GLOBALS[$key] = intval($_GET[$key]);  // 註冊成為globals 讓原本的php 可以直接取用
		}
		if($value == 'string' && array_key_exists($key, $_GET) &&  !empty($_GET[$key]) ) {
				$GLOBALS['has_data'] = true ;
				$GLOBALS[$key] = trim($_GET[$key]);
		}
		if($value == 'date' && array_key_exists($key, $_GET) && !empty($_GET[$key]) ) {
				
				$GLOBALS['has_data'] = true ; 
				$date = date_create($_GET[$key]) ;
				$GLOBALS[$key] = $date->format($TIMESTAMP_FORMAT); //預設傳近來就是OK的 date format
		}
	}
}

//產生 查詢 begin_course 的 sql where子句
function sql_course_where ($class_choose, $class_kind, $class_target_member, $date_course_begin, $date_course_end, $deliver_passhour= -1 ) 
{
	
	$sql_course_where = '' ;
	if( intval($class_target_member) != -1) {
		$sql_course_where .= ' AND memberkind = '. intval($class_target_member); 
	}	
	 
    if ( isset($class_choose) && $class_choose != -1) { //直接指定課程begin_course_cd 
        $sql_course_where .= ' AND begin_course_cd=' . $class_choose ; 
    }elseif ( isset($class_kind) && $class_kind != -1) {  
        $sql_course_where .= ' AND course_property=' . $class_kind ;
    }	
	 

	if( isset($date_course_begin) ) {
	    $sql_course_where .= " AND begin_course.d_course_begin >= '$date_course_begin 00:00:00' ";
	}
	if( isset($date_course_end) ) {
	    $sql_course_where .= " AND begin_course.d_course_begin <='$date_course_end 23:23:59' "; 
	}
    if( $deliver_passhour != -1 ) { 
        $sql_course_where .= " AND deliver=1 "; // 是否傳送高師大驗證
    }
		
	return $sql_course_where ; 
}


//產生查詢 take_course 的 sql where 的子句 
//date_begin 
//date_end 
//pass  是否通過
function sql_takecourse_where($date_begin , $date_end , $pass=-1)
{
	$sql_where  =  ' AND take_course.allow_course = 1 '; 
	if (isset($date_begin) && !empty($date_begin) ) {
		$sql_where .= " AND take_course.course_begin >= '$date_begin 00:00:00' ";
	}
	if (isset($date_end) && !empty($date_end)) {
		$sql_where .= " AND take_course.course_end <= '$date_end 23:23:59' ";
	}
	
	if( $pass != -1) {
		$sql_where .= " AND take_course.pass=1 ";
	}
	
	return $sql_where ; 
}



function sql_persoanl_basic_where($type_location=-1 , $type_doc=-1, $type_personal=-1 ) 
{
	 $type_title_str = array(-1=>'',0=>'0' /*一般教師*/, 1=>'1' /*主任*/, 2=>'2' /*校長*/);

	$sql_where = '' ; 
	
    if ( isset($type_location) && $type_location != -1) {
        $sql_where .= ' AND personal_basic.city_cd = ' . $type_location;
    }
    if ( isset($type_doc) &&  $type_doc != -1 ) {
		if( $type_doc == -2 ) { //全部
			$sql_where .= ' AND personal_basic.doc_cd in (select doc_cd from docs)';
		}else {
			$sql_where .= ' AND personal_basic.doc_cd = ' . $type_doc;
		}
        
    }
	

//人員身份別 -- 一般教師 /  校長
	if($type_personal != -1 && $type_personal != 3) {
		$sql_where .= ' AND (personal_basic.dist_cd =1 || personal_basic.dist_cd =2) ' ;
		$sql_where .= " AND personal_basic.title = '{$type_title_str[$type_personal]}'";
	}	
	
	//所有身份狀況 中小學教師
	if($type_personal == 3 ){
		$sql_where .= " AND ( personal_basic.title ='{$type_title_str[0]}' OR personal_basic.title ='{$type_title_str[1]}' OR personal_basic.title ='{$type_title_str[2]}' ) " ; 
	}
 
	return $sql_where ; 
}



function sql_gen_diff_type_num_count($sql_sub_begin_course_cd, $sql_takecourse_where, $query_type) {
	$SEX_TYPE = array( 
		'male' =>  ' AND (personal_basic.sex=1 OR personal_basic.sex is NULL)',  //男
		'female' =>  ' AND personal_basic.sex=0 ',  // 女
		'none' => ' '  // 無
	); 

	$PERSON_TYPE = array (
		'new_resident' => ' AND personal_basic.familysite = 3 ', //新住民
		'women' => ' AND personal_basic.d_birthday < DATE_SUB(NOW(), INTERVAL 40 YEAR) ' , // 婦女
		'elder' => ' AND personal_basic.d_birthday < DATE_SUB(NOW(), INTERVAL 50 YEAR) ' , // 銀髮族
		'laborer' => ' AND personal_basic.job = 0', //勞工
		'none' => ' ' // 無
	); 

	$IS_DISTINCT_PERSON = array( 
		'no_distinct' => ' count(personal_basic.personal_id) ' ,  // 人次
		'distinct' => ' count( DISTINCT personal_basic.personal_id) ' ,  // 人數
		'none' => ' ' // 無 
	);

	$count_field = $IS_DISTINCT_PERSON [$query_type[0] ] ; 
	$sex = $SEX_TYPE[ $query_type[1] ] ; 
	$person_type = $PERSON_TYPE[ $query_type[2] ] ; 
	
	$sql = " SELECT  $count_field FROM take_course "
		." LEFT JOIN personal_basic ON personal_basic.personal_id = take_course.personal_id "
		." WHERE take_course.begin_course_cd in  ( $sql_sub_begin_course_cd  ) AND take_course.allow_course = 1  "
		."  $sex $person_type $sql_takecourse_where " ;  
	return $sql ; 
}


//產生 url 參數 , 第二個參數傳入 不想自動產生的變數
function url_gen_param($input_arr, $escape_setting_name='')
{
	$param_row = array(); 
	foreach($input_arr as $key => $value) {
		if($escape_setting_name != $key)
			$param_row[] = $key.'='.$GLOBALS[$key];
	}
	if( !empty($param_row))
		return implode("&", $param_row);
	else 
		return '';
}

function url_append_param($url_string, $field_name, $value) {
	if( empty($url_string) )
		return $field_name .'=' . urlencode($value) ; 
	else 
		return $url_string . '&'. $field_name .'=' . urlencode($value) ; 
}


function search_cond_value_convert($type, $field ,  $value) {
	if( $field == 'class_kind' ) {
		global $course_property; 
		return $course_property[$value] ;
	}
	if( $field == 'class_choose' ) {
		global $class_list; 
		return $class_list[ $value ] ;
	}
	if( $field == 'type_doc') {
		global $type_docs ; 
		return $type_docs[ $value ] ;		
	}
	
	if( $field == 'type_location') {
		global $location_list; 
		return $location_list[ $value ] ;
	}
	if( $field == 'type_personal') {
		global $type_personal_list ; 
		return $type_personal_list[ $value ] ;
	}
	
	if( $type == 'int' ) {
		return $value == -1 ? '不限':$value; 
	}
	if( $type == 'date' ) {
		return $value == '' ? '無':$value ; 
	}
}
function gen_search_cond_value($input_check )  
{
	global $SEARCH_COND_TITLE ; 
	$ret_search_cond_arr = array(); 
	
	foreach( $input_check as $key => $value) {
		$target_value = search_cond_value_convert($value, $key , $GLOBALS[$key] ) ; 
		$ret_search_cond_arr[ $key ] = array(
			'title'=> $SEARCH_COND_TITLE[ $key ] , 
			'value'=> $target_value
		);
	}
	
	return $ret_search_cond_arr;
}

//return phpexcel obj
function gen_excel_with_search($search_cond ) { 
	
	global $HOME_PATH , $EXCEL_STYLE_COMMON_TITLE; 
	
	require_once $HOME_PATH.'library/PHPExcel.php';
	/** PHPExcel_IOFactory */ 
	require_once $HOME_PATH.'library/PHPExcel/IOFactory.php';


	$EXCEL_STYLE_COMMON_TITLE = array( 
		'font'    => array( 
			'bold'      => true 
		), 
		'alignment' => array( 
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
		), 
		'borders' => array( 
			'top'     => array( 
				 'style' => PHPExcel_Style_Border::BORDER_THIN 
			 ) 
		), 
		'fill' => array( 
			 'type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR, 
			 'rotation'   => 90, 
			 'startcolor' => array( 
				 'rgb' => 'DCDCDC' 
			 ), 
			 'endcolor'   => array( 
				 'rgb' => 'FFFFFF' 
			 )
		 ) 
	);
	
	$data_style = array('fill'     => array( 
			'type' => PHPExcel_Style_Fill::FILL_SOLID, 
			'color' => array('rgb' => 'D1EEEE') 
			), 
	); 

	$objPHPExcel = new PHPExcel(); 
	$objPHPExcel->setActiveSheetIndex(0);

	//搜尋結果
	$objPHPExcel->getActiveSheet()->mergeCells('A1:B1');

	//設定'層背'顏'''('/') 
	$objPHPExcel->getActiveSheet()->getStyle('A1:B1')->applyFromArray( $EXCEL_STYLE_COMMON_TITLE );

	//設定字大小 
	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);

	//設定A1字PHPEXCEL TEST 
	$objPHPExcel->getActiveSheet()->setCellValue('A1','搜尋條件');

	//設定字顏 
	//$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);

	//設定背顏 
	//設定''' 
	
	/*
	$search_cond = array(
		'course_date_begin' => array('title'=>'搜尋開課時間-開始' , 'value'=>'1985-02-19') , 
		'course_date_end' => array( 'title'=>'', 'value'=>'1985-02-19'  )
	);*/ 
	
	$index = 1 ; 
	foreach($search_cond as $key => $row) {
		$index ++ ; 
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$index , $row['title']);
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$index , $row['value']);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$index)->applyFromArray( $data_style );
	}
	
	
	// Rename sheet 
	//$objPHPExcel->getActiveSheet()->setTitle(sheet);

	//設定'''寬'('') 
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet 
	$objPHPExcel->setActiveSheetIndex(0);

	// Export to Excel2007 (.xlsx) '出'2007

	//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007'); 
	//$objWriter->save('test.xlsx');

	return $objPHPExcel;
	
	
	// Export to Excel5 (.xls) '出'2003
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
	$objWriter->save('test.xls');
}

//這個function 要確定gen_excel_with_search 被call後 才能call 
//這樣才能保證 phpexcel library 被 include
function append_request1_data($objExcel , $summary, $course_list) 
{
	$EXCEL_STYLE_COMMON_TITLE = array( 
		'font'    => array( 
			'bold'      => true 
		), 
		'alignment' => array( 
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
		), 
		'borders' => array( 
			'top'     => array( 
				 'style' => PHPExcel_Style_Border::BORDER_THIN 
			 ) 
		), 
		'fill' => array( 
			 'type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR, 
			 'rotation'   => 90, 
			 'startcolor' => array( 
				 'rgb' => 'DCDCDC' 
			 ), 
			 'endcolor'   => array( 
				 'rgb' => 'FFFFFF' 
			 )
		 ) 
	);

// 假設搜尋只會放到第 14行  所以summary 從第15行 開始放 
	$index = 13 ; 
	
	//設定 查詢結果 title 
	$objExcel->getActiveSheet()->setCellValue('A'.$index ,'查詢結果');
	$objExcel->getActiveSheet()->mergeCells('A'.$index.':B'.$index);
	$objExcel->getActiveSheet()->getStyle('A'.$index)->applyFromArray( $EXCEL_STYLE_COMMON_TITLE );
	$objExcel->getActiveSheet()->getStyle('A'.$index)->getFont()->setSize(16);
	foreach ($summary as $row ){
		$index++ ;
		$objExcel->getActiveSheet()->setCellValue('A'.$index , $row['title']);
		$objExcel->getActiveSheet()->setCellValue('B'.$index , $row['value']);
		
	}

	$index += 3 ;  // 隔個幾行再顯示課程
	
	//設定課程清單 title 
	$objExcel->getActiveSheet()->setCellValue('A'.$index ,'課程清單');
	$objExcel->getActiveSheet()->mergeCells('A'.$index.':F'.$index);	
	$objExcel->getActiveSheet()->getStyle('A'.$index)->applyFromArray( $EXCEL_STYLE_COMMON_TITLE );
	$objExcel->getActiveSheet()->getStyle('A'.$index)->getFont()->setSize(16);
	
	if(!empty($course_list) )  {
		foreach($course_list as $row) {
			$index ++ ; 
			$objExcel->getActiveSheet()->setCellValue('A'.$index , $row['index']);
			$objExcel->getActiveSheet()->setCellValue('B'.$index , $row['begin_course_name']);
			$objExcel->getActiveSheet()->setCellValue('C'.$index , $row['certify']);
			$objExcel->getActiveSheet()->setCellValue('D'.$index , $row['take_course_count']);
			$objExcel->getActiveSheet()->setCellValue('E'.$index , $row['take_course_count_pass']);
			$objExcel->getActiveSheet()->setCellValue('F'.$index , $row['course_pass_hour']);
		}
	}
	$objExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
	$objExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
	$objExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
	
	return $objExcel ; 
} 

function append_request2_data($objExcel, $summary, $course_data) 
{
	$column_index = array( 0=>'A', 1=>'B', 2=>'C', 3=>'D', 4=>'E');

	$EXCEL_STYLE_ALIGN_CENTER = array(
		'alignment' => array( 
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
		) 
	);
	$EXCEL_STYLE_COMMON_TITLE = array( 
		'font'    => array( 
			'bold'      => true 
		), 
		'alignment' => array( 
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
		), 
		'borders' => array( 
			'top'     => array( 
			'style' => PHPExcel_Style_Border::BORDER_THIN 
			 ) 
		), 
		'fill' => array( 
			 'type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR, 
			 'rotation'   => 90, 
			 'startcolor' => array( 
				 'rgb' => 'DCDCDC' 
			 ), 
			 'endcolor'   => array( 
				 'rgb' => 'FFFFFF' 
			 )
		 ) 
	);
	
	$COURSE_BACKGROUND_STYLE = array('fill'     => array( 
		'type' => PHPExcel_Style_Fill::FILL_SOLID, 
		'color' => array('rgb' => 'D1EEEE') 
		), 
	); 

// 假設搜尋只會放到第 14行  所以summary 從第15行 開始放 
	$index = 13 ; 
	
	//設定 查詢結果 title 
	$objExcel->getActiveSheet()->setCellValue('A'.$index ,'查詢結果');
	$objExcel->getActiveSheet()->mergeCells('A'.$index.':B'.$index);
	$objExcel->getActiveSheet()->getStyle('A'.$index)->applyFromArray( $EXCEL_STYLE_COMMON_TITLE );
	$objExcel->getActiveSheet()->getStyle('A'.$index)->getFont()->setSize(16);
	foreach ($summary as $row ){
		$index++ ;
		$objExcel->getActiveSheet()->setCellValue('A'.$index , $row['title']);
		$objExcel->getActiveSheet()->setCellValue('B'.$index , $row['value']);
		
	}
	
	$index += 2 ; // 與下一個課程的空行 

	$objExcel->getActiveSheet()->setCellValue('A'.$index ,'課程清單');
	$objExcel->getActiveSheet()->mergeCells('A'.$index.':B'.$index);
	$objExcel->getActiveSheet()->getStyle('A'.$index)->applyFromArray( $EXCEL_STYLE_COMMON_TITLE );
	$objExcel->getActiveSheet()->getStyle('A'.$index)->getFont()->setSize(16);	
	
	foreach($course_data as $row)  {
		
		$index ++ ; 
		$course_begin_index = $index ; 
		$objExcel->getActiveSheet()->setCellValue('A'.$index ,'課程名稱');
		$objExcel->getActiveSheet()->setCellValue('B'.$index ,$row['course_name']);
		$index ++ ; 
		$objExcel->getActiveSheet()->setCellValue('A'.$index ,'認證時數');
		$objExcel->getActiveSheet()->setCellValue('B'.$index ,$row['certify']);
		$index ++ ; 
		$objExcel->getActiveSheet()->setCellValue('A'.$index ,'通過修課人數/ 修課人數');
		$objExcel->getActiveSheet()->setCellValue('B'.$index ,"{$row['course_total_yet_pass_stu']}/{$row['course_total_stu']}");
		
		$index ++ ; 
		
		//通過認證學生 (時數)
		$objExcel->getActiveSheet()->setCellValue('A'.$index ,'通過認證學生 ('.$row['course_total_pass_stu'].')') ;
		$objExcel->getActiveSheet()->mergeCells('A'.$index.':D'.$index);
		$objExcel->getActiveSheet()->getStyle('A'.$index)->applyFromArray( $EXCEL_STYLE_ALIGN_CENTER );
		if( !empty($row['passed_stus'])) {
			foreach($row['passed_stus'] as $stus ) {
				$index ++  ;
				$objExcel->getActiveSheet()->setCellValue('A'.$index ,$stus[0]);
				$objExcel->getActiveSheet()->setCellValue('B'.$index ,$stus[1]);
				$objExcel->getActiveSheet()->setCellValue('C'.$index ,$stus[2]);
				$objExcel->getActiveSheet()->setCellValue('D'.$index ,$stus[3]);
			}
		}
		$index ++ ;
		//未通過認證學生 (時數)
		$objExcel->getActiveSheet()->setCellValue('A'.$index ,'未通過通過認證學生 ('.$row['course_total_yet_pass_stu'].')') ;
		$objExcel->getActiveSheet()->mergeCells('A'.$index.':D'.$index);
				$objExcel->getActiveSheet()->getStyle('A'.$index)->applyFromArray( $EXCEL_STYLE_ALIGN_CENTER );
		if( !empty($row['yet_passed_stus'])) {
			foreach($row['yet_passed_stus'] as $stus ) {
				$index ++  ;
				$objExcel->getActiveSheet()->setCellValue('A'.$index ,$stus[0]);
				$objExcel->getActiveSheet()->setCellValue('B'.$index ,$stus[1]);
				$objExcel->getActiveSheet()->setCellValue('C'.$index ,$stus[2]);
				$objExcel->getActiveSheet()->setCellValue('D'.$index ,$stus[3]);	
			}		
		}
		$course_end_index = $index ;
		$objExcel->getActiveSheet()->getStyle('A'.$course_begin_index.':D'.$course_end_index)->applyFromArray( $COURSE_BACKGROUND_STYLE );
		
		$index += 2 ; // 與下一個課程的空行 
	}
	
	return $objExcel ;
}




?>
