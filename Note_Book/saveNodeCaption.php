<?php
/*****************************************************************/
/* id: saveNodeCaption.php v2.0 2007/10/19 by hushpuppy 	 */
/* function: 當tree node更新描述時，由xmlHttp傳回給此檔更新資料庫*/
/*****************************************************************/

include('../config.php');
include('../session.php');

//checkMenu("/Teaching_Material/textbook_manage.php");

$Personal_id 	= $_SESSION['personal_id'];
$Notebook_cd 	= $_GET['notebook_cd'];
$nodeId 		= $_GET['nid'];
$capt	 		= $_GET['caption'];
//$prnId = $_GET['prn'];
//錯誤偵測，若有重複名稱則傳回-1

$sql = "select caption from notebook_content where notebook_cd=$Notebook_cd and menu_id = '$nodeId'";
$old_name = db_getOne($sql);

$sql = "select menu_parentid from notebook_content where notebook_cd=$Notebook_cd and menu_id = '$nodeId'";
$prnId = db_getOne($sql);

$sql = "select * from notebook_content where menu_parentid = '$prnId'";
$result = db_query($sql);
while($row = $result->fetchRow(DB_FETCHMODE_ASSOC)){
	if($row['caption'] == $capt){
		print "-1;".$old_name;
		return ;
	}
}
//==========20111205 避免回上層路徑===========
if(strstr($capt,"../"))
{
    print "-1;".$old_name;
    return ;
}

/*沒分層前的寫法
$old_path = $PERSONAL_PATH.$Personal_id."/notebook/";
$new_path = $PERSONAL_PATH.$Personal_id."/notebook/";
 */
//2011.09.25 joyce
$old_path = getPersonalPath($Personal_id)."/notebook/";
$new_path = getPersonalPath($Personal_id)."/notebook/";


$i = 0;
//$array[$i++]= $caption;
$tmp_id = $nodeId;
while($tmp_id != 0){
	$sql = "select * from notebook_content where menu_id = $tmp_id;";
	$result = $DB_CONN->query($sql);
	if(PEAR::isError($result))	die($result->userinfo);
	$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
	//if($row['menu_parentid'] != 0)
	$array[$i] = $row['caption'];
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
$handle = fopen("puppy", 'a');
fwrite($handle, "old:".$old_path.",new:".$new_path);

rename($old_path,$new_path);

$sql = "update notebook_content set caption='".$capt."' where menu_id = $nodeId";
//echo $sql;

$result = db_query($sql);

echo "1;".$capt;
?>
