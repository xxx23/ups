<?php

require_once 'UPS/Auth/UserIdentity.php';
/**
 * 管理使用者登入登出 (Http statefull controll)
 * 實作 signleton pattern只會產生一個實體
 * 需要用 UPS_Auth_ApplyCourse::getInstance()取得
 * @author wewe0901
 */
class UPS_Auth_ApplyCourse {

    /**
     * 使用者登入後的識別證
     * @var UPS_Auth_UserIdntity
     */
    protected $identity=null;

    /**
     * 物件實體
     * @var UPS_Auth_ApplyCourse
     */
    protected static $_instance;
    /**
     * construct
     */
    private function  __construct() {
        session_start();
    }

    /**
     * singleton pattern不能複製
     */
    public function __clone()
    {
        throw new Exception(__CLASS__."is Singleton Can not have a copy.");
    }

    /**
     *  Singleton pattern模式 取得實體
     * @return UPS_Auth_ApplyCourse
     */
    public static function getInstance()
    {
        if(!isset(self::$_instance))
        {
            $c = __CLASS__;
            self::$_instance = new $c;
        }
        return self::$_instance;
    }

    /**
     * 使用者登入(與ApplyCourse的登入方法一樣)
     * @param string $userId
     * @param string $passwd
     * @return boolean
     */

    public function login($userId,$passwd)//authenticate
    {
       if( !$this->checkIdentity($userId,$passwd))
            return false;

       $_SESSION['web_service_identiry'] = $this->identity;
       $_SESSION['no'] = $this->identity['no'];
       $_SESSION['category'] = $this->identity['category'];

       return true;
    }

    /**
     *查看使用者是否登入
     * @return boolean
     */
    public function hasIdentity()
    {
        
        return isset($_SESSION['no']);
    }

    /**
     * 取得以登入的使用者的識別證
     * @return UserIdentity
     */
    public function getIdentity()
    {
        $user = new UserIdentity($_SESSION['no'],$_SESSION['category']);

        return $user;
    }
    /**
     *  登出
     */
    public function logout()
    {
        unset( $_SESSION['web_service_identiry']);
        unset( $_SESSION['no']);
        unset( $_SESSION['category'] );
    }

    /**
     *
     * 確認使用者是否有系統的存取權限並存資料庫取得使用者資訊
     * @param string $userId
     * @param string $passwd
     * @return boolean
     */
    public function checkIdentity($userId,$passwd)
    {
	$check_account_exist = " SELECT * FROM register_applycourse WHERE account='$userId' AND password=md5('$passwd') AND state = 1";
        $this->identity = db_getRow($check_account_exist);
        return !empty($this->identity);
    }
   

}
//END OF ApplyCourse.php
