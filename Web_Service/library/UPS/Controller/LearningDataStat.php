<?php

require_once 'UPS/Controller/ControllerBase.php';
/**
 * Description of LearningDataStat
 *
 * @author wewe0901
 */
class UPS_Controller_LearningDataStat extends UPS_Controller_ControllerBase{
    protected $_exportData =array();
    public function init()
    {
         require_once 'UPS/Auth/ApplyCourse.php';
         require_once 'UPS/Model/ApplyCourseUser.php';
         require_once 'UPS/Model/BeginCourse.php';
         require_once 'UPS/Model/UserProfile.php';
         require_once 'UPS/Model/School.php';
    }
    
    public function indexAction()
    {
        
    }
    
    public function cityViewAction()
    {
         global $WEBROOT;
        $userModel = $this->getModel('ApplyCourseUser');
        $userProfileModel = $this->getModel('UserProfile');
        $beginCourseModel = $this->getModel('BeginCourse');
        $schoolModel = $this->getModel('School');
        
        $user = UPS_Auth_ApplyCourse::getInstance()->getIdentity();
        $userInfo = $userModel->getUserInfo($user->no);
        if(empty($userInfo['city_cd']))
            $this->_redirect ($WEBROOT.'Apply_Course/fill_up_account.php');
        
        $title_personal = $this->getParam('title_personal', PARAM_INT, -1);
        $type_personal = $this->getParam('type_personal', PARAM_INT, -1);
        $class_kind = $this->getParam('class_kind', PARAM_INT, -1);
        $class_choose = $this->getParam('class_choose', PARAM_INT, -1);
        $date_begin = $this->getParam('date_begin', PARAM_TEXT,'');
        $date_end = $this->getParam('date_end', PARAM_TEXT, '');
        $school_cd = $this->getParam('school_cd', PARAM_INT, -1);
        $deliver_passhour = $this->getParam('deliver_passhour', PARAM_BOOL, 0);
        $show_pass = $this->getParam('show_pass', PARAM_BOOL, 0);
        $export = $this->getParam('export', PARAM_BOOL, 0);
        if($this->isPost())
        {  
            
           $result_temp = $this->getModel('ApplyCourseStatistics')
                                    ->getCityLearningData(array(
                                        'begin_course_cd'=> $class_choose,
                                         'course_property'=>$class_kind ,
                                         'deliver'=> $deliver_passhour,
                                         'title'=>$title_personal ,
                                        'dist_cd' =>$type_personal,
                                         'school_cd'=> $school_cd,
                                         'date_begin'=>$date_begin ,
                                         'date_end'=>$date_end ,
                                         'city_cd'=>$userInfo['city_cd'] ,
                                    ));
            $qBegin = strtotime($date_begin);
            $qEnd = strtotime($date_end);
            
            
            //做簡單的統計與過濾
            $results = array();
            $statistics=array();
             foreach($result_temp as $row)
             {
                 $pass_time = strtotime($row['pass_time']);
                 if(!empty($date_begin)&&!empty($date_end))
                     $pass =  ($row['pass']=='通過');//;&&$qBegin<=$pass_time && $pass_time <= $qEnd;
                 else
                     $pass =  ($row['pass']=='通過');
                 if($pass){
                     $statistics['course'][$row['begin_course_name']]['pass']++;
                     $statistics['course'][$row['begin_course_name']]['certify']+= $row['certify'];
                      $statistics['summary']['pass']++;
                      $statistics['summary']['certify'] += $row['certify'];
                 }
                 $statistics['course'][$row['begin_course_name']]['total']++;
                 $statistics['summary']['total']++;
  
                 if($show_pass==1 && !$pass)
                 {
                     continue;
                 }
                 $results[]=$row;
             }
             unset($result_temp);
             
             //報表的標頭
            $header = array( 
                'personal_name'=>'姓名',
                'teach_doc '=> '教師證號',
                //'city' => '所在縣市',
               // 'dist' => '身分別',
                //'title' => '職稱',
                'school' => '所屬學校',
                'begin_course_name' => '課程名稱',
                'course_property' => '課程性質',
                'pass' => '通過與否',
                'pass_time' => '通過時間',
                'certify'=>'認證時數'
                );
            //報表的課程統計
            $statisticsData = array(
                array('[總計]'),
                array('總通過人數',$statistics['summary']['pass']),
                array('總修課人數',$statistics['summary']['total']),
                array('總通過時數人數',$statistics['summary']['certify']),
            );
            $statisticsData[] = array('[課程分別統計]');
            $statisticsData[] =$statisticsHead = array('課程名稱','通過人數','修課人數','通過時數');
            foreach($statistics['course'] as $begin_course_name => $data)
            {
                $statisticsData[] = array( 0=>$begin_course_name, 1=>$data['pass'],2=> $data['total'],3=>$data['certify']);
            }
      
            if($export ==1){
                $this->_exportData['statistics'] = $statisticsData;
                $this->_exportData['header'] = $header;
                $this->_exportData['data'] =$results;
                $this->_forward ('exportExcel');
            }
            $this->getView()->assign('statisticsHead' ,$statisticsHead);
            $this->getView()->assign('statistics' ,$statistics['course']);
            $this->getView()->assign('total_stu_pass' ,$statistics['summary']['pass']);
            $this->getView()->assign('total_stu', $statistics['summary']['total']);
            $this->getView()->assign('total_stu_pass_certify_hour', $statistics['summary']['certify']);
            $this->getView()->assign('header' , $header);
            $this->getView()->assign('result' , $results);
        }
        
        $this->getView()->assign('school_cd',$school_cd);
        $this->getView()->assign('city_cd',$userInfo['city_cd']);
        $this->getView()->assign('school_list',$schoolModel->getSchoolByUserType($userInfo['city_cd'],$type_personal));
        $this->getView()->assign('show_pass',$show_pass );
        $this->getView()->assign('deliver_passhour',$deliver_passhour );
        $this->getView()->assign('date_begin',$date_begin );
        $this->getView()->assign('date_end',$date_end );
        $this->getView()->assign('title_personal',$title_personal);
        $this->getView()->assign('type_personal', $type_personal);
        $this->getView()->assign('class_kind',$class_kind);
        $this->getView()->assign('class_choose',$class_choose);
        $this->getView()->assign('title_personal_list', $userProfileModel->getTeachTitles());
        $this->getView()->assign('type_personal_list', $userProfileModel->getCityUserDists());
        $this->getView()->assign('course_properties', $beginCourseModel->getCourseProperty());
        $this->getView()->assign('class_list', $beginCourseModel->getCourses($class_kind));
        $this->getView()->display('/apply_course/stat_request_city.tpl');
    }
   
