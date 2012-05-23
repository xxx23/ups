<?php
/***
FILE:   
DATE:   
AUTHOR: zqq

**/
	$RELEATED_PATH = "../";
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	//update_status ( "確認開課中" );
	
	//new smarty
	$tpl = new Smarty();
	
	//修改代碼資料
	if($_GET['action'] == "modify")
	{
		if(!isset($_SESSION['type_cd']))
			return;
		$sql = "UPDATE lrtstorecd_basic_ SET type_name='".$_POST['type_name']."' , type_id='".$_POST['type_id']."' , type_id_name='".$_POST['type_id_name']."' WHERE type_cd=".$_SESSION['type_cd'];

		db_query($sql);
		if (DB::isError($result)) {
			exit("Error encountered: " . $result->getMessage());
		}
		else
		{
			$tpl->assign('done','1');
			$tpl->assign("type_id",$_POST['type_id']);
			$tpl->assign("type_name",$_POST['type_name']);
			$tpl->assign("type_id_name",$_POST['type_id_name']);
		}
	}
	//讀取代碼檔案
	else if(isset($_GET['type_cd']))
	{
		unset($_SESSION['type_cd']); 
		$tpl->assign("qs","&type_cd=".$_GET['type_cd']);
		
		$sql  = "SELECT * FROM lrtstorecd_basic_ WHERE type_cd='".$_GET['type_cd']."'";
		$result = $DB_CONN->query($sql);
		if (DB::isError($result)) {
			exit("Error encountered: " . $result->getMessage());
		}
		if($result->numRows() > 0)
		{
			$_SESSION['type_cd'] = $_GET['type_cd'];
			$row = $result->fetchRow(DB_FETCHMODE_ASSOC);

			$tpl->assign("type_id",$row['type_id']);
			$tpl->assign("type_name",$row['type_name']);
			$tpl->assign("type_id_name",$row['type_id_name']);
		}	
	}

	//輸出頁面
	assignTemplate($tpl, "/course_admin/modify_typecd_basic.tpl");	
?>
