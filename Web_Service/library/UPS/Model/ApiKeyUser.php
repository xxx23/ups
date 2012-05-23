<?php
require_once 'UPS/Model/Db.php';
/**
 *  管理APIKEY的使用者 資料
 * @author wewe0901
 */
class UPS_Model_ApiKeyUser extends UPS_Model_Db
{
    /**
     * 相關的DB table name
     * @var string
     */
    protected $_tableName = "register_applycourse";
    /**
     * 課程管理使用者類別烈表
     * @var array
     */
    protected $_account_category = array(
        '0'=>'全部', 
        '1'=>'縣市政府', 
        '2'=>'大專院校', 
        '3'=>'數位機會中心輔導團', 
        '4'=>'數位機會中心',// 目前應該沒有這個帳號
        'a'=>'資教組', 
        'b'=>'資源組', 
        'c'=>'學習組',
        'd'=>'防治藥物濫用'//20110107加的
    );
   

    /**
     * 取得使用者類別烈表
     * @return array
     */
    public function getCategories()
    {
        return array('keys' => array_keys($this->_account_category),
                     'values'=> array_values($this->_account_category));
    }
    /**
     * 取得尚未審核的apikey烈表
     * @return array
     */
    public function getWaitKeys()
    {
        $datas =db_getAll("
            SELECT K.*,R.account,R.category,R.org_title
            FROM {$this->_tableName} R,ups_ws_key K
            WHERE K.user_id = R.no
            AND K.status = 0");
        $dataOut = array();
        foreach($datas as $data)
        {
            $tmp = $data;
            $tmp['category'] = $this->_account_category[$tmp['category'] ];
            $dataOut[]=$tmp;
        }
        return $dataOut;


    }

    /**
     * 取得審核通過的使用者
     * @param array where
     * @return array
     */
    public function getUsers($where = '')
    {
        if(!empty($where) && is_array($where))
        {
            $conditions = array();
            foreach($where as $key =>$value)
            {
                $key = (in_array($key,array('category','account')))? 'R.'.$key : 'K.'.$key;
                
                if(!empty($value))
                    $conditions[] = (is_int($value))? "{$key}={$value}" : "{$key} LIKE '%".$this->escape($value)."%'" ;
            }
            $where = implode(' AND ',$conditions);
        }
        else $where =1;
        $datas =db_getAll("
            SELECT K.*,R.account,R.category,R.org_title
            FROM {$this->_tableName} R,ups_ws_key K
            WHERE K.user_id = R.no
            AND K.status=1
            AND $where");
        $dataOut = array();
        foreach($datas as $data)
        {
            $tmp = $data;
            $tmp['category'] = $this->_account_category[$tmp['category'] ];
            $dataOut[]=$tmp;
        }
        return $dataOut;

    }
    /**
     *　根據輸入的userID 取得使用者的個人資料
     * @param int $user_id
     * @return <type>
     */
    public function getUserInfo($user_id)
    {

        return db_getRow("SELECT * 
                          FROM {$this->_tableName}
                          WHERE no = $user_id");
    }
    /**
     * 根據使用者的api key取得使用者資訊
     * @param string $key
     * @return array
     */
    public function getUserInfoByKey($key)
    {
        return db_getRow("SELECT *
                          FROM ups_ws_key K,register_applycourse R
                          WHERE K.user_id = R.no
                          AND K.status = 1
                          AND K.api_key = '{$key}';");
    }
    
   
}

//END OF ApiKeyUser.php
