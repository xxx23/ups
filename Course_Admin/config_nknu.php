<?php
require_once('../config.php');
//目的：將平台的課程資訊&通過認證學生匯到高師大[教師在職進修資訊傳報系統]
global $DEBUG, $commit_course_stus ; 
global $nknu_db_host, $nknu_db_user, $nknu_db_passwd, $nknu_database, $import_table_name,$nknu_link;
$DEBUG = true;
$commit_course_stus = array(/*begin_course_cd => array(personal_ids)*/) ; 

ini_set('display_errors',1);
error_reporting(E_ALL);
//Host 定義在/usr/local/etc/freetds/freetds.conf 
putenv('FREETDSCONF=/etc/freetds/freetds.conf');
$nknu_db_host = $NKNU_DB_HOST; 
$nknu_db_user = $NKNU_DB_USER ;
$nknu_db_passwd = $NKNU_DB_PASSWD ;
$nknu_database = $NKNU_DATABASE ;
$import_table_name = $NKNU_TABLE ;

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
'SchoolId'			=> array('STRING', '330N01', 0),		//研習單位/學校 330N01 教育部電算中心代號
'CourseKind'		=> array('NUMBER', '0', 0),					//班別性質
'CourseHour'		=> array('NUMBER', 'certify', 1),			//課程時數/學分數
'StartTime'			=> array('STRING', 'd_course_begin', 1),		//課程開始日期
'EndTime'			=> array('STRING', 'Y/m/d', 0),		//課程結束日期
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
'ApplyEndTime'		=> array('STRING', 'd_course_begin', 1),		//報名截止日期 設定為跟開課時間一樣已通過資訊傳報認證
'Charge'			=> array('NUMBER', '0', 0),					//繳費金額
//'TeacherChargeList' => array(-1,'NULL')				//已繳費之學員名單 NULL
'CourseState'		=> array('NUMBER', '1', 0)					//課程狀態，coursestat=1 準備狀態
//'CourseError'		=> '' //匯入錯誤
);

//連線到nknu的mssql
$nknu_link = mssql_connect($nknu_db_host, $nknu_db_user, $nknu_db_passwd) or die(mssql_get_last_message());
mssql_select_db($nknu_database) or die(mssql_get_last_message());

//???try連線??
/*
$test_sql = "insert into course (Import_ID ,CourseName ,AllowNo ,CourseProperty_1 ,CourseProperty_2 ,CourseProperty_3 ,CourseProperty_4 ,SchoolId ,CourseKind ,CourseHour ,StartTime ,EndTime ,TimeId ,FundId ,SubsidizeId ,Contact_1_name ,Contact_1_tel ,Contact_1_mail ,Contact_2_name ,Contact_2_tel ,Contact_2_mail ,TeacherList ,FundMoney ,Member ,MemberKind ,TeacherNum ,ClassNum ,ApplyStartTime ,ApplyEndTime ,Charge) VALUES ('217' ,'te' ,'tes' ,75 ,2 ,50 ,999 ,'testst' ,0 ,0 ,'2009/08/28' ,'2024/08/24' ,'3' ,3 ,14 ,'testet' ,'0912345678' ,'s750716@gmail.com' ,'' ,'' ,'' ,'' ,0 ,'23' ,'teste' ,255 ,1 ,'2009/08/28' ,'2024/08/24' ,0);";
$version = mssql_query($test_sql);
$row = mssql_fetch_array($version);
*/
function update_commit_stus(& $commit_course_stus)
{
    foreach($commit_course_stus as $begin_course_cd => $course) {
        foreach($course as $pid ) {
            $update_send2nknu_time = " update take_course 
                                       set send2nknu_time=NOW() 
                                       where begin_course_cd=$begin_course_cd 
                                       and personal_id=$pid 
                                       and send2nknu_time = '0000-00-00' ";
            db_query($update_send2nknu_time);
        }
	}
}

