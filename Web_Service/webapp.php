<?php
  /**
      * UPS Project
      *
      *  分派適合的Controller
     * 
      *  這裡實作MVC model由這支為管理者功能的進入點，並設定環境變數
      *
      *  @author wewe0901
      */
    ini_set('display_errors',1);
   // error_reporting(E_ALL);
    error_reporting(E_ERROR | E_WARNING | E_PARSE); 
    require_once '../config.php';
    define('WEB_SERVICE_ROOT', dirname(__FILE__));
    //define('HOME_URL',$HOMEURL.'');
    define('HOME_URL',preg_replace('/\/$/','',$HOMEURL).preg_replace('/\/$/','',$WEBROOT));

    set_include_path( implode(PATH_SEPARATOR, array(
        WEB_SERVICE_ROOT.'/library',
        $HOME_PATH.$LIBRARY_PATH,
        get_include_path()
    )));
    
    global $DEBUG,$DB_DEBUG ;
    $DB_DEBUG = $DEBUG=true;
    
    require_once 'UPS/Application.php';
    $app =  new UPS_Application();
    $app->bootstrap()
            ->run();

// End of  Web_Service/webapp.php
