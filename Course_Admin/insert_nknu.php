<?php 
//目的：將平台的課程資訊&通過認證學生匯到高師大[教師在職進修資訊傳報系統]

//ini_set('display_errors', 'on');
//error_reporting(E_ALL) ;
include("../config.php") ;

global $DEBUG, $commit_course_stus ; 
global $nknu_db_host, $nknu_db_user, $nknu_db_passwd, $nknu_database, $import_table_name;
$DEBUG = true;
$commit_course_stus = array(/*begin_course_cd => array(personal_ids)*/) ; 

//Host 定義在/usr/local/etc/freetds/freetds.conf 
$nknu_db_host = 'IMPORT_NKNU_TEST'; 
$nknu_db_user = "Hsngccu" ;
$nknu_db_passwd = "Cyber3elearning" ;
$nknu_database = "course_Hsngccu" ;
$import_table_name = "course" ;


//送高師大資料庫與我們平台的對應表
//高師大資料庫欄位 => array( 
//		['NUMBER','STRING','sql_value','sql_default','sql_special_value'],
//		, [數值,'字串']
//		, [1=query, 0=default, 2=speical_query]
// );

$nknu_table = array(  
//'CourseID'		=> array(0, ''), 					//識別碼  --------- 系統pk id  
'Import_ID'			=> array('STRING', 'begin_course_cd', 1), 	//各縣市自用代碼
'CourseName'		=> array('STRING', 'begin_course_name', 1), 	//研習名稱
'AllowNo'			=> array('STRING', 'article_number', 1),				//依據文號
'CourseProperty_1'	=> array('NUMBER', '75', 0),					//課程性質1
'CourseProperty_2'	=> array('NUMBER', '2', 0),					//課程性質2
'CourseProperty_3'	=> array('NUMBER', '50', 0),					//課程性質3
'CourseProperty_4'	=> array('NUMBER', '999', 0),					//課程性質4 
'SchoolId'			=> array('STRING', '教育部電算中心', 0),		//研習單位/學校
'CourseKind'		=> array('NUMBER', '0', 0),					//班別性質
'CourseHour'		=> array('NUMBER', 'take_hour', 1),			//課程時數/學分數
'StartTime'			=> array('STRING', 'd_course_begin', 1),		//課程開始日期
'EndTime'			=> array('STRING', 'd_course_end', 1),		//課程結束日期
'TimeId'			=> array('STRING', '3', 0),					//課程時間/時段
//'TimeSet'			=> array('STRING', '', 0),					//課程時間詳細描述
'FundId'			=> array('NUMBER', '3', 0),					//學員繳費方式
'SubsidizeId'		=> array('NUMBER', '14',0),					//補助單位
'Contact_1_name'	=> array('STRING', 'director_name',1),		//聯絡人1 名字
'Contact_1_tel'		=> array('STRING', 'director_tel',1),		//聯絡人1 電話
'Contact_1_mail'	=> array('STRING', 'director_email',1),		//聯絡人1 Mail
'Contact_2_name'	=> array('STRING', '',0),					//聯絡人2 名字
'Contact_2_tel'		=> array('STRING', '',0),					//聯絡人2 電話
'Contact_2_mail'	=> array('STRING', '',0),					//聯絡人2 Mail
//============== 通過認證學員名單 ex: 身份證字號-時數,身份證字號-時數,身份證字號-時數
'TeacherList'		=> array('STRING', '', 2), 	// speical case query				
'FundMoney'			=> array('NUMBER', '0', 0),					//補助金額
'Member'			=> array('STRING', 'course_stage', 1),		//研習對象階段別
'MemberKind'		=> array('STRING', 'career_stage', 1),		//研習對象身分別
//'Description'		=> array('STRING', '', 0),					//課程內容大綱
'TeacherNum'		=> array('NUMBER', '255', 0),					//班級人數
'ClassNum'			=> array('NUMBER', '1', 0),					//班級數
'ApplyStartTime'	=> array('STRING', 'd_course_begin', 1),		//報名開始日期
'ApplyEndTime'		=> array('STRING', 'd_course_end', 1),		//報名截止日期
'Charge'			=> array('NUMBER', '0', 0),					//繳費金額
//'TeacherChargeList' => array(-1,'NULL')				//已繳費之學員名單 NULL
'CourseState'		=> array('NUMBER', '1', 0)					//課程狀態，coursestat=1 準備狀態
//'CourseError'		=> '' //匯入錯誤
);


