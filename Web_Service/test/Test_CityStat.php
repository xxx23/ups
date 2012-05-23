<?php

ini_set('display_errors',1);
error_reporting(E_ALL);
ini_set("soap.wsdl_cache_enabled", 0);

//輸入認證的資訊 包含 username(帳號)、password(密碼)、apikey (平台核發的apikey)
$auth = array(
    'username' => 'wewe',
    'password' => 'wewe',
    'apikey' =>'909bfc3cf3c84d41db214a9d5ced5ac4c1de1515'
);

// 產生認證的header
$authvalues = new SoapVar($auth,SOAP_ENC_OBJECT);
$header = new SoapHeader('UPS_MOE', 'authenticate', $authvalues,false);

//連線到ups的webservice
$client = new SoapClient('http://ups.moe.edu.tw/Web_Service/api.php?wsdl&service=CityStat' ,array('cache_wsdl' => WSDL_CACHE_NONE));
$client->__setSoapHeaders(array($header));

try
{
   //讀取資料
   $datas = $client->getStatData('','','',-1,1);
   $header = array('姓名','教師證號','服務學校','課程名稱','課程類別','通過與否','通過時間','取得認證時數');
   $utf8_str =implode("\t",$header).PHP_EOL;
   foreach($datas as $row)
   {
       $utf8_str .= implode("\t",$row).PHP_EOL;
   }
   
   //使用excel讀得懂的UTF-16LE格式
    header("Content-type: application/vnd.ms-excel; charset=UTF-16LE");
    header("Content-Disposition: attachment; filename=".urlencode('查詢報表').".csv");
    header("Pragma: no-cache");
    header("Expires: 0");
    echo chr(255).chr(254).mb_convert_encoding( $utf8_str, 'UTF-16LE', 'UTF-8'); 
}
catch(SoapFault $e)
{
    echo $e;
}

?>
