<?php
require_once 'UPS/WebService/ServiceBase.php';
/**
 * Description of ServiceTest
 *
 * @author wewe0901
 */
class ServiceTest extends UPS_WebService_ServiceBase {

    /**
     * 
     * TESTIT
     * 
     * @param string 
     * @return string
     */
    public function test($name)
    {
        return "Hi {$name} you are authenticated and using service";
    }

}
//END OF ServiceTest.php
