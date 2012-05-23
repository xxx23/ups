<?php


/**
 * Description of UPS_Webservice_ApiKeyGenerator
 * 根據使用者id產生APIKEY
 * Please keep in mind that there is no security in API keys. It's just a name assigned to your API application.
 *  More and more people are using terms like "App ID" or "Dev ID" to reflect what it really is. You have to assign
 *  another secret key if you want secure your protocol, like consumer_key/consumer_secret in OAuth
 *
 * @author wewe0901
 */
class UPS_WebService_ApiKeyGenerator {
    //put your code here
    const API_KEY_SALT = "UPS_WEB_SERVICE";
    public function  __construct() {
        ;
    }

    /**
     *
     * shar1(salt + time +mac-addr +another salt + someother random data)
     *  or Base62(MD5-HMAC(key,Normalize(referr))).
     * @param int $personal_id
     */
    public function generate($personal_id)
    {
        $time = sprintf("%d",time());
        $api_key = sha1(self::API_KEY_SALT.$personal_id.$time);

        //$keyModel->save(array("key"=>$api_key,"personal_id"=>$personal_id));
        return $api_key;
    }

    public function isValid($key)
    {

    }
}
// end of ApliKeyGenerator.php
