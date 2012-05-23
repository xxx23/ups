<?php
/*****************************************************/
/* id:redirect_file.php v1.0 2007/4/21 by hushpuppy  */
/* function: 讓WWW根目錄下可以存取，系統目錄下的檔案 */
/*****************************************************/

include "../config.php";
require_once("../session.php");

global $COURSE_FILE_PATH;

$Begin_course_cd = $_SESSION['begin_course_cd'];
$Homework_no = $_GET['h_no'];
$Group_no = $_GET['g_no'];
$file_dir = $COURSE_FILE_PATH."/".$Begin_course_cd."/homework/".$Homework_no."/student/".$Group_no."/";
$download = 1;	//1值為跳出下載視窗，0值為頁面上直接顯示

//濾掉不合法字元
/*if(strstr($file_name,"/") == true || strstr($file_name,"\\") == true || strstr($file_name,"*") == true ){
	echo "擋名包含不合法字元，請勿以身試法!!";
	exit(0);
}*/

//當按下html檔案時，會直接show在原頁面，其他的檔案會跳出下載視窗
//if(strstr($file_name,"html"))
//	$download = 0;

$d = dir($file_dir);
while(($file_name = $d->read()) != false){
    if (strcmp($file_name,".") == 0 || strcmp($file_name,"..") == 0)
      continue;
    if(substr($file_name, 0,7) == "result_"){
      break;
    }
}
//print "test:".$file_name;
$file_path = $file_dir.$file_name;
//print $file_path;
//$file_string = $file_dir.$file_name; // combine the path and file

// translate file name properly for Internet Explorer.
if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE")){
  $fileName = preg_replace('/\./', '%2e', $fileName, substr_count($fileName, '.') - 1);
}

//print $file_dir."<br/>";
//print $file_string;
// make sure the file exists before sending headers
if(!$fdl = @fopen($file_path,'r')){
    die("Cannot Open File!");
} else {
    header("Cache-Control: ");// leave blank to avoid IE errors
    header("Pragma: ");// leave blank to avoid IE errors
    header("Content-type: application/octet-stream; charset=utf-8");
	//if($download == 1) //下載或開啟與否
    header("Content-Disposition: attachment; filename=\"".urlencode($file_name)."\"");
    header("Content-length:".(string)(filesize($file_path)));
    fpassthru($fdl);

}

?>
