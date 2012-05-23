<?php

require_once 'UPS/ModelFactory.php';
/**
 * Description of UPS_Webservice_Logger
 *logger
 * @author wewe0901
 */
class UPS_Webservice_Logger {
    protected $_logModel;
    protected $_service_id;
    protected $_apikey;
    
    public function __construct($apikey,$service_id)
    {
        $this->_logModel = UPS_ModelFactory::createModel('WSLog');
        $this->_service_id = $service_id;
        $this->_apikey = $apikey;
        
    }
    
    public function info($msg)
    {
        $this->_logModel->info($this->_apikey,$this->_service_id,$msg);
    }
    
    public function debug($msg)
    {
        $this->_logModel->debug($this->_apikey,$this->_service_id,$msg);
    }
    
    public function warning($msg)
    {
        $this->_logModel->warning($this->_apikey,$this->_service_id,$msg);
    }
    
    public function error($msg)
    {
        $this->_logModel->error($this->_apikey,$this->_service_id,$msg);
    }
    
    public function critical($msg)
    {
        $this->_logModel->critical($this->_apikey,$this->_service_id,$msg);
    }
}

//END OF Logger.php