    public function docViewAction()
    {
        global $WEBROOT;
        $userModel = $this->getModel('ApplyCourseUser');
        $userProfileModel = $this->getModel('UserProfile');
        $docModel = $this->getModel('Doc');
        $schoolModel = $this->getModel('School');
        $beginCourseModel = $this->getModel('BeginCourse');
        $statModel = $this->getModel('ApplyCourseStatistics');
        $user = UPS_Auth_ApplyCourse::getInstance()->getIdentity();
        $userInfo = $userModel->getUserInfo($user->no);
        $cityList = $docModel->getDocInstructCity($userInfo['account']);
        //var_dump($userInfo);
        //如果查不出輔導團管轄的縣市就代表錯誤的帳號
        if(empty($cityList))
            die('Error Doc Instructor account');
        $doc_cd = $this->getParam('doc_cd', PARAM_INT, -1);
        $city_cd = $this->getParam('city_cd', PARAM_INT, -1);
        $class_kind = $this->getParam('class_kind', PARAM_INT, -1);
        $class_choose = $this->getParam('class_choose', PARAM_INT, -1);
        $date_begin = $this->getParam('date_begin', PARAM_TEXT,'');
        $date_end = $this->getParam('date_end', PARAM_TEXT, '');
        $export = $this->getParam('export', PARAM_TEXT, 0);

        if($this->isPost())
        {
            $statistics = $statModel->getDocLearningData(array(
                'begin_course_cd'=>$class_choose,
                'course_property'=>$class_kind,
                'doc_cd'=>$doc_cd,
                'city_cd'=>$city_cd,
                'date_begin'=>$date_begin,
                'date_end'=>$date_end,
                'cityList'=>$cityList,
            ));
           
         
            $stat_head = array( '新住民(男)','新住民(女)','婦女','銀髮族(男)','銀髮族(女)','勞工(男)','勞工(女)');
            $stat_data = array(
                (int)$statistics['summary']['new_inhabitants']['male'],
               (int) $statistics['summary']['new_inhabitants']['female'],
                (int)$statistics['summary']['woman'],
                (int)$statistics['summary']['elder']['male'],
                (int)$statistics['summary']['elder']['female'],
               (int)$statistics['summary']['labor']['male'],
                (int)$statistics['summary']['labor']['female']
                );
            $header = array('縣市','所屬DOC','課程屬性','課程名稱','新住民(男)','新住民(女)','婦女','銀髮族(男)','銀髮族(女)','勞工(男)','勞工(女)');
            $results =array();
            foreach($statistics['course'] as $city => $city_data)
            {
                foreach($city_data as $doc => $doc_data )
                {
                    foreach($doc_data as $course_cd =>$course_data)
                    {
                        $results[] =array(
                               $schoolModel->getSchoolCityName($city),
                               $docModel->getDocName($doc),
                               $beginCourseModel->getCoursePropertyName($course_cd),
                               $beginCourseModel->getCourseName($course_cd),
                               (int)$course_data['new_inhabitants']['male'],
                               (int)$course_data['new_inhabitants']['female'],
                               (int)$course_data['women'],
                               (int)$course_data['elder']['male'],
                               (int)$course_data['elder']['female'],
                               (int)$course_data['labor']['male'],
                               (int)$course_data['labor']['female'],
                        );
                    }
                }
            }
           
              if($export ==1){
                $this->_exportData['statistics'] =array(array('[總計]'),$stat_head,$stat_data,array('[DOC課程資料]')) ;
                $this->_exportData['header'] = $header;
                $this->_exportData['data'] =$results;
                $this->_forward ('exportExcel');
            }
             $this->getView()->assign('statisticsHead' ,$stat_head);
            $this->getView()->assign('statistics' ,$stat_data);
            $this->getView()->assign('header',$header);
            $this->getView()->assign('results',$results);
        }
      
        $this->getView()->assign('class_kind',$class_kind);
        $this->getView()->assign('class_choose',$class_choose);
        $this->getView()->assign('date_begin',$date_begin );
        $this->getView()->assign('date_end',$date_end );
        $this->getView()->assign('city_cd',$city_cd);
        $this->getView()->assign('doc_cd',$doc_cd);
        $this->getView()->assign('cityList',$cityList);
        $this->getView()->assign('docList', $docModel->getDocByCity($city_cd));
        $this->getView()->assign('course_properties', $beginCourseModel->getCourseProperty());
        $this->getView()->assign('class_list', $beginCourseModel->getCourses($class_kind));
        $this->getView()->display('/apply_course/stat_request_doc.tpl');
    }
    
