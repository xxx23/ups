<?php
require_once 'UPS/ModelFactory.php';
require_once 'UPS/WebService/Logger.php';
/**
 * Description of WebServiceBase
 * 系統實作API的base class
 * 負責使用者認證 使用者利用soapheader輸入 apikey通過認證後才可使用
 *
 * @author wewe0901
 */
abstract class UPS_WebService_ServiceBase {

    protected $Authenticated =false;
    protected $Logger = null;
    /**
     * authenticate method
     * 
     * @param array 
     * 
     */
    public function authenticate($auth)
    {
        $userModel = UPS_ModelFactory::createModel('ApiKeyUser'); 
        $keyModel = UPS_ModelFactory::createModel('Key');
        $serviceModel = UPS_ModelFactory::createModel('Services');
        
        // Store username for logging
        $userInfo = $userModel->getUserInfoByKey($auth->apikey);
        $serviceName = get_class($this);
        
        $serviceId = $serviceModel->getServiceIdByClassName($serviceName);
        
        if(empty($userInfo))
             throw new SoapFault("Invalid Api Key!",401);
        
        if($userInfo['account'] != $auth->username
                ||$userInfo['password'] != md5($auth->password))
              throw new SoapFault("Invalid username or password! ",401);
        
        if(!$serviceModel->permissionExists($serviceId,$userInfo['category']))
        {
            $this->Logger= new UPS_Webservice_Logger($this->ApiKey,$this->ServiceId);
            $this->Logger->error("PermissionDeny");
            throw new SoapFault("Permission Deny",401);
        }
        $this->UserInfo = $userInfo;
        $this->ApiKey = $auth->apikey;
        $this->Authenticated = true;
        $this->ServiceName = $serviceName;
        
        $this->ServiceId =$serviceId;
        $this->Logger= new UPS_Webservice_Logger($this->ApiKey,$this->ServiceId);
        $this->Logger->info("[Servcie Call] {$this->ServiceName}");

    }
  

}
//END OF ServiceBase.php
