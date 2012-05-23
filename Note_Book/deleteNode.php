<?php
/*id: deleteNode.php v1.0 2007/3/6 hushpuppy Exp.*/
/*function: 教材系統的tree透過XHR呼叫本程式刪除節點*/

  Header("Cache-Control: no-cache");
  include "../config.php";
  require_once("../session.php");

  $Personal_id = $_SESSION['personal_id'];
  $id = $_GET['refid'];
  $ids = array(0 => $id);
  $i = 0;
  
  
  /*$handle = fopen("puppy", 'w');
  fwrite($handle, $id);*/
  
  //刪除資料夾
  $sql = "select * from notebook_content where menu_id = $id;";
  $result = $DB_CONN->query($sql);
  if(PEAR::isError($result))	die($result->getMessage());
  $row = $result->fetchRow(DB_FETCHMODE_ASSOC);
  
  /*沒分層前的寫法
    * $path = $PERSONAL_PATH;
	if( $path[strlen($path)-1] == '/');
	else
		$path = $path.'/';
    $path = $path.$Personal_id."/notebook/";*/

   //2011.09.25 joyce
      $path = getPersonalPath($Personal_id) . "/notebook/";
  	
  $i = 0;
  $tmp_id = $id;
  while($tmp_id != 0){
	$sql = "select * from notebook_content where menu_id = $tmp_id;";
	$result = $DB_CONN->query($sql);
	if(PEAR::isError($result))	die($result->getMessage());
	$row = $result->fetchRow(DB_FETCHMODE_ASSOC);

	//if($row['menu_parentid'] != 0)
	$array[$i] = $row['caption'];
		//$array[$i] = str_replace(" ","\ ",$row['caption']);
	$tmp_id = $row['menu_parentid'];
	$i++;
  }
	
  for($j = $i ; $j >= 0 ; $j--){
	if($j == 0){
		$path .= $array[0]."/";
	}
	else{
		$path .= $array[$j]."/";
	}
  }
  if(!file_exists($path))
  	return;
  $path = str_replace(" ","\ ",$path);
  
  
  /*$handle = fopen("puppy", 'w');
  fwrite($handle, $path);*/
  $cmd = "rm -rf ".$path;

  if(!strstr($path,"../"))
  {
      system_log($cmd);
      exec($cmd);
  }
  
  //刪除資料庫中資料
  $i =0;
  do {
    //select child nodes from database and add it to the array.
    $sql="select menu_id from notebook_content where menu_parentid='" . $ids[$i] . "'";
    $result = $DB_CONN->query($sql);
    if(PEAR::isError($result))	die($result->getMessage());
	
	
    while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
      $ids[] = $row["menu_id"];
    }
    //delete node from database
    $sql="delete from notebook_content where menu_id='" . $ids[$i] . "'";
    $result = $DB_CONN->query($sql);

    $sql="delete from notebook_node_content where menu_id='" . $ids[$i] . "'";
    $result = $DB_CONN->query($sql);
	
    $i++;
  } while($i < count($ids));
  
  
?>
