<?php
/* id: saveNodeCaption.php v2.0 2007/4/30 by hushpuppy */
/* function: 當tree node更新描述時，由xmlHttp傳回給此檔更新資料庫*/

Header("Cache-Control: no-cache");
mb_internal_encoding("UTF-8"); 
include "../config.php";
require_once("../session.php");

checkMenu("/Teaching_Material/textbook_manage.php");

$nodeId = $_GET['nid'];
$capt = $_GET['caption'];
$prnId = $_GET['prn'];

//如為教師登入,直接取用session中的p_id
if($_SESSION['role_cd'] == 1){
   $Teacher_cd = $_SESSION['personal_id'];
}
//如為助教,要去找他的教師的p_id
elseif($_SESSION['role_cd'] == 2){
    $sql="SELECT teacher_cd from teach_aid where if_aid_teacher_cd = '{$_SESSION['personal_id']}'";
    $Teacher_cd = $DB_CONN->getOne($sql);
 }

//錯誤偵測，同一個parent id下的node若有重複名稱(caption)則傳回-1
$sql = "select caption from class_content where menu_id = '$nodeId'";
$old_caption = $DB_CONN->getOne($sql);
if(PEAR::isError($old_caption))	die($old_caption->userinfo);
 
$sql = "select menu_parentid from class_content where menu_id = '$nodeId'";
$prnId = $DB_CONN->getOne($sql);
if(PEAR::isError($prnId))	die($prnId->userinfo);

$sql = "select * from class_content where menu_parentid = '$prnId'";
$result = $DB_CONN->query($sql);
while($row = $result->fetchRow(DB_FETCHMODE_ASSOC)){
	if($row['caption'] == $capt){
		print "-1;".$old_caption;
		return ;
	}
}

//更改了tree node的caption之後假使名稱為file_name名稱為New Node就去rename實際目錄名稱
$sql = "select file_name from class_content where menu_id = '$nodeId'";
$F_name = $DB_CONN->getOne($sql);
//file_put_contents("123",$F_name);

if($F_name == "New Node"){
$old_path = $DATA_FILE_PATH.$Teacher_cd."/textbook/";
$new_path = $DATA_FILE_PATH.$Teacher_cd."/textbook/";

$i = 0;
//$array[$i++]= $caption;
$tmp_id = $nodeId;
while($tmp_id != 0){
	$sql = "select * from class_content where menu_id = $tmp_id;";
	$result = $DB_CONN->query($sql);
	if(PEAR::isError($result))	die($result->userinfo);
	$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
	//if($row['menu_parentid'] != 0)
	$array[$i] = $row['file_name'];
		//$array[$i] = str_replace(" ","\ ",$row['caption']);
	$tmp_id = $row['menu_parentid'];
	$i++;
}
	
for($j = $i-1 ; $j >= 0 ; $j--){
	if($j == 0){
		$old_path .= $array[0]."/";
		$new_path .= $capt."/";
	}
	else{
		$old_path .= $array[$j]."/";
		$new_path .= $array[$j]."/";
	}
  }

}

//if it is root, do not modify the physical path
if($DB_CONN->getOne("SELECT menu_parentid FROM class_content WHERE menu_id = $nodeId") == 0)
{
        $sql = "update class_content set caption='$capt' where menu_id = $nodeId";
        $result = db_query($sql);
}
else
{	//假使實際檔案目錄名稱為New Node才去更改資料庫file_name,caption以及實際目錄名稱	
  	if($F_name == "New Node"){
           //file_put_contents("EEE",$old_path);
	   rename($old_path,$new_path);
           $sql = "update class_content set caption='$capt', file_name = '$capt' where menu_id = $nodeId";
 	   $result = db_query($sql);
	}
        else{
	//假使實際檔案目錄名稱不為New Node不去更改資料庫file_name以及實際目錄名稱,只改資料庫caption
        $sql = "update class_content set caption='$capt' where menu_id = $nodeId";
	$result = db_query($sql);
        }
}

print "1;".$capt;
?>
