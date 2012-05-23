<?php
require_once 'UPS/Controller/ControllerBase.php';

/**
 * 管理者介面的Controller 實作 MVC Model中的 Controller
 */
class UPS_Controller_AdminController extends UPS_Controller_ControllerBase
{
    /**
     *
     * @var UPS_Model_Services
     */
    public $servicesModel;

    /**
     *
     * @var UPS_Model_WSLog
     */
    public $logModel;

    /**
     *
     * @var UPS_Model_ApiKeyUser
     */
    public $userModel;

    /**
     *
     * @var UPS_Model_Key
     */
    public $keyModel;

    /**
     *  load 需要用的Model
     * 確認使用者是否登入
     * @global string $WEBROOT
     */
    public function init()
    {
        require_once 'UPS/Auth/ApplyCourse.php';
        require_once 'UPS/Model/Services.php';
        require_once 'UPS/Model/WSLog.php';
        require_once 'UPS/Model/ApiKeyUser.php';
        require_once 'UPS/Model/Key.php';
        global $WEBROOT;
        if(!UPS_Auth_ApplyCourse::getInstance()->hasIdentity())
            $this->_redirect($WEBROOT.'Apply_Course/login.php');

        $this->servicesModel = new UPS_Model_Services();
        $this->logModel = new UPS_Model_WSLog();
        $this->userModel = new UPS_Model_ApiKeyUser();
        $this->keyModel = new UPS_Model_Key();
    }
    /**
     *  等待管理者審核的使用者APIKey列表
     */
    public function indexAction()
    {
        $users = $this->userModel->getWaitKeys();
        $this->getView()->assign('users',$users);
        $this->getView()->display('/web_service/waitKey.tpl');
    }

    /**
     *  API key審核通過並啟用該apiKEY
     */
    public function activeKeyAction()
    {
        $user_id = $this->getParam('user_id',PARAM_INT,0);
        $api_key = $this->getParam('api_key',PARAM_TEXT,'');

        if(!empty($user_id)&&!empty($api_key))
        {
            $this->keyModel->save(array(
                'user_id'=>$user_id,
                'api_key'=>$api_key,
                'status'=>UPS_Model_Key::KEY_STATUS_OK
            ));
        }
        $this->_redirect('?action=index');
    }

    /**
     * 審核不通過並刪除APIKey 並send mail通知
     */
    public function deactiveKeyAction()
    {
        $user_id = $this->getParam('user_id',PARAM_INT,0);
        $api_key = $this->getParam('api_key',PARAM_TEXT,'');
        $reason = $this->getParam('reason',PARAM_TEXT,''); 
        $errors=array();
        if($this->isPost())
        {
            if(!empty($user_id)&&!empty($api_key))
            {
                if(empty($reason))
                    $errors['reason']=true;
                if(empty($errors)){
                    $userInfo = $this->userModel->getUserInfo($user_id);
                    if(!empty($userInfo) &&!empty($userInfo['email']))
                    {    
                        //TODO:Notify User by email
                        $reason;
                    }
                    $this->keyModel->delete("user_id ={$user_id} AND api_key='{$api_key}'");
                    $this->_redirect('?action=index'); 
                }
            }
        }
        $this->getView()->assign('errors',$errors);
        $this->getView()->assign('user_id',$user_id);
        $this->getView()->assign('api_key',$api_key);
        $this->getView()->assign('reason',$reason);
        $this->getView()->display('/web_service/deactiveKey.tpl');
    }
    /**
     * Web Service列表
     */
    public function serviceListAction()
    {
        $services = $this->servicesModel->getServices();
        $this->getView()->assign('services',$services);
        $this->getView()->display('/web_service/serviceList.tpl');
    }
    
    /**
     * 刪除web Service
     */
    public function removeServiceAction()
    {
        $service_id = $this->getParam('id',PARAM_INT,0);
        
        if($this->servicesModel->serviceExists($service_id))
        {
            $this->servicesModel->deleteService($service_id);
        }
        $this->_redirect('?action=serviceList');
    }

    /**
     * 開放webservice
     */
    public function activeServiceAction()
    {

        $id = $this->getParam('id',PARAM_INT,0);
        if(empty($id))
            die("錯誤的服務");
        $this->servicesModel->saveService(array(
            'id'=>$id,
            'status'=>1
        )); 
        $this->_redirect('?action=serviceList');
    }
    /**
     *  關閉web service
     */
    public function deactiveServiceAction()
    {

        $id = $this->getParam('id',PARAM_INT,0);
        if(empty($id))
            die("錯誤的服務");

        $this->servicesModel->saveService(array(
            'id'=>$id,
            'status'=>0
        ));

        $this->_redirect('?action=serviceList');
    }

