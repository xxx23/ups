<?php
require_once 'UPS/Model/Db.php';
/**
 *  關於API Key的資料操作
 * @author wewe0901
 */
class UPS_Model_Key extends UPS_Model_Db
{
    /**
     *  審核通過的Key
     */
    const KEY_STATUS_OK = 1;

    /**
     *  待審核的Key
     */
    const KEY_STATUS_WAIT = 0;
    
    /**
     * api key的 db table name
     * @var string
     */
    protected $_tableName = 'ups_ws_key';

    /**
     * 使用者是否有apikey
     * @param int $user_id
     * @return boolean
     */
    public function hasKey($user_id)
    {
        $user_id = (int)$user_id;
        $data = db_getRow("SELECT *
                           FROM ups_ws_key
                           WHERE user_id = {$user_id}");
       return !empty($data); 
    }        

    /**
     * 產生APIKEY並儲存置資料庫
     * @param int $user_id
     * @param string $ips
     * @param int $usage
     * @return string
     */
    public function createKey($user_id,$ips,$usage)
    {
        
        if($this->hasKey($user_id))
            $key = $this->getKey($user_id);
        else
        {
            require_once 'UPS/WebService/ApiKeyGenerator.php';
            $keyGen = new UPS_WebService_ApiKeyGenerator();
            $time = time();
            $key = $keyGen->generate($user_id);
            $this->insert(array('user_id' => $user_id,
                                'api_key' => $key,
                                'ip_restrict' => '*',
                                'usage' => $usage,
                                'status'=> self::KEY_STATUS_WAIT,
                                'create_time' => $time));
        }
        return $key;
    }

    /**
     * 儲存資料 如果 user_id 與api_key有值就會更新資料否則會新增資料
     * @param array $data
     */
    public function save($data)
    {
        if(isset($data['user_id']) && isset($data['api_key']))
        {
            $this->update($data," user_id = {$data['user_id']} AND api_key ='{$data['api_key']}'");
        }
        else
        {   
            $this->insert($data);
        }
    
    }

    /**
     * 取的使用者的api key
     * 
     * @param int $user_id
     * @return string
     */
    public function getKey($user_id)
    {
        $data = db_getRow("SELECT *
                           FROM ups_ws_key
                           WHERE user_id = {$user_id}");
        
        if(!empty($data['api_key']))
            return $data['api_key'];
        else 
            return '';    
    }

    /**
     * 取得使用者的api-key的整筆資料
     * @param int $user_id
     * @return array
     */
    public function getKeyInfo($user_id)
    {
         $data = db_getRow("SELECT *
                           FROM ups_ws_key
                           WHERE user_id = {$user_id}");
        
       return $data; 
    }

}

//END OF Key.php
