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
//ini_set('display_errors', 1) ;


define('ROOT', '../');
require_once(ROOT.'config.php');
require_once('session.php');
//checkAdmin();

require_once('stat_lib.php');

global $url_parma ;
$tpl = new Smarty;

//url 搜尋的參數
$url_parma = array(); 
$has_data = false;

//default value 
$type_personal = -1 ; 
$deliver_passhour = 1; 
$class_kind = -1 ;
$order_method = 2 ; 
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
    'type_location' => 'int' , 
    'type_personal' => 'int' , 
    'order_method' => 'int'
);

//well_print($_SESSION);

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
$tpl->assign('session_no', $_SESSION['no']);

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
    $sql_med_takecourse_where = '';
    $sql_begin_course_where = '' ; //撈出 哪些是需要的課
    $sql_table = '';
    $sql_med_takecourse_where = '';



    //收尋關於課程的條件
    $sql_begin_course_where .= sql_course_where($class_choose, $class_kind, $class_target_member , $date_course_begin, $date_course_end, $deliver_passhour);

    //搜尋修課 及人員條件
    $sql_med_takecourse_where .= sql_med_takecourse_where($date_begin, $date_end, -1) ;
    $sql_med_takecourse_where .= sql_persoanl_basic_where($type_location , -1 , $type_personal) ; 	


    //符合課程選取的 set (取出 begin_course_cd 的 set )
    $sql_sub_begin_course_cd  = " SELECT begin_course_cd, begin_course_name, certify FROM begin_course where 1=1 $sql_begin_course_where" ;
    //well_print($sql_sub_begin_course_cd); 
    //echo "<hr/>" ; 

    $all_course = db_getAll( $sql_sub_begin_course_cd ); 
    //well_print($all_course) ;
    //dump_sql($sql_sub_begin_course_cd, '搜尋符合的課程'); 

    $sql_sub_begin_course_cd =" SELECT begin_course_cd FROM begin_course where 1=1 $sql_begin_course_where " ;

    if($order_method == 1) { //依縣市排列
        $result = list_course_group_by_location($all_course, get_location_list(0),$flag_download_excel ) ;
    }
    if($order_method == 2) {
        $result = list_course($all_course,$flag_download_excel);
    }
    if($order_method == 3) {
        $sql_sub_begin_course_cd = " SELECT begin_course_cd, begin_course_name, certify FROM begin_course where begin_course_cd in (208,209,210,211,212,213,214,215,216)" ;
        $all_course = db_getAll( $sql_sub_begin_course_cd );
        $result = list_course_group_by_location($all_course, get_location_list(0),$flag_download_excel);
    }
    $total_stu = $result['total']['stu']; 
    $total_stu_pass = $result['total']['stu_pass']; 
    $total_stu_pass_certify_hour = $result['total']['stu_pass_certify_hour'] ;

    //well_print($result['location']) ;
    $tpl->assign('has_stu_location',	$result['location'] ) ; 

    $tpl->assign('order_method', 	$order_method);
    $tpl->assign('list_course' , 	$result['list_course']	) ; 
    $tpl->assign('total_stu', 		$result['total']['stu']	);
    $tpl->assign('total_stu_pass', 	$result['total']['stu_pass'] );
    $tpl->assign('total_stu_pass_certify_hour', $result['total']['stu_pass_certify_hour'] );
    //*/
} // end has data 

if( $flag_download_excel != true ) {
    assignTemplate($tpl, '/apply_course/stat_request_medicine.tpl');
} else {
    $search_cond = gen_search_cond_value($input_check) ; 
    $allcourse = ($type_location == -1)? true: false;	
    $objExcel = gen_excel_with_search($search_cond) ; 
    $objExcel = append_request2_data($objExcel, 
        gen_summary($total_stu, $total_stu_pass, $total_stu_pass_certify_hour), 
        $result['list_course'],
        $order_method,
        $allcourse
    ) ;

    // redirect output to client browser
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.urlencode("防治學生藥物濫用-統計報表.xls").'"');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objExcel, 'Excel5'); 
    $objWriter->save('php://output');
}


function gen_summary($total_stu, $total_stu_pass, $total_stu_pass_certify_hour) 
{
    $summary[] = array('title'=> '總通過人數', 'value'=> $total_stu_pass); 
    $summary[] = array('title'=> '總修課人數', 'value'=> $total_stu); 
    $summary[] = array('title'=> '總通過時數', 'value'=> $total_stu_pass_certify_hour); 
    return $summary ; 
}


