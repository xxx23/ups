<?php
/*******************************************************/
/*id: addNode.php v1.0 2007/3/6 hushpuppy Exp.*/
/*function: 筆記的tree透過XHR呼叫本程式新增節點*/
/*******************************************************/

include('../config.php');
include('../session.php');

Header("Cache-Control: no-cache");

$Begin_course_cd 	= $_SESSION['begin_course_cd'];
$Personal_id 		= $_SESSION['personal_id'];
$Notebook_cd 		= $_GET['notebook_cd'];
$link 				= null;
$id					="";
$refid 				= $_GET['refid'];

$debugvalue = "";
$caption='New Node';
$icon="/script/nlstree/img/folder.gif";

	//get max sort point.
	$sql="select max(menu_id+1) max_id from notebook_content";
	$result = db_query($sql);  
	$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
	$id=$row["max_id"];
	$url="notebook_content.php?notebook_cd=".$Notebook_cd."&menu_id=".$id;

	$sql='insert into notebook_content (notebook_cd, menu_id, menu_parentid, caption, url, exp, icon, seq) '
    . " values('" . $Notebook_cd . "', '" . $id . "', '" . $refid . "', '" . $caption. "', '" . $url. "', '" 	. "0',' " . $icon . "'" . ",''" . ")";
	$result = db_query($sql);
$debugvalue="INSERT:".$sql;
	
	//建立相對應的資料夾	
	$i = 0;
	//$array[$i++] = str_replace(" ","\ ",$caption);
	$array[$i++] = $caption;
	while($refid != 0){
		$sql = "select * from notebook_content where menu_id = $refid;";
		$result = db_query($sql);
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$array[$i] = $row['caption'];  //空格部份取代為 "\ "
			//$array[$i] = str_replace(" ","\ ",$row['caption']);  //空格部份取代為 "\ "
		$refid = $row['menu_parentid'];
		$i++;
	}
    
    /*沒分層前的寫法
     * $path = $PERSONAL_PATH;
	if( $path[strlen($path)-1] == '/');
	else
		$path = $path.'/';
    $path = $path.$Personal_id."/notebook/";*/

    //2011.09.25 joyce
        $path = getPersonalPath($Personal_id) . "/notebook/";
                createPath($path);//確保目錄存在 如不存在則建立


	for($j = $i-1 ; $j >= 0 ; $j--){
		$path .= $array[$j] ."/";
	}
	//$tmp = print_r($array, true);
	/*$handle = fopen("puppy", 'w');
	fwrite($handle, $path);*/
	
	//$path = str_replace(" ","\ ",$path);
	if(file_exists($path));
	else{
	  createPath($path);
	}
	
	
?>
