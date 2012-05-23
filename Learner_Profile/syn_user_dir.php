<?php
	require("../config.php");
	require("../session.php");
        checkAdmin();
	$RELEATED_PATH = "../";
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");

	//new smarty
	$tpl = new Smarty();
	//輸出頁面
	assignTemplate($tpl, "/learner_profile/syn_user_dir.tpl");
		
//----------------function area ------------------

?>
