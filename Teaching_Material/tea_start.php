<?php
/***********************************************************/
/* id: tea_start.php 2007/8/23 by hushpuppy Exp.		   */
/* function: 教材導覽 教師頁面							   */
/***********************************************************/

include "../config.php";
require_once("../session.php");
require_once("./lib/textbook_func.inc");
require_once("./lib/textbook_mgt_func.inc");
checkMenu("/Teaching_Material/textbook_manage.php");

global $path;

$Content_cd = $_GET['content_cd'];
if(!isset($Content_cd))
  $Content_cd = $_POST['content_cd'];
$option = $_POST['action'];

$smtpl = new Smarty;

$Teacher_cd = getTeacherId();
$path = $DATA_FILE_PATH.$Teacher_cd."/textbook/";

$content_name = returnContentName($Content_cd);
$content_file_name = returnContentFileName($Content_cd);
//<
$path .=$content_file_name."/";

if($option == "index"){		//編輯index.html
        //file_type 可能為 0 , 1 , 2 分別代表index.html index.htm index.swf
        $file_type = $_POST['index_show'];
	edit_index($Content_cd,$file_type);
}
show($smtpl, $path);

$new_path = str_replace($HOME_PATH, "/", $path);
#$new_path = $WEBROOT . $path;
//暫時拿掉
//$new_path = encodePATH($new_path);

$smtpl->assign("current_path",$WEBROOT . $new_path);
$smtpl->assign("content_cd",$Content_cd);
assignTemplate($smtpl, "/teaching_material/tea_start.tpl");

function show($smtpl, $path)
{
     $file_path1 = $path."index.html";
     $file_path2 = $path."index.htm";
     $file_path3 = $path."index.swf";
     
     $index_exist1 = false;
     $index_exist2 = false;
     $index_exist3 = false;

     if(file_exists($file_path1))
            $index_exist1 = true;
     if(file_exists($file_path2))
	    $index_exist2 = true;
     if(file_exists($file_path3))
	    $index_exist3 = true;


     if($index_exist1 == false && $index_exist2 == false && $index_exist3 == false)
        $smtpl->assign("index_show",0); //預覽時顯示檔案list
     else{
       if($index_exist1 == true){
            $handle = fopen($file_path1, "r");  //開啟index.html並將內容塞回textarea
            $smtpl->assign("index_show",1);     //預覽時顯示index.html
        }
       else if($index_exist2 == true){
            $handle = fopen($file_path2, "r");
            $smtpl->assign("index_show",2);     //預覽時顯示index.htm
       }

       else if($index_exist3 == true){
            $handle = fopen($file_path3, "r");
            $smtpl->assign("index_show",3);     //預覽時顯示index.swf
        }
        $index_content = fread($handle, 65535);
        $smtpl->assign("index_content",$index_content);
	}
}


?>
