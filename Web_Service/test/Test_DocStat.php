<?php

ini_set("soap.wsdl_cache_enabled", 0);

//輸入認證的資訊 包含 username(帳號)、password(密碼)、apikey (平台核發的apikey)
$auth = array(
    'username' => 'adv046',
    'password' => 'adv046',
    'apikey' =>'fd5c168ed102f9d84f85b52fdd911ba140c8f87d'
);

// 產生認證的header
$authvalues = new SoapVar($auth,SOAP_ENC_OBJECT);
$header = new SoapHeader('UPS_MOE', 'authenticate', $authvalues,false);

//連線到ups的webservice
$client = new SoapClient('http://ups.moe.edu.tw/Web_Service/api.php?wsdl&service=DocStat' ,array('cache_wsdl' => WSDL_CACHE_NONE));
$client->__setSoapHeaders(array($header));

try
{
   //讀取總計資料
   $summary_datas = $client->getStatDataSummary('','');
   
   //總計資料的表頭
   $summary_head = array( '新住民(男)','新住民(女)','婦女','銀髮族(男)','銀髮族(女)','勞工(男)','勞工(女)');
   $utf8_str =implode("\t",$summary_head).PHP_EOL;
   $utf8_str .= implode("\t",$summary_datas).PHP_EOL;
   $utf8_str .= PHP_EOL;
   
   //讀取細項資料
   $datas = $client->getStatData('','');
   
    //細項資料的表頭
   $head =  array('縣市','所屬DOC','課程屬性','課程名稱','新住民(男)','新住民(女)','婦女','銀髮族(男)','銀髮族(女)','勞工(男)','勞工(女)');
   $utf8_str .=implode("\t",$head).PHP_EOL;
   foreach($datas as $row)
   {
       $utf8_str .= implode("\t",$row).PHP_EOL;
   }

   //使用excel讀得懂的UTF-16LE格式輸出
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
