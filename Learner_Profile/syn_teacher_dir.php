<?php
	$RELEATED_PATH = "../";
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	checkAdmin();	
	//new smarty
	$tpl = new Smarty();

	$sql = "SELECT * FROM register_basic WHERE role_cd='1'";
	$res = $DB_CONN->query($sql);
	while($row = $res->fetchRow(DB_FETCHMODE_ASSOC)){

		//建立教師的目錄
		$teacher_cd = $row['personal_id'];
		$teacher_dir= $DATA_FILE_PATH . $teacher_cd ."/";
		$export_data_dir= $DATA_FILE_PATH . $teacher_cd . "/export_data/";
		$test_bank_dir	= $DATA_FILE_PATH . $teacher_cd . "/test_bank/";
		$textbook_dir	= $DATA_FILE_PATH . $teacher_cd . "/textbook/";

		if( !is_dir($teacher_dir)){
			createTeacherDIR( $teacher_dir);
			echo "create dir $teacher_dir - (ok)<br/>";
		}
		if( !is_dir($export_data_dir)){
			createTeacherDIR( $export_data_dir );
			echo "create dir $export_data_dir -- (ok)<br/>";
		}
		if( !is_dir($test_bank_dir)){
			createTeacherDIR( $test_bank_dir );
			echo "create dir $test_bank_dir -- (ok)<br/>";
		}
		if( !is_dir($textbook_dir)){
			createTeacherDIR( $textbook_dir );
			echo "create dir $textbook_dir -- (ok)<br/>";
		}
	}


	//輸出頁面
	assignTemplate($tpl, "/learner_profile/syn_teacher_dir.tpl");

//----------------function area ------------------

//建立教師目錄
function createTeacherDIR($path){

	if( $path[strlen($path)-1] == '/');
	else
		$path = $path.'/';
	$old_umask = umask(0);
	mkdir($path, 0775);
	umask($old_umask);
}
?>
