<?php
require_once 'UPS/ModelFactory.php';
require_once 'UPS/WebService/ServiceBase.php';
/**
 * Description of UniversityStat
 *
 * @author wewe0901
 */
class UniversityStat  extends UPS_WebService_ServiceBase{
    /**
     * 給定起始與結束時間 回傳所屬大專院校的 時間內的學生研習資料
     * @param string $date_begin
     * @param string $date_end
     * @return array 
     */
    function getStudentData($date_begin,$date_end)
   {
         if(!$this->Authenticated)
                 throw new SoapFault('Authenicate Fail ',401);
        
         if(empty($this->UserInfo['city_cd']))
                throw new SoapFault('Error city',401);
         
        if(empty($this->UserInfo['school_cd']))
                throw new SoapFault('Error school',401);
        
        $city_cd = $this->UserInfo['city_cd'];
        $school_cd = $this->UserInfo['school_cd'];
        $learningDataStatModel = UPS_ModelFactory::createModel('ApplyCourseStatistics');
        $data = $learningDataStatModel->getUniversityLearningData(array(
                                        'begin_course_cd'=> -1,
                                         'course_property'=>-1 ,
                                         'deliver'=> 0,
                                        'dist_cd' =>3,
                                         'school_cd'=> $school_cd,
                                         'date_begin'=>$date_begin ,
                                         'date_end'=>$date_end ,
                                         'city_cd'=>$city_cd ,
                                    ));
        
        return $data;
   }
   
    /**
     * 給定起始與結束時間 回傳所屬大專院校的 時間內的學生研習資料
     * @param string $date_begin
     * @param string $date_end
     * @return array 
     */
   function getTeacherData($date_begin,$date_end)
   {
         if(!$this->Authenticated)
                 throw new SoapFault('Authenicate Fail ',401);
        
         if(empty($this->UserInfo['city_cd']))
                throw new SoapFault('Error city',401);
         
        if(empty($this->UserInfo['school_cd']))
                throw new SoapFault('Error school',401);
        
        $city_cd = $this->UserInfo['city_cd'];
        $school_cd = $this->UserInfo['school_cd'];
        $learningDataStatModel = UPS_ModelFactory::createModel('ApplyCourseStatistics');
        $data = $learningDataStatModel->getUniversityLearningData(array(
                                        'begin_course_cd'=> -1,
                                         'course_property'=>-1 ,
                                         'deliver'=> 0,
                                        'dist_cd' =>3,
                                         'school_cd'=> $school_cd,
                                         'date_begin'=>$date_begin ,
                                         'date_end'=>$date_end ,
                                         'city_cd'=>$city_cd ,
                                    ));
        return $data;
   }    

}

?>
