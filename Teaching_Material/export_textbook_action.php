<?php
/****************************************************************************************/
/*id: export_textbook_action.php v1.0 2007/11/24 by hushpuppy Exp. 			*/
/*description: 教師匯出教材選項, 選非同步匯出，將會由本程式接收XHR，並執行匯出的動作。  */
/* 本程式沒有放在./ajax/目錄的原因為引用./scorm/目錄的套件會有路徑問題。 		*/
/****************************************************************************************/

include "../config.php";
require_once("../session.php");
require_once("./scorm/export_xml.inc");
require_once("./scorm/export_SCORM12.inc");
require_once("./scorm/export_SCORM2004.inc");
require_once("./scorm/export_dump.inc");


global $DATA_FILE_PATH, $smtpl, $tpl_path, $Content_cd;

$Content_cd = $_GET['content_cd'];
$Export_option = $_GET['export_option'];
$del_option = $_GET['del_option'];

//刪除教材備份


if(isset($Content_cd))
          $_SESSION['content_cd'] = $Content_cd;
else
          $Content_cd = $_SESSION['content_cd'];


$sql = "select teacher_cd from course_content where content_cd = '$Content_cd'";
$Teacher_cd = db_getOne($sql);
//由教材編號取得教材名稱

$sql = "select file_name from class_content where content_cd = '$Content_cd' and menu_parentid='0'";
$Content_name = db_getOne($sql);

//如果是.zip的scorm教材$Content_name
if(!isset($Content_name))
{
    $sql="select content_name from course_content where content_cd='$Content_cd'";
    $Content_name=db_getOne($sql);
}

//$Content_name = $DB_CONN->getOne($sql);
//if(PEAR::isError($Content_name))        die($Content_name->userinfo);

//刪除教材備份
if(isset($del_option)){
  del_export_file($Content_name,$del_option);
}


function del_export_file($content_name,$del_option){
    global $DATA_FILE_PATH;

    $Content_cd = $_GET['content_cd'];

    if(isset($content_name)){
        if($del_option == 1)
            $cmd = "rm {$DATA_FILE_PATH}/{$_SESSION['personal_id']}/export_data/{$content_name}.rar";
        else if($del_option == 2)
            $cmd = "rm {$DATA_FILE_PATH}/{$_SESSION['personal_id']}/export_data/{$content_name}_scorm_12.rar";
        else if($del_option == 3)
            $cmd = "rm {$DATA_FILE_PATH}/{$_SESSION['personal_id']}/export_data/{$content_name}_scorm_2004.rar";
        system_log($cmd);
        exec($cmd);

    }
}
?>