    public function universityViewAction()
    {
         global $WEBROOT;
        $userModel = $this->getModel('ApplyCourseUser');
        $userProfileModel = $this->getModel('UserProfile');
        $beginCourseModel = $this->getModel('BeginCourse');
        $schoolModel = $this->getModel('School');
        
        $user = UPS_Auth_ApplyCourse::getInstance()->getIdentity();
        $userInfo = $userModel->getUserInfo($user->no);
        if(empty($userInfo['city_cd'])||empty($userInfo['school_cd']))
            $this->_redirect ($WEBROOT.'Apply_Course/fill_up_account.php');
        
        $type_personal = $this->getParam('type_personal', PARAM_INT, -1);
        $class_kind = $this->getParam('class_kind', PARAM_INT, -1);
        $class_choose = $this->getParam('class_choose', PARAM_INT, -1);
        $date_begin = $this->getParam('date_begin', PARAM_TEXT,'');
        $date_end = $this->getParam('date_end', PARAM_TEXT, '');
        $school_cd = $userInfo['school_cd'];
        $deliver_passhour = $this->getParam('deliver_passhour', PARAM_BOOL, 0);
        $show_pass = $this->getParam('show_pass', PARAM_BOOL, 0);
        $export = $this->getParam('export', PARAM_BOOL, 0);
        if($this->isPost())
        {  
            
           $result_temp = $this->getModel('ApplyCourseStatistics')
                                    ->getUniversityLearningData(array(
                                        'begin_course_cd'=> $class_choose,
                                         'course_property'=>$class_kind ,
                                         'deliver'=> $deliver_passhour,
                                        'dist_cd' =>$type_personal,
                                         'school_cd'=> $school_cd,
                                         'date_begin'=>$date_begin ,
                                         'date_end'=>$date_end ,
                                         'city_cd'=>$userInfo['city_cd'] ,
                                    ));
            $qBegin = strtotime($date_begin);
            $qEnd = strtotime($date_end);
            
            
            //做簡單的統計與過濾
            $results = array();
            $statistics=array();
             foreach($result_temp as $row)
             {
                 $pass_time = strtotime($row['pass_time']);
                 if(!empty($date_begin)&&!empty($date_end))
                     $pass =  ($row['pass']=='通過');//;&&$qBegin<=$pass_time && $pass_time <= $qEnd;
                 else
                     $pass =  ($row['pass']=='通過');
                 if($pass){
                     $statistics['course'][$row['begin_course_name']]['pass']++;
                     $statistics['course'][$row['begin_course_name']]['certify']+= $row['certify'];
                      $statistics['summary']['pass']++;
                      $statistics['summary']['certify'] += $row['certify'];
                 }
                 $statistics['course'][$row['begin_course_name']]['total']++;
                 $statistics['summary']['total']++;
  
                 if($show_pass==1 && !$pass)
                 {
                     continue;
                 }
                 $results[]=$row;
             }
             unset($result_temp);
             
             //報表的標頭
            $header = array( 
                'personal_name'=>'姓名',
               // 'teach_doc '=> '教師證號',
                //'city' => '所在縣市',
               // 'dist' => '身分別',
                //'title' => '職稱',
                'school' => '所屬學校',
                'begin_course_name' => '課程名稱',
                'course_property' => '課程性質',
                'pass' => '通過與否',
                'pass_time' => '通過時間',
                //'certify'=>'認證時數'
                );
            //報表的課程統計
            $statisticsData = array(
                array('[總計]'),
                array('總通過人數',$statistics['summary']['pass']),
                array('總修課人數',$statistics['summary']['total']),
            );
            $statisticsData[] = array('[課程分別統計]');
            $statisticsData[] =$statisticsHead = array('課程名稱','通過人數','修課人數');
            foreach($statistics['course'] as $begin_course_name => $data)
            {
                $statisticsData[] = array( 0=>$begin_course_name, 1=>(int)$data['pass'],2=> (int)$data['total']);
            }
      
            if($export ==1){
                $this->_exportData['statistics'] = $statisticsData;
                $this->_exportData['header'] = $header;
                $this->_exportData['data'] =$results;
                $this->_forward ('exportExcel');
            }
            $this->getView()->assign('statisticsHead' ,$statisticsHead);
            $this->getView()->assign('statistics' ,$statistics['course']);
            $this->getView()->assign('total_stu_pass' ,$statistics['summary']['pass']);
            $this->getView()->assign('total_stu', $statistics['summary']['total']);
            $this->getView()->assign('total_stu_pass_certify_hour', $statistics['summary']['certify']);
            $this->getView()->assign('header' , $header);
            $this->getView()->assign('result' , $results);
        }
        
        $this->getView()->assign('city_cd',$userInfo['city_cd']);
        $this->getView()->assign('show_pass',$show_pass );
        $this->getView()->assign('deliver_passhour',$deliver_passhour );
        $this->getView()->assign('date_begin',$date_begin );
        $this->getView()->assign('date_end',$date_end );
        $this->getView()->assign('type_personal', $type_personal);
        $this->getView()->assign('class_kind',$class_kind);
        $this->getView()->assign('class_choose',$class_choose);
        $this->getView()->assign('type_personal_list', $userProfileModel->getUniversityUserDists());
        $this->getView()->assign('course_properties', $beginCourseModel->getCourseProperty());
        $this->getView()->assign('class_list', $beginCourseModel->getCourses($class_kind));
        $this->getView()->display('/apply_course/stat_request_university.tpl');
    }
 
