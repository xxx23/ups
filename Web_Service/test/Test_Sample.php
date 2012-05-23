<?php
ini_set('display_errors',1);
ini_set("soap.wsdl_cache_enabled", 0);
error_reporting(E_ALL);
echo "Test SOAP Auth and service object<br/>";

$auth = array(
    'username' => 'wewe',
    'password' => 'wewe',
    'apikey' =>'0dfc78e3f8310f951ec0c686d7cb156e01df0f96'
);



echo 'Authentication information<br/>';
var_dump($auth);


// create authentication header values
$authvalues = new SoapVar($auth,SOAP_ENC_OBJECT);
var_dump($authvalues);
$uri = 'http://140.123.105.16/~q110185/ups/Web_Service/api.php';

$header = new SoapHeader($uri, 'authenticate', $authvalues,false);

$client = new SoapClient('http://140.123.105.16/~q110185/ups/Web_Service/api.php?wsdl&service=ServiceTest' ,array('cache_wsdl' => WSDL_CACHE_NONE));
$client->__setSoapHeaders(array($header));
$name = 'wewe';
try
{
    echo $client->test($name);
}
catch(SoapFault $e)
{
    echo $e;
}



?>
