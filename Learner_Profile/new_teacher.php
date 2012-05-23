<?php
/***
FILE:   
DATE:   
AUTHOR: zqq
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
	//新增教師
	if($_GET['action']=='new'){
		if(trim($_POST['teacher_name']) == '' || trim($_POST['teacher_name']) == NULL){
			echo "教師帳號未輸入";
		}
		else{
		  	if(!validate_login_id(trim($_POST['teacher_name']))){
				echo "帳號不可含有特殊字元";
				$tpl->assign("valueOfTeacher_name", $_POST[teacher_name]);
				$tpl->assign("valueOfPassword", $_POST[password]);
			}
			else if(check_login_id(trim($_POST['teacher_name'])) == 1){
				echo "帳號已經存在";
				$tpl->assign("valueOfTeacher_name", $_POST[teacher_name]);
				$tpl->assign("valueOfPassword", $_POST[password]);
			}
			else{
			  	$teacher_cd = create_account(trim($_POST['teacher_name']), trim($_POST['password']), 1);
				if($teacher_cd == -1)
					exit(0);
				$sql = "UPDATE register_basic set login_state='1', validated='1' where personal_id=".$teacher_cd ;
				$res = $DB_CONN->query($sql);
				if (PEAR::isError($res))	die($res->getMessage());
				echo "新增教師帳號".$_POST[teacher_name]." 成功<br />";
				$sql = "UPDATE personal_basic SET personal_name='".$_POST[teacher_name]."', personal_style='IE' WHERE personal_id=".$teacher_cd;
				$res = $DB_CONN->query($sql);
				if (PEAR::isError($res))	die($res->getMessage());
			  
			  	//建立教師帳號
				createTeacherDIR($teacher_cd);
				
				//更新FTP 
				new_ftp_account( $_POST[teacher_name] , $_POST[password], '' );	
			}
		}
		
	}
	//輸出頁面
	assignTemplate($tpl, "/learner_profile/new_teacher.tpl");	
?>
