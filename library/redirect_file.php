<?php
/*****************************************************/
/* id:redirect_file.php v1.0 2007/4/21 by hushpuppy  */
/* function: 讓WWW根目錄下可以存取，系統目錄下的檔案 */
/*****************************************************/

include "../config.php";
require_once("../session.php");

//ini_set("memory_limit","4G");

$file_dir = $_SESSION['current_path']; // supply a path name.
$file_name = $_GET['file_name']; // supply a file name.
$download = 1;	//1值為跳出下載視窗，0值為頁面上直接顯示


//濾掉不合法字元
if(strstr($file_name,"/") == true || strstr($file_name,"\\") == true || strstr($file_name,"*") == true ){
	echo "檔名包含不合法字元，請勿以身試法!!";
	exit(0);
}

//當按下html檔案時，會直接show在原頁面，其他的檔案會跳出下載視窗
//if(strstr($file_name,"html"))
//	$download = 0;

$file_string = $file_dir.$file_name; // combine the path and file

// translate file name properly for Internet Explorer.
if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE")){
  $fileName = preg_replace('/\./', '%2e', $fileName, substr_count($fileName, '.') - 1);
}

//print $file_dir."<br/>";
//print $file_string;
// make sure the file exists before sending headers
//$file_string = encodePATH($file_string);


if(!$fdl = fopen($file_string,'r')){
    die("Cannot Open File!");
} else {
    header("Cache-Control: ");// leave blank to avoid IE errors
    header("Pragma: ");// leave blank to avoid IE errors
    header("Content-type: application/octet-stream; charset=utf-8");
	//if($download == 1) //下載或開啟與否
	    header("Content-Disposition: attachment; filename=\"".urlencode($file_name)."\"");
    header("Content-length:".(string)(filesize($file_string)));
    //fpassthru($fdl);
       ob_end_flush();
       @readfile($file_string);
          exit;
}
?>
