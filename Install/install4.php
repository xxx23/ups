<?php

	if( filesize("../config.php") == 0 ){
		header("Location: install2.php?info=nowritable");
		return ;
	}
	
	include("../config.php");
	include('libs.php');
	
	$DO_EXEC = true; // do not exec 
	$DEBUG_MODE = false;


	$schemas	= array('schema_all' 	=>	'SHOW TABLES;' ,
			'lrtmenu_' 		=>	'select count(*) from lrtmenu_;' ,
            'lrtrole_' 		=>	'select count(*) from lrtrole_ where role_cd=0;' ,
            'lrtunit_basic_'    => 'select count(*) from lrtunit_basic_ where department=-1' ,
		'tracking_function_menu' 	=>	'select count(*) from tracking_function_menu where system_id=1;' ,
			'tracking_system_menu'	=>	'select count(*) from tracking_system_menu  where system_id=1;' ,   
			'lrtstorecd_basic_'	=>	'select count(*) from lrtstorecd_basic_;' ,
			'menu_role'		=>	'select count(*) from menu_role ;' , 
			'lrtcourse_classify_'	=>	'select count(*) from lrtcourse_classify_',
            'lchat_settings'	=>  	'select count(*) from lchat_settings where 1;' , 
            'docs'              =>      'select count(*) from docs', 
            'location'          =>      'select count(*) from location ',
            'mdl_modules'       =>      'select count(*) from mdl_modules'
        );


    //執行資料輸入, 先匯入schema , 然後匯入data  
	$MYSQL_PATH = get_utility_path('mysql', $PATHS);
    
    $cmd = $MYSQL_PATH." -u'".$DB_USERNAME."' -p'".$DB_USERPASSWORD."' --default-character-set=utf8 $DB_NAME  < " .  $MYSQL_DEFAULT_SCHEMA;
    debug_exec($cmd) ; 	

    $cmd = $MYSQL_PATH." -u'".$DB_USERNAME."' -p'".$DB_USERPASSWORD."' --default-character-set=utf8 $DB_NAME  < " .  $MYSQL_DEFAULT_DATA;
    debug_exec($cmd) ; 

	$smtpl = new Smarty;
	
	foreach($schemas as $table => $sql ) {
		check_data($smtpl, $table, $sql);
	}


	$smtpl->display("./install4.tpl");
	return; 

	
function check_data($smtpl, $table, $sql) {

	global $DB_USERNAME, $DB_USERPASSWORD, $DB_NAME;
	global $DO_EXEC, $DEBUG_MODE; 
	global $HOME_PATH, $MYSQL_DEFAULT_DATA; 
	global $PATHS;

	if( !file_exists($MYSQL_DEFAULT_DATA) ){
          	$smtpl->assign("$table","<font color=\"red\">匯入檔案不存在</font>");
		return true;

	}
	
	$result = db_query($sql);
	if( $result->numRows() > 0 ) {
	  $smtpl->assign("$table","<font color=\"green\">匯入成功</font>");
	  return true;
	}
	else{
		$smtpl->assign("$table","<font color=\"red\">匯入失敗</font>");
		return false;
	}
}

?>
