<?php
/************************************************************************************/
/* id: tea_textbook_content.php 2007/3/6 by hushpuppy Exp.			    */
/* function: tea_loadTreeFromDB.php執行後，教師點選教材選項，將會呼叫本程式進行處理 */
/************************************************************************************/

include "../config.php";
require_once("../session.php");
require_once("./lib/textbook_func.inc");
checkMenu("/Teaching_Material/textbook_manage.php");
$option = $_POST['action'];
$Menu_id = $_GET['menu_id'];
$Content_cd = $_GET['content_cd'];
$Begin_course_cd = $_SESSION['begin_course_cd'];

$Teacher_cd = getTeacherId(); //若非助教或老師則為零，中斷。
if($_SESSION['self_textbook'] == 0)
  $Teacher_cd = textbook($Begin_course_cd); //本課程所用的教材隸屬於哪位教師，取得那位教師的personal_id 

$path = $DATA_FILE_PATH.$Teacher_cd."/textbook/"; 

//$path = $DATA_FILE_PATH.getTeacherId()."/textbook/";
$smtpl = new Smarty;

if(isset($Content_cd) && isset($Menu_id)){	//按下樹狀結構時，以得到的值向session註冊
	$_SESSION['content_cd'] = $Content_cd;
	$_SESSION['menu_id'] = $Menu_id;
}
else{
	$Content_cd = $_SESSION['content_cd'];	//當按了上傳，回傳本頁，由session取得參數
	$Menu_id = $_SESSION['menu_id'];
}

assign_path($Menu_id, $smtpl);
// 將現在menu_id對應的實體路徑放到 current_path 

$smtpl->assign("script_path",$Script_path);

if($option == "upload"){	//上傳檔案
    if(!is_dir($path)){
       $path = removetail($path)."/";
       $_SESSION['current_path'] = $path;//除去尾巴ccc.xcv
    }
	multiupload(new_file,$path,$Content_cd);
}
if($option == "index"){		//編輯index.html
	edit_index($Content_cd);
}
//刪除檔案
$delete = $_GET['delete'];
if($delete == true){
	$delete_no = $_GET['no'];
	delete_file($delete_no);
}

$current_path = $_SESSION['current_path'];
if(!file_exists($current_path)){
  //createPath($current_path); //檔案不存在先不建立path
  show_files($smtpl,$current_path);
}
else{
  show_files($smtpl,$current_path);
}

$Script_path = $WEBROOT . $JAVASCRIPT_PATH ;
//assign檔案路徑
$var = strlen($HOME_PATH);
$current_path = substr($current_path,$var,strlen($current_path));

$new_path = encodePATH($current_path);
$new_path = str_replace("+", "%20", $new_path);
$new_path = ltrim($new_path,'/');

//echo "tea current_path:$current_path <br>";
$smtpl->assign("current_path", rtrim( $WEBROOT . $new_path , '/' ));
//echo $_SESSION['current_path'];
if(!file_exists($_SESSION['current_path'])){
   echo "<font color='red'>此目錄不可以編輯</font>";
}else{
   assignTemplate($smtpl, "/teaching_material/tea_textbook_content.tpl");
}
function encodePATH($Path)
{
    $tok = strtok($Path, "/");
      $string = "/";
      while ($tok !== false) {
	    $str = URLENCODE($tok);
	        $tok = strtok("/");
	        $string = $string.$str."/";
		  }
        return $string;
}

?>
