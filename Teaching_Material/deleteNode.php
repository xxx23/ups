<?php
/*id: deleteNode.php v1.0 2007/3/6 hushpuppy Exp.*/
/*function: 教材系統的tree透過XHR呼叫本程式刪除節點*/
header("Cache-Control: no-cache");
require_once "../config.php";
require_once("../session.php");
checkMenu("/Teaching_Material/textbook_manage.php");

$Teacher_cd = $_SESSION['personal_id'];
$id = $_GET['refid'];
if(isset($_GET['content_cd']))
	$content_cd = $_GET['content_cd'];
else 
	$content_cd = $_SESSION['content_cd'];

$ids = array(0 => $id);
$i = 0;

//刪除資料夾
//$sql = "select * from class_content where menu_id = $id;";
//$result = $DB_CONN->query($sql);
//if(PEAR::isError($result))	die($result->getMessage());
//$row = $result->fetchRow(DB_FETCHMODE_ASSOC);

  	$path = $DATA_FILE_PATH;
	if( $path[strlen($path)-1] == '/') 
		;
	else
	  	$path = $path.'/';
	$path = $path.$Teacher_cd."/textbook";
    $material_path = $path;

  	$i=0;	
	while($id != 0){
			$sql = "select * from class_content where menu_id = $id;";
			$result = db_query($sql);
			$row = $result->fetchRow(DB_FETCHMODE_ASSOC);

			$array[$i] = $row['file_name'];
			$id = $row['menu_parentid'];
			$i++;
	}
	
	for($j = $i ; $j >= 0 ; $j--){
			if($j == 0)
				$path .= $array[0]."/";
	 		else
				$path .= $array[$j]."/";
	  	
    }
   	
    if(file_exists($path) && (trim($path) != $material_path) && (trim($path) != $material_path."/"))  {
		$path = str_replace(" ","\ ",$path);
        $cmd = "rm -rf ".$path;
        if(!strstr($path,"../") && !(strstr($path, "//")))
        {
            system_log($cmd);
            exec($cmd);
        } 
        else
        {
            die('Delete path error');
        }        
	}

	//刪除資料庫中資料
	$i =0;
	do {
		//select child nodes from database and add it to the array.
	  	$sql ="select menu_id from class_content where menu_parentid='" . $ids[$i] . "'";
		$result = db_query($sql);

		while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
			$ids[] = $row["menu_id"];
		}
	  	seq_operation($ids[$i]);
  
		//delete node from database
		$sql = "delete from class_content where menu_id='" . $ids[$i] . "'";
		$result = db_query($sql);
		$i++;
	} while($i < count($ids));

	//刪除節點時，上下順序性該處理的function
	function seq_operation($id){
	  //查出p_id與本節點的順序值
	  $sql = "select * from class_content where menu_id = '$id'";
	  $result = db_query($sql);
	  $row = $result->fetchRow(DB_FETCHMODE_ASSOC);
	  $p_id = $row['menu_parentid'];
	  $del_seq = $row['seq'];

	  //同p_id的節點中，更新其順序值
	  //順序值大於del_seq的點，全部減一
	  //順序值小於del_seq的點，不用動作
	  $sql = "update class_content set seq=seq-1 where seq > '$del_seq' and menu_parentid = '$p_id'";
	  $result = db_query($sql);
	}

	echo 1;
?>
