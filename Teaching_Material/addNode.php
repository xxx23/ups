<?php
/*******************************************************/
/*id: addNode.php v1.0 2007/3/6 hushpuppy Exp.*/
/*function: 教材系統的tree透過XHR呼叫本程式新增節點*/
/*******************************************************/

Header("Cache-Control: no-cache");
include "../config.php";
require_once("../session.php");
include "./lib/textbook_mgt_func.inc";
checkMenu("/Teaching_Material/textbook_manage.php");

$Content_cd = $_GET['content_cd'];
$link = null;
$id="";
$refid=$_GET['refid'];
//$Content_cd = $_GET['content_cd'];
$caption='New Node';
$icon="/script/nlstree/img/folder.gif";

//如為教師登入,直接取用session中的p_id
if($_SESSION['role_cd'] == 1){
   $Teacher_cd = $_SESSION['personal_id'];
}
//如為助教,要去找他的教師的p_id
elseif($_SESSION['role_cd'] == 2){
    $sql="SELECT teacher_cd from teach_aid where if_aid_teacher_cd = '{$_SESSION['personal_id']}'";
    $Teacher_cd = $DB_CONN->getOne($sql);
 }

//get max sort point.
  $id = get_max_menu_id();
	$url="tea_textbook_content.php?content_cd=".$Content_cd."&menu_id=".$id;

	$seq = ret_new_textbook_seq($refid, $Content_cd);
  	$sql="insert into class_content (content_cd, menu_id, menu_parentid, caption, file_name, url, exp, icon, seq) " .
    "values('" . $Content_cd . "', '" . $id . "', '" . $refid . "', '" . $caption. "', '". $caption ."','" . $url. "', '" 	. "0',' " . $icon . "','".$seq."')";
	

	$result = $DB_CONN->query($sql);
  	if(PEAR::isError($result))	die($result->getMessage());
	
	//建立相對應的資料夾
	
	$i = 0;
	//$array[$i++] = str_replace(" ","\ ",$caption);
	$array[$i++] = $caption;
	while($refid != 0){
		$sql = "select * from class_content where menu_id = $refid;";
		$result = $DB_CONN->query($sql);
		if(PEAR::isError($result))	die($result->getMessage());
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$array[$i] = $row['file_name'];  //空格部份取代為 "\ "
			//$array[$i] = str_replace(" ","\ ",$row['caption']);  //空格部份取代為 "\ "
		$refid = $row['menu_parentid'];
		$i++;
	}
	$path = $DATA_FILE_PATH;
	if( $path[strlen($path)-1] == '/');
	else
		$path = $path.'/';
	$path = $path.$Teacher_cd."/textbook/";

	for($j = $i-1 ; $j >= 0 ; $j--){
		$path .= $array[$j] ."/";
	}
	/*$handle = fopen("puppy", 'w');
	fwrite($handle, $path);*/
	//$path = str_replace(" ","\ ",$path);

	if(file_exists($path));
	else{
	  $old_umask = umask(0);
	  mkdir($path,0775);
	  umask($old_umask);
    }

?>