/*
mssql_connect($nknu_db_host, $nknu_db_user, $nknu_db_passwd) or die(mssql_get_last_message());
mssql_select_db($nknu_database) or die(mssql_get_last_message());
//mssql_query("SET NAMES UTF8") or die(mssql_get_last_message());
$test_sql = "insert into course (Import_ID ,CourseName ,AllowNo ,CourseProperty_1 ,CourseProperty_2 ,CourseProperty_3 ,CourseProperty_4 ,SchoolId ,CourseKind ,CourseHour ,StartTime ,EndTime ,TimeId ,FundId ,SubsidizeId ,Contact_1_name ,Contact_1_tel ,Contact_1_mail ,Contact_2_name ,Contact_2_tel ,Contact_2_mail ,TeacherList ,FundMoney ,Member ,MemberKind ,TeacherNum ,ClassNum ,ApplyStartTime ,ApplyEndTime ,Charge) VALUES ('217' ,'te' ,'tes' ,75 ,2 ,50 ,999 ,'testst' ,0 ,0 ,'2009/08/28' ,'2024/08/24' ,'3' ,3 ,14 ,'testet' ,'0912345678' ,'s750716@gmail.com' ,'' ,'' ,'' ,'' ,0 ,'23' ,'teste' ,255 ,1 ,'2009/08/28' ,'2024/08/24' ,0);";
$version = mssql_query($test_sql);
$row = mssql_fetch_array($version);
echo $row[0]."<br/>\n";
// Clean up
mssql_free_result($version);
debug_print(mssql_get_last_message() );

*/
// 課程很多的時候可能要做paging !!!!!!!!!! (批次處理)
// 不然一次撈出來會有可能會memory不夠  (還沒未處理)
$all_course2nknu = getAllCourse($nknu_table);

echo "Get All import courses<br/>\n" ;
well_print($all_course2nknu) ;
if( empty($all_course2nknu ) )
	return ;

print_r($all_course2nknu);
foreach($all_course2nknu as $row) {
	$import_sql = genImportSQL($nknu_table, $row );
	debug_print($import_sql) ;
	//mssql_query($import_sql) ; 
	//debug_print(mssql_get_last_message() );
}

update_commit_stus($commit_course_stus) ; 

well_print($commit_course_stus);




function update_commit_stus(& $commit_course_stus)
{
    foreach($commit_course_stus as $begin_course_cd => $course) {
        foreach($course as $pid ) {
            $update_send2nknu_time = " update take_course set send2nknu_time=NOW() where begin_course_cd=$begin_course_cd and personal_id=$pid ";
            db_query($update_send2nknu_time);
        }
	}
}

function genImportSQL(& $nknu_table, & $the_course )
{	
	global $import_table_name;
	$flag_begin = true;
	$insert_sql = '';
	$field_part = '';
	$value_part = '';
	foreach($nknu_table as $field_name => $row) {
		if($flag_begin){
			$field_part .= $field_name ;
			$value_part .= getImportSQLvalue($field_name, $row, $the_course);
			$flag_begin = false ;
		}else {
			$field_part .= ' ,'.$field_name ;
			$value_part .= ' ,'.getImportSQLvalue($field_name, $row, $the_course);
		
		}
	}
	// table name 要改;
	$insert_sql = 'insert into '.$import_table_name .' (' . $field_part . ') VALUES (' . $value_part .');';
	
	return $insert_sql ;
}

