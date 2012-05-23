<?php
require_once 'UPS/ModelFactory.php';
require_once 'UPS/WebService/ServiceBase.php';
/**
 * Description of DocStat
 *
 * @author wewe0901
 */
class DocStat extends UPS_WebService_ServiceBase{
   /**
    *
    * @param string $date_begin
    * @param string $date_end
    * @return array 
    */
  function getStatData($date_begin,$date_end)
   {
        if(!$this->Authenticated)
                 throw new SoapFault('Authenicate Fail ',401);
        
        $statModel = UPS_ModelFactory::createModel('ApplyCourseStatistics');
        $docModel = UPS_ModelFactory::createModel('Doc');
        $schoolModel = UPS_ModelFactory::createModel('School');
        $beginCourseModel = UPS_ModelFactory::createModel('BeginCourse');
      
        
        $cityList = $docModel->getDocInstructCity($this->UserInfo['account']);
         if(empty($cityList))
            throw new SoapFault('Error Doc Instructor account',401);
        
        $statistics = $statModel->getDocLearningData(array(
            'begin_course_cd'=>-1,
            'course_property'=>-1,
            'doc_cd'=>-1,
            'city_cd'=>-1,
            'date_begin'=>$date_begin,
            'date_end'=>$date_end,
            'cityList'=>$cityList,
        ));
        $results= array();
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
        return $results;
        
   }
   /**
    *
    * @param string $date_begin
    * @param string $date_end
    * @return array 
    */
   function getStatDataSummary($date_begin,$date_end)
   {
        if(!$this->Authenticated)
                 throw new SoapFault('Authenicate Fail ',401);
        
        $statModel = UPS_ModelFactory::createModel('ApplyCourseStatistics');
        $docModel = UPS_ModelFactory::createModel('Doc');
        
        $cityList = $docModel->getDocInstructCity($this->UserInfo['account']);
         if(empty($cityList))
            throw new SoapFault('Error Doc Instructor account',401);
        
        $statistics = $statModel->getDocLearningData(array(
            'begin_course_cd'=>-1,
            'course_property'=>-1,
            'doc_cd'=>-1,
            'city_cd'=>-1,
            'date_begin'=>$date_begin,
            'date_end'=>$date_end,
            'cityList'=>$cityList,
        ));
         $stat_data = array(
                (int)$statistics['summary']['new_inhabitants']['male'],
                (int)$statistics['summary']['new_inhabitants']['female'],
                (int)$statistics['summary']['woman'],
                (int)$statistics['summary']['elder']['male'],
                (int)$statistics['summary']['elder']['female'],
                (int)$statistics['summary']['labor']['male'],
                (int)$statistics['summary']['labor']['female']
                );
        return $stat_data;
        
   }
}

?>
