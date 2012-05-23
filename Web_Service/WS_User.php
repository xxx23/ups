<?php
     /**
      * UPS Project
      *
      *  WebService的使用者介面這部分會由Apply_course 課程管理系統呼叫
      *  這裡實作MVC model由這支維使用者功能的近點，並設定環境變數
      * 目前MVC的Model尚未實作Dispatcher
      * 也就是說目前不能由單一進入點呼叫每個 controller
      * 只能每個controller有一個進入點
      *
      *  @author wewe0901
      */

    ini_set('display_errors',1);
    error_reporting(E_ALL);

    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    require_once '../config.php';
    define('WEB_SERVICE_ROOT', dirname(__FILE__));
    define('HOME_URL',$HOMEURL.'');
    
    set_include_path( implode(PATH_SEPARATOR, array(
        WEB_SERVICE_ROOT.'/library',
        $HOME_PATH.$LIBRARY_PATH,
        get_include_path()
    )));

    require_once 'UPS/Controller/UserController.php';
    $upsWebService =  new UPS_Controller_UserController();
    $upsWebService->handle();
    exit;
?>
