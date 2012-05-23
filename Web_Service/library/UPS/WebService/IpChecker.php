<?php

/**
 * Description of class UPS_WebService_IpChecker
 * 負責確認使用者的IP使否允許使用WEBSERVICE
 *
 * @author wewe0901
 */
class UPS_WebService_IpChecker {
    
    /**
     * 輸入允許的IP 烈表 ex:  140.*,140.123.105.*; 或 *代表都允許
     * @param string $ipList
     * @return bool
     */
    public static function Check($ipList)
    {
        if(is_string($ipList))
            $ipList = UPS_WebService_IpChecker::parseIpStr($ipList);
        if(!is_array($ipList))
            return false;

        //testing that correct IP address used in order
        //to access admin area...
        for($i=0, $cnt=count($ipList); $i<$cnt; $i++) {
            $ipregex = preg_replace("/\./", "\.", $ipList[$i]);
            $ipregex = preg_replace("/\*/", ".*", $ipregex);

            if(preg_match('/^'.$ipregex.'/', $_SERVER[REMOTE_ADDR]))
                return true;
        }
        return false;

    }

    /**
     * 分解輸入的ip列表
     * @param string $ipString
     * @return array
     */
    public static function parseIpStr(string $ipString)
    {
        $result = array();
        $ipList = explode(",",$ipString);
        foreach($ipList as $ip)
        {
            $result[] = trim($ip);
        }
        return $result;
    }


}

//END OF IpChecker
