<?php
require_once 'UPS/Controller/ControllerBase.php';

/**
 * websercie的使用者介面
 */
class UPS_Controller_UserController extends UPS_Controller_ControllerBase
{
    /**
     *
     * @var UPS_Model_Services
     */
    protected $servicesModel;

    /**
     *
     * @var UPS_Model_Key
     */
    protected $keyModel;

    /**
     *  load 需要用的Model
     * 確認使用者是否登入
     * @global string $WEBROOT
     */
    public function init()
    {
        require_once 'UPS/Model/Services.php';
        require_once 'UPS/Model/Key.php';
        require_once 'UPS/Auth/ApplyCourse.php';
        global $WEBROOT;
        if(!UPS_Auth_ApplyCourse::getInstance()->hasIdentity())
            $this->_redirect($WEBROOT.'Apply_Course/login.php');

        $this->servicesModel = new UPS_Model_Services();
        $this->keyModel = new UPS_Model_Key();
    }

    /**
     *  APIKEY管理
     */
    public function indexAction()
    {
        
        $user = UPS_Auth_ApplyCourse::getInstance()->getIdentity();
        $errors =array();
        if($this->isPost())
        {   
            $usage = $this->getParam('usage',PARAM_TEXT,'');
            if(empty($usage))
                $errors['usage'] = true;
            if(empty($errors))
                $this->keyModel->createKey($user->no,'*',$usage);  
        }
        
        if($this->keyModel->hasKey($user->no))
        {
            $info = $this->keyModel->getKeyInfo($user->no);
            $apiKey = $info['api_key'];
            $status = $info['status'];
        }  
        else
        {
           $apiKey = ''; 
        }
        $this->getView()->assign('errors',$errors);
        $this->getView()->assign('status',$status); 
        $this->getView()->assign('apiKey',$apiKey);
        $this->getView()->assign('category',$user->category);
        $this->getView()->display('/web_service/getKey.tpl');
    }

    /**
     *申請APIKEY
     */
    public function requestKeyAction()
    {
        $user = UPS_Auth_ApplyCourse::getInstance()->getIdentity();
        if($this->isPost())
        {
            $usage = $this->getParam('usage',PARAM_TEXT,'');
            $this->KeyModel->createKey($user->no,'*',$usage);  
        }
        
        $this->_redirect('?action=index'); 

    }

    /**
     * webservcie 描述
     */
    public function serviceSummaryAction()
    {
        $user = UPS_Auth_ApplyCourse::getInstance()->getIdentity();
        $services = $this->servicesModel->getActiveServices($user->category);
        $keyInfo = $this->keyModel->getKeyInfo($user->no);

        if(!empty($keyInfo) 
            && $keyInfo['status']==1)
            $apikey = $keyInfo['api_key'];
        else
            $apikey = 'YOUR_API_KEY';
        $this->getView()->assign('apikey',$apikey);
        $this->getView()->assign('services',$services);
        $this->getView()->display('/web_service/serviceSummary.tpl');
    }

}

//END OF UserController.php
