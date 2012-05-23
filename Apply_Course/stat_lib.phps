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

function get_location_list($option = -1) 
{
    $location_list = array();
    $sql = 'SELECT city_cd,city FROM location GROUP BY city_cd';
    $result = db_query($sql);

    if( $option == -1)
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
    /*
    if( intval($class_target_member) != -1) {
        $sql_course_where .= ' AND memberkind = '. intval($class_target_member); 
    }*/	

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
//        $sql_where .= " AND take_course.send2nknu_time  <= '$date_end 23:23:59' ";
    }

    if( $pass != -1) {
        $sql_where .= " AND take_course.pass=1 ";
    }

    return $sql_where ; 
}


function sql_med_takecourse_where($date_begin , $date_end , $pass=-1)
{
    $sql_where  =  ' AND take_course.allow_course = 1 '; 
    if (isset($date_begin) && !empty($date_begin) ) {
        $sql_where .= " AND take_course.course_begin >= '$date_begin 00:00:00' ";
    }
    if (isset($date_end) && !empty($date_end)) {
        $sql_where .= " OR IF( take_course.pass !=1 ,take_course.course_end <= '$date_end 23:23:59',take_course.send2nknu_time <= '$date_end 23:23:59')";
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


//將單行的array data 轉成 2D 排列的table 資料以方便顯示
function table_2Ddata_place( $data )
{
    $num_column = 4 ; // 

    $table_data = array( array() ); 
    $x = $y = 0; 
    if(empty($data)) 
        return ; 

    $row = count($data) / $num_column; 
    if( ($data % $num_column) != 0 ) 
        $row ++;

    foreach( $data as $v) {
        $table_data[$x][$y++] = $v ; 
        if( $y == 4) {
            $x++ ;
            $y = 0 ; 
        }
    }
    //未塞滿一列
    if( $y != 0 ) {
        $table_data[$x] = array_pad($table_data[$x], $num_column, null);
    }
    return $table_data; 
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

    if(!empty($course_list) )  {
        $objSheet = $objExcel->createSheet();
        $objSheet->setTitle("資料清單");
        $objSheet->setCellValue('A1','年');
        $objSheet->setCellValue('B1','月');
        $objSheet->setCellValue('C1','DOC名稱');
        $objSheet->setCellValue('D1','課程類別');
        $objSheet->setCellValue('E1','課程名稱');
        $objSheet->setCellValue('F1','課程培訓(次數)');
        $objSheet->setCellValue('G1','課程培訓(時數)');
        $objSheet->setCellValue('H1','課程培訓人數(男)'); 
        $objSheet->setCellValue('I1','課程培訓人數(女)');
        $objSheet->setCellValue('J1','新住民教育訓練人數(男)');
        $objSheet->setCellValue('K1','新住民教育訓練人數(女)');
        $objSheet->setCellValue('L1','婦女教育訓練人數(女)');
        $objSheet->setCellValue('M1','銀髮族教育訓練人數(男)');
        $objSheet->setCellValue('N1','銀髮族教育訓練人數(女)');
        $objSheet->setCellValue('O1','勞工教育訓練人數(男)');
        $objSheet->setCellValue('P1','勞工教育訓練人數(女)');

        $rowCnt =2;
        foreach($course_list as $course)
        {
            $objSheet->setCellValue('A'.$rowCnt,'');
            $objSheet->setCellValue('B'.$rowCnt,'');
            $objSheet->setCellValue('C'.$rowCnt,$course['doc']);
            $objSheet->setCellValue('D'.$rowCnt,$course['course_property']);
            $objSheet->setCellValue('E'.$rowCnt,$course['begin_course_name']);
            $objSheet->setCellValue('F'.$rowCnt,$course['total_count']);
            $objSheet->setCellValue('G'.$rowCnt,$course['total_hour']);
            $objSheet->setCellValue('H'.$rowCnt,$course['data1']);
            $objSheet->setCellValue('I'.$rowCnt,$course['data2']);
            $objSheet->setCellValue('J'.$rowCnt,$course['data3']);
            $objSheet->setCellValue('K'.$rowCnt,$course['data4']);
            $objSheet->setCellValue('L'.$rowCnt,$course['data5']);
            $objSheet->setCellValue('M'.$rowCnt,$course['data6']);
            $objSheet->setCellValue('N'.$rowCnt,$course['data7']);
            $objSheet->setCellValue('O'.$rowCnt,$course['data8']);
            $objSheet->setCellValue('P'.$rowCnt,$course['data9']);

            $rowCnt++;

        }
        /*old code
        foreach($course_list as $row) {
            $index ++ ; 

            $objExcel->getActiveSheet()->setCellValue('A'.$index , $row['index']);
            $objExcel->getActiveSheet()->setCellValue('B'.$index , $row['begin_course_name']);
            $objExcel->getActiveSheet()->setCellValue('C'.$index , $row['certify']);
            $objExcel->getActiveSheet()->setCellValue('D'.$index , $row['take_course_count']);
            $objExcel->getActiveSheet()->setCellValue('E'.$index , $row['take_course_count_pass']);
            $objExcel->getActiveSheet()->setCellValue('F'.$index , $row['course_pass_hour']);
        }*/
    }
    $objExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
    $objExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
    $objExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);

    return $objExcel ; 
} 

function append_request2_data($objExcel, $summary, $course_data,$order_method,$allCity=false) 
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

    global $city_order;
    if($order_method ==1  or $order_method == 3){
        foreach($city_order as $city => $city_cd)
        {

            if(!$allCity && !isset($course_data[$city_cd]))
                continue;

            $objSheet = $objExcel->createSheet();
            $objSheet->setTitle($city);
            $objSheet->setCellValue('A1','所屬縣市');
            $objSheet->setCellValue('B1','時間區間');
            $objSheet->setCellValue('C1','課程名稱');
            $objSheet->setCellValue('D1','服務單位');
            $objSheet->setCellValue('E1','教師名稱');
            $objSheet->setCellValue('F1','研習時數');

            $city_courses = $course_data[$city_cd];
            if(empty($city_courses))
                continue;

            $rowCnt = 2;

            foreach($city_courses as $city_course)
            {
                foreach($city_course['passed_stus'] as $student)
                {
                    $objSheet->setCellValue('A'.$rowCnt,$city);
                    $objSheet->setCellValue('B'.$rowCnt,$student[2]);
                    $objSheet->setCellValue('C'.$rowCnt,$city_course['course_name']);
                    $objSheet->setCellValue('D'.$rowCnt,$student[3]);
                    $objSheet->setCellValue('E'.$rowCnt,$student[0]);
                    $objSheet->setCellValue('F'.$rowCnt,$city_course['certify']);
                    $rowCnt++;
                }

            }
        }
        $objSheet->getColumnDimension('A')->setAutoSize(true);
        $objSheet->getColumnDimension('B')->setAutoSize(true);
        $objSheet->getColumnDimension('C')->setAutoSize(true);
        $objSheet->getColumnDimension('D')->setAutoSize(true);
        $objSheet->getColumnDimension('E')->setAutoSize(true);
        $objSheet->getColumnDimension('F')->setAutoSize(true);
    }
    else if ($order_method == 2)
    {
        foreach($course_data as $course)
        {
            $objSheet = $objExcel->createSheet();
            $objSheet->setTitle($course['course_name']);
            $objSheet->getColumnDimension('A')->setAutoSize(true);
            $objSheet->getColumnDimension('B')->setAutoSize(true);
            $objSheet->getColumnDimension('C')->setAutoSize(true);
            $objSheet->getColumnDimension('D')->setAutoSize(true);
            $objSheet->getColumnDimension('E')->setAutoSize(true);
            $objSheet->getColumnDimension('F')->setAutoSize(true);


            $objSheet->setCellValue('A1','所屬縣市');
            $objSheet->setCellValue('B1','時間區間');
            $objSheet->setCellValue('C1','課程名稱');
            $objSheet->setCellValue('D1','服務單位');
            $objSheet->setCellValue('E1','老師姓名');
            $objSheet->setCellValue('F1','通過時數');

            $rowCnt = 2;

            foreach($course['passed_stus'] as $student)
            {
                $city = array_search($student[1],$city_order);
                $city = empty($city)? '' : $city;

                $objSheet->setCellValue('A'.$rowCnt,$city);
                $objSheet->setCellValue('B'.$rowCnt,$student[2]);
                $objSheet->setCellValue('C'.$rowCnt,$course['course_name']);
                $objSheet->setCellValue('D'.$rowCnt,$student[3]);
                $objSheet->setCellValue('E'.$rowCnt,$student[0]);
                $objSheet->setCellValue('F'.$rowCnt,$course['certify']);
                $rowCnt++;
            }
        }
    }

    return $objExcel;
}




?>
