<?php
	/*id: return_id.php v1.0 2007/3/5 Exp.*/
	/*function: 當insert node時，需要先得知目前的id值，故透過XHR向此檔案作request*/
	Header("Cache-Control: no-cache");
	include('../../config.php');
	include('../../session.php');
	
	$Menu_parentid = $_GET['parent_id'];
	
	//先檢查DB中是否已經存在名稱為"New Node"這樣的node
	$sql = "select caption from notebook_content where menu_parentid = '$Menu_parentid'";
	$result = $DB_CONN->query($sql);
	if(PEAR::isError($caption))	die($row->userinfo);
	while($row = $result->fetchRow(DB_FETCHMODE_ASSOC)){
		if($row['caption'] == "New Node"){
			echo -1;
			return;
		}
	}
	
	$sql = "select max(menu_id+1) max_id from notebook_content";
    $id = $DB_CONN->getOne($sql);
  
	echo $id;
?>