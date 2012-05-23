<?php

require_once 'UPS/Model/Db.php';
/**
 *  課程管理系統使用者資料
 *
 * @author wewe0901
 */
class UPS_Model_ApplyCourseUser extends UPS_Model_Db {
    
    /**
     * 相關的DB table name
     * @var string
     */
    protected $_tableName = "register_applycourse";
    
    
   public function getUserInfo($no)
   {
       if(empty($no))
           return null;
       return db_getRow("SELECT * FROM {$this->_tableName} WHERE no = $no");
   }
   
}

?>
