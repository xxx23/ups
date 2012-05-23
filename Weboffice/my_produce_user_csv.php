<?php
/* 
2010.4.22 by w60292
這支程式用來產生 ups_user.csv
用來讓 mmc 同步與更新用
*/
ini_set('display_errors',1);
error_reporting(E_ALL);
 
require_once '../config.php';
//require_once 'my_rja_db_lib.php';

// modified by jfish 2010/09/21
require_once("../library/passwd.php");
// modified end
// ups 權限身份欄位說明
// register_basic	role_cd	int(2)	使用者權限 0:管理者 1:講師 2:助教 3:學生

$Q1 = "select * from register_basic as r, personal_basic as p where r.role_cd='1' and r.personal_id=p.personal_id";
$user_data = db_getAll($Q1);
//print_r($user_data);

$write_data = '';
foreach($user_data as $key => $value){

	#a trick , 所有陣列中的元素都會變成 local variable
	
	foreach($value as $k => $v) $$k = $v;

	// 人員編號|帳號|密碼|使用者權限|姓名|電子郵件信箱
	// 電子郵件信箱為MMC帳號，密碼沿用cyber2密碼
	// cyber2密碼為MD5加密 無法解碼回來！
    if($email != ""){
        // modified by jfish 2010/09/21 
        $pass = passwd_decrypt($pass);
        // modified end
		$write_data .=  $personal_id .'|'.
				$login_id .'|'.
				$pass .'|'.
				$role_cd .'|'.
				$personal_name .'|'.
				$email ."\n";
	}
}
//print_r($write_data);

$csvFile = 'ups_user.csv';
$res=file_put_contents( $csvFile, $write_data);
//var_dump($res);

//目前僅dump出教師帳號資料，如要進行帳號同步或更新，請將下一行註解掉 ex: //die;
//die;

//網址請更正為自己平台的網址
$mmcUrl = 'http://ups.moe.edu.tw/mmc/my_add_user.php?source=ups';
$remotePage = file_get_contents($mmcUrl);
print '----------';
print_r($remotePage);
unlink($csvFile);

/*?>
<?PHP


define('FILE_APPEND', 1);
function file_put_contents($n, $d, $flag = false) {
    $mode = ($flag == FILE_APPEND || strtoupper($flag) == 'FILE_APPEND') ? 'a' : 'w';
    $f = @fopen($n, $mode);
    if ($f === false) {
        return 0;
    } else {
        if (is_array($d)) $d = implode($d);
        $bytes_written = fwrite($f, $d);
        fclose($f);
        return $bytes_written;
    }
}
*/
?>