//注意有順序的
function getImportSQLvalue($field_name, $field_info, & $the_course) 
{
	// special case 
	if($field_name == 'AllowNo' && $the_course[ $field_info[1] ] == '')
		return "'".iconv('UTF-8','CP950', '無文號')."'";
	
	//TODO: 時間可能需特別要處理成 2009/9/14  不用補0  ，好像不用XDD
	if($field_name == 'StartTime' || $field_name == 'EndTime' ||
		$field_name =='ApplyStartTime' || $field_name =='ApplyEndTime') {
		return "'".str_replace('-','/',trim($the_course[ $field_info[1] ], ' 00:00:00'))."'" ;
	}
    if($field_name == 'Member') { //course_stage_decode include from library/common.php
		$the_course[$field_info[1]]=implode(',', course_stage_decode_str($the_course[$field_info[1]]) );
		echo "test Member:<br/>'".$the_course[$field_info[1]]."'<br/>$field_info[1]:".$field_info[1]."<br/>";
		return "'".$the_course[$field_info[1]]."'";
    }
	
	if($field_name == 'TeacherList' ) {
		return "'".getPassedStudents($the_course['begin_course_cd'], $the_course['take_hour'])."'";
	}

	//general case 
	if($field_info[0] == 'NUMBER') { //數字 不用加 quotation mark 
		return $field_info[2]==1?$the_course[ $field_info[1] ]:$field_info[1];
	}
	if($field_info[0] == 'STRING') { // index for begin_course value ;
		$return_value = $field_info[2]==1?("N'".$the_course[ $field_info[1] ]."'"):("N'".$field_info[1]."'");
		$return_value = iconv('UTF-8','CP950', $return_value);
		return $return_value ;
		//return "'".$the_course[ $field_info[1] ]."'" ;
	}
	if($field_info[0] == -1 ){ // SQL default value 
		return $field_info[1] ;
	}
}


//產生通過的學生清單
// take_hour - 認證時數
function getPassedStudents($begin_course_cd, $take_hour )
{
	global $commit_course_stus ; 


	$getPassedStus_SQL = 'SELECT PB.personal_id, PB.identify_id FROM personal_basic PB, take_course TC '
	." WHERE PB.personal_id=TC.personal_id AND pass=1 AND begin_course_cd=$begin_course_cd  ";
		
	$passedStus = db_getAll($getPassedStus_SQL) ;
	

	if( empty($passedStus) )
		return '';
	else {
		$return_str = '';
		$flag_first = true; 
		foreach($passedStus as $row) {
		    // 將有認證過得的學生記錄下來，等送完高師大確認後，更新 send2nknu_time 為處理送高師大的時間
			$commit_course_stus[ $begin_course_cd ][] = $row['personal_id'] ;
			if($flag_first) {
				$return_str .= 	$row['identify_id'].'-'.$take_hour ; 
				$flag_first = false ;	
			}else {// append 要加 , 
				$return_str .= 	','.$row['identify_id'].'-'.$take_hour ;  
			}
		}
		return $return_str ;
	}
}


function getAllCourse(&$nknu_table, $begin_course_cd=0 ) {
	
	$flag_first = true; 
	$sql = "select ";

	if($begin_course_cd !=0 )
		$begin_course_cd_sql = ' AND begin_course_cd='. $begin_course_cd;
	else 
		$begin_course_cd_sql = '';
		
		
	foreach($nknu_table as $key => $value) {

		if($value[2] === 1 ) { //準備要query得欄位
			if( !$flag_first ){ 
				$sql .= ', '. $value[1] ;	
			}else {
				$sql .= $value[1] ;	 // 第一次不加逗號
				$flag_first = false;
			}
		}
	}
	
	$sql .= ' FROM begin_course WHERE deliver=1' .$begin_course_cd_sql; //撈出確認要傳送高師大的
	debug_print($sql);
	return db_getAll($sql) ; 
}


function debug_print($sql)
{
	global $DEBUG;
	if( $DEBUG ){
		//well_print($sql);
		echo $sql. "<br/>\n<br/>\n";
	}
}
?>	
