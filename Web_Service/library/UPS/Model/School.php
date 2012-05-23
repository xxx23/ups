<?php


require_once 'UPS/Model/Db.php';
/**
 * Description of School
 *
 * @author wewe0901
 */
class UPS_Model_School extends UPS_Model_Db {
    
    protected $_tableName = 'location';
    protected $_cityList = array();
    protected $_schoolList = array();
    public function getSchoolTypes()
    {
        return array(
            '1' =>'國小',
            '2' =>'國中',
            '3' =>'高中',
            '4' =>'高職',
            '5' =>'大專院校'
        );
    }
    public function getSchoolCityList()
    {
        if(empty($this->_cityList))
        {
            $data = db_getAll("SELECT DISTINCT city_cd,city FROM location ;");
            $cityList =  array();
            foreach($data as $city)
                $cityList[$city['city_cd']] = $city['city'];
            $this->_cityList = $cityList;
        }
        return $this->_cityList;
    }
    
    public function getSchoolCityName($city_cd)
    {
         if(empty($this->_cityList))
                 $this->getSchoolCityList ();
         
         return $this->_cityList[$city_cd];
    }
    public function getSchools($city_cd=null,$type=null)
    {
        $conds =array();
        if(!empty($city_cd))
            $conds[]= "city_cd=$city_cd";
        if(!empty($type))
            $conds[]= "type=$type";
        
        if(empty($conds))
            $condition = '1';
        else
            $condition = implode(' AND ',$conds);
        
        $data = db_getAll("SELECT school_cd, school FROM location WHERE $condition ;");
        return $data;

    }
    public function getSchoolName($school_cd)
    {
        if(!isset($this->_schoolList[$school_cd]))
        {
            $this->schoolList[$school_cd] = db_getOne("SELECT school FROM location WHERE school_cd = {$school_cd}");
        }
        return $this->schoolList[$school_cd];
    }
    public function getInnerSchoolCd($moe_school_id)
    {
         return db_getOne("SELECT school_cd FROM location WHERE moe_cd ='{$moe_school_id}'");
    }
    public function getSchoolByUserType($city_cd=null,$type=null)
    {
        $data =array();
         if($type == 1)
            {
                $data = array_merge(
                    $this->getSchools( $city_cd,1),
                    $this->getSchools( $city_cd,2)
                );
            }
            else if($type ==2 )
            {
                $data = array_merge(
                    $this->getSchools( $city_cd,3),
                    $this->getSchools( $city_cd,4)
                );
            }
            else if($type==3)
            {
                 $data =$this->getSchools( $city_cd,5);
            }
            else if($type==4)
            {
                 $data =$this->getSchools( $city_cd,5);
            }
            return $data;
    }
}

?>
