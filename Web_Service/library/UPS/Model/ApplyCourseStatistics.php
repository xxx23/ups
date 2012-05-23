<?php
require_once 'UPS/ModelFactory.php';
/**
 * Description of ApplyCourseStatistics
 *
 * @author wewe0901
 */
class UPS_Model_ApplyCourseStatistics {
    /**
     * $argas =  array(
     *  'begin_course_cd',
     * 'course_property',
     * 'deliver
     * )
     * @param array $args 
     */
    public function getCityLearningData($args)
    {
        $beginCourseModel = UPS_ModelFactory::createModel('BeginCourse');
        $schoolModel = UPS_ModelFactory::createModel('School');
            $class_choose = $args['begin_course_cd'];
            $class_kind = $args['course_property'];
            $deliver_passhour = $args['deliver'];
            $title_personal = $args['title'];
            $type_personal = $args['dist_cd'];
            $school_cd = $args['school_cd'];
            $show_pass = $args['pass'];
            $date_begin = $args['date_begin'];
            $date_end= $args['date_end'];
            $city_cd = $args['city_cd'];

        
          //search
            $courses = $beginCourseModel->getCoursesByCondition(array(
                'begin_course_cd'  => $class_choose,
                'course_property' => $class_kind,
                'deliver'=>$deliver_passhour
            ));

            $result = array();
            
            foreach($courses as $course)
            {
                $conds = array();
                if($title_personal != -1 )
                    $conds[] = "personal_basic.title={$title_personal}";
                if($type_personal==-1)
                {
                      $conds[] = "(personal_basic.dist_cd=1 OR personal_basic.dist_cd=2)";
                }
                else if($type_personal==1 or $type_personal==2)
                {
                    $conds[] = "personal_basic.dist_cd={$type_personal}";
                }
                if($school_cd != -1)
                    $conds[] = "personal_basic.school_cd={$school_cd}";
               
                 if(!empty($date_begin)&& !empty($date_end)){
                    if($course['attribute']==0)
                    {
                            $conds[] = "(take_course.course_begin <='{$date_end}' AND take_course.course_end >=  '{$date_begin}' 
                            AND ( take_course.pass !=1 OR take_course.pass_time >= '{$date_begin}'  ) )";
                    }
                    else if($course['attribute']==1)
                    {
                        $courseBegin = strtotime($course['d_course_begin']);
                        $courseEnd =strtotime($course['d_course_end']);
                        $qBegin = strtotime($date_begin);
                        $qEnd = strtotime($date_end);
                        $in_query_time = ($courseEnd >= $qBegin && $coursebegin <=$qEnd);
                       //教導式課程如果沒有在開課期間內 就不須抓出學員資料
                        if(! $in_query_time)
                            continue;
                    }
                }
                $condition='';
                if(!empty($conds))
                    $condition = ' AND '.implode(' AND ',$conds);
                
                $datas =db_getAll("SELECT take_course.*, personal_basic.title, personal_basic.teach_doc, personal_basic.city_cd, personal_basic.dist_cd, personal_basic.school_cd,personal_basic.personal_name,identify_id
                                                FROM take_course
                                                LEFT JOIN personal_basic on take_course.personal_id = personal_basic.personal_id
                                                WHERE personal_basic.city_cd = {$city_cd} 
                                                AND take_course.begin_course_cd = {$course['begin_course_cd']}
                                                $condition ");
        
                foreach($datas as $data)
                {
                        $result[]=array(
                            'personal_name' => $data['personal_name'],
                            'teach_doc' => $data['teach_doc'],
                           // 'city' => $schoolModel->getSchoolCityName($data['city_cd']),
                           // 'dist' => $userProfileModel->getCityUserDists($data['dist_cd']),
                          //  'title' => $userProfileModel->getTeachTitles($data['title']),
                            'school' => $schoolModel->getSchoolName($data['school_cd']),
                            'begin_course_name' => $course['begin_course_name'],
                            'course_property' =>$beginCourseModel->getCourseProperty( $course['course_property']),
                            'pass' =>($data['pass']==1)?'通過':'未通過',
                               'pass_time'=> $data['pass_time'],
                            'certify' =>($data['pass']==1)? $course['certify']:0
                        );
     
                }
                
            }
            return $result;
    }
    public function getUniversityLearningData($args)
    {
        $beginCourseModel = UPS_ModelFactory::createModel('BeginCourse');
        $schoolModel = UPS_ModelFactory::createModel('School');
            $class_choose = $args['begin_course_cd'];
            $class_kind = $args['course_property'];
            $deliver_passhour = $args['deliver'];
            $type_personal = $args['dist_cd'];
            $school_cd = $args['school_cd'];
            $show_pass = $args['pass'];
            $date_begin = $args['date_begin'];
            $date_end= $args['date_end'];
            $city_cd = $args['city_cd'];

        
          //search
            $courses = $beginCourseModel->getCoursesByCondition(array(
                'begin_course_cd'  => $class_choose,
                'course_property' => $class_kind,
                'deliver'=>$deliver_passhour
            ));

            $result = array();
            
            foreach($courses as $course)
            {
                $conds = array();
               
                if($type_personal==-1)
                {
                      $conds[] = "(personal_basic.dist_cd=3 OR personal_basic.dist_cd=4)";
                }
                else if($type_personal==1 or $type_personal==2)
                {
                    $conds[] = "personal_basic.dist_cd={$type_personal}";
                }
                if($school_cd != -1)
                    $conds[] = "personal_basic.school_cd={$school_cd}";
               
                 if(!empty($date_begin)&& !empty($date_end)){
                    if($course['attribute']==0)
                    {
                            $conds[] = "(take_course.course_begin <='{$date_end}' AND take_course.course_end >=  '{$date_begin}' 
                            AND ( take_course.pass !=1 OR take_course.pass_time >= '{$date_begin}'  ) )";
                    }
                    else if($course['attribute']==1)
                    {
                        $courseBegin = strtotime($course['d_course_begin']);
                        $courseEnd =strtotime($course['d_course_end']);
                        $qBegin = strtotime($date_begin);
                        $qEnd = strtotime($date_end);
                        $in_query_time = ($courseEnd >= $qBegin && $coursebegin <=$qEnd);
                       //教導式課程如果沒有在開課期間內 就不須抓出學員資料
                        if(! $in_query_time)
                            continue;
                    }
                }
                $condition='';
                if(!empty($conds))
                    $condition = ' AND '.implode(' AND ',$conds);
                
                $datas =db_getAll("SELECT take_course.*, personal_basic.title, personal_basic.teach_doc, personal_basic.city_cd, personal_basic.dist_cd, personal_basic.school_cd,personal_basic.personal_name,identify_id
                                                FROM take_course
                                                LEFT JOIN personal_basic on take_course.personal_id = personal_basic.personal_id
                                                WHERE personal_basic.city_cd = {$city_cd} 
                                                AND take_course.begin_course_cd = {$course['begin_course_cd']}
                                                $condition ");
        
                foreach($datas as $data)
                {
                        $result[]=array(
                            'personal_name' => $data['personal_name'],
                           // 'teach_doc' => $data['teach_doc'],
                           // 'city' => $schoolModel->getSchoolCityName($data['city_cd']),
                           // 'dist' => $userProfileModel->getCityUserDists($data['dist_cd']),
                          //  'title' => $userProfileModel->getTeachTitles($data['title']),
                            'school' => $schoolModel->getSchoolName($data['school_cd']),
                            'begin_course_name' => $course['begin_course_name'],
                            'course_property' =>$beginCourseModel->getCourseProperty( $course['course_property']),
                            'pass' =>($data['pass']==1)?'通過':'未通過',
                               'pass_time'=> $data['pass_time'],
                           // 'certify' =>($data['pass']==1)? $course['certify']:0
                        );
     
                }
                
            }
            return $result;
    }
    public function getDocLearningData($args)
    {
        $class_choose = $args['begin_course_cd'];
        $class_kind = $args['course_property'];
        $doc_cd = $args['doc_cd'];
        $city_cd = $args['city_cd'];
        $date_begin =$args['date_begin'];
        $date_end = $args['date_end'];
        $cityList = $args['cityList'];
        $beginCourseModel = UPS_ModelFactory::createModel('BeginCourse');
        //撈出資料
        $statistics =array('course'=>array(),'summary'=>array());
         $courses = $beginCourseModel->getCoursesByCondition(array(
            'begin_course_cd'  => $class_choose,
            'course_property' => $class_kind,
            'deliver'=>0
        ));


        foreach($courses as $course){
            $conds = array();
            if($doc_cd != -1)
                $conds[] = 'personal_basic.doc_cd ='.$doc_cd;
            else{
                $city_conds =array();
                foreach(array_keys($cityList) as $city)
                    $city_conds[] = "personal_basic.city_cd=$city";

                $conds[] = '('.implode(' OR ' ,$city_conds) .')';
            }
            if($city_cd != -1)
                $conds[] = 'personal_basic.city_cd ='.$city_cd;

            if(!empty($date_begin)&& !empty($date_end)){
                if($course['attribute']==0)
                {
                        $conds[] = "(take_course.course_begin <='{$date_end}' AND take_course.course_end >=  '{$date_begin}' 
                        AND ( take_course.pass !=1 OR take_course.pass_time >= '{$date_begin}'  ) )";
                }
                else if($course['attribute']==1)
                {
                    $courseBegin = strtotime($course['d_course_begin']);
                    $courseEnd =strtotime($course['d_course_end']);
                    $qBegin = strtotime($date_begin);
                    $qEnd = strtotime($date_end);
                    $in_query_time = ($courseEnd >= $qBegin && $coursebegin <=$qEnd);
                   //教導式課程如果沒有在開課期間內 就不須抓出學員資料
                    if(! $in_query_time)
                        continue;
                }
            }
             if(!empty($conds))
                $condition = ' AND '.implode(' AND ',$conds);
            $datas = db_getAll("SELECT *
                                            FROM take_course
                                            LEFT JOIN personal_basic ON take_course.personal_id = personal_basic.personal_id
                                            WHERE take_course.begin_course_cd={$course['begin_course_cd']} 
                                            AND personal_basic.dist_cd =0 
                                            $condition
                                            ");

            foreach($datas as $data)
            {
                 if($data['sex']==1)
                 {
                     $statistics['summary']['male']++;
                 }
                elseif($data['sex']==0)
                {
                    $statistics['summary']['female']++;
                }
                $statistics['summary']['total']++;
                //新住民統計
                if($data['family_site']==3)
                    if($data['sex']==1)
                    {
                        $statistics['course'][$data['city_cd']][$data['doc_cd']][$course['begin_course_cd']]['new_inhabitants']['male'] ++;
                        $statistics['summary']['new_inhabitants']['male'] ++;
                    }
                    elseif($data['sex']==0)
                    {
                        $statistics['course'][$data['city_cd']][$data['doc_cd']][$course['begin_course_cd']]['new_inhabitants']['female'] ++;
                        $statistics['summary']['new_inhabitants']['female'] ++;
                    }
                //婦女統計
                $birthday = strtotime($data['d_birthday']);
                $now = time();
                if($data['sex']==0 && $now -$birthday >= 40*365*24*60*60 )//四十歲以上女性
                {
                    $statistics['course'][$data['city_cd']][$data['doc_cd']][$course['begin_course_cd']]['woman']++;
                    $statistics['summary']['woman']++;
                }
                //銀髮族統計
                if($now -$birthday >= 50*365*24*60*60 ) //五十歲以上
                    if($data['sex']==1)
                    {
                         $statistics['course'][$data['city_cd']][$data['doc_cd']][$course['begin_course_cd']]['elder']['male']++;
                         $statistics['summary']['elder']['male']++;
                    }
                    elseif($data['sex']==0)
                    {    
                        $statistics['course'][$data['city_cd']][$data['doc_cd']][$course['begin_course_cd']]['elder']['female']++;
                        $statistics['summary']['elder']['female']++;
                    }
                //勞工統計
                if($data['job']==0)
                     if($data['sex']==1)
                     {
                             $statistics['course'][$data['city_cd']][$data['doc_cd']][$course['begin_course_cd']]['labor']['male']++;
                             $statistics['summary']['labor']['male']++;
                     }
                     elseif($data['sex']==0)
                     {
                        $statistics['course'][$data['city_cd']][$data['doc_cd']][$course['begin_course_cd']]['labor']['female']++;
                        $statistics['summary']['labor']['female']++;
                     }
             }
        }
        return $statistics;
    }
    public function getSchoolLearningData($args)
    {
        /* 此function與getCityLearningData相同 */
        $no = $_SESSION['no'];
        $beginCourseModel = UPS_ModelFactory::createModel('BeginCourse');
        $schoolModel = UPS_ModelFactory::createModel('School');
            $class_choose = $args['begin_course_cd'];
            $class_kind = $args['course_property'];
            $deliver_passhour = $args['deliver'];
            $title_personal = $args['title'];
            $type_personal = $args['dist_cd'];
            $school_cd = $args['school_cd'];
            $show_pass = $args['pass'];
            $date_begin = $args['date_begin'];
            $date_end= $args['date_end'];
            $city_cd = $args['city_cd'];

        
          //search
            $courses = $beginCourseModel->getCoursesByCondition(array(
                'begin_course_cd'  => $class_choose,
                'course_property' => $class_kind,
                'deliver'=>$deliver_passhour
            ));

            $result = array();
            
            foreach($courses as $course)
            {
                $conds = array();
                if($title_personal != -1 )
                    $conds[] = "personal_basic.title={$title_personal}";
                if($type_personal==-1)
                {
                      $conds[] = "(personal_basic.dist_cd=1 OR personal_basic.dist_cd=2)";
                }
                else if($type_personal==1 or $type_personal==2)
                {
                    $conds[] = "personal_basic.dist_cd={$type_personal}";
                }
                if($school_cd != -1)
                    $conds[] = "personal_basic.school_cd={$school_cd}";
               
                 if(!empty($date_begin)&& !empty($date_end)){
                    if($course['attribute']==0)
                    {
                            $conds[] = "(take_course.course_begin <='{$date_end}' AND take_course.course_end >=  '{$date_begin}' 
                            AND ( take_course.pass !=1 OR take_course.pass_time >= '{$date_begin}'  ) )";
                    }
                    else if($course['attribute']==1)
                    {
                        $courseBegin = strtotime($course['d_course_begin']);
                        $courseEnd =strtotime($course['d_course_end']);
                        $qBegin = strtotime($date_begin);
                        $qEnd = strtotime($date_end);
                        $in_query_time = ($courseEnd >= $qBegin && $coursebegin <=$qEnd);
                       //教導式課程如果沒有在開課期間內 就不須抓出學員資料
                        if(! $in_query_time)
                            continue;
                    }
                }
                $condition='';
                if(!empty($conds))
                    $condition = ' AND '.implode(' AND ',$conds);
                
                $datas =db_getAll("SELECT take_course.*, personal_basic.title, personal_basic.teach_doc, personal_basic.city_cd, personal_basic.dist_cd, personal_basic.school_cd,personal_basic.personal_name,identify_id
                                                FROM take_course
                                                LEFT JOIN personal_basic on take_course.personal_id = personal_basic.personal_id
                                                WHERE personal_basic.city_cd = {$city_cd} 
                                                AND take_course.begin_course_cd = {$course['begin_course_cd']}
                                                $condition ");
        
                foreach($datas as $data)
                {
                        $result[]=array(
                            'personal_name' => $data['personal_name'],
                            'teach_doc' => $data['teach_doc'],
                           // 'city' => $schoolModel->getSchoolCityName($data['city_cd']),
                           // 'dist' => $userProfileModel->getCityUserDists($data['dist_cd']),
                          //  'title' => $userProfileModel->getTeachTitles($data['title']),
                            'school' => $schoolModel->getSchoolName($data['school_cd']),
                            'begin_course_name' => $course['begin_course_name'],
                            'course_property' =>$beginCourseModel->getCourseProperty( $course['course_property']),
                            'pass' =>($data['pass']==1)?'通過':'未通過',
                               'pass_time'=> $data['pass_time'],
                            'certify' =>($data['pass']==1)? $course['certify']:0
                        );
     
                }
                
            }
            return $result;
    }

}

?>
