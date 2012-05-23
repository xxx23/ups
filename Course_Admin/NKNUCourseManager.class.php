<?php
require_once('../config.php');
require_Once($HOME_PATH.'Course_Admin/MSSQLWrapper.class.php');
require_once($HOME_PATH.'Course_Admin/NKNUSyncLogger.class.php');

class NKNUCourseManager
{
    private $_DB;
    private $updateList = array();
    private $_nknu_table = array(  
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
    //'TimeSet'			=> array('STRING', '', 0),					//課程時間詳
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
    
    private $_logger = null;
    
    public function __construct($nknu_db_config)
    { 
        $this->_DB = new MSSQLWrapper($nknu_db_config['host'],
                                      $nknu_db_config['user'],
                                      $nknu_db_config['password'],
                                      $nknu_db_config['database']);
        $this->_logger = new NKNUSyncLogger();
    }
    public function syncToNKNU_old()
    {
        $course_list = $this->_getAllCourse();
        if(empty($course_list))
            return False;
        $import_sql = '';

        foreach($course_list as $course)
        {
            $passStus = $this->_getPassedStudentList($course['begin_course_cd']," AND send2nknu_time < '2010-08-01'");
            if(empty($passStus))
                continue;
            $course['students'] = $passStus;
            $course_id = $course['begin_course_cd'];
            if(!$this->checkCourseExist($course_id)){
                $import_sql .= $this->_genImportSQL($course_id,$course);
                $this->_logger->addCourse($course['begin_course_cd'],"<舊傳送方式>新增課程");
                $this->_logger->addCourse($course['begin_course_cd'],"[課程名稱]:".$course['begin_course_name']);
                $this->_logger->addCourse($course['begin_course_cd'],"[研習時數]:".$course['certify']);
                $this->_logger->addCourse($course['begin_course_cd'],"[課程期間]:".$course['d_course_begin'].'~'.date('Y-m-t'));
                $this->_logger->addCourse($course['begin_course_cd'],"[聯絡人姓名]:".$course['director_name']);
                $this->_logger->addCourse($course['begin_course_cd'],"[聯絡人電話]:".$course['director_tel']);
                $this->_logger->addCourse($course['begin_course_cd'],"[聯絡人email]:".$course['director_email']);
                $this->_logger->addCourse($course['begin_course_cd'],"[研習時數名單]:".$this->_getLogTeacherList($course['students'],$course['certify']));
            }
            else{
                $import_sql_tmp = $this->_genUpdateSQL_old($course_id,$course);
                $import_sql .= $import_sql_tmp;
                $this->_logger->updateCourse($course['begin_course_cd'],'<舊傳送方式>更新教師研習時數名單');
                $this->_logger->updateCourse($course['begin_course_cd'],'[新增的研習時數名單]:');
                $this->_logger->updateCourse($course['begin_course_cd'],$this->_getLogTeacherList($course['students'],$course['certify'])); 
            }
            //$this->_updateCommitStatus($course_id);
                 
        }
        if($import_sql == null){
            return False;
        }
        
        $this->_DB->query($import_sql);
        $this->_logger->save();  
        return True;
    }    
    public function syncToNKNU()
    {
        
        $course_list = $this->_getAllCourse();
        //well_print($course_list);
        if(empty($course_list)){
            return False;
        }
        $import_sql = '';
        foreach($course_list as $course)
        {
           
            $allPassCnt = $this->_getAllPassCnt($course['begin_course_cd']);
            $passStus = $this->_getPassedStudentList($course['begin_course_cd']);
            $studentGroups = array();
            $cnt = 0;
            foreach($passStus as $student)
            {
                $group_id = (int)( ($allPassCnt+$cnt)/255 );
                $studentGroups[$group_id]['id'] =$group_id;
                $studentGroups[$group_id]['students'][] = $student;
                $cnt++;
            }
            
            foreach($studentGroups as $studentGroup)
            {
                
                $course_id = $this->_getCourseID($course['begin_course_cd'],$studentGroup['id']);
                
                $course['students'] = $studentGroup['students'];
                if(!$this->checkCourseExist($course_id)){
                    $import_sql .= $this->_genImportSQL($course_id,$course);
                    $this->_logger->addCourse($course['begin_course_cd'],"新增課程");
                    $this->_logger->addCourse($course['begin_course_cd'],"[課程名稱]:".$course['begin_course_name']);
                    $this->_logger->addCourse($course['begin_course_cd'],"[研習時數]:".$course['certify']);
                    $this->_logger->addCourse($course['begin_course_cd'],"[課程期間]:".$course['d_course_begin'].'~'.date('Y-m-t'));
                    $this->_logger->addCourse($course['begin_course_cd'],"[聯絡人姓名]:".$course['director_name']);
                    $this->_logger->addCourse($course['begin_course_cd'],"[聯絡人電話]:".$course['director_tel']);
                    $this->_logger->addCourse($course['begin_course_cd'],"[聯絡人email]:".$course['director_email']);
                    $this->_logger->addCourse($course['begin_course_cd'],"[研習時數名單]:".$this->_getLogTeacherList($course['students'],$course['certify']));
                }
                else{
                    $import_sql_tmp = $this->_genUpdateSQL($course_id,$course);
                    $import_sql .= $import_sql_tmp;
                    $this->_logger->updateCourse($course['begin_course_cd'],'更新教師研習時數名單');
                    $this->_logger->updateCourse($course['begin_course_cd'],'[新增的研習時數名單]:');
                    $this->_logger->updateCourse($course['begin_course_cd'],$this->_getLogTeacherList($course['students'],$course['certify']));
                  
                }
                $this->_updateCommitStatus($course_id);
                 
            }
        }
        if($import_sql == null){
            return False;
         }
        
        $this->_DB->query($import_sql);
        $this->_logger->save();  
        return True;
       
    }
    protected function _getLogTeacherList($students,$certify)
    {
        if(empty($students))
            return '';
        $teacherList = array();
        
        foreach($students as $student)
        {
            $identify = $student['idorpas'] == 0 ? $student['identify_id']:$student['passport'];
            $teacherList[] = $identify."-".$certify;
        }   
        return implode(',',$teacherList);
    }
    protected function _updateCommitStatus($course_id)
    {
        foreach($this->updateList as $begin_course_cd => $course) {
            foreach($course as $pid ) {
                $update_send2nknu_time = " update take_course 
                                           set send2nknu_time=NOW() ,
                                               send2nknu_course = '$course_id'
                                           where begin_course_cd=$begin_course_cd 
                                           and personal_id=$pid 
                                           and send2nknu_time = '0000-00-00' ";
                db_query($update_send2nknu_time);
            }
        }
        $this->updateList = array();
    }
    protected function _getAllPassCnt($begin_course_cd)
    {
        $start = date('Y-m-1');
        $end = date('Y-m-t');
        $sql = "SELECT COUNT(*)
                FROM personal_basic PB,take_course TC
                WHERE TC.begin_course_cd = {$begin_course_cd}
                AND PB.personal_id=TC.personal_id
                AND (PB.dist_cd =1 OR PB.dist_cd =2)
                AND TC.pass =1
                AND TC.send2nknu_time BETWEEN '$start' AND '$end'";
        return db_getOne($sql);
    }
    protected function _genUpdateSQL_old($course_id,& $the_course)
    {
        $begin_course_cd = $the_course['begin_course_cd'];
        $certify = $the_course['certify'];
        
        $sql_count_pass_stu  = "SELECT COUNT(*)
                                FROM personal_basic PB,take_course TC
                                WHERE TC.begin_course_cd = {$begin_course_cd}
                                AND PB.personal_id=TC.personal_id
                                AND (PB.dist_cd =1 OR PB.dist_cd =2)
                                AND TC.pass =1
                                AND TC.send2nknu_time < '2010-08-01';";
        $count_pass = db_getOne($sql_count_pass_stu);
        if($count_pass == 0)
            return '';
        $teacherList = $this->_getTeacherList($the_course['begin_course_cd'],$the_course['students'],$certify);
        $import_course_id = $course_id;
        $sql_update_teacher_list = " update course set TeacherList = '{$teacherList}',CourseState = 1,CourseError = 1 where Import_ID = '{$import_course_id}' ;";
              
        return $sql_update_teacher_list;

    }
    protected function _genUpdateSQL($course_id,& $the_course)
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
        $sql_count_pass_stu  = "SELECT PB.personal_id, PB.idorpas, PB.identify_id, PB.passport
                                FROM personal_basic PB,take_course TC
                                WHERE TC.begin_course_cd = {$begin_course_cd}
                                AND PB.personal_id=TC.personal_id
                                AND (PB.dist_cd =1 OR PB.dist_cd =2)
                                AND TC.pass =1
                                AND TC.send2nknu_course = '$course_id'";
        $old_stus = db_getAll($sql_count_pass_stu);
        $the_course['students'] =array_merge($old_stus, $the_course['students']);
        
        $teacherList = $this->_getTeacherList($the_course['begin_course_cd'],$the_course['students'],$certify);
        $import_course_id = $course_id;
        $sql_update_teacher_list = " update course set TeacherList = '{$teacherList}',CourseState = 1,CourseError = 1 where Import_ID = '{$import_course_id}' ;";
              
        return $sql_update_teacher_list;
    }
    