function genUpdateSQL(& $nknu_table, & $the_course)
{

    $begin_course_cd = $the_course['begin_course_cd'];
    $certify = $the_course['certify'];
    
    $sql_count_pass_stu  = "SELECT COUNT(*)
                            FROM personal_basic PB,take_course TC
                            WHERE TC.begin_course_cd = {$begin_course_cd}
                            AND PB.personal_id=TC.personal_id
                            AND (PB.dist_cd =1 OR PB.dist_cd =2)
                            AND TC.pass =1
                            AND TC.send2nknu_time = '0000-00-00';";
    $count_pass = db_getOne($sql_count_pass_stu);
    if($count_pass == 0)
        return '';
    
    $teacherList = getPassedStudents($begin_course_cd,$certify);
    $date_str = date('Y/m/d 00:00:00');
    $sql_update_teacher_list = " update course set TeacherList = '{$teacherList}',CourseState = 1,CourseError = 1,EndTime='{$date_str}' where Import_ID = {$begin_course_cd} ;";
          
    return $sql_update_teacher_list;
}
//for MSSQL
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
//for mysql
function genImportMySQL(& $nknu_table, & $the_course ,$type='LOG_UPDATE')
{	
	$flag_begin = true;
    $insert_sql = '';
    $info = '';
    $course_name = getImportMySQLvalue('CourseName', $nknu_table['CourseName'], $the_course);
    if($type=='LOG_ADD'){
        $info .= "[課程名稱]:".$course_name."<br/>";
        $info .= "[研習時數]:".getImportMySQLvalue('CourseHour', $nknu_table['CourseHour'], $the_course)."<br/>";
        $info .= "[課程期間]:".getImportMySQLvalue('StartTime', $nknu_table['StartTime'], $the_course).'~'.getImportMySQLvalue('EndTime', $nknu_table['EndTime'], $the_course)."<br/>";
        $info .= "[聯絡人姓名]:".getImportMySQLvalue('Contact_1_name', $nknu_table['Contact_1_name'], $the_course)."<br/>";
        $info .= "[聯絡人電話]:".getImportMySQLvalue('Contact_1_tel', $nknu_table['Contact_1_tel'], $the_course)."<br/>";
        $info .= "[聯絡人email]:".getImportMySQLvalue('Contact_1_mail', $nknu_table['Contact_1_mail'], $the_course)."<br/>";
        $info .= "[研習時數名單]:".getImportMySQLvalue('TeacherList', $nknu_table['TeacherList'], $the_course)."<br/>";
    }
    else if($type == 'LOG_UPDATE')
    {
        $info.="更新教師研習時數名單"."<br/>";
        $info .= "[研習時數名單]:".str_replace(',','<br/>',getImportMySQLvalue('TeacherList', $nknu_table['TeacherList'], $the_course))."<br/>" ;
    }
    //$info = mysql_real_escape_string($info);
    // table name 要改;
    
    $insert_sql = ' INSERT INTO `nknu_transfer_log`(`log_id`,`begin_course_cd`,`course_name`,`log_type`,`log_info`,`log_time`)VALUES(\'\',\''.$the_course['begin_course_cd'].'\',\''.$course_name.'\',\''.$type.'\',\''.$info.'\',NOW()); ';
	return $insert_sql ;
}

//注意有順序的for mssql
function getImportSQLvalue($field_name, $field_info, & $the_course) 
{
	// special case 
	if($field_name == 'AllowNo' && $the_course[ $field_info[1] ] == '')
		return "'無文號'";
	
	//TODO: 時間可能需特別要處理成 2009/9/14  不用補0  ，好像不用XDD
	if($field_name == 'StartTime' ||$field_name =='ApplyStartTime' || $field_name =='ApplyEndTime') {
		return "'".str_replace('-','/',trim($the_course[ $field_info[1] ], ' 00:00:00'))."'" ;
    }

    if($field_name == 'EndTime')
    {
	$date_str = date("Y/m/d 00:00:00");
        return "'{$date_str}'";
    }

    if($field_name == 'Member') { //course_stage_decode include from library/common.php
        $the_course[$field_info[1]] = implode(',', course_stage_decode_str($the_course[ $field_info[1] ]) );
		return "'".$the_course[$field_info[1]]."'";
    }
	
	if($field_name == 'TeacherList' ) {
		return "'".getPassedStudents($the_course['begin_course_cd'], $the_course['certify'])."'";
	}

	//general case 
	if($field_info[0] == 'NUMBER') { //數字 不用加 quotation mark 
		return $field_info[2]==1?$the_course[ $field_info[1] ]:$field_info[1];
	}
	if($field_info[0] == 'STRING') { // index for begin_course value ;
		$return_value = $field_info[2]==1?("N'".$the_course[ $field_info[1] ]."'"):("N'".$field_info[1]."'");
		//$return_value = iconv('UTF-8','CP950', $return_value);
		return $return_value ;
		//return "'".$the_course[ $field_info[1] ]."'" ;
	}
	if($field_info[0] == -1 ){ // SQL default value 
		return $field_info[1] ;
	}
}
//注意有順序的for mysql
function getImportMySQLvalue($field_name, $field_info, & $the_course) 
{
	// special case 
	if($field_name == 'AllowNo' && $the_course[ $field_info[1] ] == '')
		return "無文號";
	
	//TODO: 時間可能需特別要處理成 2009/9/14  不用補0  ，好像不用XDD
	if($field_name == 'StartTime' || $field_name =='ApplyStartTime' || $field_name =='ApplyEndTime') {
		return str_replace('-','/',trim($the_course[ $field_info[1] ], ' 00:00:00')) ;
    }
    if($field_name == 'EndTime')
    {
        $date_str =date('Y/m/d');
	return "{$date_str}";
    }
    if($field_name == 'Member') { //course_stage_decode include from library/common.php
        $the_course[$field_info[1]] = implode(',', course_stage_decode_str($the_course[ $field_info[1] ]) );
		return $the_course[$field_info[1]];
    }
	
	if($field_name == 'TeacherList' ) {
		return getPassedStudentsLog($the_course['begin_course_cd'], $the_course['certify']);
	}

	//general case 
	if($field_info[0] == 'NUMBER') { //數字 不用加 quotation mark 
		return $field_info[2]==1?$the_course[ $field_info[1] ]:$field_info[1];
	}
	if($field_info[0] == 'STRING') { // index for begin_course value ;
		$return_value = $field_info[2]==1?($the_course[ $field_info[1] ]):($field_info[1]);
		return $return_value ;
		//return "'".$the_course[ $field_info[1] ]."'" ;
	}
	if($field_info[0] == -1 ){ // SQL default value 
		return $field_info[1] ;
	}
}

