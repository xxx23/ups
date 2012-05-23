<?php
/************************************************************************************/
/* id: tea_textbook_content.php 2007/3/6 by hushpuppy Exp.			    */
/* function: tea_loadTreeFromDB.php執行後，教師點選教材選項，將會呼叫本程式進行處理 */
/************************************************************************************/

include "../config.php";
require_once("../session.php");
require_once("./lib/textbook_func.inc");
require_once("../library/common.php");

checkMenu("/Teaching_Material/textbook_manage.php");

$option = $_POST['action'];
$Menu_id = $_GET['menu_id'];
//更新順序性
if(!isset($Menu_id)){
  $Menu_id_array = $_POST['menu_id_array'];
  $Seq_array = $_POST['seq_array'];
  update_seq($Menu_id_array, $Seq_array);
}
$Content_cd = $_GET['content_cd'];
$Begin_course_cd = $_SESSION['begin_course_cd'];

$Teacher_cd = getTeacherId(); //若非助教或老師則為零，中斷。
if($_SESSION['self_textbook'] == 0)
  $Teacher_cd = textbook($Begin_course_cd); //本課程所用的教材隸屬於哪位教師，取得那位教師的personal_id 

$path = $DATA_FILE_PATH.$Teacher_cd."/textbook/"; 

$smtpl = new Smarty;

if(isset($Content_cd) && isset($Menu_id)){	//按下樹狀結構時，以得到的值向session註冊
	$_SESSION['content_cd'] = $Content_cd;
	$_SESSION['menu_id'] = $Menu_id;
}
else{
	$Content_cd = $_SESSION['content_cd'];	//當按了上傳，回傳本頁，由session取得參數
	$Menu_id = $_SESSION['menu_id'];
}
//echo $_SESSION['current_path'] . "<br>";
assign_path($Menu_id, $smtpl);
//echo $_SESSION['current_path'] . "<br>";
/*
$current_path = $_SESSION['current_path'];
if(!is_dir($current_path)){
  $tok = strtok($current_path, "/");
      $k = 0;
      while ($tok !== false) {
	    $tmp[$k++] = $tok;
		$tok = strtok("/");
      }
      for($k = 0 ; $k < count($tmp)-1 ; $k++)
	    $n_Path = $n_Path."/".$tmp[$k];
      $current_path = $n_Path;
}
*/
if(!file_exists($current_path)){
  createPath($current_path);
  show_dirs($smtpl,$current_path, $Menu_id);
}
else
  show_dirs($smtpl,$current_path, $Menu_id);

//assign檔案路徑
$var = strlen($HOME_PATH);
$current_path = substr($current_path,$var,-1);

//$new_path = encodePATH($current_path);
$new_path = str_replace("+", "%20", $new_path);
$smtpl->assign("current_path",$new_path);
$smtpl->assign("menu_id",$Menu_id);

assignTemplate($smtpl, "/teaching_material/tea_node_seq_content.tpl");

function update_seq($Menu_id_array, $Seq_array){
  global $DB_CONN;
  $i = 0;
  if(empty($Menu_id_array))
  	return -1;
  foreach($Menu_id_array as $id){
    $seq = $Seq_array[$i];
    $sql = "update class_content set seq = '$seq' where menu_id = '$id'";
    $i++;
    $result = $DB_CONN->query($sql);
    if(PEAR::isError($result))	die($result->userinfo);
  }
}

function show_dirs($smtpl, $current_path, $Menu_id)
{
        global $DB_CONN, $path, $smtpl;
        //$smtpl->assign("test",$path);
        $Content_cd = $_SESSION['content_cd'];

	$sql = "select * from class_content where menu_parentid = '$Menu_id' order by seq,menu_id asc";
	$result = $DB_CONN->query($sql);
	if(PEAR::isError($result))	die($result->userinfo);
	
	while($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
		$smtpl->append("content2",$row);
	}
}
?>