    public function schoolViewAction()
    {
         global $WEBROOT;
        $userModel = $this->getModel('ApplyCourseUser');
        $userProfileModel = $this->getModel('UserProfile');
        $beginCourseModel = $this->getModel('BeginCourse');
        $schoolModel = $this->getModel('School');
        
        $user = UPS_Auth_ApplyCourse::getInstance()->getIdentity();
        $userInfo = $userModel->getUserInfo($user->no);
        if(empty($userInfo['city_cd']))
            $this->_redirect ($WEBROOT.'Apply_Course/fill_up_account.php');
        
        $title_personal = $this->getParam('title_personal', PARAM_INT, -1);
        $type_personal = $this->getParam('type_personal', PARAM_INT, -1);
        $class_kind = $this->getParam('class_kind', PARAM_INT, -1);
        $class_choose = $this->getParam('class_choose', PARAM_INT, -1);
        $date_begin = $this->getParam('date_begin', PARAM_TEXT,'');
        $date_end = $this->getParam('date_end', PARAM_TEXT, '');
        $school_cd = $this->getParam('school_cd', PARAM_INT, -1);
        $deliver_passhour = $this->getParam('deliver_passhour', PARAM_BOOL, 0);
        $show_pass = $this->getParam('show_pass', PARAM_BOOL, 0);
        $export = $this->getParam('export', PARAM_BOOL, 0);
        
        //echo $userInfo['school_cd'];
        //echo $userInfo['city_cd'];
        if($this->isPost())
        {  
           /* 此function根據 cityViewAction 而來
            * 用以撈取單一學校的人員時數
            * 作法是 school_cd 及 city_cd 從 userInfo 中擷取
            * userInfo為register_applycourse裡該帳號的資料 
            */
           $result_temp = $this->getModel('ApplyCourseStatistics')
                                    ->getSchoolLearningData(array(
                                        'begin_course_cd'=> $class_choose,
                                         'course_property'=>$class_kind ,
                                         'deliver'=> $deliver_passhour,
                                         'title'=>$title_personal ,
                                         'dist_cd' =>$type_personal,
                                         'school_cd'=> $userInfo['school_cd'],
                                         'date_begin'=>$date_begin ,
                                         'date_end'=>$date_end ,
                                         'city_cd'=>$userInfo['city_cd'] ,
                                    ));
            $qBegin = strtotime($date_begin);
            $qEnd = strtotime($date_end);
            
            
            //做簡單的統計與過濾
            $results = array();
            $statistics=array();
             foreach($result_temp as $row)
             {
                 $pass_time = strtotime($row['pass_time']);
                 if(!empty($date_begin)&&!empty($date_end))
                     $pass =  ($row['pass']=='通過');//;&&$qBegin<=$pass_time && $pass_time <= $qEnd;
                 else
                     $pass =  ($row['pass']=='通過');
                 if($pass){
                     $statistics['course'][$row['begin_course_name']]['pass']++;
                     $statistics['course'][$row['begin_course_name']]['certify']+= $row['certify'];
                      $statistics['summary']['pass']++;
                      $statistics['summary']['certify'] += $row['certify'];
                 }
                 $statistics['course'][$row['begin_course_name']]['total']++;
                 $statistics['summary']['total']++;
  
                 if($show_pass==1 && !$pass)
                 {
                     continue;
                 }
                 $results[]=$row;
             }
             unset($result_temp);
             
             //報表的標頭
            $header = array( 
                'personal_name'=>'姓名',
                'teach_doc '=> '教師證號',
                //'city' => '所在縣市',
               // 'dist' => '身分別',
                //'title' => '職稱',
                'school' => '所屬學校',
                'begin_course_name' => '課程名稱',
                'course_property' => '課程性質',
                'pass' => '通過與否',
                'pass_time' => '通過時間',
                'certify'=>'認證時數'
                );
            //報表的課程統計
            $statisticsData = array(
                array('[總計]'),
                array('總通過人數',$statistics['summary']['pass']),
                array('總修課人數',$statistics['summary']['total']),
                array('總通過時數人數',$statistics['summary']['certify']),
            );
            $statisticsData[] = array('[課程分別統計]');
            $statisticsData[] =$statisticsHead = array('課程名稱','通過人數','修課人數','通過時數');
            foreach($statistics['course'] as $begin_course_name => $data)
            {
                $statisticsData[] = array( 0=>$begin_course_name, 1=>$data['pass'],2=> $data['total'],3=>$data['certify']);
            }
      
            if($export ==1){
                $this->_exportData['statistics'] = $statisticsData;
                $this->_exportData['header'] = $header;
                $this->_exportData['data'] =$results;
                $this->_forward ('exportExcel');
            }
            $this->getView()->assign('statisticsHead' ,$statisticsHead);
            $this->getView()->assign('statistics' ,$statistics['course']);
            $this->getView()->assign('total_stu_pass' ,$statistics['summary']['pass']);
            $this->getView()->assign('total_stu', $statistics['summary']['total']);
            $this->getView()->assign('total_stu_pass_certify_hour', $statistics['summary']['certify']);
            $this->getView()->assign('header' , $header);
            $this->getView()->assign('result' , $results);
        }
        
        $this->getView()->assign('school_cd',$school_cd);
        $this->getView()->assign('city_cd',$userInfo['city_cd']);
        $this->getView()->assign('school_list',$schoolModel->getSchoolByUserType($userInfo['city_cd'],$type_personal));
        $this->getView()->assign('show_pass',$show_pass );
        $this->getView()->assign('deliver_passhour',$deliver_passhour );
        $this->getView()->assign('date_begin',$date_begin );
        $this->getView()->assign('date_end',$date_end );
        $this->getView()->assign('title_personal',$title_personal);
        $this->getView()->assign('type_personal', $type_personal);
        $this->getView()->assign('class_kind',$class_kind);
        $this->getView()->assign('class_choose',$class_choose);
        $this->getView()->assign('title_personal_list', $userProfileModel->getTeachTitles());
        $this->getView()->assign('type_personal_list', $userProfileModel->getCityUserDists());
        $this->getView()->assign('course_properties', $beginCourseModel->getCourseProperty());
        $this->getView()->assign('class_list', $beginCourseModel->getCourses($class_kind));
        $this->getView()->display('/apply_course/stat_request_school.tpl');
    }
   

