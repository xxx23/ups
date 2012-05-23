<?
include "../config.php";
require_once("../session.php");

$tpl = new Smarty;

//取得教師教材目錄下的檔案
$Material_PATH = $DATA_FILE_PATH . $_SESSION['personal_id'] . "/textbook";
//echo $Material_PATH;


$dh = dir($Material_PATH);
$selMaterial_ids[0] = 0;
$selMaterial_names[0] = "請選擇教材";
$i  = 1;


while (false !== ($entry = $dh->read())) {
  //for debug 	
  //echo $entry."\n";
  if($entry == "." || $entry == ".." || (preg_match("/rar$/",$entry) != 1)){
     continue;
  }

    $selMaterial_ids[$i]   = $entry;
    $selMaterial_names[$i] = $entry;
    $i++; 
}

$sql = "select login_id from register_basic where personal_id='{$_SESSION['personal_id']}'";
$username = db_getOne($sql);

$tpl->assign("FTP_IP",$FTP_IP);
$tpl->assign("FTP_PORT",$FTP_PORT);
$tpl->assign("Material_PATH",$Material_PATH);
$tpl->assign("username",$username);
$tpl->assign("selMaterial_ids", $selMaterial_ids);
$tpl->assign("selMaterial_names", $selMaterial_names);
$tpl->assign("selMaterial", 0);



$dh->close();
$tpl->assign("content_cd",$_GET['content_cd']);
assignTemplate( $tpl,"/teaching_material/tea_extract_material.tpl");

?>
