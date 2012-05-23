<?php
/***
FILE:新增教務管理者
DATE:2009/06/25
AUTHOR:tgbsa
**/


	$RELEATED_PATH = "../";
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	require_once($RELEATED_PATH . "library/ftp_func.php");
	require_once($RELEATED_PATH . "library/account.php");

	checkAdmin();
	//update_status ( "確認開課中" );

	//new smarty
	$tpl = new Smarty();
	//新增教務管理者
	if(array_key_exists('action', $_GET) && $_GET['action']=='new'){
		if(trim($_POST['academic_admin_name']) == '' || trim($_POST['academic_admin_name']) == NULL){
			echo "教務管理者帳號未輸入";
		}
		else{
		  	if(!validate_login_id(trim($_POST['academic_admin_name']))){
				echo "帳號不可含有特殊字元";
				$tpl->assign("valueOfAcademic_admin_name", $_POST['academic_admin_name']);
				$tpl->assign("valueOfPassword", $_POST['password']);
			}
			else if(check_login_id(trim($_POST['academic_admin_name'])) == 1){
				echo "帳號已經存在";
				$tpl->assign("valueOfAcademic_admin_name", $_POST['academic_admin_name']);
				$tpl->assign("valueOfPassword", $_POST['password']);
			}
			else{
			  	$academic_admin_cd = create_account(trim($_POST['academic_admin_name']), trim($_POST['password']), 6);
				if($academic_admin_cd == -1)
					exit(0);
				$sql = "UPDATE register_basic set login_state='1', validated='1' where personal_id=".$academic_admin_cd ;
				$res = $DB_CONN->query($sql);
				if (PEAR::isError($res))	die($res->getMessage());
				echo "新增教務管理者帳號".$_POST['academic_admin_name']." 成功<br />";
				$sql = "UPDATE personal_basic SET personal_name='".$_POST['academic_admin_name']."', personal_style='IE' WHERE personal_id=".$academic_admin_cd;
				$res = $DB_CONN->query($sql);
				if (PEAR::isError($res))	die($res->getMessage());

			  	//建立教務管理者帳號資料夾 目前不需要
				//createAcademic_adminDIR($academic_admin_cd);

				//更新FTP 目前不需要
				//new_ftp_account( $_POST['academic_admin_name'] , $_POST['password'], '' );
			}
		}

	}
	//輸出頁面
	assignTemplate($tpl, "/learner_profile/new_academic_admin.tpl");
?>