    /**
     *  查詢使用者
     */
    public function browseUserAction()
    {
        $account = $this->getParam('account',PARAM_TEXT,'');
        $category = $this->getParam('category',PARAM_INT,0);
        $where = array();
        if(!empty($account))
            $where['account'] = $account;
        if($category != 0)
            $where['category'] = $category;

        $users = $this->userModel->getUsers($where);
        $categories = $this->userModel->getCategories();
        $this->getView()->assign('search_name',$account);
        $this->getView()->assign('category_sel',$category);
        $this->getView()->assign('category_keys',$categories['keys']);
        $this->getView()->assign('category_values',$categories['values']);
        $this->getView()->assign('users',$users);
        $this->getView()->display('/web_service/browseUser.tpl');     
    }

    /**
     * 查閱使用者 使用webservice的記錄
     */
    public function browseUserLogAction()
    {
        $apiKey = $this->getParam('api_key',PARAM_TEXT,'');
        $service = $this->getParam('service',PARAM_INT,0);
        $level = $this->getParam('level',PARAM_TEXT,'');
        $start = $this->getParam('start',PARAM_TEXT,'');
        $end = $this->getParam('end',PARAM_TEXT,'');

        $services = $this->servicesModel->getServicesSelect();
        
        $logs = $this->logModel->getLogs(array(
            'service_id'=>$service,
            'api_key'=>$apiKey,
            'level'=>$level,
            'start'=>$start,
            'end'=>$end,
            'name'=>$name
        ));
        $this->getView()->assign('levels_sel',$level);
        $this->getView()->assign('levels',$this->logModel->getLevels());
        $this->getView()->assign('services_sel',$service);
        $this->getView()->assign('services_outputs',$services['values']);
        $this->getView()->assign('services_values',$services['keys']);
        $this->getView()->assign('logs',$logs);
        $this->getView()->display('/web_service/browseUserLog.tpl');

    }

    /**
     * 編輯webservice詳細資訊
     */
    public function serviceDetailAction()
    {
        $service_id = $this->getParam('id',PARAM_INT,0);
        $service = array();
        $errors = array();
        if(!empty($service_id))
        {
            $services = $this->servicesModel->getServices(array('id'=>$service_id));
            $service = (!empty($services)) ? $services[0] : array();
        }
        if($this->isPost())
        {

            $name = $this->getParam('name',PARAM_TEXT,'');
            $class = $this->getParam('class',PARAM_TEXT,'');
            $description = $this->getParam('description',PARAM_RAW,'');
            //  die;
            $service = array(
                'id'=>$service_id,
                'name'=>$name,
                'class'=>$class,
                'description'=>$description
            );
            if(empty($name))
                $error['name'] = true;    
            if(empty($class))
                $error['class'] = true;

            if(empty($error))
            {
                $this->servicesModel->saveService($service);
                $this->getView()->assign('saved',true);
            }
        }
        $this->getView()->assign('service',$service);
        $this->getView()->assign('error',$error);
        $this->getView()->display('/web_service/serviceDetail.tpl'); 
    }
    /**
     * 管理web service的使用權限 EX:哪個身分可以使用
     */
    public function servicePermissionAction()
    {
        $permissionTable = $this->servicesModel->getPermissions();
        $services = $this->servicesModel->getServicesSelect();
        $categories = $this->userModel->getCategories();
        $permissions = array();
        
        foreach($services['keys'] as $service_id)
        {
            foreach($categories['keys'] as $category)
            {
                if($category=="0")
                    continue;
                if(isset($permissionTable[$service_id])
                    && in_array($category,$permissionTable[$service_id]))
                    $permissions[$service_id][$category] = 1;
                else
                    $permissions[$service_id][$category] = 0;

            }
        }
        
        if($this->isPost())
        {
            $permissionsPost = $this->getParam('permissions',PARAM_RAW,'');
            foreach($permissions as $service_id=>$category_list)
            {
                foreach($category_list as $category=>$permission)
                {
                    $permissionPost = (isset($permissionsPost[$service_id][$category]))
                                        ?$permissionsPost[$service_id][$category] 
                                        : 0;
                    if($permissionPost != $permissions[$service_id][$category])
                    {
                        if($permissionPost == 1)
                        {
                            $this->servicesModel->addPermission($service_id,$category);
                        }
                        elseif($permissionPost ==0)
                        {
                            $this->servicesModel->removePermission($service_id,$category);
                        }
                        $permissions[$service_id][$category] = $permissionPost;
                    }
                }
            }
            $this->getView()->assign('saved',true);

        }
        
        $categories['values'][0]='';
        $this->getView()->assign('services',$services['values']);
        $this->getView()->assign('categories',$categories['values']);
        $this->getView()->assign('permissions',$permissions);
        $this->getView()->display('/web_service/servicePermission.tpl');
    }
    
}


//END OF AdminController.php