function list_course($all_course,$to_excel=false) {
    global $sql_takecourse_where ; 
    $result = array() ; 
    $list_course = array() ;

    foreach( $all_course as $course) {

        $sql_take_course_stus = " select personal_basic.personal_id, personal_name,personal_basic.city_cd, personal_basic.school_type, personal_basic.school_cd, pass, take_course.send2nknu_time FROM take_course "
            ." LEFT JOIN personal_basic ON take_course.personal_id=personal_basic.personal_id "
            ." WHERE begin_course_cd={$course['begin_course_cd']} $sql_med_takecourse_where  $sql_where_location " ;

        //echo $sql_take_course_stus;
        //well_print($sql_take_course_stus) ;
        $takecourse_stus = db_getAll($sql_take_course_stus);

        //如果沒有修課學生 則不表列	
        if( empty($takecourse_stus) )
            continue ; 

        unset($passed_stus) ; 
        unset($yet_passed_stus);
        unset($passed_stus_with_time); 
        $course_total_stu = 0; 
        $course_total_pass_stu = 0  ; 


        foreach($takecourse_stus as $stu) {
            $course_total_stu ++ ;
            if( $stu['pass'] == 1 ) { //通過的學生
                $course_total_pass_stu ++ ;
                $passed_stus[] = $stu['personal_name'];
                $sql="select city , school from location where city_cd = '{$stu['city_cd']}' and school_cd = '{$stu['school_cd']}'";
                $res = db_getAll($sql);
                if(count($res) == 0)
                    $admin = '無';
                else
                    $admin = $res[0]['city'].'-'.$res[0]['school'];
                $passed_stus_with_time[] = array($stu['personal_name'],$stu['city_cd'],$stu['send2nknu_time'],$admin) ; 	
            }else { //尚未通過的學生
                $yet_passed_stus[] = $stu['personal_name'] ; 
            }

        }

        $print_course = array(
            'course_name'		=> $course['begin_course_name'], 
            'certify' 			=> $course['certify'] , 
            'course_total_stu' 	=> $course_total_stu, 
            'passed_stus' 		=> $passed_stus_with_time , 
            'yet_passed_stus' 	=> $yet_passed_stus,
            'course_total_pass_stu' 	=> $course_total_pass_stu  , 
            'course_total_yet_pass_stu' => ($course_total_stu - $course_total_pass_stu)
        );

        if(!$to_excel)
        {
            $print_course['passed_stus'] = table_2Ddata_place($passed_stus);
            $print_course['yet_passed_stus'] = table_2Ddata_place($print_course['yet_passed_stus']);
        }
        //well_print($print_course);
        $result['list_course'][]  = $print_course ;
        $result['total']['stu'] += $course_total_stu;
        $result['total']['stu_pass'] += $course_total_pass_stu ;
        $result['total']['stu_pass_certify_hour'] += $course['certify'] * $course_total_pass_stu ;	
    }// end of location 

    return $result;
}

//根據縣市分群組 
function list_course_group_by_location($all_course , $location,$to_excel=false) {
    global $sql_med_takecourse_where ; 
    $result = array() ; 
    $list_course = array() ;

    //well_print($location);
    //unset($location[-1]); 


    //loop 縣市找出修課學生及通過認證情況
    foreach( $location as $key => $value) {

        $result['location'][$key]['name'] = $value;
        $result['location'][$key]['stu'] = 0;
        $result['location'][$key]['stu_pass'] = 0;
        $result['location'][$key]['stu_pass_certify_hour'] = 0;


        $sql_where_location = ' AND personal_basic.city_cd=' . $key . ' ' ; 

        foreach( $all_course as $course) {

            $sql_take_course_stus = " select personal_basic.personal_id, personal_name, pass, personal_basic.city_cd, personal_basic.school_cd , take_course.send2nknu_time FROM take_course "
                ." LEFT JOIN personal_basic ON take_course.personal_id=personal_basic.personal_id "
                ." WHERE begin_course_cd={$course['begin_course_cd']} $sql_med_takecourse_where  $sql_where_location " ;

            unset($takecourse_stus);
            $takecourse_stus = db_getAll($sql_take_course_stus);

            //well_print($sql_take_course_stus);
            //well_print($takecourse_stus) ;

            //如果沒有修課學生 則不表列	
            // break!! 
            if( empty($takecourse_stus) ) {
                continue ; 
            }


            unset($passed_stus) ; 
            unset($yet_passed_stus); 
            unset($passed_stus_with_time);
            $course_total_stu = 0 ; 
            $course_total_pass_stu = 0 ;

            foreach($takecourse_stus as $stu) {
                $course_total_stu ++ ;
                if( $stu['pass'] == 1 ) { //通過的學生
                    $course_total_pass_stu ++ ;
                    $passed_stus[] = $stu['personal_name'] ;  
                    $sql="select city , school from location where city_cd = '{$stu['city_cd']}' and school_cd = '{$stu['school_cd']}'";
                    $res = db_getAll($sql);
                    if(count($res) == 0)
                        $admin = '無';
                    else
                        $admin = $res[0]['city'].'-'.$res[0]['school'];
                    $passed_stus_with_time[] = array($stu['personal_name'],$stu['city_cd'],$stu['send2nknu_time'],$admin) ;

                }else { //尚未通過的學生
                    $yet_passed_stus[] = $stu['personal_name'] ; 
                }
            }

            $print_course = array(
                'course_name'		=> $course['begin_course_name'], 
                'certify' 			=> $course['certify'] , 
                'course_total_stu' 	=> $course_total_stu, 
                'passed_stus' 		=> $passed_stus_with_time, 
                'yet_passed_stus' 	=> $yet_passed_stus,
                'course_total_pass_stu' 	=> $course_total_pass_stu  , 
                'course_total_yet_pass_stu' => ($course_total_stu - $course_total_pass_stu)
            );
            if(!$to_excel)
            {
                $print_course['passed_stus'] = table_2Ddata_place($passed_stus);
                $print_course['yet_passed_stus'] = table_2Ddata_place($yet_passed_stus);
            }
            //well_print($print_course) ;
            if( !empty($print_course) ){
                $result['list_course'][$key][]  = $print_course ;
                $result['location'][$key]['stu'] += $course_total_stu;
                $result['location'][$key]['stu_pass'] += $course_total_pass_stu;
                $result['location'][$key]['stu_pass_certify_hour'] += $course['certify'] * $course_total_pass_stu;

            }

            $result['total']['stu'] += $course_total_stu;
            $result['total']['stu_pass'] += $course_total_pass_stu ;
            $result['total']['stu_pass_certify_hour'] += $course['certify'] * $course_total_pass_stu ;
        }

        //如果該縣市沒有課程 則清空
        if( empty( $result['list_course'][$key] ) ) {
            unset($result['location'][$key]);
        }

    }// end of location 

    return $result;

}// end list_course 

?>
