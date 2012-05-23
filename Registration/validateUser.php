<?php
	include('../config.php');
	$personal_id = addslashes($_GET['id']);
	$randNum = addslashes($_GET['r']);

	$tpl = new Smarty();
	//先去資料庫查看randNum是否Match
	$Rnum = db_getOne("select note from personal_basic where personal_id={$personal_id}");	
	if($randNum != $Rnum){
	  $tpl->assign("validateUser","0");
	  $tpl->display("validateUser.tpl");
	}
	else{
	  db_query("update register_basic set validated = '1', d_loging=now() where personal_id={$personal_id}");	
	  $tpl->assign("validateUser","1");
	  $tpl->display("validateUser.tpl");
	}

?>
