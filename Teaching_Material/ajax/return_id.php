<?php
	/*****************************************************************************/
	/*id: return_id.php v1.0 2007/3/5 Exp.					*/
	/*function: 當insert node時，需要先得知目前的id值，故透過XHR向此檔案作request*/
	/*****************************************************************************/
	header("Cache-Control: no-cache");
	include "../../config.php";
	require_once("../../session.php");
	require_once("../lib/textbook_mgt_func.inc");
	
	$Menu_parentid = $_GET['parent_id'];
	//先檢查DB中是否已經存在名稱為"New Node"這樣的node
	$sql = "select caption from class_content where menu_parentid = '$Menu_parentid'";
	$result = db_query($sql);
	while($row = $result->fetchRow(DB_FETCHMODE_ASSOC)){
		if($row['caption'] == "New Node"){
			echo -1;
			return;
		}
	}
		
	if( $id = get_max_menu_id() )
	  echo $id;
	else 
	  echo "null";
?>
