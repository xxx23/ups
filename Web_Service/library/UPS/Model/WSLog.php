<?php

require_once 'UPS/Model/Db.php';
require_once 'UPS/ModelFactory.php';
/**
 *  記錄使用者行為的操作
 * @author wewe0901
 */
class UPS_Model_WSLog extends UPS_Model_Db
{
    /**
     *  一般訊息
     */
    const LEVEL_INFO = "INFO";

    /**
     *  警告訊息
     */
    const LEVEL_WARNING = "WARNING";
    
    /**
     * 除錯訊息
     */
    const LEVEL_DEBUG = "DEBUG";
    
    /**
     * 錯誤訊息
     */
    const LEVEL_ERROR = "ERROR";
    
    /**
     * 嚴重的錯誤訊息
     */
    const LEVEL_CRITICAL = "CRITICAL";

    /**
     * log的table name
     * @var string
     */
    protected $_tableName = 'ups_ws_log';

    /**
     * 所有的錯誤等級
     * @var array
     */
    protected $_levels =array(
                '',//搜尋全部用
                self::LEVEL_INFO,
                self::LEVEL_WARNING,
                self::LEVEL_DEBUG,
                self::LEVEL_ERROR,
                self::LEVEL_CRITICAL,
            );

    /**
     * 取得所有的錯誤等級
     * @return array
     */
    public function getLevels()
    {
        return $this->_levels;
    }

    /**
     * 儲存LOG
     * @param string $level
     * @param string $apikey
     * @param int $service_id
     * @param sring $message
     * @return UPS_Model_WSLog
     */
    public function logTo($level,$apikey,$service_id,$message)
    {
        $time = time();

        $this->insert(array('api_key'=>$apikey,
                            'level'=>$level,
                            'message'=>$message,
                            'service_id'=>$service_id,
                            'timestamp'=>$time));
        return $this;
        

    }

    /**
     * 根據輸入的條件 取得所有LOG
     *
     * @param array $where
     * @return array
     */
    public function getLogs($where)
    {
        if(!empty($where) && is_array($where))
        {
            $conditions = array();
            if(!empty($where['api_key']))
                $conditions[] = "L.api_key='{$where['api_key']}'";
            if(!empty($where['level']))
                $conditions[] = "L.level='{$where['level']}'";
            if(!empty($where['start']))
                $conditions[] = 'L.timestamp >= '.strtotime($where['start']);
            if(!empty($where['end']))
                $conditions[] = 'L.timestamp <= '.strtotime($where['end']);
            if(!empty($where['name']))
                $conditions[] = "S.name='{$where['name']}'";
            $where = implode(' AND ',$conditions);
        }
        else $where =1;
        $results=array();

        $datas= db_getAll("SELECT *
                          FROM ups_ws_log L,ups_ws_services S
                          WHERE L.service_id = S.id 
                          AND {$where}");
        foreach($datas as $data)
        {
            $result=$data;
            $result['timestamp']= date('Y-m-d h:i:s',$result['timestamp']);
            $result['service_id'] = UPS_ModelFactory::createModel('Services')->getServiceName($result['service_id']);
            $results[] = $result;
        }
        return $results;
    }

    /**
     *  儲存info等級的訊息
     * @param string $apikey
     * @param int $service_id
     * @param string $message
     */
    public function info($apikey,$service_id,$message)
    {
         
        $this->logTo(self::LEVEL_INFO,$apikey,$service_id,$message);
    }

    /**
     *  儲存warning等級的訊息
     * @param string $apikey
     * @param int $service_id
     * @param string $message
     */
    public function warning($apikey,$service_id,$message)
    {
        $this->logTo(self::LEVEL_WARNING,$apikey,$service_id,$message);
    }

    /**
     *  儲存debug等級的訊息
     * @param string $apikey
     * @param int $service_id
     * @param string $message
     */
    public function debug($apikey,$service_id,$message)
    {
        $this->logTo(self::LEVEL_DEBUG,$apikey,$service_id,$message);
    }

    /**
     *  儲存error等級的訊息
     * @param string $apikey
     * @param int $service_id
     * @param string $message
     */
    public function error($apikey,$service_id,$message)
    {
        $this->logTo(self::LEVEL_ERROR,$apikey,$service_id,$message);
    }

    /**
     *  儲存critical等級的訊息
     * @param string $apikey
     * @param int $service_id
     * @param string $message
     */
    public function critical($apikey,$service_id,$message)
    {
        $this->logTo(self::LEVEL_CRITICAL,$apikey,$service_id,$message);
    }
   
}
//END OF WSLog.php
