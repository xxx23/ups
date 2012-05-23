<?php

require_once 'UPS/Model/Db.php';
/**
 *  課程系統使用者資料
 *
 * @author wewe0901
 */
class UPS_Model_BeginCourse extends UPS_Model_Db {
    /**
     * 相關的DB table name
     * @var string
     */
    protected $_tableName = "begin_course";
    protected $_courseNames = array();
    
    public function getCoursePropertyName($begin_course_cd)
    {
        $courseProperty = db_getOne("SELECT course_property FROM begin_course WHERE begin_course_cd = $begin_course_cd");
        return $this->getCourseProperty($courseProperty);
    }
    public function getCourseProperty( $property_cd = -1)
    {
        if($property_cd==-1)
            return db_getAll("SELECT *FROM course_property;");
        else
            return db_getOne("SELECT property_name FROM course_property WHERE property_cd = $property_cd");
        
    }
    
    public function getCourses( $property_cd = -1)
    {
        if($property_cd==-1)
            return db_getAll("SELECT begin_course_cd, begin_course_name FROM {$this->_tableName} ;");
        else
            return db_getAll("SELECT  begin_course_cd, begin_course_name FROM {$this->_tableName} WHERE course_property = $property_cd");
    }
    
    public function getCoursesByCondition($data)
    {
        if(empty($data) || !is_array($data) )
            return array();

        $conds = array();
        if( $data['course_property'] != -1 )
            $conds[] = "course_property={$data['course_property']}";
            
        if($data['begin_course_cd'] != -1 )
            $conds[] = "begin_course_cd={$data['begin_course_cd']}";
            
        if(!empty($data['deliver']))
            $conds[] = "deliver={$data['deliver']}";
        
         if(empty($conds))
             $condition = '1';
         else
            $condition = implode(' AND ' ,$conds);
        return db_getAll("SELECT * FROM begin_course WHERE $condition");
    }

    public function getCourseName($begin_course_cd)
    {
        if(!isset($this->courseNames[$begin_course_cd] )) 
        {
            $this->courseNames[$begin_course_cd] = db_getOne("SELECT begin_course_name FROM begin_course WHERE begin_course_cd = '{$begin_course_cd}' ;");
        }
        return $this->courseNames[$begin_course_cd];
    }
}
    
?>
