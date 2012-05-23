<?php
/**
 *  Dispatcher用來分派工作給controller
 *
 * @author wewe0901
 */
class UPS_Application {
    
    const PREFIX = 'UPS_';
    const CONTROLLER_PATH = 'UPS/Controller';
   public function bootstrap()
   {
       
       return $this;
   }
   
   public function run()
   {
        //get controller and action name
        $controllerName = (isset($_GET['controller'])&&!empty($_GET['controller'])) ? $_GET['controller'] : "Index";
        $actionName = (isset($_GET['action'])&&!empty($_GET['action'])) ? $_GET['action'] : "index";

        $controllerClassName = self::PREFIX.'Controller_'.$controllerName;
        

       if(!file_exists(WEB_SERVICE_ROOT.'/library/UPS/Controller/'.$controllerName.'.php'))
           throw new Exception("Controller named {$controllerName} not exists!!\n");
         
        //load controller
        include self::CONTROLLER_PATH.'/'.$controllerName.'.php';
        $controller = new $controllerClassName();

        //check action
        if(!method_exists($controller, $actionName.'Action'))
            throw new Exception("Controller {$controllerName}'s action named {$actionName} not exists!!\n");

        call_user_func(array($controller,'handle'));
        return $this;
   }
}

?>
