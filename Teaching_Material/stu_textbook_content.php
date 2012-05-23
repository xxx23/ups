<?php
/************************************************************************************/
/* id: tea_textbook_content.php 2007/3/6 by hushpuppy Exp. 			    */
/* function: tea_loadTreeFromDB.php執行後，教師點選教材選項，將會呼叫本程式進行處理 */
/************************************************************************************/

include "../config.php";
require_once("../session.php");
require_once("./lib/textbook_func.inc");
require_once("./lib/learning_record.php");
require_once("../library/time.php");

if( $_SESSION['role_cd'] !=4 )
	checkMenu("/Teaching_Material/textbook_preview.php");

$option = $_POST['action'];
$Menu_id = $_GET['menu_id'];
$Content_cd = $_GET['content_cd'];
$Begin_course_cd = $_SESSION['begin_course_cd'];
$Personal_id = $_SESSION['personal_id'];
$Frame  = $_GET['frame'];

$textbook_master = textbook($Begin_course_cd);
$Teacher_cd = $textbook_master;

global $path;
$path = $DATA_FILE_PATH.$Teacher_cd."/textbook/";
//print $path;

$smtpl = new Smarty;

if(isset($Content_cd) && isset($Menu_id)){	//按下樹狀結構時，以得到的值向session註冊
	learning_status($Content_cd, $Menu_id, $Personal_id);
	$_SESSION['content_cd'] = $Content_cd;
	$_SESSION['menu_id'] = $Menu_id;
}
//將caption 以及file_name串起來,且將current_path放入session
//echo "($_SESSION[current_path])<br><br>";
assign_path($Menu_id, $smtpl);
//echo "($_SESSION[current_path])";


$Script_path = $WEBROOT.$JAVASCRIPT_PATH ;
$smtpl->assign("script_path",$Script_path);
$current_path = $_SESSION['current_path'];

//看current_path
show_files($smtpl, $current_path);
//assign檔案路徑

$var = strlen($HOME_PATH);
//modify 
$current_path = substr($current_path,$var,strlen($current_path));
//print $current_path;
$new_path = encodePATH($current_path);
$new_path = str_replace("+", "%20", $new_path);
$new_path = ltrim($new_path,'/');
//echo "stu current_path:".rtrim($WEBROOT.$new_path,'/')."<br>";
$smtpl->assign("current_path",rtrim($WEBROOT.$new_path,'/'));
//print $new_path;
$smtpl->assign("Content_cd",$Content_cd);
$smtpl->assign("Personal_id",$Personal_id);
$smtpl->assign("Menu_id",$Menu_id);
$smtpl->assign("Begin_course_cd",$Begin_course_cd);
$smtpl->assign("Frame",$Frame);

assignTemplate($smtpl,"/teaching_material/stu_textbook_content.tpl");

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