//產生通過的學生清單
// 
// take_hour - 認證時數
function getPassedStudents($begin_course_cd, $take_hour )
{
	global $commit_course_stus ; 


	$getPassedStus_SQL = 'SELECT PB.personal_id, PB.idorpas, PB.identify_id, PB.passport FROM personal_basic PB, take_course TC'
	." WHERE PB.personal_id=TC.personal_id AND (PB.dist_cd =1 OR PB.dist_cd =2)AND pass=1 AND begin_course_cd={$begin_course_cd} ";
		
	$passedStus = db_getAll($getPassedStus_SQL) ;
	
	if( empty($passedStus) )
		return '';
	else {
		$return_str = '';
		$flag_first = true; 
		foreach($passedStus as $row) {
		    // 將有認證過得的學生記錄下來，等送完高師大確認後，更新 send2nknu_time 為處理送高師大的時間
			$commit_course_stius[ $begin_course_cd ][] = $row['personal_id'] ;
            $identify = (($row['idorpas']==0)? $row['identify_id']:$row['passport']);
            if( empty($identify) )
                continue;
            $identify = strtoupper($identify);
            if($flag_first) {
				$return_str .= 	$identify.'-'.$take_hour ; 
				$flag_first = false ;	
			}else {// append 要加 , 
				$return_str .= 	','.$identify.'-'.$take_hour ;  
			}
		}
		return $return_str ;
	}
}

function getPassedStudentsLog($begin_course_cd, $take_hour )
{
	global $commit_course_stus ; 


	$getPassedStus_SQL = 'SELECT PB.personal_id,PB.personal_name, PB.idorpas, PB.identify_id, PB.passport FROM personal_basic PB, take_course TC'
	." WHERE PB.personal_id=TC.personal_id AND (PB.dist_cd =1 OR PB.dist_cd =2)AND pass=1 AND begin_course_cd={$begin_course_cd} ";
		
	$passedStus = db_getAll($getPassedStus_SQL) ;
	

	if( empty($passedStus) )
		return '';
	else {
		$return_str = '';
		$flag_first = true; 
		foreach($passedStus as $row) {
		    // 將有認證過得的學生記錄下來，等送完高師大確認後，更新 send2nknu_time 為處理送高師大的時間
            $identify = ($row['idorpas']==0)? $row['identify_id']:$row['passport'];
            
            if(empty($identify))
                continue;

            if($flag_first) {
				$return_str .= '('.$row['personal_id'].')'.	$identify.'-'.$take_hour ; 
				$flag_first = false ;	
			}else {// append 要加 , 
				$return_str .= 	',('.$row['personal_id'].')'.$identify.'-'.$take_hour ;  
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
function checkCourseExist($begin_course_cd)
{
        if($begin_course_cd == null)
            return false;
         $sql_check_course_exsist ="select count(Import_ID) from course where Import_ID = {$begin_course_cd}";
         $ms_res = mssql_query($sql_check_course_exsist); 
         $data = mssql_fetch_array($ms_res);
         return (isset($data) && $data[0] > 0);       
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

