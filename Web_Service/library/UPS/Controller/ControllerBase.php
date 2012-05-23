<?php
    
require_once 'filter.php';
abstract class UPS_Controller_ControllerBase{
    
    private $defaultAction = 'index';
    private $view;
    private $_models=array();
    protected function setDefaultAction($name)
    {
        if(method_exists($this,$name.'Action'))
            $this->defaultAction=$name;
        else
            throw Exception("Error Action {$name}!!");
    }
    
    public function handle()
    {
        $this->init();
        if(isset($_GET['action'])
            && method_exists($this,$_GET['action'].'Action'))
        {
            $methodName = $_GET['action'].'Action';
        }
        else if(method_exists($this,$this->defaultAction.'Action'))
        {
            $methodName = $this->defaultAction.'Action';
        }
        else{
            throw new Exception("Error Action");
        }
        $this->loadView();
        call_user_func(array($this,$methodName));
    }
    
    private function loadView()
    {
        require_once 'UPS/View/SmartyView.php';
        $this->view = new UPS_View_SmartyView();
        $this->view->load();
    }
    
    protected function getModel($modelName)
    {
       if(!class_exists('UPS_ModelFactory'))
           require_once 'UPS/ModelFactory.php';
       return UPS_ModelFactory::createModel($modelName);
    }
    
    protected function getView()
    {
        return $this->view;
    }

    protected function _forward($actionName)
    {
        if(method_exists($this, $actionName.'Action'))
            call_user_method($actionName.'Action', $this);
        else
            die("Action $actionName Method Does not exists!");
        exit;
    }

    protected function _redirect($url)
    {
	header( "HTTP/1.1 301 Moved Permanently" );
	header( "Location: $url" );
	exit ;

    }
    public function isPost()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST')
            return true;
        else
            return false;
    }

    public function isGet()
    {
        if($_SERVER['REQUEST_METHOD']=='GET')
            return true;
        else 
            return false;
    }

    public function getParam($key,$type,$default='')
    {
        return optional_param($key,$default,$type); 
    }

    abstract public function init();
    abstract public function indexAction();
    


}

//END OF ControllerBase.php
