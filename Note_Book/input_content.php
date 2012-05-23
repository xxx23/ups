<?php
/************************************************************************************/
/* id: notebook_content.php 2007/9/29 by hushpuppy Exp. 			    			*/
/* function: notebook_loadTreeFromDB.php執行後，點選筆記選項，將會呼叫本程式進行處理 		*/
/************************************************************************************/

include "../config.php";
require_once("../session.php");
require_once("./lib/notebook_func.inc");
//require_once("./lib/learning_record.php");
//require_once("../library/time.php");

//checkMenu("/Teaching_Material/textbook_preview.php");

$Menu_id = $_GET['menu_id'];
$Notebook_cd = $_GET['notebook_cd'];
$Begin_course_cd = $_SESSION['begin_course_cd'];
$Personal_id = $_SESSION['personal_id'];

global $path;

/*沒分層前的寫法
 * $path = $PERSONAL_PATH.$Personal_id."/notebook/";
print $path;*/
//2011.09.25 joyce
$path = getPersonalPath($Personal_id) . "/notebook/";

$smtpl = new Smarty;

if(isset($Notebook_cd) && isset($Menu_id)){	//按下樹狀結構時，以得到的值向session註冊
	$_SESSION['notebook_cd'] = $Notebook_cd;
	$_SESSION['menu_id'] = $Menu_id;
}

assign_path($Menu_id, $smtpl);

$current_path = $_SESSION['current_nb_path'];
show_files($smtpl, $current_path);

//assign檔案路徑
$current_path = substr($current_path,9,-1);
$new_path = encodePATH($current_path);
$smtpl->assign("current_nb_path",$new_path);

$smtpl->assign("notebook_cd",$Notebook_cd);
$smtpl->assign("Personal_id",$Personal_id);
$smtpl->assign("Menu_id",$Menu_id);
assignTemplate($smtpl, "/note_book/input_content.tpl");
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
