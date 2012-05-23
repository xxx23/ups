<?php
require_once 'UPS/Model/Db.php';
/**
 * Description of UserProfile
 *
 * @author wewe0901
 */
class UPS_Model_UserProfile extends UPS_Model_Db{
     protected $_userDists = array(
            '0' => '一般民眾',
            '1' => '國民中小學教師',
            '2' => '高中職教師',
            '3' => '大專院校學生',
            '4' => '大專院校教師',
            '5' => '數位機會中心輔導團隊講師',
            '6' => '縣市政府研習課程老師',
            '7' => '其他(教育部承辦人)',
        );
     protected $_teachTitles =array(
            '0' => '一般教師',
            '1' => '主任',
            '2' => '校長',
        );
    /**
     * 取得系統腳色名稱
     * @return array
     */
    function getUserRoles()
    {
        $db_roles = db_getAll("SELECT * FROM lrtrole_");
        $roles=array();
        foreach($db_roles as $data)
        {
            $roles[$data['role_cd']] = $data['role_name'];
        }
        return $roles;
    }
    
    /**
     * 取得系統使用者身份別
     * @return array
     */
    function getUserDists($dist_cd = null)
    {
        if(empty($dist_cd))
            return $this->_userDists;
        
        return $this->_userDists[$dist_cd];
    }
    /**
     * 取得大專院校 管轄之身分別
     * @return array
     */
    function getUniversityUserDists()
    {
        return array(
           '3' => '大專院校學生',
           '4' => '大專院校教師',
        );
    }
    
    /**
     * 取得縣市網 管轄之身分別
     * @return array
     */
    function getCityUserDists()
    {
        return array(
            '1' => '國民中小學教師',
            '2' => '高中職教師',
        );
    }
    
    /**
     *  取得教師之職稱
     */
    function getTeachTitles($title=null)
    {
        if(empty($title))
            return $this->_teachTitles;
        
        return $this->_teachTitles[$title];
    }
}

?>
