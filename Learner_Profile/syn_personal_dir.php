<?php
	$RELEATED_PATH = "../";
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	checkAdmin();
	//new smarty
	$tpl = new Smarty();

	$sql = "SELECT * FROM register_basic";
	$res = $DB_CONN->query($sql);
	while($row = $res->fetchRow(DB_FETCHMODE_ASSOC)){

		//建立個人的目錄
		$personal_id = $row['personal_id'];
		$personal_dir= $PERSONAL_PATH . $personal_id ."/";

		if( !is_dir($personal_dir)){
			createDIR( $personal_dir );
			echo "create dir $personal_dir - (ok) <br/>";
		}
	}


	//輸出頁面
	assignTemplate($tpl, "/learner_profile/syn_personal_dir.tpl");

//----------------function area ------------------

//建立目錄
function createDIR($path){

	if( $path[strlen($path)-1] == '/');
	else
		$path = $path.'/';
	$old_umask = umask(0);
	mkdir($path, 0775);
	umask($old_umask);
}
?>