    protected function _getImportSQLvalue($field_name, $field_info, & $the_course) 
    {
        if($field_name == 'Import_ID')
        {
            return "N'".$this->_getCourseID($the_course[$field_info[1]])."'";
        }
        // special case 
        if($field_name == 'AllowNo' && $the_course[ $field_info[1] ] == '')
            return "'無文號'";
        
        //TODO: 時間可能需特別要處理成 2009/9/14  不用補0  ，好像不用XDD
        if($field_name == 'StartTime' ||$field_name =='ApplyStartTime' || $field_name =='ApplyEndTime') {
            return "'".date('Y/m/1')."'";
           // return "'".str_replace('-','/',trim($the_course[ $field_info[1] ], ' 00:00:00'))."'" ;
        }

        if($field_name == 'EndTime')
        {
            return "'".date('Y/m/t')."'";
        }

        if($field_name == 'Member') { //course_stage_decode include from library/common.php
            $the_course[$field_info[1]] = implode(',', course_stage_decode_str($the_course[ $field_info[1] ]) );
            return "'".$the_course[$field_info[1]]."'";
        }
        
        if($field_name == 'TeacherList' ) {
            return "'".$this->_getTeacherList($the_course['begin_course_cd'],$the_course['students'], $the_course['certify'])."'";
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
    
    protected function _getTeacherList($begin_course_cd,$students,$certify)
    {
        if(empty($students))
            return '';
        $teacherList = array();
        
        foreach($students as $student)
        {
            $identify = $student['idorpas'] == 0 ? $student['identify_id']:$student['passport'];
            $identify = strtoupper($identify);
            $teacherList[] = $identify."-".$certify;
            $this->updateList[$begin_course_cd][] = $student['personal_id'];
        }
   
        
        return implode(',',$teacherList);
    }
    
    protected function _validate_identify($id)
    {
        $flag = false;
         $id = strtoupper($id); //將英文字母全部轉成大寫
         $id_len = strlen($id); //取得字元長度

      
         if($id_len <= 0) {
            return false;   
         }
         if ($id_len > 10) {
            return false;
         }
         if ($id_len < 10 && $id_len > 0) {
            return false;  
         }
      
         //檢查 第一個字母是否為英文字
         $id_sub1 = substr($id,0,1); // 從第一個字元開始 取得字串
         $id_sub1 = ord($id_sub1); // 回傳字串的acsii 碼
         if ($id_sub1 > 90 || $id_sub1 < 65) {
            return false; 
         }

         //檢查 身份證字號的 第二個字元 男生或女生
         $id_sub2 = substr($id,1,1);
      
         if($id_sub2 !="1" && $id_sub2 != "2") {
            return false;
         }

         for ($i=1;$i<10;$i++) {
            $id_sub3 = substr($id,$i,1);
            $id_sub3 = ord($id_sub3);
            if ($id_sub3 > 57 || $id_sub3 < 48) {
               $n=$i+1;
               return false;
            }
         }
      
         $num=array("A" => "10","B" => "11","C" => "12","D" => "13","E" => "14",
         "F" => "15","G" => "16","H" => "17","J" => "18","K" => "19","L" => "20",
         "M" => "21","N" => "22","P" => "23","Q" => "24","R" => "25","S" => "26",
         "T" => "27","U" => "28","V" => "29","X" => "30","Y" => "31","W" => "32",
         "Z" => "33","I" => "34","O" => "35");

         $d1 = substr($id,0,1); // 從第一個字元開始 取得字串
         $n1=substr($num[$d1],0,1)+(substr($num[$d1],1,1)*9);
         $n2=0; //初使化
         for ($j=1;$j<9;$j++) {
            $d4=substr($id,$j,1);
            $n2=$n2+$d4*(9-$j);
         }
         $n3=$n1+$n2+substr($id,9,1);
         if(($n3 % 10)!= 0) {
            return false;  
         }
         return true;  
    }
    protected function _genImportSQL($course_id, & $the_course )
    {	

        $flag_begin = true;
        $insert_sql = '';
        $field_part = '';
        $value_part = '';
        foreach($this->_nknu_table as $field_name => $row) {
            if($flag_begin){
                $field_part .= $field_name ;
                if($field_name=="Import_ID")
                  $value_part .= "N'$course_id'";
                else
                    $value_part .= $this->_getImportSQLvalue($field_name, $row, $the_course);
                $flag_begin = false ;
            }else {
                $field_part .= ' ,'.$field_name ;
                if($field_name=="Import_ID")
                  $value_part .= "N'$course_id'";
                else
                    $value_part .= ' ,'.$this->_getImportSQLvalue($field_name, $row, $the_course);
            
            }
        }
        // table name 要改;
        $insert_sql = 'insert into course(' . $field_part . ') VALUES (' . $value_part .');';
        
        return $insert_sql ;
    }
    
    protected function _getCourseID($begin_course_cd,$course_seq)
    {
        $course_year_month = date('Ym');
       
        return $course_year_month.'-'.$begin_course_cd.'-'.$course_seq;
    }
    
    protected function _getPassedStudentList($begin_course_cd,$condition='')
    {
        $getPassedStus_SQL = "SELECT PB.personal_id, PB.personal_name, PB.idorpas, PB.identify_id, PB.passport 
                              FROM personal_basic PB, take_course TC
                              WHERE PB.personal_id=TC.personal_id 
                              AND (PB.dist_cd =1 OR PB.dist_cd =2)
                              AND pass=1 
                              AND begin_course_cd={$begin_course_cd} ";
        if($condition == '')
            $getPassedStus_SQL .=" AND send2nknu_time = '0000-00-00'";
        else
            $getPassedStus_SQL .= $condition;

        $students = db_getAll($getPassedStus_SQL) ;
        
        $studentList = array();
        foreach($students as $student)
        {
            $identify = $student['idorpas'] == 0 ? $student['identify_id']:$student['passport'];
            $identify = strtoupper($identify);
            if($this->_validate_identify($identify)){
                $studentList[] = $student;
            }
            else
            {
                $this->_logger->error($begin_course_cd,"{$student['personal_name']}({$student['personal_id']})錯誤的身分證:$identify");
            }
            /*else log error*/
        }
        return $studentList;
    }
     
    public function checkCourseExist($import_course_id)
    {
        if($import_course_id == null)
            return false;
        
        $sql_check_course_exsist ="select count(Import_ID) from course where Import_ID = '{$import_course_id}'";
        $exsits = $this->_DB->getOne($sql_check_course_exsist); 
        return (!empty($exsits) && $exsits > 0);       
    } 
    
    protected function _getAllCourse( $begin_course_cd=0 ) 
    {
        
        $flag_first = true; 
        $sql = "select ";
        
        if($begin_course_cd !=0 )
            $begin_course_cd_sql = ' AND begin_course_cd='. $begin_course_cd;
        else 
            $begin_course_cd_sql = '';
            
            
        foreach($this->_nknu_table as $key => $value) {

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
        
        
        
        $data = db_getAll($sql) ;
        return $data;
    }

}
   
//END OF NKNUCourseManager