    public function ajaxGetCoursesJSONAction()
    {
        
            $beginCourseModel = new UPS_Model_BeginCourse();
           $courseProperty = $this->getParam('class_kind', PARAM_INT, -1);
     
            $data = $beginCourseModel->getCourses( $courseProperty);
            
            header('Content-Type: application/json; charset=utf-8');
            //不限  
            if($courseProperty==-1)
                 echo '{}';
            echo json_encode($data);
    }
    
    public function ajaxGetSchoolsJSONAction()
    {
        $schoolModel = new UPS_Model_School();
        $city_cd = $this->getParam('city_cd', PARAM_INT, 0);
        $type_personal = $this->getParam('type_personal', PARAM_INT, 0);

        $data =$schoolModel->getSchoolByUserType($city_cd,$type_personal);

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
    }
    
    public function ajaxGetDocJSONAction()
    {
        $docModel = $this->getModel('Doc');
        $city_cd = $this->getParam('city_cd', PARAM_INT, 0);
        $data =$docModel->getDocByCity($city_cd);

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
    }
    
    public function exportExcelAction()
    {
        require_once 'PHPExcel.php';
        require_once 'PHPExcel/IOFactory.php';
        $objPHPExcel = new PHPExcel();
     
        //$objPHPExcel->getActiveSheet()->fromArray($this->_exportData['header']);
        $rowIndex =1;
       
        foreach($this->_exportData['statistics'] as $row)
        {    
             $colIndex=0;
             foreach($row as $col){
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colIndex, $rowIndex, $col);
                $colIndex++;   
             }
             $rowIndex++;
        }
        
        $colIndex=0;
        foreach($this->_exportData['header'] as $data)
        {    
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colIndex, $rowIndex, $data);
            $colIndex++;   
        }
        $rowIndex++;
        
        foreach($this->_exportData['data'] as $row)
        {    
             $colIndex=0;
             foreach($row as $col){
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colIndex, $rowIndex, $col);
                $colIndex++;   
             }
             $rowIndex++;
        }
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=".urlencode('查詢報表').".xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        
        $objWriter->save('php://output');
    }
}
//End of LearningDataStat
