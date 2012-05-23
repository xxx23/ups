<?php
	/*author:tgbsa
	 * date: 2009/06/25
	 */
	require_once("../config.php");
	require_once("../session.php");	
	
	checkAdmin();	
	$input = $_GET;
	if(empty($input['option']))
		$input['option'] = "view";
	call_user_func($input['option'], $input);

	function view($input){
		global $HOME_PATH, $THEME_PATH;
		$tpl = new Smarty;

		$result = db_query("select * from `personal_basic` where dist_cd=1 and personal_id not in (select personal_id from `register_basic` where role_cd=6);");
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
			$tpl->append("data_list", $row);
					
		assignTemplate($tpl, "/learner_profile/check_academic_admin.tpl");
	}

	function update($input){ change_role($input['list'], 1);}

	function remove($input){ change_role($input['list'], 3);}

	function change_role($list, $type){
	  	global $DATA_FILE_PATH;
	  	for($i = 0 ; $i < count($list) ; $i++)
	  	{
		  	db_query("update `register_basic` set role_cd=$type where personal_id=$list[$i];");
			$academic_admin_dir= $DATA_FILE_PATH . $list[$i] ."/";
                        $export_data_dir= $DATA_FILE_PATH . $list[$i] . "/export_data/";
                        $test_bank_dir  = $DATA_FILE_PATH . $list[$i] . "/test_bank/";
                        $textbook_dir   = $DATA_FILE_PATH . $list[$i] . "/textbook/";

			createAcademic_AdminDIR( $academic_admin_dir);
                        createAcademic_AdminDIR( $export_data_dir );
                        createAcademic_AdminDIR( $test_bank_dir );
                        createAcademic_AdminDIR( $textbook_dir );
		}	
		header("location:list_academic_admin.php");
	}

	//建立教師目錄
	function createAcademic_AdminDIR($path){
		if(file_exists($path))
			return;

		if( $path[strlen($path)-1] == '/');
	        else
	        	$path = $path.'/';
		$old_umask = umask(0);
	        mkdir($path, 0775);
	        umask($old_umask);
	} 
?>
