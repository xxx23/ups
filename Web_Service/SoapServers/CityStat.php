<?php
require_once 'UPS/ModelFactory.php';
require_once 'UPS/WebService/ServiceBase.php';

/**
 * Description of CityStat
 *
 * @author wewe0901
 */
class CityStat extends UPS_WebService_ServiceBase{
    
    /**
     *  縣市政府取得縣市內 高中職 與國中小教師的研習紀錄
     * @param string $moe_school_id
     * @param string $date_begin
     * @param string $date_end
     * @param int $dist_cd
     * @param int $deliver
     * 
     * @return array 
     */
   function getStatData($moe_school_id,$date_begin,$date_end,$dist_cd,$deliver)
   {
        if(!$this->Authenticated)
                 throw new SoapFault('Authenicate Fail ',401);
        
        if(empty($this->UserInfo['city_cd']))
                throw new SoapFault('Wrong City',401);
        
        $schoolModel = UPS_ModelFactory::createModel('School');
        $statModel = UPS_ModelFactory::createModel('ApplyCourseStatistics');
        $city_cd = $this->UserInfo['city_cd'];
        if(!empty($moe_school_id))
            $school_cd = $schoolModel->getInnerSchoolCd($moe_school_id);
        else
            $school_cd =-1;
        
        $data = $statModel->getCityLearningData(array(
                                        'begin_course_cd'=>-1,
                                         'course_property'=>-1 ,
                                         'deliver'=> $deliver,
                                         'title'=>-1 ,
                                        'dist_cd' =>$dist_cd,
                                         'school_cd'=> $school_cd,
                                         'date_begin'=>$date_begin ,
                                         'date_end'=>$date_end ,
                                         'city_cd'=>$city_cd
                                    ));
        return $data;
   }
}

?>
