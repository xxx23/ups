<?php
/***
FILE:   
DATE:   2007.09.27
AUTHOR: tkraha

**/
	$RELEATED_PATH = "../";
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	//update_status ( "確認開課中" );
	
	//new smarty
	$tpl = new Smarty();
	
	//新增資料
	if($_GET['action'] == 'create'){
	  if($_POST[type_name] == "" || $_POST[type_id] == "" || $_POST[type_id_name] == "")
	  {
	    	$tpl->assign("msg","欄位不可有空白");
	  }
	  else
	  {
		$sql  = "INSERT INTO lrtstorecd_basic_ (type_name, type_id, type_id_name)";
		$sql .= "VALUES ('".$_POST[type_name]."','".$_POST[type_id]."','".$_POST[type_id_name]."')";		
		db_query($sql);
		$tpl->assign("done", $_POST['done']);
	  }
	}

	//讀取現有類別
	//預設值
	$str = array("未選取", "顯示全部");
	$tpl->assign("ddltype_ids", $str);
	$tpl->assign("ddltype_names", $str);
/*	$tpl->append("ddltype_ids", "未選取");
	$tpl->append("ddltype_names", "未選取");
	$tpl->append("ddltype_ids", "顯示全部");
	$tpl->append("ddltype_names", "顯示全部");*/

	$sql = "SELECT type_name FROM lrtstorecd_basic_ GROUP BY type_name";
	$result = $DB_CONN->query($sql);
	
	while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
	{
	  $tpl->append("ddltype_ids",$row['type_name']);
	  $tpl->append("ddltype_names",$row['type_name']);
	}
	if(isset($_POST['ddltype_cd']))
	{
  	  $tpl->assign("ddltype_id",$_POST['ddltype_cd']);	
	}
	else
	{
	  $tpl->assign("ddltype_id","未選取");	
	}

	  
	//讀取現有資料
	if(isset($_POST['ddltype_cd']) && $_POST['ddltype_cd'] != "未選取")
	{
	  $sql = "SELECT * FROM lrtstorecd_basic_";

	  if($_POST['ddltype_cd'] == '顯示全部')
	  {
	    $sql = "SELECT * FROM lrtstorecd_basic_";
	  }
	  else
	  {
	    $sql = "SELECT * FROM lrtstorecd_basic_ where type_name='".$_POST['ddltype_cd']."'";
	  }
	}
	else
	{
	  $sql = "SELECT * FROM lrtstorecd_basic_ where 1 != 1";	
	}

	$result = $DB_CONN->query($sql);
	while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
	{
		$tpl->append("typecd_data", $row);
	}

	//輸出頁面
	assignTemplate($tpl, "/course_admin/typecd_basic.tpl");	
?>
