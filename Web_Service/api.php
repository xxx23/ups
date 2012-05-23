<?php
    /**
     * UPS Project
     *
     *  這支程式主要為webService的進入點所有web service的使用都透過這支
     * 主要的任務為設定程式執行的環境 library的path參數等
     * call  UPS_WebService_Invoker處理使用者輸入與呼叫對應的service
     * [注意]
     * 由於需要產生通訊的XML檔所以請注意所有include來的檔<?php之前都不可以有空白行
     * ?>之後也不可以有最好把?>去掉以檔案結尾作為PHP 的結
     * 
     * @author wewe0901
     */

   /**
    * 利用output buffer操作 ob_start() ob_get_clean()trim()來避免XML前有不必要得輸出
    */
ini_set('display_errors',1);
error_reporting(E_ERROR | E_WARNING | E_PARSE); 
    ob_start();

    require_once '../config.php';
    define('WEB_SERVICE_ROOT', dirname(__FILE__));
    define('HOME_URL',$HOMEURL.'');
    
    set_include_path( implode(PATH_SEPARATOR, array(
        WEB_SERVICE_ROOT.'/library',
       $HOME_PATH.$LIBRARY_PATH,
        get_include_path()
    )));
                
    require_once 'UPS/WebService/Invoker.php';
    $upsWebService =  new UPS_WebService_Invoker(WEB_SERVICE_ROOT.'/SoapServers');
    $upsWebService->handle();
    //end output capture and trim the output
    $output = ob_get_clean();
    echo trim($output);
//END OF api.php
